<?php 
	class RecruitmentModelsrecruitment extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$limit = FSInput::get('limit',20,'int');
			$this -> limit = $limit;
			$this -> view = 'recruitment';
			
			$this -> table_category_name = FSTable_ad::_('fs_recruitment_categories');
			//$this -> table_types = 'fs_recruitment_types';
			$this -> arr_img_paths = array(array('small',200,150,'resize_image'),array('resized',200,150,'cut_image'));
			$this -> table_name = FSTable_ad::_('fs_recruitment');
			
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
			$this -> img_folder = 'images/recruitment/'.$cyear.'/'.$cmonth.'/'.$cday;
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
			
			// filter category
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
		
		function save(){
			$title = FSInput::get('title');
			$show_in_homepage = FSInput::get('show_in_homepage');
			if(!$title)
				return false;
			$id = FSInput::get('id',0,'int');	
			$category_id = FSInput::get('category_id','int',0);
			if(!$category_id){
				Errors::_('Bạn phải chọn danh mục');
				return;
			}
			
			$cat =  $this->get_record_by_id($category_id,$this -> table_category_name);
			$row['category_id_wrapper'] = $cat -> list_parents;
			$row['category_alias_wrapper'] = $cat -> alias_wrapper;
			$row['category_name'] = $cat -> name;
			$row['category_alias'] = $cat -> alias;
			$row['category_published'] = $cat -> published;
			$row['content'] = htmlspecialchars_decode(FSInput::get('content'));
            
            // related news
    		$record_relate = FSInput::get('recruitment_record_related',array(),'array');
    		$row['recruitment_related'] ='';
    		if(count($record_relate)){
    			$record_relate = array_unique($record_relate);
    			$row['recruitment_related'] = ','.implode(',', $record_relate).',';	
    		}
            
			if(isset($show_in_homepage ) && $show_in_homepage != 0)
			{
					$rs = $this -> _update_column($this -> table_name, 'show_in_homepage','0');
			}
			return parent::save($row);
		}
        
		
        function get_news_related($recruitment_related){
    		if(!$recruitment_related)
    				return;
    		$query   = " SELECT id, title,image 
    					FROM ".$this -> table_name."
    					WHERE id IN (0".$recruitment_related."0) 
    					 ORDER BY POSITION(','+id+',' IN '0".$recruitment_related."0')
    					";
    		global $db;
    		$sql = $db->query($query);
    		$result = $db->getObjectList();
    		return $result;
    	}
        /*
		 *==================== AJAX RELATED recruitment==============================
		 */
	
    	function ajax_get_recruitment_related(){
    		$content_id = FSInput::get('content_id',0,'int');
    		$category_id = FSInput::get('category_id',0,'int');
    		$keyword = FSInput::get('keyword');
    		$where = ' WHERE published = 1 ';
    		if($category_id){
    			$where .= ' AND (category_id_wrapper LIKE "%,'.$category_id.',%"	) ';
    		}
    		$where .= " AND ( title LIKE '%".$keyword."%' OR alias LIKE '%".$keyword."%' )";
    		
    		$query_body = ' FROM '.$this -> table_name.' '.$where;
    		$ordering = " ORDER BY created_time DESC , id DESC ";
    		$query = ' SELECT id,category_id,title,category_name,image'.$query_body.$ordering.' LIMIT 40 ';
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
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_category_name." AS a
						  	ORDER BY ordering ";
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
								$row['category_published'] = $cat -> published;
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