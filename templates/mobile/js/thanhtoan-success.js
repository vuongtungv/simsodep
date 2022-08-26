$(document).ready(function () {
    $(".select-paymethod").on("click", function (e) {
        $(".select-paymethod .options").slideToggle('slow');
        e.stopPropagation();
    });
    $(".select-paymethod .option").on("click", function () {
        $("#selected-paymethod").attr("value", $(this).attr("value"));
        $(".value-paymethod").text($(this).text());
        $(".select-paymethod .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.select-paymethod .options').slideUp('slow');
        e.stopPropagation();
    });

    var $height = document.getElementById('bg-opacity').offsetHeight+184;
    $('head').append('<style>.bg-opacity:after{height: ' + $height + 'px;}</style>');
    $('head').append('<style>.bg-opacity:after{top: ' + 0 + 'px;}</style>');
    $('.close-pup').click(function(e) {
        $('.success-order').fadeOut(300);
        $('#bg-opacity').removeClass('bg-opacity');
        $('head').append('<style>.bg-opacity:after{top: ' + 235 + 'px;}</style>');
        var $height = document.getElementById('bg-opacity').offsetHeight+184;
    });
});
