<?php
/**
 * @author vangiangfly
 * @copyright 2013
 */
class HomeModelsHome extends FSModels{
    function __construct(){
        parent::__construct();
        $this->table_name = 'fs_lands';
        $this->table_category = 'fs_lands_categories';
        $this->limit = 10;
    }
    
//    /**
//     * Lấy danh sách tin
//     * @return Object list
//     */
//    function getList(){
//        global $db;
//        $query = '  SELECT id, title, image, alias, created_time, category_id, category_alias, category_name
//                    FROM '.$this->table_name.'
//                    WHERE published = 1
//                    ORDER BY id DESC';
//        $result = $db->query_limit($query, $this->limit, $this->page);
//        return $db->getObjectList();
//    }
    
//    /**
//     * Lấy tổng số tin
//     * @return Int
//     */
//    function getTotal(){
//        global $db;
//        $query = '  SELECT count(id)
//                    FROM '.$this->table_name.'
//                    WHERE published = 1 '.$sqlWhere;
//        $result = $db->query($query);
//        $total = $db->getResult();
//		return $total;
//    }

    /**
     * Lấy 1 video hiển thị ra trang chủ
     *
    */
    function getVideoHome(){
        global $db;
        $query = "SELECT * FROM fs_videos WHERE published = 1 AND show_in_homepage = 1";
        $result = $db->query_limit($query, 1, $this->page);
        return $db->getObject();
    }

    /**
     * Lấy 1 new hiển thị ra trang chủ
     *
    */
    function getNewsHome(){
        global $db;
        $query = "SELECT * FROM fs_news WHERE published = 1 AND show_in_homepage = 1";
        $result = $db->query_limit($query, 2, $this->page);
        return $db->getObjectList();
    }
    function regis_default(){
        global $db;
        $query = "SELECT * FROM fs_regis_promotions ORDER BY ordering ASC";
        $result = $db->query($query);
        return $db->getObjectList();
    }

    function show_netname(){
        global $db;
        $query = "SELECT id,network,network_id FROM fs_regis_promotions GROUP BY network_id ORDER BY ordering ASC";
        $result = $db->query($query);
        return $db->getObjectList();
    }

    // ajax load
    function ajax_get_promotions($cid) {
        if (! $cid)
            return;
        global $db;
        $query = "SELECT * FROM fs_regis_promotions WHERE network_id  = $cid ORDER BY ordering ASC";
        $sql = $db->query ( $query );
        $rs = $db->getObject();
        return $rs;
    }

} 