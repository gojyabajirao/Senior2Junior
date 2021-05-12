<?php
/* ------------------------------------------------ */
/* success_stories_2 */
/* ------------------------------------------------ */
add_action( 'vc_before_init', 'adforest_success_stories_2_shortcode' );
if ( !function_exists ( 'adforest_success_stories_2_shortcode' ) ) {
function adforest_success_stories_2_shortcode() {
	vc_map( array(
		'name' => __( 'Success Stories 2', 'adforest' ),
		'description' => __( 'Select categories with icons and background images.', 'adforest' ),
		'base' => 'success_stories_2',
		'show_settings_on_create' => true,
		'category' => __( 'Theme Shortcodes - 2', 'adforest'),
		'params' => array(
		
		array(
		   'group' => __( 'Shortcode Output', 'adforest' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'adforest' ),
		   'param_name' => 'order_field_key',
		   'description' => adforest_VCImage('wedd-success-stories.png').__( 'Ouput of the shortcode will be look like this.', 'adforest' ),
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
				"type" => "dropdown",
				"heading" => __("Header Style", 'adforest') ,
				"param_name" => "header_style",
				"admin_label" => true,
				"value" => array(
				__('Section Header Style', 'adforest') => '',
				__('No Header', 'adforest') => '',
				__('Classic', 'adforest') => 'classic',
				__('Regular', 'adforest') => 'regular'
				) ,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				"std" => '',
				"description" => __("Chose header style.", 'adforest'),
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
				'dependency' => array(
				'element' => 'header_style',
				'value' => array('classic'),
				) ,
			),	
			array(
				"group" => __("Basic", "adforest"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Section Title", 'adforest' ),
				"param_name" => "section_title_regular",
				"value" => "",
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'dependency' => array(
				'element' => 'header_style',
				'value' => array('regular'),
				) ,
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
				
		array
		(
			'group' => __( 'Success Stories', 'adforest' ),
			'type' => 'param_group',
			'heading' => __( 'Client Success Stories.', 'adforest' ),
			'param_name' => 'partners',
			'params' => array
			(

				array(
					"type" => "textfield",
					"holder" => "div",
					"heading" => __( "Partner 1 Name", 'adforest' ),
					"param_name" => "p1name",
					"value" => "",
				),	
				array(
					"type" => "textfield",
					"holder" => "div",
					"heading" => __( "Partner 1 Subline", 'adforest' ),
					"param_name" => "p1subline",
					"value" => "",
				),	
				array(
					"type" => "textarea",
					"holder" => "div",
					"heading" => __( "Partner 1 Description", 'adforest' ),
					"param_name" => "p1desc",
					"value" => "",
				),						
				array(
					"type" => "attach_image",
					"holder" => "div",
					"heading" => __( "Image", 'adforest' ),
					"param_name" => "img",
				),	

				array(
					"type" => "textfield",
					"holder" => "div",
					"heading" => __( "Partner 2 Name", 'adforest' ),
					"param_name" => "p2name",
					"value" => "",
				),	
				array(
					"type" => "textfield",
					"holder" => "div",
					"heading" => __( "Partner 2 Subline", 'adforest' ),
					"param_name" => "p2subline",
					"value" => "",
				),	
				array(
					"type" => "textarea",
					"holder" => "div",
					"heading" => __( "Partner 2 Description", 'adforest' ),
					"param_name" => "p2desc",
					"value" => "",
				),				  							

			)
		),			
		)
	) );
}
}

if ( !function_exists ( 'adforest_success_stories_2_func' ) )
{
	function adforest_success_stories_2_func($atts, $content = '')
	{
		
		require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
		extract( shortcode_atts( array( 'partners' => '', ), $atts ));

		$partners_html	=	'';
		if( isset( $atts['partners'] ) )
		{
			$rows = vc_param_group_parse_atts( $atts['partners'] );
			if( count( (array)$rows ) > 0 )
			{
				foreach($rows as $row )
				{
					if( isset( $row['p2name'] )  && isset( $row['p1name'] ) && isset( $row['img'] ) )
					{
						
						$p1name = $row['p1name'];
						$p2name = $row['p2name'];
						$img 	= adforest_returnImgSrc( $row['img'] );
						
						$p1subline 	= ( isset( $row['p1subline'] ) ) ? $row['p1subline'] : '';
						$p2subline 	= ( isset( $row['p2subline'] ) ) ? $row['p2subline'] : '';
						$p1desc 	= ( isset( $row['p1desc'] ) ) 	 ? $row['p1desc'] : '';
						$p2desc 	= ( isset( $row['p2desc'] ) ) 	 ? $row['p2desc'] : '';
						
						$partners_html	.=	'<div class="item">
							<div class="col-lg-4 col-xs-12 col-sm-12 col-md-4">
							  <div class="mat-candidates-details">
								<div class="mat-candidate-name"><h5>'.esc_html($p1name).'</h5></div>
								<div class="mat-new-candidates-categories"><p>'.esc_html($p1subline).'</p></div>
								<div class="mat-candidates-full-details"><p>'.$p1desc.'</p></div>
							  </div>
							</div>
							<div class="col-lg-4 col-xs-12 col-sm-12 col-md-4">
							  <div class="mat-new-categories-section"> <img src="'.esc_url($img).'" class="img-responsive"  alt="'. esc_html__('image','adforest').'"> </div>
							</div>
							<div class="col-lg-4 col-xs-12 col-md-4 col-sm-12">
							  <div class="mat-candidates-title-section">
								<div class="mat-candidates-details">
								  <div class="mat-candidate-name"><h5>'.esc_html($p2name).'</h5></div>
								  <div class="mat-new-candidates-categories"><p>'.esc_html($p2subline).'</p></div>
								  <div class="mat-candidates-full-details"><p>'.$p2desc.'</p></div>
								</div>
							  </div>
							</div>
						  </div>';
					}
				}
			}
		}
		
		return '<section class="mat-success-stories '.$section_bg.'"><div class="container"><div class="row"><div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">'.$header.' </div><div class="col-lg-12 col-sm-12 col-xs-12 col-md-12"><div class="success-stories-2 owl-carousel owl-theme">'.$partners_html.'</div></div></div></div></section>';
		
	
	}
}
if (function_exists('adforest_add_code'))
{
	adforest_add_code('success_stories_2', 'adforest_success_stories_2_func');
}