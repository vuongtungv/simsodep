<?php
class StaffControllersStaff extends Controllers {
    
    
	function display() {
		parent::display ();
		$sort_field = $this->sort_field;
		$sort_direct = $this->sort_direct;
		
		$model = $this->model;
		$list = $model->get_data ('');
		
		$pagination = $model->getPagination ('');
		include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
	}
}
?>