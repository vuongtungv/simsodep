function clickActive(location,show){
    check_exist_id(location);
    getLocation(location,show);
}

function check_exist_id(id){
	$.ajax({
    		type : 'POST',
            dataType: 'json',
    		url : '/index.php?module=contact&view=contact&raw=1&task=map',
    		data: 'id='+id,
            success : function(data){
                if(data.error == false){
                    $('.item-row-map').html(data.html);
                } else {
                    alert('Error retrieving data.');
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert('There is an error in the process of bringing up the server. Would you please check the connection.');
            }
    	});
}
$(document).ready(function() {
    var location = 0;
    getLocation(location,false); 
});


