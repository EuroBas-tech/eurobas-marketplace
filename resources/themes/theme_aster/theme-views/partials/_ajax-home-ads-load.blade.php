<div class="auto-col mobile-items-2 mt-3 gap-2 gap-sm-3 recommended-product-grid" 
style="--minWidth: 12rem;">
    <!-- Single Vehicle -->
    @foreach($ads as $ad)
        @if($ad)
            @include('theme-views.partials._product-large-card',['ad'=>$ad])
        @endif
    @endforeach
</div>










