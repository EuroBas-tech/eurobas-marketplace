<?php

namespace App\Console\Commands;

use App\Model\SponsorVideo;
use App\Model\BusinessSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DeleteOrphanedVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'PromotionalVideos:DeleteOrphanedVideos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'automatic delete orphaned promotional videos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
    
        $sponsorVideos = SponsorVideo::where(function ($q) {
            $q->whereDoesntHave('sponsor')
            ->orWhereHas('sponsor', function ($q) {
                $q->where('is_paid', 0)
                ->where(function ($q) {
                    $q->whereDoesntHave('ad')
                    ->orWhereHas('ad', function ($q) {
                        $q->where('status', 0);
                    });
                });
            });
        })
        ->get();
        
        $muxTokenId = BusinessSetting::where('type', 'mux_api_token')->value('value');
        $muxTokenSecret = BusinessSetting::where('type', 'mux_secret_key')->value('value');

        if (!$muxTokenId || !$muxTokenSecret) {
            Log::debug('please verify your mux api credentials - ' . now()->format('Y-m-d H:i'));
            return;
        }

        foreach ($sponsorVideos as $video) {
            try {                
                $deleteResponse = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                ->delete("https://api.mux.com/video/v1/assets/{$video->asset_id}");
                
                if (!$deleteResponse->successful()) {
                    Log::debug('Failed to delete video'. ':' . $deleteResponse->body());
                }
                
                $video->is_video_deleted = 1;
                $video->save();

                Log::debug("orphaned video {$video->id} deleted successfully");
            } catch (\Exception $e) {
                Log::error("Error deleting video {$video->id}: " . $e->getMessage());
            }
        }

    }
}
