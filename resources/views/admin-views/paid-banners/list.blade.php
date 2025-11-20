@extends('layouts.back-end.app')

@section('title', translate('paid_banners_List'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">

        <!-- Page Title -->
        <div class="mb-4">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/assets/back-end/img/paid-banner.png')}}" alt="">
                {{translate('paid_banners_list')}}
                <span class="badge badge-soft-dark radius-50">{{\App\Model\PaidBanner::count()}}</span>
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="px-3 py-4">
                <div class="row gy-2 align-items-center">
                    <div class="col-sm-8 col-md-6 col-lg-4">
                        <!-- Search -->
                        <form action="{{ url()->current() }}" method="GET">
                            <div class="input-group input-group-merge input-group-custom">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch_" type="search" name="search" class="form-control"
                                       placeholder="{{translate('search_by_username_or_price_or_duration')}}"
                                       aria-label="Search orders" value="{{ $search }}">
                                <button type="submit" class="btn btn--primary">{{translate('search')}}</button>
                            </div>
                        </form>
                        <!-- End Search -->
                    </div>
                    <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                        <div class="d-flex justify-content-sm-end">
                            <button type="button" class="btn btn-outline--primary" data-toggle="dropdown">
                                <i class="tio-download-to"></i>
                                {{translate('export')}}
                                <i class="tio-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a class="dropdown-item" href="{{route('admin.paid-banner.export',['search'=>request('search')])}}">
                                        <img width="14" src="{{asset('/assets/back-end/img/excel.png')}}" alt="">
                                        {{translate('excel')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table
                    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                    class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                    <thead class="thead-light thead-50 text-capitalize">
                    <tr>
                        <th>{{translate('SL')}}</th>
                        <th>{{translate('banner_image')}}</th>
                        <th>{{translate('banner_url')}}</th>
                        <th>{{translate('user')}}</th>
                        <th>{{translate('duration_in_days')}}</th>
                        <th>{{translate('expiration_date')}}</th>
                        <th>{{translate('price')}}</th>
                        <th>{{translate('date')}}</th>
                        <th class="text-center">{{translate('suspend')}} / {{translate('unsuspend')}}</th>
                        <th class="text-center">{{translate('action')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach($paid_banners as $key=>$paid_banner)
                            <tr>
                                <td>
                                    {{$paid_banners->firstItem()+$key}}
                                </td>
                                <td class="mx-5" >
                                    <a target="_blank" href="{{cloudfront("paid-banners/".$paid_banner['banner_image'])}}"
                                        class="title-color hover-c1 d-flex align-items-center gap-10">
                                        <img src="{{cloudfront("paid-banners/".$paid_banner['banner_image'])}}"
                                        class="rounded" alt="banner_image" width="100px" height="50px">
                                    </a>
                                </td>
                                <td>
                                    <a target="_blank" href="{{$paid_banner['banner_url'] ?? '#'}}">
                                        {{translate('visit_link')}}
                                    </a>
                                </td>
                                <td>
                                    <a target="_blank" href="{{ route('show-profile', [$paid_banner->user->id, $paid_banner->user->name]) }}?tap=ads">
                                        {{$paid_banner['user']['name'] }}
                                    </a>
                                </td>
                                <td>{{$paid_banner['duration_in_days'] }} {{ translate('days') }}</td>

                                <td>
                                    <div>{{$paid_banner->created_at->format('d-m-Y')}}</div>
                                    <div>{{ \Carbon\Carbon::parse($paid_banner->expiration_date)->diffForHumans() }}</div>
                                </td>

                                <td>€{{$paid_banner['price'] }}</td>
                                <td>
                                    <div>{{$paid_banner->created_at->format('d-m-Y')}}</div>
                                    <div>{{$paid_banner->created_at->diffForHumans()}}</div>
                                </td>
                                <td>
                                    <form action="{{route('admin.paid-banner.status-update')}}"
                                    method="post"
                                    id="paid_banner_status{{$paid_banner['id']}}_form"
                                    class="paid_banner_status_form">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$paid_banner['id']}}">
                                        <label class="switcher mx-auto">
                                            <input type="checkbox" class="switcher_input" id="paid_banner_status{{$paid_banner['id']}}" name="status" value="1"
                                            {{ $paid_banner['status'] == 1 ? 'checked':'' }}
                                            onclick="toogleStatusModal(event,'paid_banner_status{{$paid_banner['id']}}','paid-banner-block-on.png','paid-banner-block-off.png','{{translate('Want_to_restore')}} {{$paid_banner['title']}}','{{translate('Want_to_suspend')}} {{$paid_banner['title']}}',`<p>{{translate('if_enabled_this_paid_banner_will_be_unblocked_and_visible_again')}}</p>`,`<p>{{translate('if_disabled_this_paid_banner_will_be_blocked_and_not_visible')}}</p>`)">
                                            <span class="switcher_control"></span>
                                        </label>
                                    </form>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a title="{{translate('view')}}"
                                        class="btn btn-outline-info btn-sm square-btn"
                                        href="{{cloudfront("paid-banners/".$paid_banner['banner_image'])}}">
                                            <i class="tio-invisible"></i>
                                        </a>
                                        @if($paid_banner['id'] != '0')
                                            <a title="{{translate('delete')}}"
                                            class="btn btn-outline-danger btn-sm delete square-btn" href="javascript:"
                                            onclick="form_alert('paid-banner-{{$paid_banner['id']}}','{{translate('want_to_delete_this_paid_banner').'?'}}')">
                                                <i class="tio-delete"></i>
                                            </a>
                                        @endif
                                    </div>
                                    <form action="{{route('admin.paid-banner.delete',[$paid_banner['id']])}}" method="post" id="paid-banner-{{$paid_banner['id']}}">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <div class="table-responsive mt-4">
                <div class="px-4 d-flex justify-content-lg-end">
                    <!-- Pagination -->
                    {!! $paid_banners->links() !!}
                </div>
            </div>

            @if(count($paid_banners)==0)
                <div class="text-center p-4">
                    <img class="mb-3 w-160" src="{{asset('assets/back-end')}}/svg/illustrations/sorry.svg"
                         alt="Image Description">
                    <p class="mb-0">{{translate('no_data_to_show')}}</p>
                </div>
        @endif
        <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
@endsection

@push('script_2')
    <script>
        $('.paid_banner_status_form').on('submit', function(event){
            event.preventDefault();

            console.log('test');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function (data) {
                    toastr.success("{{translate('status_updated_successfully')}}");
                }
            });
        });
    </script>
@endpush
