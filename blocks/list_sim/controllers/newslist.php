<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/newslist/models/newslist.php';
	class NewslistBControllersNewslist
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			$cat_id = $parameters->getParams('category_id'); 
			$ordering = $parameters->getParams('ordering'); 
		    $type  = $parameters->getParams('type'); 
			$limit = $parameters->getParams('limit');
			$limit = $limit ? $limit:6; 
            $style = $parameters->getParams('style');
			// call models
			$model = new NewslistBModelsNewslist();
			
			if($style == 'home'){
			    $list = $model -> get_list(0,$ordering,$limit,$type); 
                
				$list_cats = $model -> get_cats();
				if(!$list_cats)
				    return;
                    
				$total_cat = count($list_cats);
				$array_cats = array();
				$array_news_by_cat = array();
				$children_cat_array = array();
				$i = 0;
				foreach (@$list_cats as $item)
				{
					$news_in_cat = $model -> get_list($item->id,$ordering,$limit,$type);
					if(count($news_in_cat)){
						$array_cats[] = $item;
						$array_news_by_cat[$item->id] = $news_in_cat;	
						$i ++;
					}
				}
			}else{
			    $list = $model -> get_list($cat_id,$ordering,$limit,$type); 
			}
            
			$style = $style?$style:'default';
			// call views
			include 'blocks/newslist/views/newslist/'.$style.'.php';
		}
        
        /*
    	 * get record by rid
    	 */
    	function get_record_by_id($id, $table_name = '', $select = '*') {
    		if (! $id)
    			return;
    		if (! $table_name)
    			$table_name = $this->table_name;
                
            $fstable = FSFactory::getClass('fstable');
            $this->table_name = $fstable->_($table_name);    
    		$query = " SELECT " . $select . "
    					  FROM " . $this->table_name . "
    					  WHERE id = $id ";
    		
    		global $db;
    		$sql = $db->query ( $query );
    		$result = $db->getObject ();
    		return $result;
    	}
	}
	
?>