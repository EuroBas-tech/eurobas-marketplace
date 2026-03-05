<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyExpirationDateInPaidBannersTable extends Migration
{

    public function up()
    {
        Schema::table('paid_banners', function (Blueprint $table) {
            $table->timestamp('expiration_date')->nullable()->default(null)->change();
        });
    }

    public function down()
    {
        Schema::table('paid_banners', function (Blueprint $table) {
            $table->timestamp('expiration_date')->nullable(false)->change();
        });
    }
}
