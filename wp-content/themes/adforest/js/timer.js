function adforest_timerCounter_function(section_class) {
    jQuery(function ($) {
        
        
        var timer_class = typeof section_class !== 'undefined' && section_class != '' ? section_class : 'clock';
        
        
        function timer(config) {
            var settings;
            function prependZero(number) {
                return number < 10 ? '0' + number : number;
            }


            //console.log(config);

            $.extend(true, config, settings || {});
            var currentTime = moment();

            var endDate = moment.tz(config.endDate, config.timeZone);
            var diffTime = endDate.valueOf() - currentTime.valueOf();
            var duration = moment.duration(diffTime, 'milliseconds');
            var days = Math.floor(duration.asDays());
            var interval = 1000;
            var subMessage = $('.sub-message');
            var clock = $('.'+timer_class);
            if (diffTime < 0) {
                endEvent(subMessage, config.newSubMessage, clock);
                return;
            }
            if (days > 0) {
                config.days.text(prependZero(days));
                //$('.days').css('display', 'inline-block');
            }
            var intervalID = setInterval(function () {
                duration = moment.duration(duration - interval, 'milliseconds');
                var hours = duration.hours(),
                        minutes = duration.minutes(),
                        seconds = duration.seconds();
                days = Math.floor(duration.asDays());
                if (hours <= 0 && minutes <= 0 && seconds <= 0 && days <= 0) {
                    clearInterval(intervalID);
                    endEvent(subMessage, config.newSubMessage, clock);
                    //window.location.reload();
                }
                if (days === 0) {
                    //$('.days').hide();
                }
                config.days.text(prependZero(days));
                config.hours.text(prependZero(hours));
                config.minutes.text(prependZero(minutes));
                config.seconds.text(prependZero(seconds));
            }, interval);
        }
        function endEvent($el, newText, hideEl) {
            if ($('.bid_close').length > 0)
                $('.bid_close').show();
            hideEl.hide();
        }

        var sb_bid_timezone = jQuery('#sb-bid-timezone').val();
        $('.'+timer_class).each(function (index, element) {
            var ref = $(this).attr('data-rand');
            var aaaaa = $(this).closest('div.days-' + ref);
            var config = {
                endDate: $(this).attr('data-date'),
                /*endDate: '2018-05-23 07:01:10',*/
                days: $('.days-' + ref),
                hours: $('.hours-' + ref),
                minutes: $('.minutes-' + ref),
                seconds: $('.seconds-' + ref),
                newSubMessage: '',
                timeZone: sb_bid_timezone,
            };
            
            timer(config);
        });
    });
}