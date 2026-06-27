{{--
    Shared colour picker (used by Add and Edit listing pages).
    Replaces the old <select> dropdown with clickable colour swatches.

    Submits the chosen value through a hidden input named "color"
    (same field name the controller already expects).

    Optional variable:
        $selectedColor  the currently selected colour value
--}}
@php
    $colors = [
        'black', 'white', 'silver', 'gray', 'blue', 'red', 'brown', 'beige',
        'green', 'orange', 'yellow', 'gold', 'purple', 'pink', 'turquoise',
        'darkred', 'navy', 'peru', 'olive', 'multicolor/custom'
    ];
    $selectedColor = $selectedColor ?? old('color');
@endphp

<label class="d-block mb-2">{{ translate('color') }}</label>
<input type="hidden" name="color" id="color-input" value="{{ $selectedColor }}">

<div class="color-swatches" id="color-swatches" role="listbox" aria-label="{{ translate('color') }}">
    @foreach ($colors as $color)
        <button type="button"
                class="color-swatch {{ $selectedColor === $color ? 'is-selected' : '' }}"
                data-color="{{ $color }}"
                role="option"
                aria-selected="{{ $selectedColor === $color ? 'true' : 'false' }}"
                title="{{ translate($color) }}">
            <span class="color-swatch__dot"
                  @if($color === 'multicolor/custom')
                      style="background: conic-gradient(#e53935, #fb8c00, #fdd835, #43a047, #1e88e5, #5e35b1, #e53935);"
                  @else
                      style="background: {{ $color }};"
                  @endif></span>
            <span class="color-swatch__label">{{ translate($color) }}</span>
        </button>
    @endforeach
</div>

@push('css_or_js')
<style>
    .color-swatches {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .color-swatch {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px 6px 8px;
        border: 1px solid #d4dcec;
        border-radius: 30px;
        background: #fff;
        cursor: pointer;
        font-size: .88rem;
        color: #1f2937;
        transition: border-color .15s ease, box-shadow .15s ease;
    }
    .color-swatch:hover { border-color: #2c6ecb; }
    .color-swatch.is-selected {
        border-color: #2c6ecb;
        box-shadow: 0 0 0 2px rgba(44, 110, 203, .25);
        font-weight: 600;
    }
    .color-swatch__dot {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 1px solid rgba(0, 0, 0, .15);
        display: inline-block;
        flex: 0 0 auto;
    }
    .color-swatch__label { text-transform: capitalize; white-space: nowrap; }
</style>
@endpush

@push('script')
<script>
    (function () {
        function init() {
            var wrap = document.getElementById('color-swatches');
            var input = document.getElementById('color-input');
            if (!wrap || !input) return;

            wrap.addEventListener('click', function (e) {
                var btn = e.target.closest('.color-swatch');
                if (!btn) return;

                wrap.querySelectorAll('.color-swatch').forEach(function (el) {
                    el.classList.remove('is-selected');
                    el.setAttribute('aria-selected', 'false');
                });

                btn.classList.add('is-selected');
                btn.setAttribute('aria-selected', 'true');
                input.value = btn.dataset.color;
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();
</script>
@endpush
