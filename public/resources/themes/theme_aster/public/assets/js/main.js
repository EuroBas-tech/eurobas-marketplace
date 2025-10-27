/*---------------------------------------------
	Template name:  6valley Grocery
	Version:        1.0
	Author:         6amtech
	Author url:     https://6amtech.com/

NOTE:
------
Please DO NOT EDIT THIS JS, you may need to use "custom.js" file for writing your custom js.
We may release future updates so it will overwrite this file. it's better and safer to use "custom.js".

[Table of Content]

    01: Main Menu
    02: Sticky Nav
    03: Mobile Menu
    04: Background Image
    05: Check Data
    06: Preloader
    07: currentYear
    08: Dark, Light & RTL Switcher
    09: Settings Toggle
    10: Menu Active Page
    11: File Upload
    12: Collapse
    13: togglePassword
    14: Countdown Timer
    15: Swiper
    16: PreventDefault
    17: Back to top button
    18: Increase/Decrease Product Quantity
      18.1: Increase
      18.2: Decrease
      18.3: show hide delete icon
    19: Changing svg color
    20: Quick View Product Slider
    21: Multi Range Slider
    22: Show Initial Modal
    23: Show Cookie Dialog
    24: Hide Top Offer Bar
    25: Handle Input Focus
    26: Product Details Content Collapse
    27: Show Hide Billing Address
    28: Search Dropdown
    29: List View Grid View Product
    30: OTP Verification
    31: Verify Counter
    32: Toggle Filter Options
    33: Toggle Billing Address
    34: Profile Menu Toggle
    35: On Scroll Element Hide
    36: Stop propagation
----------------------------------------------*/

(function ($) {
    "use strict";

    /*===================
    01: Main Menu
    =====================*/
    $('ul.nav li a[href="#"]').on("click", function (event) {
        event.preventDefault();
    });

    /* Parent li add class */
    $(".header .nav-wrapper, .aside .main-nav, .common-nav")
        .find(".sub-menu, .sub_menu")
        .parents("ul li")
        .addClass("has-sub-item");

    /* Submenu Opened */
    $(".aside .aside-body, .common-nav")
        .find(".has-sub-item > a, .has-sub-item > label")
        .on("click", function (event) {
            event.preventDefault();
            $(this).parent(".has-sub-item").toggleClass("sub-menu-opened");
            if ($(this).siblings("ul").hasClass("open")) {
                $(this).siblings("ul").removeClass("open").slideUp("200");
            } else {
                $(this).siblings("ul").addClass("open").slideDown("200");
            }
        });

    /*========================
    02: Sticky Nav
    ==========================*/
    // let headerH = $(".header").outerHeight(),
    //     headerM = $(".header-main.love-sticky");
    //
    // headerM.parent(".header").css({
    //     height: headerH + "px",
    // });

    $(window).on("scroll", function () {
        var scroll = $(window).scrollTop();

        if (scroll < 100) {
            $(".love-sticky").removeClass("sticky fadeInDown animated");
        } else {
            $(".love-sticky").addClass("sticky fadeInDown animated");
        }
    });

    /*========================
    03: Mobile Menu
    ==========================*/
    /* Toggle Menu */
    $(".menu-btn").on("click", function () {
        $(".aside").toggleClass("active");
        $(".filter-toggle-aside").removeClass("active");
    });
    $(".aside-close > i").on("click", function () {
        $(".aside").removeClass("active");
    });
    $(window).on("resize", function () {
        if ($(window).width() > 1199) {
            $(".aside").removeClass("active");
        }
    });

    /*========================
    04: Background Image
    ==========================*/
    var $bgImg = $("[data-bg-img]");
    $bgImg
        .css("background-image", function () {
            return 'url("' + $(this).data("bg-img") + '")';
        })
        .removeAttr("data-bg-img")
        .addClass("bg-img");

    /*==================================
    05: Check Data
    ====================================*/
    var checkData = function (data, value) {
        return typeof data === "undefined" ? value : data;
    };

    /*==================================
    06: Preloader
    ====================================*/
    // $(window).on("load", function () {
    //     $(".preloader").fadeOut(500);
    // });

    /*==================================
    07: currentYear
    ====================================*/
    var currentYear = new Date().getFullYear();
    $(".currentYear").html(currentYear);

    /*============================================
    08: Dark, Light & RTL Switcher
    ==============================================*/
    function themeSwitcher(className, themeName) {
        $(className).on("click", function () {
            $(".theme-bar button").removeClass("active");
            $(this).addClass("active");
            $("body").attr("theme", themeName);
            localStorage.setItem("theme", themeName);
        });
    }
    themeSwitcher(".light_button", "light");
    themeSwitcher(".dark_button", "dark");

    function rtlSwitcher(className, dirName) {
        $(className).on("click", function () {
            $(".dir-bar button").removeClass("active");
            $(this).addClass("active");
            $("html").attr("dir", dirName);
            localStorage.setItem("dir", dirName);
        });
    }
    rtlSwitcher(".ltr_button", "ltr");
    rtlSwitcher(".rtl_button", "rtl");

    $(window).on("load", function () {
        let themeName = localStorage.getItem("theme");
        $(".dir-bar button").removeClass("active");
        if (themeName == "dark") {
            $(".light_button").removeClass("active");
            $(".dark_button").addClass("active");
        } else {
            $(".dark_button").removeClass("active");
            $(".light_button").addClass("active");
        }
        $(".settings-sidebar .theme-bar").addClass("d-flex");
    });

    /*============================================
    09: Settings Toggle
    ==============================================*/
    $(document).ready(function () {
        $(document).on("click", ".settings-toggle-icon", function (e) {
            e.stopPropagation();
            $(".settings-sidebar").toggleClass("active");
        });
        $(document).on("click", "body", function (e) {
            if (!$(e.target).is(".settings-sidebar, .settings-sidebar *"))
                $(".settings-sidebar").removeClass("active");
        });
    });

    /*============================================
    10: Menu Active Page
    ==============================================*/
    var current = location.pathname;
    var $path = current.substring(current.lastIndexOf("/") + 1);
    $(".aside-body .nav li a").each(function (e) {
        var $this = $(this);
        if ($path == $this.attr("href")) {
            $this.parent("li").addClass("active open");
            $this
                .parent("li")
                .parent("ul")
                .parent("li")
                .addClass("active sub-menu-opened");
        } else if ($path == "") {
            $(".aside-body .nav li:first-child").addClass("active open");
        }
    });

    /* Active Menu Open */
    $(".aside .aside-body")
        .find(".sub-menu-opened a")
        .siblings("ul")
        .addClass("open")
        .show();

    /*============================================
    11: File Upload
    ==============================================*/
    $(window).on("load", function () {
        $(".upload-file__input").on("change", function () {
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                let img = $(this)
                    .siblings(".upload-file__img")
                    .find("img")
                    .removeAttr("hidden");
                $(this)
                    .siblings(".upload-file__img")
                    .find(".temp-img-box")
                    .remove();

                reader.onload = function (e) {
                    img.attr("src", e.target.result);
                };

                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    // Thumbnail Upload Handler
    $(window).on("load", function () {
        $("#thumbnail-input").on("change", function () {
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                let img = $(this)
                    .siblings(".upload-file__img")
                    .find("img")
                    .removeAttr("hidden");
                $(this)
                    .siblings(".upload-file__img")
                    .find(".temp-img-box")
                    .remove();

                reader.onload = function (e) {
                    img.attr("src", e.target.result);
                };

                reader.readAsDataURL(this.files[0]);
            }
        });
    });


    // Cover Image Upload Handler
    $(window).on("load", function () {
        $("#cover-input").on("change", function () {
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                let img = $(this)
                    .siblings(".upload-file__img")
                    .find("img")
                    .removeAttr("hidden");
                $(this)
                    .siblings(".upload-file__img")
                    .find(".temp-img-box")
                    .remove();

                reader.onload = function (e) {
                    img.attr("src", e.target.result);
                };

                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    /*==================================
    12: Collapse
    ====================================*/
    function collapse() {
        $(document.body).on("click", '[data-toggle="collapse"]', function (e) {
            e.preventDefault();
            var target = "#" + $(this).data("target");

            $(this).toggleClass("collapsed");
            $(target).slideToggle();
        });
    }
    collapse();

    /*==================================
    13: togglePassword
    ====================================*/
    $(window).on("load", function () {
        $(".togglePassword").on("click", function (e) {
            const password = $(this).siblings(".form-control");
            password.attr("type") === "password"
                ? $(this)
                      .addClass("bi-eye-fill")
                      .removeClass("bi-eye-slash-fill")
                : $(this)
                      .addClass("bi-eye-slash-fill")
                      .removeClass("bi-eye-fill");
            const type =
                password.attr("type") === "password" ? "text" : "password";
            password.attr("type", type);
        });
    });

    /*==================================
    14: Countdown Timer
    ====================================*/
    $("[data-date]").each(function (_, value) {
        let dataDate = $(value).data("date");

        function countdownTimer() {
            var endTime = new Date(dataDate || "2 Feb 2025");
            endTime = Date.parse(endTime) / 1000;

            var now = new Date();
            now = Date.parse(now) / 1000;

            var timeLeft = endTime - now;

            // Check if the countdown has ended
            if (timeLeft <= 0) {
                clearInterval(timer);
                return;
            }

            var days = Math.floor(timeLeft / 86400);
            var hours = Math.floor((timeLeft - days * 86400) / 3600);
            var minutes = Math.floor(
                (timeLeft - days * 86400 - hours * 3600) / 60
            );
            var seconds = Math.floor(
                timeLeft - days * 86400 - hours * 3600 - minutes * 60
            );

            if (days < 10) {
                days = "0" + days;
            }
            if (hours < 10) {
                hours = "0" + hours;
            }
            if (minutes < 10) {
                minutes = "0" + minutes;
            }
            if (seconds < 10) {
                seconds = "0" + seconds;
            }

            $(value)
                .find(".days")
                .html(
                    `<span class="countdown-count">${days}</span><span class="countdown-text">Days</span>`
                );
            $(value)
                .find(".hours")
                .html(
                    `<span class="countdown-count">${hours}</span><span class="countdown-text">Hours</span>`
                );
            $(value)
                .find(".minutes")
                .html(
                    `<span class="countdown-count">${minutes}</span><span class="countdown-text">Mins</span>`
                );
            $(value)
                .find(".seconds")
                .html(
                    `<span class="countdown-count">${seconds}</span><span class="countdown-text">Sec</span>`
                );
        }

        countdownTimer(); // Call the function immediately to avoid initial delay

        var timer = setInterval(countdownTimer, 1000);
    });


    /*==================================
    15: Swiper
    ====================================*/
    const swiper = new Swiper('.swiper', {
        slidesPerView: 3,       // Show 3 slides at once
        spaceBetween: 20,       // Space between slides
        slidesPerGroup: 1,      // Move one slide at a time
        loop: false,            // No looping
        navigation: false,      // No navigation arrows
        speed: 1200,
        autoplay: {
            delay: 10000,          // 6 seconds between each slide
            disableOnInteraction: false,  // Keep autoplay even after user interaction
            pauseOnMouseEnter: true, 
        },
    });
    
    /*==================================
    15: Secondary Swiper
    ====================================*/
    const secondarySwiper = new Swiper('.secondary-swiper', {
        slidesPerView: 2,       // Default for mobile
        spaceBetween: 20,       // Space between slides
        slidesPerGroup: 1,      // Move one slide at a time
        loop: true,            // Enable looping
        navigation: {
            prevEl: '.top-stores-nav-prev',
            nextEl: '.top-stores-nav-next',
        },
        speed: 1200,
        autoplay: {
            delay: 5000,          // 5 seconds between each slide
            disableOnInteraction: false,  // Keep autoplay even after user interaction
            pauseOnMouseEnter: true, 
        },
        // Responsive breakpoints
        breakpoints: {
            // When window width is >= 768px (md)
            600: {
                slidesPerView: 3,
            },
            768: {
                slidesPerView: 4,
            },
            // When window width is >= 992px (lg)
            992: {
                slidesPerView: 5,
            },
            // When window width is >= 1200px (xl/large)
            1200: {
                slidesPerView: 6,
            },
        },
    });

    /*==================================
    16: PreventDefault
    ====================================*/
    $(".preventDefault").on("click", function (e) {
        e.preventDefault();
    });

    /*============================================
    17: Back to top button
    ==============================================*/
    $(window).on("load", function () {
        var backToTopBtn = $(".back-to-top");
        var socialChatIcon = $(".social-chat-icons");

        $(window).on("scroll", function () {
            if ($(window).scrollTop() > 400) {
                backToTopBtn.addClass("show");
                socialChatIcon.addClass("active");
            } else {
                backToTopBtn.removeClass("show");
                socialChatIcon.removeClass("active");
            }
        });

        backToTopBtn.on("click", function (e) {
            e.preventDefault();
            $("html, body").stop().animate({ scrollTop: 0 }, 0);
            return false;
        });
    });

    /*==================================
    18: Increase/Decrease Product Quantity
    ====================================*/
    /* 18.1: Increase */
    // $('.quantity__plus').on('click', function () {
    //     var $qty = $(this).parent().find('input');
    //     var currentVal = parseInt($qty.val());
    //     if (!isNaN(currentVal)) {
    //         $qty.val(currentVal + 1);
    //     }
    //     if(currentVal >= $qty.attr('max') -1){
    //         $(this).attr('disabled', true);
    //     }
    //     quantityListener();
    // });
    //
    // /* 18.2: Decrease */
    // $('.quantity__minus').on('click', function () {
    //     var $qty = $(this).parent().find('input');
    //     var currentVal = parseInt($qty.val());
    //     if (!isNaN(currentVal) && currentVal > 1) {
    //         $qty.val(currentVal - 1);
    //     }
    //     if (currentVal < $qty.attr('max')) {
    //         $('.quantity__plus').removeAttr('disabled', true);
    //     }
    //     quantityListener();
    // });

    /* 18.3: show hide delete icon */
    // function quantityListener() {
    //     $('.quantity__qty').each(function () {
    //         var qty = $(this);
    //         if (qty.val() == 1) {
    //             qty.siblings('.quantity__minus').html('<i class="bi bi-trash3-fill text-danger fs-10"></i>')
    //         } else {
    //             qty.siblings('.quantity__minus').html('<i class="bi bi-dash"></i>')
    //         }
    //     });
    // }
    // quantityListener();

    /*==================================
    19: Changing svg color
    ====================================*/
    $("img.svg").each(function () {
        var $img = jQuery(this);
        var imgID = $img.attr("id");
        var imgClass = $img.attr("class");
        var imgURL = $img.attr("src");

        jQuery.get(
            imgURL,
            function (data) {
                // Get the SVG tag, ignore the rest
                var $svg = jQuery(data).find("svg");

                // Add replaced image's ID to the new SVG
                if (typeof imgID !== "undefined") {
                    $svg = $svg.attr("id", imgID);
                }
                // Add replaced image's classes to the new SVG
                if (typeof imgClass !== "undefined") {
                    $svg = $svg.attr("class", imgClass + " replaced-svg");
                }

                // Remove any invalid XML tags as per http://validator.w3.org
                $svg = $svg.removeAttr("xmlns:a");

                // Check if the viewport is set, else we gonna set it if we can.
                if (
                    !$svg.attr("viewBox") &&
                    $svg.attr("height") &&
                    $svg.attr("width")
                ) {
                    $svg.attr(
                        "viewBox",
                        "0 0 " + $svg.attr("height") + " " + $svg.attr("width")
                    );
                }

                // Replace image with new SVG
                $img.replaceWith($svg);
            },
            "xml"
        );
    });

    /*==================================
    20: Quick View Product Slider
    ====================================*/
    var quickviewSliderThumb = new Swiper(".quickviewSliderThumb", {
        spaceBetween: 10,
        slidesPerView: "auto",
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-quickview-button-next",
            prevEl: ".swiper-quickview-button-prev",
        },
    });
    var quickviewSlider = new Swiper(".quickviewSlider", {
        // spaceBetween: 10,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        thumbs: {
            swiper: quickviewSliderThumb,
        },
    });

    var quickviewSliderThumb = new Swiper(".similar-ads-swiper", {
        spaceBetween: 20,
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".top-rated-nav-next",
            prevEl: ".top-rated-nav-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            992: {
                slidesPerView: 3,
            },
            1200: {
                slidesPerView: 4,
            },
            1400: {
                slidesPerView: 5,
            },
        },
    });

    var quickviewSlider = new Swiper(".quickviewSlider", { 
        autoplay: { 
            delay: 5000, 
            disableOnInteraction: false, 
        }, 
        thumbs: { 
            swiper: quickviewSliderThumb, 
        }, 
    });

    // Product Quick View Modal
    var quickviewSliderThumb2 = new Swiper(".quickviewSliderThumb2", {
        spaceBetween: 10,
        slidesPerView: "auto",
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-quickview-button-next",
            prevEl: ".swiper-quickview-button-prev",
        },
    });


var quickviewSlider2 = new Swiper(".quickviewSlider2", {
    // spaceBetween: 10,
    autoplay: {
        delay: 23165422,
        disableOnInteraction: false,
    },
    speed: 500, // transition speed in ms (default is 300)
    thumbs: {
        swiper: quickviewSliderThumb2,
    },
});

// Global variable to track video state
let isVideoPlaying = false;
let videoCheckInterval = null;

// Stop autoplay function
function quickviewSlider2_stop() {
    quickviewSlider2.autoplay.stop();
}

// Start autoplay function
function quickviewSlider2_start() {
    if (!isVideoPlaying) {
        quickviewSlider2.autoplay.start();
    }
}

// Mouse hover controls
$(".quickviewSlider2").on("mouseenter", function () {
    quickviewSlider2_stop();
});

$(".quickviewSlider2").on("mouseleave", function () {
    quickviewSlider2_start();
});

// Function to check if video is playing
function checkVideoPlayState() {
    const activeSlide = quickviewSlider2.slides[quickviewSlider2.activeIndex];
    const iframe = activeSlide ? activeSlide.querySelector('iframe') : null;
    
    if (iframe) {
        // Method 1: Try to detect if iframe is focused/being interacted with
        const iframeFocused = document.activeElement === iframe;
        
        // Method 2: Check if user is hovering over the video area
        const iframeRect = iframe.getBoundingClientRect();
        const mouseOverVideo = (
            event.clientX >= iframeRect.left &&
            event.clientX <= iframeRect.right &&
            event.clientY >= iframeRect.top &&
            event.clientY <= iframeRect.bottom
        );
        
        return iframeFocused;
    }
    return false;
}

// Enhanced approach using multiple detection methods
$(document).ready(function() {
    
    // Method 1: Stop autoplay when slide changes to video slide
    quickviewSlider2.on('slideChange', function() {
        const activeSlide = quickviewSlider2.slides[quickviewSlider2.activeIndex];
        const hasVideo = activeSlide.querySelector('iframe');
        
        if (hasVideo) {
            quickviewSlider2_stop();
            isVideoPlaying = true;
            
            // Start monitoring for video end
            startVideoMonitoring();
        } else {
            isVideoPlaying = false;
            stopVideoMonitoring();
            quickviewSlider2_start();
        }
    });
    
    // Method 2: Monitor iframe interactions
    function setupVideoInteractionDetection() {
        $(document).on('click', '.quickviewSlider2 iframe', function() {
            isVideoPlaying = true;
            quickviewSlider2_stop();
            startVideoMonitoring();
        });
        
        // Detect when user clicks on video thumbnail to start video
        $(document).on('click', '.quickviewSlider2 .swiper-slide', function() {
            const iframe = $(this).find('iframe');
            if (iframe.length > 0) {
                setTimeout(function() {
                    isVideoPlaying = true;
                    quickviewSlider2_stop();
                    startVideoMonitoring();
                }, 500); // Small delay to allow video to start
            }
        });
    }
    
    // Method 3: Use postMessage API for Bunny.net
    function setupBunnyVideoAPI() {
        window.addEventListener('message', function(event) {
            if (event.origin.includes('mediadelivery.net') || event.origin.includes('bunnycdn')) {
                const data = event.data;
                
                if (typeof data === 'string') {
                    try {
                        const parsedData = JSON.parse(data);
                        handleVideoEvent(parsedData);
                    } catch (e) {
                        // Handle non-JSON messages
                        if (data.includes('play')) {
                            isVideoPlaying = true;
                            quickviewSlider2_stop();
                        } else if (data.includes('pause') || data.includes('end')) {
                            isVideoPlaying = false;
                            quickviewSlider2_start();
                        }
                    }
                } else if (typeof data === 'object') {
                    handleVideoEvent(data);
                }
            }
        });
    }
    
    function handleVideoEvent(data) {
        // Handle different possible event formats
        const eventType = data.event || data.type || data.action;
        
        if (eventType && (
            eventType.includes('play') || 
            eventType.includes('playing') ||
            eventType === 'start'
        )) {
            isVideoPlaying = true;
            quickviewSlider2_stop();
        } else if (eventType && (
            eventType.includes('end') ||
            eventType === 'finished'
        )) {
            // When video ends, restart it (infinite loop)
            const activeSlide = quickviewSlider2.slides[quickviewSlider2.activeIndex];
            const iframe = activeSlide ? activeSlide.querySelector('iframe') : null;
            
            if (iframe) {
                try {
                    // Restart the video
                    iframe.contentWindow.postMessage({
                        'event': 'play',
                        'currentTime': 0
                    }, '*');
                } catch (e) {
                    // Fallback: reload iframe src to restart
                    const currentSrc = iframe.src;
                    iframe.src = currentSrc;
                }
            }
            // Keep video playing state and slider stopped
            isVideoPlaying = true;
            quickviewSlider2_stop();
        }
    }
    
    // Method 4: Keyboard detection (spacebar for play/pause)
    $(document).on('keydown', function(e) {
        if (e.code === 'Space' || e.keyCode === 32) {
            const activeSlide = quickviewSlider2.slides[quickviewSlider2.activeIndex];
            const hasVideo = activeSlide && activeSlide.querySelector('iframe');
            
            if (hasVideo && document.activeElement.tagName === 'IFRAME') {
                // Toggle video state
                isVideoPlaying = !isVideoPlaying;
                if (isVideoPlaying) {
                    quickviewSlider2_stop();
                    startVideoMonitoring();
                } else {
                    quickviewSlider2_start();
                }
            }
        }
    });
    
    // Method 5: Time-based monitoring for video slides
    function startVideoMonitoring() {
        stopVideoMonitoring(); // Clear any existing interval
        
        videoCheckInterval = setInterval(function() {
            const activeSlide = quickviewSlider2.slides[quickviewSlider2.activeIndex];
            const hasVideo = activeSlide && activeSlide.querySelector('iframe');
            
            if (!hasVideo) {
                // No video in current slide, stop monitoring
                isVideoPlaying = false;
                stopVideoMonitoring();
                quickviewSlider2_start();
                return;
            }
            
            // Keep autoplay stopped while on video slide
            quickviewSlider2_stop();
            
        }, 1000); // Check every second
        
        // Auto-resume after 5 minutes (fallback)
        setTimeout(function() {
            if (isVideoPlaying) {
                isVideoPlaying = false;
                stopVideoMonitoring();
                quickviewSlider2_start();
            }
        }, 300000); // 5 minutes
    }
    
    function stopVideoMonitoring() {
        if (videoCheckInterval) {
            clearInterval(videoCheckInterval);
            videoCheckInterval = null;
        }
    }
    
    // Method 6: Visual focus detection
    function setupFocusDetection() {
        $(document).on('focusin', '.quickviewSlider2 iframe', function() {
            isVideoPlaying = true;
            quickviewSlider2_stop();
            startVideoMonitoring();
        });
        
        $(document).on('focusout', '.quickviewSlider2 iframe', function() {
            // Delay to check if focus moved to another element
            setTimeout(function() {
                if (!$('.quickviewSlider2 iframe').is(':focus')) {
                    isVideoPlaying = false;
                    quickviewSlider2_start();
                    stopVideoMonitoring();
                }
            }, 100);
        });
    }
    
    // Initialize all detection methods
    setupVideoInteractionDetection();
    setupBunnyVideoAPI();
    setupFocusDetection();
    
    // Send initialization message to all video iframes
    setTimeout(function() {
        $('.quickviewSlider2 iframe').each(function() {
            if (this.contentWindow) {
                try {
                    this.contentWindow.postMessage({
                        'event': 'listening',
                        'data': 'init'
                    }, '*');
                } catch (e) {
                    console.log('Could not send message to iframe');
                }
            }
        });
    }, 2000);
});

// Manual controls for external use
window.forceStopSlider = function() {
    isVideoPlaying = true;
    quickviewSlider2_stop();
};

window.forceStartSlider = function() {
    isVideoPlaying = false;
    quickviewSlider2_start();
};




    $(".quickviewSliderThumb2").on("mouseenter", function () {
        quickviewSlider2_stop();
    });
    $(".quickviewSliderThumb2").on("mouseleave", function () {
        quickviewSlider2_start();
    });

    function quickviewSlider2_stop(){
        quickviewSlider2.autoplay.stop();
        quickviewSliderThumb2.autoplay.stop();
    }

    function quickviewSlider2_start(){
        quickviewSlider2.autoplay.start();
        quickviewSliderThumb2.autoplay.start();
    }

    /*==================================
    21: Multi Range Slider
    ====================================*/
    $(document).ready(function () {
        var rangeOne = $('input[name="rangeOne"]'),
            rangeTwo = $('input[name="rangeTwo"]'),
            outputOne = $("#min_price"),
            outputTwo = $("#max_price"),
            inclRange = $(".incl-range"),
            updateView = function () {
                if ($(this).attr("name") === "rangeOne") {
                    outputOne.val($(this).val());
                } else {
                    outputTwo.val($(this).val());
                }
                if (parseInt(rangeOne.val()) > parseInt(rangeTwo.val())) {
                    inclRange.css({
                        "inline-size":
                            ((rangeOne.val() - rangeTwo.val()) /
                                $(this).attr("max")) *
                                100 +
                            "%",
                        "inset-inline-start":
                            (rangeTwo.val() / $(this).attr("max")) * 100 + "%",
                    });
                } else {
                    inclRange.css({
                        "inline-size":
                            ((rangeTwo.val() - rangeOne.val()) /
                                $(this).attr("max")) *
                                100 +
                            "%",
                        "inset-inline-start":
                            (rangeOne.val() / $(this).attr("max")) * 100 + "%",
                    });
                }
            };

        updateView.call(rangeOne);
        updateView.call(rangeTwo);

        $('input[type="range"]').on({
            mouseup: function () {
                $(this).blur();
            },
            "mousedown input": function () {
                updateView.call(this);
            },
        });
    });

    /*==================================
    22: Show Initial Modal
    ====================================*/
    // $(window).on('load', function () {
    //   setTimeout(function () {
    //       $('#initialModal').modal('show');
    //   }, 1000);
    // });

    /*==================================
    23: Show Cookie Dialog
    ====================================*/
    $(".cookies").on("click", ".btn", function (e) {
        e.preventDefault();
        $(this).parents(".cookies").removeClass("active");
    });

    //Temp
    $(".cookies").removeClass("active");

    /*==================================
    24: Hide Top Offer Bar
    ====================================*/
    $(".offer-bar-close").on("click", function (e) {
        $(this).parents(".offer-bar").slideUp("fast");
    });

    /*==================================
    25: Handle Input Focus
    ====================================*/
    $(".focus-input").on("focus", function () {
        $(this).parents(".focus-border").addClass("border-dark");
    });
    $(".focus-input").on("blur", function () {
        $(this).parents(".focus-border").removeClass("border-dark");
    });

    /*==================================
    26: Product Details Content Collapse
    ====================================*/
    $(".see-more-details").on("click", function () {
        $(this)
            .parent()
            .siblings(".details-content-wrap")
            .toggleClass("custom-height active");
        $(this)
            .parent()
            .siblings(".details-content-wrap")
            .hasClass("custom-height")
            ? $(this).html($("#all-msg-container").data("seemore"))
            : $(this).html($("#all-msg-container").data("afterextend"));
    });

    /*==================================
    27: Show Hide Billing Address
    ====================================*/
    $(".billing-address-checkbox").on("change", function () {
        if ($(this).prop("checked")) {
            $(".toggle-billing-address").slideUp();
            $(".save-billing-address").hide();
        } else {
            $(".toggle-billing-address").slideDown();
            $(".save-billing-address").show();
        }
    });

    /*==================================
    28: Search Dropdown
    ====================================*/
    $(".search_dropdown ul li a").on("click", function () {
        let selectedText = $(this).text().trim();
        let selectId = $(this).data("value");
        $(this).parents(".search_dropdown").find("button").text(selectedText);
        $("#search_category_value").val(selectId);
    });

    /*==================================
    29: List View Grid View Product
    ====================================*/
    $(document).ready(function () {
        $(".product-view-option input[name=product_view]").on(
            "change",
            function () {
                if ($(this).val() === "list-view") {
                    $("#filtered-products").addClass("product-list-view").find('[class^="col-"]').removeClass('col-xxl-2 col-xl-3 col-md-4 col-sm-6').addClass('col-xl-4 col-md-6');
                } else {
                    $("#filtered-products").removeClass("product-list-view").find('[class^="col-"]').removeClass('col-xl-4 col-md-6').addClass('col-xxl-2 col-xl-3 col-md-4 col-sm-6');
                }
            }
        );
    });

    /*==================================
    30: OTP Verification
    ====================================*/
    $(document).ready(function () {
        $(".otp-form button[type=submit]").attr("disabled", true);
        $(".otp-form *:input[type!=hidden]:first").focus();
        let otp_fields = $(".otp-form .otp-field"),
            otp_value_field = $(".otp-form .otp-value");
        otp_fields
            .on("input", function (e) {
                $(this).val(
                    $(this)
                        .val()
                        .replace(/[^0-9]/g, "")
                );
                let otp_value = "";
                otp_fields.each(function () {
                    let field_value = $(this).val();
                    if (field_value != "") otp_value += field_value;
                });
                otp_value_field.val(otp_value);
                // Check if all input fields are filled
                if (otp_value.length === 4) {
                    $(".otp-form button[type=submit]").attr("disabled", false);
                } else {
                    $(".otp-form button[type=submit]").attr("disabled", true);
                }
            })
            .on("keyup", function (e) {
                let key = e.keyCode || e.charCode;
                if (key == 8 || key == 46 || key == 37 || key == 40) {
                    // Backspace or Delete or Left Arrow or Down Arrow
                    $(this).prev().focus();
                } else if (key == 38 || key == 39 || $(this).val() != "") {
                    // Right Arrow or Top Arrow or Value not empty
                    $(this).next().focus();
                }
            })
            .on("paste", function (e) {
                let paste_data = e.originalEvent.clipboardData.getData("text");
                let paste_data_splitted = paste_data.split("");
                $.each(paste_data_splitted, function (index, value) {
                    otp_fields.eq(index).val(value);
                });
            });
    });

    /*==================================
     31: Verify Counter
     ====================================*/
    function countdown() {
        var counter = $(".verifyCounter");
        var seconds = counter.data("second");
        function tick() {
            var m = Math.floor(seconds / 60);
            var s = seconds % 60;
            seconds--;
            counter.html(m + ":" + (s < 10 ? "0" : "") + String(s));
            if (seconds > 0) {
                setTimeout(tick, 1000);
                $(".resend-otp-button").attr("disabled", true);
                $(".resend_otp_custom").slideDown();
            } else {
                $(".resend-otp-button").removeAttr("disabled");
                $(".verifyCounter").html("0:00");
                $(".resend_otp_custom").slideUp();
            }
        }
        tick();
    }
    countdown();

    /*==================================
    32: Toggle Filter Options
    ====================================*/
    $(".toggle-filter").on("click", function () {
        $(".filter-toggle-aside").toggleClass("active");
        $(".aside").removeClass("active");
        $(".filter-toggle-aside .card-body").toggleClass("custom-scrollbar");
    });
    $(".filter-aside-close").on("click", function () {
        $(".filter-toggle-aside").removeClass("active");
        $(".filter-toggle-aside .card-body").removeClass("custom-scrollbar");
    });

    /*==================================
    33: Toggle Shipping Address
    ====================================*/
    $(".toggle-shipping-saved-addresses").on("click", function () {
        $(".shipping-saved-addresses").slideToggle("slow");
        $(this).toggleClass("arrow-up");
    });

    /*==================================
    33: Toggle Billing Address
    ====================================*/
    $(".toggle-billing-saved-addresses").on("click", function () {
        $(".billing-saved-addresses").slideToggle("slow");
        $(this).toggleClass("arrow-up");
    });

    /*==================================
    34: Profile Menu Toggle
    ====================================*/
    $(".profile-menu-toggle").on("click", function () {
        $(".profile-menu-aside").toggleClass("active");
    });
    $(".profile-menu-aside-close").on("click", function () {
        $(".profile-menu-aside").removeClass("active");
    });
    
    $(".filter-menu-toggle").on("click", function () {
        $(".filter-toggle-aside").toggleClass("active");
    });
    
    $(".profile-menu-aside-close").on("click", function () {
        $(".filter-toggle-aside").removeClass("active");
    });

    /*==================================
    35: On Scroll Element Hide
    ====================================*/
    var element = $(".social-chat-icons, .back-to-top");
    $(window).on("scroll", function () {
        if ($(window).width() < 768) {
            element.hide();

            clearTimeout($.data(this, "scrollTimer"));
            $.data(
                this,
                "scrollTimer",
                setTimeout(function () {
                    element.show();
                }, 250)
            );
        }
    });

    /*==================================
    36: Stop propagation
    ====================================*/
    $(".stopPropagation").on("click", function (e) {
        e.stopPropagation();
    });
})(jQuery);
