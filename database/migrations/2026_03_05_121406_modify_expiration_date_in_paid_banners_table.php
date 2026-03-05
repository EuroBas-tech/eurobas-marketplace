<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ModifyExpirationDateInPaidBannersTable extends Migration
{

    public function up(): void
    {
        DB::statement("
            ALTER TABLE paid_banners 
            MODIFY expiration_date TIMESTAMP NULL DEFAULT NULL
        ");
    }

    public function down()
    {
        Schema::table('paid_banners', function (Blueprint $table) {
            $table->timestamp('expiration_date')->nullable(false)->change();
        });
    }
}
