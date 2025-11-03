@extends('theme-views.layouts.app')

@section('title', $web_config['name']->value.' '.translate('Online_Shopping').' | '.$web_config['name']->value.' '.translate('ecommerce'))
@push('css_or_js')
    <meta property="og:image" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <meta property="twitter:card" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <!-- Add lazy loading styles -->
    <style>
        .lazy-section {
            min-height: 500px; /* Adjust based on your content */
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .loading-spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 4px solid #3498db;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Your existing styles */
        .select-category-button {
            display: none;
        }
        .position-relative {
            position: relative;
        }
        .category-name {
            position: absolute;
            top: 75px;
            right: 30px;
            margin: 0px;
            background: rgba(0, 0, 0, 0.5);
            background: linear-gradient(to bottom right, #00008b, #1e90ff);
            color: white;
            width: 205px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            border-radius: 5px;
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
@endpush
@php($lang=app()->getLocale())

@section('content')
    <main class="main-content d-flex flex-column gap-3 py-3">
        <!-- Above-the-fold content (loaded immediately) -->
        @include('theme-views.partials._main-banner')

        @php($main_section_banner =\App\Model\Banner::where('banner_type', 'Main Section Banner')->where(function($query) {
            $query->where('lang', app()->getLocale())->orWhere('lang','Both');
        })->where(function($query) {
            $query->where('for_mobile', 0)->orWhere('for_mobile', 2);
        })->where('published', 1)->orderBy('priority', 'desc')->get())

        @if (isset($main_section_banner))
            <div class="container rtl my-2 p-0">
                <div class="row">
                    @foreach ($main_section_banner as $main_section_banners)
                    <div class="col-md-4 xs-12 pl-0 pr-0 mb-4 cat_img position-relative">
                        <a href="{{$main_section_banners->url}}" style="">
                            <img class="d-block footer_banner_img rounded" loading="lazy" style="width: 100%; height: auto !important;"
                            onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                            src="{{cloudfront('banner')}}/{{$main_section_banners['photo']}}">
                            @php($category = \App\Model\Category::where('id', $main_section_banners->resource_id)->first())
                            <p class="category-name">{{$category->name}}</p>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="container p-0">
            <!-- Swiper -->
            <div class="auto-item-width position-relative my-4">
                <div class="swiper" data-swiper-loop="false" data-swiper-items="auto" data-swiper-margin="20" data-swiper-pagination-el="null" data-swiper-navigation-next=".swiper-button-next--cat" data-swiper-navigation-prev=".swiper-button-prev--cat">
                    <div class="swiper-wrapper py-2">
                        @php( $cate = \App\Model\Category::where(['parent_id' => 0])->where(['home_status' => 0])->priority()->get())
                        @foreach($cate as $categors)
                        <div class="swiper-slide" style="max-width: 211px;">
                            <a href="{{route('products',['id'=> $categors['id'],'data_from'=>'category','page'=>1])}}" class="store-product d-flex p-3 flex-column gap-3 align-items-center">
                                <div class="position-relative">
                                    <div class="avatar-cat rounded-circle ">
                                        <img  onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                                            src="{{ cloudfront('category/'.$categors->icon)}}" alt="" loading="lazy"
                                            class=" img-fit rounded-circle-cat dark-support ">
                                    </div>
                                </div>
                                <div class="d-flex flex-column align-items-center text-center gap-2 w-100">
                                    <h6 class="text-truncate text-center">{{ $categors->name }}</h6>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-button-next swiper-button-next--cat"></div>
                <div class="swiper-button-prev swiper-button-prev--cat"></div>
            </div>
        </div>

        <!-- Below-the-fold content (lazy loaded) -->

        <!-- Flash Deal -->
        @if ($web_config['flash_deals'])
            <div class="lazy-section" data-section="flash-deals">
                <div class="loading-spinner"></div>
            </div>
        @endif

        <!-- Find What You Need -->
        <div class="lazy-section" data-section="find-what-you-need">
            <div class="loading-spinner"></div>
        </div>

        <!-- Featured Deals -->
        @if ($web_config['featured_deals']->count()>0)
            <div class="lazy-section" data-section="featured-deals">
                <div class="loading-spinner"></div>
            </div>
        @endif

        <!-- Recommended For You -->
        <div class="lazy-section" data-section="recommended-product">
            <div class="loading-spinner"></div>
        </div>

        <!-- Top Rated Products -->
        <div class="lazy-section" data-section="top-rated-products">
            <div class="loading-spinner"></div>
        </div>

        <!-- Today's Best Deal and Just for you -->
        <div class="lazy-section" data-section="best-deal-just-for-you">
            <div class="loading-spinner"></div>
        </div>

        <!-- Home Categories -->
        <div class="lazy-section" data-section="home-categories">
            <div class="loading-spinner"></div>
        </div>

        <!-- Top Stores -->
        <div class="lazy-section" data-section="top-stores">
            <div class="loading-spinner"></div>
        </div>

        <!-- More Stores -->
        @if($web_config['business_mode'] == 'multi')
            <div class="lazy-section" data-section="more-stores">
                <div class="loading-spinner"></div>
            </div>
        @endif
    </main>

    @push('script')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Create Intersection Observer
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const section = entry.target;
                            const sectionName = section.getAttribute('data-section');

                            // Load the section content via AJAX
                            fetch(`/lazy-load-section/${sectionName}`)
                                .then(response => response.text())
                                .then(html => {
                                    section.innerHTML = html;
                                    section.classList.remove('lazy-section');

                                    // Initialize any components in the loaded section
                                    if (typeof initSwiper === 'function') {
                                        initSwiper();
                                    }
                                })
                                .catch(error => {
                                    console.error('Error loading section:', error);
                                    section.innerHTML = '<div class="alert alert-danger">Failed to load content. Please try again.</div>';
                                });

                            // Stop observing this section
                            observer.unobserve(section);
                        }
                    });
                }, {
                    rootMargin: '200px', // Load 200px before the section comes into view
                    threshold: 0.1
                });

                // Observe all lazy sections
                document.querySelectorAll('.lazy-section').forEach(section => {
                    observer.observe(section);
                });
            });
        </script>
    @endpush
@endsection

