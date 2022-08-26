<?php
	$path = PATH_BASE . DS . 'modules' . DS . 'statistics' . DS . 'controllers' . DS . 'statistics' . ".php";
	if(!file_exists($path))
		echo FSText::_("Not found controller");
	else
		require_once 'controllers/statistics.php';
		
	$c =  'StatisticsControllersStatistics';
	$controller = new $c();

	$controller->display();
?>