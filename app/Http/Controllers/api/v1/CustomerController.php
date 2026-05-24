<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\CustomerManager;
use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Model\DeliveryCountryCode;
use App\Model\DeliveryZipCode;
use App\Model\ShippingAddress;
use App\Model\SupportTicket;
use App\Model\SupportTicketConv;
use App\Model\Wishlist;
use App\Traits\CommonTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function App\CPU\translate;

class CustomerController extends Controller
{
    use CommonTrait;

    public function get_customer_profile(Request $request)
    {
        $customer = $request->user()->loadCount(['ads', 'paid_banners']);
        return response()->json($customer, 200);
    }

    public function show($id)
    {
        $user = User::where('is_active', 1)->find($id);

        if (!$user) {
            return response()->json([
                'errors' => [['code' => 'user-001', 'message' => translate('user_not_found')]]
            ], 404);
        }

        return response()->json([
            'user' => Helpers::publicSellerProfile($user),
        ], 200);
    }

    public function update_profile(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;
        $user->phone_code = $request->phone_code;
        $user->phone = $request->phone;
        $user->show_phone_number = $request->show_phone_number;
        $user->show_email_address = $request->show_email_address;
        $user->native_language = $request->native_language;
        $user->street_address_type = $request->street_address_type;
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->street_address = $request->street_address;
        $user->show_location_data = $request->show_location_data;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        // Avatar arrives as a multipart file part named `image` (mobile
        // sends it via POST so PHP populates the body). Stored under
        // profile/images/ as webp, matching the web profile flow; update()
        // also clears the previous avatar file.
        if ($request->hasFile('image')) {
            $user->image = ImageManager::update('profile/images/', $user->image, 'webp', $request->file('image'));
        }

        $user->save();

        return response()->json($user, 200);
    }

    public function get_customer_ads(Request $request)
    {
        $customer_ads = $request->user()->ads()->with(['category', 'brand', 'model'])->paginate(10);
        return response()->json($customer_ads, 200);
    }

    public function info(Request $request)
    {
        $user = $request->user();

        $wishlists = Wishlist::whereHas('wishlistAd')->where('customer_id', $user->id)->count();

        $data = [
            'customer' => $user,
            'wishlists' => $wishlists,
        ];
        return response()->json($data, 200);
    }

    public function create_support_ticket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'type' => 'required',
            'description' => 'required',
            'priority' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $request['customer_id'] = $request->user()->id;
        $request['status'] = 'pending';

        CustomerManager::create_support_ticket($request);

        return response()->json(['message' => 'Support ticket created successfully.'], 200);
    }

    public function account_delete(Request $request)
    {
        $user = $request->user();

        ImageManager::delete('/profile/' . $user['image']);

        $user->delete();
        return response()->json(['message' => 'Your account has been deleted successfully'], 200);
    }

    public function reply_support_ticket(Request $request, $ticket_id)
    {
        $ticket = SupportTicket::where('customer_id', $request->user()->id)
            ->where('id', $ticket_id)
            ->first();

        if (!$ticket) {
            return response()->json(['message' => translate('ticket_not_found')], 404);
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $ticket->status = 'open';
        $ticket->save();

        $support = new SupportTicketConv();
        $support->support_ticket_id = $ticket_id;
        $support->admin_id = null;
        $support->customer_message = $request['message'];
        $support->save();

        return response()->json(['message' => 'Support ticket reply sent.'], 200);
    }

    public function support_ticket_close(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $updated = SupportTicket::where('id', $request->ticket_id)
            ->where('customer_id', $request->user()->id)
            ->update([
                'status' => 'close',
                'updated_at' => now(),
            ]);

        if (!$updated) {
            return response()->json(['message' => translate('ticket_not_found')], 404);
        }

        return response()->json(['message' => translate('ticket_closed')], 200);
    }

    public function get_support_tickets(Request $request)
    {
        $customer_support_tickets = SupportTicket::where('customer_id', $request->user()->id)
            ->latest()
            ->paginate(15);
        return response()->json($customer_support_tickets, 200);
    }

    public function get_support_ticket_conv(Request $request, $ticket_id)
    {
        $ticket = SupportTicket::where('customer_id', $request->user()->id)
            ->where('id', $ticket_id)
            ->first();

        if (!$ticket) {
            return response()->json(['message' => translate('ticket_not_found')], 404);
        }

        $customer_tickets_convs = SupportTicketConv::where('support_ticket_id', $ticket_id)
            ->oldest()
            ->paginate(20);
        return response()->json($customer_tickets_convs, 200);
    }

    public function add_to_wishlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ad_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $wishlist = Wishlist::where('customer_id', $request->user()->id)
        ->where('ad_id', $request->ad_id)
        ->first();

        if (empty($wishlist)) {
            $wishlist = new Wishlist;
            $wishlist->customer_id = $request->user()->id;
            $wishlist->ad_id = $request->ad_id;
            $wishlist->save();
            return response()->json(['message' => translate('successfully added!')], 200);
        }

        return response()->json(['message' => translate('Already in your wishlist')], 409);
    }

    public function remove_from_wishlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ad_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $wishlist = Wishlist::where('customer_id', $request->user()->id)
        ->where('ad_id', $request->ad_id)
        ->first();

        if (!empty($wishlist)) {
            $wishlist->delete();
            return response()->json(['message' => translate('successfully removed!')], 200);
        }

        return response()->json(['message' => translate('No such data found!')], 404);
    }

    public function get_customer_paid_banners(Request $request) {
        $customer_paid_banners = $request->user()->paid_banners()->paginate(10);
        return response()->json($customer_paid_banners, 200);
    }

    public function wish_list(Request $request)
    {
        $wishlist = Wishlist::whereHas('wishlistAd')
            ->with(['wishlistAd' => fn($q) => $q->with(['category', 'brand', 'model'])])
            ->where('customer_id', $request->user()->id)
            ->latest()
            ->paginate(15);

        return response()->json($wishlist, 200);
    }

    public function address_list(Request $request)
    {
        $user = Helpers::get_customer($request);
        if ($user == 'offline') {
            $data = ShippingAddress::where(['customer_id' => $request->guest_id, 'is_guest' => 1])->latest()->get();
        } else {
            $data = ShippingAddress::where(['customer_id' => $user->id, 'is_guest' => '0'])->latest()->get();
        }
        return response()->json($data, 200);
    }

    public function add_new_address(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_person_name' => 'required',
            'address_type' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'is_billing' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $zip_restrict_status = Helpers::get_business_settings('delivery_zip_code_area_restriction');
        $country_restrict_status = Helpers::get_business_settings('delivery_country_restriction');

        if ($country_restrict_status && !self::delivery_country_exist_check($request->input('country'))) {
            return response()->json(['message' => translate('Delivery_unavailable_for_this_country')], 403);
        } elseif ($zip_restrict_status && !self::delivery_zipcode_exist_check($request->input('zip'))) {
            return response()->json(['message' => translate('Delivery_unavailable_for_this_zip_code_area')], 403);
        }

        $user = Helpers::get_customer($request);
        $address = [
            'customer_id' => $user == 'offline' ? $request->guest_id : $user->id,
            'is_guest' => $user == 'offline' ? 1 : 0,
            'contact_person_name' => $request->contact_person_name,
            'address_type' => $request->address_type,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'country' => $request->country,
            'email' => $request->email,
            'phone' => $request->phone,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_billing' => $request->is_billing,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        ShippingAddress::insert($address);
        return response()->json(['message' => translate('successfully added!')], 200);
    }

    public function update_address(Request $request)
    {
        $user = Helpers::get_customer($request);
        $shipping_address = ShippingAddress::where([
            'customer_id' => $user == 'offline' ? $request->guest_id : $user->id,
            'id' => $request->id
        ])->first();

        if (!$shipping_address) {
            return response()->json(['message' => translate('not_found')], 404);
        }

        $zip_restrict_status = Helpers::get_business_settings('delivery_zip_code_area_restriction');
        $country_restrict_status = Helpers::get_business_settings('delivery_country_restriction');

        if ($country_restrict_status && !self::delivery_country_exist_check($request->input('country'))) {
            return response()->json(['message' => translate('Delivery_unavailable_for_this_country')], 403);
        } elseif ($zip_restrict_status && !self::delivery_zipcode_exist_check($request->input('zip'))) {
            return response()->json(['message' => translate('Delivery_unavailable_for_this_zip_code_area')], 403);
        }

        $shipping_address->update([
            'contact_person_name' => $request->contact_person_name,
            'address_type' => $request->address_type,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'country' => $request->country,
            'phone' => $request->phone,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_billing' => $request->is_billing,
            'updated_at' => now(),
        ]);

        return response()->json(['message' => translate('update_successful')], 200);
    }

    public function delete_address(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        if (DB::table('shipping_addresses')->where(['id' => $request['address_id'], 'customer_id' => $request->user()->id])->first()) {
            DB::table('shipping_addresses')->where(['id' => $request['address_id'], 'customer_id' => $request->user()->id])->delete();
            return response()->json(['message' => 'successfully removed!'], 200);
        }
        return response()->json(['message' => translate('No such data found!')], 404);
    }

    public function get_address(Request $request, $id)
    {
        $address = ShippingAddress::where([
            'id' => $id,
            'customer_id' => $request->user()->id,
        ])->first();

        if (!$address) {
            return response()->json(['message' => translate('not_found')], 404);
        }

        return response()->json($address, 200);
    }

    public function update_cm_firebase_token(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cm_firebase_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        DB::table('users')->where('id', $request->user()->id)->update([
            'cm_firebase_token' => $request['cm_firebase_token'],
        ]);

        return response()->json(['message' => translate('successfully updated!')], 200);
    }

    public function get_restricted_country_list(Request $request)
    {
        $country_restriction = Helpers::get_business_settings('delivery_country_restriction');

        $stored_countries = array_flip(DeliveryCountryCode::orderBy('country_code', 'ASC')->pluck('country_code')->toArray());
        $country_list = defined('COUNTRIES') ? COUNTRIES : [];

        $countries = [];

        if ($country_restriction) {
            foreach ($country_list as $country) {
                if (isset($stored_countries[$country['code']])) {
                    $countries[] = [
                        'code' => $country['code'],
                        'name' => $country['name']
                    ];
                }
            }
        } else {
            foreach ($country_list as $country) {
                $countries[] = [
                    'code' => $country['code'],
                    'name' => $country['name']
                ];
            }
        }

        return response()->json($countries, 200);
    }

    public function get_restricted_zip_list(Request $request)
    {
        $zipcodes = DeliveryZipCode::orderBy('zipcode', 'ASC')
            ->when($request->search, function ($query) use ($request) {
                $query->where('zipcode', 'like', "%{$request->search}%");
            })
            ->get();

        return response()->json($zipcodes, 200);
    }
}
