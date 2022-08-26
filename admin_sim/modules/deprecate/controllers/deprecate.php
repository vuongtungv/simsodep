<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';
		  
	class DeprecateControllersDeprecate extends Controllers
	{
		function __construct()
		{
			$this->view = 'deprecate' ;
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;



			$list = $this -> model->get_data('');
			$new = $this->model->get_count('status = \'Mới\'','fs_deprecate');
			$pagination = $this -> model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
            $history = $this->model -> get_history();
            $note = $this->model -> get_note();


//            $list_user = $model -> get_list_user();

			$data = $model->get_record_by_id($id);
			$city_name = $model->get_record_by_id(@$data->city_name,'fs_cities');
//			$parts = $model->get_parts();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
        function save_comments() {

            $model = $this->model;
            $rs = $model->save_comments();

            if ($rs == 0) {
                echo 0;
                return false;
            }

            echo 1;
            return true;
        }
        function save_note() {

            $model = $this->model;

            $rs = $model->save_note();

            if ($rs == 0) {
                return false;
            }

            $note = $model -> get_note();
            include 'modules/order/views/order/note.php';

        }
	}
	
?>