<?php
/* ------------------------------------------------ */
/* adforest_main_call_to_action */
/* ------------------------------------------------ */
if (!function_exists('adforest_maincallt_integrateWithVC')) {
function adforest_maincallt_integrateWithVC() {
	vc_map( array(
		'name' => __( 'Main Section - Call To Action', 'adforest' ),
		'base' => 'adforest_main_call_to_action',
		'show_settings_on_create' => true,
		'category' => __( 'Theme Shortcodes - 2', 'adforest'),
		'params' => array(
		
		array(
		   'group' => __( 'Shortcode Output', 'adforest' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'adforest' ),
		   'param_name' => 'order_field_key',
		   'description' => adforest_VCImage('tech-main-section.png').__( 'Ouput of the shortcode will be look like this.', 'adforest' ),
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
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'admin_label' => true,
				'heading' => __( 'Section Subtitle', 'adforest' ),
				'param_name' => 'section_subtitle',
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
				"group" => __("Images", "adforest"),
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
				"group" => __("Images", "adforest"),
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => '',
				'admin_label' => true,
				'heading' => __( 'Section Image', 'adforest' ),
				'param_name' => 'section_img',
				'description' => __( 'Simple section front image.', 'adforest' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
		)
	) );
}
}
add_action( 'vc_before_init', 'adforest_maincallt_integrateWithVC' );

if (!function_exists('adforest_maincallt_shortcode_func')) {
function adforest_maincallt_shortcode_func($atts, $content = '') {
	// Attributes
	extract( shortcode_atts(
		array(
				'main_quote' => '',
				'section_title' => '',
				'section_subtitle' => '',
				'section_desc' => '',
				'section_btn_1' => '',
				'section_btn_2' => '',
				'section_content_bg' => '',
				'section_img' => '',
				'image_pos' => '',
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
	
	$main_quote_html 	 	  = ( $main_quote != "" ) ? '<div class="tech-short-text"><p>'.esc_html($main_quote).'</p></div>' : '';
	$section_title_html  	  = adforest_color_text_custom_html($section_title, '<span>', '</span>');
	$section_subtitle_html    = ( $section_subtitle != "" ) ? '<span class="color-scheme">'.$section_subtitle.'</span>' : '';
	$section_desc_html 		  = ( $section_desc != "" ) ? '<p>'.$section_desc.'</p>' : '';
	$side_img_url          	  = ( $section_img ) ? adforest_returnImgSrc( $section_img ) : '';
	
	$btn_1 = adforest_ThemeBtn($section_btn_1, 'btn btn-theme', false);
	$btn_2 = adforest_ThemeBtn($section_btn_2, 'btn btn-theme', false);	
	
	$image_side = ($image_pos == "left") ? "left" : 'right';
	$image_html_left = $image_html_right = "";
	
	$image_html  = '   <div class="col-lg-7 col-xs-12 col-md-7 col-sm-12"><div class="pets-images-section"> <img src="'.esc_url($side_img_url).'"   class="img-responsive"  alt="'. esc_html__('image','adforest').'"> </div></div>';
	$image_html_right = $image_html;
	if( $image_side == 'left')
	{
		$image_html_left = $image_html_right = "";	
		$image_html_left = $image_html ;
	}	
	// Output Code
	$output = '<section class="tech-main-section" '.$style.'>
  <div class="container">
    <div class="row">
	 
      <div class="col-lg-6 col-xs-12 col-md-6 col-sm-6">
        <div class="tech-text-section">
          '.$main_quote_html.'
          <div class="tech-mac-book">
            <h1>'.$section_title_html.' <br>'.$section_subtitle_html.'</h1>
          </div>
          <div class="tech-description-area">'.$section_desc_html.'</div>
          <div class="tech-main-post-area">
            <div class="tech-post-ads">'.$btn_1.'</div>
            <div class="tech-opinion">'.$btn_2.'</div>
          </div>
        </div>
      </div>
     <div class="tech-main-images-section"> <img src="'.esc_url($side_img_url).'" class="img-responsive"  alt="'. esc_html__('image','adforest').'" /> </div>
    </div>
  </div>
</section>';
	return $output;
}
}

if (function_exists('adforest_add_code'))
{
	adforest_add_code('adforest_main_call_to_action', 'adforest_maincallt_shortcode_func');
}