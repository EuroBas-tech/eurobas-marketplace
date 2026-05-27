<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Adds the translation keys the mobile app needs for website parity (§6.7):
 * the relative "joined … ago" suffixes and view_profile. English defaults are
 * seeded; other locales can be translated from the admin panel.
 */
class AddParityTranslationKeys extends Migration
{
    private array $keys = [
        'joined_today'         => 'Joined today',
        'joined_yesterday'     => 'Joined yesterday',
        'joined_n_days_ago'    => 'Joined :count days ago',
        'joined_n_months_ago'  => 'Joined :count months ago',
        'joined_n_years_ago'   => 'Joined :count years ago',
        'view_profile'         => 'View profile',
    ];

    public function up()
    {
        if (!Schema::hasTable('languages_translations')) {
            return;
        }

        foreach ($this->keys as $key => $value) {
            DB::table('languages_translations')->updateOrInsert(
                ['key' => $key, 'locale' => 'en'],
                ['value' => $value, 'updated_at' => now(), 'created_at' => now()]
            );
        }

        // Bust the per-locale translations cache so the new keys are served.
        try {
            Cache::store('file')->forget('translations_en');
            Cache::forget('translations_version_en');
        } catch (\Throwable $e) {
            // cache store may be unavailable during migration; ignore.
        }
    }

    public function down()
    {
        if (!Schema::hasTable('languages_translations')) {
            return;
        }

        DB::table('languages_translations')
            ->where('locale', 'en')
            ->whereIn('key', array_keys($this->keys))
            ->delete();
    }
}
