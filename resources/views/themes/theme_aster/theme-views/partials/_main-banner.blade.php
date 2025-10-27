<section class="banner">
    <div class="card moble-border-0 px-2">
        <div class="p-0">
            <div class="row g-3">
                {{--
                <div class="col-xl-3 col-lg-4 d-none d-xl-block">
                    <div class="col-xl-12 m-0">
                        <ul class="dropdown-menu dropdown-menu--static" style="--bs-dropdown-min-width: auto">
                            @foreach ($categories as $key => $category)
                                <li class="{{ $category->childes->count() > 0 ? 'menu-item-has-children' : '' }}">
                                    <a href="javascript:"
                                        onclick="location.href='{{ route('products', ['id' => $category['id'], 'data_from' => 'category', 'page' => 1]) }}'">
                                        {{ $category['name'] }}
                                    </a>
                                    @if ($category->childes->count() > 0)
                                        <ul class="sub-menu">
                                            @foreach ($category['childes'] as $subCategory)
                                                <li
                                                    class="{{ $subCategory->childes->count() > 0 ? 'menu-item-has-children' : '' }}">
                                                    <a href="javascript:"
                                                        onclick="location.href='{{ route('products', ['id' => $subCategory['id'], 'data_from' => 'category', 'page' => 1]) }}'">
                                                        {{ $subCategory['name'] }}
                                                    </a>
                                                    @if ($subCategory->childes->count() > 0)
                                                        <ul class="sub-menu">
                                                            @foreach ($subCategory['childes'] as $subSubCategory)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('products', ['id' => $subSubCategory['id'], 'data_from' => 'category', 'page' => 1]) }}">
                                                                        {{ $subSubCategory['name'] }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                            <li class="d-flex justify-content-center mt-3 py-0">
                                <a
                                    href="{{ route('products', ['data_from' => 'latest']) }}"class="btn-link text-primary">
                                    {{ translate('view_all') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                --}}
                <div class="col-xl-12 m-0">
                    <div class="row g-2 g-sm-3 mt-lg-0">
                        <div class="col-12 margin-top-on-mobile">
                            <div style="max-height: 522px;" class="swiper-container shadow-sm rounded">
                                <!-- Swiper -->
                                <div class="banner-swiper" data-swiper-loop="true" data-swiper-navigation-next="true"
                                    data-swiper-navigation-prev="true">
                                    <div class="swiper-wrapper">
                                        @foreach ($main_banner as $key => $banner)
                                            @if(($banner->lang=="Both" || $banner->lang==app()->getLocale()) &&  ($banner->for_mobile==0 || $banner->for_mobile==2  ))

                                                <div class="swiper-slide">
                                                    <a href="{{ $banner['url'] }}" class="h-100">
                                                        <img src="{{ asset('storage/app/public/banner') }}/{{ $banner['photo'] }}"
                                                            loading="lazy"
                                                            onerror="this.src='{{ theme_asset('assets/img/image-place-holder-2_1.png') }}'"
                                                            alt="" class="dark-support rounded responsive-banner-image">
                                                    </a>
                                                </div>

                                            @endif
                                        @endforeach

                                        @if (count($main_banner) == 0)
                                            <img src="{{ theme_asset('assets/img/image-place-holder-2_1.png') }}"
                                                loading="lazy" alt="" class="dark-support rounded">
                                        @endif
                                    </div>

                                    <div class="swiper-pagination main-banner-top"></div>

                                    <!-- Navigation Buttons (Required for Next/Prev) -->
                                    <div style="right: 20px;" class="swiper-button-next"></div>
                                    <div style="left: 20px;" class="swiper-button-prev"></div>


                                </div>
                            </div>
                        </div>


                        <!-- ********************** Removed ************************* -->

                        {{-- @foreach ($footer_banner as $key => $banner)
                            <div class="col-6 d-none d-sm-block">
                                <a href="{{ $banner['url'] }}" class="ad-hover h-100">
                                    <img src="{{asset('storage/app/public/banner')}}/{{$banner['photo']}}" loading="lazy" alt=""
                                         onerror="this.src='{{theme_asset('assets/img/image-place-holder-2_1.png')}}'"
                                         class="dark-support rounded w-100 img-fit">
                                </a>
                            </div>
                        @endforeach
                        @if (count($footer_banner) == 0)
                            <div class="col-6 d-none d-sm-block">
                                <span class="ad-hover h-100">
                                    <img src="{{theme_asset('assets/img/image-place-holder-2_1.png')}}" loading="lazy" alt=""
                                         class="dark-support rounded w-100 img-fit">
                                </span>
                            </div>
                            <div class="col-6 d-none d-sm-block">
                                <span class="ad-hover h-100">
                                    <img src="{{theme_asset('assets/img/image-place-holder-2_1.png')}}" loading="lazy" alt=""
                                         class="dark-support rounded w-100 img-fit">
                                </span>
                            </div>
                        @endif
                        @if (count($footer_banner) == 1)
                            <div class="col-6 d-none d-sm-block">
                                <span class="ad-hover h-100">
                                    <img src="{{theme_asset('assets/img/image-place-holder-2_1.png')}}" loading="lazy" alt=""
                                         class="dark-support rounded w-100">
                                </span>
                            </div>
                        @endif --}}
                        <!-- ********************** Removed ************************* -->



                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

        document.addEventListener("DOMContentLoaded", function () {
            var swiper = new Swiper(".banner-swiper", {
                loop: true,
                autoplay: {
                    delay: 6000, 
                    disableOnInteraction: false,
                },
                speed: 1700,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });
        });


</script>
