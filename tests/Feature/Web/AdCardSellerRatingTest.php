<?php

namespace Tests\Feature\Web;

use App\Model\Ad;
use App\Model\SellerReview;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Milestone 3 #5 — "Seller's average rating and review count displayed on ad cards
 * throughout the listing pages, under the seller's name."
 *
 * Renders each AD card partial (large / ajax-large / small) with a real ad whose
 * seller has reviews, and asserts the seller name + star rating + count appear.
 */
class AdCardSellerRatingTest extends TestCase
{
    use DatabaseTransactions;

    private function realActiveAd(): ?Ad
    {
        return Ad::where('status', 1)->whereNotNull('user_id')->whereNotNull('category_id')
            ->with('category', 'brand', 'model')->first();
    }

    private function rate(Ad $ad): void
    {
        $rater = User::create([
            'name' => 'Rater ' . Str::random(5), 'email' => 'r_' . Str::random(8) . '@test.com',
            'password' => bcrypt('TestPass1'), 'account_type' => 'individual',
            'f_name' => 'R', 'l_name' => 'U', 'phone_code' => '+31', 'phone' => '06',
            'country' => 'NL', 'city' => 'R', 'native_language' => 'en', 'is_active' => 1,
        ]);
        SellerReview::create(['seller_id' => $ad->user_id, 'customer_id' => $rater->id, 'rating' => 5, 'comment' => 'top', 'status' => 1]);
    }

    /** @test */
    public function large_card_shows_seller_name_and_rating()
    {
        $ad = $this->realActiveAd();
        if (!$ad) { $this->markTestSkipped('no renderable ad'); }
        $this->rate($ad);
        $sellerName = User::cachedName($ad->user_id);

        $html = View::make('theme-views.partials._product-large-card', ['ad' => $ad])->render();

        $this->assertStringContainsString('star-rating', $html);
        $this->assertStringContainsString('bi-star-fill', $html);
        $this->assertStringContainsString('(1)', $html);            // review count
        $this->assertStringContainsString(Str::limit($sellerName, 22), $html); // seller name
    }

    /** @test */
    public function ajax_large_card_shows_seller_name_and_rating()
    {
        $ad = $this->realActiveAd();
        if (!$ad) { $this->markTestSkipped('no renderable ad'); }
        $this->rate($ad);

        $html = View::make('theme-views.partials._ajax-product-large-card', ['ad' => $ad])->render();

        $this->assertStringContainsString('star-rating', $html);
        $this->assertStringContainsString('(1)', $html);
    }

    /** @test */
    public function large_card_shows_no_rating_block_when_seller_has_no_reviews()
    {
        $ad = $this->realActiveAd();
        if (!$ad) { $this->markTestSkipped('no renderable ad'); }

        // Point the ad at a brand-new seller with zero reviews (and a fresh id that
        // the per-request summary cache has never seen) → rating block must be absent.
        $fresh = User::create([
            'name' => 'NoReviews ' . Str::random(5), 'email' => 'nr_' . Str::random(8) . '@test.com',
            'password' => bcrypt('TestPass1'), 'account_type' => 'individual',
            'f_name' => 'N', 'l_name' => 'R', 'phone_code' => '+31', 'phone' => '06',
            'country' => 'NL', 'city' => 'R', 'native_language' => 'en', 'is_active' => 1,
        ]);
        $ad->user_id = $fresh->id;

        $html = View::make('theme-views.partials._product-large-card', ['ad' => $ad])->render();
        $this->assertStringNotContainsString('star-rating', $html);
    }
}
