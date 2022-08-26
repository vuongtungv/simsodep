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
                $listTop3 = $model->getTop3();
                $listHot = $model->getHot();
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
        function timeAgo($time_ago)
        {
            $time_ago = strtotime($time_ago);
            $cur_time   = time();
            $time_elapsed   = $cur_time - $time_ago;
            $seconds    = $time_elapsed ;
            $minutes    = round($time_elapsed / 60 );
            $hours      = round($time_elapsed / 3600);
            $days       = round($time_elapsed / 86400 );
            $weeks      = round($time_elapsed / 604800);
            $months     = round($time_elapsed / 2600640 );
            $years      = round($time_elapsed / 31207680 );
            // Seconds
            if($seconds <= 60){
                return "Just now";
            }
            //Minutes
            else if($minutes <=60){
                if($minutes==1){
                    return "1 phút trước";
                }
                else{
                    return "$minutes phút trước";
                }
            }
            //Hours
            else if($hours <=24){
                if($hours==1){
                    return "1 giờ trước";
                }else{
                    return "$hours giờ trước";
                }
            }
            //Days
            else if($days <= 7){
                if($days==1){
                    return "Hôm qua";
                }else{
                    return "$days ngày trước";
                }
            }
            //Weeks
            else if($weeks <= 4.3){
                if($weeks==1){
                    return "Một tuần trước";
                }else{
                    return "$weeks tuần trước";
                }
            }
            //Months
            else if($months <=12){
                if($months==1){
                    return "1 tháng trước";
                }else{
                    return "$months tháng trước";
                }
            }
            //Years
            else{
                if($years==1){
                    return "1 năm trước";
                }else{
                    return "$years năm trước";
                }
            }
        }
	}
	
?>