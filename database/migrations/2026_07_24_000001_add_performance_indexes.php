<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddPerformanceIndexes extends Migration
{
    public function up()
    {
        // ── ads (جدول الإعلانات الرئيسي) ──────────────────────────────────
        Schema::table('ads', function (Blueprint $table) {
            // فهرس مركب يغطي البحث عن الإعلانات المفعلة حسب القسم والتاريخ
            if (!$this->hasIndex('ads', 'ads_status_cat_created_idx')) {
                $table->index(['status', 'category_id', 'created_at'], 'ads_status_cat_created_idx');
            }
            // فهرس مركب للفلترة الجغرافية (الدولة والمدينة)
            if (!$this->hasIndex('ads', 'ads_location_idx')) {
                $table->index(['country', 'city'], 'ads_location_idx');
            }
            // فهرس مركب للفلترة حسب الماركة والموديل
            if (!$this->hasIndex('ads', 'ads_brand_model_idx')) {
                $table->index(['brand_id', 'model_id'], 'ads_brand_model_idx');
            }

            // فهارس فردية للحقول التي تُستعلم بمفردها
            if (!$this->hasIndex('ads', 'ads_user_id_idx')) {
                $table->index('user_id', 'ads_user_id_idx');
            }
            if (!$this->hasIndex('ads', 'ads_price_idx')) {
                $table->index('price', 'ads_price_idx');
            }
            if (!$this->hasIndex('ads', 'ads_year_idx')) {
                $table->index('year', 'ads_year_idx');
            }
        });

        // ── sponsored_ads (الإعلانات المميزة والرعايات) ────────────────────
        Schema::table('sponsored_ads', function (Blueprint $table) {
            if (!$this->hasIndex('sponsored_ads', 'sp_type_paid_exp_idx')) {
                $table->index(['type', 'is_paid', 'expiration_date'], 'sp_type_paid_exp_idx');
            }
            if (!$this->hasIndex('sponsored_ads', 'sp_status_idx')) {
                $table->index('status', 'sp_status_idx');
            }
        });

        // ── paid_banners (البانرات المدفوعة) ──────────────────────────────
        Schema::table('paid_banners', function (Blueprint $table) {
            if (!$this->hasIndex('paid_banners', 'pb_status_paid_exp_idx')) {
                $table->index(['status', 'is_paid', 'expiration_date'], 'pb_status_paid_exp_idx');
            }
        });

        // ── categories (الأقسام) ──────────────────────────────────────────
        Schema::table('categories', function (Blueprint $table) {
            if (!$this->hasIndex('categories', 'cat_home_status_pos_idx')) {
                $table->index(['home_status', 'position'], 'cat_home_status_pos_idx');
            }
            if (!$this->hasIndex('categories', 'cat_type_idx')) {
                $table->index('category_type', 'cat_type_idx');
            }
            if (!$this->hasIndex('categories', 'cat_priority_idx')) {
                $table->index('priority', 'cat_priority_idx');
            }
        });

        // ── user_category_interests (اهتمامات المستخدمين) ───────────────
        Schema::table('user_category_interests', function (Blueprint $table) {
            if (!$this->hasIndex('user_category_interests', 'uci_user_id_idx')) {
                $table->index('user_id', 'uci_user_id_idx');
            }
            if (!$this->hasIndex('user_category_interests', 'uci_guest_id_idx')) {
                $table->index('guest_id', 'uci_guest_id_idx');
            }
            if (!$this->hasIndex('user_category_interests', 'uci_category_score_idx')) {
                $table->index(['category_id', 'score'], 'uci_category_score_idx');
            }
        });

        // ── admin_wallet_actions (عمليات المحفظة) ─────────────────────────
        Schema::table('admin_wallet_actions', function (Blueprint $table) {
            if (!$this->hasIndex('admin_wallet_actions', 'awa_gateway_tx_gross_idx')) {
                $table->index(['gateway', 'transaction_id', 'gross_amount'], 'awa_gateway_tx_gross_idx');
            }
            if (!$this->hasIndex('admin_wallet_actions', 'awa_created_at_idx')) {
                $table->index('created_at', 'awa_created_at_idx');
            }
        });
    }

    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $this->dropIndexIfExists('ads', 'ads_status_cat_created_idx', $table);
            $this->dropIndexIfExists('ads', 'ads_location_idx', $table);
            $this->dropIndexIfExists('ads', 'ads_brand_model_idx', $table);
            $this->dropIndexIfExists('ads', 'ads_user_id_idx', $table);
            $this->dropIndexIfExists('ads', 'ads_price_idx', $table);
            $this->dropIndexIfExists('ads', 'ads_year_idx', $table);
        });

        Schema::table('sponsored_ads', function (Blueprint $table) {
            $this->dropIndexIfExists('sponsored_ads', 'sp_type_paid_exp_idx', $table);
            $this->dropIndexIfExists('sponsored_ads', 'sp_status_idx', $table);
        });

        Schema::table('paid_banners', function (Blueprint $table) {
            $this->dropIndexIfExists('paid_banners', 'pb_status_paid_exp_idx', $table);
        });

        Schema::table('categories', function (Blueprint $table) {
            $this->dropIndexIfExists('categories', 'cat_home_status_pos_idx', $table);
            $this->dropIndexIfExists('categories', 'cat_type_idx', $table);
            $this->dropIndexIfExists('categories', 'cat_priority_idx', $table);
        });

        Schema::table('user_category_interests', function (Blueprint $table) {
            $this->dropIndexIfExists('user_category_interests', 'uci_user_id_idx', $table);
            $this->dropIndexIfExists('user_category_interests', 'uci_guest_id_idx', $table);
            $this->dropIndexIfExists('user_category_interests', 'uci_category_score_idx', $table);
        });

        Schema::table('admin_wallet_actions', function (Blueprint $table) {
            $this->dropIndexIfExists('admin_wallet_actions', 'awa_gateway_tx_gross_idx', $table);
            $this->dropIndexIfExists('admin_wallet_actions', 'awa_created_at_idx', $table);
        });
    }

    private function hasIndex(string $table, string $indexName): bool
    {
        return count(DB::select(
            "SHOW INDEX FROM `{$table}` WHERE Key_name = ?",
            [$indexName]
        )) > 0;
    }

    private function dropIndexIfExists(string $table, string $indexName, Blueprint $tableBlueprint): void
    {
        if ($this->hasIndex($table, $indexName)) {
            $tableBlueprint->dropIndex($indexName);
        }
    }
}
