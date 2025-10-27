<section class="banner w-100 sweet-shadow">
    <div class="card moble-border-0">
        <div class="p-0">
            <div class="row g-3 justify-content-center">
                <div class="col-xl-12">
                    <div class="rounded">
                        <ul class="nav nav-tabs custom-tab-style" id="myTab" role="tablist">
                            @foreach($categories as $category)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link max-content fs-18 px-4 text-center @if($loop->index == 0) active @endif" 
                                        id="tab-{{$category->name}}" 
                                        data-bs-toggle="tab" 
                                        data-bs-target="#{{ str_replace(' ', '-', $category->name) }}-tap-{{$loop->index}}" 
                                        type="button"
                                        role="tab" 
                                        aria-controls="{{ str_replace(' ', '-', $category->name) }}-tap-{{$loop->index}}"
                                        aria-selected="@if($loop->index == 0) true @else false @endif">
                                            <img width="25px" src="{{ theme_asset('assets/img/svg/'.str_replace(' ', '-', $category->name).'-icon.svg') }}" alt="">
                                            {{ ucwords($category->name) }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content p-2 px-3">
                            @foreach($categories as $category)
                                <div class="tab-pane fade @if($loop->index == 0) show active @endif" 
                                    id="{{ str_replace(' ', '-', $category->name) }}-tap-{{$loop->index}}" 
                                    role="tabpanel" 
                                    aria-labelledby="{{ str_replace(' ', '-', $category->name) }}-tap-{{$loop->index}}">
                                    <form action="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row align-items-center">
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="form-group mb-3">
                                                                    <label for="delivery_service_name" class="fw-medium">{{ translate('country') }}</label>
                                                                    <select class="form-control custom-input-height emoji-font" name="" >
                                                                        <option value="">{{ translate('choose_the_country') }}</option>
                                                                        @foreach (SYSTEM_COUNTRIES as $country)
                                                                            <option class="emoji-font" value="">{{$country['emoji']}} {{ $country['name'] }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="form-group mb-3">
                                                                    <label for="delivery_service_name" class="fw-medium">{{ translate('mark') }}</label>
                                                                    <select class="form-control custom-input-height" name="" >
                                                                        <option value="">one</option>
                                                                        <option value="">two</option>
                                                                        <option value="">three</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group mb-3">
                                                                    <label for="delivery_service_name" class="fw-medium">{{ translate('model') }}</label>
                                                                    <select class="form-control custom-input-height" name="" >
                                                                        <option value="">one</option>
                                                                        <option value="">two</option>
                                                                        <option value="">three</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group mb-3">
                                                                    <label for="delivery_service_name" class="fw-medium">{{ translate('construction_year') }}</label>
                                                                    <select class="form-control custom-input-height" name="" >
                                                                        <option value="">one</option>
                                                                        <option value="">two</option>
                                                                        <option value="">three</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group mb-3">
                                                                    <label for="delivery_service_name" class="fw-medium">{{ translate('price') }}</label>
                                                                    <select class="form-control custom-input-height" name="" >
                                                                        <option value="">one</option>
                                                                        <option value="">two</option>
                                                                        <option value="">three</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group mb-3">
                                                                    <label for="delivery_service_name" class="fw-medium">{{ translate('mileage') }}</label>
                                                                    <select class="form-control custom-input-height" name="" >
                                                                        <option value="">one</option>
                                                                        <option value="">two</option>
                                                                        <option value="">three</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group d-flex justify-content-end mb-2">
                                                            <button class="btn btn-primary">
                                                                <i class="bi bi-search"></i>
                                                                Search (120)
                                                            </button>
                                                        </div>
                                                        <div class="form-group d-flex justify-content-end">
                                                            <button class="btn btn-primary">
                                                                advanced filter
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>
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

    document.addEventListener('DOMContentLoaded', function() {
        // This ensures Bootstrap's tab functionality is properly initialized
        var tabElements = document.querySelectorAll('[data-bs-toggle="tab"]');
        tabElements.forEach(function(tabElement) {
            new bootstrap.Tab(tabElement);
        });
    });

</script>
