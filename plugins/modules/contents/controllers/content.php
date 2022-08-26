<?php
/*
 * Huy write
 */
	// controller
	
	class ContentsControllersContent extends FSControllers
	{
		var $module;
		var $view;
	
		function display()
		{
			// call models
			$model = $this->model;
			
			$data = $model->get_data();
			if(!$data)
				die('Kh&#244;ng t&#7891;n t&#7841;i b&#224;i vi&#7871;t n&#224;y');
			global $tmpl,$module_config;
			$tmpl -> set_data_seo($data);
	
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>$data -> category_name, 1 => 'javascript: void(0)');
			$breadcrumbs[] = array(0=>$data->title, 1 => '');	
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			
			// seo
			$tmpl -> set_data_seo($data);
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

	}
	
?>