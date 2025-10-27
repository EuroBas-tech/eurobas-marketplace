@extends('layouts.back-end.app')
@section('title', translate('add_subscription_package'))

@push('css_or_js')
    <link href="{{asset('public/assets/back-end')}}/css/select2.min.css" rel="stylesheet"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" src="{{asset('/public/assets/back-end/img/brand.png')}}" alt="">
            {{translate('add_new_subscription_package')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <form action="{{route('admin.subscription.packages.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subscription_type" class="title-color">{{ translate('subscription_types')}}<span class="text-danger">*</span></label>
                                    <select name="subscription_type" id="subscription_type" class="form-control">
                                        @foreach($sponsor_types as  $type)
                                            <option data-type="{{$type->name}}" {{ old('subscription_type') == $type['id'] ? 'selected' : '' }} value="{{$type->id}}">{{translate($type->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price" class="title-color">{{ translate('price')}}<span class="text-danger">*</span></label>
                                    <input type="number" name="price" step="0.01" class="form-control" id="price" placeholder="{{ translate('Ex: 25')}}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="duration_in_days" class="title-color">{{ translate('subscription_duration')}}<span class="text-danger">*</span></label>
                                    <select name="duration_in_days" id="duration_in_days" class="form-control">
                                        <option {{ old('duration_in_days') == '1'   ? 'selected' : '' }} value="1">1 {{translate('day')}}</option>
                                        <option {{ old('duration_in_days') == '7'   ? 'selected' : '' }} value="7">7 {{translate('day')}}</option>
                                        <option {{ old('duration_in_days') == '15'  ? 'selected' : '' }} value="15">15 {{translate('days')}}</option>
                                        <option {{ old('duration_in_days') == '30'  ? 'selected' : '' }} value="30">30 {{translate('days')}}</option>
                                        <option {{ old('duration_in_days') == '60'  ? 'selected' : '' }} value="60">60 {{translate('days')}}</option>
                                        <option {{ old('duration_in_days') == '120' ? 'selected' : '' }} value="120">120 {{translate('days')}}</option>
                                        <option {{ old('duration_in_days') == '180' ? 'selected' : '' }} value="180">180 {{translate('days')}}</option>
                                        <option {{ old('duration_in_days') == '365' ? 'selected' : '' }} value="365">365 {{translate('days')}}</option>
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
    <script src="{{asset('public/assets/back-end')}}/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
    
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
                        url: "{{route('admin.brand.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success('{{translate('brand_deleted_successfully')}}');
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>

@endpush
