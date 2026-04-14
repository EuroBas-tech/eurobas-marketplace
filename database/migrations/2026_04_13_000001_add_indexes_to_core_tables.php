<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToCoreTables extends Migration
{
    public function up()
    {
        // Ads table - critical for search and filter queries
        if (Schema::hasTable('ads')) {
            Schema::table('ads', function (Blueprint $table) {
                if (!$this->hasIndex('ads', 'ads_user_id_index')) {
                    $table->index('user_id');
                }
                if (!$this->hasIndex('ads', 'ads_category_id_index')) {
                    $table->index('category_id');
                }
                if (!$this->hasIndex('ads', 'ads_brand_id_index')) {
                    $table->index('brand_id');
                }
                if (!$this->hasIndex('ads', 'ads_model_id_index')) {
                    $table->index('model_id');
                }
                if (!$this->hasIndex('ads', 'ads_status_index')) {
                    $table->index('status');
                }
                if (!$this->hasIndex('ads', 'ads_slug_index')) {
                    $table->index('slug');
                }
                if (!$this->hasIndex('ads', 'ads_country_index')) {
                    $table->index('country');
                }
                if (!$this->hasIndex('ads', 'ads_price_index')) {
                    $table->index('price');
                }
                if (!$this->hasIndex('ads', 'ads_created_at_index')) {
                    $table->index('created_at');
                }
            });
        }

        // Ad views
        if (Schema::hasTable('ads_views')) {
            Schema::table('ads_views', function (Blueprint $table) {
                if (!$this->hasIndex('ads_views', 'ads_views_ad_id_index')) {
                    $table->index('ad_id');
                }
                if (!$this->hasIndex('ads_views', 'ads_views_ip_user_agent_index')) {
                    $table->index(['ad_id', 'ip_address', 'user_agent'], 'ads_views_ip_user_agent_index');
                }
            });
        }

        // Sponsored ads
        if (Schema::hasTable('sponsored_ads')) {
            Schema::table('sponsored_ads', function (Blueprint $table) {
                if (!$this->hasIndex('sponsored_ads', 'sponsored_ads_ad_id_index')) {
                    $table->index('ad_id');
                }
                if (!$this->hasIndex('sponsored_ads', 'sponsored_ads_status_index')) {
                    $table->index('status');
                }
            });
        }

        // Wishlists
        if (Schema::hasTable('wishlists')) {
            Schema::table('wishlists', function (Blueprint $table) {
                if (!$this->hasIndex('wishlists', 'wishlists_customer_id_index')) {
                    $table->index('customer_id');
                }
                if (!$this->hasIndex('wishlists', 'wishlists_ad_id_index')) {
                    $table->index('ad_id');
                }
            });
        }

        // Chattings
        if (Schema::hasTable('chattings')) {
            Schema::table('chattings', function (Blueprint $table) {
                if (!$this->hasIndex('chattings', 'chattings_sender_id_index')) {
                    $table->index('sender_id');
                }
                if (!$this->hasIndex('chattings', 'chattings_receiver_id_index')) {
                    $table->index('receiver_id');
                }
            });
        }

        // Support tickets
        if (Schema::hasTable('support_tickets')) {
            Schema::table('support_tickets', function (Blueprint $table) {
                if (!$this->hasIndex('support_tickets', 'support_tickets_customer_id_index')) {
                    $table->index('customer_id');
                }
            });
        }

        // Support ticket conversations
        if (Schema::hasTable('support_ticket_convs')) {
            Schema::table('support_ticket_convs', function (Blueprint $table) {
                if (!$this->hasIndex('support_ticket_convs', 'support_ticket_convs_support_ticket_id_index')) {
                    $table->index('support_ticket_id');
                }
            });
        }

        // Paid banners
        if (Schema::hasTable('paid_banners')) {
            Schema::table('paid_banners', function (Blueprint $table) {
                if (!$this->hasIndex('paid_banners', 'paid_banners_user_id_index')) {
                    $table->index('user_id');
                }
                if (!$this->hasIndex('paid_banners', 'paid_banners_status_paid_index')) {
                    $table->index(['status', 'is_paid', 'expiration_date'], 'paid_banners_status_paid_index');
                }
            });
        }

        // User category interests
        if (Schema::hasTable('user_category_interests')) {
            Schema::table('user_category_interests', function (Blueprint $table) {
                if (!$this->hasIndex('user_category_interests', 'uci_user_id_index')) {
                    $table->index('user_id', 'uci_user_id_index');
                }
                if (!$this->hasIndex('user_category_interests', 'uci_guest_id_index')) {
                    $table->index('guest_id', 'uci_guest_id_index');
                }
            });
        }

        // Notifications
        if (Schema::hasTable('notifications')) {
            Schema::table('notifications', function (Blueprint $table) {
                if (!$this->hasIndex('notifications', 'notifications_status_index')) {
                    $table->index('status');
                }
            });
        }

        // Users
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!$this->hasIndex('users', 'users_email_index')) {
                    $table->index('email');
                }
            });
        }
    }

    public function down()
    {
        $indexes = [
            'ads' => ['ads_user_id_index', 'ads_category_id_index', 'ads_brand_id_index', 'ads_model_id_index', 'ads_status_index', 'ads_slug_index', 'ads_country_index', 'ads_price_index', 'ads_created_at_index'],
            'ads_views' => ['ads_views_ad_id_index', 'ads_views_ip_user_agent_index'],
            'sponsored_ads' => ['sponsored_ads_ad_id_index', 'sponsored_ads_status_index'],
            'wishlists' => ['wishlists_customer_id_index', 'wishlists_ad_id_index'],
            'chattings' => ['chattings_sender_id_index', 'chattings_receiver_id_index'],
            'support_tickets' => ['support_tickets_customer_id_index'],
            'support_ticket_convs' => ['support_ticket_convs_support_ticket_id_index'],
            'paid_banners' => ['paid_banners_user_id_index', 'paid_banners_status_paid_index'],
            'user_category_interests' => ['uci_user_id_index', 'uci_guest_id_index'],
            'notifications' => ['notifications_status_index'],
            'users' => ['users_email_index'],
        ];

        foreach ($indexes as $table => $idxs) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) use ($idxs) {
                    foreach ($idxs as $idx) {
                        try {
                            $table->dropIndex($idx);
                        } catch (\Exception $e) {
                            // Index may not exist
                        }
                    }
                });
            }
        }
    }

    private function hasIndex(string $table, string $indexName): bool
    {
        $conn = \Illuminate\Support\Facades\Schema::getConnection();
        $prefix = $conn->getTablePrefix();
        $indexes = collect($conn->select(
            'SHOW INDEX FROM ' . $conn->getQueryGrammar()->wrapTable($prefix . $table)
        ))->pluck('Key_name')->unique()->toArray();

        return in_array($indexName, $indexes);
    }
}
