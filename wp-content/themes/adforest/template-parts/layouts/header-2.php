<?php global $adforest_theme;?>
<!-- Header -->
<?php get_template_part('template-parts/layouts/top', 'bar');?>
<div class="sb-black-header">
<div class="sb-header">
    <div class="row">
        <div class="container">
            <!-- Logo -->
            <div class="col-md-3 col-sm-12 col-xs-12 no-padding">
                <div class="logo">
                    <?php get_template_part('template-parts/layouts/site', 'logo');?>
                </div>
            </div>
            <!-- Category -->
            <div class="col-md-7 col-sm-9 col-xs-12">
                <?php
                if (isset($adforest_theme['search_in_header']) && $adforest_theme['search_in_header']) {
                    ?>
                    <?php
                    $search_title = '';
                    if (isset($_GET['ad_title']) && $_GET['ad_title'] != "")
                        $search_title = $_GET['ad_title'];
                    $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
                    ?>
                    <form method="get" action="<?php echo urldecode(get_the_permalink($sb_search_page));?>">
                        <div class="input-group">
                            <input placeholder="<?php echo __('What Are You Looking For ?', 'adforest');?>" type="text" name="ad_title" class="form-control" value="<?php echo esc_attr($search_title);?>" autocomplete="off"><span class="input-group-btn">
                                <?php apply_filters('adforest_form_lang_field', true)?>
                                <button class="btn btn-default" type="submit"><?php echo __('Search', 'adforest');?></button>
                            </span> 
                        </div>
                    </form>  
                    <?php
                }
                ?>
            </div>
            <!-- Post Button -->
            <div class="col-md-2 col-sm-3 no-padding col-xs-12">
                <?php
                if (isset($adforest_theme['ad_in_menu']) && $adforest_theme['ad_in_menu']) {
                    $btn_text = __('Post an Ad', 'adforest');
                    if (isset($adforest_theme['ad_in_menu_text']) && $adforest_theme['ad_in_menu_text'] != "") {
                        $btn_text = $adforest_theme['ad_in_menu_text'];
                    }
                    $sb_post_ad_page = apply_filters('adforest_ad_post_verified_id', $adforest_theme['sb_post_ad_page']); // phone verification redirection
                    $sb_post_ad_page = apply_filters('adforest_language_page_id', $sb_post_ad_page);
                    $sb_ad_post_url = isset($sb_post_ad_page) && !empty($sb_post_ad_page) ? apply_filters('adforest_ad_post_verified_link',get_the_permalink($sb_post_ad_page)) : home_url('/');
                    ?>
                    <a href="<?php echo esc_url($sb_ad_post_url);?>" class="btn btn-orange btn-block">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        <?php echo esc_html($btn_text);?>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="sb-elegent-black">
    <div class="sb-main-menu">
        <!-- Navigation Bar -->
        <nav id="menu-1" class="mega-menu">
            <!-- menu list items container -->
            <section class="menu-list-items">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <!-- menu logo -->
                            <ul class="menu-logo">
                                <li>
                                    <?php get_template_part('template-parts/layouts/site', 'logo');?>
                                </li>
                            </ul>
                            <!-- menu links -->
                            <?php get_template_part('template-parts/layouts/main', 'nav');?>
                            <ul class="menu-search-bar hidden">
                                <li class="hidden-xs">
                                    <?php get_template_part('template-parts/layouts/ad', 'button');?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>      
            </section>
        </nav>
    </div>
    <div class="clearfix"></div>
</div>
</div>	