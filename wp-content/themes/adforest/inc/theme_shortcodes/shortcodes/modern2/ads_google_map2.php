<?php
/* ------------------------------------------------ */
/* ADs - Google Map 2 */
/* ------------------------------------------------ */
if (!function_exists('ads_google_map2_short')) {

    function ads_google_map2_short() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat');

        vc_map(array(
            "name" => __("ADs - Google Map 2", 'adforest'),
            "base" => "ads_google_map2_short_base",
            "category" => __("Theme Shortcodes - 2", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('ad_google_map2.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "textfield",
                    "heading" => __("Ads Title", 'adforest'),
                    "description" => __("Add the title of ads that dispaly at the top of the sidebar ads listings.", 'adforest'),
                    "param_name" => "ads_title",
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Ads Type", 'adforest'),
                    "param_name" => "ad_type",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Ads Type', 'adforest') => '',
                        __('Featured Ads', 'adforest') => 'feature',
                        __('Simple Ads', 'adforest') => 'regular',
                        __('Both', 'adforest') => 'both'
                    ),
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Order By", 'adforest'),
                    "param_name" => "ad_order",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Ads order', 'adforest') => '',
                        __('Oldest', 'adforest') => 'asc',
                        __('Latest', 'adforest') => 'desc',
                        __('Random', 'adforest') => 'rand'
                    ),
                ),
                array(
                    "group" => __("Map", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Map Marker", 'adforest'),
                    "param_name" => "map_marker_img",
                    "description" => __("50x77", 'adforest'),
                ),
                array(
                    "group" => __("Map", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Map Marker Many", 'adforest'),
                    "param_name" => "map_marker_more_img",
                    "description" => __("50x77", 'adforest'),
                ),
                array(
                    "group" => __("Map", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Map Zoom", 'adforest'),
                    "param_name" => "map_zoom",
                    "admin_label" => true,
                    "value" => range(1, 12),
                    "std" => 5,
                ),
                array(
                    "group" => __("Map", "adforest"),
                    "type" => "textfield",
                    "heading" => __("Latitude", 'adforest'),
                    "description" => __("That Area will be display in map after loading but user can change it by dragging.", 'adforest'),
                    "param_name" => "map_latitude",
                ),
                array(
                    "group" => __("Map", "adforest"),
                    "type" => "textfield",
                    "heading" => __("Longitude", 'adforest'),
                    "param_name" => "map_longitude",
                ),
                array(
                    "group" => __("Map", "adforest"),
                    "type" => "textfield",
                    "heading" => __("Map infobox address limit", 'adforest'),
                    "param_name" => "map_info_address_limit",
                    "description" => __("Characters limit should be integer value", 'adforest'),
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Number fo Ads for each category", 'adforest'),
                    "param_name" => "no_of_ads",
                    "admin_label" => true,
                    "value" => range(1, 500),
                ),
                //Group For Left Section
                array
                    (
                    'group' => __('Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        (
                        $cat_array,
                        array(
                            "type" => "attach_image",
                            "holder" => "bg_img",
                            "class" => "",
                            "heading" => __("Category Marker Image", 'adforest'),
                            "param_name" => "img",
                            "description" => __("80x120", 'adforest'),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'ads_google_map2_short');
if (!function_exists('ads_google_map2_short_base_func')) {

    function ads_google_map2_short_base_func($atts, $content = '') {
        global $adforest_theme;
        extract(shortcode_atts(array(
            'cats' => '',
            'ads_title' => '',
            'ad_type' => '',
            'ad_order' => '',
            'no_of_ads' => '',
            'map_latitude' => '',
            'map_longitude' => '',
            'map_zoom' => '',
            'map_marker_img' => '',
            'map_marker_more_img' => '',
            'map_info_address_limit' => '',
                        ), $atts));
        wp_enqueue_style('adforest-perfect-scrollbar');
        wp_enqueue_script('adforest-perfect-scrollbar');

        $address_limit = isset($map_info_address_limit) && $map_info_address_limit != '' ? $map_info_address_limit : '';

        $map_id = 'map-' . rand(1234, 99999);

        $listing_title = $ads_title;
        $ads_html = '';
        $ads = new ads();
        $rows = vc_param_group_parse_atts($atts['cats']);
        $rows = apply_filters('adforest_validate_term_type', $rows);
        $marker = trailingslashit(get_template_directory_uri()) . 'images/car-marker.png';
        $close_url = trailingslashit(get_template_directory_uri()) . 'images/close.gif';
        $marker_more = trailingslashit(get_template_directory_uri()) . 'images/car-marker-more.png';


        if ($map_marker_img != "") {
            $img1 = wp_get_attachment_image_src($map_marker_img, 'full');
            $marker = $img1[0];
        }
        if ($map_marker_more_img != "") {
            $img2 = wp_get_attachment_image_src($map_marker_more_img, 'full');
            $marker_more = $img2[0];
        }

        $listing_json = '';

        $mapType = adforest_mapType();
        if ($mapType == 'leafletjs_map') {
            $listing_json = '<script>var search_map_zoom = ' . $map_zoom . '; var listing_markers = [';
        } else if ($mapType == 'google_map') {
            $listing_json = '<script> var imageUrl = "' . $marker . '";
			var imageUrl_more	=	"' . $marker_more . '";
			var search_map_lat	=	"' . $map_latitude . '";
			var search_map_long	=	"' . $map_longitude . '";
			var search_map_zoom	=	' . $map_zoom . ';
			var close_url	=	"' . $close_url . '";
			var show_radius	=	"";
			var locations = [';
        }


        $marker = '';
        if (isset($row['img'])) {
            $marker = adforest_returnImgSrc($row['img']);
        } else {
            $marker = trailingslashit(get_template_directory_uri()) . 'images/map-marker-blue.png';
        }

        $cats = array();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    if ($row['cat'] != 'all') {
                        if (!in_array($row['cat'], $cats)) {
                            $cats[] = $row['cat'];
                        }
                    }
                }
            }
        }

        $category = '';
        if (isset($cats) && !empty($cats) && count($cats) > 0) {
            $category = array(
                'taxonomy' => 'ad_cats',
                'field' => 'term_id',
                'terms' => $cats,
            );
        }

        $ordering = 'DESC';
        $order_by = 'date';
        if ($ad_order == 'asc') {
            $ordering = 'ASC';
        } else if ($ad_order == 'desc') {
            $ordering = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }

        $countries_location = '';
        $countries_location = apply_filters('adforest_site_location_ads', $countries_location, 'search');

        $args = array(
            'post_type' => 'ad_post',
            'post_status ' => 'publish',
            'posts_per_page' => $no_of_ads,
            'meta_query' => array(
                array(
                    'key' => '_adforest_ad_status_',
                    'value' => 'active',
                    'compare' => '=',
                ),
            ),
            'orderby' => $order_by,
            'order' => $ordering,
        );


        if ($category != '') {
            $args['tax_query'][] = $category;
        }
        if ($countries_location != '') {
            $args['tax_query'][] = $countries_location;
        }

        if ($ad_type == 'feature') {
            $args['meta_query'][] = array(
                'key' => '_adforest_is_feature',
                'value' => 1,
                'compare' => '=',
            );
        } else if ($ad_type == 'both') {
            
        } else {
            $args['meta_query'][] = array(
                'key' => '_adforest_is_feature',
                'value' => 0,
                'compare' => '=',
            );
        }

        $args = apply_filters('adforest_wpml_show_all_posts', $args);

        $results = new WP_Query($args);
        if ($results->have_posts()) {
            $marker_counter = 1;
            while ($results->have_posts()) {
                $results->the_post();
                $pid = get_the_ID();
                $title = get_the_title();
                $ads_html .= $ads->adforest_search_layout_list_4(get_the_ID());
                $img = '';
                $media = adforest_get_ad_images($pid);
                if (count($media) > 0) {
                    foreach ($media as $m) {
                        $mid = '';
                        if (isset($m->ID))
                            $mid = $m->ID;
                        else
                            $mid = $m;

                        $image = wp_get_attachment_image_src($mid, 'adforest-ads-medium');
                        $img = $image[0];
                        break;
                    }
                }
                else {
                    $img = adforest_get_ad_default_image_url('adforest-ads-medium');
                }
                $price = strip_tags(adforest_adPrice(get_the_ID()));
                $location = get_post_meta(get_the_ID(), '_adforest_ad_location', true);
                $p_date = get_the_date(get_option('date_format'), get_the_ID());
                $ad_class = '';
                $is_feature = get_post_meta(get_the_ID(), '_adforest_is_feature', true);
                if ($is_feature) {
                    $ad_class = __('Featured', 'adforest');
                }
                $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
                $cat_name = '';
                $cat_link = '';
                foreach ($post_categories as $c) {
                    $cat = get_term($c);
                    $cat_name = $cat->name;
                    $cat_link = get_term_link($cat->term_id);
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
                if ($address_limit != '') {
                    $location = adforest_words_count($location, $address_limit);
                }
                if ($lat == "" || $lon == "")
                    continue;

                if ($mapType == 'leafletjs_map') {
                    $listing_json .= '{
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
						"imageUrl":""
					},';
                } else if ($mapType == 'google_map') {
                    $listing_json .= "['<div class=recent-ads><div class=recent-ads-list> <div class=recent-ads-container><div class=recent-ads-list-image><div class=featured-ribbon><span>$ad_class</span></div><a href=" . get_the_permalink($pid) . " class=recent-ads-list-image-inner> <img alt=" . $title . " src=" . $img . "></a> </div><div class=recent-ads-list-content><h3 class=recent-ads-list-title><a href=" . get_the_permalink($pid) . ">$title</a></h3><ul class=recent-ads-list-location><li><a href=javascript:void(0);> $location </a></li></ul><div class=recent-ads-list-price> $price</div></div></div></div></div>','$lat', '$lon', '$marker_counter', '$marker'],";
                }
                $marker_counter++;
            }
        }

        if ($mapType == 'google_map') {
            $listing_json .= ']; var map_lat = "' . $map_latitude . '"; var map_lon = "' . $map_longitude . '"; var zoom_option = ' . $map_zoom . ';</script>';
        } else {
            $listing_json .= "];</script>";
        }

        wp_reset_postdata();


        $leaflet_jsJS = '';
        if ($mapType == 'leafletjs_map') {
            wp_enqueue_script('oms');

            $marker_url = trailingslashit(get_template_directory_uri()) . 'images/map-pin.png';
            if ($marker != "") {
                $marker_url = $marker;
            }

            $leaflet_jsJS = '<script type="text/javascript">
			var map_lat = "' . $map_latitude . '";
			var map_long = "' . $map_longitude . '";
			if(map_lat  &&  map_long )
			{			
			var my_icons = "' . $marker_url . '";
			if(jQuery("#' . $map_id . '").length){
			var map = L.map("' . $map_id . '").setView([map_lat, map_long], "' . $map_zoom . '");
			L.tileLayer("https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png").addTo( map );
			var myIcon = L.icon({
				  iconUrl:  my_icons,
				  iconRetinaUrl:   my_icons,
				  iconSize: [25, 40],
				  iconAnchor: [10, 30],
				  popupAnchor: [0, -35]
			});
				adforest_mapCluster();
			}
			}
				
			jQuery("#reset_state").on("click", function(){
				if(jQuery("#' . $map_id . '").length)
				{
					adforest_mapCluster();
				}	
			});
			jQuery("#you_current_location").click(function () {
                            jQuery.ajax({
                                url: "https://geoip-db.com/jsonp",
                                jsonpCallback: "callback",
                                dataType: "jsonp",
                                success: function (location) {
                                  map.setView([location.latitude, location.longitude], 12);
                                }
                            });
                        });
			function adforest_mapCluster()
			{
				var markerClusters = L.markerClusterGroup();
				for ( var i = 0; i < listing_markers.length; ++i )
				{
						if(listing_markers[i].lat && listing_markers[i].lon ){
						var popup = \'<div class="recent-ads"><div class="recent-ads-list"> <div class="recent-ads-container"><div class="recent-ads-list-image"><div class="featured-ribbon"><span>\' + listing_markers[i].ad_class + \'</span></div><a href="\' + listing_markers[i].ad_link + \'" class="recent-ads-list-image-inner"> <img alt="\' + listing_markers[i].title + \'" src="\' + listing_markers[i].img + \'"></a> </div><div class="recent-ads-list-content"><h3 class="recent-ads-list-title"><a href="\' + listing_markers[i].ad_link + \'">\' + listing_markers[i].title + \'</a></h3><ul class="recent-ads-list-location"><li><a href="javascript:void(0);">\' + listing_markers[i].location + \'</a></li></ul><div class="recent-ads-list-price">\' + listing_markers[i].price + \' </div></div></div></div></div>\';		
						}
					  var m = L.marker( [listing_markers[i].lat, listing_markers[i].lon], {icon: myIcon} ).bindPopup(popup,{minWidth:270,maxWidth:270});
					  markerClusters.addLayer( m );
					  map.addLayer( markerClusters );
					  map.fitBounds(markerClusters.getBounds());
				}
				
				map.scrollWheelZoom.disable();
				map.invalidateSize();
		
		}        
        </script>  ';
        } else if ($mapType == 'google_map') {
            if ($adforest_theme['gmap_api_key'] != "") {

                wp_enqueue_script('google-map');
                wp_enqueue_script('element-map');
                ob_start();
                ?>
                <script>
                    var $ = jQuery;
                    $(document).ready(function () {
                        var map_id = "<?php echo adforest_returnEcho($map_id);?>";
                        element_map(map_id);
                    });
                </script>

                <?php
                $listing_json .= ob_get_contents();
                ob_end_clean();
            }
        }
        $html = '';
        $html .= $listing_json;
        $html .= '<section class="prop-map-hero">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-8 col-xs-12 col-sm-7 col-md-7">
                                    <div class="prop-hero-map-images" id="' . $map_id . '"> </div>
                                </div>
                                <div class="col-lg-4 col-xs-12 col-sm-5 col-md-5 no-padding">
                                    <div class="scrolable-ads ps ps--active-y">
                                        <div class="prop-hero-text-section">
                                            <h3>' . esc_html($listing_title) . '</h3>
                                        </div>
                                        ' . ($ads_html) . '
                                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 640px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 586px;"></div></div></div>
                                </div>
                            </div>
                        </div>
                    </section>' . $leaflet_jsJS . '';
        $html .= ' <script type="text/javascript">
                    jQuery( document ).ready(function() {
                        const ps = new PerfectScrollbar(".scrolable-ads");
                    });
                    </script>';


        return $html;
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('ads_google_map2_short_base', 'ads_google_map2_short_base_func');
}


    