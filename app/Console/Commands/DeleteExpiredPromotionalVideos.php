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
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'PromotionalVideos:AutoDelete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'automatic delete expired promotional videos';

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

        $promotional_videos = SponsoredAd::where('type', 'promotional_video')
            ->where('expiration_date', '<', Carbon::now()->toDateString())
            ->where('is_video_deleted', 0)
            ->get();

        $apiKey = BusinessSetting::where('type', 'bunny_api_key')->value('value');
        $libraryId = BusinessSetting::where('type', 'bunny_library_id')->value('value');
        
        if($promotional_videos->count() > 0) {
            foreach($promotional_videos as $video) {
                if ($video->playback_id) {
                    try {
                        // Delete video from Bunny Stream
                        $response = Http::withHeaders([
                            'AccessKey' => $apiKey
                        ])->delete("https://video.bunnycdn.com/library/{$libraryId}/videos/{$video->playback_id}");

                        if ($response->successful()) {                            
                            Log::debug([
                                'success' => true,
                                'message' => 'Video deleted successfully',
                                'at' => now()
                            ]);

                            $video->is_video_deleted = 1;
                            $video->save();
                            
                        } else {
                            Log::debug([
                                'success' => false,
                                'error' => 'Failed to delete video : ' . $response->body(),
                                'at' => now()
                            ], 500);
                        }
                    } catch (\Exception $e) {
                        Log::debug(response()->json([
                            'success' => false,
                            'error' => $e->getMessage()
                        ], 500));
                    }
                }
            }
        }
    }
}
