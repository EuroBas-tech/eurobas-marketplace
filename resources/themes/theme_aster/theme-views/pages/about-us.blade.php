@extends('theme-views.layouts.app')

@section('title', translate('About_Us').' | '.$web_config['name']->value)

@push('css_or_js')
<meta property="og:image" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
<meta property="og:title" content="{{ translate('About_EuroBas.com_—_Europe\'s_Unified_Marketplace') }}"/>
<meta property="og:url" content="{{env('APP_URL')}}">
<meta property="og:description" content="{{ translate('Europe\'s_unified_marketplace_for_vehicles,_real_estate,_boats,_furniture_and_more._Free_to_use,_available_in_31_languages.') }}">
<style>
*{box-sizing:border-box}
.ab-hero{text-align:center;padding:4.5rem 1rem 3.5rem;background:linear-gradient(135deg,#0d3b8e 0%,#1565c0 50%,#1976d2 100%);color:#fff;position:relative;overflow:hidden}
.ab-hero::before{content:'';position:absolute;top:-80px;right:-80px;width:350px;height:350px;border-radius:50%;background:rgba(255,255,255,.04)}
.ab-hero::after{content:'';position:absolute;bottom:-100px;left:-60px;width:300px;height:300px;border-radius:50%;background:rgba(255,255,255,.03)}
.ab-badge{display:inline-block;background:rgba(255,255,255,.18);color:#fff;font-size:13px;padding:6px 18px;border-radius:25px;margin-bottom:1.5rem;font-weight:500;letter-spacing:.3px}
.ab-hero h1{font-size:2.6rem;font-weight:700;margin-bottom:1rem;position:relative;letter-spacing:-.5px}
.ab-hero-p{font-size:1.1rem;max-width:620px;margin:0 auto 2rem;opacity:.92;line-height:1.8;position:relative}
.ab-stats{display:flex;justify-content:center;gap:3rem;flex-wrap:wrap;position:relative;margin-top:.5rem}
.ab-stat-num{font-size:2.2rem;font-weight:800}
.ab-stat-lbl{font-size:11px;opacity:.75;text-transform:uppercase;letter-spacing:.5px;margin-top:2px}
.ab-section{padding:3rem 0}
.ab-divider{border:none;border-top:1px solid #f0f0f0;margin:0}
.ab-h2{font-size:1.7rem;font-weight:700;color:#0d1b3e;margin-bottom:.5rem}
.ab-sub{font-size:1rem;color:#666;margin-bottom:2rem;line-height:1.7;max-width:680px}
.ab-free{background:linear-gradient(135deg,#e8f5e9,#f1f8e9);border:1.5px solid #a5d6a7;border-radius:18px;padding:1.75rem 2rem;display:flex;align-items:center;gap:1.5rem;margin-bottom:2.5rem}
.ab-free-icon{width:56px;height:56px;background:#2e7d32;border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.6rem}
.ab-free-title{font-size:1.15rem;font-weight:700;color:#1b5e20;margin-bottom:4px}
.ab-free-desc{font-size:.9rem;color:#388e3c;line-height:1.6}
.ab-cats{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:1rem}
.ab-cat{background:#fff;border:1px solid #eaecf0;border-radius:16px;padding:1.5rem 1.25rem;text-align:center;transition:all .25s ease;cursor:default}
.ab-cat:hover{transform:translateY(-5px);box-shadow:0 12px 30px rgba(0,0,0,.08);border-color:#c5cae9}
.ab-cat-ico{width:58px;height:58px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .875rem;font-size:1.5rem}
.ab-cat-name{font-size:.9rem;font-weight:700;color:#0d1b3e;margin-bottom:.35rem}
.ab-cat-desc{font-size:.78rem;color:#888;line-height:1.5}
.ab-paid-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem}
.ab-paid-card{background:#fff;border:1px solid #eaecf0;border-radius:14px;padding:1.25rem 1.5rem;display:flex;gap:1rem;align-items:flex-start;transition:box-shadow .2s}
.ab-paid-card:hover{box-shadow:0 6px 20px rgba(0,0,0,.06)}
.ab-paid-ico{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0}
.ab-paid-name{font-size:.9rem;font-weight:700;color:#0d1b3e;margin-bottom:4px}
.ab-paid-desc{font-size:.8rem;color:#888;line-height:1.5}
.ab-note{background:#fff8e1;border:1px solid #ffe082;border-radius:10px;padding:.875rem 1.25rem;font-size:.83rem;color:#e65100;margin-top:1rem;line-height:1.6}
.ab-offer-list{list-style:none;padding:0;margin:0}
.ab-offer-li{display:flex;gap:1rem;align-items:flex-start;padding:1rem 0;border-bottom:1px solid #f5f5f5}
.ab-offer-li:last-child{border-bottom:none}
.ab-offer-ico{width:40px;height:40px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.2rem}
.ab-offer-name{font-size:.95rem;font-weight:700;color:#0d1b3e;margin-bottom:3px}
.ab-offer-desc{font-size:.85rem;color:#666;line-height:1.65}
.ab-steps{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.25rem}
.ab-step{background:#fff;border:1px solid #eaecf0;border-radius:16px;padding:1.75rem 1.5rem;position:relative}
.ab-step-n{width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#1565c0,#1976d2);color:#fff;font-size:.95rem;font-weight:700;display:flex;align-items:center;justify-content:center;margin-bottom:1rem}
.ab-step-name{font-size:.95rem;font-weight:700;color:#0d1b3e;margin-bottom:.4rem}
.ab-step-desc{font-size:.83rem;color:#888;line-height:1.6}
.ab-vision-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:1.25rem}
.ab-vision{background:#fff;border:1px solid #eaecf0;border-radius:16px;padding:1.75rem}
.ab-vision-ico{font-size:2rem;margin-bottom:.875rem}
.ab-vision-name{font-size:1rem;font-weight:700;color:#0d1b3e;margin-bottom:.5rem}
.ab-vision-desc{font-size:.85rem;color:#666;line-height:1.7}
.ab-langs{display:flex;flex-wrap:wrap;gap:.4rem;margin-top:1rem}
.ab-lang{background:#f5f7fa;border:1px solid #e8ecf0;border-radius:20px;padding:4px 14px;font-size:.78rem;color:#555;font-weight:500}
.ab-co{background:#fff;border:1px solid #eaecf0;border-radius:16px;overflow:hidden}
.ab-co-row{display:flex;justify-content:space-between;align-items:center;padding:1rem 1.5rem;border-bottom:1px solid #f5f5f5}
.ab-co-row:last-child{border-bottom:none}
.ab-co-lbl{font-size:.88rem;color:#888}
.ab-co-val{font-size:.9rem;font-weight:700;color:#0d1b3e}
.ab-cta{text-align:center;background:linear-gradient(135deg,#0d3b8e,#1565c0);border-radius:22px;padding:3.5rem 2rem;color:#fff;margin-top:1rem}
.ab-cta h2{font-size:1.85rem;font-weight:700;margin-bottom:.875rem}
.ab-cta p{font-size:1.05rem;opacity:.9;margin-bottom:1.75rem;line-height:1.7}
.ab-cta-btn{display:inline-block;background:#fff;color:#1565c0;padding:14px 36px;border-radius:30px;font-weight:700;font-size:1rem;text-decoration:none;transition:transform .2s,box-shadow .2s}
.ab-cta-btn:hover{transform:translateY(-3px);box-shadow:0 8px 24px rgba(0,0,0,.2);color:#1565c0}
@media(max-width:600px){.ab-hero h1{font-size:1.9rem}.ab-stats{gap:1.5rem}.ab-free{flex-direction:column}}
</style>
@endpush

@section('content')
<main class="main-content">

    {{-- HERO --}}
    <div class="ab-hero">
        <div class="ab-badge">🌍 {{ translate('Europe\'s_Unified_Free_Marketplace') }}</div>
        <h1>EuroBas.com</h1>
        <p class="ab-hero-p">{{ translate('A_free,_borderless_digital_marketplace_connecting_buyers_and_sellers_across_Europe_—_available_in_31_languages,_with_zero_fees_and_zero_hidden_costs._Buy_and_sell_anything,_anywhere_in_Europe.') }}</p>
        <div class="ab-stats">
            <div><div class="ab-stat-num">31</div><div class="ab-stat-lbl">{{ translate('Languages') }}</div></div>
            <div><div class="ab-stat-num">100%</div><div class="ab-stat-lbl">{{ translate('Free_to_use') }}</div></div>
            <div><div class="ab-stat-num">20+</div><div class="ab-stat-lbl">{{ translate('Categories') }}</div></div>
            <div><div class="ab-stat-num">€0</div><div class="ab-stat-lbl">{{ translate('Hidden_fees') }}</div></div>
        </div>
    </div>

    <div class="container">

        {{-- FREE BANNER --}}
        <div class="ab-section">
            <div class="ab-free">
                <div class="ab-free-icon">✅</div>
                <div>
                    <div class="ab-free-title">{{ translate('Always_free_—_register,_post,_and_contact_sellers_at_no_cost') }}</div>
                    <div class="ab-free-desc">{{ translate('No_subscriptions._No_commissions._No_hidden_fees._EuroBas.com_will_always_remain_free_to_register,_free_to_publish_ads,_and_free_to_contact_sellers._No_payment_is_required_to_use_the_core_features_of_the_platform.') }}</div>
                </div>
            </div>

            {{-- CATEGORIES --}}
            <div class="ab-h2">{{ translate('Everything_you_can_buy_&_sell_on_EuroBas') }}</div>
            <div class="ab-sub">{{ translate('From_cars_to_real_estate,_boats_to_electronics_—_one_unified_platform_for_all_categories_across_Europe.') }}</div>
            <div class="ab-cats">

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e3f2fd">🚗</div>
                    <div class="ab-cat-name">{{ translate('Cars') }}</div>
                    <div class="ab-cat-desc">{{ translate('New_and_used_cars_of_all_makes_and_models_across_Europe.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e8eaf6">🏎️</div>
                    <div class="ab-cat-name">{{ translate('Supercars') }}</div>
                    <div class="ab-cat-desc">{{ translate('Premium_and_exotic_supercars_from_top_European_and_international_brands.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#fce4ec">🏛️</div>
                    <div class="ab-cat-name">{{ translate('Classic_Cars') }}</div>
                    <div class="ab-cat-desc">{{ translate('Vintage_and_classic_automobiles_for_collectors_and_enthusiasts.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e0f2f1">🚚</div>
                    <div class="ab-cat-name">{{ translate('Trucks') }}</div>
                    <div class="ab-cat-desc">{{ translate('Light,_medium_and_heavy-duty_trucks_for_commercial_use.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#fff3e0">🏍️</div>
                    <div class="ab-cat-name">{{ translate('Motorcycles') }}</div>
                    <div class="ab-cat-desc">{{ translate('Sport_bikes,_cruisers,_scooters_and_off-road_motorcycles.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#f3e5f5">🚌</div>
                    <div class="ab-cat-name">{{ translate('Buses') }}</div>
                    <div class="ab-cat-desc">{{ translate('Passenger_buses,_minibuses_and_coaches_for_sale_across_Europe.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e8f5e9">🚐</div>
                    <div class="ab-cat-name">{{ translate('Caravans') }}</div>
                    <div class="ab-cat-desc">{{ translate('Touring_caravans_and_camper_trailers_for_leisure_travel.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e0f7fa">🏕️</div>
                    <div class="ab-cat-name">{{ translate('Motorhomes') }}</div>
                    <div class="ab-cat-desc">{{ translate('Self-contained_motorhomes_and_camper_vans_for_the_open_road.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#fff8e1">🚜</div>
                    <div class="ab-cat-name">{{ translate('Agricultural_Machinery') }}</div>
                    <div class="ab-cat-desc">{{ translate('Tractors,_harvesters,_irrigation_equipment_and_farm_tools.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#fbe9e7">🚵</div>
                    <div class="ab-cat-name">{{ translate('Bicycles') }}</div>
                    <div class="ab-cat-desc">{{ translate('Road,_mountain,_electric_and_cargo_bicycles_for_all_riders.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#ede7f6">🔧</div>
                    <div class="ab-cat-name">{{ translate('Spare_Parts') }}</div>
                    <div class="ab-cat-desc">{{ translate('Vehicle_spare_parts,_accessories,_tires,_rims_and_tools.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e8f5e9">🎿</div>
                    <div class="ab-cat-name">{{ translate('Vehicle_Accessories') }}</div>
                    <div class="ab-cat-desc">{{ translate('Car_care_products,_navigation,_audio_systems_and_accessories.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e3f2fd">🏠</div>
                    <div class="ab-cat-name">{{ translate('Real_Estate') }}</div>
                    <div class="ab-cat-desc">{{ translate('Apartments,_houses,_villas,_land_and_commercial_properties_for_sale_or_rent.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e0f7fa">⚓</div>
                    <div class="ab-cat-name">{{ translate('Ships_&_Yachts') }}</div>
                    <div class="ab-cat-desc">{{ translate('Private_and_commercial_boats,_yachts,_marine_equipment_and_accessories.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#fff3e0">🪑</div>
                    <div class="ab-cat-name">{{ translate('Furniture') }}</div>
                    <div class="ab-cat-desc">{{ translate('Indoor,_outdoor,_office_furniture,_sofas,_beds_and_dining_sets.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#fce4ec">🌿</div>
                    <div class="ab-cat-name">{{ translate('Home_&_Garden') }}</div>
                    <div class="ab-cat-desc">{{ translate('Garden_tools,_outdoor_furniture,_plants_and_home_decoration.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#f3e5f5">📺</div>
                    <div class="ab-cat-name">{{ translate('Electronics') }}</div>
                    <div class="ab-cat-desc">{{ translate('TVs,_smartphones,_computers,_cameras_and_smart_home_devices.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e8f5e9">🍳</div>
                    <div class="ab-cat-name">{{ translate('Home_Appliances') }}</div>
                    <div class="ab-cat-desc">{{ translate('Kitchen_appliances,_washing_machines,_refrigerators_and_more.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e3f2fd">⚙️</div>
                    <div class="ab-cat-name">{{ translate('Industrial_Machines') }}</div>
                    <div class="ab-cat-desc">{{ translate('Manufacturing_equipment,_CNC_machines,_forklifts_and_heavy_tools.') }}</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e0f2f1">🏗️</div>
                    <div class="ab-cat-name">{{ translate('Heavy_Equipment') }}</div>
                    <div class="ab-cat-desc">{{ translate('Construction_machinery,_excavators,_cranes_and_bulldozers.') }}</div>
                </div>

            </div>
        </div>

        <hr class="ab-divider">

        {{-- OPTIONAL PAID SERVICES --}}
        <div class="ab-section">
            <div class="ab-h2">{{ translate('Optional_paid_services') }}</div>
            <div class="ab-sub">{{ translate('Boost_your_ad\'s_visibility_with_optional_promotional_tools_—_none_are_required_to_use_the_platform_or_publish_ads.') }}</div>
            <div class="ab-paid-grid">
                <div class="ab-paid-card">
                    <div class="ab-paid-ico" style="background:#e3f2fd">📌</div>
                    <div>
                        <div class="ab-paid-name">{{ translate('Top_ad_placement') }}</div>
                        <div class="ab-paid-desc">{{ translate('Your_ad_appears_at_the_top_of_the_page_for_maximum_visibility_and_increased_exposure_to_buyers.') }}</div>
                    </div>
                </div>
                <div class="ab-paid-card">
                    <div class="ab-paid-ico" style="background:#e8f5e9">🔍</div>
                    <div>
                        <div class="ab-paid-name">{{ translate('Highlighted_in_search') }}</div>
                        <div class="ab-paid-desc">{{ translate('Your_ad_is_visually_emphasized_in_search_results,_making_it_easier_for_buyers_to_notice_and_click.') }}</div>
                    </div>
                </div>
                <div class="ab-paid-card">
                    <div class="ab-paid-ico" style="background:#fff3e0">🎬</div>
                    <div>
                        <div class="ab-paid-name">{{ translate('Promotional_video') }}</div>
                        <div class="ab-paid-desc">{{ translate('Add_a_professional_video_to_present_your_product,_service,_or_business_in_an_engaging_way.') }}</div>
                    </div>
                </div>
                <div class="ab-paid-card">
                    <div class="ab-paid-ico" style="background:#fce4ec">🚨</div>
                    <div>
                        <div class="ab-paid-name">{{ translate('Urgent_sale_sticker') }}</div>
                        <div class="ab-paid-desc">{{ translate('Apply_an_"Urgent_Sale"_badge_to_highlight_time-sensitive_offers_and_encourage_faster_buyer_action.') }}</div>
                    </div>
                </div>
                <div class="ab-paid-card">
                    <div class="ab-paid-ico" style="background:#f3e5f5">🖼️</div>
                    <div>
                        <div class="ab-paid-name">{{ translate('Promotional_banner') }}</div>
                        <div class="ab-paid-desc">{{ translate('Upload_a_custom_banner_displayed_on_the_homepage_in_accordance_with_platform_advertising_guidelines.') }}</div>
                    </div>
                </div>
            </div>
            <div class="ab-note">⚠️ {{ translate('All_paid_services_are_completely_optional_and_not_required_to_use_the_platform_or_publish_advertisements._Fees_are_non-refundable_as_they_are_considered_fulfilled_upon_payment.') }}</div>
        </div>

        <hr class="ab-divider">

        {{-- WHAT WE OFFER --}}
        <div class="ab-section">
            <div class="ab-h2">{{ translate('What_we_offer') }}</div>
            <div class="ab-sub">{{ translate('Our_platform_is_built_on_five_core_principles_that_guide_everything_we_do.') }}</div>
            <ul class="ab-offer-list">
                <li class="ab-offer-li">
                    <div class="ab-offer-ico" style="background:#e8f5e9">🆓</div>
                    <div>
                        <div class="ab-offer-name">{{ translate('A_free_market_for_everyone') }}</div>
                        <div class="ab-offer-desc">{{ translate('Anyone_can_create_an_account_and_post_advertisements_for_vehicles,_spare_parts,_real_estate,_and_more_—_completely_free_of_charge._No_subscription,_no_commission,_no_payment_of_any_kind_required.') }}</div>
                    </div>
                </li>
                <li class="ab-offer-li">
                    <div class="ab-offer-ico" style="background:#e3f2fd">🌍</div>
                    <div>
                        <div class="ab-offer-name">{{ translate('Pan-European_reach') }}</div>
                        <div class="ab-offer-desc">{{ translate('We_bring_together_buyers_and_sellers_from_all_over_Europe,_enabling_cross-border_trading_opportunities_without_complexity._Your_ad_reaches_a_Europe-wide_audience_instantly_upon_publishing.') }}</div>
                    </div>
                </li>
                <li class="ab-offer-li">
                    <div class="ab-offer-ico" style="background:#fff8e1">⚡</div>
                    <div>
                        <div class="ab-offer-name">{{ translate('User-friendly_experience') }}</div>
                        <div class="ab-offer-desc">{{ translate('Our_platform_is_intuitive_and_fast,_making_posting,_browsing,_and_communicating_with_sellers_straightforward_and_enjoyable._Available_in_31_languages_for_a_seamless_multilingual_experience.') }}</div>
                    </div>
                </li>
                <li class="ab-offer-li">
                    <div class="ab-offer-ico" style="background:#fce4ec">🔒</div>
                    <div>
                        <div class="ab-offer-name">{{ translate('Security_first') }}</div>
                        <div class="ab-offer-desc">{{ translate('We_actively_monitor_listings_and_user_activity_to_maintain_a_safe,_trustworthy_environment_where_both_buyers_and_sellers_can_trade_with_full_confidence_and_peace_of_mind.') }}</div>
                    </div>
                </li>
                <li class="ab-offer-li">
                    <div class="ab-offer-ico" style="background:#f3e5f5">✅</div>
                    <div>
                        <div class="ab-offer-name">{{ translate('Full_transparency') }}</div>
                        <div class="ab-offer-desc">{{ translate('No_hidden_fees,_no_commissions,_no_surprises_—_just_a_clean,_open_marketplace_where_honesty_and_ease_come_first,_always._What_you_see_is_exactly_what_you_get.') }}</div>
                    </div>
                </li>
            </ul>
        </div>

        <hr class="ab-divider">

        {{-- HOW TO START --}}
        <div class="ab-section">
            <div class="ab-h2">{{ translate('How_to_get_started') }}</div>
            <div class="ab-sub">{{ translate('Four_simple_steps_to_start_buying_and_selling_across_Europe_—_takes_less_than_2_minutes_to_register.') }}</div>
            <div class="ab-steps">
                <div class="ab-step">
                    <div class="ab-step-n">1</div>
                    <div class="ab-step-name">{{ translate('Create_a_free_account') }}</div>
                    <div class="ab-step-desc">{{ translate('Visit_EuroBas.com_and_click_Register._Choose_between_a_personal_account_or_a_business_account._Enter_your_email_address_and_set_a_password.') }}</div>
                </div>
                <div class="ab-step">
                    <div class="ab-step-n">2</div>
                    <div class="ab-step-name">{{ translate('Complete_your_profile') }}</div>
                    <div class="ab-step-desc">{{ translate('Add_your_phone_number,_address,_and_preferred_language_to_unlock_ad_publishing_and_the_ability_to_contact_sellers_directly_and_securely.') }}</div>
                </div>
                <div class="ab-step">
                    <div class="ab-step-n">3</div>
                    <div class="ab-step-name">{{ translate('Publish_your_ad') }}</div>
                    <div class="ab-step-desc">{{ translate('List_any_item_with_photos,_a_full_description,_price,_and_location_—_completely_free_of_charge._Your_ad_goes_live_instantly_and_reaches_buyers_across_Europe.') }}</div>
                </div>
                <div class="ab-step">
                    <div class="ab-step-n">4</div>
                    <div class="ab-step-name">{{ translate('Connect_with_buyers') }}</div>
                    <div class="ab-step-desc">{{ translate('Receive_inquiries_and_communicate_directly_with_interested_buyers_across_Europe._Trade_confidently_in_your_own_language_or_theirs.') }}</div>
                </div>
            </div>
        </div>

        <hr class="ab-divider">

        {{-- VISION & COMMITMENT --}}
        <div class="ab-section">
            <div class="ab-h2">{{ translate('Our_vision_and_commitment') }}</div>
            <div class="ab-sub">{{ translate('We_are_committed_to_building_a_better,_more_connected_Europe_through_open,_free,_and_transparent_trade.') }}</div>
            <div class="ab-vision-grid">
                <div class="ab-vision">
                    <div class="ab-vision-ico">🎯</div>
                    <div class="ab-vision-name">{{ translate('Our_vision') }}</div>
                    <div class="ab-vision-desc">{{ translate('To_unify_the_automotive,_real_estate,_and_goods_market_across_Europe_—_creating_a_single_space_where_individuals_and_businesses_can_connect,_trade,_and_grow_without_limits,_borders,_or_fees.') }}</div>
                </div>
                <div class="ab-vision">
                    <div class="ab-vision-ico">🛡️</div>
                    <div class="ab-vision-name">{{ translate('GDPR_compliant') }}</div>
                    <div class="ab-vision-desc">{{ translate('Full_compliance_with_GDPR_regulations_to_protect_your_personal_data_and_ensure_your_privacy_at_all_times._Your_data_is_never_sold_or_shared_without_your_explicit_consent.') }}</div>
                </div>
                <div class="ab-vision">
                    <div class="ab-vision-ico">🚀</div>
                    <div class="ab-vision-name">{{ translate('Continuous_development') }}</div>
                    <div class="ab-vision-desc">{{ translate('We_continuously_develop_advanced_features_to_meet_the_evolving_needs_of_our_European_community_—_improving_speed,_reliability,_and_user_experience_every_day.') }}</div>
                </div>
            </div>
        </div>

        <hr class="ab-divider">

        {{-- LANGUAGES --}}
        <div class="ab-section">
            <div class="ab-h2">{{ translate('Available_in_31_languages') }}</div>
            <div class="ab-sub">{{ translate('Use_EuroBas_in_your_own_language_—_we_support_a_wide_range_of_European_and_international_languages_to_make_the_platform_accessible_to_everyone_across_the_globe.') }}</div>
            <div class="ab-langs">
                @foreach(['English','German','French','Spanish','Italian','Russian','Turkish','Arabic','Dutch','Greek','Romanian','Polish','Ukrainian','Bulgarian','Portuguese','Danish','Swedish','Norwegian','Finnish','Croatian','Hungarian','Czech','Albanian','Bosnian','Serbian','Lithuanian','Slovenian','Slovak','Chinese','Korean','Japanese'] as $lang)
                <span class="ab-lang">{{ translate($lang) }}</span>
                @endforeach
            </div>
        </div>

        <hr class="ab-divider">

        {{-- COMPANY INFO --}}
        <div class="ab-section">
            <div class="ab-h2">{{ translate('Company_information') }}</div>
            <div class="ab-sub">{{ translate('EuroBas_is_a_registered_company_based_in_the_Netherlands,_committed_to_fair_and_transparent_trade_across_Europe.') }}</div>
            <div class="ab-co">
                <div class="ab-co-row">
                    <div class="ab-co-lbl">🏢 {{ translate('Company_name') }}</div>
                    <div class="ab-co-val">EuroBas</div>
                </div>
                <div class="ab-co-row">
                    <div class="ab-co-lbl">📍 {{ translate('Headquarters') }}</div>
                    <div class="ab-co-val">{{ translate('Netherlands,_Europe') }}</div>
                </div>
                <div class="ab-co-row">
                    <div class="ab-co-lbl">🪪 {{ translate('Chamber_of_Commerce_(KvK)') }}</div>
                    <div class="ab-co-val">92808832</div>
                </div>
                <div class="ab-co-row">
                    <div class="ab-co-lbl">✉️ {{ translate('Contact_email') }}</div>
                    <div class="ab-co-val"><a href="mailto:info@eurobas.com" style="color:#1565c0;text-decoration:none;font-weight:700">info@eurobas.com</a></div>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div style="padding-bottom:3rem">
            <div class="ab-cta">
                <h2>{{ translate('Europe\'s_marketplace_without_borders') }}</h2>
                <p>{{ translate('Join_thousands_of_users_across_Europe_—_list_your_ads_today_and_trade_with_confidence,') }}<br>{{ translate('no_matter_where_you_are._Registration_is_free._Always.') }}</p>
                <a href="{{ route('ads-add') }}" class="ab-cta-btn">{{ translate('Post_your_first_ad_—_it\'s_completely_free') }}</a>
            </div>
        </div>

    </div>
</main>
@endsection
