<div class="inline-page-menu my-4">
    <ul class="list-unstyled">
        <li class="{{ Request::is('seller/shop/view') && !request()->has('pagetype') ?'active':'' }}"><a href="{{route('seller.shop.view')}}">{{translate('general')}}</a></li>

        @php($minimum_order_amount_status=\App\CPU\Helpers::get_business_settings('minimum_order_amount_status'))
        @php($minimum_order_amount_by_seller=\App\CPU\Helpers::get_business_settings('minimum_order_amount_by_seller'))
        @php($free_delivery_status=\App\CPU\Helpers::get_business_settings('free_delivery_status'))
        @php($free_delivery_responsibility=\App\CPU\Helpers::get_business_settings('free_delivery_responsibility'))

    </ul>
</div>
