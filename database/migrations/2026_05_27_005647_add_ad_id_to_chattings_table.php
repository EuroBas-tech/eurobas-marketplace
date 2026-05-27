<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdIdToChattingsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('chattings', 'ad_id')) {
            Schema::table('chattings', function (Blueprint $table) {
                // "Chat about this ad" context for a conversation/message.
                $table->unsignedBigInteger('ad_id')->nullable()->after('receiver_id');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('chattings', 'ad_id')) {
            Schema::table('chattings', function (Blueprint $table) {
                $table->dropColumn('ad_id');
            });
        }
    }
}
