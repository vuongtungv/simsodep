<?php
/*
 * Huy write
 */
// models 
include 'blocks/contents_menu/models/contents_menu.php';

class Contents_menuBControllersContents_menu {
	function __construct() {
	}
	function display($parameters, $title) {
		$style = $parameters->getParams ( 'style' );
		$cat_id = $parameters->getParams('category_id'); 
		$ordering = $parameters->getParams('ordering'); 
		$limit = $parameters->getParams('limit');
        $limit = $limit ? $limit:6; 
		$style = $style ? $style : 'default';
		
		// call models
		$model = new Contents_menuBModelsContents_menu ();
        $list = $model -> get_list($cat_id,$ordering,$limit);
		// need_chek
		// call views
		include 'blocks/contents_menu/views/contents_menu/' . $style . '.php';
	}
}

?>