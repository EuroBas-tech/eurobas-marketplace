<div class="product border rounded product-card-shadow scale-image-hover-effect text-center d-flex flex-column gap-10" onclick="">
    <!-- Product top -->
    <div class="product__top" style="--width: 100%; --height: 12.5rem">
        <div class="product__actions d-flex flex-column gap-2">
            @php($wishlist = count($ad->wish_list)>0 ? 1 : 0)
            <a onclick="addWishlist('{{$ad['id']}}','{{route('store-wishlist')}}')"
               class="btn-wishlist stopPropagation add_to_wishlist cursor-pointer wishlist-{{$ad['id']}} {{($wishlist == 1?'wishlist_icon_active':'')}}"
               title="{{translate('add_to_wishlist')}}">
                <i class="bi bi-heart"></i>
            </a>
            <a href="javascript:" class="btn-quickview stopPropagation"
               onclick="quickView('{{$ad->id}}', '{{route('quick-view')}}')" title="{{translate('Quick_View')}}"
            >
                <i class="bi bi-eye"></i>
            </a>
        </div>

        <div class="product__thumbnail">
            <img src="https://dev.eurobas.de/storage/app/public/product/2023-11-10-654e902c22d7f.webp"
                 loading="lazy" class="img-fit dark-support rounded card-product-image"
                 onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'" alt="{{ $ad['title'] }}">
        </div>
    </div>

    <!-- Product Summery -->
    <div class="product__summary d-flex flex-column px-3 gap-1 pb-2">

        <h6 class="product__title text-truncate text-start py-2" style="--width: 80%">
            <a href="{{route('product', $ad->slug)}}"
               class="text-capitalize">{{ Str::limit(Str::limit($ad['title'], 23)) }}</a>
        </h6>

        <a href="{{route('product',$ad->slug)}}">
            <div class="product__price d-flex flex-wrap justify-content-end column-gap-2">
                <ins class="product__new-price">
                    {{$ad->price}}
                </ins>
            </div>
        </a>
    </div>
</div>
