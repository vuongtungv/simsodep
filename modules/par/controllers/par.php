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

	
	class ParControllersPar extends FSControllers
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

			// var_dump($_REQUEST);die;

			$code = FSInput::get('code');
	        if (!$code) {
	            setRedirect(URL_ROOT,'');
	        }

	        switch ($code) {
	        	case 'kim':
	        		$where = ' AND (number like "%6" OR number like "%7")';
	        		$br = 'Sim hợp mệnh kim';
	        		$name_par = 'kim';
                    $number = '6-7';
                    $url = 'sim-hop-menh-kim.html';
	        		break;
	        	case 'moc':
	        		$where = ' AND (number like "%3" OR number like "%4")';
	        		$br = 'Sim hợp mệnh mộc';
	        		$name_par = 'mộc';
                    $number = '3-4';
                    $url = 'sim-hop-menh-moc.html';
	        		break;
        		case 'thuy':
	        		$where = ' AND number like "%1"';
	        		$br = 'Sim hợp mệnh thủy';
	        		$name_par = 'thủy';
                    $number = '1';
                    $url = 'sim-hop-menh-thuy.html';
	        		break;
        		case 'hoa':
	        		$where = ' AND number like "%9"';
	        		$br = 'Sim hợp mệnh hỏa';
	        		$name_par = 'hỏa';
                    $number = '9';
                    $url = 'sim-hop-menh-hoa.html';
	        		break;
        		case 'tho':
	        		$where = ' AND (number like "%2" OR number like "%5" OR number like "%8")';
	        		$br = 'Sim hợp mệnh thổ';
	        		$name_par = 'thổ';
                    $number = '2-5-8';
                    $url = 'sim-hop-menh-tho.html';
	        		break;
	        	default:
	        		setRedirect(URL_ROOT,'');
	        		break;
	        }

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
            $results = $this->elasticsearch($number,$cat,$network,$price,$head);

            $list = $results['hits']['hits'];
            $total = $results['hits']['total']['value'];
            $pagination = $model->getPagination($total);

            $type = $model->get_records('','fs_sim_type','id,name,alias',' ordering ASC,id ASC ');
            $net = $this->model->get_records('published = 1','fs_network','id,name,alias',' ordering ASC ');
            $prices = $model->get_records('','fs_pricesim','id,title,price',' ordering ASC ');

			$seo = $model->get_record('published = 1 AND module_seo = "par" AND type = "'.$code.'"','fs_seo','title,keywords,description,content');
			if (!$seo) {
				$seo = $model->get_record('published = 1 AND module_seo = "par" AND type = "par"','fs_seo','title,keywords,description,content');
			}
			// var_dump($seo);
			global $tmpl,$module_config;

			if ($seo) {
				$title = str_replace('#menh#',$name_par, $seo->title);
				$keywords = str_replace('#menh#',$name_par, $seo->keywords);
				$description = str_replace('#menh#',$name_par, $seo->description);
				$content = str_replace('#menh#',$name_par, $seo->content);

                $pages = FSInput::get('page');
                if ($pages>1)
                    $title = $title.' - Trang '.$pages;

				$tmpl -> assign('title', $title);
				$tmpl -> assign('keywords', $keywords);
	            $tmpl ->assign ( 'description', $description);
			}

			$content = html_entity_decode($content);

			// $type = $model->get_records('','fs_sim_type','id,name,alias',' id ASC,ordering ASC ');
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>$br, 1 => '');
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		function mdisplay()
		{
			// call models
			$model = $this->model;

			// var_dump($_REQUEST);die;

			$code = FSInput::get('code');
	        if (!$code) {
	            setRedirect(URL_ROOT,'');
	        }

	        switch ($code) {
	        	case 'kim':
	        		$where = ' AND (number like "%6" OR number like "%7")';
	        		$br = 'Sim hợp mệnh kim';
	        		$name_par = 'mệnh kim';
                    $number = '6-7';
                    $url = 'sim-hop-menh-kim.html';
	        		break;
	        	case 'moc':
	        		$where = ' AND (number like "%3" OR number like "%4")';
	        		$br = 'Sim hợp mệnh mộc';
	        		$name_par = 'mệnh mộc';
                    $number = '3-4';
                    $url = 'sim-hop-menh-moc.html';
	        		break;
        		case 'thuy':
	        		$where = ' AND number like "%1"';
	        		$br = 'Sim hợp mệnh thủy';
	        		$name_par = 'mệnh thủy';
                    $number = '1';
                    $url = 'sim-hop-menh-thuy.html';
	        		break;
        		case 'hoa':
	        		$where = ' AND number like "%9"';
	        		$br = 'Sim hợp mệnh hỏa';
	        		$name_par = 'mệnh hỏa';
                    $number = '9';
                    $url = 'sim-hop-menh-hoa.html';
	        		break;
        		case 'tho':
	        		$where = ' AND (number like "%2" OR number like "%5" OR number like "%8")';
	        		$br = 'Sim hợp mệnh thổ';
	        		$name_par = 'mệnh thổ';
                    $number = '2-5-8';
                    $url = 'sim-hop-menh-tho.html';
	        		break;
	        	default:
	        		setRedirect(URL_ROOT,'');
	        		break;
	        }

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
            $results = $this->elasticsearch($number,$cat,$network,$price,$head);

            $list = $results['hits']['hits'];
            $total = $results['hits']['total']['value'];
            $pagination = $model->getPagination($total);

            $type = $model->get_records('','fs_sim_type','id,name,alias',' ordering ASC,id ASC ');
            $net = $this->model->get_records('published = 1','fs_network','id,name,alias',' ordering ASC ');
            $prices = $model->get_records('','fs_pricesim','id,title,price',' ordering ASC ');

			$seo = $model->get_record('published = 1 AND module_seo = "par" AND type = "'.$code.'"','fs_seo','title,keywords,description,content');
			if (!$seo) {
				$seo = $model->get_record('published = 1 AND module_seo = "par" AND type = "par"','fs_seo','title,keywords,description,content');
			}
			// var_dump($seo);
			global $tmpl,$module_config;

			if ($seo) {
				$title = str_replace('#menh#',$name_par, $seo->title);
				$keywords = str_replace('#menh#',$name_par, $seo->keywords);
				$description = str_replace('#menh#',$name_par, $seo->description);
				$content = str_replace('#menh#',$name_par, $seo->content);

                $pages = FSInput::get('page');
                if ($pages>1)
                    $title = $title.' - Trang '.$pages;

				$tmpl -> assign('title', $title);
				$tmpl -> assign('keywords', $keywords);
	            $tmpl ->assign ( 'description', $description);
			}

			$content = html_entity_decode($content);

			// $type = $model->get_records('','fs_sim_type','id,name,alias',' id ASC,ordering ASC ');
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>$br, 1 => '');
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/mdefault.php';
		}

        function elasticsearch($number,$cat,$network,$price,$head){

        	// call models
			$model = $this->model;

            $client = ClientBuilder::create()->setHosts($hosts)->build();
            if ($number) {
                $arr_number = explode('-', $number);
                foreach ($arr_number as $item) {
                    $must_item = array('number'=>'*'.$item);
                    $must_item = array('wildcard'=>$must_item);
                    $must_number['should'][] = $must_item;
                }
                $query_number['bool'] = $must_number;
                $must['must'][] = $query_number;
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

           // echo '<pre>',print_r($params,1),'</pre>';
            $results = $client->search($params);

            return $results;
        }

	}
	
?>