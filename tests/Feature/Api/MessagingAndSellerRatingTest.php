<?php

namespace Tests\Feature\Api;

use App\Model\Chatting;
use App\Model\SellerReview;
use App\Model\UserBlock;
use App\Model\UserReport;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Milestone 2 (Messaging Enhancements) + Milestone 3 (Seller Ratings).
 * Exercises the new API surface against the real schema.
 */
class MessagingAndSellerRatingTest extends TestCase
{
    use DatabaseTransactions;

    private User $me;
    private User $other;

    protected function setUp(): void
    {
        parent::setUp();
        $this->me    = $this->makeUser();
        $this->other = $this->makeUser();
        Passport::actingAs($this->me);
    }

    private function makeUser(): User
    {
        return User::create([
            'name' => 'T ' . Str::random(5), 'email' => 't_' . Str::random(8) . '@test.com',
            'password' => bcrypt('TestPass1'), 'account_type' => 'individual',
            'f_name' => 'T', 'l_name' => 'U', 'phone_code' => '+31', 'phone' => '06',
            'country' => 'Netherlands', 'city' => 'Rotterdam', 'native_language' => 'en', 'is_active' => 1,
        ]);
    }

    /** @test */
    public function block_prevents_sending_a_message()
    {
        $this->postJson('/api/v1/customer/chat/block', ['blocked_id' => $this->other->id])
            ->assertStatus(200)->assertJson(['blocked' => true]);

        $this->assertTrue(UserBlock::blockedBetween($this->me->id, $this->other->id));

        // Sending to a blocked user is rejected.
        $this->postJson('/api/v1/customer/chat/send-message', ['id' => $this->other->id, 'message' => 'hi'])
            ->assertStatus(403);

        // Unblock restores messaging.
        $this->postJson('/api/v1/customer/chat/unblock', ['blocked_id' => $this->other->id])
            ->assertStatus(200)->assertJson(['blocked' => false]);

        $this->postJson('/api/v1/customer/chat/send-message', ['id' => $this->other->id, 'message' => 'hi again'])
            ->assertStatus(200);
    }

    /** @test */
    public function blocked_user_is_hidden_from_chat_list()
    {
        Chatting::create(['sender_id' => $this->me->id, 'receiver_id' => $this->other->id, 'message' => 'x', 'seen' => 0, 'created_at' => now()]);
        UserBlock::create(['blocker_id' => $this->me->id, 'blocked_id' => $this->other->id]);

        $res = $this->getJson('/api/v1/customer/chat/list')->assertStatus(200)->json();
        $partners = collect($res['chat'])->pluck('partner_id')->all();
        $this->assertNotContains($this->other->id, $partners);
    }

    /** @test */
    public function report_user_is_stored()
    {
        $this->postJson('/api/v1/customer/chat/report', [
            'reported_id' => $this->other->id, 'reason' => 'spam', 'message' => 'bad',
        ])->assertStatus(200);

        $this->assertDatabaseHas('user_reports', [
            'reporter_id' => $this->me->id, 'reported_id' => $this->other->id, 'status' => 'pending',
        ]);
    }

    /** @test */
    public function delete_message_hides_it_for_me_only()
    {
        $msg = Chatting::create(['sender_id' => $this->me->id, 'receiver_id' => $this->other->id, 'message' => 'secret', 'seen' => 0, 'created_at' => now()]);

        $this->postJson('/api/v1/customer/chat/delete-message', ['message_id' => $msg->id])->assertStatus(200);

        // Hidden for me…
        $this->assertEquals(0, Chatting::visibleTo($this->me->id)->where('id', $msg->id)->count());
        // …still visible for the other party.
        $this->assertEquals(1, Chatting::visibleTo($this->other->id)->where('id', $msg->id)->count());
    }

    /** @test */
    public function message_status_progresses_sent_delivered_seen()
    {
        // I send a message to other.
        $this->postJson('/api/v1/customer/chat/send-message', ['id' => $this->other->id, 'message' => 'status check'])->assertStatus(200);
        $msg = Chatting::where('sender_id', $this->me->id)->where('receiver_id', $this->other->id)->latest()->first();
        $this->assertNull($msg->delivered_at, 'sent only');

        // Other loads their list → delivered.
        Passport::actingAs($this->other);
        $this->getJson('/api/v1/customer/chat/list')->assertStatus(200);
        $this->assertNotNull($msg->fresh()->delivered_at, 'delivered after list load');

        // Other opens the conversation → seen.
        $this->getJson('/api/v1/customer/chat/get-messages/' . $this->me->id)->assertStatus(200);
        $this->assertNotNull($msg->fresh()->seen_at, 'seen after open');
    }

    /** @test */
    public function seller_review_creates_and_summarises()
    {
        $this->postJson('/api/v1/customer/seller-review', [
            'seller_id' => $this->other->id, 'rating' => 5, 'comment' => 'great',
        ])->assertStatus(200);

        $summary = SellerReview::summaryFor($this->other->id);
        $this->assertEquals(5.0, $summary['avg']);
        $this->assertEquals(1, $summary['count']);

        // Public reviews endpoint returns it.
        $this->getJson('/api/v1/users/' . $this->other->id . '/reviews')
            ->assertStatus(200)->assertJsonPath('summary.count', 1);
    }

    /** @test */
    public function seller_review_is_unique_per_customer_and_upserts()
    {
        $this->postJson('/api/v1/customer/seller-review', ['seller_id' => $this->other->id, 'rating' => 3])->assertStatus(200);
        $this->postJson('/api/v1/customer/seller-review', ['seller_id' => $this->other->id, 'rating' => 4])->assertStatus(200);

        $this->assertEquals(1, SellerReview::where('seller_id', $this->other->id)->where('customer_id', $this->me->id)->count());
    }

    /** @test */
    public function cannot_review_yourself()
    {
        $this->postJson('/api/v1/customer/seller-review', ['seller_id' => $this->me->id, 'rating' => 5])
            ->assertStatus(422);
    }
}
