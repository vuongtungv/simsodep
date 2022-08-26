<?php
	// models 
	include 'blocks/faq/models/faq.php';
	class FaqBControllersFaq
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{

			$ordering = $parameters->getParams('ordering'); 
		    $type  = $parameters->getParams('type'); 
			$limit = $parameters->getParams('limit');
			$limit = $limit ? $limit:5; 
			// call models
			$model = new FaqlistBModelsFaqlist();
			$list = $model -> get_list($ordering,$limit,$type);
            
            $style = $parameters->getParams('style');
            $style = $style?$style:'default';
			include 'blocks/faq/views/faq/'.$style.'.php';
		}
	}
	
?>