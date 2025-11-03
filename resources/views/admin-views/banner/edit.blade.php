@extends('layouts.back-end.app')

@section('title', translate('banner'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h2 class="h1 mb-1 text-capitalize d-flex align-items-center gap-2">
                    <img width="20" src="{{env_asset('assets/back-end/img/banner.png')}}" alt="">
                    {{translate('banner_update_form')}}
                </h2>
            </div>
            <div>
                <a class="btn btn--primary text-white" href="{{ route('admin.banner.list') }}">
                    <i class="tio-chevron-left"></i> {{ translate('back') }}</a>
            </div>
        </div>
        <!-- End Page Title -->

        <!-- Content Row -->
        <div class="row" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.banner.update',[$banner['id']])}}" method="post" enctype="multipart/form-data"
                              class="banner_form">
                            @csrf
                            @method('put')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" id="id" name="id">
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="title-color text-capitalize">{{translate('banner_type')}}</label>
                                        <select class="js-example-responsive form-control w-100" name="banner_type" required id="banner_type_select">
                                            <option value="Main Banner" {{$banner['banner_type']=='Main Banner'?'selected':''}}>{{ translate('main_Banner')}}</option>
                                            <option value="Popup Banner" {{$banner['banner_type']=='Popup Banner'?'selected':''}}>{{ translate('popup_Banner')}}</option>
                                            <option value="Header Banner" {{$banner['banner_type']=='Header Banner'?'selected':''}}>{{ translate('header_Banner')}}</option>
                                            <option value="Sidebar Banner" {{$banner['banner_type']=='Sidebar Banner'?'selected':''}}>{{ translate('sidebar_Banner')}}</option>
                                            <option value="Top Side Banner" {{$banner['banner_type']=='Top Side Banner'?'selected':''}}>{{ translate('top_Side_Banner')}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="name" class="title-color text-capitalize">{{ translate('banner_URL')}}</label>
                                        <input type="url" name="url" class="form-control" id="url" required placeholder="{{ translate('enter_url') }}" value="{{$banner['url']}}">
                                    </div>

                                    <div class="form-group" id="resource-mobile" >
                                        <label for="for_mobile">{{\App\CPU\translate('onlymobile')}}</label>
                                        <select style="width: 100%"
                                                class="js-example-responsive form-control"
                                                name="for_mobile" required>
                                            <option value="2" {{$banner['for_mobile']=='2'?'selected':''}}>{{\App\CPU\translate('both')}}</option>
                                            <option value="1" {{$banner['for_mobile']=='1'?'selected':''}}>{{\App\CPU\translate('Just in mobile')}}</option>
                                            <option value="0" {{$banner['for_mobile']=='0'?'selected':''}}>{{\App\CPU\translate('Just in desktop')}}</option>
                                        </select>
                                    </div>

                                     <div class="form-group " id="resource-lang" >
                                        <label for="language_id" class="title-color text-capitalize">{{\App\CPU\translate('lang')}}</label>
                                        <select class="js-example-responsive form-control w-100"
                                                name="lang" >
                                                <option value="Both">Both
                                                @foreach(json_decode(\App\Model\BusinessSetting::where('type', 'language')->select('value')->first()->value, true) as $lang)
                                                    <option value="{{$lang['code']}}" {{ $lang['code'] == $banner['lang'] ? 'selected' : '' }}>{{$lang['code']}}
                                                @endforeach
                                        </select>
                                    </div>
                                    <label class="title-color" for="priority">{{translate('priority')}}</label>
                                        <select class="form-control" name="priority" id="" required>
                                            @for ($i = 0; $i <= 30; $i++)
                                            <option
                                            value="{{$i}}" {{$banner['priority']==$i?'selected':''}}>{{$i}}</option>
                                            @endfor
                                        </select>
                                    {{-- For Theme Fashion - New input Field - Start --}}
                                    @if(theme_root_path() == 'theme_fashion')
                                    <div class="form-group mt-4 input_field_for_main_banner {{$banner['banner_type'] !='Main Banner'?'d-none':''}}">
                                        <label for="button_text" class="title-color text-capitalize">{{ translate('Button_Text')}}</label>
                                        <input type="text" name="button_text" class="form-control" id="button_text" placeholder="{{ translate('Enter_button_text') }}" value="{{$banner['button_text']}}">
                                    </div>
                                    <div class="form-group mt-4 mb-0 input_field_for_main_banner {{$banner['banner_type'] !='Main Banner'?'d-none':''}}">
                                        <label for="background_color" class="title-color text-capitalize">{{ translate('background_color')}}</label>
                                        <input type="color" name="background_color" class="form-control form-control_color w-100" id="background_color" value="{{$banner['background_color']}}">
                                    </div>
                                    @endif
                                    {{-- For Theme Fashion - New input Field - End --}}

                                </div>
                                <div class="col-md-6 d-flex flex-column justify-content-center">
                                    <div>
                                        <center class="mx-auto">
                                            <div class="uploadDnD">
                                                <div class="form-group inputDnD input_image input_image_edit" style="background-image: url('{{cloudfront('banner')}}/{{$banner['photo']}}')" data-title="{{ Storage::disk()->exists('banner/'.$banner['photo']) ? '': 'Drag and drop file or Browse file'}}">
                                                    <input type="file" name="image" class="form-control-file text--primary font-weight-bold" onchange="readUrl(this)"  accept=".jpg, .png, .jpeg, .gif, .bmp, .webp |image/*">
                                                </div>
                                            </div>
                                        </center>
                                        <label for="name" class="title-color text-capitalize">
                                            <span class="input-label-secondary cursor-pointer" data-toggle="tooltip" data-placement="right" title="" data-original-title="{{translate('banner_image_ratio_is_not_same_for_all_sections_in_website').' '.translate('Please_review_the_ratio_before_upload')}}">
                                                <img width="16" src={{asset('public/assets/back-end/img/info-circle.svg')}} alt="" class="m-1">
                                            </span>
                                            {{ translate('banner_image')}}
                                        </label>
                                        <span class="text-info" id="theme_ratio">( {{translate('ratio')}} 4:1 )</span>
                                        <p>{{ translate('banner_Image_ratio_is_not_same_for_all_sections_in_website') }}. {{ translate('please_review_the_ratio_before_upload') }}</p>

                                         <!-- For Theme Fashion - New input Field - Start -->
                                         @if(theme_root_path() == 'theme_fashion')
                                         <div class="form-group mt-4 input_field_for_main_banner {{$banner['banner_type'] !='Main Banner'?'d-none':''}}">
                                             <label for="title" class="title-color text-capitalize">{{ translate('Title')}}</label>
                                             <input type="text" name="title" class="form-control" id="title" placeholder="{{ translate('Enter_banner_title') }}" value="{{$banner['title']}}">
                                         </div>
                                         <div class="form-group mb-0 input_field_for_main_banner {{$banner['banner_type'] !='Main Banner'?'d-none':''}}">
                                             <label for="sub_title" class="title-color text-capitalize">{{ translate('Sub_Title')}}</label>
                                             <input type="text" name="sub_title" class="form-control" id="sub_title" placeholder="{{ translate('Enter_banner_sub_title') }}" value="{{$banner['sub_title']}}">
                                         </div>
                                         @endif
                                         <!--  For Theme Fashion - New input Field - End -->

                                    </div>
                                </div>

                                <div class="col-md-12 d-flex justify-content-end gap-3">
                                    <button type="reset" class="btn btn-secondary px-4">{{ translate('reset')}}</button>
                                    <button type="submit" class="btn btn--primary px-4">{{ translate('update')}}</button>
                                </div>
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
        $(document).on('ready', function () {
            theme_wise_ration();
        });

        function theme_wise_ration(){
            let banner_type = $('#banner_type_select').val();
            let theme = '{{ theme_root_path() }}';
            let theme_ratio = {!! json_encode(THEME_RATIO) !!};
            let get_ratio= theme_ratio[theme][banner_type];

            $('#theme_ratio').text(get_ratio);
        }

        $('#banner_type_select').on('change',function(){
            theme_wise_ration();
        });

        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            // dir: "rtl",
            width: 'resolve'
        });

        function display_data(data) {

            $('#resource-product').hide()
            $('#resource-brand').hide()
            $('#resource-category').hide()
            $('#resource-shop').hide()

            if (data === 'product') {
                $('#resource-product').show()
            } else if (data === 'brand') {
                $('#resource-brand').show()
            } else if (data === 'category') {
                $('#resource-category').show()
            } else if (data === 'shop') {
                $('#resource-shop').show()
            }
        }
    </script>

    <script>
        function mbimagereadURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#mbImageviewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#mbimageFileUploader").change(function () {
            mbimagereadURL(this);
        });

        function readUrl(input) {
            if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = (e) => {
                let imgData = e.target.result;
                let imgName = input.files[0].name;
                input.setAttribute("data-title", "");
                let img = new Image();
                img.onload = function() {
                    let imgWidth = img.naturalWidth;
                    let imgHeight = img.naturalHeight;

                    if(imgWidth > 700){
                        imgWidth = 700;
                    }
                    $('.input_image').css({
                        "background-image": `url('${imgData}')`,
                        "width": "100%",
                        "height": "auto",
                        backgroundPosition: "center",
                        backgroundSize: "contain",
                        backgroundRepeat: "no-repeat",
                    });
                    $('.input_image').addClass('hide-before-content')
                };
                img.src = imgData;
            }
            reader.readAsDataURL(input.files[0]);
        }
        }
    </script>

    <!-- New Added JS - Start -->
    <script>
        $('#banner_type_select').on('change',function(){
            let input_value = $(this).val();

            if (input_value == "Main Banner") {
                $('.input_field_for_main_banner').removeClass('d-none');
            } else {
                $('.input_field_for_main_banner').addClass('d-none');
            }
        });
    </script>
    <!-- New Added JS - End -->

@endpush
