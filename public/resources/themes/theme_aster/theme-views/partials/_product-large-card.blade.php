@php($overallRating = $ad->reviews ? \App\CPU\ProductManager::get_overall_rating($ad->reviews) : 0)
<div class="product border rounded text-center d-flex flex-column ov-hidden cursor-pointer product-card-shadow scale-image-hover-effect"
     onclick="location.href='{{route('ads-show',$ad->slug)}}'">
    <!-- Product top -->
    <div class="product__top" style="--width: 100%;">

        
        @php($wishlist = count($ad->wish_list)>0 ? 1 : 0)
        <div class="product__actions d-flex flex-column gap-2">
            <a href="javascript:" onclick="addWishlist('{{$ad['id']}}','{{route('store-wishlist')}}')"
               id="wishlist-{{$ad['id']}}"
               class="btn-wishlist stopPropagation add_to_wishlist wishlist-{{$ad['id']}} {{($wishlist == 1?'wishlist_icon_active':'')}}"
               title="Add to wishlist">
                <i class="bi bi-heart"></i>
            </a>
            <a onclick="location.href='{{route('ads-show',$ad->slug)}}'"
               class="btn-wishlist stopPropagation"
               title="Add to wishlist">
                <i class="bi bi-eye"></i>
            </a>
        </div>

        <div class="product__thumbnail">
            <img src="{{asset("public/storage/ad/thumbnail/".$ad->thumbnail)}}"
                 onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'" loading="lazy"
                 class="img-fit card-product-image dark-support custom-bottom-border-radius prod-imag2" alt="">
        </div>
    </div>
 
    <div class="product__summary p-2 py-3 cursor-pointer">
        <div class="d-flex align-items-center justify-content-between" >
            <span>{{$ad->user->f_name}} {{$ad->user->l_name}}</span>

            <div>
                <h6 class="bg-primary p-1 px-2 rounded text-light" ><i class="bi bi-tags-fill fs-13"></i><span class="mx-1" >{{$ad->category->name}}</span></h6>
            </div>

        </div>
        <h6 class="product__title text-truncate text-start p-0 my-2 responsive-sides-padding">
            {{ \Illuminate\Support\Str::limit($ad['title'], 30) }}
        </h6>

        <div class="product__price d-flex align-items-end justify-content-between">
            <div class="text-start" >
                <div class="mb-1" >
                    @if(isset($ad->brand->name))
                        <span>{{ $ad->brand->name ?? '/' }} • </span>
                    @endif
                    @if($ad->year)
                        <span>{{ $ad->year }}</span>
                    @endif
                </div>
                <div>
                    @if($ad->mileage)
                        <span>{{ $ad->mileage }}{{ translate('km') }}</span>
                    @endif
                </div>
            </div>
            <ins class="product__new-price text-primary" >
                @if($ad->price_type == 'fixed_price')
                    <b style="font-size: 18px;" >{{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}}</b>
                @elseif($ad->price_type == 'free')
                    <b style="font-size: 18px;" >{{translate('free')}}</b>
                @elseif($ad->price_type == 'asking_price')
                    <b style="font-size: 18px;" >{{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}}</b>
                @elseif($ad->price_type == 'auction')
                    <b style="font-size: 18px;" >{{translate('auction')}}</b>
                @endif
            </ins>
        </div>

    </div>
</div>

