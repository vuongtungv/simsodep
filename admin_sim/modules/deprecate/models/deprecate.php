<?php 
	class DeprecateModelsDeprecate extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'deprecate';
            $this -> table_name = FSTable_ad::_('fs_deprecate');
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
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			$where = "  ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND (fullname LIKE '%".$keysearch."%' OR telephone LIKE '%".$keysearch."%' OR six_last LIKE '%".$keysearch."%' )";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	fs_deprecate AS a
						  	WHERE 1=1".
						 $where.
						 $ordering. " ";
						
			return $query;
		}
		
		function save($row = array(), $use_mysql_real_escape_string = 1){
			$name = FSInput::get('name');
			$deprecate_id = FSInput::get('id');
			$status = $row['status'] = $status = FSInput::get('status');
			$row['user_id'] = $_SESSION['ad_userid'];
			$detail_user = $this->get_detail_user($row['user_id']);
			$row['user_full_name'] = $detail_user->full_name;
            $username = $row['author'] = $detail_user->username;
            $user_id = $row['author_id'] = $row['user_id'];
            $time = $row['edited_time'] = date('Y-m-d H:i:s');

            $sql = "INSERT INTO fs_deprecate_history (time,status,user_id,username,name_status,deprecate_id) 
                  VALUE ('$time','$status','$user_id','$username','$status','$deprecate_id')";
            global $db;
            $id = $db->insert($sql);  


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
		function get_list_user(){
            global $db;
            $query = " SELECT a.*
						  FROM fs_users AS a WHERE type = 1 ORDER BY full_name ASC";
            $sql = $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }
        function get_detail_user($id){
            global $db;
            $query = " SELECT a.*
						  FROM fs_users AS a WHERE id = $id";
            $sql = $db->query($query);
            $list = $db->getObject();
            return $list;
        }
        function save_comments(){

            $id = FSInput::get('id',0,'int');
            $note = FSInput::get('note');
            $query = " UPDATE deprecate set comments = '".$note."' WHERE id = ".$id;
            global $db;
            $db->query($query);
            $rows = $db->affected_rows();

            return $rows;
        }
        function get_history(){
            $id = FSInput::get('id',0,'int');
            global $db;
            $query = "  SELECT *
					FROM fs_deprecate_history 
					WHERE
						deprecate_id = $id ORDER BY `time` DESC LIMIT 10
					";
            $db->query($query);
            $result = $db->getObjectList();
            return $result;
        }
        function get_note(){
            $id = FSInput::get('id',0,'int');
            global $db;
            $query = "  SELECT *
					FROM fs_deprecate_note 
					WHERE
						deprecate_id = $id ORDER BY `time` DESC LIMIT 10
					";
            $db->query($query);
            $result = $db->getObjectList();
            return $result;
        }
        function save_note(){

            $id = FSInput::get('id',0,'int');
            $note = FSInput::get('note');
            $time = date("Y-m-d H:i:s");

            $row_history['deprecate_id'] = $id;
            $row_history['time'] = $time;
            $row_history['note'] = $note;
            $row_history['user_id'] = $_SESSION['ad_userid'];
            $row_history['username'] = $_SESSION['ad_username'];
            // var_dump($row_history);die;
            $rows = $this -> _add($row_history, 'fs_deprecate_note');

            return $rows;
        }
		
	}
	
?>