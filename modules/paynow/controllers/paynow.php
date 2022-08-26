<?php

    // require PATH_BASE.'libraries/elasticsearch/vendor/elasticsearch/elasticsearch/src/Elasticsearch/ClientBuilder.php';
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


class PaynowControllersPaynow extends FSControllers{
    function __construct(){
        parent::__construct();
    }
    
    function display(){
        global $arrProductLine;

        $type = FSInput::get('type', 'default');
        $this->model->type = $type;
        if(!$_SESSION['cart']){
            $link = URL_ROOT;
            $msg = 'Không có sim trong giỏ hàng hoặc sim đã được đặt!';
            setRedirect($link,$msg);
        }
        // $orderSims = $_SESSION['cart'];
        $orderSims = $this->model->getSimsCart();
        // var_dump($orderSims);die;
        $getCity = $this->model->getCity();
        $model = $this -> model;
        $method = $model->get_records('published = 1','fs_typepay','id,title,type_id');
        $id_order = FSInput::get('id');
        global $tmpl;
        $breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Thanh toán', 1=>'');
		$tmpl -> assign('breadcrumbs', $breadcrumbs);
        require(PATH_BASE.'modules/' . $this->module . '/views/paynow/default.php');
    }

    function compare_cart()
    {
        $id = FSInput::get('id');
        $arr_id = explode(',', $id);

        if (isset($_SESSION['cart'])){
            $product_list = $_SESSION['cart'];

            $products_new = array();
            foreach ($product_list as $key=>$val){
                if (in_array($val[0], $arr_id)){
                    $products_new[$key] = $val;
                }
            }

            $_SESSION['cart'] = $products_new;

            if (@$_SESSION['cart']){
                $arr_cart = array();
                foreach ($_SESSION['cart'] as $item){
                    $arr_cart[] = $item[2];
                }
                $_SESSION['arr_cart'] = $arr_cart;
            }else{
                unset($_SESSION['arr_cart']);
            }

        }

    }  

    function mcompare_cart()
    {
        $id = FSInput::get('id');
        $arr_id = explode(',', $id);

        if (isset($_SESSION['cart'])){
            $product_list = $_SESSION['cart'];

            $products_new = array();
            foreach ($product_list as $key=>$val){
                if (in_array($val[0], $arr_id)){
                    $products_new[$key] = $val;
                }
            }

            $_SESSION['cart'] = $products_new;

            if (@$_SESSION['cart']){
                $arr_cart = array();
                foreach ($_SESSION['cart'] as $item){
                    $arr_cart[] = $item[2];
                }
                $_SESSION['arr_cart'] = $arr_cart;
            }else{
                unset($_SESSION['arr_cart']);
            }

        }

    } 

    function compare()
    {
        $type = FSInput::get('type', 'default');
        $this->model->type = $type;
        $orderSims = $this->model->getSimsCart();
        // var_dump($orderSims);die;
        if(!$orderSims){
            $link = URL_ROOT;
            $msg = 'Không có sim trong giỏ hàng hoặc sim đã được đặt!';
            setRedirect($link,$msg);
        }
        global $tmpl;
        $breadcrumbs = array();
        $breadcrumbs[] = array(0=>'So sánh sim', 1=>'');
        $tmpl -> assign('breadcrumbs', $breadcrumbs);

        require(PATH_BASE.'modules/' . $this->module . '/views/paynow/compare.php');
    }


    function mcompare()
    {
        $type = FSInput::get('type', 'default');
        $this->model->type = $type;
        $orderSims = $this->model->getSimsCart();
        // var_dump($orderSims);die;
        if(!$orderSims){
            $link = URL_ROOT;
            $msg = 'Không có sim trong giỏ hàng hoặc sim đã được đặt!';
            setRedirect($link,$msg);
        }
        global $tmpl;
        $breadcrumbs = array();
        $breadcrumbs[] = array(0=>'So sánh sim', 1=>'');
        $tmpl -> assign('breadcrumbs', $breadcrumbs);

        require(PATH_BASE.'modules/' . $this->module . '/views/paynow/mcompare.php');
    }

    function sim(){

        $sim = FSInput::get('sim');

        $client = ClientBuilder::create()->setHosts($hosts)->build();

        if ($sim) {

            $must_keyword= array('number'=>$sim);
            $must_keyword = array('term'=>$must_keyword);
            $must['should'][] = $must_keyword;

            $query['bool'] = $must;
            $body['query'] = $query;

            $params = [
                'index' => 'fs',
                'type' => 'simsodep',
                'body' => $body
            ];

            // echo '<pre>',print_r($params['body'],1),'</pre>';
            $results = $client->search($params);
            $detail = $results['hits']['hits'][0]['_source'];
            // var_dump($detail['sim_id']);
            // echo '<pre>',print_r($detail,1),'</pre>';die;

        }

        // trường hợp tồn tại sim trong hệ thống
        if (@$detail && $detail['status'] == 0  && $detail['admin_status'] == 1  ) {
            $sim_list = array();
            $sim_list[$sim] = array(
                $detail['sim_id'],
                $detail['price_public'],
                $detail['number'],
                $detail['network'],
                $detail['cat_name'],
                $detail['point'],
                $detail['button'],
            );
            $_SESSION['cart'] = $sim_list;

            $type = FSInput::get('type', 'default');
            $this->model->type = $type;
            $model = $this -> model;
            $orderSims = $this->model->getSimsCart();
            foreach ($orderSims as $key) {
                $seo_sim = $key->sim;
                $seo_simkd = $key->number;
                $seo_price = $key->price_public;
                $seo_price = format_money($seo_price,'đ');
                $seo_network = $key->network;
                $seo_network = ucwords($seo_network);

                $seo_cat = $key->cat_name;
                $seo_cat = explode(',', $seo_cat);
                $seo_cat = $seo_cat[0];
                $seo_cat = str_replace('Sim ','', $seo_cat);
                $seo_cat = strtolower($seo_cat);

                $seo_head = substr($sim,0,3);

                switch (substr ( $sim, - 1 )) {
                    case '6':
                        $name_par = 'kim';
                        break;
                    case '7':
                        $name_par = 'kim';
                        break;
                    case '3':
                        $name_par = 'mộc';
                        break;
                    case '4':
                        $name_par = 'mộc';
                        break;
                    case '1':
                        $name_par = 'thủy';
                        break;
                    case '9':
                        $name_par = 'hỏa';
                        break;
                    case '2':
                        $name_par = 'thổ';
                        break;
                    case '5':
                        $name_par = 'thổ';
                        break;
                    case '8':
                        $name_par = 'thổ';
                        break;
                    default:
                        $name_par = '';
                        break;
                }

                $seo_par = $name_par;
            }
            if(!$_SESSION['cart']){
                $link = URL_ROOT;
                $msg = 'Không có sim trong giỏ hàng hoặc sim đã được đặt!';
                setRedirect($link,$msg);
            }

            $getCity = $this->model->getCity();
            $method = $model->get_records('published = 1','fs_typepay','id,title,type_id');
            global $tmpl;
            $breadcrumbs = array();
            // $breadcrumbs[] = array(0=>$sim_order->network,1=>URL_ROOT.strtolower($sim_order->network).'.html');
            $breadcrumbs[] = array(0=>$sim);

            $seo = $model->get_record('published = 1 AND module_seo = "sim"','fs_seo','title,keywords,description');
            // var_dump($seo);
            if ($seo) {
                $title = str_replace('#sim#',$seo_sim, $seo->title);
                $keywords = str_replace('#sim#',$seo_sim, $seo->keywords);
                $description = str_replace('#sim#',$seo_sim, $seo->description);
                // echo $seo_sim;
                $title = str_replace('#simkd#',$seo_simkd, $title);
                $keywords = str_replace('#simkd#',$seo_simkd, $keywords);
                $description = str_replace('#simkd#',$seo_simkd, $description);

                $title = str_replace('#gia#',$seo_price, $title);
                $keywords = str_replace('#gia#',$seo_price, $keywords);
                $description = str_replace('#gia#',$seo_price, $description);

                $title = str_replace('#mang#',$seo_network, $title);
                $keywords = str_replace('#mang#',$seo_network, $keywords);
                $description = str_replace('#mang#',$seo_network, $description);

                $title = str_replace('#theloai#',$seo_cat, $title);
                $keywords = str_replace('#theloai#',$seo_cat, $keywords);
                $description = str_replace('#theloai#',$seo_cat, $description);

                $title = str_replace('#menh#',$seo_par, $title);
                $keywords = str_replace('#menh#',$seo_par, $keywords);
                $description = str_replace('#menh#',$seo_par, $description);

                $title = str_replace('#dauso#',$seo_head, $title);
                $keywords = str_replace('#dauso#',$seo_head, $keywords);
                $description = str_replace('#dauso#',$seo_head, $description);

                $tmpl -> assign('title', $title);
                $tmpl -> assign('keywords', $keywords);
                $tmpl ->assign ( 'description', $description);
            }

            $tmpl -> assign('breadcrumbs', $breadcrumbs);
            require(PATH_BASE.'modules/' . $this->module . '/views/paynow/default.php');  
        }
        // trường hợp không tồn tại sim trong hệ thống
        else{

            $model = $this -> model;

            $key = substr ( $sim, - 6 );

            $params = array();
            $must = array();

            // trạng thái status mặc định là 0
            $must_status = array('status'=>'0');
            $must_status = array('term'=>$must_status);
            $must['must'][] = $must_status;
            // trạng thái status mặc định là 0
            $must_admin_status = array('admin_status'=>'1');
            $must_admin_status = array('term'=>$must_admin_status);
            $must['must'][] = $must_admin_status;

            $must_keyword= array('number'=>'*'.$key);
            $must_keyword = array('wildcard'=>$must_keyword);
            $must['must'][] = $must_keyword;

            $query['bool'] = $must;
            $body['query'] = $query;
            $body['size'] = 5;
            $body['from'] = 0;

            $params = [
                'index' => 'fs',
                'type' => 'simsodep',
                'body' => $body
            ];

            // echo '<pre>',print_r($params['body'],1),'</pre>';
            $results = $client->search($params);

            $list = $results['hits']['hits'];

            // var_dump($detail['sim_id']);
            // echo '<pre>',print_r($list,1),'</pre>';die;


            // $seo_sim = $key->sim;
            $seo_simkd = $sim;
            // $seo_price = $key->price_public;
            // $seo_price = format_money($seo_price,' đ');
            $net = $model->get_records('published = 1','fs_network','name,header');
            foreach ($net as $value) {
                if (in_array(substr($sim,0,3),explode(',',$value->header))) {
                    $seo_network = $value->name;
                }
            }
            $seo_cat = sim($seo_simkd);
            $seo_cat = explode(',', $seo_cat);
            $seo_cat = $seo_cat[0];
            $seo_cat = str_replace('Sim ','', $seo_cat);

            $seo_head = substr($sim,0,3);

            switch (substr ( $sim, - 1 )) {
                case '6':
                    $name_par = 'kim';
                    break;
                case '7':
                    $name_par = 'kim';
                    break;
                case '3':
                    $name_par = 'mộc';
                    break;
                case '4':
                    $name_par = 'mộc';
                    break;
                case '1':
                    $name_par = 'thủy';
                    break;
                case '9':
                    $name_par = 'hỏa';
                    break;
                case '2':
                    $name_par = 'thổ';
                    break;
                case '5':
                    $name_par = 'thổ';
                    break;
                case '8':
                    $name_par = 'thổ';
                    break;
                default:
                    $name_par = '';
                    break;
            }

            $seo_par = $name_par;

            $method = $model->get_records('published = 1','fs_typepay','id,title,type_id');
            global $tmpl;
            $breadcrumbs = array();
            $breadcrumbs[] = array(0=>'Kết quả tìm kiếm');

            $seo = $model->get_record('published = 1 AND module_seo = "no_sim"','fs_seo','title,keywords,description');

            if ($seo) {
                $title = str_replace('#sim#',$seo_sim, $seo->title);
                $keywords = str_replace('#sim#',$seo_sim, $seo->keywords);
                $description = str_replace('#sim#',$seo_sim, $seo->description);
                // echo $seo_sim;
                $title = str_replace('#simkd#',$seo_simkd, $title);
                $keywords = str_replace('#simkd#',$seo_simkd, $keywords);
                $description = str_replace('#simkd#',$seo_simkd, $description);

                $title = str_replace('#gia#',$seo_price, $title);
                $keywords = str_replace('#gia#',$seo_price, $keywords);
                $description = str_replace('#gia#',$seo_price, $description);

                $title = str_replace('#mang#',$seo_network, $title);
                $keywords = str_replace('#mang#',$seo_network, $keywords);
                $description = str_replace('#mang#',$seo_network, $description);

                $title = str_replace('#theloai#',$seo_cat, $title);
                $keywords = str_replace('#theloai#',$seo_cat, $keywords);
                $description = str_replace('#theloai#',$seo_cat, $description);

                $title = str_replace('#menh#',$seo_par, $title);
                $keywords = str_replace('#menh#',$seo_par, $keywords);
                $description = str_replace('#menh#',$seo_par, $description);

                $title = str_replace('#dauso#',$seo_head, $title);
                $keywords = str_replace('#dauso#',$seo_head, $keywords);
                $description = str_replace('#dauso#',$seo_head, $description);

                $tmpl -> assign('title', $title);
                $tmpl -> assign('keywords', $keywords);
                $tmpl ->assign ( 'description', $description);
            }

            $tmpl -> assign('breadcrumbs', $breadcrumbs);
            require(PATH_BASE.'modules/' . $this->module . '/views/paynow/no_sim.php');
        }
    }

    function msim(){
        $sim = FSInput::get('sim');

        $client = ClientBuilder::create()->setHosts($hosts)->build();

        if ($sim) {

            $must_keyword= array('number'=>$sim);
            $must_keyword = array('term'=>$must_keyword);
            $must['should'][] = $must_keyword;

            $query['bool'] = $must;
            $body['query'] = $query;

            $params = [
                'index' => 'fs',
                'type' => 'simsodep',
                'body' => $body
            ];

            // echo '<pre>',print_r($params['body'],1),'</pre>';
            $results = $client->search($params);
            $detail = $results['hits']['hits'][0]['_source'];
            // var_dump($detail['sim_id']);
            // echo '<pre>',print_r($detail,1),'</pre>';die;

        }

        // trường hợp tồn tại sim trong hệ thống
        if (@$detail && $detail['status'] == 0  && $detail['admin_status'] == 1  ) {
            $sim_list = array();
            $sim_list[$sim] = array(
                $detail['sim_id'],
                $detail['price_public'],
                $detail['number'],
                $detail['network'],
                $detail['cat_name'],
                $detail['point'],
                $detail['button'],
            );
            $_SESSION['cart'] = $sim_list;

            $type = FSInput::get('type', 'default');
            $this->model->type = $type;
            $model = $this -> model;
            $orderSims = $this->model->getSimsCart();
            foreach ($orderSims as $key) {
                $seo_sim = $key->sim;
                $seo_simkd = $key->number;
                $seo_price = $key->price_public;
                $seo_price = format_money($seo_price,'đ');
                $seo_network = $key->network;
                $seo_network = ucwords($seo_network);

                $seo_cat = $key->cat_name;
                $seo_cat = explode(',', $seo_cat);
                $seo_cat = $seo_cat[0];
                $seo_cat = str_replace('Sim ','', $seo_cat);
                $seo_cat = strtolower($seo_cat);

                $seo_head = substr($sim,0,3);

                switch (substr ( $sim, - 1 )) {
                    case '6':
                        $name_par = 'kim';
                        break;
                    case '7':
                        $name_par = 'kim';
                        break;
                    case '3':
                        $name_par = 'mộc';
                        break;
                    case '4':
                        $name_par = 'mộc';
                        break;
                    case '1':
                        $name_par = 'thủy';
                        break;
                    case '9':
                        $name_par = 'hỏa';
                        break;
                    case '2':
                        $name_par = 'thổ';
                        break;
                    case '5':
                        $name_par = 'thổ';
                        break;
                    case '8':
                        $name_par = 'thổ';
                        break;
                    default:
                        $name_par = '';
                        break;
                }

                $seo_par = $name_par;
            }
            // var_dump($orderSims);die;
            if(!$_SESSION['cart']){
                $link = URL_ROOT;
                $msg = 'Không có sim trong giỏ hàng hoặc sim đã được đặt!';
                setRedirect($link,$msg);
            }

            $getCity = $this->model->getCity();
            $method = $model->get_records('published = 1','fs_typepay','id,title,type_id,content');
            global $tmpl;
            $breadcrumbs = array();
            // $breadcrumbs[] = array(0=>$sim_order->network,1=>URL_ROOT.strtolower($sim_order->network).'.html');
            $breadcrumbs[] = array(0=>$sim);

            $seo = $model->get_record('published = 1 AND module_seo = "sim"','fs_seo','title,keywords,description');

            if ($seo) {
                $title = str_replace('#sim#',$seo_sim, $seo->title);
                $keywords = str_replace('#sim#',$seo_sim, $seo->keywords);
                $description = str_replace('#sim#',$seo_sim, $seo->description);
                // echo $seo_sim;
                $title = str_replace('#simkd#',$seo_simkd, $title);
                $keywords = str_replace('#simkd#',$seo_simkd, $keywords);
                $description = str_replace('#simkd#',$seo_simkd, $description);

                $title = str_replace('#gia#',$seo_price, $title);
                $keywords = str_replace('#gia#',$seo_price, $keywords);
                $description = str_replace('#gia#',$seo_price, $description);

                $title = str_replace('#mang#',$seo_network, $title);
                $keywords = str_replace('#mang#',$seo_network, $keywords);
                $description = str_replace('#mang#',$seo_network, $description);

                $title = str_replace('#theloai#',$seo_cat, $title);
                $keywords = str_replace('#theloai#',$seo_cat, $keywords);
                $description = str_replace('#theloai#',$seo_cat, $description);

                $title = str_replace('#menh#',$seo_par, $title);
                $keywords = str_replace('#menh#',$seo_par, $keywords);
                $description = str_replace('#menh#',$seo_par, $description);

                $tmpl -> assign('title', $title);
                $tmpl -> assign('keywords', $keywords);
                $tmpl ->assign ( 'description', $description);
            }

            $tmpl -> assign('breadcrumbs', $breadcrumbs);
            require(PATH_BASE.'modules/' . $this->module . '/views/paynow/default_mobile.php');  
        }
        // trường hợp không tồn tại sim trong hệ thống
        else{

            $model = $this -> model;

            $key = substr ( $sim, - 6 );

            $params = array();
            $must = array();
            
            // trạng thái status mặc định là 0
            $must_status = array('status'=>'0');
            $must_status = array('term'=>$must_status);
            $must['must'][] = $must_status;
            // trạng thái status mặc định là 0
            $must_admin_status = array('admin_status'=>'1');
            $must_admin_status = array('term'=>$must_admin_status);
            $must['must'][] = $must_admin_status;

            $must_keyword= array('number'=>'*'.$key);
            $must_keyword = array('wildcard'=>$must_keyword);
            $must['must'][] = $must_keyword;

            $query['bool'] = $must;
            $body['query'] = $query;
            $body['size'] = 5;
            $body['from'] = 0;

            $params = [
                'index' => 'fs',
                'type' => 'simsodep',
                'body' => $body
            ];

            // echo '<pre>',print_r($params['body'],1),'</pre>';
            $results = $client->search($params);

            $list = $results['hits']['hits'];

            // var_dump($detail['sim_id']);
            // echo '<pre>',print_r($list,1),'</pre>';die;


            // $seo_sim = $key->sim;
            $seo_simkd = $sim;
            // $seo_price = $key->price_public;
            // $seo_price = format_money($seo_price,' đ');
            $net = $model->get_records('published = 1','fs_network','name,header');
            foreach ($net as $value) {
                if (in_array(substr($sim,0,3),explode(',',$value->header))) {
                    $seo_network = $value->name;
                }
            }
            $seo_cat = sim($seo_simkd);
            $seo_cat = explode(',',$seo_cat);
            $seo_cat = $seo_cat[0];
            $seo_cat = str_replace('Sim ','', $seo_cat);
            $seo_cat = strtolower($seo_cat);

            $seo_head = substr($sim,0,3);

            switch (substr ( $sim, - 1 )) {
                case '6':
                    $name_par = 'kim';
                    break;
                case '7':
                    $name_par = 'kim';
                    break;
                case '3':
                    $name_par = 'mộc';
                    break;
                case '4':
                    $name_par = 'mộc';
                    break;
                case '1':
                    $name_par = 'thủy';
                    break;
                case '9':
                    $name_par = 'hỏa';
                    break;
                case '2':
                    $name_par = 'thổ';
                    break;
                case '5':
                    $name_par = 'thổ';
                    break;
                case '8':
                    $name_par = 'thổ';
                    break;
                default:
                    $name_par = '';
                    break;
            }

            $seo_par = $name_par;

            $method = $model->get_records('published = 1','fs_typepay','id,title,type_id');
            global $tmpl;
            $breadcrumbs = array();
            $breadcrumbs[] = array(0=>'Kết quả tìm kiếm');

            $seo = $model->get_record('published = 1 AND module_seo = "no_sim"','fs_seo','title,keywords,description');

            if ($seo) {
                $title = str_replace('#sim#',$seo_sim, $seo->title);
                $keywords = str_replace('#sim#',$seo_sim, $seo->keywords);
                $description = str_replace('#sim#',$seo_sim, $seo->description);
                // echo $seo_sim;
                $title = str_replace('#simkd#',$seo_simkd, $title);
                $keywords = str_replace('#simkd#',$seo_simkd, $keywords);
                $description = str_replace('#simkd#',$seo_simkd, $description);

                $title = str_replace('#gia#',$seo_price, $title);
                $keywords = str_replace('#gia#',$seo_price, $keywords);
                $description = str_replace('#gia#',$seo_price, $description);

                $title = str_replace('#mang#',$seo_network, $title);
                $keywords = str_replace('#mang#',$seo_network, $keywords);
                $description = str_replace('#mang#',$seo_network, $description);

                $title = str_replace('#theloai#',$seo_cat, $title);
                $keywords = str_replace('#theloai#',$seo_cat, $keywords);
                $description = str_replace('#theloai#',$seo_cat, $description);

                $title = str_replace('#menh#',$seo_par, $title);
                $keywords = str_replace('#menh#',$seo_par, $keywords);
                $description = str_replace('#menh#',$seo_par, $description);

                $tmpl -> assign('title', $title);
                $tmpl -> assign('keywords', $keywords);
                $tmpl ->assign ( 'description', $description);
            }

            $tmpl -> assign('breadcrumbs', $breadcrumbs);
            require(PATH_BASE.'modules/' . $this->module . '/views/paynow/m_no_sim.php');
        }
    }

    function save_order(){
        // var_dump(1);die;
        $model = $this -> model;
        
        $rs  = $model -> save_order();
        if($rs){
            unset($_SESSION['cart']);
            unset($_SESSION['arr_cart']);
            $_SESSION['order_id'] = $rs;
            $link = FSRoute::_('index.php?module=paynow&view=paynow&task=success&Itemid=31');
            $msg = 'Đặt sim thành công';
            setRedirect($link);
        }
        else {
            $link = URL_ROOT;
            $msg = 'Xin lỗi quý khách, sim quý khách đặt đã bán hoặc không còn tồn tại trong hệ thống!';
            setRedirect($link,$msg);  
        }
    }

    function msave_order(){
        // var_dump(1);die;
        $model = $this -> model;
        
        $rs  = $model -> save_order();
        
        if($rs){
            unset($_SESSION['cart']);
            unset($_SESSION['arr_cart']);
            $_SESSION['order_id'] = $rs;
            $link = URL_ROOT.'?success=1&id_order='.$rs;
            $msg = 'Đặt sim thành công';
            setRedirect($link);
        }
        else {
            $link = URL_ROOT;
            $msg = 'Xin lỗi quý khách, sim quý khách đặt đã bán hoặc không còn tồn tại trong hệ thống!';
            setRedirect($link,$msg); 
        }
    }

    function success(){
        $id = $_SESSION['order_id'];
        if (!$id) {
            $link = URL_ROOT;
                setRedirect($link);
        }
        $model = $this -> model;
        $order = $model->get_record('id ="'.$id.'"','fs_order','*');
        $list = $model->get_order_item($id);
        $method = $model->get_record('id ='.$order->payment_method,'fs_typepay','title,content');
        // var_dump($list);die;
        require(PATH_BASE.'modules/' . $this->module . '/views/paynow/success.php');
    }

    function delete_session_cart(){
        unset($_SESSION['order_id']);
    }

    function get_method(){
        $id= FSInput::get('id');
        $model = $this -> model;
        $method = $model->get_record('id ="'.$id.'"','fs_typepay','content');
        $json = array(
            'html' => ''
        );
        $json['html'] = $method->content;

        echo json_encode($json);
    }

    function get_member()
    {
        $model = $this -> model;

        $code= FSInput::get('code');
        $total= FSInput::get('total');
        

        $json = array(
            'total_original' => '',
            'total' => '',
            'string' => '',
            'telephone' => '',
            'email' => '',
            'address' => '',
            'string' => '',
            'name' => '',
            'discount' => '',
            'city' => '',
            'city_name' => '',
            'position' => '',
            'position_name' => '',
            'gift' => '',
            "id"=>'',
            "code"=>'',
            "discount_unit"=>'',
            "discount_original"=>'',
        );

        $json['code'] = $code;

        $member = $model->get_mem();
        $hsd = strtotime($member->day);
        $time = date("Y-m-d");
        $time_now = strtotime($time);
        if ($hsd < $time_now) {
            $member = '';
        }

        $discount = '0%';

        $number = format_money($total);
        $string = ucfirst(convert_number_to_words($total));
        if ($member) {
            $price = $model->get_records('price_id ="'.$member->position.'"','fs_member_commissions','*');
            // var_dump($price);die;
            if ($price) {
                foreach ($price as $item) {
                    if ($total >= $item->price_f && $total< $item->price_t) {
                        $discount = $item->commission;
                        $discount_original = $discount;
                        // echo $item->commission_unit;die;
                        if ($item->commission_unit == 'percent') {
                            $total = $total - $total*$discount/100;
                            $number = format_money($total);
                            $string = ucfirst(convert_number_to_words($total));
                            $discount = $item->commission.'%';
                            $unit = 'percent';
                        }elseif ($item->commission_unit == 'price') {
                            $total = $total - $discount;
                            $number = format_money($total);
                            $string = ucfirst(convert_number_to_words($total));
                            $discount = format_money($item->commission);
                            $unit = 'price';
                        }
                    }
                }
            }

            $json['discount_original'] = $discount_original;
            $json['total_original'] = $total;
            $json['total_original'] = $total;
            $json['total'] = $number;
            $json['string'] = $string;
            $json['name'] = $member->name;
            $json['telephone'] = $member->telephone;
            $json['email'] = $member->email;
            $json['address'] = $member->address;
            $json['discount'] = $discount;
            $json['city'] = $member->city;
            $json['city_name'] = $member->city_name;
            $json['position'] = $member->position;
            $json['position_name'] = $member->position_name;
            $json['gift'] = $member->gift;
            $json['id'] = $member->id;
            $json['discount_unit'] = $unit;

        }

        $vocher = $model->get_record('published = 1 AND code ="'.$code.'"','fs_discount','*');
        // var_dump($vocher);die;
        if ($vocher) {
            $date = date('Y/m/d');
            $date = strtotime($date);
            $tdate = strtotime($vocher->date_start);
            $fdate = strtotime($vocher->date_end);
            $check_date = 1;
            if ($date < $tdate || $date > $fdate) {
                $check_date = 0;
            }

            if ($check_date ==1) {
                $discount = $vocher->discount;
                $discount_original = $discount;
                if ($vocher->unit == 2) {
                    $total = $total - $total*$discount/100;
                    $number = format_money($total);
                    $string = ucfirst(convert_number_to_words($total));
                    $discount = $discount.'%';
                    $unit = 'percent';
                }elseif ($vocher->unit == 1) {
                    $total = $total - $discount;
                    $number = format_money($total);
                    $string = ucfirst(convert_number_to_words($total));
                    $discount = format_money($discount);
                    $unit = 'price';
                }
                $json['discount_original'] = $discount_original;
                $json['total_original'] = $total;
                $json['total'] = $number;
                $json['string'] = $string;
                $json['discount'] = $discount;
                $json['position_name'] = $vocher->name;
                $json['discount_unit'] = $unit;
            }
        }

        echo json_encode($json);

    } 

    function mdisplay(){
        global $arrProductLine;
        $type = FSInput::get('type', 'default');
        $this->model->type = $type;
        if(!$_SESSION['cart']){
            $link = URL_ROOT;
            $msg = 'Không có sim trong giỏ hàng hoặc sim đã được đặt!';
            setRedirect($link,$msg);
        }
        // $orderSims = $_SESSION['cart'];
        $orderSims = $this->model->getSimsCart();
        // var_dump($orderSims);die;
        $getCity = $this->model->getCity();
        $model = $this -> model;
        $method = $model->get_records('published = 1','fs_typepay','id,title,type_id');
        $id_order = FSInput::get('id');
        global $tmpl;
        $breadcrumbs = array();
        $breadcrumbs[] = array(0=>'Thanh toán', 1=>'');
        $tmpl -> assign('breadcrumbs', $breadcrumbs);
        require(PATH_BASE.'modules/' . $this->module . '/views/paynow/default_mobile.php');
    }
    function pdf_success_old(){
        $id = FSInput::get('id');
        $order = $this->model->detailOrder($id);

        $order_item = $this->model->orderItem($id);

        $table = '<tbody>';
        foreach ($order_item as $item){
            $detail_sim = $this->model->detail_sim($item->product_id);
            $ar_type = explode(',',trim($detail_sim->cat_name, ','));
            $ar_type_name = $ar_type[0];
            $table.='<tr>';
                $table.='<td>';
                $table.=$item->sim;
                $table.='</td>';

                $table.='<td>';
                $table.=$detail_sim->network;
                $table.='</td>';

                $table.='<td>';
                $table.=$ar_type_name;
                $table.='</td>';

                $table.='<td>';
                $table.=$detail_sim->point;
                $table.='</td>';

                $table.='<td>';
                $table.=date('d/m/y   H:s',strtotime($item->time_create));
                $table.='</td>';

                $table.='<td>';
                $table.=format_money($item->price_public,' đ');
                $table.='</td>';

            $table.='<tr>';
        }
        $table.="</tbody>";

        $discount = '0%';
        $gift = '';
        $d_name = '';
        if ($order->discount_unit == 'price') {
            $discount = format_money($order->discount_value,' đ');
        }
        if ($order->discount_unit == 'percent') {
            $discount = $order->discount_value.'%';
        }
        if ($order->discount_name) {
            $d_name = ' - '.$order->discount_name;
        }
        if ($order->gift) {
            $gift = ' và '.$order->gift;
        }
        $promotion = $discount.$d_name.$gift;
        $method = $this->model->get_record('id ='.$order->payment_method,'fs_typepay','title,content');
        $list = $this->model->get_order_item($id);
        global $config;
        $content2 = '
            <div class="container company-bill">
                <div class="row">
                    <div class="col-md-4 img-logo">
                        <a href="<?php echo URL_ROOT?>"><img src="'.$config['logo'].'" alt=""></a>
                    </div>
                    <div class="col-md-8 infor-company">
                        <h1>
                            <strong>
                                <span">CÔNG TY TNHH TM DV VIỄN THÔNG AN PHÚ LỘC<br />MST: 0313891354</span>
                            </strong>
                        </h1>
                        
                        <p>Địa chỉ: 486 Nguyễn Kiệm, P.3, Q.Phú Nhuận, Tp.HCM&nbsp;<br />
                            Cửa hàng Viettel: 176 Đồng Đen, P.14, Q.Tân Bình, Tp.HCM&nbsp;&nbsp;<br />
                            Hotline: 0984.747.747 - 0937.486.486 - 0911.486.486 - 0997.456789&nbsp;<br />
                            Email: simdeptructuyen@gmail.com&nbsp;<br />
                            Website: Simsodepgiare.vn - Simsodepgiare.com.vn
                        </p>
                    </div>
                    <div class="clear-fix"></div>
                </div>
            </div>
            <div class="container content-bill">
                <div class="infor-customer">
                    <p class="fl-right">Đơn đặt hàng ngày: '.date("d/m/y H:s",strtotime($order->created_time)).'</p>
                    <table>
                        <tr>
                            <td>Mã đơn hàng<span>:</span></td>
                            <td>'.$order->code.'</td>
                        </tr>
                        <tr>
                            <td>Khách hàng<span>:</span></td>
                            <td>'.$order->recipients_name.'</td>
                        </tr>
                        <tr>
                            <td>Số điện thoại<span>:</span></td>
                            <td>'.$order->recipients_mobilephone.'</td>
                        </tr>
                        <tr>
                            <td>Địa chỉ<span>:</span></td>
                            <td>'.$order->recipients_address.'</td>
                        </tr>
                        <tr>
                            <td>Email<span>:</span></td>
                            <td>'.$order->recipients_email.'</td>
                        </tr>
                        <tr>
                            <td>Ghi chú <span>:</span></td>
                            <td>'.$order->recipients_comments.'</td>
                        </tr>
                    </table>
                </div>
                <div class="table-order">
                    <table class="table table-default">
                        <thead>
                            <tr>
                                <th scope="col"><span>Số sim</span></th>
                                <th scope="col"><span>Nhà mạng</span></th>
                                <th scope="col"><span>Thể loại</span></th>
                                <th scope="col"><span>Điểm</span></th>
                                <th scope="col"><span>Ngày cập nhật</span></th>
                                <th scope="col"><span>Giá tiền</span></th>
                            </tr>
                        </thead>
                        '.$table.'
                    </table>
                </div>
            </div>
            <div class="box-total">
                <table>
                    <tr>
                        <td>Tổng cộng<span>:</span></td>
                        <td>'.format_money($order->total_before,' đ').'</td>
                    </tr>
                    <tr>
                        <td>Khuyến mãi<span>:</span></td>
                        <td>'.$promotion.'</td>
                    </tr>  
                    <tr>
                        <td>Tổng thanh toán<span>:</span></td>
                        <td>'.format_money($order->total_end,' đ').' ('.ucfirst(convert_number_to_words($order->total_end)).' đồng)</td>
                    </tr>
                </table>
            </div>
            <div class="bill-note">
                <p class="top">Hình thức thanh toán:  <span>'.$method->title.'</span></p>
                '.$method->content.'
            </div>
            <footer class="container footer-bill">
                '.$config['footer_bill'].'
            </footer>
            <style>
                @font-face {
                    font-family: Text-Bold;
                    src: url("../assets/fonts/Roboto-Bold.ttf");
                    font-weight:100;
                    font-style:normal;
                }     
                
                 .company-bill{
                    border-bottom: 2px solid #d8d7d7;  
                 }
                 .company-bill .img-logo{
                    width: 40%;   
                    float: left;
                 }   
                 .company-bill .img-logo img{
                    width: 100%;
                 }
                 .infor-company{   
                    width: 60%;
                    float: left;     
                 }     
                 .clear-fix{  
                    clear: both;
                    display: block;
                 }
                 .table-default{
                    border-collapse: collapse;
                    width: 100%;
                    color: #fffffF;
                 }
                 .table-default thead{
                    background: #3478f7;
                    text-align: center;
                    font-size: 15px;   
                 }
                 .table-default th{
                    height: 48px; 
                 }         
                 .table-default tbody{   
                    color: #0a001f;  
                    text-align: center;
                 }
                 .table-default tbody tr{         
                    border: 1px solid #d8d7d7;   
                    height: 46px;
                    border-top: 0px;
                 }
                 .table-default tbody tr td{         
                    border-bottom: 1px solid #d8d7d7;
                    color: #333333;  

                 }    
                 .infor-customer{
                    position: relative;
                 }
                 .infor-customer td:nth-child(1){
                   width: 130px;
                   font-weight: normal;
                 }
                 .infor-customer td:nth-child(2){
                   font-weight: bold;
                   font-size: 12px;    
                 }
                     
                 .infor-customer td span{
                   float: right;    
                 }
                 .fl-right{
                    right: 0px; 
                    position: absolute;
                 }
                 .table-order thead span{
                     padding: 5px 30px;
                    width: 100%;
                    background: #0253ea;
                    color: #ffffff;
                    border-radius: 25%;
                    font-weight: normal;
                    white-space: nowrap;  
                 }
                 
                 .box-total{
                    margin-top: 30px;
                    padding: 18px 20px 18px 26px;
                    background: #f3f3f3;
                    border: none;
                 }
                 .box-total table td:nth-child(1){
                    width: 130px;
                    vertical-align: top;   
                 }
                 .box-total table td:nth-child(1) span{
                    float: right;
                 } 
                 .box-total table td:nth-child(2){
                    font-weight: bold;   
                    font-style: italic;    
                    font-size: 12px;  
                 }      
                 .bill-note .top span{
                    font-weight: bold;
                 }       
                  .footer-bill{   
                    border-top:3px solid #d8d7d7;
                    padding-top: 30px;    
                  } 
                  .footer-bill .title-hea{   
                    text-transform: uppercase;
                    
                  }  
                 
            </style>  
        ';


        require(PATH_BASE.'modules/' . $this->module . '/views/paynow/pdf_success.php');
    }
    function pdf_success(){
        $id = FSInput::get('id');
        if (!$id) {
            $link = URL_ROOT;
                setRedirect($link);
        }
        $order = $this->model->detailOrder($id);

        $order_item = $this->model->orderItem($id);


        $discount = '0%';
        $gift = '';
        $d_name = '';
        if ($order->discount_unit == 'price') {
            $discount = format_money($order->discount_value,' đ');
        }
        if ($order->discount_unit == 'percent') {
            $discount = $order->discount_value.'%';
        }
        if ($order->discount_name) {
            $d_name = ' - '.$order->discount_name;
        }
        if ($order->gift) {
            $gift = ' và '.$order->gift;
        }
        $promotion = $discount.$d_name.$gift;
        $method = $this->model->get_record('id ='.$order->payment_method,'fs_typepay','title,content');
        $list = $this->model->get_order_item($id);
        require(PATH_BASE.'modules/' . $this->module . '/views/paynow/success_export.php');
    }

    function mpdf_success(){
        $id = FSInput::get('id');
        if (!$id) {
            $link = URL_ROOT;
                setRedirect($link);
        }
        $order = $this->model->detailOrder($id);

        $order_item = $this->model->orderItem($id);


        $discount = '0%';
        $gift = '';
        $d_name = '';
        if ($order->discount_unit == 'price') {
            $discount = format_money($order->discount_value,' đ');
        }
        if ($order->discount_unit == 'percent') {
            $discount = $order->discount_value.'%';
        }
        if ($order->discount_name) {
            $d_name = ' - '.$order->discount_name;
        }
        if ($order->gift) {
            $gift = ' và '.$order->gift;
        }
        $promotion = $discount.$d_name.$gift;
        $method = $this->model->get_record('id ='.$order->payment_method,'fs_typepay','title,content');
        $list = $this->model->get_order_item($id);
        require(PATH_BASE.'modules/' . $this->module . '/views/paynow/success_export.php');

    }




    function api_pdf_export(){
        $id = $_SESSION['order_id'];
        if (!$id) {
            $link = URL_ROOT;
                setRedirect($link);
        }
        $data = [
            'url' => "https://simsodepgiare.com.vn/export-$id.html",
            'apiKey' => 'a68a5a430c6bc6e6310ad38b8df6bc218244a4d236af3bd4399a24e252c3fe8c',
        ];

        $dataString = json_encode($data);

        $ch = curl_init('https://api.html2pdf.app/v1/generate');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);

        $response = curl_exec($ch);
        $err = curl_error($ch);

        curl_close($ch);

        if ($err) {
            echo 'Error #:' . $err;
        } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="don-hang-'.$id.'.pdf"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            echo $response;
        }
    }
}