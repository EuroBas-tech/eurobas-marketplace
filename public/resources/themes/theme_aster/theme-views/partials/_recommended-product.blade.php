<section class="py-3">
    <div class="container">
        <h2 class="mb-3">{{ translate('navigate_by_category') }}</h2>
        <div class="card mt-3">
            <div class="p-2 p-sm-3">
                <nav class="d-flex mb-4 justify-content-between" style="border-bottom: 1px #a2a2a236 solid;">
                    <div style="overflow-x: auto;" class="nav nav-nowrap w-75 gap-2 gap-xl-4 nav--tabs" id="nav-tab" role="tablist">
                        @foreach($categories as $category)
                            @if($category->ads->count() > 0)
                                <button class="@if($loop->index == 0) active @endif fs-18 px-2" id="{{ str_replace(' ', '-', $category->name) }}-tab" 
                                data-bs-toggle="tab" data-bs-target="#{{ str_replace(' ', '-', $category->name) }}"
                                    role="tab" aria-controls="{{str_replace(' ', '-', $category->name)}}">{{ ucwords($category->name) }}
                                </button>
                            @endif
                        @endforeach
                    </div>
                    <div class="d-flex flex-wrap justify-content-end gap-3 mb-2">
                        <a href="{{route('products',['data_from'=>'featured'])}}" class="btn btn-primary">
                            {{ translate('View_All') }}
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    @foreach($categories as $category)
                        @if($category->ads->count() > 0)
                            <div class="tab-pane fade show @if($loop->index == 0) active @endif" 
                            id="{{ str_replace(' ', '-', $category->name) }}" role="tabpanel" tabindex="0">
                                <div class="auto-col mobile-items-2 gap-2 gap-sm-3 recommended-product-grid" style="--minWidth: 12rem;">
                                    <!-- Single Vehicle -->
                                    @foreach($category->ads as $ad)
                                        @if($ad)
                                            @include('theme-views.partials._product-large-card',['ad'=>$ad])
                                        @endif
                                    @endforeach
                                </div>
                            </div>                    
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
