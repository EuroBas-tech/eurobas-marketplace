<?php

namespace Tests\Feature\Api;

use App\Model\Ad;
use App\Model\Category;
use App\Model\SponsoredAd;
use App\Model\SubscriptionPackage;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * §4 promotions & payments.
 */
class PromotionPaymentTest extends TestCase
{
    use DatabaseTransactions;

    private User $user;
    private int $categoryId;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        $this->categoryId = (int) Category::where('position', 1)->value('id');
        $this->user = $this->makeUser();
        Passport::actingAs($this->user);
    }

    private function makeUser(): User
    {
        return User::create([
            'name' => 'P ' . Str::random(5), 'email' => 'p_' . Str::random(8) . '@test.com',
            'password' => bcrypt('TestPass1'), 'account_type' => 'individual',
            'f_name' => 'P', 'l_name' => 'U', 'phone_code' => '+31', 'phone' => '06',
            'country' => 'NL', 'city' => 'R', 'native_language' => 'en', 'is_active' => 1,
        ]);
    }

    private function makeAd(int $userId): Ad
    {
        $ad = new Ad();
        $ad->user_id = $userId;
        $ad->title = 'Ad ' . Str::random(5);
        $ad->slug = Str::slug($ad->title) . '-' . Str::random(6);
        $ad->category_id = $this->categoryId;
        $ad->price_type = 'fixed_price';
        $ad->price = 1000;
        $ad->currency = 'EUR';
        $ad->status = 1;
        $ad->images = json_encode([]);
        $ad->save();
        return $ad;
    }

    private function pkg(string $type, ?bool $free = null): ?SubscriptionPackage
    {
        return SubscriptionPackage::where('status', 1)
            ->when($free === true, fn($q) => $q->where('price', 0))
            ->when($free === false, fn($q) => $q->where('price', '>', 0))
            ->whereHas('type', fn($q) => $q->where('name', $type))
            ->first();
    }

    public function test_packages_catalogue()
    {
        $this->getJson('/api/v1/subscription-packages')
            ->assertStatus(200)
            ->assertJsonStructure(['packages' => [['id', 'type', 'price', 'duration_in_days', 'features']]]);
    }

    public function test_packages_filtered_by_type()
    {
        if (!$this->pkg('promotional_banner')) {
            $this->markTestSkipped('no promotional_banner package seeded');
        }
        $res = $this->getJson('/api/v1/subscription-packages?type=promotional_banner')->assertStatus(200);
        foreach ($res->json('packages') as $p) {
            $this->assertSame('promotional_banner', $p['type']['name']);
        }
    }

    public function test_create_paid_banner_free()
    {
        $pkg = $this->pkg('promotional_banner', true);
        if (!$pkg) {
            $this->markTestSkipped('no free promotional_banner package');
        }
        $res = $this->post('/api/v1/customer/paid-banners', [
            'package_id' => $pkg->id, 'category_id' => $this->categoryId,
            'banner_image' => UploadedFile::fake()->image('b.jpg'),
        ], ['Accept' => 'application/json']);
        $res->assertStatus(201)->assertJsonPath('payment.required', false);
        $this->assertDatabaseHas('paid_banners', ['id' => $res->json('banner.id'), 'user_id' => $this->user->id, 'is_paid' => 1]);
    }

    public function test_create_sponsor_free_and_paid_branches()
    {
        $ad = $this->makeAd($this->user->id);

        $free = $this->pkg('urgent_sale_sticker', true);
        if ($free) {
            $this->postJson('/api/v1/customer/sponsors', ['ad_id' => $ad->id, 'type' => 'urgent_sale_sticker', 'package_id' => $free->id])
                ->assertStatus(201)->assertJsonPath('payment.required', false);
        }

        $paid = $this->pkg('appearance_in_first_results', false);
        if ($paid) {
            $this->postJson('/api/v1/customer/sponsors', ['ad_id' => $ad->id, 'type' => 'appearance_in_first_results', 'package_id' => $paid->id])
                ->assertStatus(201)->assertJsonPath('payment.required', true);
        }
        if (!$free && !$paid) {
            $this->markTestSkipped('no sponsor packages seeded');
        }
    }

    public function test_sponsor_on_unowned_ad_rejected()
    {
        $pkg = $this->pkg('urgent_sale_sticker');
        if (!$pkg) { $this->markTestSkipped('no urgent_sale_sticker package'); }
        $ad = $this->makeAd($this->makeUser()->id);
        $this->postJson('/api/v1/customer/sponsors', ['ad_id' => $ad->id, 'type' => 'urgent_sale_sticker', 'package_id' => $pkg->id])
            ->assertStatus(404);
    }

    public function test_promotional_video_requires_video_id()
    {
        $pkg = $this->pkg('promotional_video');
        if (!$pkg) { $this->markTestSkipped('no promotional_video package'); }
        $ad = $this->makeAd($this->user->id);
        $this->postJson('/api/v1/customer/sponsors', ['ad_id' => $ad->id, 'type' => 'promotional_video', 'package_id' => $pkg->id])
            ->assertStatus(422);
    }

    public function test_manage_lists()
    {
        $this->getJson('/api/v1/customer/sponsors')->assertStatus(200)->assertJsonStructure(['data']);
        $this->getJson('/api/v1/customer/paid-banners')->assertStatus(200)->assertJsonStructure(['data']);
    }

    public function test_delete_sponsor_owner_scope()
    {
        $ad = $this->makeAd($this->user->id);
        $sp = $ad->sponsor()->create(['ad_id' => $ad->id, 'type' => 'urgent_sale_sticker', 'price' => 0, 'duration_in_days' => 7, 'status' => 1, 'is_paid' => 1, 'expiration_date' => now()->addDays(7)]);
        // someone else's sponsor
        $otherAd = $this->makeAd($this->makeUser()->id);
        $otherSp = $otherAd->sponsor()->create(['ad_id' => $otherAd->id, 'type' => 'urgent_sale_sticker', 'price' => 0, 'duration_in_days' => 7, 'status' => 1, 'is_paid' => 1, 'expiration_date' => now()->addDays(7)]);

        $this->deleteJson("/api/v1/customer/sponsors/{$otherSp->id}")->assertStatus(404);
        $this->deleteJson("/api/v1/customer/sponsors/{$sp->id}")->assertStatus(200);
    }

    public function test_payment_initiate_branches()
    {
        $ad = $this->makeAd($this->user->id);
        $unpaid = $ad->sponsor()->create(['ad_id' => $ad->id, 'type' => 'appearance_in_first_results', 'price' => 10, 'duration_in_days' => 7, 'status' => 1, 'is_paid' => 0, 'expiration_date' => now()->addDays(7)]);
        $paid = $ad->sponsor()->create(['ad_id' => $ad->id, 'type' => 'urgent_sale_sticker', 'price' => 0, 'duration_in_days' => 7, 'status' => 1, 'is_paid' => 1, 'expiration_date' => now()->addDays(7)]);

        // validation
        $this->postJson('/api/v1/payment/initiate', ['model_type' => 'sponsor', 'model_id' => $unpaid->id, 'method' => 'bogus'])->assertStatus(422);
        // not owned
        $this->postJson('/api/v1/payment/initiate', ['model_type' => 'paid_banner', 'model_id' => 999999, 'method' => 'paypal'])->assertStatus(404);
        // already paid
        $this->postJson('/api/v1/payment/initiate', ['model_type' => 'sponsor', 'model_id' => $paid->id, 'method' => 'paypal'])->assertStatus(409);
        // verify unpaid
        $this->getJson("/api/v1/payment/verify?model_type=sponsor&model_id={$unpaid->id}")
            ->assertStatus(200)->assertJsonPath('is_paid', false);
    }

    public function test_mux_video_requires_upload_id()
    {
        $this->getJson('/api/v1/mux/video')->assertStatus(400);
    }

    public function test_config_exposes_payment_gateways_and_urls()
    {
        $this->getJson('/api/v1/config')
            ->assertStatus(200)
            ->assertJsonStructure(['payment_gateways' => ['paypal', 'stripe'], 'base_urls' => ['customer_image_url', 'cover_image_url']]);
    }
}
