<?php

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Verifies the .test reCAPTCHA bypass renders correctly on BOTH a local .test host
 * (captcha hidden) and a real host (captcha shown) — catching any Blade directive
 * imbalance from the @if/@elseif/@else gating, and confirming production is unchanged.
 *
 * (Assumes reCAPTCHA is enabled in business settings for this environment, which it is.)
 */
class RecaptchaHostGatingTest extends TestCase
{
    use DatabaseTransactions;

    /** Pages reached by a simple GET (no auth) that carry reCAPTCHA. */
    private array $publicPages = [
        '/customer/auth/login',
        '/customer/auth/sign-up?type=individual',
        '/customer/auth/sign-up?type=company',
        '/contacts',
    ];

    private function getOnHost(string $host, string $path)
    {
        return $this->withServerVariables([
            'HTTP_HOST'   => $host,
            'SERVER_NAME' => $host,
        ])->get('http://' . $host . $path);
    }

    /** @test */
    public function recaptcha_is_hidden_on_local_test_host()
    {
        foreach ($this->publicPages as $path) {
            $res = $this->getOnHost('eurobas.test', $path);
            $res->assertStatus(200);
            $res->assertDontSee('google.com/recaptcha/api.js', false);
            $res->assertDontSee('grecaptcha.render', false);
        }
    }

    /** @test */
    public function recaptcha_is_shown_on_a_real_host()
    {
        // The login page is the simplest reCAPTCHA-bearing page; on a real host the
        // widget/loader must render (proves production behaviour is preserved and the
        // @if/@elseif/@endif structure is balanced on the non-.test branch).
        $res = $this->getOnHost('eurobas.example', '/customer/auth/login');
        $res->assertStatus(200);
        $res->assertSee('google.com/recaptcha/api.js', false);
    }
}
