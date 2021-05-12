<?php
//wp_enqueue_script( 'infobox', trailingslashit( get_template_directory_uri () ) . 'js/infobox.js' , array('google-map-callback'), false, false);
//wp_enqueue_script( 'marker-clusterer', trailingslashit( get_template_directory_uri () ) . 'js/markerclusterer.js' , false, false, false);

$mapType = adforest_mapType();
if ($mapType == 'google_map') {
    wp_enqueue_script('search-map');
    wp_enqueue_script('oms');
}
?>
<div class="no-container">
    <div class="left-area">
        <div id="map" class="map"></div>
        <ul id="google-map-btn">
            <?php if ($mapType != 'leafletjs_map') {?> 
                <li><a href="javascript:void(0);" id="you_current_location" title="<?php echo __('You Current Location', 'adforest');?>"><i class="fa fa-crosshairs"></i></a></li>
         <!--<li><a href="javascript:void(0);" id="prevpoint" title="<?php //echo __('Previous point on map', 'adforest' );     ?>"><?php //echo __('Prev', 'adforest' );     ?></a></li>
         <li><a href="javascript:void(0);" id="nextpoint" title="<?php //echo __('Next point on map', 'adforest' );      ?>"><?php //echo __('Next', 'adforest' );      ?></a></li>-->
            <?php }?>
            <li><a href="javascript:void(0);" id="reset_state" title="<?php echo __('Reset map', 'adforest');?>"><?php echo __("Reset", "adforest");?></a></li>
        </ul>
    </div> <!-- end .left-area -->
    <div class="right-area">
        <div class="inner-content">
            <div class="filtes-with-maps ">
                <?php
                $map_script = '<script> var show_radius = "";';
                if (isset($adforest_theme['sb_radius_search']) && $adforest_theme['sb_radius_search']) {
                    $radius = '';
                    $area = '';
                    if (isset($_GET['org']) && $_GET['org'] != "" && isset($_GET['rd']) && $_GET['rd'] != "") {
                        $radius = $_GET['rd'];
                        $area = $_GET['org'];
                        $map_script .= ' var show_radius = "yes";';
                    }
                    
                    $radius_placeholder = __('Radius in km', 'adforest');
                    $search_radius_type = isset($adforest_theme['search_radius_type']) ? $adforest_theme['search_radius_type'] : 'km';
                    if ($search_radius_type == 'mile') {
                        $radius_placeholder = __('Radius in Miles', 'adforest');
                    }
                    ?>
                    <div class="seprator adforest-mob-radius">
                        <div class="row">
                            <div class="col-sm-12">
                                <form id="sb-radius-form" class="for-radius">
                                    <div class="form-group">
                                        <label ><?php echo __('Radius Search', 'adforest');?></label>
                                        <div class="input-group">
                                            <div class="new-location">
                                                <?php
                                                $attr_leaflet = "";
                                                $placeHolder = __('Type Location...', 'adforest');
                                                if ($mapType == 'leafletjs_map') {
                                                    $map_lat = (isset($_GET['lat']) && $_GET['lat']) ? $_GET['lat'] : '';
                                                    $map_long = (isset($_GET['long']) && $_GET['long']) ? $_GET['long'] : '';
                                                    echo '<input type="hidden" name="lat" id="sb_user_address_lat" value="' . esc_attr($map_lat) . '"><input type="hidden" name="long" id="sb_user_address_long" value="' . esc_attr($map_long) . '">';

                                                    $attr_leaflet = ' readonly="readonly"';
                                                    $placeHolder = __('Get Location...', 'adforest');
                                                }
                                                ?>                            
                                                <input class="form-control custom_width_location" name="org" id="sb_user_address" placeholder="<?php echo adforest_returnEcho($placeHolder);?>" type="text" data-parsley-required="true" data-parsley-error-message="" value="<?php echo esc_attr($area);?>" 
                                                       <?php echo adforest_returnEcho($attr_leaflet);?>>

                                                <a href="javascript:void(0);" id="you_current_location_text" data-place="text_field" ><i class="fa fa-crosshairs"></i></a>
                                            </div>
                                            <input class="form-control custom_width_radius" name="rd" id="map_radius" value="<?php echo esc_attr($radius);?>" placeholder="<?php echo adforest_returnEcho($radius_placeholder);?>" type="number" data-parsley-required="true" data-parsley-error-message="" > 
                                            <div class="input-group-btn">                           
                                                <button type="submit" class="btn btn-theme" id="radius_search1"><?php echo __('Search', 'adforest');?></button>
                                                <?php echo adforest_search_params('org', 'rd');?>
                                            </div>
                                        </div>
                                    </div>



                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php dynamic_sidebar('adforest_search_sidebar');?>
                <?php
                $mod = $GLOBALS['widget_counter'];
                if ($mod % 3 != 0) {
                    echo '</div></div>';
                }
                if ($GLOBALS['widget_counter'] >= $adforest_theme['search_widget_limit']) {
                    echo '</div>';
                }
                ?>

            </div> <!-- end .filtes-with-maps -->
            <?php
            if ($results->have_posts()) {
                $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
                ?>
                <div class="ads-listing-history">
                    <p class="results">
                        <?php echo esc_html($results->found_posts) . ' ' . __('Results', 'adforest');?> - 
                        <a href="<?php echo get_the_permalink($sb_search_page);?>"><?php echo __('Reset', 'adforest');?></a>
                    </p>
                    <div class="header-listing">

                        <div class="custom-select-box">
                            <?php if (isset($adforest_theme['search_layout_types']) && $adforest_theme['search_layout_types'] == true) {?>
                                <div class="adforest-sort-view">
                                    <?php
                                    $grid_view = adforest_custom_remove_url_query('view-type', 'grid');
                                    $list_view = adforest_custom_remove_url_query('view-type', 'list');
                                    ?>            
                                    <a href="<?php echo esc_url($list_view);?>" class="grid-switchers"><i class="fa fa-bars"></i></a>
                                    <a href="<?php echo esc_url($grid_view);?>" class="grid-switchers"><i class="fa fa-th-large"></i></a>    
                                </div>  
                                <div class="clearfix"></div>
                            <?php }?>
                            <?php
                            $selectedOldest = $selectedLatest = $selectedTitleAsc = $selectedTitleDesc = $selectedPriceHigh = $selectedPriceLow = '';
                            if (isset($_GET['sort'])) {
                                $selectedOldest = ( $_GET['sort'] == 'id-asc' ) ? 'selected' : '';
                                $selectedLatest = ( $_GET['sort'] == 'id-desc' ) ? 'selected' : '';
                                $selectedTitleAsc = ( $_GET['sort'] == 'title-asc' ) ? 'selected' : '';
                                $selectedTitleDesc = ( $_GET['sort'] == 'title-desc' ) ? 'selected' : '';
                                $selectedPriceHigh = ( $_GET['sort'] == 'price-desc' ) ? 'selected' : '';
                                $selectedPriceLow = ( $_GET['sort'] == 'price-asc' ) ? 'selected' : '';
                            }
                            ?>
                            <form method="get">
                                <select name="sort" id="order_by" class="custom-select order_by">
                                    <option value="id-desc" <?php echo esc_attr($selectedLatest);?>>
                                        <?php echo esc_html__('Newest To Oldest', 'adforest');?>
                                    </option>
                                    <option value="id-asc" <?php echo esc_attr($selectedOldest);?>>
                                        <?php echo esc_html__('Oldest To Newest', 'adforest');?>
                                    </option>
                                    <option value="price-desc" <?php echo esc_attr($selectedPriceHigh);?>>
                                        <?php echo esc_html__('Price: High to Low', 'adforest');?>
                                    </option>
                                    <option value="price-asc" <?php echo esc_attr($selectedPriceLow);?>>
                                        <?php echo esc_html__('Price: Low to High', 'adforest');?>
                                    </option>
                                </select>
                                <?php echo adforest_search_params('sort');?>
                            </form> 

                        </div>
                    </div>
                </div>
            <?php }?>
            <?php get_template_part('template-parts/layouts/search/search', 'tags');?>
            <div class="search-with-adss">
                <div class="clearfix"></div>
                <?php
                if (isset($adforest_theme['feature_on_search']) && $adforest_theme['feature_on_search'] && $results->have_posts()) {
                    $args = array(
                        'post_type' => 'ad_post',
                        'post_status' => 'publish',
                        'posts_per_page' => $adforest_theme['max_ads_feature'],
                        'tax_query' => array(
                            $category,
                        ),
                        'meta_query' => array(
                            array(
                                'key' => '_adforest_is_feature',
                                'value' => 1,
                                'compare' => '=',
                            ),
                            array(
                                'key' => '_adforest_ad_status_',
                                'value' => 'active',
                                'compare' => '=',
                            ),
                        ),
                        'orderby' => 'rand',
                    );
                    $ads = new ads();
                    echo ( '<div class="row">' . $ads->adforest_get_ads_grid_slider($args, $adforest_theme['feature_ads_title'], 4, '') . '</div>' );
                }

                $marker = trailingslashit(get_template_directory_uri()) . 'images/car-marker.png';
                $marker_more = trailingslashit(get_template_directory_uri()) . 'images/car-marker-more.png';
                $close_url = trailingslashit(get_template_directory_uri()) . 'images/close.gif';

                $map_lon = (isset($adforest_theme['search_map_lat']) && $adforest_theme['search_map_lat'] != "" ) ? $adforest_theme['search_map_lat'] : 39.739236;
                $map_lat = (isset($adforest_theme['search_map_long']) && $adforest_theme['search_map_long'] != "" ) ? $adforest_theme['search_map_long'] : -104.990251;

                if (isset($adforest_theme['search_map_marker']['url']) && $adforest_theme['search_map_marker']['url'] != "") {
                    $marker = $adforest_theme['search_map_marker']['url'];
                }


                if (isset($adforest_theme['search_map_marker_more']['url']) && $adforest_theme['search_map_marker_more']['url'] != "") {
                    $marker_more = $adforest_theme['search_map_marker_more']['url'];
                }

                if (isset($adforest_theme['search_map_lat']) && $adforest_theme['search_map_lat'] != "" && isset($adforest_theme['search_map_long']) && $adforest_theme['search_map_long'] != "") {
                    $map_lat = $adforest_theme['search_map_lat'];
                    $map_lon = $adforest_theme['search_map_long'];
                }

                if (isset($_GET['location']) && $_GET['location'] != "") {
                    $latlng = adforest_getLatLong($_GET['location']);
                    if (count($latlng) > 0) {
                        $map_lat = (isset($latlng['latitude'])) ? $latlng['latitude'] : '';
                        $map_lon = (isset($latlng['longitude'])) ? $latlng['longitude'] : '';
                    }
                }

                $map_zoom = 6;
                if (isset($adforest_theme['search_map_zoom']) && $adforest_theme['search_map_zoom'] != "") {
                    $map_zoom = $adforest_theme['search_map_zoom'];
                }


                if ($mapType == 'leafletjs_map') {
                    $map_script = '<script>var listing_markers = [';
                } else if ($mapType == 'google_map') {
                    $map_script .= ' var imageUrl = "' . $marker . '";
						var imageUrl_more	=	"' . $marker_more . '";
						var search_map_lat	=	"' . $map_lat . '";
						var search_map_long	=	"' . $map_lon . '";
						var search_map_zoom	=	' . $map_zoom . ';
						var close_url	=	"' . $close_url . '";
						var locations = [';
                }
                if ($results->have_posts()) {
                    if (isset($adforest_theme['search_ad_720_1']) && $adforest_theme['search_ad_720_1'] != "") {
                        ?>
                        <div class="margin-bottom-30 margin-top-10">
                            <?php echo "" . $adforest_theme['search_ad_720_1'];?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="clearfix"></div>
                    <?php
                    $layouts = array('list_1', 'list_2', 'list_3');
                    echo '<div class="row">';
                    $type = $adforest_theme['search_ad_layout_for_sidebar'];

                    $get_grid_layout = adforest_get_grid_layout();
                    $search_ad_layout_for_sidebar = ($get_grid_layout != "" ) ? $get_grid_layout : $adforest_theme['search_ad_layout_for_sidebar'];
                    $type = ($get_grid_layout != "" ) ? $get_grid_layout : $adforest_theme['search_ad_layout_for_sidebar'];

                    $col = 6;
                    if (in_array($search_ad_layout_for_sidebar, $layouts)) {
                        require trailingslashit(get_template_directory()) . "template-parts/layouts/ad_style/search-layout-list.php";
                        echo adforest_returnEcho($out);
                    } else {
                        require trailingslashit(get_template_directory()) . "template-parts/layouts/ad_style/search-layout-grid.php";
                        echo adforest_returnEcho($out);
                    }
                    echo '</div>';

                    /* Restore original Post Data */
                    wp_reset_postdata();
                    ?>
                    <div class="clearfix"></div>
                    <?php
                    if (isset($adforest_theme['search_ad_720_2']) && $adforest_theme['search_ad_720_2'] != "") {
                        ?>
                        <div class="margin-top-10 margin-bottom-30">
                            <?php echo "" . $adforest_theme['search_ad_720_2'];?>
                        </div>
                        <?php
                    }
                } else {
                    //echo '<script>var listing_markers = [';
                    echo '<h2>' . esc_html__('No Result Found.', 'adforest') . '</h2>';
                }

                $map_script .= "];</script>";
                ?>
            </div>

            <div class="clearfix"></div>

            <div class="margin-bottom-20 text-center">
                <?php adforest_pagination_search($results);?>
            </div>

        </div> <!-- end .inner-content -->
    </div> <!-- end .right-area -->
</div>
<?php
if ($mapType == 'leafletjs_map') {
    echo adforest_returnEcho($map_script);
}
?>
<script>

<?php
if ($mapType == 'leafletjs_map') {
    /* $marker; $marker_more; $map_lat; $map_lon; $map_zoom; $close_url; */

    $marker_url = trailingslashit(get_template_directory_uri()) . 'images/map-pin.png';
    if ($marker != "") {
        $marker_url = $marker;
    }
    ?>


        var map_lat = "<?php echo esc_html($map_lat);?>";
        var map_long = "<?php echo esc_html($map_lon);?>";
        if (map_lat && map_long)
                //if( true )
                {

                    var my_icons = "<?php echo esc_url($marker_url);?>";
                    if (jQuery('#map').length) {
                        var map = L.map('map').setView([map_lat, map_long], <?php echo esc_html($map_zoom);?>);
                        L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png').addTo(map);
                        var myIcon = L.icon({
                            iconUrl: my_icons,
                            iconRetinaUrl: my_icons,
                            iconSize: [25, 40],
                            iconAnchor: [10, 30],
                            popupAnchor: [0, -35]
                        });
                        adforest_mapCluster();
                    }
                }

        jQuery('#reset_state').on('click', function () {
            if (jQuery('#map').length)
            {
                adforest_mapCluster();
            }
        });

        function adforest_mapCluster()
        {
            var markerClusters = L.markerClusterGroup();
            for (var i = 0; i < listing_markers.length; ++i)
            {
                if (listing_markers[i].lat && listing_markers[i].lon) {
                    var popup = '<div class="recent-ads"><div class="recent-ads-list"> <div class="recent-ads-container"><div class="recent-ads-list-image"><div class="featured-ribbon"><span>' + listing_markers[i].ad_class + '</span></div><a href="' + listing_markers[i].ad_link + '" class="recent-ads-list-image-inner"> <img alt="' + listing_markers[i].title + '" src="' + listing_markers[i].img + '"></a> </div><div class="recent-ads-list-content"><h3 class="recent-ads-list-title"><a href="' + listing_markers[i].ad_link + '">' + listing_markers[i].title + '</a></h3><ul class="recent-ads-list-location"><li><a href="javascript:void(0);">' + listing_markers[i].location + '</a></li></ul><div class="recent-ads-list-price">' + listing_markers[i].price + ' </div></div></div></div></div>';
                }
                var m = L.marker([listing_markers[i].lat, listing_markers[i].lon], {icon: myIcon}).bindPopup(popup, {minWidth: 270, maxWidth: 270});
                markerClusters.addLayer(m);
                map.addLayer(markerClusters);
                map.fitBounds(markerClusters.getBounds());
            }

            map.scrollWheelZoom.disable();
            map.invalidateSize();

        }

    <?php
} else if ($mapType == 'google_map') {
    ?>
        function locationData(adImg, adPrice, isFeatured, categoryLink, categorytitle, adTitle, addLocation, adlink, adTime) {
            return ('<div class="recent-ads"><div class="recent-ads-list"> <div class="recent-ads-container"><div class="recent-ads-list-image"><div class="featured-ribbon"><span>' + isFeatured + '</span></div><a href="' + adlink + '" class="recent-ads-list-image-inner"> <img alt="' + adTitle + '" src="' + adImg + '"></a> </div><div class="recent-ads-list-content"><h3 class="recent-ads-list-title"><a href="' + adlink + '">' + adTitle + '</a></h3><ul class="recent-ads-list-location"><li><a href="javascript:void(0);">' + addLocation + '</a></li></ul><div class="recent-ads-list-price">' + adPrice + ' </div></div></div></div></div>');
        }
    <?php
}
?>
</script>
<?php
if ($mapType == 'google_map') {
    echo adforest_returnEcho($map_script);
}
?>