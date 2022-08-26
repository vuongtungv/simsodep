<?php
class CodControllersCod extends Controllers {

    function __construct()
	{
		$this->view = 'cod' ; 
		parent::__construct();
		$array_status = array( 
                                1 => FSText::_('Đang chuyển'),
                                2 =>FSText::_('Đã có tiền'),
                                3 =>FSText::_('Đã nhận tiền'),
                                4 =>FSText::_('Hủy')
                                );
		$this -> arr_status = $array_status;

		$array_money = array( 
                                0 => FSText::_('Không'),
                                1 => FSText::_('Có')
                                );
		$this -> arr_money = $array_money;
	}
    
	function display() {
		parent::display ();
		$sort_field = $this->sort_field;
		$sort_direct = $this->sort_direct;
		
		$model = $this->model;
		$list = $model->get_data ('');

		$array_status = $this -> arr_status;
		$array_obj_status = array();
		foreach($array_status as $key => $name){
			$array_obj_status[] = (object)array('id'=>($key),'name'=>$name);
		}

		$array_money = $this -> arr_money;
		$array_obj_money = array();
		foreach($array_money as $key => $name){
			$array_obj_money[] = (object)array('id'=>($key),'name'=>$name);
		}

		$new = $model->get_count('status = 1','fs_cod');
		
        //$categories = $model->get_categories_tree();
        
		$pagination = $model->getPagination ('');
		include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
	}
    
    function add()
	{
		$model = $this -> model;
		//$categories = $model->get_categories_tree();
		$maxOrdering = $model->getMaxOrdering();
		
		include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
	}
	
	function edit()
	{
		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;
		//$categories  = $model->get_categories_tree();
//			$tags_categories = $model->get_tags_categories();
		$data = $model->get_record_by_id($id);
		$order_item = $model->get_record_by_id($data->order_id,'fs_order_items');
		$order = $model->get_record_by_id($data->order_id,'fs_order');

		// var_dump($order_item->order_id);

		// data from fs_news_categories
		include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
	}
}
?>