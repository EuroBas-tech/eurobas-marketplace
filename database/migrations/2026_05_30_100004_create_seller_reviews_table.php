<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Milestone 3 — Seller Rating System.
 *
 * EuroBas's existing `reviews` table is ad-scoped (ad_id) and is left untouched.
 * Sellers here are the ad-posting users, so seller ratings get their own table:
 * one star rating (1–5) + written review per customer, per seller.
 */
class CreateSellerReviewsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('seller_reviews')) {
            return;
        }

        Schema::create('seller_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');   // user being rated (the seller)
            $table->unsignedBigInteger('customer_id'); // user leaving the rating
            $table->unsignedTinyInteger('rating');     // 1..5
            $table->text('comment')->nullable();
            $table->boolean('status')->default(1);     // 1 = visible
            $table->timestamps();

            $table->unique(['seller_id', 'customer_id']); // one review per customer per seller
            $table->index('seller_id');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('seller_reviews');
    }
}
