<div class="panel panel-default">
    <!-- Heading -->
    <div class="panel-heading" role="tab" id="headingFive">
        <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                <i class="more-less glyphicon glyphicon-plus"></i>
                <?php echo esc_html($titlee = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title'])); ?>
            </a>
        </h4>
    </div>
    <?php
    if (isset($instance['open_widget']) && $instance['open_widget'] == '1') {
        $expand = 'in';
    }
    global $wp;
    $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
    $sb_search_page = isset($sb_search_page) && $sb_search_page != '' ? get_the_permalink($sb_search_page) : 'javascript:void(0)';
    $sb_search_page = apply_filters('adforest_category_widget_form_action',$sb_search_page);
    ?>
    <form method="get" action="<?php echo adforest_returnEcho($sb_search_page);?>" >
        <!-- Content -->
        <div id="collapseFive" class="panel-collapse collapse <?php echo esc_attr($expand); ?>" role="tabpanel" aria-labelledby="headingFive">
            <div class="panel-body">
                <div class="search-widget">
                    <input placeholder="<?php echo __('search', 'adforest'); ?>" type="text" name="ad_title" value="<?php echo esc_attr($title); ?>" autocomplete="off">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
        <?php
        echo adforest_search_params('ad_title');
        ?>
    </form>
</div>