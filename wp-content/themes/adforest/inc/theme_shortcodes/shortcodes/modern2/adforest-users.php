<?php
/* ------------------------------------------------ */
/* Adforest Services */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_users_shortcode');
if (!function_exists('adforest_users_shortcode')) {

    function adforest_users_shortcode() {
        vc_map(array(
            'name' => __('Adforest Users', 'adforest'),
            'description' => '',
            'base' => 'adforest_users',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('adforest-users.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Background Color", 'adforest'),
                    "param_name" => "section_bg",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Background Color', 'adforest') => '',
                        __('White', 'adforest') => '',
                        __('Gray', 'adforest') => 'gray'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => __("Select background color.", 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Header Style", 'adforest'),
                    "param_name" => "header_style",
                    "admin_label" => true,
                    "value" => array(
                        __('Section Header Style', 'adforest') => '',
                        __('No Header', 'adforest') => '',
                        __('Classic', 'adforest') => 'classic',
                        __('Regular', 'adforest') => 'regular'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => __("Chose header style.", 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'adforest'),
                    "param_name" => "section_title",
                    "description" => __('For color ', 'adforest') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag', 'adforest') . '<strong>' . esc_html('{/color}') . '</strong>',
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('classic'),
                    ),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'adforest'),
                    "param_name" => "section_title_regular",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('regular'),
                    ),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Description", 'adforest'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('classic'),
                    ),
                ),
                array(
                    "group" => __("Users Setting", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Display Users", 'adforest'),
                    "param_name" => "show_users",
                    "value" => array(
                        __('All', 'adforest') => 'all',
                        __('Sellers only', 'adforest') => 'seller',
                    ),
                ),
                array(
                    "group" => __("Users Setting", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Pagination", 'adforest'),
                    "param_name" => "user_pagination",
                    "value" => array(
                        __('Disable', 'adforest') => 'no',
                        __('Enable', 'adforest') => 'yes',
                    ),
                ),
                array(
                    "group" => __("Users Setting", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Number of Users", 'adforest'),
                    "param_name" => "no_of_user",
                    "value" => range(1, 500),
                ),
                array(
                    "group" => __("Users Setting", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Display Reviews", "adforest"),
                    "param_name" => "show_reviews",
                    "value" => array(
                        __('Disable', 'adforest') => 'no',
                        __('Enable', 'adforest') => 'yes',
                    ),
                ),
                array(
                    "group" => __("Users Setting", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Display Ads Count", "adforest"),
                    "param_name" => "show_ads",
                    "value" => array(
                        __('Disable', 'adforest') => 'no',
                        __('Enable', 'adforest') => 'yes',
                    ),
                ),
                array(
                    "group" => __("Users Setting", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("User Order", "adforest"),
                    "param_name" => "user_order",
                    "value" => array(
                        __('ASC', 'adforest') => 'ASC',
                        __('DESC', 'adforest') => 'DESC',
                    ),
                ),
            )
        ));
    }

}

if (!function_exists('adforest_users_callback')) {

    function adforest_users_callback($atts, $content = '') {
        extract(
                shortcode_atts(
                        array(
            'show_users' => '',
            'user_pagination' => '',
            'no_of_user' => 10,
            'show_reviews' => 'no',
            'show_ads' => 'no',
            'user_order' => 'ASC',
                        ), $atts)
        );

        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        $color_style = '';
        if ('gray' !== $bg_color) {
            $color_style = ' style="background-color: #FFF;"';
        }
        $html = '';
        ob_start();
        ?>
        <section class="description-animated-section"<?php echo adforest_returnEcho($color_style);?>>
            <div class="container">
                <div class="row">
                    <?php
                    echo adforest_returnEcho($header);
                    global $adforest_theme;

                    /*
                     * for pagination args
                     */
                    $args_pag = array(
                        'orderby' => 'display_name',
                    );
                    if (isset($show_users) && $show_users == 'seller') {
                        $args_pag['has_published_posts'] = true;
                    }
                    $args_pag_user_query = new WP_User_Query($args_pag);
                    $total_users = $args_pag_user_query->get_total();
                    $total_users = isset($total_users) && ($total_users) > 0 ? $total_users : 0;
                    $page = (get_query_var('page')) ? get_query_var('page') : 1;
                    $users_per_page = $no_of_user;
                    $total_pages = 1;
                    $offset = $users_per_page * ($page - 1);
                    $args = array(
                        'orderby' => 'display_name',
                        'number' => $users_per_page,
                        'offset' => $offset,
                        'paged' => $page,
                    );

                    if (isset($show_users) && $show_users == 'seller') {
                        $args['has_published_posts'] = true;
                    }
                    $args['order'] = 'ASC';
                    if (isset($user_order) && $user_order == 'DESC') {
                        $args['order'] = 'DESC';
                    }
                    $wp_user_query = new WP_User_Query($args);
                    $users = $wp_user_query->get_results();
                    $total_pages = ceil($total_users / $users_per_page);
                    $counter = 1;
                    foreach ($users as $user) {
                        $user_pic = adforest_get_user_dp($user->ID, 'adforest-user-profile');
                        $user_type = '';
                        $cls = '';
                        if (get_user_meta($user->ID, '_sb_user_type', true) == 'Indiviual') {
                            $user_type = __('Individual', 'adforest');
                            $cls = 'h-ribbon-ind';
                        } else if (get_user_meta($user->ID, '_sb_user_type', true) == 'Dealer') {
                            $user_type = __('Dealer', 'adforest');
                            $cls = 'h-ribbon';
                        }
                        $ribbon_html = '';
                        if ($user_type != "") {
                            $ribbon_html = '<div class="' . esc_attr($cls) . '"><span>' . $user_type . '</span></div>';
                        }
                        ?>
                        <div class="col-lg-3 col-sm-6">
                            <div class="description-main-product adforest-users">
                                <div class="description-box">
                                    <?php echo adforest_returnEcho($ribbon_html);?>
                                    <a href="<?php echo adforest_set_url_param(get_author_posts_url($user->ID), 'type', 'ads');?>">
                                        <img src="<?php echo esc_attr($user_pic);?>" alt="<?php echo esc_attr($user->display_name);?>" class="img-responsive">
                                    </a>
                                </div>
                                <div class="description-heading-product">
                                    <?php
                                    $username = $user->display_name;
                                    if ($username == "") {
                                        $username = $user->user_login;
                                    }
                                    ?>
                                    <h2><a href="<?php echo adforest_set_url_param(get_author_posts_url($user->ID), 'type', 'ads');?>"><?php echo esc_html($username);?></a></h2>
                                </div>

                                <div class="paralell-box-description">
                                    <?php if ($show_reviews == 'yes') {?>
                                        <div class="product-icon-description-icons">
                                            <a href="<?php echo adforest_set_url_param(get_author_posts_url($user->ID), 'type', 1);?>">
                                                <?php
                                                $got = get_user_meta($user->ID, "_adforest_rating_avg", true);
                                                $total = 0;
                                                if ($got == "")
                                                    $got = 0;
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= round($got))
                                                        echo '<i class="fa fa-star"></i>';
                                                    else
                                                        echo '<i class="fa fa-star-o"></i>';

                                                    $total++;
                                                }
                                                $ratings = adforest_get_all_ratings($user->ID);
                                                ?>
                                            </a>
                                        </div>

                                        <div class="description-short-text">
                                            <?php echo esc_html(count($ratings) . " " . __('Reviews', 'adforest'));?>
                                        </div>
                                    <?php }?>
                                </div>
                                <?php
                                if ($show_ads == 'yes') {
                                    ?>
                                    <span class="adforest-user-ads">
                                        <b><?php echo esc_html(count_posts_by_author($user->ID));?></b><span><?php echo _n(' Ad', ' Ads', count_posts_by_author($user->ID), 'adforest');?></span>
                                    </span>
                                <?php }
                                ?>


                                <?php
                                $profiles = adforest_social_profiles();

                                if (isset($profiles) && !empty($profiles) && is_array($profiles)) {
                                    ?><div class="description-social-media-icons"><?php
                                    foreach ($profiles as $key => $value) {
                                        if (get_user_meta($user->ID, '_sb_profile_' . $key, true) != "") {
                                            echo '<a href="' . esc_url(get_user_meta($user->ID, '_sb_profile_' . $key, true)) . '" target="_blank"><i class="fa fa-' . $key . '"></i></a>';
                                        }
                                    }
                                    ?></div><?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if ($counter % 4 == 0) {
                            echo('<div class="clearfix"></div>');
                        }
                        $counter++;
                    }

                    if ($user_pagination == 'yes') {
                        ?>

                        <div class="col-md-12 col-xs-12 col-sm-12 margin-top-20">
                            <?php
                            echo adforest_comments_pagination($total_pages, $page);
                            ?>
                        </div>
                    <?php }?>
                </div>

            </div>
        </section>
        <?php
        $html .= ob_get_contents();
        ob_end_clean();
        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_users', 'adforest_users_callback');
}

function count_posts_by_author($author_id) {
    global $wp_query;

    $args = array(
        'post_type' => 'ad_post',
        'author' => $author_id,
        'posts_per_page' => -1,
        'fields' => 'ids',
    );
    $total_ads = count(get_posts($args));
    $total_ads = isset($total_ads) && $total_ads > 0 ? $total_ads : 0;
    return $total_ads;
}
