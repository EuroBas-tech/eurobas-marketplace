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
        ->limit(40)
        ->get()
        ->merge(
            SponsoredAd::whereHas('ad', fn ($q) => $q->where('status', 0))->limit(40)->get()
        )
        ->unique('id');

        $muxTokenId = BusinessSetting::where('type', 'mux_api_token')->value('value');
        $muxTokenSecret = BusinessSetting::where('type', 'mux_secret_key')->value('value');

        if (!$muxTokenId || !$muxTokenSecret) {
            Log::debug('please verify your mux api credentials - ' . now()->format('Y-m-d H:i'));
            return;
        }

        foreach ($videos as $video) {
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

                    } else {
                        Log::debug('Video not found with the provided playback ID');
                    }
                } else {
                    Log::debug('Failed to retrieve video'. ':' . $assetsResponse->body());
                }
            } catch (\Exception $e) {
                Log::error("Error deleting video {$video->id}: " . $e->getMessage());
            }
        }

        // Additional code to delete orphaned videos from Mux
        try {
            // Get all playback IDs from database
            $savedPlaybackIds = SponsoredAd::whereNotNull('playback_id')
                ->pluck('playback_id')
                ->toArray();

            // Fetch all assets from Mux (with pagination)
            $page = 1;
            $limit = 100;
            $hasMorePages = true;

            while ($hasMorePages) {
                $allAssetsResponse = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                    ->get("https://api.mux.com/video/v1/assets", [
                        'limit' => $limit,
                        'page' => $page
                    ]);

                if ($allAssetsResponse->successful()) {
                    $allAssetsData = $allAssetsResponse->json();
                    
                    if (!empty($allAssetsData['data']) && count($allAssetsData['data']) > 0) {
                        foreach ($allAssetsData['data'] as $asset) {
                            // Check if this asset has playback IDs
                            if (!empty($asset['playback_ids'])) {
                                $assetPlaybackIds = array_column($asset['playback_ids'], 'id');
                                
                                // Check if any of the asset's playback IDs exist in database
                                $foundInDb = false;
                                foreach ($assetPlaybackIds as $playbackId) {
                                    if (in_array($playbackId, $savedPlaybackIds)) {
                                        $foundInDb = true;
                                        break;
                                    }
                                }
                                
                                if (!$foundInDb) {
                                    // Check if video was created more than 1 hour ago
                                    $createdAt = isset($asset['created_at']) ? strtotime($asset['created_at']) : null;
                                    $oneHourAgo = now()->subHour()->timestamp;
                                    
                                    if ($createdAt && $createdAt < $oneHourAgo) {
                                        $assetId = $asset['id'];
                                        $deleteOrphanResponse = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                                            ->delete("https://api.mux.com/video/v1/assets/{$assetId}");
                                        
                                        if ($deleteOrphanResponse->successful()) {
                                            Log::debug("Deleted orphaned video with asset ID: {$assetId}");
                                        } else {
                                            Log::debug("Failed to delete orphaned video {$assetId}: " . $deleteOrphanResponse->body());
                                        }
                                    } else {
                                        Log::debug("Skipped deleting recent orphaned video {$asset['id']} (created less than 1 hour ago)");
                                    }
                                }
                            }
                        }
                        
                        // Check if there are more pages
                        $hasMorePages = count($allAssetsData['data']) === $limit;
                        $page++;
                    } else {
                        $hasMorePages = false;
                    }
                } else {
                    Log::debug('Failed to retrieve all assets from Mux: ' . $allAssetsResponse->body());
                    $hasMorePages = false;
                }
            }
        } catch (\Exception $e) {
            Log::error("Error deleting orphaned videos: " . $e->getMessage());
        }

        Log::debug('cron job done at ' . now()->format('Y-m-d H:i'));
    }

}