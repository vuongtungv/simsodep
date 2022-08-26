<?php

    require PATH_BASE.'libraries/elasticsearch/vendor/elasticsearch/elasticsearch/src/Elasticsearch/ClientBuilder.php';
    use Elasticsearch\ClientBuilder;
    require PATH_BASE.'libraries/elasticsearch/vendor/autoload.php';
    $hosts = [
        [
            'host' => 'localhost',          //yourdomain.com
            'port' => '9200',
            'scheme' => 'http',             //https
    //        'path' => '/elastic',
    //        'user' => 'username',         //nếu ES cần user/pass
    //        'pass' => 'password!#$?*abc'
        ],

    ];

	class SimControllersSearch extends Controllers
	{
		function __construct()
		{
			$this->view = ''; 
			parent::__construct();
			$array_status = array( 0 => 'Hiển thị',1 => 'Giữ',2=>'Đã bán',3=>'Ẩn'); 
			$this ->arr_status = $array_status;

			$array_admin_status = array( 0 => 'Chờ duyệt',1 => 'Đã duyệt',3=>'Trùng',4=>'Xóa'); 
			$this ->arr_admin_status = $array_admin_status;
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;

			$array_status = $this ->arr_status;
			$array_obj_status = array();
			foreach($array_status as $key => $name){
				$array_obj_status[] = (object)array('id'=>$key,'name'=>$name);
			}

			$array_admin_status = $this ->arr_admin_status;
			$array_obj_admin_status = array();
			foreach($array_admin_status as $key => $name){
				$array_obj_admin_status[] = (object)array('id'=>$key,'name'=>$name);
			}
            
         	$notes = $model->get_note();
         	// var_dump($notes);
         	$network = $model->get_records('published = 1','fs_network','name,id');
           	$partner = $model->get_records('published=1 and type=2 ORDER BY full_name ASC , ordering DESC , id DESC','fs_users','id,full_name');
           	$city = $model->get_records('published=1 order by ordering asc','fs_cities','id,name');
           	$type = $model->get_records(' 1=1 order by id asc','fs_sim_type','id,name,alias');
            $method = $model->get_records('published = 1','fs_typepay','id,title');
			$list_key = array();

            $results = $this->elasticsearch();

            $list_arr = $results['hits']['hits'];
            $total = $results['hits']['total']['value'];
            $pagination = $model->getPagination($total);

            // echo '<pre>',print_r($results),'</pre>';
            $list = '';
            if ($list_arr) {
                foreach ($list_arr as $item) {
                    $item = $item['_source'];
                    $list_obj[] = (object) array('id' => $item['sim_id'] , 'sim' => $item['sim'], 'number' => $item['number'], 'price' => $item['price'], 'created_time' => $item['created_time'], 'status' => $item['status'], 'admin_status' => $item['admin_status'], 'agency' => $item['agency'], 'agency_name' => $item['agency_name'], 'commission' => $item['commission'], 'commission_value' => $item['commission_value'], 'price_public' => $item['price_public']);
                }
                $list = (object) $list_obj;
            }


            // var_dump($list);die;
   //       	$list = $model->get_data('');
			// $pagination = $model->getPagination('');

			include 'modules/'.$this->module.'/views/'.$this->view.'/search.php';
		}

		function delete_history()
    	{
    		$model  = $this -> model;
    		$id = FSInput::get('id');
    		$rs = $model->_remove('id ='.$id,'fs_history_sim');
    		$link = FSRoute::_(URL_ROOT.URL_ROOT_ADMIN.'index.php?module=sim&view=search'); 
    		if ($rs) {
            	setRedirect($link,'Đã xóa ghi chú');
    		}
    		setRedirect($link,'Chưa xóa được');
    	}	

    	function save_note()
    	{
    		$model  = $this -> model;
    		$id = $model->save_note();
    		$link = FSRoute::_(URL_ROOT.URL_ROOT_ADMIN.'index.php?module=sim&view=search'); 
    		if ($id) {
            	setRedirect($link,'Đã lưu ghi chú');
    		}
    		setRedirect($link,'Chưa lưu được');
    	}

		function search(){
			$sim=  FSInput::get('sim');
			$agency=  FSInput::get('agency');
			$network=  FSInput::get('network');
			$type=  FSInput::get('type');
			$admin_status=  FSInput::get('admin_status');
			$status=  FSInput::get('status');

            if (@$sim) {
            	$_SESSION['sim'] = $sim;
            }elseif(!@$sim){
            	unset($_SESSION['sim']);
            }

            if (@$agency) {
            	$_SESSION['agency'] = $agency;
            }elseif(!@$agency){
            	unset($_SESSION['agency']);
            }

            if (@$network) {
            	$_SESSION['network'] = $network;
            }else{
            	unset($_SESSION['network']);
            }

            if (@$admin_status != '') {
            	$_SESSION['admin_status'] = $admin_status;
            }elseif(@$admin_status == ''){
            	unset($_SESSION['admin_status']);
            }

            if (@$status != '') {
            	$_SESSION['status'] = $status;
            }elseif(@$status == ''){
            	unset($_SESSION['status']);
            }

            if (@$type) {
            	$_SESSION['type'] = $type;
            }else{
            	unset($_SESSION['type']);
            }

		}

        function elasticsearch(){
            $model = $this -> model;
            $client = ClientBuilder::create()->setHosts($hosts)->build();

            $cat = @$_SESSION['type'];

            if ($cat) {
                $cat_item = $model->get_record('alias = "'.$cat.'"','fs_sim_type','id,name,parent_id,alias,level,parent_name');
                if (!$cat_item->level){
                    $list = $model->get_records('parent_id = "'.$cat_item->id.'"','fs_sim_type','id,name,parent_id,alias');
                    if ($list) {
                        foreach ($list as $item){
                            $must_cat = array('cat_name'=>','.$cat_item->name.','.$item->name.',');
                            $must_cat = array('match_phrase'=>$must_cat);
                            $must_cate['should'][] = $must_cat;
                        }
                        $query_cate['bool'] = $must_cate;
                        $must['must'][] = $query_cate;
                    }else{
                        $must_cat = array('cat_name'=>','.$cat_item->name.',');
                        $must_cat = array('match_phrase'=>$must_cat);
                        $must['must'][] = $must_cat;

                        if (strpos($cat_item->name, 'giua' ) == false) {
                            $must_item = array('cat_name'=>'*giữa*');
                            $must_item = array('wildcard'=>$must_item);
                            $must['must_not'][] = $must_item;
                        }
                    }
                }else{
                    $must_cat = array('cat_name'=>','.$cat_item->parent_name.','.$cat_item->name.',');
                    $must_cat = array('match_phrase'=>$must_cat);
                    $must['must'][] = $must_cat;
                }

            }

            $network = @$_SESSION['network'];
            if ($network) {
                $must_network = array('network_id'=>$network);
                $must_network = array('term'=>$must_network);
                $must['must'][] = $must_network; 
            }

            $agency = @$_SESSION['agency'];
            if ($agency) {
                $must_agency = array('agency'=>$agency);
                $must_agency = array('term'=>$must_agency);
                $must['must'][] = $must_agency;
            }

            $status = @$_SESSION['status'];
            if ($status) {
                $must_status = array('status'=>$status);
                $must_status = array('term'=>$must_status);
                $must['must'][] = $must_status;
            }

            $admin_status = @$_SESSION['admin_status'];
            if ($admin_status) {
                $must_admin_status = array('admin_status'=>$admin_status);
                $must_admin_status = array('term'=>$must_admin_status);
                $must['must'][] = $must_admin_status;
            }

            $keyword = @$_SESSION['sim'];
            global $db;
            $keyword = $db->escape_string($keyword);

            $keyword = str_replace(' ','',$keyword);
            $keyword = str_replace('.','',$keyword);
            $keyword = str_replace(',','',$keyword);
            
            if ($keyword) {

                $str = $this->search_advanced($keyword);

                // var_dump($str);

                foreach ($str as $item) {
                    $must_keyword= array('sim'=>$item);
                    $must_keyword = array('wildcard'=>$must_keyword);
                    $must['should'][] = $must_keyword;

                    $must_keyword= array('number'=>$item);
                    $must_keyword = array('wildcard'=>$must_keyword);
                    $must['should'][] = $must_keyword;
                }


                $must['minimum_should_match'] = 1;
                $must['boost'] = '1.0';
            }

            if (!$cat && !$network && !$agency && !$status && !$admin_status && !$keyword){
                // $body['query'] = array('match_all'=>array('boost'=>'1.2'));
                return ;
            }else{
                $query['bool'] = $must;
                $body['query'] = $query;
            }

            $body['size'] = 100;
            $page = FSInput::get('page','1','int');
            $body['from'] = ($page-1)*$body['size'];

            $order = FSInput::get('order');
            if ($order) {
                switch ($order) {
                    case 'up':
                        $ordering = 'asc';
                        break;
                    case 'down':
                        $ordering = 'desc';
                        break;
                }

                $sort = array('price_public'=>$ordering);
                $body['sort'][] = $sort;
            }

            $params = [
                'index' => 'fs',
                'type' => 'simsodep',
                'body' => $body
            ];

          // echo '<pre>',print_r($params),'</pre>';die;
            // echo '<pre>',print_r($params['body'],1),'</pre>';die;
            // print_r($params);die;

            $results = $client->search($params);
           // echo '<pre>',print_r($results,1),'</pre>';die;

            return $results;
        }

		function reset(){
			unset($_SESSION['sim']);
			unset($_SESSION['agency']);
			unset($_SESSION['network']);
			unset($_SESSION['admin_status']);
			unset($_SESSION['status']);
			unset($_SESSION['type']);

            $link = FSRoute::_(URL_ROOT.URL_ROOT_ADMIN.'index.php?module=sim&view=search'); 

            setRedirect($link);
		}


		function delete()
    	{
            $model  = $this -> model;
            $ids = FSInput::get('id',array(),'array');
            $client = ClientBuilder::create()->setHosts($hosts)->build();

            foreach ($ids as $item){
                $sim = $model->get_record('id = '.$item,'fs_sim','agency,number');
                $must_item = array('_id'=>$sim->agency.'-'.$sim->number);
                $must_arr = array('term'=>$must_item);
                $must['should'][] = $must_arr;
            }

            $query['bool'] = $must;
            $body['query'] = $query;
            $body['script'] = [
                'source' => 'ctx._source.admin_status  = params.value',
                'params' => [
                    'value' => 4
                ]
            ];
            $params = [
                'index' => 'fs',
                'type' => 'simsodep',
                'body' => $body
            ];

            $results = $client->updateByQuery($params);
//            echo '<pre>',print_r($results),'</pre>';die;

    		$this->is_check('admin_status',4,'sim đã được xóa');
    	}


        function search_advanced($keyword){
            $where ='';

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
                            $arr_number = $this->search_ngang($txt,$f,$l,1);
                        }
                        // trường hợp không có hoặc
                        elseif (strpos($txt, '-' ) == false) {
                            $arr_number = $this->search_khong_ngang($txt,'','',1);
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
                            $arr_number = $this->search_ngang($txt,$f,$l,2);
                        }
                        // trường hợp không có hoặc
                        elseif (strpos($txt, '-' ) == false) {
                            $arr_number = $this->search_khong_ngang($txt,'','',2);
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
                            $arr_number_first = $this->search_ngang($txt,$f,$l,1);
                        }
                        // trường hợp không có hoặc
                        elseif (strpos($txt, '-' ) == false) {
                            $arr_number_first = $this->search_khong_ngang($txt,'','',1);
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
                            $arr_number_last = $this->search_ngang($txt,$f,$l,2);
                        }
                        // trường hợp không có hoặc
                        elseif (strpos($txt, '-' ) == false) {
                            $arr_number_last = $this->search_khong_ngang($txt,'','',2);
                        }

                        foreach ($arr_number_first as $key) {
                            foreach ($arr_number_last as $value) {
                                $arr_number[] = str_replace("**",'*',$key.$value);
                            }
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
                            $arr_number = $this->search_ngang($txt,$f,$l,0);
                        }
                        // trường hợp không có hoặc
                        elseif (strpos($txt, '-' ) == false) {
                            $arr_number = $this->search_khong_ngang($txt,'','',0);
                        }
                }

            return $arr_number;

        }

        function search_khong_ngang($txt,$f='',$l='',$type=0){
            // $arr_number = array();
            if ($type == 0) {
                $t = '*';
                $s = '*';
            }elseif ($type == 1) {
                $t = '';
                $s = '*';
            }elseif ($type == 2) {
                $t = '*';
                $s = '';
            }

            if (strpos($txt,'x') !== false) {
                $arr_number = $this->search_x($txt,'','',$type);
            }else{
                $w = $f . $t . $txt . $s . $l;
                $arr_number[] = $w;
            }
            return $arr_number;
        }

        function search_ngang($txt,$f='',$l='',$type=0){
            $arr_txt = explode('-',$txt);
            $t = '';
            $s = '';
            if ($type == 0) {
                $t = '*';
                $s = '*';
            }elseif ($type == 1) {
                $t = '';
                $s = '*';
            }elseif ($type == 2) {
                $t = '*';
                $s = '';
            }


            $i = 1;
            foreach ($arr_txt as $item) {

                if (strpos($item,'x') !== false) {
                    $arr_number = $this->search_x($item,$f,$l,$type);
                }else{
                    $w = $t . $f . $item . $l . $s;
                    $arr_number[] = $w;
                }
                $i++;
            }
            return $arr_number;
        }

        function search_x($txt,$f='',$l='',$v = 0){
            if ($v == 0) {
                $t = '*';
                $s = '*';
            }elseif ($v == 1) {
                $t = '';
                $s = '*';
            }elseif ($v == 2) {
                $t = '*';
                $s = '';
            }
            $w = '';
            for ($i=0; $i < 10 ; $i++) { 
                $q = str_replace("x",$i,$txt);
                $w = $t . $f . $q . $l . $s;
                $arr_number[] = $w;
            }
            return $arr_number;
        }
        
	}
?>