<?php
	class DocumentsControllersDocument extends Controllers
	{
		function __construct()
		{
			$this->view = 'document' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$model  = $this -> model;
			$list = $model->get_data('');
			$pagination = $this -> model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
        
        function add()
		{
			$model = $this -> model;
//			$maxOrdering = $model->getMaxOrdering();
//			$menus_items_all = $model->getMenuItems ();
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;           
			$data = $model->get_record_by_id($id);
//			$menus_items_all = $model->getMenuItems ();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}

		function views()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
			$menus_items_all = $model->getMenuItems ();
			include 'modules/'.$this->module.'/views/'.$this->view.'/is_view.php';
		}
		
	}
?>