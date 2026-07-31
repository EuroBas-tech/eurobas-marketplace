@extends('theme-views.layouts.app')

@section('title', translate('sponsor').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@section('content')

<style>
    body {
        background-color: #f8f9fa !important;
    }

    .sponsor-card-active {
        background-color: #f0fdf4;
        border: 1px solid #bbf7d0 !important;
        border-radius: 10px;
    }

    .sponsor-card-expired {
        background-color: #ffffff;
        border: 1px solid #e5e7eb !important;
        border-radius: 10px;
        opacity: 0.85;
    }

    .info-pill {
        background-color: rgba(0, 0, 0, 0.04);
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.90rem;
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
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h1 class="mb-0 fw-bold">{{ translate('promotion_history') }}</h1>
                        </div>

                        <div class="row g-4">
                            @foreach($user_ads_sponsor as $ad)
                                @php
                                    // فلترة الباقات القديمة جداً (أكثر من 90 يوم) وترتيب النشط أولاً ثم الأحدث
                                    $filteredSponsors = $ad->sponsor
                                        ->filter(function($s) {
                                            return \Carbon\Carbon::parse($s->expiration_date)->gte(now()->subDays(90));
                                        })
                                        ->sortByDesc(function($s) {
                                            return [\Carbon\Carbon::parse($s->expiration_date)->isFuture() ? 1 : 0, $s->expiration_date];
                                        });
                                @endphp

                                @if($filteredSponsors->count() > 0)
                                    <div class="col-md-12">
                                        <div class="card rounded-3 border-0 shadow-sm">
                                            <div class="card-body p-3 p-md-4">
                                                <div class="d-flex flex-column flex-md-row align-items-start gap-3">
                                                    
                                                    <!-- Ad Thumbnail -->
                                                    <div class="avatar border rounded-3 flex-shrink-0" style="--size: 5.5rem">
                                                        <a href="{{ route('ads-show', $ad->slug) }}">
                                                            <img src="{{ cloudfront('ad/thumbnail/'.$ad->thumbnail) }}"
                                                                 onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                                                                 class="img-fit dark-support rounded-3 aspect-1" alt="{{ $ad->title }}">
                                                        </a>
                                                    </div>

                                                    <!-- Ad Details & Sponsors -->
                                                    <div class="w-100">
                                                        <h4 class="mb-3 fw-bold text-dark">
                                                            <a href="{{ route('ads-show', $ad->slug) }}" class="text-decoration-none text-dark">
                                                                {{ $ad->title }}
                                                            </a>
                                                        </h4>

                                                        <div class="d-flex flex-column gap-3">
                                                            @foreach($filteredSponsors as $sponsor)
                                                                @php
                                                                    $isActive = $sponsor->expiration_date > now();
                                                                    $locale = SOLVE_LOCALE_CODES[app()->getLocale()] ?? app()->getLocale();
                                                                @endphp

                                                                <div class="p-3 {{ $isActive ? 'sponsor-card-active' : 'sponsor-card-expired' }}">
                                                                    
                                                                    <!-- Header: Type & Icon (طريقة الملف القديم تماماً) -->
                                                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <span>
                                                                                @if($isActive)
                                                                                    <i class="bi bi-check2-circle text-success fs-5"></i>
                                                                                @else
                                                                                    <i class="bi bi-x-circle text-danger fs-5"></i>
                                                                                @endif
                                                                            </span>
                                                                            <h5 class="m-0 fw-bold text-dark">{{ translate($sponsor->type) }}</h5>
                                                                        </div>

                                                                        <div class="text-muted fs-sm">
                                                                            ( {{ translate('sponsored_at') }} : {{ $sponsor->created_at }} ) 
                                                                            ({{ $sponsor->created_at->locale($locale)->diffForHumans() }})
                                                                        </div>
                                                                    </div>

                                                                    <!-- Details Info Pills (ترجمات الملف القديم) -->
                                                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                                                        <div class="info-pill text-dark">
                                                                            ( {{ translate('price') }} : {{ $sponsor->price }}€ )
                                                                        </div>
                                                                        
                                                                        <div class="info-pill text-dark">
                                                                            ( {{ translate('duration') }} : {{ $sponsor->duration_in_days }} {{ translate('days') }} )
                                                                        </div>

                                                                        <div class="info-pill text-dark">
                                                                            @if($sponsor->expiration_date < now())
                                                                                ( {{ translate('expired_on') }} : {{ $sponsor->expiration_date }} )
                                                                            @else
                                                                                ( {{ translate('valid_until') }} : {{ $sponsor->expiration_date }} )
                                                                            @endif
                                                                            ( {{\Carbon\Carbon::parse($sponsor->expiration_date)->locale($locale)->diffForHumans()}} )
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning border-0 shadow-sm rounded-3 p-4">
                            <h5 class="alert-heading fw-medium m-0">{{ translate('there_is_no_sponsored_ads_to_show') }}</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
    <!-- End Main Content -->
@endsection
