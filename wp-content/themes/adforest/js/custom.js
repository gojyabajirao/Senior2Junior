/*
 Template: AdForest | Largest Classifieds Portal
 Author: ScriptsBundle
 Version: 1.0
 Designed and Development by: ScriptsBundle
 */
/*
 ====================================
 [ CSS TABLE CONTENT ]
 ------------------------------------
 1.0 -  Page Preloader
 2.0 -  Counter FunFacts
 3.0 -  List Grid Style Switcher
 4.0 -  Sticky Ads
 5.0 -  Accordion Panels
 6.0 -  Accordion Style 2
 7.0 -  Jquery CheckBoxes
 8.0 -  Jquery Select Dropdowns
 9.0 -  Profile Image Upload
 10.0 - Masonry Grid System
 11.0 - Featured Carousel 1
 12.0 - Featured Carousel 2
 12.0 - Featured Carousel 3
 13.0 - Category Carousel
 14.0 - Background Image Rotator Carousel
 15.0 - Single Ad Slider Carousel
 16.0 - Single Page SLider With Thumb
 17.0 - Price Range Slider
 18.0 - Template MegaMenu
 19.0 - Back To Top
 20.0 - Tooltip
 21.0 - Quick Overview Modal
 -------------------------------------
 [ END JQUERY TABLE CONTENT ]
 =====================================
 */

var adforest_is_rtl = jQuery('#is_rtl').val();
var slider_rtl = false;
if (adforest_is_rtl != 'undefined' && adforest_is_rtl == '1') {
    slider_rtl = true;
}
var header_style_val = jQuery('#sb_header_type').val();
var is_menu_display = jQuery('#is_menu_display').val();
var scroll_height = 0;
if (typeof header_style_val !== 'undefined' && header_style_val == 'modern4') {
    scroll_height = 200;
}

(function ($) {
    "use strict";
    var adforest_ajax_url = $('#adforest_ajax_url').val();
    $('.top-loc-selection').on('click', function () {
        var loc_id = $(this).attr("data-loc-id");
        $('#sb_loading').show();
        jQuery.post(jQuery('#adforest_ajax_url').val(), {action: 'sb_set_site_location', location_id: loc_id}).done(function (response)
        {
            $('#sb_loading').hide();
            if (typeof response !== undefined && response == 1) {
                window.location.reload();
            } else {
                alert(get_strings.adforest_location_error);
            }
        });
        return false;
    });

    if (header_style_val !== 'undefined' && (header_style_val == 'transparent-2' || header_style_val == 'transparent-3' || header_style_val == 'modern') && $('#sb_is_homepage').val() !== "1") {
        $(".sb-modern-header .sb-colors-combination-c1 .sb-colored-header .mega-menu").css("position", "relative");
        $(".sb-transparent2-header .sb-top-header-3 .sb-top-header .mega-menu.menu-2").css("position", "relative");
        $(".sb-transparent3-header .sb-srvs-top-header .sb-top-header-3 .sb-top-header .mega-menu").css("position", "relative");
    }





//    console.log(jQuery.error = console.error);
//    console.log(jQuery.fancybox.version);
    var adlocation_words = $("#word-count").text().length;
    if (adlocation_words < 35)
    {
        $('.country-locations').addClass('single-line');
    }

    var ua = navigator.userAgent.toLowerCase();
    if (ua.indexOf("safari/") !== -1 && // It says it's Safari
            ua.indexOf("windows") !== -1 && // It says it's on Windows
            ua.indexOf("chrom") === -1     // It DOESN'T say it's Chrome/Chromium
            ) {
        $('.sb-top-bar_notification').show();
    }
    /* ======= Preloader ======= */
    setTimeout(function () {
        $('body').addClass('loaded');
    }, 3000);
    /* ======= Counter FunFacts ======= */
    var timer = $('.timer');
    if (timer.length) {
        timer.appear(function () {
            timer.countTo();
        });
    }
    /* ======= List Grid Style Switcher ======= */
    $('#list').on("click", function (event) {
        event.preventDefault();
        $(this).addClass('active');
        $('#grid').removeClass('active');
        $('#products .item').addClass('list-group-items');
    });
    $('#grid').on("click", function (event) {
        event.preventDefault();
        $(this).addClass('active');
        $('#list').removeClass('active');
        $('#products .item').removeClass('list-group-items');
        $('#products .item').addClass('grid-group-item');
    });
    /* ======= Sticky Ads ======= */
    $('.leftbar-stick, .rightbar-stick').theiaStickySidebar({
        additionalMarginTop: 80
    });
    /* ======= Accordion Panels ======= */
    $('.accordion-title a').on('click', function (event) {
        event.preventDefault();
        if ($(this).parents('li').hasClass('open')) {
            $(this).parents('li').removeClass('open').find('.accordion-content').slideUp(400);
        } else {
            $(this).parents('.accordion').find('.accordion-content').not($(this).parents('li').find('.accordion-content')).slideUp(400);
            $(this).parents('.accordion').find('> li').not($(this).parents('li')).removeClass('open');
            $(this).parents('li').addClass('open').find('.accordion-content').slideDown(400);
        }
    });

    /* ======= Accordion Style 2 ======= */
    $('#accordion').on('shown.bs.collapse', function () {
        var offset = $('.panel.panel-default > .panel-collapse.in').offset();
        if (offset) {
            $('html,body').animate({
                scrollTop: $('.panel-title a').offset().top - 20
            }, 500);
        }
    });

    /* ======= Jquery CheckBoxes ======= */
    $('.skin-minimal .list li input').iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal',
        increaseArea: '20%' // optional
    });
    $('.checkbox-wrap input').iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal',
        increaseArea: '20%' // optional
    });

    var get_sticky = $('#is_sticky_header').val();
    var is_sticky = false;
    if (get_sticky != "" && get_sticky == "1")
    {
        var is_sticky = true;
    }
    if ($('#is_rtl').val() != "" && $('#is_rtl').val() == "1")
    {
        /* ======= Masonry Grid System ======= */
        $('.posts-masonry').imagesLoaded(function () {
            $('.posts-masonry').isotope({
                layoutMode: 'masonry',
                transitionDuration: '0.3s',
                isOriginLeft: false,
            });
        });

        /* ======= Template MegaMenu  ======= */


        if (typeof is_menu_display !== 'undefined' && is_menu_display == 'yes') {
            $('#menu-1').megaMenu({
                // DESKTOP MODE SETTINGS
                logo_align: 'left', // align the logo left or right. options (left) or (right)
                links_align: 'left', // align the links left or right. options (left) or (right)
                socialBar_align: 'right', // align the socialBar left or right. options (left) or (right)
                searchBar_align: 'left', // align the search bar left or right. options (left) or (right)
                trigger: 'hover', // show drop down using click or hover. options (hover) or (click)
                effect: 'expand-top', // drop down effects. options (fade), (scale), (expand-top), (expand-bottom), (expand-left), (expand-right)
                effect_speed: 400, // drop down show speed in milliseconds
                sibling: true, // hide the others showing drop downs if this option true. this option works on if the trigger option is "click". options (true) or (false)
                outside_click_close: true, // hide the showing drop downs when user click outside the menu. this option works if the trigger option is "click". options (true) or (false)
                top_fixed: false, // fixed the menu top of the screen. options (true) or (false)
                sticky_header: is_sticky, // menu fixed on top when scroll down down. options (true) or (false)
                sticky_header_height: scroll_height, // sticky header height top of the screen. activate sticky header when meet the height. option change the height in px value.
                menu_position: 'horizontal', // change the menu position. options (horizontal), (vertical-left) or (vertical-right)
                full_width: false, // make menu full width. options (true) or (false)
                // MOBILE MODE SETTINGS
                mobile_settings: {
                    collapse: true, // collapse the menu on click. options (true) or (false)
                    sibling: true, // hide the others showing drop downs when click on current drop down. options (true) or (false)
                    scrollBar: true, // enable the scroll bar. options (true) or (false)
                    scrollBar_height: 400, // scroll bar height in px value. this option works if the scrollBar option true.
                    top_fixed: false, // fixed menu top of the screen. options (true) or (false)
                    sticky_header: false, // menu fixed on top when scroll down down. options (true) or (false)
                    sticky_header_height: 0 // sticky header height top of the screen. activate sticky header when meet the height. option change the height in px value.
                }
            });
        }





        /* ======= Jquery Select Dropdowns ======= */
        $("select").select2({
            dir: "rtl",
            placeholder: $('#select_place_holder').val(),
            allowClear: true,
            width: '100%'
        });

        $('.remove_select2').select2('destroy');

        /* ======= Featured Carousel 1 ======= */
        $('.featured-slider').owlCarousel({
            rtl: true,
            dots: false,
            loop: ($(".featured-slider .item").length > 1) ? true : false,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: parseInt($('#auto_slide_time').val()),
            margin: -10,
            responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
            navText: ["<i class='fa fa-angle-right'></i>", "<i class='fa fa-angle-left'></i>"],
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: true
                },
                1000: {
                    items: $('#slider_item').val(),
                    nav: true,
                    loop: ($(".featured-slider .item").length > 1) ? true : false,
                }
            }
        });

        /* ======= Featured Carousel 2 ======= */
        $('.featured-slider-1').owlCarousel({
            rtl: true,
            dots: ($(".featured-slider-1 .item").length > 1) ? false : false,
            loop: ($(".featured-slider-1 .item").length > 1) ? false : false,
            autoplay: true,
            autoplayHoverPause: true,
            margin: -10,
            responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
            navText: ["<i class='fa fa-angle-right'></i>", "<i class='fa fa-angle-left'></i>"],
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: true
                },
                1000: {
                    items: $('#slider_item').val(),
                    nav: true,
                    loop: ($(".featured-slider-1 .item").length > 4) ? true : false,
                }
            }
        });

        /* ======= Featured Carousel 2 ======= */
        $('.featured-slider-5').owlCarousel({
            rtl: true,
            dots: ($(".featured-slider-5 .item").length > 1) ? false : false,
            loop: ($(".featured-slider-5 .item").length > 1) ? false : false,
            autoplay: true,
            autoplayHoverPause: true,
            margin: -10,
            responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
            navText: ["<i class='fa fa-angle-right'></i>", "<i class='fa fa-angle-left'></i>"],
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: true
                },
                1000: {
                    items: 3,
                    nav: true,
                    loop: ($(".featured-slider-5 .item").length > 1) ? false : false,
                }
            }
        });

        /* ======= Featured  Carousel 3 ======= */
        $('.featured-slider-3').owlCarousel({
            rtl: true,
            dots: ($(".featured-slider-3 .item").length > 1) ? false : false,
            loop: ($(".featured-slider-3 .item").length > 1) ? true : false,
            autoplay: true,
            autoplayHoverPause: true,
            margin: 0,
            responsiveClass: true,
            navText: ["<i class='fa fa-angle-right'></i>", "<i class='fa fa-angle-left'></i>"],
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: true
                },
                1000: {
                    items: 1,
                    nav: true,
                    loop: ($(".featured-slider-3 .item").length > 1) ? true : false,
                }
            }
        });

        /* ======= Category Carousel ======= */
        $('.category-slider').owlCarousel({
            loop: true,
            rtl: true,
            dots: false,
            autoplay: true,
            autoplayHoverPause: true,
            margin: 0,
            responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
            navText: ["<i class='fa fa-angle-right'></i>", "<i class='fa fa-angle-left'></i>"],
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: true
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: true
                }
            }
        });

        /* ======= Background Image Rotator Carousel ======= */
        $('.background-rotator-slider').owlCarousel({
            loop: false,
            rtl: true,
            dots: false,
            margin: 0,
            autoplay: true,
            autoplayHoverPause: true,
            mouseDrag: true,
            touchDrag: true,
            responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
            nav: false,
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 1,
                },
                1000: {
                    items: 1,
                }
            }
        });

        /* ======= إعلان واحد Slider Carousel  ======= */
        $('.single-details').owlCarousel({
            dots: ($(".single-details .item").length > 1) ? false : false,
            loop: ($(".single-details .item").length > 1) ? false : false,
            rtl: true,
            margin: 0,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: parseInt($('#auto_slide_time').val()),
            mouseDrag: true,
            touchDrag: true,
            responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
            nav: true,
            navText: ["<i class='fa fa-angle-right'></i>", "<i class='fa fa-angle-left'></i>"],
            responsive: {
                0: {items: 1, },
                600: {items: 1, },
                1000: {items: 1, }
            }
        });

        $('.abcd').owlCarousel({
            margin: 10,
            responsive: {
                0: {items: 1},
                600: {items: 3},
                1000: {items: 5}
            }
        });
        $('.success-stories-21').owlCarousel({
            loop: true,
            margin: 10,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            nav: true,
            autoplay: true,
            responsive: {
                0: {items: 1},
                600: {items: 3, },
                1000: {items: 1, }
            }
        });

        /*==========  Single Page SLider With Thumb ==========*/
        $('#carousels').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 110,
            itemMargin: 50,
            rtl: true,
            asNavFor: '.single-page-slider'
        });
        $('.single-page-slider').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: true,
            rtl: true,
            sync: "#carousel"
        });
    } else
    {
        /* ======= Masonry Grid System ======= */
        $('.posts-masonry').imagesLoaded(function () {
            $('.posts-masonry').isotope({
                layoutMode: 'masonry',
                transitionDuration: '0.3s',
            });
        });
        /* ======= Template MegaMenu  ======= */

        if (typeof is_menu_display !== 'undefined' && is_menu_display == 'yes') {
            $('#menu-1').megaMenu({
                // DESKTOP MODE SETTINGS
                logo_align: 'left', // align the logo left or right. options (left) or (right)
                links_align: 'left', // align the links left or right. options (left) or (right)
                socialBar_align: 'left', // align the socialBar left or right. options (left) or (right)
                searchBar_align: 'right', // align the search bar left or right. options (left) or (right)
                trigger: 'hover', // show drop down using click or hover. options (hover) or (click)
                effect: 'expand-top', // drop down effects. options (fade), (scale), (expand-top), (expand-bottom), (expand-left), (expand-right)
                effect_speed: 400, // drop down show speed in milliseconds
                sibling: true, // hide the others showing drop downs if this option true. this option works on if the trigger option is "click". options (true) or (false)
                outside_click_close: true, // hide the showing drop downs when user click outside the menu. this option works if the trigger option is "click". options (true) or (false)
                top_fixed: false, // fixed the menu top of the screen. options (true) or (false)
                sticky_header: is_sticky, // menu fixed on top when scroll down down. options (true) or (false)
                sticky_header_height: scroll_height, // sticky header height top of the screen. activate sticky header when meet the height. option change the height in px value.
                menu_position: 'horizontal', // change the menu position. options (horizontal), (vertical-left) or (vertical-right)
                full_width: false, // make menu full width. options (true) or (false)
                // MOBILE MODE SETTINGS
                mobile_settings: {
                    collapse: true, // collapse the menu on click. options (true) or (false)
                    sibling: true, // hide the others showing drop downs when click on current drop down. options (true) or (false)
                    scrollBar: true, // enable the scroll bar. options (true) or (false)
                    scrollBar_height: 400, // scroll bar height in px value. this option works if the scrollBar option true.
                    top_fixed: false, // fixed menu top of the screen. options (true) or (false)
                    sticky_header: false, // menu fixed on top when scroll down down. options (true) or (false)
                    sticky_header_height: 0 // sticky header height top of the screen. activate sticky header when meet the height. option change the height in px value.
                }
            });
        }




        /* ======= Jquery Select Dropdowns ======= */
        $("select").select2({
            placeholder: $('#select_place_holder').val(),
            allowClear: true,
            width: '100%'
        });
        $('.remove_select2').select2('destroy');

        /* ======= Featured Carousel 1 ======= */
        $('.featured-slider').owlCarousel({
            dots: false,
            loop: ($(".featured-slider .item").length > 1) ? true : false,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: parseInt($('#auto_slide_time').val()),
            margin: -10,
            responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: true
                },
                1000: {
                    items: $('#slider_item').val(),
                    nav: true,
                    loop: ($(".featured-slider .item").length > 1) ? true : false,
                }
            }
        });



        /* ======= Featured Carousel 2 ======= */
        $('.featured-slider-1').owlCarousel({
            dots: ($(".featured-slider-1 .item").length > 1) ? false : false,
            loop: ($(".featured-slider-1 .item").length > 1) ? true : false,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: parseInt($('#auto_slide_time').val()),
            margin: -10,
            responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.		
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: true
                },
                1000: {
                    items: $('#slider_item').val(),
                    nav: true,
                    loop: ($(".featured-slider-1 .item").length > 4) ? true : false,
                }
            }
        });

        /* ======= Featured Carousel 2 ======= */
        $('.featured-slider-5').owlCarousel({
            dots: ($(".featured-slider-5 .item").length > 1) ? false : false,
            loop: ($(".featured-slider-5 .item").length > 1) ? false : false,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: parseInt($('#auto_slide_time').val()),
            margin: -10,
            responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: true
                },
                1000: {
                    items: 3,
                    nav: true,
                    loop: ($(".featured-slider-5 .item").length > 1) ? false : false,
                }
            }
        });

        /* ======= Featured  Carousel 3 ======= */
        $('.featured-slider-3').owlCarousel({
            dots: ($(".featured-slider-3 .item").length > 1) ? false : false,
            loop: ($(".featured-slider-3 .item").length > 1) ? true : false,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: parseInt($('#auto_slide_time').val()),
            margin: 0,
            responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
            nav: true,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: true
                },
                1000: {
                    items: 1,
                    nav: true,
                    /*loop:($(".featured-slider-3 .item").length > 1) ? true: false,*/
                }
            }
        });

        /* ======= Category Carousel ======= */
        $('.category-slider').owlCarousel({
            loop: true,
            dots: false,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: parseInt($('#auto_slide_time').val()),
            margin: 0,
            responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: true
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: true
                }
            }
        });

        /* ======= Background Image Rotator Carousel ======= */
        $('.background-rotator-slider').owlCarousel({
            loop: false,
            dots: false,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: parseInt($('#auto_slide_time').val()),
            margin: 0,
            mouseDrag: true,
            touchDrag: true,
            responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
            nav: false,
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 1,
                },
                1000: {
                    items: 1,
                }
            }
        });

        /* ======= Single Ad Slider Carousel  ======= */
        $('.single-details').owlCarousel({
            dots: ($(".single-details .item").length > 1) ? false : false,
            loop: ($(".single-details .item").length > 1) ? false : false,
            margin: 0,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: parseInt($('#auto_slide_time').val()),
            mouseDrag: true,
            touchDrag: true,
            responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
            nav: true,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 1,
                },
                1000: {
                    items: 1,
                }
            }
        });

        /*==========  Single Page SLider With Thumb ==========*/
        $('#carousels').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 110,
            itemMargin: 50,
            asNavFor: '.single-page-slider'
        });
        $('.single-page-slider').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: true,
            sync: "#carousel"
        });

    }
    /* ======= Profile Image Upload ======= */
    $(document).on('change', '.btn-file :file', function () {
        var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
    });
    $(document).on('fileselect', '.btn-file :file', function (event, label) {
        var input = $(this).parents('.input-group').find(':text'),
                log = label;
        if (input.length) {
            input.val(log);
        }
    });
    /*==========  Back To Top  ==========*/
    var offset = 300,
            offset_opacity = 1200,
            //duration of the top scrolling animation (in ms)
            scroll_top_duration = 700,
            //grab the "back to top" link
            $back_to_top = $('.cd-top');
    var ad_post_btn = $('.sticky-post-button');
    //hide or show the "back to top" link
    $(window).scroll(function () {

        ($(this).scrollTop() > offset) ? ad_post_btn.addClass('sticky-post-button-visible') : ad_post_btn.removeClass('sticky-post-button-visible').removeClass('sticky-post-button-fadeout');
        ($(this).scrollTop() > offset) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
        if ($(this).scrollTop() > offset_opacity) {
            $back_to_top.addClass('cd-fade-out');
            ad_post_btn.addClass('sticky-post-button-fadeout');
        }

        var sb_menu_color = $('#sb_menu_color').val();

        var transparent_flag = false;
        if (header_style_val !== 'undefined' && (header_style_val == 'transparent-2' || header_style_val == 'transparent-3' || header_style_val == 'modern')) {
            transparent_flag = true;
        }
        if (($('#sb_is_homepage').val() == '1' || $('#sb_page_template').val() == 'page-home.php' || $('#sb_page_template').val() == 'single-ad_post.php') && transparent_flag && is_sticky && $('#sb_is_mobile').val() == '2')
        {

            if ($(this).scrollTop() >= 100) {
                $(".mega-menu .menu-links > li > a").css("color", "#000");
            } else {
                $(".mega-menu .menu-links > li > a").css("color", sb_menu_color);
            }
        }


        if ($(this).scrollTop() >= 100 && transparent_flag && is_sticky && $('#sb_is_mobile').val() == '2')
        {
            $('#sb_site_logo').attr('src', $('#sticky_sb_logo').val());
        }
        if ($(this).scrollTop() <= 100 && transparent_flag && is_sticky && $('#sb_is_mobile').val() == '2')
        {
            $('#sb_site_logo').attr('src', $('#static_sb_logo').val());
        }
    });
    //smooth scroll to top
    $back_to_top.on('click', function (event) {

        event.preventDefault();
        $('body,html').animate({
            scrollTop: 0,
        }, scroll_top_duration);
    });

    /*==========  Tooltip  ==========*/
    $('body').on('hover', '[data-toggle="tooltip"]', function ()
    {
        $('[data-toggle="tooltip"]').tooltip();
        $(this).trigger('hover');
    });
    /*==========  Quick Overview Modal  ==========*/
    $(".quick-view-modal").css("display", "block");
// Validating Registration process
    if ($('#sb-sign-form').length > 0)
    {
        $('#sb_register_msg').hide();
        $('#sb_register_redirect').hide();
        $('#sb-sign-form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        }).on('form:submit', function () {
            $('#sb_loading').show();
            var google_recaptcha_type = jQuery("#google_recaptcha_type").val();
            google_recaptcha_type = typeof google_recaptcha_type !== 'undefined' ? google_recaptcha_type : 'v2';
            var google_recaptcha_site_key = jQuery("#google_recaptcha_site_key").val();
            if (google_recaptcha_type == 'v3' && google_recaptcha_site_key !== 'undefined' && google_recaptcha_site_key != '') {
                grecaptcha.ready(function () {

                    var adforest_ajax_url = jQuery("#adforest_ajax_url").val();
                    try {
                        grecaptcha.execute(google_recaptcha_site_key, {action: "register_form"}).then(function (token) {
                            jQuery("#sb-sign-form").prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
                            jQuery.post(adforest_ajax_url, {action: "sb_goggle_captcha3_verification", token: token}, function (result) {
                                result = JSON.parse(result);
                                if (result.success) {
                                    // Ajax for Registration
                                    $('#sb_register_submit').hide();
                                    $('#sb_register_msg').show();
                                    $.post(adforest_ajax_url, {action: 'sb_register_user', security: $('#sb-register-token').val(), sb_data: $("form#sb-sign-form").serialize(), }).done(function (response)
                                    {
                                        $('#sb_loading').hide();
                                        $('#sb_register_msg').hide();

                                        if ($.trim(response) == '1')
                                        {
                                            $('#sb_register_redirect').show();
                                            window.location = $('#profile_page').val();
                                        } else if ($.trim(response) == '2')
                                        {
                                            $('.resend_email').show();
                                            toastr.success($('#verify_account_msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                        } else
                                        {
                                            $('#sb_register_submit').show();
                                            toastr.error(response, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                        }
                                    }).fail(function () {
                                        $('#sb_loading').hide();
                                        $('#sb_register_msg').hide();
                                        $('#sb_register_submit').show();
                                        toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                    });
                                } else {
                                    $('#sb_loading').hide();
                                    $('#sb_register_submit').show();
                                    toastr.error(result.msg, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                }
                            });
                        });
                    } catch (err) {
                        var google_recaptcha_error_text = jQuery("#google_recaptcha_error_text").val();
                        google_recaptcha_error_text = typeof google_recaptcha_error_text !== 'undefined' ? google_recaptcha_error_text : err;
                        jQuery('#sb_loading').hide();
                        toastr.error(google_recaptcha_error_text, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                });

            } else {
                // Ajax for Registration
                $('#sb_register_submit').hide();
                $('#sb_register_msg').show();
                $.post(adforest_ajax_url, {action: 'sb_register_user', security: $('#sb-register-token').val(), sb_data: $("form#sb-sign-form").serialize(), }).done(function (response)
                {
                    $('#sb_loading').hide();
                    $('#sb_register_msg').hide();

                    if ($.trim(response) == '1')
                    {
                        $('#sb_register_redirect').show();
                        window.location = $('#profile_page').val();
                    } else if ($.trim(response) == '2')
                    {
                        $('.resend_email').show();
                        toastr.success($('#verify_account_msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    } else
                    {
                        $('#sb_register_submit').show();
                        toastr.error(response, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                }).fail(function () {
                    $('#sb_loading').hide();
                    $('#sb_register_msg').hide();
                    $('#sb_register_submit').show();
                    toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                });
            }


            return false;
        });
    }
    /*Resend Email*/
    $('#resend_email').on('click', function ()
    {
        var usr_email = $('#sb_reg_email').val();
        $.post(adforest_ajax_url, {action: 'sb_resend_email', usr_email: usr_email, }).done(function (response)
        {
            toastr.success($('#verify_account_msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            $('.resend_email').hide();
            $('.contact_admin').show();
        });
    });

    if ($('#sb-login-form').length > 0)
    {
        // Login Process
        $('#sb_login_msg').hide();
        $('#sb_login_redirect').hide();

        $('#sb-login-form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('#sb_loading').show();
                    // Ajax for Registration
                    $('#sb_login_submit').hide();
                    $('#sb_login_msg').show();
                    $.post(adforest_ajax_url, {action: 'sb_login_user', security: $('#sb-login-token').val(), sb_data: $("form#sb-login-form").serialize(), }).done(function (response)
                    {
                        $('#sb_loading').hide();
                        $('#sb_login_msg').hide();

                        if ($.trim(response) == '1')
                        {
                            $('#sb_login_redirect').show();
                            window.location = $('#profile_page').val();
                        } else
                        {
                            $('#sb_login_submit').show();
                            toastr.error(response, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});

                        }
                    }).fail(function () {
                        $('#sb_login_submit').show();
                        $('#sb_loading').hide();
                        $('#sb_login_msg').hide();
                        toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    });
                    return false;
                });
    }
    /*// Forgot Password*/
    if ($('#sb-forgot-form').length > 0)
    {
        $('#sb_forgot_msg').hide();

        $('#sb-forgot-form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    // Ajax for Registration
                    $('#sb_forgot_submit').hide();
                    $('#sb_forgot_msg').show();
                    $('#sb_loading').show();
                    $.post(adforest_ajax_url, {action: 'sb_forgot_password', security: $('#sb-forgot-pass-token').val(), sb_data: $("form#sb-forgot-form").serialize(), }).done(function (response)
                    {
                        $('#sb_loading').hide();
                        $('#sb_forgot_msg').hide();

                        if ($.trim(response) == '1')
                        {
                            $('#sb_forgot_submit').show();
                            $('#sb_forgot_email').val('');
                            toastr.success($('#adforest_forgot_msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            $('#myModal').modal('hide');
                        } else
                        {
                            $('#sb_forgot_submit').show();
                            toastr.error(response, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        }
                    }).fail(function () {
                        $('#sb_forgot_submit').show();
                        $('#sb_forgot_email').val('');
                        toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    });
                    return false;
                });
    }

    jQuery(document).ready(function ($) {
        /*// Reset Password*/
        if ($('#sb-reset-password-form').length > 0)
        {
            $('#sb_reset_password_modal').modal('show');
            $('#sb_reset_password_msg').hide();
            $('#sb-reset-password-form').parsley().on('field:validated', function () {
                var ok = $('.parsley-error').length === 0;
            })
                    .on('form:submit', function () {
                        if ($('#sb_new_password').val() != $('#sb_confirm_new_password').val())
                        {
                            toastr.error($('#adforest_password_mismatch_msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            return false;
                        }
                        // Ajax for Registration
                        $('#sb_reset_password_submit').hide();
                        $('#sb_reset_password_msg').show();
                        $('#sb_loading').show();

                        $.post(adforest_ajax_url, {action: 'sb_reset_password', security: $('#sb-reset-pass-token').val(), sb_data: $("form#sb-reset-password-form").serialize(), }).done(function (response)
                        {
                            $('#sb_loading').hide();
                            $('#sb_reset_password_msg').hide();

                            var get_r = response.split('|');
                            if ($.trim(get_r[0]) == '1')
                            {
                                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                $('#sb_reset_password_modal').modal('hide');
                                $('#sb_reset_password_submit').show();
                                window.location = $('#login_page').val();
                            } else
                            {
                                $('#sb_reset_password_submit').show();
                                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            }
                        }).fail(function () {
                            $('#sb_loading').hide();
                            $('#sb_reset_password_msg').hide();
                            $('#sb_reset_password_submit').show();
                            toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        });
                        return false;
                    });
        }
    });
    /*// Change Password*/
    $(document).on('click', '#change_pwd', function () {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_change_password', security: $('#sb-profile-reset-pass-token').val(), sb_data: $("form#sb-change-password").serialize(), }).done(function (response)
        {
            $('#sb_loading').hide();
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '1')
            {
                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                $('#myModal').modal('hide');
                window.location = $('#login_page').val();
            } else
            {
                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        }).fail(function () {
            $('#sb_loading').hide();
            toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
        });
    });

    var is_load_required = 0;
    var is_error = false;
    /*// Add Post*/
    if ($('#ad_post_form').length > 0)
    {
        $('#ad_cat_sub_div').hide();
        $('#ad_cat_sub_sub_div').hide();
        $('#ad_cat_sub_sub_sub_div').hide();

        $('#ad_country_sub_div').hide();
        $('#ad_country_sub_sub_div').hide();
        $('#ad_country_sub_sub_sub_div').hide();
        if ($('#is_update').val() != "")
        {
            var level = $('#is_level').val();
            if (level >= 2)
            {
                $('#ad_cat_sub_div').show();
            }
            if (level >= 3)
            {
                $('#ad_cat_sub_sub_div').show();
            }
            if (level >= 4)
            {
                $('#ad_cat_sub_sub_sub_div').show();
            }

            var country_level = $('#country_level').val();
            if (country_level >= 2)
            {
                $('#ad_country_sub_div').show();
            }
            if (country_level >= 3)
            {
                $('#ad_country_sub_sub_div').show();
            }
            if (country_level >= 4)
            {
                $('#ad_country_sub_sub_sub_div').show();
            }
        }

        $('#ad_post_form').parsley().on('field:validated', function () {
        }).on('form:error', function ()
        {
            $('.ad_errors').show();

            $('.parsley-errors-list').show();
        })
                .on('form:submit', function () {
                    // Ad Post
                    $('#sb_loading').show();

                    $.post(adforest_ajax_url, {action: 'sb_ad_posting', security: $('#sb-post-token').val(), sb_data: $("form#ad_post_form").serialize(), is_update: $('#is_update').val(), }).done(function (response)
                    {
                        $('#sb_loading').hide();
                        if ($.trim(response) == "0")
                        {
                            toastr.error($('#not_logged_in').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        } else if ($.trim(response) == "1")
                        {
                            toastr.error($('#ad_limit_msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            window.location = $('#sb_packages_page').val();
                        } else if ($.trim(response) == "img_req")
                        {
                            toastr.error($('#required_images').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        } else
                        {
                            if ($('#is_update').val() != 'undefined' && $('#is_update').val() != '') {
                                toastr.success($('#ad_updated').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            } else {
                                toastr.success($('#ad_posted').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            }
                            window.location = response;
                        }
                    }).fail(function () {
                        $('#sb_loading').hide();
                        toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    });

                    return false;
                });

        /* Level 1 */
        $('#ad_cat').on('change', function ()
        {
            if ($("#ad_cat").val())
            {
                $('#sb_loading').show();
                $.post(adforest_ajax_url, {action: 'sb_get_sub_cat', cat_id: $("#ad_cat").val(), }).done(function (response)
                {
                    $('#sb_loading').hide();
                    if ($.trim(response) == 'cat_error') {
                        $("#ad_cat").val('');
                        $("#select2-ad_cat-container").remove();
                        toastr.error((get_strings.cat_pkg_error), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    } else {
                        $("#ad_cat_sub").val('');
                        $("#ad_cat_sub_sub").val('');
                        $("#ad_cat_sub_sub_sub").val('');
                        if ($.trim(response) != "")
                        {
                            $('#ad_cat_id').val($("#ad_cat").val());
                            $('#ad_cat_sub_div').show();
                            $('#ad_cat_sub').html(response);
                            $('#ad_cat_sub_sub_div').hide();
                            $('#ad_cat_sub_sub_sub_div').hide();
                        } else
                        {
                            $('#ad_cat_sub_div').hide();
                            $('#ad_cat_sub_sub_div').hide();
                            $('#ad_cat_sub_sub_sub_div').hide();

                        }
                        getCustomTemplate(adforest_ajax_url, $("#ad_cat").val(), $("#is_update").val());
                        adforest_make_bidding_catbase(adforest_ajax_url, $("#ad_cat").val());
                    }

                    /*For Category Templates*/

                });
            } else
            {
                $('#ad_cat_sub_div').hide();
                $('#ad_cat_sub_sub_div').hide();
                $('#ad_cat_sub_sub_sub_div').hide();
            }
        });

        /* Level 2 */
        $('#ad_cat_sub').on('change', function ()
        {
            if ($("#ad_cat_sub").val())
            {
                $('#sb_loading').show();
                $.post(adforest_ajax_url, {action: 'sb_get_sub_cat', cat_id: $("#ad_cat_sub").val(), }).done(function (response)
                {

                    $('#sb_loading').hide();
                    if ($.trim(response) == 'cat_error') {
                        $("#ad_cat_sub").val('');
                        $("#select2-ad_cat_sub-container").remove();
                        toastr.error((get_strings.cat_pkg_error), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    } else {
                        $("#ad_cat_sub_sub").val('');
                        $("#ad_cat_sub_sub_sub").val('');
                        if ($.trim(response) != "")
                        {
                            $('#ad_cat_id').val($("#ad_cat_sub").val());
                            $('#ad_cat_sub_sub_div').show();
                            $('#ad_cat_sub_sub').html(response);
                            $('#ad_cat_sub_sub_sub_div').hide();
                        } else
                        {
                            $('#ad_cat_sub_sub_div').hide();
                            $('#ad_cat_sub_sub_sub_div').hide();
                        }
                        getCustomTemplate(adforest_ajax_url, $("#ad_cat_sub").val(), $("#is_update").val());
                        adforest_make_bidding_catbase(adforest_ajax_url, $("#ad_cat_sub").val());
                    }

                });
            } else
            {
                $('#ad_cat_sub_sub_div').hide();
                $('#ad_cat_sub_sub_sub_div').hide();
            }
        });

        /* Level 3 */
        $('#ad_cat_sub_sub').on('change', function ()
        {
            if ($("#ad_cat_sub_sub").val())
            {
                $('#sb_loading').show();
                $.post(adforest_ajax_url, {action: 'sb_get_sub_cat', cat_id: $("#ad_cat_sub_sub").val(), }).done(function (response)
                {

                    $('#sb_loading').hide();
                    if ($.trim(response) == 'cat_error') {
                        $("#ad_cat_sub_sub").val('');
                        $("#select2-ad_cat_sub_sub-container").remove();
                        toastr.error((get_strings.cat_pkg_error), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    } else {
                        $("#ad_cat_sub_sub_sub").val('');
                        if ($.trim(response) != "")
                        {
                            $('#ad_cat_id').val($("#ad_cat_sub_sub").val());
                            $('#ad_cat_sub_sub_sub_div').show();
                            $('#ad_cat_sub_sub_sub').html(response);
                        } else
                        {
                            $('#ad_cat_sub_sub_sub_div').hide();
                        }
                        getCustomTemplate(adforest_ajax_url, $("#ad_cat_sub_sub").val(), $("#is_update").val());
                        adforest_make_bidding_catbase(adforest_ajax_url, $("#ad_cat_sub_sub").val());
                    }
                });
            } else
            {
                $('#ad_cat_sub_sub_sub_div').hide();
            }
        });
        /* Level 4 */
        $('#ad_cat_sub_sub_sub').on('change', function ()
        {
            //$('#ad_cat_id').val($("#ad_cat_sub_sub_sub").val());
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: 'sb_get_sub_cat', cat_id: $("#ad_cat_sub_sub_sub").val(), }).done(function (response)
            {

                $('#sb_loading').hide();
                if ($.trim(response) == 'cat_error') {
                    $("#ad_cat_sub_sub_sub").val('');
                    $("#select2-ad_cat_sub_sub_sub-container").remove();
                    toastr.error((get_strings.cat_pkg_error), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                } else {
                    getCustomTemplate(adforest_ajax_url, $("#ad_cat_sub_sub_sub").val(), $("#is_update").val());
                    adforest_make_bidding_catbase(adforest_ajax_url, $("#ad_cat_sub_sub_sub").val());
                }

            });

//            getCustomTemplate(adforest_ajax_url, $("#ad_cat_sub_sub_sub").val(), $("#is_update").val());
//            adforest_make_bidding_catbase(adforest_ajax_url, $("#ad_cat_sub_sub_sub").val());
        });
        /*  //Countries*/
        /*/ Level 1 /*/
        $('#ad_country').on('change', function ()
        {
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: 'sb_get_sub_states', country_id: $("#ad_country").val(), }).done(function (response)
            {
                $('#sb_loading').hide();
                $("#ad_country_states").val('');
                $("#ad_country_cities").val('');
                $("#ad_country_towns").val('');
                if ($.trim(response) != "")
                {
                    $('#ad_country_id').val($("#ad_cat").val());
                    $('#ad_country_sub_div').show();
                    $('#ad_country_states').html(response);
                    $('#ad_country_sub_sub_sub_div').hide();
                    $('#ad_country_sub_sub_div').hide();
                } else
                {
                    $('#ad_country_sub_div').hide();
                    $('#ad_cat_sub_sub_div').hide();
                    $('#ad_country_sub_sub_div').hide();
                    $('#ad_country_sub_sub_sub_div').hide();
                }
            });
        });

        /*/ Level 2 /*/
        $('#ad_country_states').on('change', function ()
        {
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: 'sb_get_sub_states', country_id: $("#ad_country_states").val(), }).done(function (response)
            {
                $('#sb_loading').hide();
                $("#ad_country_cities").val('');
                $("#ad_country_towns").val('');
                if ($.trim(response) != "")
                {
                    $('#ad_country_id').val($("#ad_country_states").val());
                    $('#ad_country_sub_sub_div').show();
                    $('#ad_country_cities').html(response);
                    $('#ad_country_sub_sub_sub_div').hide();
                } else
                {
                    $('#ad_country_sub_sub_div').hide();
                    $('#ad_country_sub_sub_sub_div').hide();
                }
            });
        });

        /*/ Level 3 /*/
        $('#ad_country_cities').on('change', function ()
        {
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: 'sb_get_sub_states', country_id: $("#ad_country_cities").val(), }).done(function (response)
            {
                $('#sb_loading').hide();
                $("#ad_country_towns").val('');
                if ($.trim(response) != "")
                {
                    $('#ad_country_id').val($("#ad_country_cities").val());
                    $('#ad_country_sub_sub_sub_div').show();
                    $('#ad_country_towns').html(response);
                } else
                {
                    $('#ad_country_sub_sub_sub_div').hide();
                }
            });
        });
    }
// select profile tabs
    $(document).on('click', '.messages_actions', function ()
    {
        var sb_action = $(this).attr('sb_action');
        if (sb_action != "")
        {
            //$('.dashboard-menu-container ul li').removeClass('active');
            //$(this).closest("li").addClass('active');
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: sb_action}).done(function (response)
            {

                $('#sb_loading').hide();
                $('#adforest_res').html(response);
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle=confirmation]').confirmation({
                    rootSelector: '[data-toggle=confirmation]',
                    // other options
                });


            });
        }
    });
    $('.menu-name, .profile_tabs').on('click', function ()
    {
        var sb_action = $(this).attr('sb_action');
        if (sb_action != "")
        {

            $('.dashboard-menu-container ul li').removeClass('active');
            $(this).closest("li").addClass('active');
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: sb_action}).done(function (response)
            {


                $('#sb_loading').hide();
                $('#adforest_res').html(response);
                $('[data-toggle="tooltip"]').tooltip();
                if ($('#is_video_on').val() == 1)
                {
                    /*Video Popup*/
                    $('a.play-video').YouTubePopUp();
                    $('a.play-video-new').YouTubePopUp();
                    //$('a.play-video').YouTubePopUp();
                }
                $('[data-toggle=confirmation]').confirmation({
                    rootSelector: '[data-toggle=confirmation]',
                    // other options
                });


                if ($('#is_rtl').val() != "" && $('#is_rtl').val() == "1")
                {
                    $('.posts-masonry').imagesLoaded(function () {
                        $('.posts-masonry').isotope({
                            layoutMode: 'masonry',
                            transitionDuration: '0.3s',
                            isOriginLeft: false,
                        });
                    });
                } else
                {
                    $('.posts-masonry').imagesLoaded(function () {
                        $('.posts-masonry').isotope({
                            layoutMode: 'masonry',
                            transitionDuration: '0.3s',
                        });
                    });

                }
            });
        }
    });

    (function ($) {
        $.sanitize = function (input) {
            var output = input.replace(/<script[^>]*?>.*?<\/script>/gi, '').
                    replace(/<[\/\!]*?[^<>]*?>/gi, '').
                    replace(/<style[^>]*?>.*?<\/style>/gi, '').
                    replace(/<![\s\S]*?--[ \t\n\r]*>/gi, '');
            return output;
        };
    })(jQuery);



// Update Profile
    $(document).on('click', '#sb_user_profile_update', function () {

// Ajax for Update profile
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_update_profile', security: $('#sb-profile-token').val(), sb_data: $("form#sb_update_profile").serialize(), }).done(function (response)
        {
            $('#sb_loading').hide();

            if ($.trim(response) == '1')
            {
                var sb_user_name = $.sanitize($('input[name=sb_user_name]').val());
                var sb_user_address = $.sanitize($('input[name=sb_user_address]').val());
                var sb_user_type = $.sanitize($('select[name=sb_user_type]').val());

                if (sb_user_name != '') {
                    $('.sb_put_user_name').html(sb_user_name);
                }
                if (sb_user_address != '') {
                    $('.sb_put_user_address').html(sb_user_address);
                }
                if (sb_user_type != '') {
                    $('.sb_user_type').html(sb_user_type);
                }

                toastr.success($('#adforest_profile_msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                $('body,html').animate({
                    scrollTop: 0,
                }, scroll_top_duration);
            } else
            {
                $('#sb_forgot_submit').show();
                toastr.error(response, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        }).fail(function () {
            $('#sb_loading').hide();
            toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
        }
        );
    });

    /*Upload user profile picture */
    $('body').on('change', '.sb_files-data', function (e) {

        var fd = new FormData();
        var files_data = $('.form-group .sb_files-data');

        $.each($(files_data), function (i, obj) {
            $.each(obj.files, function (j, file) {
                fd.append('my_file_upload[' + j + ']', file);
            });
        });

        fd.append('action', 'upload_user_pic');
        $('#sb_loading').show();
        $.ajax({
            type: 'POST',
            url: adforest_ajax_url,
            data: fd,
            contentType: false,
            processData: false,
            success: function (res) {
                $('#sb_loading').hide();
                var res_arr = res.split("|");
                if ($.trim(res_arr[0]) == "1")
                {
                    $('#user_dp').attr('src', res_arr[1]);
                    $('#img-upload').attr('src', res_arr[1]);
                } else
                {
                    toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                }
            }
        });
    });

    if ($('#is_sub_active').val() == "1") { /*images uplaod*/
        sbDropzone_image();
    }
    /*Make Post on blur of title field*/
    $('#ad_title').on('blur', function ()
    {
        if ($('#is_update').val() == "")
        {
            $.post(adforest_ajax_url, {action: 'post_ad', title: $('#ad_title').val(), is_update: $('#is_update').val(), }).done(function (response)
            {

            });
        }
    });
    // Location while ad posting
    $('#sb_user_address').on('focus', function () {
        var map_type = get_strings.adforest_map_type;

        if (map_type == 'google_map') {
            adforest_location();
        }


    });

    if ($('#facebook_key').val() != "" && $('#google_key').val() != "")
    {
        // Hello JS
        hello.init({
            facebook: $('#facebook_key').val(),
            google: $('#google_key').val(),
        }, {redirect_uri: $('#redirect_uri').val()});
    } else if ($('#facebook_key').val() != "" && $('#google_key').val() == "")
    {
        // Hello JS
        hello.init({
            facebook: $('#facebook_key').val(),
        }, {redirect_uri: $('#redirect_uri').val()});
    } else if ($('#google_key').val() != "" && $('#facebook_key').val() == "")
    {
        // Hello JS
        hello.init({
            google: $('#google_key').val(),
        }, {redirect_uri: $('#redirect_uri').val()});
    }
// Hello JS Hander
    $('.form-grid a.btn-social').on('click', function ()
    {
        hello.on('auth.login', function (auth) {

            $('#sb_loading').show();
            // Call user information, for the given network
            hello(auth.network).api('me').then(function (r) {
                if ($('#get_action').val() == 'login' || $('#get_action').val() == 'register')
                {

                    $.post(adforest_ajax_url, {action: 'sb_social_login', email: r.email, key_code: $('#nonce').val()}).done(function (response)
                    {

                        var get_r = response.split('|');
                        if ($.trim(get_r[0]) == '1')
                        {
                            $('#nonce').val(get_r[1]);
                            if ($.trim(get_r[2]) == '1')
                            {
                                toastr.success(get_r[3], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                window.location = $('#profile_page').val();
                            } else
                            {
                                toastr.error(get_r[3], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            }

                        }

                    });

                } else
                {
                    $('#sb_reg_name').val(r.name);
                    $('#sb_reg_email').val(r.email);
                }
                $('#sb_loading').hide();
            });
        });
    });

    if ($('#is_sub_active').val() == "1")
    {
        /* Tags*/
        adforest_inputTags();
    }
// Single Ad JS
    /* ======= Show Number ======= */
    $('.number').click(function () {
        $(this).find('span').text($(this).data('last'));
    });
    $('#show_ph_div').click(function () {
        $('#show_ph_num').text($(this).data('ph-num'));
    });
    $('#show_ph_num').click(function () {
        $('#show_ph_num').text($(this).data('ph-num'));
    });
    //caches a jQuery object containing the header element
    var header = $(".sticky-ad-detail");
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll >= 500) {
            header.addClass("show-sticky-ad-detail");
        } else {
            header.removeClass("show-sticky-ad-detail");
        }
    });

    /* ======= Ad Location ======= */
    if ($('#lat').length > 0)
    {

        var lat = $('#lat').val();
        var lon = $('#lon').val();
        var map_type = get_strings.adforest_map_type;
        if (map_type == 'leafletjs_map')
        {

            /*For leafletjs map*/
            var map = L.map('itemMap').setView([lat, lon], 7);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: ''
            }).addTo(map);
            L.marker([lat, lon]).addTo(map);


        } else if (map_type == 'google_map')
        {
            /*For Google Map*/
            var map = "";
            var latlng = new google.maps.LatLng(lat, lon);
            var myOptions = {
                zoom: 13,
                center: latlng,
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                size: new google.maps.Size(480, 240)
            }
            map = new google.maps.Map(document.getElementById("itemMap"), myOptions);
            var marker = new google.maps.Marker({
                map: map,
                position: latlng
            });
        }

    }

// Report Ad
    $('#sb_mark_it').on('click', function ()
    {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_report_ad', option: $('#report_option').val(), comments: $('#report_comments').val(), ad_id: $('#ad_id').val(), }).done(function (response)
        {
            $('#sb_loading').hide();
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '1')
            {
                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                $('.report-quote').modal('hide');
            } else
            {
                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }

        });
    });
// Add to favourites
    $('#ad_to_fav,.save-ad').on('click', function ()
    {
        var $this = $(this);

        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_fav_ad', ad_id: $(this).attr('data-adid'), }).done(function (response)
        {
            $('#sb_loading').hide();
            var get_p = response.split('|');
            if ($.trim(get_p[0]) == '1')
            {
                $this.parent().addClass("ad-favourited");
                toastr.success(get_p[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            } else
            {
                toastr.error(get_p[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }

        });
    });
// Delete  Ad
    $('body').on('hover', '.remove_fav_ad', function (e)
    {
        $(this).confirmation({
            rootSelector: '[data-toggle=confirmation]',
            // other options
        });
    });
    // Remove to favourites
    $('body').on('click', '.remove_fav_ad', function (e)
    {
        var id = $(this).attr('data-adid');
        $.post(adforest_ajax_url, {action: 'sb_fav_remove_ad', ad_id: $(this).attr('data-adid'), }).done(function (response)
        {
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '1')
            {
                $('body').find('#holder-' + id).remove();
                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            } else
            {
                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }

        });
    });

    /*Send message to ad owner*/
    if ($('#send_message_pop').length > 0)
    {
        $('#send_message_pop').parsley().on('field:validated', function () {
        })
                .on('form:submit', function () {
                    $('#sb_loading').show();


                    $.post(adforest_ajax_url, {action: 'sb_send_message', security: $('#sb-msg-token').val(), sb_data: $("form#send_message_pop").serialize(), }).done(function (response)
                    {
                        $('#sb_loading').hide();
                        var get_r = response.split('|');
                        if ($.trim(get_r[0]) == '1')
                        {
                            toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            $('#sb_forest_message').val('');
                            $(".close").trigger("click");
                        } else
                        {
                            toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            $(".close").trigger("click");

                        }
                    }).fail(function () {
                        $('#sb_loading').hide();
                        toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                    );
                    return false;
                });

    }

    $('body').on('click', '.user_list', function ()
    {
        $('#sb_loading').show();
        $('.message-history-active').removeClass('message-history-active');
        $(this).addClass('message-history-active');
        var second_user = $(this).attr('second_user');
        var inbox = $(this).attr('inbox');
        var msg_token = $(this).attr('sb_msg_token');

        var prnt = 'no';
        if (inbox == 'yes')
        {
            prnt = 'yes';
        }
        var cid = $(this).attr('cid');
        $('#' + second_user + '_' + cid).html('');
        $.post(adforest_ajax_url, {action: 'sb_get_messages', security: msg_token, ad_id: cid, user_id: second_user, receiver: second_user, inbox: prnt}).done(function (response)
        {
            $('#usr_id').val(second_user);
            $('#rece_id').val(second_user);
            $('#msg_receiver_id').val(second_user);
            $('#ad_post_id').val(cid)
            $('#sb_loading').hide();
            $('#messages').html(response);
        }).fail(function () {
            $('#sb_loading').hide();
            $('#messages').html($('#_nonce_error').val());
        });
    });

    $('body').on('click', '#send_msg', function ()
    {

        $('#send_message').parsley().on('field:validated', function () {
        })
                .on('form:submit', function () {
                    var inbox = $('#send_msg').attr('inbox');
                    var sb_msg_token = $('#send_msg').attr('sb_msg_token');
                    var prnt = 'no';
                    if (inbox == 'yes')
                    {
                        prnt = 'yes';
                    }

                    $('#sb_loading').show();
                    $.post(adforest_ajax_url, {action: 'sb_send_message', security: sb_msg_token, sb_data: $("form#send_message").serialize(), }).done(function (response)
                    {
                        var get_r = response.split('|');
                        $('#sb_loading').hide();
                        if ($.trim(get_r[0]) == '1')
                        {
                            toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            $('#sb_forest_message').val('');
                            $.post(adforest_ajax_url, {action: 'sb_get_messages', security: sb_msg_token, ad_id: $("#ad_post_id").val(), user_id: $('#usr_id').val(), inbox: prnt}).done(function (response)
                            {
                                var get_r = response.split('|');
                                if (typeof response !== undefined && $.trim(get_r[0]) == '0') {
                                    $('#sb_loading').hide();
                                    toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                } else {
                                    $('#sb_loading').hide();
                                    $('#messages').html(response);
                                    $('.message-details .list-wraps').scrollTop(20000).perfectScrollbar('update');
                                }
                            });
                        } else
                        {
                            toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            $(".close").trigger("click");
                        }
                    }).fail(function () {
                        $('#sb_loading').hide();
                        toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    });
                    return false;
                });
    });
    /*Delete  Ad*/
    $('body').on('hover', '.remove_ad', function (e)
    {
        $(this).confirmation({
            rootSelector: '[data-toggle=confirmation]',
            // other options
        });
    });
// Delete  Ad
    $('body').on('click', '.remove_ad', function (e)
    {
        $(this).confirmation({
            rootSelector: '[data-toggle=confirmation]',
            /*other options*/
        });
        $('#sb_loading').show();
        var id = $(this).attr('data-adid');
        $.post(adforest_ajax_url, {action: 'sb_remove_ad', ad_id: $(this).attr('data-adid'), }).done(function (response)
        {
            $('#sb_loading').hide();
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '1')
            {
                $('body').find('#holder-' + id).remove();
                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            } else
            {
                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    });
    /*My ads pagination*/
    $('body').on('click', '.sb_page', function ()
    {
        $('#sb_loading').show();
        var this_action = 'my_ads';
        if ($(this).attr('ad_type') == 'yes')
        {
            this_action = 'my_fav_ads';
        } else if ($(this).attr('ad_type') == 'inactive')
        {
            this_action = 'my_inactive_ads';
        } else if ($(this).attr('ad_type') == 'rejected')
        {
            this_action = 'my_rejected_ads';
        } else if ($(this).attr('ad_type') == 'expired_sold')
        {
            this_action = 'my_expire_sold_ads';
        } else if ($(this).attr('ad_type') == 'featured_ads')
        {
            this_action = 'my_feature_ads';
        }
        $.post(adforest_ajax_url, {action: this_action, paged: $(this).attr('page_no'), }).done(function (response)
        {
            $('#sb_loading').hide();
            $('#adforest_res').html(response);
            event.preventDefault();
            $('body,html').animate({
                scrollTop: 200,
            }, scroll_top_duration);
            if ($('#is_rtl').val() != "" && $('#is_rtl').val() == "1")
            {
                $('.posts-masonry').imagesLoaded(function () {
                    $('.posts-masonry').isotope({
                        layoutMode: 'masonry',
                        transitionDuration: '0.3s',
                        isOriginLeft: false,
                    });
                });
            } else
            {
                $('.posts-masonry').imagesLoaded(function () {
                    $('.posts-masonry').isotope({
                        layoutMode: 'masonry',
                        transitionDuration: '0.3s',
                    });
                });
            }
        });
    });
    /*Load Messages*/
    $('body').on('click', '.get_msgs', function ()
    {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_load_messages', ad_id: $(this).attr('ad_msg'), }).done(function (response)
        {
            $('#sb_loading').hide();
            $('#adforest_res').html(response);
        });
    });
    var previous;
    /*My ads pagination*/
    $('body').on('focus', '.ad_status', function ()
    {
        previous = this.value;
    }).on('change', '.ad_status', function ()
    {
        if ($(this).val() != "")
        {

            var $this = $(this);
            var status_val = $this.val();
            var bg_color_status = '#4caf50';
            if (status_val == 'active') {
                bg_color_status = '#4caf50';
            } else if (status_val == 'sold') {
                bg_color_status = '#3498db';
            } else if (status_val == 'expired') {
                bg_color_status = '#d9534f';
            }

            if (confirm($('#confirm_update').val()))
            {
                $('#sb_loading').show();
                $.post(adforest_ajax_url, {action: 'sb_update_ad_status', ad_id: $(this).attr('adid'), status: $(this).val(), }).done(function (response)
                {
                    $('#sb_loading').hide();
                    var get_r = response.split('|');
                    if ($.trim(get_r[0]) == '1')
                    {
                        toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        previous = this.value;
                        //$('.menu-name[sb_action="my_ads"]').get(0).click();
                        jQuery('#status-dyn-' + $this.attr('adid') + '').css({"background-color": bg_color_status, "text-transform": "capitalize"});
                        jQuery('#status-dyn-' + $this.attr('adid') + '').html($this.val());
                    } else
                    {
                        toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                });
            } else
            {
                $(this).val(previous)
            }
        }
    });
    /* Add to Cart*/
    $('body').on('click', '.sb_add_cart', function ()
    {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_add_cart', product_id: $(this).attr('data-product-id'), qty: $(this).attr('data-product-qty'), }).done(function (response)
        {
            $('#sb_loading').hide();
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '1')
            {
                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                window.location = get_r[2];
            } else
            {
                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                window.location = get_r[2];
            }
        });
    });
    if ($('#is_sub_active').val() == "1")
    {
        $('[data-toggle=confirmation]').confirmation({rootSelector: '[data-toggle=confirmation]', });
    }

    var ad_html_switch = $('#adforest_ad_html').val();
    ad_html_switch = typeof ad_html_switch !== 'undefined' && ad_html_switch == '1' ? true : false;

    if ($('#ad_description').length > 0)
    {
        if (ad_html_switch) {
            $('#ad_description').jqte({color: false});
        } else {
            $('#ad_description').jqte({
                link: false,
                unlink: false,
                formats: false,
                format: false,
                funit: false,
                fsize: false,
                fsizes: false,
                color: false,
                strike: false,
                source: false,
                sub: false,
                sup: false,
                indent: false,
                outdent: false,
                right: true,
                left: true,
                center: true,
                remove: false,
                rule: false,
                title: false,

            });
        }

    }
    $('#sb_feature_ad').on('click', function ()
    {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_make_featured', ad_id: $(this).attr('aaa_id'), }).done(function (response)
        {
            $('#sb_loading').hide();
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '1')
            {
                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                location.reload();
            } else
            {
                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    });
    $(document).on('click', '.sb_make_feature_ad', function ()
    {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_make_featured', ad_id: $(this).attr('data-aaa-id'), }).done(function (response)
        {
            $('#sb_loading').hide();
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '1')
            {
                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            } else
            {
                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    });
    $(document).on('click', '.bump_it_up', function ()
    {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_bump_it_up', ad_id: $(this).attr('data-aaa-id'), }).done(function (response)
        {
            $('#sb_loading').hide();
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '1')
            {
                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            } else
            {
                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    });
    $(document).on('click', '.delete_site_user', function ()
    {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'delete_site_user_func', del_user_id: $(this).attr('data-user-id'), }).done(function (response)
        {
            $('#sb_loading').hide();
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '1')
            {
                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                location.reload();
            } else
            {
                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    });
    $(document).on('click', '.ad_title_show', function ()
    {
        var cur_ad_id = $(this).attr('cid');
        $('.sb_ad_title').hide();
        $('#title_for_' + cur_ad_id).show();
    });
    if ($('#msg_notification_on').val() != "" && $('#msg_notification_on').val() != 0 && $('#msg_notification_time').val() != "")
    {
        if ($('#is_logged_in').val() == '1')
        {
            setInterval(function ()
            {
                $.post(adforest_ajax_url, {action: 'sb_check_messages', new_msgs: $('#is_unread_msgs').val(), }).done(function (response)
                {
                    var get_r = response.split('|');
                    if ($.trim(get_r[0]) == '1')
                    {
                        toastr.success(get_r[1], '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-bottom-left"});
                        $('#is_unread_msgs').val(get_r[2]);
                        $('.msgs_count').html(get_r[2]);
                        $('.notify').html('<span class="heartbit"></span><span class="point"></span>');
                        $.post(adforest_ajax_url, {action: 'sb_get_notifications'}).done(function (notifications)
                        {
                            $('.message-center').html(notifications);
                        });
                    }
                });
            }, $('#msg_notification_time').val());
        }
    }



    function adforest_inputTags()
    {

        var total_tags = $("#tags_count").val();
        if (typeof total_tags === 'undefined' || total_tags == '') {
            total_tags = 0;
        }
        if ($('#tags').length !== 'undefined' && $('#tags').length > 0) {
            $('#tags').tagsInput({
                'width': '100%',
                'height': '5px;',
                'defaultText': '',
                onAddTag: function (elem, elem_tags) {
                    total_tags = parseInt(total_tags) + 1;
                    if (total_tags > get_strings.adforest_tags_limit_val) {
                        alert(get_strings.adforest_tags_limit);
                        $(this).removeTag(elem);
                    }
                    if ($.sanitize(elem) == '') {
                        $(this).removeTag(elem);
                    }
                },
                onRemoveTag: function () {
                    total_tags = parseInt(total_tags) - 1;
                }
            });
        }


        if ($("#is_update").val() == "" && $('.dynamic-form-date-fields').length > 0) {
            $('.dynamic-form-date-fields').datepicker({
                timepicker: false,
                dateFormat: 'yyyy-mm-dd',
                language: {
                    days: [get_strings.Sunday, get_strings.Monday, get_strings.Tuesday, get_strings.Wednesday, get_strings.Thursday, get_strings.Friday, get_strings.Saturday],
                    daysShort: [get_strings.Sun, get_strings.Mon, get_strings.Tue, get_strings.Wed, get_strings.Thu, get_strings.Fri, get_strings.Sat],
                    daysMin: [get_strings.Su, get_strings.Mo, get_strings.Tu, get_strings.We, get_strings.Th, get_strings.Fr, get_strings.Sa],
                    months: [get_strings.January, get_strings.February, get_strings.March, get_strings.April, get_strings.May, get_strings.June, get_strings.July, get_strings.August, get_strings.September, get_strings.October, get_strings.November, get_strings.December],
                    monthsShort: [get_strings.Jan, get_strings.Feb, get_strings.Mar, get_strings.Apr, get_strings.May, get_strings.Jun, get_strings.Jul, get_strings.Aug, get_strings.Sep, get_strings.Oct, get_strings.Nov, get_strings.Dec],
                    today: get_strings.Today,
                    clear: get_strings.Clear,
                    dateFormat: 'mm/dd/yyyy',
                },
            });
        }
    }

    function adforest_remove_query_param(url, parameter) {
        //prefer to use l.search if you have a location/link object
        var urlparts = url.split('?');
        if (urlparts.length >= 2) {

            var prefix = encodeURIComponent(parameter) + '=';
            var pars = urlparts[1].split(/[&;]/g);

            //reverse iteration as may be destructive
            for (var i = pars.length; i-- > 0; ) {
                //idiom for string.startsWith
                if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                    pars.splice(i, 1);
                }
            }

            return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
        }
        return url;
    }


    function sbDropzone_image()
    {
        Dropzone.autoDiscover = false;

        var images_ajax_callback = adforest_ajax_url + "?action=upload_ad_images&is_update=" + $('#is_update').val();
        if (adforest_ajax_url.indexOf('?lang=') !== -1) {
            images_ajax_callback = adforest_ajax_url + "&action=upload_ad_images&is_update=" + $('#is_update').val();
        }
        var fileList = new Array;
        var acceptedFileTypes = "image/jpeg,image/png,image/jpg";
        var i = 0;

        var sb_max_files = typeof $('#sb_upload_limit').val() !== 'undefined' && $('#sb_upload_limit').val() == 'null' ? null : $('#sb_upload_limit').val();


        $("#dropzone").dropzone({
            timeout: 5000000,
            maxFilesize: 50000000,
            addRemoveLinks: true,
            paramName: "my_file_upload",
            maxFiles: sb_max_files, //change limit as per your requirements
            acceptedFiles: acceptedFileTypes,
            dictMaxFilesExceeded: $('#adforest_max_upload_reach').val(),
            url: images_ajax_callback,
            parallelUploads: 1,
            dictDefaultMessage: $('#dictDefaultMessage').val(),
            dictFallbackMessage: $('#dictFallbackMessage').val(),
            dictFallbackText: $('#dictFallbackText').val(),
            dictFileTooBig: $('#dictFileTooBig').val(),
            dictInvalidFileType: $('#dictInvalidFileType').val(),
            dictResponseError: $('#dictResponseError').val(),
            dictCancelUpload: $('#dictCancelUpload').val(),
            dictCancelUploadConfirmation: $('#dictCancelUploadConfirmation').val(),
            dictRemoveFile: $('#dictRemoveFile').val(),
            dictRemoveFileConfirmation: null,
            init: function () {
                var thisDropzone = this;
                $.post(adforest_ajax_url, {action: 'get_uploaded_ad_images', is_update: $('#is_update').val()}).done(function (data)
                {
                    if (typeof data !== 'undefined' && data != 0) {
                        $.each(data, function (key, value) {
                            var mockFile = {name: value.dispaly_name, size: value.size};
                            thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                            thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.name);
                            $('a.dz-remove:eq(' + i + ')').attr("data-dz-remove", value.id);
                            i++;
                            $(".dz-progress").remove();
                        });
                    }
                    if (i > 0)
                        $('.dz-message').hide();
                    else
                        $('.dz-message').show();
                });

                this.on("addedfile", function (file) {
                    $('.dz-message').hide();

                });
                this.on("success", function (file, responseText) {
                    var res_arr = responseText.split("|");
                    if ($.trim(res_arr[0]) != "0")
                    {
                        $('a.dz-remove:eq(' + i + ')').attr("data-dz-remove", responseText);
                        i++;
                        $('.dz-message').hide();
                    } else
                    {
                        if (i == 0)
                            $('.dz-message').show();
                        this.removeFile(file);
                        toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                });
                this.on("removedfile", function (file) {
                    var img_id = file._removeLink.attributes[2].value;
                    if (img_id != "")
                    {
                        i--;
                        if (i == 0)
                            $('.dz-message').show();
                        $.post(adforest_ajax_url, {action: 'delete_ad_image', img: img_id, is_update: $('#is_update').val(), }).done(function (response)
                        {
                            if ($.trim(response) == "1") { /*this.removeFile(file);*/
                            }
                        });
                    }
                });
                this.on("maxfilesexceeded", function (file) {
                    alert(get_strings.max_upload_images);
                    this.removeFile(file);
                });
            },
        });
    }
    /*// Rate User */
    if ($('#user_ratting_form').length > 0)
    {
        $('#user_ratting_form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    // Ajax for Registration
                    $('#sb_loading').show();
                    $.post(adforest_ajax_url, {action: 'sb_post_user_ratting', security: $('#sb-user-rating-token').val(), sb_data: $("form#user_ratting_form").serialize(), }).done(function (response)
                    {
                        $('#sb_loading').hide();
                        var res_arr = response.split("|");
                        if ($.trim(res_arr[0]) != "0")
                        {
                            toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            location.reload();
                        } else
                        {
                            toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        }
                    }).fail(function () {
                        $('#sb_loading').hide();
                        toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                    );
                    return false;
                });
    }
    /* Replay to Rator */
    if ($('#sb-reply-rating-form').length > 0)
    {
        $('#sb-reply-rating-form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    // Ajax for Registration
                    $('#sb_loading').show();
                    $.post(adforest_ajax_url, {action: 'sb_reply_user_rating', security: $('#sb-user-rate-reply-token').val(), sb_data: $("form#sb-reply-rating-form").serialize(), }).done(function (response)
                    {
                        $('#sb_loading').hide();
                        var res_arr = response.split("|");
                        if ($.trim(res_arr[0]) != "0")
                        {
                            toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            location.reload();
                        } else
                        {
                            toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        }
                    }).fail(function () {
                        $('#sb_loading').hide();
                        toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                    );
                    return false;
                });
    }
    $('.clikc_reply').on('click', function ()
    {
        $('#rator_name').html($(this).attr('data-rator-name'));
        $('#rator_reply').val($(this).attr('data-rator-id'));
    });
    /* Bidding System  */
    if ($('#sb_bid_ad').length > 0)
    {
        $('#sb_bid_ad').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('#sb_loading').show();
                    $.post(adforest_ajax_url, {action: 'sb_submit_bid', security: $('#sb-bidding-token').val(), sb_data: $("form#sb_bid_ad").serialize(), }).done(function (response)
                    {
                        $('#sb_loading').hide();
                        var res_arr = response.split("|");
                        if ($.trim(res_arr[0]) != "0")
                        {
                            toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            location.reload();
                        } else
                        {
                            toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        }
                    }).fail(function () {
                        $('#sb_loading').hide();
                        toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                    );

                    return false;
                });
    }

    var $scrollbar = $('.bidding');
    $scrollbar.perfectScrollbar({maxScrollbarLength: 150, });
    $scrollbar.perfectScrollbar('update');
    $('form.custom-search-form select').on("select2:select", function (e) {
        $('#sb_loading').show();
        $(this).closest("form").submit();
    });

    function getCustomTemplate(ajax_url, catId, updateId)
    {
        /*For Category Templates*/
        $('#sb_loading').hide();
        //$('#sb_loading').show();
        $.post(ajax_url, {action: 'sb_get_sub_template', 'cat_id': catId, 'is_update': updateId, }).done(function (response)
        {
            $('#sb_loading').hide();

            if ($.trim(response) != "")
            {
                $("#dynamic-fields").html(response);
                $('#dynamic-fields select').select2();
                sbDropzone_image();
                adforest_inputTags();
            }

            if ($('#theme_type').val() == 1 && updateId == "")
            {
                //$('#ad_post_form').submit();
                //$('.ad_errors').hide();
            }
        });
        /*For Category Templates*/
    }

    function adforest_make_bidding_catbase(ajax_url, catId) {
        /*For Category Templates*/
        $('#sb_loading').hide();
        //$('#sb_loading').show();
        $.post(ajax_url, {action: 'sb_display_bidding_section', 'cat_id': catId}).done(function (response)
        {
            $('#sb_loading').hide();
            if (response == '1') {
                $('.bidding-content').show();
            } else {
                $('.bidding-content').hide();
            }

        });
        /*For Category Templates*/
    }




    $(document).on('change', '#ad_price_type', function ()
    {

        if (this.value == "on_call" || this.value == "free" || this.value == "no_price")
        {
            $('#ad_price').attr("data-parsley-required", "false");
            $('#ad_currency').attr("data-parsley-required", "false");
            $('#ad_price').val('');
            //$('#ad_currency').val('');	
            $('#ad_price').parent('div').hide();
            $('#ad_currency').parent('div').hide();
            //$('.curreny_class').hide();
        } else
        {
            $('#ad_price').attr("data-parsley-required", "true");
            $('#ad_currency').attr("data-parsley-required", "true");
            $('#ad_price').parent('div').show();
            //$('.curreny_class').show();	
            $('#ad_currency').parent('div').show();
        }
    });

    if ($('#is_video_on').val() == 1)
    {
        $("a.play-video").YouTubePopUp();
        $("a.play-video-new").YouTubePopUp();
    }

    $('a.page-scroll').on('click', function (event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top - 60
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });

    $('select.submit_on_select').on("select2:select", function (e) {
        $('#sb_loading').show();
        $(this).closest("form").submit();
    });
    $('.fa_cursor').on("click", function (e) {
        $('#sb_loading').show();
        $(this).closest("form").submit();
    });
    $('.submit_on_select').on('click', function () {
        $('#sb_loading').show();
        $(this).closest("form").submit();
    });

    if ($("#sortable").length > 0)
    {
        $("#sortable").sortable({
            stop: function (event, ui) {
                $('#post_img_ids').val('');
                var current_img = '';
                $(".ui-state-default img").each(function (index) {
                    current_img = current_img + $(this).attr('data-img-id') + ",";
                });
                $('#post_img_ids').val(current_img.replace(/,\s*$/, ""));
            }
        });
        $("#sortable").disableSelection();
    }
    $('#sb_sort_images').on('click', function ()
    {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_sort_images', ids: $('#post_img_ids').val(), ad_id: $('#current_pid').val(), }).done(function (response)
        {
            toastr.success($('#re-arrange-msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            location.reload();
            $('#sb_loading').hide();
        });
    });
    var $scrollbar = $('.rating_comments');
    $scrollbar.perfectScrollbar({
        maxScrollbarLength: 150,
    });
    $scrollbar.perfectScrollbar('update');
    /*Phone verification logic*/
    $(document).on('click', '#sb_verification_ph,#resend_now', function ()
    {
        var ph_number = $('#sb_ph_number').val();
        $('#sb_verification_ph_code').hide();
        $('#sb_verification_ph').hide();
        $('#sb_verification_ph_back').show();
        $.post(adforest_ajax_url, {action: 'sb_verification_system', sb_phone_numer: ph_number, }).done(function (response)
        {
            var res_arr = response.split("|");
            if ($.trim(res_arr[0]) != "0")
            {
                $('#sb_verification_ph_back').hide();
                $('.sb_ver_ph_div').hide();
                $('.sb_ver_ph_code_div').show();
                $('#sb_verification_ph_code').show();
                toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            } else
            {
                $('#sb_verification_ph').show();
                $('#sb_verification_ph_back').hide();
                toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    });

    $(document).on('click', '#sb_verification_ph_code', function ()
    {
        var ph_code = $('#sb_ph_number_code').val();
        $('#sb_verification_ph_code').hide();
        $('#sb_verification_ph_back').show();
        $.post(adforest_ajax_url, {action: 'sb_verification_code', sb_code: ph_code, }).done(function (response)
        {
            var res_arr = response.split("|");
            if ($.trim(res_arr[0]) != "0")
            {
                toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                location.reload();
            } else
            {
                $('#sb_verification_ph_code').show();
                $('#sb_verification_ph_back').hide();
                toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    });

    /* Ad rating Logic */
// Send message to ad owner
    if ($('#ad_rating_form').length > 0)
    {
        $('#ad_rating_form').parsley().on('field:validated', function () {
        }).on('form:submit', function () {


            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: 'sb_ad_rating', security: $('#sb-review-token').val(), sb_data: $("form#ad_rating_form").serialize(), }).done(function (response)
            {
                $('#sb_loading').hide();
                var get_r = response.split('|');
                if ($.trim(get_r[0]) == '1')
                {
                    toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    location.reload();
                } else
                {
                    toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                }
            }).fail(function () {
                $('#sb_loading').hide();
                toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            });
            return false;
        });

    }
// Send message to ad owner
    if ($('#rating_reply_form').length > 0)
    {

        $('#rating_reply_form').parsley().on('field:validated', function () {
        }).on('form:submit', function () {
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: 'sb_ad_rating_reply', security: $('#sb-review-reply-token').val(), sb_data: $("form#rating_reply_form").serialize(), }).done(function (response)
            {
                $('#sb_loading').hide();
                var get_r = response.split('|');
                if ($.trim(get_r[0]) == '1')
                {
                    toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    location.reload();
                } else
                {
                    toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                }
            }).fail(function () {

                $('#sb_loading').hide();
                toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            });
            return false;
        });
    }

    $('.reply_ad_rating').on('click', function ()
    {
        var p_comment_id = $(this).attr('data-comment_id');
        $('#reply_to_rating').html($(this).attr('data-commenter-name'));
        $('#parent_comment_id').val(p_comment_id);
    });

    $("#you_current_location_text").click(function () {
        $('#sb_loading').show();
        $.ajax({
            url: "https://geoip-db.com/jsonp",
            jsonpCallback: "callback",
            dataType: "jsonp",
            success: function (location) {
                $('#sb_loading').hide();
                $('#sb-radius-form #sb_user_address').val(location.city + ", " + location.state + ", " + location.country_name);
                var map_type = get_strings.adforest_map_type;
                if (map_type == 'leafletjs_map')
                {
                    $('#sb_user_address_lat').val(location.latitude);
                    $('#sb_user_address_long').val(location.longitude);
                }
            }
        });
    });
    /* Detrmine Theme RTL OR NOT*/
    var ajax_url = $("input#adforest_ajax_url").val();
    var yes_rtl;
    if ($('#is_rtl').val() !== "" && $('#is_rtl').val() === "1") {
        yes_rtl = true;
    } else {
        yes_rtl = false;
    }

    /*Shop Settings Starts*/
    if ($('.produt-slider').length) {
        $('.produt-slider').owlCarousel({
            nav: true,
            rtl: yes_rtl,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            items: 1,
        });
    }

    if ($('.related-produt-slider').length) {
        $('.related-produt-slider').owlCarousel({
            nav: true,
            rtl: yes_rtl,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            responsive: {
                0: {items: 1, autoplay: false, },
                600: {items: 3, margin: 10, },
                1000: {items: 4, margin: 10, },
                1025: {items: 4, margin: 10, }
            },
            dots: false,
            autoplay: true,
            autoplayTimeout: 2500,
            autoplayHoverPause: true,
        });
    }
    /* Contact from profile  */
    if ($('#user_contact_form').length > 0)
    {
        $('#user_contact_form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        }).on('form:submit', function () {
            // Ajax for Registration
            $('#sb_loading').show();


            var google_recaptcha_type = jQuery("#google_recaptcha_type").val();
            google_recaptcha_type = typeof google_recaptcha_type !== 'undefined' ? google_recaptcha_type : 'v2';
            var google_recaptcha_site_key = jQuery("#google_recaptcha_site_key").val();
            if (google_recaptcha_type == 'v3' && google_recaptcha_site_key !== 'undefined' && google_recaptcha_site_key != '') {
                grecaptcha.ready(function () {

                    try {
                        var adforest_ajax_url = jQuery("#adforest_ajax_url").val();
                        grecaptcha.execute(google_recaptcha_site_key, {action: "contact_form"}).then(function (token) {
                            jQuery("#user_contact_form").prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
                            jQuery.post(adforest_ajax_url, {
                                action: "sb_goggle_captcha3_verification",
                                token: token,
                            }, function (result) {
                                result = JSON.parse(result);
                                if (result.success) {
                                    // Ajax for contact form
                                    $.post(adforest_ajax_url, {action: 'sb_user_contact_form', receiver_id: $('#receiver_id').val(), sb_data: $("form#user_contact_form").serialize(), }).done(function (response)
                                    {
                                        $('#sb_loading').hide();
                                        var res_arr = response.split("|");
                                        if ($.trim(res_arr[0]) != "0")
                                        {
                                            toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                        } else
                                        {
                                            toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});

                                        }
                                    });
                                } else {
                                    $('#sb_loading').hide();
                                    $('#sb_register_submit').show();
                                    toastr.error(result.msg, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                }
                            });
                        });
                    } catch (err) {
                        var google_recaptcha_error_text = jQuery("#google_recaptcha_error_text").val();
                        google_recaptcha_error_text = typeof google_recaptcha_error_text !== 'undefined' ? google_recaptcha_error_text : err;
                        jQuery('#sb_loading').hide();
                        toastr.error(google_recaptcha_error_text, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }

                });

            } else {
                // Ajax for contact form
                $.post(adforest_ajax_url, {action: 'sb_user_contact_form', receiver_id: $('#receiver_id').val(), sb_data: $("form#user_contact_form").serialize(), }).done(function (response)
                {
                    $('#sb_loading').hide();

                    var res_arr = response.split("|");
                    if ($.trim(res_arr[0]) != "0")
                    {
                        toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    } else
                    {
                        toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});

                    }
                });
            }


            return false;
        });
    }
    if ($('.dynamic-form-date-fields').length > 0) {
        jQuery('.dynamic-form-date-fields').datepicker({
            timepicker: false,
            dateFormat: 'yyyy-mm-dd',
            language: {
                days: [get_strings.Sunday, get_strings.Monday, get_strings.Tuesday, get_strings.Wednesday, get_strings.Thursday, get_strings.Friday, get_strings.Saturday],
                daysShort: [get_strings.Sun, get_strings.Mon, get_strings.Tue, get_strings.Wed, get_strings.Thu, get_strings.Fri, get_strings.Sat],
                daysMin: [get_strings.Su, get_strings.Mo, get_strings.Tu, get_strings.We, get_strings.Th, get_strings.Fr, get_strings.Sa],
                months: [get_strings.January, get_strings.February, get_strings.March, get_strings.April, get_strings.May, get_strings.June, get_strings.July, get_strings.August, get_strings.September, get_strings.October, get_strings.November, get_strings.December],
                monthsShort: [get_strings.Jan, get_strings.Feb, get_strings.Mar, get_strings.Apr, get_strings.May, get_strings.Jun, get_strings.Jul, get_strings.Aug, get_strings.Sep, get_strings.Oct, get_strings.Nov, get_strings.Dec],
                today: get_strings.Today,
                clear: get_strings.Clear,
                dateFormat: 'mm/dd/yyyy',
            },
        });
    }

    if (jQuery('input[name=ad_title]').length > 0) {
        jQuery('input[name=ad_title]').keypress(function () {
            var spinner_html = '<span class="adforest-search-spinner"><i class="fa fa-spinner spin"></i></span>';
            if (jQuery(this).after(spinner_html)) {
                jQuery('.adforest-search-spinner').remove();
            }
            jQuery(this).after(spinner_html);
        });
    }




    $('input[name=ad_title]').typeahead({
        minLength: 1,
        delay: 250,
        scrollBar: true,
        autoSelect: true,
        fitToElement: true,
        highlight: false,
        hint: true,
        source: function (query, process) {
            return $.get(ajax_url, {query: query, action: 'fetch_suggestions'}, function (data) {
                jQuery('.adforest-search-spinner').remove();
                data = $.parseJSON(data);
                return process(data);
            });
        }
    });


    /*Resend Email*/
    $('.ads-with-sidebar-section a.ajax-anchor').on('click', function ()
    {
        var cat_id = $(this).data('sidebar-term-id');
        var unique_id = $(this).data('unique-id');

        $(".ads-sidebar-loader").show();
        $('#sb_loading').show();
        var no_of_ads = $("#no_of_ads_" + unique_id).val();
        var layout_type = $("#layout_type_" + unique_id).val();
        var ad_order = $("#ad_order_" + unique_id).val();
        var ad_type = $("#ad_type_" + unique_id).val();
        var cat_link_page = $("#cat_link_page_" + unique_id).val();
        var wpnonce = $("#ads_with_sidebar_ajax_" + unique_id).val();
        var view_all = $("#view_all_" + unique_id).val();
        $("#ads-with-sidebar-section-" + unique_id).html('');
        $.post(adforest_ajax_url, {action: 'get_ads_with_sidebar_section', cat_id: cat_id, unique_id: unique_id, no_of_ads: no_of_ads, layout_type: layout_type, ad_order: ad_order, ad_type: ad_type, cat_link_page: cat_link_page, view_all: view_all, wpnonce: wpnonce}).done(function (response)
        {
            $("#ads-with-sidebar-section-" + unique_id).html(response);
            adforest_timerCounter_function();
            $(".ads-sidebar-loader").hide();
            $('#sb_loading').hide();
        });
    });

    /*More Js Added On Descmber 5*/
    var site_rtl = $("#is_rtl").val();
    if (site_rtl == 1)
    {
        var is_site_rtl = true;
        var navTextAngle = ["<i class='fa fa-angle-right'></i>", "<i class='fa fa-angle-left'></i>"];
    } else
    {
        var is_site_rtl = false;
        var navTextAngle = ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"];
    }

    $('.recent-ad-slider').owlCarousel({
        rtl: is_site_rtl,
        loop: true,
        margin: 10,
        nav: true,
        autoplay: true,
        responsive: {
            0: {items: 1},
            600: {items: 3},
            1000: {items: 1}
        }
    });

    $(".hammi-slider").owlCarousel({
        rtl: is_site_rtl,
        loop: true,
        dots: false,
        responsiveClass: true,
        navText: navTextAngle,
        nav: true,
        autoplay: true,
        autoplayTimeout: 10000,
        autoplaySpeed: 2000,
        autoplayHoverPause: true,
        responsive: {
            0: {items: 3, },
            600: {items: 3, },
            1000: {items: 6, }
        }
    });
    $('.success-stories-2').owlCarousel({
        rtl: is_site_rtl,
        loop: true,
        margin: 10,
        navText: navTextAngle,
        nav: true,
        smartSpeed: 600,
        autoplay: true,
        responsive: {
            0: {items: 1},
            600: {items: 3, },
            1000: {items: 1, }
        }
    });

    function toggleIcon(e) {
        $(e.target)
                .prev('.panel-heading')
                .find(".more-less")
                .toggleClass('glyphicon-plus glyphicon-minus');
    }
    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);

    $('.landing-page-slider-1').owlCarousel({
        rtl: is_site_rtl,
        loop: true,
        margin: 10,
        nav: true,
        autoplay: true,
        responsive: {
            0: {items: 1},
            600: {items: 3},
            1000: {items: 1}
        }
    });

    $('.land-one-slider-2').owlCarousel({
        rtl: is_site_rtl,
        loop: true,
        margin: 10,
        autoplay: true,
        smartSpeed: 700,
        nav: true,
        responsive: {
            0: {items: 1},
            600: {items: 3},
            1000: {items: 1}
        }
    });

    $('.apps-shots-slider').owlCarousel({
        rtl: is_site_rtl,
        loop: true,
        smartSpeed: 700,
        nav: true,
        responsive: {
            0: {items: 1},
            600: {items: 3},
            1000: {items: 4}
        }
    });

    $('.app-shots-carousal').owlCarousel({
        autoplayHoverPause: true,
        rtl: is_site_rtl,
        loop: true,
        margin: 20,
        dots: false,
        autoplay: false,
        responsiveClass: true,
        navText: navTextAngle,
        nav: true,
        center: true,
        responsive: {
            0: {items: 1, },
            600: {items: 3, },
            1000: {items: 5, }
        }
    });


    /*
     * Contact number validation
     */
    $(document).ready(function () {
        $('[id^=adforest_contact_number]').keypress(validateNumber);
    });

    function validateNumber(event) {
        var key = window.event ? event.keyCode : event.which;

        if (event.keyCode === 8 || event.keyCode === 46) {
            return true;
        } else if (event.keyCode == 43) {
            return true;
        } else if (key < 48 || key > 57) {
            return false;
        } else {
            return true;
        }
    }

    $(".menu-mobile-collapse-trigger").on("click", function () {

        $(".menu-links").toggleClass("menu-work");
        //$(".menu-links").css("display", "block !important");
    });

    $(document).ready(function () {
        $('[data-toggle="popover"]').popover({
            html: true,
            content: function () {
                return $('.category_package_list').html();
            }
        });

        if ($('#imageGallery').length > 0) {
            $('#imageGallery').lightSlider({
                gallery: true,
                item: 1,
                rtl: slider_rtl,
                loop: true,
                currentPagerPosition: 'middle',
                margin: 0,
                thumbItem: 4,
                slideMargin: 0,
                enableDrag: false,
                responsive: [],
                onSliderLoad: function (el) {

                }
            });
        }




    });




    /*More Js Added On Descmber 5*/
})(jQuery);
jQuery(document).ready(function ($) {
    $("#ad_price_type").trigger("change");
    $('[data-toggle="tooltip"]').tooltip();

    if ($('#input-21b').length > 0)
    {
        var star_rtl = false;
        if ($('#is_rtl').val() != "" && $('#is_rtl').val() == "1")
        {
            star_rtl = true;
        }
        $('#input-21b').rating({starCaptions: {1: get_strings.one, 2: get_strings.two, 3: get_strings.three, 4: get_strings.four, 5: get_strings.five}});
    }

    $(".jqte_editor").on("paste", function (e)
    {
        e.preventDefault();
        var text = e.originalEvent.clipboardData.getData('text');
        document.execCommand("insertText", false, text);
    });
});

function adforest_validateEmail(sEmail)
{
    var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    if (filter.test(sEmail))
    {
        return true;
    } else
    {
        return false;
    }
}
function adforest_select_msg(cid, second_user, prnt, msg_token)
{
    jQuery('.message-history-active').removeClass('message-history-active');
    jQuery(document).find('#' + second_user + '_' + cid).html('');
    jQuery(document).find('#sb_' + second_user + '_' + cid).addClass('message-history-active');
    jQuery('#sb_loading').show();

    jQuery.post(jQuery('#adforest_ajax_url').val(), {action: 'sb_get_messages', security: msg_token, ad_id: cid, user_id: second_user, receiver: second_user, inbox: prnt}).done(function (response)
    {
        jQuery('#usr_id').val(second_user);
        jQuery('#rece_id').val(second_user);
        jQuery('#msg_receiver_id').val(second_user);
        jQuery('#ad_post_id').val(cid)
        jQuery('#sb_loading').hide();
        jQuery('#messages').html(response);
    }).fail(function () {

        $('#sb_loading').hide();
        jQuery('#messages').html($('#_nonce_error').val());

    });

}
adforest_timerCounter_function();
/*
 * slider js for adforest app homepage
 */



if (jQuery('.mobile-hero').length > 0) {
    jQuery('.mobile-hero').owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
        center: true,
        rtl: slider_rtl,
        smartSpeed: 750,
        autoplay: false,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1,
                stagePadding: 200,
            }
        }
    });
}
/*
 * 
 */

if (jQuery('.newest').length > 0) {
    jQuery('.newest').owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
        rtl: slider_rtl,

        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4,
            }
        }
    });
}
function adforest_disableEmptyInputs(form) {
    var controls = form.elements;
    for (var i = 0, iLen = controls.length; i < iLen; i++) {
        controls[i].disabled = controls[i].value == "";
    }
}

if (jQuery('.toys-new-accessories').length > 0) {
    jQuery('.toys-new-accessories').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        rtl: slider_rtl,
        smartSpeed: 550,
        autoplay: true,
        dots: true,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },

            768: {
                items: 1,

            },

            1000: {
                items: 1,
            }
        }
    });
}

if (jQuery('.dec-location').length > 0) {
    jQuery('.dec-location').owlCarousel({
        loop: true,
        margin: 15,
        dots: false,
        rtl: slider_rtl,
        autoplay: true,
        responsiveClass: true,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        nav: true,

        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 3,
            },
            1000: {
                items: 3,
            }
        }
    });
}

if (jQuery('.dec-latest-products-s').length > 0) {
    jQuery('.dec-latest-products-s').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        rtl: slider_rtl,
        smartSpeed: 550,
        autoplay: false,
        //dots: false,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 4,
            },

            768: {
                items: 6,

            },

            1000: {
                items: 6,
            }
        }
    });
}


(function ($) {

    /* Emoji Reaction Against Reviews  */
    $(".Emoji").on("click", function ()
    {
        var reaction_id = $(this).data("reaction");
        var c_id = $(this).data("cid");
        $("#reaction-loader-" + c_id).show();
        $.post(jQuery('#adforest_ajax_url').val(), {action: 'adforest_ads_rating_reaction', r_id: reaction_id, c_id: c_id}).done(function (response)
        {
            $("#reaction-loader-" + c_id).hide();

            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '0')
            {
                alert($.trim(get_r[1]));
                return false;
            } else
            {
                if (reaction_id === 1)
                {
                    $('.emoji-count.likes-' + c_id).text(response);
                }
                if (reaction_id === 2)
                {
                    $('.emoji-count.loves-' + c_id).text(response);
                }
                if (reaction_id === 3)
                {
                    $('.emoji-count.wows-' + c_id).text(response);
                }
                if (reaction_id === 4)
                {
                    $('.emoji-count.angrys-' + c_id).text(response);
                }
            }
        });
        return false;
    });



    if ($('.ad-grid-slider').length > 0) {
        $('.ad-grid-slider').owlCarousel({
            loop: false,
            margin: 20,
            autoplay: false,
            nav: true,
            rtl: slider_rtl,
            margin: -10,
            dots: false,
            rtl: slider_rtl,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],

            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        });
    }

    if (jQuery('.mega-menu .menu-links li.hoverTrigger .drop-down.grid-col-12').length > 0) {
        var hee = jQuery('.mega-menu .menu-links li.hoverTrigger .drop-down.grid-col-12').height();
        if (hee !== 'undefined' && hee == 350) {
            const pc = new PerfectScrollbar(".drop-down.grid-col-12.effect-expand-top");
        }
    }





})(jQuery);

jQuery(document).ready(function () {

    if (jQuery('.ad-allbids').length > 0) {
        const ps = new PerfectScrollbar(".ad-allbids");
    }

    if (jQuery('.sb-top-loc').length > 0) {
        const pc = new PerfectScrollbar(".sb-top-loc");
    }

    if (jQuery('.cat-11').length > 0) {
//        var slider = tns({
//            "container": ".cat-11",
//            "items": 5,
//            "controlsContainer": "#cat-customize",
//            "nav": false,
//            "autoplay": true,
//            "autoplayButtonOutput": false,
//            "autoplayHoverPause": true,
//            "speed": 1000,
//            "responsive": {
//                320: {
//                    items: 2
//                },
//                768: {
//                    items: 3
//                },
//                900: {
//                    items: 5
//                }
//            }
//
//        });
    }
    if (jQuery('.testimonial-11').length > 0) {
//        var slider = tns({
//            "container": ".testimonial-11",
//            "items": 2,
//            "controlsContainer": ".say-btns",
//            "nav": false,
//            "autoplay": true,
//            "autoplayButtonOutput": false,
//            "autoplayHoverPause": true,
//            "gutter": 30,
//            "speed": 1000,
//            "responsive": {
//                320: {
//                    items: 1
//                },
//                768: {
//                    items: 2
//                },
//                900: {
//                    items: 2
//                }
//            }
//
//
//        });
    }

});


