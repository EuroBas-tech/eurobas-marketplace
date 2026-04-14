<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PublicEndpointsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_config_returns_200()
    {
        $response = $this->getJson('/api/v1/config');
        $response->assertStatus(200);
    }

    public function test_categories_returns_200()
    {
        $response = $this->getJson('/api/v1/categories');
        $response->assertStatus(200);
    }

    public function test_faq_returns_200()
    {
        $response = $this->getJson('/api/v1/faq');
        $response->assertStatus(200);
    }

    public function test_social_media_returns_200()
    {
        $response = $this->getJson('/api/v1/social-media');
        $response->assertStatus(200);
    }

    public function test_get_guest_id_returns_200()
    {
        $response = $this->getJson('/api/v1/get-guest-id');
        $response->assertStatus(200)
            ->assertJsonStructure(['guest_id']);
    }

    public function test_paid_banners_returns_200()
    {
        $response = $this->getJson('/api/v1/paid-banners');
        $response->assertStatus(200);
    }

    public function test_banners_requires_type()
    {
        $response = $this->getJson('/api/v1/banners');
        $response->assertStatus(422);
    }

    public function test_banners_returns_200_with_type()
    {
        $response = $this->getJson('/api/v1/banners?banner_type=main_banner');
        $response->assertStatus(200);
    }

    public function test_ads_filter_returns_200()
    {
        $response = $this->postJson('/api/v1/ads/filter', ['limit' => 3]);
        $response->assertStatus(200);
    }

    public function test_searched_ads_requires_title()
    {
        $response = $this->postJson('/api/v1/searched-ads', []);
        $response->assertStatus(422);
    }

    public function test_translations_returns_200()
    {
        $response = $this->postJson('/api/v1/locale/translations/en');
        $response->assertStatus(200)
            ->assertJsonStructure(['locale', 'translations']);
    }

    public function test_subscription_requires_email()
    {
        $response = $this->postJson('/api/v1/subscription', []);
        $response->assertStatus(422);
    }

    public function test_contact_us_requires_fields()
    {
        $response = $this->postJson('/api/v1/contact-us', []);
        $response->assertStatus(422);
    }

    public function test_map_api_autocomplete_requires_search_text()
    {
        $response = $this->getJson('/api/v1/mapapi/place-api-autocomplete');
        $response->assertStatus(422);
    }

    public function test_map_api_distance_requires_coordinates()
    {
        $response = $this->getJson('/api/v1/mapapi/distance-api');
        $response->assertStatus(422);
    }

    public function test_map_api_place_details_requires_placeid()
    {
        $response = $this->getJson('/api/v1/mapapi/place-api-details');
        $response->assertStatus(422);
    }

    public function test_map_api_geocode_requires_lat_lng()
    {
        $response = $this->getJson('/api/v1/mapapi/geocode-api');
        $response->assertStatus(422);
    }
}
