<?php

namespace Tests\Feature\Api;

use App\Model\Ad;
use App\Model\AdAuction;
use App\Model\Category;
use App\Model\SponsoredAd;
use App\Model\SubscriptionPackage;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * §3 listing lifecycle + §5 offers & report.
 */
class AdLifecycleTest extends TestCase
{
    use DatabaseTransactions;

    private User $user;
    private int $categoryId;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        // Stub the geocode call store()/update() make so tests never hit Google.
        Http::fake(['*googleapis.com*' => Http::response(['status' => 'OK', 'results' => [['geometry' => ['location' => ['lat' => 52.0, 'lng' => 5.0]]]]])]);

        $this->categoryId = (int) Category::where('position', 1)->value('id');
        if (!$this->categoryId) {
            $this->markTestSkipped('no seeded category available');
        }

        $this->user = $this->makeUser();
        Passport::actingAs($this->user);
    }

    private function makeUser(): User
    {
        return User::create([
            'name' => 'Owner ' . Str::random(5),
            'email' => 'owner_' . Str::random(8) . '@test.com',
            'password' => bcrypt('TestPass1'),
            'account_type' => 'individual',
            'f_name' => 'Test', 'l_name' => 'User',
            'phone_code' => '+31', 'phone' => '0600000000',
            'country' => 'Netherlands', 'city' => 'Rotterdam',
            'native_language' => 'en', 'is_active' => 1,
        ]);
    }

    private function makeAd(int $userId, array $o = []): Ad
    {
        $ad = new Ad();
        $ad->user_id = $userId;
        $ad->title = $o['title'] ?? 'Test Ad ' . Str::random(5);
        $ad->slug = Str::slug($ad->title) . '-' . Str::random(6);
        $ad->category_id = $o['category_id'] ?? $this->categoryId;
        $ad->price_type = $o['price_type'] ?? 'fixed_price';
        $ad->price = $o['price'] ?? 1000;
        $ad->starting_price = $o['starting_price'] ?? null;
        $ad->currency = 'EUR';
        $ad->country = 'Netherlands';
        $ad->city = 'Rotterdam';
        $ad->status = $o['status'] ?? 1;
        $ad->images = json_encode([]);
        $ad->save();
        return $ad;
    }

    private function adPayload(array $o = []): array
    {
        return array_merge([
            'title' => 'Created ' . Str::random(4),
            'description' => 'desc',
            'category_id' => $this->categoryId,
            'price_type' => 'fixed_price',
            'price' => 4500,
            'currency' => 'EUR',
            'country' => 'Netherlands',
            'city' => 'Rotterdam',
        ], $o);
    }

    // ─── §3 CRUD ─────────────────────────────────────────────────────────

    public function test_create_ad_with_images()
    {
        $res = $this->post('/api/v1/ads', $this->adPayload([
            'image' => UploadedFile::fake()->image('thumb.jpg'),
            'images' => [UploadedFile::fake()->image('g1.jpg'), UploadedFile::fake()->image('g2.jpg')],
        ]), ['Accept' => 'application/json']);

        $res->assertStatus(201)->assertJsonPath('with_payment', false);
        $id = $res->json('ad.id');
        $this->assertDatabaseHas('ads', ['id' => $id, 'user_id' => $this->user->id, 'status' => 1]);
        $this->assertCount(2, json_decode(Ad::find($id)->images, true));
        $this->assertNotEmpty(Ad::find($id)->thumbnail);
    }

    public function test_create_ad_validation_fails()
    {
        $this->post('/api/v1/ads', ['title' => 'x'], ['Accept' => 'application/json'])->assertStatus(422);
    }

    public function test_create_ad_fixed_price_requires_price()
    {
        $this->post('/api/v1/ads', $this->adPayload(['price' => null]), ['Accept' => 'application/json'])->assertStatus(422);
    }

    public function test_create_free_ad_without_price()
    {
        $this->post('/api/v1/ads', $this->adPayload(['price_type' => 'free', 'price' => null, 'image' => UploadedFile::fake()->image('t.jpg')]), ['Accept' => 'application/json'])
            ->assertStatus(201);
    }

    public function test_free_listing_is_published_immediately()
    {
        $res = $this->post('/api/v1/ads', $this->adPayload(['image' => UploadedFile::fake()->image('t.jpg')]), ['Accept' => 'application/json']);
        $res->assertStatus(201)->assertJsonPath('with_payment', false)->assertJsonPath('ad.status', 1);
    }

    public function test_paid_promotion_defers_publish_until_payment()
    {
        $paid = SubscriptionPackage::where('status', 1)->where('price', '>', 0)
            ->whereHas('type', fn($q) => $q->where('name', 'appearance_in_first_results'))->first();
        if (!$paid) {
            $this->markTestSkipped('no paid appearance_in_first_results package seeded');
        }

        // Create a listing WITH a paid promotion → must stay unpublished.
        $res = $this->post('/api/v1/ads', $this->adPayload([
            'appear_on_first_results_sponsor' => $paid->id,
            'image' => UploadedFile::fake()->image('t.jpg'),
        ]), ['Accept' => 'application/json']);

        $res->assertStatus(201)
            ->assertJsonPath('with_payment', true)
            ->assertJsonPath('ad.status', 0)
            ->assertJsonPath('payment.0.model_type', 'sponsor');

        $adId = $res->json('ad.id');
        $sponsorId = $res->json('payment.0.model_id');
        $this->assertSame(0, (int) Ad::find($adId)->status, 'listing must NOT be published before payment');
        $this->assertSame(0, (int) SponsoredAd::find($sponsorId)->is_paid);

        // Simulate a successful gateway payment, then the app polls verify.
        SponsoredAd::where('id', $sponsorId)->update(['is_paid' => 1, 'payment_transaction_id' => 'TEST_TXN']);
        $this->getJson("/api/v1/payment/verify?model_type=sponsor&model_id={$sponsorId}")
            ->assertStatus(200)->assertJsonPath('is_paid', true);

        $this->assertSame(1, (int) Ad::find($adId)->status, 'listing must be published only after successful payment');
    }

    public function test_update_own_ad()
    {
        $ad = $this->makeAd($this->user->id);
        $this->post("/api/v1/ads/{$ad->id}", $this->adPayload(['title' => 'Edited Title']), ['Accept' => 'application/json'])
            ->assertStatus(200)->assertJsonPath('ad.title', 'Edited Title');
    }

    public function test_cannot_update_another_users_ad()
    {
        $ad = $this->makeAd($this->makeUser()->id);
        $this->post("/api/v1/ads/{$ad->id}", $this->adPayload(), ['Accept' => 'application/json'])->assertStatus(404);
    }

    public function test_delete_own_ad()
    {
        $ad = $this->makeAd($this->user->id);
        $this->deleteJson("/api/v1/ads/{$ad->id}")->assertStatus(200);
        $this->assertDatabaseMissing('ads', ['id' => $ad->id]);
    }

    public function test_cannot_delete_another_users_ad()
    {
        $ad = $this->makeAd($this->makeUser()->id);
        $this->deleteJson("/api/v1/ads/{$ad->id}")->assertStatus(404);
    }

    public function test_create_options()
    {
        $this->getJson("/api/v1/ads/create-options?category_id={$this->categoryId}")
            ->assertStatus(200)->assertJsonStructure(['categories', 'brands', 'models', 'fields', 'sponsor_packages', 'limits']);
    }

    public function test_category_fields()
    {
        $this->getJson("/api/v1/categories/{$this->categoryId}/fields")->assertStatus(200)->assertJsonStructure(['category', 'category_type', 'fields']);
        $this->getJson('/api/v1/categories/99999999/fields')->assertStatus(404);
    }

    public function test_show_by_slug()
    {
        $ad = $this->makeAd($this->user->id);
        $this->getJson("/api/v1/ads/show-by-slug/{$ad->slug}")->assertStatus(200)->assertJsonPath('ad.id', $ad->id);
        $this->getJson('/api/v1/ads/show-by-slug/nope-not-real')->assertStatus(404);
    }

    public function test_by_category_and_filter_count()
    {
        $this->getJson("/api/v1/ads/by-category/{$this->categoryId}")->assertStatus(200)->assertJsonStructure(['category', 'ads']);
        $this->getJson('/api/v1/ads/by-category/99999999')->assertStatus(404);

        $filter = $this->postJson('/api/v1/ads/filter', ['category_id' => $this->categoryId]);
        $count = $this->postJson('/api/v1/ads/filter-count', ['category_id' => $this->categoryId]);
        $filter->assertStatus(200);
        $count->assertStatus(200);
        $this->assertSame($filter->json('total'), $count->json('count'));
    }

    // ─── §5 offers & report ──────────────────────────────────────────────

    public function test_place_asking_price_creates_row_and_chat_message()
    {
        $ad = $this->makeAd($this->makeUser()->id, ['price_type' => 'asking_price']);
        $this->postJson('/api/v1/ads/asking-price', ['ad_id' => $ad->id, 'price' => 1234])
            ->assertStatus(201);
        $this->assertDatabaseHas('ad_asking_price', ['ad_id' => $ad->id, 'user_id' => $this->user->id]);
        $this->assertDatabaseHas('chattings', ['ad_id' => $ad->id, 'sender_id' => $this->user->id, 'receiver_id' => $ad->user_id]);
    }

    public function test_duplicate_asking_price_rejected()
    {
        $ad = $this->makeAd($this->makeUser()->id, ['price_type' => 'asking_price']);
        $this->postJson('/api/v1/ads/asking-price', ['ad_id' => $ad->id, 'price' => 1000])->assertStatus(201);
        $this->postJson('/api/v1/ads/asking-price', ['ad_id' => $ad->id, 'price' => 2000])->assertStatus(409);
    }

    public function test_place_auction_creates_chat_message()
    {
        $ad = $this->makeAd($this->makeUser()->id, ['price_type' => 'auction', 'starting_price' => 100]);
        $this->postJson('/api/v1/ads/auction', ['id' => $ad->id, 'price' => 500])->assertStatus(201);
        $this->assertDatabaseHas('chattings', ['ad_id' => $ad->id, 'sender_id' => $this->user->id]);
    }

    public function test_delete_own_and_others_auction()
    {
        $ad = $this->makeAd($this->makeUser()->id, ['price_type' => 'auction', 'starting_price' => 100]);
        // mine
        $this->postJson('/api/v1/ads/auction', ['id' => $ad->id, 'price' => 500])->assertStatus(201);
        $mine = AdAuction::where('ad_id', $ad->id)->where('user_id', $this->user->id)->value('id');
        // another user's bid on same ad (model is guarded -> new + save)
        $o = new AdAuction();
        $o->ad_id = $ad->id;
        $o->user_id = $this->makeUser()->id;
        $o->price = 600;
        $o->save();

        $this->deleteJson("/api/v1/ads/auction/{$o->id}")->assertStatus(404);
        $this->deleteJson("/api/v1/ads/auction/{$mine}")->assertStatus(200);
    }

    public function test_report_rules()
    {
        $ownAd = $this->makeAd($this->user->id);
        $this->postJson('/api/v1/ads/report', ['id' => $ownAd->id, 'message' => 'm'])->assertStatus(403);

        $otherAd = $this->makeAd($this->makeUser()->id);
        $this->postJson('/api/v1/ads/report', ['id' => $otherAd->id, 'message' => 'spam'])->assertStatus(201);
        $this->postJson('/api/v1/ads/report', ['id' => $otherAd->id, 'message' => 'again'])->assertStatus(409);
    }

    public function test_public_ad_show_does_not_leak_seller_pii()
    {
        $seller = $this->makeUser();
        // Seller opted out of showing email/phone.
        User::where('id', $seller->id)->update(['show_email_address' => 0]);
        $ad = $this->makeAd($seller->id);
        Ad::where('id', $ad->id)->update(['contact_phone_number' => '0600000000', 'show_phone_number' => 0]);

        // Viewer is $this->user (set in setUp), i.e. NOT the seller.
        $res = $this->getJson("/api/v1/ads/show/{$ad->id}")->assertStatus(200);

        $this->assertNull($res->json('ad.user'), 'raw seller user must not be serialized on the ad');
        $this->assertNotNull($res->json('seller'), 'redacted seller profile should still be present');
        $this->assertNull($res->json('ad.contact_phone_number'), 'hidden phone must be redacted for non-owners');
        $this->assertNull($res->json('seller.email'), 'seller email hidden when show_email_address=0');
    }

    public function test_owner_sees_own_contact_phone()
    {
        $ad = $this->makeAd($this->user->id);
        Ad::where('id', $ad->id)->update(['contact_phone_number' => '0612345678', 'show_phone_number' => 0]);

        $res = $this->getJson("/api/v1/ads/show/{$ad->id}")->assertStatus(200);
        $this->assertSame('0612345678', $res->json('ad.contact_phone_number'), 'owner sees their own phone');
    }

    public function test_filter_does_not_leak_seller_contact_fields()
    {
        $seller = $this->makeUser();
        $this->makeAd($seller->id);

        $res = $this->postJson('/api/v1/ads/filter', ['profile_id' => $seller->id])->assertStatus(200);
        foreach ($res->json('data') as $row) {
            $this->assertArrayNotHasKey('email', $row['user'] ?? [], 'seller email must not leak in ad lists');
            $this->assertArrayNotHasKey('phone', $row['user'] ?? [], 'seller phone must not leak in ad lists');
        }
    }

    public function test_ad_detail_includes_offer_lists()
    {
        $ad = $this->makeAd($this->makeUser()->id, ['price_type' => 'auction', 'starting_price' => 100]);
        $this->postJson('/api/v1/ads/auction', ['id' => $ad->id, 'price' => 500]);
        $this->getJson("/api/v1/ads/show/{$ad->id}")
            ->assertStatus(200)
            ->assertJsonStructure(['ad', 'seller', 'auctions', 'asking_price'])
            ->assertJsonPath('auctions.0.price', 500);
    }
}
