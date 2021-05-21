<?php global $adforest_theme; ?>
<a href="<?php echo home_url('/'); ?>">
    <?php
    
    $transparent_flag = false;
    if ($adforest_theme['sb_header'] == 'transparent-2' || $adforest_theme['sb_header'] == 'transparent-3' || $adforest_theme['sb_header'] == 'modern' || $adforest_theme['sb_header'] == 'transparent') {
     $transparent_flag = true;  
    }
    
    if (is_singular('ad_post') && isset($adforest_theme['ad_layout_style_modern']) && $adforest_theme['ad_layout_style_modern'] == '5' && isset($adforest_theme['sb_header']) && $adforest_theme['sb_header'] == 'modern') {
        $logo_url = $adforest_theme['sb_site_logo_for_single']['url'];
    } else if (basename(get_page_template()) == 'page-home.php' && isset($adforest_theme['sb_header']) && $transparent_flag) {
        $logo_url = $adforest_theme['sb_site_logo_for_home']['url'];
    } else if (isset($adforest_theme['sb_site_logo']['url']) && $adforest_theme['sb_site_logo']['url'] != "") {
        $logo_url = $adforest_theme['sb_site_logo']['url'];
    } else {
        $logo_url = esc_url(trailingslashit(get_template_directory_uri())) . 'images/logo.png';
        ?>
        <?php
    }
    ?>
    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr__('Site Logo', 'adforest'); ?>" id="sb_site_logo">
</a>