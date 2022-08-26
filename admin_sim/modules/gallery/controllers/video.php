<?php
	class GalleryControllersvideo extends Controllers
	{
		function __construct()
		{
		    $this->view = 'video' ;  
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data('');
			$str_course = '';
			foreach ($list as $key) {
				$str_course .= $key->course_id.',';
			}
			$course = $model->get_course();
            
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
			$list = $model->get_data('');
			$str_course = '';
			foreach ($list as $key) {
				$str_course .= $key->course_id.',';
			}
            $course = $model->get_course();
			$maxOrdering = $model->getMaxOrdering();
			$uploadConfig = base64_encode('add|'.session_id());
			
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$course = $model->get_course();
			$list = $model->get_data('');
			$str_course = '';
			foreach ($list as $key) {
				$str_course .= $key->course_id.',';
			}
			$data = $model->get_record_by_id($id);
			
			$uploadConfig = base64_encode('edit|'.$id);
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
?>