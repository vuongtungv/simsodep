<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/product_menu/models/product_menu.php';
	
	class Product_menuBControllersProduct_menu 
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';
	
			// call models
			$model = new Product_menuBModelsProduct_menu();
			$list = $model->getListCat($style);
			if(!$list)
				return;
			// need_chek
			$module = FSInput::get('module');		
			$need_check = 1;
			$root_parrent_activated = 0;
			// lấy các category thuộc nhóm được activate, cả tree activated 
			$group_has_parent_activated = array();
			
			// thực hiện việc đưa danh mục activated lên đầu
			if($module == 'products'){
				$ccode = FSInput::get('ccode');
				foreach ( $list as $item ){
					if($item->alias ==  $ccode){
						if($item -> level > 0 ){
							$root_parrent_activated = 	$item -> parent_id;
							$group_has_parent_activated[] = $item -> id;
							$group_has_parent_activated[] = $item -> parent_id;
							$level_current = $item -> level;
						    
						//	 L?y tree có d? sâu > 2
							while($level_current > 1){
								foreach ( $list as $item_child ){
									if($item_child -> id  == $root_parrent_activated ){
										$group_has_parent_activated[] = $item_child -> id;
										$group_has_parent_activated[] = $item_child -> parent_id;
										break;
									}
								}
								$level_current --;
							}
						}else{
							$root_parrent_activated = 	$item -> id;
							$group_has_parent_activated[] = $item -> id;
						}
						break;
					}
				}
            }
			// call views
			include 'blocks/product_menu/views/product_menu/'.$style.'.php';
		}
	}
	
?>