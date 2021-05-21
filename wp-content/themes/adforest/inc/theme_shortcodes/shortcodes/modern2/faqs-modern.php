<?php
/* ------------------------------------------------ */
/* land_faqs_modern */
/* ------------------------------------------------ */
if (!function_exists('land_faqs_modern_shortcodeBase')) {
function land_faqs_modern_shortcodeBase() {
	vc_map( array(
		'name' => __( "FAQ's - Modern", 'adforest' ),
		'base' => 'land_faqs_modern',
		'show_settings_on_create' => true,
		'category' => __( 'Theme Shortcodes - 2', 'adforest'),
		'params' => array(
		
		array(
		   'group' => __( 'Shortcode Output', 'adforest' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'adforest' ),
		   'param_name' => 'order_field_key',
		   'description' => adforest_VCImage('land-faqs.png').__( 'Ouput of the shortcode will be look like this.', 'adforest' ),
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
					'heading' => __( 'Title', 'adforest' ),
					'param_name' => 'title',
				),
				array(
					'type' => 'textarea',
					'holder' => 'div',
					'class' => '',
					'admin_label' => true,
					'heading' => __( 'Description', 'adforest' ),
					'param_name' => 'desc',
				),				

			)
		),	
		)
	) );
}
}
add_action( 'vc_before_init', 'land_faqs_modern_shortcodeBase' );
if (!function_exists('land_faqs_modern_func')) {
function land_faqs_modern_func($atts, $content = '') {
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
		
		$section_bg_class = ( $section_bg == 'gray' ) ? 'gray' : '';

		$points	=	false;
		$points_html	=	'';
		
		if( isset( $atts['points'] ) )
		{
			$points_rows = vc_param_group_parse_atts( $atts['points'] );
			if( count( $points_rows ) > 0 )
			{
				$inner_html = '';
				$counter = 1;
				foreach($points_rows as $row )
				{
					if( isset( $row['title'] )  )
					{
						$unique_id = rand(11111, 999999) . $counter .''. time();						
						$inner_html .= '<div class="land-body-panel">
								  <div class="panel panel-default">
									<div class="panel-heading" role="tab" id="heading-'.$unique_id.'">
									  <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-'.$unique_id.'" aria-expanded="true" aria-controls="collapseOne"> <i class="more-less glyphicon glyphicon-plus"></i> '.esc_html($row['title']).' </a> </h4>
									</div>
									<div id="collapse-'.$unique_id.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-'.$unique_id.'">
									  <div class="panel-body">'.esc_html($row['desc']).'</div>
									</div>
								  </div>
								</div>';
						$counter++;
						
					}
				}
				$points_html = ($inner_html != "" ) ? '<ul class="list-inline">'.$inner_html.'</ul>' : '';
			}		
		}

		$output = 	'<section class="land-fa-qs '.$section_bg_class.'">
					  <div class="container">
						<div class="row">
						  <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6">
						  <div class="land-qs-heading-section"><h3>'.$section_title_html.'</h3></div>
						  <div class="land-qs-text-section"><h5><strong>'.$main_quote_html.'</strong></h5></div>
							<div class="land-qs-text-section">'.$section_desc_html.'</div>
							<div class="demo"><div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">'.$points_html.'</div></div>
						  </div>
						  <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6">
							<div class="land-fa-qs-image"><img src="'.esc_url($side_bg_url).'" class="img-responsive" alt="'.esc_attr('image','adforest').'">  </div>
						  </div>
						</div>
					  </div>
					</section>';
		return $output;
}
}
if (function_exists('adforest_add_code'))
{
	adforest_add_code('land_faqs_modern', 'land_faqs_modern_func');
}