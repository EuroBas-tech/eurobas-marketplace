<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropNameColumnsFromUsersTable extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['f_name', 'l_name']);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('f_name')->nullable();
            $table->string('l_name')->nullable();
        });
    }
}
