<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Model\Ad;
use App\Model\PaidBanner;
use App\Model\Setting;
use App\Model\SponsoredAd;
use App\Services\PaypalPayment;
use App\Services\StripePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Self-contained, session-free payment flow for the mobile app (§4).
 *
 *   POST v1/payment/initiate  -> { checkout_url }   (open in a webview/browser)
 *   GET  v1/payment/callback/{method}               (gateway redirect target — stateless)
 *   GET  v1/payment/verify    -> { is_paid, payment_transaction_id }
 *
 * `model_type` is `paid_banner` | `sponsor`; the model itself carries everything
 * the gateway needs, so nothing depends on a web session.
 */
class PaymentController extends Controller
{
    private const MODELS = [
        'paid_banner' => PaidBanner::class,
        'sponsor'     => SponsoredAd::class,
    ];

    /**
     * POST v1/payment/initiate
     */
    public function initiate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'model_type' => 'required|in:paid_banner,sponsor',
            'model_id'   => 'required|numeric',
            'method'     => 'required|in:paypal,stripe',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        if (!$this->gatewayEnabled($request->method)) {
            return response()->json(['message' => translate('payment_gateway_not_available')], 422);
        }

        $model = $this->resolveOwnedModel($request->model_type, $request->model_id, auth('api')->id());
        if (!$model) {
            return response()->json(['message' => translate('No such data found!')], 404);
        }

        if ($model->is_paid) {
            return response()->json(['message' => translate('already_paid')], 409);
        }

        $query     = http_build_query(['model_type' => $request->model_type, 'model_id' => $model->id]);
        $returnUrl = url('/api/v1/payment/callback/' . $request->method) . '?' . $query;
        $cancelUrl = $returnUrl . '&status=cancel';

        try {
            $service     = $request->method === 'paypal' ? new PaypalPayment() : new StripePayment();
            $checkoutUrl = $service->pay($model, $returnUrl, $cancelUrl);
        } catch (\Throwable $e) {
            Log::error('API payment initiate failed: ' . $e->getMessage());
            return response()->json(['message' => translate('unable_to_start_payment')], 500);
        }

        return response()->json([
            'success'      => true,
            'checkout_url' => $checkoutUrl,
            'model_type'   => $request->model_type,
            'model_id'     => $model->id,
            'method'       => $request->method,
        ], 200);
    }

    /**
     * GET v1/payment/callback/{method} — gateway redirect target. Stateless: it
     * reads model_type/model_id from the query and verifies with the gateway.
     */
    public function callback(Request $request, $method)
    {
        if ($request->get('status') === 'cancel') {
            return $this->resultPage(false, translate('payment_cancelled'));
        }

        $model = $this->resolveModel($request->get('model_type'), $request->get('model_id'));
        if (!$model) {
            return $this->resultPage(false, translate('No such data found!'));
        }

        $paid = $this->execute($method, $request, $model);

        if ($paid) {
            $this->publishListingAfterPayment($model);
        }

        return $this->resultPage($paid, $paid ? translate('payment_successful') : translate('payment_failed'));
    }

    /**
     * GET v1/payment/verify — poll payment status from the app.
     */
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'model_type' => 'required|in:paid_banner,sponsor',
            'model_id'   => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $model = $this->resolveOwnedModel($request->model_type, $request->model_id, auth('api')->id());
        if (!$model) {
            return response()->json(['message' => translate('No such data found!')], 404);
        }

        // If the gateway redirect was captured by the app (no server callback hit),
        // finalize here using the supplied gateway params.
        if (!$model->is_paid && $request->filled('method')) {
            if ($this->execute($request->method, $request, $model)) {
                $model->refresh();
            }
        }

        // Once paid (here or via the server callback), publish the listing.
        if ($model->is_paid) {
            $this->publishListingAfterPayment($model);
        }

        return response()->json([
            'is_paid'                 => (bool) $model->is_paid,
            'payment_transaction_id'  => $model->payment_transaction_id,
        ], 200);
    }

    /**
     * Website parity: a listing held for a paid promotion is published only once
     * payment succeeds (mirrors Multiple*Payment@executePayment setting
     * $models[0]->ad->status = 1). Publishes when no paid promotion for the ad
     * remains unpaid, so multi-package listings publish only after all are paid.
     */
    private function publishListingAfterPayment($model): void
    {
        if (!($model instanceof SponsoredAd) || !$model->ad_id) {
            return;
        }

        $hasUnpaidPromo = SponsoredAd::where('ad_id', $model->ad_id)
            ->where('price', '>', 0)
            ->where('is_paid', 0)
            ->exists();

        if (!$hasUnpaidPromo) {
            Ad::where('id', $model->ad_id)->where('status', 0)->update(['status' => 1]);
        }
    }

    // ─── internals ───────────────────────────────────────────────────────

    private function execute(string $method, Request $request, $model): bool
    {
        try {
            if ($method === 'paypal') {
                $paymentId = $request->get('paymentId');
                $payerId   = $request->get('PayerID');
                if (!$paymentId || !$payerId) {
                    return false;
                }
                return (new PaypalPayment())->executePayment($paymentId, $payerId, $model);
            }
            if ($method === 'stripe') {
                $sessionId = $request->get('session_id');
                if (!$sessionId) {
                    return false;
                }
                return (new StripePayment())->executePayment($sessionId, $model);
            }
        } catch (\Throwable $e) {
            Log::error('API payment execute failed: ' . $e->getMessage());
        }
        return false;
    }

    private function gatewayEnabled(string $method): bool
    {
        $setting = Setting::where('key_name', $method)->first();
        return $setting ? (bool) $setting->is_active : false;
    }

    private function resolveModel($type, $id)
    {
        if (!isset(self::MODELS[$type])) {
            return null;
        }
        return self::MODELS[$type]::find($id);
    }

    private function resolveOwnedModel($type, $id, $userId)
    {
        if ($type === 'paid_banner') {
            return PaidBanner::where('user_id', $userId)->find($id);
        }
        if ($type === 'sponsor') {
            $sponsor = SponsoredAd::with('ad:id,user_id')->find($id);
            return ($sponsor && $sponsor->ad && $sponsor->ad->user_id == $userId) ? $sponsor : null;
        }
        return null;
    }

    private function resultPage(bool $success, string $message)
    {
        $color = $success ? '#16a34a' : '#dc2626';
        $html  = '<!doctype html><html><head><meta charset="utf-8">'
            . '<meta name="viewport" content="width=device-width, initial-scale=1">'
            . '<title>' . e($message) . '</title></head>'
            . '<body style="font-family:sans-serif;text-align:center;padding:48px;">'
            . '<h2 style="color:' . $color . '">' . e($message) . '</h2>'
            . '<p>' . e(translate('you_can_now_return_to_the_app')) . '</p>'
            . '</body></html>';

        return response($html, 200)->header('Content-Type', 'text/html');
    }
}
