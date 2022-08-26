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
	
	class ListControllersList extends FSControllers
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


	        $ccode = FSInput::get('ccode');
	        $code = FSInput::get('code');
			$ccat = $model->get_record('alias = "'.$ccode.'"','fs_sim_type','id,name,alias');
			$cat = $model->get_record('alias = "'.$code.'"','fs_sim_type','id,name,parent_id,parent_name,alias,level,parent_alias');
			$level = $cat->level;
			if (!$level){
                $level = 0;
            }
			// var_dump($cat->parent_id);
            $title_header = $cat->name;

			if (!$cat || @$ccat->id != $cat->parent_id) {
	            setRedirect(URL_ROOT,'');
	        }

	       	$network = FSInput::get('mang');

			$order = FSInput::get('order');
			$price = FSInput::get('price');
			$head = FSInput::get('head');
			$param = array();
			
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


			$order_name = 'Ngẫu nhiên';
			foreach ($this->sort_arr as $key => $value) {
				if ($key == @$order) {
					$order_name = $value;
				}
			}


	        $net = $this->model->get_records('published = 1','fs_network','id,name,alias',' ordering ASC ');
            $mang = $model->get_record('alias = "'.$network.'" and published = 1','fs_network','id,name,header,alias');
            $prices = $model->get_records('','fs_pricesim','id,title,price',' ordering ASC ');

//			$query_body = $model -> set_query_body($cat->alias);
//			$list = $model -> get_list($query_body);
            // $results = $this->elasticsearch($cat->id,$cat->alias,$cat->parent_id,$cat->parent_name,$cat->level);
            $results = $this->elasticsearch($cat->id,$cat->alias,$cat->parent_id,$cat->parent_name,$cat->level,$mang->id,$price,$head);

            $list = $results['hits']['hits'];
            $total = $results['hits']['total']['value'];
            $pagination = $model->getPagination($total);


			$breadcrumbs = array();
			if ($ccat) {
				$url = URL_ROOT.$cat->parent_alias.'/'.$code.'.html';
				$breadcrumbs[] = array(0=>$ccat->name,1=>URL_ROOT.$ccode.'.html');
				$breadcrumbs[] = array(0=>$cat->name);
			}else{
				$url = URL_ROOT.$code.'.html';
				$breadcrumbs[] = array(0=>$cat->name);
			}
			global $tmpl,$module_config;
			$tmpl -> assign('breadcrumbs', $breadcrumbs);

            // $network = FSInput::get('code');

			if (!$ccat) {
				$seo = $model->get_record('published = 1 AND module_seo = "cat" AND type = "'.$cat->id.'"','fs_seo','title,keywords,description,content');
				if (!$seo) {
					$seo = $model->get_record('published = 1 AND module_seo = "cat" AND type = "cat"','fs_seo','title,keywords,description,content');
				}
			}else{
				$seo = $model->get_record('published = 1 AND module_seo = "subcat" AND type = "'.$cat->id.'"','fs_seo','title,keywords,description,content');
				if (!$seo) {
					$seo = $model->get_record('published = 1 AND module_seo = "subcat" AND type = "'.$ccat->id.'"','fs_seo','title,keywords,description,content');
					if (!$seo) {
						$seo = $model->get_record('published = 1 AND module_seo = "subcat" AND type = "cat"','fs_seo','title,keywords,description,content');
					}
				}
			}

			// var_dump($mang);
			// var_dump($seo);
			if ($seo) {
				$cat->name = str_replace('Sim ','', $cat->name);
				if (!$ccat) {
					$title = str_replace('#theloai#',$cat->name, $seo->title);
					$keywords = str_replace('#theloai#',$cat->name, $seo->keywords);
					$description = str_replace('#theloai#',$cat->name, $seo->description);
					$content = str_replace('#theloai#',$cat->name, $seo->content);
				}else{
					$ccat->name = str_replace('Sim ','', $ccat->name);

					$title = str_replace('#theloai#',$ccat->name, $seo->title);
					$keywords = str_replace('#theloai#',$ccat->name, $seo->keywords);
					$description = str_replace('#theloai#',$ccat->name, $seo->description);
					$content = str_replace('#theloai#',$ccat->name, $seo->content);

					$title = str_replace('#theloaicon#',$cat->name, $title);
					$keywords = str_replace('#theloaicon#',$cat->name, $keywords);
					$description = str_replace('#theloaicon#',$cat->name, $description);
					$content = str_replace('#theloaicon#',$cat->name, $content);

				}

                $pages = FSInput::get('page');
				if ($pages>1)
                $title = $title.' - Trang '.$pages;

				$content = html_entity_decode($content);

				$tmpl -> assign('title', $title);
				$tmpl -> assign('keywords', $keywords);
	            $tmpl ->assign ('description', $description);
			}


			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		function mdisplay()
		{
			// call models
			$model = $this->model;


	        $ccode = FSInput::get('ccode');
	        $code = FSInput::get('code');
			$ccat = $model->get_record('alias = "'.$ccode.'"','fs_sim_type','id,name,alias');
			$cat = $model->get_record('alias = "'.$code.'"','fs_sim_type','id,name,parent_id,parent_name,alias,level');
			$level = $cat->level;
			if (!$level){
                $level = 0;
            }
			// var_dump($cat->parent_id);
			// var_dump($cat);die;
			if (!$cat || @$ccat->id != $cat->parent_id) {
	            setRedirect(URL_ROOT,'');
	        }
            $title_header = $cat->name;


	       	$network = FSInput::get('mang');

			$order = FSInput::get('order');
			$price = FSInput::get('price');
			$head = FSInput::get('head');
			$param = array();
			
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


			$order_name = 'Ngẫu nhiên';
			foreach ($this->sort_arr as $key => $value) {
				if ($key == @$order) {
					$order_name = $value;
				}
			}


	        $net = $this->model->get_records('published = 1','fs_network','id,name,alias',' ordering ASC ');
            $mang = $model->get_record('alias = "'.$network.'" and published = 1','fs_network','id,name,header,alias');
            $prices = $model->get_records('','fs_pricesim','id,title,price',' ordering ASC ');

//			$query_body = $model -> set_query_body($cat->alias);
//			$list = $model -> get_list($query_body);
            // $results = $this->elasticsearch($cat->id,$cat->alias,$cat->parent_id,$cat->parent_name,$cat->level);
            $results = $this->elasticsearch($cat->id,$cat->alias,$cat->parent_id,$cat->parent_name,$cat->level,$mang->id,$price,$head);

            $list = $results['hits']['hits'];
            $total = $results['hits']['total']['value'];
            $pagination = $model->getPagination($total);

			
			$breadcrumbs = array();
			if ($ccat) {
				$url = URL_ROOT.$cat->parent_name.'/'.$code.'.html';
				$breadcrumbs[] = array(0=>$ccat->name,1=>URL_ROOT.$ccode.'.html');
				$breadcrumbs[] = array(0=>$cat->name);
			}else{
				$url = URL_ROOT.$code.'.html';
				$breadcrumbs[] = array(0=>$cat->name);
			}
			global $tmpl,$module_config;
			$tmpl -> assign('breadcrumbs', $breadcrumbs);

            // $network = FSInput::get('code');

			if (!$ccat) {
				$seo = $model->get_record('published = 1 AND module_seo = "cat" AND type = "'.$cat->id.'"','fs_seo','title,keywords,description,content');
				if (!$seo) {
					$seo = $model->get_record('published = 1 AND module_seo = "cat" AND type = "cat"','fs_seo','title,keywords,description,content');
				}
			}else{
				$seo = $model->get_record('published = 1 AND module_seo = "subcat" AND type = "'.$cat->id.'"','fs_seo','title,keywords,description,content');
				if (!$seo) {
					$seo = $model->get_record('published = 1 AND module_seo = "subcat" AND type = "'.$ccat->id.'"','fs_seo','title,keywords,description,content');
					if (!$seo) {
						$seo = $model->get_record('published = 1 AND module_seo = "subcat" AND type = "cat"','fs_seo','title,keywords,description,content');
					}
				}
			}

			// var_dump($mang);
			// var_dump($seo);
			if ($seo) {
				$cat->name = str_replace('Sim ','', $cat->name);
				if (!$ccat) {
					$title = str_replace('#theloai#',$cat->name, $seo->title);
					$keywords = str_replace('#theloai#',$cat->name, $seo->keywords);
					$description = str_replace('#theloai#',$cat->name, $seo->description);
					$content = str_replace('#theloai#',$cat->name, $seo->content);
				}else{
					$ccat->name = str_replace('Sim ','', $ccat->name);

					$title = str_replace('#theloai#',$ccat->name, $seo->title);
					$keywords = str_replace('#theloai#',$ccat->name, $seo->keywords);
					$description = str_replace('#theloai#',$ccat->name, $seo->description);
					$content = str_replace('#theloai#',$ccat->name, $seo->content);

					$title = str_replace('#theloaicon#',$cat->name, $title);
					$keywords = str_replace('#theloaicon#',$cat->name, $keywords);
					$description = str_replace('#theloaicon#',$cat->name, $description);
					$content = str_replace('#theloaicon#',$cat->name, $content);

				}

                $pages = FSInput::get('page');
				if ($pages>1)
                $title = $title.' - Trang '.$pages;

				$content = html_entity_decode($content);

				$tmpl -> assign('title', $title);
				$tmpl -> assign('keywords', $keywords);
	            $tmpl ->assign ('description', $description);
			}


			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/mdefault.php';
		}


        function elasticsearch($id,$alias,$parent_id,$parent_name,$level,$network,$price,$head){

            $client = ClientBuilder::create()->setHosts($hosts)->build();
            $model = $this->model;

            if ($network) {
                $must_network = array('network_id'=>$network);
                $must_network = array('term'=>$must_network);
                $must['must'][] = $must_network;
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


            $cat_item = $model->get_record('id = "'.$id.'"','fs_sim_type','id,name,parent_id,alias,level,parent_name');
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


           //  if (!$level){
           //      $list = $model->get_records('parent_id = "'.$id.'"','fs_sim_type','id,name,parent_id,alias');
           //      if ($list) {
           //          foreach ($list as $item){
           //              $must_cat = array('cat_alias'=>','.$parent_name.','.$item->alias.',');
           //              $must_cat = array('match_phrase'=>$must_cat);
           //              $must_cate['should'][] = $must_cat;
           //          }
           //          $query_cate['bool'] = $must_cate;
           //          $must['must'][] = $query_cate;
           //      }else{
           //      	$must_cat = array('cat_alias'=>','.$parent_name.',');
           //          $must_cat = array('match_phrase'=>$must_cat);
           //          $must['must'][] = $must_cat;

           //          if (strpos($parent_name, 'giua' ) == false) {
			        // 	$must_item = array('cat_alias'=>'*giua*');
			        //     $must_item = array('wildcard'=>$must_item);
			       	// 	$must['must_not'][] = $must_item;
			        // }
           //      }
           //  }else{
           //      $must_cat = array('cat_alias'=>','.$parent_name.','.$cat_item->alias.',');
           //      $must_cat = array('match_phrase'=>$must_cat);
           //      $must['must'][] = $must_cat;
           //  }


           //  if (!$level){
           //      $list = $model->get_records('parent_id = "'.$id.'"','fs_sim_type','id,name,parent_id,alias');
           //      if($list){
           //          foreach ($list as $item){
           //              $must_cat = array('cat_alias'=>','.$alias.','.$item->alias.',');
           //              $must_cat = array('match_phrase'=>$must_cat);
           //              $must['should'][] = $must_cat;
           //          }
           //      }else{
           //          $must_cat = array('cat_alias'=>','.$alias.',');
           //          $must_cat = array('match_phrase'=>$must_cat);
           //          $must['must'][] = $must_cat;

           //          if (strpos($alias, 'giua' ) == false) {
			        // 	$must_item = array('cat_alias'=>'*giua*');
			        //     $must_item = array('wildcard'=>$must_item);
			       	// 	$must['must_not'][] = $must_item;
			        // }
           //      }
           //  }else{
           //      $must_cat = array('cat_alias'=>','.$parent_name.','.$alias.',');
           //      $must_cat = array('match_phrase'=>$must_cat);
           //      $must['must'][] = $must_cat;
           //  }

            // trạng thái status mặc định là 0
			$must_status = array('status'=>'0');
            $must_status = array('term'=>$must_status);
       		$must['must'][] = $must_status;
       		// trạng thái status mặc định là 0
       		$must_admin_status = array('admin_status'=>'1');
            $must_admin_status = array('term'=>$must_admin_status);
       		$must['must'][] = $must_admin_status;

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
            // echo '<pre>',print_r($results,1),'</pre>';die;

            if (!$results) {
            	setRedirect(URL_ROOT);
            }

            return $results;
        }

	}
	
?>