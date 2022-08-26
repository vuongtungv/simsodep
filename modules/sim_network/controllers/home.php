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
	
	class Sim_networkControllersHome extends FSControllers
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
			$model = $this -> model;
			global $tmpl;	
		
            $type = FSInput::get('type');

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

            $results = $this->elasticsearch($type,$cat,$network,$price,$head);

            $list = $results['hits']['hits'];
            $total = $results['hits']['total']['value'];
            $pagination = $model->getPagination($total);
            $md = '';
            if($type==1){
			    $ber = "Sim viettel V90";
                $md = 'sim_sales';
                $url = URL_ROOT.'sim-viettel-v90.html';
            }else if($type==2){
			    $ber = "Sim vip";
                $md ="sim_vip";
                $url = URL_ROOT.'sim-vip.html';
            }else if($type==3){
			    $ber = "Sim đề xuất";
                $md ="sim_offer";
                $url = URL_ROOT.'sim-de-xuat.html';
            }else if($type==5){
                $ber = "Sim trả sau";
                $md ="sim_after";
                $url = URL_ROOT.'sim-tra-sau.html';
            }else{
			    $ber = "Khuyến mãi sim số đẹp";
                $md ='sim_promotion';
                $url = URL_ROOT.'khuyen-mai-sim-so-dep.html';
            }

            $type = $model->get_records('','fs_sim_type','id,name,alias',' ordering ASC,id ASC ');
            $net = $this->model->get_records('published = 1','fs_network','id,name,alias',' ordering ASC ');
            $prices = $model->get_records('','fs_pricesim','id,title,price',' ordering ASC ');

            $seo = $model->get_record('published = 1 AND module_seo = "'.$md.'"','fs_seo','title,keywords,description,content');

            if ($seo) {
                $tmpl -> assign('title', $seo->title);
                $tmpl -> assign('keywords', $seo->keywords);
                $tmpl ->assign ( 'description', $seo->description);
            }

            $content = html_entity_decode($seo->content);

			$breadcrumbs = array();
			$breadcrumbs[] = array(0=> $ber, 1 =>'');
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// $tmpl -> set_seo_special();

			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		} 

        function mdisplay()
        {           
            // call models
            $model = $this -> model;
            global $tmpl;   
        
            $type = FSInput::get('type');

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

            $results = $this->elasticsearch($type,$cat,$network,$price,$head);

            $list = $results['hits']['hits'];
            $total = $results['hits']['total']['value'];
            $pagination = $model->getPagination($total);
            $md = '';
            if($type==1){
                $ber = "Sim viettel V90";
                $md = 'sim_sales';
                $url = URL_ROOT.'sim-viettel-v90.html';
            }else if($type==2){
                $ber = "Sim vip";
                $md ="sim_vip";
                $url = URL_ROOT.'sim-vip.html';
            }else if($type==3){
                $ber = "Sim đề xuất";
                $md ="sim_offer";
                $url = URL_ROOT.'sim-de-xuat.html';
            }else if($type==5){
                $ber = "Sim trả sau";
                $md ="sim_after";
                $url = URL_ROOT.'sim-tra-sau.html';
            }else{
                $ber = "Khuyến mãi sim số đẹp";
                $md ='sim_promotion';
                $url = URL_ROOT.'khuyen-mai-sim-so-dep.html';
            }

            $type = $model->get_records('','fs_sim_type','id,name,alias',' ordering ASC,id ASC ');
            $net = $this->model->get_records('published = 1','fs_network','id,name,alias',' ordering ASC ');
            $prices = $model->get_records('','fs_pricesim','id,title,price',' ordering ASC ');

            $seo = $model->get_record('published = 1 AND module_seo = "'.$md.'"','fs_seo','title,keywords,description,content');

            if ($seo) {
                $tmpl -> assign('title', $seo->title);
                $tmpl -> assign('keywords', $seo->keywords);
                $tmpl ->assign ( 'description', $seo->description);
            }

            $content = html_entity_decode($seo->content);

            $breadcrumbs = array();
            $breadcrumbs[] = array(0=> $ber, 1 =>'');
            $tmpl -> assign('breadcrumbs', $breadcrumbs);
            // $tmpl -> set_seo_special();

            // call views           
            include 'modules/'.$this->module.'/views/'.$this->view.'/mdefault.php';
        }
        function elasticsearch($type,$cat,$network,$price,$head){
            // call models
            $model = $this -> model;

            $client = ClientBuilder::create()->setHosts($hosts)->build();

            if ($type) {
                $must_network = array('type'=>$type);
                $must_network = array('term'=>$must_network);
                $must['must'][] = $must_network;
            }

            if ($network) {
                $must_network = array('network'=>$network);
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
            $page = $page?$page:'1';
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
        function add_cart()
        {
            $json = array(
                'error' => true,
                'msg' => 'Có lỗi trong quán trình xử lý!'
            );
            $sim_id = FSInput::get('id');
            $price_sim = FSInput::get('price');
            $sim = FSInput::get('sim');
            if (!$sim_id)
                $sim_id = FSInput::get('id', 0, 'int');
            if (!$sim_id) {
                $json['msg'] = 'Sản phẩm chưa xác định!';
                goto return_json;
            }
//        $this->addcart($product_id, $quantity, $color, $size, $material, 0);
            $this->addcart($sim_id,$price_sim,$sim);

            $json = array(
                'error' => false,
                'msg' => 'Mua sản phẩm thành công!'
            );

            return_json:
            echo json_encode($json);
        }

        function addcart($sim_id,$price_sim,$sim)
        {
            $key = $sim_id;
            if (!isset($_SESSION['cart'])) {
                $sim_list = array();
                $sim_list[$key] = array(
                    $sim_id,
                    $price_sim,
                    $sim
                );
            } else {
                $sim_list = $_SESSION['cart'];
                $sim_list[$key] = array(
                    $sim_id,
                    $price_sim,
                    $sim
                );
            }
            $_SESSION['cart'] = $sim_list;
        }
        function delete(){
            $pid = FSInput::get('id', 0, 'int');
            $Itemid = FSInput::get('Itemid', 2, 'int');
            if ($pid){
                
                if (isset($_SESSION['cart'])){
                    $product_list = $_SESSION['cart'];
                    $count_products_current = 0;
                    $products_new = array();
                    foreach ($product_list as $key=>$val){
                        if ($pid != $key){
                            $products_new[$key] = $val;
                        }
                    }
                    $_SESSION['cart'] = $products_new;
                }
            }
//        $link = FSRoute::_('index.php?module=home&view=home&Itemid=2&task=shopcart&Itemid='.$Itemid);
            $link = header('Location: '.$_SERVER['REQUEST_URI']);
            setRedirect($link);
        }
		
	}
	
?>