<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Chatting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function App\CPU\translate;

class ChatController extends Controller
{
    public function list(Request $request)
    {
        $userId = $request->user()->id;

        $allChats = Chatting::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->whereNotNull(['sender_id', 'receiver_id'])
            ->orderBy('created_at', 'desc')
            ->get();

        $seenPartners = [];
        $uniqueChats = [];

        foreach ($allChats as $chat) {
            $partnerId = ($chat->sender_id == $userId) ? $chat->receiver_id : $chat->sender_id;

            if (!in_array($partnerId, $seenPartners)) {
                $seenPartners[] = $partnerId;
                $uniqueChats[] = $chat;
            }
        }

        $data = [];
        $data['total_size'] = count($uniqueChats);
        $data['chat'] = array_values($uniqueChats);

        return response()->json($data, 200);
    }

    public function get_message(Request $request, $id)
    {
        $messages = Chatting::where(function ($q) use ($id) {
                $q->where('sender_id', $id)
                ->orWhere('receiver_id', $id);
            })
            ->where(function ($q) use ($request) {
                $q->where('sender_id', $request->user()->id)
                ->orWhere('receiver_id', $request->user()->id);
            })
            ->latest()
            ->get();

        if ($messages->count() > 0) {
            return response()->json($messages, 200);
        }

        return response()->json(['message' => translate('no messages found!')], 200);
    }

    public function send_message(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'message' => 'required',
        ], [
            'message.required' => translate('type something!')
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $chatting = new Chatting();
        $chatting->sender_id = $request->user()->id;
        $chatting->receiver_id = $request->id;
        $chatting->message = $request->message;
        $chatting->seen = 0;
        $chatting->save();

        return response()->json(['message' => $request->message, 'time' => now()], 200);
    }
}
