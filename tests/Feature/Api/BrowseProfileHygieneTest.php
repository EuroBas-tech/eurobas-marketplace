<?php

namespace Tests\Feature\Api;

use App\Model\Ad;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Chatting;
use App\Model\VehicleModel;
use App\Model\Wishlist;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * §6 browse/discovery, public profile, chat parity, and hygiene fixes.
 */
class BrowseProfileHygieneTest extends TestCase
{
    use DatabaseTransactions;

    private User $user;
    private int $categoryId;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        $this->categoryId = (int) Category::where('position', 1)->value('id');
        $this->user = $this->makeUser();
        Passport::actingAs($this->user);
    }

    private function makeUser(array $o = []): User
    {
        return User::create(array_merge([
            'name' => 'U ' . Str::random(5), 'email' => 'u_' . Str::random(8) . '@test.com',
            'password' => bcrypt('TestPass1'), 'account_type' => 'individual',
            'f_name' => 'U', 'l_name' => 'U', 'phone_code' => '+31', 'phone' => '06',
            'country' => 'Germany', 'city' => 'Berlin', 'native_language' => 'en', 'is_active' => 1,
        ], $o));
    }

    private function makeAd(int $userId): Ad
    {
        $ad = new Ad();
        $ad->user_id = $userId;
        $ad->title = 'Ad ' . Str::random(5);
        $ad->slug = Str::slug($ad->title) . '-' . Str::random(6);
        $ad->category_id = $this->categoryId;
        $ad->price_type = 'fixed_price';
        $ad->price = 1000;
        $ad->currency = 'EUR';
        $ad->status = 1;
        $ad->images = json_encode([]);
        $ad->save();
        return $ad;
    }

    // ─── §6.3 browse ─────────────────────────────────────────────────────

    public function test_home_feed()
    {
        $this->getJson('/api/v1/home')->assertStatus(200)->assertJsonStructure(['categories', 'banners']);
    }

    public function test_brands_endpoints()
    {
        $this->getJson('/api/v1/brands')->assertStatus(200)->assertJsonStructure(['brands']);
        $this->getJson('/api/v1/brands?with_models=1')->assertStatus(200);

        $brandId = Brand::value('id');
        if ($brandId) {
            $this->getJson("/api/v1/brands/{$brandId}")->assertStatus(200)->assertJsonStructure(['brand', 'models']);
        }
        $modelId = VehicleModel::value('id');
        if ($modelId) {
            $this->getJson("/api/v1/models/{$modelId}/ads")->assertStatus(200)->assertJsonStructure(['data']);
        }
    }

    // ─── §6.2 public profile ─────────────────────────────────────────────

    public function test_public_profile_sections_and_gating()
    {
        $seller = $this->makeUser(['show_location_data' => 0, 'country' => 'Germany']);
        $this->makeAd($seller->id);

        $res = $this->getJson("/api/v1/users/{$seller->id}")->assertStatus(200)
            ->assertJsonStructure(['user', 'categories', 'brands', 'ads']);
        $this->assertNull($res->json('user.country'), 'country must be hidden when show_location_data=0');
        $this->assertNull($res->json('user.postal_code'));

        $this->getJson("/api/v1/users/{$seller->id}/ads")->assertStatus(200)->assertJsonStructure(['data']);
    }

    public function test_filter_honours_profile_id()
    {
        $seller = $this->makeUser();
        $this->makeAd($seller->id);
        $res = $this->postJson('/api/v1/ads/filter', ['profile_id' => $seller->id])->assertStatus(200);
        foreach ($res->json('data') as $row) {
            $this->assertSame($seller->id, $row['user_id']);
        }
    }

    // ─── §6.1 chat ───────────────────────────────────────────────────────

    public function test_chat_send_with_image_and_ad_context()
    {
        $partner = $this->makeUser();
        $ad = $this->makeAd($partner->id);
        $res = $this->post('/api/v1/customer/chat/send-message', [
            'id' => $partner->id, 'message' => 'hi', 'ad_id' => $ad->id,
            'image' => [UploadedFile::fake()->image('c.jpg')],
        ], ['Accept' => 'application/json']);
        $res->assertStatus(200)->assertJsonPath('data.ad.id', $ad->id);
        $this->assertCount(1, $res->json('data.attachment_images'));
        $this->assertDatabaseHas('chattings', ['sender_id' => $this->user->id, 'receiver_id' => $partner->id, 'ad_id' => $ad->id]);
    }

    public function test_chat_unread_and_mark_seen_on_open()
    {
        $partner = $this->makeUser();
        $c = new Chatting();
        $c->sender_id = $partner->id;
        $c->receiver_id = $this->user->id;
        $c->message = 'hi';
        $c->seen = 0;
        $c->save();

        $this->getJson('/api/v1/customer/chat/unread-count')->assertStatus(200)->assertJsonStructure(['unread_count']);
        $this->getJson("/api/v1/customer/chat/get-messages/{$partner->id}")->assertStatus(200);
        $this->assertSame(1, (int) Chatting::find($c->id)->seen, 'opening conversation marks partner messages seen');
    }

    public function test_chat_mark_seen_endpoint()
    {
        $partner = $this->makeUser();
        $this->postJson('/api/v1/customer/chat/mark-seen', ['id' => $partner->id])->assertStatus(200);
    }

    // ─── §6.4 hygiene ────────────────────────────────────────────────────

    public function test_wishlist_clear_all()
    {
        $ad = $this->makeAd($this->makeUser()->id);
        $w = new Wishlist();
        $w->customer_id = $this->user->id;
        $w->ad_id = $ad->id;
        $w->save();

        $this->deleteJson('/api/v1/customer/wish-list/clear')->assertStatus(200);
        $this->assertSame(0, Wishlist::where('customer_id', $this->user->id)->count());
    }

    public function test_support_ticket_attachment_and_delete()
    {
        $res = $this->post('/api/v1/customer/support-ticket/create', [
            'subject' => 'S', 'type' => 'general', 'description' => 'd', 'priority' => 'low',
            'image' => [UploadedFile::fake()->image('t.jpg')],
        ], ['Accept' => 'application/json']);
        $res->assertStatus(200);

        $ticket = \App\Model\SupportTicket::where('customer_id', $this->user->id)->latest('id')->first();
        $this->assertNotEmpty($ticket->attachment);
        $this->assertNotSame('[]', $ticket->attachment);

        $this->post("/api/v1/customer/support-ticket/reply/{$ticket->id}", ['message' => 'r', 'image' => [UploadedFile::fake()->image('r.jpg')]], ['Accept' => 'application/json'])->assertStatus(200);
        $this->deleteJson("/api/v1/customer/support-ticket/{$ticket->id}")->assertStatus(200);
        $this->assertDatabaseMissing('support_tickets', ['id' => $ticket->id]);
    }

    // ─── §6.6 / §6.7 / §6.5 ──────────────────────────────────────────────

    public function test_static_pages()
    {
        $this->getJson('/api/v1/pages/privacy-policy')->assertStatus(200)->assertJsonStructure(['title', 'content']);
        $this->getJson('/api/v1/pages/not-a-page')->assertStatus(404);
    }

    public function test_parity_translation_keys_present()
    {
        $res = $this->getJson('/api/v1/locale/translations/en')->assertStatus(200);
        $tr = $res->json('translations');
        $this->assertArrayHasKey('view_profile', $tr);
        $this->assertArrayHasKey('joined_n_days_ago', $tr);
        $this->assertStringContainsString(':count', $tr['joined_n_days_ago']);
    }

    public function test_profile_partial_update_preserves_untouched_fields()
    {
        // Regression test for the update_profile data-loss bug.
        $this->assertSame('Germany', $this->user->country);
        $this->putJson('/api/v1/customer/profile/update', ['name' => 'Renamed', 'email' => $this->user->email])
            ->assertStatus(200);
        $fresh = User::find($this->user->id);
        $this->assertSame('Renamed', $fresh->name);
        $this->assertSame('Germany', $fresh->country, 'untouched field must be preserved');
        $this->assertSame('en', $fresh->native_language);

        // explicit update still applies
        $this->putJson('/api/v1/customer/profile/update', ['name' => 'Renamed', 'email' => $this->user->email, 'bio' => 'new bio'])->assertStatus(200);
        $this->assertSame('new bio', User::find($this->user->id)->bio);
    }
}
