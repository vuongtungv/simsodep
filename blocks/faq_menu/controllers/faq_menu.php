<?php
/*
 * Huy write
 */
// models 
include 'blocks/faq_menu/models/faq_menu.php';

class Faq_menuBControllersFaq_menu {
	function __construct() {
	}
	function display($parameters,$title)
		{
			$style = $parameters->getParams('style');
            $category_id = $parameters->getParams('category_id');
			$style = $style ? $style : 'default';
	
			// call models
			$model = new Faq_menuBModelsFaq_menu();
            
            if($style == 'default'){
                $list = $model->getListCat($category_id);
            }else{
                $list = $model->getFaq($category_id);
            }
			
			if(!$list)
				return;
			// need_chek
			$module = FSInput::get('module');		
			$need_check = 1;
			$root_parrent_activated = 0;
			// lấy các category thuộc nhóm được activate, cả tree activated 
			$group_has_parent_activated = array();
			// call views
			include 'blocks/faq_menu/views/faq_menu/default.php';
		}
}

?>