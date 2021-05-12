<?php
/* ------------------------------------------------ */
/* adforest_main_call_to_action_modern2 */
/* ------------------------------------------------ */
if (!function_exists('adforest_maincallt_modern2_integrateWithVC')) {
function adforest_maincallt_modern2_integrateWithVC() {
	vc_map( array(
		'name' => __( 'Main Section - Call To Action Modern 2', 'adforest' ),
		'base' => 'adforest_main_call_to_action_modern2',
		'show_settings_on_create' => true,
		'category' => __( 'Theme Shortcodes - 2', 'adforest'),
		'params' => array(
		
		array(
		   'group' => __( 'Shortcode Output', 'adforest' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'adforest' ),
		   'param_name' => 'order_field_key',
		   'description' => adforest_VCImage('land-main-hero.png').__( 'Ouput of the shortcode will be look like this.', 'adforest' ),
		  ),			
			array(
				"group" => __("Basic", "adforest"),
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'admin_label' => true,
				'heading' => __( 'Section Quote Text', 'adforest' ),
				'param_name' => 'main_quote',
			),
			array(
				"group" => __("Basic", "adforest"),
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'admin_label' => true,
				'heading' => __( 'Section Title', 'adforest' ),
				'param_name' => 'section_title',
				'description' =>  __('For color ', 'adforest') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag', 'adforest') . '<strong>' . esc_html('{/color}') . '</strong>',
				
			),
			array(
				"group" => __("Basic", "adforest"),
				'type' => 'textarea',
				'holder' => 'div',
				'class' => '',
				'admin_label' => true,
				'heading' => __( 'Section Description', 'adforest' ),
				'param_name' => 'section_desc',
			),
		array(
			"group" => __("Basic", "adforest"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Search Block Text", 'adforest' ),
			"param_name" => "block_text",
		),			
			array(
				"group" => __("Basic", "adforest"),
				'type' => 'vc_link',
				'holder' => 'div',
				'class' => '',
				'admin_label' => true,
				'heading' => __( 'Button 1', 'adforest' ),
				'param_name' => 'section_btn_1',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				"group" => __("Basic", "adforest"),
				'type' => 'vc_link',
				'holder' => 'div',
				'class' => '',
				'admin_label' => true,
				'heading' => __( 'Button 2', 'adforest' ),
				'param_name' => 'section_btn_2',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				"group" => __("Basic", "adforest"),
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'admin_label' => true,
				'heading' => __( 'Youtube Video URL', 'adforest' ),
				'param_name' => 'section_video',
				'description' => __( "Leave empty if you don't want to show button.", 'adforest' ),
			),
			
			array(
				"group" => __("Basic", "adforest"),
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => '',
				'admin_label' => true,
				'heading' => __( 'Content Background Image', 'adforest' ),
				'param_name' => 'section_content_bg',
				'description' => __( 'Background image behind the content.', 'adforest' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),

			array(
				"group" => __("Basic", "adforest"),
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => '',
				'admin_label' => true,
				'heading' => __( 'Side Image', 'adforest' ),
				'param_name' => 'side_bg',
				'description' => __( 'Section side image', 'adforest' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),										
		)
	) );
}
}
add_action( 'vc_before_init', 'adforest_maincallt_modern2_integrateWithVC' );
if (!function_exists('adforest_maincallt_modern2_shortcode_func')) {
function adforest_maincallt_modern2_shortcode_func($atts, $content = '') {
	// Attributes
	extract( shortcode_atts(
		array(
				'main_quote' => '', 'section_title' => '', 'section_subtitle' => '', 'section_desc' => '', 'section_btn_1' => '', 'section_btn_2' => '', 'section_content_bg' => '', 'section_img' => '', 'image_pos' => '', 'block_text' => '', 'side_bg' => '', 'section_video' => ''
		),
		$atts
	));
	
	
		$style = '';
		$section_content_bg_url = '';
		if( $section_content_bg != "" )
		{
			$section_content_bg_url	=	adforest_returnImgSrc( $section_content_bg );
			$style = ( $section_content_bg_url != "" ) ? ' style="background-image: url('.$section_content_bg_url.');"' : "";
		}	
	
		$main_quote_html 	 	  = ( $main_quote != "" ) ? '<span>'.esc_html($main_quote).'</span>' : '';
		$section_title_html  	  = adforest_color_text_custom_html($section_title, '<span class="hero-color-combination">', '</span>');
		$section_subtitle_html    = ( $section_subtitle != "" ) ? '<span>'.$section_subtitle.'</span>' : '';
		$section_desc_html 		  = ( $section_desc != "" ) ? '<p>'.$section_desc.'</p>' : '';
		$side_img_url          	  = ( $section_img ) ? adforest_returnImgSrc( $section_img ) : '';
	
		$btn_1 = adforest_ThemeBtn($section_btn_1, 'btn btn-theme', false);
		$btn_2 = adforest_ThemeBtn($section_btn_2, 'btn btn-theme', false);	
	
		
	   $side_bg_url          	  = ( $side_bg ) ? adforest_returnImgSrc( $side_bg ) : '';
		
		$section_video_html = '';
		if( $section_video != "" )
		{
			$adVideoID = adforest_get_adVideoID( $section_video );			
			$section_video_html = '<div class="land-bootsrap-models"><a href="'.esc_url($section_video).'" class="btn btn-primary play-video-new "><i class="fa fa-play"></i></a></div>';
		}
			
	$output = '<section class="land-hero-section" '.$style.'" '.$section_content_bg.'>
	  <div class="container">
		<div class="row">
		  <div class="col-lg-6 col-xs-12 col-sm-12 col-md-7">
			<div class="land-hero-text-section">
			  <div class="land-hero-classified-ads"> <span>'.$main_quote_html.'</span> </div>
			  <div class="land-hero-operating-system">
				<h1> '.$section_title_html.'</h1>
			  </div>
			  <div class="land-hero-details-section">'.$section_desc_html.'</div>
			</div>
			 <div class="tech-main-post-area">
				<div class="tech-post-ads">'.$btn_1.'</div>
				<div class="tech-opinion">'.$btn_2.'</div>
			</div>
		  </div>	 
		  <div class="land-hero-mobiles-section animated finite bounce delay-9s"> <img src="'.esc_url($side_bg_url).'" class="img-responsive" alt="'.esc_attr('image','adforest').'" /> </div>
		  '.$section_video_html.'
		</div>
	  </div>
	</section>';
	return $output;
}
}
if (function_exists('adforest_add_code'))
{
	adforest_add_code('adforest_main_call_to_action_modern2', 'adforest_maincallt_modern2_shortcode_func');
}