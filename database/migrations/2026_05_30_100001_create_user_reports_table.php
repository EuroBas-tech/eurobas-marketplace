<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Milestone 2 — Report User.
 * Stores user-to-user reports raised from the chat UI or a seller profile.
 * Reviewed by admins in the dedicated admin panel section.
 */
class CreateUserReportsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('user_reports')) {
            return;
        }

        Schema::create('user_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reporter_id');        // the user who files the report
            $table->unsignedBigInteger('reported_id');        // the user being reported
            $table->unsignedBigInteger('chatting_id')->nullable(); // optional source message
            $table->string('type')->default('chat');          // 'chat' | 'seller'
            $table->string('reason')->nullable();             // short reason / category
            $table->text('message')->nullable();              // free-text details
            $table->string('status')->default('pending');     // pending | reviewed | dismissed
            $table->timestamps();

            $table->index('reporter_id');
            $table->index('reported_id');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_reports');
    }
}
