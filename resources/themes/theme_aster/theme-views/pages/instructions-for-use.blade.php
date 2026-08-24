@extends('theme-views.layouts.app')

@section('title', translate('instructions_for_use').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@push('css_or_js')
<meta property="og:image" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
<meta property="og:title" content="How It Works — EuroBas.com"/>
<meta property="og:url" content="{{env('APP_URL')}}">
<meta property="og:description" content="Learn how EuroBas.com works — Europe's free multi-category classifieds marketplace for individuals and businesses. Unlimited posting, total privacy control, smart cross-border communication, and optional premium promotional features.">
<style>
*{box-sizing:border-box}
.tc-hero{text-align:center;padding:4.5rem 1rem 3.5rem;background:linear-gradient(135deg,#0d3b8e 0%,#1565c0 50%,#1976d2 100%);color:#fff;position:relative;overflow:hidden}
.tc-hero::before{content:'';position:absolute;top:-80px;right:-80px;width:350px;height:350px;border-radius:50%;background:rgba(255,255,255,.04)}
.tc-hero::after{content:'';position:absolute;bottom:-100px;left:-60px;width:300px;height:300px;border-radius:50%;background:rgba(255,255,255,.03)}
.tc-badge{display:inline-block;background:rgba(255,255,255,.18);color:#fff;font-size:13px;padding:6px 18px;border-radius:25px;margin-bottom:1.5rem;font-weight:500;letter-spacing:.3px}
.tc-hero h1{font-size:2.6rem;font-weight:700;margin-bottom:1rem;position:relative;letter-spacing:-.5px}
.tc-hero-p{font-size:1.05rem;max-width:780px;margin:0 auto 2rem;opacity:.92;line-height:1.8;position:relative}

.tc-section{padding:3rem 0}
.tc-divider{border:none;border-top:1px solid #f0f0f0;margin:0}
.tc-h2{font-size:1.7rem;font-weight:700;color:#0d1b3e;margin-bottom:.5rem}
.tc-sub{font-size:1rem;color:#666;margin-bottom:2rem;line-height:1.7;max-width:780px}

.tc-card{background:#fff;border:1px solid #eaecf0;border-radius:16px;padding:1.75rem;margin-bottom:1.5rem;transition:all .25s ease}
.tc-card:hover{box-shadow:0 8px 24px rgba(0,0,0,.04);border-color:#c5cae9}
.tc-card-header{display:flex;align-items:center;gap:1rem;margin-bottom:1rem}
.tc-card-ico{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0}
.tc-card-title{font-size:1.15rem;font-weight:700;color:#0d1b3e;margin:0}
.tc-card-body{font-size:.92rem;color:#444;line-height:1.75}
.tc-card-body p{margin-bottom:.75rem}
.tc-card-body p:last-child{margin-bottom:0}
.tc-card-body ul{padding-left:1.25rem;margin-top:.5rem;margin-bottom:.75rem}
.tc-card-body li{margin-bottom:.5rem}

.tc-free{background:linear-gradient(135deg,#e8f5e9,#f1f8e9);border:1.5px solid #a5d6a7;border-radius:18px;padding:1.75rem 2rem;display:flex;align-items:center;gap:1.5rem;margin-bottom:2.5rem}
.tc-free-icon{width:56px;height:56px;background:#2e7d32;color:#fff;border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.6rem}
.tc-free-title{font-size:1.15rem;font-weight:700;color:#1b5e20;margin-bottom:4px}
.tc-free-desc{font-size:.92rem;color:#2e7d32;line-height:1.6}

.tc-co{background:#fff;border:1px solid #eaecf0;border-radius:16px;overflow:hidden}
.tc-co-row{display:flex;justify-content:space-between;align-items:center;padding:1rem 1.5rem;border-bottom:1px solid #f5f5f5}
.tc-co-row:last-child{border-bottom:none}
.tc-co-lbl{font-size:.88rem;color:#888}
.tc-co-val{font-size:.9rem;font-weight:700;color:#0d1b3e}

@media(max-width:600px){
    .tc-hero h1{font-size:1.9rem}
    .tc-free{flex-direction:column}
    .tc-card-header{flex-direction:column;align-items:flex-start;gap:.5rem}
    .tc-co-row{flex-direction:column;align-items:flex-start;gap:.25rem}
}
</style>
@endpush

@section('content')
<main class="main-content">

    {{-- HERO --}}
    <div class="tc-hero">
        <div class="tc-badge">💡 User Guide & Platform Instructions</div>
        <h1>How EuroBas.com Works</h1>
        <p class="tc-hero-p">Discover how easy it is to buy, sell, and connect across Europe and globally. EuroBas.com is designed for both individuals and professional businesses with zero fees and maximum convenience.</p>
    </div>

    <div class="container">

        {{-- FREE BANNER --}}
        <div class="tc-section">
            <div class="tc-free">
                <div class="tc-free-icon">🚀</div>
                <div>
                    <div class="tc-free-title">100% Free Marketplace — Unlimited Experience</div>
                    <div class="tc-free-desc">
                        Enjoy full access to EuroBas.com without any costs. Registering accounts, contacting sellers, and publishing unlimited listings are 100% free with no hidden charges, commissions, or subscription requirements.
                    </div>
                </div>
            </div>

            <div class="tc-h2">1. Seamless Browsing & Fast Registration</div>
            <div class="tc-sub">Get started effortlessly whether you are exploring listings or creating your account.</div>

            {{-- STEP 1 --}}
            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#e3f2fd">🔍</div>
                    <h3 class="tc-card-title">Step 1: Browse & Explore Without Boundaries</h3>
                </div>
                <div class="tc-card-body">
                    <p>Any visitor can freely browse and search EuroBas.com without registering or logging in:</p>
                    <ul>
                        <li>Explore thousands of active listings across <strong>20 comprehensive categories</strong> (Vehicles, Real Estate, Electronics, Services, Jobs, and more).</li>
                        <li>Filter listings by region, country, price range, condition, or specific keywords natively translated across <strong>31 fully supported static languages</strong>.</li>
                    </ul>
                </div>
            </div>

            {{-- STEP 2 --}}
            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#e8eaf6">👤</div>
                    <h3 class="tc-card-title">Step 2: Quick Registration & Account Types</h3>
                </div>
                <div class="tc-card-body">
                    <p>When you are ready to post an ad or interact with sellers, signing up takes only a few seconds:</p>
                    <ul>
                        <li><strong>Social Login:</strong> Register or log in with one click using your existing <strong>Google</strong>, <strong>Facebook</strong>, or <strong>Apple</strong> account, or sign up with your email and password.</li>
                        <li><strong>Account Type Choice:</strong> Select between an <em>Individual (Private) Account</em> or a <em>Commercial (Business/Dealer) Account</em>.
                            <br><small style="color:#666">* Both account types are completely free with full access to all features. This selection simply displays your status on your listings to provide transparency to prospective buyers.</small>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- STEP 3 --}}
            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#e0f2f1">🛡️</div>
                    <h3 class="tc-card-title">Step 3: Instant Access & Full Privacy Control</h3>
                </div>
                <div class="tc-card-body">
                    <p>Start posting listings immediately after sign-up. You have total flexibility over how you share your details:</p>
                    <ul>
                        <li><strong>Flexible Privacy Controls:</strong> You have full control over your personal data. You can choose whether to display or hide your phone number and email address publicly on your listings or public profile.</li>
                        <li><strong>Integrated On-Platform Messaging:</strong> If you prefer to keep your contact details private, buyers can easily contact you through EuroBas's secure built-in chat system.</li>
                    </ul>
                </div>
            </div>

            {{-- STEP 4 --}}
            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#fff3e0">🏪</div>
                    <h3 class="tc-card-title">Step 4: Dedicated Seller Profile Page (Your Own Storefront)</h3>
                </div>
                <div class="tc-card-body">
                    <p>Every seller on EuroBas.com automatically gets a personalized profile page that acts as their own online storefront:</p>
                    <ul>
                        <li>Customize your profile with a personal avatar, company logo, and a custom wall/cover banner image.</li>
                        <li>Add business descriptions, company information, and select your preferred native language.</li>
                        <li>Showcase all your current listings in one dedicated space with built-in search and filter tools for your visitors.</li>
                    </ul>
                </div>
            </div>

            {{-- STEP 5 --}}
            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#fce4ec">📢</div>
                    <h3 class="tc-card-title">Step 5: Post Unlimited Ads & Connect Directly</h3>
                </div>
                <div class="tc-card-body">
                    <p>Start publishing your items or services to reach buyers across Europe and worldwide:</p>
                    <ul>
                        <li><strong>Unlimited Postings:</strong> Publish as many listings as you want, completely free of charge.</li>
                        <li><strong>Direct Communication:</strong> Buyers and sellers connect directly via phone, WhatsApp, or internal messaging with zero intermediary interference or commission fees.</li>
                    </ul>
                </div>
            </div>

            {{-- NEW SECTION: CROSS-BORDER SMART MESSAGING --}}
            <div class="tc-h2">2. Smart Cross-Border Communication & Language Support</div>
            <div class="tc-sub">EuroBas makes European and global trading effortless across borders and languages.</div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#e1f5fe">🌍</div>
                    <h3 class="tc-card-title">Automated Language Smart-Routing</h3>
                </div>
                <div class="tc-card-body">
                    <p>EuroBas provides seamless communication between buyers and sellers in different countries:</p>
                    <ul>
                        <li><strong>Native Language Preferences:</strong> Each user can set their native language in their profile.</li>
                        <li><strong>Same-Language Conversations:</strong> If both users share the same native language (e.g., two users from Germany), offers and messages are delivered in their native language.</li>
                        <li><strong>Cross-Border Intelligent Fallback:</strong> If two users speak different native languages (e.g., a buyer from France and a seller from Germany), the platform automatically delivers offers and notifications in English to ensure clear mutual understanding.</li>
                        <li><strong>31 Native Languages:</strong> The platform natively supports 31 fully localized languages for seamless site navigation and interface interaction.</li>
                    </ul>
                </div>
            </div>

            {{-- NEW SECTION: OPTIONAL PREMIUM PROMOTIONAL FEATURES --}}
            <div class="tc-h2">3. Optional Premium Promotional Add-ons</div>
            <div class="tc-sub">Boost your business visibility and maximize your sales potential with our paid promotional add-ons.</div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#fff8e1">⭐</div>
                    <h3 class="tc-card-title">Maximize Your Exposure & Sales</h3>
                </div>
                <div class="tc-card-body">
                    <p>While posting ads is 100% free, businesses and sellers looking for maximum engagement can unlock optional promotional tools:</p>
                    <ul>
                        <li><strong>Homepage Promotional Banners:</strong> Businesses and individual sellers can publish custom promotional banner advertisements that appear directly on the EuroBas homepage.</li>
                        <li><strong>Promotional Showcase Videos:</strong> Add promotional video showcases to your listings or products to captivate buyers and increase engagement.</li>
                        <li><strong>Top Homepage Placement:</strong> Boost your listings to appear at the very top of the homepage and search results for maximum exposure.</li>
                        <li><strong>High-Visibility Badges:</strong> Highlight your listing with distinguished high-visibility badges to stand out from competing items.</li>
                    </ul>
                </div>
            </div>

            {{-- SAFETY TIPS --}}
            <div class="tc-h2">4. Safety Guidelines for Buyers & Sellers</div>
            <div class="tc-sub">Follow these essential security recommendations to ensure safe transactions across the platform.</div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#ffebee">🔒</div>
                    <h3 class="tc-card-title">Best Practices for Safe Trading</h3>
                </div>
                <div class="tc-card-body">
                    <ul>
                        <li><strong>Inspect Before Paying:</strong> Always inspect items or meet in person in safe public places before making any payments.</li>
                        <li><strong>Avoid Advance Deposit Requests:</strong> Never send advance deposits or wire money prior to receiving and verifying the product or service.</li>
                        <li><strong>Verify Details:</strong> Review seller profile details, listing descriptions, and photos carefully before finalizing agreements.</li>
                    </ul>
                </div>
            </div>

        </div>

        <hr class="tc-divider">

        {{-- SUMMARY & CONTACT --}}
        <div class="tc-section">
            <div class="tc-h2">Need Assistance?</div>
            <div class="tc-sub">If you have any questions or need technical support while using EuroBas.com, our support team is always ready to assist you.</div>
            
            <div class="tc-co">
                <div class="tc-co-row">
                    <div class="tc-co-lbl">🌐 Platform Name</div>
                    <div class="tc-co-val">EuroBas.com</div>
                </div>
                <div class="tc-co-row">
                    <div class="tc-co-lbl">📍 Operating Location</div>
                    <div class="tc-co-val">Netherlands, Europe</div>
                </div>
                <div class="tc-co-row">
                    <div class="tc-co-lbl">🪪 Registration (KvK)</div>
                    <div class="tc-co-val">92808832</div>
                </div>
                <div class="tc-co-row">
                    <div class="tc-co-lbl">✉️ Customer Support Email</div>
                    <div class="tc-co-val"><a href="mailto:info@eurobas.com" style="color:#1565c0;text-decoration:none;font-weight:700">info@eurobas.com</a></div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
