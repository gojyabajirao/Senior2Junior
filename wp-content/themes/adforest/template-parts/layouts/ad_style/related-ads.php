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
        echo adforest_returnEcho($ads->adforest_get_ads_grid_slider($args, $adforest_theme['sb_related_ads_title']));
    } else {
        echo adforest_returnEcho($ads->adforest_get_ads_list_style($args, $adforest_theme['sb_related_ads_title']));
    }
}
?>