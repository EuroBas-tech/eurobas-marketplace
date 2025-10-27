<div class="dropdown mb-1">                                                                        
    <input class="" type="hidden" name="ad_id" id="selected_ad_id" value="">
    <button style="border: 1px solid #ced4da;border-radius: 7px;" class="btn btn-outline-secondary no-hover-btn w-100 custom-input-height justify-content-start" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        <span id="selectedCategoryText" class="fw-normal font-size-16" >
            {{translate('ads')}} ({{$user_ads->count()}})
        </span>
    </button>
    <ul class="dropdown-menu w-100 p-0" style="max-height: 350px;overflow-y: auto;border: 1px #80808026 solid;" >
        @foreach($user_ads as $user_ad)
            <li class="p-0 border-bottom">
                <a class="dropdown-item font-size-16 d-flex align-items-center p-2 gap-2" 
                    href="#" 
                    data-id="{{ $user_ad->id }}">
                    <div>
                        <img class="rounded unset-max-inline-size" width="80px" height="80px" src="{{ env_asset('storage/ad/thumbnail/'.$user_ad->thumbnail) }}" alt="ad_image">
                    </div>
                    <div class="d-flex align-items-center justify-content-between w-100" >
                        <div class="d-flex gap-1 flex-column" >
                            <h5 class="fw-medium text-primary" >{{ $user_ad['title'] }}</h5>
                            <span class="no-hover" >{{translate('category')}} : {{ $user_ad['category']['name'] }}</span>
                        </div>
                        <div class="d-sm-block d-none" >
                            @php($locale = SOLVE_LOCALE_CODES[app()->getLocale()] ?? app()->getLocale())
                            <span class="no-hover" >{{ $user_ad['created_at']->format('Y-m-d') }} ({{$user_ad['created_at']->locale($locale)->diffForHumans()}})</span>
                        </div>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>