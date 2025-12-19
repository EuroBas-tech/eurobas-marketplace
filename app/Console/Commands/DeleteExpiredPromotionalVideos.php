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
        
        // Get expired videos
        $videos = SponsoredAd::where('type', 'promotional_video')
            ->where('expiration_date', '<=', now())
            ->where('is_video_deleted', 0)
            ->whereNotNull('playback_id')
            ->get();

        // Get Mux credentials
        $muxTokenId = BusinessSetting::where('type', 'mux_api_token')->value('value');
        $muxTokenSecret = BusinessSetting::where('type', 'mux_secret_key')->value('value');

        if (!$muxTokenId || !$muxTokenSecret) {
            return;
        }

        // Delete each video
        foreach ($videos as $video) {
            try {
                // Extract asset ID from video_url
                // URL format: https://stream.mux.com/ASSET_ID
                preg_match('/stream\.mux\.com\/([^\/\?]+)/', $video->video_url, $matches);
                $assetId = $matches[1] ?? null;

                if ($assetId) {
                    // Delete from Mux
                    Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                        ->delete("https://api.mux.com/video/v1/assets/{$assetId}");
                }

                // Mark as deleted in database
                $video->update(['is_video_deleted' => 1]);

                Log::debug($video);

            } catch (\Exception $e) {
                Log::error("Error deleting video {$video->id}: " . $e->getMessage());
            }
        }
    }

}
