{{--
    Shared ad image uploader (used by both Add and Edit listing pages).

    - Drag & drop dropzone (or click to browse)
    - Each uploaded image is shown as a re-orderable card
    - The FIRST card is automatically used as the card / featured image
    - Users can drag to reorder, or press the star button to make an image the card image
    - Submits:
        image_order[]      -> ordered list of "new:<key>" or "existing:<filename>"
        new_images[<key>]  -> the actual newly uploaded files

    Optional variables:
        $existingImages           array of existing image filenames (edit page)
        $maximum_ad_images_number max number of images allowed
        $ad_images_size           max size per image in MB
--}}
@php
    $existingImages = $existingImages ?? [];
    $maxImages = $maximum_ad_images_number ?? 10;
    $maxImageSize = $ad_images_size ?? 4;
@endphp

<div class="ad-image-uploader">
    <div id="image-dropzone" class="ad-dropzone" tabindex="0" role="button"
         aria-label="{{ translate('drag_and_drop_your_image_here_or_click_to_browse') }}">
        <input type="file" id="image-dropzone-input" class="d-none" multiple accept="image/*">
        <div class="ad-dropzone__content">
            <i class="bi bi-cloud-arrow-up ad-dropzone__icon"></i>
            <div class="ad-dropzone__title">{{ translate('drag_and_drop_your_image_here_or_click_to_browse') }}</div>
        </div>
    </div>

    <div class="ad-uploader__hint">{{ translate('first_image_will_appear_on_the_card_in_the_ad') }}</div>

    <div id="image-cards-container" class="ad-image-cards"
         data-max="{{ $maxImages }}"
         data-max-size="{{ $maxImageSize }}">
        @foreach($existingImages as $image)
            <div class="ad-image-card" draggable="true">
                <input type="hidden" name="image_order[]" value="existing:{{ $image }}">
                <span class="ad-image-card__badge">{{ translate('card_image') }}</span>
                <button type="button" class="ad-image-card__feature" title="{{ translate('set_as_card_image') }}"
                        aria-label="{{ translate('set_as_card_image') }}">
                    <i class="bi bi-star-fill"></i>
                </button>
                <button type="button" class="ad-image-card__remove" title="{{ translate('remove') }}"
                        aria-label="{{ translate('remove') }}">
                    <i class="bi bi-x-lg"></i>
                </button>
                <div class="ad-image-card__img">
                    <img src="{{ cloudfront('ad/'.$image) }}"
                         onerror="this.src='{{ theme_asset('assets/img/image-place-holder.png') }}'" alt="">
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('css_or_js')
<style>
    .ad-image-uploader { width: 100%; }

    .ad-dropzone {
        border: 2px dashed #2c6ecb;
        border-radius: 14px;
        background: #f8faff;
        padding: 38px 20px;
        text-align: center;
        cursor: pointer;
        transition: background .15s ease, border-color .15s ease;
    }
    .ad-dropzone:hover,
    .ad-dropzone:focus { background: #eef4ff; outline: none; }
    .ad-dropzone.dragover { background: #e3edff; border-color: #1b54a8; }
    .ad-dropzone__icon { font-size: 2.6rem; color: #2c6ecb; display: block; line-height: 1; }
    .ad-dropzone__title { font-size: 1.1rem; color: #1f2937; margin-top: 12px; }

    .ad-uploader__hint { margin: 18px 0 12px; color: #1f2937; font-size: .98rem; }

    .ad-image-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }
    .ad-image-card {
        position: relative;
        width: 150px;
        height: 150px;
        border: 1px solid #b9cdf0;
        border-radius: 12px;
        background: #fff;
        overflow: hidden;
        cursor: grab;
    }
    .ad-image-card.dragging { opacity: .45; cursor: grabbing; }
    .ad-image-card__img { width: 100%; height: 100%; }
    .ad-image-card__img img { width: 100%; height: 100%; object-fit: cover; display: block; }

    .ad-image-card__badge {
        position: absolute;
        top: 8px; left: 8px;
        z-index: 2;
        background: #2c6ecb;
        color: #fff;
        font-size: .72rem;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 20px;
        display: none;
        text-transform: capitalize;
    }
    .ad-image-card.is-cover .ad-image-card__badge { display: inline-block; }
    .ad-image-card.is-cover { border-color: #2c6ecb; border-width: 2px; }

    .ad-image-card__feature,
    .ad-image-card__remove {
        position: absolute;
        z-index: 2;
        top: 8px;
        width: 26px; height: 26px;
        border: none;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .8rem;
        cursor: pointer;
        padding: 0;
        box-shadow: 0 1px 3px rgba(0,0,0,.15);
    }
    .ad-image-card__remove { right: 8px; background: #fff; color: #2c6ecb; }
    .ad-image-card__remove:hover { background: #2c6ecb; color: #fff; }
    /* The "set as card image" control stays out of the way until you hover a card
       (keeping the default look clean), and is always shown on touch devices where
       drag-to-reorder is impractical. */
    .ad-image-card__feature {
        left: 8px;
        background: #fff;
        color: #c9a227;
        opacity: 0;
        transition: opacity .15s ease;
    }
    .ad-image-card:hover .ad-image-card__feature { opacity: 1; }
    .ad-image-card__feature:hover { background: #c9a227; color: #fff; }
    .ad-image-card.is-cover .ad-image-card__feature { display: none; }
    @media (hover: none) {
        .ad-image-card__feature { opacity: 1; }
    }

    /* Shown on a card while its image is being pre-processed in the background */
    .ad-image-card.is-uploading .ad-image-card__img { opacity: .5; }
    .ad-image-card__spinner {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3;
    }
    .ad-image-card__spinner .spinner-border { width: 1.6rem; height: 1.6rem; color: #2c6ecb; }
</style>
@endpush

@php
    $imgUploaderText = [
        'invalidType' => translate('Only JPG, JPEG, PNG, WEBP, AVIF files are acceptable'),
        'tooLarge'    => translate('Maximum file size is'),
        'mb'          => translate('mb'),
        'maxImages'   => translate('maximum_images_allowed_number_is'),
        'image'       => translate('image'),
        'cardImage'   => translate('card_image'),
        'setAsCard'   => translate('set_as_card_image'),
        'remove'      => translate('remove'),
    ];
@endphp
@push('script')
<script>
    (function () {
        var T = {!! json_encode($imgUploaderText) !!};
        var uploadUrl = "{{ route('ads-upload-image') }}";
        var csrfToken = "{{ csrf_token() }}";
        var pendingUploads = 0;

        function init() {
            var container = document.getElementById('image-cards-container');
            var dropzone = document.getElementById('image-dropzone');
            var dropInput = document.getElementById('image-dropzone-input');
            if (!container || !dropzone || !dropInput) return;

            var form = container.closest('form');

            var allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
            var maxImages = parseInt(container.dataset.max, 10) || 10;
            var maxSize = (parseFloat(container.dataset.maxSize) || 4) * 1024 * 1024;
            var counter = 0;
            var dragSrc = null;

            function cardCount() {
                return container.querySelectorAll('.ad-image-card').length;
            }

            // Keep the first card flagged as the cover/card image.
            function refresh() {
                var cards = container.querySelectorAll('.ad-image-card');
                cards.forEach(function (card, i) {
                    card.classList.toggle('is-cover', i === 0);
                });
            }

            // Exposes whether any image is still being pre-processed, and lets
            // the publish button wait for them instead of showing an error.
            // The button already has its own translated loading state
            // ("Processing..." + spinner) that we reuse here — see
            // _global-adding-js-code.blade.php.
            window.eurobasWaitForImageUploads = function (callback) {
                if (pendingUploads <= 0) { callback(); return; }
                var check = setInterval(function () {
                    if (pendingUploads <= 0) {
                        clearInterval(check);
                        callback();
                    }
                }, 150);
            };

            // Sends the file to the server the moment it's chosen, instead of
            // waiting for form submit. On success the card switches to
            // referencing the already-processed filename (image_order becomes
            // "existing:<filename>") and drops its raw file input, so submit
            // time has nothing left to process for that image. On any failure
            // (network error, validation, etc.) the card is left completely
            // untouched — it still carries "new:<key>" and the raw file, which
            // build_ordered_ad_images() already knows how to process the old
            // way. Nothing breaks either way.
            function preUpload(card, orderInput, fileInput, file) {
                pendingUploads++;
                card.classList.add('is-uploading');
                var spinner = document.createElement('div');
                spinner.className = 'ad-image-card__spinner';
                spinner.innerHTML = '<div class="spinner-border" role="status"></div>';
                card.appendChild(spinner);

                var formData = new FormData();
                formData.append('image', file);

                fetch(uploadUrl, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: formData
                })
                    .then(function (res) { return res.json().catch(function () { return { success: false }; }); })
                    .then(function (data) {
                        if (data && data.success && data.filename) {
                            orderInput.value = 'existing:' + data.filename;
                            if (fileInput && fileInput.parentNode) fileInput.parentNode.removeChild(fileInput);
                        }
                        // On failure we simply leave the card as "new:<key>" with
                        // its raw file input intact — the normal submit-time path
                        // handles it exactly as it always has.
                    })
                    .catch(function () { /* offline/network error — same fallback as above */ })
                    .finally(function () {
                        pendingUploads--;
                        card.classList.remove('is-uploading');
                        if (spinner.parentNode) spinner.parentNode.removeChild(spinner);
                    });
            }

            function buildCard(key, dataUrl, file) {
                var card = document.createElement('div');
                card.className = 'ad-image-card';
                card.setAttribute('draggable', 'true');

                var order = document.createElement('input');
                order.type = 'hidden';
                order.name = 'image_order[]';
                order.value = 'new:' + key;
                card.appendChild(order);

                var badge = document.createElement('span');
                badge.className = 'ad-image-card__badge';
                badge.textContent = T.cardImage;
                card.appendChild(badge);

                var feature = document.createElement('button');
                feature.type = 'button';
                feature.className = 'ad-image-card__feature';
                feature.title = T.setAsCard;
                feature.setAttribute('aria-label', T.setAsCard);
                feature.innerHTML = '<i class="bi bi-star-fill"></i>';
                card.appendChild(feature);

                var remove = document.createElement('button');
                remove.type = 'button';
                remove.className = 'ad-image-card__remove';
                remove.title = T.remove;
                remove.setAttribute('aria-label', T.remove);
                remove.innerHTML = '<i class="bi bi-x-lg"></i>';
                card.appendChild(remove);

                var imgWrap = document.createElement('div');
                imgWrap.className = 'ad-image-card__img';
                var img = document.createElement('img');
                if (dataUrl) img.src = dataUrl;
                img.alt = '';
                imgWrap.appendChild(img);
                card.appendChild(imgWrap);

                // The real file input that gets submitted with the form.
                var fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.name = 'new_images[' + key + ']';
                fileInput.className = 'd-none ad-image-card__file';
                fileInput.accept = 'image/*';
                try {
                    var dt = new DataTransfer();
                    dt.items.add(file);
                    fileInput.files = dt.files;
                } catch (e) { /* DataTransfer unsupported – ignore */ }
                card.appendChild(fileInput);

                preUpload(card, order, fileInput, file);

                return card;
            }

            function addFiles(fileList) {
                var files = Array.prototype.slice.call(fileList || []);
                if (!files.length) return;

                for (var i = 0; i < files.length; i++) {
                    var ext = files[i].name.split('.').pop().toLowerCase();
                    if (allowed.indexOf(ext) === -1) {
                        if (window.toastr) toastr.error(T.invalidType);
                        return;
                    }
                    if (files[i].size > maxSize) {
                        if (window.toastr) toastr.error(T.tooLarge + ' ' + (maxSize / (1024 * 1024)) + ' ' + T.mb);
                        return;
                    }
                }

                var remaining = maxImages - cardCount();
                if (remaining <= 0) {
                    if (window.toastr) toastr.error(T.maxImages + ' ' + maxImages + ' ' + T.image);
                    return;
                }
                if (files.length > remaining) {
                    if (window.toastr) toastr.error(T.maxImages + ' ' + maxImages + ' ' + T.image);
                    files = files.slice(0, remaining);
                }

                // Append cards synchronously so their order always matches the
                // order the files were selected/dropped (the first one is the card
                // image). The async preview load must NOT decide ordering, otherwise
                // FileReader completion races could shuffle the images.
                files.forEach(function (file) {
                    var key = 'n' + (counter++);
                    var card = buildCard(key, '', file);
                    container.appendChild(card);

                    var img = card.querySelector('.ad-image-card__img img');
                    var reader = new FileReader();
                    reader.onload = function (e) { if (img) img.src = e.target.result; };
                    reader.readAsDataURL(file);
                });
                refresh();
            }

            // ---- Dropzone interactions ----
            dropzone.addEventListener('click', function (e) {
                // The file input lives inside the dropzone; ignore the click it
                // re-dispatches when we open it, otherwise we recurse infinitely.
                if (e.target === dropInput) return;
                dropInput.click();
            });
            dropzone.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); dropInput.click(); }
            });
            dropInput.addEventListener('change', function () {
                addFiles(dropInput.files);
                dropInput.value = '';
            });
            ['dragenter', 'dragover'].forEach(function (ev) {
                dropzone.addEventListener(ev, function (e) {
                    e.preventDefault();
                    dropzone.classList.add('dragover');
                });
            });
            ['dragleave', 'drop'].forEach(function (ev) {
                dropzone.addEventListener(ev, function (e) {
                    e.preventDefault();
                    dropzone.classList.remove('dragover');
                });
            });
            dropzone.addEventListener('drop', function (e) {
                if (e.dataTransfer && e.dataTransfer.files) addFiles(e.dataTransfer.files);
            });

            // ---- Card actions (remove / make cover) ----
            container.addEventListener('click', function (e) {
                var removeBtn = e.target.closest('.ad-image-card__remove');
                if (removeBtn) {
                    removeBtn.closest('.ad-image-card').remove();
                    refresh();
                    return;
                }
                var featureBtn = e.target.closest('.ad-image-card__feature');
                if (featureBtn) {
                    var card = featureBtn.closest('.ad-image-card');
                    container.insertBefore(card, container.firstElementChild);
                    refresh();
                }
            });

            // ---- Drag to reorder ----
            container.addEventListener('dragstart', function (e) {
                var card = e.target.closest('.ad-image-card');
                if (!card) return;
                dragSrc = card;
                card.classList.add('dragging');
                if (e.dataTransfer) e.dataTransfer.effectAllowed = 'move';
            });
            container.addEventListener('dragend', function () {
                if (dragSrc) dragSrc.classList.remove('dragging');
                dragSrc = null;
                refresh();
            });
            container.addEventListener('dragover', function (e) {
                if (!dragSrc) return;
                e.preventDefault();
                var after = getDragAfter(e.clientX, e.clientY);
                if (after == null) {
                    container.appendChild(dragSrc);
                } else if (after !== dragSrc) {
                    container.insertBefore(dragSrc, after);
                }
            });

            function getDragAfter(x, y) {
                var cards = Array.prototype.slice.call(
                    container.querySelectorAll('.ad-image-card:not(.dragging)')
                );
                var closest = { dist: Infinity, el: null };
                cards.forEach(function (card) {
                    var box = card.getBoundingClientRect();
                    var cx = box.left + box.width / 2;
                    var cy = box.top + box.height / 2;
                    // Only treat cards at/after the pointer as insert targets.
                    if (cy - y > -box.height / 2) {
                        var dist = Math.hypot(cx - x, cy - y);
                        if (dist < closest.dist) closest = { dist: dist, el: card };
                    }
                });
                return closest.el;
            }

            refresh();
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();
</script>
@endpush
