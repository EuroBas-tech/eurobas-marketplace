<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveVideoFieldsFromSponsoredAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sponsored_ads', function (Blueprint $table) {
            $table->dropColumn([
                'video_url',
                'playback_id',
                'is_video_deleted',
                'is_video_suspended',
            ]);
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
            $table->string('video_url')->nullable();
            $table->string('playback_id')->nullable();
            $table->boolean('is_video_deleted')->default(false);
            $table->boolean('is_video_suspended')->default(false);
        });
    }
}
