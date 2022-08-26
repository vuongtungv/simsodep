<?php 
	class PollModelsMembers extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'members';
			$this -> table_category_name = FSTable_ad::_('fs_poll_answers');
			$this -> table_name = FSTable_ad::_('fs_poll_members');
			$this -> table_promotion = FSTable_ad::_('fs_promotion');

			// config for save
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
			
			// estore
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.promotion_id = "'.$filter.'" ';
				}
			}	
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
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

		
		/*
		 * select in category of home
		 */
		function get_answers($answers_1)
		{
			global $db;
			$query = " SELECT *
						  FROM ".$this -> table_category_name."
						  WHERE id = '$answers_1' ";
			global $db;
			$result = $db->getObject($query);
			return $result;
		}

		function get_promotion()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_promotion." AS a
						  	WHERE published = 1 AND is_types = 2
						  	ORDER BY ordering ";         
			$sql = $db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
		
		
	}
	
?>