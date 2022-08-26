<?php

/*
 * Huy write
 */
	// models 
	
	
	class SearchBControllersSearch
	{
		function __construct()
		{
		}
		function display($parameters = array(),$title = '')
		{
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';
            
			include 'blocks/search/models/search.php';
			$model = new SearchBModelsSearch();
			$network = $model->get_records('published = 1','fs_network','id,name',' ordering ASC ');
			$type = $model->get_records('','fs_sim_type','id,name,alias',' ordering ASC,id ASC ');
			$price = $model->get_records('','fs_pricesim','id,title,price',' ordering ASC ');
			//$field_work = $model->get_field_work();
			
			// call views
			include 'blocks/search/views/search/'.$style.'.php';
		}
  
	}
	
?>