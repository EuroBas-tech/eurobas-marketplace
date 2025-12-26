<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

   public function up(): void
{
    if (!Schema::hasTable('temporary_videos')) {
        Schema::create('temporary_videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ad_id')->nullable();
            $table->string('upload_id')->nullable();
            $table->string('asset_id')->nullable()->index();
            $table->string('playback_id')->nullable();
            $table->enum('status', ['pending', 'paid', 'deleted'])->default('pending');
            $table->timestamps();
        });
    }
}

    public function down(): void
    {
        Schema::dropIfExists('temporary_videos');
    }
};
