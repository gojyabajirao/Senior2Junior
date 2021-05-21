<?php

function sb_load_bread_bg() {
    global $adforest_theme;
    ?>
    <style type="text/css">

        <?php
        if ($adforest_theme['search_breadcrumb_bg']['url'] != "") {
            ?>
            .breadcrumb-1 {
                background: rgba(0, 0, 0, 0) url("<?php echo esc_url($adforest_theme['search_breadcrumb_bg']['url']); ?>") center center no-repeat;
                background-color: #6c6e73;
                background-repeat: no-repeat;
                background-size: cover;
                color: #fff;
                position: relative;
            }
            <?php
        }
        if ($adforest_theme['footer_bg']['url'] != "") {
            ?>

            .footer-area {
                background-color: #232323;
                background-position: center center;
                background-repeat: no-repeat;
                background-size: cover;
                color: #c9c9c9;
                background-image: url("<?php echo esc_url($adforest_theme['footer_bg']['url']); ?>");
                position: relative;
            }
            <?php
        }
        if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'classic' && $adforest_theme['breadcrumb_bg']['url'] != "") {
            ?>

            .page-header-area {
                background: rgba(0, 0, 0, 0) url("<?php echo esc_url($adforest_theme['breadcrumb_bg']['url']); ?>") no-repeat scroll center center / cover !important;
                padding: 50px 0;
                text-align: left;
                position: relative;
            }
            <?php
        }
        if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern' && isset($adforest_theme['sb_header']) && $adforest_theme['sb_header'] == 'modern' && $adforest_theme['breadcrumb_bg_modern_header']['url'] != "" && $adforest_theme['ad_layout_style_modern'] == '5' && is_singular('ad_post')) {
            ?>

            .page-header-area {
                background: rgba(0, 0, 0, 0) url("<?php echo esc_url($adforest_theme['breadcrumb_bg_modern_header']['url']); ?>") repeat !important;
                padding: 25px 0;
                text-align: left;
                padding: 25px 0;

            }
            <?php
        } else if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern' && $adforest_theme['breadcrumb_bg_modern']['url'] != "") {
            ?>

            .page-header-area {
                background: rgba(0, 0, 0, 0) url("<?php echo esc_url($adforest_theme['breadcrumb_bg_modern']['url']); ?>") repeat !important;
                padding: 25px 0;
                text-align: left;
                padding: 25px 0;

            }
            <?php
        }
        ?>
    </style>

    <?php
}

add_action('wp_footer', 'sb_load_bread_bg');

function sb_load_custom_js() {
    ?>
    <script type="text/javascript">
        (function ($) {
            "use strict";
            // Adding email in mailchimp

            $('#processing_req').hide();
            $('#save_email').on('click', function ()
            {
                var sb_email = $('#sb_email').val();
                var sb_action = $('#sb_action').val();
                if (adforest_validateEmail(sb_email))
                {
                    $('#save_email').hide();
                    $('#processing_req').show();
                    $.post('<?php echo admin_url('admin-ajax.php'); ?>',
                            {action: 'sb_mailchimp_subcribe', sb_email: sb_email, sb_action: sb_action}).done(function (response)
                    {
                        $('#processing_req').hide();
                        $('#save_email').show();
                        if (response == 1)
                        {
                            toastr.success('<?php echo adforest_translate('mc_success_msg'); ?>', '<?php echo adforest_translate('cart_success'); ?>!', {timeOut: 2500, "closeButton": true, "positionClass": "toast-bottom-right"});
                            $('#sb_email').val('');
                        } else
                        {
                            toastr.error('<?php echo adforest_translate('mc_error_msg'); ?>', '<?php echo adforest_translate('cart_error'); ?>!', {timeOut: 2500, "closeButton": true, "positionClass": "toast-bottom-right"});
                        }
                    });
                } else
                {
                    toastr.error("<?php echo adforest_translate('email_error_msg'); ?>", "<?php echo adforest_translate('cart_error'); ?>!", {timeOut: 2500, "closeButton": true, "positionClass": "toast-bottom-right"});
                }
            });


        })(jQuery);
        function checkVals()
        {
            return false;
        }

    </script>
    <?php
}

add_action('wp_footer', 'sb_load_custom_js', "100");
