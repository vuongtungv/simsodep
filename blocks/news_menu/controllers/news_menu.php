<?php
/*
 * Huy write
 */
// models 
include 'blocks/news_menu/models/news_menu.php';

class News_menuBControllersNews_menu {
	function __construct() {
	}
	function display($parameters,$title)
		{
			$style = $parameters->getParams('style');
            $category_id = $parameters->getParams('category_id');
			$style = $style ? $style : 'default';
	
			// call models
			$model = new News_menuBModelsNews_menu();
            
            if($style == 'default' || $style == 'responsive'){
                $list = $model->getListCat($category_id);
            }else{
                $list = $model->getNews($category_id);
            }
			
			if(!$list)
				return;
			// need_chek
			$module = FSInput::get('module');
						$need_check = 1;
			$root_parrent_activated = 0;
			// lấy các category thuộc nhóm được activate, cả tree activated 
			$group_has_parent_activated = array();
			
			// thực hiện việc đưa danh mục activated lên đầu
			if($module == 'enterprises'){
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
			include 'blocks/news_menu/views/news_menu/'.$style.'.php';
		}
}

?>