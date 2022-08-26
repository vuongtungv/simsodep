
<?php 
	class FilterBModelsFilter
	{
		function __construct()
		{
		}
		
		/*
		 * get records
		 */
		function get_records($where = '', $table_name = '', $select = '*', $ordering = '', $limit = '', $field_key = '') {
			$sql_where = " ";
			if ($where) {
				$sql_where .= ' WHERE ' . $where;
			}
			if (! $table_name)
				$table_name = $this->table_name;
			$query = " SELECT " . $select . "
						  FROM " . $table_name . $sql_where;

			if ($ordering)
				$query .= ' ORDER BY ' . $ordering;
			if ($limit)
				$query .= ' LIMIT ' . $limit;

	//		echo $query;
			global $db;
			$sql = $db->query ( $query );
			if (! $field_key)
				$result = $db->getObjectList ();
			else
				$result = $db->getObjectListByKey ( $field_key );
			return $result;
		}
	
	}
	
?>