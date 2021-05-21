<?php
/* ------------------------------------------------ */
/* call_to_action_techy */
/* ------------------------------------------------ */
add_action( 'vc_before_init', 'adforest_call_to_action_techy_shortcode' );
if ( !function_exists ( 'adforest_call_to_action_techy_shortcode' ) ) {
function adforest_call_to_action_techy_shortcode() {
	vc_map( array(
		'name' => __( 'Call To Action - Techy', 'adforest' ),
		'description' => '',
		'base' => 'call_to_action_techy',
		'show_settings_on_create' => true,
		'category' => __( 'Theme Shortcodes - 2', 'adforest'),
		'params' => array(
		array(
		   'group' => __( 'Shortcode Output', 'adforest' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'adforest' ),
		   'param_name' => 'order_field_key',
		   'description' => adforest_VCImage('tech-call-to-action.png').__( 'Ouput of the shortcode will be look like this.', 'adforest' ),
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
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Section Title", 'adforest' ),
				"param_name" => "section_title",
				"description" =>  __('For color ', 'adforest') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag', 'adforest') . '<strong>' . esc_html('{/color}') . '</strong>',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				
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
				
			),
			array(
				"group" => __("Basic", "adforest"),
				'type' => 'vc_link',
				'holder' => 'div',
				'class' => '',
				'admin_label' => true,
				'heading' => __( 'Button 1', 'adforest' ),
				'param_name' => 'btn_1',
			),
			
			array(
				"group" => __("Basic", "adforest"),
				'type' => 'vc_link',
				'holder' => 'div',
				'class' => '',
				'admin_label' => true,
				'heading' => __( 'Button 2', 'adforest' ),
				'param_name' => 'btn_2',
			),	
			
			array(
				"group" => __("Basic", "adforest"),
				"type" => "attach_image",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Image", 'adforest' ),
				"param_name" => "section_img",
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
					__('Gray', 'adforest') => 'gray'
				) ,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				"std" => '',
				"description" => __("Select background color.", 'adforest'),
			),											
		array(
				"group" => __("Basic", "adforest"),
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'admin_label' => true,
				'heading' => __( 'Image Position', 'adforest' ),
				'param_name' => 'image_pos',
				'value' => array(__('Select Option', 'adforest') =>"", __('Left', 'adforest') =>"left", __('Right', 'adforest') => "right"),
			),
			array(
				"group" => __("Images", "adforest"),
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => '',
				'admin_label' => true,
				'heading' => __( 'Content Background Image', 'adforest' ),
				'param_name' => 'section_bg_img',
				'description' => __( 'Background image behind the content.', 'adforest' ),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			
			array(
				"group" => __("Images", "adforest"),
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => '',
				'admin_label' => true,
				'heading' => __( 'Section Image', 'adforest' ),
				'param_name' => 'section_img_1',
				'description' => __( 'Simple section front image.', 'adforest' ),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
					
			array(
				"group" => __("Images", "adforest"),
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => '',
				'admin_label' => true,
				'heading' => __( 'Section Image', 'adforest' ),
				'param_name' => 'section_img_2',
				'description' => __( 'Simple section front image.', 'adforest' ),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),			
						
		)
	) );
}
}

if ( !function_exists ( 'adforest_call_to_action_techy_func' ) )
{
	function adforest_call_to_action_techy_func($atts, $content = '')
	{
		extract( shortcode_atts(
			array(
				'main_quote' => '',
				'section_title' => '',
				'section_description' => '',
				'btn_1' => '',
				'btn_2' => '',
				'section_img_1' => '',
				'section_img_2' => '',
				'section_bg_img' => '',
				'image_pos' => '',
				'section_bg_color' => '',
			), $atts ));
		
				
		$btn_1 = adforest_ThemeBtn($btn_1, 'btn btn-theme', false);
		$btn_2 = adforest_ThemeBtn($btn_2, 'btn btn-theme', false);
		
		$buttons_html = ($btn_1 != "" ) ? '<div class="tech-search-button">'.$btn_1.' </div>' : '';
		$buttons_html .= ($btn_2 != "" ) ? '<div class="tech-new-select-categories">'.$btn_2.'</div>' : '';
		
		$section_bg_class = ( $section_bg_color == 'gray' )  ? 'gray' : '';
		
		$style = '';
		$section_content_bg_url = '';
		
		if( $section_bg_img != "" )
		{
			$section_content_bg_url	=	adforest_returnImgSrc( $section_bg_img );
			$style = ( $section_content_bg_url != "" ) ? ' style="background-image: url('.$section_content_bg_url.');"' : "";
		}
		
		$side_img_url          	      = ( $section_img_1 ) ? adforest_returnImgSrc( $section_img_1 ) : '';
		$side_img_url2          	  = ( $section_img_2 ) ? adforest_returnImgSrc( $section_img_2 ) : '';  
		$images_html = '';
		if( $side_img_url != "" )
		{
			$images_html .= '<div class="tech-action-latest-products"><img src="'.esc_url($side_img_url).'" class="img-responsive"  alt="'.esc_attr('image','adforest').'"></div>';
		}
		if( $side_img_url2 != "" )
		{
			$images_html .= '<div class="tech-action-latest-products-1"> <img src="'.esc_url($side_img_url2).'" class="img-responsive" alt="'.esc_attr('image','adforest').'"> </div>';
		}		
		$section_title_html  = esc_html($section_title);
		$main_quote_html    = ( $main_quote != "" ) ? '<span>'.$main_quote.'</span><br />' : '';
		
		
		return '<section class="tech-call-to-action '.$section_bg_class.'" '.$style.'>
		<div class="container">
		<div class="row">
		  <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6 col-lg-offset-4">
			<div class="tech-modify-text-section">
			  <div class="tech-view-section">
				<h2>'.$main_quote_html.' '.$section_title_html.'</h2>
			  </div>
			  <div class="tech-details-section">'.$section_description.'</div>
			  <div class="clearfix"></div>
			  '.$buttons_html.'
			</div>
		  </div>
		</div>
			'.$images_html.'			
		</div>
		</section>';
	
	}
}
if (function_exists('adforest_add_code'))
{
	adforest_add_code('call_to_action_techy', 'adforest_call_to_action_techy_func');
}