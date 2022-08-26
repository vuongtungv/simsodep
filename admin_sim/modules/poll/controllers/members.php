<?php
	class PollControllersMembers extends Controllers
	{
		function __construct()
		{
			$this->view = 'members' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data('');
			$promotion = $model->get_promotion();
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
//			$answers = $model->get_answers();
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
			$promotion = $model->get_promotion();
			$answers1 = $model->get_answers($data->answers_1);
			$answers2 = $model->get_answers($data->answers_2);
			$answers3 = $model->get_answers($data->answers_3);
			$answers4 = $model->get_answers($data->answers_4);
			$answers5 = $model->get_answers($data->answers_5);

			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		      
	}
?>