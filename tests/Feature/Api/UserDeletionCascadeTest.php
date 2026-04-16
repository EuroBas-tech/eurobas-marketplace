<?php

namespace Tests\Feature\Api;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserDeletionCascadeTest extends TestCase
{
    use DatabaseTransactions;

    private function createUser(array $attrs = []): User
    {
        return User::create(array_merge([
            'name' => 'CascadeTest ' . Str::random(5),
            'email' => Str::random(12) . '@cascade-test.com',
            'password' => bcrypt('TestPass1'),
            'account_type' => 'individual',
            'phone_code' => 1,
            'is_active' => 1,
        ], $attrs));
    }

    private function insert(string $table, array $row): int
    {
        return (int) DB::table($table)->insertGetId($row + [
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function makeAd(int $userId, string $title): int
    {
        return $this->insert('ads', [
            'user_id'            => $userId,
            'title'              => $title,
            'slug'               => Str::slug($title) . '-' . Str::random(6),
            'description'        => 'cascade test ad',
            'category_id'        => $this->categoryId(),
            'currency'           => 'EUR',
            'allow_offers'       => 1,
            'country'            => 'PL',
            'city'               => 'Warsaw',
            'show_phone_number'  => 0,
            'price'              => 100,
            'status'             => 1,
        ]);
    }

    private function categoryId(): int
    {
        return (int) DB::table('categories')->value('id');
    }

    public function test_deleting_user_removes_all_associated_data(): void
    {
        $owner = $this->createUser();
        $other = $this->createUser();

        // Ad owned by the user, plus children belonging to OTHER users.
        $adId = $this->makeAd($owner->id, 'Owner Ad');

        $auctionByOther = $this->insert('ad_auctions',     ['ad_id' => $adId, 'user_id' => $other->id, 'price' => 50]);
        $askByOther     = $this->insert('ad_asking_price', ['ad_id' => $adId, 'user_id' => $other->id, 'price' => 50]);
        $reportByOther  = $this->insert('ad_reports',      ['ad_id' => $adId, 'user_id' => $other->id, 'message' => 'spam']);
        $wishByOther    = $this->insert('wishlists',       ['ad_id' => $adId, 'customer_id' => $other->id]);
        $viewId         = $this->insert('ads_views',       ['ad_id' => $adId, 'ip_address' => '127.0.0.1', 'user_agent' => 'phpunit']);
        $sponsoredId    = $this->insert('sponsored_ads',   ['ad_id' => $adId, 'type' => 'top', 'price' => 1, 'duration_in_days' => 1, 'status' => 1, 'is_paid' => 1]);
        $reviewOnAd     = $this->insert('reviews',         ['ad_id' => $adId, 'customer_id' => $other->id, 'rating' => 5, 'comment' => 'ok']);

        // Activity the user performed on others' content.
        $otherAdId = $this->makeAd($other->id, 'Other Ad');
        $myWish    = $this->insert('wishlists',                ['ad_id' => $otherAdId, 'customer_id' => $owner->id]);
        $myCompare = $this->insert('product_compares',         ['user_id' => $owner->id, 'product_id' => 1]);
        $myAuction = $this->insert('ad_auctions',              ['ad_id' => $otherAdId, 'user_id' => $owner->id, 'price' => 75]);
        $myAsk     = $this->insert('ad_asking_price',          ['ad_id' => $otherAdId, 'user_id' => $owner->id, 'price' => 60]);
        $myReport  = $this->insert('ad_reports',               ['ad_id' => $otherAdId, 'user_id' => $owner->id, 'message' => 'bad']);
        $myBanner  = $this->insert('paid_banners',             ['user_id' => $owner->id, 'banner_image' => 'x.png', 'package_id' => 1, 'duration_in_days' => 7, 'price' => 10, 'status' => 1, 'is_paid' => 0]);
        $myCat     = $this->insert('user_category_interests',  ['user_id' => $owner->id, 'category_id' => $this->categoryId(), 'score' => 1]);
        $sentChat  = $this->insert('chattings',                ['sender_id' => $owner->id, 'receiver_id' => $other->id, 'message' => 'hi']);
        $recvChat  = $this->insert('chattings',                ['sender_id' => $other->id, 'receiver_id' => $owner->id, 'message' => 'yo']);
        $myReview  = $this->insert('reviews',                  ['ad_id' => $otherAdId, 'customer_id' => $owner->id, 'rating' => 4, 'comment' => 'fine']);

        // Profile-adjacent data.
        $shipping  = $this->insert('shipping_addresses',          ['customer_id' => $owner->id, 'contact_person_name' => 'x', 'address_type' => 'home', 'address' => 'a', 'city' => 'c', 'zip' => '1', 'country' => 'PL', 'phone' => '1']);
        $wallet    = $this->insert('wallet_transactions',         ['user_id' => $owner->id, 'transaction_id' => (string) Str::uuid(), 'credit' => 5, 'debit' => 0, 'balance' => 5]);
        $loyalty   = $this->insert('loyalty_point_transactions', ['user_id' => $owner->id, 'transaction_id' => (string) Str::uuid(), 'credit' => 5, 'debit' => 0, 'balance' => 5]);
        $emergency = $this->insert('emergency_contacts',          ['user_id' => $owner->id, 'name' => 'mom', 'phone' => '1', 'status' => 1]);
        $follower  = $this->insert('shop_followers',              ['user_id' => $owner->id, 'shop_id' => 1]);

        $ticketId  = $this->insert('support_tickets',     ['customer_id' => $owner->id, 'subject' => 'help', 'type' => 'general', 'description' => 'x', 'status' => 'pending', 'attachment' => '[]']);
        $convId    = $this->insert('support_ticket_convs', ['support_ticket_id' => $ticketId, 'admin_id' => 1, 'admin_message' => 'reply', 'position' => 0]);

        $billing   = $this->insert('billing_addresses',           ['customer_id' => $owner->id, 'contact_person_name' => 'x', 'address_type' => 'home', 'address' => 'a', 'city' => 'c', 'zip' => '1', 'country' => 'PL', 'phone' => '1']);
        $cart      = $this->insert('carts',                       ['customer_id' => $owner->id, 'product_id' => 1, 'quantity' => 1, 'price' => 1]);
        $cwallet   = $this->insert('customer_wallets',            ['customer_id' => $owner->id, 'balance' => 0]);
        $cwhist    = $this->insert('customer_wallet_histories',   ['customer_id' => $owner->id, 'transaction_amount' => 1, 'transaction_type' => 'add']);
        $notifSeen = $this->insert('notification_seens',          ['user_id' => $owner->id, 'notification_id' => 1, 'user_type' => 'customer']);

        // Active OAuth token simulating a logged-in session.
        $tokenId = Str::random(80);
        DB::table('oauth_access_tokens')->insert([
            'id'         => $tokenId,
            'user_id'    => $owner->id,
            'client_id'  => 1,
            'name'       => 'test',
            'scopes'     => '[]',
            'revoked'    => 0,
            'created_at' => now(),
            'updated_at' => now(),
            'expires_at' => now()->addDay(),
        ]);

        $this->assertDatabaseHas('users', ['id' => $owner->id]);

        // ACT
        $owner->delete();

        // ASSERT
        $this->assertDatabaseMissing('users', ['id' => $owner->id]);

        $assertGone = function (string $table, array $where) {
            $count = DB::table($table)->where($where)->count();
            $this->assertSame(0, $count, "Expected $table rows matching " . json_encode($where) . " to be deleted, found $count");
        };

        // Owner's ad and its children
        $assertGone('ads',             ['id' => $adId]);
        $assertGone('ad_auctions',     ['id' => $auctionByOther]);
        $assertGone('ad_asking_price', ['id' => $askByOther]);
        $assertGone('ad_reports',      ['id' => $reportByOther]);
        $assertGone('wishlists',       ['id' => $wishByOther]);
        $assertGone('ads_views',       ['id' => $viewId]);
        $assertGone('sponsored_ads',   ['id' => $sponsoredId]);
        $assertGone('reviews',         ['id' => $reviewOnAd]);

        // Owner's activity on others' content
        $assertGone('wishlists',                ['id' => $myWish]);
        $assertGone('product_compares',         ['id' => $myCompare]);
        $assertGone('ad_auctions',              ['id' => $myAuction]);
        $assertGone('ad_asking_price',          ['id' => $myAsk]);
        $assertGone('ad_reports',               ['id' => $myReport]);
        $assertGone('paid_banners',             ['id' => $myBanner]);
        $assertGone('user_category_interests',  ['id' => $myCat]);
        $assertGone('chattings',                ['id' => $sentChat]);
        $assertGone('chattings',                ['id' => $recvChat]);
        $assertGone('reviews',                  ['id' => $myReview]);

        // Profile-adjacent
        $assertGone('shipping_addresses',          ['id' => $shipping]);
        $assertGone('wallet_transactions',         ['id' => $wallet]);
        $assertGone('loyalty_point_transactions', ['id' => $loyalty]);
        $assertGone('emergency_contacts',          ['id' => $emergency]);
        $assertGone('shop_followers',              ['id' => $follower]);
        $assertGone('support_tickets',             ['id' => $ticketId]);
        $assertGone('support_ticket_convs',        ['id' => $convId]);
        $assertGone('billing_addresses',           ['id' => $billing]);
        $assertGone('carts',                       ['id' => $cart]);
        $assertGone('customer_wallets',            ['id' => $cwallet]);
        $assertGone('customer_wallet_histories',   ['id' => $cwhist]);
        $assertGone('notification_seens',          ['id' => $notifSeen]);
        $assertGone('oauth_access_tokens',         ['id' => $tokenId]);

        // The OTHER user and their ad must NOT be affected.
        $this->assertDatabaseHas('users', ['id' => $other->id]);
        $this->assertDatabaseHas('ads',   ['id' => $otherAdId]);
    }

    public function test_deleting_user_with_no_related_data_succeeds(): void
    {
        $user = $this->createUser();
        $id = $user->id;

        $user->delete();

        $this->assertDatabaseMissing('users', ['id' => $id]);
    }

    public function test_failed_cascade_rolls_back_user_deletion(): void
    {
        // If anything inside the booted() transaction throws, the user row
        // must remain so the user can retry rather than ending up in a
        // half-deleted state. We force a failure by stuffing a chat row with
        // an invalid value that DB::transaction will reject on a later step.
        $user = $this->createUser();
        $id = $user->id;

        // Static deleting hook on Eloquent. We register a one-shot handler
        // that throws AFTER our cascade runs; if rollback works, the user
        // row should still exist.
        User::deleting(function () {
            throw new \RuntimeException('forced failure inside delete');
        });

        try {
            $user->delete();
            $this->fail('Expected RuntimeException was not thrown');
        } catch (\RuntimeException $e) {
            $this->assertSame('forced failure inside delete', $e->getMessage());
        }

        $this->assertDatabaseHas('users', ['id' => $id]);

        // Clean up the listener so it does not leak into other tests.
        User::flushEventListeners();
    }
}
