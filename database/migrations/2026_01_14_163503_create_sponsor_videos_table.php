<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsor_videos', function (Blueprint $table) {
            $table->id();

            $table->string('video_url');
            $table->string('playback_id');
            $table->string('asset_id');
            $table->boolean('is_video_deleted')->default(false);
            $table->boolean('is_video_suspended')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sponsor_videos');
    }
}
