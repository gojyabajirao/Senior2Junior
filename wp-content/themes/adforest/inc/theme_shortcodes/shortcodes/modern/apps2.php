<?php
/* ------------------------------------------------ */
/* Apps 2 */
/* ------------------------------------------------ */
if ( !function_exists ( 'apps2_short' ) ) {
function apps2_short()
{
	vc_map(array(
		"name" => __("Apps - Simple 2", 'adforest') ,
		"base" => "apps2_short_base",
		"category" => __("Theme Shortcodes", 'adforest') ,
		"params" => array(
		array(
		   'group' => __( 'Shortcode Output', 'adforest' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'adforest' ),
		   'param_name' => 'order_field_key',
		   'description' => adforest_VCImage('apps2.png') . __( 'Ouput of the shortcode will be look like this.', 'adforest' ),
		  ),	
		array(
			"group" => __("Basic", "adforest"),
			"type" => "attach_image",
			"holder" => "bg_img",
			"class" => "",
			"heading" => __( "Main Image", 'adforest' ),
			"param_name" => "bg_img",
			"description" => __("448x378", 'adforest'),
		),
		  array(
			"group" => __("Basic", "adforest"),
			"type" => "dropdown",
			"heading" => __("Background Color", 'adforest') ,
			"param_name" => "section_bg",
			"admin_label" => true,
			"value" => array(
				__('Select Background Color', 'adforest') => '',
				__('White', 'adforest') => '',
				__('Gray', 'adforest') => 'gray',
			) ,
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			"std" => '',
			"description" => __("Select background color.", 'adforest'),
		),
		array(
			"group" => __("Basic", "adforest"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Section Title", 'adforest' ),
			"param_name" => "section_title",
		),
		array(
			"group" => __("Basic", "adforest"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Tagline", 'adforest' ),
			"param_name" => "tag_line",
		),
		
			array(
				"group" => __("Basic", "adforest"),
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Section Description", 'adforest' ),
				"param_name" => "section_description",
				"value" => "",
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'dependency' => array(
				'element' => 'header_style',
				'value' => array('classic'),
				) ,
			),
		// Android
		array(
			"group" => __("Android", "adforest"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Download Link", 'adforest' ),
			"param_name" => "a_link",
		),	
		array(
			"group" => __("Android", "adforest"),
			"type" => "attach_image",
			"holder" => "bg_img",
			"class" => "",
			"heading" => __( "Android image", 'adforest' ),
			"param_name" => "android_img",
			"description" => __("167x49", 'adforest'),
		),
		// IOS
		array(
			"group" => __("IOS", "adforest"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Download Link", 'adforest' ),
			"param_name" => "i_link",
		),	
		array(
			"group" => __("IOS", "adforest"),
			"type" => "attach_image",
			"holder" => "bg_img",
			"class" => "",
			"heading" => __( "IOS image", 'adforest' ),
			"param_name" => "ios_img",
			"description" => __("167x49", 'adforest'),
		),
		),
	));
}
}

add_action('vc_before_init', 'apps2_short');
if ( !function_exists ( 'apps2_short_base_func' ) ) {
function apps2_short_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'bg_img' => '',
		'section_title' => '',
		'section_bg' => '',
		'tag_line'	=> '',
		'section_description'	=> '',
		'a_link' => '',
		'i_link' => '',
		'android_img' => '',
		'ios_img' => '',
	) , $atts));
	
$style = '';
if( $bg_img != "" )
{
$bgImageURL	=	adforest_returnImgSrc( $bg_img );
}
$apps_html = '';

if( $android_img != "" && $ios_img != "" )
{
	
	$android_img	=	adforest_returnImgSrc( $android_img );
	$ios_img		=	adforest_returnImgSrc( $ios_img );
	$apps_html	= '<div class="ios-logo-f1"> <a href="'.esc_url($i_link).'" target="_blank"><img src="'.$ios_img.'" class="img-responsive"  alt="'.esc_attr('image','adforest').'"></a> </div>
          <div class="android-logo-f2"> <a href="'.esc_url($a_link).'" target="_blank"> <img src="'.$android_img.'" class="img-responsive"  alt="'.esc_attr('image','adforest').'"></a> </div>';
	
}

return '
<section class="mobile-app-section '.$section_bg.'" '. $style .'>
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-xs-12 col-md-6 col-sm-7">
        <div class="mobile-apps-text">
          <div class="download-app-h2">
            <h2>'.$section_title.'</h2>
          </div>
          <div class="mobile-apps-h3">
            <h3>'.$tag_line.'</h3>
          </div>
          <div class="mobile-text-h5">
            <p>'.$section_description.'</p>
          </div>
          '.$apps_html.'
        </div>
      </div>
      <div class="col-lg-6 col-xs-12 col-md-6 col-sm-5">
        <div class="mobile-images-h6"><img src="'.$bgImageURL.'" alt="'.__('Apps','adforest').'" class="img-responsive"></div>
      </div>
    </div>
  </div>
</section>';
}
}

if (function_exists('adforest_add_code'))
{
	adforest_add_code('apps2_short_base', 'apps2_short_base_func');
}