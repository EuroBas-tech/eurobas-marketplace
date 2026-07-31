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

    .badge-status-active {
        background-color: #16a34a;
        color: #ffffff;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.80rem;
    }

    .badge-status-expired {
        background-color: #6b7280;
        color: #ffffff;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.80rem;
    }

    .info-pill {
        background-color: rgba(0, 0, 0, 0.03);
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.88rem;
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
                            <h2 class="h4 m-0 fw-bold">{{ translate('promotion_history') }}</h2>
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
                                                        <h3 class="h5 fw-bold mb-3 text-dark">
                                                            <a href="{{ route('ads-show', $ad->slug) }}" class="text-decoration-none text-dark">
                                                                {{ $ad->title }}
                                                            </a>
                                                        </h3>

                                                        <div class="d-flex flex-column gap-3">
                                                            @foreach($filteredSponsors as $sponsor)
                                                                @php
                                                                    $isActive = \Carbon\Carbon::parse($sponsor->expiration_date)->isFuture();
                                                                    $locale = SOLVE_LOCALE_CODES[app()->getLocale()] ?? app()->getLocale();
                                                                @endphp

                                                                <div class="p-3 {{ $isActive ? 'sponsor-card-active' : 'sponsor-card-expired' }}">
                                                                    
                                                                    <!-- Header: Type & Status -->
                                                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            @if($isActive)
                                                                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                                                            @else
                                                                                <i class="bi bi-clock-history text-secondary fs-5"></i>
                                                                            @endif
                                                                            <h4 class="h6 m-0 fw-bold text-dark">{{ translate($sponsor->type) }}</h4>
                                                                            
                                                                            <span class="{{ $isActive ? 'badge-status-active' : 'badge-status-expired' }}">
                                                                                {{ $isActive ? translate('active') : translate('expired') }}
                                                                            </span>
                                                                        </div>

                                                                        <div class="text-muted fs-sm">
                                                                            <i class="bi bi-calendar3 me-1"></i>
                                                                            {{ translate('sponsored_at') }}: {{ $sponsor->created_at->format('Y-m-d') }} 
                                                                            <span class="text-lowercase">({{ $sponsor->created_at->locale($locale)->diffForHumans() }})</span>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Details Info Pills -->
                                                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                                                        <div class="info-pill text-dark">
                                                                            <strong>{{ translate('price') }}:</strong> {{ $sponsor->price }}€
                                                                        </div>
                                                                        
                                                                        <div class="info-pill text-dark">
                                                                            <strong>{{ translate('duration') }}:</strong> {{ $sponsor->duration_in_days }} {{ translate('days') }}
                                                                        </div>

                                                                        <div class="info-pill text-dark">
                                                                            @if($isActive)
                                                                                <strong class="text-success">{{ translate('valid_until') }}:</strong> {{ $sponsor->expiration_date }}
                                                                            @else
                                                                                <strong class="text-muted">{{ translate('expired_on') }}:</strong> {{ $sponsor->expiration_date }}
                                                                            @endif
                                                                            <span class="ms-1 font-weight-normal">
                                                                                ({{\Carbon\Carbon::parse($sponsor->expiration_date)->locale($locale)->diffForHumans()}})
                                                                            </span>
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
                            <h5 class="alert-heading fw-bold mb-1">{{ translate('there_is_no_sponsored_ads_to_show') }}</h5>
                            <p class="m-0 text-muted fs-sm">{{ translate('you_have_not_promoted_any_ads_yet') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
    <!-- End Main Content -->
@endsection
