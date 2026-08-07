@extends('theme-views.layouts.app')

@section('title', translate('My_Profile').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@section('content')
    <!-- Main Content -->

    <!-- Aside Toggle Button -->
    @include('theme-views.partials._aside-toggler-btn')

    <main class="main-content d-flex flex-column gap-3 py-3 py-sm-3 pt-0 mb-4">
        <div class="container">
            <div class="row g-4">

                <!-- Sidebar-->
                @include('theme-views.partials._profile-aside')

                <!-- تم تعديل col إلى col-12 col-lg-9 لضمان العرض الكامل على الموبايل -->
                <div class="col-12 col-lg-9">
                    <div class="card card-border aside-shadow">
                        <div class="card-body">
                            
                            <!-- الكروت الثلاثة العلوية -->
                            <div class="d-flex flex-column flex-sm-row gap-3 flex-wrap flex-grow-1">
                                <div class="card border flex-grow-1 product-card-shadow">
                                    <div class="card-body grid-center">
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <div class="d-flex flex-column gap-2">
                                                <img width="35" src="{{ theme_asset('assets/img/icons/vehicle-icon.png') }}" class="dark-support" alt="">
                                                <span class="text-dark">{{translate('ads')}}</span>
                                            </div>
                                            <h2 class="mb-2">{{ $user_ads_count }}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border flex-grow-1 product-card-shadow">
                                    <div class="card-body grid-center">
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <div class="d-flex flex-column gap-2">
                                                <img width="35" src="{{ theme_asset('assets/img/icons/profile-icon3.png') }}" class="dark-support" alt="">
                                                <span class="text-dark">{{translate('Wish_List')}}</span>
                                            </div>
                                            <h2 class="mb-2">{{ $wishlists }}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border flex-grow-1 product-card-shadow">
                                    <div class="card-body grid-center">
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <div class="d-flex flex-column gap-2">
                                                <img width="35" src="{{ theme_asset('assets/img/icons/banner-icon.png') }}" class="dark-support" alt="">
                                                <span class="text-dark">{{translate('paid_banners')}}</span>
                                            </div>
                                            <h2 class="mb-2">{{ $wishlists }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- تفاصيل الحساب الشخصية (تم حذف width: max-content وتعديل الـ row) -->
                            <div class="mt-30 bg-light rounded dashed-border p-3 overflow-hidden">
                                <div class="d-flex align-items-center flex-wrap justify-content-between gap-3">
                                    <h3>{{translate('Personal_Details')}}</h3>
                                    <a href="{{route('user-account')}}" class="btn btn-outline-secondary rounded px-3 px-sm-4"><span class="d-none d-sm-inline-block">{{ translate('Edit_Profile') }}</span> <i class="bi bi-pencil-square"></i></a>
                                </div>

                                <div class="mt-4 w-100">
                                    <div class="d-flex flex-column text-dark">
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <h5 class="fw-bold responsive-font-size-14 mb-0">{{ $customer_detail['account_type'] == 'company' ? translate('business_name') : translate('profile_name') }} : </h5>
                                            <h5 class="fw-medium responsive-font-size-14 mb-0">{{$customer_detail['name'] ?? '/'}}</h5>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <h5 class="fw-bold responsive-font-size-14 mb-0">{{translate('Phone')}} : </h5>
                                            <h5 class="fw-medium responsive-font-size-14 mb-0">{{$customer_detail['phone'] ? $customer_detail['phone_code'] . $customer_detail['phone'] : '/'}}</h5>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <h5 class="fw-bold responsive-font-size-14 mb-0">{{translate('Email')}} : </h5>
                                            <h5 class="fw-medium responsive-font-size-14 mb-0">{{$customer_detail['email'] ?? '/'}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- تفاصيل الموقع (تم حذف width: max-content وتعديل الـ row) -->
                            <div class="mt-30 bg-light rounded dashed-border p-3 overflow-hidden">
                                <div class="d-flex align-items-center flex-wrap justify-content-between gap-3">
                                    <h3>{{translate('Location_Details')}}</h3>
                                </div>

                                <div class="mt-4 w-100">
                                    <div class="d-flex flex-column text-dark">
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <h5 class="fw-bold responsive-font-size-14 mb-0">{{translate('country')}} : </h5>
                                            <h5 class="fw-medium responsive-font-size-14 mb-0">{{$customer_detail['country'] ?? '/'}}</h5>
                                        </div>
                                        
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <h5 class="fw-bold responsive-font-size-14 mb-0">{{translate('city')}} :</h5>
                                            <h5 class="fw-medium responsive-font-size-14 mb-0">{{$customer_detail['city'] ?? '/'}}</h5>
                                        </div>
                                        
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <h5 class="fw-bold responsive-font-size-14 mb-0">{{translate('postal_code') ?? '/'}} : </h5>
                                            <h5 class="fw-medium responsive-font-size-14 mb-0">{{$customer_detail['postal_code'] ?? '/'}}</h5>
                                        </div>
                                        
                                        <div class="d-flex align-items-center gap-2">
                                            <h5 class="fw-bold responsive-font-size-14 mb-0">{{translate('Address')}} : </h5>
                                            <h5 class="fw-medium responsive-font-size-14 mb-0">{{$customer_detail['street_address'] ?? '/'}}</h5>
                                        </div>
                                    </div>
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
