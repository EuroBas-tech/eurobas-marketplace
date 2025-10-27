<div class="table-responsive d-none d-md-block">
    <table class="table align-middle table-striped">
        <tbody>
        @if($ads->count()>0)
            @foreach($ads as $key=>$ad)
                <tr class="dashed-border" >
                    <td>
                        <div class="media gap-3 align-items-center mn-w200">
                            <div class="avatar border rounded" style="--size: 4.75rem">
                                <img
                                    src="{{ asset('public/storage/ad/thumbnail/'.$ad->thumbnail)}}"
                                    onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                                    class="img-fit dark-support rounded aspect-1" alt="">
                            </div>
                            <div class="media-body">
                                <a href="">
                                    <h6 class="text-truncate text-capitalize" style="margin-bottom: 3px;"
                                    >{{$ad['title']}}</h6>                                
                                </a>
                                <div>
                                    <span>{{ translate('brand') }} : {{ $ad->model->name ?? '/' }}</span>
                                </div>
                                <div>
                                    <span>{{ translate('year') }} : {{$ad->year  ?? '/' }}</span>
                                </div>
                                <div>
                                    {{ translate('price') }} :
                                    @if($ad->price_type == 'fixed_price')
                                        <b class="text-dark" >{{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}}</b>
                                    @elseif($ad->price_type == 'free')
                                        <b class="text-dark" >{{translate('free')}}</b>
                                    @elseif($ad->price_type == 'asking_price')
                                        <b class="text-dark" >{{translate('asking_price')}} </b><b class="text-dark" >({{\App\CPU\BackEndHelper::set_price_currency($ad->price, $ad->currency)}})</b>
                                    @elseif($ad->price_type == 'auction')
                                        <b class="text-dark" >{{translate('auction')}} </b><b class="text-dark" >@if($ad->auctions->count() > 0) {{\App\CPU\BackEndHelper::set_price_currency($ad->auctions()->latest()->value('price'), $ad->currency)}} @else {{\App\CPU\BackEndHelper::set_price_currency($ad->starting_price, $ad->currency)}} @endif</b>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-end gap-2 align-items-center">
                            <a href="{{route('ads-show', $ad->slug)}}"
                                class="btn btn-outline-success rounded-circle btn-action add_to_compare "
                                id="">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('ads-edit', $ad->id) }}"
                                class="btn btn-outline-primary rounded-circle btn-action add_to_compare "
                                onclick=""
                                id="">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="javascript:" title="{{translate('Delete')}}"
                                onclick="route_alert('{{route('ads-delete',[$ad->id])}}','{{translate('want_to_delete_this_ad?')}}')"
                                class="btn btn-outline-danger rounded-circle btn-action oktext-btn">
                                <i class="bi bi-trash3-fill"></i>
                            </a>
                        </div>
                    </td>
                    </tr>
                </tr>
            @endforeach
        @endif
        @if($ads->count()==0)
            <tr class="dashed-border" >
                <td class="dashed-border rounded" ><h5 class="text-center">{{translate('not_found_anything')}}</h5></td>
            </tr>
        @endif
        </tbody>
    </table>
</div>

<div class="d-flex flex-column gap-2 d-md-none">
    @if($ads->count()>0)
        @foreach($ads as $key=>$ad)
            <div class="media gap-3 bg-light p-3 rounded">
                <div class="avatar border rounded" style="--size: 3.75rem">
                    <img
                        src="{{ asset('public/storage/ad/thumbnail/'.$ad->thumbnail)}}"
                        onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                        class="dark-support rounded" alt="">
                </div>
                <div class="media-body d-flex flex-column gap-1">
                    <a href="">
                        <h6 class="text-truncate text-capitalize" style="--width: 20ch">{{$ad['name']}}</h6>
                    </a>
                    <div>
                        {{ translate('price') }} :
                        {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($ad->price))}}
                    </div>
                    <div>
                        {{ translate('brand') }} : toyota
                    </div>
                    <div class="d-flex gap-2 align-items-center mt-1">
                        <a href="{{route('ads-show', $ad->slug)}}"
                            class="btn btn-outline-success rounded-circle btn-action add_to_compare "
                            id="">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('ads-edit', $ad->id) }}"
                            class="btn btn-outline-primary rounded-circle btn-action add_to_compare "
                            onclick=""
                            id="">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="javascript:" title="{{translate('Delete')}}"
                            onclick="route_alert('{{route('ads-delete',[$ad->id])}}','{{translate('want_to_delete_this_ad?')}}')"
                            class="btn btn-outline-danger rounded-circle btn-action oktext-btn">
                            <i class="bi bi-trash3-fill"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<div class="card-footer border-0 bg-white">
    {{$ads->links()}}
</div>
