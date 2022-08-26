<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';
		  
	class TypesimControllersTypesim extends Controllers
	{
		function __construct()
		{
			$this->view = 'contact' ; 
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

        function add()
        {
            $model = $this -> model;
//            $categories = $model->get_categories_tree();

            // data from fs_contents_categories
//            $categories_home  = $model->get_categories_tree();
//            $maxOrdering = $model->getMaxOrdering();

            include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
        }

        function edit()
        {
            $ids = FSInput::get('id',array(),'array');
            $id = $ids[0];
            $model = $this -> model;  
//            $categories  = $model->get_categories_tree();
//			$tags_categories = $model->get_tags_categories();
            $data = $model->get_record_by_id($id);
            // data from fs_news_categories
            include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
        }
	}
	
?>