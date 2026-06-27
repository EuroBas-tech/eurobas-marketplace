<div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
    <div class="mb-2" >
        <h2>{{ translate('media_information') }}</h2>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>{{ translate('ad_images') }}</label>
                @include('theme-views.ad.partials._image-uploader', ['existingImages' => json_decode($ad->images) ?? []])
            </div>
        </div>
    </div>
</div>
