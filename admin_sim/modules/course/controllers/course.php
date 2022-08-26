<?php
	class CourseControllersCourse extends Controllers
	{
		function __construct()
		{
			$this->view = 'course' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
            $categories = $model->get_categories_tree();
         	$list = $model->get_data('');
            
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
			$categories = $model->get_categories_tree();
			$maxOrdering = $model->getMaxOrdering();            
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
        
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$categories = $model->get_categories_tree();
            
			$data = $model->get_record_by_id($id);

			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
        
        function active()
        {
            $this->is_check('active',1,'active');
        }
        function unactive()
        {
            $this->unis_check('active',0,'un_active');
        }
        
	}
?>