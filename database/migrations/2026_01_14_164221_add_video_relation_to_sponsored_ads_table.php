<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoRelationToSponsoredAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
        Schema::table('sponsored_ads', function (Blueprint $table) {
            $table->foreignId('video_id')
            ->nullable()
            ->after('payment_transaction_id')
            ->constrained('sponsor_videos')
            ->nullOnDelete()
            ->unique(); // one-to-one
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sponsored_ads', function (Blueprint $table) {
            $table->dropForeign(['video_id']);
            $table->dropColumn('video_id');
        });
    }
}
