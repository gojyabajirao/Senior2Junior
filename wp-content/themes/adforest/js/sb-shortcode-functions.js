/*
 Adforest Shorcode functions 
 */
(function ($) {

    var adforest_is_rtl = jQuery('#is_rtl').val();
    var slider_rtl = false;
    if (adforest_is_rtl != 'undefined' && adforest_is_rtl == '1') {
        slider_rtl = true;
    }
    var adforest_ajax_url = $('#adforest_ajax_url').val();

    jQuery(document).ready(function () {

        /*
         * Ajax categories load function
         */
        if (jQuery('.sb-load-ajax-cats')) {
            jQuery('.sb-load-ajax-cats').select2({
                allowClear: true, width: '100%', rtl: slider_rtl,
                ajax: {
                    url: adforest_ajax_url,
                    dataType: 'json',
                    delay: 250,
                   // quietMillis: 250,
                    data: function (params) {
                        var page_num = typeof params.page !== 'undefined' ? params.page : 1;
                        var query_string = typeof params.term !== 'undefined' ? params.term : '';

                        if (query_string == '') {
                            return {
                                //page: page_num,
                                action: 'load_categories_frontend_html'
                            };

                        } else {
                            //jQuery(document).on('keyup', '.select2-search__field', function (e) {
                            // console.log(query_string);
                            //setTimeout(function () {
                                return {
                                    q: query_string, // search query
                                    action: 'load_categories_frontend_html'
                                };
                            // }, 1000);   
                                
                            //});

                        }

                    },
                    escapeMarkup: function (m) {
                        return m;
                    },
                    processResults: function (data) {
                        var options = [];
                        if (data) {
                            $.each(data, function (index, text) {
                                options.push({id: text[0], text: text[1]});
                            });
                        }
                        return {
                            results: options,
                            //pagination: {"more": true},
                        };
                        $('.sb-load-ajax-cats').val(null);
                    },

                    cache: true
                },
                "language": {
                    "errorLoading": function () {
                        return shortcode_globals.errorLoading;
                    },
                    "inputTooShort": function () {
                        return shortcode_globals.inputTooShort;
                    },
                    "searching": function () {
                        return shortcode_globals.searching;
                    },
                    "noResults": function () {
                        return shortcode_globals.noResults;
                    }
                },
                //minimumInputLength: 3 ,
            });
        }
    });

})(jQuery);