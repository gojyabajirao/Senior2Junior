<?php
add_action('show_user_profile', 'sb_show_extra_profile_fields');
add_action('edit_user_profile', 'sb_show_extra_profile_fields');

if (!function_exists('adforest_check_if_package_expired')) {

    function adforest_check_if_package_expired($user_id = 0) {
        //$simple_ads	=	get_user_meta($user_id, '_sb_simple_ads', true);
        $expiry = get_user_meta($user_id, '_sb_expire_ads', true);

        $is_expired = false;
        if ($expiry != '-1') {
            if ($expiry < date('Y-m-d')) {
                $is_expired = true;
            }
        }

        return $is_expired;
    }

}

function sb_show_extra_profile_fields($user) {
    ?>

    <h3><?php echo __('Adforest User Profile', 'redux-framework');?></h3>

    <table class="form-table">

        <tr>
            <th><label for="_sb_pkg_type"><?php echo __('Package Type', 'redux-framework');?></label></th>

            <td>
                <input type="text" name="_sb_pkg_type" id="_sb_pkg_type" value="<?php echo esc_attr(get_the_author_meta('_sb_pkg_type', $user->ID));?>" class="regular-text" /><br />
            </td>
        </tr>
        <tr>
            <th><label for="_sb_simple_ads"><?php echo __('Free Ads Remaining', 'redux-framework');?></label></th>
            <?php
            $simple_ads = get_the_author_meta('_sb_simple_ads', $user->ID);
            if ($simple_ads == "") {
                $simple_ads = 0;
            }
            ?>
            <td>
                <input type="text" name="_sb_simple_ads" id="_sb_simple_ads" value="<?php echo esc_attr($simple_ads);?>" class="regular-text" /><br />
                <p><?php echo __('-1 means unlimited.', 'redux-framework');?>
            </td>
        </tr>
        <tr>
            <th><label for="_sb_featured_ads"><?php echo __('Featured Ads Remaining', 'redux-framework');?></label></th>
            <?php
            $featured_ads = get_the_author_meta('_sb_featured_ads', $user->ID);
            if ($featured_ads == "") {
                $featured_ads = 0;
            }
            ?>
            <td>
                <input type="text" name="_sb_featured_ads" id="_sb_featured_ads" value="<?php echo esc_attr($featured_ads);?>" class="regular-text" /><br />
                <p><?php echo __('-1 means unlimited.', 'redux-framework');?>
            </td>
        </tr>
        <tr>
            <th><label for="_sb_bump_ads"><?php echo __('Bump up Ads Remaining', 'redux-framework');?></label></th>
            <?php
            $bump_ads = get_the_author_meta('_sb_bump_ads', $user->ID);
            if ($bump_ads == "") {
                $bump_ads = 0;
            }
            ?>
            <td>
                <input type="text" name="_sb_bump_ads" id="_sb_bump_ads" value="<?php echo esc_attr($bump_ads);?>" class="regular-text" /><br />
                <p><?php echo __('-1 means unlimited.', 'redux-framework');?></p>
            </td>
        </tr>
        <!-- new features start -->
        <tr>
            <th><label for="_sb_num_of_images"><?php echo __('Allowed Images Remaining', 'redux-framework');?></label></th>
            <?php
            $_sb_num_of_images = get_the_author_meta('_sb_num_of_images', $user->ID);
            if ($_sb_num_of_images == "") {
                $_sb_num_of_images = 0;
            }
            ?>
            <td>
                <input type="text" name="_sb_num_of_images" id="_sb_num_of_images" value="<?php echo esc_attr($_sb_num_of_images);?>" class="regular-text" /><br />
                <p><?php echo __('-1 means unlimited.', 'redux-framework');?></p>
            </td>
        </tr>

        <tr>
            <th><label for="_sb_video_links"><?php echo __('Allowed Video links', 'redux-framework');?></label></th>
            <td>
                <select name="_sb_video_links" id="_sb_video_links">
                    <option value=""><?php echo __('Select an option', 'redux-framework');?></option>
                    <option value="yes" <?php if (get_the_author_meta('_sb_video_links', $user->ID) == "yes") echo "selected";?>><?php echo __('Yes', 'redux-framework');?></option>
                    <option value="no" <?php if (get_the_author_meta('_sb_video_links', $user->ID) == "no") echo "selected";?>><?php echo __('No', 'redux-framework');?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="_sb_allow_tags"><?php echo __('Allowed Tags', 'redux-framework');?></label></th>
            <td>
                <select name="_sb_allow_tags" id="_sb_allow_tags">
                    <option value=""><?php echo __('Select an option', 'redux-framework');?></option>
                    <option value="yes" <?php if (get_the_author_meta('_sb_allow_tags', $user->ID) == "yes") echo "selected";?>><?php echo __('Yes', 'redux-framework');?></option>
                    <option value="no" <?php if (get_the_author_meta('_sb_allow_tags', $user->ID) == "no") echo "selected";?>><?php echo __('No', 'redux-framework');?></option>
                </select>
            </td>
        </tr>

        <tr>
            <th><label for="_sb_allow_bidding"><?php echo __('Allowed Bidding', 'redux-framework');?></label></th>
            <?php
            $_sb_allow_bidding = get_the_author_meta('_sb_allow_bidding', $user->ID);
            if ($_sb_allow_bidding == "") {
                $_sb_allow_bidding = 0;
            }
            ?>
            <td>
                <input type="text" name="_sb_allow_bidding" id="_sb_allow_bidding" value="<?php echo esc_attr($_sb_allow_bidding);?>" class="regular-text" /><br />
                <p><?php echo __('-1 means unlimited.', 'redux-framework');?></p>
            </td>
        </tr>
        <tr>
            <th><label for="_sb_expire_ads"><?php echo __('Expiry Date', 'redux-framework');?></label></th>

            <td>
                <input type="text" name="_sb_expire_ads" id="_sb_expire_ads" value="<?php echo esc_attr(get_the_author_meta('_sb_expire_ads', $user->ID));?>" class="regular-text" /><br />
                <p><?php echo __('-1 means never expired or date format will be yyyy-mm-dd.', 'redux-framework');?>
            </td>
        </tr>
        <tr>
            <th><label for="_sb_badge_type"><?php echo __('Badge Color', 'redux-framework');?></label></th>

            <td>
                <select name="_sb_badge_type" id="_sb_badge_type">
                    <option value=""><?php echo __('Select Type', 'redux-framework');?></option>
                    <option value="label-success" <?php if (get_the_author_meta('_sb_badge_type', $user->ID) == "label-success") echo "selected";?>><?php echo __('Green', 'redux-framework');?></option>
                    <option value="label-warning" <?php if (get_the_author_meta('_sb_badge_type', $user->ID) == "label-warning") echo "selected";?>><?php echo __('Orange', 'redux-framework');?></option>
                    <option value="label-info" <?php if (get_the_author_meta('_sb_badge_type', $user->ID) == "label-info") echo "selected";?>><?php echo __('Blue', 'redux-framework');?></option>
                    <option value="label-danger" <?php if (get_the_author_meta('_sb_badge_type', $user->ID) == "label-danger") echo "selected";?>><?php echo __('Red', 'redux-framework');?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="_sb_badge_text"><?php echo __('Badge Text', 'redux-framework');?></label></th>

            <td>
                <input type="text" name="_sb_badge_text" id="_sb_badge_text" value="<?php echo esc_attr(get_the_author_meta('_sb_badge_text', $user->ID));?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="_sb_ph_num_"><?php echo __('Phone Number', 'redux-framework');?></label></th>

            <td>
                <input type="text" name="_sb_ph_num_" id="_sb_ph_num_" value="<?php echo esc_attr(get_the_author_meta('_sb_contact', $user->ID));?>" class="regular-text" />
                <small><?php echo __('+CountrycodeMobilenumber', 'redux-framework');?></small>
            </td>
        </tr>
        <tr>
            <th><label for="_sb_ph_verified_"><?php echo __('Phone no. verified', 'redux-framework');?></label></th>
            <?php
            $ph_is_verified_ = get_the_author_meta('_sb_is_ph_verified', $user->ID);
            if ($ph_is_verified_ == "") {
                $ph_is_verified_ = 0;
            }
            ?>
            <td>
                <select name="_sb_ph_verified_" id="_sb_ph_verified_">
                    <option value=""><?php echo __('Select option', 'redux-framework');?></option>
                    <option value="0" <?php if ($ph_is_verified_ == '0') echo "selected";?>><?php echo __('Not verified', 'redux-framework');?></option>
                    <option value="1" <?php if ($ph_is_verified_ == '1') echo "selected";?>><?php echo __('Verified', 'redux-framework');?></option>
                </select>
            </td>
            </td>
        </tr>
        <tr>
            <th><label for="_sb_user_type_"><?php echo __('User Type', 'redux-framework');?></label></th>
            <?php
            $user_type = get_user_meta($user->ID, '_sb_user_type', true);
            ?>
            <td>
                <select name="_sb_user_type_" id="_sb_user_type_">
                    <option value=""><?php echo __('Select option', 'redux-framework');?></option>
                    <option value="Indiviual" <?php if ($user_type == 'Indiviual') echo "selected";?>><?php echo __('Individual', 'redux-framework');?></option>
                    <option value="Dealer" <?php if ($user_type == 'Dealer') echo "selected";?>><?php echo __('Dealer', 'redux-framework');?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="_sb_user_location_"><?php echo __('User Location', 'redux-framework');?></label></th>
            <?php
            $user_location_ = get_the_author_meta('_sb_address', $user->ID);
            ?>
            <td>
                <input type="text" name="_sb_user_location_" id="_sb_user_location_" value="<?php echo esc_attr($user_location_);?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="_sb_user_intro_"><?php echo __('User Introduction', 'redux-framework');?></label></th>
            <?php
            $_sb_user_intro_ = get_the_author_meta('_sb_user_intro', $user->ID);
            ?>
            <td>
                <textarea rows="5" cols="30" name="_sb_user_intro_" id="_sb_user_intro_"><?php echo esc_attr($_sb_user_intro_);?></textarea>
            </td>
        </tr>


    </table>
    <div>
        <h2><?php echo __('User Rating', 'redux-framework');?></h2>
        <br />
        <table class="wp-list-table widefat fixed striped users">
            <tr>
                <th width="15%"><strong><?php echo __('Username who rated', 'redux-framework');?></strong></th>
                <th width="10%"><strong><?php echo __('Rating', 'redux-framework');?></strong></th>
                <th width="65%"><strong><?php echo __('Comments', 'redux-framework');?></strong></th>
                <th width="10%"><strong><?php echo __('Action', 'redux-framework');?></strong></th>
            </tr>
            <?php
            $author_id = $user->ID;
            $ratings = adforest_get_all_ratings($user->ID);
            if (count($ratings) > 0) {
                foreach ($ratings as $rating) {
                    $data = explode('_separator_', $rating->meta_value);
                    $rated = $data[0];
                    $comments = $data[1];
                    $date = $data[2];
                    $reply = '';
                    $reply_date = '';
                    if (isset($data[3])) {
                        $reply = $data[3];
                    }
                    if (isset($data[4])) {
                        $reply_date = $data[4];
                    }
                    $_arr = explode('_user_', $rating->meta_key);
                    $rator = $_arr[1];
                    $user = get_user_by('ID', $rator);
                    ?>
                    <tr>
                        <td><?php echo esc_html($user->display_name);?></td>
                        <td><?php echo esc_html($rated) . ' ' . __('Star', 'redux-framework');?></td>
                        <td><?php echo esc_html($comments);?></td>
                        <td><a href="javascript:void(0);" class="get_user_meta_id" data-mid="<?php echo esc_attr($rating->umeta_id);?>"><?php echo __('Delete', 'redux-framework');?></a></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr><td colspan="4"><?php echo __('There is no rating of this user yet.', 'redux-framework');?></td></tr>
                <?php
            }
            ?>
        </table>
    </div>
    <br />
    <?php
}

add_action('personal_options_update', 'sb_save_extra_profile_fields');
add_action('edit_user_profile_update', 'sb_save_extra_profile_fields');

function sb_save_extra_profile_fields($user_id) {

    if (!current_user_can('edit_user', $user_id))
        return false;

    /* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
    update_user_meta(absint($user_id), '_sb_pkg_type', wp_kses_post($_POST['_sb_pkg_type']));
    update_user_meta(absint($user_id), '_sb_simple_ads', wp_kses_post($_POST['_sb_simple_ads']));
    update_user_meta(absint($user_id), '_sb_featured_ads', wp_kses_post($_POST['_sb_featured_ads']));
    update_user_meta(absint($user_id), '_sb_bump_ads', wp_kses_post($_POST['_sb_bump_ads']));
    update_user_meta(absint($user_id), '_sb_expire_ads', wp_kses_post($_POST['_sb_expire_ads']));
    update_user_meta(absint($user_id), '_sb_badge_type', wp_kses_post($_POST['_sb_badge_type']));
    update_user_meta(absint($user_id), '_sb_badge_text', wp_kses_post($_POST['_sb_badge_text']));
    update_user_meta(absint($user_id), '_sb_is_ph_verified', wp_kses_post($_POST['_sb_ph_verified_']));
    update_user_meta(absint($user_id), '_sb_contact', wp_kses_post($_POST['_sb_ph_num_']));
    update_user_meta(absint($user_id), '_sb_user_type', wp_kses_post($_POST['_sb_user_type_']));
    update_user_meta(absint($user_id), '_sb_address', wp_kses_post($_POST['_sb_user_location_']));
    update_user_meta(absint($user_id), '_sb_user_intro', wp_kses_post($_POST['_sb_user_intro_']));

    update_user_meta(absint($user_id), '_sb_video_links', wp_kses_post($_POST['_sb_video_links']));
    update_user_meta(absint($user_id), '_sb_allow_tags', wp_kses_post($_POST['_sb_allow_tags']));
    update_user_meta(absint($user_id), '_sb_allow_bidding', wp_kses_post($_POST['_sb_allow_bidding']));
    update_user_meta(absint($user_id), '_sb_num_of_images', wp_kses_post($_POST['_sb_num_of_images']));
}

// Adding Custom coulumn in user dashboard

function new_modify_user_table($column) {
    $role = $column['role'];
    $posts = $column['posts'];

    unset($column['name']);
    unset($column['role']);
    unset($column['posts']);

    $column['display_name'] = __('Display Name', 'redux-framework');
    $column['_sb_user_type'] = __('User Type', 'redux-framework');
    $column['_sb_pkg_type'] = __('Package', 'redux-framework');
    $column['role'] = $role;
    $column['posts'] = $posts;
    return $column;
    //return array_reverse($column);
}

add_filter('manage_users_columns', 'new_modify_user_table');

function new_modify_user_table_row($val, $column_name, $user_id) {


    $is_expired = adforest_check_if_package_expired($user_id);
    if ($is_expired) {
        $is_expired_txt = get_the_author_meta('_sb_pkg_type', $user_id);
        if ($is_expired_txt) {
            $is_expired_txt .= '<br />(' . __("Expired", "redux-framework") . ')';
        }
    } else {
        $is_expired_txt = get_the_author_meta('_sb_pkg_type', $user_id);
    }
    switch ($column_name) {
        case '_sb_user_type' :
            if (get_the_author_meta('_sb_user_type', $user_id) == 'Indiviual')
                return __('Individual', 'redux-framework');
            if (get_the_author_meta('_sb_user_type', $user_id) == 'Dealer')
                return __('Dealer', 'redux-framework');
            return get_the_author_meta('_sb_user_type', $user_id);
            break;
        case 'display_name' :
            return get_the_author_meta('display_name', $user_id);
            break;
        case '_sb_pkg_type' :
            return $is_expired_txt;
            break;
        default:
    }
    return $val;
}

add_filter('manage_users_custom_column', 'new_modify_user_table_row', 10, 3);

if (!function_exists('adforest_get_all_ratings')) {

    function adforest_get_all_ratings($user_id) {
        global $wpdb;
        $ratings = $wpdb->get_results("SELECT * FROM $wpdb->usermeta WHERE user_id = '$user_id' AND  meta_key like  '_user_%' ORDER BY umeta_id DESC", OBJECT);
        return $ratings;
    }

}