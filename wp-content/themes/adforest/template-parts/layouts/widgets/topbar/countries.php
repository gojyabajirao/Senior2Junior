<?php
$sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
?>
<div class="col-md-4 col-xs-12 col-sm-6">
    <form method="get" id="search_countries" action="<?php echo urldecode(get_the_permalink($sb_search_page));?>">

        <div class="form-group">
            <label><?php
                $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
                echo esc_html($title);
                ?>
            </label>
            <?php
            $cur_cat_id = '';
            $main_cat = '';
            $current_location = '';
            if (isset($_GET['country_id']) && $_GET['country_id'] != "") {
                $main_cat = $_GET['country_id'];
                $term = get_term($main_cat, 'ad_country');
                $current_location = '- ' . $term->name;
            }
            if (isset($_GET['country_id']) && $_GET['country_id'] != "") {
                $main_cat = $_GET['country_id'];
            }
            ?>
            <small><?php echo esc_html($current_location);?></small>
            <select class="category form-control" id="ad_country">
                <option label=""></option>
                <?php
                $ad_country = adforest_get_cats('ad_country', 0);
                foreach ($ad_country as $ad_catz) {
                    $category = get_term($ad_catz->term_id);
                    $count = $category->count;
                    ?>
                    <option value="<?php echo esc_attr($ad_catz->term_id);?>" <?php
                    if ($main_cat == $ad_catz->term_id) {
                        echo esc_attr("selected");
                    }
                    ?>>
                        <?php echo esc_html($ad_catz->name);?>(<?php echo adforest_returnEcho($count);?>)
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>
        <?php
        echo adforest_search_params('country_id');
        apply_filters('adforest_form_lang_field', true);
        ?>
        <input type="hidden" name="country_id" id="country_id" value="" />

    </form>

    <?php
    adforest_widget_counter();
    ?>
</div>
<?php adforest_advance_search_container();?>