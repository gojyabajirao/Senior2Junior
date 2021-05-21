<div class="col-md-4 col-xs-12 col-sm-6">
    <?php
    $radius = '';
    $area = '';
    if (isset($_GET['org']) && $_GET['org'] != "" && isset($_GET['rd']) && $_GET['rd'] != "") {
        $radius = $_GET['rd'];
        $area = $_GET['org'];
    }
    $radius_placeholder = __('Radius in km', 'adforest');
    $search_radius_type = isset($adforest_theme['search_radius_type']) ? $adforest_theme['search_radius_type'] : 'km';
    if ($search_radius_type == 'mile') {
        $radius_placeholder = __('Radius in Miles', 'adforest');
    }
    ?>
    <form id="sb-radius-form" class="for-radius">
        <div class="form-group">
            <label><?php echo esc_html($instance['title']); ?></label>





            <div class="with-top-bar clearfix">
                <div class="col-md-9 no-padding">
                    <?php
                    $mapType = adforest_mapType();
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
                    <input name="org" class="form-control" id="sb_user_address" placeholder="<?php echo adforest_returnEcho($placeHolder); ?>" type="text" data-parsley-required="true" data-parsley-error-message="" value="<?php echo esc_attr($area); ?>" <?php echo adforest_returnEcho($attr_leaflet); ?>>


                    <i id="you_current_location_text" class="fa fa-bullseye"></i>
                </div>
                <div class="col-md-3  no-padding">
                    <input name="rd" value="<?php echo esc_attr($radius); ?>" placeholder="<?php echo adforest_returnEcho($radius_placeholder);?>" type="number" data-parsley-required="true" data-parsley-error-message="" class="form-control" >
                    <input type="submit" hidden />
                </div>
            </div>


        </div> 


        <?php echo adforest_search_params('org', 'rd'); ?>
    </form>
    <?php
    adforest_widget_counter();
    ?>
</div>
<?php adforest_advance_search_container(); ?>