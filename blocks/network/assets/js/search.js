function header_sim(header) {
  arr_header= header.split(",");
  $('.header_number').hide();
  for (var i = 0; i < arr_header.length; i++) {
  	$('.header_'+arr_header[i]).show();
  }
}

function submit_form_search_network() {
	itemid = 20; 
	var link_search = document.getElementById('link_search').value;
	var url_root = document.getElementById('url_root').value;
	url = url_root+'tim-kiem';

	var net = document.getElementById('quicked-net').value;
	var first = document.getElementById('quicked-first').value;

	if (!net) {
		net = 'all';
	}

	if (!first) {
		first = 'all';
	}else{
		first = first+'*';
	}

	if (net || first) {
		url += 	'/'+first+'/'+net+'/all/all/random/all/all/all.html';
	}else{
		alert('Bạn vui lòng chọn nhà mạng hoặc đầu số');
		return false;
	}

	window.location.href=url;
	return false;
}

