<?php

namespace App\Console\Commands;

use App\Model\BusinessSetting;
use Carbon\Carbon;
use App\Model\SponsoredAd;
use Illuminate\Console\Command;
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
        $promotional_videos = SponsoredAd::where('type', 'promotional_video')
            ->where('expiration_date', '<', Carbon::now()->toDateString())
            ->where('is_video_deleted', 0)
            ->get();

        $muxTokenId     = BusinessSetting::where('type', 'mux_api_token')->value('value');
        $muxTokenSecret = BusinessSetting::where('type', 'mux_secret_key')->value('value');

        if ($promotional_videos->count() > 0) {
            foreach ($promotional_videos as $video) {

                if ($video->playback_id) {
                    try {
                        /**
                         * 1️⃣ Get asset by playback_id
                         */
                        $assetResponse = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                            ->get('https://api.mux.com/video/v1/assets', [
                                'playback_id' => $video->playback_id
                            ]);

                        if (!$assetResponse->successful() || empty($assetResponse['data'][0]['id'])) {
                            Log::debug([
                                'success' => false,
                                'error' => 'Asset not found for playback ID',
                                'playback_id' => $video->playback_id,
                                'at' => now()
                            ]);
                            continue;
                        }

                        $assetId = $assetResponse['data'][0]['id'];

                        /**
                         * 2️⃣ Delete asset from Mux
                         */
                        $deleteResponse = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                            ->delete("https://api.mux.com/video/v1/assets/{$assetId}");

                        if ($deleteResponse->successful()) {

                            Log::debug([
                                'success' => true,
                                'message' => 'Video deleted successfully from Mux',
                                'asset_id' => $assetId,
                                'at' => now()
                            ]);

                            $video->is_video_deleted = 1;
                            $video->save();

                            Log::debug($video);

                        } else {
                            Log::debug([
                                'success' => false,
                                'error' => 'Failed to delete video from Mux: ' . $deleteResponse->body(),
                                'at' => now()
                            ]);
                        }

                    } catch (\Exception $e) {
                        Log::debug([
                            'success' => false,
                            'error' => $e->getMessage(),
                            'at' => now()
                        ]);
                    }
                }
            }
        }

    }
    
}
