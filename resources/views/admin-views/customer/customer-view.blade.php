@extends('layouts.back-end.app')
{{--@section('title','user')--}}
@section('title', translate('user_Details'))

@push('css_or_js')

<style>
    .object-fit-cover {
        object-fit: cover;
    }
</style>

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-print-none pb-2">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">

                    <!-- Page Title -->
                    <div class="mb-3">
                        <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
                            <img width="20" src="{{asset('/public/assets/back-end/img/customer.png')}}" alt="">
                            {{translate('user_details')}}
                        </h2>
                    </div>
                    <!-- End Page Title -->

                    <div class="d-sm-flex align-items-sm-center">
                        <h3 class="page-header-title">{{translate('user_ID')}} #{{$customer['id']}}</h3>
                        <span class="{{Session::get('direction') === "rtl" ? 'mr-2 mr-sm-3' : 'ml-2 ml-sm-3'}}">
                        <i class="tio-date-range">
                        </i> {{translate('joined_At')}} : {{date('d M Y H:i:s',strtotime($customer['created_at']))}} ({{$customer->created_at->diffForHumans()}})
                        </span>
                    </div>

                    @if($is_profile_incompleted)
                        <div class="d-sm-flex align-items-sm-center my-3">
                            <span class="fs-16" >
                                <i class="tio-clear text-danger"></i>
                                <strong>
                                    {{translate('profile_not_competed')}}
                                </strong>
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="row" id="printableArea">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="card">
                    <div class="p-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <h4 class="m-0" >{{translate('ads')}} : {{$ads->count()}}</h4>
                            </div>
                            <div class="col-auto">
                                <form action="{{ url()->current() }}" method="GET">
                                    <!-- Search -->
                                    <div class="input-group input-group-merge input-group-custom">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                            placeholder="{{translate('search_orders')}}" aria-label="Search orders" value="{{ $search }}"
                                            required>
                                        <button type="submit" class="btn btn--primary">{{translate('search')}}</button>
                                    </div>
                                    <!-- End Search -->
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                            <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{translate('sl')}}</th>
                                    <th>{{translate('title')}}</th>
                                    <th>{{translate('thumbnail')}}</th>
                                    <th class="text-center" >{{translate('sponsor')}}</th>
                                    <th class="text-center">{{translate('suspend')}} / {{translate('unsuspend')}}</th>
                                    <th class="text-center">{{translate('action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ads as $key=>$ad)
                                    <tr>
                                        <td>{{$ads->firstItem()+$key}}</td>
                                        <td>
                                            <a href="{{route('ads-show', $ad->slug)}}" class="title-color hover-c1">{{$ad['title']}}</a>
                                        </td>
                                        <td>
                                            <img width="80px" height="80px" class="object-fit-cover rounded" src="{{env_asset('storage/ad/thumbnail/'.$ad->thumbnail)}}" alt="ad_image">
                                        </td>
                                        <td class="text-center" >
                                            @if($ad->sponsor->count() > 0)
                                                @foreach($ad->sponsor as $index => $sponsor)
                                                    @php
                                                        $modalId = 'sponsor_type_'.$ad->id.'_'.$index;
                                                    @endphp

                                                    <a class="px-4 d-block mb-1" role="button"
                                                    data-toggle="modal"
                                                    data-target="#{{ $modalId }}">
                                                        {{ translate($sponsor['type']) }}
                                                    </a>

                                                    <div class="modal fade" id="{{ $modalId }}" tabindex="-1"
                                                        aria-labelledby="{{ $modalId }}_label" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                            <div class="modal-content mx-auto w-75">
                                                                <div class="modal-header p-3">
                                                                    <h3 class="mb-0">{{ translate('sponsor_details') }}</h3>
                                                                    <button type="button" class="btn-close border-0"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                        <i class="tio-clear"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body px-4 px-sm-5 pt-0">
                                                                    <div class="d-flex flex-column gap-2">
                                                                        <h5>{{translate('type')}} : {{translate($sponsor['type'])}}</h5>
                                                                        <h5>{{translate('price')}} : {{$sponsor['price']}}€</h5>
                                                                        <h5>{{translate('duration_in_days')}} : {{$sponsor['duration_in_days']}} {{translate('days')}}</h5>
                                                                        <h5>{{translate('expiration_date')}} : {{$sponsor['expiration_date']}} ({{\Carbon\Carbon::parse($sponsor['expiration_date'])->diffForHumans()}})</h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <span class="text-muted">{{ translate('no_sponsor') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{route('admin.ad.status-update')}}" method="post" id="ad_status{{$ad['id']}}_form" class="ad_status_form">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$ad['id']}}">
                                                <label class="switcher mx-auto">
                                                    <input type="checkbox" class="switcher_input" id="ad_status{{$ad['id']}}" name="status" value="1" {{ $ad['status'] == 1 ? 'checked':'' }} onclick="toogleStatusModal(event,'ad_status{{$ad['id']}}','ad-block-on.png','ad-block-off.png','{{translate('Want_to_restore')}} {{$ad['title']}}','{{translate('Want_to_suspend')}} {{$ad['title']}}',`<p>{{translate('if_enabled_this_ad_will_be_unblocked_and_visible_again')}}</p>`,`<p>{{translate('if_disabled_this_ad_will_be_blocked_and_not_visible')}}</p>`)">
                                                    <span class="switcher_control"></span>
                                                </label>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-10">
                                                <a class="btn btn-outline--primary btn-sm edit square-btn"
                                                    title="{{translate('view')}}"
                                                    href="{{route('ads-show', $ad->slug)}}"><i
                                                    class="tio-invisible"></i>
                                                </a>
                                                <a class="btn btn-outline-info btn-sm square-btn"
                                                    title="{{translate('invoice')}}"
                                                    target="_blank"
                                                    href=""><i class="tio-download"></i>
                                                </a>
                                                @if($ad['id'] != '0')
                                                    <a title="{{translate('delete')}}"
                                                    class="btn btn-outline-danger btn-sm delete square-btn" href="javascript:"
                                                    onclick="form_alert('ad-{{$ad['id']}}','{{translate('want_to_delete_this_ad').'?'}}')">
                                                        <i class="tio-delete"></i>
                                                    </a>
                                                @endif
                                                <form action="{{route('admin.ad.delete',[$ad['id']])}}" method="post" id="ad-{{$ad['id']}}">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if(count($ads)==0)
                            <div class="text-center p-4">
                                <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description">
                                <p class="mb-0">{{ translate('no_data_to_show')}}</p>
                            </div>
                        @endif
                        @if(count($ads)!=0)
                            <!-- Footer -->
                            <div class="card-footer">
                                <!-- Pagination -->
                                {!! $ads->links() !!}
                                <!-- End Pagination -->
                            </div>
                            <!-- End Footer -->
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Card -->
                <div class="card mb-4">
                    @if($customer)
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-4" >
                                <div>
                                    <h4 class="d-flex align-items-center gap-2">
                                    <img src="{{asset('/public/assets/back-end/img/seller-information.png')}}" alt="">
                                    {{translate('user_information')}}
                                </div>
                                <div>
                                    <a class="btn btn-primary d-flex align-items-center gap-1" _target="_blank" href="{{ route('show-profile', [$customer['id'], $customer['name']]) }}?tap=ads">
                                        <i class="tio-user"></i>
                                        {{translate('show_profile')}}
                                    </a>
                                </div>
                            </h4>
                            </div>
                            <div class="media">
                                <div class="mr-3">
                                    <img class="avatar rounded avatar-70"
                                    src="{{$customer['image'] ? env_asset('storage/profile/images/'.$customer['image']) : theme_asset('assets/img/avatar/def-image.jpg')  }}"
                                    alt="Image">
                                </div>
                                <div class="media-body d-flex flex-column gap-1">
                                    <span class="title-color hover-c1"><strong>{{$customer['name']}}</strong></span>
                                    <span class="title-color"><strong>{{$customer['phone_code']}} {{$customer['phone']}}</strong></span>
                                    <span class="title-color">{{$customer['email']}}</span>
                                    @if($customer['country'])
                                        <div class="mb-1" >
                                            <span><strong class="title-color" >{{translate('country')}}</strong> : {{$customer['country']}}</span>
                                        </div>
                                    @endif
                                    @if($customer['city'])
                                        <div class="mb-1" >
                                            <span><strong class="title-color" >{{translate('city')}}</strong> : {{$customer['city']}}</span>
                                        </div>
                                    @endif
                                    @if($customer['postal_code'])
                                        <div class="mb-1" >
                                            <span><strong class="title-color" >{{translate('postal_code')}}</strong> : {{$customer['postal_code']}}</span>
                                        </div>
                                    @endif
                                    @if($customer['street_address'])
                                        <div class="mb-1" >
                                            <span><strong class="title-color" >{{translate('street_address')}}</strong> : {{$customer['street_address']}}</span>
                                        </div>
                                    @endif
                                    @if($user_native_language)
                                        <span><strong class="title-color" >{{ translate('native_language') }}</strong> : {{$user_native_language}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- End Body -->
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="media-body d-flex flex-column gap-1">
                                @if($customer->paid_banners->count() > 0)
                                    @foreach($customer->paid_banners as $paid_banner)
                                        <div>
                                            <a href="{{$paid_banner->banner_url}}">
                                                <img src="{{cloudfront('paid-banners/'.$paid_banner['banner_image']) }}" alt="banner_image">
                                            </a>
                                        </div>
                                    @endforeach
                                @else
                                    <span class="badge badge-danger" >{{translate('no_banners')}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection

@push('script_2')

@endpush
