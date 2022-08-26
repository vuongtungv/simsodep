<?php

	include 'blocks/filter/models/filter.php';
	
	class FilterBControllersFilter
	{
		function __construct()
		{
		}
		function display($parameters = array())
		{
			// call models
			$model = new FilterBModelsFilter();

			$style = $parameters->getParams('style');
			$url = $parameters->getParams('url');
			$trang = $parameters->getParams('type');

			$cat = FSInput::get('cat');
			$order = FSInput::get('order');
			$network = FSInput::get('mang');
			$price = FSInput::get('price');
			$head = FSInput::get('head');
			$param = array();

			$order_name = 'Ngẫu nhiên';
			foreach ($this->sort_arr as $key => $value) {
				if ($key == @$order) {
					$order_name = $value;
				}
			}

			if ($cat) {
				$param['cat']= $cat;
			}
			if ($order) {
				$param['order']= $order;
			}
			if ($network) {
				$param['mang']= $network;
			}
			if ($price) {
				$param['price']= $price;
			}
			if ($head) {
				$param['head']= $head;
			}

	        $type = $model->get_records('published = 1','fs_sim_type','id,name,alias',' ordering ASC,id ASC ');
			$net = $model->get_records('published = 1','fs_network','id,name,alias','ordering ASC ','','id');
			$prices = $model->get_records('','fs_pricesim','id,title,price',' ordering ASC ');
			
			include 'blocks/filter/views/filter/'.$style.'.php';
		}
	
	}
	
?>