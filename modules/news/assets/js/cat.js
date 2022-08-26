$(document).ready( function(){
    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
        var type = $(this).data('type');
        $.ajax({
    	    url: "/index.php?module=news&view=cat&task=ajax_session&raw=1",
    		data: {type: type},
    		dataType: "text",
    		success: function(result) {
    			if(result == 1){
    				location.reload();
    			} 
    		}
    	});
    });
    //$('#myTab a:last').tab('show');
});