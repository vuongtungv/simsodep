<?php
	class PromotionControllersPromotion_seekers extends Controllers
	{
		function __construct()
		{
			$this->view = 'promotion_seekers' ; 
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
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
			$promotion = $model->get_promotion();
			$answers1 = $model->get_answers($data->questions_answers_1);
			$answers2 = $model->get_answers($data->questions_answers_2);
			$answers3 = $model->get_answers($data->questions_answers_3);
			$answers4 = $model->get_answers($data->questions_answers_4);
			$answers5 = $model->get_answers($data->questions_answers_5);

			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		      
	}
?>