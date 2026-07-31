@extends('theme-views.layouts.app')

@section('title', translate('Privacy_Policy').' | '.$web_config['name']->value)

@push('css_or_js')
<meta property="og:image" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
<meta property="og:title" content="Privacy Policy — EuroBas.com"/>
<meta property="og:url" content="{{env('APP_URL')}}">
<meta property="og:description" content="Read the Privacy Policy for EuroBas.com — Europe's free multi-category classifieds marketplace. Fully compliant with EU GDPR regulations.">
<style>
*{box-sizing:border-box}
.tc-hero{text-align:center;padding:4.5rem 1rem 3.5rem;background:linear-gradient(135deg,#0d3b8e 0%,#1565c0 50%,#1976d2 100%);color:#fff;position:relative;overflow:hidden}
.tc-hero::before{content:'';position:absolute;top:-80px;right:-80px;width:350px;height:350px;border-radius:50%;background:rgba(255,255,255,.04)}
.tc-hero::after{content:'';position:absolute;bottom:-100px;left:-60px;width:300px;height:300px;border-radius:50%;background:rgba(255,255,255,.03)}
.tc-badge{display:inline-block;background:rgba(255,255,255,.18);color:#fff;font-size:13px;padding:6px 18px;border-radius:25px;margin-bottom:1.5rem;font-weight:500;letter-spacing:.3px}
.tc-hero h1{font-size:2.6rem;font-weight:700;margin-bottom:1rem;position:relative;letter-spacing:-.5px}
.tc-hero-p{font-size:1.05rem;max-width:750px;margin:0 auto 2rem;opacity:.92;line-height:1.8;position:relative}

.tc-section{padding:3rem 0}
.tc-divider{border:none;border-top:1px solid #f0f0f0;margin:0}
.tc-h2{font-size:1.7rem;font-weight:700;color:#0d1b3e;margin-bottom:.5rem}
.tc-sub{font-size:1rem;color:#666;margin-bottom:2rem;line-height:1.7;max-width:750px}

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
        <div class="tc-badge">🔒 GDPR Compliant & User Protection</div>
        <h1>Privacy Policy</h1>
        <p class="tc-hero-p">Effective Date: <strong>04-27-2025</strong> | Last Updated: <strong>04/27/2025</strong><br>
        Welcome to EuroBas.com. We place the highest importance on protecting your privacy and personal data. Our commitment is based on transparency, security, and respect for all our users’ rights.</p>
    </div>

    <div class="container">

        {{-- INTRODUCTION BANNER --}}
        <div class="tc-section">
            <div class="tc-free">
                <div class="tc-free-icon">🛡️</div>
                <div>
                    <div class="tc-free-title">Our Commitment to Data Protection</div>
                    <div class="tc-free-desc">
                        We fully comply with the European General Data Protection Regulation (GDPR), ensuring the highest standards of privacy and security across all 31 supported languages and European jurisdictions.
                    </div>
                </div>
            </div>

            <div class="tc-h2">1. Collection and Use of Data</div>
            <div class="tc-sub">Understanding how we handle your information to deliver a seamless classifieds marketplace experience.</div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#e3f2fd">📥</div>
                    <h3 class="tc-card-title">Information We Collect</h3>
                </div>
                <div class="tc-card-body">
                    <p>We collect only the necessary information required to improve your experience and facilitate your use of the platform, including:</p>
                    <ul>
                        <li><strong>Contact Details:</strong> Basic account information such as your name, email address, and phone number when registered.</li>
                        <li><strong>Advertisement Information:</strong> Listings, descriptions, images, and category details you choose to publish on the marketplace.</li>
                        <li><strong>Usage Patterns:</strong> Technical interaction data and device preferences to optimize platform performance.</li>
                    </ul>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#e8eaf6">⚙️</div>
                    <h3 class="tc-card-title">How Your Data is Used</h3>
                </div>
                <div class="tc-card-body">
                    <ul>
                        <li>Your information is used solely to deliver our services effectively, personalize your experience, and enhance platform performance.</li>
                        <li><strong>No Data Selling:</strong> We do not sell, rent, or share your personal data with third parties without your explicit consent, except as required by applicable laws.</li>
                        <li>Direct communication between buyers and sellers is initiated at the user's discretion outside platform tracking.</li>
                    </ul>
                </div>
            </div>

            {{-- USER RIGHTS & DATA SECURITY --}}
            <div class="tc-h2">2. User Rights & Data Protection</div>
            <div class="tc-sub">Full transparency and total control over your personal account and stored records.</div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#e0f2f1">👤</div>
                    <h3 class="tc-card-title">User Rights & Account Control</h3>
                </div>
                <div class="tc-card-body">
                    <ul>
                        <li>You have full rights to access, modify, or update your personal data at any time.</li>
                        <li><strong>Instant Account Deletion:</strong> You can permanently delete your account at any time directly through your account settings without providing any justification or needing prior approval.</li>
                        <li>We provide easy-to-use self-service tools inside your profile to manage your privacy preferences effortlessly.</li>
                    </ul>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#fff3e0">🔐</div>
                    <h3 class="tc-card-title">Data Security Standards</h3>
                </div>
                <div class="tc-card-body">
                    <p>We apply the latest security technologies, encrypted connection protocols, and organizational procedures to protect your personal information against unauthorized access, loss, alteration, or disclosure.</p>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#fce4ec">📝</div>
                    <h3 class="tc-card-title">Policy Updates & Notice</h3>
                </div>
                <div class="tc-card-body">
                    <p>We may update this Privacy Policy from time to time to align with legal requirements or operational improvements. Any significant changes will be communicated to you appropriately through the platform.</p>
                </div>
            </div>

        </div>

        <hr class="tc-divider">

        {{-- ACCEPTANCE & CONTACT --}}
        <div class="tc-section">
            <div class="tc-h2">Contact Us & Legal Details</div>
            <div class="tc-sub">By using EuroBas.com, you acknowledge that you have read and agree to this Privacy Policy. If you have any questions regarding your personal data, please contact us.</div>
            
            <div class="tc-co">
                <div class="tc-co-row">
                    <div class="tc-co-lbl">🏢 Platform Name</div>
                    <div class="tc-co-val">EuroBas.com</div>
                </div>
                <div class="tc-co-row">
                    <div class="tc-co-lbl">📍 Location / Law</div>
                    <div class="tc-co-val">Netherlands, Europe (Dutch & EU Law)</div>
                </div>
                <div class="tc-co-row">
                    <div class="tc-co-lbl">🪪 Chamber of Commerce (KvK)</div>
                    <div class="tc-co-val">92808832</div>
                </div>
                <div class="tc-co-row">
                    <div class="tc-co-lbl">✉️ Contact Email</div>
                    <div class="tc-co-val"><a href="mailto:info@eurobas.com" style="color:#1565c0;text-decoration:none;font-weight:700">info@eurobas.com</a></div>
                </div>
                <div class="tc-co-row">
                    <div class="tc-co-lbl">📅 Effective Date</div>
                    <div class="tc-co-val">04/27/2025</div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
