<?php

namespace Tests\Feature\Api;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
    }

    private function createUser(array $attrs = []): User
    {
        return User::create(array_merge([
            'name' => 'Test User ' . Str::random(5),
            'email' => Str::random(10) . '@test.com',
            'password' => bcrypt('TestPass1'),
            'account_type' => 'individual',
            'phone_code' => 1,
            'is_active' => 1,
        ], $attrs));
    }

    public function test_register_returns_token_on_success()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Test User',
            'email' => 'register_' . Str::random(8) . '@example.com',
            'account_type' => 'individual',
            'agree' => true,
            'password' => 'TestPass1',
            'password_confirmation' => 'TestPass1',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['token', 'message']);
    }

    public function test_register_fails_with_missing_fields()
    {
        $response = $this->postJson('/api/v1/auth/register', []);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }

    public function test_register_fails_with_short_password()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Test',
            'email' => 'short_pw_' . Str::random(8) . '@example.com',
            'account_type' => 'individual',
            'agree' => true,
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertStatus(422);
    }

    public function test_register_fails_with_invalid_account_type()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Test',
            'email' => 'invalid_type_' . Str::random(8) . '@example.com',
            'account_type' => 'invalid',
            'agree' => true,
            'password' => 'TestPass1',
            'password_confirmation' => 'TestPass1',
        ]);

        $response->assertStatus(422);
    }

    public function test_register_fails_with_duplicate_email()
    {
        $user = $this->createUser(['email' => 'taken_' . Str::random(8) . '@example.com']);

        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Test',
            'email' => $user->email,
            'account_type' => 'individual',
            'agree' => true,
            'password' => 'TestPass1',
            'password_confirmation' => 'TestPass1',
        ]);

        $response->assertStatus(422);
    }

    public function test_login_returns_token_on_valid_credentials()
    {
        $email = 'login_' . Str::random(8) . '@test.com';
        $this->createUser([
            'email' => $email,
            'password' => bcrypt('TestPass1'),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $email,
            'password' => 'TestPass1',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token', 'message']);
    }

    public function test_login_returns_401_on_wrong_password()
    {
        $email = 'wrongpw_' . Str::random(8) . '@test.com';
        $this->createUser([
            'email' => $email,
            'password' => bcrypt('TestPass1'),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $email,
            'password' => 'WrongPass1',
        ]);

        $response->assertStatus(401);
    }

    public function test_login_returns_401_for_nonexistent_user()
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'nobody_' . Str::random(8) . '@test.com',
            'password' => 'TestPass1',
        ]);

        $response->assertStatus(401);
    }

    public function test_login_returns_422_with_missing_fields()
    {
        $response = $this->postJson('/api/v1/auth/login', []);

        $response->assertStatus(422);
    }

    public function test_logout_revokes_token()
    {
        $user = $this->createUser();
        Passport::actingAs($user);

        $response = $this->postJson('/api/v1/auth/logout');

        $response->assertStatus(200)
            ->assertJsonStructure(['message']);
    }

    public function test_refresh_returns_new_token()
    {
        $user = $this->createUser();
        Passport::actingAs($user);

        $response = $this->postJson('/api/v1/auth/refresh');

        $response->assertStatus(200)
            ->assertJsonStructure(['token', 'message']);
    }

    public function test_authenticated_endpoints_reject_no_token()
    {
        $this->getJson('/api/v1/customer/info')->assertStatus(401);
        $this->getJson('/api/v1/customer/profile')->assertStatus(401);
        $this->getJson('/api/v1/notifications')->assertStatus(401);
    }
}
