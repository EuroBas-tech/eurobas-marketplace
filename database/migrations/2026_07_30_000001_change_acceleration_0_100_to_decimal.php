<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAcceleration0100ToDecimal extends Migration
{
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->decimal('acceleration_0_100', 5, 2)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->tinyInteger('acceleration_0_100')->nullable()->change();
        });
    }
}
