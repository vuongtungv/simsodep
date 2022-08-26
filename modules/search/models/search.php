<?php

class SearchModelsSearch extends FSModels
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


    /* return query run
     * get products list in category list.
     * These categories is Children of category_current
     */
    function set_query_body($cat_id = 0)
    {
        global $db;
        $where ='';
        $ordering ='';

        $network = FSInput::get('network');
        if ($network && $network != 'all') {
            $where .= " AND network_id = " . $network . "  ";
        }
        $cat = FSInput::get('cat');
        if ($cat && $cat != 'all') {
            $where .= " AND cat_alias like '%" . $cat . "%'  ";
        }
        $button = FSInput::get('button');
        if ($button && $button != 'all') {
            $where .= " AND button = " . $button . "";
        }
        $point = FSInput::get('point');
        if ($point && $point != 'all') {
            $where .= " AND point = " . $point . "";
        }
        $price = FSInput::get('price');
        if ($price && $price != 'all') {
            $arr_price = explode('-', $price);
            $where .= " AND price_public >= " . $arr_price[0] . " AND price_public <= " . $arr_price[1] . " ";
        }
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
        $number = FSInput::get('number');
        if ($number && $number != 'all') {
            $arr_number = explode('-', $number);
            foreach ($arr_number as $item) {
                $where .= " AND number not like '%" . $item . "%'  ";
            }
        }

        // $limit = FSInput::get('limit');
        // if ($limit) {
        //     $limit = " Limit " . $limit . "";
        // }


        // phân tích từ khóa chính
        $keyword = FSInput::get('keyword');
        $keyword = $db->escape_string($keyword);
        $keyword = preg_replace('/\.{1,}/', '', $keyword);
        $keyword = preg_replace('/\ {1,}/', '', $keyword);

        if ($keyword && $keyword != 'all') {
            // trường hợp có *
            if (strpos($keyword, '*' ) !== false) {
                $arr_key = explode('*', $keyword);
                // trường hợp tìm theo đầu
                if ($arr_key[0] && !$arr_key[1]) {
                    $txt = $arr_key[0];
                    // trường hợp có ký tự hoặc
                    if (strpos($txt, '-' ) !== false) {
                        $f = ''; 
                        $l = '';
                        $arr_first = explode('(', $txt);
                        if ($arr_first[0]) {
                            $f = $arr_first[0];
                        }
                        $arr_key1 = explode(')', $arr_first[1]);
                        if ($arr_key1[1]) {
                            $l = $arr_key1[1];
                        }

                        $txt = $arr_key1[0];
                        $where .= $this->search_ngang($txt,$f,$l,1);
                    }
                    // trường hợp không có hoặc
                    elseif (strpos($txt, '-' ) == false) {
                        $where .= $this->search_khong_ngang($txt,'','',1);
                    }
                }

                // trường hợp tìm theo đuôi
                if (!$arr_key[0] && $arr_key[1]) {
                    $txt = $arr_key[1];
                    // trường hợp có ký tự hoặc
                    if (strpos($txt, '-' ) !== false) {
                        $f = ''; 
                        $l = '';
                        $arr_first = explode('(', $txt);
                        if ($arr_first[0]) {
                            $f = $arr_first[0];
                        }
                        $arr_key1 = explode(')', $arr_first[1]);
                        if ($arr_key1[1]) {
                            $l = $arr_key1[1];
                        }

                        $txt = $arr_key1[0];
                        $where .= $this->search_ngang($txt,$f,$l,2);
                    }
                    // trường hợp không có hoặc
                    elseif (strpos($txt, '-' ) == false) {
                        $where .= $this->search_khong_ngang($txt,'','',2);
                    }
                }

                // trường hợp tìm theo cả đầu và đuôi
                if ($arr_key[0] && $arr_key[1]) {

                    $txt = $arr_key[0];
                    // trường hợp có ký tự hoặc
                    if (strpos($txt, '-' ) !== false) {
                        $f = ''; 
                        $l = '';
                        $arr_first = explode('(', $txt);
                        if ($arr_first[0]) {
                            $f = $arr_first[0];
                        }
                        $arr_key1 = explode(')', $arr_first[1]);
                        if ($arr_key1[1]) {
                            $l = $arr_key1[1];
                        }

                        $txt = $arr_key1[0];
                        $where .= $this->search_ngang($txt,$f,$l,1);
                    }
                    // trường hợp không có hoặc
                    elseif (strpos($txt, '-' ) == false) {
                        $where .= $this->search_khong_ngang($txt,'','',1);
                    }

                    $txt = $arr_key[1];
                    // trường hợp có ký tự hoặc
                    if (strpos($txt, '-' ) !== false) {
                        $f = ''; 
                        $l = '';
                        $arr_first = explode('(', $txt);
                        if ($arr_first[0]) {
                            $f = $arr_first[0];
                        }
                        $arr_key1 = explode(')', $arr_first[1]);
                        if ($arr_key1[1]) {
                            $l = $arr_key1[1];
                        }

                        $txt = $arr_key1[0];
                        $where .= $this->search_ngang($txt,$f,$l,2);
                    }
                    // trường hợp không có hoặc
                    elseif (strpos($txt, '-' ) == false) {
                        $where .= $this->search_khong_ngang($txt,'','',2);
                    }

                }
            }
            // trường hợp không có *
            elseif (strpos($keyword, '*' ) == false) {
                $txt = $keyword;
                    // trường hợp có ký tự hoặc
                    if (strpos($txt, '-' ) !== false) {
                        $f = ''; 
                        $l = '';
                        $arr_first = explode('(', $txt);
                        if ($arr_first[0]) {
                            $f = $arr_first[0];
                        }
                        $arr_key1 = explode(')', $arr_first[1]);
                        if ($arr_key1[1]) {
                            $l = $arr_key1[1];
                        }

                        $txt = $arr_key1[0];
                        $where .= $this->search_ngang($txt,$f,$l,0);
                    }
                    // trường hợp không có hoặc
                    elseif (strpos($txt, '-' ) == false) {
                        $where .= $this->search_khong_ngang($txt,'','',0);
                    }
            }
        }

        // Tìm kiếm
        $params = [
            'index' => 'sim',
            'type' => 'fs_sim',
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['match_phrase' => [
                                'cat_alias' => 'sim-de-nho'                      
                            ]],
                            ['wildcard' => [
                                'number' => '090*092'                      
                            ]],
                            ['term' => [
                                'network_id' => '5'                     
                            ]],
                            ['term' => [
                                'point' => '47'                     
                            ]],
                            ['term' => [
                                'button' => '7'                     
                            ]],
                            ['range' => [
                                'price_public' => [
                                    'gte' => 520000,
                                    'lte' => 680479000
                                ]                       
                            ]]
                        ],
                        'must_not' => [
                            ['wildcard' => [
                                'number' => '*7*'                       
                            ]],
                            ['wildcard' => [
                                'number' => '*6*'                       
                            ]],
                        ],

                    ]
                ],
                'sort' => [
                    ['price_public'=>'desc']
                ]
            ]
        ];
            
        $fs_table = FSFactory::getClass('fstable');
        $sql = "	SELECT id,sim,network,number,price_public,point,cat_name
					    FROM " . $fs_table->getTable('fs_sim') . "
						WHERE admin_status = 1 " . $where . $ordering ; 
			 echo $sql;
        return $sql;

    }


    function elasticsearch(){

    }

    function search_khong_ngang($txt,$f='',$l='',$type=0){

        if ($type == 0) {
            $t = '%';
            $s = '%';
        }elseif ($type == 1) {
            $t = '';
            $s = '%';
        }elseif ($type == 2) {
            $t = '%';
            $s = '';
        }

        if (strpos($txt,'x') !== false) {
            $w = ' AND (';
            $w .= $this->search_x($txt,'','',$type);
            $w .= ')';
        }else{
            $w = " AND (number like '".$f . $t . $txt . $s . $l."')  "; 
        }
        return $w;
    }

    function search_ngang($txt,$f='',$l='',$type=0){
        $arr_txt = explode('-',$txt);
        $t = '';
        $s = '';
        if ($type == 0) {
            $t = '%';
            $s = '%';
        }elseif ($type == 1) {
            $t = '';
            $s = '%';
        }elseif ($type == 2) {
            $t = '%';
            $s = '';
        }

        $w = ' AND (';
        $i = 1;
        foreach ($arr_txt as $item) {
            // var_dump($item);

            if (strpos($item,'x') !== false) {
                $w .= $this->search_x($item,$f,$l,$type);
            }else{
                $w .= " number like '".$f . $t . $item . $s . $l."'  ";
            }

            if ($i<count($arr_txt)) {
                $w .= " or ";
            }
            $i++;
        }
        $w .= ')';
        return $w;
    }

    function search_x($txt,$f='',$l='',$v = 0){
        if ($v == 0) {
            $t = '%';
            $s = '%';
        }elseif ($v == 1) {
            $t = '';
            $s = '%';
        }elseif ($v == 2) {
            $t = '%';
            $s = '';
        }
        $w = '';
        for ($i=0; $i < 10 ; $i++) { 
            $q = str_replace("x",$i,$txt);
            $w .= " number like '". $t . $f . $q . $l . $s ."'  ";
            if ($i<9) {
                $w .= " or ";
            }
        }
        return $w;
    }

    /* return query run
         * get products list in category list.
         * These categories is Children of category_current
         */

    function get_list($query_body)
    {
        if (!$query_body)
            return;
        $query = $query_body;
        global $db;
        $sql = $db->query_limit($query, $this->limit, $this->page);
        $result = $db->getObjectList();
        return $result;

        // $query = $query_body;
        // $db->query($query);
        // $result = $db->getObjectList();
        // return $result;
    }

//     function getTotal($query_body)
//     {
//         global $db;
// //			$query = "SELECT count(*) ";
//         $query = $query_body;
//         $db->query($query);
//         $result = $db->getObjectList();
// //			$total = $db->getResult();
//         return count($result);
//     }

    function getTotal($query_body)
    {
        $query = $query_body;
        $query = str_ireplace('sim,network,number,price_public,point,cat_name','count(id)',$query);
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

    function get_types()
    {
        return $list = $this->get_records('published = 1', 'fs_products_types', 'id,name,image,alias', 'ordering ASC');
    }

}