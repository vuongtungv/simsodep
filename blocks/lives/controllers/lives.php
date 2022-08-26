<?php

/*
 * Huy write
 */
	// models 
	
	
	class LivesBControllersLives
	{
		function __construct()
		{
		}
		function display($parameters = array(),$title = '')
		{
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';
            
			include 'blocks/lives/models/lives.php';
			$model = new LivesBModelsLives();
			
			// call views
			include 'blocks/lives/views/lives/'.$style.'.php';
		}
  
	}
	
?>