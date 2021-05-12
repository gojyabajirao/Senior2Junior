<?php
/* Template Name: All Seller/Buyer */ 
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Adforest
 */

?>
<?php get_header(); ?>

<div class="main-content-area clearfix">
<section class="description-animated-section">
    <div class="container">
      <div class="row">
      <?php
	  	global $adforest_theme;
		
		$result = count_users();
		$total_users = isset( $result['total_users'] ) ? $result['total_users'] : 50;
		
		
		// grab the current page number and set to 1 if no page number is set
		$page = (get_query_var('page')) ? get_query_var('page') : 1;
		
		// how many users to show per page
		$users_per_page = isset( $adforest_theme['users_per_page'] ) ? $adforest_theme['users_per_page'] : 12;
		
		// calculate the total number of pages.
		$total_pages = 1;
		$offset = $users_per_page * ($page - 1);
		$total_pages = ceil($total_users / $users_per_page);
		
		
		// main user query
		$args  = array(
			// order results by display_name
			'orderby'   => 'display_name',
			'number'    => $users_per_page,
			'offset'    => $offset // skip the number of users that we have per page  
		);
		
		// Create the WP_User_Query object
		$wp_user_query = new WP_User_Query($args);
		
		// Get the results
		$users = $wp_user_query->get_results();
		$counter = 1;
		foreach ( $users as $user )
		{
			$user_pic =	adforest_get_user_dp( $user->ID, 'adforest-user-profile' );
			$user_type = '';
			$cls	= '';
			if( get_user_meta( $user->ID, '_sb_user_type', true ) == 'Indiviual' )
			{
				$user_type = __('Individual', 'adforest');
				$cls	= 	'h-ribbon-ind';
			}
			else if( get_user_meta( $user->ID, '_sb_user_type', true ) == 'Dealer' )
			{
				$user_type = __('Dealer', 'adforest');
				$cls	= 	'h-ribbon';	
			}
			
			$ribbon_html	=	'';
			if( $user_type != "" )
			{
				$ribbon_html	=	'<div class="'.esc_attr( $cls ) .'"><span>'.$user_type.'</span></div>';
			}
		?>
        <div class="col-lg-3 col-sm-6">
          <div class="description-main-product">
            <div class="description-box">
            <?php echo adforest_returnEcho($ribbon_html); ?>
            <a href="<?php echo adforest_set_url_param(get_author_posts_url( $user->ID ),'type','ads') ; ?>">
            <img src="<?php echo esc_attr($user_pic); ?>" alt="<?php echo esc_attr( $user->display_name ) ; ?>" class="img-responsive">
            </a>
            </div>
            <div class="description-heading-product">
            <?php
				$username = $user->display_name;
				if( $username == "")
				{
					$username	=	$user->user_login;
				}
			?>
              <h2><a href="<?php echo adforest_set_url_param(get_author_posts_url( $user->ID ),'type','ads') ; ?>"><?php echo esc_html( $username ) ; ?></a></h2>
            </div>
            <div class="paralell-box-description">
              <div class="product-icon-description-icons">
              <a href="<?php echo adforest_set_url_param(get_author_posts_url( $user->ID ),'type',1); ?>">
              	<?php
					$got	=	get_user_meta($user->ID, "_adforest_rating_avg", true );
					$total 	=	0;
					if( $got == "" )
						$got = 0;
						for( $i = 1; $i<=5; $i++ )
						{
							if( $i <= round( $got ) )
								echo '<i class="fa fa-star"></i>';
							else
								echo '<i class="fa fa-star-o"></i>';	
								
								$total++;
						}
						$ratings 	=	adforest_get_all_ratings($user->ID);
				?>
                </a>
              </div>
              <div class="description-short-text">
                <?php echo esc_html( count($ratings ) . " "  . __('Reviews', 'adforest' ) ); ?>
              </div>
            </div>
            <div class="description-social-media-icons">
            
            <?php
			$profiles	=	adforest_social_profiles();
            foreach( $profiles as $key => $value )
            {
                if( get_user_meta( $user->ID, '_sb_profile_' . $key, true ) != "" )
                {
					echo '<a href="'.esc_url( get_user_meta( $user->ID, '_sb_profile_' . $key, true ) ).'" target="_blank"><i class="fa fa-'.$key.'"></i></a>';
				}
			}
			?>
            </div>
          </div>
        </div>
        <?php
		if( $counter % 4 == 0 )
		{
			echo('<div class="clearfix"></div>');	
		}
		$counter++;
		}
		?>
        
        <div class="col-md-12 col-xs-12 col-sm-12 margin-top-20">
			   <?php
				echo adforest_comments_pagination( $total_pages ,$page);
			   ?>
        </div>
      </div>
      
    </div>
  </section>
</div>
<!--footer section-->
<?php get_footer(); ?>