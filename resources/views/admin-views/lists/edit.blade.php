@extends('layouts.back-end.app')
@section('title', translate('list_item_Edit').' - '.translate($list_value->list->name))

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
            {{translate('list_Setup')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <form action="{{route('admin.list.update', $list_value['id'])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="attribute_id" value="{{$list_value['list']['id']}}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="attribute_id" class="title-color">{{ translate('edit_list_attribute')}}<span class="text-danger">*</span></label>
                                    <select class="form-control" id="attribute_id" disabled>
                                        @foreach($lists as $list_item)
                                            <option {{ $list_item['name'] == $list_value['list']['name'] ? 'selected' : '' }} value="{{$list_item->id}}">{{translate($list_item->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group lang_form" id="">
                                    <label for="value" class="title-color">{{ translate('List Item')}}<span class="text-danger">*</span></label>
                                    <input type="text" name="value" class="form-control" id="value" value="{{$list_value['value']}}" placeholder="{{translate('ex')}} : {{translate('diesel')}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group w-100">
                                    <label class="title-color" for="priority">{{translate('priority')}}
                                        <span>
                                            <i class="tio-info-outined" title="{{translate('the_lowest_number_will_get_the_highest_priority')}}"></i>
                                        </span>
                                    </label>
                                    <select class="form-control" name="priority" id="" required>
                                        <option disabled selected>{{translate('set_Priority')}}</option>
                                        @for ($i = 0; $i <= 20; $i++)
                                            <option {{ $list_value['priority'] == $i ? 'selected' : '' }}  value="{{$i}}" >{{$i}}</option>
                                        @endfor
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
    <script src="{{asset('public/assets/back-end')}}/js/select2.min.js"></script>
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
    </script>
@endpush
