{{--
    Centralised, lazy reCAPTCHA loader for the login / register popups.

    Rendering reCAPTCHA v2 widgets on page load creates heavy iframes. When several
    of them exist on a single page (the login + register popups are injected into
    every non-auth page, e.g. the home page) mobile Safari's content process can run
    out of memory and crash the tab ("A problem repeatedly occurred" / "Web Page
    Crashed"). To avoid that we:
      • never load Google's api.js or render any widget on page load,
      • load api.js exactly once, the first time a captcha-bearing popup is opened,
      • render each widget only when its own popup is shown, and only once.

    The popup submit handlers keep reading the rendered widget id from the
    data-login-id / data-reg-id attributes, so their validation is unchanged.
--}}
@if(recaptcha_enabled())
    @push('script')
    <script>
        (function () {
            var SITE_KEY = '{{ \App\CPU\Helpers::get_business_settings('recaptcha')['site_key'] }}';

            // container id -> data attribute the submit handler reads back
            var WIDGETS = {
                'recaptcha_element_customer_login': 'data-login-id',
                'recaptcha_element_customer_regi':  'data-reg-id'
            };
            // popup id -> its captcha container id
            var MODAL_TO_WIDGET = {
                'loginModal':    'recaptcha_element_customer_login',
                'registerModal': 'recaptcha_element_customer_regi'
            };

            var apiRequested = false;   // api.js injected?
            var apiReady     = false;   // api.js finished loading?
            var rendered     = {};      // containerId -> true once rendered
            var queue        = [];      // containerIds waiting for api.js

            // Called by Google's api.js once it has loaded.
            window.onEurobasRecaptchaLoad = function () {
                apiReady = true;
                queue.forEach(renderWidget);
                queue = [];
            };

            function loadApi() {
                if (apiRequested) return;
                apiRequested = true;
                var s = document.createElement('script');
                s.src = 'https://www.google.com/recaptcha/api.js?onload=onEurobasRecaptchaLoad&render=explicit&hl=en';
                s.async = true;
                s.defer = true;
                document.head.appendChild(s);
            }

            function renderWidget(containerId) {
                if (rendered[containerId]) return;
                var el = document.getElementById(containerId);
                if (!el || typeof grecaptcha === 'undefined' || !grecaptcha.render) return;
                if (el.childElementCount > 0) { rendered[containerId] = true; return; }
                var id = grecaptcha.render(containerId, { 'sitekey': SITE_KEY });
                el.setAttribute(WIDGETS[containerId], id);
                rendered[containerId] = true;
            }

            // Ensure the widget for a popup is loaded + rendered.
            function ensure(containerId) {
                if (!containerId || !document.getElementById(containerId)) return;
                loadApi();
                if (apiReady) {
                    renderWidget(containerId);
                } else if (queue.indexOf(containerId) === -1) {
                    queue.push(containerId);
                }
            }

            // Wire each popup's "show" event (Bootstrap 5 dispatches native events).
            Object.keys(MODAL_TO_WIDGET).forEach(function (modalId) {
                var m = document.getElementById(modalId);
                if (!m) return;
                m.addEventListener('show.bs.modal', function () {
                    ensure(MODAL_TO_WIDGET[modalId]);
                });
            });
        })();
    </script>
    @endpush
@endif
