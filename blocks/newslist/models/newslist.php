
<?php 
	class NewslistBModelsNewslist
	{
		function __construct()
		{
		    $fstable = FSFactory::getClass('fstable');
            $this->table_name = $fstable->_('fs_news');
            $this->table_categories = $fstable->_('fs_news_categories');
//            $this->table_video = $fstable->_('fs_video');
		}
		
		function setQuery($str_cats,$ordering,$limit,$type){
		    $ccode = FSInput::get('ccode');
			$where = '';
			$order = '';
        //    if($ccode && $type =='highlight'){
        //      $where .= ' AND category_alias_wrapper LIKE "%,'.$ccode.',%" ';  
        //    }	
			if($str_cats)
					$where .= ' AND category_id_wrapper LIKE "%,'.$str_cats.',%" ';
//			echo $type; die;
			switch ($type){
    			case 'hit_most':
    				$limit_day = $limit;
    				$where .= '  AND published_time >= DATE_SUB(CURDATE(), INTERVAL '.$limit_day.' DAY) ';	
    				break;
    			case 'ramdom':	
    				$order .= ' RAND(),';
    				break;
    			case 'newest':
    				$where .= '  AND is_new = 1 ';
    			    break;
                case 'home':
    				$where .= '  AND show_in_homepage = 1 ';
    			    break;
                case 'marquee':
    				$where .= '  AND is_marquee = 1 ';
    			    break;
                case 'new_video':
    				$where .= '  AND is_new_video = 1 AND is_video = 0 ';
    			    break;
                case 'highlight':
    				$where .= ' AND is_hot = 1';
    			    break;
                case 'hits':
                    //$where .= '  AND is_view = 1 ';
    				$order .= ' hits DESC , ';
    			    break;
                case 'auto':
    				$order .= ' id DESC , ';
    			    break;
			}
			$order .= ' updated_time DESC, id DESC ';
//			echo $order; die;
			$query = ' SELECT title,alias,image,summary,id,category_name, category_alias,created_time,updated_time
						  FROM '. $this->table_name .'
						  WHERE  published = 1 '. $where .'
						  ORDER BY  '. $order .'
						  LIMIT '. $limit
						 ;
//			echo $query;
			return $query;
		}
        
		function get_list($str_cats,$ordering,$limit,$type){
			global $db;
//			$ordering = " id DESC ";
			$query = $this->setQuery($str_cats,$ordering,$limit,$type);
//			echo $query;
			if(!$query)
				return;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
        	
		function get_cats(){
			global $db;
			$query = ' SELECT id,name, alias, list_parents,image,level,parent_id,icon
					FROM '. $this->table_categories .' 
					WHERE published = 1 AND show_in_homepage = 1
					ORDER BY ordering
							';
			$db->query($query);
			$result = $db->getObjectList();
			return $result;	
		}
        
        function getVideo($limit_video,$type){
            global $db;
			$query = ' SELECT *
					FROM '. $this->table_name .' 
					WHERE published = 1 AND is_video = 1
					ORDER BY id DESC 
                    LIMIT '. $limit_video  
					;
			$db->query($query);
			$result = $db->getObjectList();
			return $result;	
        }
        function getTop3(){
            global $db;
            $limit =10;

            $query = ' SELECT *
					FROM '. $this->table_name .' 
					WHERE published = 1 AND show_in_homepage !=1 ORDER BY id DESC 
                    LIMIT '. $limit
            ;
            $db->query($query);
            $result = $db->getObjectList();
            return $result;
        }
        function getHot(){
            global $db;
            $limit =12;
            $query = ' SELECT *
					FROM '. $this->table_name .' 
					WHERE published = 1 AND show_in_homepage = 1 ORDER BY id DESC 
                    LIMIT '. $limit
            ;
            $db->query($query);
            $result = $db->getObjectList();
            return $result;
        }
	}
	
?>