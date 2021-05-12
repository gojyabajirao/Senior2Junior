<?php
/* ------------------------------------------------ */
/* apps_call_to_action */
/* ------------------------------------------------ */
if (!function_exists('apps_call_to_action_shortcodeBase')) {
function apps_call_to_action_shortcodeBase() {
	vc_map( array(
		'name' => __( "App's - Call To Action Modern", 'adforest' ),
		'base' => 'apps_call_to_action',
		'show_settings_on_create' => true,
		'category' => __( 'Theme Shortcodes - 2', 'adforest'),
		'params' => array(
		
		array(
		   'group' => __( 'Shortcode Output', 'adforest' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'adforest' ),
		   'param_name' => 'order_field_key',
		   'description' => adforest_VCImage('land-call-to-action.png').__( 'Ouput of the shortcode will be look like this.', 'adforest' ),
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
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => '',
				'admin_label' => true,
				'heading' => __( 'Side Image', 'adforest' ),
				'param_name' => 'side_bg',
				'description' => __( 'Section side image', 'adforest' ),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),					
		
		array
		(
			'group' => __( "Point's", 'adforest' ),
			'type' => 'param_group',
			'heading' => __( 'Select points under description.', 'adforest' ),
			'param_name' => 'points',
			'value' => '',
			'params' => array
			(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'admin_label' => true,
					'heading' => __( 'Points', 'adforest' ),
					'param_name' => 'point',
				),

			)
		),	

		array
		(
			'group' => __( "Buttons", 'adforest' ),
			'type' => 'param_group',
			'heading' => __( 'Select points under description.', 'adforest' ),
			'param_name' => 'buttons',
			'value' => '',
			'params' => array
			(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'admin_label' => true,
					'heading' => __( 'Button Link', 'adforest' ),
					'param_name' => 'btn_link',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'admin_label' => true,
					'heading' => __( 'Button Text 1', 'adforest' ),
					'param_name' => 'btn_txt_1',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'admin_label' => true,
					'heading' => __( 'Button Text 2', 'adforest' ),
					'param_name' => 'btn_txt_2',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					"group" => __("Basic", "adforest"),
					'type' => 'attach_image',
					'holder' => 'div',
					'class' => '',
					'admin_label' => true,
					'heading' => __( 'Btn Image', 'adforest' ),
					'param_name' => 'img',
					'description' => __( 'Section side image', 'adforest' ),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),												

			)
		),				
		
					
		)
	) );
}
}
add_action( 'vc_before_init', 'apps_call_to_action_shortcodeBase' );
if (!function_exists('apps_call_to_action_func')) {
function apps_call_to_action_func($atts, $content = '') {
	// Attributes
	extract( shortcode_atts(
		array(
				'main_quote' => '', 'section_title' => '', 'section_subtitle' => '', 'section_desc' => '', 'section_btn_1' => '', 'section_btn_2' => '', 'section_content_bg' => '', 'section_img' => '', 'image_pos' => '', 'block_text' => '', 'side_bg' => '', 'section_video' => '', 'section_bg' => '', 'points' => '', 'buttons' => ''
		),
		$atts
	));
		
		$main_quote_html 	 	  = ( $main_quote != "" ) ? ''.esc_html($main_quote).'' : '';
		$section_title_html  	  = adforest_color_text_custom_html($section_title, '<span>', '</span>');
		$section_subtitle_html    = ( $section_subtitle != "" ) ? '<span>'.$section_subtitle.'</span>' : '';
		$section_desc_html 		  = ( $section_desc != "" ) ? '<p>'.$section_desc.'</p>' : '';
		$side_bg_url          	  = ( $side_bg ) ? adforest_returnImgSrc( $side_bg ) : '';
		
		$btn_1 = adforest_ThemeBtn($section_btn_1, 'btn btn-theme', false);
		$btn_2 = adforest_ThemeBtn($section_btn_2, 'btn btn-theme', false);	
		
		$section_bg_class = ( $section_bg == 'gray' ) ? 'gray' : '';

		$points	=	false;
		$points_html	=	'';
		
		if( isset( $atts['points'] ) )
		{
			$points_rows = vc_param_group_parse_atts( $atts['points'] );
			if( count( $points_rows ) > 0 )
			{
				$inner_html = '';
				foreach($points_rows as $row )
				{
					if( isset( $row['point'] )  )
					{
						$inner_html .= '<li><i class="fa fa-check-circle"></i><span>'.esc_html($row['point']).'</span></li>';
					}
				}
				$points_html = ($inner_html != "" ) ? '<ul class="list-inline">'.$inner_html.'</ul>' : '';
			}		
		}
		
		$buttons_html	=	'';
		if( isset( $atts['buttons'] ) )
		{
			$buttons_rows = vc_param_group_parse_atts( $atts['buttons'] );
			if( count( $buttons_rows ) > 0 )
			{
				$inner_html = '';
				foreach($buttons_rows as $row )
				{
					if( isset( $row['btn_link'] ) && isset( $row['img'] ) )
					{
						$img_url	= ( isset( $row['img'] ) ) ? adforest_returnImgSrc( $row['img'] ) : "";
						$btn_txt_1 	= ( isset( $row['btn_txt_1'] ) ) ? "<p>".esc_html($row['btn_txt_1'])."</p>" : "";
						$btn_txt_2  = ( isset( $row['btn_txt_2'] ) ) ? "<span>".esc_html($row['btn_txt_2'])."</span>" : "";
						$btn_link   = ( isset( $row['btn_link'] ) )  ? esc_url($row['btn_link']) : "#";
												
						$img_html = '';
						if( $img_url != "" )
						{
							$img_html = '<div class="land-android-logos"><img src="'.esc_url($img_url).'" alt="'.$btn_txt_1.'" class="img-responsive"></div>';
						}
						
						$inner_html .= '<li><a href="'.esc_url($btn_link).'"><div class="land-classified-android-apps">'.$img_html.'<div class="land-apps-android-text-area">'.$btn_txt_1.''.$btn_txt_2.'</div></div></a></li>';
					}
				}
				$buttons_html = ($inner_html != "" ) ? '<div class="land-classified-operating-system"><ul class="list-inline">'.$inner_html.'</ul></div>' : '';
			}		
		}		
		
		$output = 	'<section class="land-classified-apps '.$section_bg_class.'">
					<div class="container">
					<div class="row">
					  <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6">
						<div class="land-classified-app-section"> <img  alt="'.esc_attr('image','adforest').'" src="'.esc_url($side_bg_url).'" class="img-responsive"> </div>
					  </div>
					  <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6">
						<div class="land-classified-text-section">
						  <div class="land-classified-heading"><h3>'.$section_title_html.'</h3></div>
						   <div class="land-classified-details-section"><h5><strong>'.$main_quote_html.'</strong></h5></div>
						  <div class="land-classified-details-section">'.$section_desc_html.'</div>
							'.$points_html.''.$buttons_html.'		  
						 </div>
					  </div>
					</div>
					</div>
				</section>';

		return $output;
}
}
if (function_exists('adforest_add_code'))
{
	adforest_add_code('apps_call_to_action', 'apps_call_to_action_func');
}