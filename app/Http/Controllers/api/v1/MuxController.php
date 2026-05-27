<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use App\Model\SponsorVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
 * Promotional-video upload for the mobile sponsor flow (§4). Mirrors the web
 * MuxApiController but returns the persisted SponsorVideo `video_id` in the
 * body (instead of stashing it in the session) so the app can pass it to
 * POST v1/customer/sponsors. The upload itself is free.
 */
class MuxController extends Controller
{
    private function credentials(): array
    {
        return [
            BusinessSetting::where('type', 'mux_api_token')->value('value'),
            BusinessSetting::where('type', 'mux_secret_key')->value('value'),
        ];
    }

    /**
     * POST v1/mux/create-upload — returns a direct-upload URL + upload_id.
     */
    public function create_upload(Request $request)
    {
        [$tokenId, $tokenSecret] = $this->credentials();

        if (!$tokenId || !$tokenSecret) {
            return response()->json(['success' => false, 'error' => translate('Mux credentials not configured')], 500);
        }

        try {
            $response = Http::withBasicAuth($tokenId, $tokenSecret)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post('https://api.mux.com/video/v1/uploads', [
                    'new_asset_settings' => ['playback_policy' => ['public']],
                    'cors_origin'        => '*',
                    'timeout'            => 3600,
                ]);

            if (!$response->successful()) {
                return response()->json(['success' => false, 'error' => $response->body()], 500);
            }

            $data = $response->json();
            return response()->json([
                'success'   => true,
                'url'       => $data['data']['url'],
                'upload_id' => $data['data']['id'],
            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * GET v1/mux/video?upload_id=… — polls Mux; once the asset is ready it
     * persists a SponsorVideo and returns its `video_id` and `video_url`.
     */
    public function video(Request $request)
    {
        $uploadId = $request->input('upload_id');
        if (!$uploadId) {
            return response()->json(['success' => false, 'error' => translate('Upload ID is required')], 400);
        }

        [$tokenId, $tokenSecret] = $this->credentials();

        try {
            $uploadResponse = Http::withBasicAuth($tokenId, $tokenSecret)
                ->get("https://api.mux.com/video/v1/uploads/{$uploadId}");

            if (!$uploadResponse->successful()) {
                return response()->json(['success' => false, 'error' => $uploadResponse->body()], 500);
            }

            $uploadData = $uploadResponse->json();
            if (($uploadData['data']['status'] ?? null) !== 'asset_created') {
                return response()->json([
                    'success' => false,
                    'error'   => translate('Video is still processing please try again in a moment'),
                    'status'  => $uploadData['data']['status'] ?? null,
                ], 202);
            }

            $assetId       = $uploadData['data']['asset_id'];
            $assetResponse = Http::withBasicAuth($tokenId, $tokenSecret)
                ->get("https://api.mux.com/video/v1/assets/{$assetId}");

            if (!$assetResponse->successful()) {
                return response()->json(['success' => false, 'error' => $assetResponse->body()], 500);
            }

            $assetData = $assetResponse->json();
            if (($assetData['data']['status'] ?? null) !== 'ready') {
                return response()->json([
                    'success' => false,
                    'error'   => translate('Video is still processing please try again in a moment'),
                    'status'  => $assetData['data']['status'] ?? null,
                ], 202);
            }

            $playbackId = $assetData['data']['playback_ids'][0]['id'];

            $sponsorVideo = new SponsorVideo;
            $sponsorVideo->playback_id = $playbackId;
            $sponsorVideo->asset_id    = $assetId;
            $sponsorVideo->video_url   = "https://stream.mux.com/{$playbackId}";
            $sponsorVideo->save();

            return response()->json([
                'success'   => true,
                'video_id'  => $sponsorVideo->id,
                'video_url' => "https://stream.mux.com/{$playbackId}.m3u8",
            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
