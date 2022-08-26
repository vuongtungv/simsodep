
<?php 
	class ProductsModelsProduct extends FSModels
	{
		function __construct()
		{
			$limit = 10;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->page = $page;
			$fstable = FSFactory::getClass('fstable');
			$this->table_name  = $fstable->_('fs_products');
			$this->table_category  = $fstable->_('fs_products_categories');
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
			$query = " SELECT id,name,name_display,is_comment, alias, display_tags,display_title,display_sharing,display_comment,display_category,display_created_time,display_related,updated_time,display_summary
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
		function getproducts()
		{
			$id = FSInput::get('id',0,'int');
			if($id){
				$where = " AND id = '$id' ";				
			} else {
				$code = FSInput::get('code');
				if(!$code)
					die('Not exist this url');
				$where = " AND alias = '$code' ";
			}
			$fs_table = FSFactory::getClass('fstable');
			$query = " SELECT id,title,title_display,source_website,content,category_id,category_alias, summary,display_column, display_title, alias, tags,tags_group, created_time, updated_time, rating_count,rating_sum,seo_title,seo_keyword,seo_description,source_products,products_related
						FROM ".$fs_table -> getTable('fs_products')." 
						WHERE published = 1
						".$where." ";
            //print_r($query) ;   
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}

	function getNewerproductsList($cid,$created_time)
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
		function getOlderproductsList($cid,$created_time)
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
		
		function getRelateproductsList($cid)
		{
			if(!$cid)
				die;
			$code = FSInput::get('code');	
			$where = '';
			if($code){
				$where .= " AND alias <> '$code' ";
			} else {
				$id = FSInput::get('id',0,'int');
				if(!$id)
					die('Not exist this url');
				$where .= " AND id <> '$id' ";
			}
			
			global $db;
			$limit = 10;
			$fs_table = FSFactory::getClass('fstable');
			
			$query = " SELECT id,title,alias, category_id,updated_time ,image,category_alias
						FROM ".$fs_table -> getTable('fs_products')."
						WHERE alias <> '".$code."'
							AND category_id = $cid
							AND published = 1
							".$where."
						ORDER BY  id DESC, ordering DESC
						LIMIT 0,$limit
						";
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
                          FROM ".$fs_table -> getTable('fs_products_categories')."
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
		
    	function get_products_related($products_related, $products_id) {
    		if (! $products_related || ! $products_id)
    			return;
    		$limit = 20;
    		$rest_products_related_ = substr($products_related, 1, -1);  // retourne "abcde"
    		
    		$fs_table = FSFactory::getClass ( 'fstable' );
    		$query = " SELECT id,title,summary,image, alias, category_id,category_alias
    						  FROM " . $fs_table->getTable ( 'fs_products' ) . "
    						  WHERE ID IN ( $rest_products_related_ )
    						  	AND id <>  $products_id
    						  	AND published = 1
    						     ORDER BY  ordering DESC , id DESC
    						     LIMIT $limit
    						 ";
    		global $db;
    		$sql = $db->query ( $query );
    		$result = $db->getObjectList ();
    		return $result;
    	}

		function save_comment(){
			$name = mysql_real_escape_string(FSInput::get('name'));
			$email = mysql_real_escape_string(FSInput::get('email'));
			$text = mysql_real_escape_string(FSInput::get('text'));
			$record_id = FSInput::get('record_id',0,'int');
			$parent_id = FSInput::get('parent_id',0,'int');
			if(!$name || !$email || !$text || !$record_id)
				return false;
			
			$time = date('Y-m-d H:i:s');
			$published =0;
			
			$sql = " INSERT INTO fs_products_comments
						(`name`,email,`comment`,products_id,parent_id,published,created_time,edited_time)
						VALUES('$name','$email','$text','$record_id','$parent_id','$published','$time','$time')
						";
			global $db;
			$db->query($sql);
			$id = $db->insert();
			if($id)
				$this -> recalculate_comment($record_id,$time);
			return $id;
		}
		function recalculate_comment($record_id,$time){
			$sql = " UPDATE  fs_products
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
			
			$sql = " UPDATE  fs_products
						SET rating_count = rating_count + 1,
						    rating_sum = rating_sum + ".$rate."
						    WHERE id = ".$id."
						";
			global $db;
			$db->query($sql);
			$rows = $db->affected_rows();
			
			// save cookies
			if($rows){
				$cookie_rating = isset($_COOKIE['rating_products'])?$_COOKIE['rating_products']:'';
				$cookie_rating .= $id.',';
				setcookie ("rating_products", $cookie_rating, time() + 60); //60s
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
						FROM ".$fs_table -> getTable('fs_products')."
							".$where."
						ORDER BY  id DESC, ordering DESC
						LIMIT 0,$limit
						";
			$db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		function update_hits($products_id){
			if(USE_MEMCACHE){
				$fsmemcache = FSFactory::getClass('fsmemcache');
				$mem_key = 'array_hits';
				
				$data_in_memcache = $fsmemcache -> get($mem_key);
				if(!isset($data_in_memcache))
					$data_in_memcache = array();
				if(isset($data_in_memcache[$products_id])){
					$data_in_memcache[$products_id]++;
				}else{
					$data_in_memcache[$products_id] = 1;
				}
				$fsmemcache -> set($mem_key,$data_in_memcache,10000);
				
			}else{
				if(!$products_id)
					return;
					
				// count
				global $db,$econfig;
				$sql = " UPDATE fs_products 
						SET hits = hits + 1 
						WHERE  id = '$products_id' 
					 ";
				$db->query($sql);
				$rows = $db->affected_rows();
				return $rows;
			}
		}
		
	}
	
?>