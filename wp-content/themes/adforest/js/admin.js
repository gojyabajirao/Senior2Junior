(function ($) {
    "use strict";

    // verifying Purchase code...
    $('#verify_it').on('click', function ()
    {
        var purchase_code = document.getElementById('adforest_code').value;
        if (purchase_code != "")
        {
            $.post(ajaxurl, {action: 'verify_code', code: purchase_code}).done(function (response)
            {
                $('#adforest_code').val('');
                if ($.trim(response) == 'Looks good, now you can install required plugins.')
                {
                    alert(response);
                    location.reload();

                } else
                {
                    alert(response);
                }
            });
        }
    });



    jQuery(document).ready(function ($) {

        jQuery(document).on('click', '.wpb-textinput.cats_cat, .wpb-textinput.cats_d_cat, .wpb-textinput.cats_round_cat, .wpb-textinput.catsm_cat', function ()
        {
            var $this = jQuery(this);

            $this.attr('autocomplete', 'off');
            $this.addClass('sb-input-loading');
            var adforest_ajax_url_admin = jQuery('#sb-admin-ajax').val();
            var sb_data = 'action=adforest_term_autocomplete';
            jQuery.ajax({
                url: adforest_ajax_url_admin,
                type: "POST",
                data: sb_data,
                dataType: "json",
                success: function (data) {
                    $this.removeClass('sb-input-loading');
                    jQuery('.sb-admin-dropdown').remove();
                    $this.after(data);
                },
                error: function (xhr) {
                    alert('Ajax request fail');
                }
            });
            return false;

        });

        jQuery(document).on('click', '.sb-select-term', function ()
        {
            var selected_val = jQuery(this).data('sb-term-value');
            jQuery(this).closest("div.edit_form_line").find("input[name='cats_cat'], input[name='cats_d_cat'], input[name='cats_round_cat'], input[name='catsm_cat']").val(selected_val);
            jQuery(this).closest(".sb-admin-dropdown").remove();
        });

    });

})(jQuery);




