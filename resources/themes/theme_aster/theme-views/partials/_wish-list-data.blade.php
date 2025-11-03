<div class="table-responsive d-none d-md-block">
    <table class="table align-middle table-striped">
        <tbody>
        @if($wishlists->count()>0)
            @foreach($wishlists as $key=>$wishlist)
                @php($ad = $wishlist->wishlistAd)
                @if( $wishlist->wishlistAd)
                    <td>
                        <div class="media gap-5 align-items-center mn-w200">
                            <div class="avatar border rounded" style="--size: 3.75rem">
                                <img
                                    src="{{ asset("public/storage/ad/thumbnail")}}/{{$ad['thumbnail'] }}"
                                    onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                                    class="img-fit dark-support rounded aspect-1" alt="">
                            </div>
                            <div class="media-body">
                                <a href="{{route('ads-show',$ad['slug'])}}">
                                    <h6 class="text-truncate text-capitalize" style="--width: 40ch">{{$ad['title']}}</h6>
                                </a>
                            </div>
                            <div class="media-body">
                                <h6 class="rounded text-center text-primary p-2 border">
                                    <img src="{{ cloudfront("category/2025-05-08-681bddf0b7a73.svg") }}" alt="" style="width: 25px; height: 25px;">
                                    {{ $ad->category ? $ad->category['name'] : '' }}
                                </h6>
                            </div>
                            @if($ad->brand)
                                <div class="media-body">
                                    <h6 class="text-truncate" style="--width: 20ch" >{{ $ad->brand?$ad->brand['name'] : '' }} </h6>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($ad->price_type == 'fixed_price')
                            <h5 class="text-primary currency-font"  >{{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}}</h5>
                        @elseif($ad->price_type == 'free')
                            <h5 class="text-primary currency-font" >{{translate('free')}}</h5>
                        @elseif($ad->price_type == 'asking_price')
                            <h5 class="text-primary currency-font" >{{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}}</h5>
                        @elseif($ad->price_type == 'auction')
                            <h5 class="text-primary currency-font" >{{translate('auction')}}</h5>
                        @endif
                    </td>
                    <td>
                        <button type="button" onclick="removeWishlist({{$ad['id']}}, '{{ route('delete-wishlist') }}')" class="btn btn-outline-danger rounded-circle btn-action">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </td>
                    </tr>
                @endif
            @endforeach
        @endif
        @if($wishlists->count()==0)
            <tr class="dashed-border" >
                <td class="dashed-border rounded" ><h5 class="text-center">{{translate('not_found_anything')}}</h5></td>
            </tr>
        @endif
        </tbody>
    </table>
</div>

<div class="d-flex flex-column gap-2 d-md-none">
    @if($wishlists->count()>0)
        @foreach($wishlists as $key=>$wishlist)
            @php($ad = $wishlist->wishlistAd)
            @if( $wishlist->wishlistAd)
                <div class="media gap-4 bg-light p-3 rounded">
                    <div class="avatar border rounded" style="--size: 3.75rem">
                        <img
                            src="{{asset("public/storage/ad/thumbnail")}}/{{$ad['thumbnail']}}"
                            onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                            class="img-fit dark-support rounded" alt="">
                    </div>
                    <div class="media-body w-100 d-flex flex-column gap-1">
                        <a href="{{route('ads-show',$ad['slug'])}}">
                            <h6 class="text-truncate text-capitalize mb-1" style="--width: 30ch">{{ $ad['title'] }}</h6>
                        </a>
                        <div>
                            <h6 class="rounded text-primary border mb-1">
                                <img src="{{ cloudfront("category/2025-05-08-681bddf0b7a73.svg") }}" alt="" style="width: 25px; height: 25px;">
                                {{ $ad->category ? $ad->category['name'] : '' }}
                            </h6>
                        </div>
                        <div>
                            <h6 class="text-truncate mb-1" style="--width: 10ch">{{ $ad->brand?$ad->brand['name'] : '' }} </h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-between" >
                            <div>
                                @if($ad->price_type == 'fixed_price')
                                    <h5 class="text-primary currency-font mb-1"  >{{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}}</h5>
                                @elseif($ad->price_type == 'free')
                                    <h5 class="text-primary currency-font mb-1" >{{translate('free')}}</h5>
                                @elseif($ad->price_type == 'asking_price')
                                    <h5 class="text-primary currency-font mb-1" >{{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}}</h5>
                                @elseif($ad->price_type == 'auction')
                                    <h5 class="text-primary currency-font mb-1" >{{translate('auction')}}</h5>
                                @endif
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <button type="button" onclick="removeWishlist({{$ad['id']}}, '{{ route('delete-wishlist') }}')" class="btn btn-outline-danger rounded-circle btn-action">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
    @if($wishlists->count()==0)
        <tr class="dashed-border" >
            <td class="dashed-border rounded" ><h5 class="text-center">{{translate('not_found_anything')}}</h5></td>
        </tr>
    @endif
</div>

<div class="card-footer border-0 bg-white">
    {{$wishlists->links()}}
</div>
