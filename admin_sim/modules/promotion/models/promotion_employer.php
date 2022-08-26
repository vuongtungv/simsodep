<?php 
	class PromotionModelsPromotion_employer extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'promotion_employer';
			$this -> table_name = FSTable_ad::_('fs_promotion_members_employer');
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

		function get_promotion()
		{
			global $db;
			$query = " SELECT *
						  FROM 
						  	".$this -> table_promotion." 
						  	WHERE published = 1 AND is_types = 1
						  	ORDER BY ordering ";         
			$sql = $db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
		
	}
	
?>