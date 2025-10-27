@php
    $customer_info = \App\CPU\customer_info();
@endphp
<div class="col-lg-3">
    <div class="card profile-sidebar-sticky">
        <div class="card-body position-relative">
            <div class="d-lg-none bg-primary rounded px-1 pt-2 pb-1 d-inline text-end text-white cursor-pointer end-1 top-1 profile-menu-toggle">
                <i class="bi bi-list fs-18"></i>
            </div>
            <div class="profile-menu-aside">
                <div class="profile-menu-aside-close d-lg-none">
                    <i class="bi bi-x-lg text-primary"></i>
                </div>
                <ul class="list-unstyled profile-menu gap-1 mt-3">
                    <li class="{{Request::is('user-profile') || Request::is('user-account') ||Request::is('account-address-*') ? 'active' :''}}">
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
                    <li class="{{Request::is('user-paid-banners') || Request::is('user-paid-banners') ||Request::is('user-paid-banners-*') ? 'active' :''}}">
                        <a  href="{{ route('user-paid-banners') }}">
                            <img width="20" src="{{ theme_asset('assets/img/icons/banner-icon.png') }}" class="dark-support" alt="">
                            <span>{{translate('paid_banners')}}</span>
                        </a>
                    </li>
                    <li class="{{Request::is('wishlists') ? 'active' :''}}">
                        <a href="{{route('wishlists')}}">
                            <img width="20" src="{{theme_asset('assets/img/icons/profile-icon3.png')}}" class="dark-support" alt="">
                            <span>{{translate('Wish_List')}}</span>
                        </a>
                    </li>
                    @if ($web_config['wallet_status'] == 1)
                        <li class="{{Request::is('wallet') ? 'active' :''}}">
                            <a href="{{route('wallet')}}">
                                <img width="20" src="{{theme_asset('assets/img/icons/profile-icon5.png')}}" class="dark-support" alt="">
                                <span>{{translate('Wallet')}}</span>
                            </a>
                        </li>
                    @endif
                    @if ($web_config['loyalty_point_status'] == 1)
                        <li class="{{Request::is ('loyalty') ? 'active' : ''}}">
                            <a href="{{route('loyalty')}}">
                                <img width="20" src="{{theme_asset('assets/img/icons/profile-icon6.png')}}" class="dark-support" alt="">
                                <span>{{translate('Loyalty_Point')}}</span>
                            </a>
                        </li>
                    @endif

                    <li class="{{Request::is ('chat/seller') || Request::is ('chat/delivery-man') ? 'active' : ''}}">
                        <a href="{{route('chat', ['type' => 'seller'])}}">
                            <img width="20" src="{{theme_asset('assets/img/icons/profile-icon7.png')}}" class="dark-support" alt="">
                            <span>{{translate('Inbox')}}</span>
                        </a>
                    </li>
                    <li class="{{Request::is ('account-tickets') || Request::is('support-ticket*') ? 'active' : ''}}" >
                        <a href="{{route('account-tickets')}}">
                            <img width="20" src="{{theme_asset('assets/img/icons/profile-icon8.png')}}" class="dark-support" alt="">
                            <span>{{translate('Support_Ticket')}}</span>
                        </a>
                    </li>

                    <li>
                        <a class="d-flex align-items-center" href="javascript:" onclick="route_alert('{{ route('account-delete',[$customer_info['id']]) }}','{{ translate('want_to_delete_this_account?')}}')">
                            <i class="bi bi-trash3-fill text-danger fs-16"></i>
                            {{ translate('Delete_My_Account') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
