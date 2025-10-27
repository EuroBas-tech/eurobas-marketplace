@php
    $customer_info = \App\CPU\customer_info();
@endphp
<div class="col-lg-2 min-width-max-content mt-0 mt-sm-4">
    <div class="card profile-sidebar-sticky large-screen-card-border large-screen-aside-shadow">
        <div class="card-body position-relative p-0 px-3 pb-3">
            <div class="profile-menu-aside">
                <div class="profile-menu-aside-close d-lg-none">
                    <i class="bi bi-x-lg text-primary"></i>
                </div>
                <ul class="list-unstyled profile-menu gap-1 mt-3">
                    <li class="{{Request::is('user-profile') || Request::is('user-account') ||Request::is('account-address-*') || Request::is('edit-location-data') ? 'active' :''}}">
                        <a  href="{{ route('user-profile') }}">
                            <img width="20" src="{{ theme_asset('assets/img/icons/profile-icon.png') }}" class="dark-support" alt="">
                            <span>{{translate('My_profile')}}</span>
                        </a>
                    </li>
                    <li class="{{Request::is('user-ads') || Request::is('ads*') ? 'active' :''}}">
                        <a  href="{{ route('user-ads') }}"> 
                            <img width="20" src="{{ theme_asset('assets/img/icons/vehicle-icon.png') }}" class="dark-support" alt="">
                            <span>{{translate('My_ads')}}</span>
                        </a>
                    </li>
                    <li class="{{Request::is('wishlists') ? 'active' :''}}">
                        <a href="{{route('wishlists')}}">
                            <img width="20" src="{{theme_asset('assets/img/icons/profile-icon3.png')}}" class="dark-support" alt="">
                            <span>{{translate('Wish_List')}}</span>
                        </a>
                    </li>
                    <li class="{{Request::is('user-paid-banners') || Request::is('user-paid-banners') ||Request::is('user-paid-banners-*') ? 'active' :''}}">
                        <a  href="{{ route('index.paid-banners') }}">
                            <img width="20" src="{{ theme_asset('assets/img/icons/banner-icon.png') }}" class="dark-support" alt="">
                            <span>{{translate('paid_banners')}}</span>
                        </a>
                    </li>
                    <li class="{{Request::is('user-paid-banners') || Request::is('sponsor/data') ||Request::is('sponsor/data/*') ? 'active' :''}}">
                        <a  href="{{ route('data.sponsor') }}">
                            <img width="20" src="{{ theme_asset('assets/img/icons/promotion.png') }}" class="dark-support" alt="">
                            <span>{{translate('promotion_history')}}</span>
                        </a>
                    </li>
                    <li class="{{Request::is ('chat/*') ? 'active' : ''}}">
                        <a href="{{route('chat', ['type' => 'user'])}}">
                            <img width="20" src="{{theme_asset('assets/img/icons/profile-icon7.png')}}" class="dark-support" alt="">
                            <span>{{translate('Inbox')}}</span>
                        </a>
                    </li>
                    <li class="{{Request::is ('account-tickets') || Request::is('support-ticket*') ? 'active' : ''}}" >
                        <a href="{{route('account-tickets')}}">
                            <img width="20" src="{{theme_asset('assets/img/icons/profile-icon8.png')}}" class="dark-support" alt="">
                            <span class="position-relative @if(\App\Model\SupportTicket::where('customer_id', auth('customer')->id())->where('status','open')->count() > 0) notification-red-point @endif" >{{translate('Support_Ticket')}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="javascript:" onclick="route_alert('{{ route('account-delete',[$customer_info['id']]) }}','{{ translate('want_to_delete_this_account?')}}')">
                            <i class="bi bi-trash3-fill text-danger fs-16"></i>
                            {{ translate('Delete_My_Account') }}
                        </a>
                    </li>
                </ul>
                <a target="_blank" href="{{ route('show-profile', [$customer_info['id'], $customer_info['name']]) }}?tap=ads" 
                    class="btn btn-primary w-100 mt-3">
                    {{translate('show_profile')}}
                </a>
            </div>
        </div>
    </div>
</div>
