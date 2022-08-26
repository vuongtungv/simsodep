<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/schedule/models/schedule.php';
	class ScheduleBControllersSchedule
	{
		function Content_home()
		{
		  global $module_name;
		}
		function display($parameters,$title)
		{
		     
			//$ordering = $parameters->getParams('ordering');
            $style = $parameters->getParams('style'); 
		    $type  = $parameters->getParams('type'); 
			$limit = $parameters->getParams('limit');
            $limit = $limit ? $limit:3; 
            $style = $style?$style:'default';
			// call models
			$model = new ScheduleBModelsSchedule();
			$data = $model -> setQuery($limit,$style,$type);
            if(!$data)
                return;
            
			
			// call views
			include 'blocks/schedule/views/schedule/'.$style.'.php';
		}
	}
	
?>