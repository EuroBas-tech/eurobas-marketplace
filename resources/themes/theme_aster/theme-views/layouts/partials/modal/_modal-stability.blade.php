{{-- Milestone 1: Mobile modal stability fix --}}
{{-- Resolves popup flickering / disappearing content on mobile (iPhone, Android, tablet) --}}
{{-- for the RETAINED quick-action popups (Add to Favourites, Contact Seller, etc.). --}}
<style>
    /* Reduce repaint flicker on low-end / mobile GPUs */
    .modal-dialog {
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
        will-change: transform;
    }
    /* Smooth, non-jittery scrolling inside scrollable modals on iOS */
    .modal {
        -webkit-overflow-scrolling: touch;
    }
    /* A single, stable backdrop — prevents the progressive darkening flicker
       caused by stacked backdrops when a popup is opened repeatedly */
    .modal-backdrop + .modal-backdrop {
        display: none !important;
    }
    @media (max-width: 991.98px) {
        /* Keep popups centred and fully visible when the on-screen keyboard
           resizes the viewport (the main cause of "disappearing content") */
        .modal.fade .modal-dialog {
            transition: transform .15s ease-out, opacity .15s ease-out;
        }
        .modal-dialog-centered {
            min-height: calc(100% - 1rem);
        }
        /* Avoid the horizontal jump from scrollbar-width compensation on mobile */
        body.modal-open {
            padding-right: 0 !important;
        }
    }
</style>
<script>
    (function () {
        if (window.__eurobasModalStability) return;
        window.__eurobasModalStability = true;

        document.addEventListener('hidden.bs.modal', function () {
            // If no modal remains open, scrub any orphaned backdrop / body state
            // that Bootstrap occasionally leaves behind on mobile (the flicker/freeze bug).
            if (!document.querySelector('.modal.show')) {
                document.querySelectorAll('.modal-backdrop').forEach(function (el) { el.remove(); });
                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('overflow');
                document.body.style.removeProperty('padding-right');
            }
        });

        // Collapse duplicate backdrops the instant a modal opens.
        document.addEventListener('shown.bs.modal', function () {
            var backdrops = document.querySelectorAll('.modal-backdrop');
            for (var i = 0; i < backdrops.length - 1; i++) {
                backdrops[i].remove();
            }
        });
    })();
</script>
