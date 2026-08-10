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
            display: none !important;
        }

        .card-custom-shadow {
            box-shadow: 1px 1px 4px #00000017, -1px 1px 4px #00000017;
        }

        .select2-container {
            width: 100% !important;
        }

        /* تحسين التجاوب والمساحة المتاحة للموبايل */
        @media screen and (max-width: 575px) {
            .card-body-mobile-padding {
                padding: 1rem 0.75rem !important;
            }

            /* تقليل الحواشي الداخلية لإعطاء مساحة أكبر للخانات في الموبايل */
            .inner-form-box {
                padding: 0.75rem !important;
                border: 1px solid #e5e5e5;
            }
        }

        /* تحسينات وضع التدوير العرضي */
        @media screen and (max-width: 991px) and (orientation: landscape) {
            .main-content {
                min-height: 100vh !important;
                height: auto !important;
            }

            .card {
                height: auto !important;
                overflow: visible !important;
            }

            .select2-dropdown {
                max-height: 200px !important;
                z-index: 1060 !important;
            }

            .select2-results__options {
                max-height: 140px !important;
                overflow-y: auto !important;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 mb-4 min-vh-100">
        <div class="container px-2 px-sm-3">
            <div class="row justify-content-center">
                <!-- Sidebar-->
                <div class="col-lg-10">
                    <div class="card h-100 card-custom-shadow">
                        <div class="card-body card-body-mobile-padding p-3 p-sm-4">
                            <div>
                                <h1 class="h3 mb-3">{{translate('what_do_you_want_to_sell')}} {{app()->getLocale() == 'ar' ? ' ؟' : ' ?'}}</h1>
                            </div>

                            <div class="my-3">
                                <form action="{{route('ads-add')}}" method="POST">
                                    @csrf
                                    <div class="row gy-3">
                                        <div class="col-12">
                                            <div class="inner-form-box rounded">
                                                <div class="row g-3">
                                                    <!-- 1. Title -->
                                                    <div class="col-12">
                                                        <div class="form-group mb-0">
                                                            <label for="title">{{translate('title')}}</label>
                                                            <input type="text" id="title" class="form-control" value="{{ old('title') }}"
                                                                name="title" placeholder="{{translate('title')}}" required>
                                                        </div>
                                                    </div>

                                                    <!-- 2. Category -->
                                                    <div class="col-12 col-sm-6 col-md-4">
                                                        <div class="form-group mb-0">
                                                            <label for="category">{{translate('category')}}</label>
                                                            <select class="form-control" name="category_id" id="category" required>
                                                                <option value="">{{ translate('choose_category') }}</option>
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

                                                    <!-- 3. Brand -->
                                                    <div id="brand-box" class="col-12 col-sm-6 col-md-4 hide-element">
                                                        <div class="form-group mb-0">
                                                            <label for="brand">{{ translate('brand') }}</label>
                                                            <select class="form-control" name="brand_id" id="brand">
                                                                <option value="">{{ translate('choose_brand') }}</option>
                                                                @foreach($brands as $brand)
                                                                    <option data-brand-categories="{{ implode(', ', $brand['categories']) }}" {{ $brand['id'] == old('brand_id') ? 'selected' : ''}} value="{{ $brand['id'] }}" >{{ $brand['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- 4. Model -->
                                                    <div id="model-box" class="col-12 col-sm-6 col-md-4 hide-element">
                                                        <div class="form-group mb-0">
                                                            <label for="model">{{ translate('model') }}</label>
                                                            <select class="form-control" name="model_id" id="model" disabled>
                                                                <option value="">{{ translate('choose_model') }}</option>
                                                                @foreach($models as $model)
                                                                    <option
                                                                        data-model-categories="{{ implode(', ', $model['categories']) }}"
                                                                        data-brand-id="{{ $model['brand_id'] }}"
                                                                        data-category-id="{{ $model['category_id'] }}"
                                                                        {{ $model['id'] == old('model_id') ? 'selected' : ''}}
                                                                        value="{{ $model['id'] }}">{{ $model['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex justify-content-end gap-3 mt-2">
                                                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                                                    <span>{{translate('next')}}</span>
                                                    <i class="bi {{ app()->getLocale() == 'ae' || app()->getLocale() == 'ar' ? 'bi-arrow-left' : 'bi-arrow-right' }}"></i>
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
        $(document).ready(function () {
            const $brandSelect = $('#brand');
            const $modelSelect = $('#model');
            const $categorySelect = $('#category');

            // Initialize Select2
            $brandSelect.select2({
                placeholder: "{{ translate('choose_brand') }}",
                allowClear: true,
                width: '100%'
            });

            $modelSelect.select2({
                placeholder: "{{ translate('choose_model') }}",
                allowClear: true,
                width: '100%'
            });

            // Store all brand and model options
            const allBrandOptions = $('#brand option').clone();
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

            // Filter brands based on selected category
            function filterBrands() {
                const selectedCategoryId = $categorySelect.val();
                $brandSelect.empty().append('<option value=""> -- {{ translate("choose_brand") }} -- </option>');

                allBrandOptions.each(function () {
                    const brandCategories = $(this).data('brand-categories')?.toString().split(',').map(s => s.trim()) || [];
                    if (
                        $(this).val() === "" ||                 // keep empty option
                        $(this).val() === "other" ||            // keep "other"
                        brandCategories.length === 0 ||         // if no restriction
                        brandCategories.includes(selectedCategoryId)
                    ) {
                        $brandSelect.append($(this).clone());
                    }
                });

                $brandSelect.val(null).trigger('change');
                addPersistentOptions();
            }

            function filterModels() {
                const selectedBrandId = $brandSelect.val();
                const selectedCategoryId = $categorySelect.val();

                // Clear models but keep the default option
                $modelSelect.find('option').not('[value=""]').remove();

                // Filter and add matching models
                allModelOptions.each(function () {
                    const brandId = $(this).data('brand-id');
                    const modelCategories = $(this).data('model-categories')?.toString().split(',').map(s => s.trim()) || [];

                    if ($(this).val() === "") {
                        // keep empty option
                        $modelSelect.append($(this).clone());
                    } else if (
                        (selectedBrandId && brandId == selectedBrandId) &&
                        (modelCategories.length === 0 || modelCategories.includes(selectedCategoryId))
                    ) {
                        // Model matches the selected brand AND (has no category restrictions OR includes selected category)
                        $modelSelect.append($(this).clone());
                    }
                });

                // Ensure "Other Model" is at the end
                if ($modelSelect.find('option[value="other"]').length > 1) {
                    $modelSelect.find('option[value="other"]').not(':last').remove();
                }

                $modelSelect.val(null).trigger('change');
                addPersistentOptions();
            }

            // Brand change event
            $brandSelect.on('change', function () {
                const selectedBrandId = $brandSelect.val();

                if (!selectedBrandId || selectedBrandId === '') {
                    // Hide and disable model when no brand is selected
                    $modelSelect.val(null).trigger('change');
                    $modelSelect.prop('disabled', true);
                    $('#model-box').addClass('hide-element');
                } else {
                    // Show, enable model and filter options
                    filterModels();
                    $modelSelect.prop('disabled', false);
                    $('#model-box').removeClass('hide-element');
                }

                addPersistentOptions();
            });

            // Category change event
            $categorySelect.on('change', function () {
                var selectedOption = $(this).find('option:selected');

                // Reset brand and model
                $brandSelect.val(null).trigger('change');
                $modelSelect.val(null).trigger('change');
                $modelSelect.prop('disabled', true);
                $('#model-box').addClass('hide-element');

                // Show brand box based on category type
                if(selectedOption.attr('data-is-vehicle') == 'vehicles') {
                    $('#brand-box').removeClass('hide-element');
                } else {
                    $('#brand-box').addClass('hide-element');
                }

                filterBrands();
                filterModels();
                addPersistentOptions();
            });
        });
    </script>
@endpush
