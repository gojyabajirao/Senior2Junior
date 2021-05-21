<?php
get_template_part('template-parts/layouts/html', 'head');
global $adforest_theme, $wpdb;

$user_id = get_current_user_id();
$unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' ");

define('ADFOREST_MESSAGE_COUNT', $unread_msgs);

if (!function_exists('adforest_header_content_html')) {

    function adforest_header_content_html() {
        global $adforest_theme;
        ?> 
        <div class="sb-top-bar_notification">
            <span>
                <?php echo __('For a better experience please change your browser to CHROME, FIREFOX, OPERA or Internet Explorer.', 'adforest');?>
            </span>
        </div>
        <?php
        if (isset($adforest_theme['sb_header']) && $adforest_theme['sb_header'] == 'black') {
            get_template_part('template-parts/layouts/header', '2');
        } else if (isset($adforest_theme['sb_header']) && $adforest_theme['sb_header'] == 'with_ad') {
            get_template_part('template-parts/layouts/header', '3');
        } else if (isset($adforest_theme['sb_header']) && $adforest_theme['sb_header'] == 'light') {
            get_template_part('template-parts/layouts/header', '4');
        } else if (isset($adforest_theme['sb_header']) && $adforest_theme['sb_header'] == 'modern') {
            get_template_part('template-parts/layouts/header', '5');
        } else if (isset($adforest_theme['sb_header']) && $adforest_theme['sb_header'] == 'modern2') {
            get_template_part('template-parts/layouts/header', '6');
        } else if (isset($adforest_theme['sb_header']) && $adforest_theme['sb_header'] == 'modern3') {
            get_template_part('template-parts/layouts/header', '7');
        } else if (isset($adforest_theme['sb_header']) && $adforest_theme['sb_header'] == 'transparent-2') {
            get_template_part('template-parts/layouts/header', '8');
        } else if (isset($adforest_theme['sb_header']) && $adforest_theme['sb_header'] == 'Decore') {
            get_template_part('template-parts/layouts/header', '9');
        } else if (isset($adforest_theme['sb_header']) && $adforest_theme['sb_header'] == 'transparent-3') {
            get_template_part('template-parts/layouts/header', '10');
        } else if (isset($adforest_theme['sb_header']) && $adforest_theme['sb_header'] == 'modern4') {
            get_template_part('template-parts/layouts/header', '11');
        } else {
            get_template_part('template-parts/layouts/header', '1');
        }

        if (in_array('sb_framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            if (isset($adforest_theme['sb_header']) && $adforest_theme['sb_header'] == 'black') {
                global $post;
                if (is_404() || is_search()) {
                    get_template_part('template-parts/layouts/bread', 'crumb-search');
                } else if (is_author()) {
                    get_template_part('template-parts/layouts/bread', 'crumb');
                } else {
                    $sb_profile_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_profile_page']);
                    if (basename(get_page_template()) != 'page-home.php' && $sb_profile_page != get_the_ID()) {
                        get_template_part('template-parts/layouts/bread', 'crumb');
                    }
                }
            } else {
                if (is_404() || is_search()) {
                    get_template_part('template-parts/layouts/bread', 'crumb-search');
                } else if (is_author()) {
                    get_template_part('template-parts/layouts/bread', 'crumb');
                } else {
                    if (basename(get_page_template()) != 'page-home.php') {
                        get_template_part('template-parts/layouts/bread', 'crumb');
                    }
                }
            }
        } else {
            get_template_part('template-parts/layouts/bread', 'crumb-before');
        }
        ?>
        <?php
    }

}
/* Close ad action here */
do_action('adforestAction_header_content', 'adforest_header_content_html');
?>