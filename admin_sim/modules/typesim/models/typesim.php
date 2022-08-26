<?php 
	class TypesimModelsTypesim extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'typesim';
            $this -> table_name = FSTable_ad::_('fs_sim_type');
			parent::__construct();
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
					
			}
			if(!$ordering)
				$ordering .= " ORDER BY ordering ASC , id DESC ";
			
			$where = "  ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	fs_sim_type AS a
						  	WHERE 1=1".
						 $where.
						 $ordering. " ";
						
			return $query;
		}
        function get_record_by_id($id,$table_name = '')
        {
            if(!$id)
                return;
            if(!$table_name)
                $table_name = $this -> table_name;
            $query = " SELECT *
						  FROM ".$table_name."
						  WHERE id = $id ";
            global $db;
            $result = $db->getObject($query);
            return $result;
        }
        function save($row = array(), $use_mysql_real_escape_string = 1){
            $title = FSInput::get('title');
            $show_in_homepage = FSInput::get('show_in_homepage');
            if(!$title)
                return false;
            $id = FSInput::get('id',0,'int');
//            $category_id = FSInput::get('category_id','int',0);
//            if(!$category_id){
//                Errors::_('Bạn phải chọn danh mục');
//                return;
//            }

//            $user_id = isset($_SESSION['ad_userid'])? $_SESSION['ad_userid']:'';
//            if(!$user_id)
//                return false;

//            $user = $this->get_record_by_id($user_id,'fs_users','username');
//            if($id){
//                $row['author_last'] = $user->username;
//            }else{
//                $row['author'] = $user->username;
//            }

//            $cat =  $this->get_record_by_id($category_id,'fs_contents_categories');
//            $row['category_id_wrapper'] = $cat -> list_parents;
//            $row['category_alias_wrapper'] = $cat -> alias_wrapper;
//            $row['category_name'] = $cat -> name;
//            $row['category_alias'] = $cat -> alias;
//            $row['category_published'] = $cat -> published;

            $row['content'] = htmlspecialchars_decode(FSInput::get('content'));
            //if(isset($show_in_homepage ) && $show_in_homepage != 0)
//			{
//					$rs = $this -> _update_column('fs_contents', 'show_in_homepage','0');
//			}
            return parent::save($row);
        }

		function get_parts()
		{
			global $db;
			$query = " SELECT a.*
						  FROM fs_contact_parts AS a
						  	WHERE published = 1 ORDER BY ordering ";         
			$sql = $db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
		
	}
	
?>