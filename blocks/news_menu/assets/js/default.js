$(document).ready(function() {
	$('.news_search span').click(function(e){
		var id = $(this).attr('data-id');
			$( this ).children().toggleClass( "active" );
			$('#'+id).toggle("slow");
	});

	$('#submitbt_news').click(function(){
		url = '';
		var keyword = $('#keyword_news').val();
		var link_search = $('#link_search_news').val();
		if(keyword != 'Tìm kiếm...' && keyword != '')	{
			url += 	'&keyword='+keyword;
			var check = 1;
		}else{
			var check =0;
		}
		if(check == 0){
			alert('Bạn phải nhập tham số tìm kiếm');
			return false;
		}
		if(link_search.indexOf("&") == '-1')
			var link = link_search+'/'+keyword+'.html';
		else
			var link = link_search+'&keyword='+keyword+'&Itemid=9';
	    window.location.href=link;
	    return false;
		})

});