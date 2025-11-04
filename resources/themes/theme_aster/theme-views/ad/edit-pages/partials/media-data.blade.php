<div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
    <div class="mb-2" >
        <h2>{{ translate('media_information') }}</h2>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label>{{translate('ad_thumbnail')}}</label>

                <div class="d-flex flex-column gap-3">
                    <div class="upload-file" style="width: min-content;">
                        <input
                            type="file"
                            class="upload-file__input thumbnail"
                            name="image"
                            accept="image/*"
                            aria-required="true"
                            data-old="{{cloudfront('ad/thumbnail/'.$ad->thumbnail)}}" {{-- this is key for JS to read the old image --}}
                        >

                        <div class="upload-file__img">
                            <div class="temp-img-box">
                                <div class="d-flex align-items-center flex-column gap-2">
                                    <i class="bi bi-upload fs-30"></i>
                                    <div class="fs-12 text-muted">{{ translate('ad_image') }}</div>
                                </div>
                            </div>
                            <img
                                src="#"
                                class="dark-support img-fit-contain border"
                                alt="ad Image"
                                hidden
                            >
                        </div>
                    </div>

                    {{--<div class="text-muted">{{ translate('Image_ratio_should_be') }} 1:1</div>--}}
                </div>
            </div>
            <div class="form-group">
                <label>{{ translate('ad_images') }}</label>
                <div class="d-flex gap-3 flex-wrap" id="additional_Image_Section">
                    @foreach(json_decode($ad->images) as $image)
                        <div class="upload-file position-relative">
                            <input type="hidden" name="old_images[]" value="{{$image}}">
                            <input
                                type="file"
                                class="upload-file__input ad-images"
                                name="images[]"
                                multiple
                                data-old="{{ cloudfront('ad/'.$image)}}"
                                aria-required="true"
                                accept="image/*">
                            <div class="upload-file__img">
                                <div class="temp-img-box">
                                    <div class="d-flex align-items-center flex-column gap-2">
                                        <i class="bi bi-upload fs-30"></i>
                                        <div class="fs-12 text-muted">{{translate('ad_images')}}</div>
                                    </div>
                                </div>
                                <img src="#" class="dark-support img-fit-contain border" alt="" hidden="">
                            </div>
                            <span style="position: absolute;top: 10px;right: 10px;"
                            class="btn btn-danger btn-sm rounded p-1 d-inline remove-image-btn">
                                <i class="bi bi-trash3-fill text-white"></i>
                            </span>
                        </div>
                    @endforeach
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
        </div>
    </div>
</div>
