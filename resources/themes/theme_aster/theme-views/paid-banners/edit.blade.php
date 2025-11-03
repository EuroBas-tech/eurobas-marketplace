@extends('theme-views.layouts.app')

@section('title', translate('My_Profile').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@section('content')

<style>
    body {
        background-color: unset !important;
    }
    .price-text {
        font-size: 35px;
    }

    .fixed-description-height {
        min-height: 3em; /* adjust this based on your font size */
        line-height: 1.5em;
        overflow: hidden;
    }

    .pricing-card {
        border: 1px solid #d9d9d9;
        box-shadow: 0px 0px 2px #858585;
    }

    .pricing-card.active {
        border: 1px solid #198754;
        transform: scale(1.08);
        transition: .2s;
    }
</style>

<!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 mb-4">
        <div class="container">
            <div class="row g-3">

                <!-- Sidebar-->
                @include('theme-views.partials._profile-aside')

                <div class="col-xxl-10 col-xl-9 col-lg-9 col-md-12 px-3">
                    <div>
                        <form method="POST" action="{{route('update.paid-banners')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="banner_id" value="{{$paid_banner->id}}" />
                            <div class="col-xl-12 mb-2">
                                <div class="form-group">
                                    <h1 class="pt-4 pb-3 sponsor-title" >{{translate('Promote Your Project or Product – Reach More Buyers with a Banner')}}</h1>
                                </div>
                            </div>

                            <div class="col-xl-12 mb-4">
                                <div class="form-check form-switch d-flex align-items-center gap-1 mb-3">
                                    <input class="form-check-input" type="checkbox" name="redirect_to_ads" role="switch" id="redirect_to_ads" {{ $paid_banner['banner_url'] ? 'checked' : '' }} >
                                    <label class="form-check-label m-0 pt-1" for="redirect_to_ads">{{translate('redirect_to_one_of_your_ads_when_clicked')}}</label>
                                </div>
                                <div id="user_ads_box" class="form-group @if(!$paid_banner['banner_url']) d-none @endif ">
                                    <div id="user_ads" >
                                        <label for="banner_url">{{translate('banner_url')}}</label>
                                        <div class="dropdown mb-1">
                                            <input type="hidden" name="ad_id" id="selected_ad_id" value="">
                                            <button style="border: 1px solid #ced4da;border-radius: 7px;"
                                                    class="btn btn-outline-secondary no-hover-btn w-100 custom-input-height justify-content-start"
                                                    type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span id="selectedCategoryText" class="fw-normal font-size-16">
                                                    {{translate('ads')}} ({{$user_ads->count()}})
                                                </span>
                                            </button>
                                            <ul class="dropdown-menu w-100 p-0" style="max-height: 350px;overflow-y: auto;border: 1px #80808026 solid;">
                                                @foreach($user_ads as $user_ad)
                                                    <li class="p-0 border-bottom">
                                                        <a class="dropdown-item font-size-16 d-flex align-items-center p-2 gap-2"
                                                        href="#"
                                                        data-id="{{ $user_ad->id }}"
                                                        data-slug="{{ $user_ad->slug }}">
                                                            <div>
                                                                <img class="rounded unset-max-inline-size" width="80px" height="80px" src="{{ env_asset('storage/ad/thumbnail/'.$user_ad->thumbnail) }}" alt="ad_image">
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                                <div class="d-flex gap-1 flex-column">
                                                                    <h5 class="fw-medium text-primary">{{ $user_ad['title'] }}</h5>
                                                                    <span class="no-hover">{{translate('category')}} : {{ $user_ad['category']['name'] }}</span>
                                                                </div>
                                                                <div class="d-sm-block d-none">
                                                                    @php($locale = SOLVE_LOCALE_CODES[app()->getLocale()] ?? app()->getLocale())
                                                                    <span class="no-hover">{{ $user_ad['created_at']->format('Y-m-d') }} ({{$user_ad['created_at']->locale($locale)->diffForHumans()}})</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-sm-4 mb-5">
                                <div class="form-group">
                                    <label >{{translate('banner_image')}}</label>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="row">
                                            <div class="col-xl-6 col-md-7 col-sm-10 col-12">
                                                <div class="upload-file w-100" style="width: min-content;">
                                                    <input
                                                        type="file"
                                                        class="upload-file__input banner"
                                                        name="banner_image"
                                                        data-old="{{ cloudfront('paid-banners/'.$paid_banner->banner_image) }}"
                                                        id="cover-input"
                                                        aria-required="true"
                                                        accept="image/*"
                                                    >
                                                    <div class="upload-file__img w-100">
                                                        <div class="temp-img-box">
                                                            <div class="d-flex align-items-center flex-column gap-2">
                                                                <i class="bi bi-upload fs-30"></i>
                                                                <div class="fs-12 text-muted">{{translate('banner_image')}}</div>
                                                            </div>
                                                        </div>
                                                        <img src="#" class="dark-support image-fit-cover border" alt="" hidden="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="my-4" >
                                <h2 class="my-3" >{{translate('pricing')}}</h2>

                                <div class="mb-4">
                                    @if (\Carbon\Carbon::parse($paid_banner->expiration_date)->isPast())
                                        <span class="text-danger">
                                            {{ translate('this_package_has_expired') }} :
                                            {{ \Carbon\Carbon::parse($paid_banner->expiration_date)->format('Y-m-d H:i') }}
                                        </span>
                                    @else
                                        <span class="text-success">
                                            {{ translate('this_package_is_active_until') }} :
                                            {{ \Carbon\Carbon::parse($paid_banner->expiration_date)->format('Y-m-d H:i') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="row">
                                    @foreach($packages as $package)
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 d-flex mb-4" style="min-width: 289px;">
                                            <div class="card rounded position-relative p-4 w-100 d-flex flex-column justify-content-between pricing-card">
                                                <div class="mb-4" >
                                                    <div class="d-flex align-items-end gap-1 mb-4">
                                                        <h2 class="text-primary price-text m-0">€{{number_format($package['price'], 2) }}</h2>
                                                        <h2 class="fw-lighter price-text">/</h2>
                                                        <h6 class="mb-2 fw-medium">{{translate('for')}} {{$package->duration_in_days}} {{ translate('days') }}</h6>
                                                    </div>
                                                    <div>
                                                        @if($package->features)
                                                            @foreach($package->features as $feature)
                                                                <h6 class="mb-2 fw-medium d-flex align-items-start gap-1">
                                                                    <i class="bi bi-check2-all text-success"></i>
                                                                    <span>{{translate($feature->name)}}</span>
                                                                </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary package-btn rounded-pill mt-auto" data-id="{{ $package->id }}" type="button">
                                                    {{translate('get_started')}}
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div>
                                    <button id="sponsor-submit-btn" type="submit" class="btn btn-primary d-flex align-items-center gap-1">
                                        <span><i class="bi bi-floppy"></i></span>
                                        <span>{{translate('Update')}}</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End Main Content -->
@endsection


@push('script')
    <script>
        $(document).ready(function () {
            $(".upload-file__input.banner").each(function () {
                const input = this;
                const oldImage = $(input).data("old");
                const img = $(input)
                    .siblings(".upload-file__img")
                    .find("img");

                if (oldImage) {
                    img.attr("src", oldImage).removeAttr("hidden");
                    $(input)
                        .siblings(".upload-file__img")
                        .find(".temp-img-box")
                        .remove();
                }
            });

            $(".upload-file__input.banner").on("change", function (event) {
                const input = event.target;
                const file = input.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = $(input)
                            .siblings(".upload-file__img")
                            .find("img");

                        img.attr("src", e.target.result).removeAttr("hidden");
                        $(input)
                            .siblings(".upload-file__img")
                            .find(".temp-img-box")
                            .remove();
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>

    <script>
        const packagePrices = @json($packages->pluck('price', 'id'));
    </script>

    <script>
        const currentPackageId = "{{ $paid_banner->package_id ?? '' }}";
        const packageExpirationDate = "{{ $package_expiration_date ? \Carbon\Carbon::parse($package_expiration_date)->format('Y-m-d H:i') : '' }}";
        const packageIsExpired = "{{ \Carbon\Carbon::parse($package_expiration_date)->isPast() ? '1' : '0' }}";
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const buttons = document.querySelectorAll('.package-btn');

            // Auto-select the current package on load
            if (currentPackageId) {
                const card = document.querySelector(`.package-btn[data-id="${currentPackageId}"]`)?.closest('.pricing-card');
                if (card) {
                    card.classList.add('active');

                    const icon = document.createElement('i');
                    icon.className = 'bi bi-check-circle-fill text-success position-absolute top-0 end-0 m-2 check-icon fs-4';
                    card.appendChild(icon);

                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'package_id';
                    hiddenInput.id = 'appear-on-first-input';
                    hiddenInput.value = currentPackageId;
                    card.appendChild(hiddenInput);
                }
            }

            // Handle user click on packages
            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const selectedId = this.dataset.id;

                    // If current package is still active, block selecting a new one
                    if (currentPackageId && packageIsExpired === '0' && selectedId !== currentPackageId) {
                        toastr.error(
                            `{{ translate('You must wait until your current package expires to choose another one.') }}<br><small>Expires on: ${packageExpirationDate}</small>`,
                            '{{ translate('Package Change Restricted') }}'
                        );
                        return;
                    }

                    // Remove .active and related icons/inputs
                    document.querySelectorAll('.pricing-card').forEach(card => card.classList.remove('active'));
                    document.querySelectorAll('.check-icon').forEach(icon => icon.remove());
                    document.querySelectorAll('#appear-on-first-input').forEach(input => input.remove());

                    // Add .active to selected card
                    const card = this.closest('.pricing-card');
                    card.classList.add('active');

                    const icon = document.createElement('i');
                    icon.className = 'bi bi-check-circle-fill text-success position-absolute top-0 end-0 m-2 check-icon fs-4';
                    card.appendChild(icon);

                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'package_id';
                    hiddenInput.id = 'appear-on-first-input';
                    hiddenInput.value = selectedId;
                    card.appendChild(hiddenInput);
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            // When user clicks on item
            $('.dropdown-menu .dropdown-item').on('click', function (e) {
                e.preventDefault();

                let adTitle = $(this).find('h5').text().trim();
                let adId    = $(this).data('id');

                $('#selectedCategoryText').text(adTitle);
                $('#selected_ad_id').val(adId);
            });

            // --- Auto-select if banner_url exists ---
            let bannerUrl = @json($paid_banner->banner_url);

            if (bannerUrl) {
                $('.dropdown-menu .dropdown-item').each(function () {
                    let slug = $(this).data('slug');

                    if (bannerUrl.includes(slug)) {
                        let adTitle = $(this).find('h5').text().trim();
                        let adId    = $(this).data('id');

                        $('#selectedCategoryText').text(adTitle);
                        $('#selected_ad_id').val(adId);

                        return false; // stop loop after finding match
                    }
                });
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#redirect_to_ads').on('change', function () {
                if ($(this).is(':checked')) {
                    $('#user_ads_box').removeClass('d-none');
                } else {
                    $('#user_ads_box').addClass('d-none');
                }
            });
        });
    </script>

@endpush
