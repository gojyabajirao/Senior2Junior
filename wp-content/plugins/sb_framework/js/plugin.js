(function ($) {
    "use strict";

    $('#ad_catsdiv').hide();
    $('#ad_tagsdiv').hide();
    $('#ad_conditiondiv').hide();
    $('#ad_typediv').hide();
    $('#ad_warrantydiv').hide();
    $('#ad_currencydiv').hide();
    $('#ad_countrydiv').hide();
    
    
    jQuery(document).on('click', '.sb-update-ads-counter', function ()
        {
            if (confirm(jQuery('#sb-admin-confirm').val())) {
                var adforest_ajax_url_admin = jQuery('#sb-admin-ajax').val();
                var sb_data = 'action=adforest_update_ads_counter';
                jQuery('.adforest-spin-load img').show();
                jQuery.ajax({
                    url: adforest_ajax_url_admin,
                    type: "POST",
                    data: sb_data,
                    dataType: "json",
                    success: function (data) {
                        jQuery('.adforest-spin-load img').hide();
                        if (typeof data.status !== 'undefined' && data.status == true) {
                            alert(data.msg);
                            window.location.reload();
                        }
                    },
                    error: function (xhr) {
                        alert('Database updation fails.');
                    }
                });
                return false;
            } else {
                return false;
            }
        });
    
    
    

    jQuery(document).on('click', '#adforest-reject-submit', function (e) {
        
        'use strict';
        
        var reject_reason = jQuery('#rejection-reason').val();
        var ajax_url = jQuery('#ajax-url').val();
        var reject_post_id = jQuery('#reject_post_id').val();
        var redirect_url = jQuery('#redirect-url').val();
        var response_ = jQuery('.rej-response').val();
        jQuery('.rej-response').html('');
        $(".adforest-spinner").show();
        var request = $.ajax({
            url: ajax_url,
            method: "POST",
            data: {
                post_id: reject_post_id,
                ad_reject_reason: reject_reason,
                action: 'adforest_ad_rejection',
            },
            dataType: "json"
        });
        request.done(function (response) {
            $(".adforest-spinner").hide();
            if (typeof response.status !== 'undefined' && response.status == true) {
                jQuery('.rej-response').html('<span>' + response.message + '</span>');
                window.location.href = redirect_url;
            } else {
                jQuery('.rej-response').html('<span>' + response.message + '</span>');
            }
        });

    });


})(jQuery);
function adforest_fresh_install()
{
    var is_fresh_copy = confirm("Are you installating it with fresh copy of WordPress? Please only select OK if it is fresh installation.");
    if (is_fresh_copy)
    {
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: {action: 'demo_data_start', is_fresh: 'yes'}
        }).done(function (msg) {
            //alert( msg );
        });

    }
}
jQuery('.get_user_meta_id').on('click', function ()
{
    is_process = confirm("Are you sure to delete it.");
    if (is_process)
    {
        meta_id = jQuery(this).attr('data-mid');
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: {action: 'sb_delete_user_rating', meta_id: meta_id}
        }).done(function (data) {
            if (data == "1")
            {
                location.reload();
            }
        });

    }
});

jQuery('.bids-in-admin').on('click', function ()
{
    is_process = confirm("Are you sure to delete it.");
    if (is_process)
    {
        meta_id = jQuery(this).attr('data-bid-meta');
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: {action: 'sb_delete_user_bid', meta_id: meta_id}
        }).done(function (data) {
            if (data == "1")
            {
                location.reload();
            }
        });

    }
});




jQuery(document).ready(function () {
    jQuery("#publishing-action").append(jQuery("#reject-btn"));
});

