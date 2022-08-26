<?php 
	class Faq_menuBModelsFaq_menu
	{
		function __construct()
		{
		}
        
        function getListCat($category_id){
            //$id = FSInput::get('id');
            $fstable = FSFactory::getClass('fstable');
			$Itemid = FSInput::get('Itemid',16,'int');
			if($Itemid == 15){
			  	$this->table_categories = $fstable->_('fs_aq_categories');
			}else{
			  	$this->table_categories = $fstable->_('fs_faq_categories');
			}
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
		function getFaq($category_id){
			$fstable = FSFactory::getClass('fstable');
			$Itemid = FSInput::get('Itemid',16,'int');
			if($Itemid == 15){
			  	$this->table_name  = $fstable->_('fs_aq');
			}else{
			  	$this->table_name  = $fstable->_('fs_faq');
			}
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