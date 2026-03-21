<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Chatting;
use App\Model\DeliveryMan;
use App\Model\Seller;
use App\Model\Shop;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function App\CPU\translate;

class ChatController extends Controller
{
    public function list(Request $request)
    {
        $userId = $request->user()->id;

        // Get all messages involving the user
        $allChats = Chatting::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->whereNotNull(['sender_id', 'receiver_id'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Filter to keep only the latest message per unique conversation
        $seenPartners = [];
        $uniqueChats = [];

        foreach ($allChats as $chat) {
            // Determine the other person in the conversation
            $partnerId = ($chat->sender_id == $userId) ? $chat->receiver_id : $chat->sender_id;

            // Only keep the first (latest) message per partner
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

    public function search(Request $request, $type)
    {
        $terms = explode(" ", $request->input('search'));
        if ($type == 'seller') {
            $id_param = 'seller_id';
            $with_param = 'seller_info.shops';
            $users = Seller::when($request->search, function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $query->where('f_name', 'like', '%' . $term . '%')
                        ->orWhere('l_name', 'like', '%' . $term . '%');
                }
            })->pluck('id')->toArray();

        } elseif ($type == 'delivery-man') {
            $with_param = 'delivery_man';
            $id_param = 'delivery_man_id';
            $users = DeliveryMan::when($request->search, function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $query->where('f_name', 'like', '%' . $term . '%')
                        ->orWhere('l_name', 'like', '%' . $term . '%');
                }
            })->pluck('id')->toArray();
        } else {
            return response()->json(['message' => translate('Invalid Chatting Type!')], 403);
        }

        $unique_chat_ids = Chatting::where(['user_id' => $request->user()->id])
            ->whereIn($id_param, $users)
            ->select($id_param)
            ->distinct()
            ->get()
            ->toArray();
        $unique_chat_ids = call_user_func_array('array_merge', $unique_chat_ids);

        $chats = array();
        if ($unique_chat_ids) {
            foreach ($unique_chat_ids as $unique_chat_id) {
                $chats[] = Chatting::with([$with_param])
                    ->where(['user_id' => $request->user()->id, $id_param => $unique_chat_id])
                    ->whereNotNull($id_param)
                    ->latest()
                    ->first();
            }
        }

        return response()->json($chats, 200);
    }

    public function get_message(Request $request, $id)
    {
        // $validator = Validator::make($request->all(), [
        //     'offset' => 'required',
        //     'limit' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        // }
        
        $messages = Chatting::
            where(function ($q) use ($id) {
                $q->where('sender_id', $id)
                ->orWhere('receiver_id', $id);
            })
            ->where(function ($q) use ($request) {
                $q->where('sender_id', $request->user()->id)
                ->orWhere('receiver_id', $request->user()->id);
            })
            ->latest()
            ->get();

        if($messages->count() > 0) {
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
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $message_form = User::find($request->user()->id);

        $chatting = new Chatting();
        $chatting->sender_id = $request->user()->id;
        $chatting->receiver_id = $request->id;
        $chatting->message = $request->message;
        $chatting->seen = 0;

        $chatting->save();

        return response()->json(['message' => $request->message, 'time' => now()], 200);

    }
}
