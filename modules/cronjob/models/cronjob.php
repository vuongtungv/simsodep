
<?php 
	class CronjobModelsCronjob extends FSModels
	{
		function __construct()
		{
		}
//        function get_duplicate() {
//            $query = "SELECT id,number,price
//                    FROM fs_sim_dublicate
//                    WHERE number IN (
//                    SELECT number
//                    FROM fs_sim_dublicate
//                    GROUP BY number
//                    HAVING COUNT(number) > 1
//            ) ORDER BY number ASC,price ASC";
////		echo $query;
//            global $db;
//            $sql = $db->query ( $query );
//            $result = $db->getObjectList ();
//            return $result;
//        }

        // lấy tất cả dữ liệu trùng lặp trong bảng

        function get_duplicate() {
            // $query = "SELECT id, agency, number, price FROM fs_sim_dublicate AS A INNER JOIN (SELECT C.id AS m_id, C.number AS m_number, MIN(price) AS m_price , MIN(id) AS min_id FROM fs_sim_dublicate AS C GROUP BY number HAVING COUNT(id) > 1) AS B ON A.number = B.m_number WHERE A.price > B.m_price OR A.id > B.min_id";
            $query = "SELECT id, agency, number, price, price_public FROM fs_sim_dublicate AS A INNER JOIN (SELECT C.id AS m_id, C.number AS m_number FROM fs_sim_dublicate AS C GROUP BY number HAVING COUNT(id) > 1) AS B ON A.number = B.m_number ORDER BY number Limit 0,100000";
                
            global $db;
            $sql = $db->query ( $query );
            $result = $db->getObjectList ();
            // var_dump(count($result));die;
            return $result;

        }

        function get_duplicate_agency($table) {
            // $query = "SELECT id, agency, number, price FROM ".$table." AS A 
            //     INNER JOIN 
            //     (SELECT C.id AS m_id, C.number AS m_number FROM ".$table." AS C GROUP BY number HAVING COUNT(id) > 1) AS B ON A.number = B.m_number
            //     WHERE A.id > B.m_id";

            $query = "SELECT id, agency, number, price FROM ".$table." AS A INNER JOIN (SELECT C.id AS m_id, C.number AS m_number FROM ".$table." AS C GROUP BY number HAVING COUNT(id) > 1) AS B ON A.number = B.m_number";

     // echo $query;die;
            global $db;
            $sql = $db->query ( $query );
            $result = $db->getObjectList ();
            return $result;
        }
		
	}
	
?>