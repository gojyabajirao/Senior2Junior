<?php
global $adforest_theme;
$bg_cls = 'no-top-margin';
$sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
if ($adforest_theme['search_breadcrumb_bg']['url'] != "") {
    the_post();
    $bg_cls = '';
    ?>
    <section class="breadcrumb-1 small-hero">
        <div class="bg-overlay">
            <div class="container">
                <!-- Main Content -->
                <div class="content-section">
                    <!-- Title -->
                    <h1><?php the_title(); ?></h1>
                    <p><?php the_content(); ?></p>
                </div>
                <!-- Main Content End -->
            </div>
        </div>
    </section>
    <?php
}
?>
<div class="main-content-area clearfix">
    <!-- =-=-=-=-=-=-= Latest Ads =-=-=-=-=-=-= -->
    <section class="with_top_bar padding-bottom-80">
        <!-- Main Container -->
        <div class="container">


            <div class="new-filter <?php echo esc_attr($bg_cls); ?>">
                <?php dynamic_sidebar('adforest_search_sidebar'); ?>
                <?php
                if ($GLOBALS['widget_counter'] >= $adforest_theme['search_widget_limit']) {
                    echo '</div>';
                }
                ?>
            </div>
            <?php
            if ($results->have_posts()) {
                ?>
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 no-padding">
                    <div class="clearfix"></div>
                    <div class="listingTopFilterBar">
                        <div class="col-md-9 col-xs-12 col-sm-6 no-padding">
                            <ul class="filterAdType">
                                <li class="active">
                                    <span class="filterAdType-count"><?php echo __('Found Ads', 'adforest'); ?>
                                        <small>(<?php echo esc_html($results->found_posts); ?>)</small>
                                    </span>
                                </li>
                                <?php
                                $param = $_SERVER['QUERY_STRING'];
                                if ($param != "") {
                                    ?>
                                    <li class="">
                                        <a class="filterAdType-count" href="<?php echo get_the_permalink($sb_search_page); ?>"><?php echo __('Reset Search', 'adforest'); ?></a>
                                    </li>
                                    <?php
                                }
                                if (isset($adforest_theme['search_layout_types']) && $adforest_theme['search_layout_types'] == true) {
                                    ?>
                                    <?php
                                    $grid_view = adforest_custom_remove_url_query('view-type', 'grid');
                                    $list_view = adforest_custom_remove_url_query('view-type', 'list');
                                    ?>           
                                    <li class="<?php echo (is_rtl() ) ? 'pull-left' : 'pull-right'; ?>"><a  class="filterAdType-count"  href="<?php echo esc_url($list_view); ?>" class="<?php echo (is_rtl() ) ? 'pull-left' : 'pull-right'; ?>"><i class="fa fa-bars"></i></a><a  class="filterAdType-count" href="<?php echo esc_url($grid_view); ?>" class="pull-right"><i class="fa fa-th-large"></i></a></li>                      
                                <?php } ?>      
                            </ul>
                        </div>
                        <div class="col-md-3 col-xs-12 col-sm-6 no-padding">
                            <div class="header-listing">
                                <div class="custom-select-boxz">
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
                                        <select name="sort" id="order_by" class="order_by" class="custom-select">
                                            <option value="id-desc" <?php echo esc_attr($selectedLatest); ?>>
                                                <?php echo esc_html__('Newest To Oldest', 'adforest'); ?>
                                            </option>
                                            <option value="id-asc" <?php echo esc_attr($selectedOldest); ?>>
                                                <?php echo esc_html__('Oldest To Newest', 'adforest'); ?>
                                            </option>
                                            <option value="price-desc" <?php echo esc_attr($selectedPriceHigh); ?>>
                                                <?php echo esc_html__('Price: High to Low', 'adforest'); ?>
                                            </option>
                                            <option value="price-asc" <?php echo esc_attr($selectedPriceLow); ?>>
                                                <?php echo esc_html__('Price: Low to High', 'adforest'); ?>
                                            </option>
                                        </select>
                                        <?php echo adforest_search_params('sort'); ?>
                                    </form>   

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sorting Filters End-->
                <?php
            }
            get_template_part('template-parts/layouts/search/search', 'tags');
            ?>
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
                echo adforest_returnEcho($ads->adforest_get_ads_grid_slider($args, $adforest_theme['feature_ads_title'], 4, 'no-padding'));
            }
            if (isset($adforest_theme['search_ad_720_1']) && $adforest_theme['search_ad_720_1'] != "" && $results->have_posts()) {
                ?>
                <div class="col-md-12">
                    <div class="margin-bottom-30 margin-top-10 text-center">
                        <?php echo "" . $adforest_theme['search_ad_720_1']; ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="clearfix"></div>

            <!-- Row -->
            <div class="row">
                <!-- Middle Content Area -->
                <div class="col-md-12 col-lg-12 col-sx-12">
                    <?php
                    $layouts = array('list', 'list_1', 'list_2', 'list_3');
                    if ($results->have_posts()) {
                        ?>
                        <!-- Row -->
                        <div class="row">
                            <!-- Ads Archive 10 -->
                            <?php
                            $col = 3;

                            //if( isset( $adforest_theme['design_type'] ) && $adforest_theme['design_type'] == 'modern' ){ $col	= 4; }

                            $get_grid_layout = adforest_get_grid_layout();
                            $search_ad_layout_for_topbar = ($get_grid_layout != "" ) ? $get_grid_layout : $adforest_theme['search_ad_layout_for_topbar'];
                            $type = ($get_grid_layout != "" ) ? $get_grid_layout : $adforest_theme['search_ad_layout_for_topbar'];

                            if (in_array($search_ad_layout_for_topbar, $layouts)) {
                                require trailingslashit(get_template_directory()) . "template-parts/layouts/ad_style/search-layout-list.php";
                                echo ( isset($_GET['view-type']) && $_GET['view-type'] == "list" && $type == "list") ? '<div class="col-md-12"><ul>' : '';
                                echo adforest_returnEcho($out);
                                echo ( isset($_GET['view-type']) && $_GET['view-type'] == "list" && $type == "list") ? '</ul></div>' : "";
                            } else {

                                require trailingslashit(get_template_directory()) . "template-parts/layouts/ad_style/search-layout-grid.php";
                                echo adforest_returnEcho($out);
                            }
                            ?>
                            <div class="clearfix"></div>
                            <?php
                            if (isset($adforest_theme['search_ad_720_2']) && $adforest_theme['search_ad_720_2'] != "") {
                                ?>
                                <div class="col-md-12">
                                    <div class="margin-top-10 margin-bottom-20 text-center">
                                        <?php echo adforest_returnEcho($adforest_theme['search_ad_720_2']); ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                            <!-- Ads Archive End -->  
                            <div class="clearfix"></div>
                            <!-- Pagination -->  
                            <div class="text-center margin-top-30">
                                <?php adforest_pagination_search($results); ?>
                            </div>
                            <!-- Pagination End -->   
                        </div>
                        <!-- Row End -->
                        <?php
                    } else {
                        echo '<h2>' . esc_html__('No Result Found.', 'adforest') . '</h2>';
                    }
                    ?>
                </div>
                <!-- Middle Content Area  End -->
            </div>
            <!-- Row End -->
        </div>
        <!-- Main Container End -->
    </section>
</div>