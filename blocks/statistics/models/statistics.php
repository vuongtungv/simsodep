
<?php 
	class StatisticsModelsStatistics
	{
		function __construct()
		{
		}
		
		function get_online(){
			global $db ;
			$time_space = 15; // time to recalculate
			$time_unit = 'MINUTE'; 
			$time = date('Y-m-d H:i:s');
		
			// count
			$sql = " SELECT count( distinct(ip_address)) 
					 FROM fs_hits 
							WHERE 
							DATE_SUB('".$time."',INTERVAL $time_space $time_unit) < visited_time ";
			$db -> query($sql);
			return $db -> getResult();
		}
	}
	
?>