<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/statistics/models/statistics.php';
	
	class StatisticsBControllersStatistics
	{
		function __construct()
		{
		}
		function display()
		{
			// call models
			$model = new StatisticsModelsStatistics();
			//$pagesview= $model->get_pagesview();
			$online= $model->get_online();
			$online = $online ;
			
			include 'blocks/statistics/views/statistics/default.php';
		}
	
	}
	
?>