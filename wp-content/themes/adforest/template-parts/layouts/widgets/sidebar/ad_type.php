<div class="panel panel-default">
    <!-- Heading -->
    <div class="panel-heading" role="tab" id="headingSeven">
        <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                <i class="more-less glyphicon glyphicon-plus"></i>
                <?php echo esc_html($title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']));?>
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
        <div id="collapseSeven" class="panel-collapse collapse <?php echo esc_attr($expand);?>" role="tabpanel" aria-labelledby="headingSeven">
            <div class="panel-body">
                <div class="skin-minimal">
                    <ul class="list">
                        <?php
                        $conditions = adforest_get_cats('ad_type', 0);
                        foreach ($conditions as $con) {
                            ?>
                            <li>
                                <input tabindex="7" type="radio" id="minimal-radio-<?php echo esc_attr($con->term_id);?>" name="ad_type" value="<?php echo esc_attr($con->name);?>" <?php
                                       if ($cur_type == $con->name) {
                                           echo esc_attr("checked");
                                       }
                                       ?>  >
                                <label for="minimal-radio-<?php echo esc_attr($con->term_id);?>" ><?php echo esc_html($con->name);?></label>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
        echo adforest_search_params('ad_type');
        ?>
    </form>
</div>