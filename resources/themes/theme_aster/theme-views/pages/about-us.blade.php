@extends('theme-views.layouts.app')

@section('title', translate('About_Us').' | '.$web_config['name']->value)

@push('css_or_js')
<meta property="og:image" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
<meta property="og:title" content="About EuroBas.com — Europe's Unified Marketplace"/>
<meta property="og:url" content="{{env('APP_URL')}}">
<meta property="og:description" content="Europe's unified marketplace for vehicles, real estate, boats, furniture and more. Free to use, available in 31 languages.">
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
        <div class="ab-badge">🌍 Europe's Unified Free Marketplace</div>
        <h1>EuroBas.com</h1>
        <p class="ab-hero-p">A free, borderless digital marketplace connecting buyers and sellers across Europe — available in 31 languages, with zero fees and zero hidden costs. Buy and sell anything, anywhere in Europe.</p>
        <div class="ab-stats">
            <div><div class="ab-stat-num">31</div><div class="ab-stat-lbl">Languages</div></div>
            <div><div class="ab-stat-num">100%</div><div class="ab-stat-lbl">Free to use</div></div>
            <div><div class="ab-stat-num">20+</div><div class="ab-stat-lbl">Categories</div></div>
            <div><div class="ab-stat-num">€0</div><div class="ab-stat-lbl">Hidden fees</div></div>
        </div>
    </div>

    <div class="container">

        {{-- FREE BANNER --}}
        <div class="ab-section">
            <div class="ab-free">
                <div class="ab-free-icon">✅</div>
                <div>
                    <div class="ab-free-title">Always free — register, post, and contact sellers at no cost</div>
                    <div class="ab-free-desc">No subscriptions. No commissions. No hidden fees. EuroBas.com will always remain free to register, free to publish ads, and free to contact sellers. No payment is required to use the core features of the platform.</div>
                </div>
            </div>

            {{-- CATEGORIES --}}
            <div class="ab-h2">Everything you can buy & sell on EuroBas</div>
            <div class="ab-sub">From cars to real estate, boats to electronics — one unified platform for all categories across Europe.</div>
            <div class="ab-cats">

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e3f2fd">🚗</div>
                    <div class="ab-cat-name">Cars</div>
                    <div class="ab-cat-desc">New and used cars of all makes and models across Europe.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e8eaf6">🏎️</div>
                    <div class="ab-cat-name">Supercars</div>
                    <div class="ab-cat-desc">Premium and exotic supercars from top European and international brands.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#fce4ec">🏛️</div>
                    <div class="ab-cat-name">Classic Cars</div>
                    <div class="ab-cat-desc">Vintage and classic automobiles for collectors and enthusiasts.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e0f2f1">🚚</div>
                    <div class="ab-cat-name">Trucks</div>
                    <div class="ab-cat-desc">Light, medium and heavy-duty trucks for commercial use.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#fff3e0">🏍️</div>
                    <div class="ab-cat-name">Motorcycles</div>
                    <div class="ab-cat-desc">Sport bikes, cruisers, scooters and off-road motorcycles.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#f3e5f5">🚌</div>
                    <div class="ab-cat-name">Buses</div>
                    <div class="ab-cat-desc">Passenger buses, minibuses and coaches for sale across Europe.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e8f5e9">🚐</div>
                    <div class="ab-cat-name">Caravans</div>
                    <div class="ab-cat-desc">Touring caravans and camper trailers for leisure travel.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e0f7fa">🏕️</div>
                    <div class="ab-cat-name">Motorhomes</div>
                    <div class="ab-cat-desc">Self-contained motorhomes and camper vans for the open road.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#fff8e1">🚜</div>
                    <div class="ab-cat-name">Agricultural Machinery</div>
                    <div class="ab-cat-desc">Tractors, harvesters, irrigation equipment and farm tools.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#fbe9e7">🚵</div>
                    <div class="ab-cat-name">Bicycles</div>
                    <div class="ab-cat-desc">Road, mountain, electric and cargo bicycles for all riders.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#ede7f6">🔧</div>
                    <div class="ab-cat-name">Spare Parts</div>
                    <div class="ab-cat-desc">Vehicle spare parts, accessories, tires, rims and tools.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e8f5e9">🎿</div>
                    <div class="ab-cat-name">Vehicle Accessories</div>
                    <div class="ab-cat-desc">Car care products, navigation, audio systems and accessories.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e3f2fd">🏠</div>
                    <div class="ab-cat-name">Real Estate</div>
                    <div class="ab-cat-desc">Apartments, houses, villas, land and commercial properties for sale or rent.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e0f7fa">⚓</div>
                    <div class="ab-cat-name">Ships & Yachts</div>
                    <div class="ab-cat-desc">Private and commercial boats, yachts, marine equipment and accessories.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#fff3e0">🪑</div>
                    <div class="ab-cat-name">Furniture</div>
                    <div class="ab-cat-desc">Indoor, outdoor, office furniture, sofas, beds and dining sets.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#fce4ec">🌿</div>
                    <div class="ab-cat-name">Home & Garden</div>
                    <div class="ab-cat-desc">Garden tools, outdoor furniture, plants and home decoration.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#f3e5f5">📺</div>
                    <div class="ab-cat-name">Electronics</div>
                    <div class="ab-cat-desc">TVs, smartphones, computers, cameras and smart home devices.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e8f5e9">🍳</div>
                    <div class="ab-cat-name">Home Appliances</div>
                    <div class="ab-cat-desc">Kitchen appliances, washing machines, refrigerators and more.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e3f2fd">⚙️</div>
                    <div class="ab-cat-name">Industrial Machines</div>
                    <div class="ab-cat-desc">Manufacturing equipment, CNC machines, forklifts and heavy tools.</div>
                </div>

                <div class="ab-cat">
                    <div class="ab-cat-ico" style="background:#e0f2f1">🏗️</div>
                    <div class="ab-cat-name">Heavy Equipment</div>
                    <div class="ab-cat-desc">Construction machinery, excavators, cranes and bulldozers.</div>
                </div>

            </div>
        </div>

        <hr class="ab-divider">

        {{-- OPTIONAL PAID SERVICES --}}
        <div class="ab-section">
            <div class="ab-h2">Optional paid services</div>
            <div class="ab-sub">Boost your ad's visibility with optional promotional tools — none are required to use the platform or publish ads.</div>
            <div class="ab-paid-grid">
                <div class="ab-paid-card">
                    <div class="ab-paid-ico" style="background:#e3f2fd">📌</div>
                    <div>
                        <div class="ab-paid-name">Top ad placement</div>
                        <div class="ab-paid-desc">Your ad appears at the top of the page for maximum visibility and increased exposure to buyers.</div>
                    </div>
                </div>
                <div class="ab-paid-card">
                    <div class="ab-paid-ico" style="background:#e8f5e9">🔍</div>
                    <div>
                        <div class="ab-paid-name">Highlighted in search</div>
                        <div class="ab-paid-desc">Your ad is visually emphasized in search results, making it easier for buyers to notice and click.</div>
                    </div>
                </div>
                <div class="ab-paid-card">
                    <div class="ab-paid-ico" style="background:#fff3e0">🎬</div>
                    <div>
                        <div class="ab-paid-name">Promotional video</div>
                        <div class="ab-paid-desc">Add a professional video to present your product, service, or business in an engaging way.</div>
                    </div>
                </div>
                <div class="ab-paid-card">
                    <div class="ab-paid-ico" style="background:#fce4ec">🚨</div>
                    <div>
                        <div class="ab-paid-name">Urgent sale sticker</div>
                        <div class="ab-paid-desc">Apply an "Urgent Sale" badge to highlight time-sensitive offers and encourage faster buyer action.</div>
                    </div>
                </div>
                <div class="ab-paid-card">
                    <div class="ab-paid-ico" style="background:#f3e5f5">🖼️</div>
                    <div>
                        <div class="ab-paid-name">Promotional banner</div>
                        <div class="ab-paid-desc">Upload a custom banner displayed on the homepage in accordance with platform advertising guidelines.</div>
                    </div>
                </div>
            </div>
            <div class="ab-note">⚠️ All paid services are completely optional and not required to use the platform or publish advertisements. Fees are non-refundable as they are considered fulfilled upon payment.</div>
        </div>

        <hr class="ab-divider">

        {{-- WHAT WE OFFER --}}
        <div class="ab-section">
            <div class="ab-h2">What we offer</div>
            <div class="ab-sub">Our platform is built on five core principles that guide everything we do.</div>
            <ul class="ab-offer-list">
                <li class="ab-offer-li">
                    <div class="ab-offer-ico" style="background:#e8f5e9">🆓</div>
                    <div>
                        <div class="ab-offer-name">A free market for everyone</div>
                        <div class="ab-offer-desc">Anyone can create an account and post advertisements for vehicles, spare parts, real estate, and more — completely free of charge. No subscription, no commission, no payment of any kind required.</div>
                    </div>
                </li>
                <li class="ab-offer-li">
                    <div class="ab-offer-ico" style="background:#e3f2fd">🌍</div>
                    <div>
                        <div class="ab-offer-name">Pan-European reach</div>
                        <div class="ab-offer-desc">We bring together buyers and sellers from all over Europe, enabling cross-border trading opportunities without complexity. Your ad reaches a Europe-wide audience instantly upon publishing.</div>
                    </div>
                </li>
                <li class="ab-offer-li">
                    <div class="ab-offer-ico" style="background:#fff8e1">⚡</div>
                    <div>
                        <div class="ab-offer-name">User-friendly experience</div>
                        <div class="ab-offer-desc">Our platform is intuitive and fast, making posting, browsing, and communicating with sellers straightforward and enjoyable. Available in 31 languages for a seamless multilingual experience.</div>
                    </div>
                </li>
                <li class="ab-offer-li">
                    <div class="ab-offer-ico" style="background:#fce4ec">🔒</div>
                    <div>
                        <div class="ab-offer-name">Security first</div>
                        <div class="ab-offer-desc">We actively monitor listings and user activity to maintain a safe, trustworthy environment where both buyers and sellers can trade with full confidence and peace of mind.</div>
                    </div>
                </li>
                <li class="ab-offer-li">
                    <div class="ab-offer-ico" style="background:#f3e5f5">✅</div>
                    <div>
                        <div class="ab-offer-name">Full transparency</div>
                        <div class="ab-offer-desc">No hidden fees, no commissions, no surprises — just a clean, open marketplace where honesty and ease come first, always. What you see is exactly what you get.</div>
                    </div>
                </li>
            </ul>
        </div>

        <hr class="ab-divider">

        {{-- HOW TO START --}}
        <div class="ab-section">
            <div class="ab-h2">How to get started</div>
            <div class="ab-sub">Four simple steps to start buying and selling across Europe — takes less than 2 minutes to register.</div>
            <div class="ab-steps">
                <div class="ab-step">
                    <div class="ab-step-n">1</div>
                    <div class="ab-step-name">Create a free account</div>
                    <div class="ab-step-desc">Visit EuroBas.com and click Register. Choose between a personal account or a business account. Enter your email address and set a password.</div>
                </div>
                <div class="ab-step">
                    <div class="ab-step-n">2</div>
                    <div class="ab-step-name">Start instantly</div>
                    <div class="ab-step-desc">No complicated setups. Once registered, your account is immediately ready to browse listings, post ads, and start trading across Europe.</div>
                </div>
                <div class="ab-step">
                    <div class="ab-step-n">3</div>
                    <div class="ab-step-name">Publish your ad</div>
                    <div class="ab-step-desc">List any item with photos, a full description, price, and location — completely free of charge. Your ad goes live instantly and reaches buyers across Europe.</div>
                </div>
                <div class="ab-step">
                    <div class="ab-step-n">4</div>
                    <div class="ab-step-name">Connect with buyers</div>
                    <div class="ab-step-desc">Receive inquiries and communicate directly with interested buyers across Europe. Trade confidently in your own language or theirs.</div>
                </div>
            </div>
        </div>

        <hr class="ab-divider">

        {{-- VISION & COMMITMENT --}}
        <div class="ab-section">
            <div class="ab-h2">Our vision and commitment</div>
            <div class="ab-sub">We are committed to building a better, more connected Europe through open, free, and transparent trade.</div>
            <div class="ab-vision-grid">
                <div class="ab-vision">
                    <div class="ab-vision-ico">🎯</div>
                    <div class="ab-vision-name">Our vision</div>
                    <div class="ab-vision-desc">To unify the automotive, real estate, and goods market across Europe — creating a single space where individuals and businesses can connect, trade, and grow without limits, borders, or fees.</div>
                </div>
                <div class="ab-vision">
                    <div class="ab-vision-ico">🛡️</div>
                    <div class="ab-vision-name">GDPR compliant</div>
                    <div class="ab-vision-desc">Full compliance with GDPR regulations to protect your personal data and ensure your privacy at all times. Your data is never sold or shared without your explicit consent.</div>
                </div>
                <div class="ab-vision">
                    <div class="ab-vision-ico">🚀</div>
                    <div class="ab-vision-name">Continuous development</div>
                    <div class="ab-vision-desc">We continuously develop advanced features to meet the evolving needs of our European community — improving speed, reliability, and user experience every day.</div>
                </div>
            </div>
        </div>

        <hr class="ab-divider">

        {{-- LANGUAGES --}}
        <div class="ab-section">
            <div class="ab-h2">Available in 31 languages</div>
            <div class="ab-sub">Use EuroBas in your own language — we support a wide range of European and international languages to make the platform accessible to everyone across the globe.</div>
            <div class="ab-langs">
                @foreach(['English','German','French','Spanish','Italian','Russian','Turkish','Arabic','Dutch','Greek','Romanian','Polish','Ukrainian','Bulgarian','Portuguese','Danish','Swedish','Norwegian','Finnish','Croatian','Hungarian','Czech','Albanian','Bosnian','Serbian','Lithuanian','Slovenian','Slovak','Chinese','Korean','Japanese'] as $lang)
                <span class="ab-lang">{{ $lang }}</span>
                @endforeach
            </div>
        </div>

        <hr class="ab-divider">

        {{-- COMPANY INFO --}}
        <div class="ab-section">
            <div class="ab-h2">Company information</div>
            <div class="ab-sub">EuroBas is a registered company based in the Netherlands, committed to fair and transparent trade across Europe.</div>
            <div class="ab-co">
                <div class="ab-co-row">
                    <div class="ab-co-lbl">🏢 Company name</div>
                    <div class="ab-co-val">EuroBas</div>
                </div>
                <div class="ab-co-row">
                    <div class="ab-co-lbl">📍 Headquarters</div>
                    <div class="ab-co-val">Netherlands, Europe</div>
                </div>
                <div class="ab-co-row">
                    <div class="ab-co-lbl">🪪 Chamber of Commerce (KvK)</div>
                    <div class="ab-co-val">92808832</div>
                </div>
                <div class="ab-co-row">
                    <div class="ab-co-lbl">✉️ Contact email</div>
                    <div class="ab-co-val"><a href="mailto:info@eurobas.com" style="color:#1565c0;text-decoration:none;font-weight:700">info@eurobas.com</a></div>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div style="padding-bottom:3rem">
            <div class="ab-cta">
                <h2>Europe's marketplace without borders</h2>
                <p>Join thousands of users across Europe — list your ads today and trade with confidence,<br>no matter where you are. Registration is free. Always.</p>
                <a href="{{ route('ads-add') }}" class="ab-cta-btn">Post your first ad — it's completely free</a>
            </div>
        </div>

    </div>
</main>
@endsection
