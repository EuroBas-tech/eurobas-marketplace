@extends('theme-views.layouts.app')

@section('title', translate('Terms_&_Conditions').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@section('content')

<!-- Main Content -->
<main class="main-content d-flex flex-column gap-3 pb-3">
    <div class="page-title overlay py-5 __opacity-half background-custom-fit"
    @if ($page_title_banner)
        @if (\Illuminate\Support\Facades\Storage::disk()->exists('banner/'.json_decode($page_title_banner['value'])->image))
        data-bg-img="{{ cloudfront('banner/'.json_decode($page_title_banner['value'])->image) }}"
        @else
        data-bg-img="{{theme_asset('assets/img/media/page-title-bg.png')}}"
        @endif
    @else
        data-bg-img="{{theme_asset('assets/img/media/page-title-bg.png')}}"
    @endif
    >
        <div class="container">
            <h1 class="absolute-white text-center">{{translate('Terms_&_Conditions')}}</h1>
        </div>
    </div>
    
    <div class="container">
        <div class="card my-4 border-0 bg-transparent">
            <div class="card-body p-0 text-dark page-paragraph">
                
                <!-- بداية كود الشروط والأحكام الفاخر -->
                <style>
                    .terms-container {
                        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                        color: #2c3e50;
                        line-height: 1.7;
                        max-width: 1000px;
                        margin: 0 auto;
                    }
                    .terms-header {
                        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
                        color: #ffffff;
                        padding: 35px 30px;
                        border-radius: 16px;
                        margin-bottom: 30px;
                        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
                    }
                    .terms-header h2 {
                        margin: 0 0 10px 0;
                        font-size: 2rem;
                        font-weight: 700;
                        color: #ffffff;
                    }
                    .terms-header p {
                        margin: 0;
                        opacity: 0.85;
                        font-size: 0.95rem;
                    }
                    .terms-card {
                        background: #ffffff;
                        border: 1px solid #e2e8f0;
                        border-radius: 12px;
                        padding: 28px;
                        margin-bottom: 20px;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
                    }
                    .terms-card h3 {
                        color: #0f172a;
                        font-size: 1.25rem;
                        margin-top: 0;
                        margin-bottom: 16px;
                        font-weight: 600;
                        border-bottom: 2px solid #f1f5f9;
                        padding-bottom: 10px;
                    }
                    .terms-card ul {
                        padding-left: 20px;
                        margin-bottom: 0;
                    }
                    .terms-card li {
                        margin-bottom: 10px;
                        color: #475569;
                    }
                    .terms-card li:last-child {
                        margin-bottom: 0;
                    }
                    .warning-box {
                        background-color: #fff8f6;
                        border-left: 4px solid #ef4444;
                        padding: 20px;
                        border-radius: 8px;
                        margin-top: 15px;
                    }
                    .warning-box h4 {
                        color: #991b1b;
                        margin-top: 0;
                        margin-bottom: 10px;
                        font-size: 1.05rem;
                    }
                    .highlight-badge {
                        display: inline-block;
                        background-color: #e0f2fe;
                        color: #0369a1;
                        padding: 4px 12px;
                        border-radius: 20px;
                        font-size: 0.85rem;
                        font-weight: 600;
                        margin-top: 10px;
                    }
                    .contact-box {
                        background: #f8fafc;
                        border: 2px dashed #cbd5e1;
                        border-radius: 12px;
                        padding: 25px;
                        text-align: center;
                        margin-top: 30px;
                    }
                    .contact-box a {
                        color: #2563eb;
                        font-weight: 600;
                        text-decoration: none;
                    }
                </style>

                <div class="terms-container">
                    <div class="terms-header">
                        <h2>Terms & Conditions</h2>
                        <p>Welcome to <strong>EuroBas.com</strong> – Europe's Unified Vehicle Marketplace.</p>
                        <div style="margin-top: 12px; font-size: 0.85rem; opacity: 0.75;">
                            <strong>Effective Date:</strong> April 27, 2025 &nbsp;|&nbsp; <strong>Last Updated:</strong> April 27, 2025
                        </div>
                    </div>

                    <div class="terms-card">
                        <h3>1. Introduction & Overview</h3>
                        <p>By accessing or using <strong>EuroBas.com</strong>, you agree to strictly comply with and be bound by these Terms and Conditions. Our platform serves as an open digital marketplace designed to connect buyers and private or commercial sellers of used and new vehicles, commercial trucks, motorcycles, and spare parts across the European Union.</p>
                        <span class="highlight-badge">Advertising Space Provider Only</span>
                    </div>

                    <div class="terms-card">
                        <h3>2. Platform Functionality & Liability Limits</h3>
                        <ul>
                            <li><strong>Classifieds Platform Only:</strong> EuroBas.com operates purely as an advertising marketplace. We are not a commercial or financial intermediary between buyers and sellers.</li>
                            <li><strong>No Payment Processing:</strong> Payments for listed vehicles or items are not processed through the platform. We do not execute, handle, or monitor financial agreements.</li>
                            <li><strong>Zero Commissions:</strong> EuroBas.com takes no commission fees on completed sales or purchases, directly or indirectly.</li>
                            <li><strong>Direct User Contact:</strong> Interested clients contact advertisers directly outside the platform. We have no visibility or legal involvement in transactions.</li>
                            <li><strong>EU DAC7 Exemption:</strong> EuroBas.com is not subject to the EU DAC7 directive, as it does not facilitate, process, or execute monetary payments for sellers.</li>
                        </ul>
                    </div>

                    <div class="terms-card">
                        <h3>3. Posting Advertisements Policy</h3>
                        <p>To ensure a safe environment and combat fraud, all users must adhere strictly to these posting rules:</p>
                        <ul>
                            <li><strong>Ownership & Authorization:</strong> You must own the listed vehicle/product or have legal power of attorney to advertise it.</li>
                            <li><strong>Authentic Media & Data:</strong> Misleading details or unauthorized images taken from other websites are strictly forbidden.</li>
                            <li><strong>No External Communication Links:</strong> Adding external phone numbers or third-party links within the ad description to bypass platform controls is prohibited.</li>
                            <li><strong>Duplicate Listings:</strong> Posting the same advertisement multiple times to manipulate search rankings is not allowed.</li>
                            <li><strong>Commercial Usage:</strong> Personal accounts may not be utilized for organized dealer activities without explicit prior approval.</li>
                        </ul>
                        <p style="color: #dc2626; font-size: 0.9rem; margin-top: 10px; font-style: italic;">
                            * Note: Accounts posting fake or fraudulent ads will be permanently suspended without prior notice.
                        </p>
                    </div>

                    <div class="terms-card">
                        <h3>4. Prohibited Content</h3>
                        <p>It is strictly prohibited to publish advertisements that violate local or EU legal regulations, including but not limited to:</p>
                        <ul>
                            <li>Weapons, firearms, and dangerous items.</li>
                            <li>Controlled substances, drugs, or illegal items.</li>
                            <li>Counterfeit goods, non-homologated auto parts, or stolen vehicles.</li>
                        </ul>
                    </div>

                    <div class="terms-card">
                        <h3>5. Tax & Customs Compliance</h3>
                        <p>Users bear sole legal responsibility for identifying and complying with local and EU regulations regarding cross-border vehicle transactions, import/export duties, VAT, and customs fees. EuroBas.com provides no customs clearance or transportation services.</p>
                    </div>

                    <div class="terms-card">
                        <h3>6. Optional Paid Services</h3>
                        <p>EuroBas.com offers optional promotional packages (e.g., featuring ads on the homepage or highlighting search listings). Paid services are considered fully fulfilled immediately upon activation, and payments are non-refundable.</p>
                    </div>

                    <div class="terms-card">
                        <h3>7. Important Safety & Payment Disclaimer</h3>
                        <div class="warning-box">
                            <h4>⚠️ Safety Advice for Buyers & Sellers</h4>
                            <ul style="margin: 0; color: #7f1d1d;">
                                <li><strong>Never send wire transfers or advance deposits</strong> before verifying the identity of the seller and physically inspecting the vehicle.</li>
                                <li>Whenever possible, meet in safe, public places and ensure proper legal transfer documents are completed.</li>
                                <li>Avoid non-traceable payment methods.</li>
                                <li>EuroBas.com accepts no liability for financial loss, fraud, or disputes arising between users.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="terms-card">
                        <h3>8. Intellectual Property & Governing Law</h3>
                        <ul>
                            <li><strong>Intellectual Property:</strong> All trademarks, design codes, logos, and original written content remain the exclusive property of EuroBas.com.</li>
                            <li><strong>Legal Jurisdiction:</strong> These Terms and Conditions are governed by the laws of <strong>The Netherlands</strong>. Any disputes shall be settled exclusively within competent Dutch courts.</li>
                            <li><strong>Regulatory Cooperation:</strong> EuroBas.com fully cooperates with legal and tax authorities in full compliance with EU GDPR regulations.</li>
                        </ul>
                    </div>

                    <div class="contact-box">
                        <h4 style="margin-top:0; color: #0f172a;">Questions or Inquiries?</h4>
                        <p style="margin-bottom: 10px; color: #64748b;">If you need further clarification regarding our Terms & Conditions, please reach out to us:</p>
                        <a href="mailto:info@eurobas.com">📩 info@eurobas.com</a>
                    </div>
                </div>
                <!-- نهاية كود الشروط والأحكام -->

            </div>
        </div>
    </div>
</main>
<!-- End Main Content -->

@endsection
