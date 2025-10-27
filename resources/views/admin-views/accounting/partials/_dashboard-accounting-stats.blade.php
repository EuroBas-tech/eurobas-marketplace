<div class="col-lg-12">
    <div class="row g-2">
        <div class="col-md-6">
            <div class="card custom-card-border card-body h-100 justify-content-center">
                <div class="d-flex gap-2 justify-content-between align-items-center">
                    <div class="d-flex flex-column align-items-start">
                        <h3 class="mb-1 fz-24">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($data['collected_cash']))}}</h3>
                        <div class="text-capitalize mb-0">{{translate('total_platform_revenue')}}</div>
                    </div>
                    <div>
                        <img width="40" src="{{asset('public/assets/back-end/img/cc.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card custom-card-border card-body h-100 justify-content-center">
                <div class="d-flex gap-2 justify-content-between align-items-center">
                    <div class="d-flex flex-column align-items-start">
                        <h3 class="mb-1 fz-24">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($data['costs_and_expenses']))}}</h3>
                        <div class="text-capitalize mb-0">{{translate('costs_and_expenses')}}</div>
                    </div>
                    <div>
                        <img width="40" src="{{asset('public/assets/back-end/img/costs.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card custom-card-border card-body h-100 justify-content-center">
                <div class="d-flex gap-2 justify-content-between align-items-center">
                    <div class="d-flex flex-column align-items-start">
                        <h3 class="mb-1 fz-24">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($data['commission_earned'] - $data['costs_and_expenses']))}}</h3>
                        <div class="text-capitalize mb-0">{{translate('total_net_profit')}}</div>
                    </div>
                    <div>
                        <img width="40" src="{{asset('public/assets/back-end/img/net-profit.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
