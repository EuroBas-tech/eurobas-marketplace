<!-- Footer -->
<style>
    /* CSS for desktop view */
@media (min-width: 768px) {
    .mobile-view {
        display: none;
    }
    .desktop-view {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .footer-content {
        display: flex;
        align-items: center;
    }
    .payment-methods {
        margin-right: 20px; /* Adjust margin as needed */
    }
}

/* CSS for mobile view */
@media (max-width: 767px) {
    .desktop-view {
        display: none;
    }
    .mobile-view {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .footer-content {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .payment-methods {
        margin-bottom: 10px; /* Adjust margin as needed */
    }
}

</style>
<footer class="footer">
    <div class="footer-bg-img">

    </div>
    <div class="footer-top">
        <div class="container">
            <div class="row gy-3 align-items-center justify-content-between">
                <div class="col-lg-3 col-sm-3">
                    <img width="180" src="{{asset('storage/app/public/company/')}}/{{ $web_config['footer_logo']->value }}"
                        onerror="this.src='{{theme_asset('assets/img/image-place-holder-4_1.png')}}'"
                        loading="lazy" alt="">
                </div>
                <div class="col-lg-4 col-sm-3 d-flex">
                    <div class="media gap-3 absolute-white d-flex align-items-center">
                        <i class="bi bi-envelope fs-28"></i>
                        <div class="media-body">
                            <a href="{{route('contacts')}}" class="absolute-white mb-1">{{translate('Help_&_Support')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-main px-2  px-lg-0 py-1">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-5">
                    <div class="widget widget--about absolute-white">
                        @if(\App\CPU\Helpers::get_business_settings('shop_address'))
                            <p>{{ \App\CPU\Helpers::get_business_settings('shop_address')}}</p>
                        @endif
                        <a class="fs-18" href="mailto:{{$web_config['email']->value}}">{{$web_config['email']->value}}</a>

                        <ul class="list-socials list-socials--white gap-4 pt-4 pb-2 fs-20">
                            @if($web_config['social_media'])
                                @foreach ($web_config['social_media'] as $item)
                                    <li>
                                        @if ($item->name == "twitter")
                                            <a href="{{$item->link}}" target="_blank" class="font-bold">
                                                <svg class="mt-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                                                    <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                                                </svg>
                                            </a>
                                        @elseif($item->name == 'google-plus')
                                            <a href="{{$item->link}}" target="_blank">
                                                <i class="bi bi-google font-size-22"></i>
                                            </a>
                                        @else
                                            <a href="{{$item->link}}" target="_blank">
                                                <i class="bi bi-{{$item->name}} font-size-22"></i>
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                        <div class="d-flex gap-3 justify-content-center justify-content-lg-start flex-wrap mt-3">
                            @if($web_config['android']['status'])
                                <a href="{{ $web_config['android']['link'] }}"><img src="{{ theme_asset('assets/img/media/google-play.png') }}" loading="lazy" alt=""></a>
                            @endif
                            @if($web_config['ios']['status'])
                                <a href="{{ $web_config['ios']['link'] }}"><img src="{{ theme_asset('assets/img/media/app-store.png' ) }}" loading="lazy" alt=""></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row gy-5">
                        <div class="col-sm-6 col-6">
                            <div class="widget widget--nav absolute-white">
                                <h4 class="widget__title">{{translate('Accounts')}}</h4>
                                <ul class="d-flex flex-column gap-3">
                                    @if($web_config['seller_registration'])
                                        <li>
                                            <a href="{{route('customer.auth.sign-up-type')}}">{{translate('register_on_marketplace')}}</a>
                                        </li>
                                    @endif
                                    <li>
                                        @if(auth('customer')->check())
                                            <a href="{{route('user-profile')}}">{{translate('Profile')}}</a>
                                        @else
                                            <button class="bg-transparent border-0 p-0" data-bs-toggle="modal" data-bs-target="#loginModal">{{translate('Profile')}}</button>
                                        @endif
                                    </li>
                                    <li><a href="{{route('helpTopic')}}">{{translate('FAQ')}}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6 col-6">
                            <div class="widget widget--nav absolute-white">
                                <h4 class="widget__title">{{translate('Links')}}</h4>
                                <ul class="d-flex flex-column gap-3">
                                    <li><a href="{{route('about-us')}}">{{translate('About_marketplace')}}</a></li>
                                    <li><a href="{{route('privacy-policy')}}">{{translate('Privacy_Policy')}}</a></li>
                                    <li><a href="{{route('terms')}}">{{translate('Terms_&_Conditions')}}</a></li>
                                    <li>
                                        @if(auth('customer')->check())
                                            <a href="{{route('account-tickets')}}">{{translate('Support_Ticket')}}</a>
                                        @else
                                            <button class="bg-transparent border-0 p-0" data-bs-toggle="modal" data-bs-target="#loginModal">{{translate('Support_Ticket')}}</button>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom absolute-white">
        <div class="container">
            <div class="text-center">
                <!-- On desktop -->
                <div class="desktop-view">
                    <div class="footer-content">
                        <div class="payment-methods">
                            <!-- <img src="{{ theme_asset('assets/img/media/payments.png') }}" > -->
                        </div>
                        <div class="copyright-text">
                            {{ $web_config['copyright_text']->value }}
                        </div>
                    </div>
                </div>
                <!-- On mobile -->
                <div class="mobile-view">
                    <div class="footer-content">
                        <div class="copyright-text">
                            {{ $web_config['copyright_text']->value }}
                        </div>
                        <div class="payment-methods my-2">
                            <!-- <img src="{{ theme_asset('assets/img/media/payments.png') }}" > -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>
