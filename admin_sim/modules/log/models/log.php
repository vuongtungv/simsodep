<?php 
	class LogModelsLog extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'log';
            $this -> table_name = FSTable_ad::_('fs_log');
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
					$where .= " AND title LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	fs_log AS a
						  	WHERE 1=1".
						 $where.
						 $ordering. " ";
						
			return $query;
		}
		
		function save($row = array(), $use_mysql_real_escape_string = 1){
			$price = FSInput::get('price');
			if(!$price)
				return false;
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