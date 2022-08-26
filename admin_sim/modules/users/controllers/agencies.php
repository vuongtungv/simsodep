<?php
	// models 
	class UsersControllersAgencies extends Controllers 
	{
		var $module;
		var $gid;
		function __construct()
		{
//			$module = 'users';
			$this->view = 'agencies';
			parent::__construct(); 
			$this->gid = FSInput::get('gid');
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data('');
			
			// call views
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		
		
		function add()
		{
			$model = $this -> model;
			$maxOrdering = $model->getMaxOrdering();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		function edit()
		{
			$cds = FSInput::get('id',array(),'array');
			$cid = $cds[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($cid);
			$commissions = $model ->get_records('agency_id = '.$data -> id,'fs_agencies_commissions');
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}	 
}
	
?>