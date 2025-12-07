@extends('theme-views.layouts.app')

@section('title', translate('All_Brands_Page').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@push('css_or_js')
    <style>
        .search-input {
            height: 35px;
            border-radius: 5px 0 0 5px !important;
        }
        .search-btn {
            border-radius: 0 5px 5px 0 !important;
            height: 35px;
        }

        /* RTL Fix (when dir="rtl") */
        [dir="rtl"] .search-input {
            border-radius: 0 5px 5px 0 !important;
        }

        [dir="rtl"] .search-btn {
            border-radius: 5px 0 0 5px !important;
        }

    </style>
@endpush

@section('content')
    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 mb-30">
        <div class="container">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row gy-2 align-items-center">
                        <div class="col-md-12">
                            <div class="d-flex align-items-start justify-content-between" >
                                <div>
                                    <h2 class="mb-1">{{ translate('all_brands') }}</h2>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb fs-12 mb-0">
                                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ translate('Home') }}</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">{{ translate('Brands') }}</li>
                                        </ol>
                                    </nav>
                                </div>
                                <div>
                                    <form class="d-flex align-items-center" action="{{ route('brands') }}" method="GET">
                                        <input name="search"
                                            value="{{ request('search') }}"
                                            class="form-control search-input"
                                            placeholder="{{ translate('Search_for_items') }}..."
                                            type="search">
                                        <button class="btn btn-primary search-btn">
                                            {{ translate('search') }}
                                        </button>
                                    </form>
                                </div>
                                <div class="d-none d-sm-block" ></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row g-4">
                                @foreach($brands as $brand)
                                    <div class="col-md-2 col-sm-4 col-6">
                                        <a href="{{url('ads/filter?brand_id='.$brand->id)}}">
                                            <div class="card text-center">
                                                <div style="height: 115px;" class="card-body d-flex align-items-center justify-content-center">
                                                    <img width="85px" src="{{ cloudfront('brand') }}/{{ $brand['image'] }}"
                                                    onerror="this.src='https://www.pngkey.com/png/detail/233-2332677_image-500580-placeholder-transparent.png'"
                                                    alt="Brand_image">
                                                </div>
                                                <div class="card-footer bg-transparent border-0">
                                                    <h4>{{$brand->name}}</h4>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer border-0">
            {{$brands->links() }}
        </div>
    </main>
    <!-- End Main Content -->
@endsection
