<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissingTables extends Migration
{
    public function up()
    {
        // sponsored_ad_types
        if (!Schema::hasTable('sponsored_ad_types')) {
            Schema::create('sponsored_ad_types', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->tinyInteger('status')->default(1);
                $table->timestamps();
            });
        }

        // subscription_packages
        if (!Schema::hasTable('subscription_packages')) {
            Schema::create('subscription_packages', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('type_id')->nullable();
                $table->string('name')->nullable();
                $table->decimal('price', 10, 2)->default(0);
                $table->integer('duration_in_days')->default(0);
                $table->tinyInteger('status')->default(1);
                $table->timestamps();

                if (Schema::hasTable('sponsored_ad_types')) {
                    $table->foreign('type_id')->references('id')->on('sponsored_ad_types')->nullOnDelete();
                }
            });
        }

        // subscription_package_features
        if (!Schema::hasTable('subscription_package_features')) {
            Schema::create('subscription_package_features', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->unsignedBigInteger('type_id')->nullable();
                $table->tinyInteger('status')->default(1);
                $table->timestamps();

                if (Schema::hasTable('sponsored_ad_types')) {
                    $table->foreign('type_id')->references('id')->on('sponsored_ad_types')->nullOnDelete();
                }
            });
        }

        // package_feature (pivot)
        if (!Schema::hasTable('package_feature')) {
            Schema::create('package_feature', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('package_id');
                $table->unsignedBigInteger('feature_id');
                $table->timestamps();

                if (Schema::hasTable('subscription_packages')) {
                    $table->foreign('package_id')->references('id')->on('subscription_packages')->cascadeOnDelete();
                }
                if (Schema::hasTable('subscription_package_features')) {
                    $table->foreign('feature_id')->references('id')->on('subscription_package_features')->cascadeOnDelete();
                }
            });
        }

        // models (vehicle models)
        if (!Schema::hasTable('models')) {
            Schema::create('models', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->unsignedBigInteger('brand_id')->nullable();
                $table->unsignedBigInteger('category_id')->nullable();
                $table->tinyInteger('status')->default(1);
                $table->timestamps();

                if (Schema::hasTable('brands')) {
                    $table->foreign('brand_id')->references('id')->on('brands')->nullOnDelete();
                }
                if (Schema::hasTable('categories')) {
                    $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
                }
            });
        }

        // model_category (pivot)
        if (!Schema::hasTable('model_category')) {
            Schema::create('model_category', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('model_id');
                $table->unsignedBigInteger('category_id');
                $table->timestamps();
            });
        }

        // category_types
        if (!Schema::hasTable('category_types')) {
            Schema::create('category_types', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->tinyInteger('status')->default(1);
                $table->timestamps();
            });
        }

        // ads
        if (!Schema::hasTable('ads')) {
            Schema::create('ads', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('category_id')->nullable();
                $table->unsignedBigInteger('brand_id')->nullable();
                $table->unsignedBigInteger('model_id')->nullable();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('thumbnail')->nullable();
                $table->json('images')->nullable();
                $table->string('currency')->nullable();
                $table->string('price_type')->nullable();
                $table->decimal('price', 15, 2)->nullable();
                $table->decimal('starting_price', 15, 2)->nullable();
                $table->decimal('first_price', 15, 2)->nullable();
                $table->tinyInteger('allow_offers')->default(0);
                $table->string('color')->nullable();
                $table->string('ad_status')->nullable();
                $table->string('fuel_type')->nullable();
                $table->string('engine_size')->nullable();
                $table->string('engine_cylinders')->nullable();
                $table->string('engine_power')->nullable();
                $table->string('mileage')->nullable();
                $table->string('year')->nullable();
                $table->string('transmission_type')->nullable();
                $table->string('body_type')->nullable();
                $table->string('length')->nullable();
                $table->string('width')->nullable();
                $table->string('height')->nullable();
                $table->string('max_weight')->nullable();
                $table->string('bag_capacity')->nullable();
                $table->string('doors_number')->nullable();
                $table->string('seats_number')->nullable();
                $table->string('co2_emissions')->nullable();
                $table->string('energy_consumption')->nullable();
                $table->string('gas_emission_tax')->nullable();
                $table->string('previous_scan_date')->nullable();
                $table->string('battery_charging_time')->nullable();
                $table->string('fast_battery_charging_time')->nullable();
                $table->string('battery_life')->nullable();
                $table->string('acceleration_0_100')->nullable();
                $table->json('options')->nullable();
                $table->string('furniture_type')->nullable();
                $table->string('material')->nullable();
                $table->string('listing_type')->nullable();
                $table->string('property_type')->nullable();
                $table->string('property_size')->nullable();
                $table->string('floor')->nullable();
                $table->string('rooms_number')->nullable();
                $table->string('machine_type')->nullable();
                $table->string('manufacturer')->nullable();
                $table->string('power_capacity')->nullable();
                $table->string('power_source')->nullable();
                $table->string('custom_brand')->nullable();
                $table->string('electronic_type')->nullable();
                $table->string('bicycle_type')->nullable();
                $table->string('bicycle_size')->nullable();
                $table->string('home_appliance_type')->nullable();
                $table->string('usage_type')->nullable();
                $table->string('maximum_speed')->nullable();
                $table->string('engines_number')->nullable();
                $table->string('cabins_number')->nullable();
                $table->string('beds_number')->nullable();
                $table->string('shipbuilding_type')->nullable();
                $table->tinyInteger('show_phone_number')->default(0);
                $table->tinyInteger('show_email_address')->default(0);
                $table->tinyInteger('whatsapp_availability')->default(0);
                $table->string('phone_code')->nullable();
                $table->string('contact_phone_number')->nullable();
                $table->string('city')->nullable();
                $table->string('country')->nullable();
                $table->decimal('latitude', 10, 7)->nullable();
                $table->decimal('longitude', 10, 7)->nullable();
                $table->string('postal_code')->nullable();
                $table->tinyInteger('status')->default(0);
                $table->timestamps();

                if (Schema::hasTable('users')) {
                    $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
                }
            });
        }

        // ads_views
        if (!Schema::hasTable('ads_views')) {
            Schema::create('ads_views', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('ad_id');
                $table->string('ip_address')->nullable();
                $table->string('user_agent')->nullable();
                $table->timestamps();

                if (Schema::hasTable('ads')) {
                    $table->foreign('ad_id')->references('id')->on('ads')->cascadeOnDelete();
                }
            });
        }

        // sponsored_ads
        if (!Schema::hasTable('sponsored_ads')) {
            Schema::create('sponsored_ads', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('ad_id')->nullable();
                $table->string('type')->nullable();
                $table->decimal('price', 10, 2)->default(0);
                $table->integer('duration_in_days')->default(0);
                $table->tinyInteger('status')->default(1);
                $table->tinyInteger('is_paid')->default(0);
                $table->unsignedBigInteger('package_id')->nullable();
                $table->string('payment_transaction_id')->nullable();
                $table->timestamp('expiration_date')->nullable();
                $table->unsignedBigInteger('video_id')->nullable();
                $table->timestamps();
            });
        }

        // ad_asking_price
        if (!Schema::hasTable('ad_asking_price')) {
            Schema::create('ad_asking_price', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('ad_id');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->decimal('price', 15, 2)->nullable();
                $table->tinyInteger('status')->default(0);
                $table->timestamps();
            });
        }

        // ad_auctions
        if (!Schema::hasTable('ad_auctions')) {
            Schema::create('ad_auctions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('ad_id');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->decimal('price', 15, 2)->nullable();
                $table->tinyInteger('status')->default(0);
                $table->timestamps();
            });
        }

        // ad_reports
        if (!Schema::hasTable('ad_reports')) {
            Schema::create('ad_reports', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('ad_id');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->text('reason')->nullable();
                $table->tinyInteger('status')->default(0);
                $table->timestamps();
            });
        }

        // payment_requests (if missing)
        if (!Schema::hasTable('payment_requests')) {
            Schema::create('payment_requests', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('payment_method')->nullable();
                $table->string('transaction_id')->nullable();
                $table->decimal('amount', 10, 2)->default(0);
                $table->string('type')->nullable();
                $table->string('status')->default('pending');
                $table->json('data')->nullable();
                $table->timestamps();
            });
        }

        // lists_attributes
        if (!Schema::hasTable('lists_attributes')) {
            Schema::create('lists_attributes', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        // lists_values
        if (!Schema::hasTable('lists_values')) {
            Schema::create('lists_values', function (Blueprint $table) {
                $table->id();
                $table->string('value');
                $table->unsignedBigInteger('list_attribute_id')->nullable();
                $table->integer('priority')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('lists_values');
        Schema::dropIfExists('lists_attributes');
        Schema::dropIfExists('payment_requests');
        Schema::dropIfExists('ad_reports');
        Schema::dropIfExists('ad_auctions');
        Schema::dropIfExists('ad_asking_price');
        Schema::dropIfExists('sponsored_ads');
        Schema::dropIfExists('ads_views');
        Schema::dropIfExists('ads');
        Schema::dropIfExists('category_types');
        Schema::dropIfExists('model_category');
        Schema::dropIfExists('models');
        Schema::dropIfExists('package_feature');
        Schema::dropIfExists('subscription_package_features');
        Schema::dropIfExists('subscription_packages');
        Schema::dropIfExists('sponsored_ad_types');
    }
}
