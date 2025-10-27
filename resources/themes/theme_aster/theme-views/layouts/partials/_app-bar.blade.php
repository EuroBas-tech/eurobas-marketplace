<!-- App Bar -->
<ul class="list-unstyled d-flex justify-content-around gap-3 mb-0 position-relative bg-white shadow-lg">
    <li>
        <a href="{{ route('home') }}" class="d-flex align-items-center flex-column py-2 {{ (Request::is('/') || Request::is('home')) ? 'active' : '' }}">
            <i class="bi bi-house-door fs-16"></i>
            <span class="fs-14">{{ translate('home') }}</span>
        </a>
    </li>
    <li>
        @if(auth('customer')->check())
            <a href="{{ route('wishlists') }}" class="d-flex align-items-center flex-column  py-2 {{ Request::is('wishlists') ? 'active' : '' }}">
                <div class="position-relative">
                    <i class="bi bi-heart fs-16"></i>
                    <span class="count wishlist_count_status top-0">{{session()->has('wish_list')?count(session('wish_list')):0}}</span>
                </div>
                <span class="fs-14">{{ translate('wishlist') }}</span>
            </a>
        @else
            <a href="javascript:" class="d-flex align-items-center flex-column py-2" data-bs-toggle="modal"
            data-bs-target="#loginModal">
                <div class="position-relative">
                    <i class="bi bi-heart fs-16"></i>

                </div>
                <span class="fs-14">{{ translate('wishlist') }}</span>
            </a>
        @endif
    </li>
    <li>
        @if(auth('customer')->check())
            <a href="{{ route('chat', 'user') }}" class="d-flex align-items-center flex-column py-2 {{ Request::is('chat/user') ? 'active' : '' }}">
                <div class="position-relative">
                    <i class="bi bi-envelope fs-16"></i>
                    @php($unread_message_count=\App\Model\Chatting::where(['receiver_id'=>auth('customer')->id(),'seen'=>0])->count())
                    <span class="count compare_list_count_status bg-danger top-0">{{$unread_message_count}}</span>
                </div>
                <span class="fs-14">{{ translate('messages') }}</span>
            </a>
        @else
            <a href="javascript:" class="d-flex align-items-center flex-column py-2" data-bs-toggle="modal"
            data-bs-target="#loginModal">
                <div class="position-relative">
                    <i class="bi bi-envelope fs-16"></i>
                </div>
                <span class="fs-14">{{ translate('messages') }}</span>
            </a>
        @endif
    </li>
</ul>
