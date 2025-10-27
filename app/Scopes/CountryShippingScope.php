<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
class CountryShippingScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // تحقق مما إذا كان المستخدم هو الإداري
        if (Request::is('admin/*') or Request::is('seller/*') ) {

            return;
        }
        
        
        if (
            Request::is('api/*') &&
            !Request::is('api/v1/order/cancel-order') &&
            !Request::is('api/v1/customer/order/list') &&
            !Request::is('api/v1/customer/order/details') &&
            !Request::is('api/v1/customer/order/place') &&
            !Request::is('api/v1/order/track') &&
            !Request::is('api/v1/customer/order/get-order-by-id') &&
            !Request::is('api/v1/customer/order/refund-store') &&
            !Request::is('api/v1/customer/order/refund') &&
            !Request::is('api/v1/customer/order/refund-details')&&
            !Request::is('api/v1/products/reviews/submit')&&
                !Request::is('api/v3/seller') &&
    !Request::is('api/v3/seller/*')
        ) {
            $countryHeader = Request::header('CountryShipping');

            if ($countryHeader == 'ALL') {
                return;
            } else {
                $builder->whereJsonContains('shipping_country', $countryHeader);
            }
        }
        

                

        $countryShipping = session('country_shipping');

        // تطبيق الشرط فقط إذا كانت قيمة الجلسة موجودة وليست 'ALL'
        if (isset($countryShipping) && $countryShipping !== 'All') {
            $builder->whereJsonContains('shipping_country', $countryShipping);
        }
    }
}
