$(document).ready(function(){
    /* place-viewed */
    $('#news-slide .jcarousel')
        .on('jcarousel:reload jcarousel:create', function () {
//          var element = $(this);
            var element = $(this),
                width = element.innerWidth();
            if (width >= 600) {
                width = width / 1;
            } else if (width >= 700) {
                width = width / 1;
            } else if (width >= 470) {
                width = width / 1;
            } else if (width >= 250) {
                width = width / 1;
            }
            element.jcarousel('items').css('width', width + 'px');
//            element.jcarousel('items').css('width', 276 + 'px');
        })
        .jcarousel({
            wrap: 'circular',
            animation: {
                duration: 600,
                easing:   'linear',
                complete: function() {
                }
            }
        })
        /*.jcarouselAutoscroll({
            interval: 2000
        })*/;

    $('#news-slide .jcarousel-control-prev')
        .jcarouselControl({
            target: '-=1'
        });

    $('#news-slide .jcarousel-control-next')
        .jcarouselControl({
            target: '+=1'
        });
});
