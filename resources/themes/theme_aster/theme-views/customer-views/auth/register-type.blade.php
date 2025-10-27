@extends('theme-views.layouts.app')

@section('title', translate('select_your_profile').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@push('css_or_js')
    <meta property="og:image" content="{{env_asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <meta property="twitter:card" content="{{env_asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <style>
        .selection-card {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 2rem 5rem;
            margin: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .selection-card:hover {
            transform: translateY(-2px);
        }
        
        .selection-card.selected {
            border: 2px solid #0d6efd;
            background-color: #f8f9ff;
        }
        
        .selection-card .icon {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            color: #6c757d;
            transition: color 0.3s ease;
        }
        
        .selection-card.selected .icon {
            color: #0d6efd;
        }
        
        .selection-card .label {
            font-size: 1.1rem;
            font-weight: 500;
            color: #495057;
            margin: 0;
        }
        
        .selection-card.selected .label {
            color: #0d6efd;
        }
        
        .selection-radio {
            display: none;
        }
        
        .next-btn {
            margin-top: 2rem;
            padding: 0.50rem 2rem;
            font-size: 1.1rem;
            font-weight: 500;
        }
        .large-icon {
            font-size: 5rem;
        }

        @media (max-width: 576px) {
            .selection-card {
                border: 2px solid #e9ecef;
                border-radius: 12px;
                padding: 1rem 4rem;
                margin: 0.5rem;
                cursor: pointer;
                transition: all 0.3s ease;
                background: white;
                height: 140px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
            }
            .large-icon {
                font-size: 3rem;
            }
        }
    </style>

@endpush


@section('content')
    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 mb-4 vh-100">
        <div class="container h-100">
            <div class="row h-100">
                <!-- Sidebar-->
                <div class="col-12">
                    <div class="card h-lg-100 card-custom-shadow">
                        <div class="card-body p-4 pb-4">
                            <div class="mt-4">
                                <form action="{{route('customer.auth.sign-up')}}" method="POST" id="ads-store-form" enctype="multipart/form-data">
                                    @csrf
                                    <h1 class="text-center mb-4">{{translate('select_your_profile')}}</h1>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-auto col-6">
                                            <div class="selection-card product-card-shadow" data-value="individual">
                                                <input type="radio" name="type" value="individual" class="selection-radio" id="individual">
                                                <i class="bi bi-person large-icon text-primary"></i>
                                                <p class="label">{{translate('individual')}}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-auto col-6">
                                            <div class="selection-card product-card-shadow" data-value="company">
                                                <input type="radio" name="type" value="company" class="selection-radio" id="company">
                                                <i class="bi bi-buildings large-icon text-primary"></i>
                                                <p class="label">{{translate('company')}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center" >
                                        <button disabled type="submit" class="btn btn-primary next-btn d-flex align-items-center gap-2">
                                            <span>{{translate('next')}}</span>
                                            <i class="bi {{ app()->getLocale() == 'ae' ? 'bi-arrow-left' : 'bi-arrow-right' }}"></i>
                                        </button>
                                    </div>
                                </form>
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
    <script>
        $(document).ready(function() {
            // Handle card click
            $('.selection-card').click(function() {
                // Remove selected class from all cards
                $('.selection-card').removeClass('selected');
                
                // Add selected class to clicked card
                $(this).addClass('selected');
                
                // Check the corresponding radio button
                var value = $(this).data('value');
                $('input[value="' + value + '"]').prop('checked', true);

                $('.next-btn').prop('disabled', false);

            });
        });
    </script>
@endpush


