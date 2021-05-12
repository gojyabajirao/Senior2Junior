<?php
global $adforest_theme, $template;

$sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
$sb_search_page = isset($sb_search_page) && $sb_search_page != '' ? get_the_permalink($sb_search_page) : 'javascript:void(0)';
$sb_search_page = apply_filters('adforest_category_widget_form_action', $sb_search_page);

$section_class = '';
if (wp_is_mobile()) {
    $section_class = 'section-no-pad ';
}
$page_template = basename($template);
if ($page_template == 'taxonomy-ad_cats.php') {

    $term_id = get_queried_object_id();
}

$texonomy_single_style = isset($adforest_theme['texonomy_single_style']) && $adforest_theme['texonomy_single_style'] != '' ? $adforest_theme['texonomy_single_style'] : 'list';

$list_styles_arr = array('list', 'list_2');

$masnory_enabled = TRUE;
if (in_array($texonomy_single_style, $list_styles_arr)) {
    $masnory_enabled = FALSE;
}



$sidebar_position = isset($adforest_theme['cat_sidebar_position']) ? $adforest_theme['cat_sidebar_position'] : 'left';
?>
<div class="main-content-area clearfix">
    <!-- =-=-=-=-=-=-= Latest Ads =-=-=-=-=-=-= -->
    <section class="section-padding <?php echo esc_attr($section_class);?>">
        <!-- Main Container -->
        <div class="container">
            <!-- Row -->
            <div class="row">
                <!-- Left Sidebar -->
                <?php
                if ($search_cat_page && $sidebar_position == 'left') {
                    echo '<div class="col-md-3 col-sm-12 col-xs-12 col-lg-3"><div class="sidebar"><div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
                    if (is_active_sidebar('adforest_cat_search')) : dynamic_sidebar('adforest_cat_search');
                    endif;
                    echo '</div></div></div>';
                }
                ?>
                <!-- Left Sidebar End -->

                <!-- Middle Content Area -->
                <div class="<?php echo esc_attr($left_col);?>">
                    <!-- Row -->
                    <div class="row">
                        <?php if ($search_cat_page) {?>
                            <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                <div class="clearfix"></div>
                                <div class="listingTopFilterBar">
                                    <div class="col-md-7 col-xs-12 col-sm-7 no-padding">
                                        <ul class="filterAdType">
                                            <li class="active">
                                                <span class="filterAdType-count" ><?php echo __('Found Ads', 'adforest');?>
                                                    <small>(<?php echo esc_html($results->found_posts);?>)</small>
                                                </span>
                                            </li>
                                            <?php
                                            $param = $_SERVER['QUERY_STRING'];

                                            if ($param != "") {
                                                ?>
                                                <li class="">
                                                    <a class="filterAdType-count" href="<?php echo adforest_returnEcho($sb_search_page);?>"><?php echo __('Reset Search', 'adforest');?></a>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="col-md-5 col-xs-12 col-sm-5 no-padding">
                                        <div class="header-listing">

                                            <h6><?php echo __('Sort by', 'adforest');?> : </h6>
                                            <div class="custom-select-box <?php echo (is_rtl() ) ? 'pull-left' : 'pull-right';?>">

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
                                </div>
                            </div>
                            <?php if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern') {?>
                                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                    <?php get_template_part('template-parts/layouts/search/search', 'tags');?>
                                </div>
                            <?php }?>
                            <!-- Sorting Filters End-->
                            <div class="clearfix"></div>
                            <?php
                            //if (isset($adforest_theme['sb_allow_cats_above_filters']) && $adforest_theme['sb_allow_cats_above_filters']) {

                            if (isset($term_id) && $term_id != "") {
                                ?>

                                <?php
                                $cat_id = $term_id;
                                $ad_cats = adforest_get_cats('ad_cats', $cat_id);


                                $res = '';
                                $rows_count = 1;
                                $max_rows = $adforest_theme['sb_max_sub_cats'];
                                $show = true;
                                $show_child = FALSE;
                                if (count($ad_cats) > 0) {
                                    parse_str($_SERVER['QUERY_STRING'], $search_params);
                                    unset($search_params['cat_id']);
                                    $new_params = http_build_query($search_params);
                                    $show_child = TRUE;

                                    $cat_params = '';
                                    $cls = '';
                                    $res .= '<ul class="city-select-city sb-ul-list" >';
                                    foreach ($ad_cats as $ad_cat) {

                                        if ($new_params != "") {
                                            $cat_link = get_term_link($ad_cat->slug, 'ad_cats');
                                        } else {
                                            $cat_link = get_term_link($ad_cat->slug, 'ad_cats');
                                        }

                                       
                                        if (isset($adforest_theme['sb_li_cols']) && $adforest_theme['sb_li_cols'] != "") {
                                            $li_col = $adforest_theme['sb_li_cols'];
                                        }

                                        $count = ($ad_cat->count);

                                        if ($rows_count > $max_rows && $show) {
                                            $show = false;
                                            $res .= '<li class="col-md-12 col-sm-12 col-xs-12 hide_cats text-center margin-top-20">
                                                        <a href="javascript:void(0);" class="tax-show-more btn-theme">
                                                        ' . __('Show More ', 'adforest') . '
                                                        </a>
                                                        </li>';
                                            $cls = 'no-display show_it';
                                        }

                                        $res .= '<li class="'. esc_attr($cls) . '">
                                                <a href="' . $cat_link . '" >
                                                ' . $ad_cat->name . ' <span>(' . $count . ')</span>
                                                </a>
                                                </li>';
                                                                $rows_count++;
                                    }
                                    $res .= '</ul>';
                                }
                                ?>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="adforest-new-filters">
                                        <div class="panel panel-default">
                                            <!-- Heading -->
                                            <div class="panel-heading sb-panel-heading" role="tab" id="headingOnez">
                                                <!-- Title -->
                                                <div class="panel-title sb-panel-title">
                                                    <?php
                                                    //echo __('Categories', 'adforest');
                                                    $title = adforest_get_taxonomy_parents($cat_id, 'ad_cats', true, '');
                                                    //$find = '&raquo;';
                                                    //$replace = '';
                                                    //$result = preg_replace("/$find/", $replace, $title, 1);
                                                    echo adforest_returnEcho($title);
                                                    ?>
                                                    <!--                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOnez" aria-expanded="true" aria-controls="collapseOnez" class="sb-btn">
                                                                                                            <i class="more-less glyphicon glyphicon-plus"></i>
                                                                                                        </a>-->

                                                </div>
                                                <!-- Title End -->
                                            </div>
                                            <!-- Content -->
                                            <?php if ($show_child) {?>
                                                <form>
                                                    <div id="collapseOnez" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOnez">
                                                        <div class="panel-body sb-panel-body">
                                                            <div class="search-modal">
                                                                <div class="search-block">

                                                                    <?php echo adforest_returnEcho($res);?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            <?php }?>
                                        </div>
                                    </div>                        


                                </div>




                                <div class="clearfix"></div>
                                <?php
                                //}
                            }
                        }
                        ?>

                        <?php
                        if (isset($adforest_theme['feature_on_search']) && $adforest_theme['feature_on_search']) {
                            $countries_location = '';
                            $countries_location = apply_filters('adforest_site_location_ads', $countries_location, 'search');
                            $args = array(
                                'post_type' => 'ad_post',
                                'post_status' => 'publish',
                                'posts_per_page' => $adforest_theme['max_ads_feature'],
                                'tax_query' => array(
                                    $category,
                                    $countries_location,
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
                            echo adforest_returnEcho($ads->adforest_get_ads_grid_slider($args, $adforest_theme['feature_ads_title'], 4, ''));
                        }

                        if ($results->have_posts()) {
                            ?>
                            <?php
                            if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern') {
                                
                            } else {
                                ?>
                                <!-- Sorting Filters -->
                                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                    <!-- Sorting Filters Breadcrumb -->
                                    <div class="filter-brudcrums">
                                        <span>
                                            <?php echo __('Category', 'adforest') . ': ' . ucfirst(single_cat_title("", false));?>
                                        </span>
                                    </div>
                                    <!-- Sorting Filters Breadcrumb End -->
                                </div>
                                <!-- Sorting Filters End-->
                                <?php
                            }
                            ?>
                            <div class="clearfix"></div>
                            <!-- Ads Archive 1 -->
                            <?php if ($masnory_enabled) {?> <div class="posts-masonry"><?php }?>
                                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                    <ul class="list-unstyled clear-custom">

                                        <?php
                                        $function = "adforest_search_layout_$texonomy_single_style";
                                        $ads = new ads();
                                        while ($results->have_posts()) {
                                            $results->the_post();
                                            $pid = get_the_ID();
                                            $ad = new ads();
                                            //  echo adforest_returnEcho($ad->adforest_search_layout_list($pid));
                                            echo adforest_returnEcho($ads->$function(get_the_ID(), 4));
                                        }
                                        ?>

                                    </ul>
                                </div>
                                <?php if ($masnory_enabled) {?> </div><?php }?>
                            <!-- Ads Archive End -->  
                            <div class="clearfix"></div>

                            <?php
                        } else {
                            get_template_part('template-parts/content', 'none');
                        }
                        ?>

                        <div class="clearfix"></div>

                        <!-- Pagination -->  
                        <div class="text-center margin-top-30 margin-bottom-20">
                            <?php adforest_pagination($results);?>
                        </div>
                        <!-- Pagination End -->   
                    </div>
                    <!-- Row End -->
                </div>
                <!-- Middle Content Area  End -->

                <?php
                if ($search_cat_page && $sidebar_position == 'right') {
                    echo '<div class="col-md-3 col-sm-12 col-xs-12 col-lg-3"><div class="sidebar"><div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
                    if (is_active_sidebar('adforest_cat_search')) : dynamic_sidebar('adforest_cat_search');
                    endif;
                    echo '</div></div></div>';
                }
                ?>

            </div>
            <!-- Row End -->
        </div>
        <!-- Main Container End -->
    </section>
</div>