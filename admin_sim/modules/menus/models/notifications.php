
<?php 
	class MenusModelsNotifications
	{
		function __construct()
		{
		}
		
		function setQuery()
		{
			// fix user_group_id = 51 là quyền đại lý
			$time = date("Y-m-d");
			$timefrom = strtotime($time.' 00:00');
			$timeto = strtotime($time.' 23:59');
			$where =' date_appointment > '.$timefrom.' and  date_appointment < '.$timeto.' and status = 12' ;
			$query = " SELECT id,code,date_appointment
						  FROM fs_order
						  WHERE 
						  ".$where."
						  ORDER BY created_time DESC
						 ";
			return $query;
		}
		
		
		function getMenusNotifications()
		{
			global $db;
			$query = $this->setQuery();
			$result = $db->getObjectList($query);
			
			return $result;
		}

		function get_count($where = '', $table_name = '', $select = '*') {
			if (! $where)
				return;
			if (! $table_name)
				$table_name = $this->table_name;
			 $query = ' SELECT count(' . $select . ')
						  FROM ' . $table_name . '
						  WHERE ' . $where;
			
			global $db;
			$sql = $db->query ( $query );
			$result = $db->getResult ();
			return $result;
		}
			
		
	}
	
?>