<?php

add_filter('adforest_form_lang_field', 'adforest_form_lang_field_callback', 10, 1);
add_filter('adforest_page_lang_url', 'adforest_page_lang_url_callback', 10, 1);
add_filter('adforest_languages_code', 'adforest_languages_code_callback', 10, 1);
add_filter('adforest_language_page_id', 'adforest_language_page_id_callback', 10, 1);
add_filter('adforest_set_query_param', 'adforest_set_query_param_callback', 10, 1);
add_action('adforest_duplicate_posts_lang', 'adforest_duplicate_posts_lang_callback', 10, 1);
add_action('adforest_wpml_settings_options', 'adforest_wpml_settings_options_callback', 10, 1);
add_filter('adforest_wpml_show_all_posts', 'adforest_wpml_show_all_posts_callback', 10, 1);
add_filter('aforest_load_wpml_terms', 'aforest_load_wpml_terms_callback', 10, 3);
add_filter('adforest_get_lang_posts_by_author', 'adforest_get_lang_posts_by_author_callback', 10, 2);
add_filter('adforest_get_lang_tamonomy', 'adforest_get_lang_tamonomy_callback', 10, 1);
add_action('adforest_check_post_duplication', 'adforest_check_post_duplication_callback', 10, 1);

function adforest_check_post_duplication_callback($post_id = 0) {
    global $sitepress;
    if (function_exists('icl_object_id') && $post_id != 0) {
        $_icl_lang_duplicate_of = get_post_meta($post_id, '_icl_lang_duplicate_of', true);
        if ($_icl_lang_duplicate_of) {
            return;
        }
    }
}

function adforest_get_lang_tamonomy_callback($cat_id = 0) {

    if (function_exists('icl_object_id') && $cat_id != 0) {
        $my_current_lang = apply_filters('wpml_current_language', NULL);
        $cat_id = apply_filters('wpml_object_id', $cat_id, 'ad_cats', FALSE, $my_current_lang);
    }

    return $cat_id;
}

function adforest_get_lang_posts_by_author_callback($total_posts = 0, $user_id = 0) {
    global $sitepress;
    if (function_exists('icl_object_id') && $user_id != 0) {
        $my_current_lang = apply_filters('wpml_current_language', NULL); //Store current language
        do_action('wpml_switch_language', ICL_LANGUAGE_CODE); //Switch to the language in which post exist
        $args = array(
            'post_type' => 'ad_post',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'suppress_filters' => 0,
            'fields' => 'ids',
            'author' => $user_id,
        );
        $args = apply_filters('adforest_site_location_ads', $args, 'ads');
        $the_query = new WP_Query($args);
        do_action('wpml_switch_language', $my_current_lang); //Switch again to current language
        wp_reset_postdata();
        $total_posts = $the_query->found_posts;
    }
    return $total_posts;
}

if (!function_exists('aforest_load_wpml_terms_callback')) {

    function aforest_load_wpml_terms_callback($cats_arr = array(), $org_cat_id = 0, $taxonomy = 'ad_cats') {
        global $sitepress;
        if (class_exists('Redux')) {
            $sb_show_posts = Redux::getOption('adforest_theme', 'sb_show_posts');
        }
        $language_code = $sitepress->get_current_language();

        if (function_exists('icl_object_id') && $org_cat_id != 0 && $sb_show_posts) {
            foreach ($sitepress->get_active_languages() as $lang => $details) {
                if ($language_code != $lang) {
                    $lang_cat_id = icl_object_id($org_cat_id, $taxonomy, false, $lang);
                    $lang_cat_data = get_term_by('id', $lang_cat_id, $taxonomy, OBJECT);
                    $lang_cat_count = ($lang_cat_data->count);
                    $cats_arr[$lang_cat_data->name . ' (' . urldecode_deep($lang_cat_data->slug) . ')' . ' (' . $lang_cat_count . ')'] = $lang_cat_data->term_id;
                }
            }
        }
        return $cats_arr;
    }

}
if (!function_exists('adforest_wpml_show_all_posts_callback')) {

    function adforest_wpml_show_all_posts_callback($query_args = array()) {
        global $sitepress;

        $sb_show_posts = false;

        if (function_exists('icl_object_id') && $query_args != '' && $sb_show_posts) {
            if (class_exists('Redux')) {
                $sb_show_posts = Redux::getOption('adforest_theme', 'sb_show_posts');
            }
            do_action('adforest_wpml_terms_filters');
            $query_args['suppress_filters'] = true;
        }
        return $query_args;
    }

}
if (!function_exists('adforest_duplicate_posts_lang_callback')) {

    function adforest_duplicate_posts_lang_callback($org_post_id = 0) {
        global $sitepress;
        $sb_duplicate_post = false;
        if (class_exists('Redux')) {
            $sb_duplicate_post = Redux::getOption('adforest_theme', 'sb_duplicate_post');
        }
        if (function_exists('icl_object_id') && $org_post_id != 0 && $sb_duplicate_post) {
            $language_details_original = $sitepress->get_element_language_details($org_post_id, 'post_ad_post');
            if (!class_exists('TranslationManagement')) {
                include(ABSPATH . 'wp-content/plugins/sitepress-multilingual-cms/inc/translation-management/translation-management.class.php');
            }
            foreach ($sitepress->get_active_languages() as $lang => $details) {
                if ($lang != $language_details_original->language_code) {
                    $iclTranslationManagement = new TranslationManagement();
                    $iclTranslationManagement->make_duplicate($org_post_id, $lang);
                }
            }
        }
    }

}
if (!function_exists('adforest_set_query_param_callback')) {

    function adforest_set_query_param_callback($ajax_url = '') {
        global $sitepress;
        if (function_exists('icl_object_id')) {
            $wpml_options = get_option('icl_sitepress_settings');
            $default_lang = $wpml_options['default_language'];
            $language_code = $sitepress->get_current_language();
            if ($language_code != $default_lang) {
                $ajax_url = add_query_arg('lang', $language_code, $ajax_url);
            }
        }
        return $ajax_url;
    }

}
if (!function_exists('adforest_language_page_id_callback')) {

    function adforest_language_page_id_callback($page_id = '') {
        global $sitepress;
        if (function_exists('icl_object_id') && function_exists('wpml_init_language_switcher') && $page_id != '' && is_numeric($page_id)) {
            $language_code = $sitepress->get_current_language();
            $lang_page_id = icl_object_id($page_id, 'page', false, $language_code);
            if ($lang_page_id <= 0) {
                $lang_page_id = $page_id;
            }
            return $lang_page_id;
        } else {
            return $page_id;
        }
    }

}
if (!function_exists('adforest_languages_code_callback')) {

    function adforest_languages_code_callback($lang_code = '') {
        global $sitepress;

        if (function_exists('icl_object_id')) {
            $lang_code = ICL_LANGUAGE_CODE;
        }

        return $lang_code;
    }

}
if (!function_exists('adforest_page_lang_url_callback')) {

    function adforest_page_lang_url_callback($page_url = '') {
        global $sitepress;

        if (function_exists('icl_object_id') && $page_url != '') {
            $page_url = apply_filters('wpml_permalink', $page_url, ICL_LANGUAGE_CODE, true);
        }

        return $page_url;
    }

}
if (!function_exists('adforest_form_lang_field_callback')) {

    function adforest_form_lang_field_callback($echo = false) {
        global $sitepress;
        $hidden_lang_html = '';
        if (function_exists('icl_object_id')) {
            if ($sitepress->get_setting('language_negotiation_type') == 3) {
                $hidden_lang_html = '<input name="lang" type="hidden" value="' . ICL_LANGUAGE_CODE . '">';
            }
        }
        if ($echo) {
            echo adforest_returnEcho($hidden_lang_html);
        } else {
            return $hidden_lang_html;
        }
    }

}
if (!function_exists('adforest_wpml_settings_options_callback')) {

    function adforest_wpml_settings_options_callback($opt_name = '') {

        if (!function_exists('icl_object_id')) {
            return $options;
        }

        $options = array(
            'title' => __('WPML Settings', 'adforest'),
            'id' => 'sb-wpml-settings',
            'desc' => '',
            'icon' => 'el el-cogs',
            'fields' => array(
                array(
                    'id' => 'sb_duplicate_post',
                    'type' => 'switch',
                    'title' => __('Duplicate Posts', 'adforest'),
                    'default' => false,
                    'subtitle' => __('Enable this option to duplicate posts in all others languages after successfully publish.', 'adforest'),
                    'desc' => __('<b>Note : </b> Disable means the posts publish only in the current language.', 'adforest'),
                ),
                array(
                    'id' => 'sb_show_posts',
                    'type' => 'switch',
                    'title' => __('Display Posts', 'adforest'),
                    'default' => false,
                    'subtitle' => __('Enable this option to display all others languages posts in current language.', 'adforest'),
                    'desc' => __('<b>Note : </b> Disable means to display only current language posts.', 'adforest'),
                ),
                array(
                    'id' => 'sb_head_lang_switch',
                    'type' => 'switch',
                    'title' => __('Language Switcher Header', 'adforest'),
                    'default' => false,
                    'subtitle' => __('Enable this option to display language switcher in header.', 'adforest'),
                //'desc' => __('<b>Note : </b> Ensure that you have enabled <b>"Custom language switchers"</b> in Dashboard >> WMPM >> languages.', 'adforest'),
                ),
                array(
                    'id' => 'sb_menu_lang_switch',
                    'type' => 'switch',
                    'title' => __('Menu Language Switcher', 'adforest'),
                    'default' => false,
                    'subtitle' => __('Enable this option to display language switcher in menu list.', 'adforest'),
                ),
            )
        );


        Redux::setSection($opt_name, $options);
    }

}

add_action('adforest_language_switcher', 'adforest_language_switcher_callback');

function adforest_language_switcher_callback() {
    $sb_head_lang_switch = false;
    if (class_exists('Redux')) {
        $sb_head_lang_switch = Redux::getOption('adforest_theme', 'sb_head_lang_switch');
    }
    $languages = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc');
    if (isset($sb_head_lang_switch) && $sb_head_lang_switch && !empty($languages)) {
        $lang_list = '';
        $lang_html = '';
        $active_html = '';
        foreach ($languages as $l) {
            if ($l['active']) {
                $active_html = '<img src="' . $l['country_flag_url'] . '" height="12" alt="' . $l['language_code'] . '" width="18"  alt="' . esc_attr('flag', 'adforest') . '" /> ' . $l['language_code'] . ' ';
            } else {
                $lang_list .= '<li><a href="' . $l['url'] . '"><img src="' . $l['country_flag_url'] . '" height="12" alt="' . $l['language_code'] . '" width="18"  alt="' . esc_attr('flag', 'adforest') . '" />' . $l['native_name'] . '</a></li>';
            }
        }
        $lang_html .= '<div class="dropdown ad-language">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                ' . $active_html . '
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                            ' . $lang_list . '
                            </ul>
                        </div>';
        echo adforest_returnEcho($lang_html);
    }
}

?>