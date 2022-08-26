<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/fanpage_facebook/models/fanpage_facebook.php';
	class Fanpage_facebookBControllersFanpage_facebook
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			//$cat_id = $parameters->getParams('category_id'); 
			//$ordering = $parameters->getParams('ordering'); 
		    //$type  = $parameters->getParams('type'); 
			//$limit = $parameters->getParams('limit');
			//$limit = $limit ? $limit:3; 
			// call models
			$model = new Fanpage_facebookBModelsFanpage_facebook();
			$style = $parameters->getParams('style');
			$style = $style?$style:'default';
			
			// call views
			include 'blocks/fanpage_facebook/views/fanpage_facebook/'.$style.'.php';
		}
	}
	
?>