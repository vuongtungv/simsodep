<?php 
	class EventModelsEvent extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
		    date_default_timezone_set('Asia/Ho_Chi_Minh');  
			$this -> limit = 30;
			$this -> view = 'event';
			
			//$this -> table_types = 'fs_event_types';
			$this -> arr_img_paths = array(
                                            //array('resized',420,252,'resize_image'),
                                            array('small',114,72,'cut_image'),
                                            array('large',374,234,'cut_image')
                                        );
			$this -> table_name_category = FSTable_ad::_('fs_event_categories');
            $this -> table_name = FSTable_ad::_('fs_event');
            // create link
            //$this -> table_link = 'fs_menus_createlink';
            //$limit_created_link = 30;
			//$this->limit_created_link = $limit_created_link;
            
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			//$cday = date('d');
			$this -> img_folder = 'images/event/'.$cyear.'/'.$cmonth;
			$this -> check_alias = 0;
			$this -> field_img = 'image';
			
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
			
			// estore
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.category_id_wrapper like  "%,'.$filter.',%" ';
				}
			}	
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.title LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
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
			
			$cat =  $this->get_record_by_id($category_id,$this -> table_name_category);
			$row['category_id_wrapper'] = $cat -> list_parents;
			$row['category_alias_wrapper'] = $cat -> alias_wrapper;
			$row['category_name'] = $cat -> name;
			$row['category_alias'] = $cat -> alias;
            
            
            //$image_name_icon = $_FILES["icon"]["name"];
//    		if($image_name_icon){
//    			$image_icon = $this->upload_image('icon','_'.time(),2000000,$this -> arr_img_paths_icon);
//    			if($image_icon){
//    				$row['icon'] = $image_icon;
//    			}
//    		}
            
            // related event
    		$record_relate = FSInput::get('event_record_related',array(),'array');
    		$row['event_related'] ='';
    		if(count($record_relate)){
    			$record_relate = array_unique($record_relate);
    			$row['event_related'] = ','.implode(',', $record_relate).',';	
    		}
            // related products
            $products_related  = FSInput::get ( 'products_record_related', array (), 'array' );
            $str_products_related = implode ( ',', $products_related );
    		if ($str_products_related) {
    			$str_products_related = ',' . $str_products_related . ',';
    		}
    		$row ['products_related'] = $str_products_related;
			
			$row['content'] = htmlspecialchars_decode(FSInput::get('content'));
			$time = date('Y-m-d H:i:s');
            
            $user_id = isset($_SESSION['ad_userid'])? $_SESSION['ad_userid']:'';
            if(!$user_id)
                return false;
                
            $user = $this->get_record_by_id($user_id,'fs_users','username');
            if($id){
                $row['end_time'] = $time;
                $row['author_last'] = $user->username;
                $row['author_last_id'] = $user_id;
            }else{
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
        

		/*
		 * select in category of home
		 */
		function get_categories_tree()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name_category." AS a
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
	        	          		$cat =  $this->get_record_by_id($field_value_new,$this -> table_name_category);
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