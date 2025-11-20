@extends('layouts.back-end.app')
@section('title', translate('model_Add'))

@push('css_or_js')
    <link href="{{asset('assets/back-end')}}/css/select2.min.css" rel="stylesheet"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .no-arrow {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: none !important;
        }
    </style>

@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" src="{{asset('/assets/back-end/img/brand.png')}}" alt="">
            {{translate('model_Setup')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <form action="{{route('admin.model.add-new')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group lang_form">
                                    <label for="name" class="title-color">{{ translate('model_Name')}}<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" value="" placeholder="{{translate('ex')}} : {{translate('corolla')}}">
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
                                            <option data-brand-categories="{{ !empty($brand['categories']) ? implode(',', $brand['categories']) : '' }}" value="{{$brand['id']}}">{{$brand['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="title-color">{{ translate('Categories')}}<span class="text-danger">*</span> <span>({{translate('press_ctrl_for_multiple_selection')}})</span></label>
                                    <select class="form-control no-arrow" name="categories[]" id="categories" multiple>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 justify-content-end">
                            <button type="reset" id="reset" class="btn btn-secondary px-4">{{ translate('reset')}}</button>
                            <button type="submit" class="btn btn--primary px-4">{{ translate('submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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


        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: '{{translate('are_you_sure?')}}',
                text: "{{translate('you_will_not_be_able_to_revert_this')}}!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '{{ translate("cancel") }}',
                confirmButtonText: '{{translate('yes_delete_it')}}!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.model.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success('{{translate('model_deleted_successfully')}}');
                            location.reload();
                        }
                    });
                }
            })
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
