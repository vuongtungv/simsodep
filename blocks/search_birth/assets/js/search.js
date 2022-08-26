function submit_form_search_birth() {
		itemid = 20; 
		var link_search = document.getElementById('link_search').value;
		var url_root = document.getElementById('url_root').value;
		url = url_root+'tim-sim';

		var day = document.getElementById('selected-day-2').value;
		var moth = document.getElementById('selected-month-2').value;
		var year = document.getElementById('selected-year-2').value;

		keyword = day+moth+year;

		if (keyword) {
			url += 	'/*'+keyword+'.html';
		}else{
			alert('Bạn vui lòng nhập ngày tháng năm sinh');
			return false;
		}

		window.location.href=url;
		return false;
}

