// Toggle menu
$(document).ready(function () {
   var $height = document.body.clientHeight-183;
   var i=0;j=0;k=0;h=0
   $('#btn-menu').click(function () {
       i++;
       if(i %2 !=0){
           $("#bg-opacity").addClass('bg-opacity');
           $("#bg-opacity").addClass('bg-none');
           $('head').append('<style>.bg-opacity:after{height: ' + $height + 'px;}</style>');
           $('#id-show-cart').hide();
           $('#dots-show').hide();
           $('#show-menu').slideDown('300');
       }else{
           $("#bg-opacity").removeClass('bg-opacity');
           $("#bg-opacity").removeClass('bg-none');
           $('#show-menu').slideUp('300');
       }
   });

   $("#btn-cart").on("click", function () {
       j++;
       if(j %2 !=0) {
           $("#bg-opacity").addClass('bg-opacity');
           $("#bg-opacity").addClass('bg-none');
           $('head').append('<style>.bg-opacity:after{height: ' + $height + 'px;}</style>');
           $('#show-menu').hide();
           $('#dots-show').hide();
           $('#id-show-cart').slideDown('300');
       }
       else{
           $("#bg-opacity").removeClass('bg-opacity');
           $("#bg-opacity").removeClass('bg-none');
           $('#id-show-cart').slideUp('300');
       }
   });

   $("#btn-dots").click(function () {
       k++;
       if(k %2 !=0) {
           $("#bg-opacity").addClass('bg-opacity');
           $("#bg-opacity").addClass('bg-none');
           $('head').append('<style>.bg-opacity:after{height: ' + $height + 'px;}</style>');
           $('#show-menu').hide();
           $('#id-show-cart').hide();
           $('#dots-show').slideDown('300');
       }
       else{
           $("#bg-opacity").removeClass('bg-opacity');
           $("#bg-opacity").removeClass('bg-none');
           $('#dots-show').slideUp('300');
       }
   });






    // js dots choose

    // Select promotion
    $(".select-promotion").on("click", function (e) {
        $(".select-promotion .options").slideToggle('slow');
        e.stopPropagation();
    });
    $(".select-promotion .option").on("click", function () {
        $("#regis-promotion").attr("value", $(this).attr("value"));
        $(".value-promotion").text($(this).text());
        $(".select-promotion .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.select-promotion .options').hide('slow');
        e.stopPropagation();
    });




    // Quick search home
    $(".select-options").on("click", function (e) {
        $(".select-type .options").slideUp('slow');
        $(".select-options .options").slideToggle('slow');
        e.stopPropagation();
    });
    $(".select-options .option").on("click", function () {
        $("#selected-options").attr("value", $(this).attr("value"));
        $(".value-options").text($(this).text());
        $(".select-options .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.select-options .options').hide('slow');
        e.stopPropagation();
    });

    $(".select-type").on("click", function (e) {
        $(".select-options .options").slideUp('slow');
        $(".select-type .options").slideToggle('slow');
        e.stopPropagation();
    });
    $(".select-type .option").on("click", function () {
        $("#selected-type").attr("value", $(this).attr("value"));
        $(".value-type").text($(this).text());
        $(".select-type .options").css('display', 'none !important');
    });
    $(document).click(function(e) {
        $('.select-type .options').hide('slow');
        e.stopPropagation();
    });



    $('.select-options img').on("click", function () {
        $('.select-options .sel-ip').addEventListener('click');
    });
});
