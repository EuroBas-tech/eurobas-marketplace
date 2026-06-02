<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Milestone 2 — Block User.
 * A blocker hides/blocks another user. Blocked users cannot send messages and
 * do not appear in the blocker's chat list. Used by both chat and seller profile.
 */
class CreateUserBlocksTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('user_blocks')) {
            return;
        }

        Schema::create('user_blocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blocker_id'); // user performing the block
            $table->unsignedBigInteger('blocked_id'); // user being blocked
            $table->timestamps();

            $table->unique(['blocker_id', 'blocked_id']);
            $table->index('blocker_id');
            $table->index('blocked_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_blocks');
    }
}
