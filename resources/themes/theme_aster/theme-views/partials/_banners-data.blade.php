<div class="table-responsive d-none d-md-block">
    <table class="table align-middle table-striped">
        <tbody>
        @if($banners->count()>0)
            @foreach($banners as $key=>$banner)
                <tr class="dashed-border" >
                    <td>
                        <div class="media gap-3 align-items-center mn-w200">
                            <div class="avatar border rounded" style="--size: 5rem">
                                <a href="">
                                    <img
                                    src="{{ cloudfront('paid-banners/'.$banner->banner_image)}}"
                                    onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                                    class="img-fit dark-support rounded aspect-1" alt="">
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="mb-2" >
                                    @if($banner->banner_url)
                                        <a class="btn btn-primary d-inline px-2 py-1" target="_blank" href="{{ $banner->banner_url }}" >
                                            <i class="bi bi-globe me-1"></i>
                                            <span>{{ translate('banner_url') }}</span>
                                        </a>
                                    @else
                                        <a href="#" class="text-primary" >
                                            <span>{{ translate('no_url_to_this_banner') }}</span>
                                        </a>
                                    @endif
                                </div>
                                <div class="mb-2" >
                                    @php($locale = SOLVE_LOCALE_CODES[app()->getLocale()] ?? app()->getLocale())
                                    <span>{{translate('expires_at')}} : {{ \Carbon\Carbon::parse($banner->expiration_date)->format('d M Y') }} ({{$banner->expiration_date->locale($locale)->diffForHumans()}})</span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-end gap-2 align-items-center">
                            <a href="{{route('edit.paid-banners', [$banner->id])}}"
                                class="btn btn-outline-primary rounded-circle btn-action add_to_compare "
                                onclick=""
                                id="">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="javascript:" title="{{translate('Delete')}}"
                                onclick="route_alert('{{route('delete.paid-banners',[$banner->id])}}','{{translate('want_to_delete_this_banner?')}}')"
                                class="btn btn-outline-danger rounded-circle btn-action oktext-btn">
                                <i class="bi bi-trash3-fill"></i>
                            </a>
                        </div>
                    </td>
                    </tr>
                </tr>
            @endforeach
        @endif
        @if($banners->count()==0)
            <tr class="dashed-border" >
                <td class="dashed-border rounded" ><h5 class="text-center">{{translate('not_found_anything')}}</h5></td>
            </tr>
        @endif
        </tbody>
    </table>
</div>

<div class="d-flex flex-column gap-2 d-md-none">
    @if($banners->count()>0)
        @foreach($banners as $key=>$banner)
            <div class="media gap-3 bg-light p-3 rounded">
                <div class="avatar border rounded" style="--size: 5.75rem">
                    <a href="">
                        <img style="block-size: 6rem;"
                            src="{{ cloudfront('paid-banners/'.$banner->banner_image)}}"
                            onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                            class="dark-support rounded" alt="banner-image">
                    </a>
                </div>
                <div class="media-body d-flex flex-column gap-2">
                    <div class="media-body">
                        <div class="mb-3" >
                            @if($banner->banner_url)
                                <a class="btn btn-primary d-inline px-2 py-1" target="_blank" href="{{ $banner->banner_url }}" >
                                    <i class="bi bi-globe me-1"></i>
                                    <span>{{ translate('banner_url') }}</span>
                                </a>
                            @else
                                <a href="#" class="text-primary" >
                                    <span>{{ translate('no_url_to_this_banner') }}</span>
                                </a>
                            @endif
                        </div>
                        <div class="mb-2" >
                            @php($locale = SOLVE_LOCALE_CODES[app()->getLocale()] ?? app()->getLocale())
                            <span class="d-block">{{ translate('expires_at') }} : {{ $banner->expiration_date->format('d/m/Y') }}</span>
                            <span class="d-block" >({{$banner->expiration_date->locale($locale)->diffForHumans()}})</span>
                        </div>
                        <div>
                            <span>
                            <span class="tio-visible nav-indicator-icon fs-15"></span>
                            <span>{{ translate('views') }} : {{$banner->views_number}}</span>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex gap-2 align-items-center justify-content-end">
                        <a href=""
                            class="btn btn-outline-success rounded-circle btn-action add_to_compare "
                            id="">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href=""
                            class="btn btn-outline-primary rounded-circle btn-action add_to_compare "
                            onclick=""
                            id="">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="javascript:" title="{{translate('Delete')}}"
                            onclick="route_alert('{{route('delete.paid-banners',[$banner->id])}}','{{translate('want_to_delete_this_banner?')}}')"
                            class="btn btn-outline-danger rounded-circle btn-action oktext-btn">
                            <i class="bi bi-trash3-fill"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    @if($banners->count()==0)
        <tr class="dashed-border" >
            <td class="dashed-border rounded" ><h5 class="text-center">{{translate('not_found_anything')}}</h5></td>
        </tr>
    @endif
</div>

<div class="card-footer border-0 bg-white">
    {{$banners->links()}}
</div>
