<?php 
	class Regis_promotionsModelsRegis_promotions extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'regis_promotions';
            $this -> table_name = FSTable_ad::_('fs_regis_promotions');
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
					$where .= " AND price LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	fs_regis_promotions AS a
						  	WHERE 1=1".
						 $where.
						 $ordering. " ";
						
			return $query;
		}
		
		function save($row = array(), $use_mysql_real_escape_string = 1){
			$price = FSInput::get('price');
			$id_new = FSInput::get('network_id');
			$name_network = $this->getNameNetWork($id_new);
			$row['network'] = $name_network->name;
			if(!$price)
				return false;
			return parent::save($row);
		}

		function getNetWork()
		{
			global $db;
			$query = " SELECT id,name
						  FROM fs_network
						  	WHERE published = 1 ORDER BY ordering ASC";
			$sql = $db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
		function getNameNetWork($id)
		{
			global $db;
			$query = " SELECT id,name
						  FROM fs_network
						  	WHERE published = 1 AND id=$id ORDER BY ordering ASC";
			$sql = $db->query($query);
			$list = $db->getObject();
			return $list;
		}

	}

?>