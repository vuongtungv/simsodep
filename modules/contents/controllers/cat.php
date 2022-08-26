<?php
/*
 * Huy write
 */
	// controller
	
	class ContentsControllersCat extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;
			$cat  = $model->getCategory();
			if(!$cat)
			{
				echo "Not found Category";	
				die;
			}
			$query_body = $model->set_query_body($cat->id);
			$list = $model->getContentsList($query_body);
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>$cat->name, 1 => '');
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// seo
			$tmpl -> set_data_seo($cat);
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
	}
	
?>