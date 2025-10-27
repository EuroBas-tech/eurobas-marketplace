<ul class="list-group list-group-flush " >
    @foreach($ads as $ad)
        <li class="list-group-item">
            <a href="{{route('ads-show',$ad->slug)}}" >
                {{$ad['title']}}
            </a>
        </li>
    @endforeach
</ul>