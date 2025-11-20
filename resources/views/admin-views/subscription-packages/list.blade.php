@extends('layouts.back-end.app')

@section('title', translate('subscription_packages_List'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img width="20" src="{{asset('/assets/back-end/img/brand.png')}}" alt="">
                {{translate('subscription_packages_List')}}
                <span class="badge badge-soft-dark radius-50 fz-14">{{ $packages->count() }}</span>
            </h2>
        </div>
        <!-- End Page Title -->

        <div class="row mt-20">
            <div class="col-md-12">
                <div class="card">
                    <!-- Data Table Top -->
                    <div class="px-3 py-3">
                        <div class="row g-2 flex-grow-1">
                            <div class="col-12 d-flex justify-content-end gap-2">
                                <div>
                                    <button type="button" class="btn btn-outline--primary" data-toggle="dropdown">
                                        <i class="tio-download-to"></i>
                                        {{translate('export')}}
                                        <i class="tio-chevron-down"></i>
                                    </button>

                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.brand.export',['search'=>request('search')]) }}">
                                                <img width="14" src="{{asset('/assets/back-end/img/excel.png')}}" alt="">
                                                {{ translate('excel') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <a href="{{ route('admin.subscription.packages.add-new') }}" class="btn btn-outline--primary" >
                                        <i class="tio-add"></i>
                                        {{ translate('add_new_package') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Data Table Top -->

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                                <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{ translate('SL')}}</th>
                                    <th>{{ translate('package_type')}}</th>
                                    <th>{{ translate('price')}}</th>
                                    <th>{{ translate('duration')}}</th>
                                    <th class="text-center">{{translate('status')}}</th>
                                    <th class="text-center">{{ translate('action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($packages as $k=>$package)
                                        <tr>
                                            <td>{{ $k + 1 }}</td>
                                            <td>{{translate($package['type']['name'])}}</td>
                                            <td>{{ number_format($package['price'], 2) }}€</td>
                                            <td>{{$package['duration_in_days']}} {{ $package['duration_in_days'] == 1 ? translate('day') : translate('days')}}</td>
                                            <td>
                                                <form action="{{route('admin.subscription.packages.status-update')}}" method="POST" id="package_status{{$package['id']}}_form" class="package_status_form">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$package['id']}}">
                                                    <label class="switcher mx-auto">
                                                        <input type="checkbox" class="switcher_input" id="packege_status{{$package['id']}}" name="status" value="1" {{ $package['status'] == 1 ? 'checked':'' }} onclick="toogleStatusModal(event,'package_status{{$package['id']}}','package-status-on.png','package-status-off.png','{{translate('Want_to_Turn_ON')}} {{$package['name']}} {{translate('status')}}','{{translate('Want_to_Turn_OFF')}} {{$package['name']}} {{translate('status')}}',`<p>{{translate('if_enabled_this_package_will_be_available_on_the_website_and_customer_app')}}</p>`,`<p>{{translate('if_disabled_this_package_will_be_hidden_from_the_website_and_customer_app')}}</p>`)">
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </form>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end gap-2">
                                                    @if($package->type->name != 'promotional_video')
                                                        <a href="{{ route('admin.subscription.packages.add-remove-features', $package['id']) }}"
                                                        class="btn btn-outline-primary btn-sm square-btn"
                                                        title="{{translate('features')}}">
                                                            <i class="tio-star"></i>
                                                        </a>
                                                    @endif
                                                    <a class="btn btn-outline-info btn-sm square-btn" title="{{ translate('edit')}}"
                                                    href="{{route('admin.subscription.packages.edit',[$package['id']])}}">
                                                        <i class="tio-edit"></i>
                                                    </a>
                                                    <a class="btn btn-outline-danger btn-sm delete square-btn" title="{{ translate('delete')}}"
                                                    data-id="{{$package['id']}}">
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
                    @if(count($packages)==0)
                        <div class="text-center p-4">
                            <img class="mb-3 w-160" src="{{asset('assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description">
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
            Swal.fire({
                title: "{{ translate('are_you_sure_delete_this_package')}}?",
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
                        url: "{{route('admin.subscription.packages.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success("{{ translate('package_deleted_successfully')}}");
                            location.reload();
                        }
                    });
                }
            })
        });

        $('.package_status_form').on('submit', function(event){
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.subscription.packages.status-update')}}",
                method: 'POST',
                data: $(this).serialize(),
                success: function (data) {
                    if (data.success == true) {
                        toastr.success("{{translate('status_updated_successfully')}}");
                        location.reload();
                    }
                }
            });
        });
    </script>
@endpush
