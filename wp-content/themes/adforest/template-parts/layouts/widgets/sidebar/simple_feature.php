<div class="panel panel-default">
    <!-- Heading -->
    <div class="panel-heading" role="tab" id="headingNine">
        <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseNine" aria-expanded="true" aria-controls="collapseNine">
                <i class="more-less glyphicon glyphicon-plus"></i>
                <?php echo esc_html($title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title'])); ?>
            </a>
        </h4>
    </div>
    <!-- Content -->
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
        <div id="collapseNine" class="panel-collapse collapse <?php echo esc_attr($expand); ?>" role="tabpanel" aria-labelledby="headingNine">
            <div class="panel-body">
                <div class="skin-minimal">
                    <ul class="list">
                        <li>
                            <input tabindex="7" type="radio" id="minimal-radio-sb_1" name="ad" value="0" <?php echo esc_attr($simple); ?>  >
                            <label for="minimal-radio-sb_1" >
                                <?php echo __('Simple Ads', 'adforest'); ?></label>
                        </li>
                        <li>
                            <input tabindex="7" type="radio" id="minimal-radio-sb_2" name="ad" value="1" <?php echo esc_attr($featured); ?>  >
                            <label for="minimal-radio-sb_2" >
                                <?php echo __('Featured Ads', 'adforest'); ?></label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
        echo adforest_search_params('ad');
        ?>
    </form>
</div>