<?php 
	class SignedsimModelsSignedsim extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'signedsim';
            $this -> table_name = FSTable_ad::_('fs_signedsim');
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
					$where .= " AND (fullname LIKE '%".$keysearch."%' OR telephone LIKE '%".$keysearch."%' OR deposit_sim LIKE '%".$keysearch."%') ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	fs_signedsim AS a
						  	WHERE 1=1".
						 $where.
						 $ordering. " ";
						
			return $query;
		}
		
		function save($row = array(), $use_mysql_real_escape_string = 1){
            $status = $row['status'] = $status = FSInput::get('status');
            $signedsim_id = FSInput::get('id');
            $user_id = isset($_SESSION['ad_userid'])? $_SESSION['ad_userid']:'';
            if(!$user_id)
                return false;

            $user = $this->get_record_by_id($user_id,'fs_users','username');

            $username = $row['author'] = $user->username;
            $row['author_id'] = $user_id;
            $time = $row['edited_time'] = date('Y-m-d H:i:s');


            $sql = "INSERT INTO fs_signedsim_history (time,status,user_id,username,name_status,signedsim_id) 
                  VALUE ('$time','$status','$user_id','$username','$status','$signedsim_id')";
//            echo $sql; die;
            global $db;
            $id = $db->insert($sql);

			return parent::save($row);
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




        function save_comments(){

            $id = FSInput::get('id',0,'int');
            $note = FSInput::get('note');
            $query = " UPDATE signedsim set comments = '".$note."' WHERE id = ".$id;
            global $db;
            $db->query($query);
            $rows = $db->affected_rows();

            return $rows;
        }
        function get_history(){
            $id = FSInput::get('id',0,'int');
            global $db;
            $query = "  SELECT *
					FROM fs_signedsim_history 
					WHERE
						signedsim_id = $id ORDER BY `time` DESC LIMIT 10
					";
            $db->query($query);
            $result = $db->getObjectList();
            return $result;
        }
        function get_note(){
            $id = FSInput::get('id',0,'int');
            global $db;
            $query = "  SELECT *
					FROM fs_signedsim_note 
					WHERE
						signedsim_id = $id ORDER BY `time` DESC LIMIT 10
					";
            $db->query($query);
            $result = $db->getObjectList();
            return $result;
        }
        function save_note(){

            $id = FSInput::get('id',0,'int');
            $note = FSInput::get('note');
            $time = date("Y-m-d H:i:s");
            $row_history['signedsim_id'] = $id;
            $row_history['time'] = $time;
            $row_history['note'] = $note;
            $row_history['user_id'] = $_SESSION['ad_userid'];
            $row_history['username'] = $_SESSION['ad_username'];

            $rows = $this -> _add($row_history, 'fs_signedsim_note');

            return $rows;
        }
	}
	
?>