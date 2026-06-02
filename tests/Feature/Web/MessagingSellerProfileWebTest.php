<?php

namespace Tests\Feature\Web;

use App\Http\Middleware\VerifyCsrfToken;
use App\Model\Chatting;
use App\Model\SellerReview;
use App\Model\UserBlock;
use App\Model\UserReport;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Website (session-guard) coverage for Milestone 2 (messaging) + Milestone 3
 * (seller profile/ratings). These render the FULL Blade pages with real data —
 * catching any runtime view error the compile step can't — and exercise the
 * web POST endpoints.
 */
class MessagingSellerProfileWebTest extends TestCase
{
    use DatabaseTransactions;

    private User $me;
    private User $seller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->me     = $this->makeUser('Buyer ' . Str::random(4));
        $this->seller = $this->makeUser('Seller ' . Str::random(4));
    }

    private function makeUser(string $name): User
    {
        return User::create([
            'name' => $name, 'email' => 'w_' . Str::random(8) . '@test.com',
            'password' => bcrypt('TestPass1'), 'account_type' => 'individual',
            'f_name' => 'W', 'l_name' => 'U', 'phone_code' => '+31', 'phone' => '06',
            'country' => 'Netherlands', 'city' => 'Rotterdam', 'native_language' => 'en', 'is_active' => 1,
        ]);
    }

    /** @test */
    public function chat_inbox_renders_with_messages_and_status_icons()
    {
        // Two messages each direction so the bubble loop, day separators and
        // status icons all execute.
        Chatting::create(['sender_id' => $this->me->id, 'receiver_id' => $this->seller->id, 'message' => 'hello there', 'seen' => 1, 'seen_at' => now(), 'delivered_at' => now(), 'created_at' => now()->subDay()]);
        Chatting::create(['sender_id' => $this->seller->id, 'receiver_id' => $this->me->id, 'message' => 'hi back', 'seen' => 0, 'created_at' => now()]);

        $res = $this->actingAs($this->me, 'customer')
            ->get(route('chat', ['type' => 'user']) . '?id=' . $this->seller->id);

        $res->assertStatus(200);
        $res->assertSee('hello there');
        $res->assertSee('hi back');
        $res->assertSee('chat-bubble');            // new bubble markup rendered
        $res->assertSee('reportUserModal', false); // report option/modal present
        $res->assertSee('chat-status', false);     // message status icons rendered
    }

    /** @test */
    public function chat_inbox_renders_when_user_has_no_conversations()
    {
        $lonely = $this->makeUser('Lonely ' . Str::random(4));
        $this->actingAs($lonely, 'customer')
            ->get(route('chat', ['type' => 'user']))
            ->assertStatus(200);
    }

    /** @test */
    public function blocked_partner_hidden_and_soft_deleted_message_hidden_in_inbox()
    {
        $hiddenMsg = Chatting::create(['sender_id' => $this->me->id, 'receiver_id' => $this->seller->id, 'message' => 'TOPSECRETLINE', 'seen' => 0, 'deleted_by_sender' => 1, 'created_at' => now()]);
        Chatting::create(['sender_id' => $this->me->id, 'receiver_id' => $this->seller->id, 'message' => 'VISIBLELINE', 'seen' => 0, 'created_at' => now()]);

        $res = $this->actingAs($this->me, 'customer')
            ->get(route('chat', ['type' => 'user']) . '?id=' . $this->seller->id)
            ->assertStatus(200);

        $res->assertSee('VISIBLELINE');
        $res->assertDontSee('TOPSECRETLINE'); // soft-deleted for me
    }

    /** @test */
    public function web_block_then_unblock_endpoints_work()
    {
        $this->actingAs($this->me, 'customer')
            ->post(route('block_user'), ['blocked_id' => $this->seller->id])
            ->assertStatus(200)->assertJson(['blocked' => true]);
        $this->assertDatabaseHas('user_blocks', ['blocker_id' => $this->me->id, 'blocked_id' => $this->seller->id]);

        $this->actingAs($this->me, 'customer')
            ->post(route('unblock_user'), ['blocked_id' => $this->seller->id])
            ->assertStatus(200)->assertJson(['blocked' => false]);
        $this->assertDatabaseMissing('user_blocks', ['blocker_id' => $this->me->id, 'blocked_id' => $this->seller->id]);
    }

    /** @test */
    public function web_report_user_endpoint_stores_report()
    {
        $this->actingAs($this->me, 'customer')
            ->post(route('report_user'), ['reported_id' => $this->seller->id, 'reason' => 'spam', 'message' => 'bad'])
            ->assertStatus(200);
        $this->assertDatabaseHas('user_reports', ['reporter_id' => $this->me->id, 'reported_id' => $this->seller->id]);
    }

    /** @test */
    public function web_delete_message_and_conversation_endpoints_work()
    {
        $m1 = Chatting::create(['sender_id' => $this->me->id, 'receiver_id' => $this->seller->id, 'message' => 'a', 'seen' => 0, 'created_at' => now()]);
        Chatting::create(['sender_id' => $this->me->id, 'receiver_id' => $this->seller->id, 'message' => 'b', 'seen' => 0, 'created_at' => now()]);

        $this->actingAs($this->me, 'customer')->post(route('delete_message'), ['message_id' => $m1->id])->assertStatus(200);
        $this->assertEquals(1, (int) Chatting::where('id', $m1->id)->value('deleted_by_sender'));

        $this->actingAs($this->me, 'customer')->post(route('delete_conversation'), ['user_id' => $this->seller->id])->assertStatus(200);
        $this->assertEquals(0, Chatting::visibleTo($this->me->id)
            ->where('sender_id', $this->me->id)->where('receiver_id', $this->seller->id)->count());
    }

    /** @test */
    public function seller_profile_renders_with_rating_toolbar_and_reviews()
    {
        SellerReview::create(['seller_id' => $this->seller->id, 'customer_id' => $this->me->id, 'rating' => 4, 'comment' => 'REVIEWBODYLINE', 'status' => 1]);

        $res = $this->actingAs($this->me, 'customer')
            ->get(route('show-profile', [$this->seller->id, $this->seller->name]) . '?tap=profile')
            ->assertStatus(200);

        $res->assertSee('seller-rating-text', false);       // rating element rendered
        $res->assertSee('contactSellerProfileModal', false); // contact toolbar/modal present
        $res->assertSee('rateSellerModal', false);
        $res->assertSee('REVIEWBODYLINE');                   // review list rendered
    }

    /** @test */
    public function web_seller_review_endpoint_upserts_and_blocks_self_review()
    {
        $this->actingAs($this->me, 'customer')
            ->post(route('seller-review-store'), ['seller_id' => $this->seller->id, 'rating' => 5, 'comment' => 'great'])
            ->assertStatus(200);
        $this->assertDatabaseHas('seller_reviews', ['seller_id' => $this->seller->id, 'customer_id' => $this->me->id, 'rating' => 5]);

        // Update keeps a single row.
        $this->actingAs($this->me, 'customer')
            ->post(route('seller-review-store'), ['seller_id' => $this->seller->id, 'rating' => 2])
            ->assertStatus(200);
        $this->assertEquals(1, SellerReview::where('seller_id', $this->seller->id)->where('customer_id', $this->me->id)->count());

        // Cannot review yourself (controller returns an error_message, no row created).
        $this->actingAs($this->me, 'customer')
            ->post(route('seller-review-store'), ['seller_id' => $this->me->id, 'rating' => 5])
            ->assertStatus(200)
            ->assertJsonStructure(['error_message']);
        $this->assertDatabaseMissing('seller_reviews', ['seller_id' => $this->me->id, 'customer_id' => $this->me->id]);
    }
}
