<?php

namespace App\Http\Controllers;

use App\Model\SponsorVideo;
use Illuminate\Http\Request;
use App\Model\BusinessSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class MuxApiController extends Controller
{

    public function createUploadUrl(Request $request)     
    {         
        $muxTokenId = BusinessSetting::where('type', 'mux_api_token')->value('value');
        $muxTokenSecret = BusinessSetting::where('type', 'mux_secret_key')->value('value');
        
        if (!$muxTokenId || !$muxTokenSecret) {            
            return response()->json([                 
                'success' => false,                 
                'error' => 'Mux credentials not configured'        
            ], 500);         
        }          
        
        try {             
            // Create direct upload in Mux with proper CORS settings
            $response = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                ->withHeaders([                 
                    'Content-Type' => 'application/json'             
                ])->post("https://api.mux.com/video/v1/uploads", [               
                    'new_asset_settings' => [
                        'playback_policy' => ['public']
                    ],
                    'cors_origin' => request()->getSchemeAndHttpHost(), // Use actual domain
                    'timeout' => 3600
                ]);    
            
            if ($response->successful()) {                 
                $uploadData = $response->json();                 
                $uploadId = $uploadData['data']['id'];
                $uploadUrl = $uploadData['data']['url'];
                
                // Return the response with upload URL                 
                return response()->json([                     
                    'success' => true,                     
                    'data' => [                         
                        'url' => $uploadUrl,                         
                        'id' => $uploadId,                         
                        'upload_id' => $uploadId,                         
                        'access_key' => ''  // Mux doesn't need access key                   
                    ]                 
                ]);

            } else {                 
                return response()->json([                     
                    'success' => false,                     
                    'error' => 'Failed to create upload: ' . $response->body()           
                ], 500);             
            }                              
        } catch (\Exception $e) {             
            return response()->json([                 
                'success' => false,                 
                'error' => $e->getMessage()             
            ], 500);         
        }     
    }

    public function getVideoUrl(Request $request)
    {
        $uploadId = $request->input('upload_id');
        
        if (!$uploadId) {
            return response()->json([
                'success' => false,
                'error' => translate("Upload ID is required")
            ], 400);
        }

        $muxTokenId = BusinessSetting::where('type', 'mux_api_token')->value('value');
        $muxTokenSecret = BusinessSetting::where('type', 'mux_secret_key')->value('value');

        try {
            // Get upload details from Mux
            $response = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                ->get("https://api.mux.com/video/v1/uploads/{$uploadId}");

            if ($response->successful()) {
                $uploadData = $response->json();
                
                // Check if upload is completed and asset is created
                if ($uploadData['data']['status'] !== 'asset_created') {
                    return response()->json([
                        'success' => false,
                        'error' => translate("Video is still processing please try again in a moment"),
                        'status' => $uploadData['data']['status']
                    ], 202);
                }
                
                $assetId = $uploadData['data']['asset_id'];
                
                // Get asset details to check if it's ready
                $assetResponse = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                ->get("https://api.mux.com/video/v1/assets/{$assetId}");
                
                if ($assetResponse->successful()) {
                    $assetData = $assetResponse->json();
                    
                    // Check if asset is ready for playback
                    if ($assetData['data']['status'] !== 'ready') {
                        return response()->json([
                            'success' => false,
                            'error' => translate("Video is still processing please try again in a moment"),
                            'status' => $assetData['data']['status']
                        ], 202);
                    }
                    
                    $playbackId = $assetData['data']['playback_ids'][0]['id'];

                    $sponsorVideo = new SponsorVideo;

                    $sponsorVideo->playback_id = $playbackId;
                    $sponsorVideo->asset_id = $assetId;
                    $sponsorVideo->video_url = "https://stream.mux.com/{$playbackId}";

                    $sponsorVideo->save();
                    
                    session(['video_id' => $sponsorVideo->id]);

                    Log::debug(session('video_id'));
                    
                    return response()->json([
                        'success' => true,
                        'video_url' => "https://stream.mux.com/{$playbackId}.m3u8"
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'error' => translate("Failed to get asset details") . ':' . $assetResponse->body()
                    ], 500);
                }
                
            } else {
                return response()->json([
                    'success' => false,
                    'error' => translate("Failed to get upload details") . ':' . $response->body()
                ], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteVideo(Request $request)
    {
        $uploadId = $request->input('upload_id');
        
        if (!$uploadId) {
            return response()->json([
                'success' => false,
                'error' => translate("Upload ID is required")
            ], 400);
        }

        $muxTokenId = BusinessSetting::where('type', 'mux_api_token')->value('value');
        $muxTokenSecret = BusinessSetting::where('type', 'mux_secret_key')->value('value');

        try {
            // Get upload to find associated asset
            $uploadResponse = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                ->get("https://api.mux.com/video/v1/uploads/{$uploadId}");
            
            if ($uploadResponse->successful()) {
                $uploadData = $uploadResponse->json();
                $assetId = $uploadData['data']['asset_id'] ?? null;
                
                // Delete the asset if it exists
                if ($assetId) {
                    $deleteResponse = Http::withBasicAuth($muxTokenId, $muxTokenSecret)
                        ->delete("https://api.mux.com/video/v1/assets/{$assetId}");
                    
                    if (!$deleteResponse->successful()) {
                        return response()->json([
                            'success' => false,
                            'error' => translate("Failed to delete video") . ':' . $deleteResponse->body()
                        ], 500);
                    }
                }

                SponsorVideo::find(session('video_id'))?->delete();
                
            }
            
            // Clear session data
            session()->forget(['playback_id', 'video_player_url', 'asset_id']);
            
            return response()->json([
                'success' => true,
                'message' => translate("Video deleted successfully")
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function clearVideoSession(Request $request)
    {
        session()->forget(['playback_id', 'video_player_url', 'asset_id']);
        
        return response()->json([
            'success' => true,
            'message' => translate("Session cleared")
        ]);
    }


}
