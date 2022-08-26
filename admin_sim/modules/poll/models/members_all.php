<?php 
	class PollModelsMembers_all extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'members_all';
			$this -> table_name_answers = FSTable_ad::_('fs_poll_answers');
			$this -> table_name = FSTable_ad::_('fs_poll_questions');
			
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
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1  AND total_poll <> 0 ".
						 $where.
						 $ordering. " ";
			return $query;
		}

		
		/*
		 * select in category of home
		 */
		function get_answers($category_id)
		{
			global $db;
			$query = " SELECT *
						  FROM ".$this -> table_name_answers."
						  WHERE category_id = '$category_id' ";
			global $db;
			$result = $db->getObjectList($query);
			return $result;
		}

	    function getCountAnswer($answers_id){
	        global $db;
	        $query = '  SELECT count(id)
	                    FROM fs_poll_members_all
	                    WHERE answers_1 = '.$answers_id
	                    ;
	        $result = $db->query($query);
	        $total = $db->getResult();
			return $total;
	    }
		
	}
	
?>