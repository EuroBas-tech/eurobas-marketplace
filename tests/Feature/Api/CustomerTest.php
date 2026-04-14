<?php

namespace Tests\Feature\Api;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use DatabaseTransactions;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::create([
            'name' => 'Test Customer ' . Str::random(5),
            'email' => 'customer_' . Str::random(8) . '@test.com',
            'password' => bcrypt('TestPass1'),
            'account_type' => 'individual',
            'phone_code' => 1,
            'is_active' => 1,
        ]);
        Passport::actingAs($this->user);
    }

    public function test_get_customer_info()
    {
        $response = $this->getJson('/api/v1/customer/info');

        $response->assertStatus(200)
            ->assertJsonStructure(['customer', 'wishlists']);
    }

    public function test_get_customer_profile()
    {
        $response = $this->getJson('/api/v1/customer/profile');

        $response->assertStatus(200)
            ->assertJsonFragment(['email' => $this->user->email]);
    }

    public function test_update_profile()
    {
        $response = $this->putJson('/api/v1/customer/profile/update', [
            'name' => 'Updated Name',
            'email' => $this->user->email,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['id' => $this->user->id, 'name' => 'Updated Name']);
    }

    public function test_update_profile_validates_email()
    {
        $response = $this->putJson('/api/v1/customer/profile/update', [
            'name' => 'Test',
            'email' => 'not-an-email',
        ]);

        $response->assertStatus(422);
    }

    public function test_get_customer_ads()
    {
        $response = $this->getJson('/api/v1/customer/profile/ads');
        $response->assertStatus(200);
    }

    public function test_get_customer_paid_banners()
    {
        $response = $this->getJson('/api/v1/customer/profile/paid-banners');
        $response->assertStatus(200);
    }

    public function test_create_support_ticket()
    {
        $response = $this->postJson('/api/v1/customer/support-ticket/create', [
            'subject' => 'Test ticket',
            'type' => 'general',
            'description' => 'Test description',
            'priority' => 'low',
        ]);

        $response->assertStatus(200);
    }

    public function test_create_support_ticket_validates()
    {
        $response = $this->postJson('/api/v1/customer/support-ticket/create', []);
        $response->assertStatus(422);
    }

    public function test_get_support_tickets()
    {
        $response = $this->getJson('/api/v1/customer/support-ticket/get');
        $response->assertStatus(200);
    }

    public function test_support_ticket_idor_protection()
    {
        $response = $this->getJson('/api/v1/customer/support-ticket/conv/99999');
        $response->assertStatus(404);
    }

    public function test_support_ticket_reply_idor_protection()
    {
        $response = $this->postJson('/api/v1/customer/support-ticket/reply/99999', [
            'message' => 'test',
        ]);

        $response->assertStatus(404);
    }

    public function test_wishlist_add()
    {
        $response = $this->postJson('/api/v1/customer/wish-list/add', [
            'ad_id' => 1,
        ]);

        $response->assertStatus(200);
    }

    public function test_wishlist_add_validates()
    {
        $response = $this->postJson('/api/v1/customer/wish-list/add', []);
        $response->assertStatus(422);
    }

    public function test_wishlist_get()
    {
        $response = $this->getJson('/api/v1/customer/wish-list');
        $response->assertStatus(200);
    }

    public function test_wishlist_remove()
    {
        $response = $this->deleteJson('/api/v1/customer/wish-list/remove', [
            'ad_id' => 1,
        ]);

        // 404 because nothing to remove - but the endpoint works
        $response->assertStatus(404);
    }

    public function test_chat_list()
    {
        $response = $this->getJson('/api/v1/customer/chat/list');
        $response->assertStatus(200);
    }

    public function test_notifications()
    {
        $response = $this->getJson('/api/v1/notifications');
        $response->assertStatus(200);
    }

    public function test_update_firebase_token()
    {
        $response = $this->putJson('/api/v1/customer/cm-firebase-token', [
            'cm_firebase_token' => 'test_token_123',
        ]);

        $response->assertStatus(200);
    }

    public function test_account_delete()
    {
        $response = $this->getJson('/api/v1/customer/account-delete');
        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
    }
}
