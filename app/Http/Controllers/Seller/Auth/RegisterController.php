<?php

namespace App\Http\Controllers\Seller\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovalWaitingMail;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Model\Shop;
use Illuminate\Support\Str;
use App\Model\SellerHelpTopic;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CPU\Helpers;
use Illuminate\Support\Facades\Session;
use function App\CPU\translate;

class RegisterController extends Controller
{
    public function create()
    {
        $business_mode=Helpers::get_business_settings('business_mode');
        $seller_registration=Helpers::get_business_settings('seller_registration');
        if((isset($business_mode) && $business_mode=='single') || (isset($seller_registration) && $seller_registration==0))
        {
            Toastr::warning(translate('access_denied!!'));
            return redirect('/');
        }

        $helps = SellerHelpTopic::Status()->latest()->get();

        return view(VIEW_FILE_NAMES['seller_registration'], compact('helps'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'logo'          => 'required|mimes: jpg,jpeg,png,gif',
            'banner'        => 'required|mimes: jpg,jpeg,png,gif',
            'bottom_banner' => 'mimes: jpg,jpeg,png,gif',
            'email'         => 'required|unique:sellers',
            'shop_address'  => 'required',
            'refund_address'  => 'required',
            'f_name'        => 'required',
            'l_name'        => 'required',
            'shop_name'     => 'required',
            'password'      => 'required|min:8'
        ],
        [

            'logo.required'  => translate('logo_name_is_required').'!',
            'banner.required'  => translate('banner_name_is_required').'!',
            'bottom_banner.required'  => translate('bottom_banner_name_is_required').'!',
            'shop_address.required'  => translate('shop_address_is_required').'!',
            'refund_address.required'  => translate('refund_address_is_required').'!',
        ]
        );

        if($request['from_submit'] != 'admin') {
            //recaptcha validation
            $recaptcha = Helpers::get_business_settings('recaptcha');
            if (isset($recaptcha) && $recaptcha['status'] == 1) {
                try {
                    $request->validate([
                        'g-recaptcha-response' => [
                            function ($attribute, $value, $fail) {
                                $secret_key = Helpers::get_business_settings('recaptcha')['secret_key'];
                                $response = $value;
                                $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $response;
                                $response = \file_get_contents($url);
                                $response = json_decode($response);
                                if (!$response->success) {
                                    $fail(\App\CPU\translate('ReCAPTCHA Failed'));
                                }
                            },
                        ],
                    ]);
                } catch (\Exception $exception) {
                }
            } else {
                if (strtolower($request->default_recaptcha_id_seller_regi) != strtolower(Session('default_recaptcha_id_seller_regi'))) {
                    Session::forget('default_recaptcha_id_seller_regi');
                    return back()->withErrors(\App\CPU\translate('Captcha Failed'));
                }
            }
        }

        DB::transaction(function ($r) use ($request) {
            $seller = new Seller();
            $seller->seller_id = 'Sl'.Str::random(6);
            $seller->f_name = $request->f_name;
            $seller->l_name = $request->l_name;
            $seller->phone = $request->phone;
            $seller->email = $request->email;
            $seller->swift = $request->swift;
            $seller->country = $request->country;
            $seller->city = $request->city;
            $seller->street_address = $request->street_address;
            $seller->house_number = $request->house_number;
            $seller->postal_code = $request->postal_code;
            $seller->date_of_birth = $request->date_of_birth;
            $seller->sex = $request->sex;
            $seller->nationality = $request->nationality;
            $seller->image = ImageManager::upload('seller/', 'webp', $request->file('image'), 'def.jpg');
            $seller->password = bcrypt($request->password);
            $seller->status =  $request->status == 'approved'?'approved': "pending";
            $seller->save();

            $shop = new Shop();
            $shop->seller_id = $seller->id;
            $shop->name = $request->shop_name;
            $shop->address = $request->shop_address;
            $shop->refund_address = $request->refund_address;
            $shop->business_model = $request->business_model;
            // $shop->business_model = $request->business_model;
            $shop->product_category = $request->product_category;
            $shop->business_country = $request->business_country;
            $shop->business_city = $request->business_city;
            $shop->business_street_address = $request->business_street_address;
            $shop->business_place_number = $request->business_place_number;
            $shop->business_phone = $request->business_phone;
            $shop->shipping_info = json_encode($request->shipping_info);
            $shop->business_email = $request->business_email;
            // $shop->company_type = $request->company_type;
            $shop->optional_tax_number = $request->optional_tax_number;
            $shop->optional_commercial_register = $request->optional_commercial_register;
            $shop->business_model_other=$request->business_model_other;
            $shop->product_category_other = $request->product_category_other;
            $uploadedImagesProduct = [];

        {
            foreach($request->file('product_images') as $image)
            {
                $uploadedImage = ImageManager::upload('shop/product/', 'webp', $image, 'def.jpg');
                array_push($uploadedImagesProduct, $uploadedImage);
            }
        }

        $shop->images_product = json_encode($uploadedImagesProduct);
            $shop->image = ImageManager::upload('shop/', 'webp', $request->file('logo'), 'def.jpg');
            $shop->banner = ImageManager::upload('shop/banner/', 'webp', $request->file('banner'), 'def.jpg');
            $shop->bottom_banner = ImageManager::upload('shop/banner/', 'webp', $request->file('bottom_banner'), 'def.jpg');
            $shop->save();

            DB::table('seller_wallets')->insert([
                'seller_id' => $seller['id'],
                'withdrawn' => 0,
                'commission_given' => 0,
                'total_earning' => 0,
                'pending_withdraw' => 0,
                'delivery_charge_earned' => 0,
                'collected_cash' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        });

        $seller = Seller::select('id', 'seller_id', 'email')->where('email', $request->email)->get()->first();

        session(['seller_prefered_language'=> session('local') ?? 'en']);
        
        \Log::debug(session('local'));

        if($request->status == 'approved'){
            Toastr::success(translate('shop_apply_successfully'));
            
            Mail::to($request->email)->send(new ApprovalWaitingMail(translate('shop_apply_successfully'), $seller->seller_id));
            session()->forget('seller_prefered_language');
        

            return back();
        }else{
            Toastr::success(translate('shop_apply_successfully'));

            Mail::to($request->email)->send(new ApprovalWaitingMail($seller->seller_id));
            session()->forget('seller_prefered_language');

            return redirect()->route('seller.auth.login');
        }

    }

    

}
