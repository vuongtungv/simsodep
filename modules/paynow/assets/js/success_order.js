// $(document).ready( function(){
// 	setTimeout(function(){ 
// 	  $.ajax({
// 	      async: true,
// 	      url:"/index.php?module=paynow&view=paynow&task=delete_session_cart&raw=1"
// 	  });
// 	}, 60000);
// });

$('.close-pup').click(function () {
    $('.success-order').css('display','none');
});
// If an event gets to the body
$(".success-order").click(function(e){
    var container = $(".success-order .body");
    if (!container.is(e.target) && container.has(e.target).length === 0)
    {
        $('.success-order').css('display','none');
    }
});