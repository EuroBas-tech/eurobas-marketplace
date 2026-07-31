@extends('theme-views.layouts.app')

@section('title', translate('Terms_and_Conditions').' | '.$web_config['name']->value)

@push('css_or_js')
<meta property="og:image" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
<meta property="og:title" content="Terms & Conditions — EuroBas.com"/>
<meta property="og:url" content="{{env('APP_URL')}}">
<meta property="og:description" content="Read the terms and conditions for using EuroBas.com — Europe's unified marketplace.">
<style>
*{box-sizing:border-box}
.tc-hero{text-align:center;padding:4.5rem 1rem 3.5rem;background:linear-gradient(135deg,#0d3b8e 0%,#1565c0 50%,#1976d2 100%);color:#fff;position:relative;overflow:hidden}
.tc-hero::before{content:'';position:absolute;top:-80px;right:-80px;width:350px;height:350px;border-radius:50%;background:rgba(255,255,255,.04)}
.tc-hero::after{content:'';position:absolute;bottom:-100px;left:-60px;width:300px;height:300px;border-radius:50%;background:rgba(255,255,255,.03)}
.tc-badge{display:inline-block;background:rgba(255,255,255,.18);color:#fff;font-size:13px;padding:6px 18px;border-radius:25px;margin-bottom:1.5rem;font-weight:500;letter-spacing:.3px}
.tc-hero h1{font-size:2.6rem;font-weight:700;margin-bottom:1rem;position:relative;letter-spacing:-.5px}
.tc-hero-p{font-size:1.1rem;max-width:620px;margin:0 auto 2rem;opacity:.92;line-height:1.8;position:relative}

.tc-section{padding:3rem 0}
.tc-divider{border:none;border-top:1px solid #f0f0f0;margin:0}
.tc-h2{font-size:1.7rem;font-weight:700;color:#0d1b3e;margin-bottom:.5rem}
.tc-sub{font-size:1rem;color:#666;margin-bottom:2rem;line-height:1.7;max-width:680px}

.tc-card{background:#fff;border:1px solid #eaecf0;border-radius:16px;padding:1.75rem;margin-bottom:1.5rem;transition:all .25s ease}
.tc-card:hover{box-shadow:0 8px 24px rgba(0,0,0,.04);border-color:#c5cae9}
.tc-card-header{display:flex;align-items:center;gap:1rem;margin-bottom:1rem}
.tc-card-ico{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0}
.tc-card-title{font-size:1.15rem;font-weight:700;color:#0d1b3e;margin:0}
.tc-card-body{font-size:.9rem;color:#555;line-height:1.75}
.tc-card-body p{margin-bottom:.75rem}
.tc-card-body p:last-child{margin-bottom:0}
.tc-card-body ul{padding-left:1.25rem;margin-top:.5rem;margin-bottom:.75rem}
.tc-card-body li{margin-bottom:.4rem}

.tc-free{background:linear-gradient(135deg,#e8f5e9,#f1f8e9);border:1.5px solid #a5d6a7;border-radius:18px;padding:1.75rem 2rem;display:flex;align-items:center;gap:1.5rem;margin-bottom:2.5rem}
.tc-free-icon{width:56px;height:56px;background:#2e7d32;border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.6rem}
.tc-free-title{font-size:1.15rem;font-weight:700;color:#1b5e20;margin-bottom:4px}
.tc-free-desc{font-size:.9rem;color:#388e3c;line-height:1.6}

.tc-note{background:#fff8e1;border:1px solid #ffe082;border-radius:10px;padding:1rem 1.25rem;font-size:.85rem;color:#e65100;margin-top:1rem;line-height:1.6}

.tc-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:1.25rem}

.tc-co{background:#fff;border:1px solid #eaecf0;border-radius:16px;overflow:hidden}
.tc-co-row{display:flex;justify-content:space-between;align-items:center;padding:1rem 1.5rem;border-bottom:1px solid #f5f5f5}
.tc-co-row:last-child{border-bottom:none}
.tc-co-lbl{font-size:.88rem;color:#888}
.tc-co-val{font-size:.9rem;font-weight:700;color:#0d1b3e}

@media(max-width:600px){
    .tc-hero h1{font-size:1.9rem}
    .tc-free{flex-direction:column}
    .tc-card-header{flex-direction:column;align-items:flex-start;gap:.5rem}
}
</style>
@endpush

@section('content')
<main class="main-content">

    {{-- HERO --}}
    <div class="tc-hero">
        <div class="tc-badge">⚖️ Legal Information</div>
        <h1>Terms & Conditions</h1>
        <p class="tc-hero-p">Please read these terms carefully before using EuroBas.com. By accessing or using our platform, you agree to be bound by these terms.</p>
    </div>

    <div class="container">

        {{-- FREE & TRANSPARENT BANNER --}}
        <div class="tc-section">
            <div class="tc-free">
                <div class="tc-free-icon">📜</div>
                <div>
                    <div class="tc-free-title">Transparent & Fair Platform Guidelines</div>
                    <div class="tc-free-desc">EuroBas.com operates as a free, open marketplace designed to connect buyers and sellers across Europe fairly and transparently, adhering strictly to Dutch and European Union legal standards.</div>
                </div>
            </div>

            {{-- TERMS CONTENT --}}
            <div class="tc-h2">User Agreement</div>
            <div class="tc-sub">These terms govern your access to and use of EuroBas.com, including any content, functionality, and services offered on or through the platform.</div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#e3f2fd">1️⃣</div>
                    <h3 class="tc-card-title">Acceptance of Terms</h3>
                </div>
                <div class="tc-card-body">
                    <p>By registering an account, publishing an advertisement, or browsing EuroBas.com, you confirm that you have read, understood, and agreed to these Terms & Conditions. If you do not agree with any part of these terms, you must not use our services.</p>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#e8eaf6">2️⃣</div>
                    <h3 class="tc-card-title">User Accounts & Registration</h3>
                </div>
                <div class="tc-card-body">
                    <p>To access certain features of EuroBas.com, such as posting advertisements or contacting sellers, you must register for an account:</p>
                    <ul>
                        <li>You must provide accurate, current, and complete information during registration.</li>
                        <li>You are responsible for maintaining the confidentiality of your account credentials.</li>
                        <li>You may register as a personal user or a business user.</li>
                        <li>EuroBas reserves the right to suspend or terminate accounts that contain false or misleading information.</li>
                    </ul>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#fce4ec">3️⃣</div>
                    <h3 class="tc-card-title">Listing Rules & Content Guidelines</h3>
                </div>
                <div class="tc-card-body">
                    <p>When posting an advertisement on EuroBas.com, you agree to comply with the following content rules:</p>
                    <ul>
                        <li><strong>Accuracy:</strong> All descriptions, prices, photos, and item details must be truthful and accurate.</li>
                        <li><strong>Prohibited Items:</strong> Illegal goods, weapons, hazardous materials, counterfeit items, and offensive content are strictly prohibited.</li>
                        <li><strong>Duplication:</strong> Duplicate listings for the same item are not allowed and may be removed.</li>
                        <li><strong>Ownership:</strong> You must own or have the legal right to sell any item or service you list.</li>
                    </ul>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#e0f2f1">4️⃣</div>
                    <h3 class="tc-card-title">Free Core Services & Optional Paid Features</h3>
                </div>
                <div class="tc-card-body">
                    <p>EuroBas.com provides core marketplace features completely free of charge:</p>
                    <ul>
                        <li>Registering, listing items, and contacting sellers are 100% free with no commissions or hidden costs.</li>
                        <li>Users may optionally purchase promotional tools (e.g., Top Placement, Highlighted Ads, Urgent Badges, Banners) to increase visibility.</li>
                    </ul>
                    <div class="tc-note">
                        ⚠️ <strong>Refund Policy for Paid Services:</strong> Promotional paid services are considered fully executed upon activation. Therefore, all fees paid for optional promotional features are non-refundable once the service is rendered.
                    </div>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#fff3e0">5️⃣</div>
                    <h3 class="tc-card-title">Limitation of Liability & Transactions</h3>
                </div>
                <div class="tc-card-body">
                    <p>EuroBas.com acts solely as an online venue connecting buyers and sellers across Europe. EuroBas is not a party to any transaction between users:</p>
                    <ul>
                        <li>We do not guarantee the quality, safety, legality, or existence of items advertised.</li>
                        <li>We do not handle payments or escrow between buyers and sellers for advertised goods.</li>
                        <li>Users are solely responsible for verifying the authenticity of buyers or sellers and executing secure payments and delivery independently.</li>
                    </ul>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#ede7f6">6️⃣</div>
                    <h3 class="tc-card-title">Privacy & Data Protection (GDPR)</h3>
                </div>
                <div class="tc-card-body">
                    <p>Your privacy is important to us. All personal data collected through EuroBas.com is processed in accordance with the General Data Protection Regulation (GDPR) and applicable Dutch data protection laws. For detailed information, please review our <a href="{{ route('terms') }}" style="color:#1565c0;font-weight:700;text-decoration:none">Privacy Policy</a>.</p>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#fbe9e7">7️⃣</div>
                    <h3 class="tc-card-title">Applicable Law & Jurisdiction</h3>
                </div>
                <div class="tc-card-body">
                    <p>These Terms & Conditions are governed by and construed in accordance with the laws of the Netherlands. Any disputes arising out of or in connection with these terms shall be subject to the exclusive jurisdiction of the competent courts in the Netherlands.</p>
                </div>
            </div>

        </div>

        <hr class="tc-divider">

        {{-- COMPANY INFORMATION --}}
        <div class="tc-section">
            <div class="tc-h2">Legal Entity Information</div>
            <div class="tc-sub">For official inquiries regarding these Terms & Conditions, please reach out to our legal team using the details below.</div>
            
            <div class="tc-co">
                <div class="tc-co-row">
                    <div class="tc-co-lbl">🏢 Company name</div>
                    <div class="tc-co-val">EuroBas</div>
                </div>
                <div class="tc-co-row">
                    <div class="tc-co-lbl">📍 Registered Location</div>
                    <div class="tc-co-val">Netherlands, Europe</div>
                </div>
                <div class="tc-co-row">
                    <div class="tc-co-lbl">🪪 Chamber of Commerce (KvK)</div>
                    <div class="tc-co-val">92808832</div>
                </div>
                <div class="tc-co-row">
                    <div class="tc-co-lbl">✉️ Legal Enquiries</div>
                    <div class="tc-co-val"><a href="mailto:info@eurobas.com" style="color:#1565c0;text-decoration:none;font-weight:700">info@eurobas.com</a></div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
