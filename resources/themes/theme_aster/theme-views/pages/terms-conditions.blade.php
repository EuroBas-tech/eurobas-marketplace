@extends('theme-views.layouts.app')

@section('title', translate('Terms_and_Conditions').' | '.$web_config['name']->value)

@push('css_or_js')
<meta property="og:image" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
<meta property="og:title" content="Terms & Conditions — EuroBas.com"/>
<meta property="og:url" content="{{env('APP_URL')}}">
<meta property="og:description" content="Read the terms and conditions for using EuroBas.com — Europe's unified vehicles marketplace.">
<style>
*{box-sizing:border-box}
.tc-hero{text-align:center;padding:4.5rem 1rem 3.5rem;background:linear-gradient(135deg,#0d3b8e 0%,#1565c0 50%,#1976d2 100%);color:#fff;position:relative;overflow:hidden}
.tc-hero::before{content:'';position:absolute;top:-80px;right:-80px;width:350px;height:350px;border-radius:50%;background:rgba(255,255,255,.04)}
.tc-hero::after{content:'';position:absolute;bottom:-100px;left:-60px;width:300px;height:300px;border-radius:50%;background:rgba(255,255,255,.03)}
.tc-badge{display:inline-block;background:rgba(255,255,255,.18);color:#fff;font-size:13px;padding:6px 18px;border-radius:25px;margin-bottom:1.5rem;font-weight:500;letter-spacing:.3px}
.tc-hero h1{font-size:2.6rem;font-weight:700;margin-bottom:1rem;position:relative;letter-spacing:-.5px}
.tc-hero-p{font-size:1.05rem;max-width:720px;margin:0 auto 2rem;opacity:.92;line-height:1.8;position:relative}

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

.tc-warning-box{background:#fff3e0;border:1.5px solid #ffe082;border-radius:16px;padding:1.75rem 2rem;margin-bottom:2.5rem}
.tc-warning-title{font-size:1.15rem;font-weight:700;color:#e65100;margin-bottom:.75rem;display:flex;align-items:center;gap:.5rem}
.tc-warning-body{font-size:.92rem;color:#bf360c;line-height:1.7}
.tc-warning-body ul{padding-left:1.25rem;margin-top:.5rem;margin-bottom:0}
.tc-warning-body li{margin-bottom:.4rem}

.tc-note{background:#fff8e1;border:1px solid #ffe082;border-radius:10px;padding:1rem 1.25rem;font-size:.88rem;color:#e65100;margin-top:1rem;line-height:1.6}

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
        <div class="tc-badge">⚖️ Legal & Operating Guidelines</div>
        <h1>Terms & Conditions</h1>
        <p class="tc-hero-p">Effective Date: <strong>04-27-2025</strong> | Last Updated: <strong>04/27/2025</strong><br>
        Welcome to EuroBas.com — Europe’s Unified Vehicle Marketplace. Buy and sell all types of vehicles across Europe with ease.</p>
    </div>

    <div class="container">

        {{-- INTRODUCTION BANNER --}}
        <div class="tc-section">
            <div class="tc-free">
                <div class="tc-free-icon">🚗</div>
                <div>
                    <div class="tc-free-title">Introduction and Company Rules</div>
                    <div class="tc-free-desc">
                        Whether you’re listing a used or new car, truck, motorcycle, or commercial vehicle, EuroBas.com connects private sellers and dealers with interested buyers in one centralized, easy-to-use marketplace. Post your ad for free and reach a European-wide audience today.
                    </div>
                </div>
            </div>

            <div class="tc-h2">1. Terms Agreement & Platform Scope</div>
            <div class="tc-sub">By using our platform, you agree to comply with these Terms and Conditions. Our goal is to provide a safe and reliable environment for buying and selling vehicles, spare parts, and related products across Europe.</div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#e3f2fd">🌐</div>
                    <h3 class="tc-card-title">Digital Advertising Space</h3>
                </div>
                <div class="tc-card-body">
                    <p><strong>EuroBas.com</strong> is an open digital marketplace for publishing advertisements related to the sale and purchase of used/new vehicles and spare parts within the European Union. The platform provides advertising space to users and is not a party to any transaction.</p>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#e8eaf6">2️⃣</div>
                    <h3 class="tc-card-title">Platform Functionality & Liability Limits</h3>
                </div>
                <div class="tc-card-body">
                    <ul>
                        <li><strong>Classifieds Venue Only:</strong> The platform operates solely as a classifieds marketplace and is not a financial or commercial intermediary between the buyer and seller.</li>
                        <li><strong>No Platform Payments:</strong> Payments are not made through the platform, and it does not execute or monitor any transaction or agreement.</li>
                        <li><strong>Zero Commissions:</strong> The platform does not receive any commission from sales or purchases, whether directly or indirectly.</li>
                        <li><strong>Direct Contact:</strong> Users are responsible for posting their own ads, and interested clients contact advertisers directly outside the platform.</li>
                        <li><strong>No Deal Tracking:</strong> The platform has no knowledge of whether a transaction is completed and bears no legal or financial responsibility.</li>
                        <li><strong>User Responsibility:</strong> Users are fully responsible for the accuracy of the ad content, the credibility of other parties, and any resulting obligations.</li>
                        <li><strong>EU DAC7 Exemption:</strong> The platform is not subject to the EU DAC7 directive, as it does not facilitate or execute transactions or participate in any payment process.</li>
                    </ul>
                </div>
            </div>

            {{-- POSTING ADS POLICY --}}
            <div class="tc-h2">Posting Ads Policy</div>
            <div class="tc-sub">Guidelines to ensure community safety, prevent fraud, and maintain quality listings.</div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#fff3e0">2.1</div>
                    <h3 class="tc-card-title">Important Notice Before Posting an Ad</h3>
                </div>
                <div class="tc-card-body">
                    <p>To ensure the safety of our community and protect you from fraud, please adhere to the following rules before publishing any advertisement:</p>
                    <ul>
                        <li>The vehicle or item listed must be owned by you or you must be authorized to advertise it.</li>
                        <li>Posting false or misleading advertisements is strictly prohibited.</li>
                        <li>It is not allowed to use images taken from the internet or from other ads without explicit permission.</li>
                        <li>Adding external phone numbers or links to other websites for off-platform communication within the description is forbidden.</li>
                        <li>Accounts found posting fraudulent ads will be immediately suspended without prior notice.</li>
                        <li>We work diligently to protect our users by automatically and manually reviewing suspicious advertisements.</li>
                    </ul>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#e0f2f1">2.2</div>
                    <h3 class="tc-card-title">Platform and Ads Usage Policy</h3>
                </div>
                <div class="tc-card-body">
                    <ul>
                        <li>All advertisements must be genuine and represent an actual vehicle or product available for sale.</li>
                        <li>Publishing fake ads or ads intended to collect users’ information is strictly prohibited.</li>
                        <li>Reposting the same advertisement multiple times to gain visibility is not allowed.</li>
                        <li>Personal accounts must not be used for organized commercial activities without prior approval from EuroBas.com.</li>
                        <li>EuroBas.com reserves the right to delete or suspend any ad without prior notice if a violation or suspicious activity is suspected.</li>
                        <li>All transactions are conducted directly between users. EuroBas.com is not responsible for any financial dealings between parties but provides tools to help minimize risks.</li>
                        <li>We encourage all users to report any suspicious content or activities to help maintain a safe and professional environment.</li>
                    </ul>
                </div>
            </div>

            {{-- GENERAL TERMS & LEGAL CLAUSES --}}
            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#fce4ec">3️⃣</div>
                    <h3 class="tc-card-title">Legal Disclaimer</h3>
                </div>
                <div class="tc-card-body">
                    <p>EuroBas.com is not responsible for the accuracy or authenticity of ads posted by users. Users are solely responsible for the information they publish and for any damages or losses resulting from their transactions.</p>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#ede7f6">4️⃣ & 11</div>
                    <h3 class="tc-card-title">Amendments to Terms</h3>
                </div>
                <div class="tc-card-body">
                    <p>We reserve the right to modify or update these Terms and Conditions at any time without prior notice. Updates will be announced through the platform, and continued use of the platform constitutes acceptance of the revised terms.</p>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#e8f5e9">5️⃣</div>
                    <h3 class="tc-card-title">Intellectual Property Rights</h3>
                </div>
                <div class="tc-card-body">
                    <p>All rights related to the platform and its content (including text, images, designs, and trademarks) are reserved to EuroBas.com and may not be used without prior written permission.</p>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#f3e5f5">6️⃣</div>
                    <h3 class="tc-card-title">Tax and Customs Regulations</h3>
                </div>
                <div class="tc-card-body">
                    <ul>
                        <li>Users must comply with local and EU laws regarding taxes, customs, import, and export.</li>
                        <li>The platform does not offer shipping or customs clearance services and assumes no liability for related processes.</li>
                        <li>Users are solely responsible for identifying and fulfilling any tax or customs obligations related to their transactions.</li>
                    </ul>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#e0f7fa">7️⃣</div>
                    <h3 class="tc-card-title">Paid Ads and Optional Services</h3>
                </div>
                <div class="tc-card-body">
                    <p>The platform offers additional paid services, such as:</p>
                    <ul>
                        <li>Featuring ads on the homepage.</li>
                        <li>Highlighting ads in search results.</li>
                        <li>Monthly or annual subscription plans with added features.</li>
                    </ul>
                    <p>These services are optional and not mandatory.</p>
                    <div class="tc-note">
                        ⚠️ <strong>Refund Policy:</strong> Users are not entitled to a refund for any paid service, as they are considered fulfilled upon payment.
                    </div>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#ffebee">8️⃣</div>
                    <h3 class="tc-card-title">Prohibited Content</h3>
                </div>
                <div class="tc-card-body">
                    <p>It is strictly forbidden to publish or advertise any products or services that violate EU or local laws, including but not limited to:</p>
                    <ul>
                        <li>Weapons</li>
                        <li>Controlled substances or drugs</li>
                        <li>Animals (where prohibited by law)</li>
                        <li>Counterfeit or illegal goods</li>
                    </ul>
                    <p>The platform reserves the right to remove any violating content without prior notice. Repeat violations may result in account suspension.</p>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#fbe9e7">9️⃣ & 10</div>
                    <h3 class="tc-card-title">Cooperation with Authorities & Data Privacy (GDPR)</h3>
                </div>
                <div class="tc-card-body">
                    <ul>
                        <li><strong>Cooperation:</strong> If tax or legal authorities request user information, the platform will cooperate in accordance with the law and GDPR regulations.</li>
                        <li><strong>GDPR Compliance:</strong> The platform complies with the General Data Protection Regulation (GDPR).</li>
                        <li><strong>User Control:</strong> Users can modify or delete their data at any time directly through their profile without contacting the administration.</li>
                    </ul>
                </div>
            </div>

            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-ico" style="background:#e8eaf6">12</div>
                    <h3 class="tc-card-title">Applicable Law & Jurisdiction</h3>
                </div>
                <div class="tc-card-body">
                    <p>These terms are governed by Dutch law. In the event of a dispute, the courts of the Netherlands shall have jurisdiction.</p>
                </div>
            </div>

            {{-- IMPORTANT PAYMENT DISCLAIMER --}}
            <div class="tc-warning-box">
                <div class="tc-warning-title">
                    <span>⚠️ Important Disclaimer on Payments</span>
                </div>
                <div class="tc-warning-body">
                    <p>EuroBas.com is a classifieds platform only and does not participate in or monitor any financial transactions between users. All users, especially buyers, are strongly advised to exercise extreme caution when engaging in transactions. Please follow these important guidelines:</p>
                    <ul>
                        <li>Do not send any money or make advance payments (such as deposits) before verifying the identity and credibility of the seller.</li>
                        <li>Always try to inspect the item in person or use a trusted third party before proceeding with any payment.</li>
                        <li>Prefer to meet in safe, public locations and ensure all transactions are documented.</li>
                        <li>Avoid using untraceable or non-secure payment methods.</li>
                    </ul>
                    <p style="margin-top:.75rem">Any payment, agreement, or transaction is done entirely at the user’s own risk. EuroBas.com shall not be held liable for any loss, fraud, or dispute arising from user-to-user transactions. By using the platform, you acknowledge and accept full responsibility for your interactions and payments.</p>
                </div>
            </div>

        </div>

        <hr class="tc-divider">

        {{-- ACCEPTANCE & CONTACT --}}
        <div class="tc-section">
            <div class="tc-h2">Your Acceptance & Contact Information</div>
            <div class="tc-sub">By using this website, you agree to these Terms & Conditions and the associated policies. If you do not agree, please refrain from using the platform.</div>
            
            <div class="tc-co">
                <div class="tc-co-row">
                    <div class="tc-co-lbl">🏢 Platform Name</div>
                    <div class="tc-co-val">EuroBas.com</div>
                </div>
                <div class="tc-co-row">
                    <div class="tc-co-lbl">📍 Location / Law</div>
                    <div class="tc-co-val">Netherlands, Europe (Dutch Law)</div>
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
                    <div class="tc-co-lbl">📅 Last Updated</div>
                    <div class="tc-co-val">04/27/2025</div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
