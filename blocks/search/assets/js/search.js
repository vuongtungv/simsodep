jQuery(function($) {
    $('.numeric').autoNumeric('init');
});

$(document).ready(function(){
  $(".total-button-sim").keyup(function(){
    data = $(this).val();
    if (data == parseInt(data, 10) && data > 0 && data < 11)
	    return true;
	else
	    $(this).val('');
  });
  $(".total-score-sim").keyup(function(){
    data = $(this).val();
    if (data == parseInt(data, 10) && data > 0 && data < 81)
	    return true;
	else
	    $(this).val('');
  });  

  var Expression = /^[0-9 .x*()-]+$/;
  $("#text-search").keyup(function(){
    data = $(this).val();
    if (data.match(Expression)){
	    document.getElementById("text-search-2").value = data;
    }
	else{
		data = data.slice (0, -1);
	}
	$(this).val(data);
	document.getElementById("text-search-2").value = data;
	if(data == ''){
		$('.img_search_ic').attr('src','/templates/default/images/icon_search.png');
		$('#submit_search').attr('style','');
		$('.fa-search').attr('style','');
		$('#submit_search a').attr('style','');
	}
  });
  $("#text-search-2").keyup(function(){
    data = $(this).val();
    if (data.match(Expression)){
	    document.getElementById("text-search").value = data;
    }
	else{
		data = data.slice (0, -1);
	}
    $(this).val(data);
    document.getElementById("text-search-2").value = data;
	  if(data == ''){
		$('.img_search_ic').attr('src','/templates/default/images/icon_search.png');
		$('#submit_search').attr('style','');
		$('.fa-search').attr('style','');
		$('#submit_search a').attr('style','');
	  }
  });
})

$('#text-search-2').keypress(function (e) {
    if (e.which == 13) {
        submit_form_search();
        return false;
    }
});

$('#search_form').keypress(function (e) {
    if (e.which == 13) {
        submit_form_search();
        return false;
    }
});

function submit_form_search() {

	  	txt = '';
		$('input[name="number"]:checked').each(function() {
		   // console.log(this.value);
		   v = this.value;
		   v = parseInt(v);
		   txt += v+'-';
		});
	  	number = txt.replace(/(\s+)?.$/, '');

		itemid = 20; 
		var link_search = document.getElementById('link_search').value;
		var url_root = document.getElementById('url_root').value;
		url = url_root+'tim-sim';
		var keyword = document.getElementById('text-search').value;
		if (!keyword) {
			keyword = document.getElementById('text-search-2').value;
		}
		keyword = encodeURIComponent(encodeURIComponent(keyword));
		var network = document.getElementById('selected-value').value;
		var cat = document.getElementById('selected-type').value;
		var form_price = document.getElementById('form_price').value;
		var to_price = document.getElementById('to_price').value;
		var order = $("input[name=sim-price]:checked").val()
		var button = document.getElementById('total-button-sim').value;
		var point = document.getElementById('total-score-sim').value;

		keyword = String(keyword);
		keyword = keyword.split('.').join('');
		keyword = keyword.replace(/\s+/g, '');
		keyword = keyword.replace(/%2520/g, '');

		// check nếu là số thì chuyển hướng sang trang chi tiết sim
		// kleng = keyword.length;
		// fkey = keyword.slice(0, 1);

		// if (kleng > 9 && kleng < 12 && fkey == 0) {
		// 	url = url_root+keyword+'.html';
		// 	window.location.href=url;
		// 	return false;
		// }

		if (keyword) {
			url += 	'/'+keyword;
		}else{
			url += 	'/all';
		}

		param = '';
		if (network) {
			param += '&network='+network;
		}

		if (cat) {
			param += '&cat='+cat;
		}

		if (form_price) {
			param += '&from_price='+form_price;
		}

		if (to_price) {
			param += '&to_price='+to_price;
		}

		if (order) {
			param += '&order='+order;
		}

		if (button) {
			param += '&button='+button;
		}

		if (point) {
			param += '&point='+point;
		}

		if (number) {
			param += '&number='+number;
		}

		url += 	'.html';
		if (param) {
			param = param.substr(1);
			url += '?'+param;
		}

		window.location.href=url;
		return false;
}

