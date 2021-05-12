<?php

function hex2rgba($color, $opacity = false) {
    $default = 'rgb(0,0,0)';
    if (empty($color))
        return $default;
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }
    if (strlen($color) == 6) {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
        return $default;
    }
    $rgb = array_map('hexdec', $hex);
    if ($opacity) {
        if (abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }
    return $output;
}

if (!function_exists('adforest_custom_theme_add_color')) {
    $adforest_theme_color_str = '';

    function adforest_custom_theme_add_color($custom_colors_arr = array(), $frontend = false) {
        global $adforest_theme_color_str, $adforest_theme;

        extract($custom_colors_arr);

        if (!$frontend) {
            $adforest_theme_color = '';
            $adforest_btn_hover_color = '';
            if (class_exists('Redux')) {
                $adforest_theme_color = Redux::getOption('adforest_theme', 'custom-theme-color');
                $adforest_btn_hover_color = Redux::getOption('adforest_theme', 'custom-btn-hover-color');
                $adforest_btn_border_color = Redux::getOption('adforest_theme', 'custom-btn-border-color');
            }
        }



        ob_start();

        if (isset($adforest_theme_color) && $adforest_theme_color != '') {
            ?>
            a , a:hover {
            color: <?php echo esc_html($adforest_theme_color); ?>;
            }
            .ad-favourited i.fa.fa-heart, .product-description .product-description-text p, .ad-sidebar-profile .ad-prof-raing p,.ads-grid-container .ads-grid-content p i, .ads-grid-container .ads-grid-panel span,.box h4 a:hover, .category-grid-box .short-description h2 a:hover, .category-grid-box .view-details:hover, .ad-listing .content-area h3 a:hover, .car-details h4:hover, .post-title a:hover, .post-info a:hover, .popular-categories li a:hover, .font-color, .ad-location-gird .location-title-disc h5:hover, .ad-location-gird .location-title-disc h5 a:hover, .footer-content .footer-widget .contact-info li:hover, .footer-content .footer-widget.links-widget li a:hover, .footer-content .news-widget .news-post a:hover, ul.category-list-style li a:hover, .funfacts h4 span, .singlepost-content .descs-box .short-history li b, .singlepost-content .descs-box .short-history li b a, .descs-box i, .share-ad .modal-body p a, .item-date a, .blog-sidebar .widget .widget-content .tagcloud a:hover, .blog-sidebar .widget .widget-content ul li a:hover, .comming-soon-grid .count-down #clock > span, .features .features-text h3:hover, .features .features-text h3 a:hover, .site-map-list li a:hover , .header-top ul li a:hover, .ad-archive-desc h2:hover, .ad-archive-desc h2 a:hover , .footer-area .contact-info li .icon , .heading-color , .ad-preview-details .overview-price span , .ad-listing .content-area .price , .category-grid-box-1 a:hover, .category-grid i , .hero .content p:first-child b , ul.category-list-data li:hover::before, ul.category-list-data li:hover a , ul.category-list-data li:hover a span , .category-list-title h5 > a:hover , .view-more a:hover , .category-grid-box .short-description .price , ul.category-list-style li:hover a i , .sidebar .side-menu nav .nav > li > a:hover , .filter-brudcrums-sort ul li a:hover , .skin-minimal .list li label:hover , .advertising .banner .submit , .recent-ads .recent-ads-list-price , .bread-3.page-header-area .small-breadcrumb .breadcrumb-link ul li a.active , .ad .content-zone .short-description-1 h2 a:hover , .user-profile ul li:hover a, .user-profile ul li.active a , .dashboard-menu-container ul li.active .menu-name , .dashboard-menu-container ul li:hover .menu-name , .tags-share .tags ul li a , .comment-list .comment .comment-info .author-desc .author-title li a:hover , .why-us:hover i, .why-us:hover h5 , .card .nav-tabs > li.active > a, .card .nav-tabs > li > a:hover , .accordion-title a:hover , .usefull-info .info-content h3:hover ,.mega-menu .drop-down a:hover, .mega-menu .drop-down-tab-bar a:hover , .ad-price , .recent-ads .recent-ads-list-title a:hover , .singleContadds i , .white.category-grid-box-1 .ad-info-1 ul li:hover, .white.category-grid-box-1 .ad-info-1 ul li a:hover , .widget.widget-content ul li a:hover , body .woocommerce table.shop_table tr.cart_item td a:hover , body .woocommerce table.shop_table td.product-remove a.remove:hover , .blog-post .post-excerpt a strong:hover , .category-list:hover .category-list-title h5 a , .category-list:hover .view-more a , .copyright-content p a , .content-zone .short-description-1 .list-3-short-info li a:hover , .single-blog.blog-detial .blog-post .post-excerpt p a, .message-inbox .message-header span a:hover, .message-inbox .message-header span a.active .footer-top .widget.my-quicklinks ul li a:hover , .listing-detail .listing-content .listing-title a:hover , .listing-detail .listing-content ul li span span.padding_cats a:hover , .new-small-grid-description h3 a:hover , .category_gridz .title:hover, .details-text-section .details-price h2, .details-post-ad .new-details-pages-links li a span, .single-details-page-links .single-details-list li a i, .single-details-page-links-right .reporting_section li a i, .new-feature-products span {
               color: <?php echo esc_html($adforest_theme_color); ?> !important;
            }
            .woocommerce #respond input#submit:hover, .woocommerce table.shop_table td .button:hover, .wc-proceed-to-checkout .button:hover, .place-order .button:hover , .woocommerce #respond input#submit.alt:hover , .woocommerce a.button.alt:hover , .woocommerce button.button.alt:hover , .woocommerce input.button.alt:hover,.sb-header-top4 .sb-dec-top-ad-post a:hover{
            background-color: <?php echo esc_html($adforest_btn_hover_color); ?> ;
            border: 1px solid <?php echo esc_html($adforest_btn_border_color); ?> ;
            }
            .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button , .woocommerce #respond input#submit.alt , .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt {
            text-transform: uppercase;
            background-color: <?php echo esc_html($adforest_theme_color); ?>;
            border-color: <?php echo esc_html($adforest_btn_border_color); ?>;
            border: 1px solid <?php echo esc_html($adforest_btn_border_color); ?> ;
            }
            .single-blog.blog-detial .blog-post .post-excerpt blockquote {
            border-left: 5px solid <?php echo esc_html($adforest_btn_border_color); ?>;
            }
            .post-password-form input[type="submit"] {
            background: <?php echo esc_html($adforest_theme_color); ?> none repeat scroll 0 0;
            border: 1px solid <?php echo esc_html($adforest_btn_border_color); ?>;
            color: #fff;
            padding: 2px 30px;
            }
            .sb-social-mobile a .fa,.shop-overlay-box .shop-icon, .ad-sidebar-form .ad-6-message::before, .featured-slider .owl-controls .owl-nav .owl-next:hover, .featured-slider-3.owl-carousel .owl-nav button.owl-prev,.featured-slider-3.owl-carousel .owl-nav button.owl-next, .featured-slider .owl-controls .owl-nav .owl-prev:hover .ms-layer.btn3:hover, .home-category-slider .category-slider .owl-controls .owl-nav .owl-next:hover, .home-category-slider .category-slider .owl-controls .owl-nav .owl-prev:hover, .subscribe button:hover , .featured-slider-1 .owl-controls .owl-nav .owl-next:hover, .featured-slider-1 .owl-controls .owl-nav .owl-prev:hover  , .btn-light:hover , .featured-slider-3 .owl-controls .owl-nav .owl-next:hover, .featured-slider-3 .owl-controls .owl-nav .owl-prev:hover , .hero-form-sub li a:hover , #google-map-btn a:hover , .modern-version-block-cat:hover , .featured-slider-5 .owl-controls .owl-nav .owl-next:hover, .featured-slider-5 .owl-controls .owl-nav .owl-prev:hover, .owl-carousel .owl-nav button.owl-next, .owl-carousel .owl-nav button.owl-prev, .owl-carousel button.owl-dot, .owl-carousel .owl-nav button.owl-next:hover, .owl-carousel .owl-nav button.owl-prev:hover, .owl-carousel button.owl-dot:hover {
            background-color: <?php echo esc_html($adforest_theme_color); ?> !important;
            }
            .app-download-button.hover, .app-download-button:hover, .app-download-button.focus, .app-download-button:focus, .app-download-button:active, .app-download-button.active, .ms-layer.btn3, .minimal-footer-1 .widget .social-links a:hover, .subscribe button, .social-area-share > a:hover , .search-section .search-options > li .btn.btn-danger:hover , .featured-slider-1 .owl-controls .owl-nav .owl-next, .featured-slider-1 .owl-controls .owl-nav .owl-prev , .featured-slider .owl-controls .owl-nav .owl-next, .featured-slider .owl-controls .owl-nav .owl-prev, .featured-slider-3 .owl-controls .owl-nav .owl-next, .featured-slider-3 .owl-controls .owl-nav .owl-prev , .small-breadcrumb .breadcrumb-link ul li a::after , .user-profile .badge , .ps-container > .ps-scrollbar-y-rail > .ps-scrollbar-y , .select2-container--default .select2-results__option--highlighted[aria-selected] , .mega-menu .menu-links > li.activeTriggerMobile , .dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus , .featured-slider-5 .owl-controls .owl-nav .owl-next, .featured-slider-5 .owl-controls .owl-nav .owl-prev, .owl-carousel button.owl-dot, .owl-carousel .owl-nav button.owl-next:hover, .owl-carousel .owl-nav button.owl-prev:hover, .owl-carousel button.owl-dot:hover {
            background-color: <?php echo esc_html($adforest_btn_hover_color); ?> !important;
            }
            .btn-success,.browse-feature-icons i:hover {
            background-color: <?php echo esc_html($adforest_theme_color); ?> !important;
            border-color: <?php echo esc_html($adforest_btn_border_color); ?> !important;
            }
            .btn-success:hover {
            background-color: <?php echo esc_html($adforest_btn_hover_color); ?> !important;
            border-color: <?php echo esc_html($adforest_btn_border_color); ?> !important;
            }
            span.app-store-btn:hover, .social-links-two a:hover , .search-section .search-options > li .btn.btn-danger:hover, .details-buttons .details-click-view .btn-primary, .details-buttons .details-messages .btn-primary {
            border: 1px solid <?php echo esc_html($adforest_btn_border_color); ?> !important;
            }
            .slide-thumbnail .flex-active-slide img {
            border-color: <?php echo esc_html($adforest_btn_border_color); ?> !important;
            }
            .pagination > .active > a:hover, .pagination li:hover > a, .pagination > .active > a , .category-grid .custom-cat:hover , .pricing .featured a.btn-theme:hover , .btn-orange, .header-social-h2 .list-inline li .btn-primary {
            background-color: <?php echo esc_html($adforest_theme_color); ?>;
            border-color: <?php echo esc_html($adforest_btn_border_color); ?>;
            color: #fff !important;
            }
            .small-breadcrumb .breadcrumb-link ul li a.active {
            border-bottom: 4px solid <?php echo esc_html($adforest_btn_border_color); ?>;
            color: <?php echo esc_html($adforest_theme_color); ?>;
            font-weight: 600;
            }
            .popup-cls.close::before {
            border-color: rgba(0, 0, 0, 0) <?php echo esc_html($adforest_btn_border_color); ?>;
            border-style: solid;
            border-width: 0 70px 70px 0;
            content: "";
            display: block;
            height: 0;
            position: absolute;
            right: 0;
            top: 0;
            width: 0;
            z-index: -1;
            }
            .grid-panel .location-icon i , .widget-newsletter .fieldset form .submit-btn , .ad-listing .content-area .additional-info li a:hover , .noUi-connect , .card .nav-tabs > li > a::after , .ad-listing-price p , .mega-menu .drop-down-multilevel li.activeTriggerMobile , .mega-menu .drop-down-multilevel li:hover , .blog-sidebar .widget.widget-content .tagcloud a:hover, .new-shortcode .tab .nav-tabs li.active a, .new-shortcode .tab .nav-tabs li a:hover{
            background: <?php echo esc_html($adforest_theme_color); ?> none repeat scroll 0 0 !important;
            }
            .cd-top {
            background: <?php echo esc_html($adforest_theme_color); ?> url(../../images/cd-top-arrow.svg) no-repeat center 50%;
            }
            .heading-panel .main-title {
            border-bottom: 2px solid <?php echo esc_html($adforest_btn_border_color); ?>;
            }
            .mega-menu .drop-down a, .mega-menu .drop-down-tab-bar a {
            color:#232323;
            }
            .mega-menu .menu-search-bar li .btn:hover{
            color:#fff;
            }
            .btn-theme , .btn-light {
            color: #ffffff;
            background-color: <?php echo esc_html($adforest_theme_color); ?>;
            border-color: <?php echo esc_html($adforest_btn_border_color); ?>;
            }
            .btn-theme:hover, .btn-theme:focus, .btn-theme:active, .btn-theme.active, .open .dropdown-toggle.btn-theme , .btn-orange:hover, .header-social-h2 .list-inline li .btn-primary:hover{
            color: #ffffff;
            background-color: <?php echo esc_html($adforest_btn_hover_color); ?>;
            border-color: <?php echo esc_html($adforest_btn_border_color); ?>;
            }
            .btn-theme:active, .btn-theme.active, .open .dropdown-toggle.btn-theme {
            background-image: none;
            }
            .btn-theme.disabled, .btn-theme[disabled], fieldset[disabled] .btn-theme, .btn-theme.disabled:hover, .btn-theme[disabled]:hover, fieldset[disabled] .btn-theme:hover, .btn-theme.disabled:focus, .btn-theme[disabled]:focus, fieldset[disabled] .btn-theme:focus, .btn-theme.disabled:active, .btn-theme[disabled]:active, fieldset[disabled] .btn-theme:active, .btn-theme.disabled.active, .btn-theme[disabled].active, fieldset[disabled] .btn-theme.active {
            background-color: <?php echo esc_html($adforest_theme_color); ?>;
            border-color: <?php echo esc_html($adforest_btn_border_color); ?>;
            }
            .btn-theme .badge {
            color: <?php echo esc_html($adforest_theme_color); ?>;
            background-color: #ffffff;
            }
            .country-box:hover .country-description {
            background-color: rgba(231, 76, 60, 0.8);
            }
            .profile-tabs .nav-tabs {
            border-color: -moz-use-text-color -moz-use-text-color <?php echo esc_html($adforest_btn_border_color); ?> ;
            }
            .user-profile ul li.active a::before {
            border-left: 9px solid <?php echo esc_html($adforest_btn_border_color); ?>;
            }
            .user-profile ul li.active a {
            border-left: 3px solid <?php echo esc_html($adforest_btn_border_color); ?>;
            }
            .add-pages > span, .details-buttons .details-messages .btn-primary:hover,   .add-pages > span, .details-buttons .details-messages .btn-primary:hover {
            color:#fff !important;
            background-color: <?php echo esc_html($adforest_theme_color); ?> !important;
            border: 1px solid <?php echo esc_html($adforest_btn_border_color); ?>;
            }
            ul.filterAdType li.active .filterAdType-count, ul.filterAdType li .filterAdType-count:hover {
            background: <?php echo esc_html($adforest_theme_color); ?> none repeat scroll 0 0;
            color: #fff;
            }
            .sb_tag, div.sidebar .ad-type, .details-buttons .details-click-view .btn-primary { background: <?php echo esc_html($adforest_theme_color); ?> !important; }
            .mat-hero-text-section h1 span, .tech-mac-book h1 span, .tech-latest-primary-section h3 .explore-style, .tech-view-section h2 span, .land-classified-heading h3 span, .land-classified-text-section .list-inline li i, .land-qs-heading-section h3 span, .land-one-rating i, .mat-new-candidates-categories p, .shop-great-products .shop-old-price strike{color:<?php echo esc_html($adforest_theme_color); ?> !important;}
            .tech-new-great-product .new-all-categories, .shop-great-products .shops-cart a{background-color: <?php echo esc_html($adforest_theme_color); ?> !important;}
            .tech-new-prices strike { color: <?php echo esc_html($adforest_theme_color); ?> !important; }
            .land-one-slider-2 div.owl-dots button.owl-dot{ background-color: transparent !important; }

            .tabbable-line > .nav-tabs > li.active > a {background-color: <?php echo esc_html($adforest_theme_color); ?> !important;}
            .srvs-prov-text h4 {color: <?php echo esc_html($adforest_theme_color); ?>;}
            .sb-header-top3 .sb-mob-top-bar {background:<?php echo esc_html($adforest_theme_color); ?> !important;; }

            .sw-theme-default>ul.step-anchor>li>a::after {background: <?php echo esc_html($adforest_theme_color); ?> !important; }
            .postdetails .sw-theme-default > ul.step-anchor > li.active > a {color: <?php echo esc_html($adforest_theme_color); ?> !important; }
            .sw-theme-default>ul.step-anchor>li.done>a::after {background: #5cb85c !important;}
            .listing-detail .listing-content span.listing-price,.adforest-user-ads b {color: <?php echo esc_html($adforest_theme_color); ?> !important;}

            .toys-hero-section .toys-new-accessories .toys-hero-content{background: <?php echo esc_html($adforest_theme_color); ?> !important;}
            .toys-call-to-action{background-color: <?php echo esc_html($adforest_theme_color); ?>;}
            .sb-dec-top-bar{background:linear-gradient(90deg, #ffffff 26%, <?php echo esc_html($adforest_theme_color); ?> 0%)}
            .sb-header-top4 .sb-dec-top-ad-post a i, .dec-featured-details-section p i,.prop-estate-text-section p i{color: <?php echo esc_html($adforest_theme_color); ?> !important;}
             .sb-header-top4 .sb-dec-top-ad-post a:hover i{color: <?php echo esc_html($adforest_theme_color); ?> !important;}
            .sprt-header-box i{background: <?php echo esc_html($adforest_theme_color); ?> !important;}
            .sb-modern4-header .sb-bk-search-area .sb-bk-side-btns .sb-bk-srch-links .sb-bk-srch-contents .sb-bk-absolute{background:<?php echo esc_html($adforest_theme_color); ?>;}
            .sb-modern4-header .sb-bk-search-area .sb-bk-side-btns .sb-bk-srch-links .sb-bk-srch-contents li:first-child,.sb-modern-header .sb-colors-combination-c1 .sb-header-social-h2 .list-inline li .btn-primary{border: 1px solid <?php echo esc_html($adforest_btn_border_color); ?>;}
            .dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus{background: <?php echo esc_html($adforest_theme_color); ?> !important;}
            .sb-modern4-header .sb-latest-book-menu .sb-sprt-header .sb-srvs-top-header .sb-top-header-3 .sb-top-header .mega-menu.menu-2 {background-color:<?php echo esc_html($adforest_theme_color); ?>;}
            .sb-header-top2 .sb-dec-top-bar {
                background: linear-gradient(45deg, #ffffff 24%,<?php echo esc_html($adforest_theme_color); ?> 0%);
            }
            .category-grid-box .category-grid-img .ad-status {background-color: <?php echo esc_html(hex2rgba($adforest_theme_color, 0.8)); ?> !important;}
            .label.label-warning{background: <?php echo esc_html($adforest_theme_color); ?> none repeat scroll 0 0;}
            .rating i,.seller-public-profile .seller-public-profile-star-icons i{color:<?php echo esc_html($adforest_theme_color); ?> !important;}
            #accordion .panel-body.categories ul li a:hover,.description-right-area .description-new-prices{color:<?php echo esc_html($adforest_theme_color); ?>}
            .sticky-post-button{background-color:<?php echo esc_html($adforest_theme_color); ?>;}
            .sticky-post-button:hover,.ad-button-r1 .btn-primary:hover,.submit-categories .btn-primary:hover,.shops-cart a:hover{background-color:<?php echo esc_html($adforest_btn_hover_color); ?>;}
            .hero-form-sub li a{background-color:<?php echo esc_html($adforest_theme_color); ?>;}
            .shop-overlay-box .shop-icon, .ad-sidebar-style{background-color:<?php echo esc_html($adforest_theme_color); ?>;}
            .product-description .product-description-text p,.browse-feature-products .list-inline li a:hover,.browse-text-h4 i{color:<?php echo esc_html($adforest_theme_color); ?>;}
            .submit-categories .btn-primary,.shops-cart a{background-color:<?php echo esc_html($adforest_theme_color); ?>;}
            .product-description .product-description-heading h3 a:hover {color:<?php echo esc_html($adforest_btn_hover_color); ?>;}
            .single-blog.blog-detial .blog-post .post-excerpt .woocommerce .order-again a, .des-hero-adres p i,.des-us-details ul li,.des-price ul li span{color: #ffffff !important;}
            .social-links-two a:hover{background: <?php echo esc_html($adforest_theme_color); ?> none repeat scroll 0 0;}
            .tab-description .card .woocommerce-tabs ul li.active a {color: <?php echo esc_html($adforest_theme_color); ?> ; border-bottom: 2px solid <?php echo esc_html($adforest_theme_color); ?>;}
            .card.bid-state-2 .nav-tabs > li > a:hover {background: <?php echo esc_html($adforest_theme_color); ?>;   color: #FFF !important;}
            .ad-price-tble .ad-pric-content .ad-pic-style{background: linear-gradient(to right, <?php echo esc_html($adforest_btn_hover_color); ?>, <?php echo esc_html($adforest_theme_color); ?>);}
             .ad-price-tble .ad-pric-content .ad-pic-style .ad-pric-box h5::before, .ad-bid-pricetg span, .sb-modern-header .sb-colors-combination-c1 .sb-header-social-h2 .list-inline li .btn-primary {background-color: <?php echo esc_html($adforest_theme_color); ?>;}
             .ad-bid-pricetg span::before{border-right-color: <?php echo esc_html($adforest_theme_color); ?>;}
             
             .sb-light-header .sb-colored-header .sb-new-version .mega-menu .menu-search-bar li a.btn:hover,
             .btn-light:hover{background-color:<?php echo esc_html($adforest_btn_hover_color);?> !important;}
             
             .sb-header-top2 .sb-dec-top-ad-post a:hover,.sb-modern-header .sb-colors-combination-c1 .sb-header-social-h2 .list-inline li .btn-primary:hover {
                    color: #ffffff;
                    background-color: <?php echo esc_html($adforest_btn_hover_color);?>;
                    border-color: <?php echo esc_html($adforest_btn_border_color); ?>;
                }
                
                .sb-header-top2 .sb-dec-top-ad-post a i{color: <?php echo esc_html($adforest_theme_color);?>;}
             
             
             
             @media (min-width: 320px) and (max-width: 767px) {.sb-header-top2 .sb-dec-top-bar {background:  <?php echo esc_html($adforest_theme_color); ?>;}}
             @media (min-width: 768px) and (max-width: 991px) {.sb-header-top2 .sb-dec-top-bar {background:  <?php echo esc_html($adforest_theme_color); ?>;}}
            .sb-transparent2-header .sb-top-header-3 .sb-top-header .mega-menu.menu-2 .sb-header-social-h2 .list-inline .sb-new-social-icons-bars a i, .sb-sprt-header-box i{background-color:<?php echo esc_html($adforest_theme_color); ?> !important;}
             
   <?php
        }
        $adforest_theme_color_str = ob_get_contents();
        ob_end_clean();
        return $adforest_theme_color_str;
    }

}



add_action('wp_ajax_adforest_custom_theme_color', 'adforest_custom_theme_color_callback');
add_action('wp_ajax_nopriv_adforest_custom_theme_color', 'adforest_custom_theme_color_callback');

if (!function_exists('adforest_custom_theme_color_callback')) {

    function adforest_custom_theme_color_callback() {

        $theme_color = isset($_POST['theme_color']) && !empty($_POST['theme_color']) ? $_POST['theme_color'] : '#f58936';
        $custom_btn_hover = isset($_POST['custom_btn_hover']) && !empty($_POST['custom_btn_hover']) ? $_POST['custom_btn_hover'] : '#f58936';
        $btn_border_color = isset($_POST['btn_border_color']) && !empty($_POST['btn_border_color']) ? $_POST['btn_border_color'] : '#f58936';
        $colors_array = array(
            'adforest_theme_color' => $theme_color,
            'adforest_btn_hover_color' => $custom_btn_hover,
            'adforest_btn_border_color' => $btn_border_color,
        );
        $custom_css_code = adforest_custom_theme_add_color($colors_array, true);
        echo esc_html($custom_css_code);
        wp_die();
    }

}


if (!function_exists('adforest_generate_custom_color_css')) {

    function adforest_generate_custom_color_css() {
        global $wp_filesystem;
        require_once (ABSPATH . '/wp-admin/includes/file.php');
        $adforest_page_url = wp_nonce_url('themes.php?page=adforest_theme_options');
        if (false === ($creds = request_filesystem_credentials($adforest_page_url, '', false, false, array()) )) {
            return true;
        }
        if (!WP_Filesystem($creds)) {
            request_filesystem_credentials($adforest_page_url, '', true, false, array());
            return true;
        }
        $adforest_filename = trailingslashit(get_template_directory()) . 'css/colors/custom-theme-color.css';
        $adforest_color_css = adforest_custom_theme_add_color();
        $wp_filesystem->put_contents($adforest_filename, $adforest_color_css, FS_CHMOD_FILE);
    }

}
?>