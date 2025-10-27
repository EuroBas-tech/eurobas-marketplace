<div class="table-responsive d-none d-md-block">
    <table class="table align-middle table-striped">
        <tbody>
        @if($wishlists->count()>0)
            @foreach($wishlists as $key=>$wishlist)
                @php($ad = $wishlist->wishlistAd)
                @if( $wishlist->wishlistAd)
                    <td>
                        <div class="media gap-3 align-items-center mn-w200">
                            <div class="avatar border rounded" style="--size: 3.75rem">
                                <img
                                    src="{{asset("public/storage/ad/thumbnail")}}/{{$ad->thumbnail}}"
                                    onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                                    class="img-fit dark-support rounded aspect-1" alt="">
                            </div>
                            <div class="media-body">
                                <a href="{{route('ads-show',$ad['slug'])}}">
                                    <h6 class="text-truncate text-capitalize"
                                        style="--width: 20ch">{{$ad['name']}}</h6>
                                </a>
                            </div>
                            @if($brand_setting)
                                <div class="media-body">
                                    <h6 class="text-truncate"
                                        style="--width: 10ch">{{$ad->brand?$ad->brand['name']:''}} </h6>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($ad->discount > 0)
                            <del style="color: #9B9B9B;">
                                {{\App\CPU\Helpers::currency_converter($ad->price)}}
                            </del> &nbsp;&nbsp;
                        @endif
                        {{$ad->price }}
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
                <div class="media gap-3 bg-light p-3 rounded">
                    <div class="avatar border rounded" style="--size: 3.75rem">
                        <img
                            src="{{asset("public/storage/ad/thumbnail")}}/{{$ad->thumbnail}}"
                            onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                            class="img-fit dark-support rounded" alt="">
                    </div>
                    <div class="media-body d-flex flex-column gap-1">
                        <a href="{{route('ads-show',$ad['slug'])}}">
                            <h6 class="text-truncate text-capitalize" style="--width: 20ch">{{$ad['name']}}</h6>
                        </a>
                        <div>
                            {{ translate('price') }} :
                            @if($ad->discount > 0)
                                <del style="color: #9B9B9B;">
                                    {{\App\CPU\Helpers::currency_converter($ad->price)}}
                                </del> &nbsp;&nbsp;
                            @endif
                            {{$ad->price }}
                        </div>

                        <div class="d-flex gap-2 align-items-center mt-1">
                            <button type="button" onclick="removeWishlist({{$ad['id']}}, '{{ route('delete-wishlist') }}')" class="btn btn-outline-danger rounded-circle btn-action">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
</div>

<div class="card-footer border-0 bg-white">
    {{$wishlists->links()}}
</div>
