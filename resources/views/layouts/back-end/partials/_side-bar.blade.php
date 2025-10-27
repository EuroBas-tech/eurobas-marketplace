
<style>
    .fs-15 {
        font-size: 15px;
    }

    .svg-color {
        fill: #bdc5d1;
    }

    .active .svg-color {
        fill: #5EDF8A;
    }

</style>
<div id="sidebarMain" class="d-none">
    <aside
        style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
        class="bg-white js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
            <div class="navbar-vertical-footer-offset pb-0">
                <div class="navbar-brand-wrapper justify-content-between side-logo">
                    <!-- Logo -->
                    @php($e_commerce_logo=\App\Model\BusinessSetting::where(['type'=>'company_web_logo'])->first()->value)
                    <a class="navbar-brand" href="{{route('admin.dashboard.index')}}" aria-label="Front">
                        <img onerror="this.src='{{asset('public/assets/back-end/img/900x400/img1.jpg')}}'"
                             class="navbar-brand-logo-mini for-web-logo max-h-30"
                             src="{{asset("storage/app/public/company/$e_commerce_logo")}}" alt="Logo">
                    </a>
                    <!-- Navbar Vertical Toggle -->
                    <button type="button"
                            class="d-none js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                        <i class="tio-clear tio-lg"></i>
                    </button>
                    <!-- End Navbar Vertical Toggle -->

                    <button type="button" class="js-navbar-vertical-aside-toggle-invoker close">
                        <i class="tio-first-page navbar-vertical-aside-toggle-short-align" data-toggle="tooltip"
                           data-placement="right" title="" data-original-title="Collapse"></i>
                        <i class="tio-last-page navbar-vertical-aside-toggle-full-align"
                           data-template="<div class=&quot;tooltip d-none d-sm-block&quot; role=&quot;tooltip&quot;><div class=&quot;arrow&quot;></div><div class=&quot;tooltip-inner&quot;></div></div>"
                           data-toggle="tooltip" data-placement="right" title="" data-original-title="Expand"></i>
                    </button>
                </div>

                <!-- Content -->
                <div class="navbar-vertical-content">
                    <!-- Search Form -->
                    <div class="sidebar--search-form pb-3 pt-4">
                        <div class="search--form-group">
                            <button type="button" class="btn"><i class="tio-search"></i></button>
                            <input type="text" class="js-form-search form-control form--control" id="search-bar-input"
                                   placeholder="{{translate('search_menu')}}...">
                        </div>
                    </div>
                    <!-- End Search Form -->
                    <ul class="navbar-nav navbar-nav-lg nav-tabs">
                        <!-- Dashboards -->
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/dashboard')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               title="{{translate('dashboard')}}"
                               href="{{route('admin.dashboard.index')}}">
                                <i class="tio-home-vs-1-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{translate('dashboard')}}
                                </span>
                            </a>
                        </li>
                        <!-- End Dashboards -->

                        <!--Product Management -->
                        @if(\App\CPU\Helpers::module_permission_check('product_management'))
                            <li class="nav-item {{(Request::is('admin/brand*') || Request::is('admin/category*') || Request::is('admin/sub*') || Request::is('admin/attribute*') || Request::is('admin/product*'))?'scroll-here':''}}">
                                <small class="nav-subtitle"
                                       title="">{{translate('market_management')}}</small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li>
                            <!-- Pages -->
                            <li class="navbar-vertical-aside-has-menu {{Request::is('admin/ad*')?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.ad.list')}}" title="{{translate('ads')}}">
                                    <i class="tio-car nav-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('ads')}}</span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu {{(Request::is('admin/category*') ||Request::is('admin/sub*')) ?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                   href="javascript:" title="{{translate('category_Setup')}}">
                                    <i class="tio-filter-list nav-icon"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{translate('categories')}}
                                    </span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                    style="display: {{(Request::is('admin/category*'))?'block':''}}">
                                    <li class="nav-item {{Request::is('admin/category/view')?'active':''}}">
                                        <a class="nav-link " href="{{route('admin.category.view')}}"
                                           title="{{translate('categories')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">{{translate('list')}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="navbar-vertical-aside-has-menu {{Request::is('admin/brand*')?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                   href="javascript:" title="{{translate('brands')}}">
                                    <i class="tio-star nav-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('brands')}}</span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                    style="display: {{Request::is('admin/brand*')?'block':'none'}}">
                                    <li class="nav-item {{Request::is('admin/brand/add-new')?'active':''}}"
                                        title="{{translate('add_new')}}">
                                        <a class="nav-link " href="{{route('admin.brand.add-new')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">{{translate('add_new')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('admin/brand/list')?'active':''}}"
                                        title="{{translate('list')}}">
                                        <a class="nav-link " href="{{route('admin.brand.list')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">{{translate('list')}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="navbar-vertical-aside-has-menu {{Request::is('admin/brand*')?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                   href="javascript:" title="{{translate('brands')}}">
                                    <i class="tio-star nav-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('models')}}</span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                    style="display: {{Request::is('admin/model*')?'block':'none'}}">
                                    <li class="nav-item {{Request::is('admin/model/add-new')?'active':''}}"
                                        title="{{translate('add_new')}}">
                                        <a class="nav-link " href="{{route('admin.model.add-new')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">{{translate('add_new')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('admin/model/list')?'active':''}}"
                                        title="{{translate('list')}}">
                                        <a class="nav-link " href="{{route('admin.model.list')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">{{translate('list')}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="navbar-vertical-aside-has-menu {{Request::is('admin/brand*')?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                   href="javascript:" title="{{translate('brands')}}">
                                    <svg style="fill: #bdc5d1;" width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M152.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 113C-2.3 103.6-2.3 88.4 7 79s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zm0 160c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 273c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zM224 96c0-17.7 14.3-32 32-32l224 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-224 0c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32l224 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-224 0c-17.7 0-32-14.3-32-32zM160 416c0-17.7 14.3-32 32-32l288 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-288 0c-17.7 0-32-14.3-32-32zM48 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate mx-2">
                                        {{translate('lists')}}
                                    </span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                    style="display: {{Request::is('admin/model*')?'block':'none'}}">
                                    <li class="nav-item {{Request::is('admin/list/list/body_types')?'active':''}}"
                                        title="{{translate('add_new')}}">
                                        <a class="nav-link gap-2" href="{{route('admin.list.list', 'body_types')}}"> 
                                            <span class="tio-car nav-indicator-icon fs-15"></span>
                                            <span class="text-truncate">{{translate('body_types')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('admin/list/list/fuel_types')?'active':''}}"
                                        title="{{translate('list')}}">
                                        <a class="nav-link gap-2" href="{{route('admin.list.list', 'fuel_types')}}">
                                            <span class="tio-gas-station nav-indicator-icon fs-15" ></span>
                                            <span class="text-truncate">{{translate('fuel_types')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('admin/list/list/transmission_types')?'active':''}}"
                                        title="{{translate('list')}}">
                                        <a class="nav-link gap-2" href="{{route('admin.list.list', 'transmission_types')}}">
                                            <span class="tio-settings nav-indicator-icon fs-15"></span>
                                            <span class="text-truncate">{{translate('transmission_types')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('admin/list/list/power_sources')?'active':''}}"
                                        title="{{translate('list')}}">
                                        <a class="nav-link gap-2" href="{{route('admin.list.list', 'power_sources')}}">
                                            <span class="tio-flash nav-indicator-icon fs-15"></span>
                                            <span class="text-truncate">{{translate('power_sources')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('admin/list/list/bicycle_types')?'active':''}}"
                                        title="{{translate('list')}}">
                                        <a class="nav-link gap-2" href="{{route('admin.list.list', 'bicycle_types')}}">
                                            <span class="tio-bike nav-indicator-icon fs-15"></span>
                                            <span class="text-truncate">{{translate('bicycle_types')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('admin/list/list/furniture_types')?'active':''}}"
                                        title="{{translate('list')}}">
                                        <a class="nav-link gap-2" href="{{route('admin.list.list', 'furniture_types')}}">
                                            <svg width="20px" class="nav-indicator-icon svg-color" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M144 336C144 288.7 109.8 249.4 64.8 241.5C72 177.6 126.2 128 192 128L448 128C513.8 128 568 177.6 575.2 241.5C530.2 249.5 496 288.7 496 336L496 368L144 368L144 336zM0 448L0 336C0 309.5 21.5 288 48 288C74.5 288 96 309.5 96 336L96 416L544 416L544 336C544 309.5 565.5 288 592 288C618.5 288 640 309.5 640 336L640 448C640 483.3 611.3 512 576 512L64 512C28.7 512 0 483.3 0 448z"/></svg>
                                            <span class="text-truncate">{{translate('furniture_types')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('admin/list/list/furniture_materials')?'active':''}}"
                                        title="{{translate('list')}}">
                                        <a class="nav-link gap-2" href="{{route('admin.list.list', 'furniture_materials')}}">
                                            <span class="tio-layers nav-indicator-icon fs-15"></span>
                                            <span class="text-truncate">{{translate('furniture_material')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('admin/list/list/home_garden_material')?'active':''}}"
                                        title="{{translate('list')}}">
                                        <a class="nav-link gap-2" href="{{route('admin.list.list', 'home_garden_materials')}}">
                                            <span class="tio-layers nav-indicator-icon fs-15"></span>
                                            <span class="text-truncate">{{translate('home_garden_material')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('admin/list/list/machine_types')?'active':''}}"
                                        title="{{translate('list')}}">
                                        <a class="nav-link gap-2" href="{{route('admin.list.list', 'machine_types')}}">
                                            <svg class="nav-indicator-icon svg-color" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 32C241.7 32 256 46.3 256 64L256 160L384 160L384 64C384 46.3 398.3 32 416 32C433.7 32 448 46.3 448 64L448 160L512 160C529.7 160 544 174.3 544 192C544 209.7 529.7 224 512 224L512 288C512 383.1 442.8 462.1 352 477.3L352 544C352 561.7 337.7 576 320 576C302.3 576 288 561.7 288 544L288 477.3C197.2 462.1 128 383.1 128 288L128 224C110.3 224 96 209.7 96 192C96 174.3 110.3 160 128 160L192 160L192 64C192 46.3 206.3 32 224 32z"/></svg>
                                            <span class="text-truncate">{{translate('machine_types')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('admin/list/list/electronic_types')?'active':''}}"
                                        title="{{translate('list')}}">
                                        <a class="nav-link gap-2" href="{{route('admin.list.list', 'electronic_types')}}">
                                            <svg class="nav-indicator-icon svg-color" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 32C241.7 32 256 46.3 256 64L256 160L384 160L384 64C384 46.3 398.3 32 416 32C433.7 32 448 46.3 448 64L448 160L512 160C529.7 160 544 174.3 544 192C544 209.7 529.7 224 512 224L512 288C512 383.1 442.8 462.1 352 477.3L352 544C352 561.7 337.7 576 320 576C302.3 576 288 561.7 288 544L288 477.3C197.2 462.1 128 383.1 128 288L128 224C110.3 224 96 209.7 96 192C96 174.3 110.3 160 128 160L192 160L192 64C192 46.3 206.3 32 224 32z"/></svg>
                                            <span class="text-truncate">{{translate('electronic_types')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('admin/list/list/listing_types')?'active':''}}"
                                        title="{{translate('list')}}">
                                        <a class="nav-link gap-2" href="{{route('admin.list.list', 'listing_types')}}">
                                            <span class="tio-home nav-indicator-icon fs-15"></span>
                                            <span class="text-truncate">{{translate('listing_types')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('admin/list/list/property_types')?'active':''}}"
                                        title="{{translate('list')}}">
                                        <a class="nav-link gap-2" href="{{route('admin.list.list', 'property_types')}}">
                                            <span class="tio-home nav-indicator-icon fs-15"></span>
                                            <span class="text-truncate">{{translate('property_types')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('admin/list/list/shipbuilding_types')?'active':''}}"
                                        title="{{translate('list')}}">
                                        <a class="nav-link gap-2" href="{{route('admin.list.list', 'shipbuilding_types')}}">
                                            <svg width="20px" class="nav-indicator-icon svg-color" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M272 64C245.5 64 224 85.5 224 112L224 128L208 128C163.8 128 128 163.8 128 208L128 316.8L106.4 325.4C91.6 331.3 83.9 347.8 89 362.9C99.4 394.2 115.8 422.2 136.7 446C156.8 436.8 178.4 432.1 200 432C233.1 431.8 266.3 442.2 294.4 463.4L296 464.6L296 249.6L192 291.2L192 208C192 199.2 199.2 192 208 192L432 192C440.8 192 448 199.2 448 208L448 291.2L344 249.6L344 464.6L345.6 463.4C373.1 442.7 405.5 432.2 438 432C460.3 431.9 482.6 436.5 503.3 446C524.2 422.3 540.6 394.2 551 362.9C556 347.7 548.4 331.3 533.6 325.4L512 316.8L512 208C512 163.8 476.2 128 432 128L416 128L416 112C416 85.5 394.5 64 368 64L272 64zM403.4 540.1C424.7 524 453.3 524 474.6 540.1C493.6 554.5 516.5 568.3 541.8 573.4C568.3 578.8 596.1 574.2 622.5 554.3C633.1 546.3 635.2 531.3 627.2 520.7C619.2 510.1 604.2 508 593.6 516C578.7 527.2 565 529.1 551.3 526.3C536.4 523.3 520.4 514.4 503.5 501.7C465.1 472.7 413 472.7 374.5 501.7C350.5 519.8 333.8 528 320 528C306.2 528 289.5 519.8 265.5 501.7C227.1 472.7 175 472.7 136.5 501.7C114.9 518 95.2 527.5 77.6 527.4C68 527.3 57.7 524.4 46.4 515.9C35.8 507.9 20.8 510 12.8 520.6C4.8 531.2 7 546.3 17.6 554.3C36.7 568.7 57 575.3 77.4 575.4C111.3 575.6 141.7 558 165.5 540.1C186.8 524 215.4 524 236.7 540.1C260.9 558.4 289 576 320.1 576C351.2 576 379.2 558.3 403.5 540.1z"/></svg>
                                            <span class="text-truncate">{{translate('shipbuilding_types')}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <!--Product Management Ends-->

                        @if(\App\CPU\Helpers::module_permission_check('promotion_management'))
                        <!--promotion management start-->
                        <li class="nav-item {{(Request::is('admin/banner*') || (Request::is('admin/coupon*')) || (Request::is('admin/notification*')) || (Request::is('admin/deal*')))?'scroll-here':''}}">
                            <small class="nav-subtitle" title="">{{translate('promotion_management')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/banner*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.banner.list')}}" title="{{translate('banners')}}">
                                <i class="tio-photo-square-outlined nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('banners')}}</span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/notification*') ?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:" title="{{translate('notifications')}}">
                                <i class="tio-users-switch nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('notifications')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{(Request::is('admin/notification*') || Request::is('admin/business-settings/fcm-index')) ? 'block':'none'}}">
                                <li class="navbar-vertical-aside-has-menu {{!Request::is('admin/notification/push') && Request::is('admin/notification*')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link"
                                       href="{{route('admin.notification.add-new')}}"
                                       title="{{translate('send_notification')}}">
                                        <img src="{{ asset('public/assets/back-end/img/icons/send-notification.svg') }}" alt="Send Notification.svg" width="15" class="mr-2">
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                            {{translate('Send_Notification')}}
                                        </span>
                                    </a>
                                </li>
                                <li class="navbar-vertical-aside-has-menu {{(Request::is('admin/business-settings/fcm-index') || Request::is('admin/notification/push'))?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{route('admin.notification.push')}}"
                                    title="{{translate('Push_Notification')}}">
                                        <img src="{{ asset('public/assets/back-end/img/icons/push-notification.svg') }}" alt="Push Notification.svg" width="15" class="mr-2">
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                            {{translate('Push_Notification')}}
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/announcement')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.business-settings.announcement')}}"
                               title="{{translate('announcements')}}">
                                <i class="tio-mic-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{translate('announcements')}}
                                </span>
                            </a>
                        </li>
                        <!--promotion management end-->
                        @endif
                        <!-- end refund section -->
                        @if(\App\CPU\Helpers::module_permission_check('support_section'))
                        <li class="nav-item {{(Request::is('admin/support-ticket*') || Request::is('admin/contact*'))?'scroll-here':''}}">
                            <small class="nav-subtitle"
                                   title="">{{translate('help_&_support')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/contact*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.contact.list')}}" title="{{translate('messages')}}">
                                <i class="tio-messages nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <span class="position-relative">
                                    {{translate('messages')}}
                                    @php($message=\App\Model\Contact::where('seen',0)->count())
                                    @if($message!=0)
                                        <span
                                            class="btn-status btn-xs-status btn-status-danger position-absolute top-0 menu-status"></span>
                                    @endif
                                </span>
                            </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/support-ticket*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.support-ticket.view')}}"
                               title="{{translate('support_Ticket')}}">
                                <i class="tio-chat nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <span class="position-relative">
                                    {{translate('support_Ticket')}}
                                    @if(\App\Model\SupportTicket::where('status','open')->count()>0)
                                        <span
                                            class="btn-status btn-xs-status btn-status-danger position-absolute top-0 menu-status"></span>
                                    @endif
                                </span>
                            </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/report*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.report.list')}}"
                                title="{{translate('Reports')}}">
                                <i class="tio-flag-outlined nav-icon"></i>                                
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <span class="position-relative">
                                    {{translate('Reports')}}
                                    @if(\App\Model\SupportTicket::where('status','open')->count()>0)
                                        <span class="btn-status btn-xs-status btn-status-danger position-absolute top-0 menu-status"></span>
                                    @endif
                                </span>
                            </span>
                            </a>
                        </li>
                        @endif
                        <!--support section ends here-->

                        <!--Reports & Analytics section-->
                        @if(\App\CPU\Helpers::module_permission_check('report'))
                        <li class="nav-item {{(Request::is('admin/report/earning') || Request::is('admin/report/inhoue-product-sale') || Request::is('admin/report/seller-report') || Request::is('admin/report/earning') || Request::is('admin/transaction/list') || Request::is('admin/refund-section/refund-list') || Request::is('admin/stock/product-in-wishlist') || Request::is('admin/reviews*') || Request::is('admin/stock/product-stock') || Request::is('admin/transaction/wallet-bonus') || Request::is('admin/report/order')) ? 'scroll-here':''}}">
                            <small class="nav-subtitle" title="">
                                {{translate('accounting')}}
                            </small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>                            
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/report/order')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.accounting.index')}}"
                                title="{{translate('order_Report')}}">
                                <i class="tio-calculator nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><span class="position-relative">
                                {{translate('accounting')}}
                            </a>
                        </li>
                        @endif
                        <!--Reports & Analytics section End-->

                        @if(\App\CPU\Helpers::module_permission_check('user_section'))
                            <li class="nav-item {{(Request::is('admin/customer/list') ||Request::is('admin/sellers/subscriber-list')||Request::is('admin/sellers/seller-add') || Request::is('admin/sellers/seller-list') || Request::is('admin/delivery-man*'))?'scroll-here':''}}">
                                <small class="nav-subtitle" title="">{{translate('user_management')}}</small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li>

                            <li class="navbar-vertical-aside-has-menu {{(Request::is('admin/customer/wallet*') || Request::is('admin/customer/list') || Request::is('admin/customer/view*') || Request::is('admin/reviews*') || Request::is('admin/customer/loyalty/report'))?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                href="javascript:" title="{{translate('customers')}}">
                                    <i class="tio-wallet nav-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('customers')}}</span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                    style="display: {{(Request::is('admin/customer/wallet*') || Request::is('admin/customer/list') || Request::is('admin/customer/view*') || Request::is('admin/reviews*') || Request::is('admin/customer/loyalty/report'))?'block':'none'}}">
                                    <li class="nav-item {{Request::is('admin/customer/list') || Request::is('admin/customer/view*')?'active':''}}">
                                        <a class="nav-link " href="{{route('admin.customer.list')}}"
                                        title="{{translate('Customer_List')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">{{translate('customer_List')}} </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            @if(auth('admin')->user()->admin_role_id==1)
                                <li class="navbar-vertical-aside-has-menu {{(Request::is('admin/employee*') || Request::is('admin/custom-role*'))?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:" title="{{translate('employees')}}">
                                        <i class="tio-user nav-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{translate('employees')}}
                                    </span>
                                    </a>
                                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                        style="display: {{Request::is('admin/employee*') || Request::is('admin/custom-role*')?'block':'none'}}">
                                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/custom-role*')?'active':''}}">
                                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                            href="{{route('admin.custom-role.create')}}"
                                            title="{{translate('employee_Role_Setup')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                            {{translate('employee_Role_Setup')}}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{(Request::is('admin/employee/list') || Request::is('admin/employee/add-new') || Request::is('admin/employee/update*'))?'active':''}}">
                                            <a class="nav-link" href="{{route('admin.employee.list')}}"
                                            title="{{translate('employees')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate">{{translate('employees')}}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endif

                        @if(\App\CPU\Helpers::module_permission_check('user_section'))
                            <li class="nav-item {{(Request::is('admin/customer/list') ||Request::is('admin/sellers/subscriber-list')||Request::is('admin/sellers/seller-add') || Request::is('admin/sellers/seller-list') || Request::is('admin/delivery-man*'))?'scroll-here':''}}">
                                <small class="nav-subtitle" title="">{{translate('paid_promotion')}}</small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li>

                            <li class="navbar-vertical-aside-has-menu {{Request::is('admin/paid-banners/*')?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.paid-banner.list')}}"
                                title="{{translate('paid_banners')}}">
                                    <i class="tio-photo-square-outlined nav-icon"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{translate('paid_banners')}}
                                </span>
                                </a>
                            </li>

                            <li class="navbar-vertical-aside-has-menu {{Request::is('admin/customer/subscriber-list')?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:" title="{{translate('subscribers')}}">
                                    <i class="tio-crown nav-icon"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{translate('subscriptions')}}
                                    </span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                    style="display: {{Request::is('admin/subscription')?'active':''}}">
                                    
                                    <li class="nav-item {{(Request::is('admin/subscription/packages/list') || Request::is('admin/subscription/packages/list') || Request::is('admin/subscription/packages/list*'))?'active':''}}">
                                        <a class="nav-link" href="{{route('admin.subscription.packages.list')}}"
                                        title="{{translate('subscription_packages')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">{{translate('subscription_packages')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{(Request::is('admin/subscription/promotional-videos/list') || Request::is('admin/subscription/promotional-videos/list') || Request::is('admin/subscription/promotional-videos/list*'))?'active':''}}">
                                        <a class="nav-link" href="{{route('admin.subscription.promotional-videos.list')}}"
                                        title="{{translate('promotional_videos')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">{{translate('promotional_videos')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{(Request::is('admin/subscription/settings') || Request::is('admin/subscription/settings') || Request::is('admin/subscription/settings*'))?'active':''}}">
                                        <a class="nav-link" href="{{route('admin.subscription.subscription-settings')}}"  
                                        title="{{translate('subscription_settings')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">{{translate('subscription_settings')}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <!--System Settings-->
                        @if(\App\CPU\Helpers::module_permission_check('system_settings'))
                        <li class="nav-item {{(Request::is('admin/business-settings/social-media') || Request::is('admin/business-settings/web-config/app-settings') || Request::is('admin/business-settings/terms-condition') || Request::is('admin/business-settings/page*') || Request::is('admin/business-settings/privacy-policy') || Request::is('admin/business-settings/about-us') || Request::is('admin/helpTopic/list') || Request::is('admin/business-settings/fcm-index') || Request::is('admin/business-settings/mail')|| Request::is('admin/business-settings/web-config/login-url-setup') || Request::is('admin/business-settings/web-config/db-index')||Request::is('admin/business-settings/web-config/environment-setup') || Request::is('admin/business-settings/web-config') || Request::is('admin/business-settings/cookie-settings') || Request::is('admin/business-settings/otp-setup') || Request::is('admin/system-settings/software-update') || Request::is('admin/business-settings/web-config/theme/setup') || Request::is('admin/business-settings/delivery-restriction') || Request::is('admin/addon')) ? 'scroll-here' : '' }}">
                            <small class="nav-subtitle"
                                   title="">{{translate('system_Settings')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{(Request::is('admin/business-settings/web-config') || Request::is('admin/product-settings/inhouse-shop') || Request::is('admin/business-settings/seller-settings') || Request::is('admin/customer/customer-settings') || Request::is('admin/business-settings/delivery-man-settings') || Request::is('admin/refund-section/refund-index') || Request::is('admin/business-settings/shipping-method/setting') || Request::is('admin/business-settings/order-settings/index') || Request::is('admin/product-settings') || Request::is('admin/business-settings/web-config/delivery-restriction') || Request::is('admin/business-settings/delivery-restriction'))?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.business-settings.web-config.index')}}"
                               title="{{translate('business_Setup')}}">
                                <i class="tio-globe nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{translate('business_Setup')}}
                            </span>
                            </a>
                        </li>

{{--                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/email-templates/*') ? 'active':''}}">--}}
{{--                            <a class="nav-link " href="{{route('admin.business-settings.email-templates.index')}}"--}}
{{--                               title="{{translate('email_templates')}}">--}}
{{--                                <span class="tio-email nav-icon"></span>--}}
{{--                                <span class="text-truncate">{{translate('email_templates')}}</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}

                        <li class="navbar-vertical-aside-has-menu {{(Request::is('admin/business-settings/mail') || Request::is('admin/business-settings/sms-module') || Request::is('admin/business-settings/captcha') || Request::is('admin/social-login/view') || Request::is('admin/social-media-chat/view') || Request::is('admin/business-settings/map-api') || Request::is('admin/business-settings/payment-method') || Request::is('admin/business-settings/payment-method/offline-payment*'))?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.payment-method.index')}}"
                               title="{{translate('3rd_party')}}">
                                <span class="tio-key nav-icon"></span>
                                <span class="text-truncate">{{translate('3rd_party')}}</span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/terms-condition') || Request::is('admin/business-settings/page*') || Request::is('admin/business-settings/privacy-policy') || Request::is('admin/business-settings/about-us') || Request::is('admin/helpTopic/list') || Request::is('admin/business-settings/social-media') || Request::is('admin/file-manager*') || Request::is('admin/business-settings/features-section') ?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:" title="{{translate('Pages_&_Media')}}">
                                <i class="tio-pages-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{translate('Pages_&_Media')}}
                            </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/business-settings/terms-condition') || Request::is('admin/business-settings/page*') || Request::is('admin/business-settings/privacy-policy') || Request::is('admin/business-settings/about-us') || Request::is('admin/helpTopic/list') || Request::is('admin/business-settings/social-media') || Request::is('admin/file-manager*') || Request::is('admin/business-settings/features-section')?'block':'none'}}">
                                <li class="nav-item {{(Request::is('admin/business-settings/terms-condition') || Request::is('admin/business-settings/page*') || Request::is('admin/business-settings/privacy-policy') || Request::is('admin/business-settings/about-us') || Request::is('admin/helpTopic/list')|| Request::is('admin/business-settings/features-section'))?'active':''}}">
                                    <a class="nav-link" href="{{route('admin.business-settings.terms-condition')}}"
                                       title="{{translate('pages')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                      {{translate('pages')}}
                                    </span>
                                    </a>
                                </li>
                                <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/social-media')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link"
                                       href="{{route('admin.business-settings.social-media')}}"
                                       title="{{translate('social_Media_Links')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{translate('social_Media_Links')}}
                                </span>
                                    </a>
                                </li>

                                <li class="navbar-vertical-aside-has-menu {{Request::is('admin/file-manager*')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link"
                                       href="{{route('admin.file-manager.index')}}"
                                       title="{{translate('gallery')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{translate('gallery')}}
                                    </span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{(Request::is('admin/business-settings/web-config/environment-setup') || Request::is('admin/business-settings/web-config/mysitemap') || Request::is('admin/business-settings/analytics-index') || Request::is('admin/currency/view') || Request::is('admin/business-settings/web-config/db-index') || Request::is('admin/business-settings/language*') || Request::is('admin/business-settings/web-config/theme/setup')  || Request::is('admin/system-settings/software-update') || Request::is('admin/business-settings/cookie-settings') || Request::is('admin/business-settings/otp-setup') || Request::is('admin/business-settings/web-config/app-settings') || Request::is('admin/addon'))?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               title="{{translate('system_Setup')}}"
                               href="{{route('admin.business-settings.web-config.environment-setup')}}">
                                <i class="tio-labels nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{translate('system_Setup')}}
                            </span>
                            </a>
                        </li>

                        @if(count(config('addon_admin_routes'))>0)
                            <li class="navbar-vertical-aside-has-menu
                                @foreach(config('addon_admin_routes') as $routes)
                                    @foreach($routes as $route)
                                        {{strstr(Request::url(), $route['path'])?'active':''}}
                                    @endforeach
                                @endforeach
                            ">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                   href="javascript:" title="{{translate('Pages_&_Media')}}">
                                    <i class="tio-puzzle nav-icon"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{translate('addon_Menus')}}
                                    </span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                    style="display:
                                    @foreach(config('addon_admin_routes') as $routes)
                                        @foreach($routes as $route)
                                            {{ strstr(Request::url(), $route['path'])?'block':'' }}
                                        @endforeach
                                    @endforeach
                                    ">
                                    @foreach(config('addon_admin_routes') as $routes)
                                        @foreach($routes as $route)
                                            <li class="navbar-vertical-aside-has-menu {{strstr(Request::url(), $route['path'])?'active':''}}">

                                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                                   href="{{ $route['url'] }}" title="{{ translate($route['name']) }}">
                                                    <span class="tio-circle nav-indicator-icon"></span>
                                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                                        {{ translate($route['name']) }}
                                                    </span>
                                                </a>

                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </li>
                        @endif

{{--                            @if(count(config('addon_admin_routes'))>0)--}}
{{--                                <li class="nav-item--}}
{{--                                @foreach(config('addon_admin_routes') as $routes)--}}
{{--                                    @foreach($routes as $route)--}}
{{--                                        {{ strstr(Request::url(), $route['path']) ? 'scroll-here':''}}--}}
{{--                                    @endforeach--}}
{{--                                @endforeach--}}
{{--                                ">--}}
{{--                                    <small class="nav-subtitle"--}}
{{--                                           title="">{{translate('addon_menus')}}</small>--}}
{{--                                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>--}}
{{--                                </li>--}}

{{--                                @foreach(config('addon_admin_routes') as $routes)--}}
{{--                                    @foreach($routes as $route)--}}
{{--                                        <li class="navbar-vertical-aside-has-menu {{strstr(Request::url(), $route['path'])?'active':''}}">--}}

{{--                                            <a class="js-navbar-vertical-aside-menu-link nav-link"--}}
{{--                                               href="{{ $route['url'] }}" title="{{ translate($route['name']) }}">--}}
{{--                                                <i class="tio-labels nav-icon"></i>--}}
{{--                                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">--}}
{{--                                                    {{ translate($route['name']) }}--}}
{{--                                                </span>--}}
{{--                                            </a>--}}

{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                @endforeach--}}

{{--                            @endif--}}
                        @endif
                        <!--System Settings end-->

                        <li class="nav-item pt-5">
                        </li>
                    </ul>
                </div>
                <!-- End Content -->
            </div>
        </div>
    </aside>
</div>

@push('script_2')
    <script>
        $(window).on('load' , function() {
            if($(".navbar-vertical-content li.active").length) {
                $('.navbar-vertical-content').animate({
                    scrollTop: $(".navbar-vertical-content li.active").offset().top - 150
                }, 10);
            }
        });

        //Sidebar Menu Search
        var $rows = $('.navbar-vertical-content .navbar-nav > li');
        $('#search-bar-input').keyup(function() {
            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

            $rows.show().filter(function() {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                return !~text.indexOf(val);
            }).hide();
        });

    </script>
@endpush

