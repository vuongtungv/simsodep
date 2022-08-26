
<?php 
	class NewsModelsNews extends FSModels
	{
		function __construct()
		{
			$limit = 10;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->page = $page;
			$fstable = FSFactory::getClass('fstable');
			$this->table_name  = $fstable->_('fs_news');
			$this->table_category  = $fstable->_('fs_news_categories');
            $this -> table_comment = $fstable->_('fs_news_comments');
		}
//		function setQuery()
//		{
//			$query = " SELECT id,title,summary,image, categoryid, tag
//						  FROM fs_contents
//						  WHERE categoryid = $cid 
//						  	AND published = 1
//						ORDER BY  id DESC, ordering DESC
//						 ";
//			return $query;
//		}
		/*
		 * get Category current
		 */
		function get_category_by_id($category_id)
		{
			if(!$category_id)
				return "";
			$query = " SELECT id,name,name_display,is_comment, alias, display_tags,display_title,display_sharing,display_comment,
                        display_category,display_created_time,display_related,updated_time,display_summary,products_related
						FROM ".$this->table_category ."  
						WHERE id = $category_id ";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
		
		/*
		 * get Article
		 */
		function getNews()
		{
			$id = FSInput::get('id');
			if($id){
				$where = " id = '$id' ";				
			} else {
				$code = FSInput::get('code');
				if(!$code)
					die('Not exist this url');
				$where = " alias = '$code' ";
			}
			$fs_table = FSFactory::getClass('fstable');
			$query = " SELECT id,title,seo_title,seo_keyword,seo_description, content,category_name,category_id,category_alias, summary,hits,
                        alias, tags, created_time, updated_time,image
						FROM ".$fs_table -> getTable('fs_news')." 
						WHERE
						".$where." ";
            //print_r($query) ;   
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}

	function getNewerNewsList($cid,$created_time)
		{
			global $db;
			$limit = 10;
			$id = FSInput::get('id');
			$query = " SELECT id,title,created_time, category_id 
						FROM ".$this->table_name."
						WHERE id <> $id
							AND category_id = $cid
							AND published = 1
							AND ( created_time > '$created_time' OR id > $id)
						ORDER BY  id DESC, ordering DESC
						LIMIT 0,$limit
						";
			$db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		function getOlderNewsList($cid,$created_time)
		{
			global $db;
			$limit = 10;
			$id = FSInput::get('id');
			$query = " SELECT id,title ,created_time,category_id
						FROM ".$this->table_name."
						WHERE id <> $id
							AND category_id = $cid
							AND published = 1
							AND ( created_time < '$created_time' OR id < $id)
						ORDER BY  id DESC, ordering DESC
						LIMIT 0,$limit
						";
			$db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		function getRelateNewsList($cid)
		{
			if(!$cid)
				die;
                
			global $db;
			$limit = 4;
			$fs_table = FSFactory::getClass('fstable');
			$id = FSInput::get('id',0,'int');
            if($id){
                $where = " AND id  != '$id' ";
            } else {
                $code = FSInput::get('code');
                if(!$code)
                    die('Not exist this url');
                $where = " AND alias != '$code' ";
            }
			$query = ' SELECT id,title,alias, category_id,updated_time ,image,category_alias,created_time
						FROM '.$fs_table -> getTable('fs_news').'
						WHERE category_id = '.$cid.'
							AND published = 1 '.$where.'
						ORDER BY  created_time DESC, ordering DESC
						LIMIT ' .$limit;
			$db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		
	/* 
		 * get array [id] = alias
		 */
		function get_content_category_ids($str_ids){
            if(!$str_ids)
                 return;
             $fs_table = FSFactory::getClass('fstable');    
            
		  // search for category
           
            $query = " SELECT id,alias
                          FROM ".$fs_table -> getTable('fs_news_categories')."
                          WHERE id IN (".$str_ids.")
                         ";
            
           global $db;
            $sql = $db->query($query);
            $result = $db->getObjectList();
            $array_alias = array();
            if($result)
	            foreach ($result as $item){
	               	$array_alias[$item -> id] = $item -> alias;
	            }
            return $array_alias;
		}
        
        function get_products_related($products_related) {
    		if (! $products_related)
    			return;
    		$limit = 20;
    		$rest_products_related_ = substr($products_related, 1, -1);  // retourne "abcde"
    		
    		$fs_table = FSFactory::getClass ( 'fstable' );
    		$query = " SELECT id,name,summary,image, alias, category_id,category_alias,price_old,price,discount
    						  FROM " . $fs_table->getTable ( 'fs_products' ) . "
    						  WHERE ID IN ( $rest_products_related_ )
    						  	AND published = 1
    						     ORDER BY  ordering DESC , id DESC
    						     LIMIT $limit
    						 ";
    		global $db;
    		$sql = $db->query ( $query );
    		$result = $db->getObjectList ();
    		return $result;
    	}
		
    	function get_news_related($news_related, $news_id,$is_video) {
    		if (! $news_related || ! $news_id)
    			return;
    		$where = '';
    		$limit = 20;
    		$rest_products_related_ = substr($news_related, 1, -1);  // retourne "abcde"
    		
    		if($is_video){
				$where .= " AND is_video = '$is_video' ";
			}

    		$fs_table = FSFactory::getClass ( 'fstable' );
    		$query = " SELECT id,title,summary,image, alias, category_id,category_alias
    						  FROM " . $fs_table->getTable ( 'fs_news' ) . "
    						  WHERE ID IN ( $rest_products_related_ )
    						  	AND id <>  $news_id
    						  	AND published = 1
    						  	".$where."
    						     ORDER BY  ordering DESC , id DESC
    						     LIMIT $limit
    						 ";
    		global $db;
    		$sql = $db->query ( $query );
    		$result = $db->getObjectList ();
    		return $result;
    	}

        function get_comments($news_id) {
    		global $db;
    		if (! $news_id)
    			return;
    		
    		//			$limit = 5;
    		//			$id = FSInput::get('id');
    		$query = " SELECT name,created_time,id,email,comment,parent_id,level,record_id
    						FROM ".$this -> table_comment."
    						WHERE record_id = $news_id
    							AND published = 1
    						ORDER BY  created_time  DESC
    						";
    		$db->query ( $query );
    		$result = $db->getObjectList ();
    		
    		$tree  = FSFactory::getClass('tree','tree/');
    		$list = $tree -> indentRows2($result);
    		return $list;
    	}

		//function save_comment(){
//		    $row = array();
//			$name = FSInput::get('name');
//			$email = FSInput::get('email');
//			$text = FSInput::get('text');
//            
//			$record_id = FSInput::get('record_id',0,'int');
//			$parent_id = FSInput::get('parent_id',0,'int');
//            
//			if(!$name || !$email || !$text || !$record_id)
//				return false;
//			
//            //print_r(123);die;
//			$time = date('Y-m-d H:i:s');
//			$published =1;
//			
//            $row['name'] = $name;
//			$row['email'] = $email;
//			$row['comment'] = $text;
//            $row['record_id'] = $record_id;
//            $row['parent_id'] = $parent_id;
//            $row['published'] = $published;
//            $row['edited_time'] = $time;
//            $row['created_time'] = $time;
//            
//			global $db;
//			
//			$id = $this->_add($row,$this->table_comment,1);
//            //print_r($id);die;
//			if($id){
//				$this -> recalculate_comment($record_id,$time);
//                $this->clean_cache();
//            }
//			return $id;
//		}
        
		function recalculate_comment($record_id,$time){
			$sql = " UPDATE  fs_news
						SET comments_total = comments_total + 1,
						    comments_unread = comments_unread + 1,
						    comments_last_time = '".$time."' 
						    WHERE id = ".$record_id."
						";
			global $db;
			$db->query($sql);
			$rows = $db->affected_rows();
		}
		function save_rating(){
			$id = FSInput::get('id',0,'int');
			$rate = FSInput::get('rate',0,'int');
			
			$sql = " UPDATE  fs_news
						SET rating_count = rating_count + 1,
						    rating_sum = rating_sum + ".$rate."
						    WHERE id = ".$id."
						";
			global $db;
			$db->query($sql);
			$rows = $db->affected_rows();
			
			// save cookies
			if($rows){
				$cookie_rating = isset($_COOKIE['rating_news'])?$_COOKIE['rating_news']:'';
				$cookie_rating .= $id.',';
				setcookie ("rating_news", $cookie_rating, time() + 60); //60s
			}
			return $rows;
		}
		
		function get_comment_by_id($comment_id){
			if(!$comment_id)
				return false;
			$query = " SELECT * 
						FROM fs_contents_comments
						WHERE id =  $comment_id
							AND published = 1
						";
			global $db;
			$db->query($query);
			return $result = $db->getObject();
		}
	function  get_relate_by_tags($tags,$exclude = '',$category_id){
			if(!$tags)
				return;
			$arr_tags = explode(',',$tags);
			$where = ' WHERE 1 = 1';
			$where .= ' AND  category_id_wrapper like "%,'.$category_id.',%" ';
			
			if($exclude)
				$where .= ' AND id <> '.$exclude.' ';
			$total_tags = count($arr_tags);
			if($total_tags){
				$where .= ' AND (';
				$j = 0;
				for($i = 0; $i < $total_tags; $i ++){
					$item = trim($arr_tags[$i]);
					if($item){
						if($j > 0)
							$where .= ' OR ';
						$where .= " tags like '%".addslashes($item)."%' ";
						$j ++;
					}
				}
				$where .= ' )';
			}
			
			global $db;
			$limit = 10;
			$fs_table = FSFactory::getClass('fstable');
			
			$query = " SELECT id,title,alias, category_id , image, category_alias,summary
						FROM ".$fs_table -> getTable('fs_news')."
							".$where."
						ORDER BY  id DESC, ordering DESC
						LIMIT 0,$limit
						";
			$db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		function update_hits($news_id){
			if(USE_MEMCACHE){
				$fsmemcache = FSFactory::getClass('fsmemcache');
				$mem_key = 'array_hits';
				
				$data_in_memcache = $fsmemcache -> get($mem_key);
				if(!isset($data_in_memcache))
					$data_in_memcache = array();
				if(isset($data_in_memcache[$news_id])){
					$data_in_memcache[$news_id]++;
				}else{
					$data_in_memcache[$news_id] = 1;
				}
				$fsmemcache -> set($mem_key,$data_in_memcache,10000);
				
			}else{
				if(!$news_id)
					return;
					
				// count
				global $db,$econfig;
				$sql = " UPDATE fs_news 
						SET hits = hits + 1 
						WHERE  id = '$news_id' 
					 ";
				$db->query($sql);
				$rows = $db->affected_rows();
				return $rows;
			}
		}
		
	}
	
?>