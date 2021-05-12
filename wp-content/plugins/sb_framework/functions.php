<?php

function adforest_add_code($id, $func) {
    add_shortcode($id, $func);
}

function adforest_decode($html) {
    return base64_decode($html);
}

// Ajax handler for add to cart
add_action('wp_ajax_sb_mailchimp_subcribe', 'adforest_mailchimp_subcribe');
add_action('wp_ajax_nopriv_sb_mailchimp_subcribe', 'adforest_mailchimp_subcribe');

// Addind Subcriber into Mailchimp
function adforest_mailchimp_subcribe() {
    global $adforest_theme;

    //$apiKey = '97da4834058c44cd770dbbdbab0c5730-us14';
    // $listid = '9b80a80904';
    $sb_action = $_POST['sb_action'];

    $apiKey = $adforest_theme['mailchimp_api_key'];

    if ($sb_action == 'coming_soon')
        $listid = $adforest_theme['mailchimp_notify_list_id'];
    if ($sb_action == 'footer_action')
        $listid = $adforest_theme['mailchimp_footer_list_id'];

    if ($apiKey == "" || $listid == "") {
        echo 0;
        die();
    }
    // Getting value from form
    $email = $_POST['sb_email'];
    $fname = '';
    $lname = '';

    // MailChimp API URL
    $memberID = md5(strtolower($email));
    $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
    $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listid . '/members/' . $memberID;

    // member information
    $json = json_encode(array(
        'email_address' => $email,
        'status' => 'subscribed',
        'merge_fields' => array(
            'FNAME' => $fname,
            'LNAME' => $lname
        )
    ));

    // send a HTTP POST request with curl
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    // store the status message based on response code

    $mcdata = json_decode($result);
    if (!empty($mcdata->error)) {
        echo 0;
    } else {
        echo 1;
    }
    die();
}

// Report Ad
add_action('wp_ajax_sb_report_ad', 'adforest_sb_report_ad');
add_action('wp_ajax_nopriv_sb_report_ad', 'adforest_sb_report_ad');

function adforest_sb_report_ad() {
    adforest_authenticate_check();

    global $adforest_theme;
    $ad_id = $_POST['ad_id'];
    $option = $_POST['option'];
    $comments = sanitize_text_field($_POST['comments']);
    if (get_post_meta($ad_id, '_sb_user_id_' . get_current_user_id(), true) == get_current_user_id()) {
        echo '0|' . __("You have reported already.", 'redux-framework');
    } else {
        update_post_meta($ad_id, '_sb_user_id_' . get_current_user_id(), get_current_user_id());
        update_post_meta($ad_id, '_sb_report_option_' . get_current_user_id(), $option);
        update_post_meta($ad_id, '_sb_report_comments_' . get_current_user_id(), $comments);

        $count = get_post_meta($ad_id, '_sb_count_report', true);
        $count = $count + 1;
        update_post_meta($ad_id, '_sb_count_report', $count);
        if ($count >= $adforest_theme['report_limit']) {
            if ($adforest_theme['report_action'] == '1') {
                $my_post = array(
                    'ID' => $ad_id,
                    'post_status' => 'pending',
                );
                wp_update_post($my_post);
            } else {
                // Sending email
                $to = $adforest_theme['report_email'];
                $subject = __('Ad Reported', 'redux-framework');
                $body = '<html><body><p>' . __('Users reported this ad, please check it. ', 'redux-framework') . '<a href="' . get_the_permalink($ad_id) . '">' . get_the_title($ad_id) . '</a></p></body></html>';

                $from = get_bloginfo('name');
                if (isset($adforest_theme['sb_report_ad_from']) && $adforest_theme['sb_report_ad_from'] != "") {
                    $from = $adforest_theme['sb_report_ad_from'];
                }
                $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                if (isset($adforest_theme['sb_report_ad_message']) && $adforest_theme['sb_report_ad_message'] != "") {


                    $subject_keywords = array('%site_name%', '%ad_title%');
                    $subject_replaces = array(get_bloginfo('name'), get_the_title($ad_id));

                    $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_report_ad_subject']);

                    $author_id = get_post_field('post_author', $ad_id);
                    $user_info = get_userdata($author_id);

                    $msg_keywords = array('%site_name%', '%ad_title%', '%ad_link%', '%ad_owner%');
                    $msg_replaces = array(get_bloginfo('name'), get_the_title($ad_id), get_the_permalink($ad_id), $user_info->display_name);

                    $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_report_ad_message']);
                }

                wp_mail($to, $subject, $body, $headers);
                update_post_meta($ad_id, '_sb_count_report', 0); // recount the report limit.
            }
        }

        echo '1|' . __("Reported successfully.", 'redux-framework');
    }

    die();
}

// reject ad mail template

add_action('wp_ajax_adforest_ad_rejection', 'adforest_ad_rejection_callback');

function adforest_ad_rejection_callback() {

    global $adforest_theme;

    $rej_ad_id = isset($_POST['post_id']) && !empty($_POST['post_id']) ? $_POST['post_id'] : 0;
    $ad_reject_reason = isset($_POST['ad_reject_reason']) && !empty($_POST['ad_reject_reason']) ? $_POST['ad_reject_reason'] : '';

    $status = array();
    $author_id = get_post_field('post_author', $rej_ad_id);
    $user_info = get_userdata($author_id);
    $to = $user_info->user_email;
    $subject = __('New Messages', 'redux-framework');
    $body = '<html><body><p>' . __('Got new message on ads', 'redux-framework') . ' ' . get_the_title($rej_ad_id) . '</p><p>' . $ad_reject_reason . '</p></body></html>';
    $from = get_bloginfo('name');
    if (isset($adforest_theme['sb_ad_rejection_from']) && $adforest_theme['sb_ad_rejection_from'] != "") {
        $from = $adforest_theme['sb_ad_rejection_from'];
    }
    $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
    $subject_keywords = array('%site_name%', '%ad_title%');
    $subject_replaces = array(get_bloginfo('name'), get_the_title($rej_ad_id));
    $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_ad_rejection_subject']);
    $msg_keywords = array('%ad_author%', '%site_name%', '%ad_title%', '%ad_link%', '%reject_reason%');
    $msg_replaces = array($user_info->display_name, get_bloginfo('name'), get_the_title($rej_ad_id), get_the_permalink($rej_ad_id), $ad_reject_reason);
    $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_ad_rejection_msg']);
    $body = stripcslashes($body);

    if (wp_mail($to, $subject, $body, $headers)) {
        $status['status'] = true;
        $status['message'] = __('Email sent to the ad author successfully', 'redux-framework');
        //wp_trash_post($rej_ad_id);
        wp_update_post(array(
            'ID' => $rej_ad_id,
            'post_status' => 'rejected'
        ));
        //update_post_meta($rej_ad_id, '_adforest_ad_status_', 'rejected');
    } else {
        $status['status'] = false;
        $status['message'] = __('Oops! Something went wrong.Please Check your Mailing details.', 'redux-framework');
    }
    echo json_encode($status);
    wp_die();
}

// package Expiry Notification


add_action('adforest_package_expiry_notification', 'adforest_package_expiry_notification_callback', 10, 2);

function adforest_package_expiry_notification_callback($before_days = 0, $user_id = 0) {
    global $adforest_theme;
    $sb_pkg_name = get_user_meta($user_id, '_sb_pkg_type', true);
    $user_info = get_userdata($user_id);
    $to = $user_info->user_email;
    $subject = __('New Messages', 'redux-framework');
    $body = '<html><body><p>' . __('Got new message on ads', 'redux-framework') . ' ' . get_the_title($rej_ad_id) . '</p><p>' . $ad_reject_reason . '</p></body></html>';
    $from = get_bloginfo('name');
    if (isset($adforest_theme['sb_package_expiry_from']) && $adforest_theme['sb_package_expiry_from'] != "") {
        $from = $adforest_theme['sb_package_expiry_from'];
    }
    $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
    $subject_keywords = array('%site_name%');
    $subject_replaces = array(get_bloginfo('name'));
    $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_package_expiray_subject']);
    $msg_keywords = array('%package_subcriber%', '%site_name%', '%package_name%', '%no_of_days%');
    $msg_replaces = array($user_info->display_name, get_bloginfo('name'), $sb_pkg_name, $before_days);
    $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_package_expiry_msg']);
    $body = stripcslashes($body);
    wp_mail($to, $subject, $body, $headers);
}

// Send message to ad owner
add_action('wp_ajax_sb_send_message', 'adforest_send_message');

function adforest_send_message() {

    check_ajax_referer('sb_msg_secure', 'security');
    adforest_authenticate_check();

    // Getting values

    if (function_exists('adforest_check_if_phoneVerified')) {
        $verifed_phone_number = adforest_check_if_phoneVerified();
        if ($verifed_phone_number) {
            echo '0|' . __("Please go to profile and verify your phone number to send message.", 'redux-framework');
            die();
        }
    }
    $params = array();
    parse_str($_POST['sb_data'], $params);


    if (function_exists('adforest_set_date_timezone')) {
        adforest_set_date_timezone();
    }
    $time = current_time('mysql', 1);
    //$time = date('Y-m-d H:i:s');
    $blocked_user_array1 = get_user_meta($params['msg_receiver_id'], 'adforest_blocked_users', true);

    if (isset($blocked_user_array1) && !empty($blocked_user_array1) && is_array($blocked_user_array1) && in_array($params['usr_id'], $blocked_user_array1)) {
        echo '0|' . __("You can't send message to this user.", 'redux-framework');
        die();
    }

    $blocked_user_array2 = get_user_meta(get_current_user_id(), 'adforest_blocked_users', true);

    if (isset($blocked_user_array2) && !empty($blocked_user_array2) && is_array($blocked_user_array2) && in_array($params['msg_receiver_id'], $blocked_user_array2)) {
        echo '0|' . __("Unblock this user to send message.", 'redux-framework');
        die();
    }

    if (isset($params['msg_receiver_id']) && $params['msg_receiver_id'] == get_current_user_id()) {
        echo '0|' . __("Ad Author cannot message himself.", 'redux-framework');
        die();
    }

    $data = array(
        'comment_post_ID' => $params['ad_post_id'],
        'comment_author' => $params['name'],
        'comment_author_email' => $params['email'],
        'comment_author_url' => '',
        'comment_content' => sanitize_text_field($params['message']),
        'comment_type' => 'ad_post',
        'comment_parent' => $params['usr_id'],
        'user_id' => get_current_user_id(),
        'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
        'comment_date' => $time,
        'comment_approved' => 1,
    );

    global $adforest_theme;
    if ($adforest_theme['sb_send_email_on_message']) {
        $author_obj = get_user_by('id', $params['msg_receiver_id']);
        $to = $author_obj->user_email;
        $subject = __('New Message', 'redux-framework');
        $body = '<html><body><p>' . __('Got new message on ad', 'redux-framework') . ' ' . get_the_title($params['ad_post_id']) . '</p><p>' . $params['message'] . '</p></body></html>';
        $from = get_bloginfo('name');
        if (isset($adforest_theme['sb_message_from_on_new_ad']) && $adforest_theme['sb_message_from_on_new_ad'] != "") {
            $from = $adforest_theme['sb_message_from_on_new_ad'];
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        if (isset($adforest_theme['sb_message_on_new_ad']) && $adforest_theme['sb_message_on_new_ad'] != "") {


            $subject_keywords = array('%site_name%', '%ad_title%');
            $subject_replaces = array(get_bloginfo('name'), get_the_title($params['ad_post_id']));

            $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_message_subject_on_new_ad']);

            $msg_keywords = array('%site_name%', '%ad_title%', '%ad_link%', '%message%', '%sender_name%', '%sender_email%');
            $msg_replaces = array(get_bloginfo('name'), get_the_title($params['ad_post_id']), get_the_permalink($params['ad_post_id']), $params['message'], $params['name'], $params['email']);

            $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_message_on_new_ad']);
            $body = stripcslashes($body);
        }
        
        wp_mail($to, $subject, $body, $headers);
    }
    $comment_id = wp_insert_comment($data);
    if ($comment_id) {
        if (function_exists('adforestAPI_messages_sent_func')) {
            $strip_message = stripcslashes($params['message']);
            adforestAPI_messages_sent_func('sent', $params['msg_receiver_id'], get_current_user_id(), $params['usr_id'], $comment_id, $params['ad_post_id'], sanitize_text_field($strip_message), $time);
        }

        update_comment_meta($params['msg_receiver_id'], $params['ad_post_id'] . "_" . get_current_user_id(), 0);
        echo '1|' . __("Message sent successfully.", 'redux-framework');
    } else {
        echo '0|' . __("Message not sent, please try again later.", 'redux-framework');
    }
    die();
}

// Ajax handler for Forgot Password
add_action('wp_ajax_sb_forgot_password', 'adforest_forgot_password');
add_action('wp_ajax_nopriv_sb_forgot_password', 'adforest_forgot_password');

// Forgot Password
function adforest_forgot_password() {
    global $adforest_theme;
    // Getting values
    $params = array();
    parse_str($_POST['sb_data'], $params);

    check_ajax_referer('sb_forgot_pass_secure', 'security', false);

    $email = $params['sb_forgot_email'];
    if (email_exists($email) == true) {
        $from = get_bloginfo('name');
        if (isset($adforest_theme['sb_forgot_password_from']) && $adforest_theme['sb_forgot_password_from'] != "") {
            $from = $adforest_theme['sb_forgot_password_from'];
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        if (isset($adforest_theme['sb_forgot_password_message']) && $adforest_theme['sb_forgot_password_message'] != "") {


            $subject_keywords = array('%site_name%');
            $subject_replaces = array(get_bloginfo('name'));

            $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_forgot_password_subject']);

            $token = adforest_randomString(50);

            $user = get_user_by('email', $email);
            $msg_keywords = array('%site_name%', '%user%', '%reset_link%');
            $reset_link = trailingslashit(get_home_url()) . '?token=' . $token . '-sb-uid-' . $user->ID;
            $msg_replaces = array(get_bloginfo('name'), $user->display_name, $reset_link);

            $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_forgot_password_message']);

            $to = $email;
            $mail = wp_mail($to, $subject, $body, $headers);
            if ($mail) {
                update_user_meta($user->ID, 'sb_password_forget_token', $token);
                echo "1";
            } else {
                echo __('Email server not responding', 'redux-framework');
            }
        }
    } else {
        echo __('Email is not resgistered with us.', 'redux-framework');
    }
    die();
}

function adforest_get_notify_on_ad_post($pid) {
    global $adforest_theme;
    if (isset($adforest_theme['sb_send_email_on_ad_post']) && $adforest_theme['sb_send_email_on_ad_post']) {
        $to = $adforest_theme['ad_post_email_value'];
        $subject = __('New Ad', 'redux-framework') . '-' . get_bloginfo('name');
        $body = '<html><body><p>' . __('Got new ad', 'redux-framework') . ' <a href="' . get_edit_post_link($pid) . '">' . get_the_title($pid) . '</a></p></body></html>';
        $from = get_bloginfo('name');
        if (isset($adforest_theme['sb_msg_from_on_new_ad']) && $adforest_theme['sb_msg_from_on_new_ad'] != "") {
            $from = $adforest_theme['sb_msg_from_on_new_ad'];
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        if (isset($adforest_theme['sb_msg_on_new_ad']) && $adforest_theme['sb_msg_on_new_ad'] != "") {

            $author_id = get_post_field('post_author', $pid);
            $user_info = get_userdata($author_id);

            $subject_keywords = array('%site_name%', '%ad_owner%', '%ad_title%');
            $subject_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($pid));

            $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_msg_subject_on_new_ad']);

            $msg_keywords = array('%site_name%', '%ad_owner%', '%ad_title%', '%ad_link%');
            $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($pid), get_the_permalink($pid));

            $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_msg_on_new_ad']);
        }
        wp_mail($to, $subject, $body, $headers);
    }
}

function adforest_send_email_new_rating($sender_id, $receiver_id, $rating = '', $comments = '') {
    global $adforest_theme;
    $receiver_info = get_userdata($receiver_id);
    $to = $receiver_info->user_email;
    $subject = __('New Rating', 'redux-framework') . '-' . get_bloginfo('name');

    $body = '<html><body><p>' . __('Got new Rating', 'redux-framework') . ' <a href="' . get_author_posts_url($receiver_id) . '?type=1">' . get_author_posts_url($receiver_id) . '</a></p></body></html>';
    $from = get_bloginfo('name');

    if (isset($adforest_theme['sb_new_rating_from']) && $adforest_theme['sb_new_rating_from'] != "") {
        $from = $adforest_theme['sb_new_rating_from'];
    }
    $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
    if (isset($adforest_theme['sb_new_rating_message']) && $adforest_theme['sb_new_rating_message'] != "") {



        $subject_keywords = array('%site_name%');
        $subject_replaces = array(get_bloginfo('name'));

        $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_new_rating_subject']);

        // Rator info
        $sender_info = get_userdata($sender_id);

        $msg_keywords = array('%site_name%', '%receiver%', '%rator%', '%rating%', '%comments%', '%rating_link%');
        $msg_replaces = array(get_bloginfo('name'), $receiver_info->display_name, $sender_info->display_name, $rating, $comments, get_author_posts_url($receiver_id) . '?type=1');

        $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_new_rating_message']);
    }
    wp_mail($to, $subject, $body, $headers);
}

add_action('adforest_send_email_bid_winner', 'adforest_send_email_bid_winner_callback', 10, 1);

function adforest_send_email_bid_winner_callback($ad_id = 0) {

    global $adforest_theme;

    if ($ad_id == 0)
        return;

    $adforest_bid_flag = get_post_meta($ad_id, 'adforest_bid_winner_mail_flg', true);
    $adforest_bid_flag = $adforest_bid_flag == '' ? '1' : $adforest_bid_flag;

    if ($adforest_bid_flag == '0')
        return;


    $bids_res = adforest_get_all_biddings_array($ad_id);
    $total_bids = count($bids_res);
    $max = 0;
    if ($total_bids > 0) {
        $max = max($bids_res);
    }
    $count = 1;
    if ($total_bids > 0) {
        foreach ($bids_res as $key => $val) {
            $bid_winner_neme = 'demo';
            if ($val == $max) {

                $data = explode('_', $key);
                $bid_winner_id = $data[0];
                $user_info = get_userdata($bid_winner_id);
                $bid_winner_neme = $user_info->display_name;
                $to = $user_info->user_email;
                $from = '';
                if (isset($adforest_theme['sb_new_bid_winner_from']) && $adforest_theme['sb_new_bid_winner_from'] != "") {
                    $from = $adforest_theme['sb_new_bid_winner_from'];
                }
                $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                if (isset($adforest_theme['sb_email_to_bid_winner']) && $adforest_theme['sb_email_to_bid_winner']) {
                    if (isset($adforest_theme['sb_new_bid_winner_message']) && $adforest_theme['sb_new_bid_winner_message'] != "") {
                        $subject_keywords = array('%site_name%');
                        $subject_replaces = array(get_bloginfo('name'));
                        $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_new_bid_winner_subject']);
                        $msg_keywords = array('%site_name%', '%bid_winner_name%', '%bid_link%');
                        $msg_replaces = array(get_bloginfo('name'), $bid_winner_neme, get_the_permalink($ad_id) . '#tab2default');
                        echo $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_new_bid_winner_message']);
                        wp_mail($to, $subject, $body, $headers);
                        update_post_meta($ad_id, 'adforest_bid_winner_mail_flg', '0');
                    }
                }
            }
            break;
        }
    }
}

function adforest_send_email_new_bid($sender_id, $receiver_id, $bid = '', $comments = '', $aid) {
    global $adforest_theme;
    $receiver_info = get_userdata($receiver_id);
    $to = $receiver_info->user_email;
    $from = '';
    if (isset($adforest_theme['sb_new_bid_from']) && $adforest_theme['sb_new_bid_from'] != "") {
        $from = $adforest_theme['sb_new_bid_from'];
    }
    $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
    if (isset($adforest_theme['sb_new_bid_message']) && $adforest_theme['sb_new_bid_message'] != "") {



        $subject_keywords = array('%site_name%');
        $subject_replaces = array(get_bloginfo('name'));

        $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_new_bid_subject']);

        // Bidder info
        $sender_info = get_userdata($sender_id);

        $msg_keywords = array('%site_name%', '%receiver%', '%bidder%', '%bid%', '%comments%', '%bid_link%');
        $msg_replaces = array(get_bloginfo('name'), $receiver_info->display_name, $sender_info->display_name, $bid, $comments, get_the_permalink($aid) . '#tab2default');

        $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_new_bid_message']);
        wp_mail($to, $subject, $body, $headers);
    }
}

// Resend Email
add_action('wp_ajax_sb_resend_email', 'adforest_resend_email');
add_action('wp_ajax_nopriv_sb_resend_email', 'adforest_resend_email');

function adforest_resend_email() {
    $email = $_POST['usr_email'];
    $user = get_user_by('email', $email);
    if (get_user_meta($user->ID, 'sb_resent_email', true) != 'yes') {

        adforest_email_on_new_user($user->ID, '', false);
        update_user_meta($user->ID, 'sb_resent_email', 'yes');
    }
    die();
}

// Email on new User
function adforest_email_on_new_user($user_id, $social = '', $admin_email = true) {
    global $adforest_theme;

    if (isset($adforest_theme['sb_new_user_email_to_admin']) && $adforest_theme['sb_new_user_email_to_admin'] && $admin_email) {
        if (isset($adforest_theme['sb_new_user_admin_message']) && $adforest_theme['sb_new_user_admin_message'] != "" && isset($adforest_theme['sb_new_user_admin_message_from']) && $adforest_theme['sb_new_user_admin_message_from'] != "") {
            $to = get_option('admin_email');
            $subject = $adforest_theme['sb_new_user_admin_message_subject'];
            $from = $adforest_theme['sb_new_user_admin_message_from'];
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");

            // User info
            $user_info = get_userdata($user_id);


            $msg_keywords = array('%site_name%', '%display_name%', '%email%');
            $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, $user_info->user_email);


            $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_new_user_admin_message']);
            wp_mail($to, $subject, $body, $headers);
        }
    }

    if (isset($adforest_theme['sb_new_user_email_to_user']) && $adforest_theme['sb_new_user_email_to_user']) {
        if (isset($adforest_theme['sb_new_user_message']) && $adforest_theme['sb_new_user_message'] != "" && isset($adforest_theme['sb_new_user_message_from']) && $adforest_theme['sb_new_user_message_from'] != "") {
            // User info
            $user_info = get_userdata($user_id);

            $to = $user_info->user_email;
            $subject = $adforest_theme['sb_new_user_message_subject'];
            $from = $adforest_theme['sb_new_user_message_from'];
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");



            $user_name = $user_info->user_email;
            if ($social != '')
                $user_name .= "(Password: $social )";

            $verification_link = '';
            if (isset($adforest_theme['sb_new_user_email_verification']) && $adforest_theme['sb_new_user_email_verification'] && $social == "") {
                $token = get_user_meta($user_id, 'sb_email_verification_token', true);
                if ($token == "") {
                    $token = adforest_randomString(50);
                }
                $verification_link = trailingslashit(get_the_permalink($adforest_theme['sb_sign_in_page'])) . '?verification_key=' . $token . '-sb-uid-' . $user_id;

                update_user_meta($user_id, 'sb_email_verification_token', $token);
            }

            $msg_keywords = array('%site_name%', '%user_name%', '%display_name%', '%verification_link%');
            $msg_replaces = array(get_bloginfo('name'), $user_name, $user_info->display_name, $verification_link);

            $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_new_user_message']);
            wp_mail($to, $subject, $body, $headers);
        }
    }
}

// Email on new social login user

function adforest_email_on_new_social_user($user_id, $social = '', $admin_email = true) {
    global $adforest_theme;

    if (isset($adforest_theme['sb_new_user_email_to_admin']) && $adforest_theme['sb_new_user_email_to_admin'] && $admin_email) {
        if (isset($adforest_theme['sb_new_user_admin_message']) && $adforest_theme['sb_new_user_admin_message'] != "" && isset($adforest_theme['sb_new_user_admin_message_from']) && $adforest_theme['sb_new_user_admin_message_from'] != "") {
            $to = get_option('admin_email');
            $subject = $adforest_theme['sb_new_user_admin_message_subject'];
            $from = $adforest_theme['sb_new_user_admin_message_from'];
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            $user_info = get_userdata($user_id);
            $msg_keywords = array('%site_name%', '%display_name%', '%email%');
            $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, $user_info->user_email);
            $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_new_user_admin_message']);
            wp_mail($to, $subject, $body, $headers);
        }
    }

    if (isset($adforest_theme['sb_new_user_email_to_user']) && $adforest_theme['sb_new_user_email_to_user']) {
        if (isset($adforest_theme['sb_welcome_social_message']) && $adforest_theme['sb_welcome_social_message'] != "" && isset($adforest_theme['sb_welcome_social_message_from']) && $adforest_theme['sb_welcome_social_message_from'] != "") {
            $user_info = get_userdata($user_id);
            $to = $user_info->user_email;
            $subject = $adforest_theme['sb_welcome_social_message_subject'];
            $from = $adforest_theme['sb_welcome_social_message_from'];
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            $login_details = '';
            $login_details .= ' Username : ' . $user_info->user_email;

            if ($social != '') {
                $login_details .= "(Password: $social )";
            }
            $msg_keywords = array('%site_name%', '%email%', '%display_name%', '%details%');
            $msg_replaces = array(get_bloginfo('name'), $user_info->user_email, $user_info->display_name, $login_details);

            $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_welcome_social_message']);
            wp_mail($to, $subject, $body, $headers);
        }
    }
}

// Email on Ad approval
function adforest_get_notify_on_ad_approval($pid) {
    global $adforest_theme;
    $from = get_bloginfo('name');
    if (isset($adforest_theme['sb_active_ad_email_from']) && $adforest_theme['sb_active_ad_email_from'] != "") {
        $from = $adforest_theme['sb_active_ad_email_from'];
    }
    $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
    if (isset($adforest_theme['sb_active_ad_email_message']) && $adforest_theme['sb_active_ad_email_message'] != "") {

        $author_id = get_post_field('post_author', $pid);
        $user_info = get_userdata($author_id);

        $subject = $adforest_theme['sb_active_ad_email_subject'];

        $msg_keywords = array('%site_name%', '%user_name%', '%ad_title%', '%ad_link%');
        $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($pid), get_the_permalink($pid));

        $to = $user_info->user_email;
        $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_active_ad_email_message']);
        
        wp_mail($to, $subject, $body, $headers);
    }
}

// Email on Ad rating
function adforest_email_ad_rating($pid, $sender_id, $rating, $comments) {
    global $adforest_theme;
    $from = get_bloginfo('name');
    if (isset($adforest_theme['ad_rating_email_from']) && $adforest_theme['ad_rating_email_from'] != "") {
        $from = $adforest_theme['ad_rating_email_from'];
    }
    $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
    if (isset($adforest_theme['ad_rating_email_message']) && $adforest_theme['ad_rating_email_message'] != "") {

        $author_id = get_post_field('post_author', $pid);
        $user_info = get_userdata($author_id);

        $subject = $adforest_theme['ad_rating_email_subject'];

        $msg_keywords = array('%site_name%', '%ad_title%', '%ad_link%', '%rating%', '%rating_comments%', '%author_name%');
        $msg_replaces = array(get_bloginfo('name'), get_the_title($pid), get_the_permalink($pid) . '#ad-rating', $rating, $comments, $user_info->display_name);

        $to = $user_info->user_email;
        $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['ad_rating_email_message']);
        wp_mail($to, $subject, $body, $headers);
    }
}

// Email on Ad rating reply
function adforest_email_ad_rating_reply($pid, $receiver_id, $reply, $rating, $rating_comments) {
    global $adforest_theme;
    $from = get_bloginfo('name');
    if (isset($adforest_theme['ad_rating_reply_email_from']) && $adforest_theme['ad_rating_reply_email_from'] != "") {
        $from = $adforest_theme['ad_rating_reply_email_from'];
    }
    $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
    if (isset($adforest_theme['ad_rating_reply_email_message']) && $adforest_theme['ad_rating_reply_email_message'] != "") {

        $author_id = get_post_field('post_author', $pid);
        $user_info = get_userdata($author_id);

        $subject = $adforest_theme['ad_rating_reply_email_subject'];

        $msg_keywords = array('%site_name%', '%ad_title%', '%ad_link%', '%rating%', '%rating_comments%', '%author_name%', '%author_reply%');
        $msg_replaces = array(get_bloginfo('name'), get_the_title($pid), get_the_permalink($pid) . '#ad-rating', $rating, $rating_comments, $user_info->display_name, $reply);

        $receiver_info = get_userdata($receiver_id);
        $to = $receiver_info->user_email;
        $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['ad_rating_reply_email_message']);
        wp_mail($to, $subject, $body, $headers);
    }
}

// Ajax handler for add to cart
add_action('wp_ajax_demo_data_start', 'adforest_before_install_demo_data');

// Addind Subcriber into Mailchimp
function adforest_before_install_demo_data() {
    if (get_option('adforest_fresh_installation') != 'no') {
        update_option('adforest_fresh_installation', $_POST['is_fresh']);
    }
    die();
}

// Importing data
function adforest_importing_data($demo_type) {
    global $wpdb;
    $sql_file_OR_content;
    if ($demo_type == 'Adforest') {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/data.sql';
    } else if ($demo_type == 'PetForest') {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/petforest-data.sql';
    } else if ($demo_type == 'MatchForest') {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/matchforest-data.sql';
    } else if ($demo_type == 'TechForest') {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/techforest-data.sql';
    } else if ($demo_type == 'Landing-Page') {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/landing-data.sql';
    } else if ($demo_type == 'bookforest') {                              // new sql files
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/bookforest-data.sql';
    } else if ($demo_type == 'decorforest') {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/decorforest-data.sql';
    } else if ($demo_type == 'estateforest') {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/estateforest-data.sql';
    } else if ($demo_type == 'mobileforest') {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/mobileforest-data.sql';
    } else if ($demo_type == 'serviceforest') {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/serviceforest-data.sql';
    } else if ($demo_type == 'sportforest') {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/sportforest-data.sql';
    } else if ($demo_type == 'toyforest') {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/toyforest-data.sql';
    } else {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/data-rtl.sql';
    }

    $SQL_CONTENT = (strlen($sql_file_OR_content) > 300 ? $sql_file_OR_content : file_get_contents($sql_file_OR_content) );
    $allLines = explode("\n", $SQL_CONTENT);
    $zzzzzz = $wpdb->query('SET foreign_key_checks = 0');
    preg_match_all("/\nCREATE TABLE(.*?)\`(.*?)\`/si", "\n" . $SQL_CONTENT, $target_tables);
    foreach ($target_tables[2] as $table) {
        $wpdb->query('DROP TABLE IF EXISTS ' . $table);
    }
    $zzzzzz = $wpdb->query('SET foreign_key_checks = 1');
    //$wpdb->query("SET NAMES 'utf8'");	
    $templine = ''; // Temporary variable, used to store current query
    foreach ($allLines as $line) {           // Loop through each line
        if (substr($line, 0, 2) != '--' && $line != '') {
            $templine .= $line;  // (if it is not a comment..) Add this line to the current segment
            if (substr(trim($line), -1, 1) == ';') {  // If it has a semicolon at the end, it's the end of the query
                if ($wpdb->prefix != 'wp_') {
                    $templine = str_replace("`wp_", "`$wpdb->prefix", $templine);
                }
                if (!$wpdb->query($templine)) {
                    //print('Error performing query \'<strong>' . $templine . '\': ' . $wpdb->error . '<br /><br />');
                }
                $templine = ''; // set variable to empty, to start picking up the lines after ";"
            }
        }
    }
    //return 'Importing finished. Now, Delete the import file.';
}

// define the admin_comment_types_dropdown callback 
function sb_filter_admin_comment_types_dropdown($comment_type_array) {
    // make filter magic happen here... 
    $comment_type_array['ad_post_rating'] = __('Ad Rating', 'redux-framework');
    return $comment_type_array;
}

;

// add the filter 
add_filter('admin_comment_types_dropdown', 'sb_filter_admin_comment_types_dropdown', 10, 1);

add_action('wp_ajax_sb_delete_user_rating', 'adforest_delete_user_rating');

// Delete user rating
function adforest_delete_user_rating() {
    global $wpdb;
    $meta_id = $_POST['meta_id'];
    $table_name = $wpdb->prefix . "usermeta";
    $wpdb->query("DELETE FROM $table_name WHERE umeta_id = '$meta_id' ");
    echo "1";
    die();
}

add_action('wp_ajax_sb_delete_user_bid', 'adforest_delete_user_bid_admin');

// Delete user rating
function adforest_delete_user_bid_admin() {
    global $wpdb;
    $meta_id = $_POST['meta_id'];
    $table_name = $wpdb->prefix . "postmeta";
    $wpdb->query("DELETE FROM $table_name WHERE meta_id = '$meta_id' ");
    echo "1";
    die();
}

// Email on new User
add_action('wp_ajax_sb_user_contact_form', 'adforest_user_contact_form');
add_action('wp_ajax_nopriv_sb_user_contact_form', 'adforest_user_contact_form');

function adforest_user_contact_form() {
    global $adforest_theme;
    $params = array();
    parse_str($_POST['sb_data'], $params);
    $name = $params['name'];
    $email = $params['email'];
    $sender_subject = $params['subject'];
    $message = $params['message'];
    $user_id = $_POST['receiver_id'];

    $google_captcha_auth = false;
    $google_captcha_auth = adforest_recaptcha_verify($adforest_theme['google_api_secret'], $params['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'], $params['is_captcha']);
    $captcha_type = isset($adforest_theme['google-recaptcha-type']) && !empty($adforest_theme['google-recaptcha-type']) ? $adforest_theme['google-recaptcha-type'] : 'v2';

    if ($google_captcha_auth) {
        if (isset($adforest_theme['user_contact_form']) && $adforest_theme['user_contact_form']) {
            if (isset($adforest_theme['sb_profile_contact_message']) && $adforest_theme['sb_profile_contact_message'] != "" && isset($adforest_theme['sb_profile_contact_from']) && $adforest_theme['sb_profile_contact_from'] != "") {
                $user_info = get_userdata($user_id);
                $to = $user_info->user_email;
                $user_info->display_name;
                $subject = $adforest_theme['sb_profile_contact_subject'];
                $from = $adforest_theme['sb_profile_contact_from'];
                $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                $msg_keywords = array('%receiver_name%', '%sender_name%', '%sender_email%', '%sender_subject%', '%sender_message%');
                $msg_replaces = array($user_info->display_name, $name, $email, $sender_subject, $message);
                $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_profile_contact_message']);
                $res = wp_mail($to, $subject, $body, $headers);
                if ($res) {
                    echo '1|' . __("Message has been sent.", "redux-framework");
                } else {
                    echo '0|' . __("Message not sent, please try later.", "redux-framework");
                }
                die();
            }
        }
    } else {


        if ($captcha_type == 'v3') {
            echo '0|' . __("You are spammer ! Get out..", "redux-framework");
        } else {
            echo '0|' . __("please verify captcha code.", "redux-framework");
        }
    }
}

class Adforest_Demo_OCDI {

    function __construct() {
        add_filter('pt-ocdi/import_files', array($this, 'adforest_ocdi_import_files'));
        add_action('pt-ocdi/after_import', array($this, 'adforest_ocdi_after_import'));
        add_filter('pt-ocdi/plugin_intro_text', array($this, 'adforest_ocdi_plugin_intro_text'));
        add_filter('pt-ocdi/disable_pt_branding', array($this, '__return_true'));
        //add_action('pt-ocdi/enable_wp_customize_save_hooks', '__return_true');
    }

    function adforest_ocdi_before_content_import($a) {
        $msg = '';
        $fresh_installation = (array) get_option('_adforest_ocdi_demos');
        if (in_array("$a", $fresh_installation)) {
            $msg = __('Note: This demo data is already imported.', 'redux-framework');
            $msg = "<strong style='color:red;'>" . $msg . "</strong><br />";
        }
        return $msg;
    }

    function adforest_ocdi_options($demo_type = array()) {
        if (isset($demo_type)) {
            $fresh_installation = (array) get_option('_adforest_ocdi_demos');
            $result = array_merge($fresh_installation, $demo_type);
            $result = array_unique($result);
            update_option('_adforest_ocdi_demos', $result);
        }
        $fresh_installation = (array) get_option('_adforest_ocdi_demos');
    }

    function adforest_ocdi_import_files() {


        /* LTR Demo Options */
        $text = " - " . __('Imported', 'redux-framework') . "";
        // $text = "";

        $notice = $this->adforest_ocdi_before_content_import('Adforest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Adforest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/Adforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/Adforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/Adforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/Adforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/Adforest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforest.scriptsbundle.com/',
        );
        $notice = $this->adforest_ocdi_before_content_import('PetForest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'PetForest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/PetForest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/PetForest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/PetForest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/PetForest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/PetForest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforest.scriptsbundle.com/',
        );
        $notice = $this->adforest_ocdi_before_content_import('MatchForest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'MatchForest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/MatchForest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/MatchForest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/MatchForest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/MatchForest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/MatchForest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforest.scriptsbundle.com/',
        );
        $notice = $this->adforest_ocdi_before_content_import('TechForest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'TechForest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/TechForest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/TechForest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/TechForest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/TechForest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/TechForest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforest.scriptsbundle.com/',
        );
        $notice = $this->adforest_ocdi_before_content_import('Landing Page');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Landing Page' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/Landing-Page/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/Landing-Page/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/Landing-Page/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/Landing-Page/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/Landing-Page/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforest.scriptsbundle.com/',
        );
        $notice = $this->adforest_ocdi_before_content_import('Bookforest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Bookforest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/bookforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/bookforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/bookforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/bookforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/bookforest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforest.scriptsbundle.com/',
        );
        $notice = $this->adforest_ocdi_before_content_import('Decorforest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Decorforest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/decorforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/decorforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/decorforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/decorforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/decorforest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforest.scriptsbundle.com/',
        );
        $notice = $this->adforest_ocdi_before_content_import('Estateforest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Estateforest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/estateforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/estateforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/estateforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/estateforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/estateforest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforest.scriptsbundle.com/',
        );
        $notice = $this->adforest_ocdi_before_content_import('Mobileforest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Mobileforest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/mobileforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/mobileforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/mobileforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/mobileforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/mobileforest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforest.scriptsbundle.com/',
        );
        $notice = $this->adforest_ocdi_before_content_import('Serviceforest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Serviceforest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/serviceforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/serviceforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/serviceforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/serviceforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/serviceforest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforest.scriptsbundle.com/',
        );
        $notice = $this->adforest_ocdi_before_content_import('Sportforest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Sportforest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/sportforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/sportforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/sportforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/sportforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/sportforest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforest.scriptsbundle.com/',
        );
        $notice = $this->adforest_ocdi_before_content_import('Toyforest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Toyforest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/toyforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/toyforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/toyforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/toyforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/toyforest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforest.scriptsbundle.com/',
        );

        /* RTL Demo Options */
        $notice = $this->adforest_ocdi_before_content_import('Adforest RTL');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Adforest RTL' . $notice2,
            'categories' => array('RTL Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/Adforest-RTL/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/Adforest-RTL/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/Adforest-RTL/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/Adforest-RTL/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/Adforest-RTL/screen-image.jpg',
            'import_notice' => $notice . '' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforest.scriptsbundle.com/',
        );

        return $allDemos;
    }

    function adforest_ocdi_after_import($selected_import) {

        //echo "This will be displayed on all after imports!";
        $fresh_installation = get_option('adforest_fresh_installation');
        if ($fresh_installation != 'no') {
            //if($fresh_installation == 'yes'){
            global $wpdb;
            $wpdb->query("TRUNCATE TABLE $wpdb->term_relationships");
            $wpdb->query("TRUNCATE TABLE $wpdb->term_taxonomy");
            $wpdb->query("TRUNCATE TABLE $wpdb->termmeta");
            $wpdb->query("TRUNCATE TABLE $wpdb->terms");
            //}
        }

        if ('Adforest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
// Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('Almond Classified');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('Adforest'); // use for sql import
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Adforest')); // instalation check yes/no
        } elseif ('PetForest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
// Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('Petforest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('PetForest'); // use for sql import
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('PetForest')); // instalation check yes/no
        } elseif ('MatchForest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
// Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('MatchForest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('MatchForest'); // use for sql import
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('MatchForest')); // instalation check yes/no
        } elseif ('TechForest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
// Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('TechForest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('TechForest'); // use for sql import
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('TechForest')); // instalation check yes/no
        } elseif ('Landing Page' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
// Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('LandingPage');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('Landing-Page'); // use for sql import
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Landing Page')); // instalation check yes/no
        } elseif ('Bookforest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
// Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('BoookForest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('bookforest'); // use for sql import
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Bookforest')); // instalation check yes/no
        } elseif ('Decorforest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
// Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('DecorForest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('decorforest'); // use for sql import
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Decorforest')); // instalation check yes/no
        } elseif ('Estateforest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
// Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('RealEstate Forest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('estateforest'); // use for sql import
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Estateforest')); // instalation check yes/no
        } elseif ('Mobileforest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
// Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('MobileForest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('mobileforest'); // use for sql import
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Mobileforest')); // instalation check yes/no
        } elseif ('Serviceforest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
// Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('ServiceForest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('serviceforest'); // use for sql import
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Serviceforest')); // instalation check yes/no
        } elseif ('Sportforest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
// Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('Sports Forest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('sportforest'); // use for sql import
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Sportforest')); // instalation check yes/no
        } elseif ('Toyforest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
// Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('ToyForest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('toyforest'); // use for sql import
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Toyforest')); // instalation check yes/no
        } elseif ('Adforest RTL' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            // Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('الكاجو مصن�?ة');
            $blog_page_id = get_page_by_title('مدون');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('Adforest RTL');
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Adforest RTL'));
        }

        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure('/%postname%/');
    }

    function adforest_ocdi_plugin_intro_text($default_text) {
        $default_text .= '<div class="ocdi__intro-text"><h4 id="before">Before Importing Demo</h4>
	<p><strong>Before importing one of the demos available it is advisable to check the following list</strong>. <br />All these queues are important and will ensure that the import of a demo ends successfully. In the event that something should go wrong with your import, open a ticket and <a href="https://scriptsbundle.ticksy.com/" target="_blank">contact our Technical Support</a>.</p>
	<ul>
	<li><strong>Theme Activation</strong> – Please make sure to activate the theme to be able to access the demo import section</li>
	<li><strong>Required Plugins</strong> – Install and activate all required plugins</li>
	<li><strong>Other Plugins</strong> – Is recommended to <strong>disable all other plugins that are not required</strong>. Such as plugins to create coming soon pages, plugins to manage the cache, plugin to manage SEO, etc &#8230; You will reactivate your personal plugins later as soon as the import process is finished</li>
	</ul>
	<h4>Requirements for demo importing</h4>
	<p>To correctly import a demo please make sure that your hosting is running the following features:</p>
	<p><strong>WordPress Requirements</strong></p>
	<ul>
	<li>WordPress 4.6+</li>
	<li>PHP 5.6+</li>
	<li>MySQL 5.6+</li>
	</ul>
	<p><strong>Recommended PHP configuration limits</strong></p>
	<p>*If the import stalls and fails to respond after a few minutes it because your hosting is suffering from PHP configuration limits. You should contact your hosting provider and ask them to increase those limits to a minimum as follows:</p>
	<ul>
	<li>max_execution_time 3000</li>
	<li>memory_limit 256M</li>
	<li>post_max_size 100M</li>
	<li>upload_max_filesize 81M</li>
	</ul></div>
	<p><strong>*Please note that you can import 1 demo data select it carefully.</strong></p>
	<hr />';

        return $default_text;
    }

}

$adforest_demo_ocdi = new Adforest_Demo_OCDI();

add_action('adforest_wpml_terms_filters', 'adforest_wpml_terms_filters_callback');

function adforest_wpml_terms_filters_callback() {
    global $sitepress;
    remove_filter('get_terms_args', array($sitepress, 'get_terms_args_filter'), 10);
    remove_filter('get_term', array($sitepress, 'get_term_adjust_id'), 1);
    remove_filter('terms_clauses', array($sitepress, 'terms_clauses'), 10);
}
