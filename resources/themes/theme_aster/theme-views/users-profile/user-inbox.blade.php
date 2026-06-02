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

        /* ── Milestone 2: chat bubbles, status, day grouping ── */
        .chat-thread { display: flex; flex-direction: column; gap: .35rem; }
        .chat-row { display: flex; width: 100%; }
        .chat-row.mine { justify-content: flex-end; }
        .chat-row.theirs { justify-content: flex-start; }
        .chat-bubble {
            position: relative;
            max-width: 70%;
            padding: .55rem .75rem;
            border-radius: .85rem;
            word-wrap: break-word;
            overflow-wrap: anywhere;
            font-size: 14px;
            line-height: 1.4;
        }
        .chat-row.mine .chat-bubble {
            background: var(--bs-primary, #0d6efd);
            color: #fff;
            border-bottom-right-radius: .2rem;
        }
        .chat-row.mine .chat-bubble a { color: #fff; text-decoration: underline; }
        .chat-row.theirs .chat-bubble {
            background: #f1f3f5;
            color: #212529;
            border-bottom-left-radius: .2rem;
        }
        .chat-meta { display: flex; align-items: center; gap: .25rem; justify-content: flex-end; margin-top: .15rem; font-size: 10px; opacity: .85; }
        .chat-row.theirs .chat-meta { justify-content: flex-start; }
        .chat-status .bi { font-size: 13px; line-height: 1; }
        .chat-status .seen { color: #34b7f1; }
        .chat-day-separator { text-align: center; margin: .6rem 0; }
        .chat-day-separator span {
            background: #e9ecef; color: #6c757d; font-size: 11px;
            padding: .15rem .6rem; border-radius: 1rem;
        }
        .chat-attachments { display: flex; flex-wrap: wrap; gap: .35rem; margin-top: .35rem; }
        .chat-attachments img { width: 110px; height: 90px; object-fit: cover; border-radius: .4rem; }
        .msg-del {
            visibility: hidden; border: 0; background: transparent; color: inherit;
            font-size: 12px; opacity: .7; padding: 0 .15rem; cursor: pointer;
        }
        .chat-bubble:hover .msg-del { visibility: visible; }
        .chat-image-preview { display: flex; flex-wrap: wrap; gap: .35rem; }
        .chat-image-preview .preview-item { position: relative; }
        .chat-image-preview img { width: 48px; height: 48px; object-fit: cover; border-radius: .35rem; }
        .chat-image-preview .remove-preview {
            position: absolute; top: -6px; right: -6px; background: #dc3545; color: #fff;
            border-radius: 50%; width: 16px; height: 16px; font-size: 11px; line-height: 16px;
            text-align: center; cursor: pointer;
        }
        @media (max-width: 575.98px) {
            .chat-bubble { max-width: 85%; }
            .chat-attachments img { width: 90px; height: 75px; }
        }

        /* ── Chat input alignment ── */
        .type_msg .input_msg_write { align-items: center; }
        .type_msg .input_msg_write > div.form-control {
            min-height: 0;
            padding-top: 0;
            padding-bottom: 0;
        }
        .type_msg .attach-btn {
            display: flex;
            align-items: center;
            margin: 0;
            line-height: 1;
        }
        .type_msg .focus-input {
            border: 0;
            background: transparent;
            outline: none;
            box-shadow: none;
            resize: none;
            height: 40px;
            min-height: 40px;
            max-height: 120px;
            line-height: 1.6;
            padding: 8px 0;
            margin: 0;
            overflow-y: auto;
        }
        .type_msg #msgSendBtn {
            display: flex;
            align-items: center;
            align-self: center;
            padding: 0;
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
                                    <form action="#" class="mb-3" onsubmit="return false;">
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
                                                                    @if($shop->unseen_message_count > 0)
                                                                        <span class="fs-10 message-notification-number d-flex align-items-center justify-content-center rounded-circle bg-danger text-white">{{$shop->unseen_message_count}}</span>
                                                                    @endif
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
                                @if(isset($last_chat) && isset($user) && $user)
                                    <div class="border-bottom px-3 py-3 bg-light d-flex align-items-center justify-content-between">
                                        <div class="media gap-2 align-items-center">
                                            <div class="avatar rounded-circle">
                                                <img
                                                onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'"
                                                src="{{cloudfront('profile/images/'.$user->image)}}"
                                                loading="lazy" id="image" class="img-fit rounded-circle dark-support"
                                                alt="">
                                            </div>
                                            <div class="media-body">
                                                <div class="d-flex flex-column gap-1">
                                                    <h5 class="mb-0" id="name">{{$user->name}}</h5>
                                                    @if(isset($is_blocked) && $is_blocked)
                                                        <span class="badge bg-danger" id="blocked-badge">{{ translate('blocked') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <a target="_blank"
                                                href="{{ route('show-profile', [$user->id, $user->name]) . '?tap=ads' }}"
                                                class="btn btn-outline-primary btn-sm px-2 d-none d-sm-flex align-items-center gap-1">
                                                <i class="bi bi-person-circle"></i>
                                                {{ translate('show_profile') }}
                                            </a>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li class="d-sm-none">
                                                        <a class="dropdown-item" target="_blank" href="{{ route('show-profile', [$user->id, $user->name]) . '?tap=ads' }}">
                                                            <i class="bi bi-person-circle me-1"></i>{{ translate('show_profile') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reportUserModal">
                                                            <i class="bi bi-flag me-1"></i>{{ translate('report_user') }}
                                                        </button>
                                                    </li>
                                                    <li id="block-toggle-wrap">
                                                        @if(isset($is_blocked) && $is_blocked)
                                                            <button type="button" class="dropdown-item text-success" onclick="toggleBlock({{$user->id}}, false)">
                                                                <i class="bi bi-unlock me-1"></i>{{ translate('unblock_user') }}
                                                            </button>
                                                        @else
                                                            <button type="button" class="dropdown-item text-danger" onclick="toggleBlock({{$user->id}}, true)">
                                                                <i class="bi bi-slash-circle me-1"></i>{{ translate('block_user') }}
                                                            </button>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        <button type="button" class="dropdown-item text-danger" onclick="deleteConversation({{$user->id}})">
                                                            <i class="bi bi-trash me-1"></i>{{ translate('delete_conversation') }}
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="messaging">
                                        <div class="inbox_msg custom-scrollbar p-3 msg_history" style="height: 480px" id="show_msg">
                                            <div class="chat-thread">
                                                @if (isset($filteredChats))
                                                    @php($lastDate = null)
                                                    @foreach($filteredChats as $key => $chat)
                                                        @php($mine = $chat->sender_id == auth('customer')->id())
                                                        @php($thisDate = \Carbon\Carbon::parse($chat->created_at)->format('Y-m-d'))
                                                        @if($thisDate !== $lastDate)
                                                            <div class="chat-day-separator">
                                                                <span>
                                                                    @if(\Carbon\Carbon::parse($chat->created_at)->isToday())
                                                                        {{ translate('today') }}
                                                                    @elseif(\Carbon\Carbon::parse($chat->created_at)->isYesterday())
                                                                        {{ translate('yesterday') }}
                                                                    @else
                                                                        {{ \Carbon\Carbon::parse($chat->created_at)->format('M d, Y') }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            @php($lastDate = $thisDate)
                                                        @endif

                                                        @php($decoded = json_decode($chat->attachment, true))
                                                        @php($imgs = is_array($decoded) ? array_filter($decoded) : [])
                                                        @php($ad = $chat->ad_id ? \App\Model\Ad::find($chat->ad_id) : (($chat->attachment && is_numeric($chat->attachment)) ? \App\Model\Ad::find($chat->attachment) : null))

                                                        <div class="chat-row {{ $mine ? 'mine' : 'theirs' }}">
                                                            <div class="chat-bubble">
                                                                @if($mine)
                                                                    <button class="msg-del" title="{{translate('delete')}}" onclick="deleteMessage({{$chat->id}}, this)">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                @endif

                                                                @if($ad)
                                                                    <a href="{{route('ads-show',$ad->slug)}}" class="d-flex align-items-start gap-2 mb-2 pb-2 border-bottom">
                                                                        <img class="rounded chat-img"
                                                                             src="{{cloudfront('ad/thumbnail/'.$ad->thumbnail)}}"
                                                                             onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'"
                                                                             alt="ad_thumbnail">
                                                                        <span class="fw-medium">{{ $ad->title }}</span>
                                                                    </a>
                                                                @endif

                                                                @if($chat->message)
                                                                    <div class="chat-text">{!! $chat->message !!}</div>
                                                                @endif

                                                                @if(count($imgs))
                                                                    <div class="chat-attachments">
                                                                        @foreach($imgs as $photo)
                                                                            <a href="{{cloudfront('chatting')}}/{{$photo}}" data-lightbox="msg-{{$chat->id}}">
                                                                                <img src="{{cloudfront('chatting')}}/{{$photo}}"
                                                                                     onerror="this.src='{{theme_asset('assets/img/image-place-holder.png')}}'" alt="">
                                                                            </a>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                <div class="chat-meta">
                                                                    <span>{{ \Carbon\Carbon::parse($chat->created_at)->format('h:i A') }}</span>
                                                                    @if($mine)
                                                                        <span class="chat-status">
                                                                            @if($chat->seen_at || $chat->seen)
                                                                                <i class="bi bi-check-all seen" title="{{translate('seen')}}"></i>
                                                                            @elseif($chat->delivered_at)
                                                                                <i class="bi bi-check-all" title="{{translate('delivered')}}"></i>
                                                                            @else
                                                                                <i class="bi bi-check" title="{{translate('sent')}}"></i>
                                                                            @endif
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div id="down"></div>
                                        </div>

                                        <div class="type_msg px-2">
                                            <form class="mt-3" id="myForm" enctype="multipart/form-data">
                                                @csrf
                                                <div id="chatImagePreview" class="chat-image-preview px-2 mb-2"></div>
                                                <div class="input_msg_write border rounded py-2 px-2 px-sm-3 d-flex align-items-center justify-content-between gap-2 {{ (isset($is_blocked) && $is_blocked) ? 'd-none' : '' }}" id="chat-input-wrap">
                                                    <div class="d-flex align-items-center gap-2 py-0 h-auto form-control focus-border rounded-10">
                                                        <input type="hidden" value="{{$chat_with}}" id="chat_with" name="chat_with">
                                                        <label class="attach-btn cursor-pointer" title="{{translate('attach_image')}}">
                                                            <i class="bi bi-image fs-18 text-primary"></i>
                                                            <input type="file" id="chatImageInput" name="image[]" accept="image/*" multiple hidden>
                                                        </label>
                                                        <textarea class="w-100 focus-input" id="msgInputValue" rows="1"
                                                        placeholder="{{translate('start_a_new_message')}}"></textarea>
                                                    </div>

                                                    <button class="bg-transparent border-0" type="submit" id="msgSendBtn">
                                                        <i class="bi bi-send-fill fs-16 text-primary"></i>
                                                    </button>
                                                </div>
                                                @if(isset($is_blocked) && $is_blocked)
                                                    <p class="text-center text-muted mt-2 mb-0" id="blocked-note">
                                                        {{ translate('you_blocked_this_user_unblock_to_send_messages') }}
                                                    </p>
                                                @endif
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

    @if(isset($user) && $user)
        <!-- Report User Modal (Milestone 2) -->
        <div class="modal fade" id="reportUserModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ translate('report_user') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="reportUserForm">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="reported_id" value="{{ $user->id }}">
                            <div class="form-group mb-3">
                                <label>{{ translate('reason') }}</label>
                                <select name="reason" class="form-control">
                                    <option value="spam">{{ translate('spam_or_scam') }}</option>
                                    <option value="abuse">{{ translate('abusive_or_harassment') }}</option>
                                    <option value="inappropriate">{{ translate('inappropriate_content') }}</option>
                                    <option value="other">{{ translate('other') }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{ translate('details') }}</label>
                                <textarea name="message" class="form-control" rows="3" placeholder="{{ translate('describe_the_issue') }}"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ translate('cancel') }}</button>
                            <button type="submit" class="btn btn-primary">{{ translate('submit_report') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection


@push('script')
    <script>
        $(document).ready(function () {

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
            });

            function scrollChatToBottom() {
                let h = $(".msg_history");
                if (h.length) { h.stop().animate({scrollTop: h[0].scrollHeight}, 600); }
            }
            scrollChatToBottom();

            // Sidebar conversation search
            $("#myInput").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $(".chat_list").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // ── Auto-grow the message textarea (single line that expands) ──
            var msgInput = document.getElementById('msgInputValue');
            function autoGrowMsg() {
                if (!msgInput) return;
                msgInput.style.height = 'auto';
                msgInput.style.height = Math.min(msgInput.scrollHeight, 120) + 'px';
            }
            function resetMsgHeight() {
                if (msgInput) { msgInput.style.height = '40px'; }
            }
            if (msgInput) { msgInput.addEventListener('input', autoGrowMsg); }

            // ── Image attach preview ──
            let selectedFiles = [];
            $('#chatImageInput').on('change', function () {
                selectedFiles = Array.from(this.files);
                renderPreview();
            });
            function renderPreview() {
                let box = $('#chatImagePreview');
                box.empty();
                selectedFiles.forEach(function (file, idx) {
                    let url = URL.createObjectURL(file);
                    box.append(`<div class="preview-item">
                        <img src="${url}" alt="">
                        <span class="remove-preview" data-idx="${idx}">&times;</span>
                    </div>`);
                });
            }
            $('#chatImagePreview').on('click', '.remove-preview', function () {
                selectedFiles.splice($(this).data('idx'), 1);
                renderPreview();
            });

            // ── Send message (text + images) ──
            $("#myForm").on('submit', function (e) {
                e.preventDefault();

                var message = $('#msgInputValue').val().trim();
                var chat_with = $('#chat_with').val();
                if (message === '' && selectedFiles.length === 0) { return; }

                var formData = new FormData();
                formData.append('message', message);
                formData.append('chat_with', chat_with);
                selectedFiles.forEach(function (file) { formData.append('image[]', file); });

                $('#msgSendBtn').prop('disabled', true);

                $.ajax({
                    type: "post",
                    url: "{{route('discussion_store')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#msgSendBtn').prop('disabled', false);
                        let imgHtml = '';
                        if (response.image && response.image.length) {
                            imgHtml = '<div class="chat-attachments">';
                            response.image.forEach(function (p) {
                                imgHtml += `<a href="{{cloudfront('chatting')}}/${p}"><img src="{{cloudfront('chatting')}}/${p}" alt=""></a>`;
                            });
                            imgHtml += '</div>';
                        }
                        let textHtml = response.message ? `<div class="chat-text">${response.message}</div>` : '';
                        $(".chat-thread").append(`
                            <div class="chat-row mine">
                                <div class="chat-bubble">
                                    ${textHtml}
                                    ${imgHtml}
                                    <div class="chat-meta">
                                        <span>{{ \Carbon\Carbon::now()->format('h:i A') }}</span>
                                        <span class="chat-status"><i class="bi bi-check" title="{{translate('sent')}}"></i></span>
                                    </div>
                                </div>
                            </div>`);
                        $('#msgInputValue').val('');
                        resetMsgHeight();
                        selectedFiles = [];
                        renderPreview();
                        scrollChatToBottom();
                    },
                    error: function (error) {
                        $('#msgSendBtn').prop('disabled', false);
                        let msg = (error.responseJSON && typeof error.responseJSON === 'string') ? error.responseJSON : '{{ translate("something_went_wrong") }}';
                        toastr.warning(msg);
                    }
                });
            });
        });

        // ── Report user ──
        $('#reportUserForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: "{{ route('report_user') }}",
                data: $(this).serialize(),
                success: function (res) {
                    if (res.error_message) { toastr.error(res.error_message); return; }
                    toastr.success(res.message);
                    $('#reportUserModal').modal('hide');
                    $('#reportUserForm')[0].reset();
                },
                error: function () { toastr.error('{{ translate("something_went_wrong") }}'); }
            });
        });

        // ── Block / Unblock ──
        function toggleBlock(userId, block) {
            $.ajax({
                type: 'post',
                url: block ? "{{ route('block_user') }}" : "{{ route('unblock_user') }}",
                data: { blocked_id: userId, _token: $('meta[name="_token"]').attr('content') },
                success: function (res) {
                    if (res.error_message) { toastr.error(res.error_message); return; }
                    toastr.success(res.message);
                    setTimeout(function () { location.reload(); }, 800);
                },
                error: function () { toastr.error('{{ translate("something_went_wrong") }}'); }
            });
        }

        // Reusable SweetAlert2 confirmation (no native confirm/alert anywhere).
        function eurobasConfirm(title, onConfirm) {
            Swal.fire({
                title: title,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '{{ $web_config['primary_color'] ?? '#0d6efd' }}',
                cancelButtonText: '{{ translate('no') }}',
                confirmButtonText: '{{ translate('yes') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) { onConfirm(); }
            });
        }

        // ── Delete single message (soft, for me only) ──
        function deleteMessage(id, el) {
            eurobasConfirm('{{ translate("delete_this_message") }}?', function () {
                $.ajax({
                    type: 'post',
                    url: "{{ route('delete_message') }}",
                    data: { message_id: id, _token: $('meta[name="_token"]').attr('content') },
                    success: function (res) {
                        if (res.error_message) { toastr.error(res.error_message); return; }
                        $(el).closest('.chat-row').remove();
                        toastr.success(res.message);
                    },
                    error: function () { toastr.error('{{ translate("something_went_wrong") }}'); }
                });
            });
        }

        // ── Delete whole conversation (soft, for me only) ──
        function deleteConversation(userId) {
            eurobasConfirm('{{ translate("delete_entire_conversation") }}?', function () {
                $.ajax({
                    type: 'post',
                    url: "{{ route('delete_conversation') }}",
                    data: { user_id: userId, _token: $('meta[name="_token"]').attr('content') },
                    success: function (res) {
                        toastr.success(res.message);
                        setTimeout(function () { location.href = "{{ route('chat', 'user') }}"; }, 800);
                    },
                    error: function () { toastr.error('{{ translate("something_went_wrong") }}'); }
                });
            });
        }
    </script>
    <script src="{{ theme_asset('assets/js/lightbox.min.js') }}"></script>
@endpush
