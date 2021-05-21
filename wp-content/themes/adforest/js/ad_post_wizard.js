/*
 Template: AdForest | Largest Classifieds Portal
 Author: ScriptsBundle
 Version: 1.0
 Designed and Development by: ScriptsBundle
 */
(function ($) {
    "use strict";
    var adforest_ajax_url = $('#adforest_ajax_url').val();
    var adforest_map_type = $('#adforest_map_type').val();



    // Step show event 
    var map_counter = 1;
    var show_preview = 1;
    $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection, stepPosition) {
        if (stepPosition === 'first')
        {
            $("#prev-btn").addClass('disabled');
        } else if (stepPosition === 'final')
        {
            $("#next-btn").addClass('disabled');
            $('.submit_ad_now').show();
            $('.preview_ad_now').show();
            if (map_counter == 1)
            {
                if ($("#is_allow_map").val() == "1" && adforest_map_type == 'google_map')
                {
                    setTimeout(function () {
                        my_g_map(markers);
                        map_counter++;
                    }, 1000);
                }

            }
        } else
        {
            $("#prev-btn").removeClass('disabled');
            $("#next-btn").removeClass('disabled');
        }
    });

    // Toolbar extra buttons
    var btnFinish = $('<button style="display:none;" type="submit" class="submit_ad_now" data-btn-val="1"></button>').text($('#wizard_submit').val())
            .addClass('btn btn-success');
    var btnPreview = $('<button style="display:none;" type="submit" class="preview_ad_now" data-btn-val="0"></button>').text($('#wizard_preview').val())
            .addClass('btn btn-info');


    var btn_position_wizard = 'right';
    if ($('#is_rtl').val() != "" && $('#is_rtl').val() == "1")
    {
        btn_position_wizard = 'left';
    }

    // Smart Wizard
    $('#smartwizard').smartWizard({
        selected: 0,
        theme: $('#post_ad_layout').val(),
        transitionEffect: 'fade',
        showStepURLhash: false,
        keyNavigation: false,
        lang: {// Language variables
            next: $('#wizard_next').val(),
            previous: $('#wizard_previous').val(),
        },
        toolbarSettings: {
            toolbarPosition: 'both',
            toolbarButtonPosition: btn_position_wizard,
            toolbarExtraButtons: [btnFinish]
        }
    });
    $("#smartwizard").on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {
        $('.ad_errors').hide();
        if (stepDirection == 'backward' && stepNumber != 2)
        {
            $('.parsley-errors-list').hide();
            return true;
        }
        var is_error = false;
        $('.parsley-errors-list').show();
        $("#step-" + stepNumber + " :input[data-parsley-required='true']").each(function (index, element)
        {
            if ($(this).val() == "")
            {
                is_error = true;

            }
            if ($(this).attr('id') == 'ad_price')
            {
                var ex = /^[0-9]+\.?[0-9]*$/;
                if (ex.test($(this).val()) == false)
                {
                    is_error = true;
                }
            }
            if ($(this).attr('id') == 'ad_yvideo')
            {
                var ex = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
                if (ex.test($(this).val()) == false)
                {
                    is_error = true;
                }
            }
        });
        $("#step-" + stepNumber + " :input[data-parsley-required='false']").each(function (index, element)
        {

            if ($(this).attr('id') == 'ad_yvideo')
            {
                if ($(this).val() !== '') {
                    var ex = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
                    if (ex.test($(this).val()) == false)
                    {
                        is_error = true;
                    }
                }
            }
        });


        $('body,html').animate({
            scrollTop: 200,
        }, 700);

        if (is_error)
        {
            $('#ad_post_form').submit();
            $('.ad_errors').show();
            $('.parsley-errors-list').show();
            event.preventDefault();
            return false;
        } else
        {
            $('.parsley-errors-list').hide();
        }
    });


    // External Button Events
    $("#reset-btn").on("click", function () {
        // Reset wizard
        $('#smartwizard').smartWizard("reset");
        return true;
    });

    $("#prev-btn").on("click", function () {
        // Navigate previous
        $('#smartwizard').smartWizard("prev");
        return true;
    });
    var submit_counter = 1;
    $(".sw-btn-next").on("click", function () {
        if (submit_counter == 1 && $('#is_update').val() == "")
        {
            $('#ad_post_form').submit();
            submit_counter++;
            if ($('#ad_title').val())
            {
                $('.ad_errors').hide();
                $('.parsley-errors-list').hide();
            }
        }
    });

    $("#next-btn").on("click", function () {
        // Navigate next
        $('#smartwizard').smartWizard("next");
        return true;
    });

    $(".submit_ad_now, .preview_ad_now").on("click", function () {
        // Navigate next
        $('#pre_sub').val($(this).attr('data-btn-val'))
        return true;
    });


    if ($('#is_bidding_on').val() == "0" || $('#is_bidding_on').val() == "")
    {
        $('.biddind_div').hide();
    }
    $('#ad_bidding').on('change', function ()
    {
        if ($('#ad_bidding').val() == "1")
        {
            $('.biddind_div').show();
        } else
        {
            $('.biddind_div').hide();
        }
    });

    $('#ad_bidding_date').datepicker({
        timepicker: true,
        dateFormat: 'yyyy-mm-dd',
        timeFormat: 'hh:ii:00',
        language: {
            days: [get_strings.Sunday, get_strings.Monday, get_strings.Tuesday, get_strings.Wednesday, get_strings.Thursday, get_strings.Friday, get_strings.Saturday],
            daysShort: [get_strings.Sun, get_strings.Mon, get_strings.Tue, get_strings.Wed, get_strings.Thu, get_strings.Fri, get_strings.Sat],
            daysMin: [get_strings.Su, get_strings.Mo, get_strings.Tu, get_strings.We, get_strings.Th, get_strings.Fr, get_strings.Sa],
            months: [get_strings.January, get_strings.February, get_strings.March, get_strings.April, get_strings.May, get_strings.June, get_strings.July, get_strings.August, get_strings.September, get_strings.October, get_strings.November, get_strings.December],
            monthsShort: [get_strings.Jan, get_strings.Feb, get_strings.Mar, get_strings.Apr, get_strings.May, get_strings.Jun, get_strings.Jul, get_strings.Aug, get_strings.Sep, get_strings.Oct, get_strings.Nov, get_strings.Dec],
            today: get_strings.Today,
            clear: get_strings.Clear,
            dateFormat: 'mm/dd/yyyy',
            timeFormat: 'hh:ii aa',
            firstDay: 0
        },
        minDate: new Date() // Now can select only dates, which goes after today
    });

})(jQuery);