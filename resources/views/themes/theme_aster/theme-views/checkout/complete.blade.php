@extends('theme-views.layouts.app')

@section('title', translate('Order_Complete').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@section('content')
    <main style="min-height: 80vh;" class="main-content d-flex flex-column gap-3 py-3 mb-5">
        <div class="container">
            <div class="card">
                <div class="card-body p-md-5">
                    <div class="row justify-content-center">
                        <div class="col-xl-6 col-md-10">
                            <div class="text-center d-flex flex-column align-items-center gap-3 px-5">
                                <img width="70" src="{{ theme_asset('assets/img/icons/check.png') }}" class="dark-support" alt="">
                                <h2 class="fs-30 py-2" >{{ translate('Your_Order_is_Completed') }}</h2>
                                <p class="text-muted fs-25">{{ translate('thank_you_for_your_order') }}! {{ translate('your_order_has_been_processed.') }} {{ translate('check_your_email_to_get_the_order_id_and_details.') }}</p>
                                <div class="d-flex flex-wrap justify-content-center gap-3">
                                    <a href="{{route('home')}}" class="btn btn-outline-primary px-3 border-0 bg-primary-light text-white"><i class="bi bi-shop fs-26"></i>{{ translate('Continue_Shopping') }}</a>
                                    <a href="{{ route('track-order.index') }}" class="btn btn-primary px-3"><i class="bi bi-geo-alt"></i>{{ translate('Track_Order') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
