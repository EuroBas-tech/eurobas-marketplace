<div class="mt-3" >
    @if(\App\Model\SponsoredAdType::where('name', 'urgent_sale_sticker')->value('status') == 1)
        <div class="mt-3 pt-3 rounded" >
            <div class="mb-4" >
                <h2 class="mb-4" >{{ translate('add_urgent_sale_sticker_to_this_ad') }}</h2>
            </div>
            <div class="row mt-3">
                @foreach($urgent_sale_sticker_packages as $package)
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-2 col-1 d-flex mb-4" style="min-width: 289px;">
                        <div class="card rounded position-relative p-4 w-100 d-flex flex-column justify-content-between pricing-card">
                            <div class="mb-4" >
                                <div class="d-flex align-items-end gap-1 mb-4">
                                    <h2 class="text-primary price-text m-0">€{{number_format($package['price'], 2) }}</h2>
                                    <h2 class="fw-lighter price-text">/</h2>
                                    <h6 class="mb-2 fw-medium">{{translate('for')}} {{$package->duration_in_days}} {{ translate('days') }}</h6>
                                </div>
                                <div>
                                    @if($package->features)
                                        @foreach($package->features as $feature)
                                            <h6 class="mb-2 fw-medium d-flex align-items-start gap-1">
                                                <i class="bi bi-check2-all text-success"></i>
                                                <span>{{translate($feature->name)}}</span>
                                            </h6>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            
                            <!-- For old video packages, keep btn-light -->
                            <button type="button" class="btn btn-primary rounded-pill" data-id="{{ $package->id }}">
                                {{ translate('get_started') }}
                            </button>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if(\App\Model\SponsoredAdType::where('name', 'appearance_in_first_results')->value('status') == 1)
        <div class="mb-3 py-3 rounded" >
            <div class="mb-4" >
                <h2 class="mb-1" >{{ translate('promote_this_ad') }}</h2>
                <h5 class="fw-normal urgent-sale-text mb-2">{{translate('to_speed_up_sales_you_can_use_paid_promotion_for_your_ad_and_show_it_in_the_first_results_for_interested_users')}}.</h5>
            </div>
            <div class="row my-3">
                @foreach($appear_on_top_packages as $package)
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-2 col-1 d-flex mb-4" style="min-width: 289px;">
                        <div class="card rounded position-relative p-4 w-100 d-flex flex-column justify-content-between pricing-card">
                            <div class="mb-4" >
                                <div class="d-flex align-items-end gap-1 mb-4">
                                    <h2 class="text-primary price-text m-0">€{{number_format($package['price'], 2) }}</h2>
                                    <h2 class="fw-lighter price-text">/</h2>
                                    <h6 class="mb-2 fw-medium">{{translate('for')}} {{$package->duration_in_days}} {{ translate('days') }}</h6>
                                </div>
                                <div>
                                    @if($package->features)
                                        @foreach($package->features as $feature)
                                            <h6 class="mb-2 fw-medium d-flex align-items-start gap-1">
                                                <i class="bi bi-check2-all text-success"></i>
                                                <span>{{translate($feature->name)}}</span>
                                            </h6>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            
                            <!-- For old video packages, keep btn-light -->
                            <button type="button" class="btn btn-primary rounded-pill" data-id="{{ $package->id }}">
                                {{ translate('get_started') }}
                            </button>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if(\App\Model\SponsoredAdType::where('name', '!=', 'promotional_banner')
    ->where('status', 1)->exists())
        @include('theme-views.ad.sponsor.partials._payment-checkout')
    @endif
</div>