<style>
    .video-pricing-card {
        background: linear-gradient(135deg, #1e3c72, #2758acff);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        color: white;
    }

    .video-pricing-card h2 {
        font-size: 38px;
    }
    
    .video-pricing-card h5 {
        font-size: 16px;
    }

    .pricing-card-box {
        max-width: 210px;
    }

    .video-pricing-card.active {
        box-shadow: 0px 0px 5px #00000075;
        transform: scale(1.1);
        transition: .2s;
    }

    .video-pricing-card .check-icon {
        color: white !important;
    }
</style>

<div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
    <div class="mb-4" >
        <h2>{{ translate('media_information') }}</h2>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 col-sm-10 col-12">
            <div class="card p-3 bg-light dashed-border" style="border-radius: 10px;">
                <h6 class="mb-2" >
                    <span><i class="bi bi-image-fill mx-1"></i></span>
                    <span class="fw-medium" >{{ translate('Allowed Image Types') }}</span> : 
                    <span>{{translate('jpg, jpeg, png, webp, avif')}}</span>
                </h6>
                <h6 class="mb-2" >
                    <span><i class="bi bi-hdd-rack-fill mx-1"></i></span>
                    <span class="fw-medium" >{{ translate('maximum_size') }}</span> : 
                    <span>{{$ad_images_size}} {{translate('Mb')}} .</span>
                </h6>
                <h6>
                    <span><i class="bi bi-images mx-1"></i></span>
                    <span class="fw-medium" >{{ translate('maximum_ad_images') }}</span> : 
                    <span>{{$maximum_ad_images_number}} {{translate('images')}} .</span>
                </h6>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group mb-4">
                <label>{{translate('ad_thumbnail')}}</label>
                <div class="d-flex flex-column gap-3">
                    <div class="upload-file" style="width: min-content;">
                        <input type="file" class="upload-file__input" name="image" aria-required="true" accept="image/*" onchange="validateThumbnailImage(this)">
                        <div class="upload-file__img">
                            <div class="temp-img-box">
                                <div class="d-flex align-items-center flex-column gap-2">
                                    <i class="bi bi-upload fs-30"></i>
                                    <div class="fs-12 text-muted">{{translate('ad_image')}}</div>
                                </div>
                            </div>
                            <img src="#" class="dark-support img-fit-contain border" alt="" hidden="">
                        </div>
                    </div>
                    {{--<div class="text-muted">{{translate('Image_ratio_should_be')}} 1:1</div>--}}
                </div>
            </div>

            <div class="form-group mb-4">
                <label >{{ translate('ad_images') }}</label>
                <div class="d-flex gap-3 flex-wrap mb-3" id="additional_Image_Section">
                    <div class="upload-file position-relative" style="width: min-content;">
                        <input 
                            type="file" 
                            class="upload-file__input"  
                            onchange="addMoreImage(this, '#additional_Image_Section')"
                            name="images[]" 
                            aria-required="true"
                            multiple
                            accept="image/*">
                        <div class="upload-file__img">
                            <div class="temp-img-box">
                                <div class="d-flex align-items-center flex-column gap-2">
                                    <i class="bi bi-upload fs-30"></i>
                                    <div class="fs-12 text-muted">{{ translate('ad_images') }}</div>
                                </div>
                            </div>
                            <img src="#" class="dark-support img-fit-contain border" alt="" hidden="">
                        </div>
                    </div>
                </div>
                {{--<div class="text-muted">{{ translate('Image_ratio_should_be') }} 1:1</div>--}}
            </div>

            @if(\App\Model\SponsoredAdType::where('name', 'promotional_video')->value('status') == 1)
                <div style="width:100%;height: 1px;border-bottom: 1px solid #cccccc85;margin: 35px 0 28px;" ></div>

                <div class="mt-4">
                    <div>
                        <div class="mb-4" >
                            <h2 class="mb-1" >{{ translate('promotional_video') }}</h2>
                            <h5 class="fw-normal urgent-sale-text mb-2">{{translate('to_attract_more_customers_and_increase_your_sales_you_can_add_a_promotional_video_to_your_ad')}}</h5>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card p-3 bg-light dashed-border" style="border-radius: 10px;">
                                    <h6 class="mb-2" >
                                        <span><i class="bi bi-clock-fill mx-1"></i></span>
                                        <span class="fw-medium" >{{ translate('maximum_duration') }}</span> : 
                                        <span>{{ $maximum_video_duration }} {{translate('seconds')}}.</span>
                                    </h6>
                                    <h6>
                                        <span><i class="bi bi-hdd-rack-fill mx-1"></i></span>
                                        <span class="fw-medium" >{{ translate('maximum_size') }}</span> : 
                                        <span>{{ $maximum_video_size }} {{translate('Mb')}}.</span>
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden file input -->
                        <input type="file" id="videoFile" name="video" accept="video/*" style="display: none;">

                        <div class="card"></div>

                        <div class="d-flex align-items-center gap-2" >
                            <!-- Clickable upload card -->
                            <div id="videoUploadCard"
                                class="d-flex flex-column align-items-center justify-content-center"
                                style="
                                    width: 140px;
                                    height: 140px;
                                    min-width: 140px;
                                    min-height: 140px;
                                    border: 1px dashed #c3c3c3ff;
                                    border-radius: 10px;
                                    cursor: pointer;
                                ">
                                <i class="bi bi-camera-video gray-icon-color" style="font-size: 2.5rem;"></i>
                                <span class="mt-2 text-center gray-icon-color">{{ translate('Click to upload') }}</span>
                                <div id="videoBtnContainer" class="mt-1 d-none gap-2">
                                    <small id="showVideoBtn" data-bs-toggle="modal" data-bs-target="#videoPreviewModal" class="text-success" style="cursor: pointer; text-decoration: underline;">{{translate('Show video')}}</small>
                                    <small id="deleteVideoBtn" class="text-danger" style="cursor: pointer; text-decoration: underline;">{{translate('delete')}}</small>
                                </div>
                            </div>
                            <div class="mt-3 w-100" id="globalVideoProgress" ></div>
                        </div>
                    </div>
                </div>

                <!-- Video Preview Modal -->
                <div class="modal fade" id="videoPreviewModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                        <div class="modal-body p-2 text-center">
                            <video id="modalVideo" controls style="width:100%; height:auto; border-radius:8px;"></video>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 mb-3">  
                    <div class="row">  
                        @foreach($promotional_video_packages as $package)  
                            <div class="col-md-3 d-flex pricing-card-box position-relative mb-4">  
                                <div class="video-pricing-card text-center text-white d-flex flex-column justify-content-center align-items-center w-100 px-2 pt-3 pb-4 rounded-4 position-relative">  
                                    
                                    <!-- package name (needed for JS toastr message) -->
                                    <h5 class="package-name d-none">{{ $package->name ?? 'Package' }}</h5>  

                                    <h2 class="fw-bold mb-2 text-white">€{{ number_format($package['price'], 2) }}</h2>  
                                    <h5 class="fw-light mb-3 text-white">{{ translate('for') }} {{ $package->duration_in_days }} {{ translate('Days') }}</h5>  

                                    <button class="btn btn-light video-package-btn text-primary package-btn rounded-pill mt-auto px-4" data-id="{{ $package->id }}" type="button">
                                        {{ translate('get_started') }}
                                    </button>  
                                </div>  
                            </div>
                        @endforeach
                    </div>  
                </div>
            @endif
        </div>
    </div>
</div>