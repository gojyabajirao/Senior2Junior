<?php

if (!class_exists('ads')) {

    class ads {

// user object
        var $obj;

        public function __construct() {
            
        }

        function adforest_get_ads_grid($args, $paged, $show_pagination = 0, $fav_ads) {
            $my_ads = '';
            global $adforest_theme;
            
            if($fav_ads == 'expired_sold'){
              // $fav_ads = 'no'; 
            }
            
            $sb_post_ad_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_post_ad_page']);
            $cols = 4;
            if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern')
                $cols = 4;

            $flip_it = '';
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }
            $args = apply_filters('adforest_wpml_show_all_posts', $args);
            $args = apply_filters('adforest_site_location_ads', $args, 'ads');
            $ads = new WP_Query($args);
            if ($ads->have_posts()) {
                $number = 0;
                $remove = '';
                while ($ads->have_posts()) {
                    $ads->the_post();

                    $pid = get_the_ID();
                    $status = get_post_meta(get_the_ID(), '_adforest_ad_status_', true);
                    $status = adforest_ad_statues($status);

                    if ($status == '') {
                        $status = adforest_ad_statues('active');
                    }
                    $cats_html = adforest_display_cats($pid);
                    $messages = '';
                    if ($fav_ads == 'no' || 'expired_sold' == $fav_ads || $fav_ads == 'featured_ads' ) {
                        if ($adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'message') {


                            $messages = '<div class="notification msgs get_msgs" ad_msg=' . $pid . '>
                                    <a class="round-btn" href="javascript:void(0);"><i class="fa fa-envelope-o"></i></a>
                                    <span>' . $this->adforest_count_ad_messages($pid) . '</span>
                     </div>';
                        }
                    }


                    $add_ons = '';
                    if ($fav_ads == 'no' || 'expired_sold' == $fav_ads || $fav_ads == 'featured_ads' ) {
                        $ad_featured = '<a class="btn btn-sm btn-info" href="javascript:void(0);">' . __('Featured', 'adforest') . '</a>';
                        if (get_post_meta($pid, '_adforest_is_feature', true) != '1') {
                            $ad_featured = '<a class="btn btn-sm btn-info sb_anchor sb_make_feature_ad" href="javascript:void(0);" data-btn-ok-label="' . __('Yes', 'adforest') . '" data-btn-cancel-label="' . __('No', 'adforest') . '" data-toggle="confirmation" data-singleton="true" data-title="' . __('Are you sure?', 'adforest') . '" data-content="" data-aaa-id="' . esc_attr($pid) . '">' . __('Mark featured', 'adforest') . '</a>';
                        }

                        $add_ons = '<div class="bump-or-feature">
								' . $ad_featured . '
			<a class="btn btn-sm btn-blue bump_it_up" href="javascript:void(0);" data-btn-ok-label="' . __('Yes', 'adforest') . '" data-btn-cancel-label="' . __('No', 'adforest') . '" data-toggle="confirmation" data-singleton="true" data-title="' . __('Are you sure?', 'adforest') . '" data-content="" data-aaa-id="' . esc_attr($pid) . '">' . __('Bump up', 'adforest') . '</a>
			</div>';
                    }


                    $outer_html = '';
                    $media = adforest_get_ad_images($pid);
                    if (count($media) > 0) {
                        $counting = 1;
                        foreach ($media as $m) {
                            if ($counting > 1)
                                break;

                            $mid = '';
                            if (isset($m->ID))
                                $mid = $m->ID;
                            else
                                $mid = $m;
                            $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                            $outer_html = '<div class="image"><div class="ribbon ' . adforest_ads_status_color(get_post_meta(get_the_ID(), '_adforest_ad_status_', true)) . '" id="status-dyn-' . get_the_ID() . '">' . $status . '</div>
				<img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive"></div>';
                            $counting++;
                        }
                    }
                    else {
                        $outer_html = '<div class="image"><div class="ribbon ' . adforest_ads_status_color(get_post_meta(get_the_ID(), '_adforest_ad_status_', true)) . '" id="status-dyn-' . get_the_ID() . '">' . $status . '</div>
					<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-responsive"></div>';
                    }

                   if ($fav_ads == 'no' || 'expired_sold' == $fav_ads || $fav_ads == 'featured_ads' ) {

                        $ad_status = '<select class="ad_status category form-control"  adid="' . get_the_ID() . '"><option value="">' . __('Post Status', 'adforest') . '</option>';
                        if (get_post_meta(get_the_ID(), '_adforest_ad_status_', true) == 'expired') {
                            $ad_status .= '<option value="expired" selected>' . adforest_ad_statues('expired') . '</option>';
                        } else {
                            $ad_status .= '<option value="expired">' . adforest_ad_statues('expired') . '</option>';
                        }
                        if (get_post_meta(get_the_ID(), '_adforest_ad_status_', true) == 'sold') {
                            $ad_status .= '<option value="sold" selected>' . adforest_ad_statues('sold') . '</option>';
                        } else {
                            $ad_status .= '<option value="sold">' . adforest_ad_statues('sold') . '</option>';
                        }
                        if (get_post_meta(get_the_ID(), '_adforest_ad_status_', true) == 'active') {
                            $ad_status .= '<option value="active" selected>' . adforest_ad_statues('active') . '</option>';
                        } else {
                            $ad_status .= '<option value="active">' . adforest_ad_statues('active') . '</option>';
                        }
                        $ad_status .= '</select>';

                        $my_url = adforest_get_current_url();
                        if (strpos($my_url, 'adforest.scriptsbundle.com') !== false) {
                            $edit = '<li><a data-toggle="tooltip" data-placement="top" data-original-title="' . __('Edit Disable for Demo', 'adforest') . '" href="javascript:void(0);"><i class="fa fa-pencil edit"></i></a> </li>';
                        } else {
                            $edit = '<li><a data-toggle="tooltip" data-placement="top" title="' . __('Edit this Ad', 'adforest') . '" data-original-title="' . __('Edit this Ad', 'adforest') . '" href="' . get_the_permalink($sb_post_ad_page) . '?id=' . get_the_ID() . '"><i class="fa fa-pencil edit"></i></a> </li>';
                        }

                        if (strpos($my_url, 'adforest.scriptsbundle.com') !== false) {
                            $delete = '<li>
									   <a  href="javascript:void(0);"  data-toggle="tooltip" data-placement="top" title="' . __('Delete Disable for Demo', 'adforest') . '" data-original-title="' . __('Delete Disable for Demo', 'adforest') . '"  >
									   <i class="fa fa-times delete"></i>
									   </a>
									   </li>';
                        } else {
                            $delete = '<li>
									   <a  href="javascript:void(0);" data-adid="' . get_the_ID() . '" class="remove_ad" data-btn-ok-label="' . __('Yes', 'adforest') . '" data-btn-cancel-label="' . __('No', 'adforest') . '" data-toggle="confirmation" data-singleton="true" data-title="' . __('Are you sure?', 'adforest') . '" data-content=""  >
									   <i class="fa fa-times delete"></i>
									   </a>
									   </li>';
                        }
                    } else {
                        $my_url = adforest_get_current_url();
                        if (strpos($my_url, 'adforest.scriptsbundle.com') !== false) {
                            $remove = '<li style="margin-right:39px;">
                                            <a  href="javascript:void(0);"  data-toggle="tooltip" data-placement="top" title="' . __('Delete Disable for Demo', 'adforest') . '" data-original-title="' . __('Delete Disable for Demo', 'adforest') . '"  >
                                            <i class="fa fa-times delete"></i>
                                            </a>
                                       </li><li></li>';
                        } else {
                            $remove = '<li style="margin-right:39px;">
                                            <a data-btn-ok-label="' . __('Yes', 'adforest') . '" data-btn-cancel-label="' . __('No', 'adforest') . '"  data-toggle="confirmation" data-singleton="true" data-title="' . __('Are you sure?', 'adforest') . '" data-content="" href="javascript:void(0);" data-adid="' . get_the_ID() . '" class="remove_fav_ad" >
                                            <i class="fa fa-times delete"></i>
                                            </a>
					</li><li></li>';
                        }
                    }

                    $my_ads .= '<div class="col-md-' . esc_attr($cols) . ' col-lg-' . esc_attr($cols) . ' col-sm-6 col-xs-12" id="holder-' . get_the_ID() . '">
						  <div class="white category-grid-box-1 ">
						  ' . adforest_video_icon() . '
							 <!-- Image Box -->
									 ' . $outer_html . '
							 <!-- Short Description -->
							 <div class="short-description-1 ">
							 	' . $messages . '
								<!-- Category Title -->
								<div class="category-title"> ' . $cats_html . ' </div>
								<!-- Ad Title -->
								<h2>
								   <a title="' . get_the_title() . '" href="' . get_the_permalink() . '">' . get_the_title() . '</a>
								</h2>
								<!-- Location -->
								<p class="location"><i class="fa fa-map-marker"></i> ' . get_post_meta(get_the_ID(), '_adforest_ad_location', true) . '</p>
									   

								 <!-- Price -->
								 
								 <span class="ad-price">' . adforest_adPrice(get_the_ID()) . '</span> 
								 ' . $ad_status . '
								 ' . $add_ons . '
							 </div>
							 <!-- Ad Meta Stats -->
							 <div class="ad-info-1">
								<ul class="pull-left ' . esc_attr($flip_it) . '">
								   <li> <i class="fa fa-eye"></i><a href="javascript:void(0);">' . adforest_getPostViews(get_the_ID()) . '</a> </li>
								   <li> <i class="fa fa-clock-o"></i>' . get_the_date(get_option('date_format'), get_the_ID()) . '</li>
								</ul>
								<ul class="pull-right ' . esc_attr($flip_it) . '">
								   ' . $delete . '
								   ' . $edit . '
								   ' . $remove . '
								</ul>
							 </div>
						  </div>
					   </div>';
                }
                wp_reset_postdata();
            } else {
                $my_ads = get_template_part('template-parts/content', 'none');
            }
            $load_more = '';
            if ($show_pagination == 1) {
                $load_more = $this->adforest_get_pages($paged, $ads->max_num_pages, $fav_ads);
            }

            return '
       <!-- Row -->
       <div class="row">
          <!-- Middle Content Area -->
          <div class="col-md-12 col-sm-12 col-xs-12">
             <!-- Row -->
             <div class="row">
                <!-- Sorting Filters -->
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                   <!-- Sorting Filters Breadcrumb -->
                   <!-- Sorting Filters Breadcrumb End -->
                </div>
                <!-- Sorting Filters End-->
                <div class="clearfix"></div>
                <!-- Ads Archive 3 -->
                <div class="posts-masonry">
					' . $my_ads . '                   
                </div>
                <!-- Ads Archive End -->  
                <div class="clearfix"></div>
                <!-- Pagination -->  
                <div class="col-md-12 col-xs-12 col-sm-12">
                   ' . $load_more . '
                </div>
                <!-- Pagination End -->   
             </div>
             <!-- Row End -->
          </div>
          <!-- Middle Content Area  End -->
       </div>
       <!-- Row End -->
	<input type="hidden" id="max_pages" value="' . $ads->max_num_pages . '" />';
        }

        function adforest_get_ads_grid_inactive($args, $paged, $show_pagination = 0, $fav_ads) {
            $my_ads = '';
            global $adforest_theme;

            $flip_it = '';
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }
            $args = apply_filters('adforest_wpml_show_all_posts', $args);
            $args = apply_filters('adforest_site_location_ads', $args, 'ads');
            $ads = new WP_Query($args);
            if ($ads->have_posts()) {
                $number = 0;
                while ($ads->have_posts()) {
                    $ads->the_post();

                    $pid = get_the_ID();
                    $status = get_post_meta(get_the_ID(), '_adforest_ad_status_', true);
                    $status = adforest_ad_statues($status);

                    if ($status == '') {
                        $status = adforest_ad_statues('active');
                    }
                    $cats_html = adforest_display_cats($pid);
                    $messages = '';
                    if ($fav_ads == 'no') {
                        if ($adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'message') {

                            $messages = '<div class="message-box get_msgs" ad_msg=' . $pid . '>
						<div class="message"><span>
							<i class="fa fa-envelope"></i><small>' . $this->adforest_count_ad_messages($pid) . '</small>
							</span></div>
						</div>';
                        }
                    }

                    $outer_html = '';
                    $media = adforest_get_ad_images($pid);
                    if (count($media) > 0) {
                        $counting = 1;
                        foreach ($media as $m) {
                            if ($counting > 1)
                                break;

                            $mid = '';
                            if (isset($m->ID))
                                $mid = $m->ID;
                            else
                                $mid = $m;
                            $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                            $outer_html = '<div class="image">
				<img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive"> ' . $messages . '
				</div>';
                            $counting++;
                        }
                    }
                    else {
                        $outer_html = '<div class="image">
					<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-responsive">
                                       ' . $messages . '
					</div>';
                    }

                    $my_ads .= '<div class="col-md-4 col-lg-4 col-sm-6 col-xs-12" id="holder-' . get_the_ID() . '">
						  <div class="white category-grid-box-1 ">
							 <!-- Image Box -->
									 ' . $outer_html . '
							 <!-- Short Description -->
							 <div class="short-description-1 ">
								<!-- Category Title -->
								<div class="category-title"> ' . $cats_html . ' </div>
								<!-- Ad Title -->
								<h2>
								   <a title="' . get_the_title() . '<" href="' . get_the_permalink() . '">' . get_the_title() . '</a>
								</h2>
								<!-- Location -->
								<p class="location"><i class="fa fa-map-marker"></i> ' . get_post_meta(get_the_ID(), '_adforest_ad_location', true) . '</p>
								<div class="rating">
                                       <span class="rating-count">
									   ' . $ad_status . '
									   </span>
                                      
                                    </div>

								 <!-- Price -->
								 
								 <span class="ad-price">' . adforest_adPrice(get_the_ID()) . '</span> 
							 </div>
							 <!-- Ad Meta Stats -->
							 <div class="ad-info-1">
								<ul class="pull-left ' . esc_attr($flip_it) . '">
								   <li> <i class="fa fa-eye"></i><a href="javascript:void(0);">' . adforest_getPostViews(get_the_ID()) . ' ' . __('Views', 'adforest') . '</a> </li>
								   <li> <i class="fa fa-clock-o"></i>' . get_the_date(get_option('date_format'), get_the_ID()) . '</li>
								</ul>
								<ul class="pull-right ' . esc_attr($flip_it) . '">
								</ul>
							 </div>
						  </div>
					   </div>';
                }
                wp_reset_postdata();
            } else {
                $my_ads = get_template_part('template-parts/content', 'none');
                return '';
            }
            $load_more = '';
            if ($show_pagination == 1) {
                $load_more = $this->adforest_get_pages($paged, $ads->max_num_pages, $fav_ads);
            }

            return '
          <!-- Middle Content Area -->
          <div class="col-md-12 col-sm-12 col-xs-12">
		  <div class="row">
	   <div role="alert" class="alert alert-info alert-dismissible ' . adforest_alert_type() . '">
<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&#10005;</span></button>
<strong>' . __('Info', 'adforest') . '</strong> - 
' . __('Waiting for admin approval.', 'adforest') . '
             </div>
             <!-- Row -->
             <div class="row">
                <!-- Sorting Filters -->
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                   <!-- Sorting Filters Breadcrumb -->
                   <!-- Sorting Filters Breadcrumb End -->
                </div>
                <!-- Sorting Filters End-->
                <div class="clearfix"></div>
                <!-- Ads Archive 4 -->
                <div class="posts-masonry">
					' . $my_ads . '                   
                </div>
                <!-- Ads Archive End -->  
                <div class="clearfix"></div>
                <!-- Pagination -->  
                <div class="col-md-12 col-xs-12 col-sm-12">
                   ' . $load_more . '
                </div>
                <!-- Pagination End -->   
             </div>
             <!-- Row End -->
          </div>
          <!-- Middle Content Area  End -->
       </div>
       <!-- Row End -->
	<input type="hidden" id="max_pages" value="' . $ads->max_num_pages . '" />';
        }

        function adforest_get_ads_grid_rejected($args, $paged, $show_pagination = 0, $fav_ads) {
            $my_ads = '';
            global $adforest_theme;

            $flip_it = '';
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }
            $args = apply_filters('adforest_wpml_show_all_posts', $args);
            $args = apply_filters('adforest_site_location_ads', $args, 'ads');
            $ads = new WP_Query($args);
            if ($ads->have_posts()) {
                $number = 0;
                while ($ads->have_posts()) {
                    $ads->the_post();

                    $pid = get_the_ID();
                    $status = get_post_meta(get_the_ID(), '_adforest_ad_status_', true);
                    $status = adforest_ad_statues($status);

                    if ($status == '') {
                        $status = adforest_ad_statues('active');
                    }
                    $cats_html = adforest_display_cats($pid);
                    $messages = '';
                    
                    
                   
                        $my_url = adforest_get_current_url();
                        if (strpos($my_url, 'adforest.scriptsbundle.com') !== false) {
                            $edit = '<li><a data-toggle="tooltip" data-placement="top" data-original-title="' . __('Edit Disable for Demo', 'adforest') . '" href="javascript:void(0);"><i class="fa fa-pencil edit"></i></a> </li>';
                        } else {
                            $edit = '<li><a data-toggle="tooltip" data-placement="top" title="' . __('Edit this Ad', 'adforest') . '" data-original-title="' . __('Edit this Ad', 'adforest') . '" href="' . get_the_permalink($sb_post_ad_page) . '?id=' . get_the_ID() . '"><i class="fa fa-pencil edit"></i></a> </li>';
                        }

                        if (strpos($my_url, 'adforest.scriptsbundle.com') !== false) {
                            $delete = '<li>
									   <a  href="javascript:void(0);"  data-toggle="tooltip" data-placement="top" title="' . __('Delete Disable for Demo', 'adforest') . '" data-original-title="' . __('Delete Disable for Demo', 'adforest') . '"  >
									   <i class="fa fa-times delete"></i>
									   </a>
									   </li>';
                        } else {
                            $delete = '<li>
									   <a  href="javascript:void(0);" data-adid="' . get_the_ID() . '" class="remove_ad" data-btn-ok-label="' . __('Yes', 'adforest') . '" data-btn-cancel-label="' . __('No', 'adforest') . '" data-toggle="confirmation" data-singleton="true" data-title="' . __('Are you sure?', 'adforest') . '" data-content=""  >
									   <i class="fa fa-times delete"></i>
									   </a>
									   </li>';
                        }
                    

                    $outer_html = '';
                    $media = adforest_get_ad_images($pid);
                    if (count($media) > 0) {
                        $counting = 1;
                        foreach ($media as $m) {
                            if ($counting > 1)
                                break;

                            $mid = '';
                            if (isset($m->ID))
                                $mid = $m->ID;
                            else
                                $mid = $m;
                            $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                            $outer_html = '<div class="image">
				<img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive"> ' . $messages . '
				</div>';
                            $counting++;
                        }
                    }
                    else {
                        $outer_html = '<div class="image">
					<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-responsive">
                                       ' . $messages . '
					</div>';
                    }

                    $my_ads .= '<div class="col-md-4 col-lg-4 col-sm-6 col-xs-12" id="holder-' . get_the_ID() . '">
						  <div class="white category-grid-box-1 ">
							 <!-- Image Box -->
									 ' . $outer_html . '
							 <!-- Short Description -->
							 <div class="short-description-1 ">
								<!-- Category Title -->
								<div class="category-title"> ' . $cats_html . ' </div>
								<!-- Ad Title -->
								<h2>
								   <a title="' . get_the_title() . '<" href="' . get_the_permalink() . '">' . get_the_title() . '</a>
								</h2>
								<!-- Location -->
								<p class="location"><i class="fa fa-map-marker"></i> ' . get_post_meta(get_the_ID(), '_adforest_ad_location', true) . '</p>
								<div class="rating">
                                       <span class="rating-count">
									   ' . $ad_status . '
									   </span>
                                      
                                    </div>

								 <!-- Price -->
								 
								 <span class="ad-price">' . adforest_adPrice(get_the_ID()) . '</span> 
							 </div>
							 <!-- Ad Meta Stats -->
							 <div class="ad-info-1">
								<ul class="pull-left ' . esc_attr($flip_it) . '">
								   <li> <i class="fa fa-eye"></i><a href="javascript:void(0);">' . adforest_getPostViews(get_the_ID()) . ' ' . __('Views', 'adforest') . '</a> </li>
								   <li> <i class="fa fa-clock-o"></i>' . get_the_date(get_option('date_format'), get_the_ID()) . '</li>
                                                                   
                                                                    '.$delete.'  
                                                                        '.$edit.'
								</ul>
								<ul class="pull-right ' . esc_attr($flip_it) . '">
								</ul>
							 </div>
						  </div>
					   </div>';
                }
                wp_reset_postdata();
            } else {
                $my_ads = get_template_part('template-parts/content', 'none');
                return '';
            }
            $load_more = '';
            if ($show_pagination == 1) {
                $load_more = $this->adforest_get_pages($paged, $ads->max_num_pages, $fav_ads);
            }

            return '
          <!-- Middle Content Area -->
          <div class="col-md-12 col-sm-12 col-xs-12">
		  
	   
             <!-- Row -->
             <div class="row">
                <!-- Sorting Filters -->
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                   <!-- Sorting Filters Breadcrumb -->
                   <!-- Sorting Filters Breadcrumb End -->
                </div>
                <!-- Sorting Filters End-->
                <div class="clearfix"></div>
                <!-- Ads Archive 4 -->
                <div class="posts-masonry">
					' . $my_ads . '                   
                </div>
                <!-- Ads Archive End -->  
                <div class="clearfix"></div>
                <!-- Pagination -->  
                <div class="col-md-12 col-xs-12 col-sm-12">
                   ' . $load_more . '
                </div>
                <!-- Pagination End -->   
             </div>
             <!-- Row End -->
          
          <!-- Middle Content Area  End -->
       </div>
       <!-- Row End -->
	<input type="hidden" id="max_pages" value="' . $ads->max_num_pages . '" />';
        }

        function adforest_get_featured_ads_grid($args, $paged, $show_pagination = 0, $fav_ads) {
            $my_ads = '';
            global $adforest_theme;

            $colors = array('active' => 'status_active', 'expired' => 'status_expired', 'sold' => 'status_sold');

            $flip_it = '';
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }

            $args = apply_filters('adforest_wpml_show_all_posts', $args);
            $args = apply_filters('adforest_site_location_ads', $args, 'ads');
            $ads = new WP_Query($args);
            if ($ads->have_posts()) {
                $number = 0;
                while ($ads->have_posts()) {
                    $ads->the_post();

                    $pid = get_the_ID();

                    adforest_display_cats($pid);
                    $messages = '';
                    if ($fav_ads == 'no') {
                        if ($adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'message') {

                            $messages = '<div class="notification msgs get_msgs" ad_msg=' . $pid . '>
                                    <a class="round-btn" href="javascript:void(0);"><i class="fa fa-envelope-o"></i></a>
                                    <span>' . $this->adforest_count_ad_messages($pid) . '</span>
                     </div>';
                        }
                    }

                    $timer_html = '';
                    $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
                    if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                        $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
                    }
                    $outer_html = '';
                    $media = adforest_get_ad_images($pid);
                    if (count($media) > 0) {
                        $counting = 1;
                        foreach ($media as $m) {
                            if ($counting > 1)
                                break;

                            $mid = '';
                            if (isset($m->ID))
                                $mid = $m->ID;
                            else
                                $mid = $m;
                            $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');

                            $outer_html = '<div class="image">
				' . $timer_html . '
				<img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive"></div>';
                            $counting++;
                        }
                    }
                    else {
                        $outer_html = '<div class="image">
			' . $timer_html . '
					<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-responsive">
					</div>';
                    }
                    if ($fav_ads == 'no') {
                        $edit = '<li>
								   <a data-toggle="tooltip" data-placement="top" title="' . __('Edit this Ad', 'adforest') . '" data-original-title="' . __('Edit this Ad', 'adforest') . '" href="' . get_the_permalink($sb_post_ad_page) . '?id=' . get_the_ID() . '"><i class="fa fa-pencil edit"></i></a> 
								   </li>';
                        $delete = '<li>
								   <a  href="javascript:void(0);" data-adid="' . get_the_ID() . '" class="remove_ad" data-btn-ok-label="' . __('Yes', 'adforest') . '" data-btn-cancel-label="' . __('No', 'adforest') . '" data-toggle="confirmation" data-singleton="true" data-title="' . __('Are you sure?', 'adforest') . '" data-content=""  >
								   <i class="fa fa-times delete"></i>
								   </a>
				
				
								   </li>';
                    }

                    $is_feature = '';
                    if (get_post_meta($pid, '_adforest_is_feature', true) == '1') {
                        $is_feature = '<div class="' . esc_attr($ribbion) . '">
			  <span>' . __('Featured', 'adforest') . '</span>
		   </div>';
                    }


                    $my_ads .= '<div class="col-md-4 col-lg-4 col-sm-6 col-xs-12" id="holder-' . get_the_ID() . '">
						  <div class="white category-grid-box-1 ">
						  ' . adforest_video_icon() . '
							 <!-- Image Box -->
							 ' . $is_feature . '
									 ' . $outer_html . '
							 <!-- Short Description -->
							 <div class="short-description-1 ">
							 ' . $messages . '
								<!-- Category Title -->
								<div class="category-title"> ' . $cats_html . ' </div>
								<!-- Ad Title -->
								<h2>
								   <a title="javascript:void(0);" href="' . get_the_permalink() . '">' . get_the_title() . '</a>
								</h2>
								<!-- Location -->
								<p class="location"><i class="fa fa-map-marker"></i> ' . get_post_meta(get_the_ID(), '_adforest_ad_location', true) . '</p>
								<div class="rating">
                                       <span class="rating-count">
									   ' . $ad_status . '
									   </span>
                                      
                                    </div>

								 <!-- Price -->
								 
								 <span class="ad-price">' . adforest_adPrice(get_the_ID()) . '</span> 
							 </div>
							 <!-- Ad Meta Stats -->
							 <div class="ad-info-1">
								<ul class="pull-left ' . esc_attr($flip_it) . '">
								   <li> <i class="fa fa-eye"></i><a href="javascript:void(0);">' . adforest_getPostViews(get_the_ID()) . ' ' . __('Views', 'adforest') . '</a> </li>
								   <li> <i class="fa fa-clock-o"></i>' . get_the_date(get_option('date_format'), get_the_ID()) . '</li>
								</ul>
								<ul class="pull-right ' . esc_attr($flip_it) . '">
								   ' . $delete . '
								   ' . $edit . '
								   ' . $remove . '
								</ul>
							 </div>
						  </div>
					   </div>';
                }
                wp_reset_postdata();
            } else {
                $my_ads = get_template_part('template-parts/content', 'none');
            }
            $load_more = '';
            if ($show_pagination == 1) {
                $load_more = $this->adforest_get_pages($paged, $ads->max_num_pages, $fav_ads);
            }

            return '<div class="row">
          <!-- Middle Content Area -->
          <div class="col-md-12 col-sm-12 col-xs-12">
             <!-- Row -->
             <div class="row">
                <!-- Sorting Filters -->
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                   <!-- Sorting Filters Breadcrumb -->
                   <!-- Sorting Filters Breadcrumb End -->
                </div>
                <!-- Sorting Filters End-->
                <div class="clearfix"></div>
                <!-- Ads Archive 5 -->
                <div class="posts-masonry">
					' . $my_ads . '                   
                </div>
                <!-- Ads Archive End -->  
                <div class="clearfix"></div>
                <!-- Pagination -->  
                <div class="col-md-12 col-xs-12 col-sm-12">
                   ' . $load_more . '
                </div>
                <!-- Pagination End -->   
             </div>
             <!-- Row End -->
          </div>
          <!-- Middle Content Area  End -->
       </div>
       <!-- Row End -->
	<input type="hidden" id="max_pages" value="' . $ads->max_num_pages . '" />';
        }

        function adforest_get_ads_grid_slider($args, $title, $col = 12, $css_class = '') {

            $my_ads = '';
            global $adforest_theme;

            $flip_it = '';
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }
            $args = apply_filters('adforest_wpml_show_all_posts', $args);
            $args = apply_filters('adforest_site_location_ads', $args, 'ads');

            $ads = new WP_Query($args);
            $no_padding = '';
            if ($ads->have_posts()) {
                $number = 0;
                $grid_type = 'grid_1';
                if (isset($adforest_theme['featured_ad_slider_layout']) && $adforest_theme['featured_ad_slider_layout'] != "") {
                    $grid_type = $adforest_theme['featured_ad_slider_layout'];
                }

                while ($ads->have_posts()) {

                    $ads->the_post();

                    $pid = get_the_ID();
                    $function = "adforest_search_layout_$grid_type";

                    $my_ads .= '<div class="item">';
                    $my_ads .= $this->$function($pid, 12, 12);
                    $my_ads .= '</div>';
                    continue;
                    $cats_html = adforest_display_cats($pid);

                    $timer_html = '';
                    $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
                    if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                        $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
                    }
                    $outer_html = '';
                    $media = adforest_get_ad_images($pid);
                    if (count($media) > 0) {
                        $counting = 1;
                        foreach ($media as $m) {
                            if ($counting > 1)
                                break;

                            $mid = '';
                            if (isset($m->ID))
                                $mid = $m->ID;
                            else
                                $mid = $m;
                            $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                            $outer_html = '<div class="image">
				' . $timer_html . '
				<a href="' . get_the_permalink() . '"><img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive"></a>
				</div>';
                            $counting++;
                        }
                    }
                    else {
                        $outer_html = '<div class="image">
			' . $timer_html . '
					<a href="' . get_the_permalink() . '"><img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-responsive"></a>
					</div>';
                    }
                    $is_feature = '';
                    if (get_post_meta($pid, '_adforest_is_feature', true) == '1') {
                        $is_feature = '<div class="' . esc_attr($ribbion) . '"><span>' . __('Featured', 'adforest') . '</span></div>';
                    }
                    $save_ad = '';
                    if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern') {
                        
                    } else {
                        $save_ad = '<ul class="pull-right ' . esc_attr($flip_it) . '"><li><a data-toggle="tooltip" data-placement="top" data-original-title="' . __('Saved Ad', 'adforest') . '" href="javascript:void(0);" class="save-ad" data-adid="' . get_the_ID() . '"><i class="fa fa-heart-o"></i></a></li></ul>';
                    }
                    $no_padding = '';

                    if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern' && is_single('ad_post')) {

                        $save_ad = '';
                        $no_padding = 'no-padding';
                    } else {
                        if ($css_class != "") {
                            $no_padding = $css_class;
                        }
                    }

                    $my_ads .= '<div class="item"><div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="holder-' . get_the_ID() . '">
						  <div class="white category-grid-box-1 ">
						  ' . adforest_video_icon() . '
							 <!-- Image Box -->
							 		' . $is_feature . '
									 ' . $outer_html . '
							 <!-- Short Description -->
							 <div class="short-description-1 ">
								<!-- Category Title -->
								<div class="category-title"> ' . $cats_html . ' </div>
								<!-- Ad Title -->
								<h2><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>
								<p class="location"><i class="fa fa-map-marker"></i> ' . get_post_meta(get_the_ID(), '_adforest_ad_location', true) . '</p>
								 <span class="ad-price">' . adforest_adPrice(get_the_ID()) . '</span> 
							 </div>
							 <!-- Ad Meta Stats -->
							 <div class="ad-info-1">
								<ul class="pull-left ' . esc_attr($flip_it) . '">
								   <li> <i class="fa fa-eye"></i><a href="javascript:void(0);">' . adforest_getPostViews(get_the_ID()) . ' ' . __('Views', 'adforest') . '</a> </li>
								   <li> <i class="fa fa-clock-o"></i>' . get_the_date(get_option('date_format'), get_the_ID()) . '</li>
								</ul>
								' . $save_ad . '
							 </div>
						  </div>
					   </div>
					   </div>';
                }
                wp_reset_postdata();
            }



            if ($my_ads == '') {
                return '';
            }

            $no_padding .= $no_padding . ' ' . $css_class;

            return '<div class="col-xs-12 col-md-12 col-sm-12 margin-bottom-30 ' . esc_attr($no_padding) . '"><div class="grid-card"><div class="heading-panel"><div class="main-title text-left">' . $title . '</div></div><div class="featured-slider-1 row owl-carousel owl-theme">' . $my_ads . '</div></div></div>';
        }

        function adforest_get_ads_list_style($args, $title) {
            global $adforest_theme;
            $html = '';
            $cats = '';
            $args = apply_filters('adforest_wpml_show_all_posts', $args);
            $args = apply_filters('adforest_site_location_ads', $args, 'ads');
            $ads = new WP_Query($args);
            if ($ads->have_posts()) {
                while ($ads->have_posts()) {
                    $ads->the_post();
                    $pid = get_the_ID();
                    $media = adforest_get_ad_images($pid);
                    $img = adforest_get_ad_default_image_url('adforest-ad-related');
                    if (count($media) > 0) {
                        foreach ($media as $m) {
                            $mid = '';
                            if (isset($m->ID))
                                $mid = $m->ID;
                            else
                                $mid = $m;

                            $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                            $img = $image[0];
                            break;
                        }
                    }
                    $cats = adforest_display_cats($pid);
                    $condition_html = '';
                    if (isset($adforest_theme['allow_tax_condition']) && $adforest_theme['allow_tax_condition'] && get_post_meta(get_the_ID(), '_adforest_ad_condition', true) != "") {
                        $condition_html = '<li>
							 <div class="custom-tooltip tooltip-effect-4">
								<span class="tooltip-item"><i class="fa fa-cog"></i></span>
								<div class="tooltip-content"> 
								<strong>' . __('Condition', 'adforest') . '</strong>
								<span class="label label-danger">
								' . get_post_meta(get_the_ID(), '_adforest_ad_condition', true) . '
								</span>
								</div>
							 </div>
						  </li>';
                    }
                    $ad_type_html = '';
                    if (get_post_meta(get_the_ID(), '_adforest_ad_type', true) != "") {
                        $ad_type_html = '<li>
							 <div class="custom-tooltip tooltip-effect-4">
								<span class="tooltip-item"><i class="fa fa-check-square-o"></i></span>
								<div class="tooltip-content"> <strong>' . __('Type', 'adforest') . '</strong> <span class="label label-danger">' . get_post_meta(get_the_ID(), '_adforest_ad_type', true) . '</span> </div>
							 </div>
						  </li>';
                    }

                    $poster_contact = '';
                    if (get_post_meta(get_the_ID(), '_adforest_poster_contact', true) != "" && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'phone' )) {

                        $showPhone_to_users = adforest_showPhone_to_users();
                        if (!$showPhone_to_users) {
                            $poster_contact = '<li><div class="custom-tooltip tooltip-effect-4"><span class="tooltip-item"><i class="fa fa-phone"></i></span><div class="tooltip-content"><h4>' . __('Contact', 'adforest') . '</h4>' . get_post_meta(get_the_ID(), '_adforest_poster_contact', true) . '</div></div> </li>';
                        }
                    }
                    $timer_html = '';
                    $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
                    if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                        $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
                    }

                    $html .= $this->adforest_search_layout_list_2($pid, true, 'val');
                }
                wp_reset_postdata();
            }
            if ($html == '') {
                return '';
            }

            return '<div class="grid-panel margin-top-30"> <div class="heading-panel"><div class="col-xs-12 col-md-12 col-sm-12"><h3 class="main-title text-left">' . $title . '</h3></div></div><div class="posts-masonry"><div class="col-md-12 col-xs-12 col-sm-12">' . $html . '</div></div></div>';
        }

        function adforest_get_pages($paged, $max_pages, $fav_ads) {
            $load_more = '';
            if ($max_pages > 1) {
                $load_more = ' <ul class="pagination pagination-lg">';
                $p = $paged - 1;
                if ($paged != 1) {
                    $load_more .= '<li> <a href="javascript:void(0);" page_no="' . $p . '" class="sb_page" ad_type="' . $fav_ads . '"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>';
                }
                $class = '';
                for ($k = 1; $k <= $max_pages; $k++) {
                    $class = '';
                    $a_class = '';
                    if ($k == $paged) {
                        $class = 'class="active"';
                    } else {
                        $a_class = 'class="sb_page"';
                    }
                    $load_more .= '<li ' . $class . '> <a href="javascript:void(0);" page_no="' . $k . '" ' . $a_class . ' ad_type="' . $fav_ads . '">' . $k . '</a></li>';
                }
                $next = $paged + 1;
                if ($paged != $max_pages) {
                    $load_more .= '<li><a href="javascript:void(0);" page_no="' . $next . '" class="sb_page" ad_type="' . $fav_ads . '"> <i class="fa fa-chevron-right" aria-hidden="true"></i></a>';
                }
                $load_more .= '</ul>';
            }
            return $load_more;
        }

        function adforest_count_ad_messages($ad_id) {
            global $wpdb;

            $total = $wpdb->get_var("SELECT COUNT(DISTINCT(comment_author)) as total FROM $wpdb->comments WHERE comment_post_ID = '$ad_id' AND user_id != '" . get_current_user_id() . "'");
            return $total;
        }

        function adforest_load_messages($ad_id) {

            adforest_set_date_timezone();

            $script = '<script type="text/javascript">
         jQuery(document).ready(function($){
         "use strict";
         $(\'.message-history\').wrap(\'<div class="list-wrap"></div>\');
         function scrollbar() {
            var $scrollbar = $(\'.message-inbox .list-wrap\');
            $scrollbar.perfectScrollbar({
                maxScrollbarLength: 150,
            });
            $scrollbar.perfectScrollbar(\'update\');
         }
         scrollbar();
         $(\'.messages\').wrap(\'<div class="list-wraps"></div>\');
         function scrollbar1() {
            var $scrollbar1 = $(\'.message-details .list-wraps\');
            $scrollbar1.perfectScrollbar({
                maxScrollbarLength: 150,
            });
            $scrollbar1.perfectScrollbar(\'update\');
         }
          scrollbar1();
         });
         
      </script>';

            $script = apply_filters('adforest_blocked_user_scripts', $script);


            global $wpdb;

            $rows = $wpdb->get_results("SELECT comment_author, user_id FROM $wpdb->comments WHERE comment_post_ID = '$ad_id' AND comment_type = 'ad_post'  GROUP BY user_id ORDER BY MAX(comment_date) DESC");

            $users = '';
            $messages = '';
            $author_html = '';
            $form = '<div class="text-center">' . __('No message received on this ad yet.', 'adforest') . '</div>';
            $turn = 1;
            $level_2 = '';
            foreach ($rows as $row) {
                if (get_current_user_id() == $row->user_id)
                    continue;
                $user_dp = adforest_get_user_dp($row->user_id);

                $last_date = $wpdb->get_var("SELECT comment_date FROM $wpdb->comments WHERE comment_post_ID = '$ad_id' AND user_id = '" . $row->user_id . "' AND comment_type = 'ad_post' ORDER BY comment_date DESC LIMIT 1");
                $date = explode(' ', $last_date);
                $cls = '';
                if ($turn == 1)
                    $cls = 'message-history-active';

                $msg_status = get_comment_meta(get_current_user_id(), $ad_id . "_" . $row->user_id, true);
                $status = '';
                if ($msg_status == '0') {
                    $status = '<i class="fa fa-envelope" aria-hidden="true"></i>';
                }
                $users .= '<li class="user_list ' . $cls . '" cid="' . $ad_id . '" second_user="' . $row->user_id . '" id="sb_' . $row->user_id . '_' . $ad_id . '" sb_msg_token="'.wp_create_nonce('sb_msg_secure').'">
						 <a href="javascript:void(0);">
							<div class="image"> <img src="' . $user_dp . '" alt="' . $row->comment_author . '"> </div>
							<div class="user-name">
							   <div class="author"> <span>' . $row->comment_author . '</span> </div>
							   <p>' . get_the_title($ad_id) . '</p>
							   <div class="time" id="' . $row->user_id . '_' . $ad_id . '"> ' . $status . ' </div>
							</div>
						 </a>
					  </li>';
                $authors = array($row->user_id, get_current_user_id());
                $block_user_html = '';
                if ($turn == 1) {
                    $args = array(
                        'author__in' => $authors,
                        'post_id' => $ad_id,
                        'parent' => $row->user_id,
                        'orderby' => 'comment_date',
                        'order' => 'ASC',
                    );
                    $comments = get_comments($args);
                    if (count($comments) > 0) {


                        $level_2 = '<input type="hidden" id="usr_id" name="usr_id" value="' . $row->user_id . '" />
				<input type="hidden" id="rece_id" name="rece_id" value="' . $row->user_id . '" />
				<input type="hidden" name="msg_receiver_id" id="msg_receiver_id" value="' . esc_attr($row->user_id) . '" />
				';

                        foreach ($comments as $comment) {
                            $user_pic = '';
                            $class = 'friend-message';
                            if ($comment->user_id == get_current_user_id()) {
                                $class = 'my-message';
                            }


                            $block_user_html = apply_filters('adforest_blocked_button_html', $block_user_html, $comment->user_id, get_current_user_id());

                            $user_pic = adforest_get_user_dp($comment->user_id);
                            $messages .= '<li class="' . $class . ' clearfix">
									 <figure class="profile-picture">
										 <a href="' . get_author_posts_url($comment->user_id) . '?type=ads" class="link" target="_blank">
										<img src="' . $user_pic . '" class="img-circle" alt="' . __('Profile Pic', 'adforest') . '">
										</a>
									 </figure>
									 <div class="message">
										' . $comment->comment_content . '
										<div class="time"><i class="fa fa-clock-o"></i> ' . adforest_timeago($comment->comment_date) . '</div>
									 </div>
								  </li>';
                        }
                    }

                    // Message form
                    $profile = new adforest_profile();

                    $verifed_phone_number = adforest_check_if_phoneVerified();
                    if ($verifed_phone_number) {
                        $form = '<div role="alert" class="alert alert-info alert-dismissible">
                        
                        ' . __("Please verify your phone number to send message.", "adforest") . ' 
                     </div>';
                        ;
                    } else {
                        $form = '<form role="form" class="form-inline" id="send_message">
                                 <div class="form-group">
								 <input type="hidden" name="ad_post_id" id="ad_post_id" value="' . $ad_id . '" />
								 <input type="hidden" name="name" value="' . $profile->user_info->display_name . '" />
								 <input type="hidden" name="email" value="' . $profile->user_info->user_email . '" />
								 ' . $level_2 . '
                                    <input name="message" id="sb_forest_message" placeholder="' . __('Type a message here...', 'adforest') . '" class="form-control message-text" autocomplete="off" type="text" data-parsley-required="true" data-parsley-error-message="' . __('This field is required.', 'adforest') . '">
                                 </div>
                                 <button class="btn btn-theme" id="send_msg" type="submit" inbox="no" sb_msg_token="'.wp_create_nonce('sb_msg_secure').'">' . __('Send', 'adforest') . '</button>
                              </form>';
                    }
                }
                $turn++;
            }
            if ($users == '') {
                $users = '<li class="padding-top-30 padding-bottom-20"><div class="user-name">' . __('No message received on this ad yet.', 'adforest') . '</div></li>';
            }
            $title = '';
            if (isset($ad_id) && $ad_id != "") {
                $title = '<a href="' . get_the_permalink($ad_id) . '" target="_blank">' . get_the_title($ad_id) . '</a>';
            }
            $title_html = '<h2 class="padding-top-20">' . $title . '    ' . $block_user_html . ' </h2>';


            return $script . '<section class="gray">
                  <div class="message-body">
                     <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="message-inbox">
                           <div class="message-header">
                              <h4>' . __('Users', 'adforest') . '</h4>
                                  <div class="message-tabs"> 
                                    <span><a class="messages_actions active" sb_action="my_msgs"><small>' . __(' Sent Offers', 'adforest') . '</small></a></span>
                                    <span><a class="messages_actions" sb_action="received_msgs_ads_list"><small>' . __('Received Offers', 'adforest') . '</small></a></span>
                                    <span><a class="messages_actions" sb_action="adforest_all_blocked_users"><small>' . __('Blocked users', 'adforest') . ' </small></a></span>  
                                  </div>
                           </div>
                            <ul class="message-history">
                                    ' . $users . '
                            </ul>
                        </div>
                     </div>
                     <div class="col-md-8 clearfix col-sm-6 col-xs-12 message-content">
					 	' . $title_html . '
                        <div class="message-details">
                           <ul class="messages" id="messages">
                              ' . $messages . '
                           </ul>
                           <div class="chat-form ">
                              ' . $form . '
                           </div>
                        </div>
                     </div>
                  </div>
         </section>';
        }

        function adforest_get_user_ads_list() {
            global $adforest_theme;
            $script = '<script type="text/javascript">
         jQuery(document).ready(function($){
         "use strict";
         $(\'.message-history\').wrap(\'<div class="list-wrap"></div>\');
         function scrollbar() {
            var $scrollbar = $(\'.message-inbox .list-wrap\');
            $scrollbar.perfectScrollbar({
                maxScrollbarLength: 150,
            });
            $scrollbar.perfectScrollbar(\'update\');
         }
         scrollbar();
         $(\'.messages\').wrap(\'<div class="list-wraps"></div>\');
         function scrollbar1() {
            var $scrollbar1 = $(\'.message-details .list-wraps\');
            $scrollbar1.perfectScrollbar({
                maxScrollbarLength: 150,
            });
            $scrollbar1.perfectScrollbar(\'update\');
         }
          scrollbar1();
         });
         
         
      </script>';




            global $wpdb;
            $profile = new adforest_profile();
            $args = array(
                'post_type' => 'ad_post',
                'author' => $profile->user_info->ID,
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'paged' => $paged,
                'order' => 'DESC',
                'orderby' => 'ID',
            );

            $args = apply_filters('adforest_wpml_show_all_posts', $args);
            $args = apply_filters('adforest_site_location_ads', $args, 'ads');
            $ads = new WP_Query($args);

            if ($ads->have_posts()) {
                $number = 0;
                $ads_list = '';
                while ($ads->have_posts()) {
                    $ads->the_post();
                    $pid = get_the_ID();

                    $ad_img = adforest_get_ad_default_image_url('adforest-ad-related');
                    $media = adforest_get_ad_images($pid);
                    if (count($media) > 0) {
                        foreach ($media as $m) {
                            $mid = '';
                            if (isset($m->ID))
                                $mid = $m->ID;
                            else
                                $mid = $m;

                            $img = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                            $ad_img = $img[0];
                            break;
                        }
                    }

                    $is_unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '" . get_current_user_id() . "' AND meta_value = '0' AND meta_key like '" . $pid . "_%'");

                    $status = '';
                    if ($is_unread_msgs > 0) {
                        $status = '<i class="fa fa-envelope" aria-hidden="true"></i>';
                    }

                    $ads_list .= '<li class="get_msgs" ad_msg="' . esc_attr($pid) . '"><a href="javascript:void(0);">
							<div class="image">
							   <img src="' . $ad_img . '" alt="' . get_the_title($pid) . '">
							</div>
							<div class="user-name">
							   <div class="author">
								  <span>' . get_the_title($pid) . '</span>
							   </div>
							   <div class="time">
								  ' . $status . '
							   </div>
							</div>
						 </a>
						 </li>';
                }
            }

            $msg = '<div class="text-center">' . __('Please click to your ad in order to see messages.', 'adforest') . '</div>';


            return $script . '<div>
                   <div class="message-body">
                     <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="message-inbox">
                           <div class="message-header">
                              <h4>' . __('Ads', 'adforest') . '</h4>
                                  <div class="message-tabs"> 
			       <span><a class="messages_actions" sb_action="my_msgs"><small>' . __(' Sent Offers', 'adforest') . '</small></a></span>
                              <span><a class="messages_actions active" sb_action="received_msgs_ads_list"><small>' . __('Received Offers', 'adforest') . '</small></a></span>
                              <span><a class="messages_actions" sb_action="adforest_all_blocked_users"><small>' . __('Blocked users', 'adforest') . ' </small></a></span>     
                                   </div>
                           </div>
                                <ul class="message-history">
                                        ' . $ads_list . '
                                </ul>
                        </div>
                     </div>
                     <div class="col-md-8 clearfix col-sm-6 col-xs-12 message-content">
                        <div class="message-details">
                           <div class="chat-form ">
                              ' . $msg . '
                           </div>
                        </div>
                     </div>
                  </div>
               </div>';
        }

        function adforest_get_messages($user_id) {
            global $adforest_theme;

            $script = '<script type="text/javascript">
         jQuery(document).ready(function($){
         "use strict";
         $(\'.message-history\').wrap(\'<div class="list-wrap"></div>\');
         function scrollbar() {
            var $scrollbar = $(\'.message-inbox .list-wrap\');
            $scrollbar.perfectScrollbar({
                maxScrollbarLength: 150,
            });
            $scrollbar.perfectScrollbar(\'update\');
         }
         scrollbar();
         $(\'.messages\').wrap(\'<div class="list-wraps"></div>\');
         function scrollbar1() {
            var $scrollbar1 = $(\'.message-details .list-wraps\');
            $scrollbar1.perfectScrollbar({
                maxScrollbarLength: 150,
            });
            $scrollbar1.perfectScrollbar(\'update\');
         }
          scrollbar1();
         });
         
      </script>';

            $script = apply_filters('adforest_blocked_user_scripts', $script);

            global $wpdb;

            $rows = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_type = 'ad_post' AND user_id = '$user_id' AND comment_parent = '$user_id' GROUP BY comment_post_ID ORDER BY comment_ID DESC");

            $users = '';
            $messages = '';
            $form = '<div class="text-center">' . __('No message received on this ad yet.', 'adforest') . '</div>';
            $author_html = '';
            $turn = 1;
            $level_2 = '';
            $title_html = '';

            foreach ($rows as $row) {
                $last_date = $row->comment_date;
                $date = explode(' ', $last_date);
                $author = get_post_field('post_author', $row->comment_post_ID);
                $cls = '';
                if ($turn == 1)
                    $cls = 'message-history-active';

                $ad_img = adforest_get_ad_default_image_url('adforest-ad-related');
                $media = adforest_get_ad_images($row->comment_post_ID);
                if (count($media) > 0) {
                    foreach ($media as $m) {
                        $mid = '';
                        if (isset($m->ID))
                            $mid = $m->ID;
                        else
                            $mid = $m;

                        $img = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                        $ad_img = $img[0];
                        break;
                    }
                }


                if (isset($row->comment_post_ID) && $row->comment_post_ID != "") {
                    if ($turn == 1) {
                        $title_html .= '<h2 class="padding-top-20 sb_ad_title" id="title_for_' . esc_attr($row->comment_post_ID) . '"><a href="' . get_the_permalink($row->comment_post_ID) . '" target="_blank" >' . get_the_title($row->comment_post_ID) . '</a></h2>';
                    } else {
                        $title_html .= '<h2 class="padding-top-20 sb_ad_title no-display" id="title_for_' . esc_attr($row->comment_post_ID) . '" ><a href="' . get_the_permalink($row->comment_post_ID) . '" target="_blank" >' . get_the_title($row->comment_post_ID) . '</a></h2>';
                    }
                }


                $ad_id = $row->comment_post_ID;
                $comment_author = get_userdata($author);

                $msg_status = get_comment_meta(get_current_user_id(), $ad_id . "_" . $author, true);
                $status = '';
                if ($msg_status == '0') {
                    $status = '<i class="fa fa-envelope" aria-hidden="true"></i>';
                }

                $users .= '<li class="user_list ad_title_show ' . $cls . '" cid="' . $row->comment_post_ID . '" second_user="' . $author . '" inbox="yes" id="sb_' . $author . '_' . $ad_id . '" sb_msg_token="'.wp_create_nonce('sb_msg_secure').'">
						 <a href="javascript:void(0);">
							<div class="image">
							   <img src="' . $ad_img . '" alt="' . $comment_author->display_name . '">
							</div>
							<div class="user-name">
							   <div class="author">
								  <span>' . get_the_title($ad_id) . '</span>
							   </div>
							   <p>' . $comment_author->display_name . '</p>
							   <div class="time" id="' . $author . '_' . $ad_id . '">
								  ' . $status . '
							   </div>
							</div>
						 </a>
					  </li>
';
                $authors = array($author, get_current_user_id());
                $block_user_html = '';
                if ($turn == 1) {
                    $args = array(
                        'author__in' => $authors,
                        'post_id' => $ad_id,
                        'parent' => get_current_user_id(),
                        'post_type' => 'ad_post',
                        'orderby' => 'comment_date',
                        'order' => 'ASC',
                    );
                    $comments = get_comments($args);
                    if (count($comments) > 0) {

                        foreach ($comments as $comment) {
                            $user_pic = '';
                            $class = 'friend-message';
                            if ($comment->user_id == get_current_user_id()) {
                                $class = 'my-message';
                            }
                            $user_pic = adforest_get_user_dp($comment->user_id);

                            $messages .= '<li class="' . $class . ' clearfix">
                                            <figure class="profile-picture">
                                            <a href="' . get_author_posts_url($comment->user_id) . '?type=ads" class="link" target="_blank">
                                                   <img src="' . $user_pic . '" class="img-circle" alt="' . __('Profile Pic', 'adforest') . '">
                                                   </a>
                                            </figure>
                                            <div class="message">
                                                   ' . $comment->comment_content . '
                                                   <div class="time"><i class="fa fa-clock-o"></i> ' . adforest_timeago($comment->comment_date) . '</div>
                                            </div>
                                     </li>';
                        }
                    }

                    // Message form
                    $profile = new adforest_profile();
                    $level_2 = '<input type="hidden" name="usr_id" value="' . $user_id . '" />
			<input type="hidden" id="usr_id" value="' . $author . '" />
			<input type="hidden" id="rece_id" name="rece_id" value="' . $author . '" />
			<input type="hidden" name="msg_receiver_id" id="msg_receiver_id" value="' . esc_attr($author) . '" />
			';

                    $block_user_html = apply_filters('adforest_blocked_button_html', $block_user_html, $author, $user_id);

                    $verifed_phone_number = adforest_check_if_phoneVerified();
                    if ($verifed_phone_number) {
                        $form = '<div role="alert" class="alert alert-info alert-dismissible">' . __("Please verify your phone number to send a message.", "adforest") . ' 
                     </div>';
                    } else {

                        $form = '<form role="form" class="form-inline" id="send_message">
                                 <div class="form-group">
                                    <input type="hidden" name="ad_post_id" id="ad_post_id" value="' . $ad_id . '" />
                                    <input type="hidden" name="name" value="' . $profile->user_info->display_name . '" />
                                    <input type="hidden" name="email" value="' . $profile->user_info->user_email . '" />
								 ' . $level_2 . '
                                    <input name="message" id="sb_forest_message" placeholder="' . __('Type a message here...', 'adforest') . '" class="form-control message-text" autocomplete="off" type="text" data-parsley-required="true" data-parsley-error-message="' . __('This field is required.', 'adforest') . '">
                                 </div>
                                 <button class="btn btn-theme" id="send_msg" type="submit" inbox="yes" sb_msg_token="'.wp_create_nonce('sb_msg_secure').'">' . __('Send', 'adforest') . '</button>
                              </form>';
                    }
                }
                $turn++;
            }
            if ($users == '') {
                $users = '<li class="padding-top-30 padding-bottom-20"><div class="user-name">' . __('Nothing Found.', 'adforest') . '</div></li>';
            }


            return $script . '<div>
                   <div class="message-body">
                     <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="message-inbox">
                           <div class="message-header">
                              <h4>' . __('Ads', 'adforest') . '</h4>
                                <div class="message-tabs"> 
                               <span><a class="messages_actions active" sb_action="my_msgs"><small>' . __(' Sent Offers', 'adforest') . '</small></a></span>
                              <span><a class="messages_actions" sb_action="received_msgs_ads_list"><small>' . __('Received Offers', 'adforest') . '</small></a></span>
                              <span><a class="messages_actions" sb_action="adforest_all_blocked_users"><small>' . __('Blocked users', 'adforest') . ' </small></a></span>  
                                </div>   
                           </div>
                            <ul class="message-history">
                                    ' . $users . '
                            </ul>
                        </div>
                     </div>
                     <div class="col-md-8 clearfix col-sm-6 col-xs-12 message-content">
					 	' . $title_html . '
                        <div class="message-details">
                            ' . $block_user_html . '
                           <ul class="messages" id="messages">
                              ' . $messages . '
                           </ul>
                           <div class="chat-form ">
                              ' . $form . '
                           </div>
                        </div>
                     </div>
                  </div>
               </div>';
        }

        function adforest_all_blocked_users_callback($current_user_id) {
            global $adforest_theme;

            $script = '<script type="text/javascript">
         jQuery(document).ready(function($){
         "use strict";
         $(\'.message-history\').wrap(\'<div class="list-wrap"></div>\');
         function scrollbar() {
            var $scrollbar = $(\'.message-inbox .list-wrap\');
            $scrollbar.perfectScrollbar({
                maxScrollbarLength: 150,
            });
            $scrollbar.perfectScrollbar(\'update\');
         }
         scrollbar();
         $(\'.messages\').wrap(\'<div class="list-wraps"></div>\');
         function scrollbar1() {
            var $scrollbar1 = $(\'.message-details .list-wraps\');
            $scrollbar1.perfectScrollbar({
                maxScrollbarLength: 150,
            });
            $scrollbar1.perfectScrollbar(\'update\');
         }
          scrollbar1();
         });
         
      </script>';

            $script = apply_filters('adforest_blocked_user_scripts', $script);

            global $wpdb;


            $users = '';
            $messages = '';
            $messages = '<div class="text-center">' . __('No Blocked user.', 'adforest') . '</div>';
            $author_html = '';
            $turn = 1;
            $level_2 = '';
            $title_html = '<h2 class="padding-top-20 sb_ad_title">' . __('Blocked Users', 'adforest') . '</h2>';


            $blocked_user_array = get_user_meta($current_user_id, 'adforest_blocked_users', true);

            if (isset($blocked_user_array) && !empty($blocked_user_array) && is_array($blocked_user_array)) {

                $messages = '';

                foreach ($blocked_user_array as $block_time => $block_user_id) {

                    if ($turn == 1)
                        $cls = 'message-history-active';

                    $user_data = get_userdata($block_user_id);






                    $ad_id = $row->comment_post_ID;
                    $comment_author = get_userdata($author);

                    $msg_status = get_comment_meta(get_current_user_id(), $ad_id . "_" . $author, true);

                    $form = ' ';
                    $form = apply_filters('adforest_blocked_button_html', $form, $block_user_id, get_current_user_id(), false);

                    $user_pic = adforest_get_user_dp($block_user_id);
                    $messages .= '<li class="friend-message clearfix">
                                            <figure class="profile-picture">
                                            <a href="' . get_author_posts_url($comment->user_id) . '?type=ads" class="link" target="_blank">
                                                   <img src="' . $user_pic . '" class="img-circle" alt="' . __('Profile Pic', 'adforest') . '">
                                                   </a>
                                            </figure>
                                            <div class="message block-user-box">
                                                <div class="user-detail-wrap">
                                                   <span class="block-user-name">' . $user_data->display_name . '</span>
                                                   <span class="block-user-date">' . __('Blocked on', 'adforest') . ' : ' . date('F j, Y', $block_time) . '</span>
                                                </div>       
                                                  ' . $form . '    
                                            </div>
                                           
                                     </li>';


                    $turn++;
                }
            }




            if ($users == '') {
                $users = '<li class="padding-top-30 padding-bottom-20"><div class="user-name">' . __('Nothing Found.', 'adforest') . '</div></li>';
            }


            return $script . '<div>
                   <div class="message-body">
                     <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="message-inbox">
                           <div class="message-header">
                              <h4>' . __('Ads', 'adforest') . '</h4>
                                <div class="message-tabs">  
                              <span><a class="messages_actions" sb_action="my_msgs"><small>' . __(' Sent Offers', 'adforest') . '</small></a></span>
                              <span><a class="messages_actions" sb_action="received_msgs_ads_list"><small>' . __('Received Offers', 'adforest') . '</small></a></span>
                              <span><a class="messages_actions active" sb_action="adforest_all_blocked_users"><small>' . __('Blocked users', 'adforest') . ' </small></a></span>  
                                   </div>
                           </div>
                           
                        </div>
                     </div>
                     <div class="col-md-8 clearfix col-sm-6 col-xs-12 message-content">
					 	' . $title_html . '
                        <div class="message-details">
                            
                           <ul class="messages">
                              ' . $messages . '
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>';
        }

        function adforest_search_layout_grid_1($pid, $col = 6, $sm = 6, $holder = '') {

            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $cats_html = adforest_display_cats($pid);

            $flip_it = '';
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }


            $outer_html = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                $counting = 1;
                foreach ($media as $m) {
                    if ($counting > 1)
                        break;

                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;

                    $timer_html = '';
                    $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
                    if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                        $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
                    }


                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $outer_html = '<div class="image">
				' . $timer_html . '
				<a href="' . get_the_permalink() . '"><img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive"></a> 
				</div>';
                    $counting++;
                }
            } else {
                $timer_html = '';
                $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
                if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                    $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
                }

                $outer_html = '<div class="image">
			' . $timer_html . '
					<a href="' . get_the_permalink() . '"><img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-responsive"></a>
					</div>';
            }
            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '">
			  <span>' . __('Featured', 'adforest') . '</span>
		   </div>';
            }

            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            $my_ads = '';

            if ($col == 0) {
                $my_ads .= '<div class="item">';
            } else {
                $my_ads .= '<div class="col-md-' . esc_attr($col) . '  col-lg-' . esc_attr($col) . ' col-sm-' . esc_attr($sm) . ' col-xs-12" id="' . $holder . '.holder-' . get_the_ID() . '">';
            }


            $my_ads .= '<div class="white category-grid-box-1 ">
						  ' . adforest_video_icon() . '
							 <!-- Image Box -->
							 ' . $is_feature . '
									 ' . $outer_html . '
							 <!-- Short Description -->
							 <div class="short-description-1 ">
								<!-- Category Title -->
								<div class="category-title"> ' . $cats_html . ' </div>
								<!-- Ad Title -->
								<h2>
								   <a title="' . get_the_title() . '" href="' . get_the_permalink() . '">' . $ad_title . '</a>
								</h2>
								<!-- Location -->
								<p class="location"><i class="fa fa-map-marker"></i> ' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</p>
								 <span class="ad-price">' . adforest_adPrice(get_the_ID()) . '</span> 
							 </div>
							 <!-- Ad Meta Stats -->
							 <div class="ad-info-1">
								<ul class="pull-left ' . esc_attr($flip_it) . '">
								   <li> <i class="fa fa-eye"></i><a href="javascript:void(0);">' . adforest_getPostViews(get_the_ID()) . ' ' . __('Views', 'adforest') . '</a> </li>
								   <li> <i class="fa fa-clock-o"></i>' . get_the_date(get_option('date_format'), get_the_ID()) . '</li>
								</ul>
								<ul class="pull-right">
								</ul>
							 </div>
						  </div>
					   </div>';

            return $my_ads;
        }

        function adforest_search_layout_grid_2($pid, $col = 6, $sm = 6, $holder = '') {
            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $cats_html = adforest_display_cats($pid);

            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;

                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $img = '<img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive">';
                    break;
                }
            }
            else {
                $img = '<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-responsive">';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $is_feature = '<span class="ad-status">' . __('Featured', 'adforest') . '</span>';
            }

            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);
            ;

            $condition_html = '';
            if (isset($adforest_theme['allow_tax_condition']) && $adforest_theme['allow_tax_condition'] && get_post_meta(get_the_ID(), '_adforest_ad_condition', true) != "") {
                $condition_html = '<p>' . __('Condition', 'adforest') . ": " . get_post_meta(get_the_ID(), '_adforest_ad_condition', true) . '</p>';
            }

            $ad_type_html = '';
            if (get_post_meta(get_the_ID(), '_adforest_ad_type', true) != "") {
                $ad_type_html = '<p>' . __('Ad Type', 'adforest') . ": " . get_post_meta(get_the_ID(), '_adforest_ad_type', true) . '</p>';
            }

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }
            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            if ($col == 0) {
                $my_ads .= '<div class="item">';
            } else {
                $my_ads .= '<div class="col-md-' . esc_attr($col) . ' col-xs-12 col-sm-' . esc_attr($sm) . '">';
            }


            $my_ads .= '<div class="category-grid-box">
					 <!-- Ad Img -->
					 <div class="category-grid-img">
					 ' . $timer_html . '
						' . $img . '
						<!-- Ad Status -->
						' . $is_feature . '
						<!-- User Review -->
						<div class="user-preview">
						   <a href="' . adforest_set_url_param(get_author_posts_url($author_id), 'type', 'ads') . '">
						   <img src="' . adforest_get_user_dp($author_id) . '" class="avatar avatar-small" alt="' . get_the_title() . '">
						   </a>
						</div>
						' . adforest_video_icon(true) . '
						<!-- View Details -->
						<a href="' . get_the_permalink() . '" class="view-details">
						' . __('View Details', 'adforest') . '
						</a>
						<!-- Additional Info -->
						<div class="additional-information">
						   <p>' . __('Posted on', 'adforest') . ": " . get_the_date(get_option('date_format'), get_the_ID()) . '</p>
						   ' . $ad_type_html . '
						   ' . $condition_html . '
						</div>
						<!-- Additional Info End-->
					 </div>
					 <!-- Ad Img End -->
					 <div class="short-description">
							<!-- Category Title -->
								<div class="category-title"> ' . $cats_html . ' </div>
								<!-- Ad Title -->
								<h2>
								   <a title="' . get_the_title() . '" href="' . get_the_permalink() . '">' . $ad_title . '</a>
								</h2>
						<!-- Price -->
						<div class="price">
						' . adforest_adPrice(get_the_ID()) . '
						</div>
					 </div>
					 <!-- Addition Info -->
					 <div class="ad-info">
						<ul>
						   <li><i class="fa fa-map-marker"></i>
						   ' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '
						   </li>
						</ul>
					 </div>
				  </div>
				  <!-- Ad Box End -->
			   </div>';

            return $my_ads;
        }

        function adforest_search_layout_grid_3($pid, $col = 6, $sm = 6, $holder = '') {
            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $cats_html = adforest_display_cats($pid);

            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $ribbion = 'featured-ribbon-rtl';
            }

            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;

                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $img = '<img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive">';
                    break;
                }
            }
            else {
                $img = '<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-responsive">';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '">
			  <span>' . __('Featured', 'adforest') . '</span>
		   </div>';
            }

            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);
            ;

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }
            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }
            if ($col == 0) {
                $my_ads .= '<div class="item">';
            } else {
                $my_ads .= '<div class="col-md-' . esc_attr($col) . ' col-sm-' . esc_attr($sm) . ' col-xs-12">';
            }

            $my_ads .= '<div class="category-grid-box-1">
							  ' . $is_feature . '
							  ' . adforest_video_icon() . '
                                 <div class="image">
                                    <a href="' . get_the_permalink() . '">' . $img . '</a>
									
                                 </div>
                                 <div class="short-description-1 clearfix">
				<div class="price-tag">
				<div class="price">
				<span>
				' . adforest_adPrice(get_the_ID()) . '
				</span>
				</div>
				</div>
				    <div class="category-title">
					' . $cats_html . ' 
				    </div>
                                    <h2>
                                        <a title="' . get_the_title() . '" href="' . get_the_permalink() . '">' . $ad_title . '</a>
                                        </h2>
                                        <i class="fa fa-clock-o"></i>
                                        <small>
                                        ' . get_the_date(get_option('date_format'), get_the_ID()) . '
                                        </small>
                                        ' . $timer_html . '
                                 </div>
				<div class="ad-info-1">
                                    <ul>
                                       <li> <i class="fa fa-map-marker"></i>
                                        ' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '
                                        </li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
		';
            return $my_ads;
        }

        function adforest_search_layout_grid_4($pid, $col = 6, $sm = 6, $holder = '') {
            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $cats_html = adforest_display_cats($pid);

            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $ribbion = 'featured-ribbon-rtl';
            }

            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;

                    $image = wp_get_attachment_image_src($mid, 'adforest-category');
                    $img = '<img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive">';
                    break;
                }
            }
            else {
                $img = '<img src="' . adforest_get_ad_default_image_url('adforest-category') . '" alt="' . get_the_title() . '" class="img-responsive">';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '">
			  <span>' . __('Featured', 'adforest') . '</span>
		   </div>';
            }

            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }

            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            if ($col == 0) {
                $my_ads .= '<div class="item">';
            } else {
                $my_ads .= '<div class="col-md-' . esc_attr($col) . ' col-sm-' . esc_attr($sm) . ' col-xs-12">';
            }

            $my_ads .= '<div class="listing-card">
                                <div class="image-area">
                                        ' . adforest_video_icon() . '
                                        ' . $timer_html . '
                                        ' . $is_feature . '
                                    <div class="photo-count-flag">' . count($media) . ' <i class="fa fa-camera"></i></div>
                                    <a href="' . get_the_permalink() . '">' . $img . '</a>
                                </div>
                                <div class="listing-detail">
                                    <div class="listing-content">
                                        <h2 class="listing-title">
                                            <a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . $ad_title . '</a>
                                        </h2>
                                        <span class="listing-price">' . adforest_adPrice(get_the_ID()) . '</span>
                                        <ul>
                                            <li> <i class="fa fa-th-large fa-fw"></i><span>' . $cats_html . ' </span> </li>
                                            <li> <i class="fa fa-map-marker fa-fw"></i><span>' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</span> </li>
                                            <li> <i class="fa fa-clock-o fa-fw"></i><span>' . get_the_date(get_option('date_format'), get_the_ID()) . '</span> </li>
                                        </ul>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                          </div>
                        </div>';
            return $my_ads;
        }

        function adforest_search_layout_grid_5($pid, $col = 6, $sm = 6, $holder = '') {
            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $cats_html = adforest_display_cats($pid);

            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $ribbion = 'featured-ribbon-rtl';
            }

            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;
                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $img = '<img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive">';
                    break;
                }
            }
            else {
                $img = '<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-responsive">';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '">
			  <span>' . __('Featured', 'adforest') . '</span>
		   </div>';
            }

            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }

            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            if ($col == 0) {
                $my_ads .= '<div class="item">';
            } else {
                $my_ads .= '<div class="grid-padding col-md-' . esc_attr($col) . ' col-sm-' . esc_attr($sm) . ' col-xs-12 marrgin-bottom-20">';
            }


            $my_ads .= '<div class="new-small-grid">
                                    ' . adforest_video_icon() . '
                                    ' . $is_feature . '
				 <a href="' . get_the_permalink() . '">
				  <figure class="new-small-grid-img">
				  ' . $timer_html . '
					' . $img . '	
				  </figure>
				  </a>
				  <div class="new-small-grid-description">
					<h2><a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . $ad_title . '</a></h2>
					<div class="category-title">
						' . $cats_html . ' 
					</div>
					<span class="ad-price">' . adforest_adPrice(get_the_ID()) . '</span>
				  </div>
				</div>
			</div>';

            return $my_ads;
        }

        function adforest_search_layout_grid_6($pid, $col = 6, $sm = 6, $holder = '') {
            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $ribbion = 'featured-ribbon-rtl';
            }

            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;
                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $img = '<img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive">';
                    break;
                }
            }
            else {
                $img = '<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-responsive">';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '">
			  <span>' . __('Featured', 'adforest') . '</span>
		   </div>';
            }

            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }

            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
            $cats_html = '';
            foreach ($post_categories as $c) {
                $cat = get_term($c);
                $cats_html .= '<li><a href="' . get_term_link($cat->term_id) . '">' . esc_html($cat->name) . '</a></li>';
            }

            if ($col == 0) {
                $my_ads .= '<div class="item">';
            } else {
                $my_ads .= '<div class="col-lg-' . esc_attr($col) . ' col-xs-12 col-md-' . esc_attr($col) . ' col-sm-6">';
            }
            $my_ads .= '<div class="feature-section">
				<div class="feature-products-timer">
                	' . $timer_html . '
                </div>
			 
              <div class="feature-shops">
			  ' . $is_feature . '
			  <a href="' . get_the_permalink() . '">
			  ' . $img . '
			  </a>
                <div class="new-feature-products-maker">
                  <div class="feature-products new-feature-products">
				  <span>' . adforest_adPrice(get_the_ID()) . '</span>
                  </div>
                </div>
				 <div class="feature-icons new-feature-icons">
				  ' . adforest_video_icon(false, 'play-video-new') . '
					<a href="javascript:void(0);" id="ad_to_fav" data-adid="' . esc_attr(get_the_ID()) . '">
						<i class="fa fa-heart"></i>
					</a>
				  </div>
              </div>
              <div class="feature-description">
                <div class="feature-text new-feature-text">
                  <div class="feature-shop-colors"> <ul class="list-inline"> ' . $cats_html . ' </ul> </div>
                  <h2 class="fonts"><a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . $ad_title . '</a></h2>
                  <h4><i class="fa fa-map-marker no-padding"></i>
				  <a href="javascript:void(0);">' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</a>
				  </h4>
                </div>
                <div class="feature-shadow">
                  <ul class="list-inline">
                    <li><i class="fa fa-clock-o"><span class="items">' . get_the_date(get_option('date_format'), get_the_ID()) . '</span></i></li>
                    <li><i class="fa fa-eye"><span class="items">' . adforest_getPostViews(get_the_ID()) . ' ' . __('Views', 'adforest') . '</span></i></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>';
            return $my_ads;
        }

        function adforest_search_layout_grid_7($pid, $col = 6, $sm = 6, $holder = '') {
            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $ribbion = 'featured-ribbon-rtl';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '">
			  <span>' . __('Featured', 'adforest') . '</span>
		   </div>';
            }


            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;
                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $img = '<img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive">';
                    break;
                }
            }
            else {
                $img = '<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-responsive">';
            }



            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }

            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
            $cats_html = '';
            foreach ($post_categories as $c) {
                $cat = get_term($c);
                $cats_html .= '<li><a href="' . get_term_link($cat->term_id) . '">' . esc_html($cat->name) . '</a></li>';
            }

            if ($col == 0) {
                $my_ads .= '<div class="item">';
            } else {
                $my_ads .= '<div class="col-lg-' . esc_attr($col) . ' col-xs-12 col-md-' . esc_attr($col) . ' col-sm-6">';
            }

            $my_ads .= '<div class="browse-feature-details">
            <div class="browse-featured-list">
              <div class="browse-featured-images">
			  ' . $is_feature . '
				<a href="' . get_the_permalink() . '">
				' . $img . '
				</a>
                <div class="browse-feature-icons">
                    ' . adforest_video_icon(false, 'play-video-new') . '
                    <a href="javascript:void(0);" id="ad_to_fav" data-adid="' . esc_attr(get_the_ID()) . '">
						<i class="fa fa-heart"></i>
					</a>
                </div>
                <div class="browse-timer">
                  <p>' . $timer_html . '</p>
                </div>
              </div>
            </div>
            <div class="browse-feature-text">
              <div class="browse-feature-products">
                <ul class="list-inline">
                  ' . $cats_html . '
                </ul>
              </div>
              <div class="browse-heading-h2">
                <h2><a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . $ad_title . '</a></h2>
              </div>
              <div class="browse-text-h4">
                <p><i class="fa fa-map-marker"></i><a href="javascript:void(0);">' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</a></p>
              </div>';

            if (adforest_adPrice(get_the_ID()) != '') {
                $my_ads .= ' <div class="browse-price-section">
                                <ul class="list-inline">
                                  <li><a href="javascript:void(0);">' . adforest_adPrice(get_the_ID()) . '</a></li>

                                </ul>
                              </div>';
            }
            $my_ads .= '   </div>
          </div>
        </div>';

            return $my_ads;
        }

        function adforest_search_layout_grid_8($pid, $col = 12) {
            global $adforest_theme;
            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;
                    $image = wp_get_attachment_image_src($mid, 'adforest-category');
                    $img = '<a href="' . get_the_permalink() . '"><img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive"> </a>';
                    break;
                }
            }
            else {
                $img = '<a href="' . get_the_permalink() . '"><img src="' . adforest_get_ad_default_image_url('adforest-category') . '" alt="' . get_the_title() . '" class="img-responsive"> </a>';
            }

            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            $cats_html = '';
            $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));

            if (isset($post_categories) && !empty($post_categories) && is_array($post_categories)) {
                foreach ($post_categories as $c) {
                    $cat = get_term($c);
                    $cats_html = ' <a href="' . get_term_link($cat->term_id) . '" class="btn-theme">' . esc_html($cat->name) . '</a> ';
                    // break;
                }
            }




            $author_id = get_post_field('post_author', $pid);
            $html = '';
            // featured code
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $ribbion = 'featured-ribbon-rtl';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '">
			  <span>' . __('Featured', 'adforest') . '</span>
		   </div>';
            }

            // time code
            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }

            if ($col == 0) {
                $html .= '<div class="item">';
            } else {
                $html .= '<div class="col-lg-' . esc_attr($col) . ' col-xs-12 col-md-' . esc_attr($col) . ' col-sm-6">';
            }
            $html .= ' <div class="prop-newest-main-section">
                                            <div class="prop-newest-image">  ' . $timer_html . $is_feature . ($img) . '
                                               
                                                <div class="prop-estate-links"> <a href="' . adforest_set_url_param(get_author_posts_url($author_id), 'type', 'ads') . '"> <img src="' . adforest_get_user_dp($author_id) . '" alt="' . get_the_title() . '" class="avatar avatar-small img-responsive"></a> </div>
                                                <div class="prop-estate-icons"> <a href="javascript:void(0);" id="ad_to_fav" data-adid="' . esc_attr(get_the_ID()) . '"><i class="fa fa-heart"></i></a> </div>
                                            </div>
                                            <div class="prop-main-contents">
                                                <div class="prop-real-estate-box">
                                                    <div class="prop-estate-advertisement">
                                                        <div class="prop-estate-text-section">
                                                         <div class="prop-estate-rent"> ' . ($cats_html) . ' </div>
                                                            <a href="' . get_the_permalink() . '">
                                                                <h2>' . esc_html($ad_title) . '</h2>
                                                            </a> <a href="javascript:void(0);">
                                                                <p><i class="fa fa-map-marker"></i>' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</p>
                                                            </a> <span>' . adforest_adPrice(get_the_ID()) . '</span> </div>
                                                    </div>
                                                    <div class="prop-estate-table">
                                                        <ul class="list-inline prop-content-area">
                                                            <li><i class="fa fa-clock-o"><span class="items">' . get_the_date(get_option('date_format'), get_the_ID()) . '</span></i></li>
                                                            <li><i class="fa fa-eye"><span class="items">' . adforest_getPostViews(get_the_ID()) . ' ' . __('Views', 'adforest') . '</span></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
            return $html;
        }

        function adforest_search_layout_grid_9($pid, $col = 12) {
            global $adforest_theme;
            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;
                    $image = wp_get_attachment_image_src($mid, 'adforest-category');
                    $img = '<a href="' . get_the_permalink() . '"><img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive"> </a>';
                    break;
                }
            }
            else {
                $img = '<a href="' . get_the_permalink() . '"><img src="' . adforest_get_ad_default_image_url('adforest-category') . '" alt="' . get_the_title() . '" class="img-responsive"> </a>';
            }

            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            $cats_html = '';
            if (isset($taxonomy_obj) && !empty($taxonomy_obj) && is_object($taxonomy_obj)) {
                $cats_html .= '<a href="' . get_term_link($taxonomy_obj->term_id) . '" class="btn-theme">' . esc_html($taxonomy_obj->name) . '</a>';
            } else {
                $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
                foreach ($post_categories as $c) {
                    $cat = get_term($c);
                    $cats_html .= ' <a href="' . get_term_link($cat->term_id) . '" class="btn-theme">' . esc_html($cat->name) . '</a> ';
                }
            }


            $author_id = get_post_field('post_author', $pid);
            $html = '';
            // featured code
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $ribbion = 'featured-ribbon-rtl';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {

                $is_feature = '<div class="dec-featured-icons">
                                    <i class="fa fa-star"></i>
                                    <span>' . __('Featured', 'adforest') . '</span>
                                </div>';
            }

            // time code
            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }


            if ($col == 0) {
                $html .= '<div class="item">';
            } else {
                $html .= '<div class="col-lg-' . esc_attr($col) . ' col-xs-12 col-md-' . esc_attr($col) . ' col-sm-6">';
            }

            $html .= '<div class="dec-featured-box">
                          <div class="dec-featured-box-img"> 
                          ' . $img . ' 
                            ' . $timer_html . '   
                              <div class="img-options-wrap">
                            ' . $is_feature . '
                           <div class="dec-featured-cam">
                           <i class="fa fa-camera"></i>
                           <span>' . count($media) . ' ' . esc_html__('Photo', 'adforest') . '</span>
                           </div>
                           <div class="dec-featured-ht">
                           <a href="javascript:void(0);" id="ad_to_fav" data-adid="' . esc_attr(get_the_ID()) . '"><i class="fa fa-heart"></i></a>
                           <span>' . esc_html__('Bookmark', 'adforest') . '</span>
                           </div>
                           </div>
                          </div>
                          <div class="dec-featured-details-section"> <a href="' . get_the_permalink() . '">
                            <h2>' . esc_html($ad_title) . '</h2>
                            </a> <a href="javascript:void(0)">
                            <p><i class="fa fa-map-marker"></i>' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</p>
                            </a> <span>' . adforest_adPrice(get_the_ID()) . '</span> </div>
                          <div class="dec-featured-new-categories">
                            <ul class="list-inline dec-featured-select">
                               <li><i class="fa fa-clock-o"><span class="items">' . get_the_date(get_option('date_format'), get_the_ID()) . '</span></i></li>
                               <li><i class="fa fa-eye"><span class="items">' . adforest_getPostViews(get_the_ID()) . ' ' . __('Views', 'adforest') . '</span></i></li>
                            </ul>
                          </div>
                        </div>
                      </div>';
            return $html;
        }

        function adforest_search_layout_grid_10($pid, $col = 12) {
            global $adforest_theme;
            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;
                    $image = wp_get_attachment_image_src($mid, 'adforest-location-grid');
                    $img = '<a href="' . get_the_permalink() . '"><img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-fluid"> </a>';
                    break;
                }
            }
            else {
                $img = '<a href="' . get_the_permalink() . '"><img src="' . adforest_get_ad_default_image_url('adforest-location-grid') . '" alt="' . get_the_title() . '" class="img-fluid"> </a>';
            }

            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            $cats_html = '';
            if (isset($taxonomy_obj) && !empty($taxonomy_obj) && is_object($taxonomy_obj)) {
                $cats_html .= '<a href="' . get_term_link($taxonomy_obj->term_id) . '" class="btn-theme">' . esc_html($taxonomy_obj->name) . '</a>';
            } else {
                $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
                foreach ($post_categories as $c) {
                    $cat = get_term($c);
                    $cats_html .= ' <a href="' . get_term_link($cat->term_id) . '" class="btn-theme">' . esc_html($cat->name) . '</a> ';
                }
            }


            $poster_id = get_post_field('post_author', $pid);
            $user_pic = adforest_get_user_dp($poster_id, 'adforest-single-small-50');
            $poster_name = get_post_meta($pid, '_adforest_poster_name', true);
            if ($poster_name == "") {
                $user_info = get_userdata($poster_id);
                $poster_name = $user_info->display_name;
            }
            $html = '';
            // featured code
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $ribbion = 'featured-ribbon-rtl';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {

                $is_feature = '<div class="' . $ribbion . '"> <span>' . __('Featured', 'adforest') . '</span></div>';
            }
            // time code


            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, true, 'style-2') . '</div>';
            }



            $categories_html = '';
            $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
            if (isset($post_categories) && !empty($post_categories) && sizeof($post_categories) > 0) {
                $categories_html .= '<ul>';
                foreach ($post_categories as $c) {
                    $cat = get_term($c);
                    $link = get_term_link($cat->term_id);
                    $categories_html .= '<li> <a href="' . esc_url($link) . '">' . esc_html($cat->name) . '</a></li>';
                }
                $categories_html .= '</ul>';
            }
            $is_fav = '';
            if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
                $is_fav = ' class="ad-favourited" ';
            }

            $img_count = count($media) > 0 ? count($media) : 0;
            $html .= '<div class="col-lg-' . esc_attr($col) . ' col-xs-12 col-md-' . esc_attr($col) . ' col-sm-12">';
            $html .= '<div class="ads-grid-container">
                                <div class="ads-grid-style"> <div class="featured-ribbon">  ' . $is_feature . ' </div> ' . adforest_video_icon() . '  ' . $img . ' 
                                   ' . $timer_html . '
                                </div>
                                <div class="ads-grid-content">
                                    ' . $categories_html . '
                                    <a href="' . get_the_permalink() . '">
                                      <h3>' . esc_html($ad_title) . '</h3>
                                    </a>
                                    <p><i class="fa fa-map-marker"></i>' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</p>
                                </div>
                                <div class="ads-grid-price">
                                    <div class="ads-grid-panel"> <span>' . adforest_adPrice(get_the_ID()) . '</span> </div>
                                    <div class="ads-grid-vc"> 
                                    <span data-toggle="tooltip" data-placement="top" title="' . $img_count . '"><i class="fa fa-camera"></i></span> 
                                    <a ' . $is_fav . ' href="javascript:void(0);" id="ad_to_fav" data-adid="' . get_the_ID() . '"><i class="fa fa-heart"></i> </a></div>
                                </div>
                                <div class="ads-grid-views">
                                    <ul>
                                        <li> <a href="' . adforest_set_url_param(get_author_posts_url($poster_id), 'type', 'ads') . '"> <img src="' . $user_pic . '" alt="' . __('User image', 'adforest') . '" class="img-fluid"></a> <span><a href="' . adforest_set_url_param(get_author_posts_url($poster_id), 'type', 'ads') . '">' . $poster_name . '</a></span> </li>
                                        <li>
                                           <p>' . __('Views', 'adforest') . ' : ' . adforest_getPostViews(get_the_ID()) . '</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>';

            $html .= '</div>';

            return $html;
        }

        function adforest_search_layout_list_4($pid) {
            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;
                    $image = wp_get_attachment_image_src($mid, 'adforest-ads-medium');
                    $img = '<a href="' . get_the_permalink() . '"><img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive" height="127" width="169"> </a>';
                    break;
                }
            }
            else {
                $img = '<a href="' . get_the_permalink() . '"><img src="' . adforest_get_ad_default_image_url('adforest-ads-medium') . '" alt="' . get_the_title() . '" class="img-responsive"> </a>';
            }
            $ad_title = wp_trim_words(get_the_title(), 3, '...');

            $html = '';
            $html .= '<div class="prop-real-estates">
                <div class="prop-estate-image-section"> 
                    ' . ($img) . '
                </div>
                <div class="prop-real-estate-box">
                    <div class="prop-estate-text-section">
                        <a href="' . get_the_permalink() . '"><div class="directory-ad-title">' . esc_html($ad_title) . '</div></a>
                        <a href="javascript:void(0)"> <p><i class="fa fa-map-marker"></i>' . adforest_words_count(get_post_meta(get_the_ID(), '_adforest_ad_location', true), 20) . '</p></a>
                        <span>' . adforest_adPrice(get_the_ID()) . '</span> </div>
                    <div class="prop-estate-table">
                        <ul class="list-inline prop-content-area">
                            <li><i class="fa fa-clock-o"><span class="items">' . get_the_date(get_option('date_format'), get_the_ID()) . '</span></i></li>
                            <li><i class="fa fa-eye"><span class="items">' . adforest_getPostViews(get_the_ID()) . ' ' . __('Views', 'adforest') . '</span></i></li>
                        </ul>
                    </div>
                </div>
            </div>';

            return $html;
        }

        function adforest_search_layout_list($pid, $col = 12) {
            global $adforest_theme;
            $author_id = get_post_field('post_author', $pid);
            $condition_html = '';
            if (isset($adforest_theme['allow_tax_condition']) && $adforest_theme['allow_tax_condition'] && get_post_meta($pid, '_adforest_ad_condition', true) != "") {
                $condition_html = '<div class="ad-stats hidden-xs">
		<span>' . __('Condition', 'adforest') . '  : </span>
		' . get_post_meta($pid, '_adforest_ad_condition', true) . '
		</div>';
            }
            $ad_type_html = '';
            if (get_post_meta($pid, '_adforest_ad_type', true) != "") {
                $ad_type_html = '<div class="ad-stats hidden-xs">
                    <span>' . __('Ad Type', 'adforest') . '  : </span>
                    ' . get_post_meta($pid, '_adforest_ad_type', true) . '
                    </div>';
            }
            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $rtl_fet = 'featured-ribbon';
                if (is_rtl()) {
                    $rtl_fet = 'featured-ribbon-rtl';
                }
                $is_feature = '<div class="' . esc_attr($rtl_fet) . '">
			  <span>' . __('Featured', 'adforest') . '</span>
		   </div>';
            }

            $poster_contact = '';
            if (get_post_meta(get_the_ID(), '_adforest_poster_contact', true) != "" && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'phone' )) {

                $showPhone_to_users = adforest_showPhone_to_users();
                if (!$showPhone_to_users) {
                    $poster_contact = '<li>
                                        <a data-toggle="tooltip" title="' . get_post_meta($pid, '_adforest_poster_contact', true) . '" href="javascript:void(0);" class="fa fa-phone"></a>
                                        </li>';
                                                }
                                            }

                                            $price = '<div class="price">
                                        <span>
                                        ' . adforest_adPrice(get_the_ID()) . '
                                        </span> 
                                        </div>';

            $output = '<li>
				<div class="well ad-listing clearfix">
				<div class="col-md-3 col-sm-5 col-xs-12 grid-style no-padding">';
            $img = adforest_get_ad_default_image_url('adforest-ad-related');
            $media = adforest_get_ad_images($pid);
            $total_imgs = count($media);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;

                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $img = $image[0];
                    break;
                }
            }else {
                $img = adforest_get_ad_default_image_url('adforest-ads-medium');
            }
            $output .= '<div class="img-box">
	' . adforest_video_icon() . '
            ' . $is_feature . '
                <img src="' . esc_url($img) . '" class="img-responsive" alt="' . get_the_title() . '">
                <div class="total-images">
                <strong>' . esc_html($total_imgs) . '</strong>
                ' . __('photos', 'adforest') . '
                </div>
                <div class="quick-view">
                <a href="' . get_the_permalink() . '" class="view-button"><i class="fa fa-search"></i></a>
                </div>';

            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $output .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }

            $output .= '</div>
	<div class="user-preview">
	<a href="' . adforest_set_url_param(get_author_posts_url($author_id), 'type', 'ads') . '">
	<img src="' . adforest_get_user_dp($author_id) . '" class="avatar avatar-small" alt="' . get_the_title() . '">
	</a>
	</div>
	</div>
	<div class="col-md-9 col-sm-7 col-xs-12">
	<!-- Ad Content-->
	<div class="row">
	<div class="content-area">
	<div class="col-md-9 col-sm-12 col-xs-12">
	';
            $cats_html = '';
            $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
            $it_one = 1;
            foreach ($post_categories as $c) {
                $cls = '';
                if ($it_one != 1)
                    $cls = 'padding-left';
                $cat = get_term($c);
                $cats_html .= '<span><a class="' . $cls . '" href="' . get_term_link($cat->term_id) . '">' . esc_html($cat->name) . '</a></span>';
                $it_one++;
            }
            $output .= '
	<div class="category-title">
	' . $cats_html . '
	</div>
	<!-- Ad Title -->
	<h3>
	<a href="' . get_the_permalink() . '">
	' . get_the_title() . '
	</a>
	</h3>
	<ul class="additional-info pull-right">
	' . $poster_contact . '
	<li>
	<a data-toggle="tooltip" title="' . __('Save', 'adforest') . '" href="javascript:void(0);" class="fa fa-heart save-ad" data-adid="' . esc_attr($pid) . '"></a>
	</li>
	</ul>
	<ul class="ad-meta-info">
	<li> <i class="fa fa-map-marker"></i>
	<a href="javascript:void(0);">
	' . get_post_meta($pid, '_adforest_ad_location', true) . '
	</a>
	</li>
	<li> <i class="fa fa-clock-o"></i>
	' . get_the_date(get_option('date_format'), $pid) . '
	</li>
	</ul>
	<div class="ad-details">
	<p>' . adforest_words_count(get_the_excerpt(), 150) . '</p>
	</div>
	</div>
	<div class="col-md-3 col-xs-12 col-sm-12">
	<!-- Ad Stats -->
	<div class="short-info">
	' . $ad_type_html . '
	' . $condition_html . '
	<div class="ad-stats hidden-xs">
	<span>' . __('Visits', 'adforest') . '  : </span>
	' . adforest_getPostViews($pid) . '
	</div>
	</div>
	<!-- Price -->
	' . $price . '
	<!-- Ad View Button -->
	<a href="' . get_the_permalink() . '" class="btn btn-block btn-theme">
	<i class="fa fa-eye" aria-hidden="true"></i>
	' . __('View Ad', 'adforest') . '
	</a>
	</div>
	</div>
	</div>
	<!-- Ad Content End -->
	</div>
	</div>
	</li>
	';
            return $output;
        }

        function adforest_search_layout_list_1($pid) {
            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $cats_html = adforest_display_cats($pid);

            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;

                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $img = '<img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive">';
                    break;
                }
            }
            else {
                $img = '<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-responsive">';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $rtl_fet = 'featured-ribbon';
                if (is_rtl()) {
                    $rtl_fet = 'featured-ribbon-rtl';
                }
                $is_feature = '<div class="' . esc_attr($rtl_fet) . '">
			  <span>' . __('Featured', 'adforest') . '</span>
		   </div>';
            }

            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);
            ;

            $warranty = '';
            if (get_post_meta(get_the_ID(), '_adforest_ad_warranty', true) != "" && isset($adforest_theme['allow_tax_warranty']) && $adforest_theme['allow_tax_warranty']) {
                $warranty = '<li>
						<a href="javascript:void(0);"> <i class="flaticon-ribbon-badge"></i>
					' . get_post_meta(get_the_ID(), '_adforest_ad_warranty', true) . '
					</a>
					<li>';
            }
            $condition_html = '';
            if (isset($adforest_theme['allow_tax_condition']) && $adforest_theme['allow_tax_condition'] && get_post_meta(get_the_ID(), '_adforest_ad_condition', true) != "") {
                $condition_html = '<li>
					 <a href="javascript:void(0);"><i class="flaticon-check-square"></i>
					 ' . get_post_meta(get_the_ID(), '_adforest_ad_condition', true) . '
					 </a>
					 </li>';

                $modern_feature = '';
                if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern') {
                    $modern_feature = $is_feature;
                    $is_feature = '';
                }
            }

            $poster_contact = '';
            if (get_post_meta(get_the_ID(), '_adforest_poster_contact', true) != "" && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'phone' )) {
                $poster_contact = '<li> <a href="javascript:void(0);"><i class="flaticon-phone-call"></i>
					 ' . get_post_meta(get_the_ID(), '_adforest_poster_contact', true) . '
					 </a>
					 </li>';
            }
            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }


            return '
			<div class="item list-group-items col-md-6 col-sm-6 col-xs-12 clearfix">
            <div class="category-grid-box-1">
			' . $modern_feature . '
               <!-- Image Box -->
               <div class="image">
			   ' . adforest_video_icon() . '
			   timer' . $timer_html . '
                  <a href="' . get_the_permalink() . '">' . $img . '</a>
                  <div class="price-tag">
                     <div class="price"><span>
					 ' . adforest_adPrice(get_the_ID()) . '
					 </span>
					 </div>
                  </div>
               </div>
               <!-- Short Description -->
               <div class="short-description-1 clearfix">
			   ' . $is_feature . '
                  <!-- Category Title -->
                  <div class="category-title">' . $cats_html . '</div>
                  <!-- Ad Title -->
                  <h2><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>
                  <!-- Short Description -->
                  <p class="list-group-item-text">' . adforest_words_count(get_the_excerpt(), 150) . '</p>
                  <!-- Ad Meta Info -->
                  <ul class="ad-meta-info">
					 ' . $warranty . '
					 ' . $condition_html . '
                     ' . $poster_contact . '
                  </ul>
               </div>
               <!-- Ad Meta Stats -->
               <div class="ad-info-1">
                  <ul>
                     <li> <i class="fa fa-map-marker"></i>
					 ' . get_post_meta(get_the_ID(), '_adforest_ad_location', true) . '
					  </li>
                     <li> <i class="fa fa-clock-o"></i>
					 ' . get_the_date(get_option('date_format'), get_the_ID()) . '
					 </li>
                     <li class="views"> <i class="fa fa-eye"></i>
					 ' . adforest_getPostViews(get_the_ID()) . " " . __('Views', 'adforest') . '
					 </li>
                  </ul>
                  <!-- View All Button -->
                  <div class="detail-button">
				  <a href="' . get_the_permalink() . '">' . __('View Details', 'adforest') . '</a>
				  </div>
               </div>
            </div>
         </div>
		';
        }

        function adforest_search_layout_list_2($pid, $is_show = true, $cols = '') {
            $number = 0;
            global $adforest_theme;
            $cats_html = adforest_display_cats($pid);

            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;

                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $img = '<img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive">';
                    break;
                }
            }
            else {
                $img = '<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-responsive">';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $rtl_fet = 'featured-ribbon';
                if (is_rtl()) {
                    $rtl_fet = 'featured-ribbon-rtl';
                }


                $is_feature = '<div class="' . esc_attr($rtl_fet) . '">
			  <span>' . __('Featured', 'adforest') . '</span>
		   </div>';
            }

            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);
            ;

            $warranty = '';
            if (get_post_meta(get_the_ID(), '_adforest_ad_warranty', true) != "" && isset($adforest_theme['allow_tax_warranty']) && $adforest_theme['allow_tax_warranty']) {

                $warranty = ' <li><div class="custom-tooltip tooltip-effect-4">
						<span class="tooltip-item"><i class="fa fa-check-square-o"></i></span>
						<div class="tooltip-content"> 
						<strong>' . __('Warranty', 'adforest') . '</strong>
						<span class="label label-danger">' . get_post_meta(get_the_ID(), '_adforest_ad_warranty', true) . '</span> </div>
					 </div>
				  </li>';
            }
            $condition = '';
            if (isset($adforest_theme['allow_tax_condition']) && $adforest_theme['allow_tax_condition'] && get_post_meta(get_the_ID(), '_adforest_ad_condition', true) != "") {



                $condition = ' <li>
						 <div class="custom-tooltip tooltip-effect-4">
							<span class="tooltip-item"><i class="fa fa-cog"></i></span>
							<div class="tooltip-content">
							<strong>' . __('Condition', 'adforest') . '</strong>
							<span class="label label-danger">
							' . get_post_meta(get_the_ID(), '_adforest_ad_condition', true) . '
							</span>
							</div>
						 </div>
					  </li>';
            }

            $list_col_1 = 'col-lg-5 col-md-5 col-sm-5 no-padding';
            $list_col_2 = 'col-lg-7 col-md-7 col-sm-7 no-padding';
            $modern_feature = '';
            if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern') {
                $list_col_1 = 'col-lg-4 col-md-4 col-sm-4 no-padding';
                $list_col_2 = 'col-lg-8 col-md-8 col-sm-8 no-padding';
                $modern_feature = $is_feature;
                $is_feature = '';
            }
            if ($cols != "") {
                $list_col_1 = 'col-lg-3 col-md-3 col-sm-3 no-padding';
                $list_col_2 = 'col-lg-9 col-md-9 col-sm-9 no-padding';
            }

            $poster_contact = '';
            if (get_post_meta(get_the_ID(), '_adforest_poster_contact', true) != "" && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'phone' )) {

                $showPhone_to_users = adforest_showPhone_to_users();
                if (!$showPhone_to_users) {
                    $poster_contact = '<li>
				<div class="custom-tooltip tooltip-effect-4">
					<span class="tooltip-item"><i class="fa fa-phone"></i></span>
					<div class="tooltip-content">
					   <h4>' . get_post_meta(get_the_ID(), '_adforest_poster_contact', true) . '</h4>
					</div>
				 </div>
			  </li>';
                }
            }

            $options_html = '';
            if ($is_show) {
                $options_html = '<ul class="add_info">
		  <!-- Contact Details -->
		 ' . $poster_contact . '
		  <li>
			 <div class="custom-tooltip tooltip-effect-4">
				<span class="tooltip-item"><i class="fa fa-map-marker"></i></span>
				<div class="tooltip-content">
				   ' . get_post_meta(get_the_ID(), '_adforest_ad_location', true) . '
				</div>
			 </div>
		  </li>
		  ' . $condition . '
			' . $warranty . '
	   </ul>';
            }
            if (isset($_GET['view-type']) && $_GET['view-type'] == 'list') {
                if (isset($adforest_theme['search_design']) && $adforest_theme['search_design'] == 'map') {
                    $options_html = '';
                }
            }

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }

            return '
			<div class="ads-list-archive">
                                 <!-- Image Block -->
                                 <div class="' . esc_attr($list_col_1) . '">
                                    <!-- Img Block -->
                                    <div class="ad-archive-img list-3">
									' . $modern_feature . '
									' . adforest_video_icon() . '
									' . $timer_html . '
                                       <a href="' . get_the_permalink() . '">
                                          ' . $img . '
										  ' . $is_feature . '
                                       </a>
                                    </div>
                                    <!-- Img Block -->
                                 </div>
                                 <!-- Ads Listing -->
                                 <div class="clearfix visible-xs-block"></div>
                                 <!-- Content Block -->
                                 <div class="' . esc_attr($list_col_2) . '">
                                    <!-- Ad Desc -->
                                    <div class="ad-archive-desc">
                                       <!-- Price -->
                                       <div class="ad-price">
									   ' . adforest_adPrice(get_the_ID()) . '
									   </div>
                                       <!-- Title -->
                                       <h2><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>
                                       <!-- Category -->
                                       <div class="category-title">' . $cats_html . '</div>
                                       <!-- Short Description -->
                                       <div class="clearfix visible-xs-block"></div>
                                       <p class="hidden-sm">' . adforest_words_count(get_the_excerpt(), 110) . '</p>
                                       <!-- Ad Features -->
                                       ' . $options_html . '
                                       <!-- Ad History -->
                                       <div class="clearfix archive-history">
                                          <div class="last-updated">' . __('Posted', 'adforest') . ': ' . get_the_date(get_option('date_format'), get_the_ID()) . '</div>
                                          <div class="ad-meta">
										  <a href="' . get_the_permalink() . '" class="btn btn-theme"><i class="fa fa-phone"></i> ' . __('View Details', 'adforest') . '</a>
										   </div>
                                       </div>
                                    </div>
                                    <!-- Ad Desc End -->
                                 </div>
                                 <!-- Content Block End -->
                              </div>
		';
        }

        function adforest_search_layout_list_3($pid) {
            $number = 0;
            global $adforest_theme;
            $cats_html = adforest_display_cats($pid);

            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;

                    $image = wp_get_attachment_image_src($mid, 'adforest-category');
                    $img = '<img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive">';
                    break;
                }
            }
            else {
                $img = '<img src="' . adforest_get_ad_default_image_url('adforest-category') . '" alt="' . get_the_title() . '" class="img-responsive">';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $ribbion = 'featured-ribbon';
                if (is_rtl()) {
                    $ribbion = 'featured-ribbon-rtl';
                }
                $is_feature = '<div class="' . esc_attr($ribbion) . '">
			  <span>' . __('Featured', 'adforest') . '</span>
		   </div>';
            }

            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);
            ;

            $warranty = '';
            if (get_post_meta(get_the_ID(), '_adforest_ad_warranty', true) != "" && isset($adforest_theme['allow_tax_warranty']) && $adforest_theme['allow_tax_warranty']) {

                $warranty = ' <li><div class="custom-tooltip tooltip-effect-4">
						<span class="tooltip-item"><i class="fa fa-check-square-o"></i></span>
						<div class="tooltip-content"> 
						<strong>' . __('Warranty', 'adforest') . '</strong>
						<span class="label label-danger">' . get_post_meta(get_the_ID(), '_adforest_ad_warranty', true) . '</span> </div>
					 </div>
				  </li>';
            }
            $condition = '';
            if (isset($adforest_theme['allow_tax_condition']) && $adforest_theme['allow_tax_condition'] && get_post_meta(get_the_ID(), '_adforest_ad_condition', true) != "") {



                $condition = ' <li>
						 <div class="custom-tooltip tooltip-effect-4">
							<span class="tooltip-item"><i class="fa fa-cog"></i></span>
							<div class="tooltip-content">
							<strong>' . __('Condition', 'adforest') . '</strong>
							<span class="label label-danger">
							' . get_post_meta(get_the_ID(), '_adforest_ad_condition', true) . '
							</span>
							</div>
						 </div>
					  </li>';
            }

            $modern_feature = '';
            if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern') {
                $modern_feature = $is_feature;
                $is_feature = '';
            }

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }


            return '
		<li class="ad">
                                 <div class="content-zone">
								 
                                    <div class="col-md-4 col-sm-4 col-xs-12">
									' . $is_feature . '
                                       <div class="img-zone">
									   ' . $modern_feature . '
									   ' . adforest_video_icon() . '
									   ' . $timer_html . '
                                          ' . $img . '
                                          <div class="quick-view">
										  <a href="' . get_the_permalink() . '" class="view-button">
										  <i class="fa fa-search"></i>
										  </a>
										  </div>
                                       </div>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                       <div class="short-description-1 ">
									   
                                          <!-- Category Title -->
                                          <div class="category-title">' . $cats_html . '</div>
                                          <!-- Ad Title -->
                                          <h2><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>
										<ul class="list-3-short-info list-inline">
										  <li><a href="javascript:void(0);"> <i class="fa fa-map-marker"></i> 
													' . get_post_meta(get_the_ID(), '_adforest_ad_location', true) . '</a></li>
										  <li><a href="javascript:void(0);"> <i class="fa fa-clock-o"></i> 
													' . get_the_date(get_option('date_format'), get_the_ID()) . ' </a></li>
										</ul>		
										<p class="hidden-sm">' . adforest_words_count(get_the_excerpt(), 110) . '</p>
										  
										  
                                          <!-- Price -->
										  <span class="ad-price">
										  ' . adforest_adPrice(get_the_ID()) . '
										  </span> 
                                       </div>
                                    </div>
                                 </div>
                              </li>
		';
        }

    }

}
?>