<?php 
	class SimModelsWait extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
		    date_default_timezone_set('Asia/Ho_Chi_Minh');  
			$this -> limit = 500;
			$this -> view = 'wait';

            $this -> table_name = FSTable_ad::_('fs_sim');
            $this -> table_link = 'fs_menus_createlink';
            $this -> table_products = 'fs_products';

            $limit_created_link = 30;
			$this->limit_created_link = $limit_created_link;
			$this -> check_alias = 0;
			parent::__construct();
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
            
            // from
    		if(isset($_SESSION[$this -> prefix.'text0']))
    		{
    			$date_from = $_SESSION[$this -> prefix.'text0'];
    			if($date_from){
    				$date_from = strtotime($date_from);
    				$date_new = date('Y-m-d H:i:s',$date_from);
    				$where .= ' AND created_time >=  "'.$date_new.'" ';
    			}
    		}
    
    		// to
    		if(isset($_SESSION[$this -> prefix.'text1']))
    		{
    			$date_to = $_SESSION[$this -> prefix.'text1'];
    			if($date_to){
    				$date_to = $date_to . ' 23:59:59';
    				$date_to = strtotime($date_to);
    				$date_new = date('Y-m-d H:i:s',$date_to);
    				$where .= ' AND created_time <=  "'.$date_new.'" ';
    			}
    		}

    		// from
    		if(isset($_SESSION[$this -> prefix.'text2']))
    		{
    			$price_from = $_SESSION[$this -> prefix.'text2'];
    			if($price_from){
    				$where .= ' AND price >= '.$price_from.'';
    			}
    		}
    
    		// to
    		if(isset($_SESSION[$this -> prefix.'text3']))
    		{
    			$price_to = $_SESSION[$this -> prefix.'text3'];
    			if($price_to){
    				$where .= ' AND price <= '.$price_to.'';
    			}
    		}
			
			// estore
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND network_id = '.$filter.'';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter1 = $_SESSION[$this -> prefix.'filter1'];
				if($filter1){
					$where .= ' AND agency = '.$filter1.'';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'])){
				$filter2 = $_SESSION[$this -> prefix.'filter2'];
				if($filter2){
					$where .= " AND cat_id LIKE '%,".$filter2.",%' ";
				}
			}	
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND (number LIKE '%".$keysearch."%' OR sim LIKE '%".$keysearch."%') ";
				}
			}

			$query = " SELECT id, sim, number, price, created_time, network, status, admin_status, cat_name, agency_name, commission_value, price_public 
						  FROM 
						  	".$this -> table_name."
						  	WHERE admin_status = 0 ".
						 $where." ";
			return $query;
		}

		function getTotal($value='')
		{
			$query = $this->setQuery();
			$query = str_ireplace('id, sim, number, price, created_time, network, status, admin_status, cat_name, agency_name, commission_value, price_public','count(id)',$query);
			if(!$query)
				return ;
			global $db;
			$sql = $db->query($query);
			$total = $db->getResult();
			return $total;
		}
		
		function save($row = array(), $use_mysql_real_escape_string = 1){
			$title = FSInput::get('title');		
			if(!$title)
				return false;
			$id = FSInput::get('id',0,'int');	
			$category_id = FSInput::get('category_id',0,'int');
			if(!$category_id){
				Errors::_('Bạn phải chọn danh mục');
				return;
			}
			
			$cat =  $this->get_record_by_id($category_id,$this -> table_category_name);
			$row['category_id_wrapper'] = $cat -> list_parents;
			$row['category_alias_wrapper'] = $cat -> alias_wrapper;
			$row['category_name'] = $cat -> name;
			$row['category_alias'] = $cat -> alias;
            
     
			
			$row['content'] = htmlspecialchars_decode(FSInput::get('content'));
			$time = date('Y-m-d H:i:s');
            $row['published'] = 1;

            $user_id = isset($_SESSION['ad_userid'])? $_SESSION['ad_userid']:'';
            if(!$user_id)
                return false;
                
            $user = $this->get_record_by_id($user_id,'fs_users','username');
            if($id){
          		$row['updated_time'] = $time;
                $row['end_time'] = $time;
                $row['author_last'] = $user->username;
                $row['author_last_id'] = $user_id;
            }else{
            	$row['created_time'] = $time;
            	$row['updated_time'] = $time;
                $row['end_time'] = $time;
                $row['start_time'] = $time;
                $row['author'] = $user->username;
                $row['author_id'] = $user_id;
            }
            
            $fsstring = FSFactory::getClass('FSString','','../');
            $alias = $fsstring -> stringStandart($title);
			$rs = parent::save($row);

            return $rs;
		}
        
        function get_news_related($news_related){
    		if(!$news_related)
    				return;
    		$query   = " SELECT id, title,image 
    					FROM ".$this -> table_name."
    					WHERE id IN (0".$news_related."0) 
    					 ORDER BY POSITION(','+id+',' IN '0".$news_related."0')
    					";
    		global $db;
    		$sql = $db->query($query);
    		$result = $db->getObjectList();
    		return $result;
    	}
        /*
		 *==================== AJAX RELATED news==============================
		 */
	
    	function ajax_get_news_related(){
    		$news_id = FSInput::get('new_id',0,'int');
            // category_id danh muc
    		$category_id = FSInput::get('category_id',0,'int');
            // tim kiem keyword
    		$keyword = FSInput::get('keyword');
            $keyword_tag = FSInput::get('keyword_tag');
            // chuoi id tin lien quan keyword tag
            $str_related = FSInput::get('str_related');
            // id khi click vao xoa tin lien quan
            $id = FSInput::get('id',0,'int');
            
    		$where = ' WHERE published = 1 ';
            
    		if($category_id){
    			$where .= ' AND (category_id_wrapper LIKE "%,'.$category_id.',%"	) ';
    		}
            if($keyword){
                $where .= " AND ( title LIKE '%".$keyword."%' OR alias LIKE '%".$keyword."%' OR content LIKE '%".$keyword."%' )";
            }
    		if($keyword_tag){
    		    $keyword_tag = explode(',',$keyword_tag);
                //$keyword_tag = str_replace(',','',$keyword_tag);
                $total = count($keyword_tag);
                $where .= ' AND ( ';
                for($i=0;$i<$total;$i++){
                    if($i == 0){
                        $where .= " title LIKE '%".$keyword_tag[$i]."%' OR alias LIKE '%".$keyword_tag[$i]."%' OR content LIKE '%".$keyword_tag[$i]."%' ";
                    }else{
                       $where .= " OR title LIKE '%".$keyword_tag[$i]."%' OR alias LIKE '%".$keyword_tag[$i]."%' OR content LIKE '%".$keyword_tag[$i]."%' ";
                    }
                }
                $where .= ' ) '; 
            }
            if($str_related){
                if($id){
                    $str_related = str_replace(','.$id,'',$str_related);
                }
                $where .= ' AND id NOT IN(0'.$str_related.'0) ';
            }
    		
    		$query_body = ' FROM '.$this -> table_name.' '.$where;
    		$ordering = " ORDER BY created_time DESC , id DESC ";
    		$query = ' SELECT id,category_id,title,category_name,image'.$query_body.$ordering.' LIMIT 100 ';
            //print_r($query);
    		global $db;
    		$sql = $db->query($query);
    		$result = $db->getObjectList();
    		return $result;
    	}
		
		/*
		 * select in category of home
		 */
		function get_categories_tree()
		{
			global $db;
			$query = " SELECT *
						  FROM 
						  	".$this -> table_category_name." AS a
						  	WHERE published = 1 ORDER BY ordering ";         
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			return $list;
		}
		
		/*
	     * Save all record for list form
	     */
	    function save_all(){
	        $total = FSInput::get('total',0,'int');
	        if(!$total)
	           return true;
	        $field_change = FSInput::get('field_change');
	        if(!$field_change)
	           return false;
	        $field_change_arr = explode(',',$field_change);
	        $total_field_change = count($field_change_arr);
	        $record_change_success = 0;
	        for($i = 0; $i < $total; $i ++){
//	        	$str_update = '';
	        	$row = array();
	        	$update = 0;
	        	foreach($field_change_arr as $field_item){
	        	      $field_value_original = FSInput::get($field_item.'_'.$i.'_original')	;
	        	      $field_value_new = FSInput::get($field_item.'_'.$i)	;
	        		  if(is_array($field_value_new)){
        	      		$field_value_new = count($field_value_new)?','.implode(',',$field_value_new).',':'';
	        	      }
	        	      
	        	      if($field_value_original != $field_value_new){
	        	          $update =1;
	        	       		// category
	        	          if($field_item == 'category_id'){
	        	          		$cat =  $this->get_record_by_id($field_value_new,$this -> table_category_name);
								$row['category_id_wrapper'] = $cat -> list_parents;
								$row['category_alias_wrapper'] = $cat -> alias_wrapper;
								$row['category_name'] = $cat -> name;
								$row['category_alias'] = $cat -> alias;
								$row['category_id'] = $field_value_new;
	        	          }else{
								$row[$field_item] = $field_value_new;
	        	          }
	        	      }    
	        	}
	        	if($update){
	        		$id = FSInput::get('id_'.$i, 0, 'int'); 
	        		$str_update = '';
	        		global $db;
	        		$j = 0;
	        		foreach($row as $key => $value){
	        			if($j > 0)
	        				$str_update .= ',';
	        			$str_update .= "`".$key."` = '".$value."'";
	        			$j++;
	        		}
            
		            $sql = ' UPDATE  '.$this ->  table_name . ' SET ';
		            $sql .=  $str_update;
		            $sql .=  ' WHERE id =    '.$id.' ';
		            $db->query($sql);
		            $rows = $db->affected_rows();
		            if(!$rows)
		                return false;
		            $record_change_success ++;
	        	}
	        }
	        return $record_change_success;  
	           
	        
	    }

	}
	
?>