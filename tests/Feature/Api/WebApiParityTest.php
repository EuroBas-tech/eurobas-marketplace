<?php

namespace Tests\Feature\Api;

use App\Http\Controllers\api\v1\AdController as ApiAd;
use App\Http\Controllers\Web\AdController as WebAd;
use App\Model\Ad;
use App\Model\Category;
use App\Model\Chatting;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Cross-surface parity: runs the SAME logic through the website's controllers and
 * the API's, against the same data, and asserts they agree. This verifies the API
 * matches the website behaviour (not just that the API works in isolation).
 */
class WebApiParityTest extends TestCase
{
    use DatabaseTransactions;

    private User $user;
    private int $categoryId;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        Http::fake(['*googleapis.com*' => Http::response(['status' => 'OK', 'results' => [['geometry' => ['location' => ['lat' => 52.0, 'lng' => 5.0]]]]])]);
        $this->categoryId = (int) Category::where('position', 1)->value('id');
        $this->user = $this->makeUser();
        Passport::actingAs($this->user);
    }

    private function makeUser(): User
    {
        return User::create([
            'name' => 'PR ' . Str::random(5), 'email' => 'pr_' . Str::random(8) . '@test.com',
            'password' => bcrypt('TestPass1'), 'account_type' => 'individual',
            'f_name' => 'P', 'l_name' => 'R', 'phone_code' => '+31', 'phone' => '06',
            'country' => 'Netherlands', 'city' => 'Rotterdam', 'native_language' => 'en', 'is_active' => 1,
        ]);
    }

    private function makeAd(int $userId, array $o = []): Ad
    {
        $ad = new Ad();
        $ad->user_id = $userId;
        $ad->title = 'PAd ' . Str::random(5);
        $ad->slug = Str::slug($ad->title) . '-' . Str::random(6);
        $ad->category_id = $o['category_id'] ?? $this->categoryId;
        $ad->brand_id = $o['brand_id'] ?? null;
        $ad->price_type = $o['price_type'] ?? 'fixed_price';
        $ad->price = $o['price'] ?? 1000;
        $ad->starting_price = $o['starting_price'] ?? null;
        $ad->year = $o['year'] ?? 2020;
        $ad->fuel_type = $o['fuel_type'] ?? null;
        $ad->currency = 'EUR';
        $ad->country = $o['country'] ?? 'Netherlands';
        $ad->city = 'Rotterdam';
        $ad->status = $o['status'] ?? 1;
        $ad->images = json_encode([]);
        $ad->save();
        return $ad;
    }

    /**
     * The website filter and the API filter must select the same ads for the same
     * parameters. We seed a known set of ads and run several parameter combinations
     * through BOTH controllers' ad_query_filter.
     */
    public function test_filter_logic_matches_website_exactly()
    {
        $this->makeAd($this->user->id, ['country' => 'Netherlands', 'price' => 1000, 'year' => 2020, 'fuel_type' => 'diesel']);
        $this->makeAd($this->user->id, ['country' => 'Germany', 'price' => 5000, 'year' => 2010, 'fuel_type' => 'petrol']);
        $this->makeAd($this->user->id, ['country' => 'Germany', 'price' => 9000, 'year' => 2022]);
        $this->makeAd($this->user->id, ['price_type' => 'auction', 'starting_price' => 2000, 'price' => null]);

        $web = new WebAd();
        $api = new ApiAd();

        $paramSets = [
            [],
            ['country' => 'Germany'],
            ['min_price' => 2000, 'max_price' => 6000],
            ['min_construction_year' => 2015],
            ['max_construction_year' => 2015],
            ['category_id' => $this->categoryId],
            ['fuel_type' => ['diesel']],
            ['country' => 'All Europe'],
        ];

        foreach ($paramSets as $params) {
            $webIds = $web->ad_query_filter(Ad::active(), new Request($params))->pluck('id')->sort()->values()->all();
            $apiIds = $api->ad_query_filter(Ad::active(), new Request($params))->pluck('id')->sort()->values()->all();
            $this->assertSame($webIds, $apiIds, 'filter mismatch for params: ' . json_encode($params));
        }
    }

    /** The API only ever exposes active ads — matching the website's Ad::active() scope. */
    public function test_api_filter_excludes_inactive_like_website()
    {
        $active = $this->makeAd($this->user->id, ['status' => 1]);
        $inactive = $this->makeAd($this->user->id, ['status' => 0]);

        $res = $this->postJson('/api/v1/ads/filter', ['profile_id' => $this->user->id])->assertStatus(200);
        $ids = collect($res->json('data'))->pluck('id');

        $this->assertTrue($ids->contains($active->id));
        $this->assertFalse($ids->contains($inactive->id), 'inactive ads must never appear (website parity)');
    }

    /** users/{id} ads_count must equal the website profile's computation (active ads). */
    public function test_seller_ads_count_matches_website_profile()
    {
        $seller = $this->makeUser();
        $this->makeAd($seller->id, ['status' => 1]);
        $this->makeAd($seller->id, ['status' => 1]);
        $this->makeAd($seller->id, ['status' => 0]); // inactive, must not count

        // How the website profile computes it (UserProfileController@show_profile, post-fix):
        $websiteCount = User::with('ads')->find($seller->id)->ads->where('status', 1)->count();

        $apiCount = $this->getJson("/api/v1/users/{$seller->id}")->assertStatus(200)->json('user.ads_count');

        $this->assertSame(2, $websiteCount);
        $this->assertSame($websiteCount, $apiCount, 'API ads_count must match the website profile count');
    }

    /**
     * popular_categories counts must equal the actual active-ad count per category.
     * Invoked directly (the route sits behind the guest-check middleware, which is
     * orthogonal to the count logic under test here).
     */
    public function test_popular_categories_counts_match_active_ads()
    {
        $data = (new \App\Http\Controllers\api\v1\CategoryController())->popular_categories()->getData(true);
        $this->assertNotEmpty($data);
        foreach ($data as $cat) {
            $expected = Ad::active()->where('category_id', $cat['id'])->count();
            $this->assertSame($expected, $cat['ads_count'], "category {$cat['id']} count must match active ads");
        }
    }

    /** ads/show by id and by slug resolve the same ad, both within the active scope the website uses. */
    public function test_show_by_id_and_slug_resolve_same_active_ad()
    {
        $ad = $this->makeAd($this->user->id);
        $byId = $this->getJson("/api/v1/ads/show/{$ad->id}")->assertStatus(200)->json('ad.id');
        $bySlug = $this->getJson("/api/v1/ads/show-by-slug/{$ad->slug}")->assertStatus(200)->json('ad.id');
        $this->assertSame($ad->id, $byId);
        $this->assertSame($ad->id, $bySlug);
    }

    /**
     * The asking-price offer writes a chat row with the same shape the website's
     * ChattingController@messages_store produces (seller-facing message + ad context).
     */
    public function test_offer_chat_row_matches_website_shape()
    {
        $seller = $this->makeUser();
        $ad = $this->makeAd($seller->id, ['price_type' => 'asking_price']);

        $this->postJson('/api/v1/ads/asking-price', ['ad_id' => $ad->id, 'price' => 4242])->assertStatus(201);

        $chat = Chatting::where('ad_id', $ad->id)->where('sender_id', $this->user->id)->latest('id')->first();
        $this->assertNotNull($chat, 'a chat message must be created (website parity)');
        $this->assertSame($seller->id, (int) $chat->receiver_id);
        $this->assertSame(0, (int) $chat->seen);
        $this->assertNotEmpty($chat->message);
        $this->assertIsArray(json_decode($chat->attachment, true), 'attachment must be a JSON array like the website');
    }

    /**
     * Creating an ad via the API maps the request onto the same columns, with the
     * same "on"-flag and asking-price/allow-offers handling, as Web\AdController@store.
     */
    public function test_create_maps_fields_like_website()
    {
        $payload = [
            'title' => 'Mapping Test', 'description' => 'd', 'category_id' => $this->categoryId,
            'price_type' => 'asking_price', 'price' => 12000, 'first_price' => 9000, 'allow_offers' => 'on',
            'currency' => 'EUR', 'country' => 'Netherlands', 'city' => 'Rotterdam', 'postal_code' => '3024 EA',
            'status' => 'used', 'year' => '2019', 'mileage' => '50000', 'fuel_type' => 'diesel',
            'transmission_type' => 'automatic', 'body_type' => 'suv', 'doors_number' => '4', 'color' => 'black',
            'show_phone_number' => 'on', 'contact_phone_number' => '0612345678',
            'whatsapp_availability' => 'on', 'show_email_address' => 'on',
            'image' => UploadedFile::fake()->image('t.jpg'),
        ];

        $id = $this->post('/api/v1/ads', $payload, ['Accept' => 'application/json'])->assertStatus(201)->json('ad.id');
        $ad = Ad::find($id);

        // Same column mapping the website's store() applies:
        $this->assertSame('used', $ad->ad_status);            // request 'status' -> ad_status
        $this->assertSame(1, (int) $ad->show_phone_number);   // 'on' -> 1
        $this->assertSame(1, (int) $ad->whatsapp_availability);
        $this->assertSame(1, (int) $ad->show_email_address);
        $this->assertSame(1, (int) $ad->allow_offers);        // asking_price + allow_offers=on
        $this->assertSame('9000', (string) $ad->first_price);
        $this->assertSame('diesel', $ad->fuel_type);
        $this->assertSame('2019', (string) $ad->year);
        $this->assertSame('automatic', $ad->transmission_type);
        $this->assertSame('suv', $ad->body_type);
        $this->assertSame('4', (string) $ad->doors_number);
        $this->assertSame('black', $ad->color);
        $this->assertSame('3024 EA', $ad->postal_code);
        $this->assertSame('0612345678', $ad->contact_phone_number);
        $this->assertSame('asking_price', $ad->price_type);
    }

    /**
     * The ad-detail composition (gallery count, more-from-seller, view tracking)
     * matches Web\AdController@show.
     */
    public function test_ad_detail_computed_fields_match_website()
    {
        $seller = $this->makeUser();
        $ad = $this->makeAd($seller->id);
        $ad->images = json_encode(['a.webp', 'b.webp']); // 2 gallery images
        $ad->save();
        $other = $this->makeAd($seller->id); // another ad by same seller

        $res = $this->getJson("/api/v1/ads/show/{$ad->id}")->assertStatus(200);

        // Website: count(json_decode(images)) + 1 (thumbnail).
        $this->assertSame(3, $res->json('gallery_images_number'));
        // Website: more ads from the same user (active, excluding this one).
        $this->assertContains($other->id, collect($res->json('more_ads_from_user'))->pluck('id')->all());
        // A view row is tracked like the website (table: ads_views).
        $this->assertDatabaseHas('ads_views', ['ad_id' => $ad->id]);
        $this->assertIsInt($res->json('ad_views_number'));
    }

    /** Auction bid guards reject the same cases the website's store_auction does. */
    public function test_auction_guards_match_website()
    {
        $ad = $this->makeAd($this->makeUser()->id, ['price_type' => 'auction', 'starting_price' => 1000, 'price' => null]);

        // <= starting price -> rejected (website: must be greater than starting/last)
        $this->postJson('/api/v1/ads/auction', ['id' => $ad->id, 'price' => 800])->assertStatus(422);
        // valid bid
        $this->postJson('/api/v1/ads/auction', ['id' => $ad->id, 'price' => 1500])->assertStatus(201);
        // same user bidding again -> rejected
        $this->postJson('/api/v1/ads/auction', ['id' => $ad->id, 'price' => 2000])->assertStatus(409);
    }

    /**
     * Editing maps fields like Web\AdController@update: retains kept old_images,
     * appends new ones, updates columns, and does NOT republish (status unchanged).
     */
    public function test_update_maps_fields_like_website()
    {
        $ad = $this->makeAd($this->user->id);
        $ad->images = json_encode(['keep.webp', 'drop.webp']);
        $ad->save();

        $payload = [
            'title' => 'Edited Mapping', 'description' => 'd2', 'category_id' => $this->categoryId,
            'price_type' => 'fixed_price', 'price' => 7777, 'currency' => 'EUR',
            'country' => 'Germany', 'city' => 'Berlin', 'fuel_type' => 'petrol', 'year' => '2018',
            'old_images' => ['keep.webp'],
            'images' => [UploadedFile::fake()->image('newgallery.jpg')], // new gallery image
            'image' => UploadedFile::fake()->image('newthumb.jpg'),      // thumbnail
        ];

        $this->post("/api/v1/ads/{$ad->id}", $payload, ['Accept' => 'application/json'])->assertStatus(200);

        $fresh = Ad::find($ad->id);
        $this->assertSame('Edited Mapping', $fresh->title);
        $this->assertSame('petrol', $fresh->fuel_type);
        $this->assertSame('2018', (string) $fresh->year);
        $this->assertSame('Germany', $fresh->country);
        $images = json_decode($fresh->images, true);
        $this->assertContains('keep.webp', $images, 'kept old image retained');
        $this->assertNotContains('drop.webp', $images, 'dropped old image removed');
        $this->assertCount(2, $images, 'kept image + 1 newly uploaded');
        $this->assertSame(1, (int) $fresh->status, 'editing does not unpublish (website parity)');
    }

    /** Chat send + list produce the same row shape/behaviour as the website. */
    public function test_chat_send_and_list_shape_match_website()
    {
        $partner = $this->makeUser();

        $this->post('/api/v1/customer/chat/send-message', ['id' => $partner->id, 'message' => 'hello there'], ['Accept' => 'application/json'])
            ->assertStatus(200);

        // Website Chatting columns: sender_id, receiver_id, message, attachment(json), seen.
        $row = Chatting::where('sender_id', $this->user->id)->where('receiver_id', $partner->id)->latest('id')->first();
        $this->assertNotNull($row);
        $this->assertSame('hello there', $row->message);
        $this->assertSame(0, (int) $row->seen);
        $this->assertIsArray(json_decode($row->attachment, true));

        $list = $this->getJson('/api/v1/customer/chat/list')->assertStatus(200);
        $first = $list->json('chat.0');
        $this->assertArrayHasKey('unseen_message_count', $first);
        $this->assertArrayHasKey('last_message', $first);
        $this->assertArrayHasKey('partner_id', $first);
    }

    /** /config values come from the same BusinessSetting source the website uses. */
    public function test_config_values_match_business_settings_source()
    {
        $res = $this->getJson('/api/v1/config')->assertStatus(200);

        $this->assertSame(\App\CPU\Helpers::get_business_settings('about_us') ?? '', $res->json('about_us'));
        $this->assertSame(\App\CPU\Helpers::get_business_settings('privacy_policy') ?? '', $res->json('privacy_policy'));
        $this->assertSame(\App\CPU\Helpers::get_business_settings('terms_condition') ?? '', $res->json('terms_&_conditions'));
        $this->assertSame(cloudfront('profile/images'), $res->json('base_urls.customer_image_url'));
        $this->assertSame(cloudfront('profile/covers'), $res->json('base_urls.cover_image_url'));
    }
}
