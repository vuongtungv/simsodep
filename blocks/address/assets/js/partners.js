$(document).ready(function() {
  //var type = $('#type_block').val();  
  $("#owl-partners").owlCarousel({
    autoplay: true, //Set AutoPlay to 3 seconds
    autoplaySpeed: 500,
    loop:true,
    autoplayTimeout: 3000,
    autoWidth: true,
    autoHeight: true,
    autoplayHoverPause:true,
    items : 5,
    nav:true,
    responsive:{
        0:{
            items:2,
            margin:20,
        },
       
        992:{
            items: 5,
            margin: 30,
        },
    }
  });
 
});