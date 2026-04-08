<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaidBannersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('paid_banners')) {
            Schema::create('paid_banners', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('category_id')->nullable();
                $table->unsignedBigInteger('package_id')->nullable();
                $table->string('banner_url')->nullable();
                $table->string('banner_image')->nullable();
                $table->decimal('price', 10, 2)->default(0);
                $table->integer('duration_in_days')->default(0);
                $table->timestamp('expiration_date')->nullable();
                $table->tinyInteger('is_paid')->default(0);
                $table->tinyInteger('status')->default(1);
                $table->timestamps();

                if (Schema::hasTable('users')) {
                    $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
                }
                if (Schema::hasTable('categories')) {
                    $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
                }
                if (Schema::hasTable('subscription_packages')) {
                    $table->foreign('package_id')->references('id')->on('subscription_packages')->nullOnDelete();
                }
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('paid_banners');
    }
}
