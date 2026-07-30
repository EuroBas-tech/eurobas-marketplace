@extends('theme-views.layouts.app')

@section('title', translate('About_Us').' | '.$web_config['name']->value)

@push('css_or_js')
<meta property="og:image" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
<meta property="og:title" content="About EuroBas.com"/>
<meta property="og:url" content="{{env('APP_URL')}}">
<meta property="og:description" content="Europe's unified marketplace for vehicles, real estate, boats, furniture and more.">
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
.ab-cat{background:#fff;border:1px solid #eaecf0;border-radius:16px;padding:1.5rem 1.25rem;text-align:center;transition:all .25s ease}
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
.ab-step{background:#fff;border:1px solid #eaecf0;border-radius:16px;padding:1.75rem 1.5rem}
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
        <div class="ab-badge">🌍 {{ translate('europes_unified_free_marketplace') }}</div>
        <h1>EuroBas.com</h1>
        <p class="ab-hero-p">{{ translate('about_hero_description') }}</p>
        <div class="ab-stats">
            <div><div class="ab-stat-num">31</div><div class="ab-stat-lbl">{{ translate('languages') }}</div></div>
            <div><div class="ab-stat-num">100%</div><div class="ab-stat-lbl">{{ translate('free_to_use') }}</div></div>
            <div><div class="ab-stat-num">20+</div><div class="ab-stat-lbl">{{ translate('categories') }}</div></div>
            <div><div class="ab-stat-num">€0</div><div class="ab-stat-lbl">{{ translate('hidden_fees') }}</div></div>
        </div>
    </div>

    <div class="container">

        {{-- FREE BANNER --}}
        <div class="ab-section">
            <div class="ab-free">
                <div class="ab-free-icon">✅</div>
                <div>
                    <div class="ab-free-title">{{ translate('about_free_title') }}</div>
                    <div class="ab-free-desc">{{ translate('about_free_desc') }}</div>
                </div>
            </div>

            {{-- CATEGORIES --}}
            <div class="ab-h2">{{ translate('about_categories_title') }}</div>
            <div class="ab-sub">{{ translate('about_categories_sub') }}</div>
            <div class="ab-cats">
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#e3f2fd">🚗</div><div class="ab-cat-name">{{ translate('Cars') }}</div><div class="ab-cat-desc">{{ translate('about_cat_cars_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#e8eaf6">🏎️</div><div class="ab-cat-name">{{ translate('Supercars') }}</div><div class="ab-cat-desc">{{ translate('about_cat_supercars_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#fce4ec">🏛️</div><div class="ab-cat-name">{{ translate('Classic_Cars') }}</div><div class="ab-cat-desc">{{ translate('about_cat_classic_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#e0f2f1">🚚</div><div class="ab-cat-name">{{ translate('Trucks') }}</div><div class="ab-cat-desc">{{ translate('about_cat_trucks_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#fff3e0">🏍️</div><div class="ab-cat-name">{{ translate('Motorcycles') }}</div><div class="ab-cat-desc">{{ translate('about_cat_motorcycles_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#f3e5f5">🚌</div><div class="ab-cat-name">{{ translate('Buses') }}</div><div class="ab-cat-desc">{{ translate('about_cat_buses_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#e8f5e9">🚐</div><div class="ab-cat-name">{{ translate('Caravans') }}</div><div class="ab-cat-desc">{{ translate('about_cat_caravans_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#e0f7fa">🏕️</div><div class="ab-cat-name">{{ translate('Motorhomes') }}</div><div class="ab-cat-desc">{{ translate('about_cat_motorhomes_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#fff8e1">🚜</div><div class="ab-cat-name">{{ translate('Agricultural_machinery') }}</div><div class="ab-cat-desc">{{ translate('about_cat_agri_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#fbe9e7">🚵</div><div class="ab-cat-name">{{ translate('Bicycles') }}</div><div class="ab-cat-desc">{{ translate('about_cat_bicycles_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#ede7f6">🔧</div><div class="ab-cat-name">{{ translate('Spare_parts') }}</div><div class="ab-cat-desc">{{ translate('about_cat_spareparts_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#e8f5e9">🎿</div><div class="ab-cat-name">{{ translate('Vehicle_Accessories') }}</div><div class="ab-cat-desc">{{ translate('about_cat_accessories_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#e3f2fd">🏠</div><div class="ab-cat-name">{{ translate('Real_Estate') }}</div><div class="ab-cat-desc">{{ translate('about_cat_realestate_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#e0f7fa">⚓</div><div class="ab-cat-name">{{ translate('Ships_Yachts') }}</div><div class="ab-cat-desc">{{ translate('about_cat_boats_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#fff3e0">🪑</div><div class="ab-cat-name">{{ translate('Furniture') }}</div><div class="ab-cat-desc">{{ translate('about_cat_furniture_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#fce4ec">🌿</div><div class="ab-cat-name">{{ translate('Home_Garden') }}</div><div class="ab-cat-desc">{{ translate('about_cat_garden_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#f3e5f5">📺</div><div class="ab-cat-name">{{ translate('Electronics') }}</div><div class="ab-cat-desc">{{ translate('about_cat_electronics_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#e8f5e9">🍳</div><div class="ab-cat-name">{{ translate('Home_Appliances') }}</div><div class="ab-cat-desc">{{ translate('about_cat_appliances_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#e3f2fd">⚙️</div><div class="ab-cat-name">{{ translate('Industrial_Machines') }}</div><div class="ab-cat-desc">{{ translate('about_cat_industrial_desc') }}</div></div>
                <div class="ab-cat"><div class="ab-cat-ico" style="background:#e0f2f1">🏗️</div><div class="ab-cat-name">{{ translate('Heavy_Equipment') }}</div><div class="ab-cat-desc">{{ translate('about_cat_heavy_desc') }}</div></div>
            </div>
        </div>

        <hr class="ab-divider">

        {{-- OPTIONAL PAID SERVICES --}}
        <div class="ab-section">
            <div class="ab-h2">{{ translate('about_paid_title') }}</div>
            <div class="ab-sub">{{ translate('about_paid_sub') }}</div>
            <div class="ab-paid-grid">
                <div class="ab-paid-card"><div class="ab-paid-ico" style="background:#e3f2fd">📌</div><div><div class="ab-paid-name">{{ translate('about_paid_top_title') }}</div><div class="ab-paid-desc">{{ translate('about_paid_top_desc') }}</div></div></div>
                <div class="ab-paid-card"><div class="ab-paid-ico" style="background:#e8f5e9">🔍</div><div><div class="ab-paid-name">{{ translate('about_paid_search_title') }}</div><div class="ab-paid-desc">{{ translate('about_paid_search_desc') }}</div></div></div>
                <div class="ab-paid-card"><div class="ab-paid-ico" style="background:#fff3e0">🎬</div><div><div class="ab-paid-name">{{ translate('about_paid_video_title') }}</div><div class="ab-paid-desc">{{ translate('about_paid_video_desc') }}</div></div></div>
                <div class="ab-paid-card"><div class="ab-paid-ico" style="background:#fce4ec">🚨</div><div><div class="ab-paid-name">{{ translate('about_paid_urgent_title') }}</div><div class="ab-paid-desc">{{ translate('about_paid_urgent_desc') }}</div></div></div>
                <div class="ab-paid-card"><div class="ab-paid-ico" style="background:#f3e5f5">🖼️</div><div><div class="ab-paid-name">{{ translate('about_paid_banner_title') }}</div><div class="ab-paid-desc">{{ translate('about_paid_banner_desc') }}</div></div></div>
            </div>
            <div class="ab-note">⚠️ {{ translate('about_paid_note') }}</div>
        </div>

        <hr class="ab-divider">

        {{-- WHAT WE OFFER --}}
        <div class="ab-section">
            <div class="ab-h2">{{ translate('about_offer_title') }}</div>
            <div class="ab-sub">{{ translate('about_offer_sub') }}</div>
            <ul class="ab-offer-list">
                <li class="ab-offer-li"><div class="ab-offer-ico" style="background:#e8f5e9">🆓</div><div><div class="ab-offer-name">{{ translate('about_offer_free_title') }}</div><div class="ab-offer-desc">{{ translate('about_offer_free_desc') }}</div></div></li>
                <li class="ab-offer-li"><div class="ab-offer-ico" style="background:#e3f2fd">🌍</div><div><div class="ab-offer-name">{{ translate('about_offer_reach_title') }}</div><div class="ab-offer-desc">{{ translate('about_offer_reach_desc') }}</div></div></li>
                <li class="ab-offer-li"><div class="ab-offer-ico" style="background:#fff8e1">⚡</div><div><div class="ab-offer-name">{{ translate('about_offer_ux_title') }}</div><div class="ab-offer-desc">{{ translate('about_offer_ux_desc') }}</div></div></li>
                <li class="ab-offer-li"><div class="ab-offer-ico" style="background:#fce4ec">🔒</div><div><div class="ab-offer-name">{{ translate('about_offer_security_title') }}</div><div class="ab-offer-desc">{{ translate('about_offer_security_desc') }}</div></div></li>
                <li class="ab-offer-li"><div class="ab-offer-ico" style="background:#f3e5f5">✅</div><div><div class="ab-offer-name">{{ translate('about_offer_transparency_title') }}</div><div class="ab-offer-desc">{{ translate('about_offer_transparency_desc') }}</div></div></li>
            </ul>
        </div>

        <hr class="ab-divider">

        {{-- HOW TO START --}}
        <div class="ab-section">
            <div class="ab-h2">{{ translate('about_steps_title') }}</div>
            <div class="ab-sub">{{ translate('about_steps_sub') }}</div>
            <div class="ab-steps">
                <div class="ab-step"><div class="ab-step-n">1</div><div class="ab-step-name">{{ translate('about_step1_title') }}</div><div class="ab-step-desc">{{ translate('about_step1_desc') }}</div></div>
                <div class="ab-step"><div class="ab-step-n">2</div><div class="ab-step-name">{{ translate('about_step2_title') }}</div><div class="ab-step-desc">{{ translate('about_step2_desc') }}</div></div>
                <div class="ab-step"><div class="ab-step-n">3</div><div class="ab-step-name">{{ translate('about_step3_title') }}</div><div class="ab-step-desc">{{ translate('about_step3_desc') }}</div></div>
                <div class="ab-step"><div class="ab-step-n">4</div><div class="ab-step-name">{{ translate('about_step4_title') }}</div><div class="ab-step-desc">{{ translate('about_step4_desc') }}</div></div>
            </div>
        </div>

        <hr class="ab-divider">

        {{-- VISION --}}
        <div class="ab-section">
            <div class="ab-h2">{{ translate('about_vision_title') }}</div>
            <div class="ab-sub">{{ translate('about_vision_sub') }}</div>
            <div class="ab-vision-grid">
                <div class="ab-vision"><div class="ab-vision-ico">🎯</div><div class="ab-vision-name">{{ translate('about_vision_1_title') }}</div><div class="ab-vision-desc">{{ translate('about_vision_1_desc') }}</div></div>
                <div class="ab-vision"><div class="ab-vision-ico">🛡️</div><div class="ab-vision-name">{{ translate('about_vision_2_title') }}</div><div class="ab-vision-desc">{{ translate('about_vision_2_desc') }}</div></div>
                <div class="ab-vision"><div class="ab-vision-ico">🚀</div><div class="ab-vision-name">{{ translate('about_vision_3_title') }}</div><div class="ab-vision-desc">{{ translate('about_vision_3_desc') }}</div></div>
            </div>
        </div>

        <hr class="ab-divider">

        {{-- LANGUAGES --}}
        <div class="ab-section">
            <div class="ab-h2">{{ translate('about_languages_title') }}</div>
            <div class="ab-sub">{{ translate('about_languages_sub') }}</div>
            <div class="ab-langs">
                @foreach(['English','Deutsch','Français','Español','Italiano','Русский','Türkçe','العربية','Nederlands','Ελληνικά','Română','Polski','Українська','Български','Português','Dansk','Svenska','Norsk','Suomi','Hrvatski','Magyar','Čeština','Shqip','Bosanski','Srpski','Lietuvių','Slovenščina','Slovenčina','中文','한국어','日本語'] as $lang)
                <span class="ab-lang">{{ $lang }}</span>
                @endforeach
            </div>
        </div>

        <hr class="ab-divider">

        {{-- COMPANY INFO --}}
        <div class="ab-section">
            <div class="ab-h2">{{ translate('about_company_title') }}</div>
            <div class="ab-sub">{{ translate('about_company_sub') }}</div>
            <div class="ab-co">
                <div class="ab-co-row"><div class="ab-co-lbl">🏢 {{ translate('about_company_name') }}</div><div class="ab-co-val">EuroBas</div></div>
                <div class="ab-co-row"><div class="ab-co-lbl">📍 {{ translate('about_company_country') }}</div><div class="ab-co-val">{{ translate('Netherlands') }}, Europe</div></div>
                <div class="ab-co-row"><div class="ab-co-lbl">🪪 {{ translate('about_company_kvk') }}</div><div class="ab-co-val">92808832</div></div>
                <div class="ab-co-row"><div class="ab-co-lbl">✉️ {{ translate('about_company_email') }}</div><div class="ab-co-val"><a href="mailto:info@eurobas.com" style="color:#1565c0;text-decoration:none;font-weight:700">info@eurobas.com</a></div></div>
            </div>
        </div>

        {{-- CTA --}}
        <div style="padding-bottom:3rem">
            <div class="ab-cta">
                <h2>{{ translate('about_cta_title') }}</h2>
                <p>{{ translate('about_cta_desc') }}</p>
                <a href="{{ route('ads-add') }}" class="ab-cta-btn">{{ translate('about_cta_btn') }}</a>
            </div>
        </div>

    </div>
</main>
@endsection
