<?php
class QuestionControllersCategories extends ControllersCategories{
	function __construct(){
		parent::__construct();
		$this->view = 'categories';
	}

	function edit(){
		$model = $this->model;
		$ids = FSInput::get('id', array(), 'array');
		$id = $ids[0];
		$data = $model->get_record_by_id($id);
		$categories = $model->get_categories_tree();
		//$categories_products = $model->get_product_categories_tree_by_permission();
		//$products_related = $model->get_products_related($data->products_related);
        
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}
}