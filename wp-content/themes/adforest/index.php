<?php get_header(); ?>
<?php global $adforest_theme; ?>
<div class="main-content-area clearfix">
    <section class="section-padding error-page pattern-bgs gray ">
        <!-- Main Container -->
        <div class="container">
            <!-- Row -->
            <div class="row">
                <!-- Left Sidebar -->
                
                <!-- Middle Content Area -->
                <!-- Right Sidebar -->
                <?php
                $md_push = '';
                $blog_type = 'col-md-8 col-xs-12 col-sm-12';
                if (isset($adforest_theme['blog_sidebar']) && $adforest_theme['blog_sidebar'] == 'no-sidebar') {
                    $blog_type = 'col-md-12 col-xs-12 col-sm-12';
                } else {
                    if (isset($adforest_theme['blog_sidebar']) && $adforest_theme['blog_sidebar'] == 'left') {
                        $md_push = 'col-md-push-4';
                    }
                        
                    $blog_type = 'col-md-8 col-xs-12 col-sm-12 '.$md_push;
                }
                ?>

                <div class="<?php echo esc_attr($blog_type); ?>">
                    <div class="row">
                        <!-- Blog Archive -->
                        <div class="posts-masonry">
                            <!-- Blog Post-->
                            <?php get_template_part('template-parts/layouts/blog', 'loop'); ?>                       
                        </div>
                        <!-- Pagination -->  
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <?php adforest_pagination(); ?>
                        </div>
                    </div>
                </div>
                <?php
                if (isset($adforest_theme['blog_sidebar']) && $adforest_theme['blog_sidebar'] == 'left')
                    get_sidebar();
                ?>
                <!-- Right Sidebar -->
                <?php
                if (isset($adforest_theme['blog_sidebar']) && $adforest_theme['blog_sidebar'] == 'right')
                    get_sidebar();

                if (!isset($adforest_theme['blog_sidebar']))
                    get_sidebar();
                ?>
                <!-- Middle Content Area  End -->
            </div>
            <!-- Row End -->
        </div>
        <!-- Main Container End -->
    </section>
</div>
<?php get_footer(); ?>