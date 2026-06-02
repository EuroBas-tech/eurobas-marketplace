{{-- Milestone 3: reusable seller rating (stars + count).
     Params: $seller_id (required), $star_size (optional, e.g. '12px'),
             $text_class (optional), $show_empty (optional bool). --}}
@php($__sr = \App\Model\SellerReview::summaryFor($seller_id ?? 0))
@if(($show_empty ?? false) || $__sr['count'] > 0)
    <div class="d-flex align-items-center gap-1 seller-rating-inline">
        <span class="star-rating text-gold" style="font-size: {{ $star_size ?? '12px' }};">
            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $__sr['avg'])
                    <i class="bi bi-star-fill"></i>
                @elseif ($__sr['avg'] != 0 && $i <= (int)$__sr['avg'] + 1 && $__sr['avg'] >= ((int)$__sr['avg'] + .30))
                    <i class="bi bi-star-half"></i>
                @else
                    <i class="bi bi-star"></i>
                @endif
            @endfor
        </span>
        <span class="{{ $text_class ?? 'text-muted' }} fs-12">{{ $__sr['avg'] }} ({{ $__sr['count'] }})</span>
    </div>
@endif
