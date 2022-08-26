<?php
	class PositionControllersPosition extends Controllers
	{
		function __construct()
		{
			$this->view = 'position' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data('');
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function edit(){
			$id = FSInput::get('id');
			$model  = $this -> model;
			$data = $model->get_record_by_id($id);
			$commissions = $model ->get_records('price_id = '.$data -> id.' ORDER BY ordering ASC','fs_member_commissions');
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>