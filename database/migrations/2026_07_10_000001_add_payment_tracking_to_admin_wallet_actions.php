<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentTrackingToAdminWalletActions extends Migration
{
    public function up()
    {
        Schema::table('admin_wallet_actions', function (Blueprint $table) {
            $table->string('gateway')->nullable()->after('order_id');           // stripe / paypal
            $table->string('transaction_id')->nullable()->after('gateway');     // payment transaction ID
            $table->string('package_type')->nullable()->after('transaction_id');// sponsored_ad / paid_banner
            $table->decimal('gross_amount', 10, 2)->default(0)->after('package_type');  // full amount paid
            $table->decimal('gateway_fee', 10, 2)->default(0)->after('gross_amount');   // stripe/paypal fee
            $table->decimal('vat_amount', 10, 2)->default(0)->after('gateway_fee');     // VAT collected
            $table->decimal('net_amount', 10, 2)->default(0)->after('vat_amount');      // net after fee
            $table->string('user_country')->nullable()->after('net_amount');             // user country
            $table->boolean('is_eu')->default(false)->after('user_country');            // inside EU?
            $table->decimal('vat_rate', 5, 2)->default(0)->after('is_eu');             // VAT % applied
        });
    }

    public function down()
    {
        Schema::table('admin_wallet_actions', function (Blueprint $table) {
            $table->dropColumn([
                'gateway', 'transaction_id', 'package_type',
                'gross_amount', 'gateway_fee', 'vat_amount',
                'net_amount', 'user_country', 'is_eu', 'vat_rate',
            ]);
        });
    }
}
