<?php
	class SeoControllersSeo extends Controllers
	{
		function __construct()
		{
			$this->view = 'seo' ; 
			parent::__construct(); 
			$array_cat = array( 
								// 'home' => 'Trang chủ',
								'cat' => 'Thể loại',
								'subcat' => 'Thể loại & Thể loại con',
								'network'=>'Nhà mạng',
								// 'header'=>'Đầu số',
								'head_network'=>'Nhà mạng & Đầu số',
								'par'=>'Sim hợp mệnh',
								'sim'=>'Sim',
								'no_sim'=>'Sim không có trên hệ thống',
								'phongthuy'=>'Phong thủy',
								'sim_sales'=>'Sim khuyến mãi trong ngày',
								'sim_vip'=>'Sim Vip',
								'sim_offer'=>'Sim Đề Xuất',
								'sim_after'=>'Sim Trả Sau',
								'sim_promotion'=>'Khuyến mãi sim số đẹp',
								'deposit'=>'Ký gửi sim',
								'find'=>'Tìm sim theo yêu cầu',
								'dinhgia'=>'Định giá sim',
								'internet'=>'Lắp đặt internet',
								'bangso'=>'Bảng số',
								'timkiem'=>'Tìm kiếm',
							); 
			$array_obj_cat = array();
			foreach($array_cat as $key => $name){
				$array_obj_cat[] = (object)array('id'=>($key),'name'=>$name);
			}
			// echo '<pre>',print_r($array_obj_cat),'</pre>';die;
			$this -> array_cat = $array_obj_cat;
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

		function get_list_module()
		{		
			$model  = $this -> model;
			$type = FSinput::get('type');
			switch ($type) {
				case 'cat':
					include 'modules/'.$this->module.'/views/'.$this->view.'/cat.php';
					break;
				case 'subcat':
					include 'modules/'.$this->module.'/views/'.$this->view.'/cat.php';
					break;
				case 'network':
					include 'modules/'.$this->module.'/views/'.$this->view.'/network.php';
					break;
				case 'head_network':
					include 'modules/'.$this->module.'/views/'.$this->view.'/network.php';
					break;
				case 'header':
					include 'modules/'.$this->module.'/views/'.$this->view.'/header.php';
					break;
				case 'sim':
					break;
				case 'par':
					include 'modules/'.$this->module.'/views/'.$this->view.'/par.php';
					break;
				case 'price':
					include 'modules/'.$this->module.'/views/'.$this->view.'/price.php';
					break;
				default:
					
					break;
			}
			// var_dump($list);die;
			
		}

	}
	
?>