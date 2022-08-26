function submit_form_search_poin_button() {
		itemid = 20; 
		var link_search = document.getElementById('link_search').value;
		var url_root = document.getElementById('url_root').value;
		url = url_root+'tim-sim/all.html';

		var point = document.getElementById('point_pt').value;
		var button = document.getElementById('button_pt').value;
		var param = '';

		if (button) {
			param += '&button='+button;
		}

		if (point) {
			param += '&point='+point;
		}
		if (param) {
			param = param.substr(1);
			url += '?'+param;
		}else{
			alert('Bạn vui lòng nhập tổng nút hoặc tổng điểm');
			return false;
		}

		window.location.href=url;
		return false;
}

