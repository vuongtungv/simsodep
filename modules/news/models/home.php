<?php 
	class NewsModelsHome extends FSModels
	{
		function __construct(){
    		parent::__construct();
    		global $module_config;
    		FSFactory::include_class('parameters');
    		$current_parameters = new Parameters($module_config->params);
    		$limit   = $current_parameters->getParams('limit'); 
            $limit = 10;
    		$this->limit = $limit;
		}

		/*
		 * select cat list is children of catid
		 */
		function set_query_body()
		{
			$date1  = FSInput::get("date_search");
			$where  = "";
			$fs_table = FSFactory::getClass('fstable');
			$query = " FROM ".$fs_table -> getTable('fs_news')."
						  WHERE 
						  	 published = 1
						  	". $where.
						    " ORDER BY show_in_homepage DESC , updated_time DESC, id DESC
						 ";
			return $query;
		}
		
		function get_list($query_body)
		{
			if(!$query_body)
				return;
				
			global $db;
			$query = " SELECT id,title,summary,image, created_time, alias, updated_time,category_name";
			$query .= $query_body;
//            print_r($query); die;
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			return $result;
		}

		function getListHot(){
		    global $db;
		    $query= "SELECT id,title,image,alias,summary,category_name,created_time FROM fs_news WHERE show_in_homepage=1 AND published = 1 ORDER BY created_time DESC LIMIT 2";
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