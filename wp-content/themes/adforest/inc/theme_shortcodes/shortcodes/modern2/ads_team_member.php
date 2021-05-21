<?php

/* ------------------------------------------------ */
/* Ads- Cats based boxes */
/* ------------------------------------------------ */
if (!function_exists('ads_team_member_short')) {

    function ads_team_member_short() {

        vc_map(array(
            "name" => __("Team Memebers", 'adforest'),
            "description" => '',
            "base" => "ads_team_member",
            "category" => __("Theme Shortcodes - 2", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('team_member.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    'group' => __('Team member', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Add Team Members', 'adforest'),
                    'param_name' => 'team_members',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Memeber Name", "adforest"),
                            "param_name" => "member_name",
                            "value" => '',
                            "description" => '',
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Memeber Address", "adforest"),
                            "param_name" => "member_address",
                            "value" => '',
                            "description" => '',
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Memeber Designation", "adforest"),
                            "param_name" => "member_designation",
                            "value" => '',
                            "description" => '',
                        ),
                        array(
                            "type" => "attach_image",
                            "class" => "",
                            "heading" => __("Member Image", "adforest"),
                            "param_name" => "member_image",
                            "value" => '',
                            "description" => __("Add an image of your team member : Recommended size (270 X 237)", "adforest")
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Facebook", "adforest"),
                            "param_name" => "facebook",
                            "value" => '',
                            "description" => '',
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Twitter", "adforest"),
                            "param_name" => "twitter",
                            "value" => '',
                            "description" => '',
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Linkedin", "adforest"),
                            "param_name" => "linkedin",
                            "value" => '',
                            "description" => '',
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Google +", "adforest"),
                            "param_name" => "google",
                            "value" => '',
                            "description" => '',
                        ),
                    ),
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'ads_team_member_short');

if (!function_exists('ads_team_member_callback')) {

    function ads_team_member_callback($atts, $content = '') {
        global $adforest_theme;
        extract(shortcode_atts(array(
            'section_title' => '',
            'section_description' => '',
            'header_style' => '',
            'team_members' => '',
                        ), $atts));

        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        $team_members_arr = vc_param_group_parse_atts($atts['team_members']);

        $members_html = '';
        if (isset($team_members_arr) && is_array($team_members_arr) && !empty($team_members_arr[0]) && sizeof($team_members_arr) > 0) {
            foreach ($team_members_arr as $team_member) {
                $member_image_id = isset($team_member['member_image']) ? $team_member['member_image'] : '';
                $member_image = adforest_returnImgSrc($member_image_id);

                $facebook_html = '';
                $twitter_html = '';
                $linkedin_html = '';
                $google_html = '';

                if (isset($team_member['facebook']) && !empty($team_member['facebook'])) {
                    $facebook_html = '<li> <a href="' . esc_url($team_member['facebook']) . '"> <i class="fa fa-facebook"></i> </a> </li>';
                }if (isset($team_member['twitter']) && !empty($team_member['twitter'])) {
                    $twitter_html = '<li> <a href="' . esc_url($team_member['twitter']) . '"> <i class="fa fa-twitter "></i> </a> </li>';
                }if (isset($team_member['linkedin']) && !empty($team_member['linkedin'])) {
                    $linkedin_html = '<li> <a href="' . esc_url($team_member['linkedin']) . '"> <i class="fa fa-linkedin "></i> </a> </li>';
                }if (isset($team_member['google']) && !empty($team_member['google'])) {
                    $google_html = '<li> <a href="' . esc_url($team_member['google']) . '"> <i class="fa fa-google"></i> </a> </li>';
                }

                $member_name = isset($team_member['member_name']) && $team_member['member_name'] != "" ? $team_member['member_name'] : "";
                $member_address = isset($team_member['member_address']) && $team_member['member_address'] != "" ? $team_member['member_address'] : "";
                $member_designation = isset($team_member['member_designation']) && $team_member['member_designation'] != "" ? $team_member['member_designation'] : "";


                $members_html .= '<div class="col-lg-3 col-xs-12 col-sm-6 col-md-3">
                                    <div class="prop-agent-box">
                                        <div class="prop-agent-image"> <img  src="' . esc_url($member_image) . '" alt="' . esc_html__('Team member image', 'adforest') . '" class="img-responsive">
                                            <div class="prop-agent-icons">
                                                <div class="new-social-icons">
                                                    <ul class="list-inline">
                                                        ' . $facebook_html . '
                                                        ' . $twitter_html . '
                                                        ' . $linkedin_html . '
                                                        ' . $google_html . '
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prop-agent-text-section">
                                            <h5>' . $member_name . '</h5>
                                            <p><i class="fa fa-map-marker"></i>' . $member_address . '</p>
                                            <span>' . $member_designation . '</span> </div>
                                    </div>
                                </div>';
            }
        }


        $html = '';
        $html .= '<section class="no-extra ' . $bg_color . '">
                    <div class="container">
                        <div class="row">
                            ' . $header . '
                             <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                               ' . $members_html . ' 
                            </div>
                        </div>
                    </div>
                </section>';

        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('ads_team_member', 'ads_team_member_callback');
}



    