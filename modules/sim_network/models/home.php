<?php 
	class Sim_networkModelsHome extends FSModels
	{
		function __construct(){
    		parent::__construct();
    		global $module_config;
    		FSFactory::include_class('parameters');
//    		$current_parameters = new Parameters($module_config->params);
//    		$limit   = $current_parameters->getParams('limit');
            $limit = 50;
    		$this->limit = $limit;
		}

		/*
		 * select cat list is children of catid
		 */
		function set_query_body()
		{
			$type  = FSInput::get("type");

			$where  = "";
			$query = " FROM fs_sim
						  WHERE 
						  	 1 = 1 AND type = $type
						  	". $where.
						    " ORDER BY created_time DESC
						 ";
                        
			return $query;
		}

        function get_list($query_body)
        {
            if(!$query_body)
                return;

            global $db;
            $query = " SELECT id,sim,price,price_old,price_public,created_time,network,cat_name,point,button,number";
            $query .= $query_body;
            //print_r($query);
            $sql = $db->query_limit($query,$this->limit,$this->page);
            $result = $db->getObjectList();
            return $result;
        }

		function getListHot(){
		    global $db;
		    $query= "SELECT id,title,image,alias FROM fs_news WHERE is_hot=1 LIMIT 2";
            $sql = $db->query($query);
            $result = $db->getObjectList();
            return $result;
        }

		/*
		 * return products list in category list.
		 * These categories is Children of category_current
		 */

        function getTotal($query_body)
        {
            if(!$query_body)
                return ;
            global $db;
            $query = "SELECT count(*)";
            $query .= $query_body;
            $sql = $db->query($query);
            $total = $db->getResult();
            return $total;
        }
		
		function getPagination($total)
		{
			FSFactory::include_class('Pagination');
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
		}

	}
	
?>