<?php

if (in_array('sb_framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/icons/icons.php';
    /* ------------------------------------------------ */
    /* Common Shortcode */
    /* ------------------------------------------------ */
    if (class_exists('Redux')) {
        if (Redux::getOption('adforest_theme', 'design_type') == 'modern') {

            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/classes/ads.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/ads-slider_modern.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/ads-slider_modern2.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/ads_google_map_modern.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/ad_post_modern.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/search_modern.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/search_hero.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/search_hero2.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/search_hero3.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/search_hero4.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/ads_cats_tabs_modern.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/grid_modern.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/clouds.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/cats_round.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/ads-countries.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/process_cycle_new.php';
            if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/shop_layout.php';
            }

            /* New Addition V XXX */

            /*
             * Realstate home  shortcodes files
             */

            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/ads_tab_modern6.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/ads_countries_listings.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/ads_team_member.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/call-to-action4.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest-services.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/ads_google_map2.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/search_modern2.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest-hero-realestate.php';
            
            /*
             * Mobile home  shortcodes files
             */
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest-slider.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest-brands.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/ads_slider.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest-category-ads-slider.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest-contact-info.php';

            /*
             * Service home  shortcodes files
             */
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest-hero-services.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest_search_services.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest_cats_services.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest-callto-action-service.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest_ads_listing_services.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest_shop_services.php';
            /*
             * Toyforest home  shortcodes files
             */
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest-hero-section-toy.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest-sales.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/call-to-action-toy.php';
            /*
             * Sports home  shortcodes files
             */
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest-hero-sports.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest_cats_sports.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest-locations-slider.php';
            /*
             * Decoration home  shortcodes files
             */
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest-hero-decoration.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/shop_layout_book.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/shop_layout_book_2.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest-hero-book.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest-users.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/products_fancy.php';

            
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/search_hero_classic.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/browse-categories.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/browse-categories2.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/call-to-action.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/call-to-action3.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/shop_layout2.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/shop_layout3.php';

            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/main-call-to-action.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/call-to-action-techy.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/ads-with-sidebar.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/partners_modern.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/success-stories-2.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/main-call-to-action-modern.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/main-call-to-action-modern2.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/process_cycle_new4.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/apps-call-to-action.php';

            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/apps-screenshots-slider.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/awesome-features-modern.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/faqs-modern.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/testimonial-modern.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/ad_post_fancy.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/ad_post_fancy.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest-visited-ads.php';
            
            /*
             * Adforest Directory
             */
            //require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/adforest-hero-directory.php';
            //require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/directory-callto-action-1.php';
            //require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/directory-how-it-works.php';
            //require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/directory-locations.php';
            //require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/directory-testimonial.php';
            //require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern2/directory-callto-action-2.php';
            
            
        } else {
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/ads_google_map.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/ad_post.php';
        }
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/short_codes_functions.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/woo_functions.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/classes/ads.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/classes/packages.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/classes/authentication.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/classes/profile.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/classes/ad_post.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/sign_up.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/sign_in.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/profile.php';



        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/ads.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/ads_cats_boxes.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/ads-slider.php';

        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/search_modern.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/search_simple.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/search_classic.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/search_minimal.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/search_fancy.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/search_stylish.php';

        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/cats_modern.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/cats_minimal.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/cats_fancy.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/cats_flat.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/cats_color.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/cats_tab.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/cats_classic.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/cats_classic_2.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/popular_cats.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/cats_1.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/blog.php';

// Woo Commerce is avtive
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/products_classic.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/products_simple.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/products_modern.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/products_new.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/products_minimal.php';
            require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/select_product.php';
        }


        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/about.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/why_chose.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/partners.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/partners_grid.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/partners_classic.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/apps.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/apps2.php';

        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/apps_classic.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/process_cycle.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/process_cycle3.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/fun_facts.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/modern/fun_facts2.php';

        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/call_to_action.php';


        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/text_block.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/faq.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/contact_us.php';
        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes/advertisement_720-90.php';
    }
}