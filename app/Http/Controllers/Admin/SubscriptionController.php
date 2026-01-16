<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Model\Cost;
use App\CPU\Convert;
use App\CPU\Helpers;
use App\Models\User;
use App\Model\Category;
use Carbon\CarbonPeriod;
use App\CPU\BackEndHelper;
use App\Model\SponsoredAd;
use App\Model\SponsorVideo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Model\BusinessSetting;
use App\Model\SponsoredAdType;
use App\Model\WithdrawRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class SubscriptionController extends Controller
{

    public function settings() {
        
        $promotion_types = SponsoredAdType::get();

        $maximum_video_duration = BusinessSetting::where('type', 'maximum_promotional_video_duration')->value('value');
        $maximum_video_size = BusinessSetting::where('type', 'maximum_promotional_video_size')->value('value');

        return view('admin-views.subscriptions.settings', compact('maximum_video_duration', 'maximum_video_size', 'promotion_types'));

    }

    public function store_settings(Request $request) {

        $request->validate([
            'maximum_video_duration' => 'required|numeric|min:1',
            'maximum_video_size' => 'required|numeric|min:1',
        ]);

        $maximum_video_duration = BusinessSetting::where('type', 'maximum_promotional_video_duration')->first();
        $maximum_video_size = BusinessSetting::where('type', 'maximum_promotional_video_size')->first();

        $maximum_video_duration->value = $request->maximum_video_duration;
        $maximum_video_size->value = $request->maximum_video_size;

        $maximum_video_duration->save();
        $maximum_video_size->save();
        
        Toastr::success(translate('subscription_settings_updated_successfully'));
        return back();

    }

    public function subscription_type_status(Request $request)
    {
        $type = $request->input('type');
        $status = $request->input('status') === 'enabled' ? 1 : 0;

        $promotionType = SponsoredAdType::where('name', $type)->first();

        if (!$promotionType) {
            return response()->json(['success' => false, 'message' => 'Promotion type not found'], 404);
        }

        $promotionType->status = $status;
        $promotionType->save();

        Cache::forget('sponsor_types');

        return response()->json([
            'success'     => true,
            'message'     => translate($type.'Status updated successfully'),
            'new_status'  => $status,
            'updated_at'  => $promotionType->updated_at->format('Y-m-d H:i:s')
        ]);
    }

    public function promotional_videos(Request $request) {

        $query_param = [];
        $search = $request['search'];

        $muxTokenId = BusinessSetting::where('type', 'mux_api_token')->value('value');
        $muxTokenSecret = BusinessSetting::where('type', 'mux_secret_key')->value('value');

        $query = SponsorVideo::with('sponsor.ad.user')
        ->has('sponsor')
        ->has('sponsor.ad');

        if ($search = $request->input('search')) {
            $keywords = explode(' ', $search);

            $query->whereHas('sponsor.ad', function ($q) use ($keywords) {
                $q->where(function ($sub) use ($keywords) {
                    foreach ($keywords as $word) {
                        $sub->orWhere('title', 'like', "%{$word}%");
                    }
                });
            });

            $query_param = ['search' => $search];
        }

        $promotional_videos = $query->latest()->paginate(Helpers::pagination_limit());

        return view('admin-views.subscriptions.promotional-videos',
        compact('promotional_videos', 'muxTokenId', 'muxTokenSecret', 'search'));
    }

    public function status_update(Request $request)
    {
        $video = SponsorVideo::find($request['id']);
        $video->is_video_suspended = $request['status'] ? 0 : 1;

        if($video->save()){
            $success = 1;
        }else{
            $success = 0;
        }

        return response()->json([
            'success' => $success,
        ], 200);
    }

    public function delete_promotional_video(Request $request) {

        $muxTokenId = BusinessSetting::where('type', 'mux_api_token')->value('value');
        $muxTokenSecret = BusinessSetting::where('type', 'mux_secret_key')->value('value');

        $video = SponsoredAd::find($request['id'])?->video;

        if ($video->playback_id) {
            try {
                // Search for asset by playback_id
                $assetsResponse = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                ->get("https://api.mux.com/video/v1/assets", [
                    'playback_id' => $video['playback_id'],
                    'limit' => 1
                ]);

                if ($assetsResponse->successful()) {
                    $assetsData = $assetsResponse->json();
                    
                    // Check if asset was found
                    if (!empty($assetsData['data']) && count($assetsData['data']) > 0) {
                        $assetId = $assetsData['data'][0]['id'];
                        
                        // Delete the asset
                        $deleteResponse = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                            ->delete("https://api.mux.com/video/v1/assets/{$assetId}");
                        
                        if (!$deleteResponse->successful()) {
                            Log::debug('Failed to delete video'. ':' . $deleteResponse->body());
                        }
                        
                        $video->is_video_deleted = 1;
                        $video->save();
                        
                        Toastr::success(translate('Video deleted successfully'));
                        return back();
                        
                    } else {
                        Log::debug('Video not found with the provided playback ID');
                        Toastr::error(translate("Video not found with the provided playback ID"));
                        return back();
                    }
                } else {
                    Log::debug('Failed to retrieve video'. ':' . $assetsResponse->body());
                    Toastr::error(translate('Failed to retrieve video'));
                    return back();
                }
            } catch (\Exception $e) {
                Log::debug($e->getMessage());
                Toastr::error($e->getMessage());
                return back();
            }
        } else {
            Toastr::error(translate('Video Not Found'));
            return back();
        }
    }
    
}
