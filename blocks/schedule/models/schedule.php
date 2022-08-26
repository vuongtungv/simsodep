
<?php 
	class ScheduleBModelsSchedule
	{
		function __construct()
		{
			$fstable = FSFactory::getClass('fstable');
            $this-> table_name = $fstable->_('fs_training');
		}
		
		function setQuery($limit = '',$style,$type){
            global $db;
            $where = '';
			$order = '';
            $limits = '';
            if($limit){
                $limits .= ' LIMIT '. $limit;
            }
            
            switch ($type){
    			case 'ramdom':	
    				$order .= ' RAND(),';
    				break;	   	
                case 'auto':
    				$order .= ' a.date_training ASC ';
    			    break;
			}
			$time = date('Y-m-d');
			$query = " SELECT a.id,a.date_training,a.title,a.alias,a.location,b.name
						FROM ".$this-> table_name." as a
						INNER JOIN fs_cities as b ON a.city_id = b.id
						AND a.published = 1 ". $where ." AND a.date_training >= "."'".$time."'"."
                        ORDER BY ". $order ."
						";
           	//print_r($query);            
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
	}
	
?>