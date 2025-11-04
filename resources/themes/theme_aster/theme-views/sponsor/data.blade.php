@extends('theme-views.layouts.app')

@section('title', translate('sponsor').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@section('content')

<style>
    body {
        background-color: unset !important;
    }
    .price-text {
        font-size: 35px;
    }

    .fixed-description-height {
        min-height: 3em; /* adjust this based on your font size */
        line-height: 1.5em;
        overflow: hidden;
    }

    .pricing-card {
        border: 1px solid #d9d9d9;
        box-shadow: 0px 0px 2px #858585;
    }

    .pricing-card.active {
        border: 1px solid #198754;
        transform: scale(1.08);
        transition: .2s;
    }
</style>

    <!-- Aside Toggle Button -->
    @include('theme-views.partials._aside-toggler-btn')

    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 py-sm-3 pt-0 mb-4">
        <div class="container">
            <div class="row g-3">
                <!-- Sidebar-->
                @include('theme-views.partials._profile-aside')
                <div class="col px-3 flex-shrink-0">
                    @if($user_ads_sponsor->count() > 0)
                        <h1 class="mb-4" >{{translate('promotion_history')}}</h1>
                        <div>
                            <div class="row g-4">
                                @foreach($user_ads_sponsor as $ad)
                                        <div class="col-md-12">
                                            <div class="card rounded border large-screen-card-border large-screen-aside-shadow">
                                                <div class="card-body p-3">
                                                    <div class="d-flex align-items-start gap-3">
                                                        <div class="avatar border rounded" style="--size: 5rem">
                                                            <a href="{{route('ads-show', $ad->slug)}}">
                                                                <img
                                                                src="{{ cloudfront('ad/thumbnail/'.$ad->thumbnail)}}"
                                                                onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                                                                class="img-fit dark-support rounded aspect-1" alt="">
                                                            </a>
                                                        </div>

                                                        <div>
                                                            <h4 class="mb-3" >{{$ad->title}}</h4>
                                                            @foreach($ad->sponsor as $sponsor)
                                                                <div class="@if(!$loop->last) mb-4 @endif d-flex flex-column align-items-start gap-1" >

                                                                    <div class="d-flex align-items-start align-items-sm-center flex-column flex-md-row gap-2 fw-medium">
                                                                        <div class="d-flex align-items-center gap-1 mb-sm-0 mb-2" >
                                                                            <span>
                                                                                @if($sponsor->expiration_date > now())
                                                                                    <i class="bi bi-check2-circle text-success"></i>
                                                                                @else
                                                                                    <i class="bi bi-x-circle text-danger"></i>
                                                                                @endif
                                                                            </span>
                                                                            <h5>{{ translate($sponsor->type) }}</h5>
                                                                        </div>
                                                                        @php($locale = SOLVE_LOCALE_CODES[app()->getLocale()] ?? app()->getLocale())
                                                                        <span>( {{ translate('sponsored_at')}} : {{($sponsor->created_at)}} ) ({{$sponsor->created_at->locale($locale)->diffForHumans()}})</span>
                                                                    </div>
                                                                    <div>
                                                                        <span>
                                                                            ( {{translate('price')}} : {{ $sponsor->price }}€ )
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span>
                                                                            ( {{ translate('duration') }} : {{ $sponsor->duration_in_days }} {{ translate('days') }} )
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span>
                                                                            @if($sponsor->expiration_date < now())
                                                                                ( {{ translate('expired_on') }} : {{ $sponsor->expiration_date }} )
                                                                            @else
                                                                                ( {{ translate('valid_until') }} : {{ $sponsor->expiration_date }} )
                                                                            @endif
                                                                            @php($locale = SOLVE_LOCALE_CODES[app()->getLocale()] ?? app()->getLocale())
                                                                            ( {{\Carbon\Carbon::parse($sponsor->expiration_date)->locale($locale)->diffForHumans()}} )
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <h5 class="alert-heading fw-medium">{{ translate('there_is_no_sponsored_ads_to_show') }}</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
    <!-- End Main Content -->
@endsection

@push('script')




@endpush
