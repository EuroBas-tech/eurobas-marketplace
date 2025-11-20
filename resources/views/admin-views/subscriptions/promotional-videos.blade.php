@extends('layouts.back-end.app')

@section('title', translate('promotional_videos_List'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        video {
            max-height: 500px !important;
        }
    </style>

@endpush

@section('content')
    <div class="content container-fluid">

        <!-- Page Title -->
        <div class="mb-4">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/assets/back-end/img/video.png')}}" alt="">
                {{ translate('videos_list') }}
                <span class="badge badge-soft-dark radius-50">{{$promotional_videos->count()}}</span>
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Card -->
        <div class="card">
            <!-- Table -->

            <div class="col-sm-8 col-md-6 col-lg-4 p-3">
                <!-- Search -->
                <form action="{{ url()->current() }}" method="GET">
                    <div class="input-group input-group-merge input-group-custom">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tio-search"></i>
                            </div>
                        </div>
                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                            placeholder="{{translate('search_by_Name_or_Email_or_Phone')}}"
                            aria-label="Search orders" value="{{ $search }}">
                        <button type="submit" class="btn btn--primary">{{translate('search')}}</button>
                    </div>
                </form>
                <!-- End Search -->
            </div>

            <div class="table-responsive datatable-custom">
                <table
                    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                    class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                    <thead class="thead-light thead-50 text-capitalize">
                    <tr>
                        <th>{{translate('SL')}}</th>
                        <th>{{translate('thumbnail')}}</th>
                        <th>{{translate('video')}}</th>
                        <th>{{translate('video_ad')}}</th>
                        <th>{{translate('published_at')}}</th>
                        <th>{{translate('duration')}}</th>
                        <th>{{translate('expiration_date')}}</th>
                        <th>{{translate('video_status')}}</th>
                        <th class="text-center">{{translate('suspend')}} / {{translate('unsuspend')}}</th>
                        <th class="text-center">{{translate('action')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach($promotional_videos as $key=>$video)
                            <tr>
                                <td>
                                    {{$promotional_videos->firstItem()+$key}}
                                </td>
                                <td>
                                    @if(!$video->is_video_deleted && !\Carbon\Carbon::parse($video->expiration_date)->isPast())
                                        <img src="https://image.mux.com/{{$video['playback_id']}}/thumbnail.jpg"
                                        class="rounded" alt="video_image" width="60" >
                                    @endif
                                </td>
                                <td class="mx-5" >
                                    @if(!$video->is_video_deleted && !\Carbon\Carbon::parse($video->expiration_date)->isPast())
                                        <button onclick="show_video({{$key+1}})" type="button" class="btn btn-success btn-sm" >
                                            {{translate('show')}}
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    <a class="text-info text-decoration-underline" href="{{route('ads-show', $video->ad->slug)}}">{{translate('visit')}}</a>
                                </td>
                                <td>
                                    <div>{{$video->created_at->format('d-m-Y')}}</div>
                                    <div>{{$video->created_at->diffForHumans()}}</div>
                                </td>
                                <td>{{ $video->duration_in_days }} {{translate('days')}}</td>
                                <td>
                                    <div>{{ \Carbon\Carbon::parse($video->expiration_date)->format('d-m-Y') }}</div>
                                    <div>{{ \Carbon\Carbon::parse($video->expiration_date)->diffForHumans() }}</div>
                                </td>
                                <td>
                                    @if(!\Carbon\Carbon::parse($video->expiration_date)->isPast() && !$video->is_video_deleted && !$video->is_video_suspended)
                                        <span class="badge bg-success text-white">{{translate('valid')}}</span>
                                    @elseif(\Carbon\Carbon::parse($video->expiration_date)->isPast() && !$video->is_video_deleted)
                                        <span class="badge bg-danger text-white">{{translate('expired')}}</span>
                                    @elseif(!\Carbon\Carbon::parse($video->expiration_date)->isPast() && !$video->is_video_deleted && $video->is_video_suspended)
                                        <span class="badge bg-danger text-white">{{translate('suspended')}}</span>
                                    @elseif(!\Carbon\Carbon::parse($video->expiration_date)->isPast() && $video->is_video_deleted)
                                        <span class="badge bg-danger text-white">{{translate('deleted')}}</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$video->is_video_deleted && !\Carbon\Carbon::parse($video->expiration_date)->isPast())
                                        <form action="{{route('admin.subscription.promotional-videos.status-update')}}" method="post" id="video_status{{$video['id']}}_form" class="video_status_form">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$video['id']}}">
                                            <label class="switcher mx-auto">
                                                <input type="checkbox" class="switcher_input" id="video_status{{$video['id']}}" name="status" value="1" {{ $video['is_video_suspended'] == 0 ? 'checked':'' }} onclick="toogleStatusModal(event,'video_status{{$video['id']}}','video-block-on.png','video-block-off.png','{{translate('Want_to_restore_video')}}','{{translate('Want_to_suspend_video')}}',`<p>{{translate('if_enabled_this_video_will_be_unblocked_and_visible_again')}}</p>`,`<p>{{translate('if_disabled_this_video_will_be_blocked_and_not_visible')}}</p>`)">
                                                <span class="switcher_control"></span>
                                            </label>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    @if(!$video->is_video_deleted && !\Carbon\Carbon::parse($video->expiration_date)->isPast())
                                        <div class="d-flex justify-content-center gap-2">
                                            @if($video['id'] != '0')
                                                <a title="{{translate('delete')}}"
                                                    class="btn btn-outline-danger btn-sm delete square-btn" href="javascript:"
                                                    onclick="form_alert('video-{{$video['id']}}','{{translate('want_to_delete_this_video').'?'}}')">
                                                    <i class="tio-delete"></i>
                                                </a>
                                            @endif
                                        </div>
                                        <form action="{{route('admin.subscription.promotional-videos.delete')}}" method="post" id="video-{{$video['id']}}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$video['id']}}">
                                        </form>
                                    @endif
                                </td>
                            </tr>

                            @if(!$video->is_video_deleted && !\Carbon\Carbon::parse($video->expiration_date)->isPast())
                                <div class="modal" id="show_video{{$key+1}}" role="dialog" tabindex="-1" >
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{translate('promotional_video')}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    <mux-player stream-type="on-demand" playback-id="{{$video->playback_id}}"
                                                        metadata-video-title="Uploaded Video"
                                                        accent-color="#0F407D"
                                                        style="width: 100%; height: 450px; object-fit: contain;"
                                                    ></mux-player>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <div class="table-responsive mt-4">
                <div class="px-4 d-flex justify-content-lg-end">
                    <!-- Pagination -->
                    {!! $promotional_videos->links() !!}
                </div>
            </div>

            @if(count($promotional_videos)==0)
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

    <script src="https://cdn.jsdelivr.net/npm/@mux/mux-player"></script>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const mux = document.querySelector('mux-player');
            mux.addEventListener('loadeddata', () => {
                const video = mux.shadowRoot.querySelector('video');
                if (video) video.style.maxHeight = '500px !important';
            });
        });
    </script>

    <script>
        $('.video_status_form').on('submit', function(event){
            event.preventDefault();

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
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            });
        });

        function show_video($id)
        {
            $('#show_video'+$id).show();
            $('#show_video'+$id).modal("show");
        }

        // Stop all videos when any modal is closed
        $(document).on('hidden.bs.modal', function () {
            $('mux-player').each(function () {
                this.pause();              // Pause the video
                this.currentTime = 0;      // Reset to beginning (optional)
            });
        });

    </script>
@endpush
