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

        /* جعل الحاويات المباشرة مرجعية لفتح القائمة المنسدلة داخلها */
        #brand-box, #model-box {
            position: relative !important;
        }

        /* تثبيت أبعاد الحاوية ومنع التمدد الأفقي التلقائي */
        .select2-container {
            width: 100% !important;
            max-width: 100% !important;
        }

        /* تحسينات الاستقرار والشكل الجمالي المريح للموبايل */
        @media screen and (max-width: 575px) {
            /* إلغاء صراع حساب الارتفاع 100vh لمنع اهتزاز الشاشة */
            .main-content {
                min-height: auto !important;
                height: auto !important;
                overflow-x: hidden !important;
            }

            /* تكبير عناوين الخانات (Labels) لتكون واضحة ومريحة للعين */
            .form-group label {
                font-size: 16px !important;
                font-weight: 600 !important;
                margin-bottom: 8px !important;
                display: block;
                color: #333 !important;
            }

            /* تكبير ارتفاع الخانات العادية والنص الداخلي */
            .form-control,
            input[type="text"],
            select {
                font-size: 16px !important;
                height: 48px !important;
                padding: 0.65rem 1rem !important;
                border-radius: 8px !important;
                box-sizing: border-box !important;
            }

            /* تكبير ارتفاع وخانات Select2 للبراند والموديل وتوسيط النصوص والأسهم */
            .select2-container--default .select2-selection--single {
                height: 48px !important;
                padding: 0.65rem 0.5rem !important;
                border-radius: 8px !important;
                border: 1px solid #ced4da !important;
                box-sizing: border-box !important;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                font-size: 16px !important;
                line-height: 26px !important;
                color: #495057 !important;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 46px !important;
                right: 8px !important;
            }

            /* تكبير الخط وقفل أبعاد القائمة المنسدلة المفتوحة للبراند والموديل */
            .select2-search input,
            .select2-search__field,
            .select2-dropdown,
            .select2-results__option {
                font-size: 16px !important;
                box-sizing: border-box !important;
            }

            .select2-results__option {
                padding: 10px 12px !important;
            }

            .select2-dropdown {
                max-width: 100% !important;
                width: 100% !important;
                box-sizing: border-box !important;
                overflow-x: hidden !important;
            }

            .select2-results,
            .select2-results__options {
                max-width: 100% !important;
                overflow-x: hidden !important;
            }

            /* إزالة الإطار الداخلي المزدوج وتعديل الهوامش للكرت */
            .mobile-no-border {
                border: none !important;
                padding: 0 !important;
            }

            .card-body-mobile-padding {
                padding: 1.25rem 1rem !important;
            }

            /* مسافات عمودية متناسقة بين الخانات */
            .mobile-form-spacing {
                margin-bottom: 1.35rem !important;
            }

            .mobile-btn-spacing {
                margin-top: 1.5rem !important;
            }
        }

        /* تحسينات وضع التدوير العرضي للموبايل (Landscape) */
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
                                            <div class="mobile-no-border border p-3 rounded custom-gray-border-color">
                                                <div class="row g-3">
                                                    <!-- 1. Title -->
                                                    <div class="col-12 mobile-form-spacing">
                                                        <div class="form-group mb-0">
                                                            <label for="title">{{translate('title')}}</label>
                                                            <input type="text" id="title" class="form-control" value="{{ old('title') }}"
                                                                name="title" placeholder="{{translate('title')}}" required>
                                                        </div>
                                                    </div>

                                                    <!-- 2. Category -->
                                                    <div class="col-12 col-sm-6 col-md-4 mobile-form-spacing">
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
                                                    <div id="brand-box" class="col-12 col-sm-6 col-md-4 hide-element mobile-form-spacing">
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
                                                    <div id="model-box" class="col-12 col-sm-6 col-md-4 hide-element mobile-form-spacing">
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
                                            <div class="d-flex justify-content-end gap-3 mt-2 mobile-btn-spacing">
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
            const $titleInput = $('#title');

            // حل مشكلة زر "التالي": تحديث حالة التحقق للعنوان فور الكتابة أو المغادرة
            $titleInput.on('input change blur', function () {
                if (this.checkValidity) {
                    this.checkValidity();
                }
            });

            // Initialize Select2 مع ربط المنسدلة بالحاوية المباشرة لمنع الاهتزاز
            $brandSelect.select2({
                placeholder: "{{ translate('choose_brand') }}",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#brand-box')
            });

            $modelSelect.select2({
                placeholder: "{{ translate('choose_model') }}",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#model-box')
            });

            // Store all brand and model options
            const allBrandOptions = $('#brand option').clone();
            const allModelOptions = $('#model option').clone();

            // Create the "Other" options once with value="other"
            const otherBrandOption = '<option value="other">{{ translate("other_brand") }}</option>';
            const otherModelOption = '<option value="other">{{ translate("other_model") }}</option>';

            addPersistentOptions();

            function addPersistentOptions() {
                if ($brandSelect.find('option[value="other"]').length === 0) {
                    $brandSelect.append(otherBrandOption);
                }
                if ($modelSelect.find('option[value="other"]').length === 0) {
                    $modelSelect.append(otherModelOption);
                }
            }

            function filterBrands() {
                const selectedCategoryId = $categorySelect.val();
                $brandSelect.empty().append('<option value=""> -- {{ translate("choose_brand") }} -- </option>');

                allBrandOptions.each(function () {
                    const brandCategories = $(this).data('brand-categories')?.toString().split(',').map(s => s.trim()) || [];
                    if (
                        $(this).val() === "" ||
                        $(this).val() === "other" ||
                        brandCategories.length === 0 ||
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

                $modelSelect.find('option').not('[value=""]').remove();

                allModelOptions.each(function () {
                    const brandId = $(this).data('brand-id');
                    const modelCategories = $(this).data('model-categories')?.toString().split(',').map(s => s.trim()) || [];

                    if ($(this).val() === "") {
                        $modelSelect.append($(this).clone());
                    } else if (
                        (selectedBrandId && brandId == selectedBrandId) &&
                        (modelCategories.length === 0 || modelCategories.includes(selectedCategoryId))
                    ) {
                        $modelSelect.append($(this).clone());
                    }
                });

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
                    $modelSelect.val(null).trigger('change');
                    $modelSelect.prop('disabled', true);
                    $('#model-box').addClass('hide-element');
                } else {
                    filterModels();
                    $modelSelect.prop('disabled', false);
                    $('#model-box').removeClass('hide-element');
                }

                addPersistentOptions();
            });

            // Category change event
            $categorySelect.on('change', function () {
                var selectedOption = $(this).find('option:selected');

                $brandSelect.val(null).trigger('change');
                $modelSelect.val(null).trigger('change');
                $modelSelect.prop('disabled', true);
                $('#model-box').addClass('hide-element');

                if(selectedOption.attr('data-is-vehicle') == 'vehicles') {
                    $('#brand-box').removeClass('hide-element');
                } else {
                    $('#brand-box').addClass('hide-element');
                }

                filterBrands();
                filterModels();
                addPersistentOptions();
            });

            // إظهار الخانات تلقائياً إذا كانت الفئة مختارة مسبقاً
            if ($categorySelect.val()) {
                var selectedOption = $categorySelect.find('option:selected');
                if (selectedOption.attr('data-is-vehicle') == 'vehicles') {
                    $('#brand-box').removeClass('hide-element');
                    if ($brandSelect.val()) {
                        $('#model-box').removeClass('hide-element');
                        $modelSelect.prop('disabled', false);
                    }
                }
            }
        });
    </script>
@endpush
