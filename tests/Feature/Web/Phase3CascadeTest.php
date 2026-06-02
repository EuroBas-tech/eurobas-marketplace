<?php

namespace Tests\Feature\Web;

use App\Model\SellerReview;
use App\Model\UserBlock;
use App\Model\UserReport;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Data integrity: deleting a user must remove every Phase-2/3 row that references
 * them (as owner OR as the other party) — and must NOT touch unrelated rows.
 */
class Phase3CascadeTest extends TestCase
{
    use DatabaseTransactions;

    private function user(): User
    {
        return User::create([
            'name' => 'C ' . Str::random(5), 'email' => 'cas_' . Str::random(8) . '@test.com',
            'password' => bcrypt('TestPass1'), 'account_type' => 'individual',
            'phone_code' => '+1', 'is_active' => 1,
        ]);
    }

    /** @test */
    public function deleting_a_user_cleans_up_blocks_reports_and_reviews_both_directions()
    {
        $a = $this->user();
        $b = $this->user();
        $c = $this->user();

        // Rows involving A (both directions) — must all be deleted with A.
        UserBlock::create(['blocker_id' => $a->id, 'blocked_id' => $b->id]);
        UserBlock::create(['blocker_id' => $b->id, 'blocked_id' => $a->id]);
        UserReport::create(['reporter_id' => $a->id, 'reported_id' => $b->id, 'type' => 'chat', 'status' => 'pending']);
        UserReport::create(['reporter_id' => $b->id, 'reported_id' => $a->id, 'type' => 'chat', 'status' => 'pending']);
        SellerReview::create(['seller_id' => $a->id, 'customer_id' => $b->id, 'rating' => 5, 'status' => 1]);
        SellerReview::create(['seller_id' => $b->id, 'customer_id' => $a->id, 'rating' => 4, 'status' => 1]);

        // Rows NOT involving A (B↔C) — must survive.
        UserBlock::create(['blocker_id' => $b->id, 'blocked_id' => $c->id]);
        UserReport::create(['reporter_id' => $b->id, 'reported_id' => $c->id, 'type' => 'chat', 'status' => 'pending']);
        SellerReview::create(['seller_id' => $c->id, 'customer_id' => $b->id, 'rating' => 3, 'status' => 1]);

        $a->delete();

        // Everything touching A is gone…
        $this->assertEquals(0, UserBlock::where('blocker_id', $a->id)->orWhere('blocked_id', $a->id)->count());
        $this->assertEquals(0, UserReport::where('reporter_id', $a->id)->orWhere('reported_id', $a->id)->count());
        $this->assertEquals(0, SellerReview::where('seller_id', $a->id)->orWhere('customer_id', $a->id)->count());

        // …and the unrelated B↔C rows are untouched.
        $this->assertDatabaseHas('user_blocks', ['blocker_id' => $b->id, 'blocked_id' => $c->id]);
        $this->assertDatabaseHas('user_reports', ['reporter_id' => $b->id, 'reported_id' => $c->id]);
        $this->assertDatabaseHas('seller_reviews', ['seller_id' => $c->id, 'customer_id' => $b->id]);
    }
}
