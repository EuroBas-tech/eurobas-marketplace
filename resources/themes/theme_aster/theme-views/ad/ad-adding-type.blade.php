@extends('theme-views.layouts.adding-app')

@section('title', translate('add_new_ad').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@push('css_or_js')
    <meta property="og:image" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <meta property="twitter:card" content="{{cloudfront('company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <style>
        .hide-element {
            visibility: hidden;
            height: 0;
            overflow: hidden;
        }

        .card-custom-shadow {
            box-shadow: 1px 1px 4px #00000017, -1px 1px 4px #00000017;
        }
    </style>

@endpush

@section('content')
    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 mb-4 vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Sidebar-->
                <div class="col-lg-10">
                    <div class="card h-lg-100 card-custom-shadow">
                        <div class="card-body p-4 pb-0">
                            <div class="">
                                <h1>{{translate('what_do_you_want_to_sell')}} {{app()->getLocale() == 'ae' ? ' ؟' : ' ?'}}</h1>
                            </div>

                            <div class="my-4">
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
                                                            <option value=""> -- {{ translate('choose_category') }} -- </option>
                                                            @foreach($categories as $category)
                                                                <option
                                                                data-id="{{ $category['id'] }}"
                                                                data-is-vehicle="{{$category['category_type']}}"
                                                                {{ $category['id'] == old('category_id') ? 'selected' : ''}}
                                                                value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="brand-box" class="col-sm-4 mb-2 hide-element">
                                                    <div class="form-group">
                                                        <label for="brand">{{ translate('brand') }}</label>
                                                        <select class="form-control" name="brand_id" id="brand">
                                                            <option value=""> -- {{ translate('choose_brand') }} -- </option>
                                                            @foreach($brands as $brand)
                                                                <option data-brand-categories="{{ implode(', ', $brand['categories']) }}" {{ $brand['id'] == old('brand_id') ? 'selected' : ''}} value="{{ $brand['id'] }}" >{{ $brand['name'] }}</option>
                                                            @endforeach
                                                            <option value="other" >{{ translate('other_brand') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="model-box" class="col-sm-4 mb-3 mt-sm-0 mt-3 hide-element">
                                                    <div class="form-group">
                                                        <label for="model">{{ translate('model') }}</label>
                                                        <select class="form-control" name="model_id" id="model">
                                                            <option value=""> -- {{ translate('choose_model') }} -- </option>
                                                            @foreach($models as $model)
                                                                <option
                                                                data-model-categories="{{ implode(', ', $model['categories']) }}"
                                                                data-brand-id="{{ $model['brand_id'] }}"
                                                                data-category-id="{{ $model['category_id'] }}"
                                                                {{ $model['id'] == old('model_id') ? 'selected' : ''}}
                                                                value="{{ $model['id'] }}">{{ $model['name'] }}</option>
                                                            @endforeach
                                                            <option value="other" >{{ translate('other_model') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex justify-content-end gap-3">
                                                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                                                    <span>{{translate('next')}}</span>
                                                    <i class="bi {{ app()->getLocale() == 'ae' ? 'bi-arrow-left' : 'bi-arrow-right' }}"></i>
                                                </button>
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

@push('script')

    <script>
        const $brandSelect = $('#brand');
        const $modelSelect = $('#model');
        const $categorySelect = $('#category');

        // Initialize Select2
        $brandSelect.select2({
            placeholder: "{{ translate('choose_brand') }}",
            allowClear: true
        });

        $modelSelect.select2({
            placeholder: "{{ translate('choose_model') }}",
            allowClear: true
        });

        // Store all model options
        const allModelOptions = $('#model option').clone();

        // Create the "Other" options once with value="other"
        const otherBrandOption = '<option value="other">{{ translate("other_brand") }}</option>';
        const otherModelOption = '<option value="other">{{ translate("other_model") }}</option>';

        addPersistentOptions();

        function addPersistentOptions() {
            // Add "Other Brand" if it doesn't exist
            if ($brandSelect.find('option[value="other"]').length === 0) {
                $brandSelect.append(otherBrandOption);
            }
            
            // Add "Other Model" if it doesn't exist
            if ($modelSelect.find('option[value="other"]').length === 0) {
                $modelSelect.append(otherModelOption);
            }
        }

        function filterModels() {
            const selectedBrandId = $brandSelect.val();
            const selectedCategoryId = $categorySelect.val();

            // Clear models but keep the "Other Model" and default option
            $modelSelect.find('option').not('[value="other"], [value=""]').remove();
            
            // Filter and add matching models
            allModelOptions.each(function () {
                const brandId = $(this).data('brand-id');
                const categoryId = $(this).data('category-id');

                if (
                    (!brandId || brandId == selectedBrandId) &&
                    (!categoryId || categoryId == selectedCategoryId)
                ) {
                    $modelSelect.append($(this).clone());
                }
            });

            // Ensure "Other Model" is at the end and only appears once
            if ($modelSelect.find('option[value="other"]').length > 1) {
                $modelSelect.find('option[value="other"]').not(':last').remove();
            }
            
            $modelSelect.val(null).trigger('change');
            
            // Ensure "Other Brand" exists
            addPersistentOptions();
        }

        $brandSelect.on('change', function () {
            const selectedBrandId = $brandSelect.val();
            
            if (!selectedBrandId || selectedBrandId === '') {
                $modelSelect.val(null).trigger('change');
                $modelSelect.prop('disabled', true);
            } else {
                filterModels();
                $modelSelect.prop('disabled', false);
            }
            
            addPersistentOptions();
        });

        $categorySelect.on('change', function () {
            $brandSelect.val(null).trigger('change');
            $modelSelect.val(null).trigger('change');

            if($(this).find(':selected').data('is-vehicle') == 1) {
                $('#year-box').removeClass('d-none');
                $('#engine-type-box').removeClass('d-none');
                $('#mileage-box').removeClass('d-none');
                $('#transmission-type-box').removeClass('d-none');
                $('#body-type-box').removeClass('d-none');
                $('#bag-capacity-box').removeClass('d-none');
                $('#environmental-information-box').removeClass('d-none');
                $('#ad-options-box').removeClass('d-none');
                $('#additional-information-box').removeClass('d-none');
                $('#engine-type-box').removeClass('d-none');
                $('#engine-size-box').removeClass('d-none');
                $('#cylinders-box').removeClass('d-none');
                $('#power-box').removeClass('d-none');
            } else {
                $('#year-box').addClass('d-none');
                $('#engine-type-box').addClass('d-none');
                $('#mileage-box').addClass('d-none');
                $('#transmission-type-box').addClass('d-none');
                $('#body-type-box').addClass('d-none');
                $('#bag-capacity-box').addClass('d-none');
                $('#environmental-information-box').addClass('d-none');
                $('#ad-options-box').addClass('d-none');
                $('#additional-information-box').addClass('d-none');
                $('#engine-type-box').addClass('d-none');
                $('#engine-size-box').addClass('d-none');
                $('#cylinders-box').addClass('d-none');
                $('#power-box').addClass('d-none');
            }

            filterModels();
            addPersistentOptions();
        });
    </script>
@endpush










