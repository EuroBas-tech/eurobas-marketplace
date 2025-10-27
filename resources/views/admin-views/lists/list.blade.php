@extends('layouts.back-end.app')

@section('title', translate($list->name))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/model.png')}}" alt="">
                {{translate($list->name)}}
                <span class="badge badge-soft-dark radius-50 fz-14">{{ $list->values->count() }}</span>
            </h2>
        </div>
        <!-- End Page Title -->

        <div class="row mt-20">
            <div class="col-md-12">
                <div class="card">

                <!-- Data Table Top -->
                    <div class="px-3 py-3">
                        <div class="text-end">
                            <a href="{{route('admin.list.add-new', $list->name)}}" class="btn btn-outline--primary">
                                <i class="tio-add"></i>
                                {{translate('add_new')}}
                            </a>
                        </div>
                    </div>
                    <!-- End Data Table Top -->

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                                <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{ translate('SL')}}</th>
                                    <th>{{ translate('name')}}</th>
                                    <th>{{ translate('attribute')}}</th>
                                    <th class="text-center">
                                        {{ translate('action')}}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($list->values as $k=>$v)
                                        <tr>
                                            <td>{{$k + 1}}</td>
                                            <td>{{translate($v->value)}}</td>
                                            <td>{{translate($list->name)}}</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a class="btn btn-outline-info btn-sm square-btn" title="{{ translate('edit')}}"
                                                    href="{{route('admin.list.update',[$v['id']])}}">
                                                        <i class="tio-edit"></i>
                                                    </a>
                                                    <a class="btn btn-outline-danger btn-sm delete square-btn" title="{{ translate('delete')}}"
                                                    data-id="{{$v['id']}}">
                                                        <i class="tio-delete"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if(count($list->values)==0)
                        <div class="text-center p-4">
                            <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description">
                            <p class="mb-0">{{ translate('no_data_to_show')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).on('click', '.delete', function () {
            var id = $(this).data("id");
            console.log(id);
            Swal.fire({
                title: "{{ translate('are_you_sure_delete_this_list_value')}}?",
                text: "{{ translate('you_will_not_be_able_to_revert_this')}}!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ translate('yes_delete_it')}}!",
                cancelButtonText: "{{ translate('cancel')}}",
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.list.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success("{{ translate('list_value_deleted_successfully')}}");
                            location.reload();
                        }
                    });
                }
            })
        });

        $('.model_status_form').on('submit', function(event){
            event.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.model.status-update')}}",
                method: 'POST',
                data: $(this).serialize(),
                success: function (data) {
                    if (data.success == true) {
                        toastr.success("{{translate('status_updated_successfully')}}");
                    } else {
                        toastr.error('{{translate("status_updated_failed.")}} {{translate("Product_must_be_approved")}}');
                        location.reload();
                    }
                }
            });
        });
    </script>
@endpush
