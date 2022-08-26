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

	// controller
	class SearchControllersSearch extends FSControllers
	{
		var $module;
		var $view;
		function __construct()
		{
			parent::__construct ();
			// khai báo mảng sắp sếp
			$this->sort_arr = array(
										'random' => 'Ngẫu nhiên', 
										'up' => 'Giá thấp đến cao', 
										'down' => 'Giá cao đến thấp', 
										'prioritize' => 'Sim số đẹp giá gốc', 
									);
		}
		function display()
		{
			// call models
			$model = $this->model;
			// $query_body = $model -> set_query_body();
			// $list = $model -> get_list($query_body);

			$order = FSInput::get('order');
			$param = array();

			$network = FSInput::get('network');

	        if ($network && $network != 'all') {
	        	$param['network']= $network;
	        }

	        $button = FSInput::get('button');
	        if ($button) {
	        	$param['button']= $button;
	        }

	        $point = FSInput::get('point');
	        if ($point) {
	        	$param['point']= $point;
	        }

	        $from_price = FSInput::get('from_price');
	        if ($from_price) {
	        	$param['from_price']= $from_price;
	        }
	        $to_price = FSInput::get('to_price');
	        if ($to_price) {
	        	$param['to_price']= $to_price;
	        }

	        $number = FSInput::get('number');
	        if ($number) {
	        	$param['number']= $number;
	        }

	        $cat = FSInput::get('cat');
	        if ($cat && $cat != 'all') {
	        	$param['cat']= $cat;
	        	$name_cat = $model->get_record('alias = "'.$cat.'"','fs_sim_type','name');
	        }

	        $keyword = FSInput::get('keyword');
	        if ($number) {
	        	$param['keyword']= $keyword;
	        }
			
			if ($order) {
				$param['order']= $order;
			}

			$order_name = 'Ngẫu nhiên';
			foreach ($this->sort_arr as $key => $value) {
				if ($key == @$order) {
					$order_name = $value;
				}
			}

			$results = $this->elasticsearch();

			$list = $results['hits']['hits'];
			$total = $results['hits']['total']['value'];
			$pagination = $model->getPagination($total);

			if ($total == 0 && strlen($keyword) == 10) {
				$link = FSRoute::_(URL_ROOT.$keyword.'.html');
            	setRedirect($link);
			}

			$type = $model->get_records('','fs_sim_type','id,name,alias',' id ASC,ordering ASC ');
			$type_es = $model->get_records('','fs_sim_type','id,name,alias','','','alias');
			$net_es = $model->get_records('','fs_network','id,name,alias','ordering ASC','','id');

			// var_dump($type_es);die;
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Kết quả tìm kiếm sim', 1 => '');
			global $tmpl,$module_config;
			$tmpl -> assign('breadcrumbs', $breadcrumbs);

			$title_search = 'Kết quả tìm kiếm sim';
			$timkiem = '';
			if ($keyword && $keyword != 'all') {
				$title_search = 'Kết quả tìm kiếm sim '.$keyword;
				$timkiem = $keyword;
	        }

			$seo = $model->get_record('module_seo = "timkiem"','fs_seo','title,keywords,description,content');

	        if ($seo) {

                $title = str_replace('#timkiem#',$timkiem, $seo->title);
                $keywords = str_replace('#timkiem#',$timkiem, $seo->keywords);
                $description = str_replace('#timkiem#',$timkiem, $seo->description);
                $content = str_replace('#timkiem#',$timkiem, $seo->content);

	            $tmpl -> assign('title', $title);
	            $tmpl -> assign('keywords', $keywords);
	            $tmpl ->assign ( 'description', $description);
	        }

			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		function mdisplay()
		{
			// call models
			$model = $this->model;
			// $query_body = $model -> set_query_body();
			// $list = $model -> get_list($query_body);

			$order = FSInput::get('order');
			$param = array();

			$network = FSInput::get('network');
	        if ($network && $network != 'all') {
	        	$param['network']= $network;
	        }

	        $button = FSInput::get('button');
	        if ($button) {
	        	$param['button']= $button;
	        }

	        $point = FSInput::get('point');
	        if ($point) {
	        	$param['point']= $point;
	        }

	        $from_price = FSInput::get('from_price');
	        if ($from_price) {
	        	$param['from_price']= $from_price;
	        }
	        $to_price = FSInput::get('to_price');
	        if ($to_price) {
	        	$param['to_price']= $to_price;
	        }

	        $number = FSInput::get('number');
	        if ($number) {
	        	$param['number']= $number;
	        }

	        $cat = FSInput::get('cat');
	        if ($cat && $cat != 'all') {
	        	$param['cat']= $cat;
	        	$name_cat = $model->get_record('alias = "'.$cat.'"','fs_sim_type','name');
	        }

	        $keyword = FSInput::get('keyword');
	        if ($number) {
	        	$param['keyword']= $keyword;
	        }
			
			if ($order) {
				$param['order']= $order;
			}

			$order_name = 'Ngẫu nhiên';
			foreach ($this->sort_arr as $key => $value) {
				if ($key == @$order) {
					$order_name = $value;
				}
			}

			$results = $this->elasticsearch();

			$list = $results['hits']['hits'];
			$total = $results['hits']['total']['value'];
			$pagination = $model->getPagination($total);

			if ($total == 0 && strlen($keyword) == 10) {
				$link = FSRoute::_(URL_ROOT.$keyword.'.html');
            	setRedirect($link);
			}

			$type = $model->get_records('','fs_sim_type','id,name,alias',' id ASC,ordering ASC ');
			$type_es = $model->get_records('','fs_sim_type','id,name,alias','','','alias');
			$net_es = $model->get_records('','fs_network','id,name,alias','','','id');

			// var_dump($type_es);die;
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Kết quả tìm kiếm sim', 1 => '');
			global $tmpl,$module_config;
			$tmpl -> assign('breadcrumbs', $breadcrumbs);

			$title_search = 'Kết quả tìm kiếm sim';
			$timkiem = '';
			if ($keyword && $keyword != 'all') {
				$title_search = 'Kết quả tìm kiếm sim '.$keyword;
				$timkiem = $keyword;
	        }

			$seo = $model->get_record('module_seo = "timkiem"','fs_seo','title,keywords,description,content');

	        if ($seo) {

                $title = str_replace('#timkiem#',$timkiem, $seo->title);
                $keywords = str_replace('#timkiem#',$timkiem, $seo->keywords);
                $description = str_replace('#timkiem#',$timkiem, $seo->description);
                $content = str_replace('#timkiem#',$timkiem, $seo->content);

	            $tmpl -> assign('title', $title);
	            $tmpl -> assign('keywords', $keywords);
	            $tmpl ->assign ( 'description', $description);
	        }
	        
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/mdefault.php';
		}

		function all()
		{
			// call models
			$model = $this->model;
			// $query_body = $model -> set_query_body();
			// $list = $model -> get_list($query_body);

			$url = "danh-sach-sim.html";

			$cat = FSInput::get('cat');
			$order = FSInput::get('order');
			$network = FSInput::get('mang');
			$price = FSInput::get('price');
			$head = FSInput::get('head');
			$param = array();

			$order_name = 'Ngẫu nhiên';
			foreach ($this->sort_arr as $key => $value) {
				if ($key == @$order) {
					$order_name = $value;
				}
			}

			if ($cat) {
				$param['cat']= $cat;
				$name_cat = $model->get_record('alias = "'.$cat.'"','fs_sim_type','name');
			}
			if ($order) {
				$param['order']= $order;
			}
			if ($network) {
				$param['mang']= $network;
			}
			if ($price) {
				$param['price']= $price;
			}
			if ($head) {
				$param['head']= $head;
			}

//			$query_body = $model -> set_query_body($where);
//			$list = $model -> get_list($query_body);
            $results = $this->elasticsearch_all($number,$cat,$network,$price,$head);

			$list = $results['hits']['hits'];
			$total = $results['hits']['total']['value'];
			$pagination = $model->getPagination($total);

			$type = $model->get_records('','fs_sim_type','id,name,alias',' id ASC,ordering ASC ');
			$net = $model->get_records('','fs_network','id,name,alias','ordering ASC ','','id');
			$prices = $model->get_records('','fs_pricesim','id,title,price',' ordering ASC ');

			// var_dump($prices);die;
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Toàn bộ sim trong hệ thống', 1 => '');
			global $tmpl,$module_config;
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/all.php';
		}

		function mall()
		{
			// call models
			$model = $this->model;
			// $query_body = $model -> set_query_body();
			// $list = $model -> get_list($query_body);
			$url = "danh-sach-sim.html";

			$cat = FSInput::get('cat');
			$order = FSInput::get('order');
			$network = FSInput::get('mang');
			$price = FSInput::get('price');
			$head = FSInput::get('head');
			$param = array();

			$order_name = 'Ngẫu nhiên';
			foreach ($this->sort_arr as $key => $value) {
				if ($key == @$order) {
					$order_name = $value;
				}
			}

			if ($cat) {
				$param['cat']= $cat;
				$name_cat = $model->get_record('alias = "'.$cat.'"','fs_sim_type','name');
			}
			if ($order) {
				$param['order']= $order;
			}
			if ($network) {
				$param['mang']= $network;
			}
			if ($price) {
				$param['price']= $price;
			}
			if ($head) {
				$param['head']= $head;
			}

//			$query_body = $model -> set_query_body($where);
//			$list = $model -> get_list($query_body);
            $results = $this->elasticsearch_all($number,$cat,$network,$price,$head);

			$list = $results['hits']['hits'];
			$total = $results['hits']['total']['value'];
			$pagination = $model->getPagination($total);

			$type = $model->get_records('','fs_sim_type','id,name,alias',' id ASC,ordering ASC ');
			$net = $model->get_records('','fs_network','id,name,alias','ordering ASC ','','id');
			$prices = $model->get_records('','fs_pricesim','id,title,price',' ordering ASC ');

			// var_dump($prices);die;
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Toàn bộ sim trong hệ thống', 1 => '');
			global $tmpl,$module_config;
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/mall.php';
		}

        function update_es(){
//		    $x = 3001/1000;
//		    echo ceil($x);die;
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
            $client = ClientBuilder::create()->setHosts($hosts)->build();

            // $params = [
            //     'index' => 'sim'
            // ];


//Kiểm tra xem Index đã tồn tại không
            // $indexExist = $client->indices()->exists($params);

            // if ($indexExist) {
            //     $response = $client->indices()->delete($params);
            //     echo "Đã xóa";
            // }
            // else {
            //     echo "Index {$params['index']} không có";
            // }
            // die;
            // cập nhật dữ liệu theo query elasticsearch
            // Request
            // $updateRequest = [
            //     'index'     => 'fs_sim_542',
            //     'type'      => '542',
            //     'conflicts' => 'proceed',
            //     'body' => [
            //         'query' => [
            //             'term' => [
            //                 'agency' => '999'
            //             ]

            //         ],
            //         'script' => [
            //             'source' => 'ctx._source.agency  = params.value',
            //             'params' => [
            //                 'value' => 542
            //             ]
            //         ]
            //     ]
            // ];

//            var_dump($updateRequest);
            # Update
            // $results = $client->updateByQuery($updateRequest);

            // xóa dữ liệu theo query elasticsearch
            $updateRequest = [
                'index' => 'fs',
	            'type' => 'simsodep',
                'conflicts' => 'proceed',
                'body' => [
                    'query' => [
                        'term' => [
                            'price_public' => '0'
                        ]
                    ]
                ]
            ];

// //            var_dump($updateRequest);
//             # Update
            $results = $client->deleteByQuery($updateRequest);

            echo '<pre>',print_r($results,1),'</pre>';die;

//             $model = $this -> model;
//             $sim = $model->get_records('','fs_sim_542','sim,number,price,network,network_id,status,admin_status,agency,cat_alias,cat_name,price_public,button,point','','900000,300000');

//             $params = ['body' => []];

//             for ($i = 1; $i <= count($sim); $i++) {
//                 $params['body'][] = [
//                     'index' => [
//                         '_index' => 'fs_sim_542',
//                         '_type' => '542',
//                         '_id' => $sim[$i]->number
//                     ]
//                 ];

//                 $params['body'][] = [
//                     'sim' => $sim[$i]->sim,
//                     'number' => $sim[$i]->number,
//                     'price' => $sim[$i]->price,
// //                    'network' => $sim[$i]->network,
//                     'network_id' => $sim[$i]->network_id,
//                     'status' => $sim[$i]->status,
//                     'admin_status' => $sim[$i]->admin_status,
//                     'agency' => $sim[$i]->agency,
//                     'cat_alias' => $sim[$i]->cat_alias,
// //                    'cat_name' => $sim[$i]->cat_name,
//                     'price_public' => $sim[$i]->price_public,
//                     'button' => $sim[$i]->button,
//                     'point' => $sim[$i]->point
//                 ];

//                 // Every 1000 documents stop and send the bulk request
//                 if ($i % 1000 == 0) {
//                     $responses = $client->bulk($params);

//                     // erase the old bulk request
//                     $params = ['body' => []];

//                     // unset the bulk response when you are done to save memory
//                     unset($responses);
//                 }
//             }

// // Send the last batch if it exists
//             if (!empty($params['body'])) {
//                 $responses = $client->bulk($params);
//             }

        }


		 // "query": {
		 //        "bool": {
		 //            "must": {
		 //                "bool" : { "should": [
		 //                      { "match": { "title": "Elasticsearch" }},
		 //                      { "match": { "title": "Solr" }} ] }
		 //            },
		 //            "must": { "match": { "authors": "clinton gormely" }},
		 //            "must_not": { "match": {"authors": "radu gheorge" }}
		 //        }
		 //    }

        function elasticsearch_all($number,$cat,$network,$price,$head){

        	// call models
			$model = $this->model;

            $client = ClientBuilder::create()->setHosts($hosts)->build();
            if ($number) {
                $arr_number = explode('-', $number);
                foreach ($arr_number as $item) {
                    $must_item = array('number'=>'*'.$item);
                    $must_item = array('wildcard'=>$must_item);
                    $must['should'][] = $must_item;
                }
            }

            if ($head) {
            	$heads = $model->get_records('published = 1','fs_network','id,head_new,head_old');
            	$arr_head = '';
            	if ($head == 'new') {
            		foreach ($heads as $item) {
            			$arr_head .= $item->head_new.',';
            		}
            	}
            	if ($head == 'old') {
            		foreach ($heads as $item) {
            			$arr_head .= $item->head_old.',';
            		}
            	}

            	$arr_head = rtrim($arr_head,',');
            	// var_dump($arr_head);die;
            	$arr_head = explode(',',$arr_head); 

            	foreach ($arr_head as $key){

                    $must_head = array('number'=>$key.'*');
                    $must_head = array('wildcard'=>$must_head);
                    $must_header['should'][] = $must_head;
                }
                $query_header['bool'] = $must_header;
                $must['must'][] = $query_header;

            }

            // var_dump($must);die;

            if ($price) {
            	$prices = $model->get_record('id = "'.$price.'"','fs_pricesim','id,title,price');
            	if ($prices) {

            		$arr_price = explode ( '-' , $prices->price);

            		$from_price = $arr_price[0];
			        if ($from_price) {
			        	$end_price['gte'] = $from_price;
			        }
			        $to_price = $arr_price[1];
			        if ($to_price) {
			        	$end_price['lte'] = $to_price;
			        }
			        if ($from_price || $to_price) {
		                $must_price = array('price_public'=>$end_price);
			            $must_price = array('range'=>$must_price);
			       		$must['must'][] = $must_price;
			        }

            	}
            }

            if ($network) {
                $must_network = array('network'=>$network);
                $must_network = array('term'=>$must_network);
                $must['must'][] = $must_network;
            }

            if ($cat && $cat != 'all') {
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

	                    if (strpos($cat_item->name, 'giữa' ) == false) {
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

            $order = FSInput::get('order');
            if ($order) {
                switch ($order) {
                    case 'up':
                        $ordering = 'asc';
                        $sort = array('price_public'=>$ordering);
                		$body['sort'][] = $sort;
                        break;
                    case 'down':
                        $ordering = 'desc';
                        $sort = array('price_public'=>$ordering);
                		$body['sort'][] = $sort;
                        break;
                    case 'prioritize':
                        $ordering = 'prioritize';
                        $user = $model->get_records('is_hot = 1','fs_users','id,username');

                        if($user){
		                    foreach ($user as $item){
		                        $must_user = array('agency'=>$item->id);
		                        $must_user = array('term'=>$must_user);
		                        $must_s['should'][] = $must_user;
		                    }
		                }


		                $query2['bool'] = $must_s;
		                $must['filter'][] = $query2;

                        // echo '<pre>',print_r($query,1),'</pre>';die;

                        break;
                    default :
                    	unset($body['sort']);
                        break;
                }
            
            }

            // trạng thái status mặc định là 0
			$must_status = array('status'=>'0');
            $must_status = array('term'=>$must_status);
       		$must['must'][] = $must_status;
       		// trạng thái status mặc định là 0
       		$must_admin_status = array('admin_status'=>'1');
            $must_admin_status = array('term'=>$must_admin_status);
       		$must['must'][] = $must_admin_status;

            $query['bool'] = $must;
            $body['query'] = $query;
            $body['size'] = 50;
            $page = FSInput::get('page','1','int');
            $page = $page<200 ? $page:200;
            $body['from'] = ($page-1)*$body['size'];

            $params = [
                'index' => 'fs',
                'type' => 'simsodep',
                'body' => $body
            ];

            $results = $client->search($params);
           // echo '<pre>',print_r($results,1),'</pre>';die;

            return $results;
        }

		function elasticsearch(){

            $model = $this -> model;
			$client = ClientBuilder::create()->setHosts($hosts)->build();

			// trạng thái status mặc định là 0
			$must_status = array('status'=>'0');
            $must_status = array('term'=>$must_status);
       		$must['must'][] = $must_status;
       		// trạng thái status mặc định là 0
       		$must_admin_status = array('admin_status'=>'1');
            $must_admin_status = array('term'=>$must_admin_status);
       		$must['must'][] = $must_admin_status;

			$network = FSInput::get('network');
	        if ($network && $network != 'all') {
	            $must_network = array('network_id'=>$network);
	            $must_network = array('term'=>$must_network);
	       		$must['must'][] = $must_network; 
	        }

	        $button = FSInput::get('button');
	        if ($button) {
                $must_button = array('button'=>$button);
	            $must_button = array('term'=>$must_button);
	       		$must['must'][] = $must_button;
	        }

	        $point = FSInput::get('point');
	        if ($point) {
                $must_point = array('point'=>$point);
	            $must_point = array('term'=>$must_point);
	       		$must['must'][] = $must_point;
	        }

	        $from_price = FSInput::get('from_price');
	        if ($from_price) {
	        	$from_price = str_replace(",","",$from_price);
	        	$end_price['gte'] = $from_price;
	        }
	        $to_price = FSInput::get('to_price');
	        if ($to_price) {
	        	$to_price = str_replace(",","",$to_price);
	        	$end_price['lte'] = $to_price;
	        }
	        if ($from_price || $to_price) {
                $must_price = array('price_public'=>$end_price);
	            $must_price = array('range'=>$must_price);
	       		$must['must'][] = $must_price;
	        }

	        $number = FSInput::get('number');
	        if ($number == '0') {
	        	$must_item = array('number'=>'0??*0*');
	            $must_item = array('wildcard'=>$must_item);
	       		$must['must_not'][] = $must_item;
	        }
	        elseif ($number) {
	            $arr_number = explode('-', $number);
	            foreach ($arr_number as $item) {
	            	if ($item == 0) {
	            		$must_item = array('number'=>'0??*0*');
			            $must_item = array('wildcard'=>$must_item);
			       		$must['must_not'][] = $must_item;
	            	}else{
		                $must_item = array('number'=>'*'.$item.'*');
			            $must_item = array('wildcard'=>$must_item);
			       		$must['must_not'][] = $must_item;
	            	}
	            }
	        }

	        $cat = FSInput::get('cat');
	        if ($cat && $cat != 'all') {
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

	                    if (strpos($cat_item->name, 'giữa' ) == false) {
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

	        $keyword = FSInput::get('keyword');
	        global $db;
        	$keyword = $db->escape_string($keyword);

        	$keyword = str_replace(' ','',$keyword);
        	$keyword = str_replace('.','',$keyword);
        	$keyword = str_replace(',','',$keyword);
        	$keyword = str_replace('x','?',$keyword);

	        if ($keyword && $keyword != 'all') {

	        	$str = $this->search_advanced($keyword);

	        	// var_dump($str);

	        	foreach ($str as $item) {
	        		// $must_keyword= array('sim'=>$item);
		         //    $must_keyword = array('wildcard'=>$must_keyword);
		       		// $must['should'][] = $must_keyword;

		            $must_keyword= array('number'=>$item);
		            $must_keyword = array('wildcard'=>$must_keyword);
		       		$must['should'][] = $must_keyword;
	        	}


	       		$must['minimum_should_match'] = 1;
	       		$must['boost'] = '1.0';
	        }

            // if (!$cat && !$network && !$button && !$point && !$from_price && !$to_price && !$number && $keyword == 'all'){
            //     $body['query'] = array('match_all'=>array('boost'=>'1.2'));
            // }else{
            //     $query['bool'] = $must;
            //     $body['query'] = $query;
            // }

            $query['bool'] = $must;
            $body['query'] = $query;
                

            $body['size'] = 50;
            $page = FSInput::get('page','1','int');
            $page = $page<200 ? $page:200;
            $body['from'] = ($page-1)*$body['size'];


            $order = FSInput::get('order');
            if ($order) {
                switch ($order) {
                    case 'up':
                        $ordering = 'asc';
                        $sort = array('price_public'=>$ordering);
                		$body['sort'][] = $sort;
                        break;
                    case 'down':
                        $ordering = 'desc';
                        $sort = array('price_public'=>$ordering);
                		$body['sort'][] = $sort;
                        break;
                    case 'prioritize':
                        $ordering = 'prioritize';
                        $user = $model->get_records('is_hot = 1','fs_users','id,username');

                        if($user){
		                    foreach ($user as $item){
		                        $must_user = array('agency'=>$item->id);
		                        $must_user = array('term'=>$must_user);
		                        $must_s['should'][] = $must_user;
		                    }
		                }


		                $query2['bool'] = $must_s;
		                $must['filter'][] = $query2;

                        // echo '<pre>',print_r($query,1),'</pre>';die;

                        break;
                    default :
                    	unset($body['sort']);
                        break;
                }
            
            }

	        $params = [
	            'index' => 'fs',
	            'type' => 'simsodep',
	            'body' => $body
	        ];

	        // $params['body']['sort'][] = array( "price_public.keyword" => 'asc');

	         // echo '<pre>',print_r($params),'</pre>';
	        // echo '<pre>',print_r($params['body'],1),'</pre>';
	        // print_r($params);die;

            $results = $client->search($params);
           	// echo '<pre>',print_r($results,1),'</pre>';die;

            return $results;
		}

		function search_advanced($keyword){
			$where ='';

	            // trường hợp có *
	            if (strpos($keyword, '*' ) !== false) {
	                $arr_key = explode('*', $keyword);
	                $quantity = count($arr_key);
	                // trường hợp tìm theo đầu
	                if ($arr_key[0] && !$arr_key[1] && $quantity < 3) {
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
	                if (!$arr_key[0] && $arr_key[1] && $quantity < 3) {
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
	                if ($arr_key[0] && $arr_key[1] && $quantity < 3) {
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

	                // trường hợ dạng *xxx*
	                elseif ($quantity == 3) {
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
        	$arr_number = array();
	        foreach ($arr_txt as $item) {

	            if (strpos($item,'x') !== false) {
	                $arr_number = array_merge($arr_number, $this->search_x($item,$f,$l,$type));
	                // var_dump($arr_number);
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