<?php global $adforest_theme;?>
<?php

$layout = 'list_2';
if (isset($adforest_theme['search_layout']) && $adforest_theme['search_layout'] != "") {
    $layout = $adforest_theme['search_layout'];
}

$mapType = adforest_mapType();

if (isset($type)) {
    $layout = $type;
}
$out = '';
if ($layout == 'list_1') {
    $out .= '<div class="col-md-12 col-xs-12 col-sm-12">
   <div id="products" class=" mid-container list-group">
      <div class="row">';
} else if ($layout == 'list_2') {
    $out .= '<div class="posts-masonry">
		   <div class="col-md-12 col-xs-12 col-sm-12">';
} else if ($layout == 'list_3') {
    $out .= '<div class="col-md-12 col-sm-12 col-xs-12">
   					<ul>';
}
// The Loop
$marker_counter = 1;
while ($results->have_posts()) {
    $results->the_post();
    $pid = get_the_ID();
    $ads = new ads();
    $option = $layout;
    $function = "adforest_search_layout_$option";
    $out .= $ads->$function($pid);
    if (isset($map_script) && $map_script != "") {
        $title = addslashes(get_the_title());
        $img = '';
        $media = adforest_get_ad_images($pid);
        if (count($media) > 0) {
            foreach ($media as $m) {
                $mid = '';
                if (isset($m->ID))
                    $mid = $m->ID;
                else
                    $mid = $m;

                $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                $img = $image[0];
                break;
            }
        }
        else {
            $img = adforest_get_ad_default_image_url('adforest-ad-related');
        }
        $price = addslashes(strip_tags(adforest_adPrice(get_the_ID())));
        $location = addslashes(get_post_meta(get_the_ID(), '_adforest_ad_location', true));
        $p_date = get_the_date(get_option('date_format'), get_the_ID());
        $ad_class = '';
        $is_feature = get_post_meta(get_the_ID(), '_adforest_is_feature', true);
        if ($is_feature == '1') {
            $ad_class = addslashes(__('Featured', 'adforest'));
        }

        $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
        $cat_name = '';
        $cat_link = '';
        foreach ($post_categories as $current_cat) {
            $cat = get_term($current_cat);
            $cat_name = addslashes($cat->name);
            $cat_link = addslashes(get_term_link($cat->term_id));
        }
        $lat = '';
        $lon = '';
        if (get_post_meta($pid, '_adforest_ad_map_lat', true) != "" && get_post_meta($pid, '_adforest_ad_map_long', true) != "") {
            $lat = get_post_meta($pid, '_adforest_ad_map_lat', true);
            $lon = get_post_meta($pid, '_adforest_ad_map_long', true);
        } else {
            if ($location != "") {
                global $wpdb;
                $table_name = $wpdb->prefix . 'adforest_locations';
                $loc_arr = explode(',', $location);
                if (count($loc_arr) > 0) {
                    $city = $loc_arr[0];
                    $is_city = $wpdb->get_row("SELECT latitude, longitude FROM $table_name WHERE location_type = 'city'  AND name = '$city'");
                    if (isset($is_city->latitude)) {
                        $lat = $is_city->latitude;
                        $lon = $is_city->longitude;
                    }
                }
            }
        }
        if ($lat != "" && $lon != "") {
            $lat_arr = explode('.', $lat);
            //$lat	=	$lat_arr[0] . '.' . ((int)$lat_arr[1] + (int)mt_rand(100000,5000000));

            $lon_arr = explode('.', $lon);
            //$lon	=	$lon_arr[0] . '.' . ((int)$lon_arr[1] + (int)mt_rand(100000,5000000));


            if ($mapType == 'leafletjs_map') {
                $map_script .= '{
						"img":"' . esc_url($img) . '",
						"price":"' . ($price) . '",
						"ad_class":"' . ($ad_class) . '",
						"cat_link":"' . ($cat_link) . '",
						"cat_name":"' . ($cat_name) . '",
						"title":"' . ($title) . '",
						"location":"' . ($location) . '",
						"ad_link":"' . get_the_permalink($pid) . '",
						"p_date":"' . ($p_date) . '",
						"lat":"' . ($lat) . '",
						"lon":"' . ($lon) . '",
						"marker_counter":"' . ($marker_counter) . '",
						"imageUrl":"",
					},';
            } else if ($mapType == 'google_map') {
                $map_script .= "[locationData('$img','$price','$ad_class','$cat_link','$cat_name','$title','$location','" . get_the_permalink($pid) . "','$p_date'), '$lat', '$lon', '$marker_counter', imageUrl],";
            }

            $marker_counter++;
        }
    }
}
if ($layout == 'list_1') {
    $out .= '</div></div></div>';
} else if ($layout == 'list_2') {
    $out .= '</div></div>';
} else if ($layout == 'list_3') {
    $out .= '</ul></div>';
}
?>