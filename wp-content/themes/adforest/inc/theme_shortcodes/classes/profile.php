<?php

if (!class_exists('adforest_profile')) {

    class adforest_profile {

// user object
        var $user_info;

        public function __construct() {
            $this->user_info = get_userdata(get_current_user_id());
        }

// Full Width Profile Top
        function adforest_profile_full_top() {
            $user_pic = adforest_get_user_dp($this->user_info->ID, 'adforest-user-profile');

            global $adforest_theme;
            $msgs = '';
            if ($adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'message') {
                $msgs = '				<li>
				  <a href="javascript:void(0);">
					 <div class="menu-name" sb_action="my_msgs">' . __('Messages', 'adforest') . '</div>
				  </a>
			   </li>';
            }

            $packages = '';
            $order_history = '';
            $sb_packages_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_packages_page']);
            if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                $packages = '<li>
				  <a href="' . get_the_permalink($sb_packages_page) . '" target="_blank">
					 <div class="menu-name" sb_action="">' . __('Packages', 'adforest') . '</div>
				  </a>
			   </li>';

                $order_history = '<li>
				  <a href="javascript:void(0);">
					 <div class="menu-name" sb_action="my_orders">' . __('Package history', 'adforest') . '</div>
				  </a>
			   </li>';
            }
            $package_type_html = '';
            if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                $package_type = get_user_meta($this->user_info->ID, '_sb_pkg_type', true);
                if (get_user_meta($this->user_info->ID, '_sb_pkg_type', true) != 'free') {
                    $package_type = __('Paid', 'adforest');
                } else {
                    $package_type = __('Free', 'adforest');
                }
                $package_type_html = '<span class="label label-warning">' . $package_type . '</span>';
            }
            $rating = '';
            if (isset($adforest_theme['user_public_profile']) && $adforest_theme['user_public_profile'] != "" && $adforest_theme['user_public_profile'] == "modern" && isset($adforest_theme['sb_enable_user_ratting']) && $adforest_theme['sb_enable_user_ratting']) {

                $rating = '<a href="' . adforest_set_url_param(get_author_posts_url($this->user_info->ID), 'type', 1) . '">
			<div class="rating">';
                $got = get_user_meta($this->user_info->ID, "_adforest_rating_avg", true);
                if ($got == "")
                    $got = 0;
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= round($got))
                        $rating .= '<i class="fa fa-star"></i>';
                    else
                        $rating .= '<i class="fa fa-star-o"></i>';
                }
                $rating .= '<span class="rating-count">
			   (' . count(adforest_get_all_ratings($this->user_info->ID)) . ')
			   </span>
			</div>
			</a>';
            }

            $badge = '';
            if (get_user_meta($this->user_info->ID, '_sb_badge_type', true) != "" && get_user_meta($this->user_info->ID, '_sb_badge_text', true) != "" && isset($adforest_theme['sb_enable_user_badge']) && $adforest_theme['sb_enable_user_badge'] && $adforest_theme['sb_enable_user_badge'] && isset($adforest_theme['user_public_profile']) && $adforest_theme['user_public_profile'] != "" && $adforest_theme['user_public_profile'] == "modern") {
                $badge = ' <span class="label ' . get_user_meta($this->user_info->ID, '_sb_badge_type', true) . '">
	' . get_user_meta($this->user_info->ID, '_sb_badge_text', true) . '</span>';
            }

            $user_type = '';
            if (get_user_meta($this->user_info->ID, '_sb_user_type', true) == 'Indiviual') {
                $user_type = __('Individual', 'adforest');
            } else if (get_user_meta($this->user_info->ID, '_sb_user_type', true) == 'Dealer') {
                $user_type = __('Dealer', 'adforest');
            }

            $profile_html = '';
            $profiles = adforest_social_profiles();
            foreach ($profiles as $key => $value) {
                if (get_user_meta($this->user_info->ID, '_sb_profile_' . $key, true) != "")
                    $profile_html .= '<li><a href="' . esc_url(get_user_meta($this->user_info->ID, '_sb_profile_' . $key, true)) . '" class="fa fa-' . $key . '" target="_blank"></a></li>';
            }

            return '<div class="row">
	  <!-- Middle Content Area -->

	  <div class="col-md-12 col-xs-12 col-sm-12">
		<section class="search-result-item">
		   <div class="image-link" href="javascript:void(0);">
		   <img class="image" alt="' . __('Profile Picture', 'adforest') . '" src="' . $user_pic . '" id="user_dp">
		   <ul class="social-f">
				' . $profile_html . '
			</ul>
		   </div>
		   <div class="search-result-item-body">
			  <div class="row">
				 <div class="col-md-5 col-sm-12 col-xs-12">

					<h4 class="search-result-item-heading sb_put_user_name">' . $this->user_info->display_name . '</h4>
					<p class="info">
					<span class="profile_tabs" sb_action="get_profile"><i class="fa fa-user"></i>&nbsp; ' . __('Profile', 'adforest') . '</span>&nbsp;| &nbsp;
					<span class="profile_tabs" sb_action="update_profile"><i class="fa fa-edit"></i>&nbsp; ' . __('Edit Profile', 'adforest') . '</span>
				  </p>
					<p class="info sb_put_user_address">' . get_user_meta($this->user_info->ID, '_sb_address', true) . '</p>
					<p class="description">' . __('Last active', 'adforest') . ': ' . adforest_get_last_login($this->user_info->ID) . ' ' . __('Ago', 'adforest') . '</p>
					' . $package_type_html . '
					<span class="label label-success sb_user_type">' . $user_type . '</span>
					' . $badge . '
					' . $rating . '


				 </div>
				 <div class="col-md-7 col-sm-12 col-xs-12">
				  <div class="row ad-history">
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="user-stats">
								<h2 id="sb-sold-ads">' . adforest_get_sold_ads($this->user_info->ID) . '</h2>
								<small>' . __('Ad Sold', 'adforest') . '</small>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="user-stats">
								<h2>' . adforest_get_all_ads($this->user_info->ID) . '</h2>
								<small>' . __('Total Listings', 'adforest') . '</small>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="user-stats">
								<h2 id="sb-inactive-ads">' . adforest_get_disbale_ads($this->user_info->ID) . '</h2>
								<small>' . __('Inactve ads', 'adforest') . '</small>
							</div>
						</div>
					</div>
				 </div>
			  </div>
		   </div>
		</section>
		<div class="dashboard-menu-container profile-dropdown">
			<ul>
                        <li class="ads-list-wrap">

                            <button class="dropdown-toggle" type="button" data-toggle="dropdown">' . __('My Ads', 'adforest') . '
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                              <li><a href="javascript:void(0);"><div class="menu-name sub-list-item" sb_action="my_ads">' . __('My Ads', 'adforest') . '</div></a></li>
                              <li><a href="javascript:void(0);"><div class="menu-name sub-list-item" sb_action="my_feature_ads">' . __('Featured Ads', 'adforest') . '</div></a></li>
                              <li><a href="javascript:void(0);"><div class="menu-name sub-list-item" sb_action="my_rejected_ads">' . __('Rejected Ads', 'adforest') . '</div></a></li>
                              <li><a href="javascript:void(0);"><div class="menu-name sub-list-item" sb_action="my_inactive_ads">' . __('Inactive Ads', 'adforest') . '</div></a></li>
                              <li><a href="javascript:void(0);"><div class="menu-name sub-list-item" sb_action="my_expire_sold_ads">' . __('Expired / Sold Ads', 'adforest') . '</div></a></li>
                              <li><a href="javascript:void(0);"><div class="menu-name sub-list-item" sb_action="my_fav_ads">' . __('Fav Ads', 'adforest') . '</div></a></li>
                            </ul>

                        </li>

			   ' . $msgs . '
			    ' . $packages . '
			    ' . $order_history . '
			</ul>
		 </div>
	  </div>
	  <!-- Middle Content Area  End -->
   </div>
		';
        }

// Full Width Profile Body
        function adforest_profile_full_body() {
            if (isset($_GET['sb_action']) && isset($_GET['ad_id']) && isset($_GET['uid']) && $_GET['sb_action'] == 'sb_load_messages') {
                $script = "<script>	jQuery(document).ready(function($){
   					adforest_select_msg('$_GET[ad_id]', '$_GET[uid]', 'no'," . wp_create_nonce('sb_msg_secure') . ");
	});
	</script>
";
                $ads = new ads();
                return '<div id="adforest_res">
			 ' . $ads->adforest_load_messages($_GET['ad_id']) . '
		  </div>
		  ' . $script . '
		';
            } else if (isset($_GET['sb_action']) && isset($_GET['ad_id']) && isset($_GET['uid']) && isset($_GET['user_id']) && $_GET['sb_action'] == 'sb_get_messages') {
                $script = "<script>	jQuery(document).ready(function($){
   					adforest_select_msg('$_GET[ad_id]', '$_GET[uid]', 'yes'," . wp_create_nonce('sb_msg_secure') . ");
	});
	</script>
";
                $ads = new ads();
                return '<div id="adforest_res">
			 ' . $ads->adforest_get_messages($_GET['user_id']) . '
		  </div>
		  ' . $script . '
		';
            } else {
                return '<div id="adforest_res">
			 ' . $this->adforest_profile_get() . '
		  </div>
		';
            }
        }

// Getting profile details
        function adforest_profile_get() {
            $expiry = '';
            $free_ads = '';
            $featured_ads = '';
            $bump_ads = '';
            $paid_html = '';
            global $adforest_theme;
            if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                if (get_user_meta($this->user_info->ID, '_sb_expire_ads', true) != '-1') {
                    $expiry = get_user_meta($this->user_info->ID, '_sb_expire_ads', true);
                } else {
                    $expiry = __('Never', 'adforest');
                }
                if (get_user_meta($this->user_info->ID, '_sb_simple_ads', true) != '-1' && get_user_meta($this->user_info->ID, '_sb_simple_ads', true) >= 0) {
                    $free_ads = get_user_meta($this->user_info->ID, '_sb_simple_ads', true);
                } else {
                    $free_ads = __('Unlimited', 'adforest');
                }
                if (get_user_meta($this->user_info->ID, '_sb_featured_ads', true) != '-1') {
                    $featured_ads = get_user_meta($this->user_info->ID, '_sb_featured_ads', true);
                } else {
                    $featured_ads = __('Unlimited', 'adforest');
                }
                if (get_user_meta($this->user_info->ID, '_sb_bump_ads', true) != '-1') {
                    $bump_ads = get_user_meta($this->user_info->ID, '_sb_bump_ads', true);
                } else {
                    $bump_ads = __('Unlimited', 'adforest');
                }

                $pkg_type_str = '';
                $profile_td_pkg = get_user_meta($this->user_info->ID, '_sb_pkg_type', true);
                if (isset($profile_td_pkg) && $profile_td_pkg == 'free') {
                    $pkg_type_str = __('Free', 'adforest');
                } else {
                    $pkg_type_str = $profile_td_pkg;
                }


                $new_package_features = '';

                $yes_no_arr = array(
                    'yes' => __('Yes', 'adforest'),
                    'no' => __('No', 'adforest'),
                );

                $_sb_video_links = get_user_meta($this->user_info->ID, '_sb_video_links', true);
                $_sb_video_links = isset($_sb_video_links) && !empty($_sb_video_links) && ($_sb_video_links == 'yes' || $_sb_video_links == 'no') ? $yes_no_arr[$_sb_video_links] : '-';

                $_sb_allow_tags = get_user_meta($this->user_info->ID, '_sb_allow_tags', true);
                $_sb_allow_tags = isset($_sb_allow_tags) && !empty($_sb_allow_tags) && ($_sb_allow_tags == 'yes' || $_sb_allow_tags == 'no') ? $yes_no_arr[$_sb_allow_tags] : '-';


                if (get_user_meta($this->user_info->ID, '_sb_allow_bidding', true) != '-1' && get_user_meta($this->user_info->ID, '_sb_allow_bidding', true) >= 0) {
                    $bidding_ads = get_user_meta($this->user_info->ID, '_sb_allow_bidding', true);
                } else {
                    $bidding_ads = __('Unlimited', 'adforest');
                }

                $inner_htmll = '';


                $selected_categories = get_user_meta($this->user_info->ID, "package_allow_categories", true);
                $selected_categories = isset($selected_categories) && !empty($selected_categories) ? $selected_categories : '';
                $selected_categories_arr = array();
                if ($selected_categories != '') {
                    $selected_categories_arr = explode(",", $selected_categories);
                }

                $cat_list_ = '';
                if (isset($selected_categories_arr) && !empty($selected_categories_arr) && is_array($selected_categories_arr)) {
                    if (isset($selected_categories_arr[0]) && $selected_categories_arr[0] != 'all') {
                        $cat_list_ .= '<div  class="category_package_list"  style="display:none;" ><ul>';
                        foreach ($selected_categories_arr as $single_cat_id) {
                            $category = get_term($single_cat_id);
                            $cat_list_ .= '<li > <i class="fa fa-check"></i> ' . $category->name . '</li>';
                        }
                        $cat_list_ .= '</ul></div>';
                    }
                }

                $sb_upload_limit_admin = isset($adforest_theme['sb_upload_limit']) && !empty($adforest_theme['sb_upload_limit']) && $adforest_theme['sb_upload_limit'] > 0 ? $adforest_theme['sb_upload_limit'] : 0;
                $user_packages_images = get_user_meta($this->user_info->ID, '_sb_num_of_images', true);

                if (isset($user_packages_images) && $user_packages_images == '-1') {
                    $user_upload_max_images = __('Unlimited','adforest');
                } elseif (isset($user_packages_images) && $user_packages_images > 0) {
                    $user_upload_max_images = $user_packages_images;
                } else {
                    $user_upload_max_images = $sb_upload_limit_admin;
                }

                $new_package_features .= '<dt><strong>' . __('Allowed Video link', 'adforest') . ' </strong></dt>
					  <dd>
					     ' . $_sb_video_links . '
					   </dd>';

                $new_package_features .= '<dt><strong>' . __('Allowed Tags', 'adforest') . ' </strong></dt>
					  <dd>
					     ' . $_sb_allow_tags . '
					   </dd>';

                $new_package_features .= '<dt><strong>' . __('Allowed Bidding', 'adforest') . ' </strong></dt>
					  <dd>
					     ' . $bidding_ads . '
					   </dd>';

                $new_package_features .= '<dt><strong>' . __('Allowed Images', 'adforest') . ' </strong></dt>
					  <dd>
					     ' . $user_upload_max_images . '
					   </dd>';


                if (isset($selected_categories_arr) && !empty($selected_categories_arr) && is_array($selected_categories_arr)) {
                    if (isset($selected_categories_arr[0]) && $selected_categories_arr[0] == 'all') {
                        $new_package_features .= '<dt class="price-category"><strong>' . __('Categories ', 'adforest') . '</strong></dt><dd>' . __('All ', 'adforest') . ' </dd>';
                    } else {
                        $new_package_features .= '<dt><strong>' . __(' Categories ', 'adforest') . '</strong></dt><dd class="price-category cat-profile" data-placement="top" data-toggle="popover" title="' . __('Allowed Categories ', 'adforest') . '"><span> ' . __('See All ', 'adforest') . '<i class="fa fa-question-circle"></i></span> ' . $cat_list_ . '</dd>';
                    }
                } else {
                    $new_package_features .= '<dt><strong>' . __(' Categories', 'adforest') . ' </strong></dt>
					  <dd>
					     -
					   </dd>';
                }

                $paid_html = '<dt><strong>' . __('Package Type', 'adforest') . ' </strong></dt>
					<dd>
					   ' . adforest_returnEcho($pkg_type_str) . '
					</dd>
                                        <dt><strong>' . __('Package Expiry', 'adforest') . ' </strong></dt>
					<dd>
					   ' . $expiry . '
					</dd>
					<dt><strong>' . __('Free Ads Remaining', 'adforest') . ' </strong></dt>
					<dd>
					   ' . $free_ads . '
					</dd>
					<dt><strong>' . __('Featured Ads Remaining', 'adforest') . ' </strong></dt>
					<dd>
					   ' . $featured_ads . '
					</dd>

					<dt><strong>' . __('Bump-up Ads Remaining', 'adforest') . ' </strong></dt>
					<dd>
					   ' . $bump_ads . '
					</dd>

                                        ' . $new_package_features . '
                                        ';
            }


            $user_type = '';
            if (get_user_meta($this->user_info->ID, '_sb_user_type', true) == 'Indiviual') {
                $user_type = __('Individual', 'adforest');
            } else if (get_user_meta($this->user_info->ID, '_sb_user_type', true) == 'Dealer') {
                $user_type = __('Dealer', 'adforest');
            }


            $is_verified = '';

            $sms_gateway = adforest_verify_sms_gateway();
            if ($sms_gateway != "") {
                if (get_user_meta($this->user_info->ID, '_sb_is_ph_verified', true) == '1') {
                    $is_verified = '<span class="label label-success sb_user_type">' . __('Verified', 'adforest') . '</span>';
                } else {
                    $is_verified = '<span class="label label-danger sb_user_type">' . __('Not verified', 'adforest') . '</span>&nbsp;
				<a data-target="#verification_modal" data-toggle="modal" class="small_text" id="sb-verify-phone">' . __('Verify now?', 'adforest') . '</a>';
                }
            }

            $verifed_phone_number = adforest_check_if_phoneVerified();
            $message_html = '';
            if ($verifed_phone_number) {
                $message_html = '<div role="alert" class="alert alert-info alert-dismissible">
                        <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">✕</span></button>
                        ' . __("Please verify your phone number to send a message.", "adforest") . '
                     </div>';
            }
            $message_html = apply_filters('adforest_ad_post_verified_id', $message_html, 'yes');
            $res = $message_html . '
	<div class="profile-section margin-bottom-20">
		<div class="profile-tabs">
		   <div class="tab-content">
			  <div class="profile-edit tab-pane fade in active" id="profile">
				 <h2 class="heading-md">' . __('Manage your profile', 'adforest') . '</h2>
				 <dl class="dl-horizontal">
					<dt><strong>' . __('Your name', 'adforest') . '</strong></dt>
					<dd>
					   ' . esc_html($this->user_info->display_name) . '
					</dd>
					<dt><strong>' . __('Email Address', 'adforest') . ' </strong></dt>
					<dd>
					   ' . esc_html($this->user_info->user_email) . '
					</dd>
					<dt><strong>' . __('Phone Number', 'adforest') . ' </strong></dt>
					<dd>
					   ' . esc_html(get_user_meta($this->user_info->ID, '_sb_contact', true)) . '
					   &nbsp;' . $is_verified . '
					</dd>
					<dt><strong>' . __('You are a(n)', 'adforest') . ' </strong></dt>
					<dd>
					   ' . $user_type . '
					</dd>
					<dt><strong>' . __('Location', 'adforest') . ' </strong></dt>
					<dd>
					   ' . esc_html(get_user_meta($this->user_info->ID, '_sb_address', true)) . '
					</dd>
						' . $paid_html . '
				 </dl>
			  </div>

		   </div>
		</div>
	 </div>';
            $sb_user_phone_num = get_user_meta($this->user_info->ID, '_sb_contact', true);

            $phone_verified_html = '<div class="modal-body">'
                    . '<div class="alert alert-warning" role="alert">' . __('Oops! The phone number is missing, please update the profile and add a number to verify.', 'adforest') . '</div></div>';

            if (isset($sb_user_phone_num) && $sb_user_phone_num != '') {
                $phone_verified_html = '<form id="sb-ph-verification">
                                        <div class="modal-body">

                                           <div class="form-group sb_ver_ph_div">
                                             <label>' . __('Phone number', 'adforest') . '</label>
                                             <input class="form-control" value="' . esc_html($sb_user_phone_num) . '" type="text" name="sb_ph_number" id="sb_ph_number" readonly>
                                           </div>
                                           <div class="form-group sb_ver_ph_code_div no-display">
                                             <label>' . __('Enter code', 'adforest') . '</label>
                                             <input class="form-control" type="text" name="sb_ph_number_code" id="sb_ph_number_code">
                                               <small class="pull-right">' . __('Did not get code?', 'adforest') . ' <a href="javascript:void(0);" class="small_text" id="resend_now">' . __('Resend now', 'adforest') . '</a></small>
                                           </div>
                                        </div>
                                        <div class="modal-footer">
                                              <button class="btn btn-theme btn-sm" type="button" id="sb_verification_ph">' . __('Verify now', 'adforest') . '</button>
                                              <button class="btn btn-theme btn-sm no-display" type="button" id="sb_verification_ph_back">' . __('Processing ...', 'adforest') . '</button>
                                              <button class="btn btn-theme btn-sm no-display" type="button" id="sb_verification_ph_code">' . __('Verify now', 'adforest') . '</button>

                                        </div>
                                 </form>';
            }


            return $res . '<div class="custom-modal">
                            <div id="verification_modal" class="sb-verify-modal modal fade" role="dialog">
                               <div class="modal-dialog">
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                     <div class="modal-header">
                                        <h2 class="modal-title">' . __('Verify phone number', 'adforest') . '</h2>
                                     </div>
                                      ' . $phone_verified_html . '
                                  </div>
                               </div>
                            </div>
                       </div>';
        }

        function adforest_profile_update_form() {
            $user_pic = $user_pic = adforest_get_user_dp($this->user_info->ID);

            $is_indiviual = '';
            $is_dealer = '';
            if (get_user_meta($this->user_info->ID, '_sb_user_type', true) == 'Dealer') {
                $is_dealer = 'selected="selected"';
            }
            if (get_user_meta($this->user_info->ID, '_sb_user_type', true) == 'Indiviual') {
                $is_indiviual = 'selected="selected"';
            }
            $user_type = '<option value="Indiviual"  ' . $is_indiviual . '>' . __('Individual', 'adforest') . '</option>
					 <option value="Dealer" ' . $is_dealer . '>' . __('Dealer', 'adforest') . '</option>';


            $change_password_html = '';
            $my_url = adforest_get_current_url();
            if (strpos($my_url, 'adforest.scriptsbundle.com') !== false) {
                $change_password_html = '<a data-toggle="tooltip" data-placement="top" title="' . __('Change Password', 'adforest') . '" data-original-title="' . __('Disable for Demo', 'adforest') . '">' . __('Change Password', 'adforest') . '</a>';
            } else {
                $change_password_html = '<a data-target="#myModal" data-toggle="modal">' . __('Change Password', 'adforest') . '</a>';
            }
            $intro_html = '';
            if (true) {
                $intro_html = '<div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-30">
						  <label>' . __('Introduction', 'adforest') . ' <span class="color-red"></span></label>
						  <textarea name="sb_user_intro" class="form-control" rows="6">' . esc_attr(get_user_meta($this->user_info->ID, '_sb_user_intro', true)) . '</textarea>
					   </div>';
            }
            global $adforest_theme;
            if (isset($adforest_theme['sb_enable_social_links']) && $adforest_theme['sb_enable_social_links']) {
                $social_html = '';
                $profiles = adforest_social_profiles();
                foreach ($profiles as $key => $value) {

                    $social_html .= '<div class="col-md-6 col-sm-6 col-xs-12">
						  <label>' . $value . ' <span class="color-red"></span></label>
						  <input type="text" class="form-control margin-bottom-20" value="' . esc_attr(get_user_meta($this->user_info->ID, '_sb_profile_' . $key, true)) . '" name="_sb_profile_' . $key . '">
					   </div>';
                }
            }


            $ph_placeholder = '';
            $sms_gateway = adforest_verify_sms_gateway();
            if ($sms_gateway != "") {
                $ph_placeholder = __('+CountrycodePhonenumber', 'adforest');
            }
            /* if (isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification'] && in_array('wp-twilio-core/core.php', apply_filters('active_plugins', get_option('active_plugins')))) {
              $ph_placeholder = __('+CountrycodePhonenumber', 'adforest');
              } */

            /* Delete Account HTML Starts */

            $delete_account_html = '';
            if (isset($adforest_theme['sb_new_user_delete_option']) && $adforest_theme['sb_new_user_delete_option']) {
                $data_title = __("Are you sure you want to delete this account?", "adforest");
                $delete_account_html = '<a class="remove_user_profile delete_site_user" href="javascript:void(0);" data-btn-ok-label="' . __("Yes", "adforest") . '" data-btn-cancel-label="' . __("No", "adforest") . '" data-toggle="confirmation" data-singleton="true" data-title="' . $data_title . '" data-content="" data-user-id="' . $this->user_info->ID . '" title="' . __("Delete Account?", "adforest") . '" aria-describedby="confirmation151400">' . __("Delete Account?", "adforest") . '</a>';
            }
            /* Delete Account HTML Ends */
            $counteries_load = '';
            ob_start();
            adforest_load_search_countries();


            $counteries_load = ob_get_contents();
            ob_end_clean();


            return $counteries_load . adforest_get_location('adforest_location') . '
	      <div class="profile-section margin-bottom-20">
		<div class="profile-tabs">
		   <div class="tab-content">
			<div class="profile-edit tab-pane fade in active" id="edit">
				 <h2 class="heading-md">' . __('Manage your Security Settings', 'adforest') . '</h2>
				 <p>' . __('Manage Your Account', 'adforest') . '</p>
				 <div class="clearfix"></div>
                                 <form id="sb_update_profile" enctype="multipart/form-data">
					<div class="row">
					   <div class="col-md-12 col-sm-12 col-xs-12">
						  <p class="help-block pull-right">
						  	' . $change_password_html . '
						  </p>
					   </div>
					   <div class="col-md-6 col-sm-6 col-xs-12">
						  <label>' . __('Your Name', 'adforest') . '</label>
						  <input type="text" class="form-control margin-bottom-20" value="' . esc_attr($this->user_info->display_name) . '" name="sb_user_name">
					   </div>
					   <div class="col-md-6 col-sm-6 col-xs-12">
						  <label>' . __('Email Address', 'adforest') . ' <span class="color-red">*</span></label>
						  <input type="text" class="form-control margin-bottom-20" value="' . esc_attr($this->user_info->user_email) . '" readonly>
					   </div>
					   <div class="col-md-6 col-sm-12 col-xs-12">
						  <label>' . __('Contact Number', 'adforest') . '<span class="color-red">*</span></label>
						  <input type="text" class="form-control margin-bottom-20" name="sb_user_contact" id="sb_user_contact" value="' . esc_attr(get_user_meta($this->user_info->ID, '_sb_contact', true)) . '" placeholder="' . $ph_placeholder . '">
					   </div>
					   <div class="col-md-6 col-sm-12 col-xs-12 margin-bottom-20 form-group">
						  <label>' . __('I am', 'adforest') . ' <span class="color-red">*</span></label>
						  <select class="category form-control" name="sb_user_type">
							 ' . $user_type . '
						  </select>
					   </div>
					   ' . $social_html . '
					   <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-20">
						  <label>' . __('Location', 'adforest') . ' <span class="color-red">*</span></label>
						  <input type="text" class="form-control margin-bottom-20" placeholder="' . __('Enter a location', 'adforest') . '"  name="sb_user_address" id="sb_user_address" autocomplete="on" value="' . esc_attr(get_user_meta($this->user_info->ID, '_sb_address', true)) . '">

					   </div>
					   ' . $intro_html . '
                                           ' . apply_filters('adforest_directory_user_opening_hours', '', $this->user_info->ID) . '
					</div>
				 <div class="row margin-bottom-20">
					   <div class="form-group">
						  <div class="col-md-9">
							 <div class="input-group">
								<span class="input-group-btn">
								<span class="btn btn-default btn-file">
								' . __('Profile Picture', 'adforest') . '
								<input type="file" id="imgInp" name="my_file_upload[]" accept = "image/*" class="sb_files-data form-control">
								</span>
								</span>
								<input type="text" class="form-control" readonly>
							 </div>
						  </div>
						  <div class="col-md-3">
							 <img id="img-upload" class="img-responsive" src="' . $user_pic . '" alt="' . __('Profile Picture', 'adforest') . '" width="100" height="100" />
						  </div>
					   </div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
					   <div class="col-md-8 col-sm-8 col-xs-12">
					   ' . $delete_account_html . '
					   </div>
					   <div class="col-md-4 col-sm-4 col-xs-12 text-right">
                                           <input type="hidden" id="sb-profile-token" value="' . wp_create_nonce('sb_profile_secure') . '" />
						  <button type="button" class="btn btn-theme btn-sm" id="sb_user_profile_update">
						  ' . __('Update My Info', 'adforest') . '
						  </button>
					   </div>
					</div>
				 </form>
                                 <script>  jQuery(document).ready(function () {jQuery("select").select2();});</script>
			  </div>
			  <div class="custom-modal">
         <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
               <!-- Modal content-->
               <div class="modal-content">
                  <div class="modal-header rte">
                     <h2 class="modal-title">' . __('Password Change', 'adforest') . '</h2>
                  </div>
		    <form id="sb-change-password">
                        <div class="modal-body">
                               <div class="form-group">
                                 <label>' . __('Current Password', 'adforest') . '</label>
                                 <input placeholder="' . __('Current Password', 'adforest') . '" class="form-control" type="password"  name="current_pass" id="current_pass">
                               </div>
                               <div class="form-group">
                                 <label>' . __('New Password', 'adforest') . '</label>
                                 <input placeholder="' . __('New Password', 'adforest') . '" class="form-control" type="password" name="new_pass" id="new_pass">
                               </div>
                               <div class="form-group">
                                 <label>' . __('Confirm New Password', 'adforest') . '</label>
                                 <input placeholder="' . __('Confirm Password', 'adforest') . '" class="form-control" type="password" name="con_new_pass" id="con_new_pass">
                               </div>
                        </div>
                        <div class="modal-footer">
                                  <input type="hidden" id="sb-profile-reset-pass-token" value="' . wp_create_nonce('sb_profile_reset_pass_secure') . '" />
                                  <button class="btn btn-theme btn-sm" type="button" id="change_pwd">' . __('Reset My Account', 'adforest') . '</button>
                        </div>
		    </form>
               </div>
            </div>
         </div>
      </div>
		';
        }

        // Get met Ads
        function adforest_my_ads($args, $paged, $show_pagination, $fav_ads) {

            $ads = new ads();
            return $ads->adforest_get_ads_grid($args, $paged, $show_pagination, $fav_ads);
        }

        // Get met Ads
        function adforest_my_expire_sold_ads($args, $paged, $show_pagination, $fav_ads) {
            $ads = new ads();
            return $ads->adforest_get_ads_grid($args, $paged, $show_pagination, $fav_ads);
        }

    }

}


// Ajax handler for add to cart
add_action('wp_ajax_sb_add_cart', 'adforest_add_to_cart');
add_action('wp_ajax_nopriv_sb_add_cart', 'adforest_add_to_cart');
if (!function_exists('adforest_add_to_cart')) {

    function adforest_add_to_cart() {
        global $adforest_theme;
        $sb_packages_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_packages_page']);
        $redirect_url = adforest_login_with_redirect_url_param(get_the_permalink($sb_packages_page));
        if (get_current_user_id() == "") {
            echo '0|' . __("You need to be logged in.", 'adforest') . '|' . $redirect_url;
            die();
        }

        $product_id = $_POST['product_id'];
        $qty = $_POST['qty'];
        global $woocommerce;
        if ($woocommerce->cart->add_to_cart($product_id, $qty)) {
            echo '1|' . __("Added to cart.", 'adforest') . '|' . wc_get_cart_url();
        } else {
            echo '1|' . __("Already in your cart.", 'adforest') . '|' . wc_get_cart_url();
        }
        die();
    }

}

// Make ad featured
add_action('wp_ajax_sb_make_featured', 'adforest_make_featured');
if (!function_exists('adforest_make_featured')) {

    function adforest_make_featured() {
        $ad_id = $_POST['ad_id'];
        $user_id = get_current_user_id();

        if (get_post_field('post_author', $ad_id) == $user_id) {

            if (get_post_meta($ad_id, '_adforest_is_feature', true) == '1') {
                echo '0|' . __("This ad is featured already.", 'adforest');
                die();
            }

            if (get_user_meta($user_id, '_sb_featured_ads', true) != 0) {
                if (get_user_meta($user_id, '_sb_expire_ads', true) != '-1') {
                    if (get_user_meta($user_id, '_sb_expire_ads', true) < date('Y-m-d')) {
                        echo '0|' . __("Your package has expired.", 'adforest');
                        die();
                    }
                }
                $feature_ads = get_user_meta($user_id, '_sb_featured_ads', true);
                $feature_ads = $feature_ads - 1;
                update_user_meta($user_id, '_sb_featured_ads', $feature_ads);

                update_post_meta($ad_id, '_adforest_is_feature', '1');
                update_post_meta($ad_id, '_adforest_is_feature_date', date('Y-m-d'));
                echo '1|' . __("This ad has been featured successfullly.", 'adforest');
            } else {
                echo '0|' . __("Get package in order to make it featured.", 'adforest');
            }
        } else {
            echo '0|' . __("You must be the Ad owner to make it featured.", 'adforest');
        }

        die();
    }

}
/* Delete USER */
// Bump it up
add_action('wp_ajax_delete_site_user_func', 'adforest_delete_site_user_func');
if (!function_exists('adforest_delete_site_user_func')) {

    function adforest_delete_site_user_func() {
        $del_user_id = $_POST['del_user_id'];
        $current_user_id = get_current_user_id();

        $success = 0;
        $message = __("Something went wrong.", "adforest");
        $if_user_exists = adforest_user_id_exists($del_user_id);
        if ($current_user_id == $del_user_id && $if_user_exists) {
            if (current_user_can('administrator')) {

                $success = 0;
                $message = __("Admin can not delete his account from here.", "adforest");
            } else {
                adforestTheme_delete_userComments($current_user_id);
                $user_delete = wp_delete_user($current_user_id);
                if ($user_delete) {

                    $success = 1;
                    $message = __("Your account has been deleted successfully.", "adforest");
                    wp_logout();
                }
            }
        }
        echo adforest_returnEcho($success . '|' . $message);
        die();
    }

}

if (!function_exists('adforest_user_id_exists')) {

    function adforest_user_id_exists($user) {

        global $wpdb;

        $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE ID = %d", $user));

        if ($count == 1) {
            return true;
        } else {
            return false;
        }
    }

}

if (!function_exists('adforestTheme_delete_userComments')) {

    function adforestTheme_delete_userComments($user_id) {
        $user = get_user_by('id', $user_id);

        $comments = get_comments('author_email=' . $user->user_email);
        foreach ($comments as $comment) :
            wp_delete_comment($comment->$comment_id, true);
        endforeach;

        $comments = get_comments('user_id=' . $user_id);
        foreach ($comments as $comment) :
            wp_delete_comment($comment->$comment_id, true);
        endforeach;
    }

}


// Bump it up
add_action('wp_ajax_sb_bump_it_up', 'adforest_bump_it_up');
if (!function_exists('adforest_bump_it_up')) {

    function adforest_bump_it_up() {
        $ad_id = $_POST['ad_id'];
        $user_id = get_current_user_id();
        adforest_set_date_timezone();
        if (get_post_field('post_author', $ad_id) == $user_id) {
            global $adforest_theme;
            // Uptaing remaining ads.
            $bump_ads = get_user_meta($user_id, '_sb_bump_ads', true);
            if ($bump_ads > 0 || $bump_ads == '-1' || ( isset($adforest_theme['sb_allow_free_bump_up']) && $adforest_theme['sb_allow_free_bump_up'] )) {
                wp_update_post(
                        array(
                            'ID' => $ad_id, // ID of the post to update
                            'post_date' => current_time('mysql'),
                           // 'post_date' => date('Y-m-d H:i:s'),
                            'post_date_gmt' => get_gmt_from_date(current_time('mysql'))
                           // 'post_date_gmt' => get_gmt_from_date(date('Y-m-d H:i:s'))
                        )
                );
                //echo date('Y-m-d H:i:s');
                if (!$adforest_theme['sb_allow_free_bump_up'] && $bump_ads != '-1') {
                    $bump_ads = $bump_ads - 1;
                    update_user_meta($user_id, '_sb_bump_ads', $bump_ads);
                }

                echo '1|' . __("Bumped up successfully.", 'adforest');
                die();
            } else {
                echo '0|' . __("Buy package to make it bump.", 'adforest');
                die();
            }
        } else {
            echo '0|' . __("You must be the Ad owner to make it featured.", 'adforest');
        }

        die();
    }

}

// Ajax handler for My ads
add_action('wp_ajax_sb_packages', 'adforest_packages');
if (!function_exists('adforest_packages')) {

    function adforest_packages() {
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'order' => 'DESC',
            'orderby' => 'ID'
        );

        $package = new packages();
        echo adforest_returnEcho($package->adforest_get_packages_style_1($args, 4));

        die();
    }

}


// Ajax handler for My ads
add_action('wp_ajax_sb_load_messages', 'adforest_load_messages');
if (!function_exists('adforest_load_messages')) {

    function adforest_load_messages() {
        $ad_id = $_POST['ad_id'];
        $profile = new adforest_profile();
        $args = array(
            'post_type' => 'ad_post',
            'author' => $profile->user_info->ID,
            'post_status' => 'publish',
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
            'order' => 'DESC',
            'orderby' => 'ID'
        );


        $ads = new ads();
        echo adforest_returnEcho($ads->adforest_load_messages($ad_id));

        die();
    }

}

// Ajax handler for messages
add_action('wp_ajax_my_msgs', 'adforest_my_msgs');
if (!function_exists('adforest_my_msgs')) {

    function adforest_my_msgs() {
        $profile = new adforest_profile();
        $ads = new ads();
        echo adforest_returnEcho($ads->adforest_get_messages($profile->user_info->ID));

        die();
    }

}
// Ajax handler for messages
add_action('wp_ajax_adforest_all_blocked_users', 'adforest_all_blocked_users_callback');
if (!function_exists('adforest_all_blocked_users_callback')) {

    function adforest_all_blocked_users_callback() {
        $profile = new adforest_profile();
        $ads = new ads();
        echo adforest_returnEcho($ads->adforest_all_blocked_users_callback($profile->user_info->ID));

        die();
    }

}

// ajax handler for featured Ads

add_action('wp_ajax_my_feature_ads', 'adforest_my_feature_ads');
if (!function_exists('adforest_my_feature_ads')) {

    function adforest_my_feature_ads() {
        $profile = new adforest_profile();
        $paged = $_POST['paged'];
        if (!isset($paged))
            $paged = 1;
        $args = array(
            'post_type' => 'ad_post',
            'author' => $profile->user_info->ID,
            'post_status' => 'publish',
            'posts_per_page' => get_option('posts_per_page'),
            'meta_key' => '_adforest_is_feature',
            'meta_value' => '1',
            'paged' => $paged,
            'order' => 'DESC',
            'orderby' => 'ID'
        );
        $fav_ads = 'featured_ads';
        $show_pagination = 1;
        $ads = new ads();

        echo adforest_returnEcho($ads->adforest_get_featured_ads_grid($args, $paged, $show_pagination, $fav_ads));
        echo '<script>adforest_timerCounter_function();</script>';
        die();
    }

}

// Ajax handler for My ads
add_action('wp_ajax_my_ads', 'adforest_my_ads');
if (!function_exists('adforest_my_ads')) {

    function adforest_my_ads() {
        $profile = new adforest_profile();
        $paged = isset($_POST['paged']) && $_POST['paged'] != '' ? $_POST['paged'] : 1;
        if (!isset($paged))
            $paged = 1;
        $args = array(
            'post_type' => 'ad_post',
            'author' => $profile->user_info->ID,
            'post_status' => 'publish',
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
            'order' => 'DESC',
            'orderby' => 'date'
        );
        $fav_ads = 'no';
        $show_pagination = 1;
        echo adforest_returnEcho($profile->adforest_my_ads($args, $paged, $show_pagination, $fav_ads));

        die();
    }

}

// Ajax handler my_ads_msgs
add_action('wp_ajax_received_msgs_ads_list', 'adforest_received_msgs_ads_list');
if (!function_exists('adforest_received_msgs_ads_list')) {

    function adforest_received_msgs_ads_list() {
        $ads = new ads();
        echo adforest_returnEcho($ads->adforest_get_user_ads_list());

        die();
    }

}

// Ajax handler for My ads
add_action('wp_ajax_my_inactive_ads', 'adforest_my_inactive_ads');
if (!function_exists('adforest_my_inactive_ads')) {

    function adforest_my_inactive_ads() {
        $profile = new adforest_profile();
        $paged = $_POST['paged'];
        if (!isset($paged))
            $paged = 1;
        $args = array(
            'post_type' => 'ad_post',
            'author' => $profile->user_info->ID,
            'post_status' => array('pending'),
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
            'order' => 'DESC',
            'orderby' => 'ID'
        );
        $show_pagination = 1;

        $ads = new ads();
        echo adforest_returnEcho($ads->adforest_get_ads_grid_inactive($args, $paged, $show_pagination, 'inactive'));

        die();
    }

}
// Ajax handler for Expire Sold ads
add_action('wp_ajax_my_expire_sold_ads', 'adforest_my_expire_sold_ads');
if (!function_exists('adforest_my_expire_sold_ads')) {

    function adforest_my_expire_sold_ads() {
        $profile = new adforest_profile();
        $paged = $_POST['paged'];
        if (!isset($paged))
            $paged = 1;
        $args = array(
            'post_type' => 'ad_post',
            'author' => $profile->user_info->ID,
            'post_status' => array('draft'),
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
            'order' => 'DESC',
            'orderby' => 'ID'
        );
        $show_pagination = 1;
        $fav_ads = 'no';
        $ads = new ads();
        echo adforest_returnEcho($profile->adforest_my_expire_sold_ads($args, $paged, $show_pagination, 'expired_sold'));
        die();
    }

}
// Ajax handler for Rejected ads
add_action('wp_ajax_my_rejected_ads', 'adforest_my_rejected_ads');
if (!function_exists('adforest_my_rejected_ads')) {

    function adforest_my_rejected_ads() {
        $profile = new adforest_profile();
        $paged = $_POST['paged'];
        if (!isset($paged))
            $paged = 1;
        $args = array(
            'post_type' => 'ad_post',
            'author' => $profile->user_info->ID,
            'post_status' => 'rejected',
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
            'order' => 'DESC',
            'orderby' => 'ID'
        );
        $show_pagination = 1;

        $ads = new ads();
        echo adforest_returnEcho($ads->adforest_get_ads_grid_rejected($args, $paged, $show_pagination, 'rejected'));

        die();
    }

}

// Ajax handler for My ads
add_action('wp_ajax_my_fav_ads', 'adforest_my_fav_ads');
if (!function_exists('adforest_my_fav_ads')) {

    function adforest_my_fav_ads() {
        $profile = new adforest_profile();
        $paged = $_POST['paged'];
        if (!isset($paged))
            $paged = 1;

        // Getting most ID of fav ads
        global $wpdb;
        $uid = $profile->user_info->ID;
        $rows = $wpdb->get_results("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$uid' AND meta_key LIKE '_sb_fav_id_%'");
        $pids = array(0);
        foreach ($rows as $row) {
            $pids[] = $row->meta_value;
        }
        $args = array(
            'post_type' => 'ad_post',
            'post__in' => $pids,
            'post_status' => 'publish',
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
            'order' => 'DESC',
            'orderby' => 'date'
        );
        $show_pagination = 1;
        $fav_ads = 'yes';
        echo adforest_returnEcho($profile->adforest_my_ads($args, $paged, $show_pagination, $fav_ads));
        die();
    }

}

// Ajax handler for Order history

add_action('wp_ajax_my_orders', 'adforest_order_history');
if (!function_exists('adforest_order_history')) {

    function adforest_order_history() {
        $args = array(
            'customer_id' => get_current_user_id(),
        );
        $history_html = '
	<table class="table table-striped">
     <thead>
        <tr class="row-name">

           <th>' . __('Order #', 'adforest') . '</th>
           <th width="30%">' . __('Package(s)', 'adforest') . '</th>
           <th>' . __('Status', 'adforest') . '</th>
           <th>' . __('Date', 'adforest') . '</th>
           <th>' . __('Order total', 'adforest') . '</th>
        </tr>
     </thead>
     <tbody>';
        $orders = wc_get_orders($args);
        if (count((array) $orders) > 0) {
            foreach ($orders as $order) {
                $items = $order->get_items();
                $product_name = '';
                foreach ($items as $item) {
                    $product_name .= $item->get_name() . ',';
                }

                $history_html .= '<tr class="row-content">
			   <td>' . $order->get_id() . '</td>
			   <td>' . rtrim($product_name, ',') . '</td>
			   <td> <span class="label label-default"> ' . wc_get_order_status_name($order->get_status()) . ' </span></td>
			   <td>' . date_i18n(get_option('date_format'), strtotime($order->get_date_created())) . '</td>
			   <td>' . $order->get_total() . '</td>
			</tr>';
            }
        } else {
            $history_html .= '<td colspan="5">' . __('There is no order history found.', 'adforest') . '</td>';
        }
        $history_html .= '</tbody></table>';


        echo '	<div class="profile-section margin-bottom-20">
		<div class="profile-tabs">
		   <div class="tab-content">
			  <div class="profile-edit tab-pane fade in active" id="profile">
				 <h2 class="heading-md">' . __('Packages purchase history', 'adforest') . '</h2>
				 <br />
				 <div class="table-responsive">
				 ' . $history_html . '
				 </div>
				</dl>
				</div>
				</div>
				</div>';
        die();
    }

}

// Ajax hander for get profile
add_action('wp_ajax_get_profile', 'adforest_profile_get_ajax');
if (!function_exists('adforest_profile_get_ajax')) {

    function adforest_profile_get_ajax() {
        $profile = new adforest_profile();
        echo adforest_returnEcho($profile->adforest_profile_get());
        die();
    }

}


// Ajax hander for update profile
add_action('wp_ajax_update_profile', 'adforest_profile_update_ajax');
if (!function_exists('adforest_profile_update_ajax')) {

    function adforest_profile_update_ajax() {
        $profile = new adforest_profile();
        echo adforest_returnEcho($profile->adforest_profile_update_form());
        die();
    }

}

// Ajax hander for update profile processing
add_action('wp_ajax_sb_update_profile', 'adforest_profile_update_ajax_processed');
if (!function_exists('adforest_profile_update_ajax_processed')) {

    function adforest_profile_update_ajax_processed() {

        // Getting values
        $params = array();
        parse_str($_POST['sb_data'], $params);
        check_ajax_referer('sb_profile_secure', 'security');
        $profile = new adforest_profile();
        $uid = $profile->user_info->ID;

        global $adforest_theme;
        $sms_gateway = adforest_verify_sms_gateway();
        if ($sms_gateway != "") {
            $ph_num = sanitize_text_field($params['sb_user_contact']);
            if (!preg_match("/\+[0-9]+$/", $ph_num)) {
                echo __('Please enter valid phone number +CountrycodePhonenumber', 'adforest');
                die();
            }

            $saved_ph = get_user_meta($uid, '_sb_contact', true);
            if ($saved_ph != $ph_num) {
                update_user_meta($uid, '_sb_is_ph_verified', '0');
            }
        }

        /* if (isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification'] && in_array('wp-twilio-core/core.php', apply_filters('active_plugins', get_option('active_plugins')))) {
          $ph_num = sanitize_text_field($params['sb_user_contact']);
          if (!preg_match("/\+[0-9]+$/", $ph_num)) {
          echo __('Please enter valid phone number +CountrycodePhonenumber', 'adforest');
          die();
          }

          $saved_ph = get_user_meta($uid, '_sb_contact', true);
          if ($saved_ph != $ph_num) {
          update_user_meta($uid, '_sb_is_ph_verified', '0');
          }
          } */

        wp_update_user(array('ID' => $uid, 'display_name' => sanitize_text_field($params['sb_user_name'])));
        update_user_meta($uid, '_sb_contact', sanitize_text_field($params['sb_user_contact']));
        update_user_meta($uid, '_sb_address', sanitize_text_field($params['sb_user_address']));
        update_user_meta($uid, '_sb_user_type', sanitize_text_field($params['sb_user_type']));
        update_user_meta($uid, '_sb_user_intro', sanitize_textarea_field($params['sb_user_intro']));

        $profiles = adforest_social_profiles();
        foreach ($profiles as $key => $value) {
            update_user_meta($uid, '_sb_profile_' . $key, sanitize_textarea_field($params['_sb_profile_' . $key]));
        }

        do_action('adforest_directory_update_profile_opening_hours', $uid, $params);


        echo '1';
        die();
    }

}

add_action('wp_ajax_upload_user_pic', 'adforest_user_profile_pic');
if (!function_exists('adforest_user_profile_pic')) {

    function adforest_user_profile_pic() {


        /* img upload */

        $condition_img = 7;
        $img_count = count(explode(',', $_POST["image_gallery"]));

        if (!empty($_FILES["my_file_upload"])) {

            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';


            $files = $_FILES["my_file_upload"];



            $attachment_ids = array();
            $attachment_idss = '';

            if ($img_count >= 1) {
                $imgcount = $img_count;
            } else {
                $imgcount = 1;
            }


            $ul_con = '';

            foreach ($files['name'] as $key => $value) {
                if ($files['name'][$key]) {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );

                    $_FILES = array("my_file_upload" => $file);

                    // Allow certain file formats
                    $imageFileType = strtolower(end(explode('.', $file['name'])));
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        echo '0|' . __("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", 'adforest');
                        die();
                    }

                    // Check file size
                    if ($file['size'] > 2097152) {
                        echo '0|' . __("Max allowd image size is 2MB", 'adforest');
                        die();
                    }


                    foreach ($_FILES as $file => $array) {

                        if ($imgcount >= $condition_img) {
                            break;
                        }
                        $attach_id = media_handle_upload($file, $post_id);
                        $attachment_ids[] = $attach_id;

                        $image_link = wp_get_attachment_image_src($attach_id, 'adforest-user-profile');
                    }
                    if ($imgcount > $condition_img) {
                        break;
                    }
                    $imgcount++;
                }
            }
        }
        /* img upload */
        $attachment_idss = array_filter($attachment_ids);
        $attachment_idss = implode(',', $attachment_idss);


        $arr = array();
        $arr['attachment_idss'] = $attachment_idss;
        $arr['ul_con'] = $ul_con;

        $profile = new adforest_profile();
        $uid = $profile->user_info->ID;
        update_user_meta($uid, '_sb_user_pic', $attach_id);
        echo '1|' . $image_link[0];
        die();
    }

}

if (!function_exists('adforest_get_all_ads')) {

    function adforest_get_all_ads($user_id) {
        global $wpdb;
        $total = $wpdb->get_var("SELECT COUNT(*) AS total FROM  $wpdb->posts WHERE post_type = 'ad_post' AND post_status = 'publish' AND post_author = '$user_id'");
        $total = apply_filters('adforest_get_lang_posts_by_author', $total, $user_id);
        return $total;
    }

}

if (!function_exists('adforest_get_sold_ads')) {

    function adforest_get_sold_ads($user_id) {
        global $wpdb;
        $total = $wpdb->get_var("SELECT COUNT(*) AS total FROM $wpdb->posts WHERE post_type = 'ad_post' AND post_author = '$user_id' AND post_status = 'publich' ");

        $args = array(
            'post_type' => 'ad_post',
            'author' => $user_id,
             'posts_per_page' => -1,
            'post_status' => 'draft',
            'meta_key' => '_adforest_ad_status_',
            'meta_value' => 'sold',
        );
        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $args = apply_filters('adforest_site_location_ads', $args, 'ads');
        $query = new WP_Query($args);
        return $query->post_count;
    }

}

if (!function_exists('adforest_get_fav_ads')) {

    function adforest_get_fav_ads($user_id) {
        global $wpdb;
        $rows = $wpdb->get_results("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$user_id' AND meta_key LIKE  '_sb_fav_id%' ");
        $total = 0;
        foreach ($rows as $row) {
            if (get_post_status($row->meta_value) == 'publish') {
                $total++;
            }
        }
        return $total;
    }

}

if (!function_exists('adforest_get_disbale_ads')) {

    function adforest_get_disbale_ads($user_id) {
        global $wpdb;
        $rows = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_author = '$user_id' AND post_status = 'pending' AND post_type = 'ad_post' ");

        return count($rows);
    }

}


// Add to favourites
add_action('wp_ajax_sb_fav_ad', 'adforest_sb_fav_ad');
add_action('wp_ajax_nopriv_sb_fav_ad', 'adforest_sb_fav_ad');
if (!function_exists('adforest_sb_fav_ad')) {

    function adforest_sb_fav_ad() {
        adforest_authenticate_check();

        $ad_id = $_POST['ad_id'];

        if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $ad_id, true) == $ad_id) {
            echo '0|' . __("You have added already.", 'adforest');
        } else {
            update_user_meta(get_current_user_id(), '_sb_fav_id_' . $ad_id, $ad_id);
            echo '1|' . __("Added to your favourites.", 'adforest');
        }


        die();
    }

}

// Remove to favourites
add_action('wp_ajax_sb_fav_remove_ad', 'adforest_sb_fav_remove_ad');
if (!function_exists('adforest_sb_fav_remove_ad')) {

    function adforest_sb_fav_remove_ad() {
        adforest_authenticate_check();

        $ad_id = $_POST['ad_id'];

        if (delete_user_meta(get_current_user_id(), '_sb_fav_id_' . $ad_id)) {
            echo '1|' . __("Ad removed successfully.", 'adforest');
        } else {
            echo '0|' . __("There'is some problem, please try again later.", 'adforest');
        }
        die();
    }

}

// Remove Ad
add_action('wp_ajax_sb_remove_ad', 'adforest_sb_remove_ad');
if (!function_exists('adforest_sb_remove_ad')) {

    function adforest_sb_remove_ad() {
        adforest_authenticate_check();

        $ad_id = $_POST['ad_id'];
        $stored_status = get_post_meta($ad_id, '_adforest_ad_status_', true);
        if (wp_trash_post($ad_id)) {
            echo '1|' . __("Ad removed successfully.", 'adforest');
        } else {
            echo '0|' . __("There'is some problem, please try again later.", 'adforest');
        }

        die();
    }

}


// Remove Ad
add_action('wp_ajax_sb_update_ad_status', 'adforest_sb_update_ad_status');
if (!function_exists('adforest_sb_update_ad_status')) {

    function adforest_sb_update_ad_status() {
        adforest_authenticate_check();
        $ad_id = $_POST['ad_id'];
        $status = $_POST['status'];

        $sb_status_array = array(
            'expired' => 'draft',
            'sold' => 'draft',
            'active' => 'publish',
        );

        update_post_meta($ad_id, '_adforest_ad_status_', $status);

        $my_post = array(
            'ID' => $ad_id,
            'post_status' => $sb_status_array[$status],
        );

        wp_update_post($my_post);

        echo '1|' . __("Updated successfully.", 'adforest');
        die();
    }

}


// Get user profile PIC
if (!function_exists('adforest_get_user_dp')) {

    function adforest_get_user_dp($user_id, $size = 'adforest-single-small') {
        global $adforest_theme;
        $user_pic = trailingslashit(get_template_directory_uri()) . 'images/users/9.jpg';
        if (isset($adforest_theme['sb_user_dp']['url']) && $adforest_theme['sb_user_dp']['url'] != "") {
            $user_pic = $adforest_theme['sb_user_dp']['url'];
        }

        $image_link = array();
        if (get_user_meta($user_id, '_sb_user_pic', true) != "") {
            $attach_id = get_user_meta($user_id, '_sb_user_pic', true);
            $image_link = wp_get_attachment_image_src($attach_id, $size);
        }
        if (isset($image_link) && !empty($image_link) && is_array($image_link) && count($image_link) > 0) {
            if ($image_link[0] != "") {
                $headers = @get_headers($image_link[0]);
                if (strpos($headers[0], '404') === false) {

                    return $image_link[0];
                } else {
                    return $user_pic;
                }
            } else {
                return $user_pic;
            }
        } else {
            return $user_pic;
        }
    }

}

// check permission for ad posting
if (!function_exists('adforest_check_validity')) {

    function adforest_check_validity() {
        global $adforest_theme;
        $uid = get_current_user_id();
        $sb_packages_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_packages_page']);
        if (get_user_meta($uid, '_sb_simple_ads', true) == 0 || get_user_meta($uid, '_sb_simple_ads', true) == "") {
            adforest_redirect_with_msg(get_the_permalink($sb_packages_page), __('Please subscribe to a package to post an ad.', 'adforest'));
            exit;
        } else {

            if (get_user_meta($uid, '_sb_expire_ads', true) != '-1') {
                if (get_user_meta($uid, '_sb_expire_ads', true) < date('Y-m-d')) {
                    update_user_meta($uid, '_sb_simple_ads', 0);
                    update_user_meta($uid, '_sb_featured_ads', 0);
                    adforest_redirect_with_msg(get_the_permalink($sb_packages_page), __("Your package has been expired.", 'adforest'));
                    exit;
                }
            }
        }
    }

}

if (!function_exists('adforest_load_countries')) {

    function adforest_load_countries() {
        global $wpdb;
        $res = $wpdb->get_results("SELECT post_excerpt FROM $wpdb->posts WHERE post_type = '_sb_country' AND post_status = 'publish'");
        $countries = array();
        foreach ($res as $r) {
            $countries[] = $r->post_excerpt;
        }
        return json_encode($countries);
    }

}

if (!function_exists('adforest_load_search_countries')) {

    function adforest_load_search_countries($action_on_complete = '') {
        global $adforest_theme;
        $stricts = '';
        if (isset($adforest_theme['sb_location_allowed']) && !$adforest_theme['sb_location_allowed'] && isset($adforest_theme['sb_list_allowed_country'])) {
            $stricts = "componentRestrictions: {country: " . json_encode($adforest_theme['sb_list_allowed_country']) . "}";
        }
        $types = "'(cities)'";
        if (isset($adforest_theme['sb_location_type']) && $adforest_theme['sb_location_type'] != "") {
            if ($adforest_theme['sb_location_type'] == 'regions')
                $types = "";
            else
                $types = "'(cities)'";
        }

        echo "<script>
	   function adforest_location() {
	   var options = {
                types: [" . $types . "],
                " . $stricts . "
               };
      var input = document.getElementById('sb_user_address');
	  var action_on_complete	=	'" . $action_on_complete . "';
      var autocomplete = new google.maps.places.Autocomplete(input, options);
	  if( action_on_complete )
	  {
	   new google.maps.event.addListener(autocomplete, 'place_changed', function() {
	  // document.getElementById('sb_loading').style.display	= 'block';
    var place = autocomplete.getPlace();
	document.getElementById('ad_map_lat').value = place.geometry.location.lat();
	document.getElementById('ad_map_long').value = place.geometry.location.lng();
	var markers = [
        {
            'title': '',
            'lat': place.geometry.location.lat(),
            'lng': place.geometry.location.lng(),
        },
    ];

	my_g_map(markers);
	//document.getElementById('sb_loading').style.display	= 'none';
});
	   }

   }
   </script>";
    }

}

// Ajax handler for Change Password
add_action('wp_ajax_sb_change_password', 'adforest_change_password');
if (!function_exists('adforest_change_password')) {

    function adforest_change_password() {
        adforest_authenticate_check();
        global $adforest_theme;
        // Getting values
        $params = array();
        parse_str($_POST['sb_data'], $params);
        check_ajax_referer('sb_profile_reset_pass_secure', 'security');
        $current_pass = $params['current_pass'];
        $new_pass = $params['new_pass'];
        $con_new_pass = $params['con_new_pass'];
        if ($current_pass == "" || $new_pass == "" || $con_new_pass == "") {
            echo '0|' . __("All fields are required.", 'adforest');
            die();
        }
        if ($new_pass != $con_new_pass) {
            echo '0|' . __("New password not matched.", 'adforest');
            die();
        }
        $user = get_user_by('ID', get_current_user_id());
        if ($user && wp_check_password($current_pass, $user->data->user_pass, $user->ID)) {
            wp_set_password($new_pass, $user->ID);
            echo '1|' . __("Password changed successfully.", 'adforest');
        } else {
            echo '0|' . __("Current password not matched.", 'adforest');
        }

        die();
    }

}

// Check Notification
add_action('wp_ajax_sb_check_messages', 'adforest_check_messages');
if (!function_exists('adforest_check_messages')) {

    function adforest_check_messages() {
        adforest_authenticate_check();

        $user_id = get_current_user_id();
        $current_msgs = $_POST['new_msgs'];
        global $wpdb;
        $unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' ");
        //$unread_msgs = ADFOREST_MESSAGE_COUNT; // Message count define in header
        if ($unread_msgs > $current_msgs) {
            global $adforest_theme;
            echo '1|' . str_replace('%count%', $unread_msgs, $adforest_theme['msg_notification_text']) . '|' . $unread_msgs;
        }
        die();
    }

}


// Check Notification
add_action('wp_ajax_sb_get_notifications', 'adforest_get_notifications');
if (!function_exists('adforest_get_notifications')) {

    function adforest_get_notifications() {
        global $wpdb;
        global $adforest_theme;
        $user_id = get_current_user_id();
        $notes = $wpdb->get_results("SELECT * FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND  meta_value = 0 ORDER BY meta_id DESC LIMIT 5", OBJECT);
        if (count($notes) > 0) {
            $list = '';
            foreach ($notes as $note) {
                $ad_img = adforest_get_ad_default_image_url('adforest-single-small');
                $get_arr = explode('_', $note->meta_key);
                $ad_id = $get_arr[0];
                $media = adforest_get_ad_images($ad_id);
                if (count($media) > 0) {
                    $counting = 1;
                    foreach ($media as $m) {
                        if ($counting > 1) {
                            $mid = '';
                            if (isset($m->ID))
                                $mid = $m->ID;
                            else
                                $mid = $m;

                            $image = wp_get_attachment_image_src($mid, 'adforest-single-small');
                            if ($image[0] != "") {
                                $ad_img = $image[0];
                            }
                            break;
                        }
                        $counting++;
                    }
                }
                $sb_profile_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_profile_page']);
                $action = get_the_permalink($sb_profile_page) . '?sb_action=sb_get_messages' . '&ad_id=' . $ad_id . '&user_id=' . $user_id . '&uid=' . $get_arr[1] . '&sb_msg_token="' . wp_create_nonce('sb_msg_secure') . '"';
                $poster_id = get_post_field('post_author', $ad_id);
                if ($poster_id == $user_id) {
                    $action = get_the_permalink($sb_profile_page) . '?sb_action=sb_load_messages' . '&ad_id=' . $ad_id . '&uid=' . $get_arr[1] . '&sb_msg_token="' . wp_create_nonce('sb_msg_secure') . '"';
                }
                $user_data = get_userdata($get_arr[1]);
                $user_pic = adforest_get_user_dp($get_arr[1]);
                $list .= '<a href="' . esc_url($action) . '"><div class="user-img"> <img src="' . esc_url($user_pic) . '" alt="' . $user_data->display_name . '" width="30" height="50" > </div><div class="mail-contnet"><h5>' . $user_data->display_name . '</h5> <span class="mail-desc">' . get_the_title($ad_id) . '</span></div></a>';
            }
            echo adforest_returnEcho($list);
        }
        die();
    }

}


// Rate User
add_action('wp_ajax_sb_post_user_ratting', 'adforest_post_user_ratting');
add_action('wp_ajax_nopriv_sb_post_user_ratting', 'adforest_post_user_ratting');
if (!function_exists('adforest_post_user_ratting')) {

    function adforest_post_user_ratting() {
        adforest_authenticate_check();
        // Getting values
        $params = array();
        parse_str($_POST['sb_data'], $params);
        check_ajax_referer('sb_user_rating_secure', 'security');
        $ratting = $params['rating'];
        $comments = $params['sb_rate_user_comments'];
        $author = $params['author'];
        $rator = get_current_user_id();

        if ($author == $rator) {
            echo '0|' . __("You can't rate yourself.", 'adforest');
            die();
        }
        if (get_user_meta($author, "_user_" . $rator, true) == "") {
            update_user_meta($author, "_user_" . $rator, $ratting . "_separator_" . $comments . "_separator_" . date('Y-m-d'));

            $ratings = adforest_get_all_ratings($author);
            $all_rattings = 0;
            $got = 0;
            if (count($ratings) > 0) {
                foreach ($ratings as $rating) {
                    $data = explode('_separator_', $rating->meta_value);
                    $got = $got + $data[0];
                    $all_rattings++;
                }
                $avg = $got / $all_rattings;
            } else {
                $avg = $ratting;
            }

            update_user_meta($author, "_adforest_rating_avg", $avg);
            $total = get_user_meta($author, "_adforest_rating_count", true);
            if ($total == "")
                $total = 0;
            $total = $total + 1;
            update_user_meta($author, "_adforest_rating_count", $total);

            // Send email if enabled
            global $adforest_theme;
            if (isset($adforest_theme['email_to_user_on_rating']) && $adforest_theme['email_to_user_on_rating']) {
                adforest_send_email_new_rating($rator, $author, $ratting, $comments);
            }


            echo '1|' . __("You've rated this user.", 'adforest');
        } else {
            echo '0|' . __("You already rated this user.", 'adforest');
        }
        die();
    }

}


// Reply Rator
add_action('wp_ajax_sb_reply_user_rating', 'adforest_reply_rator');
add_action('wp_ajax_nopriv_sb_reply_user_rating', 'adforest_reply_rator');
if (!function_exists('adforest_reply_rator')) {

    function adforest_reply_rator() {
        adforest_authenticate_check();
        check_ajax_referer('sb_user_rate_reply_secure', 'security');
        $params = array();
        parse_str($_POST['sb_data'], $params);
        $comments = $params['sb_rate_user_comments'];
        $rator = $params['rator_reply'];
        $got_ratting = get_current_user_id();

        $ratting = get_user_meta($got_ratting, "_user_" . $rator, true);
        $data_arr = explode('_separator_', $ratting);
        if (count($data_arr) > 3) {
            echo '0|' . __("You already replied to this user.", 'adforest');
        } else {
            $ratting = $ratting . "_separator_" . $comments . "_separator_" . date('Y-m-d');
            update_user_meta($got_ratting, '_user_' . $rator, $ratting);
            echo '1|' . __("Your reply has been posted.", 'adforest');
        }
        die();
    }

}

if (!function_exists('adforest_get_all_ratings')) {

    function adforest_get_all_ratings($user_id) {
        global $wpdb;
        $ratings = $wpdb->get_results("SELECT * FROM $wpdb->usermeta WHERE user_id = '$user_id' AND  meta_key like  '_user_%' ORDER BY umeta_id DESC", OBJECT);
        return $ratings;
    }

}


// Submit bid
add_action('wp_ajax_sb_submit_bid', 'adforest_submit_bid');
add_action('wp_ajax_nopriv_sb_submit_bid', 'adforest_submit_bid');
if (!function_exists('adforest_submit_bid')) {

    function adforest_submit_bid() {
        
        adforest_authenticate_check();

        global $adforest_theme;
        $params = array();
        parse_str($_POST['sb_data'], $params);
        check_ajax_referer('sb_bidding_secure', 'security');
        adforest_set_date_timezone();
        $bid_end_date = get_post_meta($params['ad_id'], '_adforest_ad_bidding_date', true); // '2018-03-16 14:59:00';
        if ($bid_end_date != "" && date('Y-m-d H:i:s') > $bid_end_date && isset($adforest_theme['bidding_timer']) && $adforest_theme['bidding_timer']) {
            echo '0|' . __('Bidding has been closed.', 'adforest');
            die();
        }

        $comments = sanitize_text_field($params['bid_comment']);
        $offer = sanitize_text_field($params['bid_amount']);
        $ad_id = $params['ad_id'];
        $offer_by = get_current_user_id();
        $ad_author = get_post_field('post_author', $ad_id);
        if ($offer_by == $ad_author) {
            //echo '0|' . __( "Ad author can't post bid.", 'adforest' );
            //die();
        }
        $bid = '';

        if ($offer == "") {
            $bid = date('Y-m-d H:i:s') . "_separator_" . $comments . "_separator_" . $offer_by;
        } else {
            $bid = date('Y-m-d H:i:s') . "_separator_" . $comments . "_separator_" . $offer_by . "_separator_" . $offer;
        }

        if (isset($adforest_theme['sb_email_on_new_bid_on']) && $adforest_theme['sb_email_on_new_bid_on']) {
            adforest_send_email_new_bid($offer_by, $ad_author, $offer, $comments, $ad_id);
        }

        $is_exist = get_post_meta($ad_id, "_adforest_bid_" . $offer_by, true);
        if ($is_exist != "") {
            update_post_meta($ad_id, "_adforest_bid_" . $offer_by, $bid);
            echo '1|' . __("Updated successfully.", 'adforest');
        } else {
            update_post_meta($ad_id, "_adforest_bid_" . $offer_by, $bid);
            echo '1|' . __("Posted successfully.", 'adforest');
        }
        die();
    }

}

if (!function_exists('adforest_get_all_biddings')) {

    function adforest_get_all_biddings($ad_id) {
        global $wpdb;
        $biddings = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE post_id = '$ad_id' AND  meta_key like  '_adforest_bid_%' ORDER BY meta_id DESC", OBJECT);
        return $biddings;
    }

}

if (!function_exists('adforest_get_all_biddings_array')) {

    function adforest_get_all_biddings_array($ad_id) {
        global $wpdb;
        $biddings = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = '$ad_id' AND  meta_key like  '_adforest_bid_%' ORDER BY meta_id DESC", OBJECT);
        $bid_array = array();
        if (count($biddings) > 0) {
            foreach ($biddings as $bid) {
                // date - comment - user - offer
                $data_array = explode('_separator_', $bid->meta_value);
                $bid_array[$data_array[2] . '_' . $data_array[0]] = $data_array[3];
            }
        }

        return $bid_array;
    }

}

if (!function_exists('adforest_bidding_html')) {

    function adforest_bidding_html($ad_id, $bidhtml_style = 'style-1') {
        global $adforest_theme;

        $curreny = $adforest_theme['sb_currency'];
        if (get_post_meta($ad_id, '_adforest_ad_currency', true) != "") {
            $curreny = get_post_meta($ad_id, '_adforest_ad_currency', true);
        }

        $biddings = adforest_get_all_biddings($ad_id);
        global $wpdb;
        $html = '';
        if (count($biddings) > 0) {
            foreach ($biddings as $bid) {
                // date - comment - user - offer
                $data_array = explode('_separator_', $bid->meta_value);
                $date = $data_array[0];
                $comments = $data_array[1];
                $user = $data_array[2];
                $offer = '';
                $user_info = get_user_by('ID', $user);
                if ($user_info === false)
                    continue;

                $current_user = get_current_user_id();
                $ad_owner = get_post_field('post_author', $ad_id);
                $cls = '';
                $admin_html = '';
                if ($current_user == $ad_owner && get_post_meta($ad_id, '_adforest_poster_contact', true) != "") {
                    $cls = 'admin';
                    $admin_html = '<div>' . get_user_meta($user_info->ID, '_sb_contact', true) . '</div>';
                }

                $offer = substr($data_array[3], 0, 12);
                $thousands_sep = ",";
                if (isset($adforest_theme['sb_price_separator']) && $adforest_theme['sb_price_separator'] != '') {
                    $thousands_sep = $adforest_theme['sb_price_separator'];
                }
                $decimals = 0;
                if (isset($adforest_theme['sb_price_decimals']) && $adforest_theme['sb_price_decimals'] != '') {
                    $decimals = $adforest_theme['sb_price_decimals'];
                }
                $decimals_separator = ".";
                if (isset($adforest_theme['sb_price_decimals_separator']) && $adforest_theme['sb_price_decimals_separator'] != '') {
                    $decimals_separator = $adforest_theme['sb_price_decimals_separator'];
                }
                // Price format
                $price = number_format($offer, $decimals, $decimals_separator, $thousands_sep);
                $price = ( isset($price) && $price != "") ? $price : 0;

                if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right') {
                    $price = $price . $curreny;
                } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left') {
                    $price = $curreny . $price;
                } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right_with_space') {
                    $price = $price . " " . $curreny;
                } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left_with_space') {
                    $price = $curreny . " " . $price;
                } else {
                    $price = $curreny . $price;
                }

                if ($bidhtml_style == 'style-2') {

                    $html .= ' <div class="ad-bid-meta"><div class="ad-bids-details">
                                <div class="ad-bidn-img">
                                <a href="' . adforest_set_url_param(get_author_posts_url($user_info->ID), 'type', 'ads') . '">'
                            . '     <img src="' . adforest_get_user_dp($user_info->ID, 'adforest-single-small') . '" alt="' . esc_attr__('image', 'adforest') . '" class="img-fluid">
                                </a>
                                </div>
                                <div class="ad-bids-ndetail"> <span>' . date_i18n(get_option('date_format'), strtotime($date)) . '</span>
                                    <a href="' . adforest_set_url_param(get_author_posts_url($user_info->ID), 'type', 'ads') . '"><div class="ad-6-bidder-title">' . $user_info->display_name . '</div></a>
                                </div>
                                <div class="ad-bid-pricetg"> <span>' . $price . '</span> </div>
                            </div>
                            <div class="ad-bids-contnt">
                                <p>' . esc_html($comments) . '</p>
                            </div></div>';
                } else {

                    $col = '8';
                    $html .= '<div class="panel panel-default event" id="sb_bids-' . rand(1234, 99999) . '">
                            <div class="panel-body"><div class="author col-xs-4 col-sm-2">
                            <div class="profile-image"><a href="' . adforest_set_url_param(get_author_posts_url($user_info->ID), 'type', 'ads') . '">
                                    <img src="' . adforest_get_user_dp($user_info->ID) . '" alt="' . esc_attr__('image', 'adforest') . '" /></a></div></div>
                                    <div class="info col-xs-' . esc_attr($col) . ' col-sm-' . esc_attr($col) . '">
                                    <p class="no-margin-8"><strong>' . date_i18n(get_option('date_format'), strtotime($date)) . '</strong></p>
                                      <p>' . esc_html($comments) . ' - <strong><a href="' . adforest_set_url_param(get_author_posts_url($user_info->ID), 'type', 'ads') . '">' . $user_info->display_name . '</a></strong></p>
                                    </div>';
                    $html .= '<div class="rsvp col-xs-12 col-sm-2">
                          <i class="' . esc_attr($cls) . '">' . $price . '</i>
                              ' . $admin_html . '
                        </div>';
                    $html .= '</div></div>';
                }
            }
        }

        return $html;
    }

}

if (!function_exists('adforest_bidding_stats')) {

    function adforest_bidding_stats($ad_id, $style = 'style-1') {
        global $adforest_theme;
        $html = '';
        $bids_res = adforest_get_all_biddings_array($ad_id);

        // echo '<';


        $total_bids = count($bids_res);
        $max = 0;
        $min = 0;
        if ($total_bids > 0) {
            $max = max($bids_res);
            $min = min($bids_res);
        }

        $thousands_sep = ",";
        if (isset($adforest_theme['sb_price_separator']) && $adforest_theme['sb_price_separator'] != '') {
            $thousands_sep = $adforest_theme['sb_price_separator'];
        }
        $decimals = 0;
        if (isset($adforest_theme['sb_price_decimals']) && $adforest_theme['sb_price_decimals'] != '') {
            $decimals = $adforest_theme['sb_price_decimals'];
        }
        $decimals_separator = ".";
        if (isset($adforest_theme['sb_price_decimals_separator']) && $adforest_theme['sb_price_decimals_separator'] != '') {
            $decimals_separator = $adforest_theme['sb_price_decimals_separator'];
        }

        $curreny = $adforest_theme['sb_currency'];
        if (get_post_meta($ad_id, '_adforest_ad_currency', true) != "") {
            $curreny = get_post_meta($ad_id, '_adforest_ad_currency', true);
        }

        // Price format
        $max = number_format((int) $max, $decimals, $decimals_separator, $thousands_sep);
        $min = number_format((int) $min, $decimals, $decimals_separator, $thousands_sep);

        $min = substr($min, 0, 12);
        $max = substr($max, 0, 12);

        if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right') {
            $max = $max . '<small>' . $curreny . '</small>';
            $min = $min . '<small>' . $curreny . '</small>';
        } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left') {
            $max = '<small>' . $curreny . '</small>' . $max;
            $min = '<small>' . $curreny . '</small>' . $min;
        } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right_with_space') {
            $max = $max . ' <small>' . $curreny . '</small>';
            $min = $min . ' <small>' . $curreny . '</small>';
        } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left_with_space') {
            $max = '<small>' . $curreny . '</small> ' . $max;
            $min = '<small>' . $curreny . '</small> ' . $min;
        } else {
            $max = '<small>' . $curreny . '</small>' . $max;
            $min = '<small>' . $curreny . '</small>' . $min;
        }
        if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern') {

            $bid_stat_class = 'card';
            $bid_sidebar = FALSE;
            if ($style == 'style-2') {
                $bid_stat_class = 'card bid-state-2';
                $bid_sidebar = TRUE;
            }
            if ($bid_sidebar) {
                $html .= '<div class="sidebar">';
            }

            $html .= '<div class="' . $bid_stat_class . '">
                    <ul class="nav nav-tabs" role="tablist">
                       <li role="presentation"  class="active" ><a href="#home" aria-controls="home" role="tab" data-toggle="tab">' . __('Bidding Stats', 'adforest') . '</a></li>';
            if (isset($adforest_theme['top_bidder_limit']) && $adforest_theme['top_bidder_limit'] != "" && $adforest_theme['top_bidder_limit'] != 0)
                $html .= '<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">' . __('Top Bidders', 'adforest') . '</a></li>';
            $html .= '</ul>
                    <div class="tab-content bidding-advanced">
                       <div role="tabpanel" class="tab-pane active" id="home">';


            if (get_post_meta($ad_id, '_adforest_ad_bidding_date', true) != "" && isset($adforest_theme['bidding_timer']) && $adforest_theme['bidding_timer']) {
                $bid_end_date = get_post_meta($ad_id, '_adforest_ad_bidding_date', true);
                if ($bid_end_date != "" && date('Y-m-d H:i:s') > $bid_end_date) {
                    $html .= '<div class="text-center bid-close-msg"><a href="javascript:void(0);"><i class="fa fa-lock"></i> ' . __('Bidding has been closed.', 'adforest') . '</a></div>';
                    do_action('adforest_send_email_bid_winner', $ad_id);
                }
                if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                    $html .= '<p class="text-center bid_close no-display"><i class="fa fa-lock"></i> ' . __('Bidding has been closed.', 'adforest') . '</p>';
                    $html .= adforest_timer_html($bid_end_date);
                }
            }
            $html .= '<div class="panel status panel-info">
				<div class="panel-heading">
					<p class="panel-title fancy ">' . __('Total Bids', 'adforest') . ':<strong><a href="#tab2default">' . esc_html($total_bids) . '</a></strong></p>
				</div>
			</div>
			<div class="panel status panel-success">
				<div class="panel-heading">
					<p class="panel-title fancy">' . __('Highest Bid', 'adforest') . ':<strong> <a href="#tab2default">' . $max . '</a></strong></p>
				</div>
			</div>
			<div class="panel status panel-warning">
				<div class="panel-heading">
					<p class="panel-title fancy">' . __('Lowest Bid', 'adforest') . ': <strong><a href="#tab2default">' . $min . '</a></strong></p>
				</div>
			</div>

			</div>
			<div role="tabpanel" class="tab-pane " id="profile">
         <div class="sidebar-activity">
            <div class="adforest-top-bidders">';

            arsort($bids_res);
            $count = 1;
            if ($total_bids > 0) {
                foreach ($bids_res as $key => $val) {
                    $data = explode('_', $key);
                    $bidder_id = $data[0];
                    $bid_date = $data[1];

                    $user_info = get_userdata($bidder_id);
                    $bidder_name = 'demo';
                    $user_profile = 'javascript:void(0);';
                    if (isset($user_info->display_name) && $user_info->display_name != "") {
                        $bidder_name = $user_info->display_name;
                        $user_profile = adforest_set_url_param(get_author_posts_url($bidder_id), 'type', 'ads');
                    } else {
                        continue;
                        //$bidder_name = $user_info->display_name;
                        //$user_profile	= get_author_posts_url(1 );
                    }

                    $current_user = get_current_user_id();
                    $ad_owner = get_post_field('post_author', $ad_id);
                    $cls = '';
                    $admin_html = '';
                    if ($current_user == $ad_owner && get_post_meta($ad_id, '_adforest_poster_contact', true) != "") {
                        $admin_html = '<time class="date">' . get_user_meta($bidder_id, '_sb_contact', true) . '</time>';
                    }

                    $val = substr($val, 0, 12);

                    $user_pic = adforest_get_user_dp($bidder_id, 'adforest-user-profile');

                    if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right') {
                        $offer = $val . '<small>' . $curreny . '</small>';
                    } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left') {
                        $offer = '<small>' . $curreny . '</small>' . $val;
                    } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right_with_space') {
                        $offer = $val . ' <small>' . $curreny . '</small>';
                    } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left_with_space') {
                        $offer = '<small>' . $curreny . '</small> ' . $val;
                    } else {
                        $offer = '<small>' . $curreny . '</small>' . $val;
                    }


                    $html .= '<div class="top-bidder-grids">
                  <div class="media">
                     <div class="media-left">
                        <div class="avatar">
						<a class="text-black" href="' . $user_profile . '">
                           <img src="' . esc_url($user_pic) . '" alt="' . esc_attr($bidder_name) . '"  alt="' . esc_attr__('image', 'adforest') . '" >
                           <span class="bidding-notification bg-danger">' . $count . '</span>
					   </a>
                        </div>
                     </div>
                     <div class="media-body">
                        ' . $admin_html . '
                        <div><a class="text-black" href="' . $user_profile . '">' . $bidder_name . '</a> ' . __('posted an offer', 'adforest') . ' </div>
                        <div class="bid-offer"><a href="javascript:void(0);">' . $offer . '</a></div>
                        <div class="time-ago">' . adforest_timeago($bid_date) . '</div>
                     </div>
                  </div>
               </div>';



                    $max_bidder = 5;
                    if (isset($adforest_theme['top_bidder_limit']) && $adforest_theme['top_bidder_limit'] != "")
                        $max_bidder = $adforest_theme['top_bidder_limit'];

                    if ($count == $max_bidder)
                        break;
                    $count++;
                }
            }
            else {
                $html .= '<p class="text-center"><em>' . __('There is no bid yet.', 'adforest') . '</em></p>';
            }

            if ($bid_sidebar) {
                $html .= '</div>';
            }

            $html .= '</div>
         </div>
      </div>
   </div>
</div>
';
        } else {
            $html = '<div class="bid-info">
                               <div class="descs-box  col-md-4 col-sm-4 col-xs-12">
                                <h4>' . __('Total Bids', 'adforest') . '</h4>
                                <a href="#tab2default">' . esc_html($total_bids) . '</a>
                               </div>
                               <div class="descs-box  col-md-4 col-sm-4 col-xs-12">
                                <h4>' . __('Highest', 'adforest') . '</h4>
                                <a href="#tab2default">' . $max . '</a></div>
                               <div class="descs-box  col-md-4 col-sm-4 col-xs-12">
                                <h4>' . __('Lowest', 'adforest') . '</h4>
                                <a href="#tab2default">' . $min . '</a>
                               </div>
                         </div>';
        }


        return $html;
    }

}

// phone verification
add_action('wp_ajax_sb_verification_system', 'adforest_verification_system');
if (!function_exists('adforest_verification_system')) {

    function adforest_verification_system() {
        global $adforest_theme;
        $ph = sanitize_text_field($_POST['sb_phone_numer']);
        if (!preg_match("/\+[0-9]+$/", $ph)) {
            echo '0|' . __('Please update valid phone number +CountrycodePhonenumber in profile.', 'adforest');
            die();
        }

        $user_id = get_current_user_id();

        if (isset($adforest_theme['sb_resend_code']) && $adforest_theme['sb_resend_code'] != "" && get_user_meta($user_id, '_ph_code_', true) != "") {
            $timeFirst = strtotime(get_user_meta($user_id, '_ph_code_date_', true));
            $timeSecond = strtotime(date('Y-m-d H:i:s'));
            $differenceInSeconds = $timeSecond - $timeFirst;
            $adforest_theme['sb_resend_code'] . "<" . $differenceInSeconds;
            if ($adforest_theme['sb_resend_code'] > $differenceInSeconds) {
                $after_seconds = $adforest_theme['sb_resend_code'] - $differenceInSeconds;
                echo '0|' . __("You can't resend the verification code before", 'adforest') . " " . $after_seconds . '-' . __("seconds.", 'adforest');
                die();
            }
        }

        $code = mt_rand(100000, 500000);
        $res = adforest_send_sms($ph, $code);

        $gateway = adforest_verify_sms_gateway();
        $sms_sent = false;
        if ($gateway == "iletimerkezi-sms" && $res == true) {
            $sms_sent = true;
        }
        if ($gateway == "twilio" && $res->sid) {
            $sms_sent = true;
        }

        if ($sms_sent) {
            //if( true )
            update_user_meta($user_id, '_ph_code_', $code);
            update_user_meta($user_id, '_sb_is_ph_verified', '0');
            update_user_meta($user_id, '_ph_code_date_', date('Y-m-d H:i:s'));
            echo '1|' . __("Verification code has been sent.", 'adforest');
        } else {
            echo '0|' . __("Server not responding.", 'adforest');
            update_user_meta($user_id, '_sb_is_ph_verified', '0');
        }
        die();
    }

}

if (!function_exists('adforest_send_sms')) {

    function adforest_send_sms($receiver_ph, $code) {
        global $adforest_theme;
        $message = __('Your verification code is', 'adforest') . " " . $code;
        $gateway = adforest_verify_sms_gateway();

        if ($gateway == "iletimerkezi-sms") {
            $ilt_data = get_option('ilt_option');

            $options = ilt_get_options();
            $options['number_to'] = $receiver_ph;
            $options['message'] = $message;
            $args = wp_parse_args($args, $options);
            $is_args_valid = ilt_validate_sms_args($args);

            if (!$is_args_valid) {
                extract($args);
                $message = apply_filters('ilt_sms_message', $message, $args);
                try {
                    $client = Emarka\Sms\Client::createClient(['api_key' => $args['public_key'], 'secret' => $args['private_key'], 'sender' => $args['sender'],]);
                    $response = $client->send($receiver_ph, $message);
                    if (!$response) {
                        $is_args_valid = ilt_log_entry_format(__('[Api Error] Connection error', 'adforest'), $args);
                        $return = false;
                    } else {
                        $is_args_valid = ilt_log_entry_format(sprintf(__('Success! Message ID: %s', 'adforest'), $response), $args);
                        $return = true;
                    }
                } catch (\Exception $e) {
                    $is_args_valid = ilt_log_entry_format(sprintf(__('[Api Error] %s ', 'adforest'), $e->getMessage()), $args);
                    $return = false;
                }
            } else {
                $return = false;
            }

            ilt_update_logs($is_args_valid, $args['logging']);
            return $return;
        }

        if ($gateway == "twilio") {
            $twl_data = get_option('twl_option');

            $account_sid = $twl_data['account_sid'];
            $auth_token = $twl_data['auth_token'];
            $twilio_phone_number = $twl_data['number_from'];

            $client = new Twilio\Rest\Client($account_sid, $auth_token);
            try {
                $response = $client->messages->create($receiver_ph, array("from" => $twilio_phone_number, "body" => $message));
                return $response;
            } catch (\Exception $e) {
                echo '0|' . __($e->getMessage(), 'adforest');
                die();
            }
        }
    }

}
add_action('wp_ajax_sb_verification_code', 'adforest_verification_code');
if (!function_exists('adforest_verification_code')) {

    function adforest_verification_code() {
        $code = $_POST['sb_code'];
        $user_id = get_current_user_id();
        $saved = get_user_meta($user_id, '_ph_code_', true);
        if ($saved == "") {
            echo '0|' . __("Code not found in DB", 'adforest');
        }

        if ($code == $saved) {
            update_user_meta($user_id, '_ph_code_', '');
            update_user_meta($user_id, '_sb_is_ph_verified', '1');
            update_user_meta($user_id, '_ph_code_date_', '');
            echo '1|' . __("Phone number has been verified", 'adforest');
        } else {
            echo '0|' . __("Invalid code that you entered", 'adforest');
        }

        die();
    }

}
