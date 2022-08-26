<?php
/*
 * Huy write
 */
	// models 
	include 'modules/menus/models/notifications.php';
	
	class MenusControllersNotifications
	{
		function __construct()
		{
			$module = 'menus';
			$this -> module = $module ;
		}
		function display()
		{
			// call models
			$model = new MenusModelsNotifications();
			$list = $model->getMenusNotifications();
            $total = count($list);
			$menus = array();
			// call views
            // var_dump($list);
			
			include 'modules/menus/views/notifications/default.php';
		}
		
	}
	
?>