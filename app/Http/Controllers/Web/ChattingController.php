<?php

namespace App\Http\Controllers\Web;

use Auth;
use App\Model\Ad;
use App\CPU\Helpers;
use App\Model\Order;
use App\Models\User;
use App\Model\Seller;
use App\Model\Chatting;
use App\Model\Wishlist;
use App\Model\AdAuction;
use App\CPU\ImageManager;
use App\Model\DeliveryMan;
use App\CPU\BackEndHelper;
use App\Model\AdAskingPrice;
use Illuminate\Http\Request;
use App\Model\ProductCompare;
use function App\CPU\translate;
use function App\CPU\specificTranslate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Faker\Extension\Helper;
use Illuminate\Support\Facades\Validator;

class ChattingController extends Controller
{
    public function __construct(
        private Order $order,
        private Wishlist $wishlist,
        private ProductCompare $compare,

    )
    {

    }
    public function chat_list(Request $request, $type)
    {

        if ($type == 'user')
        {
            $last_chat = Chatting::where('sender_id', auth('customer')->id())
            ->orWhere('receiver_id', auth('customer')->id())
            ->whereNotNull(['sender_id', 'receiver_id'])
            ->orderBy('created_at', 'DESC')
            ->first();

            $user = User::select('id', 'name', 'image')->find(request()->id);

            if (isset($last_chat)) {

                $userId = auth('customer')->id();

                $unique_chats = Chatting::where('sender_id', $userId)
                ->orWhere('receiver_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get()
                ->unique(function ($chat) use ($userId) {
                    return $chat->sender_id === $userId ? $chat->receiver_id : $chat->sender_id;
                });

                $id = $unique_chats->first()->sender_id == $userId ? 
                    $unique_chats->first()->receiver_id :
                $unique_chats->first()->sender_id;

                $user = User::select('id', 'name', 'image')->find(request()->id ?? $id);

                $chatting = Chatting::where('sender_id', $userId)
                ->orWhere('receiver_id', $userId)
                ->get();

                $chat_with = $unique_chats->count() > 0 && !request()->id
                ? ($unique_chats[0]->sender_id == auth('customer')->id()
                    ? $unique_chats[0]->receiver_id
                    : $unique_chats[0]->sender_id)
                : request()->id;

                Chatting::where('sender_id', $chat_with)
                ->where('receiver_id', $userId)
                ->update(['seen' =>1]);
                
                $filteredChats = $chatting->filter(function ($chat) use ($chat_with) {
                    return $chat->sender_id == $chat_with || $chat->receiver_id == $chat_with;
                });

                // /*Unseen Message Count*/
                $unique_chats?->map(function($unique_chat){
                    $unique_chat['unseen_message_count'] = Chatting::where([
                        'sender_id' =>$unique_chat->sender_id === auth('customer')->id() ? $unique_chat->receiver_id : $unique_chat->sender_id,
                        'receiver_id'=>auth('customer')->id(),
                        'seen'=>0,
                    ])->count();
                });
                /*End Unseen Message*/

                return view(VIEW_FILE_NAMES['user_inbox'], compact('chatting', 'chat_with', 'filteredChats', 
                'unique_chats', 'last_chat', 'user'));
            }
        }
        
        return view(VIEW_FILE_NAMES['user_inbox']);

    }
    
    public function messages(Request $request)
    {
        if ($request->has('shop_id'))
        {
            Chatting::where(['user_id'=>auth('customer')->id(), 'shop_id'=> $request->shop_id])->update([
                'seen' => 1
            ]);

            $shops = Chatting::join('shops', 'shops.id', '=', 'chattings.shop_id')
                ->select('chattings.*', 'shops.name', 'shops.image')
                ->where('user_id', auth('customer')->id())
                ->where('chattings.shop_id', json_decode($request->shop_id))
                ->orderBy('created_at', 'ASC')
                ->get();
        }
        elseif ($request->has('delivery_man_id'))
        {
            Chatting::where(['user_id'=>auth('customer')->id(), 'delivery_man_id'=> $request->delivery_man_id])->update([
                'seen' => 1
            ]);

            $shops = Chatting::join('delivery_men', 'delivery_men.id', '=', 'chattings.delivery_man_id')
                ->select('chattings.*',  'delivery_men.f_name','delivery_men.l_name', 'delivery_men.image')
                ->where('user_id', auth('customer')->id())
                ->where('chattings.delivery_man_id', json_decode($request->delivery_man_id))
                ->orderBy('created_at', 'ASC')
                ->get();
        }
        return response()->json($shops);


    }

    public function chat_with_seller(Request $request) {

        $is_profile_completed = Helpers::json_prevent_if_profile_incomplete();

        if ($is_profile_completed) {
            return response()->json(['error_message'=>translate('you_must_complete_your_profile_first_to_be_able_to_contact_the_seller')]);
        }

        if ($request->image == null && $request->message == '') {
            return response()->json(['error_message'=>translate('type_something')]);
        }

        if(auth('customer')->id() == $request->seller_id) {
            return response()->json(['error_message'=>translate('you_cant_send_message_to_yourself')]);
        }

        $ad = Ad::findOrFail($request->ad_id);

        if ($request->has('seller_id'))
        {
            Chatting::create([
                'sender_id'          => auth('customer')->id(),
                'receiver_id'        => $request->seller_id,
                'message'          => $request->message,
                'attachment'       => $ad->id,
                'seen' => 0,
                'created_at'       => now(),
            ]);
        }

        return response()->json([
            'message'=>$request->message
        ]);

    }

    public function messages_store(Request $request)
    {

        $is_profile_completed = Helpers::json_prevent_if_profile_incomplete();

        if ($is_profile_completed) {
            return response()->json(['error_message'=>translate('you_must_complete_your_profile_first_to_be_able_to_contact_the_seller')]);
        }

        if ($request->image == null && $request->message == '') {
            return response()->json(['error_message'=>translate('type_something')]);
        }

        if(auth('customer')->id() == $request->seller_id) {
            return response()->json(['error_message'=>translate('you_cant_send_message_to_yourself')]);
        }

        $image = [];

        if ($request->file('image')) {
            $validator = Validator::make($request->all(), [
                'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:6000'
            ]);
            if ($validator->fails()) {
                return response()->json(translate('The_file_must_be_an_image').'!', 403);
            }
            foreach ($request->image as $key=>$value) {
                $image_name = ImageManager::upload('chatting/', 'webp', $value, 'def.jpg');
                $image[] = $image_name;
            }
        }

        $ad = Ad::with('auctions', 'askingPrice', 'user')->find($request->ad_id);

        $offer_price = $request->message_type == 'make_an_offer' ? $request->auction_price : $request->asking_price;

        $seller_profile = User::find($request->seller_id);

        $message_language = $seller_profile->native_language && auth('customer')->user()->native_language && 
            $seller_profile->native_language == auth('customer')->user()->native_language ?
        auth('customer')->user()->native_language : 'en';

        $message =
        specificTranslate('dear', $message_language) . ' ' . $ad->user->f_name . ",<br>" .
        specificTranslate('i_would_like_to_offer', $message_language) . ' ' . BackEndHelper::set_currency($ad->currency). $offer_price . ' ' . specificTranslate('for_your_listing', $message_language) . ' "' . $ad->title . "\".<br>" .
        specificTranslate('i_look_forward_to_hearing_from_you', $message_language) . ",<br>" .
        specificTranslate('kind_regards', $message_language) . ",<br>" .
        auth('customer')->user()->f_name . ' ' . auth('customer')->user()->l_name;

        $message_form = User::find(auth('customer')->id());

        if ($request->has('seller_id'))
        {
            Chatting::create([
                'sender_id'          => auth('customer')->id(),
                'receiver_id'        => $request->seller_id,
                'message'          => $message,
                'attachment'       => json_encode($image),
                'seen' => 0,
                'created_at'       => now(),
            ]);
            // $seller = User::find($request->seller_id);
            // Helpers::chatting_notification('message_from_customer','seller',$seller,$message_form);
        }

        if($request->message_type && $request->message_type == 'make_an_offer') {

            $last_auction_price = $ad->auctions->count() > 0
                ? $ad->auctions()->latest()->value('price') 
            : ($ad->starting_price ? $ad->starting_price : 0);

            if($ad->auctions->count() && $ad->auctions->contains('user_id', auth('customer')->id())) {
                return response()->json(['error_message'=>translate('you_already_send_an_offer_to_this_ad')]);
            }

            if($request->auction_price <= $last_auction_price) {
                return response()->json(['error_message'=>translate('the_offer_price_must_be_greater_than_the_starting_price_or_the_last_offer_price')]);
            }

            $auction = new AdAuction();

            $auction->ad_id = $ad->id;
            $auction->user_id = auth('customer')->id();
            $auction->price = $request->auction_price;

            $auction->save();
        }

        if($request->message_type && $request->message_type == 'asking_price') {
    
            if($ad->askingPrice->count() && $ad->askingPrice->contains('user_id', auth('customer')->id())) {
                return response()->json(['error_message'=>translate('you_already_send_an_negotiate_price_to_this_ad')]);
            }
    
            $last_asking_price = $ad->askingPrice->count() > 0 
            ? $ad->askingPrice()->latest()->value('price') 
            : ($ad->starting_price ? $ad->starting_price : 0);
    
            if($request->asking_price < $last_asking_price) {
                return response()->json(['error_message'=>translate('the_offer_price_must_be_greater_than_the_starting_price_or_the_last_offer_price')]);
            } 
    
            $asking_price = new AdAskingPrice();
    
            $asking_price->ad_id = $ad->id;
            $asking_price->user_id = auth('customer')->id();
            $asking_price->price = $request->asking_price;
    
            $asking_price->save();
    
        }

        return response()->json(['message'=>$message,'image'=>$image]);
    }

    public function discussion_store(Request $request)
    {
        $message_form = User::find(auth('customer')->id());

        if ($request->image == null && $request->message == '') {
            return response()->json(translate('type_something').'!', 403);
        }

        $image = [];

        if ($request->file('image')) {
            $validator = Validator::make($request->all(), [
                'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:6000'
            ]);
            if ($validator->fails()) {
                return response()->json(translate('The_file_must_be_an_image').'!', 403);
            }
            foreach ($request->image as $key=>$value) {
                $image_name = ImageManager::upload('chatting/', 'webp', $value, 'def.jpg');
                $image[] = $image_name;
            }
        }

        if ($request->has('chat_with'))
        {
            $message = $request->message;
            Chatting::create([
                'sender_id'          => auth('customer')->id(),
                'receiver_id'        => $request->chat_with,
                'message'          => $request->message,
                'attachment'       => json_encode($image),
                'seen' => 0,
                'created_at'       => now(),
            ]);
            // $seller = User::find($request->seller_id);
            // Helpers::chatting_notification('message_from_customer','seller',$seller,$message_form);
        }

        return response()->json(['message'=>$message,'image'=>$image]);
    }

}
