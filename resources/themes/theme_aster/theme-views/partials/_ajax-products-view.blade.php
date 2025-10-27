<div id="ajax-products-view">
    @if ($ads && count($ads) > 0)
        <div class="auto-col gap-3 mobile_two_items product-list-view"
            id="filtered-products" >
            <div class="row position-relative" >
                @foreach($ads as $ad)
                        @include('theme-views.partials._ajax-product-large-card',['ad'=>$ad])
                @endforeach
            </div>
        </div>
    @else
        <div class="d-flex flex-column gap-3 align-items-center pt-5 pb-4 h-100 mx-auto">
            <img width="140px" src="{{asset('public/resources/themes/theme_aster/public/assets/img/svg/no-result-icon.svg')}}" alt="">
            <h2 class="mb-2 text-primary fw-normal" >{{translate('No_Ad_Found_on_this_category')}}</h2>
        </div>
    @endif
</div>