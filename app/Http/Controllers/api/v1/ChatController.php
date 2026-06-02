<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Ad;
use App\Model\Chatting;
use App\Model\UserBlock;
use App\Model\UserReport;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function App\CPU\translate;

class ChatController extends Controller
{
    /**
     * GET v1/customer/chat/list — conversations with per-row unread count and a
     * last-message preview/time. Blocked users are hidden; loading the list marks
     * all incoming messages as "delivered" (Milestone 2).
     */
    public function list(Request $request)
    {
        $userId = $request->user()->id;

        // Message status — "Delivered" on chat-list load.
        Chatting::where('receiver_id', $userId)->whereNull('delivered_at')->update(['delivered_at' => now()]);

        $blocked_ids = UserBlock::relatedBlockedIds($userId);

        $allChats = Chatting::with([
                'sender'   => fn($q) => $q->select('id', 'name', 'image'),
                'receiver' => fn($q) => $q->select('id', 'name', 'image'),
            ])
            ->visibleTo($userId)
            ->where(fn($q) => $q->where('sender_id', $userId)->orWhere('receiver_id', $userId))
            ->whereNotNull('sender_id')
            ->whereNotNull('receiver_id')
            ->orderBy('created_at', 'desc')
            ->get();

        $seenPartners = [];
        $uniqueChats  = [];

        foreach ($allChats as $chat) {
            $partnerId = ($chat->sender_id == $userId) ? $chat->receiver_id : $chat->sender_id;

            if (in_array($partnerId, $blocked_ids)) {
                continue; // hide blocked conversations
            }

            if (!in_array($partnerId, $seenPartners)) {
                $seenPartners[] = $partnerId;

                $chat->partner_id           = $partnerId;
                $chat->last_message         = $chat->message;
                $chat->last_message_time    = $chat->created_at;
                $chat->message_status       = $this->messageStatus($chat);
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
     * Opening it stamps seen_at on that partner's messages (Milestone 2).
     */
    public function get_message(Request $request, $id)
    {
        $userId = $request->user()->id;

        // Message status — "Seen" on conversation open (keep legacy `seen` in sync).
        Chatting::where('sender_id', $id)->where('receiver_id', $userId)
            ->whereNull('seen_at')->update(['seen' => 1, 'seen_at' => now()]);
        Chatting::where('sender_id', $id)->where('receiver_id', $userId)
            ->where('seen', 0)->update(['seen' => 1]);

        $messages = Chatting::visibleTo($userId)
            ->where(fn($q) => $q->where('sender_id', $id)->orWhere('receiver_id', $id))
            ->where(fn($q) => $q->where('sender_id', $userId)->orWhere('receiver_id', $userId))
            ->latest()
            ->paginate($request->input('limit', 20));

        $messages->getCollection()->transform(function ($message) use ($userId) {
            $message->attachment_images = $this->decodeImages($message->attachment);
            $message->ad                = $this->adRef($message->ad_id);
            $message->is_mine           = $message->sender_id == $userId;
            $message->message_status    = $this->messageStatus($message);
            return $message;
        });

        $is_blocked = UserBlock::where('blocker_id', $userId)->where('blocked_id', $id)->exists();

        return response()->json($messages->toArray() + ['is_blocked' => $is_blocked], 200);
    }

    /**
     * POST v1/customer/chat/send-message — text and/or image[] attachments, with
     * an optional ad_id "about this ad" context. Blocked relationships are rejected.
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

        if (UserBlock::blockedBetween($request->user()->id, $request->id)) {
            return response()->json(['message' => translate('you_can_not_message_this_user')], 403);
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
        $chatting->message_status    = $this->messageStatus($chatting);

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
            ->whereNull('seen_at')
            ->update(['seen' => 1, 'seen_at' => now()]);
        Chatting::where('sender_id', $request->id)
            ->where('receiver_id', $request->user()->id)
            ->where('seen', 0)
            ->update(['seen' => 1]);

        return response()->json(['message' => translate('successfully updated!')], 200);
    }

    /* ─── Milestone 2: Report / Block / Delete (API) ───────────────────────── */

    /** POST v1/customer/chat/report — report a user. */
    public function report_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reported_id' => 'required|numeric',
            'message'     => 'nullable|string',
            'reason'      => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        if ($request->user()->id == $request->reported_id) {
            return response()->json(['message' => translate('you_can_not_report_yourself')], 422);
        }

        UserReport::create([
            'reporter_id' => $request->user()->id,
            'reported_id' => $request->reported_id,
            'chatting_id' => $request->chatting_id,
            'type'        => $request->type ?? 'chat',
            'reason'      => $request->reason,
            'message'     => $request->message,
            'status'      => 'pending',
        ]);

        return response()->json(['message' => translate('report_submitted_successfully')], 200);
    }

    /** POST v1/customer/chat/block — block a user. */
    public function block_user(Request $request)
    {
        $validator = Validator::make($request->all(), ['blocked_id' => 'required|numeric']);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        if ($request->user()->id == $request->blocked_id) {
            return response()->json(['message' => translate('you_can_not_block_yourself')], 422);
        }

        UserBlock::firstOrCreate(['blocker_id' => $request->user()->id, 'blocked_id' => $request->blocked_id]);

        return response()->json(['message' => translate('user_blocked_successfully'), 'blocked' => true], 200);
    }

    /** POST v1/customer/chat/unblock — unblock a user. */
    public function unblock_user(Request $request)
    {
        $validator = Validator::make($request->all(), ['blocked_id' => 'required|numeric']);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        UserBlock::where('blocker_id', $request->user()->id)
            ->where('blocked_id', $request->blocked_id)
            ->delete();

        return response()->json(['message' => translate('user_unblocked_successfully'), 'blocked' => false], 200);
    }

    /** GET v1/customer/chat/blocked-list — users this customer has blocked. */
    public function blocked_list(Request $request)
    {
        $blocked = UserBlock::where('blocker_id', $request->user()->id)
            ->with(['blocked' => fn($q) => $q->select('id', 'name', 'image')])
            ->get()
            ->pluck('blocked')
            ->filter()
            ->values();

        return response()->json(['total_size' => $blocked->count(), 'blocked_users' => $blocked], 200);
    }

    /** POST v1/customer/chat/delete-message — soft delete one message for me only. */
    public function delete_message(Request $request)
    {
        $validator = Validator::make($request->all(), ['message_id' => 'required|numeric']);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $me = $request->user()->id;
        $chat = Chatting::where('id', $request->message_id)
            ->where(fn($q) => $q->where('sender_id', $me)->orWhere('receiver_id', $me))
            ->first();

        if (!$chat) {
            return response()->json(['message' => translate('message_not_found')], 404);
        }

        if ($chat->sender_id == $me) {
            $chat->deleted_by_sender = 1;
        }
        if ($chat->receiver_id == $me) {
            $chat->deleted_by_receiver = 1;
        }
        $chat->save();

        return response()->json(['message' => translate('message_deleted')], 200);
    }

    /** POST v1/customer/chat/delete-conversation — soft delete a whole thread for me only. */
    public function delete_conversation(Request $request)
    {
        $validator = Validator::make($request->all(), ['user_id' => 'required|numeric']);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $me = $request->user()->id;
        $partner = $request->user_id;

        Chatting::where('sender_id', $me)->where('receiver_id', $partner)->update(['deleted_by_sender' => 1]);
        Chatting::where('sender_id', $partner)->where('receiver_id', $me)->update(['deleted_by_receiver' => 1]);

        return response()->json(['message' => translate('conversation_deleted')], 200);
    }

    // ─── helpers ─────────────────────────────────────────────────────────

    /** Sent / Delivered / Seen — for rendering single / double / blue-double checks. */
    private function messageStatus($message): string
    {
        if ($message->seen_at || $message->seen) {
            return 'seen';
        }
        if ($message->delivered_at) {
            return 'delivered';
        }
        return 'sent';
    }

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
