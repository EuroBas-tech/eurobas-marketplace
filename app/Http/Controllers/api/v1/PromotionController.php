<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Ad;
use App\Model\PaidBanner;
use App\Model\SponsoredAd;
use App\Model\SubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Promotions (§4): subscription-package catalogue, paid banners and sponsors.
 * Mirrors Web\PaidBannerController and Web\SponsorController, but returns a
 * `payment` descriptor (instead of a browser redirect) when a package costs
 * money, so the mobile client can drive POST v1/payment/initiate.
 */
class PromotionController extends Controller
{
    private const SPONSOR_TYPES = ['urgent_sale_sticker', 'appearance_in_first_results', 'promotional_video'];

    /**
     * GET v1/subscription-packages?type=…  — package catalogue.
     */
    public function packages(Request $request)
    {
        $packages = SubscriptionPackage::with(['type:id,name', 'features:id,name'])
            ->where('status', 1)
            ->when($request->filled('type'), fn($q) => $q->whereHas('type', fn($t) => $t->where('name', $request->type)))
            ->get()
            ->map(fn($p) => [
                'id'               => $p->id,
                'type'            => $p->type ? ['id' => $p->type->id, 'name' => $p->type->name] : null,
                'price'            => (float) $p->price,
                'duration_in_days' => (int) $p->duration_in_days,
                'is_free'          => (bool) $p->is_free,
                'status'           => (int) $p->status,
                'features'         => $p->features->pluck('name')->values(),
            ]);

        return response()->json(['packages' => $packages], 200);
    }

    // ─── PAID BANNERS ────────────────────────────────────────────────────

    /**
     * POST v1/customer/paid-banners (multipart).
     */
    public function store_paid_banner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'banner_image'    => 'required|image|mimes:jpeg,png,jpg,webp|max:6000',
            'package_id'      => 'required|numeric',
            'category_id'     => 'nullable|numeric',
            'redirect_to_ads' => 'nullable',
            'ad_id'           => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $package = SubscriptionPackage::with('type')
            ->where('id', $request->package_id)
            ->where('status', 1)
            ->whereHas('type', fn($q) => $q->where('name', 'promotional_banner'))
            ->first();

        if (!$package) {
            return response()->json(['message' => translate('package_not_found')], 404);
        }

        $redirect = $request->boolean('redirect_to_ads');
        $ad = $redirect && $request->filled('ad_id')
            ? Ad::where('user_id', auth('api')->id())->find($request->ad_id)
            : null;

        $banner = new PaidBanner();
        $banner->user_id          = auth('api')->id();
        $banner->category_id      = $request->category_id;
        $banner->package_id       = $package->id;
        $banner->banner_image     = ImageManager::upload('paid-banners/', 'webp', $request->file('banner_image'), null);
        $banner->banner_url       = $ad && $ad->slug ? route('ads-show', $ad->slug) : null;
        $banner->price            = $package->price;
        $banner->duration_in_days = $package->duration_in_days;
        $banner->expiration_date  = now()->addHours($package->duration_in_days * 24);
        $banner->is_paid          = $package->price > 0 ? 0 : 1;
        $banner->save();

        return response()->json([
            'success' => true,
            'message' => translate('paid_banner_created_successfully'),
            'banner'  => $banner,
            'payment' => $package->price > 0
                ? ['required' => true, 'model_type' => 'paid_banner', 'model_id' => $banner->id, 'price' => (float) $package->price]
                : ['required' => false],
        ], 201);
    }

    /**
     * GET v1/customer/paid-banners — manage my banners.
     */
    public function my_paid_banners(Request $request)
    {
        return response()->json(
            PaidBanner::with('package.type', 'category')
                ->where('user_id', auth('api')->id())
                ->latest()
                ->paginate($request->input('limit', 10)),
            200
        );
    }

    /**
     * DELETE v1/customer/paid-banners/{id}.
     */
    public function delete_paid_banner($id)
    {
        $banner = PaidBanner::where('user_id', auth('api')->id())->find($id);
        if (!$banner) {
            return response()->json(['message' => translate('No such data found!')], 404);
        }
        if ($banner->banner_image) {
            ImageManager::delete('paid-banners/' . $banner->banner_image);
        }
        $banner->delete();
        return response()->json(['message' => translate('successfully removed!')], 200);
    }

    // ─── SPONSORS ────────────────────────────────────────────────────────

    /**
     * POST v1/customer/sponsors — boost a listing.
     */
    public function store_sponsor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ad_id'      => 'required|numeric',
            'type'       => 'required|in:' . implode(',', self::SPONSOR_TYPES),
            'package_id' => 'required|numeric',
            'video_id'   => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $ad = Ad::where('user_id', auth('api')->id())->find($request->ad_id);
        if (!$ad) {
            return response()->json(['message' => translate('ad_not_found')], 404);
        }

        $package = SubscriptionPackage::with('type')
            ->where('id', $request->package_id)
            ->where('status', 1)
            ->whereHas('type', fn($q) => $q->where('name', $request->type))
            ->first();

        if (!$package) {
            return response()->json(['message' => translate('package_not_found')], 404);
        }

        if ($request->type === 'promotional_video' && !$request->filled('video_id')) {
            return response()->json(['message' => translate('video_id_is_required')], 422);
        }

        $data = [
            'ad_id'            => $ad->id,
            'type'             => $package->type->name,
            'price'            => $package->price,
            'package_id'       => $package->id,
            'duration_in_days' => $package->duration_in_days,
            'expiration_date'  => now()->addHours($package->duration_in_days * 24),
            'is_paid'          => $package->price > 0 ? 0 : 1,
        ];
        if ($request->type === 'promotional_video') {
            $data['video_id'] = $request->video_id;
        }

        $sponsor = $ad->sponsor()->create($data);

        return response()->json([
            'success' => true,
            'message' => translate('sponsor_created_successfully'),
            'sponsor' => $sponsor,
            'payment' => $package->price > 0
                ? ['required' => true, 'model_type' => 'sponsor', 'model_id' => $sponsor->id, 'price' => (float) $package->price]
                : ['required' => false],
        ], 201);
    }

    /**
     * GET v1/customer/sponsors — manage my sponsors.
     */
    public function my_sponsors(Request $request)
    {
        $adIds = Ad::where('user_id', auth('api')->id())->pluck('id');

        return response()->json(
            SponsoredAd::with(['type', 'ad:id,title,slug,thumbnail', 'video'])
                ->whereIn('ad_id', $adIds)
                ->latest()
                ->paginate($request->input('limit', 10)),
            200
        );
    }

    /**
     * DELETE v1/customer/sponsors/{id}.
     */
    public function delete_sponsor($id)
    {
        $adIds = Ad::where('user_id', auth('api')->id())->pluck('id');

        $sponsor = SponsoredAd::whereIn('ad_id', $adIds)->find($id);
        if (!$sponsor) {
            return response()->json(['message' => translate('No such data found!')], 404);
        }
        $sponsor->delete();
        return response()->json(['message' => translate('successfully removed!')], 200);
    }
}
