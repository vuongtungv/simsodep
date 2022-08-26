<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';
		  
	class Regis_promotionsControllersRegis_promotions extends Controllers
	{
		function __construct()
		{
			$this->view = 'regis_promotions' ;
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$list = $this -> model->get_data('');
			$pagination = $this -> model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
            $network = $this->model->getNetWork();
			$data = $model->get_record_by_id($id);
//			$parts = $model->get_parts();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
        function add() {
            $model = $this->model;
//            $categories = $model->get_categories ();
            $network = $this->model->getNetWork();
            // data from fs_news_categories
            $maxOrdering = $model->getMaxOrdering ();
            include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
        }
	}
	
?>