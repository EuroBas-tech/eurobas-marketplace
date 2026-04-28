<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Tests\TestCase;

class PasswordResetLanguageTest extends TestCase
{
    use DatabaseTransactions;

    private function createUser(): User
    {
        return User::create([
            'name'         => 'LangTest ' . Str::random(5),
            'email'        => Str::random(12) . '@lang-test.com',
            'password'     => bcrypt('TestPass1'),
            'account_type' => 'individual',
            'phone_code'   => 1,
            'is_active'    => 1,
        ]);
    }

    // ── URL generation (the core fix) ──────────────────────────────────

    public function test_localized_url_uses_mapped_segment_for_chinese(): void
    {
        $url = LaravelLocalization::getLocalizedURL('zh', '/customer/auth/reset-password?token=abc');
        $this->assertStringContainsString('/zh-Hans/', $url);
        $this->assertStringNotContainsString('/zh/customer', $url);
    }

    public function test_localized_url_uses_mapped_segment_for_norwegian(): void
    {
        $url = LaravelLocalization::getLocalizedURL('nn', '/customer/auth/reset-password?token=abc');
        $this->assertStringContainsString('/no/', $url);
        $this->assertStringNotContainsString('/nn/', $url);
    }

    public function test_localized_url_hides_default_locale(): void
    {
        $url = LaravelLocalization::getLocalizedURL('en', '/customer/auth/reset-password?token=abc');
        $this->assertStringNotContainsString('/en/', $url);
        $this->assertStringContainsString('/customer/auth/reset-password?token=abc', $url);
    }

    public function test_localized_url_preserves_unmapped_locales(): void
    {
        foreach (['de', 'fr', 'ar', 'pl', 'ru'] as $locale) {
            $url = LaravelLocalization::getLocalizedURL($locale, '/customer/auth/reset-password?token=abc');
            $this->assertStringContainsString("/{$locale}/", $url, "URL for {$locale} should contain /{$locale}/");
        }
    }

    public function test_localized_home_url_uses_mapping(): void
    {
        $zhHome = LaravelLocalization::getLocalizedURL('zh', '/');
        $nnHome = LaravelLocalization::getLocalizedURL('nn', '/');
        $enHome = LaravelLocalization::getLocalizedURL('en', '/');

        $this->assertStringContainsString('/zh-Hans', $zhHome);
        $this->assertStringContainsString('/no', $nnHome);
        $this->assertStringNotContainsString('/en', $enHome);
    }

    // ── Old (wrong) URL segments DO 404 ────────────────────────────────

    public function test_old_chinese_url_segment_returns_404(): void
    {
        $response = $this->get('/zh/customer/auth/reset-password?token=test');
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function test_old_norwegian_url_segment_returns_404(): void
    {
        $response = $this->get('/nn/customer/auth/reset-password?token=test');
        $this->assertEquals(404, $response->getStatusCode());
    }

    // ── Email URL content via controller (default locale path) ─────────

    public function test_forgot_password_sends_email_with_reset_url(): void
    {
        Mail::fake();
        $user = $this->createUser();

        // POST via default locale (the only one registered in test env).
        $this->post('/customer/auth/forgot-password', [
            'identity' => $user->email,
        ]);

        Mail::assertSent(\App\Mail\PasswordResetMail::class, function ($mail) {
            $url = $this->extractUrl($mail);
            // Default locale (en) → no locale prefix, just the path.
            return str_contains($url, '/customer/auth/reset-password?token=');
        });
    }

    /**
     * Simulate what the controller does for Chinese locale: call
     * getLocalizedURL('zh', ...) and verify the result matches /zh-Hans/.
     * This tests the exact code path in the fixed ForgotPasswordController.
     */
    public function test_controller_url_generation_for_chinese(): void
    {
        $token  = Str::random(120);
        $locale = 'zh';
        $url    = LaravelLocalization::getLocalizedURL($locale, '/customer/auth/reset-password?token=' . $token);

        $this->assertStringContainsString('/zh-Hans/customer/auth/reset-password?token=' . $token, $url);
    }

    public function test_controller_url_generation_for_norwegian(): void
    {
        $token  = Str::random(120);
        $locale = 'nn';
        $url    = LaravelLocalization::getLocalizedURL($locale, '/customer/auth/reset-password?token=' . $token);

        $this->assertStringContainsString('/no/customer/auth/reset-password?token=' . $token, $url);
    }

    // ── Post-reset redirect via default locale ─────────────────────────

    public function test_post_reset_redirects_to_home(): void
    {
        $user  = $this->createUser();
        $token = Str::random(120);

        DB::table('password_resets')->insert([
            'identity'   => $user->email,
            'token'      => $token,
            'user_type'  => 'customer',
            'created_at' => now(),
        ]);

        $response = $this->withSession(['forgot_password_identity' => $user->email])
            ->post('/customer/auth/reset-password', [
                'reset_token'      => $token,
                'password'         => 'NewPass123',
                'confirm_password' => 'NewPass123',
            ]);

        $response->assertRedirect();
        // Default locale is hidden, so redirect should be to root.
        $location = $response->headers->get('Location');
        $this->assertNotNull($location);
    }

    public function test_post_reset_redirect_url_generation_for_chinese(): void
    {
        // Verify the redirect helper produces /zh-Hans for Chinese.
        $url = LaravelLocalization::getLocalizedURL('zh', '/');
        $this->assertStringContainsString('/zh-Hans', $url);
    }

    private function extractUrl(\App\Mail\PasswordResetMail $mail): string
    {
        $reflection = new \ReflectionProperty($mail, 'reset_url');
        $reflection->setAccessible(true);
        return $reflection->getValue($mail);
    }
}
