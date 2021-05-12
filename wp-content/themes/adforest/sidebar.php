<?php
global $adforest_theme;
$md_pull = '';
if (isset($adforest_theme['blog_sidebar']) && $adforest_theme['blog_sidebar'] == 'left') {
    $md_pull = 'col-md-pull-8';
}

if(is_single()){
   $md_pull = ''; 
}


?>
<div class="col-md-4 col-xs-12 col-sm-12 <?php echo adforest_returnEcho($md_pull); ?>">
    <div class="blog-sidebar">
        <?php dynamic_sidebar('sb_themes_sidebar'); ?>
    </div>
</div>