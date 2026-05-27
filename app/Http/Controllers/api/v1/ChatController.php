<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Ad;
use App\Model\Chatting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function App\CPU\translate;

class ChatController extends Controller
{
    /**
     * GET v1/customer/chat/list — conversations with per-row unread count and a
     * last-message preview/time.
     */
    public function list(Request $request)
    {
        $userId = $request->user()->id;

        $allChats = Chatting::with([
                'sender'   => fn($q) => $q->select('id', 'name', 'image'),
                'receiver' => fn($q) => $q->select('id', 'name', 'image'),
            ])
            ->where(fn($q) => $q->where('sender_id', $userId)->orWhere('receiver_id', $userId))
            ->whereNotNull('sender_id')
            ->whereNotNull('receiver_id')
            ->orderBy('created_at', 'desc')
            ->get();

        $seenPartners = [];
        $uniqueChats  = [];

        foreach ($allChats as $chat) {
            $partnerId = ($chat->sender_id == $userId) ? $chat->receiver_id : $chat->sender_id;

            if (!in_array($partnerId, $seenPartners)) {
                $seenPartners[] = $partnerId;

                $chat->partner_id           = $partnerId;
                $chat->last_message         = $chat->message;
                $chat->last_message_time    = $chat->created_at;
                $chat->unseen_message_count = Chatting::where('sender_id', $partnerId)
                    ->where('receiver_id', $userId)
                    ->where('seen', 0)
                    ->count();
                $chat->attachment_images = $this->decodeImages($chat->attachment);
                $chat->ad                = $this->adRef($chat->ad_id);

                $uniqueChats[] = $chat;
            }
        }

        return response()->json([
            'total_size' => count($uniqueChats),
            'chat'       => array_values($uniqueChats),
        ], 200);
    }

    /**
     * GET v1/customer/chat/get-messages/{id} — conversation with partner {id}.
     * Opening it marks that partner's messages as seen.
     */
    public function get_message(Request $request, $id)
    {
        $userId = $request->user()->id;

        // Auto mark-seen on open.
        Chatting::where('sender_id', $id)->where('receiver_id', $userId)->update(['seen' => 1]);

        $messages = Chatting::where(fn($q) => $q->where('sender_id', $id)->orWhere('receiver_id', $id))
            ->where(fn($q) => $q->where('sender_id', $userId)->orWhere('receiver_id', $userId))
            ->latest()
            ->paginate($request->input('limit', 20));

        $messages->getCollection()->transform(function ($message) {
            $message->attachment_images = $this->decodeImages($message->attachment);
            $message->ad                = $this->adRef($message->ad_id);
            return $message;
        });

        return response()->json($messages, 200);
    }

    /**
     * POST v1/customer/chat/send-message — text and/or image[] attachments, with
     * an optional ad_id "about this ad" context.
     */
    public function send_message(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'      => 'required',
            'message' => 'required_without:image|nullable|string',
            'image'   => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:6000',
            'ad_id'   => 'nullable|numeric',
        ], [
            'message.required_without' => translate('type something!'),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        if ($request->user()->id == $request->id) {
            return response()->json(['message' => translate('you_cant_send_message_to_yourself')], 422);
        }

        $images = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                if ($image && $image->isValid()) {
                    $images[] = ImageManager::upload('chatting/', 'webp', $image, 'def.jpg');
                }
            }
        }

        $chatting = Chatting::create([
            'sender_id'   => $request->user()->id,
            'receiver_id' => $request->id,
            'message'     => $request->message,
            'attachment'  => json_encode($images),
            'ad_id'       => $request->ad_id,
            'seen'        => 0,
            'created_at'  => now(),
        ]);

        $chatting->attachment_images = $images;
        $chatting->ad                = $this->adRef($chatting->ad_id);

        return response()->json(['data' => $chatting, 'time' => now()], 200);
    }

    /**
     * GET v1/customer/chat/unread-count — global unread badge.
     */
    public function unread_count(Request $request)
    {
        $count = Chatting::where('receiver_id', $request->user()->id)->where('seen', 0)->count();
        return response()->json(['unread_count' => $count], 200);
    }

    /**
     * POST v1/customer/chat/mark-seen — mark a partner's messages seen.
     */
    public function mark_seen(Request $request)
    {
        $validator = Validator::make($request->all(), ['id' => 'required']);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        Chatting::where('sender_id', $request->id)
            ->where('receiver_id', $request->user()->id)
            ->update(['seen' => 1]);

        return response()->json(['message' => translate('successfully updated!')], 200);
    }

    // ─── helpers ─────────────────────────────────────────────────────────

    private function decodeImages($attachment): array
    {
        if (!$attachment) {
            return [];
        }
        $decoded = json_decode($attachment, true);
        return is_array($decoded) ? $decoded : [];
    }

    private function adRef($adId)
    {
        if (!$adId) {
            return null;
        }
        return Ad::select('id', 'slug', 'title', 'thumbnail')->find($adId);
    }
}
