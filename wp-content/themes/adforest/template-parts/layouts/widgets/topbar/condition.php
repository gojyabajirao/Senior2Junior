<?php 
$sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
?>
<div class="col-md-4 col-xs-12 col-sm-6">
    <form method="get" action="<?php echo get_the_permalink($sb_search_page); ?>">
        <div class="form-group">
            <label><?php
                $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
                echo esc_html($title);
                ?>
            </label>
            <select class="category form-control submit_on_select" name="condition">
                <option label=""></option>
                <?php
                $conditions = adforest_get_cats('ad_condition', 0);
                foreach ($conditions as $con) {
                    ?>
                    <option value="<?php echo esc_attr($con->name); ?>" <?php if ($cur_con == $con->name) {
                    echo esc_attr("selected");
                } ?>>
                    <?php echo esc_html($con->name); ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>
        <?php
        echo adforest_search_params('condition');
        ?>

    </form>
    <?php
    adforest_widget_counter();
    ?>
</div>
<?php adforest_advance_search_container(); ?>