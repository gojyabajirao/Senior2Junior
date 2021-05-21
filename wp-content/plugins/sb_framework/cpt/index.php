<?php
// Register post  type and taxonomy
add_action('init', 'sb_themes_custom_types', 0);

function sb_themes_custom_types() {
    // Register Post type
    $args = array(
        'public' => true,
        'label' => __('Countries', 'redux-framework'),
        'supports' => array('thumbnail', 'title')
    );
    register_post_type('_sb_country', $args);


    //Register Post type
    $args = array(
        'public' => true,
        'label' => __('Classified Ads', 'redux-framework'),
        'supports' => array('title', 'thumbnail', 'editor', 'author'),
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'has_archive' => true,
        'rewrite' => array('with_front' => false, 'slug' => 'ad')
    );
    register_post_type('ad_post', $args);



    //Ads Cats
    register_taxonomy('ad_cats', array('ad_post'), array(
        'hierarchical' => true,
        'show_ui' => true,
        'label' => __('Categories', 'redux-framework'),
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_category'),
    ));

    //Ads Country
    $labels = array(
        'name' => _x('Ad Locations', 'taxonomy general name', 'redux-framework'),
        'singular_name' => _x('Location', 'taxonomy singular name', 'redux-framework'),
        'search_items' => __('Search Ad Locations', 'redux-framework'),
        'all_items' => __('All Ad Locations', 'redux-framework'),
        'parent_item' => __('Parent Location', 'redux-framework'),
        'parent_item_colon' => __('Parent Location:', 'redux-framework'),
        'edit_item' => __('Edit Location', 'redux-framework'),
        'update_item' => __('Update Location', 'redux-framework'),
        'add_new_item' => __('Add New Location', 'redux-framework'),
        'new_item_name' => __('New Location Name', 'redux-framework'),
        'menu_name' => __('Ad Locations', 'redux-framework'),
    );


    //Ads Country
    register_taxonomy('ad_country', array('ad_post'), array(
        'hierarchical' => true,
        'show_ui' => true,
        'labels' => $labels,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_country'),
    ));

    //Ads tags
    register_taxonomy('ad_tags', array('ad_post'), array(
        'hierarchical' => false,
        'label' => __('Tags', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_tag'),
    ));
    //Ads Currency
    register_taxonomy('ad_currency', array('ad_post'), array(
        'hierarchical' => true,
        'label' => __('Currency', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_currency'),
    ));
    //Ads Condition
    register_taxonomy('ad_condition', array('ad_post'), array(
        'hierarchical' => true,
        'label' => __('Condition', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_consition'),
    ));
    //Ads Type
    register_taxonomy('ad_type', array('ad_post'), array(
        'hierarchical' => true,
        'label' => __('Type', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_type'),
    ));
    //Ads warranty
    register_taxonomy('ad_warranty', array('ad_post'), array(
        'hierarchical' => true,
        'label' => __('Warranty', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_warranty'),
    ));
}

// Register metaboxes for Products
add_action('add_meta_boxes', 'sb_meta_box_ads');

function sb_meta_box_ads() {
    add_meta_box('sb_thmemes_adforest_metaboxes', __('Reported', 'redux-framework'), 'sb_render_meta_ads', 'ad_post', 'normal', 'high');
    add_meta_box('sb_theme_adforest_metaboxes', __('Bids', 'redux-framework'), 'adforest_render_bids_admin', 'ad_post', 'normal', 'high');
}

function sb_render_meta_ads($post) {
    global $wpdb;
    $pid = $post->ID;
    $rows = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = '$pid' AND meta_key LIKE  '_sb_user_id_%' ");
    ?>
    <div class="margin_top">
        <h3><?php echo count($rows);?> <?php echo __('Users report to this AD.', 'redux-framework');?></h3>
        <ul type="square">
            <?php
            foreach ($rows as $row) {
                $user = get_userdata($row->meta_value);
                ?>
                <li>
                    <p>->
                        <strong>
                            <?php if (isset($user->display_name)) echo esc_html($user->display_name);?>
                        </strong> <?php echo __('mark as', 'redux-framework');?>
                        <strong>
                            <?php echo get_post_meta($pid, '_sb_report_option_' . $row->meta_value, true);?>
                        </strong>
                    </p>
                    <p><?php echo get_post_meta($pid, '_sb_report_comments_' . $row->meta_value, true);?></p>
                </li>
                <?php
            }
            ?>
        </ul>

    </div>

    <?php
}

function adforest_render_bids_admin($post) {
    global $adforest_theme;
    $curreny = $adforest_theme['sb_currency'];
    ?>
    <div class="margin_top">
        <table class="wp-list-table widefat fixed striped users">
            <tr>
                <th width="15%"><strong><?php echo __('Bidder', 'redux-framework');?></strong></th>
                <th width="15%"><strong><?php echo __('Bid', 'redux-framework');?></strong></th>
                <th width="15%"><strong><?php echo __('Time', 'redux-framework');?></strong></th>
                <th width="45%"><strong><?php echo __('Comment', 'redux-framework');?></strong></th>
                <th width="10%"><strong><?php echo __('Action', 'redux-framework');?></strong></th>
            </tr>

            <?php
            global $wpdb;
            $have_bids = true;
            $biddings = $wpdb->get_results("SELECT meta_id, meta_value FROM $wpdb->postmeta WHERE post_id = '" . $post->ID . "' AND  meta_key like  '_adforest_bid_%' ORDER BY meta_id DESC", OBJECT);
            if (count($biddings) > 0) {

                $sr = 1;
                foreach ($biddings as $bid) {
                    // date - comment - user - offer
                    $data_array = explode('_separator_', $bid->meta_value);

                    $bidder_id = $data_array[2];
                    $bid_date = $data_array[0];
                    $offer = substr($data_array[3], 0, 12);
                    $comment = $data_array[1];

                    if (get_post_meta($post->ID, '_adforest_ad_currency', true) != "") {
                        $curreny = get_post_meta($post->ID, '_adforest_ad_currency', true);
                    }

                    $user_info = get_userdata($bidder_id);
                    $bidder_name = 'demo';
                    $user_profile = 'javascript:void(0);';
                    if (isset($user_info->display_name) && $user_info->display_name != "") {
                        $bidder_name = $user_info->display_name;
                        $user_profile = get_author_posts_url($bidder_id) . '?type=ads';
                        $have_bids = false;
                    } else {
                        continue;
                    }


                    $user_html = '<a class="text-black" href="' . $user_profile . '" target="_blank">' . $bidder_name . '</a>';
                    ?>
                    <tr>
                        <td><?php echo ( $user_html );?></td>
                        <td><?php echo esc_html($offer) . '<span>(' . $curreny . ')</span>';?></td>
                        <td><?php echo ($bid_date);?></td>
                        <td><?php echo esc_html($comment);?></td>
                        <td><a href="javascript:void(0);" class="bids-in-admin" data-bid-meta="<?php echo esc_attr($bid->meta_id);?>"><?php echo __('Delete', 'redux-framework');?></a></td>

                    </tr>

                    <?php
                }
            }
            if ($have_bids) {
                echo '<tr><td colspan="5">' . __('There is no bid on this ad yet.', 'redux-framework') . '</td></tr>';
            }
            ?>

        </table>	
    </div>
    <?php
}

// Register metaboxes for Products
add_action('add_meta_boxes', 'sb_rane_meta_box_add');

function sb_rane_meta_box_add() {
    add_meta_box('sb_thmemes_adforest_metaboxes', __('Package Essentials', 'redux-framework'), 'sb_render_meta_product', 'product', 'normal', 'high');
}

function sb_render_meta_product($post) {
    // We'll use this nonce field later on when saving.
    global $adforest_theme;
    wp_nonce_field('my_meta_box_nonce_product', 'meta_box_nonce_product');
    //$get_all_cats = adforest_sb_get_cats('ad_cats', true);


    $get_all_cats = array();

    $terms_args = array(
        'taxonomy' => 'ad_cats',
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => 0,
        'hierarchical' => true,
    );
    $cat_pkg_type = isset($adforest_theme['cat_pkg_type']) && $adforest_theme['cat_pkg_type'] != '' ? $adforest_theme['cat_pkg_type'] : 'parent';
    if ($cat_pkg_type == 'parent') {
        $terms_args['parent'] = 0;
    }
    if (taxonomy_exists('ad_cats')) {
        $get_all_cats = get_terms($terms_args);
    }

    $selected_categories = get_post_meta($post->ID, "package_allow_categories", true);
    $selected_categories = isset($selected_categories) && !empty($selected_categories) ? $selected_categories : '';
    $selected_categories_arr = array();
    if ($selected_categories != '' && $selected_categories != 'all') {
        $selected_categories_arr = explode(",", $selected_categories);
    }
    ?>
    <div class="margin_top">
        <p><?php echo __('Package BG Color', 'redux-framework');?></p>
        <select name="package_bg_color" style="width:100%; height:40px;">
            <option value="light" <?php if (get_post_meta($post->ID, "package_bg_color", true) == 'new') echo 'selected';?>>
                <?php echo esc_html__('White', 'redux-framework');?>
            </option>
            <option value="dark" <?php if (get_post_meta($post->ID, "package_bg_color", true) == 'dark') echo 'selected';?>>
                <?php echo esc_html__('Dark', 'redux-framework');?>
            </option>
        </select>
    </div>
    <div class="margin_top">
        <p><?php echo __('Package Expiry', 'redux-framework');?></p>
        <input type="text" name="package_expiry_days" class="project_meta" placeholder="<?php echo esc_attr__('Like 30, 40 or 50 but must be an inter value.', 'redux-framework');?>" size="30" value="<?php echo esc_attr(get_post_meta($post->ID, "package_expiry_days", true));?>" id="package_expiry_days" spellcheck="true" autocomplete="off">
        <div><?php echo __('Expiry in days, -1 means never experied unless used it.', 'redux-framework');?></div>
    </div>
    <div>
        <p><?php echo __('Simple Ads', 'redux-framework');?></p>
        <input type="text" name="package_free_ads" class="project_meta" placeholder="<?php echo esc_attr__('Must be an inter value.', 'redux-framework');?>" size="30" value="<?php echo esc_attr(get_post_meta($post->ID, "package_free_ads", true));?>" id="package_free_ads" spellcheck="true" autocomplete="off">
        <div><?php echo __('-1 means unlimited.', 'redux-framework');?></div>
    </div>
    <div>
        <p><?php echo __('Featured Ads', 'redux-framework');?></p>
        <input type="text" name="package_featured_ads" class="project_meta" placeholder="<?php echo esc_attr__('Must be an inter value.', 'redux-framework');?>" size="30" value="<?php echo esc_attr(get_post_meta($post->ID, "package_featured_ads", true));?>" id="package_featured_ads" spellcheck="true" autocomplete="off">
        <div><?php echo __('-1 means unlimited.', 'redux-framework');?></div>
    </div>
    <div>
        <p><?php echo __('Bump Ads', 'redux-framework');?></p>
        <input type="text" name="package_bump_ads" class="project_meta" placeholder="<?php echo esc_attr__('Must be an inter value.', 'redux-framework');?>" size="30" value="<?php echo esc_attr(get_post_meta($post->ID, "package_bump_ads", true));?>" id="package_bump_ads" spellcheck="true" autocomplete="off">
    </div>
    <div class="margin_top">

        <p><?php echo __('Allow Bidding', 'redux-framework');?></p>
        <input type="text" name="package_allow_bidding" class="project_meta" placeholder="<?php echo esc_attr__('Must be an integer value.', 'redux-framework');?>" size="30" value="<?php echo esc_attr(get_post_meta($post->ID, "package_allow_bidding", true));?>" id="package_allow_bidding" spellcheck="true" autocomplete="off">
        <div><?php echo __('-1 means unlimited.', 'redux-framework');?></div>
    </div>
    <div class="margin_top">
        <p><?php echo __('Allow Tags', 'redux-framework');?></p>
        <select name="package_allow_tags" style="width:100%; height:40px;">
            <option value=""><?php echo esc_html__('Select an option', 'redux-framework');?> </option>
            <option value="yes" <?php if (get_post_meta($post->ID, "package_allow_tags", true) == 'yes') echo 'selected';?>>
                <?php echo esc_html__('Yes', 'redux-framework');?>
            </option>
            <option value="no" <?php if (get_post_meta($post->ID, "package_allow_tags", true) == 'no') echo 'selected';?>>
                <?php echo esc_html__('No', 'redux-framework');?>
            </option>
        </select>
    </div>
    <div>
        <p><?php echo __('Number of Images ( while ad posting )', 'redux-framework');?></p>
        <input type="text" name="package_num_of_images" class="project_meta" placeholder="<?php echo esc_attr__('Must be an integer value.', 'redux-framework');?>" size="30" value="<?php echo esc_attr(get_post_meta($post->ID, "package_num_of_images", true));?>" id="package_num_of_images" spellcheck="true" autocomplete="off">
        <div><?php echo __('-1 means unlimited.', 'redux-framework');?></div>
    </div>
    <div class="margin_top">
        <p><?php echo __('Allow Video Links ( while ad posting )', 'redux-framework');?></p>
        <select name="package_video_links" style="width:100%; height:40px;">
            <option value=""><?php echo esc_html__('Select an option', 'redux-framework');?> </option>
            <option value="yes" <?php if (get_post_meta($post->ID, "package_video_links", true) == 'yes') echo 'selected';?>>
                <?php echo esc_html__('Yes', 'redux-framework');?>
            </option>
            <option value="no" <?php if (get_post_meta($post->ID, "package_video_links", true) == 'no') echo 'selected';?>>
                <?php echo esc_html__('No', 'redux-framework');?>
            </option>
        </select>
    </div>
    <div class="margin_top">
        <p><?php echo __('Allow Categories ( while ad posting )', 'redux-framework');?></p>
        <select name="package_allow_categories[]" style="width:100%; height:100px;" multiple="multiple">
            <option value=""><?php echo esc_html__('Select categories', 'redux-framework');?> </option>
            <option value="all" <?php if (get_post_meta($post->ID, "package_allow_categories", true) == 'all') echo 'selected';?>><?php echo esc_html__('All', 'redux-framework');?> </option>
            <?php
            if (isset($get_all_cats) && !empty($get_all_cats) && is_array($get_all_cats)) {
                foreach ($get_all_cats as $single_cat) {
                    $selected_opt = '';
                    if (in_array($single_cat->term_id, $selected_categories_arr)) {
                        $selected_opt = ' selected ';
                    }

                    $adforest_make_cat_paid = get_term_meta($single_cat->term_id, 'adforest_make_cat_paid', true);
                    if (isset($adforest_make_cat_paid) && $adforest_make_cat_paid != 'yes')
                        continue;
                    ?><option <?php echo esc_html($selected_opt);?> value="<?php echo intVal($single_cat->term_id);?>"><?php echo esc_html($single_cat->name);?> </option><?php
                }
            }
            ?>
        </select>
        <div> <b>Note : </b><?php echo __('Load only those categories which are "Is paid" enabled in category meta. ( dashboard >> Classified Ads >> Categories >> Is paid checkbox field. )', 'redux-framework');?></div>
    </div>
    <?php
}

// Saving Metabox data 
add_action('save_post', 'sb_themes_meta_save_product', 10, 3);

function sb_themes_meta_save_product($post_id, $post, $update) {
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

// if our nonce isn't there, or we can't verify it, bail
    if (!isset($_POST['meta_box_nonce_product']) || !wp_verify_nonce($_POST['meta_box_nonce_product'], 'my_meta_box_nonce_product'))
        return;

    // if our current user can't edit this post, bail
    if (!current_user_can('edit_post'))
        return;

    if ('product' !== $post->post_type) {
        return;
    }


    $pkg_cat_val = '';
    if (isset($_POST['package_allow_categories']) && !empty($_POST['package_allow_categories']) && in_array('all', $_POST['package_allow_categories'])) {
        $pkg_cat_val = 'all';
    } elseif (isset($_POST['package_allow_categories']) && !empty($_POST['package_allow_categories'])) {
        $pkg_cat_val = implode(",", $_POST['package_allow_categories']);
    }


    // Make sure your data is set before trying to save it
    if (isset($_POST['package_bg_color']))
        update_post_meta($post_id, 'package_bg_color', $_POST['package_bg_color']);
    if (isset($_POST['package_expiry_days']))
        update_post_meta($post_id, 'package_expiry_days', $_POST['package_expiry_days']);
    if (isset($_POST['package_free_ads']))
        update_post_meta($post_id, 'package_free_ads', $_POST['package_free_ads']);
    if (isset($_POST['package_featured_ads']))
        update_post_meta($post_id, 'package_featured_ads', $_POST['package_featured_ads']);
    if (isset($_POST['package_bump_ads']))
        update_post_meta($post_id, 'package_bump_ads', $_POST['package_bump_ads']);
    if (isset($_POST['package_video_links']))
        update_post_meta($post_id, 'package_video_links', $_POST['package_video_links']);
    if (isset($_POST['package_num_of_images']))
        update_post_meta($post_id, 'package_num_of_images', $_POST['package_num_of_images']);
    if (isset($_POST['package_allow_tags']))
        update_post_meta($post_id, 'package_allow_tags', $_POST['package_allow_tags']);
    if (isset($_POST['package_allow_bidding']))
        update_post_meta($post_id, 'package_allow_bidding', $_POST['package_allow_bidding']);
    if (isset($_POST['package_allow_categories']))
        update_post_meta($post_id, 'package_allow_categories', $pkg_cat_val);
}

// Register metaboxes for Country CPT
add_action('add_meta_boxes', 'sb_meta_box_for_country');

function sb_meta_box_for_country() {
    add_meta_box('sb_metabox_for_country', 'County', 'sb_render_meta_country', '_sb_country', 'normal', 'high');
}

function sb_render_meta_country($post) {
    // We'll use this nonce field later on when saving.
    wp_nonce_field('my_meta_box_nonce_country', 'meta_box_nonce_country');
    ?>
    <div class="margin_top">
        <input type="text" name="country_county" class="project_meta" placeholder="<?php echo esc_attr__('County', 'redux-framework');?>" size="30" value="<?php echo get_the_excerpt($post->ID);?>" id="country_county" spellcheck="true" autocomplete="off">
        <p><?php echo __('This should be follow ISO2 like', 'redux-framework');?> <strong><?php echo __('US', 'redux-framework');?></strong> <?php echo __('for USA and', 'redux-framework');?> <strong><?php echo __('CA', 'redux-framework');?></strong> <?php echo __('for Canada', 'redux-framework');?>, <a href="http://data.okfn.org/data/core/country-list" target="_blank"><?php echo __('Read More.', 'redux-framework');?></a></p>
    </div>

    <?php
}

// Saving Metabox data 
add_action('save_post', 'sb_themes_meta_save_country', 10, 3);

function sb_themes_meta_save_country($post_id, $post, $update) {
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

// if our nonce isn't there, or we can't verify it, bail
    if (!isset($_POST['meta_box_nonce_country']) || !wp_verify_nonce($_POST['meta_box_nonce_country'], 'my_meta_box_nonce_country'))
        return;

    // if our current user can't edit this post, bail
    if (!current_user_can('edit_post'))
        return;
    if ('_sb_country' !== $post->post_type) {
        return;
    }

    // Make sure your data is set before trying to save it
    if (isset($_POST['country_county'])) {
        //update_post_meta( $post_id, '_sb_country_county', $_POST['country_county'] );
        $my_post = array(
            'ID' => $post_id,
            'post_excerpt' => $_POST['country_county'],
        );
        global $wpdb;
        $county = $_POST['country_county'];
        $wpdb->query("UPDATE $wpdb->posts SET post_excerpt = '$county' WHERE ID = '$post_id'");
    }
}

// Add the fields to the "ad_cats" taxonomy, using our callback function  
add_action('ad_cats_edit_form_fields', 'ad_cats_taxonomy_custom_fields', 10, 2);

// A callback function to add a custom field to our "ad_cats" taxonomy  
function ad_cats_taxonomy_custom_fields($tag) {
    // Check for existing taxonomy meta for the term you're editing  
    $t_id = $tag->term_id; // Get the ID of the term you're editing  
    $term_meta = get_option("taxonomy_term_$t_id"); // Do the check  
    ?>  

    <tr class="form-field">  
        <th scope="row" valign="top">  
            <label for="ad_cat_icon"><?php echo __('Icon Name', 'redux-framework');?></label>  
        </th>  
        <td>  
            <input type="text" name="term_meta[ad_cat_icon]" id="term_meta[ad_cat_icon]" size="25" style="width:60%;" value="<?php echo $term_meta['ad_cat_icon'] ? $term_meta['ad_cat_icon'] : '';?>"><br />  
            <span class="description">
                <a href="http://adforest.scriptsbundle.com/theme-icons/" target="_blank"><?php echo __('Check icons list.', 'redux-framework');?></a>
            </span>  
        </td>  
    </tr>  

    <?php
}

// Save the changes made on the "ad_cats" taxonomy, using our callback function  
add_action('edited_ad_cats', 'save_taxonomy_custom_fields', 10, 2);

// A callback function to save our extra taxonomy field(s)  
function save_taxonomy_custom_fields($term_id) {
    if (isset($_POST['term_meta'])) {
        $t_id = $term_id;
        $term_meta = get_option("taxonomy_term_$t_id");
        $cat_keys = array_keys($_POST['term_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['term_meta'][$key])) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        //save the option array  
        update_option("taxonomy_term_$t_id", $term_meta);
    }
}

// Register metaboxes for Bumbup ads
if (isset($_GET['post']) && $_GET['post'] != "") {
    add_action('add_meta_boxes', 'sb_meta_box_bump');
}

function sb_meta_box_bump() {
    add_meta_box('sb_adforest_bump_ad', __('Bump This Ad At Top', 'redux-framework'), 'sb_render_meta_bump', 'ad_post', 'normal', 'high');
}

function sb_render_meta_bump() {
    ?>
    <div class="margin_top">

        <h3 class="alignleft"> <?php echo __("Current Date: ", "redux-framework") . '' . get_the_date() . __(' And Time: ', 'redux-framework') . get_the_date('g:i A', get_the_ID());?> </h3>
        <div class="clear"></div>
        <input class="button button-primary" id="ad-adforest-bump-btn" value="<?php echo __("Bump This Ad At Top", "redux-framework");?>" type="buttom">
        <script type="text/javascript">
            //Car Comparison
            jQuery('#ad-adforest-bump-btn').on('click', function () {
                var post_id = '<?php echo get_the_ID();?>';
                var confrm = confirm('<?php echo __("Are Your Sure You Want To Bumb The Ad", "redux-framework");?>');
                if (confrm != true)
                    return;
                jQuery.post('<?php echo admin_url('admin-ajax.php');?>', {action: 'adforest_make_ad_bumb', post_id: post_id, }).done(function (response)
                {
                    if (response == 1)
                    {
                        location.reload();
                    }
                });
            });
        </script>
        <div class="clear"></div>

    </div>    
    <?php
}

add_action('wp_ajax_adforest_make_ad_bumb', 'adforest_make_ad_bumb_admin');

function adforest_make_ad_bumb_admin() {
    $id = ($_POST['post_id'] != "") ? $_POST['post_id'] : '';
    if (function_exists('adforest_set_date_timezone')) {
        adforest_set_date_timezone();
    }
    //$time = current_time('mysql');
    $time = date();
    $updated = wp_update_post(array('ID' => $id, 'post_date' => $time, 'post_date_gmt' => get_gmt_from_date(current_time('mysql'))));
    update_post_meta($id, '_adforest_ad_status_', 'active');
    if ($updated) {
        echo '1';
    } else {
        echo '0';
    }
    wp_die();
}

// Register metaboxes for Products
add_action('add_meta_boxes', 'sb_adforest_ad_meta_box');

function sb_adforest_ad_meta_box() {
    add_meta_box('sb_thmemes_adforest_metaboxes_for_ad', __('Assign AD', 'redux-framework'), 'sb_render_meta_for_ads', 'ad_post', 'normal', 'high');
}

function sb_render_meta_for_ads($post) {
    // We'll use this nonce field later on when saving.
    wp_nonce_field('my_meta_box_nonce_ad', 'meta_box_nonce_ad');
    ?>

    <div class="margin_top">
        <p><?php echo __('Select Author', 'redux-framework');?></p>
        <select name="sb_change_author" style="width:100%; height:40px;">
            <?php
            $users = get_users(array('fields' => array('display_name', 'ID', 'user_email')));

            foreach ($users as $user) {
                echo '<span>' . esc_html($user->display_name) . '</span>';
                ?>
                <option value="<?php echo esc_attr($user->ID);?>" <?php if ($post->post_author == $user->ID) echo 'selected';?>>
                    <?php
                    echo esc_html($user->display_name) . ' ( ' . $user->user_email . ' )';
                    ?>
                </option>
                <?php
            }
            ?>
        </select>
    </div>
    <?php
}

// Saving Metabox data 
add_action('save_post', 'sb_themes_meta_save_for_ad', 10, 3);

function sb_themes_meta_save_for_ad($post_id, $post, $update) {
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

// if our nonce isn't there, or we can't verify it, bail
    if (!isset($_POST['meta_box_nonce_ad']) || !wp_verify_nonce($_POST['meta_box_nonce_ad'], 'my_meta_box_nonce_ad')) {
        return;
    }
    // if our current user can't edit this post, bail
    if (!current_user_can('edit_post'))
        return;

    if ('ad_post' !== $post->post_type) {
        return;
    }

    // Make sure your data is set before trying to save it
    if (isset($_POST['sb_change_author'])) {
        $my_post = array(
            'ID' => $post_id,
            'post_author' => $_POST['sb_change_author'],
        );
        // unhook this function so it doesn't loop infinitely
        remove_action('save_post', 'sb_themes_meta_save_for_ad');

        // update the post, which calls save_post again
        wp_update_post($my_post);

        // re-hook this function
        add_action('save_post', 'sb_themes_meta_save_for_ad');
    }
}
