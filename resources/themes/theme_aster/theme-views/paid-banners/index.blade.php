@extends('theme-views.layouts.app')

@section('title', translate('My_Paid_banners').' | '.$web_config['name']->value)

@section('content')

    <!-- Aside Toggle Button -->
    @include('theme-views.partials._aside-toggler-btn')

    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 py-sm-3 pt-0 mb-4">
        <div class="container">
            <div class="row g-4">
                <!-- Sidebar-->
                @include('theme-views.partials._profile-aside')
                <div class="col">
                    <div class="card h-lg-100 card-border aside-shadow">
                        @if(\App\Model\SponsoredAdType::where('name', 'promotional_banner')->value('status') != 1)
                            <div class="px-4 pt-3" >
                                <div class="alert alert-warning py-2 m-0">{{ translate('this_promotion_type_not_available_now') }}</div>
                            </div>
                        @endif
                        <div class="card-body p-lg-4">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <h3>{{translate('my_banners')}}</h3>
                                @if(\App\Model\SponsoredAdType::where('name', 'promotional_banner')->value('status') == 1)
                                    <a class="btn btn-primary px-3" href="{{ route('create.paid-banners') }}">
                                        <i class="bi bi-plus-circle"></i>
                                        {{ translate('add_new_banner') }}
                                    </a>
                                @endif
                            </div>
                            <div class="mt-4" id="set-wish-list">
                                @include('theme-views.partials._banners-data',['banners'=>$user_banners])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End Main Content -->
@endsection
