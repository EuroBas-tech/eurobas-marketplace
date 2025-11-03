<div class="col-sm-6 col-lg-3">
    <!-- Business Analytics Card -->
    <div class="business-analytics">
        <h5 class="business-analytics__subtitle">{{translate('total_users')}}</h5>
        <h2 class="business-analytics__title">{{ $data['users_count'] }}</h2>
        <img src="{{asset('/public/assets/back-end/img/total-customer.png')}}" class="business-analytics__img" alt="">
    </div>
    <!-- End Business Analytics Card -->
</div>
<div class="col-sm-6 col-lg-3">
    <!-- Business Analytics Card -->
    <div class="business-analytics">
        <h5 class="business-analytics__subtitle">{{translate('total_ads')}}</h5>
        <h2 class="business-analytics__title">{{ $data['ads_count'] }}</h2>
        <img src="{{asset('/public/assets/back-end/img/total-stores.png')}}" class="business-analytics__img" alt="">
    </div>
    <!-- End Business Analytics Card -->
</div>
<div class="col-sm-6 col-lg-3">
    <!-- Business Analytics Card -->
    <div class="business-analytics">
        <h5 class="business-analytics__subtitle">{{translate('total_categories')}}</h5>
        <h2 class="business-analytics__title">{{ $data['categories_count'] }}</h2>
        <img src="{{asset('/public/assets/back-end/img/total-product.png')}}" class="business-analytics__img" alt="">
    </div>
    <!-- End Business Analytics Card -->
</div>

<div class="col-sm-6 col-lg-3">
    <!-- Business Analytics Card -->
    <div class="business-analytics">
        <h5 class="business-analytics__subtitle">{{translate('total_paid_banners')}}</h5>
        <h2 class="business-analytics__title">{{ $data['paid_banners_count'] }}</h2>
        <img src="{{asset('/public/assets/back-end/img/total-sale.png')}}" class="business-analytics__img" alt="">
    </div>
    <!-- End Business Analytics Card -->
</div>

@php($classes = ['text-success', 'text-info', 'text-danger', 'text-warning'])

@foreach($data['categories_ads_count'] as $category)

    @php($randomClass = $classes[array_rand($classes)])

    <div class="col-sm-6 col-lg-3">
        <!-- Card -->
        <a class="order-stats order-stats_packaging" href="{{route('admin.orders.list',['processing'])}}">
            <div class="order-stats__content" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                <img width="35" src="{{ cloudfront('category/'.$category->icon)}}" alt="">
                <h6 class="order-stats__subtitle">{{$category['name']}}</h6>
            </div>
            <span class="{{ $randomClass }} fw-bold">
                {{$category['ads_count']}}
            </span>
        </a>
        <!-- End Card -->
    </div>
@endforeach
