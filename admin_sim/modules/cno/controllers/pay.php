<?php
class CnoControllersPay extends Controllers {

    function __construct()
	{
		$this->view = 'pay' ; 
		parent::__construct();
		$array_status = array( 
                                1 => FSText::_('Mới'),
                                2 =>FSText::_('Đã xem'),
                                3 =>FSText::_('Đối chiếu'),
                                4 =>FSText::_('Đã xong')
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
		 
		// Errors::setError ( 'Chọn đại lý để đối chiếu');

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

		$user_cms = $model->get_records('published=1 and type=1 order by ordering asc','fs_users','id,username,full_name');
		$agency = $model->get_records('published=1 and type=2 ORDER BY full_name ASC , ordering DESC , id DESC','fs_users','id,username,full_name');

		$new_agency = array();
        foreach ($agency as $value) {
            $sum_total = $model->get_count('status=3 and agency='.$value->id,'fs_cno');
            $sum_price = $model->get_sum('status=3 and agency='.$value->id,'fs_cno','recive');
            $name_full = $value->full_name;
            if ($sum_total) {
                $name_full = $value->full_name.' (Số lượng: '.$sum_total.' - Tổng tiền: '.format_money($sum_price).')';
            }
            $new_agency[] = (object) array('id' => $value->id , 'name' => $name_full);
        }
        $new_agency = (object) $new_agency;
		
        //$categories = $model->get_categories_tree();
        
		$pagination = $model->getPagination ('');
		include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
	}
    
    function add()
	{
		$model = $this -> model;
		$agency_id = FSInput::get('filter1','0','int');

		$list = $model->get_records('status=3 AND agency='.$agency_id,'fs_cno');
		if (!$list) {
				Errors::setError ( 'Không có công nợ' );
				$link = 'index.php?module=cno&view=pay';
	    		setRedirect($link);
			}
		$data_agency = $model->get_record('id='.$agency_id,'fs_users');
		$history = $model->get_records('agency='.$agency_id.' limit 10','fs_pay');
		$city = $model->get_record('id='.$data_agency->city,'fs_cities','name');

		//$categories = $model->get_categories_tree();

		$maxOrdering = $model->getMaxOrdering();
		
		include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
	}
	
	function edit()
	{
		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;

		$data = $model->get_record_by_id($id);
		$list_id = trim($data->cno_id,',');
		$list = $model->get_records('id IN('.$list_id.')','fs_cno');
		// var_dump($list);

		$array_status = $this -> arr_status;
		$array_obj_status = array();
		foreach($array_status as $key => $name){
			$array_obj_status[] = (object)array('id'=>($key),'name'=>$name);
		}

		// data from fs_news_categories
		include 'modules/'.$this->module.'/views/'.$this->view.'/view.php';
	}

	function compare()
	{
		echo 1;
	}
}
?>