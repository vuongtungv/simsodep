$(document).ready(function() {
    $("#news-related-cat").owlCarousel({
        autoPlay: false, //Set AutoPlay to 3 seconds
        items : 4,
        itemsDesktop : [1199,4],
        itemsDesktopSmall : [979,3],
        itemsTablet : [768, 2],
        itemsMobile : [479, 1],
        lazyLoad : true,
        navigation : true,
        pagination : false,
        navigationText : ["&nbsp;", "&nbsp;"]
    });

    $("#news-related").owlCarousel({
        autoPlay: false, //Set AutoPlay to 3 seconds
        items : 4,
        itemsDesktop : [1199,4],
        itemsDesktopSmall : [979,3],
        itemsTablet : [768, 2],
        itemsMobile : [479, 1],
        lazyLoad : true,
        navigation : true,
        pagination : false,
        navigationText : ["&nbsp;", "&nbsp;"]
    });

});