<?php

/*
 * Huy write
 */
	// models 
	
	
	class Point_buttonBControllersPoint_button
	{
		function __construct()
		{
		}
		function display($parameters = array(),$title = '')
		{
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';
            
			include 'blocks/point_button/models/point_button.php';
			$model = new Point_buttonBModelsPoint_button();
			
			// call views
			include 'blocks/point_button/views/point_button/'.$style.'.php';
		}
  
	}
	
?>