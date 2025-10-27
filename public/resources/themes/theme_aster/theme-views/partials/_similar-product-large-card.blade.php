@php($overallRating = $ad->reviews ? \App\CPU\ProductManager::get_overall_rating($ad->reviews) : 0)
<div class="product border product-card-shadow rounded text-center d-flex flex-column gap-10" onclick="location.href='{{route('product',$ad->slug)}}'">
    <!-- Product top -->
    <div class="product__top" style="--width: 100%; --height: 12.5rem">
        @php($wishlist = count($ad->wish_list)>0 ? 1 : 0)
        <div class="product__actions d-flex flex-column gap-2">
            <a href="javascript:" onclick="addWishlist('{{$ad['id']}}','{{route('store-wishlist')}}')" id="wishlist-{{$ad['id']}}"
            class="btn-wishlist stopPropagation add_to_wishlist wishlist-{{$ad['id']}} {{($wishlist == 1?'wishlist_icon_active':'')}}" title="Add to wishlist">
                <i class="bi bi-heart"></i>
            </a>
            <a href="javascript:" class="btn-quickview stopPropagation" onclick="location.href='{{route('ads-show',$ad->slug)}}'" title="Quick View"
              >
                <i class="bi bi-eye"></i>
            </a>
        </div>

        <div class="product__thumbnail">
            <img src="{{ asset("storage/app/public/ad/thumbnail")}}/{{$ad->thumbnail }}"
                 onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'" loading="lazy"
                 class="img-fit dark-support rounded" alt="">
        </div>
    </div>

    <!-- Product Summery -->
    <div class="product__summary px-2 pb-2 cursor-pointer">
        <div class="d-flex align-items-center mb-2 justify-content-between" >
            <div class="text-muted fs-14">
                {{ $ad->user->f_name }} {{ $ad->user->l_name }}
            </div>
            <div class="d-flex gap-1 align-items-center">
                <div class="star-rating text-gold fs-12">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= (int)$overallRating[0])
                            <i class="bi bi-star-fill"></i>
                        @elseif ($overallRating[0] != 0 && $i <= (int)$overallRating[0] + 1.1 && $overallRating[0] > ((int)$overallRating[0]))
                            <i class="bi bi-star-half"></i>
                        @else
                            <i class="bi bi-star"></i>
                        @endif
                    @endfor
                </div>
                <span>( {{$ad->reviews->count()}} )</span>
            </div>
        </div>

        <h6 class="product__title mb-2 text-truncate text-start">
            {{ \Illuminate\Support\Str::limit(ad['name'], 25) }}
        </h6>

        <div class="product__price text-end">
            <ins class="product__new-price">
                {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($ad->price))}}
            </ins>
        </div>
    </div>
</div>

