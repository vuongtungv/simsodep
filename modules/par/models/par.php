<?php

class ParModelsPar extends FSModels
{
    var $limit;
    var $page;

    function __construct()
    {
        $page = FSInput::get('page');
        $this->page = $page;
        $limit = 50;
        $this->limit = $limit;
    }

    function set_query_body($where)
    {
        global $db;
        $ordering ='';

        $order = FSInput::get('order');
        if ($order && $order != 'random') {
            switch ($order) {
                case 'up':
                    $ordering = ' ORDER BY price_public ASC ';
                    break;
                case 'down':
                    $ordering = ' ORDER BY price_public DESC ';
                    break;
            }
        }

        // $limit = FSInput::get('limit');
        // if ($limit) {
        //     $limit = " Limit " . $limit . "";
        // }

        $sql = "	SELECT id,sim,network,number,price_public,point,cat_name
					    FROM fs_sim
						WHERE admin_status = 1 " . $where . $ordering ; 
			 // echo $sql.'<br />';
        return $sql;

    }

    function get_list($query_body)
    {
        if (!$query_body)
            return;
        $query = $query_body;
        global $db;
        $sql = $db->query_limit($query, $this->limit, $this->page);
        $result = $db->getObjectList();
        return $result;
    }

    function getTotal($query_body)
    {
        $query = $query_body;
        $query = str_ireplace('id,sim,network,number,price_public,point,cat_name','count(id)',$query);
        if(!$query)
            return ;
        global $db;
        $sql = $db->query($query);
        $total = $db->getResult();
        return $total;
    }

    function getPagination($total)
    {
        FSFactory::include_class('Pagination');
        $pagination = new Pagination ($this->limit, $total, $this->page);
        return $pagination;
    }

}