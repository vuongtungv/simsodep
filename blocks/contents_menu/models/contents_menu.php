<?php 
	class Contents_menuBModelsContents_menu
	{
		function __construct()
		{
		  $fstable = FSFactory::getClass('fstable');
            $this->table_name = $fstable->_('fs_contents');
            $this->table_categories = $fstable->_('fs_contents_categories');
		}
        
        function setQuery($str_cats,$ordering,$limit){
		    $ccode = FSInput::get('ccode');
			$where = '';
			$order = '';
            //if($ccode){
//              $where .= ' AND category_alias_wrapper LIKE "%,'.$ccode.',%" ';  
//            }	
			if($str_cats)
					$where .= ' AND category_id_wrapper LIKE "%,'.$str_cats.',%" ';	
			
			$order .= ' ordering DESC , created_time DESC';
            
			$query = ' SELECT title,alias,image,summary,id,category_alias
						  FROM '. $this->table_name .'
						 WHERE  published = 1 '.$where.'
						  ORDER BY  '.$order.'
						 LIMIT '.$limit  
						 ;
            //print_r($query);
			return $query;
		}
        
		function get_list($str_cats,$ordering,$limit){
			global $db;
			$query = $this->setQuery($str_cats,$ordering,$limit);
			if(!$query)
				return;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
	}
?>