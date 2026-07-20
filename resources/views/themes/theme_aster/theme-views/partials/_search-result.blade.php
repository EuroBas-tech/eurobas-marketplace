<ul class="list-group list-group-flush">
    @if(isset($ads) && count($ads) > 0)
        @foreach($ads as $ad)
            <li class="list-group-item">
                <a href="{{ url(app()->getLocale() . '/ads/show/' . $ad->slug) }}">
                    {{ $ad['title'] }}
                </a>
            </li>
        @endforeach
    @else
        <li class="list-group-item text-center">
            {{ translate('not_found_anything') }}
        </li>
    @endif
</ul>
