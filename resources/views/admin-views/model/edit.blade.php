@extends('layouts.back-end.app')

@section('title', translate('model_Edit'))

@push('css_or_js')
    <link href="{{asset('assets/back-end')}}/css/select2.min.css" rel="stylesheet"/>
    <link href="{{asset('assets/back-end/css/croppie.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h2 class="h1 mb-0 align-items-center d-flex gap-2">
            <img width="20" src="{{asset('/assets/back-end/img/model.png')}}" alt="">
            {{translate('model_Update')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <form action="{{route('admin.model.update',[$m['id']])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="title-color">{{ translate('model_Name')}}<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{$m['name']}}" placeholder="{{translate('ex')}} : {{translate('corolla')}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="brand" class="title-color">{{ translate('brand')}}</label>
                                    <select class="form-control" name="brand" id="brand">
                                        <option value="">-- {{ translate('choose_model_brand') }} --</option>
                                        @foreach($brands as $brand)
                                            <option data-brand-categories="{{ !empty($brand['categories']) ? implode(',', $brand['categories']) : '' }}" {{ $m['brand_id'] == $brand['id'] ? 'selected' : '' }}
                                            value="{{$brand['id']}}">
                                                {{$brand['name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group lang_form">
                                    <label for="name" class="title-color">{{ translate('Categories')}}<span class="text-danger">*</span> <span>({{translate('press_ctrl_for_multiple_selection')}})</span></label>
                                    <select class="form-control" name="categories[]" id="categories" multiple>
                                        @foreach($categories as $category)
                                            <option {{ in_array($category['id'], $modelCategoriesIds) ? 'selected' : '' }}
                                            value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <button type="reset" id="reset" class="btn btn-secondary px-4">{{ translate('reset')}}</button>
                            <button type="submit" class="btn btn--primary px-4">{{ translate('update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--modal-->
    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'model-image-modal','width'=>1000,'margin_left'=>'-53%'])
    <!--modal-->
</div>
@endsection

@push('script')
<script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
    <script src="{{asset('assets/back-end')}}/js/select2.min.js"></script>
    <script>
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload").change(function () {
            readURL(this);
        });

        const initialCategories = @json($initialCategories); // Must be an array like [1, 2, 3]

        $(document).ready(function () {
            $('#categories option').each(function () {
                const optionVal = $(this).val();
                if (initialCategories.includes(parseInt(optionVal))) {
                    $(this).show();
                } else {
                    $(this).hide().prop('selected', false);
                }
            });
        });

        $('#brand').on('change', function () {
            const selectedOption = $(this).find('option:selected');
            const brandCategoriesString = selectedOption.attr('data-brand-categories') || '';
            const allowedCategories = brandCategoriesString.split(',').filter(Boolean);

            $('#categories option').each(function () {
                const optionVal = $(this).val();
                if (allowedCategories.includes(optionVal)) {
                    $(this).show();
                } else {
                    $(this).hide().prop('selected', false);
                }
            });
        });

    </script>
@endpush
