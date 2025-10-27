<div class="row my-3">
    
    <input type="checkbox" name="urgent_sale" class="form-input-check d-none" id="urgent_sale">
    <div class="col-md-3 d-flex">
        <div class="card rounded position-relative p-4 w-100 d-flex flex-column justify-content-between pricing-card">
            <div class="mb-4">
                <div class="d-flex align-items-end gap-1 mb-3">
                    <h2 class="text-primary price-text m-0">€{{$urgent_sale_sticker_price}}</h2>
                    <h2 class="fw-lighter price-text">/</h2>
                    <h6 class="mb-2 fw-medium">{{ translate('for') }} {{$urgent_sale_sticker_duration}} {{ translate('days') }}</h6>
                </div>
                <div>
                    <h6 class="mb-2 fw-medium d-flex align-items-center gap-1">
                        <i class="bi bi-check2-all text-success"></i>
                        <span>{{$urgent_sale_sticker_duration}} days on first results</span>
                    </h6>
                    <h6 class="mb-2 fw-medium d-flex align-items-center gap-1">
                        <i class="bi bi-check2-all text-success"></i>
                        <span>show ad to targeted users</span>
                    </h6>
                    <h6 class="mb-2 fw-medium d-flex align-items-center gap-1">
                        <i class="bi bi-check2-all text-success"></i>
                        <span>Ad display preference</span>
                    </h6>
                </div>
            </div>
            <button class="btn btn-primary rounded-pill mt-auto toggle-urgent" type="button">{{ translate('get_started') }}</button>
        </div>
    </div>
</div>