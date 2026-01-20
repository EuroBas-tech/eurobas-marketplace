@extends('theme-views.layouts.app')

@section('title', translate('My_Inbox').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@push('css_or_js')
    <style>
        .chat-img {
            width: 120px;
            height: 80px;
            object-fit: cover;
        }
        .width-fill-available {
            width: -webkit-fill-available;
        }
    </style>
@endpush

@section('content')
    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 py-3 mb-5">
        <div class="container">
            <div class="row g-4">

                <!-- Sidebar-->
                @include('theme-views.partials._profile-aside')
                <div class="col">
                    <div class="card h-100 mb-3 card-border aside-shadow">
                        <div class="flexible-grid md-down-1 h-100" style="--width: 15.625rem">
                            <div class="bg-light h-100">
                                <div class="p-3">
                                    <h3 class="mb-3">{{translate('messages')}}</h3>
                                    <form action="#" class="mb-3">
                                        <div class="search-bar style--two">
                                            <button type="submit">
                                                <i class="bi bi-search"></i>
                                            </button>
                                            <input type="search" class="form-control" id="myInput" autocomplete="off"
                                                   placeholder="{{translate('search')}}...">
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-content p-2 pt-0">
                                    <div class="tab-pane fade show active" id="seller-tab-pane" role="tabpanel"
                                         aria-labelledby="seller-tab" tabindex="0">
                                        <div class="chat-list custom-scrollbar">
                                            @if (isset($unique_chats))
                                                @foreach($unique_chats as $key=>$shop)
                                                    @php($type = 'user')
                                                    @php($unique_id = $shop->id)
                                                    @php($senderOrReceiver = $shop->sender_id == auth('customer')->id() ? 'receiver' : 'sender')
                                                    @php($correspondent_id = $shop->sender_id == auth('customer')->id() ? $shop->receiver_id : $shop->sender_id)
                                                    @php($username = $shop->$senderOrReceiver->name ?? null)
                                                    <div
                                                        onclick="location.href='{{route('chat', ['type' => $type])}}/?id={{$correspondent_id}}'"
                                                        class="chat_list  chat-list-item @if(!request()->id && $loop->first) active @elseif(request()->id && request()->id == $correspondent_id) active @endif media gap-2 align-items-center"
                                                        id="user_{{$unique_id}}">
                                                        <div class="avatar rounded-circle ">
                                                            <img width="40px" height="35px"
                                                                onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                                                                src="{{ cloudfront('profile/images/' . ($shop->$senderOrReceiver?->image ?? 'default.png')) }}"
                                                                loading="lazy" class="img-fit rounded-circle dark-support" alt="">
                                                        </div>
                                                        <div class="media-body width-fill-available">
                                                            <div class="d-flex justify-content-between gap-2 align-items-center mb-1">
                                                                <div
                                                                    class="w-75 d-flex align-items-center gap-1">
                                                                    <h6 class="fs-12 seller"
                                                                        id="{{$unique_id}}">{{ substr($username, 0, 18)}}{{ strlen($username) > 28 ? '...' : '' }}</h6>
                                                                    <div class="fs-12 text-muted"></div>
                                                                </div>

                                                                <div>
                                                                    <span class="fs-10 message-notification-number d-flex align-items-center justify-content-center rounded-circle bg-danger text-white">{{$shop->unseen_message_count}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center" >
                                                                <div class="fs-10">{{date('M d Y',strtotime($shop->created_at))}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                @if(isset($last_chat))
                                    <div class="border-bottom px-3 py-3 bg-light d-flex align-items-center justify-content-between">
                                        <div class="media gap-2 align-items-center">
                                            @if($user)
                                                <div class="avatar rounded-circle">
                                                    <img
                                                    onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                                                    src="{{cloudfront('profile/images/'.$user->image)}}"
                                                    loading="lazy" id="image" class="img-fit rounded-circle dark-support"
                                                    alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="d-flex flex-column gap-1">
                                                        <h5 class="" id="name">{{$user->name}}</h5>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <a target="_blank" 
                                                href="{{ $user ? route('show-profile', [$user->id, $user->name]) . '?tap=ads' : '#' }}" 
                                                class="btn btn-outline-primary btn-sm px-2 d-flex align-items-center gap-1">
                                                <i class="bi bi-person-circle"></i>
                                                {{ translate('show_profile') }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="messaging">
                                        <div class="inbox_msg custom-scrollbar p-3 msg_history" style="height: 480px"
                                            id="show_msg">
                                            @if (isset($chatting))
                                                @foreach($filteredChats as $key => $chat)
                                                    @php($ad = $chat->attachment ? \App\Model\Ad::find($chat->attachment) : null)

                                                    @if($chat->receiver_id == auth('customer')->id())
                                                        <div class="received_msg">
                                                            @if($chat->message)
                                                                @if($chat->attachment && $ad)
                                                                    <div class="message_text p-2">
                                                                        <div class="d-flex align-items-start gap-3" >
                                                                            <div>
                                                                                <a href="{{route('ads-show',$ad->slug)}}">
                                                                                    <img class="rounded chat-img"
                                                                                    src="{{cloudfront('ad/thumbnail/'.$ad->thumbnail)}}"
                                                                                    onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'"
                                                                                    alt="ad_thumbnail">
                                                                                </a>
                                                                            </div>
                                                                            <div class="w-100" >
                                                                                <h5 class="text-white fw-medium mb-2 border-bottom pb-2 w-100" >
                                                                                    <a class="text-light" href="{{route('ads-show',$ad->slug)}}">
                                                                                        {{ $ad->title }}
                                                                                    </a>
                                                                                </h5>
                                                                                <h6 class="text-white fw-medium" >{!! $chat->message!!}</h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <p class="message_text" >{!! $chat->message!!}</p>
                                                                @endif
                                                            @endif
                                                            <span class="time_date"> {{ date('h:i:A | M d Y',strtotime($chat->created_at)) }} </span>
                                                        </div>
                                                    @elseif($chat->sender_id == auth('customer')->id())
                                                        <div class="outgoing_msg" id="outgoing_msg">
                                                            @if($chat->message)
                                                                @if($chat->attachment && $ad)
                                                                    <div class="message_text p-2">
                                                                        <div class="d-flex align-items-start gap-3" >
                                                                            <div>
                                                                                <a href="{{route('ads-show',$ad->slug)}}">
                                                                                    <img class="rounded chat-img"
                                                                                    src="{{cloudfront('ad/thumbnail/'.$ad->thumbnail)}}"
                                                                                    onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'"
                                                                                    alt="ad_thumbnail">
                                                                                </a>
                                                                            </div>
                                                                            <div class="w-100" >
                                                                                <h5 class="text-white fw-medium mb-2 border-bottom pb-2 w-100" >
                                                                                    <a class="text-light" href="{{route('ads-show',$ad->slug)}}">
                                                                                        {{ $ad->title }}
                                                                                    </a>
                                                                                </h5>
                                                                                <h6 class="text-white fw-medium" >{!! $chat->message!!}</h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <p class="message_text" >{!! $chat->message!!}</p>
                                                                @endif
                                                            @endif
                                                            <span class="time_date d-flex justify-content-end"> {{ date('h:i:A | M d',strtotime($chat->created_at)) }} </span>
                                                        </div>
                                                    @endif
                                                @endForeach
                                                <div id="down"></div>
                                            @endif
                                        </div>

                                        <div class="type_msg px-2">
                                            <form class="mt-4" id="myForm">
                                                @csrf
                                                <div
                                                    class="input_msg_write border rounded py-2 px-2 px-sm-3 d-flex align-items-center justify-content-between gap-2">
                                                    <div
                                                        class="d-flex align-items-center gap-2 py-0 h-auto form-control focus-border rounded-10">
                                                        <input type="hidden"
                                                        value="{{$chat_with}}" id="chat_with" name="chat_with">

                                                        <textarea class="w-100 focus-input" id="msgInputValue"
                                                        placeholder="{{translate('start_a_new_message')}}"></textarea>
                                                    </div>

                                                    <button class="bg-transparent border-0" type="submit" id="msgSendBtn">
                                                        <i class="bi bi-send-fill fs-16 text-primary"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-center mt-5 p-2 bg-light dashed-border mx-2">
                                        {{ translate('no_conversation_found') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End Main Content -->
@endsection


@push('script')
    <script>

        // This script runs when the document is ready.
        $(document).ready(function () {

            let shop_id; // Declares a variable `shop_id`, but it is unused in the current code.

            // Scrolls the `.msg_history` container to the bottom when the page loads.
            $(".msg_history").stop().animate({scrollTop: $(".msg_history")[0].scrollHeight}, 1000);

            // Adds a keyup event listener to the input field with ID `myInput`.
            $("#myInput").on("keyup", function () {
                var value = $(this).val().toLowerCase(); // Gets the input value and converts it to lowercase.
                $(".chat_list").filter(function () {
                    // Filters `.chat_list` elements based on whether their text contains the input value.
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // Adds a click event listener to the button with ID `msgSendBtn`.
            $("#msgSendBtn").click(function (e) {
                e.preventDefault(); // Prevents the default form submission behavior.

                // Retrieves values from the form inputs.
                var inputs = $('#myForm').find('#msgInputValue').val(); // Gets the message input value.
                var chat_with = $('#myForm').find('#chat_with').val(); // Gets the `chat_with` value.

                // Prepares the data object to send via AJAX.
                let data = {
                    message: inputs,
                    chat_with: chat_with,
                }

                // Sets up the CSRF token for secure AJAX requests.
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') // Retrieves the CSRF token from a meta tag.
                    }
                });

                // Sends an AJAX POST request to the server.
                $.ajax({
                    type: "post", // Specifies the HTTP method as POST.
                    url: "{{route('discussion_store')}}", // Uses a Laravel route helper to define the endpoint URL.
                    data: data, // Sends the `data` object as the request payload.
                    success: function (response) {
                        // Handles the success response from the server.
                        if (response.message) {
                            // Appends the new message to the `.msg_history` container.
                            $(".msg_history").append(`
                                <div class="outgoing_msg" id="outgoing_msg">
                                    <p class="message_text">
                                        ${response.message }
                                    </p>
                                    <span class="time_date"> {{ translate('now') }} </span>
                                </div>`
                            )
                        }
                    },
                    error: function (error) {
                        // Handles errors by showing a warning notification using `toastr`.
                        toastr.warning(error.responseJSON)
                    }
                });

                // Clears the message input field after sending the message.
                $('#myForm').find('#msgInputValue').val('');

                // Scrolls the `.msg_history` container to the bottom after appending the new message.
                $(".msg_history").stop().animate({scrollTop: $(".msg_history")[0].scrollHeight}, 1000);
            });
        });
    </script>
    <script>
        // Adds a click event listener to elements with the class `remove-mask-img`.
        $('.remove-mask-img').on('click', function(){
            // Removes the `active` class from elements with the class `show-more--content`.
            $('.show-more--content').removeClass('active')
        })
    </script>
    <script src="{{ theme_asset('assets/js/lightbox.min.js') }}"></script> // Includes the `lightbox.min.js` script for additional functionality.
@endpush


