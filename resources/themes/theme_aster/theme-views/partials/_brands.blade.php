<section>
    <div class="container p-0">
        <div class="card">
            <div class="p-3 p-sm-4">
                <div class="d-flex flex-wrap justify-content-between gap-3 mb-3 mb-sm-4">
                    <div class="d-flex flex-wrap gap-3 align-items-center">
                        <h2><span class="text-primary">{{ translate('brands') }}</span></h2>
                    </div>
                    <div class="swiper-nav d-flex gap-2 align-items-center">
                        <div class="swiper-button-prev top-stores-nav-prev position-static rounded-10"></div>
                        <div class="swiper-button-next top-stores-nav-next position-static rounded-10"></div>
                    </div>
                </div>
                <div class="swiper-container">
                    <div class="secondary-swiper">
                        <div class="swiper-wrapper">
                            @foreach($brands as $brand)
                                <div class="swiper-slide rounded">
                                    <a href="{{url('ads/filter?brand_id='.$brand['id'])}}">
                                        <div class="d-flex flex-column gap-2">
                                            <div>
                                                <img class="d-block m-auto"
                                                src="{{ cloudfront('brand/'.$brand['image'])}}"
                                                onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                                                alt="brand-image"
                                                loading="lazy">
                                            </div>
                                            <h3 class="fw-medium text-center text-primary">{{$brand['name']}}</h3>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
