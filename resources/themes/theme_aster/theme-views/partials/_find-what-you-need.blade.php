<section>
    <div class="container p-0">
        <div class="flexible-grid lg-down-1 gap-3 flex-fullwidth">
            <!-- for mobile start -->
            @if(isset($footer_banner[0]))
                <div class="col-12 d-sm-none">
                    <a href="{{ $footer_banner[0]['url'] }}" class="ad-hover">
                        <img src="{{cloudfront('banner')}}/{{$footer_banner[0]['photo']}}" loading="lazy" alt=""
                                onerror="this.src='{{theme_asset('assets/img/image-place-holder-2_1.png')}}'"
                                class="dark-support rounded w-100">
                    </a>
                </div>
            @endif
            <!-- for mobile end -->
            <div class="card">
                <div class="p-3 p-sm-4">
                    <div class="d-flex flex-wrap justify-content-between gap-3 mb-3 mb-sm-4">
                        <h2><span class="text-primary">{{translate('Find')}}</span> {{translate('what_you_need')}}</h2>
                        <div class="swiper-nav d-flex gap-2 align-items-center">
                            <div
                                class="swiper-button-prev find-what-you-need-nav-prev position-static rounded-10"></div>
                            <div
                                class="swiper-button-next find-what-you-need-nav-next position-static rounded-10"></div>
                        </div>
                    </div>
                    <div class="swiper-container">
                        <!-- Swiper -->
                        <div class="position-relative d-none d-md-block">
                            <div class="swiper" data-swiper-loop="true" data-swiper-margin="16"
                                 data-swiper-speed="2000" data-swiper-pagination-el="null"
                                 data-swiper-navigation-next=".find-what-you-need-nav-next"
                                 data-swiper-navigation-prev=".find-what-you-need-nav-prev">
                                <div class="swiper-wrapper">
                                    @foreach($category_slider as $ke=>$all_category)
                                    <div class="swiper-slide align-items-start bg-white">
                                        <div class="flexible-grid md-down-1 gap-3 w-100" style="--width: 1fr">
                                            <!-- Category Wrap -->
                                            @foreach($all_category as $key=>$category)

                                                <div class="bg-light rounded p-4 cool-gray-bg">
                                                    <div
                                                        class="d-flex flex-wrap justify-content-between gap-3 mb-3 align-items-start">
                                                        <div class="">
                                                            <h5 class="mb-1 text-truncate" style="--width: 16ch">
                                                                {{$category['name']}}
                                                            </h5>
                                                            <div class="text-muted">{{$category['product_count']}} {{translate('products')}}</div>
                                                        </div>

                                                        <a href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}" class="outlined-bordered-btn">
                                                            {{ translate('View_All') }}
                                                            <i class="bi bi-chevron-right"></i>
                                                        </a>

                                                    </div>

                                                    <div class="find-what-you-need-items">
                                                        @foreach($category['childes'] as $key=>$sub_category)
                                                            <a href="{{route('products',['id'=> $sub_category['id'],'data_from'=>'category','page'=>1])}}"
                                                               class="d-flex flex-column gap-2 mb-3 align-items-center">
                                                                <div class="img-wrap bg-white w-100 rounded justify-content-center d-flex">
                                                                    <div class="floting-text">
                                                                        <span class="truncate text-center">
                                                                            <span>
                                                                                {{
                                                                                    count($category['childes'])<4 && in_array($key, [0,1,2]) && !array_key_exists(++$key, $category['childes']) ?
                                                                                            ($sub_category['sub_category_product_count'] > 1 ? ($sub_category['sub_category_product_count']-1).'+' : $sub_category['sub_category_product_count'])
                                                                                    : $sub_category['sub_category_product_count']
                                                                                }}
                                                                            </span>
                                                                            {{ translate('products') }}
                                                                        </span>
                                                                    </div>
                                                                    <div
                                                                        class=" rounded " >
                                                                        <img onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                                                                            src="{{cloudfront('ategory')}}/{{$sub_category['icon']}}" alt=""
                                                                            loading="lazy" class="dark-support img-fit prod-imag4 " >
                                                                    </div>
                                                                </div>
                                                                <div class="truncate text-center">{{$sub_category['name']}}</div>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Swiper -->
                        <div class="position-relative d-md-none">
                            <div class="swiper" data-swiper-loop="true"
                                 data-swiper-speed="2000" data-swiper-margin="10" data-swiper-pagination-el="null"
                                 data-swiper-navigation-next=".find-what-you-need-nav-next"
                                 data-swiper-navigation-prev=".find-what-you-need-nav-prev">
                                <div class="swiper-wrapper">
                                    @foreach($final_category as $key=>$category)
                                    <div class="swiper-slide align-items-start d-block bg-light rounded p-3 p-sm-4 align-items-stretch">
                                        <div>
                                            <div
                                                class="d-flex flex-wrap justify-content-between gap-3 mb-3 align-items-start">
                                                <div class="">
                                                    <h5 class="mb-1 text-truncate" style="--width: 16ch">
                                                        {{$category['name']}}</h5>
                                                    <div class="text-muted">{{$category['product_count']}} {{translate('products')}}</div>
                                                </div>

                                                <a href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}" class="btn-link">{{translate('view_all')}}<i
                                                        class="bi bi-chevron-right text-primary"></i></a>
                                            </div>

                                            <div class="auto-col gap-3" style="--minWidth: 3.75rem; --maxWidth: 5rem">
                                                @foreach($category['childes'] as $key=>$sub_category)
                                                    <a href="{{route('products',['id'=> $sub_category['id'],'data_from'=>'category','page'=>1])}}"
                                                        class="d-flex flex-column gap-2 mb-3 align-items-start">
                                                        <div
                                                            class="avatar avatar-xxl ov-hidden hover-zoom-in rounded">
                                                            <img onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                                                                    src="{{cloudfront('category')}}/{{$sub_category['icon']}}" alt=""
                                                                    loading="lazy" class="dark-support img-fit " >
                                                        </div>
                                                        <div class="text-truncate">{{$sub_category['name']}}</div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
