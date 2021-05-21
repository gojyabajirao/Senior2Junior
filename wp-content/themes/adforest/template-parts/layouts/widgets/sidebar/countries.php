<div class="panel panel-default">
    <!-- Heading -->
    <div class="panel-heading" role="tab" id="location_heading">
        <!-- Title -->
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#ad-location" aria-expanded="true" aria-controls="collapseOne">
                <i class="more-less glyphicon glyphicon-plus"></i>
                <?php echo esc_html($title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']));?>
            </a>
        </h4>
        <!-- Title End -->
    </div>
    <!-- Content -->
    <?php
    if (isset($instance['open_widget']) && $instance['open_widget'] == '1') {
        $expand = 'in';
    }
    global $wp;
    $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
    $sb_search_page = isset($sb_search_page) && $sb_search_page != '' ? get_the_permalink($sb_search_page) : 'javascript:void(0)';
    $sb_search_page = apply_filters('adforest_category_widget_form_action',$sb_search_page,'location_page');
    ?>
    <form method="get" id="search_countries" action="<?php echo adforest_returnEcho($sb_search_page);?>">
        <div id="ad-location" class="panel-collapse collapse <?php echo esc_attr($expand);?>" role="tabpanel" aria-labelledby="headingOne">

            <?php
            $ad_country = adforest_get_cats('ad_country', 0);
            if (count($ad_country) > 0) {
                ?>
                <div class="panel-body countries">
                    <?php
                    if (isset($_GET['country_id']) && $_GET['country_id'] != "") {
                        $selected_cats = adforest_get_taxonomy_parents($_GET['country_id'], 'ad_country', false);
                        $find = '&raquo;';
                        $replace = '';
                        $selected_cats = preg_replace("/$find/", $replace, $selected_cats, 1);
                        echo adforest_returnEcho($selected_cats);
                        //echo adforest_get_taxonomy_parents( $_GET['country_id'], 'ad_country', false);
                    }
                    ?>
                    <ul>
                        <?php
                        foreach ($ad_country as $country) {
                            $category = get_term($country->term_id);
                            $count = $category->count;
                            $cat_meta = get_option("taxonomy_term_$country->term_id");
                            
                            $loc_search_page = 'javascript:void(0);';
                            $loc_search_page = apply_filters('adforest_filter_taxonomy_popup_actions',$loc_search_page,$country->term_id,'ad_country');
                            ?>
                            <li> 
                                <a href="<?php echo adforest_returnEcho($loc_search_page);?>"  data-country-id="<?php echo esc_attr($country->term_id);?>">
                                    <?php echo esc_html($country->name);?> 
                                    <span>(<?php echo esc_html($count);?>)</span>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>	
                </div>
                <?php
            }
            ?>
        </div>
        <input type="hidden" name="country_id" id="country_id" value="" />
        <?php echo adforest_search_params('country_id');?>
        <?php apply_filters('adforest_form_lang_field', true);?>
    </form>

</div>