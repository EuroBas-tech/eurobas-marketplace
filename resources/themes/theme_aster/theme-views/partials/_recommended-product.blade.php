<section class="py-3">
    <div class="container">
        @foreach($categories->where('position', 1) as $category)
            @if($category->ads()->when(session('show_by_country'), fn($q, $country) => $q->country($country['name']))->count() > 4)
                <div class="mb-4" >
                    <div class="d-flex justify-content-between align-items-center mb-3" >
                        <h3 class="m-0 fw-bold">{{ $category->name }}</h3>
                        <a href="{{route('show-by-category', $category->id)}}" class="btn btn-primary btn-sm py-1 px-2">
                            {{translate('show_all')}}
                            <i class="bi {{ app()->getLocale() == 'ae' ? 'bi-arrow-left' : 'bi-arrow-right' }}"></i>
                        </a>
                    </div>
                    <div>
                        <div data-category="{{$category->id}}" id="{{ preg_replace('/[^a-zA-Z0-9 ]/', '', str_replace(' ', '-', $category->name)) }}">
                            <div class="auto-col mobile-items-2 gap-2 gap-sm-3 recommended-product-grid" style="--minWidth: 12rem;">
                                @foreach($category->ads as $ad)
                                    @include('theme-views.partials._product-large-card',['ad'=>$ad])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section>