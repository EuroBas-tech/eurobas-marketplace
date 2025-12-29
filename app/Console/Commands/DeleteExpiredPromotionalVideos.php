<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Model\SponsoredAd;
use App\Model\BusinessSetting;
use Illuminate\Console\Command;
use Illuminate\Support\FacadesLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DeleteExpiredPromotionalVideos extends Command
{
    
    protected $signature = 'PromotionalVideos:AutoDelete';

    protected $description = 'automatic delete expired promotional videos';

    public function __construct()
    {
        parent::__construct();
    }
    
    
    public function handle()
    {
        $videos = SponsoredAd::where('type', 'promotional_video')
            ->where('expiration_date', '<=', now())
            ->where('is_video_deleted', 0)
            ->whereNotNull('playback_id')
            ->get();

        $muxTokenId = BusinessSetting::where('type', 'mux_api_token')->value('value');
        $muxTokenSecret = BusinessSetting::where('type', 'mux_secret_key')->value('value');

        if (!$muxTokenId || !$muxTokenSecret) {
            return;
        }

        foreach ($videos as $video) {
            try {

                    // 1️⃣ Get asset_id from playback_id
                    $response = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                        ->get("https://api.mux.com/video/v1/playback-ids/{$video->playback_id}");

                    if (!$response->successful()) {
                        Log::error("Failed to get asset_id for video {$video->id}", [
                            'status' => $response->status(),
                            'response' => $response->body()
                        ]);
                        continue;
                    }

                    // Try different possible paths for asset_id
                    $responseData = $response->json();
                    $assetId = $responseData['data']['asset_id'] ?? 
                    $responseData['data']['object']['id'] ?? 
                    null;

                    if (!$assetId) {
                        Log::error("Asset ID not found for video {$video->id}", [
                            'response_data' => $responseData
                        ]);
                        continue;
                    }

                    // 2️⃣ Delete asset from Mux
                    $deleteResponse = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                        ->delete("https://api.mux.com/video/v1/assets/{$assetId}");

                    if (!$deleteResponse->successful()) {
                        Log::error("Failed to delete asset {$assetId} for video {$video->id}", [
                            'status' => $deleteResponse->status(),
                            'response' => $deleteResponse->body()
                        ]);
                        continue;
                    }

                    // 3️⃣ Mark as deleted locally
                    $video->update([
                        'is_video_deleted' => 1,
                    ]);

                    Log::info("Successfully deleted video {$video->id} with asset {$assetId}");

            } catch (\Exception $e) {
                Log::error("Error deleting video {$video->id}: " . $e->getMessage());
            }
        }
    }


}