@extends('theme-views.layouts.adding-app')

@section('title', translate('add_new_ad').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <style>


        #brand-box, #model-box {
            visibility: hidden;
        }
        
        .card-custom-shadow {
            box-shadow: 1px 1px 4px #00000017, -1px 1px 4px #00000017;
        }

    </style>


@endpush

@section('content')
    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 mb-4">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Sidebar-->
                <div class="col-lg-10">
                    <div class="card h-lg-100 card-custom-shadow">
                        <div class="card-body p-4 pb-0">
                            <div class="">
                                <h1>{{translate('what_do_you_want_to_sell')}} ?</h1>
                            </div>

                            <div class="mt-4">
                                <form  action="{{route('ads-add')}}" method="POST">
                                    @csrf
                                    <div class="row gy-4">
                                        <div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
                                            <div class="row">
                                                <div class="col-sm-12 mb-2">
                                                    <div class="form-group">
                                                        <label for="title">{{translate('title')}}</label>
                                                        <input type="text" id="title" class="form-control" value="{{ old('title') }}" 
                                                        name="title" placeholder="{{translate('title')}}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="category">{{translate('category')}}</label>
                                                        <select class="form-control" name="category_id" id="category" required>
                                                            <option value=""> -- {{ translate('choose_category') }} --</option>
                                                            @foreach($categories as $category)
                                                                <option data-is-vehicle="{{$category->is_vehicle}}" {{ $category['id'] == old('category_id') ? 'selected' : ''}} value="{{ $category->id }}">{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="brand-box" class="col-sm-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="brand">{{ translate('brand') }}</label>
                                                        <select class="form-control" name="brand_id" id="brand">
                                                            <option value=""> -- {{ translate('choose_brand') }} -- </option>
                                                            @foreach($brands as $brand)
                                                                <option {{ $brand['id'] == old('brand_id') ? 'selected' : ''}} value="{{ $brand->id }}" >{{ $brand->name }}</option>
                                                            @endforeach
                                                            <option value="other" >{{ translate('other_brand') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="model-box" class="col-sm-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="model">{{ translate('model') }}</label>
                                                        <select class="form-control" name="model_id" id="model">
                                                            <option value=""> -- {{ translate('choose_model') }} -- </option>
                                                            @foreach($models as $model)
                                                                <option 
                                                                data-brand-id="{{ $model->brand_id }}"
                                                                data-category-id="{{ $model->category_id }}"
                                                                {{ $model['id'] == old('model_id') ? 'selected' : ''}}
                                                                value="{{ $model->id }}">{{ $model->name }}</option>
                                                            @endforeach
                                                            <option value="other" >{{ translate('other_model') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex justify-content-end gap-3">
                                                <button type="submit" class="btn btn-primary">{{translate('next')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End Main Content -->
@endsection

<script>

function addMoreImage(input, targetSection) {
    const files = input.files;
    if (!files || files.length === 0) return;

    const reader = new FileReader();
    const previewImg = input.closest('.upload-file').querySelector('img');
    const tempBox = input.closest('.upload-file').querySelector('.temp-img-box');

    reader.onload = function (e) {
        previewImg.src = e.target.result;
        previewImg.hidden = false;
        if (tempBox) tempBox.style.display = 'none';
    };

    reader.readAsDataURL(files[0]);

    // Check if this is the last .upload-file inside the target section
    const $fileInputs = document.querySelectorAll(`${targetSection} input[type='file']`);
    const isLastInput = input === $fileInputs[$fileInputs.length - 1];

    if (isLastInput) {
        const newInputIndex = $fileInputs.length;

        const newInputHTML = `
            <div class="upload-file">
                <input 
                    type="file" 
                    class="upload-file__input"  
                    onchange="addMoreImage(this, '${targetSection}')"
                    name="images[]" 
                    multiple 
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
            </div>
        `;

        // Append the new input to the target section
        const container = document.querySelector(targetSection);
        container.insertAdjacentHTML('beforeend', newInputHTML);
    }
}

</script>


<script>
    // $(document).ready(function() {
    //     // Wait for the select2 to open
    //     $('.select2-results__option--selectable').css('background-color', '#f0f8ff !important'); // light blue
    // });

    document.addEventListener('DOMContentLoaded', function () {
        const brandSelect = document.getElementById('brand');
        const modelSelect = document.getElementById('model');
        const allModelOptions = Array.from(modelSelect.options);

        brandSelect.addEventListener('change', function () {
            const selectedBrandId = this.value;
            modelSelect.innerHTML = '<option value=""> -- {{ translate("choose_model") }} -- </option>';

            allModelOptions.forEach(option => {
                const brandId = option.getAttribute('data-brand-id');
                if (!brandId || brandId === selectedBrandId) {
                    modelSelect.appendChild(option);
                }
            });
        });
    });



</script>








