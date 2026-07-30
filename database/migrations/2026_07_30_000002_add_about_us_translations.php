<?php

use Illuminate\Database\Migrations\Migration;

class AddAboutUsTranslations extends Migration
{
    public function up()
    {
        $translations = [
            'europes_unified_free_marketplace' => "Europe's Unified Free Marketplace",
            'about_hero_description' => "A free, borderless digital marketplace connecting buyers and sellers across Europe — available in 31 languages, with zero fees and zero hidden costs. Buy and sell anything, anywhere in Europe.",
            'about_free_title' => "Always free — register, post, and contact sellers at no cost",
            'about_free_desc' => "No subscriptions. No commissions. No hidden fees. EuroBas.com will always remain free to register, free to publish ads, and free to contact sellers. No payment is required to use the core features of the platform.",
            'about_categories_title' => "Everything you can buy & sell on EuroBas",
            'about_categories_sub' => "From cars to real estate, boats to electronics — one unified platform for all categories across Europe.",
            'about_cat_cars_desc' => "New and used cars of all makes and models across Europe.",
            'about_cat_supercars_desc' => "Premium and exotic supercars from top European and international brands.",
            'about_cat_classic_desc' => "Vintage and classic automobiles for collectors and enthusiasts.",
            'about_cat_trucks_desc' => "Light, medium and heavy-duty trucks for commercial use.",
            'about_cat_motorcycles_desc' => "Sport bikes, cruisers, scooters and off-road motorcycles.",
            'about_cat_buses_desc' => "Passenger buses, minibuses and coaches for sale across Europe.",
            'about_cat_caravans_desc' => "Touring caravans and camper trailers for leisure travel.",
            'about_cat_motorhomes_desc' => "Self-contained motorhomes and camper vans for the open road.",
            'about_cat_agri_desc' => "Tractors, harvesters, irrigation equipment and farm tools.",
            'about_cat_bicycles_desc' => "Road, mountain, electric and cargo bicycles for all riders.",
            'about_cat_spareparts_desc' => "Vehicle spare parts, accessories, tires, rims and tools.",
            'about_cat_accessories_desc' => "Car care products, navigation, audio systems and accessories.",
            'about_cat_realestate_desc' => "Apartments, houses, villas, land and commercial properties for sale or rent.",
            'about_cat_boats_desc' => "Private and commercial boats, yachts, marine equipment and accessories.",
            'about_cat_furniture_desc' => "Indoor, outdoor, office furniture, sofas, beds and dining sets.",
            'about_cat_garden_desc' => "Garden tools, outdoor furniture, plants and home decoration.",
            'about_cat_electronics_desc' => "TVs, smartphones, computers, cameras and smart home devices.",
            'about_cat_appliances_desc' => "Kitchen appliances, washing machines, refrigerators and more.",
            'about_cat_industrial_desc' => "Manufacturing equipment, CNC machines, forklifts and heavy tools.",
            'about_cat_heavy_desc' => "Construction machinery, excavators, cranes and bulldozers.",
            'about_paid_title' => "Optional paid services",
            'about_paid_sub' => "Boost your ad's visibility with optional promotional tools — none are required to use the platform or publish ads.",
            'about_paid_top_title' => "Top ad placement",
            'about_paid_top_desc' => "Your ad appears at the top of the page for maximum visibility and increased exposure to buyers.",
            'about_paid_search_title' => "Highlighted in search",
            'about_paid_search_desc' => "Your ad is visually emphasized in search results, making it easier for buyers to notice.",
            'about_paid_video_title' => "Promotional video",
            'about_paid_video_desc' => "Add a professional video to present your product or business in an engaging way.",
            'about_paid_urgent_title' => "Urgent sale sticker",
            'about_paid_urgent_desc' => "Apply an Urgent Sale badge to highlight time-sensitive offers and encourage faster buyer action.",
            'about_paid_banner_title' => "Promotional banner",
            'about_paid_banner_desc' => "Upload a custom banner displayed on the homepage per platform advertising guidelines.",
            'about_paid_note' => "All paid services are completely optional and not required to use the platform. Fees are non-refundable as they are considered fulfilled upon payment.",
            'about_offer_title' => "What we offer",
            'about_offer_sub' => "Our platform is built on five core principles that guide everything we do.",
            'about_offer_free_title' => "A free market for everyone",
            'about_offer_free_desc' => "Anyone can create an account and post advertisements for vehicles, spare parts, real estate, and more — completely free of charge, no subscription required.",
            'about_offer_reach_title' => "Pan-European reach",
            'about_offer_reach_desc' => "We bring together buyers and sellers from all over Europe, enabling cross-border trading opportunities without complexity or barriers.",
            'about_offer_ux_title' => "User-friendly experience",
            'about_offer_ux_desc' => "Our platform is intuitive and fast, making posting, browsing, and communicating with sellers straightforward and enjoyable in 31 languages.",
            'about_offer_security_title' => "Security first",
            'about_offer_security_desc' => "We actively monitor listings and user activity to maintain a safe, trustworthy environment where both buyers and sellers can trade with confidence.",
            'about_offer_transparency_title' => "Full transparency",
            'about_offer_transparency_desc' => "No hidden fees, no commissions, no surprises — just a clean, open marketplace where honesty and ease come first, always.",
            'about_steps_title' => "How to get started",
            'about_steps_sub' => "Four simple steps to start buying and selling across Europe — takes less than 2 minutes to register.",
            'about_step1_title' => "Create a free account",
            'about_step1_desc' => "Visit EuroBas.com and click Register. Choose between a personal or business account. Enter your email and set a password.",
            'about_step2_title' => "Complete your profile",
            'about_step2_desc' => "Add your phone number, address, and preferred language to unlock ad publishing and the ability to contact sellers directly.",
            'about_step3_title' => "Publish your ad",
            'about_step3_desc' => "List any item with photos, description, price, and location — completely free. Your ad goes live instantly across Europe.",
            'about_step4_title' => "Connect with buyers",
            'about_step4_desc' => "Receive inquiries and communicate directly with interested buyers across Europe in your own language or theirs.",
            'about_vision_title' => "Our vision and commitment",
            'about_vision_sub' => "We are committed to building a better, more connected Europe through open, free, and transparent trade.",
            'about_vision_1_title' => "Our vision",
            'about_vision_1_desc' => "To unify the automotive, real estate, and goods market across Europe — creating a single space where individuals and businesses can connect, trade, and grow without limits or borders.",
            'about_vision_2_title' => "GDPR compliant",
            'about_vision_2_desc' => "Full compliance with GDPR regulations to protect your personal data and ensure your privacy. Your data is never sold or shared without your explicit consent.",
            'about_vision_3_title' => "Continuous development",
            'about_vision_3_desc' => "We continuously develop advanced features to meet the evolving needs of our European community — improving speed, reliability, and user experience every day.",
            'about_languages_title' => "Available in 31 languages",
            'about_languages_sub' => "Use EuroBas in your own language — we support a wide range of European and international languages to make the platform accessible to everyone.",
            'about_company_title' => "Company information",
            'about_company_sub' => "EuroBas is a registered company based in the Netherlands, committed to fair and transparent trade across Europe.",
            'about_company_name' => "Company name",
            'about_company_country' => "Headquarters",
            'about_company_kvk' => "Chamber of Commerce (KvK)",
            'about_company_email' => "Contact email",
            'about_cta_title' => "Europe's marketplace without borders",
            'about_cta_desc' => "Join thousands of users across Europe — list your ads today and trade with confidence, no matter where you are. Registration is free. Always.",
            'about_cta_btn' => "Post your first ad — it's completely free",
            'Netherlands' => "Netherlands",
        ];

        foreach ($translations as $key => $value) {
            \App\Model\Translation::updateOrCreate(
                ['translationable_type' => 'App\Model\BusinessSetting', 'locale' => 'en', 'key' => $key],
                ['value' => $value]
            );
        }
    }

    public function down()
    {
        $keys = ['europes_unified_free_marketplace','about_hero_description','about_free_title','about_free_desc','about_categories_title','about_categories_sub','about_paid_title','about_paid_sub','about_offer_title','about_offer_sub','about_steps_title','about_steps_sub','about_vision_title','about_vision_sub','about_languages_title','about_languages_sub','about_company_title','about_company_sub','about_cta_title','about_cta_desc','about_cta_btn'];
        \App\Model\Translation::whereIn('key', $keys)->where('locale', 'en')->delete();
    }
}
