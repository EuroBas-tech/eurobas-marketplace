<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Model\SponsoredAd;
use App\Model\BusinessSetting;

class DeleteExpiredPromotionalVideos extends Command
{
    protected $signature = 'PromotionalVideos:AutoDelete';
    protected $description = 'Delete orphaned, expired, or unpaid videos from Mux and local DB';

    public function handle(): int
    {
        $muxTokenId = BusinessSetting::where('type', 'mux_api_token')->value('value');
        $muxTokenSecret = BusinessSetting::where('type', 'mux_secret_key')->value('value');

        if (!$muxTokenId || !$muxTokenSecret) {
            Log::error('[PromotionalVideos] Mux credentials are missing');
            return Command::FAILURE;
        }

        $videos = SponsoredAd::query()
            ->where('type', 'promotional_video')
            ->where('is_video_deleted', 0)
            ->whereNotNull('playback_id')
            ->where(function ($query) {
                $query
                    // 1. Expired videos
                    ->where('expiration_date', '<=', Carbon::now())

                    // 2. Unpaid videos older than 1 hour (covers back-button or refresh cases)
                    ->orWhere(function($q) {
                        $q->where('is_paid', 0)
                          ->where('created_at', '<=', Carbon::now()->subHour());
                    })

                    // 3. Manually suspended videos
                    ->orWhere('is_video_suspended', 1)

                    // 4. Videos linked to inactive or deleted ads
                    ->orWhereHas('ad', function ($q) {
                        $q->where('status', 0);
                    })
                    
                    // 5. Orphaned videos without any ad relationship
                    ->orWhereDoesntHave('ad');
            })
            ->limit(100)
            ->get();

        if ($videos->isEmpty()) {
            return Command::SUCCESS;
        }

        foreach ($videos as $video) {
            try {
                // Fetch the Asset ID using Playback ID
                $response = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                    ->timeout(10)
                    ->get("https://api.mux.com/video/v1/playback-ids/{$video->playback_id}");

                if ($response->successful()) {
                    $assetId = $response->json('data.asset_id');

                    if ($assetId) {
                        // Delete from Mux
                        $deleteRes = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                            ->delete("https://api.mux.com/video/v1/assets/{$assetId}");

                        if ($deleteRes->successful() || $deleteRes->status() == 404) {
                            $video->update(['is_video_deleted' => 1]);
                            Log::info("[PromotionalVideos] Successfully deleted video ID: {$video->id}");
                        }
                    }
                } elseif ($response->status() == 404) {
                    // If video doesn't exist on Mux, sync local DB
                    $video->update(['is_video_deleted' => 1]);
                }

            } catch (\Throwable $e) {
                Log::error("[PromotionalVideos] Error processing video {$video->id}: " . $e->getMessage());
            }
        }

        return Command::SUCCESS;
    }
}
