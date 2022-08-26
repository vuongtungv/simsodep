<?php
	class SimControllersDuplicate extends Controllers
	{
		function __construct()
		{
			$this->view = ''; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
            
         	$list = $model->get_data('');
            $network = $model->get_records('published = 1','fs_network','name,id');
            $partner = $model->get_records('published=1 and type=2 order by ordering asc','fs_users','id,full_name');
			$list_key = array();
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
        function wait()
        {
            parent::display();
            $sort_field = $this -> sort_field;
            $sort_direct = $this -> sort_direct;
            
            $model  = $this -> model;
            
            $list = $model->get_data('');
            
           
            $list_key = array();
            $pagination = $model->getPagination('');
            include 'modules/'.$this->module.'/views/'.$this->view.'/wait.php';
        }
		function add()
		{
			$model = $this -> model;
			$maxOrdering = $model->getMaxOrdering();
			$uploadConfig = base64_encode('add|'.session_id());

			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
        
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$categories = $model->get_news_categories_tree_by_permission();
            
			$data = $model->get_record_by_id($id);

			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
        



        function add_param(){
            $results_id= FSInput::get('results_id');
			$model  = $this -> model;
			$created_link  = $model -> get_linked_id();
			if(!$created_link)
				return;
			
			$field_display  = $created_link -> add_field_display;
			$field_value  = $created_link -> add_field_value;
			$add_param  = $created_link -> add_parameter;
			
			// create array if add multi param
			$arr_field_value = explode(',',$field_value);
			$arr_add_param = explode(',',$add_param);
			
			
			$list = $model->get_data_from_table($created_link -> add_table,$field_display,$field_value,$created_link -> add_field_distinct);
			$pagination = $model->get_pagination_create_link($created_link -> add_table,$field_display,$field_value,$created_link -> add_field_distinct);
			
            include 'modules/'.$this->module.'/views/news/add_param.php';
		}

        function delete()
        {
            $this->is_check('admin_status',4,'sim đã được xóa');
        }
        
        function is_hot()
    	{
    		$this->is_check('is_hot',1,'is_hot');
    	}
    	function unis_hot()
    	{
    		$this->unis_check('is_hot',0,'un_hot');
    	}
        function is_new()
    	{
    		$this->is_check('is_new',1,'is_new');
    	}
    	function unis_new()
    	{
    		$this->unis_check('is_new',0,'un_new');
    	}
        
        function show_in_homepage()
    	{
    		$this->is_check('show_in_homepage',1,'show home');
    	}
    	function unshow_in_homepage()
    	{
    		$this->unis_check('show_in_homepage',0,'un home');
    	}

        function is_slideshow()
        {
            $this->is_check('is_slide',1,'show slideshow');
        }
        function unis_slideshow()
        {
            $this->unis_check('is_slide',0,'un slideshow');
        }
        function is_new_video()
        {
            $this->is_check('is_new_video',1,'show news dưới slide');
        }
        function unis_new_video()
        {
            $this->unis_check('is_new_video',0,'un news dưới slide');
        }
        
	}
?>