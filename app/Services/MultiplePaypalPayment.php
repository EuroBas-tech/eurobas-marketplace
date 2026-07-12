<?php

namespace App\Services;

use Exception;
use PayPal\Api\Payer;
use App\Model\Setting;
use PayPal\Api\Amount;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use App\Model\AdminWallet;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use PayPal\Auth\OAuthTokenCredential;

class MultiplePaypalPayment
{
    protected $apiContext;

    // EU VAT rates (OSS system)
    const EU_VAT_RATES = [
        'AT'=>20,'BE'=>21,'BG'=>20,'CY'=>19,'CZ'=>21,
        'DE'=>19,'DK'=>25,'EE'=>22,'ES'=>21,'FI'=>24,
        'FR'=>20,'GR'=>24,'HR'=>25,'HU'=>27,'IE'=>23,
        'IT'=>22,'LT'=>21,'LU'=>17,'LV'=>21,'MT'=>18,
        'NL'=>21,'PL'=>23,'PT'=>23,'RO'=>19,'SE'=>25,
        'SI'=>22,'SK'=>20,
    ];

    public function __construct()
    {
        $paypal_credentials = $this->getPaypalCredentials();

        $paypalConfig = [
            'client_id' => $paypal_credentials['client_id'],
            'secret'    => $paypal_credentials['client_secret'],
            'settings'  => [
                'mode'                   => $paypal_credentials['mode'],
                'http.ConnectionTimeOut' => 60,
                'http.Retry'             => 3,
                'log.LogEnabled'         => true,
                'log.FileName'           => storage_path('logs/paypal.log'),
                'log.LogLevel'           => 'ERROR',
            ],
        ];

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypalConfig['client_id'],
                $paypalConfig['secret']
            )
        );
        $this->apiContext->setConfig($paypalConfig['settings']);
    }

    protected function getPaypalCredentials()
    {
        $paypal = Setting::where('key_name', 'paypal')->first();
        if (!$paypal) throw new \Exception("PayPal configuration not found.");
        $values = $paypal->{$paypal->mode . '_values'};
        $values['mode'] = $paypal->mode === 'test' ? 'sandbox' : 'live';
        return $values;
    }

    /**
     * Create a PayPal payment
     */
    public function pay($models)
    {
        try {
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $amount = new Amount();
            $amount->setCurrency('EUR')
                   ->setTotal(number_format($models->sum('price'), 2, '.', ''));

            $transaction = new Transaction();
            $transaction->setAmount($amount)
                        ->setDescription("Payment for Sponsored Ad");

            $ids = $models->pluck('id')->implode(',');

            $redirectUrls = new RedirectUrls();
            $redirectUrls
                ->setReturnUrl(URL::route('multiple.payment.success', [
                    'method' => 'paypal', 'sponsor_ids' => $ids
                ]))
                ->setCancelUrl(URL::route('multiple.payment.cancel', [
                    'method' => 'paypal', 'sponsor_ids' => $ids
                ]));

            $payment = new Payment();
            $payment->setIntent('sale')
                    ->setPayer($payer)
                    ->setRedirectUrls($redirectUrls)
                    ->setTransactions([$transaction]);

            $payment->create($this->apiContext);

            Log::info('PayPal payment created', [
                'sponsor_ids' => $ids,
                'payment_id'  => $payment->getId(),
                'amount'      => $models->sum('price'),
            ]);

            return $payment->getApprovalLink();

        } catch (Exception $e) {
            Log::error('PayPal Create Payment Error: ' . $e->getMessage());
            if (method_exists($e, 'getData')) Log::error('PayPal API Response: ' . $e->getData());
            throw new Exception('Unable to process PayPal payment. Please try again later.');
        }
    }

    /**
     * Execute PayPal payment after user approval
     */
    public function executePayment($paymentId, $payerId, $models)
    {
        try {
            Log::info('Executing PayPal payment', [
                'paymentId'   => $paymentId,
                'payerId'     => $payerId,
                'sponsor_ids' => $models->pluck('id')->implode(','),
            ]);

            $payment   = Payment::get($paymentId, $this->apiContext);
            $execution = new PaymentExecution();
            $execution->setPayerId($payerId);

            $result = $payment->execute($execution, $this->apiContext);

            Log::info('PayPal execution result', ['state' => $result->getState()]);

            if ($result->getState() === 'approved') {
                $transactions     = $result->getTransactions();
                $transaction      = $transactions[0];
                $relatedResources = $transaction->getRelatedResources();
                $sale             = $relatedResources[0]->getSale();

                foreach ($models as $model) {

                    // Only record paid packages (price > 0)
                    if ($model->price > 0) {
                        $model->update([
                            'is_paid'                => 1,
                            'payment_transaction_id' => $sale->getId(),
                        ]);

                        // Record each package separately in accounting
                        $this->recordToAccounting($model, $sale->getId(), 'paypal');
                    }

                    Log::info('PayPal payment completed', [
                        'sponsor_id'     => $model->id,
                        'transaction_id' => $sale->getId(),
                        'package_type'   => $model->type ?? 'N/A',
                        'price'          => $model->price,
                    ]);
                }

                $models[0]->ad->status = 1;
                $models[0]->ad->save();

                return true;

            } else {
                foreach ($models as $model) {
                    Log::error('PayPal payment not approved', [
                        'state'      => $result->getState(),
                        'sponsor_id' => $model->id,
                    ]);
                }
                return false;
            }

        } catch (Exception $ex) {
            Log::error('PayPal Execute Payment Error: ' . $ex->getMessage(), [
                'payment_id' => $paymentId,
                'payer_id'   => $payerId,
            ]);
            if (method_exists($ex, 'getData')) Log::error('PayPal Execute API Response: ' . $ex->getData());
            return false;
        }
    }

    /**
     * Record successful payment to accounting
     * Called ONLY after confirmed approved — never for free packages
     */
    protected function recordToAccounting($model, $transactionId, $gateway)
    {
        try {
            $grossAmount = (float) $model->price;
            if ($grossAmount <= 0) return; // extra safety: skip free packages

            // PayPal fee: 3.49% + €0.49
            $gatewayFee = round(($grossAmount * 0.0349) + 0.49, 2);
            $netAmount  = round($grossAmount - $gatewayFee, 2);

            // Get user country via Ad → User
            $userCountry = '';
            if ($model->ad && $model->ad->user) {
                $userCountry = strtoupper($model->ad->user->country ?? '');
            }

            // VAT calculation
            $isEu      = array_key_exists($userCountry, self::EU_VAT_RATES);
            $vatRate   = $isEu ? self::EU_VAT_RATES[$userCountry] : 0;
            $vatAmount = $isEu ? round($grossAmount * ($vatRate / 100), 2) : 0;

            // Package type name
            $packageType = $model->type ?? 'SponsoredAd';

            // Get or create AdminWallet
            $adminWallet = AdminWallet::where('admin_id', 1)->first();
            if (!$adminWallet) {
                $walletId = DB::table('admin_wallets')->insertGetId([
                    'admin_id'               => 1,
                    'withdrawn'              => 0,
                    'commission_earned'      => 0,
                    'delivery_charge_earned' => 0,
                    'pending_amount'         => 0,
                    'total_earning'          => 0,
                    'collected_cash'         => 0,
                    'total_tax_collected'    => 0,
                    'created_at'             => now(),
                    'updated_at'             => now(),
                ]);
            } else {
                $walletId = $adminWallet->id;
            }

            // Update wallet totals
            DB::table('admin_wallets')->where('admin_id', 1)->update([
                'commission_earned'   => DB::raw("commission_earned + {$netAmount}"),
                'collected_cash'      => DB::raw("collected_cash + {$grossAmount}"),
                'total_tax_collected' => DB::raw("total_tax_collected + {$vatAmount}"),
                'updated_at'          => now(),
            ]);

            // Insert transaction record
            DB::table('admin_wallet_actions')->insert([
                'admin_wallet_id'     => $walletId,
                'order_id'            => $model->id,
                'gateway'             => $gateway,
                'transaction_id'      => $transactionId,
                'package_type'        => $packageType,
                'gross_amount'        => $grossAmount,
                'gateway_fee'         => $gatewayFee,
                'vat_amount'          => $vatAmount,
                'net_amount'          => $netAmount,
                'user_country'        => $userCountry,
                'is_eu'               => $isEu ? 1 : 0,
                'vat_rate'            => $vatRate,
                'commission_earned'   => $netAmount,
                'collected_cash'      => $grossAmount,
                'total_tax_collected' => $vatAmount,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);

            Log::info('Accounting recorded (PayPal)', [
                'sponsor_id'     => $model->id,
                'transaction_id' => $transactionId,
                'package_type'   => $packageType,
                'gross'          => $grossAmount,
                'gateway_fee'    => $gatewayFee,
                'vat'            => $vatAmount,
                'net'            => $netAmount,
                'country'        => $userCountry,
                'is_eu'          => $isEu,
            ]);

        } catch (\Exception $e) {
            // NEVER block the payment flow — only log
            Log::error('Accounting record failed (PayPal)', [
                'sponsor_id' => $model->id,
                'error'      => $e->getMessage(),
            ]);
        }
    }
}
