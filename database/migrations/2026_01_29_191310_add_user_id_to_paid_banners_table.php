<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToPaidBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paid_banners', function (Blueprint $table) {
            $table->foreignId('user_id')
            ->nullable()
            ->constrained('users')
            ->cascadeOnDelete(); // if user deleted, user_id becomes null
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paid_banners', function (Blueprint $table) {
            //
        });
    }
}
