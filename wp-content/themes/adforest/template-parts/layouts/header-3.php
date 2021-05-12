<?php
global $adforest_theme;
?>
<!-- =-=-=-=-=-=-= Light Header =-=-=-=-=-=-= -->
<div class="colored-header modern-type-2">
    <?php get_template_part('template-parts/layouts/top', 'bar'); ?>
    <!-- Navigation Menu -->
    <div class="clearfix"></div>
	
	<div class="sb-baner-header">
    <!-- menu start -->
    <div class="sb-header-middle">
        <div class="container">
            <div class="row">

                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="widget sb-ad-logo">
                        <?php get_template_part('template-parts/layouts/site', 'logo'); ?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8">
                    <div class="widget">
                        <?php
                        if (isset($adforest_theme['with_ad_720_90']) && $adforest_theme['with_ad_720_90'] != "") {
                            echo adforest_returnEcho($adforest_theme['with_ad_720_90']);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- menu end -->
    <nav id="menu-1" class="mega-menu">
        <!-- menu list items container -->
        <section class="menu-list-items">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <!-- menu logo -->
                        <ul class="menu-logo">
                            <li>
                                <?php get_template_part('template-parts/layouts/site', 'logo'); ?>
                            </li>
                        </ul>
                        <!-- menu links -->
                        <?php get_template_part('template-parts/layouts/main', 'nav'); ?>
                        <ul class="menu-search-bar">
                            <li>
                                <?php get_template_part('template-parts/layouts/ad', 'button'); ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </nav>  
		
		
	</div>		


</div>