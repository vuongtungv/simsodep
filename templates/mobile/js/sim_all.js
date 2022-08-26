$(document).ready(function () {
    // choose phân trang
    $(".value-pagination").on("click", function (e) {
        $(".show-pagination .options").toggle('300');
        e.stopPropagation();
    });  
    $(".show-pagination .option").on("click", function () {
        $("#selected-pagination").attr("value", $(this).attr("value"));
        $(".value-pagination").text($(this).text());
        $(".show-pagination .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.show-pagination .options').hide('slow');
        e.stopPropagation();
    });


    $('#id-filter').click(function () {
        $('.filter-show').fadeIn(300);
        $('#bg-opacity').addClass('bg-opacity');
        var $height = document.body.clientHeight;
        $('head').append('<style>.bg-opacity:after{height: ' + $height + 'px;}</style>');
        $('head').append('<style>.bg-opacity:after{top: ' + 0 + 'px;}</style>');
    });
    $('.close-pup').click(function(e) {
        $('.filter-show').fadeOut(300);
        $('#bg-opacity').removeClass('bg-opacity');
    });

});