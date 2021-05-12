<?php

if (!class_exists('authentication')) {

    class authentication {

        function adforest_sign_up_form($string, $terms, $key = '', $is_captcha = '', $key_code = '') {
            global $adforest_theme;

            $captcha_type = isset($adforest_theme['google-recaptcha-type']) && !empty($adforest_theme['google-recaptcha-type']) ? $adforest_theme['google-recaptcha-type'] : 'v2';


            // Check phone is required or not
            $phone_html = '<input class="form-control" id="adforest_contact_number" name="sb_reg_contact" data-parsley-type="integer" data-parsley-required="true" data-parsley-error-message="' . __('This field is required.Should be a valid integr value', 'adforest') . '" placeholder="' . __('Your Contact Number', 'adforest') . '" type="text">';
            if (isset($adforest_theme['sb_user_phone_required']) && !$adforest_theme['sb_user_phone_required']) {
                $phone_html = '<input id="adforest_contact_number" placeholder="' . __('Your Contact Number', 'adforest') . '" class="form-control" type="text" name="sb_reg_contact">';
            }


            $sms_gateway = adforest_verify_sms_gateway();
            if ($sms_gateway != "") {
                $phone_html = '<input placeholder="' . __('+CountrycodePhonenumber', 'adforest') . '" class="form-control" type="text" name="sb_reg_contact" data-parsley-required="true" data-parsley-pattern="/\+[0-9]+$/" data-parsley-error-message="' . __('Format should be +CountrycodePhonenumber', 'adforest') . '">';
            }

            /* if (isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification'] && in_array('wp-twilio-core/core.php', apply_filters('active_plugins', get_option('active_plugins')))) {
              $phone_html = '<input id="adforest_contact_number" placeholder="' . __('+CountrycodePhonenumber', 'adforest') . '" class="form-control" type="text" name="sb_reg_contact" data-parsley-required="true" data-parsley-pattern="/\+[0-9]+$/" data-parsley-error-message="' . __('Format should be +CountrycodePhonenumber', 'adforest') . '">';
              } */


            $res = adforest_extarct_link($string);
            $captcha = '<input type="hidden" value="no" name="is_captcha" />';
            if ($captcha_type == 'v2') {

                if ($is_captcha == 'with' && $key != "") {
                    $captcha = '<div class="form-group">
			  <div class="g-recaptcha" data-sitekey="' . $key . '"></div>
		   </div><input type="hidden" value="yes" name="is_captcha" />
		';
                }
            } else {
                $captcha = '<input type="hidden" value="yes" name="is_captcha" />';
            }

            $sb_sign_in_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_in_page']);
            return '<form id="sb-sign-form" >
		   <div class="form-group">
			  <label>' . __('Name', 'adforest') . '</label>
			  <input placeholder="' . __('Your Name', 'adforest') . '" class="form-control" type="text" data-parsley-required="true" data-parsley-error-message="' . __('Please enter your name.', 'adforest') . '" name="sb_reg_name" id="sb_reg_name">
		   </div>
		   <div class="form-group">
			  <label>' . __('Contact Number', 'adforest') . '</label>
			  ' . $phone_html . '
		   </div>
		   <div class="form-group">
			  <label>' . __('Email', 'adforest') . '</label>
			  <input placeholder="' . __('Your Email', 'adforest') . '" class="form-control" type="email" data-parsley-type="email" data-parsley-required="true" data-parsley-error-message="' . __('Please enter your valid email.', 'adforest') . '" data-parsley-trigger="change" name="sb_reg_email" id="sb_reg_email">
		   </div>
		   <div class="form-group">
			  <label>' . __('Password', 'adforest') . '</label>
			  <input placeholder="' . __('Your Password', 'adforest') . '" class="form-control" type="password" data-parsley-required="true" data-parsley-error-message="' . __('Please enter your password.', 'adforest') . '" name="sb_reg_password">
		   </div>
		   <div class="form-group">
			  <div class="row">
				 <div class="col-xs-12 col-md-12 col-sm-12">
					<div class="skin-minimal">
					   <ul class="list">
						  <li>
							 <input  type="checkbox" id="minimal-checkbox-1" name="minimal-checkbox-1" data-parsley-required="true" data-parsley-error-message="' . __('Please accept terms and conditions.', 'adforest') . '">
							 <label for="minimal-checkbox-1">' . __('I agree to', 'adforest') . ' <a href="' . $res['url'] . '" title="' . $res['title'] . '" target="' . $res['target'] . '">' . $terms . '</a></label>
						  </li>
					   </ul>
					</div>
				 </div>
			  </div>
		   </div>
		' . $captcha . '
                    <input type="hidden" id="sb-register-token" value="' . wp_create_nonce('sb_register_secure') . '" />
		   <button class="btn btn-theme btn-lg btn-block" type="submit" id="sb_register_submit">' . __('Register', 'adforest') . '</button>
		   <button class="btn btn-theme btn-lg btn-block no-display" type="button" id="sb_register_msg">' . __('Processing...', 'adforest') . '</button>
		   <button class="btn btn-theme btn-lg btn-block no-display" type="button" id="sb_register_redirect">' . __('Redirecting...', 'adforest') . '</button>
		   <br />
		   <p class="text-center"><a href="' . get_the_permalink($sb_sign_in_page) . '">' . __('Already registered, login here.', 'adforest') . '</a>
					</p>
		   <input type="hidden" id="get_action" value="register" />
		   <input type="hidden" id="nonce_register" value="' . $key_code . '" />
		   <input type="hidden" id="verify_account_msg" value="' . __('Verificaton email has been sent to your email.', 'adforest') . '" />
		</form>';
        }

        // sign In form
        function adforest_sign_in_form($key_code = '') {
            global $adforest_theme;
            $sb_sign_up_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_up_page']);
            return '<form id="sb-login-form" >
		   <div class="form-group">
			  <label>' . __('Email', 'adforest') . '</label>
			  <input placeholder="' . __('Your Email', 'adforest') . '" class="form-control" type="email" data-parsley-type="email" data-parsley-required="true" data-parsley-error-message="' . __('Please enter your valid email.', 'adforest') . '" data-parsley-trigger="change" name="sb_reg_email" id="sb_reg_email">
		   </div>
		   <div class="form-group">
			  <label>' . __('Password', 'adforest') . '</label>
			  <input placeholder="' . __('Your Password', 'adforest') . '" class="form-control" type="password" data-parsley-required="true" data-parsley-error-message="' . __('Please enter your password.', 'adforest') . '" name="sb_reg_password">
		   </div>
		   <div class="form-group">
			  <div class="row">
				 <div class="col-xs-12 col-sm-7">
					<div class="skin-minimal">
					   <ul class="list">
						  <li>
							 <input  type="checkbox" name="is_remember" id="is_remember">
							 <label for="is_remember">' . __('Remember Me', 'adforest') . '</label>
						  </li>
					   </ul>
					</div>
				 </div>
				 <div class="col-xs-12 col-sm-5 text-right">
					<p class="help-block"><a data-target="#myModal" data-toggle="modal">' . __('Forgot password?', 'adforest') . '</a>
					</p>
				 </div>
			  </div>
		   </div>
		   <input type="hidden" id="sb-login-token" value="' . wp_create_nonce('sb_login_secure') . '" />
		   <button class="btn btn-theme btn-lg btn-block" type="submit" id="sb_login_submit">' . __('Login', 'adforest') . '</button>
		   <button class="btn btn-theme btn-lg btn-block no-display" type="button" id="sb_login_msg">' . __('Processing...', 'adforest') . '</button>
		   <button class="btn btn-theme btn-lg btn-block no-display" type="button" id="sb_login_redirect">' . __('Redirecting...', 'adforest') . '</button>
		   <br />
		   <p class="text-center"><a href="' . get_the_permalink($sb_sign_up_page) . '">' . __('Sign up for an account.', 'adforest') . '</a></p>
		   <input type="hidden" id="nonce" value="' . $key_code . '" />
		   <input type="hidden" id="get_action" value="login" />
		</form>';
        }

        // Forgot Password Form
        function adforest_forgot_password_form() {
            return '<form id="sb-forgot-form">
                             <div class="modal-body">
                                    <div class="form-group">
                                      <label>' . __('Email', 'adforest') . '</label>
                                      <input placeholder="' . __('Your Email', 'adforest') . '" class="form-control" type="email" data-parsley-type="email" data-parsley-required="true" data-parsley-error-message="' . __('Please enter valid email.', 'adforest') . '" data-parsley-trigger="change" name="sb_forgot_email" id="sb_forgot_email">
                                    </div>
                             </div>
                             <div class="modal-footer">
                                       <input type="hidden" id="sb-forgot-pass-token" value="' . wp_create_nonce('sb_forgot_pass_secure') . '" />
                                       <button class="btn btn-dark" type="submit" id="sb_forgot_submit">' . __('Reset My Account', 'adforest') . '</button>
                                       <button class="btn btn-dark" type="button" id="sb_forgot_msg">' . __('Processing...', 'adforest') . '</button>
                            </div>
		  </form>';
        }

    }

}

add_action('wp_ajax_sb_goggle_captcha3_verification', 'sb_goggle_captcha3_verification_callback');
add_action('wp_ajax_nopriv_sb_goggle_captcha3_verification', 'sb_goggle_captcha3_verification_callback');

if (!function_exists('sb_goggle_captcha3_verification_callback')) {

    function sb_goggle_captcha3_verification_callback() {
        global $adforest_theme;
        $google_api_secret = isset($adforest_theme['google_api_secret']) && !empty($adforest_theme['google_api_secret']) ? $adforest_theme['google_api_secret'] : '';
        $captcha;
        if (isset($_POST['token'])) {
            $captcha = $_POST['token'];
        }
        $secretKey = $google_api_secret;
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($captcha);
        $responseData = wp_remote_get($url);
        $data_resp = array();
        if (is_wp_error($responseData)) {
            $error_message = $responseData->get_error_message();
            $data_resp['success'] = false;
            $data_resp['msg'] = $error_message;
            echo json_encode($data_resp);
            wp_die();
        } else {
            $res = json_decode($responseData['body'], true);
            if ($res["success"]) {
                $data_resp['success'] = true;
            } else {
                $data_resp['success'] = false;
                $data_resp['msg'] = __('You are spammer ! Get out here.', 'adforest');
            }
            echo json_encode($data_resp);
            wp_die();
        }
    }

}

// Goog re-capthca verification
if (!function_exists('adforest_recaptcha_verify')) {

    function adforest_recaptcha_verify($api_secret, $code, $ip, $is_captcha) {

        global $adforest_theme;
        $captcha_status = false;
        $captcha_type = isset($adforest_theme['google-recaptcha-type']) && !empty($adforest_theme['google-recaptcha-type']) ? $adforest_theme['google-recaptcha-type'] : 'v2';
        if ($is_captcha == 'no') {
            return true;
        }
        if ($captcha_type == 'v3') {
            return true;
        } else {
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $api_secret . '&response=' . $code . '&remoteip=' . $ip;
            $responseData = wp_remote_get($url);
            $res = json_decode($responseData['body'], true);
            if ($res["success"] === true) {
                $captcha_status = true;
            } else {
                $captcha_status = false;
            }
        }
        return $captcha_status;
    }

}



// Ajax handler for Login User
add_action('wp_ajax_sb_login_user', 'adforest_login_user');
add_action('wp_ajax_nopriv_sb_login_user', 'adforest_login_user');
// Login User
if (!function_exists('adforest_login_user')) {

    function adforest_login_user() {
        global $adforest_theme;
        // Getting values
        $params = array();
        parse_str($_POST['sb_data'], $params);
        check_ajax_referer('sb_login_secure', 'security');
        $remember = false;
        if ($params['is_remember']) {
            $remember = true;
        }
        $user = wp_authenticate($params['sb_reg_email'], $params['sb_reg_password']);
        if (!is_wp_error($user)) {
            if (count($user->roles) == 0) {
                echo __('Your account is not verified yet.', 'adforest');
                die();
            } else {
                $res = adforest_auto_login($params['sb_reg_email'], $params['sb_reg_password'], $remember);
                if ($res == 1) {
                    echo "1";
                }
            }
        } else {
            echo __('Invalid email or password.', 'adforest');
        }
        die();
    }

}

function adforest_admin_user_identification($user, $password) {

    if (count($user->roles) == 0) {
        $not_verified = new WP_Error('not_verified_user', __('<strong>ERROR</strong>: Your account is not verified yet.', 'adforest'));
        return $not_verified;
    }
    return $user;
}

add_filter('wp_authenticate_user', 'adforest_admin_user_identification', 10, 2);


// Ajax handler for Register User
add_action('wp_ajax_sb_register_user', 'adforest_register_user');
add_action('wp_ajax_nopriv_sb_register_user', 'adforest_register_user');
// Register User
if (!function_exists('adforest_register_user')) {

    function adforest_register_user() {
        global $adforest_theme;
        // Getting values
        $params = array();
        parse_str($_POST['sb_data'], $params);
        check_ajax_referer('sb_register_secure', 'security');
        if (email_exists($params['sb_reg_email']) == false) {

            $google_captcha_auth = false;

            $google_captcha_auth = adforest_recaptcha_verify($adforest_theme['google_api_secret'], $params['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'], $params['is_captcha']);
            $captcha_type = isset($adforest_theme['google-recaptcha-type']) && !empty($adforest_theme['google-recaptcha-type']) ? $adforest_theme['google-recaptcha-type'] : 'v2';


            if ($google_captcha_auth) {

                $user_name = explode('@', $params['sb_reg_email']);
                $u_name = adforest_check_user_name($user_name[0]);
                $uid = wp_create_user($u_name, $params['sb_reg_password'], sanitize_email($params['sb_reg_email']));
                wp_update_user(array('ID' => $uid, 'display_name' => sanitize_text_field($params['sb_reg_name'])));
                update_user_meta($uid, '_sb_contact', sanitize_text_field($params['sb_reg_contact']));

                if ($adforest_theme['sb_allow_ads']) {
                    update_user_meta($uid, '_sb_simple_ads', $adforest_theme['sb_free_ads_limit']);
                    if ($adforest_theme['sb_allow_featured_ads']) {
                        update_user_meta($uid, '_sb_featured_ads', $adforest_theme['sb_featured_ads_limit']);
                    }
                    if ($adforest_theme['sb_allow_bump_ads']) {
                        update_user_meta($uid, '_sb_bump_ads', $adforest_theme['sb_bump_ads_limit']);
                    }
                    if ($adforest_theme['sb_package_validity'] == '-1') {
                        update_user_meta($uid, '_sb_expire_ads', $adforest_theme['sb_package_validity']);
                    } else {
                        $days = $adforest_theme['sb_package_validity'];
                        $expiry_date = date('Y-m-d', strtotime("+$days days"));
                        update_user_meta($uid, '_sb_expire_ads', $expiry_date);
                    }
                } else {
                    update_user_meta($uid, '_sb_simple_ads', 0);
                    update_user_meta($uid, '_sb_featured_ads', 0);
                    update_user_meta($uid, '_sb_bump_ads', 0);
                    update_user_meta($uid, '_sb_expire_ads', date('Y-m-d'));
                }

                update_user_meta($uid, '_sb_pkg_type', 'free');
                // Email for new user
                if (function_exists('adforest_email_on_new_user')) {
                    adforest_email_on_new_user($uid, '');
                }

                // check phone verification is on or not
                // check phone verification is on or not
                $sms_gateway = adforest_verify_sms_gateway();
                if ($sms_gateway != "") {
                    update_user_meta($uid, '_sb_is_ph_verified', '0');
                }

                /* if (isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification'] && in_array('wp-twilio-core/core.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                  update_user_meta($uid, '_sb_is_ph_verified', '0');
                  } */

                if (isset($adforest_theme['sb_new_user_email_verification']) && $adforest_theme['sb_new_user_email_verification']) {
                    $user = new WP_User($uid);
                    // Remove all user roles after registration
                    foreach ($user->roles as $role) {
                        $user->remove_role($role);
                    }
                    echo 2;
                    die();
                } else {
                    adforest_auto_login($params['sb_reg_email'], $params['sb_reg_password'], true);
                    echo 1;
                    die();
                }
            } else {

                if ($captcha_type == 'v3') {
                    echo __('You are spammer ! Get out.', 'adforest');
                } else {
                    echo __('please verify captcha code', 'adforest');
                }
                die();
            }
        } else {
            echo __('Email already exist, please try other one.', 'adforest');
            die();
        }


        die();
    }

}


if (!function_exists('adforest_auto_login')) {

    function adforest_auto_login($username, $password, $remember) {
        $creds = array();
        $creds['user_login'] = $username;
        $creds['user_password'] = $password;
        $creds['remember'] = $remember;

        $user = wp_signon($creds, false);
        if (is_wp_error($user)) {
            return false;
        } else {
            //global $adforest_theme;
            //if( isset( $adforest_theme['sb_new_user_email_verification'] ) && $adforest_theme['sb_new_user_email_verification'] )
            //{
            if (count($user->roles) > 0) {
                return true;
            } else {
                return 2;
            }
            //}
        }
    }

}

//associating a function to login hook
add_action('wp_login', 'adforest_set_last_login', 10, 2);

//function for setting the last login
if (!function_exists('adforest_set_last_login')) {

    function adforest_set_last_login($login, $user) {
        //$user = get_userdatabylogin($login);
        $cur_user = get_user_by('login', $login);

        //add or update the last login value for logged in user
        update_user_meta($cur_user->ID, '_sb_last_login', time());
    }

}

// Last login time
if (!function_exists('adforest_get_last_login')) {

    function adforest_get_last_login($uid) {
        $from = get_user_meta($uid, '_sb_last_login', true);
        if ($from == "") {
            update_user_meta($uid, '_sb_last_login', time());
            $from = get_user_meta($uid, '_sb_last_login', true);
        }
        return adforest_human_time_diff($from, time());
    }

}

// Ajax handler for Social login
add_action('wp_ajax_sb_social_login', 'adforest_check_social_user');
add_action('wp_ajax_nopriv_sb_social_login', 'adforest_check_social_user');
if (!function_exists('adforest_check_social_user')) {

    function adforest_check_social_user() {
        if (true) {
            $user_name = $_POST['email'];


            unset($_SESSION['sb_nonce']);
            $_SESSION['sb_nonce'] = time();


            if ($user_name == "") {
                echo '1|' . $_SESSION['sb_nonce'] . '|0|' . __("We are unable to get your email.", 'adforest');
                die();
            }



            if (email_exists($user_name) == true) {
                $user = get_user_by('email', $user_name);
                $user_id = $user->ID;
                if ($user) {
                    wp_set_current_user($user_id, $user->user_login);
                    wp_set_auth_cookie($user_id);
                    //do_action( 'wp_login', $user->user_login );
                    echo '1|' . $_SESSION['sb_nonce'] . '|1|' . __("You're logged in successfully.", 'adforest');
                }
            } else {
                // Here we need to register user.
                $password = mt_rand(1000, 10000);
                $uid = adforest_do_register($user_name, $password);
                global $adforest;
                if (function_exists('adforest_email_on_new_social_user')) {
                    adforest_email_on_new_social_user($uid, $password);
                }
                echo '1|' . $_SESSION['sb_nonce'] . '|1|' . __("You're registered and logged in successfully.", 'adforest');
            }
        } else {
            echo '0|error|Invalid request|Diret Access not allowed';
        }
        die();
    }

}

if (!function_exists('adforest_do_register')) {

    function adforest_do_register($email = '', $password = '') {
        global $adforest_theme;
        $user_name = explode('@', $email);
        $u_name = adforest_check_user_name($user_name[0]);
        $uid = wp_create_user($u_name, $password, $email);
        wp_update_user(array('ID' => $uid, 'display_name' => $u_name));
        adforest_auto_login($email, $password, true);

        if ($adforest_theme['sb_allow_ads']) {

            update_user_meta($uid, '_sb_simple_ads', $adforest_theme['sb_free_ads_limit']);
            if ($adforest_theme['sb_allow_featured_ads']) {
                update_user_meta($uid, '_sb_featured_ads', $adforest_theme['sb_featured_ads_limit']);
            }
            if ($adforest_theme['sb_allow_bump_ads']) {
                update_user_meta($uid, '_sb_bump_ads', $adforest_theme['sb_bump_ads_limit']);
            }
            if ($adforest_theme['sb_package_validity'] == '-1') {
                update_user_meta($uid, '_sb_expire_ads', $adforest_theme['sb_package_validity']);
            } else {
                $days = $adforest_theme['sb_package_validity'];
                $expiry_date = date('Y-m-d', strtotime("+$days days"));
                update_user_meta($uid, '_sb_expire_ads', $expiry_date);
            }
        } else {
            update_user_meta($uid, '_sb_simple_ads', 0);
            update_user_meta($uid, '_sb_featured_ads', 0);
            update_user_meta($uid, '_sb_bump_ads', 0);
            update_user_meta($uid, '_sb_expire_ads', date('Y-m-d'));
        }
        update_user_meta($uid, '_sb_pkg_type', 'free');
        return $uid;
    }

}
if (!function_exists('adforest_user_not_logged_in')) {

    function adforest_user_not_logged_in() {
        global $adforest_theme;
        if (get_current_user_id() == "") {
            $redirect_url = adforest_login_with_redirect_url_param(adforest_get_current_url());
            echo adforest_redirect($redirect_url);
            exit;
        }
    }

}


if (!function_exists('adforest_user_logged_in')) {

    function adforest_user_logged_in() {
        if (get_current_user_id() != "") {
            echo adforest_redirect(home_url('/'));
            exit;
        }
    }

}

if (!function_exists('adforest_check_user_name')) {

    function adforest_check_user_name($username = '') {
        if (username_exists($username)) {
            $random = mt_rand();
            $username = $username . '-' . $random;
            adforest_check_user_name($username);
        }
        return $username;
    }

}

add_action('wp_ajax_sb_reset_password', 'adforest_reset_password');
add_action('wp_ajax_nopriv_sb_reset_password', 'adforest_reset_password');
// Reset Password
if (!function_exists('adforest_reset_password')) {

    function adforest_reset_password() {
        global $adforest_theme;
        // Getting values
        $params = array();
        parse_str($_POST['sb_data'], $params);

        check_ajax_referer('sb_reset_pass_secure', 'security');
        $token = $params['token'];
        $token_arr = explode('-sb-uid-', $token);
        $key = $token_arr[0];
        $uid = $token_arr[1];
        $token_db = get_user_meta($uid, 'sb_password_forget_token', true);
        if ($token_db != $key) {
            echo '0|' . __("Invalid security token.", 'adforest');
        } else {
            $new_password = $params['sb_new_password'];
            wp_set_password($new_password, $uid);
            update_user_meta($uid, 'sb_password_forget_token', '');
            echo '1|' . __("Password Changed successfully.", 'adforest');
        }
        die();
    }

}