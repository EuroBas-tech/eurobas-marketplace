@extends('layouts.back-end.app')
@section('title', translate('subscription_settings') . ' - Eurobas.com')

@push('css_or_js')
    <link href="{{asset('assets/back-end')}}/css/select2.min.css" rel="stylesheet"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .currency-absolute-span {
            top: 50%;
            transform: translateY(-50%);
            left: 4px;
        }
        .custom-promotional-card {
            border: 1px solid #0f407d;
        }
        .custom-promotional-card.disabled {
            border: 1px solid red !important;
        }

        .custom-font-size-13 {
            font-size: 13px !important;
        }

        @keyframes shake {
    0% { transform: translateX(0); }
    25% { transform: translateX(-1mm); }
    50% { transform: translateX(1mm); }
    75% { transform: translateX(-1mm); }
    100% { transform: translateX(0); }
}

.shake {
    animation: shake 0.2s ease-in-out;
}

    </style>

@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" src="{{asset('/assets/back-end/img/brand.png')}}" alt="">
            {{translate('subscriptions_settings')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <form action="{{route('admin.subscription.store-subscription-settings')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <h3 class="mb-4" >{{translate('enable_or_disable_promotion_types')}}</h3>

                        <div class="row mb-5">
                            <div class="col-md-3">
                                <div class="card custom-promotional-card text-center p-3" >
                                    <h5>{{translate('appear_on_first_results')}}</h5>
                                    <img class="d-block mx-auto mb-2" width="140px" src="{{ cloudfront('sponsor/appear-on-first-results.png') }}" alt="sponsor-image">
                                    <div class="d-flex align-items-center gap-1 justify-content-center mb-2" >
                                        <span>{{translate('current_status')}}</span>
                                        <span>:</span>
                                        @if($promotion_types->firstWhere('name', 'appearance_in_first_results')?->status == 1)
                                            <span class="text-success" >enabled</span>
                                        @else
                                            <span class="text-danger" >disabled</span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center gap-1 justify-content-center " >
                                        <span>{{translate('last_update')}}</span>
                                        <span>:</span>
                                        <span class="last-update-date custom-font-size-13" >{{$promotion_types->firstWhere('name', 'appearance_in_first_results')?->updated_at}}</span>
                                    </div>
                                    @if($promotion_types->firstWhere('name', 'appearance_in_first_results')?->status == 1)
                                        <button class="btn btn-danger btn-sm py-2 w-50 mx-auto mt-3" data-type="appearance_in_first_results" >{{translate('disable')}}</button>
                                    @else
                                        <button class="btn btn-success btn-sm py-2 w-50 mx-auto mt-3" data-type="appearance_in_first_results" >{{translate('enable')}}</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card custom-promotional-card text-center p-3">
                                    <h5>{{translate('urgent_sale_sticker')}}</h5>
                                    <img class="d-block mx-auto mb-2" width="140px" src="{{ cloudfront('sponsor/urgent-sale-sticker.png') }}" alt="sponsor-image">
                                    <div class="d-flex align-items-center gap-1 justify-content-center mb-2" >
                                        <span>{{translate('current_status')}}</span>
                                        <span>:</span>
                                        @if($promotion_types->firstWhere('name', 'urgent_sale_sticker')?->status == 1)
                                            <span class="text-success" >enabled</span>
                                        @else
                                            <span class="text-danger" >disabled</span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center gap-1 justify-content-center " >
                                        <span>{{translate('last_update')}}</span>
                                        <span>:</span>
                                        <span class="last-update-date custom-font-size-13" >{{$promotion_types->firstWhere('name', 'urgent_sale_sticker')?->updated_at}}</span>
                                    </div>
                                    @if($promotion_types->firstWhere('name', 'urgent_sale_sticker')?->status == 1)
                                        <button class="btn btn-danger btn-sm py-2 w-50 mx-auto mt-3" data-type="urgent_sale_sticker" >{{translate('disable')}}</button>
                                    @else
                                        <button class="btn btn-success btn-sm py-2 w-50 mx-auto mt-3" data-type="urgent_sale_sticker" >{{translate('enable')}}</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card custom-promotional-card text-center p-3">
                                    <h5>{{translate('promotional_video')}}</h5>
                                    <img class="d-block mx-auto mb-2" width="140px" src="{{ cloudfront('sponsor/promotional-video.png') }}" alt="sponsor-image">
                                    <div class="d-flex align-items-center gap-1 justify-content-center mb-2" >
                                        <span>{{translate('current_status')}}</span>
                                        <span>:</span>
                                        @if($promotion_types->firstWhere('name', 'promotional_video')?->status == 1)
                                            <span class="text-success" >enabled</span>
                                        @else
                                            <span class="text-danger" >disabled</span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center gap-1 justify-content-center " >
                                        <span>{{translate('last_update')}}</span>
                                        <span>:</span>
                                        <span class="last-update-date custom-font-size-13" >{{$promotion_types->firstWhere('name', 'promotional_video')?->updated_at}}</span>
                                    </div>
                                    @if($promotion_types->firstWhere('name', 'promotional_video')?->status == 1)
                                        <button class="btn btn-danger btn-sm py-2 w-50 mx-auto mt-3" data-type="promotional_video" >{{translate('disable')}}</button>
                                    @else
                                        <button class="btn btn-success btn-sm py-2 w-50 mx-auto mt-3" data-type="promotional_video" >{{translate('enable')}}</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card custom-promotional-card text-center p-3">
                                    <h5>{{translate('promotional_banner')}}</h5>
                                    <img class="d-block mx-auto mb-2" width="140px" src="{{ cloudfront('sponsor/promotional-banner.png') }}" alt="sponsor-image">
                                    <div class="d-flex align-items-center gap-1 justify-content-center mb-2" >
                                        <span>{{translate('current_status')}}</span>
                                        <span>:</span>
                                        @if($promotion_types->firstWhere('name', 'promotional_banner')?->status == 1)
                                            <span class="text-success" >enabled</span>
                                        @else
                                            <span class="text-danger" >disabled</span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center gap-1 justify-content-center " >
                                        <span>{{translate('last_update')}}</span>
                                        <span>:</span>
                                        <span class="last-update-date custom-font-size-13" >{{$promotion_types->firstWhere('name', 'promotional_banner')?->updated_at}}</span>
                                    </div>
                                    @if($promotion_types->firstWhere('name', 'promotional_banner')?->status == 1)
                                        <button class="btn btn-danger btn-sm py-2 w-50 mx-auto mt-3" data-type="promotional_banner" >{{translate('disable')}}</button>
                                    @else
                                        <button class="btn btn-success btn-sm py-2 w-50 mx-auto mt-3" data-type="promotional_banner" >{{translate('enable')}}</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <h3 class="mb-4" >{{translate('promotional_video_settings')}}</h3>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="maximum_video_duration" class="title-color">{{ translate('promotional_video_maximum_duration')}} ({{translate('in_seconds')}})<span class="text-danger">*</span></label>
                                    <div class="position-relative" >
                                        <input type="number" name="maximum_video_duration" class="form-control" value="{{$maximum_video_duration}}" placeholder="{{ translate('Ex: 120')}}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="maximum_video_size" class="title-color">{{ translate('promotional_video_maximum_size')}} ({{translate('in_mega_bits')}})<span class="text-danger">*</span></label>
                                    <div class="position-relative" >
                                        <input type="number" name="maximum_video_size" class="form-control" value="{{$maximum_video_size}}" placeholder="{{ translate('Ex: 25')}}">
                                    </div>
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
    <script src="{{asset('assets/back-end')}}/js/select2.min.js"></script>

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

    <script>
        $(document).ready(function () {
            function toggleAdsLimit() {
                var selected = $('#subscription_type').val();
                if (selected === 'marketplace subscription') {
                    $('#ads_number_limit').closest('.row').show();
                } else {
                    $('#ads_number_limit').closest('.row').hide();
                }
            }

            // Run on page load
            toggleAdsLimit();

            // Run on change
            $('#subscription_type').on('change', toggleAdsLimit);
        });
    </script>

    <script>
        $(document).on('click', '.custom-promotional-card button', function (e) {
            e.preventDefault();
            let $btn = $(this);
            let $card = $btn.closest('.custom-promotional-card');
            // find the current status text from the status span (safer than relying on classes)
            let $statusContainer = $card.find('.d-flex.align-items-center.gap-1.justify-content-center.mb-2');
            let currentStatus = $statusContainer.find('span').last().text().trim().toLowerCase();
            let newStatus = currentStatus === 'enabled' ? 'disabled' : 'enabled';
            let type = $btn.data('type');

            let actionText = newStatus === 'enabled' ? 'Enable this promotion type?' : 'Disable this promotion type?';

            Swal.fire({
                title: actionText,
                text: "Are you sure you want to " + (newStatus === 'enabled' ? 'enable' : 'disable') + " this?",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, ' + (newStatus === 'enabled' ? 'Enable' : 'Disable') + ' it!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('admin.subscription.subscription-type-status') }}",
                        method: 'POST',
                        data: {
                            type: type,
                            status: newStatus
                        },
                        dataType: 'json',
                        success: function (res) {
                            // update status span and button text/classes
                            let $statusSpan = $statusContainer.find('span').last(); // the status word span
                            if (newStatus === 'enabled') {
                                // show enabled
                                $statusSpan.removeClass('text-danger').addClass('text-success').text('enabled');
                                $btn.removeClass('btn-success').addClass('btn-danger').text('Disable');
                                $card.removeClass('disabled');
                            } else {
                                // show disabled
                                $statusSpan.removeClass('text-success').addClass('text-danger').text('disabled');
                                $btn.removeClass('btn-danger').addClass('btn-success').text('Enable');
                                $card.addClass('disabled');
                            }

                            // update last-update date from server response
                            let $dateSpan = $card.find('.last-update-date');
                            if (res.updated_at) {
                                $dateSpan.text(res.updated_at);
                            }

                            // === Apply shake animation to both status and date ===
                            $statusSpan.addClass('shake').one('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function () {
                                $(this).removeClass('shake');
                            });
                            $dateSpan.addClass('shake').one('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function () {
                                $(this).removeClass('shake');
                            });
                            // === end animation ===

                            // show success message with toastr
                            toastr.success('Status updated successfully');
                        },
                        error: function () {
                            toastr.error('Something went wrong. Please try again.');
                        }
                    });
                }
            });
        });
    </script>

@endpush
