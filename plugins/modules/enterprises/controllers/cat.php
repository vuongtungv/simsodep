<?php
/*
 * Huy write
 */
	// controller
	
	class EnterprisesControllersCat extends FSControllers
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
				echo "Kh&#244;ng th&#7845;y Category";	
				die;
			}
			global $tags_group;
//            $tags_group = $cat -> tags_group;
			$query_body = $model->set_query_body($cat->id);
			$list = $model->getenterprisesList($query_body);
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);
            $Itemid = 13;
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Doanh nghiệp Việt Nam', 1 => FSRoute::_('index.php?module=enterprises&view=home&Itemid='.$Itemid));
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