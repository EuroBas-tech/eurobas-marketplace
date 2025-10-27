<div class="my-4" >
    <h2 class="my-4" >{{translate('pricing')}}</h2>

    <div class="row">
        @foreach($packages as $package)
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 d-flex mb-4" style="min-width: 289px;">
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
                    <button class="btn btn-primary package-btn rounded-pill mt-auto" data-id="{{ $package->id }}" type="button">
                        {{translate('get_started')}}
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>