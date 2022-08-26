
<?php 
	class Content_homeBModelsContent_home
	{
		function __construct()
		{
			$fstable = FSFactory::getClass('fstable');
            $this-> table_name = $fstable->_('fs_contents');
		}
		
		function setQuery($str_cats,$limit = '',$style,$type){
		
            global $db;
            $where = '';
			$order = '';
            $limits = '';
            if($str_cats){
                $where .= ' AND category_id_wrapper LIKE "%,'.$str_cats.',%" ';	
            }
            if($limit){
                $limits .= ' LIMIT '. $limit;
            }
            
            switch ($type){
    			case 'ramdom':	
    				$order .= ' RAND(),';
    				break;
                case 'home':
    				$where .= '  AND show_in_homepage = 1 ';
    			    break;	   	
                case 'auto':
    				$order .= ' created_time DESC , ';
    			    break;
			}
            $order .= ' ordering DESC , created_time DESC';
			$query = ' SELECT title,id, summary,image,category_alias,alias,content,created_time
						FROM '.$this-> table_name.' 
						WHERE published = 1 '. $where .' 
                        ORDER BY '. $order .'
						'. $limits;
            //print_r($query);            
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
	}
	
?>