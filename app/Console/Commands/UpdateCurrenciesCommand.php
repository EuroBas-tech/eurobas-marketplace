<?php

namespace App\Console\Commands;
use App\Model\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;


class UpdateCurrenciesCommand extends Command
{
    protected $signature = 'currencies:update';
    protected $description = 'Update currency exchange rates';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $accessKey = '24b460b5930e3b1d63fff68243b7dc28'; // استبدل بمفتاح الوصول الخاص بك
        $url = 'http://apilayer.net/api/live?access_key=' . $accessKey . '&format=1' . '&source=EUR';

        $response = Http::get($url);

        if ($response->successful()) {
            $quotes = $response->json()['quotes'];

            // تحديث سعر الصرف لكل عملة في جدول العملات
            foreach ($quotes as $pair => $rate) {
                $currencyCode = substr($pair, 3); // Remove the "USD" prefix

                // يجب التأكد من أن جدول العملات يحتوي على العملة المطابقة
                if(Currency::where('code', $currencyCode)->exists()) {
                    Currency::where('code', $currencyCode)->update(['exchange_rate' => $rate]);
                }
            }

            $this->info('All currency rates updated successfully.');
        } else {
            $this->error('Failed to retrieve currency rates.');
        }
    }
}
