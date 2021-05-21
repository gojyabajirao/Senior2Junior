<?php

global $adforest_theme;
$pid = get_the_ID();
if ($adforest_theme['Related_ads_on']) {
    $cats = wp_get_post_terms($pid, 'ad_cats');
    $categories = array();
    foreach ($cats as $cat) {
        $categories[] = $cat->term_id;
    }
    $is_active = array(
        'key' => '_adforest_ad_status_',
        'value' => 'active',
        'compare' => '=',
    );
    $args = array(
        'post_type' => 'ad_post',
        'post_status' => 'publish',
        'posts_per_page' => $adforest_theme['max_ads'],
        'order' => 'DESC',
        'post__not_in' => array($pid),
        'tax_query' => array(
            array(
                'taxonomy' => 'ad_cats',
                'field' => 'id',
                'terms' => $categories,
                'operator' => 'IN',
                'include_children' => 0,
            )
        ),
        'meta_query' => array(
            $is_active,
        ),
    );
    $ads = new ads();
    if ($adforest_theme['related_ad_style'] == '1') {
        //echo adforest_returnEcho($ads->adforest_get_ads_grid_slider($args, $adforest_theme['sb_related_ads_title']));
        $titile = $adforest_theme['sb_related_ads_title'];

        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $args = apply_filters('adforest_site_location_ads', $args, 'ads');
        $grid_type = 'grid_1';
        if (isset($adforest_theme['featured_ad_slider_layout']) && $adforest_theme['featured_ad_slider_layout'] != "") {
            $grid_type = $adforest_theme['featured_ad_slider_layout'];
        }
        $ads = new WP_Query($args);

        $ads_clone = new ads();
        $my_ads = '';

        if ($ads->have_posts()) {
            $titile = $adforest_theme['sb_related_ads_title'];
            $titile = isset($titile) && !empty($titile) ? $titile : __('Related Ads', 'adforest');
            $my_ads .= '<div class="heading-panel">
                            <div class="col-xs-12 col-md-12 col-sm-12">
                                <div class="main-title text-left">
                                   ' . $titile . '
                                </div>
                            </div>
                        </div>';
            $my_ads .= '<div class="ad-grid-slider owl-carousel owl-theme margin-bottom-30">';
            while ($ads->have_posts()) {
                $ads->the_post();
                $pid = get_the_ID();
                $function = "adforest_search_layout_$grid_type";
                $my_ads .= '<div class="item">';
                $my_ads .= $ads_clone->$function($pid, 12, 12);
                $my_ads .= '</div>';
            }
            $my_ads .= '</div>';
            wp_reset_postdata();
            echo adforest_returnEcho($my_ads);
        }
    } else {
        echo adforest_returnEcho($ads->adforest_get_ads_list_style($args, $adforest_theme['sb_related_ads_title']));
    }
}
?>