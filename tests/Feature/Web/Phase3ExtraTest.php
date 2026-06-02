<?php

namespace Tests\Feature\Web;

use App\Http\Middleware\VerifyCsrfToken;
use App\Model\Admin;
use App\Model\SellerReview;
use App\Model\UserReport;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Extra Phase 3 coverage: Milestone 1 login redirect cycle, Milestone 3 ad-card
 * rating rendering, and the Milestone 2 admin user-reports pages.
 */
class Phase3ExtraTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    private function makeUser(string $name = null): User
    {
        return User::create([
            'name' => $name ?? ('U ' . Str::random(5)), 'email' => 'x_' . Str::random(8) . '@test.com',
            'password' => bcrypt('TestPass1'), 'account_type' => 'individual',
            'f_name' => 'X', 'l_name' => 'Y', 'phone_code' => '+31', 'phone' => '06',
            'country' => 'Netherlands', 'city' => 'Rotterdam', 'native_language' => 'en',
            'is_active' => 1, 'is_phone_verified' => 1, 'is_email_verified' => 1,
        ]);
    }

    /** @test  Milestone 1: dedicated login page logs in and honours redirect_url. */
    public function dedicated_login_post_authenticates_and_honours_redirect_url()
    {
        $user = $this->makeUser();
        $target = 'http://eurobas.test/ads/adding-type';

        // The page submits via jQuery $.ajax, which sets X-Requested-With so the
        // controller returns JSON. (postJson alone omits that header.)
        $res = $this->withHeaders(['X-Requested-With' => 'XMLHttpRequest', 'Accept' => 'application/json'])
            ->post(route('customer.auth.login'), [
                'user_id'      => $user->email,
                'password'     => 'TestPass1',
                'redirect_url' => $target,
            ]);

        $res->assertStatus(200)
            ->assertJson(['status' => 'success', 'redirect_url' => $target]);
        $this->assertTrue(auth('customer')->check());
    }

    /** @test  reCAPTCHA is disabled on a local .test host, enabled otherwise. */
    public function recaptcha_is_disabled_on_local_test_host()
    {
        // On a .test development host → reCAPTCHA off.
        $this->app->instance('request', \Illuminate\Http\Request::create('http://eurobas.test/customer/auth/login'));
        $this->assertTrue(is_local_test_host());
        $this->assertFalse(recaptcha_enabled());

        // On a real host → follows the business setting (enabled in this environment).
        $this->app->instance('request', \Illuminate\Http\Request::create('https://eurobas.com/customer/auth/login'));
        $this->assertFalse(is_local_test_host());
        $this->assertTrue(recaptcha_enabled());
    }

    /** @test  Milestone 1: the GET login page records a safe redirect target. */
    public function login_page_records_safe_redirect_target()
    {
        // redirect_to is captured into the session for the hidden field.
        $this->get(route('customer.auth.login', ['redirect_to' => 'http://eurobas.test/ads/adding-type']))
            ->assertStatus(200);
        $this->assertEquals('http://eurobas.test/ads/adding-type', session('keep_return_url'));
    }

    /** @test  Milestone 3: the ad-card seller rating partial renders stars + count when reviews exist. */
    public function seller_rating_partial_renders_with_reviews()
    {
        $seller   = $this->makeUser();
        $rater    = $this->makeUser();
        SellerReview::create(['seller_id' => $seller->id, 'customer_id' => $rater->id, 'rating' => 4, 'comment' => 'ok', 'status' => 1]);

        $html = View::make('theme-views.partials._seller-rating-inline', ['seller_id' => $seller->id])->render();

        $this->assertStringContainsString('bi-star-fill', $html); // stars rendered
        $this->assertStringContainsString('(1)', $html);          // review count
        $this->assertStringContainsString('4', $html);            // average
    }

    /** @test  Milestone 3: the partial renders nothing for a seller with no reviews. */
    public function seller_rating_partial_is_empty_without_reviews()
    {
        $seller = $this->makeUser();
        $html = trim(View::make('theme-views.partials._seller-rating-inline', ['seller_id' => $seller->id])->render());
        $this->assertSame('', $html);
    }

    /** @test  Milestone 2: admin user-reports list + detail pages render. */
    public function admin_user_report_pages_render()
    {
        $admin = Admin::find(1);
        if (!$admin) {
            $this->markTestSkipped('No admin account available.');
        }

        $reporter = $this->makeUser('Reporter ' . Str::random(4));
        $reported = $this->makeUser('Reported ' . Str::random(4));
        $report = UserReport::create([
            'reporter_id' => $reporter->id, 'reported_id' => $reported->id,
            'type' => 'chat', 'reason' => 'spam', 'message' => 'ADMINTESTLINE', 'status' => 'pending',
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.user-reports.list'))
            ->assertStatus(200)
            ->assertSee($reporter->name)
            ->assertSee($reported->name);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.user-reports.view', $report->id))
            ->assertStatus(200)
            ->assertSee('ADMINTESTLINE');
    }

    /** @test  Milestone 2: admin can update a report status and delete it. */
    public function admin_can_update_status_and_delete_report()
    {
        $admin = Admin::find(1);
        if (!$admin) {
            $this->markTestSkipped('No admin account available.');
        }

        $report = UserReport::create([
            'reporter_id' => $this->makeUser()->id, 'reported_id' => $this->makeUser()->id,
            'type' => 'chat', 'status' => 'pending',
        ]);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.user-reports.status'), ['id' => $report->id, 'status' => 'reviewed']);
        $this->assertEquals('reviewed', $report->fresh()->status);

        $this->actingAs($admin, 'admin')
            ->delete(route('admin.user-reports.delete'), ['id' => $report->id]);
        $this->assertDatabaseMissing('user_reports', ['id' => $report->id]);
    }
}
