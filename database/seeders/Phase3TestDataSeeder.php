<?php

namespace Database\Seeders;

use App\Model\Ad;
use App\Model\Category;
use App\Model\Brand;
use App\Model\Chatting;
use App\Model\SellerReview;
use App\Model\UserReport;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Phase 3 test fixtures — a ready-to-use buyer + seller (with ads, a conversation
 * and a review) so every Phase-3 feature can be exercised from the website.
 *
 * Run with:  php artisan db:seed --class=Database\\Seeders\\Phase3TestDataSeeder
 *
 * Logins (password for all = "password"):
 *   buyer@eurobas.test   — the account to log in and test with
 *   seller@eurobas.test  — a seller to contact / block / report / rate
 *   rater@eurobas.test   — already left the seller a review
 */
class Phase3TestDataSeeder extends Seeder
{
    public function run()
    {
        $buyer  = $this->makeUser('buyer@eurobas.test', 'Test Buyer', 'Test', 'Buyer');
        $seller = $this->makeUser('seller@eurobas.test', 'Test Seller', 'Test', 'Seller');
        $rater  = $this->makeUser('rater@eurobas.test', 'Happy Customer', 'Happy', 'Customer');

        $categoryId = (int) (Category::where('position', 1)->value('id') ?? Category::value('id'));
        $brandId    = (int) Brand::value('id');

        // Two ads for the seller so their profile + listing cards have content.
        $ad1 = $this->makeAd($seller->id, $categoryId, $brandId, 'Test Seller — BMW 320i 2021', 12500);
        $this->makeAd($seller->id, $categoryId, $brandId, 'Test Seller — Audi A4 2020', 9800);

        // A seed conversation between buyer and seller (both directions) so the inbox,
        // status icons, delete, block and report can all be tried immediately.
        $this->seedConversation($buyer->id, $seller->id, $ad1->id);

        // A review already left for the seller so the rating shows on profile + ad cards.
        SellerReview::updateOrCreate(
            ['seller_id' => $seller->id, 'customer_id' => $rater->id],
            ['rating' => 5, 'comment' => 'Great seller, smooth and honest transaction!', 'status' => 1]
        );
        SellerReview::updateOrCreate(
            ['seller_id' => $seller->id, 'customer_id' => $buyer->id],
            ['rating' => 4, 'comment' => 'Good communication.', 'status' => 1]
        );

        // A sample user report so the admin User-Reports panel has demo data.
        // (Clean any prior reports between this pair first so re-running stays tidy.)
        UserReport::where('reporter_id', $rater->id)->where('reported_id', $seller->id)->delete();
        UserReport::create([
            'reporter_id' => $rater->id,
            'reported_id' => $seller->id,
            'type'        => 'chat',
            'reason'      => 'spam',
            'message'     => 'Sample report for testing the admin panel.',
            'status'      => 'pending',
        ]);

        $this->command->info('Phase 3 test data ready.');
        $this->command->info('  Buyer  : buyer@eurobas.test  / password');
        $this->command->info('  Seller : seller@eurobas.test / password (id ' . $seller->id . ')');
        $this->command->info('  Open the seller profile at: /show-profile/' . $seller->id . '/' . urlencode($seller->name));
    }

    private function makeUser(string $email, string $name, string $fName, string $lName): User
    {
        return User::updateOrCreate(
            ['email' => $email],
            [
                'name'              => $name,
                'f_name'            => $fName,
                'l_name'            => $lName,
                'password'          => Hash::make('password'),
                'account_type'      => 'individual',
                'phone_code'        => '+44',
                'phone'             => '70' . random_int(10000000, 99999999),
                'country'           => 'United Kingdom',
                'city'              => 'London',
                'native_language'   => 'en',
                'is_active'         => 1,
                'is_phone_verified' => 1,
                'is_email_verified' => 1,
                'show_phone_number' => 1,
                'show_email_address'=> 1,
                'show_location_data'=> 1,
            ]
        );
    }

    private function makeAd(int $userId, int $categoryId, ?int $brandId, string $title, int $price): Ad
    {
        // Stable slug so re-seeding doesn't change the ad URL.
        $slug = Str::slug($title);

        return Ad::updateOrCreate(
            ['user_id' => $userId, 'title' => $title],
            [
                'slug'              => $slug,
                'description'       => 'This is a Phase-3 test listing used to demo the seller profile, ratings and chat features.',
                'category_id'       => $categoryId,
                'brand_id'          => $brandId,
                'price_type'        => 'fixed_price',
                'price'             => $price,
                'year'              => 2021,
                'currency'          => 'GBP',
                'country'           => 'United Kingdom',
                'city'              => 'London',
                'allow_offers'      => 1,
                'show_phone_number' => 1,
                'status'            => 1,
                'images'            => json_encode([]),
            ]
        );
    }

    private function seedConversation(int $buyerId, int $sellerId, int $adId): void
    {
        // Clear any prior seeded messages between this pair so re-running is clean.
        Chatting::where(function ($q) use ($buyerId, $sellerId) {
            $q->where('sender_id', $buyerId)->where('receiver_id', $sellerId);
        })->orWhere(function ($q) use ($buyerId, $sellerId) {
            $q->where('sender_id', $sellerId)->where('receiver_id', $buyerId);
        })->delete();

        Chatting::create([
            'sender_id' => $buyerId, 'receiver_id' => $sellerId, 'ad_id' => $adId,
            'message' => 'Hi, is the BMW still available?',
            'attachment' => json_encode([]), 'seen' => 1, 'seen_at' => now()->subDays(1),
            'delivered_at' => now()->subDays(1), 'created_at' => now()->subDays(1),
        ]);
        Chatting::create([
            'sender_id' => $sellerId, 'receiver_id' => $buyerId, 'ad_id' => $adId,
            'message' => 'Yes it is! When would you like to view it?',
            'attachment' => json_encode([]), 'seen' => 1, 'seen_at' => now()->subDays(1),
            'delivered_at' => now()->subDays(1), 'created_at' => now()->subDays(1)->addMinutes(5),
        ]);
        Chatting::create([
            'sender_id' => $buyerId, 'receiver_id' => $sellerId, 'ad_id' => $adId,
            'message' => 'Could you send a photo of the interior?',
            'attachment' => json_encode([]), 'seen' => 0,
            'delivered_at' => now(), 'created_at' => now(),
        ]);
    }
}
