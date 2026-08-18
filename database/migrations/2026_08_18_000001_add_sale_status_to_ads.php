<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSaleStatusToAds extends Migration
{
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->enum('sale_status', ['active', 'reserved', 'sold'])
                  ->default('active')
                  ->after('ad_status');
        });
    }

    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn('sale_status');
        });
    }
}
