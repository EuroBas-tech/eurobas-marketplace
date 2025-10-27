@extends('theme-views.layouts.app')

@section('title', translate('payment_methods').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@section('content')

    <style>
        body {
            background-color: unset !important;
        }

        .payment-method-card {
            cursor: pointer;
            transition: transform 0.3s ease;
            border: 2px solid transparent;
            position: relative;
        }

        .payment-method-card.active {
            border-color: #28a745;
            box-shadow: 0 0 3px rgba(40, 167, 69, 0.4);
            transform: scale(1.05);
        }

        .check-icon {
            position: absolute;
            top: 6px;
            right: 6px;
            color: #28a745;
            font-size: 1.1rem;
            transform: scale(0);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .payment-method-card.active .check-icon {
            transform: scale(1);
            opacity: 1;
        }

        .min-height-100-vh {
            min-height: 100vh;
        }
    </style>

    <!-- Main Content -->
    <main class="d-flex justify-content-center min-height-100-vh py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-5 mx-auto rounded">
                    <div class="card bg-light p-sm-5 p-4 large-screen-aside-shadow" >
                        <form action="{{route('multiple.redirect.payment.method')}}" method="POST">
                            @csrf
                            <input type="hidden" name="payment_method" id="payment_method" value="">
                            
                            <h1 class="text-center pb-5" >{{translate('select_a_payment_method')}}</h1>
                            
                            <div class="row mb-5"> 
                                <div class="col-6">
                                    <div data-method-name="paypal" role="button" class="card payment-method-card large-screen-aside-shadow px-4 py-2 position-relative"> 
                                        <img src="{{env_asset('storage/payment_modules/gateway_image')}}/{{$payment_methods_images['paypal']}}" alt="paypal_image"> 
                                        <i class="bi bi-check-circle-fill check-icon"></i>
                                    </div> 
                                </div>  
                                <div class="col-6">
                                    <div data-method-name="stripe" role="button" class="card payment-method-card large-screen-aside-shadow px-4 py-2 position-relative"> 
                                        <img src="{{env_asset('storage/payment_modules/gateway_image')}}/{{$payment_methods_images['stripe']}}" alt="stripe_image"> 
                                        <i class="bi bi-check-circle-fill check-icon"></i>
                                    </div> 
                                </div>
                            </div>
    
                            <div class="mb-4" >
                                @foreach($packages as $package)
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h3>{{ translate($package->type->name) }}</h3>
                                        <h4>€{{ number_format($package->price, 2) }}</h4>
                                    </div>
                                @endforeach
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3>{{ translate('total') }}</h3>
                                    <h4>€{{ number_format($packages->sum('price'), 2) }}</h4>
                                </div>
                            </div>

                            <div class="mb-3" >
                                <span class="text-center" >
                                    <span class="fw-bold text-dark" >{{translate('note')}} : </span>
                                    {{translate('payments_for_this_service_are_non_refundable')}}
                                </span>
                            </div>
    
                            <div class="row">
                                <div class="col-12">
                                    <button disabled id="pay-btn" class="btn btn-primary rounded w-100" >{{translate('pay')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End Main Content -->
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $(".payment-method-card").on("click", function () {
                // Remove active class from all cards
                $(".payment-method-card").removeClass("active");

                // Add active to clicked card
                $(this).addClass("active");

                // Brief scale effect then return to normal size
                $(this).css("transform", "scale(1.08)");
                setTimeout(() => {
                    $(this).css("transform", "scale(1.05)");
                }, 200);

                // Set hidden input value
                let method = $(this).data("method-name");
                $("#payment_method").val(method);
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $(".payment-method-card").on("click", function () {
                $("#pay-btn").removeAttr("disabled");
            });
        });
    </script>
@endpush
