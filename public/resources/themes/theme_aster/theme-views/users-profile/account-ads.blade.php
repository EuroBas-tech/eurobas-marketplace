@extends('theme-views.layouts.app')

@section('title', translate('My_Ads').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@section('content')
    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 mb-4">
        <div class="container">
            <div class="row g-3">

                <!-- Sidebar-->
                @include('theme-views.partials._profile-aside')

                <div class="col-lg-9">
                    <div class="card h-lg-100">
                        <div class="card-body p-lg-4">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <h3>{{translate('my_ads')}}</h3>
                                <a class="btn btn-primary px-1" href="{{ route('ads-adding-type') }}">
                                    <i class="bi bi-plus-circle"></i>
                                    {{ translate('post_an_add') }}
                                </a>
                            </div>

                            <div class="mt-4" id="set-wish-list">
                                @include('theme-views.partials._ads-data',['ads'=>$user_ads])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End Main Content -->
@endsection
