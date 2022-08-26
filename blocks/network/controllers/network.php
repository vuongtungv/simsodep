<?php

/*
 * Huy write
 */
	// models 
	
	
	class NetworkBControllersNetwork
	{
		function __construct()
		{
		}
		function display($parameters = array(),$title = '')
		{
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';

            
			include 'blocks/network/models/network.php';
			$model = new NetworkBModelsNetwork();
			$net = $model->get_records('','fs_network','id,name,header',' id ASC,ordering ASC ');
			
			// call views
			include 'blocks/network/views/network/'.$style.'.php';
		}
  
	}
	
?>