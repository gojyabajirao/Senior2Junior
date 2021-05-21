<?php
$sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
?>

<div class="col-md-4 col-xs-12 col-sm-6">
    <form method="get" action="<?php echo urldecode(get_the_permalink($sb_search_page));?>" id="search_cats_w">
        <div class="form-group">
            <label><?php
                $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
                echo esc_html($title);
                ?>
            </label>
            <?php
            $cur_cat_id = '';
            $main_cat = '';
            $term_title = '';
            if (isset($_GET['cat_id']) && $_GET['cat_id'] != "") {
                $cur_cat_id = $_GET['cat_id'];
                $term = get_term($cur_cat_id, 'ad_cats');
                $term_title = '- ' . $term->name;
            }
            if (isset($_GET['cat_id']) && $_GET['cat_id'] != "") {
                $main_cat = $_GET['cat_id'];
            }
            ?>
            <small><?php echo esc_html($term_title);?></small>
            <select class="category form-control" id="ad_cats">
                <option label=""></option>
                <?php
                $ad_cats = adforest_get_cats('ad_cats', 0);
                foreach ($ad_cats as $ad_cat) {
                    $category = get_term($ad_cat->term_id);
                    $count = $category->count;
                    
                    
                    ?>
                    <option value="<?php echo esc_attr($ad_cat->term_id);?>" <?php
                    if ($main_cat == $ad_cat->term_id) {
                        echo esc_attr("selected");
                    }
                    ?>>
                        <?php echo esc_html($ad_cat->name);?>(<?php echo adforest_returnEcho($count);?>)
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>
        <?php
        echo adforest_search_params('cat_id');
        apply_filters('adforest_form_lang_field', true);
        ?>
        <input type="hidden" name="cat_id" id="cat_id" value="" />

    </form>
    <?php
    adforest_widget_counter();
    ?>
</div>
<?php adforest_advance_search_container();?>