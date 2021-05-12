<?php global $adforest_theme; ?>
 <footer class="minimal-footer sb-foot-4 text-center <?php echo esc_attr( $adforest_theme['footer_4_bg'] ); ?>">
    <div class="container">
       <ul class="footer-social text-center">
            <?php
                 foreach( $adforest_theme['social_media']  as $index => $val)
                 {
            ?>
            <?php
                     if($val != "")
                     {
			?>
            			<li>
                        <a <?php do_action('adforest_relation_follow_links');?>href="<?php echo esc_url($val); ?>">
                        <span class="<?php echo adforest_social_icons( $index ); ?>"></span>
                        </a>
                        </li>
            <?php
                     }
                 }
			?>
       </ul>
       <p class="copy-rights">
		<?php
            if( isset( $adforest_theme['sb_footer'] ) && $adforest_theme['sb_footer'] != "" )
            {
                echo wp_kses( $adforest_theme['sb_footer'], adforest_required_tags() );
            }
            else
            {
                echo wp_kses( "Copyright 2017 &copy; Theme Created By <a href='https://themeforest.net/user/scriptsbundle/portfolio'>ScriptsBundle</a> All Rights Reserved.", adforest_required_tags() );
            }
        ?>
       </p>
    </div>
 </footer>