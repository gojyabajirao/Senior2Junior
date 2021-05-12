<?php
$pid = get_the_ID();
$uid = get_current_user_id();
global $adforest_theme;
if (get_post_status($pid) != 'publish') {
    $not_msg = ( get_post_status($pid) == 'pending' ) ? __('Waiting for admin approval.', 'adforest') : __('Under process by user and only admin can view this.', 'adforest')
    ?>
    <div role="alert" class="alert alert-info alert-dismissible <?php echo adforest_alert_type(); ?>">
        <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&#10005;</span></button>
        <?php echo esc_html($not_msg); ?>
    </div>
    <?php
    return;
}
$sb_packages_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_packages_page']);
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && get_current_user_id() != "" && get_post_meta($pid, '_adforest_is_feature', true) == '0' && get_post_meta($pid, '_adforest_ad_status_', true) == 'active') {
    if (get_post_field('post_author', $pid) == $uid) {
        if (get_user_meta($uid, '_sb_featured_ads', true) != 0) {
            if (get_user_meta($uid, '_sb_expire_ads', true) != '-1') {
                if (get_user_meta($uid, '_sb_expire_ads', true) < date('Y-m-d')) {
                    ?>
                    <div role="alert" class="alert alert-info alert-dismissible <?php echo adforest_alert_type(); ?>">
                        <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&#10005;</span></button>
                        <?php echo __('Your package has been expired, please subscribe the package to make it featured AD. ', 'adforest') . " "; ?>
                        <a href="<?php echo get_the_permalink($sb_packages_page); ?>" class="sb_anchor">
                            <?php echo __('Packages. ', 'adforest'); ?>
                        </a>
                    </div>
                    <?php
                } else {
                    echo adforest_get_feature_text($pid);
                }
            } else {
                echo adforest_get_feature_text($pid);
            }
        } else {
            ?>
            <div role="alert" class="alert alert-info alert-dismissible <?php echo adforest_alert_type(); ?>">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&#10005;</span></button>
                <strong><?php echo __('Info', 'adforest'); ?></strong> - 
                <?php echo __('Get your ad featured - visit our ', 'adforest') . " "; ?>
                <a href="<?php echo get_the_permalink($sb_packages_page); ?>" class="sb_anchor"><?php echo __('Packages. ', 'adforest'); ?></a>
            </div>
            <?php
        }
    }
}
?>