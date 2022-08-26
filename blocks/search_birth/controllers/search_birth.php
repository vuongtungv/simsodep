<?php

/*
 * Huy write
 */
	// models 
	
	
	class Search_birthBControllersSearch_birth
	{
		function __construct()
		{
		}
		function display($parameters = array(),$title = '')
		{
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';
            
			include 'blocks/search_birth/models/search_birth.php';
			$model = new Search_birthBModelsSearch_birth();
			
			// call views
			include 'blocks/search_birth/views/search_birth/'.$style.'.php';
		}
  
	}
	
?>