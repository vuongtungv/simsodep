<?php
	class EventControllersEvent extends Controllers
	{
		function __construct()
		{
			$this->view = 'event' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
            //$categories = $model->get_categories_tree();
			$categories = $model->get_categories_tree_by_permission();
			$str_cat_id = '';
			foreach($categories as $item){
				$str_cat_id .= ','.$item -> id;	
			}
			$str_cat_id .= ',';
            
         	$list = $model->get_data($str_cat_id);
            
           
			$list_key = array();
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
			$categories = $model->get_categories_tree();
			$list_key = array();
			// data from fs_event_categories
			//$categories_home  = $model->get_categories_tree();
            $categories = $model->get_categories_tree_by_permission();
            
			$maxOrdering = $model->getMaxOrdering();
			$uploadConfig = base64_encode('add|'.session_id());
            $list_key = $model->get_records(' new_id = "'.$uploadConfig.'"','fs_event_keyword');
            
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
        
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$categories = $model->get_categories_tree_by_permission();
			$data = $model->get_record_by_id($id);
			// data from fs_event_categories
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
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
        
		function view_comment($new_id){
			$link = 'index.php?module=event&view=comments&keysearch=&text_count=1&text0='.$new_id.'&filter_count=1&filter0=0';
			return '<a href="'.$link.'" target="_blink">Comment</a>'; 
		}
		
		function view_title($data){
			$link = FSRoute::_('index.php?module=event&view=event&id='.$data->id.'&code='.$data -> alias.'&ccode='.$data-> category_alias);
			return '<a target="_blink" href="' . $link . '" title="Xem ngoài font-end">'.$data -> title.'</a>';
		}
        
	}
?>