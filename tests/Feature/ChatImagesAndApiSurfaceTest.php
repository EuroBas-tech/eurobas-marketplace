<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Model\Chatting;
use App\Model\UserBlock;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Final hardening: the "Send Images" deliverable (real uploads, web + API),
 * block enforcement on the web send path, and the remaining API surface
 * (blocked-list, delete-conversation, response shape, self-action guards).
 */
class ChatImagesAndApiSurfaceTest extends TestCase
{
    use DatabaseTransactions;

    private User $me;
    private User $other;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->me    = $this->makeUser();
        $this->other = $this->makeUser();
    }

    private function makeUser(): User
    {
        return User::create([
            'name' => 'C ' . Str::random(5), 'email' => 'c_' . Str::random(8) . '@test.com',
            'password' => bcrypt('TestPass1'), 'account_type' => 'individual',
            'f_name' => 'C', 'l_name' => 'U', 'phone_code' => '+31', 'phone' => '06',
            'country' => 'Netherlands', 'city' => 'Rotterdam', 'native_language' => 'en', 'is_active' => 1,
        ]);
    }

    /** @test  M2 Send Images — API: image attachment is stored + returned. */
    public function api_send_message_with_image_stores_attachment()
    {
        Passport::actingAs($this->me);

        $res = $this->post('/api/v1/customer/chat/send-message', [
            'id'      => $this->other->id,
            'message' => 'see attached',
            'image'   => [UploadedFile::fake()->image('photo.jpg')],
        ], ['Accept' => 'application/json']);

        $res->assertStatus(200);
        $this->assertCount(1, $res->json('data.attachment_images'));

        $row = Chatting::where('sender_id', $this->me->id)->where('receiver_id', $this->other->id)->latest()->first();
        $decoded = json_decode($row->attachment, true);
        $this->assertIsArray($decoded);
        $this->assertCount(1, $decoded);
    }

    /** @test  M2 Send Images — Web: discussion_store accepts an image and returns it. */
    public function web_discussion_store_with_image_stores_attachment()
    {
        $res = $this->actingAs($this->me, 'customer')->post(route('discussion_store'), [
            'chat_with' => $this->other->id,
            'message'   => 'web image',
            'image'     => [UploadedFile::fake()->image('w.jpg')],
        ]);

        $res->assertStatus(200);
        $this->assertCount(1, (array) $res->json('image'));

        $row = Chatting::where('sender_id', $this->me->id)->where('receiver_id', $this->other->id)->latest()->first();
        $this->assertCount(1, json_decode($row->attachment, true));
    }

    /** @test  M2 — Web send path is blocked between blocked users. */
    public function web_discussion_store_rejected_when_blocked()
    {
        UserBlock::create(['blocker_id' => $this->other->id, 'blocked_id' => $this->me->id]); // other blocked me

        $this->actingAs($this->me, 'customer')->post(route('discussion_store'), [
            'chat_with' => $this->other->id, 'message' => 'should fail',
        ])->assertStatus(403);

        $this->assertDatabaseMissing('chattings', ['sender_id' => $this->me->id, 'receiver_id' => $this->other->id, 'message' => 'should fail']);
    }

    /** @test  M2 — API get-messages returns status + ownership + block fields. */
    public function api_get_messages_response_shape()
    {
        Chatting::create(['sender_id' => $this->me->id, 'receiver_id' => $this->other->id, 'message' => 'hi', 'seen' => 0, 'created_at' => now()]);

        Passport::actingAs($this->me);
        $this->getJson('/api/v1/customer/chat/get-messages/' . $this->other->id)
            ->assertStatus(200)
            ->assertJsonStructure(['data' => [['id', 'message', 'is_mine', 'message_status', 'attachment_images']], 'is_blocked']);
    }

    /** @test  M2 — API blocked-list returns blocked users. */
    public function api_blocked_list_returns_blocked_users()
    {
        Passport::actingAs($this->me);
        $this->post('/api/v1/customer/chat/block', ['blocked_id' => $this->other->id], ['Accept' => 'application/json'])->assertStatus(200);

        $res = $this->getJson('/api/v1/customer/chat/blocked-list')->assertStatus(200);
        $this->assertEquals(1, $res->json('total_size'));
        $this->assertEquals($this->other->id, $res->json('blocked_users.0.id'));
    }

    /** @test  M2 — API delete-conversation hides the thread from the owner. */
    public function api_delete_conversation_hides_thread()
    {
        Chatting::create(['sender_id' => $this->me->id, 'receiver_id' => $this->other->id, 'message' => 'one', 'seen' => 0, 'created_at' => now()]);
        Chatting::create(['sender_id' => $this->other->id, 'receiver_id' => $this->me->id, 'message' => 'two', 'seen' => 0, 'created_at' => now()]);

        Passport::actingAs($this->me);
        $this->post('/api/v1/customer/chat/delete-conversation', ['user_id' => $this->other->id], ['Accept' => 'application/json'])->assertStatus(200);

        // Nothing visible to me anymore…
        $this->assertEquals(0, Chatting::visibleTo($this->me->id)
            ->where(fn($q) => $q->where('sender_id', $this->other->id)->orWhere('receiver_id', $this->other->id))->count());
        // …but the other party still sees both messages.
        $this->assertEquals(2, Chatting::visibleTo($this->other->id)
            ->where(fn($q) => $q->where('sender_id', $this->me->id)->orWhere('receiver_id', $this->me->id))->count());
    }

    /** @test  M2 — API guards self-block and self-report. */
    public function api_guards_self_block_and_self_report()
    {
        Passport::actingAs($this->me);
        $this->post('/api/v1/customer/chat/block', ['blocked_id' => $this->me->id], ['Accept' => 'application/json'])->assertStatus(422);
        $this->post('/api/v1/customer/chat/report', ['reported_id' => $this->me->id], ['Accept' => 'application/json'])->assertStatus(422);
    }
}
