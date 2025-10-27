@extends('theme-views.layouts.app')

@section('title', translate('Seller_Apply').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@section('content')



<style>

.banner-image-holder {
    height: 138px;
    width: 100%;
    object-fit: cover;
}


/* استهداف الجوالات بشاشات عرض تصل إلى 768px */
@media (max-width: 768px) {
    .footer {
        display: none;
    }
    .header {
        display: none;
    }
    .feature-section,
    .feature-secton { /* إخفاء القسم الذي ذكرته */
        display: none;
    }
    .app-bar {
        display: none;
    }
    .offer-bar {
        display: none;
    }
    .up-header {
        display: none;
    }
      #cookie-section { /* إخفاء قسم الكوكيز */
        display: none;
    }
    
       .cookies {
 
    display: none;
           
       } 
}

/* استهداف الأجهزة بشاشات عرض تصل إلى 1024px (مثل iPad Pro 11 بوصة) */
@media (max-width: 1024px) {
    .footer {
        display: none;
    }
    .header {
        display: none;
    }
    .feature-section,
    .feature-secton { /* إخفاء القسم الذي ذكرته */
        display: none;
    }
    .app-bar {
        display: none;
    }
    .offer-bar {
        display: none;
    }
    .up-header {
        display: none;
    }
    #cookie-section { /* إخفاء قسم الكوكيز */
        display: none;
    }
    
       .cookies {
 
    display: none;
} 
}

/* استهداف الأجهزة بشاشات عرض تصل إلى 1366px (مثل iPad Pro 12.9 بوصة) */
@media (max-width: 1406px) {
    .footer {
        display: none;
    }
    .header {
        display: none;
    }
    .feature-section,
    .feature-secton { /* إخفاء القسم الذي ذكرته */
        display: none;
    }
    .app-bar {
        display: none;
    }
    .offer-bar {
        display: none;
    }
    .up-header {
        display: none;
    }
    #cookie-section { /* إخفاء قسم الكوكيز */
        display: none;
    }
   .cookies {
 
    display: none;
} 
}


.select2-container {

    min-width: 100%;


}


.image-box-uplade
{
    border-width: 1px;
    border-style: solid;
    border-color:#c4c4c4;
    display: flex;
    justify-content: center;
    padding: 16px;
    flex-wrap: nowrap;
    flex-direction: column;
    align-content: center;
    align-items: center;
    border-radius: 7px;


}
    .imgPreview img {
        padding: 8px;
        max-width: 100px;

    background: #ebebeb;
    padding: 20px;
    margin: 10px;
    border-radius: 20px;
    }


.upload-file__inputt{
    position: absolute;
    inset-inline-start: 0;
    inset-block-start: 0;
    inline-size: 100%;
    block-size: 100%;
    opacity: 0;
    cursor: pointer;
}
.actions.clearfix {
    margin-top: 25px;
}

@media (min-width: 1200px) {
    .width-75-percent {
        width: 75%;
    }
}

.steps.clearfix {
    /* right: 20px; */
    @if(Session::get('direction') === "rtl")
        right: 20px !important;
    @else
        left: 20px !important;
    @endif
}


</style>
    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 mb-sm-5">
        <div class="container">
            <div class="card">
                <div class="card-body p-sm-4">
                    <div class="row justify-content-between gy-4">
                    
                        <div class="col-lg-3">
                            <div class="rounded h-100">
                                <div class="d-flex">
                                    <div class="ext-center">
                                        <h2 class="mb-2">{{translate('Seller_Registration')}}</h2>
                                        <p class="text-primary d-none">{{translate('Open_your_and_start_selling.')}} {{translate('Create_your_own_business')}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    

                        <div class="col-lg-9 col-xl-8">

                            

                            <form id="seller-registration" class="pt-1 margin-top-295-on-small-screen" action="{{route('shop.apply')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="wizard">
                                    <h3>{{translate('Seller_Info')}}</h3>
                                    <section>
                                        <div class="row">

                                            <div class="py-2 pb-4" >
                                                <p>
                                                    {{translate('Create_your_own_store.')}} {{translate('Already_have_store')}}?
                                                    <a class="text-primary fw-bold" href="{{route('seller.auth.login')}}">
                                                        {{translate('Login')}}
                                                    </a>
                                                </p>                        
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="firstName">{{translate('First_Name')}} *</label>
                                                    <input class="form-control" type="text" id="firstName" name="f_name" value="{{old('f_name')}}" placeholder="{{translate('Ex')}} : Jhon" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="Last_Name">{{translate('Last_Name')}} *</label>
                                                    <input class="form-control" type="text" id="lastName" name="l_name" value="{{old('l_name')}}" placeholder="{{translate('Ex')}} : Doe" required>
                                                </div>
                                            </div>
                                            <!--<div class="col-lg-6">-->
                                            <!--    <div class="form-group mb-4">-->
                                            <!--        <label for="date_of_birth">{{ translate('date_of_birth') }} </label>-->
                                            <!--        <input class="form-control datepicker" type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" placeholder="{{ translate('Ex') }}: 2024/12/31" >-->
                                            <!--    </div>-->
                                            <!--</div>-->

                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="nationality">{{translate('nationality')}} </label>
                                                    <input class="form-control" type="text" id="nationality" name="nationality" value="{{old('nationality')}}" placeholder="{{translate('Ex')}} : USA" >
                                                </div>
                                            </div>
                                            <!--<div class="col-lg-6">-->
                                            <!--    <div class="form-group mb-4">-->
                                            <!--        <label for="sex">{{translate('Sex')}} </label>-->
                                            <!--        <select class="form-control " id="sex" name="sex" required>-->
                                            <!--            <option value="Male"  >{{ translate('Male') }}</option>-->
                                            <!--            <option value="Female"  >{{ translate('Female') }}</option>-->

                                            <!--        </select>-->
                                            <!--      </div>-->
                                            <!--</div>-->
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="email2">{{translate('Email')}} *</label>
                                                    <input class="form-control" type="email" id="email2"  name="email" value="{{old('email')}}" placeholder="{{translate('Enter_email')}}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group mb-3">
                                                    <label for="tel">{{translate('Phone')}} </label>
                                                    <input class="form-control" type="tel" id="tel" name="phone" value="{{old('phone')}}" placeholder="{{translate('Enter_phone_number')}}" >
                                                </div>
                                            </div>

                                        </div>
                                    </section>

                                    <h3>{{translate('Seller_Additional_Info')}}</h3>
                                    <section>
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div class="image-box-uplade">
                                                    <label class="m-0" for="city">{{translate('upload_samples_of_your_products')}} </label>
                                                    <div class="user-image mb-3 text-center ">
                                                        <div class="imgPreview"> </div>
                                                    </div>
                                                    <div class="custom-file text-center">
                                                        <div class="upload-file">
                                                            <input type="file" class="upload-file__inputt" id="images" multiple name="product_images[]" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                                            <div class="upload-file__img style--two">
                                                                <div class="temp-img-box">
                                                                    <div class="d-flex align-items-center flex-column gap-2">
                                                                        <i class="bi bi-upload fs-30"></i>
                                                                        <div class="fs-12 text-muted">{{translate('Upload_File')}}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="country">{{ translate('country') }} </label>
                                                    <select class="form-control " id="country" name="country" >
                                                        <option value="" disabled selected>{{ translate('Select Country') }}</option>
                                                        @foreach (COUNTRIES as $country)
                                                            <option value="{{ $country['code'] }}">{{ $country['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="city">{{translate('city')}} </label>
                                                    <input class="form-control" type="text" id="city" name="city" value="{{old('city')}}" placeholder="{{translate('Ex')}} : city" >
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="password">{{translate('Password')}} *</label>
                                                    <div class="input-inner-end-ele">
                                                        <input class="form-control" type="password" id="password"  name="password" value="{{old('password')}}" placeholder="{{translate('Enter_password')}}" required>
                                                        <i class="bi bi-eye-slash-fill togglePassword"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="repeat_password">{{translate('Confirm_Password')}} *</label>
                                                    <div class="input-inner-end-ele">
                                                        <input class="form-control" type="password" id="repeat_password" name="repeat_password" placeholder="{{translate('repeat_password')}}" required>
                                                        <i class="bi bi-eye-slash-fill togglePassword"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <h3>{{translate('Business_Basic_Info')}}</h3>
                                    <section>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="storeName">{{translate('Store_Name')}} *</label>
                                                    <input class="form-control" type="text" id="storeName" name="shop_name" placeholder="{{translate('Ex')}}: {{translate('halar')}}" value="{{old('shop_name')}}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="company_name">{{translate('company_name')}} *</label>
                                                    <input class="form-control" type="text" id="company_name" name="company_name" placeholder="{{translate('Ex')}}: {{translate('company_name')}}" value="{{old('company_name')}}" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="tel">{{translate('business_phone')}} *</label>
                                                    <input class="form-control" type="tel" id="tel" name="business_phone" value="{{old('business_phone')}}" placeholder="{{translate('business_phone')}}" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="business_email">{{translate('business_email')}} *</label>
                                                    <input class="form-control" type="email" id="business_email"  name="business_email" value="{{old('business_email')}}" placeholder="{{translate('Enter_business_email')}}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="product_category">{{translate('product_category')}} *</label>
                                                    <select class="js-select2-custom form-control" name="product_category"
                                                    onchange="getRequest('{{ url('/') }}/admin/product/get-categories?parent_id='+this.value,'sub-category-select','select')"
                                                    required>
                                                <option value="{{ old('product_category') }}" selected disabled>{{ translate('select_category') }}</option>
                                                {{$cat = App\Model\Category::where('parent_id', 0)->get();}}

                                                @foreach ($cat as $c)
                                                    <option value="{{ $c['id'] }}"
                                                        {{ old('product_category') == $c['id'] ? 'selected' : '' }}>
                                                        {{ $c['defaultName'] }}
                                                    </option>

                                                @endforeach
                                                <option value="other"  >
                                                    Other
                                                </option>
                                            </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6" >
                                                <div class="form-group mb-3" id="product_category_other_container" style="display: none;">
                                                    <label for="product_category_other">{{translate('product_category_other')}} </label>
                                                    <input class="form-control" type="text" id="product_category_other" name="product_category_other" value="{{old('product_category_other')}}" >
                                                </div>
                                            </div>                                
                                        </div>
                                    </section>

                                    <h3>{{translate('Business_Administration_Info')}}</h3>
                                    <section>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-3" id="shipping_info">
                                                    <label for="shipping_info">{{ translate('What are the countries or cities to which you can ship your products?') }}</label>
                                                    <span>
                                                        <select
                                                        class="js-example-basic-multiple js-states js-example-responsive form-control color-var-select"
                                                        name="shipping_info[]" multiple="multiple" id="shipping_info" name="shipping_info" 
                                                        placeholder="{{ translate('What are the countries or cities to which you can ship your products?') }}" rows="4">
                                                        @foreach (COUNTRIES as $country)
                                                            <option value="{{ $country['code'] }}">
                                                                {{ $country['name'] }}
                                                            </option>
                                                        @endforeach
                                                        </select>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="business_country">{{ translate('business_country') }} *</label>
                                                    <select class="form-control " id="country" name="business_country" required>
                                                        <option value="" disabled selected>{{ translate('Select Country') }}</option>
                                                        @foreach (COUNTRIES as $country)
                                                            <option value="{{ $country['code'] }}">{{ $country['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="business_city">{{translate('business_city')}} *</label>
                                                    <input class="form-control" type="text" id="business_city" name="business_city" value="{{old('business_city')}}" placeholder="{{translate('Ex_:New York') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group mb-3">
                                                    <label for="storeAddress">{{translate('Store_Address')}} *</label>
                                                    <input class="form-control" type="text" id="storeAddress" name="shop_address" value="{{old('shop_address')}}" placeholder="{{translate('Ex_:_Shop_-12_Road-8') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group mb-3">
                                                    <label for="refundAddress">{{translate('refund_address')}} *</label>
                                                    <input class="form-control" type="text" id="refundAddress" name="refund_address" value="{{old('refund_address')}}" placeholder="{{translate('Ex_:_Shop_-12_Road-8') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="business_street_address">{{translate('business_street_address')}} </label>
                                                    <input class="form-control" type="text" id="business_street_address" name="business_street_address" value="{{old('business_street_address')}}" placeholder="{{translate('Ex_:_Shop_-12_Road-8') }}" >
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="business_place_number">{{translate('business_place_number')}} </label>
                                                    <input class="form-control" type="text" id="business_place_number" name="business_place_number" value="{{old('business_place_number')}}" placeholder="{{translate('Ex_:143') }}" >
                                                </div>
                                            </div>

                                            {{--
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-3">
                                                        <label for="business_model">{{translate('business_model')}} *</label>
                                                        <input class="form-control" type="text" id="business_model" name="business_model" value="{{ old('business_model') }}" placeholder="Ex: Online Retail">
                                                    </div>
                                                </div>
                                            --}}
                                                
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="business_model">{{ translate('business_model') }} *</label>
                                                    <select class="form-control" id="country" name="business_model" required>
                                                        <option value="Corporation">{{ translate('Corporation') }}</option>
                                                        <option value="Limited Liability Company (LLC)">{{ translate('Limited Liability Company (LLC)') }}</option>
                                                        <option value="Partnership">{{ translate('Partnership') }}</option>
                                                        <option value="Sole Proprietorship">{{ translate('Sole Proprietorship') }}</option>
                                                        <option value="Cooperative">{{ translate('Cooperative') }}</option>
                                                        <option value="Nonprofit Organization">{{ translate('Nonprofit Organization') }}</option>
                                                        <option value="Joint Venture">{{ translate('Joint Venture') }}</option>
                                                        <option value="Franchise">{{ translate('Franchise') }}</option>
                                                        <option value="S Corporation">{{ translate('S Corporation') }}</option>
                                                        <option value="Holding Company">{{ translate('Holding Company') }}</option>
                                                        <option value="Subsidiary Company">{{ translate('Subsidiary Company') }}</option>
                                                        <option value="Public Company">{{ translate('Public Company') }}</option>
                                                        <option value="Private Company">{{ translate('Private Company') }}</option>
                                                        <option value="State-Owned Enterprise (SOE)">{{ translate('State-Owned Enterprise (SOE)') }}</option>
                                                        <option value="Social Enterprise">{{ translate('Social Enterprise') }}</option>
                                                        <option value="Mutual Company">{{ translate('Mutual Company') }}</option>
                                                        <option value="Trust Company">{{ translate('Trust Company') }}</option>
                                                        <option value="Professional Corporation (PC)">{{ translate('Professional Corporation (PC)') }}</option>
                                                        <option value="Benefit Corporation">{{ translate('Benefit Corporation') }}</option>
                                                        <option value="Cooperative Corporation">{{ translate('Cooperative Corporation') }}</option>
                                                        <option value="other">{{ translate('other') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6" id="business_model_other_container" style="display: none;" >
                                                <div class="form-group mb-3" >
                                                    <label for="business_model_other">{{translate('business_model_other')}} </label>
                                                    <input class="form-control" type="text" id="business_model_other" name="business_model_other" value="{{old('business_model_other')}}" >
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group mb-4">
                                                    <label for="optional_tax_number">{{translate('Tax_number')}} *</label>
                                                    <input class="form-control" type="text" id="optional_tax_number" name="optional_tax_number" value="{{old('optional_tax_number')}}" placeholder="{{translate('Ex_:123456789') }}" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="optional_commercial_register">{{translate('optional_commercial_register')}} </label>
                                                    <input class="form-control" type="text" id="optional_commercial_register" name="optional_commercial_register" value="{{old('optional_commercial_register')}}" placeholder="{{translate('Ex_:123456789') }}" >
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <div class="d-flex flex-column gap-3 align-items-center">
                                                    <div class="upload-file">
                                                        <input type="file" class="upload-file__input" name="banner" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                                        <div class="upload-file__img style--two" style="--size: 14.75rem !important;height: 140px;">
                                                            <div class="temp-img-box">
                                                                <div class="d-flex w-100 align-items-center flex-column gap-2">
                                                                    <div class="d-flex w-100 align-items-center flex-column gap-2">
                                                                        <img src="{{asset('public/assets\back-end\img\400x400\img2.jpg')}}" class="dark-support border banner-image-holder" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <img src="#" style="object-fit: cover !important;" class="dark-support img-fit-contain border" alt="" hidden>
                                                        </div>
                                                    </div>

                                                    <div class="text-center">
                                                        <h5 class="text-uppercase mb-1">{{translate('Store_Banner')}}</h5>
                                                        <div class="text-muted">{{translate('Image_Ratio')}} 3:1</div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if(theme_root_path() == "theme_aster")
                                                <div class="col-lg-6 mb-3">
                                                    <div class="d-flex flex-column gap-3 align-items-center">
                                                        <div class="upload-file">
                                                            <input type="file" class="upload-file__input" name="bottom_banner" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                                            <div class="upload-file__img style--two" style="--size: 14.75rem !important;height: 140px;">
                                                                <div class="temp-img-box">
                                                                    <div class="d-flex w-100 align-items-center flex-column gap-2">
                                                                        <div class="d-flex w-100 align-items-center flex-column gap-2">
                                                                            <img src="{{asset('public/assets\back-end\img\400x400\img2.jpg')}}" class="dark-support border banner-image-holder" alt="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <img src="#" style="object-fit: cover !important;" class="dark-support img-fit-contain border" alt="" hidden>
                                                            </div>
                                                        </div>

                                                        <div class="text-center">
                                                            <h5 class="text-uppercase mb-1">{{translate('Store_Secondary_Banner')}}</h5>
                                                            <div class="text-muted">{{translate('Image_Ratio')}} 3:1</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="col-lg-6 mb-3">
                                                <div class="d-flex flex-column gap-3 align-items-center">
                                                    <div class="upload-file">
                                                        <input type="file" class="upload-file__input" name="logo" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                                        <div class="upload-file__img">
                                                            <div class="temp-img-box">
                                                                <div class="d-flex align-items-center flex-column gap-2">
                                                                    <i class="bi bi-upload fs-30"></i>
                                                                    <div class="fs-12 text-muted">{{translate('Upload_File')}}</div>
                                                                </div>
                                                            </div>
                                                            <img src="#" class="dark-support img-fit-contain border" alt="" hidden>
                                                        </div>
                                                    </div>

                                                    <div class="text-center">
                                                        <h5 class="text-uppercase mb-1">{{translate('Store_Logo')}}</h5>
                                                        <div class="text-muted">{{translate('Image_Ratio')}} 1:1</div>
                                                    </div>
                                                </div>
                                            </div>


                                            @if($web_config['recaptcha']['status'] == 1)
                                                <div class="col-12">
                                                    <div id="recaptcha_element_seller_regi" class="w-100 mt-4" data-type="image"></div>
                                                    <br/>
                                                </div>
                                            @else
                                                <div class="col-12">
                                                    <div class="row py-2 mt-4">
                                                        <div class="col-6 pr-2">
                                                            <input type="text" class="form-control border __h-40" name="default_recaptcha_id_seller_regi" value=""
                                                                placeholder="{{ translate('Enter_captcha_value') }}" autocomplete="off" required>
                                                        </div>
                                                        <div class="col-6 input-icons mb-2 rounded bg-white">
                                                            <a onclick="re_captcha_seller_regi();" class="d-flex align-items-center align-items-center">
                                                                <img src="{{ URL('/seller/auth/code/captcha/1?captcha_session_id=default_recaptcha_id_seller_regi') }}" class="input-field rounded __h-40" id="default_recaptcha_id_regi">
                                                                <i class="bi bi-arrow-repeat icon cursor-pointer p-2"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="col-12">
                                                <label class="custom-checkbox">
                                                    <input id="acceptTerms" name="acceptTerms" type="checkbox" required>
                                                    {{translate('I_agree_with_the')}} <a target="_blank" href="{{route('terms')}}">{{translate('terms_and_condition')}}.</a>
                                                </label>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </form>
                        </div>

                        @php $length=count($helps); @endphp
                        @php if($length%2!=0){$first=($length+1)/2;}else{$first=$length/2;}@endphp
                        <div class="row mt-4 mb-3" >

                            <div class="my-4 text-center hide-on-large-screens">
                                <img src="{{theme_asset('assets/img/media/seller-registration.jpg')}}" loading="lazy" alt="" class="dark-support">
                            </div>

                            <h2 class="text-center py-4 fs-30" >{{ translate('FAQ_For_Seller') }}</h2>
                            <div class="col-md-6">
                                <div class="container pt-4 mx-auto width-75-percent">
                                    <div class="my-4">
                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            @php($i = 0)
                                            @foreach($helps as $help)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-heading{{ $help['id'] }}">
                                                        <button class="accordion-button mb-2 dashed-border rounded bg-light collapsed text-dark fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $help['id'] }}" aria-expanded="false" aria-controls="flush-collapse{{ $help['id'] }}">
                                                            {{ $help['question'] }}
                                                        </button>
                                                    </h2>
                                                    <div id="flush-collapse{{ $help['id'] }}" class="accordion-collapse collapse {{ $i == 0 ? 'show' : '' }}" aria-labelledby="flush-heading{{ $help['id'] }}" data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            {{ $help['answer'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @php($i++)
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 hide-on-medium-and-small">
                                <div class="my-4 text-center">
                                    <img src="{{theme_asset('assets/img/media/seller-registration.jpg')}}" loading="lazy" alt="" class="dark-support">
                                </div>
                            </div>
                        </div>


                        
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End Main Content -->
@endsection

@push('script')
    <!-- Page Level Scripts -->
    <script src="{{theme_asset('assets/plugins/jquery-step/jquery.validate.min.js')}}"></script>
    <script src="{{theme_asset('assets/plugins/jquery-step/jquery.steps.min.js')}}"></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

@if($web_config['recaptcha']['status'] == '1')
    <script>
        var onloadCallback = function () {
            let reg_id = grecaptcha.render('recaptcha_element_seller_regi', {'sitekey': '{{ $web_config['recaptcha']['site_key'] }}'});
            let login_id = grecaptcha.render('recaptcha_element_seller_login', {'sitekey': '{{ $web_config['recaptcha']['site_key'] }}'});

            $('#recaptcha_element_seller_regi').attr('data-reg-id', reg_id);
            $('#recaptcha_element_seller_login').attr('data-login-id', login_id);
        };
    </script>
@else
    <script>
        function re_captcha_seller_regi() {
            $url = "{{ URL('/seller/auth/code/captcha/') }}";
            $url = $url + "/" + Math.random()+'?captcha_session_id=default_recaptcha_id_seller_regi';

            document.getElementById('default_recaptcha_id_regi').src = $url;
            console.log('url: '+ $url);
        }
    </script>
@endif
<script>
$(document).ready(function(){
    $('.select2').select2({
        placeholder: "{{ translate('Search for a country') }}",
        allowClear: true,
        minimumInputLength: 2 // تحديد عدد الحروف الدنيا لبدء البحث
    });
});
</script>
    <script>
        // Multi Step Form

        $(document).ready(function(){
            $('#seller-registration [href="#next"]').text("{{ translate('next') }}");
            $('#seller-registration [href="#previous"]').text("{{ translate('previous') }}");
        });

        var form = $("#seller-registration");
        form.validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
            rules: {
                password: {
                    minlength: 8
                },
                repeat_password: {
                    equalTo: "#password"
                }
            }
        });

        // Form Wizard
        form.children(".wizard").steps({
            headerTag: "h3",
            bodyTag: "section",
            onStepChanging: function (event, currentIndex, newIndex)
            {
                $('[href="#next"]').text("{{ translate('next') }}");
                $('[href="#previous"]').text("{{ translate('previous') }}");
                $('[href="#finish"]').text("{{ translate('finish') }}");
                $('[href="#finish"]').addClass('disabled');

                $('#acceptTerms').click(function(){
                    if ($(this).is(':checked')) {
                        $('[href="#finish"]').removeClass('disabled');
                    }else{
                        $('[href="#finish"]').addClass('disabled');
                    }
                });

                if (currentIndex > newIndex) {
                    return true;
                }
                if (currentIndex < newIndex) {
                    form.find('.body:eq(' + newIndex + ') label.error').remove();
                    form.find('.body:eq(' + newIndex + ') .error').removeClass('error');
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onFinishing: function (event, currentIndex)
            {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                @if($web_config['recaptcha']['status'] == '1')
                    if(currentIndex > 0){
                        var response = grecaptcha.getResponse($('#recaptcha_element_seller_regi').attr('data-reg-id'));
                        if (response.length === 0) {
                            toastr.error("{{translate('Please_check_the_recaptcha')}}");
                        }else{
                            $('#seller-registration').submit();
                        }
                    }
                @else
                    $('#seller-registration').submit();
                @endif
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var categorySelect = document.querySelector('select[name="product_category"]');
            var otherContainer = document.getElementById('product_category_other_container');

            categorySelect.addEventListener('change', function () {
                if (this.value === 'other') {
                    otherContainer.style.display = 'block';
                } else {
                    otherContainer.style.display = 'none';
                }
            });

            // Trigger the change event on page load if "other" is selected
            if (categorySelect.value === 'other') {
                otherContainer.style.display = 'block';
            }
        });
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var companySelect = document.querySelector('select[name="company_type"]');
        var otherContainer = document.getElementById('company_category_other_container');

        companySelect.addEventListener('change', function () {
            if (this.value === 'other') {
                otherContainer.style.display = 'block';
            } else {
                otherContainer.style.display = 'none';
            }
        });

        // Trigger the change event on page load if "other" is selected
        if (companySelect.value === 'other') {
            otherContainer.style.display = 'block';
        }
    });
</script>


<script>
    $(function() {
    // Multiple images preview with JavaScript
    var multiImgPreview = function(input, imgPreviewPlaceholder) {
        if (input.files) {
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    };
    $('#images').on('change', function() {
        multiImgPreview(this, 'div.imgPreview');
    });
    });
</script>
<script>

$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>

@endpush
