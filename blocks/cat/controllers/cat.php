<?php

/*
 * Huy write
 */
	// models 
	
	
	class CatBControllersCat
	{
		function __construct()
		{
		}
		function display($parameters = array(),$title = '')
		{
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';

            
			include 'blocks/cat/models/cat.php';
			$model = new CatBModelsCat();
			$type_level_0 = $model->get_records('level=0','fs_sim_type','id,name,alias,level,parent_id,parent_name',' ordering ASC ');
			$type_level_1 = $model->get_records('level=1','fs_sim_type','id,name,alias,level,parent_id,parent_name',' ordering ASC ');
			// call views
			include 'blocks/cat/views/cat/'.$style.'.php';
		}
		function mdisplay($parameters = array(),$title = '')
		{
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default_mobile';


			include 'blocks/cat/models/cat.php';
			$model = new CatBModelsCat();
			$type_level_0 = $model->get_records('level=0','fs_sim_type','id,name,alias,level,parent_id,parent_name',' ordering ASC ');
			$type_level_1 = $model->get_records('level=1','fs_sim_type','id,name,alias,level,parent_id,parent_name',' ordering ASC ');
			// call views
			include 'blocks/cat/views/cat/'.$style.'.php';
		}
  
	}
	
?>