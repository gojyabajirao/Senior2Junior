<?php
$sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
?>
<div class="col-md-4 col-xs-12 col-sm-6">
    <form method="get" action="<?php echo get_the_permalink($sb_search_page); ?>">
        <div class="form-group">
            <label><?php
                $titlez = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
                echo esc_html($titlez);
                ?>
            </label>
            <div class="input-group add-on">
                <input type="text" name="ad_title" value="<?php echo esc_attr($title); ?>" class="form-control" placeholder="<?php echo esc_html( $titlee = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']) ); ?>" autocomplete="off"  /> 
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>
        </div>
        <?php
        echo adforest_search_params('ad_title');
        ?>
    </form>
    <?php
    adforest_widget_counter();
    ?>
</div>
<?php adforest_advance_search_container(); ?>