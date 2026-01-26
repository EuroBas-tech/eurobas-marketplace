<style>
    .search-image {
        width: 70px !important;
        height: 70px !important;
        max-inline-size: initial;
        block-size: initial;
        object-fit: cover;
    }
    .search-title {
        line-height: 1.5;
    }
    .torn-paper-sticker {
        background-color: #ff0018;
        animation: urgentDance 5s infinite;
        clip-path: polygon(
            0% 0%,
            95% 0%,
            100% 15%,
            98% 25%,
            100% 35%,
            97% 45%,
            100% 55%,
            96% 65%,
            100% 75%,
            95% 85%,
            100% 100%,
            5% 100%,
            0% 85%,
            2% 75%,
            0% 65%,
            3% 55%,
            0% 45%,
            4% 35%,
            0% 25%,
            2% 15%
        );
    }
    @keyframes urgentDance {
        0%, 85%, 100% {
            transform: translateX(0);
        }
        5% {
            transform: translateX(-2px);
        }
        10% {
            transform: translateX(2px);
        }
        15% {
            transform: translateX(-1.5px);
        }
        20% {
            transform: translateX(1.5px);
        }
        25% {
            transform: translateX(-1px);
        }
        30% {
            transform: translateX(1px);
        }
        35% {
            transform: translateX(0);
        }
    }
    .urgent-sale-sticker-text {
        font-size: 13px;
    }
</style>

<ul class="list-group list-group-flush" >
    @if(!empty($ads))
        @foreach($ads as $ad)
            <li class="list-group-item p-2">
                <a class="font-size-16 d-flex align-items-center gap-2" href="{{route('ads-show',$ad->slug)}}">
                    <div>
                        <img class="rounded search-image"
                        src="{{ cloudfront('ad/thumbnail/'.$ad->thumbnail) }}" alt="ad_image">
                    </div>
                    <div class="d-flex align-items-center justify-content-between w-100" >
                        <div class="d-flex gap-1 flex-column w-100" >
                            <h6 class="fw-medium text-primary search-title" >{{ $ad['title'] }}</h6>
                            <div class="d-flex align-items-center justify-content-between w-100" >
                                <h6 class="no-hover fw-medium" >
                                    {{ $ad['created_at']->toDateString() }} ({{$ad['created_at']->diffForHumans()}})
                                </h6>
                                @if($ad->sponsor()->where('type', 'urgent_sale_sticker')
                                    ->where('expiration_date', '>', now())
                                    ->where('is_paid', 1)
                                    ->exists()
                                )
                                    <span class="text-white fw-bold p-1 torn-paper-sticker urgent-sale-sticker-text">
                                        {{translate('urgent_sale')}}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </li>
        @endforeach
    @else
        <li class="list-group-item p-4">
            <div class="text-center" >
                <h6 class="no-hover fw-medium text-primary" >{{ translate('no_result_found') }}</h6>
            </div>
        </li>
    @endif
</ul>
