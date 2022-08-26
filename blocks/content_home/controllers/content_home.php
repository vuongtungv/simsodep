<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/content_home/models/content_home.php';
	class Content_homeBControllersContent_home
	{
		function Content_home()
		{
		  global $module_name;
		}
		function display($parameters,$title)
		{
		     
			$cat_id = $parameters->getParams('category_id'); 
			//$ordering = $parameters->getParams('ordering');
            $style = $parameters->getParams('style'); 
		    $type  = $parameters->getParams('type'); 
			$limit = $parameters->getParams('limit');
            $limit = $limit ? $limit:3; 
            $style = $style?$style:'default';
			// call models
			$model = new Content_homeBModelsContent_home();
			$data = $model -> setQuery($cat_id,$limit,$style,$type);
            if(!$data)
                return;
            
			
			// call views
			include 'blocks/content_home/views/content_home/'.$style.'.php';
		}
	}
	
?>