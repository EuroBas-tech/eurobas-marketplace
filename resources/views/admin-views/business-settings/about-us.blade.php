@extends('layouts.back-end.app')

@section('title', translate('about_us'))

@push('css_or_js')

<style>
    #cke_notifications_area_description {
        display: none !important;
    }
</style>

@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="mb-3">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img src="{{asset('/assets/back-end/img/Pages.png')}}" width="20" alt="">
            {{translate('pages')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Inlile Menu -->
    @include('admin-views.business-settings.pages-inline-menu')
    <!-- End Inlile Menu -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{translate('about_us')}}</h5>
                </div>

                <form action="{{route('admin.business-settings.about-update')}}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <textarea name="about_us" id="editor" cols="30" rows="20" class="form-control">{{$about_us->value}}</textarea>
                        </div>
                        <div class="form-group mb-2">
                            <input class="btn btn--primary btn-block" type="submit" name="btn" value="{{ translate('submit') }}">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- CKEditor --}}
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

    {{-- jQuery adapter (required for $("#editor").ckeditor()) --}}
    <script src="https://cdn.ckeditor.com/4.21.0/standard/adapters/jquery.js"></script>

    <script>
        $('#editor').ckeditor({
            contentsLangDirection : "{{ LaravelLocalization::getCurrentLocale() == 'ar' ? 'rtl' : 'ltr' }}",
        });
    </script>
@endpush