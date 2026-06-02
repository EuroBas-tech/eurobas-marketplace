<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Milestone 2 — Message status (Sent / Delivered / Seen) + per-user soft delete.
 *
 *  - delivered_at: set when the recipient loads their chat list (double check).
 *  - seen_at:      set when the recipient opens the conversation (blue double check).
 *                  The legacy `seen` flag is preserved and kept in sync.
 *  - deleted_by_sender / deleted_by_receiver: per-user soft delete so a message
 *    (or a whole conversation) disappears for one party only.
 */
class AddStatusColumnsToChattingsTable extends Migration
{
    public function up()
    {
        Schema::table('chattings', function (Blueprint $table) {
            if (!Schema::hasColumn('chattings', 'delivered_at')) {
                $table->timestamp('delivered_at')->nullable()->after('seen');
            }
            if (!Schema::hasColumn('chattings', 'seen_at')) {
                $table->timestamp('seen_at')->nullable()->after('delivered_at');
            }
            if (!Schema::hasColumn('chattings', 'deleted_by_sender')) {
                $table->boolean('deleted_by_sender')->default(0)->after('seen_at');
            }
            if (!Schema::hasColumn('chattings', 'deleted_by_receiver')) {
                $table->boolean('deleted_by_receiver')->default(0)->after('deleted_by_sender');
            }
        });
    }

    public function down()
    {
        Schema::table('chattings', function (Blueprint $table) {
            foreach (['delivered_at', 'seen_at', 'deleted_by_sender', 'deleted_by_receiver'] as $col) {
                if (Schema::hasColumn('chattings', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
}
