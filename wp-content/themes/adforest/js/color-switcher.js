(function ($) {
    "use strict";
    var theme_path = $('#theme_path').val();

    $("#defualt").on('click', function () {
        $("#defualt-color-css").attr("href", theme_path + "css/colors/defualt.css");
        return false;
    });


    $("#red").on('click', function () {
        $("#defualt-color-css").attr("href", theme_path + "css/colors/red.css");
        return false;
    });

    $("#green").on('click', function () {
        $("#defualt-color-css").attr("href", theme_path + "css/colors/green.css");
        return false;
    });

    $("#blue").on('click', function () {
        $("#defualt-color-css").attr("href", theme_path + "css/colors/blue.css");
        return false;
    });


    $("#sea-green").on('click', function () {
        $("#defualt-color-css").attr("href", theme_path + "css/colors/sea-green.css");
        return false;
    });
    $("#dark-red").on('click', function () {
        $("#defualt-color-css").attr("href", theme_path + "css/colors/dark-red.css");
        return false;
    });



    // picker buttton
    $(".picker_close").click(function () {
        $("#choose_color").toggleClass("position");

    });

    jQuery(document).on('click', '#custom-theme', function () {
        var theme_color = $("#theme-color").val();
        var btn_hover_color = $("#btn-hover-color").val();
        var btn_border_color = $("#btn-border-color").val();

        jQuery.ajax({
            type: 'POST',
            url: $("#adforest_ajax_url").val(),
            data: 'action=adforest_custom_theme_color&theme_color=' + theme_color + '&btn_border_color=' + btn_border_color + '&custom_btn_hover=' + btn_hover_color,
            success: function (response) {
                $("#defualt-color-css").attr("href", "");

                $("#adforest-custom-css").html(response);

            }
        });
        return false;
    });


    $("#theme-color").spectrum({
        color: $("#custom-theme-color").val(),
        showInput: true,
        preferredFormat: "hex",
    });
    $("#btn-hover-color").spectrum({
        color: $("#custom-hover-color").val(),
        preferredFormat: "hex",
        showInput: true,

    });
    $("#btn-border-color").spectrum({
        color: $("#custom-border-color").val(),
        preferredFormat: "hex",
        showInput: true,

    });



})(jQuery);