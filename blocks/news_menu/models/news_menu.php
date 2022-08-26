<?php 
	class News_menuBModelsNews_menu
	{
		function __construct()
		{
            $fstable = FSFactory::getClass('fstable');
            $this->table_name = $fstable->_('fs_news');
            $this->table_categories = $fstable->_('fs_news_categories');
		}
        
        function getListCat($category_id){
            //$id = FSInput::get('id');
	        $where = '';
            if($category_id) 
                $where = ' AND  parent_id =  '. $category_id ;  
			$query = ' SELECT name,alias,id,level,parent_id as parent_id,alias, list_parents,icon 
						  FROM '. $this->table_categories .' AS a
						  WHERE published = 1 '. $where .'
						  ORDER BY ordering ASC, id ASC
						 ';            
			global $db;
			$db->query($query);
			$category_list = $db->getObjectList();
			
			if(!$category_list)
			  return;
			$tree_class  = FSFactory::getClass('tree','tree/');
			return $list = $tree_class -> indentRows2($category_list,3);
				
		}
		function getNews($category_id){
	        $where = '';
            if($category_id) 
                $where = ' AND category_id_wrapper LIKE "%,'.$category_id.',%" ';	   
			$query = ' SELECT title,alias,id,category_alias,category_id
						  FROM '. $this->table_name .' AS a
						  WHERE published = 1 '. $where .'
						  ORDER BY ordering ASC, id ASC
						 ';
			global $db;
			$db->query($query);
			$enterprise_list = $db->getObjectList();

				
		}
	}
?>