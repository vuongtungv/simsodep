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

class PaynowModelsPaynow extends FSModels{
    var $type;
    var $where;

    function __construct(){
        global $config;
        parent::__construct();
		$this->table_name  = FSTable::_('fs_products_vulcano_fashion');
		$this->table_category  = FSTable::_('fs_products_categories');
//        $this->limit = intval($config['number_product']);
        $limit = FSInput::get('limit');
        if(empty($limit)){
            $limit = 30;
        }
        $this->limit = $limit;
        $this->type = 'default';
    }
    function get_order_item($id)
    {
        $query = "  SELECT fs_order_items.id,fs_order_items.sim,fs_order_items.price_public,fs_order_items.time_create,fs_sim.network,fs_sim.cat_name,fs_sim.point
                        FROM fs_order_items
                        INNER JOIN fs_sim
                        ON fs_order_items.product_id = fs_sim.id WHERE fs_order_items.order_id = ".$id;
        global $db;
        $db->query($query);
        return $db->getObjectlist();
    }
    function getSimsCart(){
        $listProduct = array();
        if(!isset($_SESSION['cart']))
            return false;
        foreach($_SESSION['cart'] as $item){
            $product = $this->getSim($item[0]);
            $product->quantity  = $item[1];
            $product->releases  = false;
            $product->info = $item[2];
            $listProduct[] = $product;
        }
        return $listProduct;
    }

    function get_mem()
    {
        $code= FSInput::get('code');
        $query = "  SELECT fs_members.*,fs_position.gift
                    FROM fs_members
                    INNER JOIN fs_position
                    ON fs_members.position = fs_position.id WHERE fs_members.published = 1 AND fs_members.code ='".$code."';";
        global $db;
        $db->query($query);
        return $db->getObject();
    }  

    function getSim($product_id = 0)
    {
        $query = "  SELECT id,sim,number,price_public,price,created_time,network,point,cat_name,button
                    FROM fs_sim 
                    WHERE id = ".intval($product_id);
        global $db;
        $db->query($query);
        return $db->getObject();
    } 

    function save_order(){
        $str_id = ',';
        $str_phone = '';
        $str_number = '';
        // var_dump($_SESSION['cart']);die;
        foreach($_SESSION['cart'] as $item){
            $exit = $this -> get_record('admin_status = 1 AND id ='.$item[0],'fs_sim');  
            if ($exit) {
                $list_id[] = $item[0];
                $str_id .= $item[0].',';
                $str_phone .= $item[2].';';
                $str_number .= str_replace('.','',$item[2]).';';
            }
        }
        $str_id = trim($str_id,',');
        $str_phone = trim($str_phone,';');
        $str_number = trim($str_number,';');
        // var_dump($list_id);die;

        $phone = FSInput::get('deprecate_phone');
        $select_city = FSInput::get('select-city');
        $address = FSInput::get('deprecate_address');
        $name = FSInput::get('deprecate_name');
        $email = FSInput::get('deprecate_email');
        $deposit = FSInput::get('deposit');
        $pay = FSInput::get('select-paymethod');
        $note = FSInput::get('comment');
        $totalmoney = FSInput::get('totalmoney');
        $totalafter = FSInput::get('totalafter');

        $code = FSInput::get('code');
        $discount = FSInput::get('discount');
        $discount_unit = FSInput::get('discount_unit');
        $discount_name = FSInput::get('discount_name');
        $gift = FSInput::get('gift');

        $time = date("Y-m-d H:i:s");

        if(!$list_id)
            return;
        global $db;
        
        //Lưu thông tin khách hàng
        $row['member_level_name'] = 'Khách vãng lai';
        $row['member_level'] = '99';
        $member = $this -> get_record(' telephone ='.$phone,'fs_members','id,position,position_name,discount,code');
        if (@$member) {
            $row['member_level'] = $member->position;
            $row['member_level_name'] = $member->position_name;
            $row['member_id'] = $member->id;
            $row['member_code'] = $member->code;
        }
        
        // Lưu thông tin đơn hàng
        $row['list_sim'] = $str_phone;
        $row['list_number'] = $str_number;
        $row['recipients_name'] = $name;
        $row['recipients_email'] = $email;
        $row['deposit_method'] = $deposit;
        $row['payment_method'] = $pay;
        $row['recipients_comments'] = $note;
        $row['recipients_mobilephone'] = $phone;
        $row['recipients_address'] = $address;
        $row['products_id'] = $str_id;
        $row['created_time'] = $time;
        $row['total_before'] = $totalmoney;
        $row['total_after'] = $totalmoney;
        $row['total_end'] = $totalafter;

        $row['discount_code'] = $code;
        $row['discount_unit'] = $discount_unit;
        $row['discount_value'] = $discount;
        $row['discount_name'] = $discount_name;
        $row['gift'] = $gift;

        $city = $this->get_record('published = 1 AND id = '.$select_city,'fs_cities','id,name');
        if ($city) {
            $row['recipients_city'] = $city->id;
            $row['recipients_city_name'] = $city->name;
        }

        // $row['user_id'] = $_SESSION['ad_userid'];
        // $row['username'] = $_SESSION['ad_username'];
        $row['status'] = 9;
        // var_dump($row);die;


        $rs = $this -> _add($row, 'fs_order');

        $code_dh = 'DH'.str_pad($rs, 8 , "0", STR_PAD_LEFT);
        $query = " UPDATE fs_order set code = '".$code_dh."' WHERE id = ".$rs;
        $db->query($query);
        $rs2 = $db->affected_rows();

        if(!$rs)
            return false;

        $client = ClientBuilder::create()->setHosts($hosts)->build();

        //Lưu dữ liệu từng sim
        foreach ($list_id as $key) {
            if (!$key) {
                continue;
            }

            $product = $this -> get_record('admin_status = 1 AND status = 0 AND id ='.$key,'fs_sim');

            if (!$product) {


                $query = " DELETE FROM fs_order WHERE id = ".$rs;
                $db->query($query);
                $db->affected_rows();

                return false;

                // $str_phone = str_replace($product->sim,'',$str_phone);
                // $str_number = str_replace($product->number,'',$str_number);
                // $str_id = str_replace($product->id,'',$str_id);

                // $totalmoney = $totalmoney - $product->price_public;
                // $totalafter = $totalafter - $product->price_public;

                // continue;
            }
            $agency = $this->get_record('published = 1 AND type = 2 AND id = '.$product->agency,'fs_users');
            if ($agency) {
                $agency_city = $this->get_record('published = 1 AND id = '.$agency->city,'fs_cities','id,name');

                $row_item['agency_id'] = $agency->id;
                $row_item['agency_name'] = $agency->full_name;
                $row_item['agency_phone'] = $agency->phone;
                $row_item['agency_web'] = $agency->web;
                $row_item['agency_city'] = $agency_city->name;
            }

            $row_item['order_id'] = @$rs;
            $row_item['time_create'] = $product->created_time;
            $row_item['time_order'] = $time;
            $row_item['product_id'] = $product->id;
            $row_item['sim'] = $product->sim;
            $row_item['number'] = $product->number;

            // Thông tin khuyến mại
            $row_item['discount'] = $discount;
            if ($discount_unit == 'price') {
                $row_item['discount'] = $discount/count($list_id);
            }
            $row_item['discount_code'] = $code;
            $row_item['discount_unit'] = $discount_unit;
            $row_item['discount_name'] = $discount_name;
            $row_item['gift'] = $gift;


            // Giá đại lý
            $row_item['price'] = $product->price;
            // chiết khấu vnd
            $row_item['commission'] = $product->commission_value;
            // chiết khấu %
            $row_item['commission_percent'] = $product->commission_value/$product->price*100;
            // Giá thu về = gía đại lý - chiết khấu
            $price_recive = $product->price - $product->commission_value;
            // Giá cuối = giá bán - giảm giá
            $price_end = $product->price_public;
            if (@$discount_unit == 'price') {
                $price_end = $product->price_public - $row_item['discount'];
            }
            if (@$discount_unit == 'percent') {
                $price_end = $product->price_public - $row_item['discount']*$product->price_public/100;
                $price_end = round($price_end);
            }
            // tiền lãi = giá cuối - giá thu về
            $interest = $price_end - $price_recive;

            $row_item['price_public'] = $product->price_public;
            $row_item['price_sell'] = $price_recive;
            $row_item['price_end'] = $price_end;
            $row_item['interest'] = $interest;

            // var_dump($row_item);die;
            $item_id = $this -> _add($row_item, 'fs_order_items');


            //cập nhật trạng thái sim

            $must = array();

            $must_item = array('_id'=>$agency->id.'-'.$product->number);
            $must_arr = array('term'=>$must_item);
            $must['must'][] = $must_arr;

            $query_es['bool'] = $must;
            $body['query'] = $query_es;
            $body['script'] = [
                'source' => 'ctx._source.status  = params.value',
                'params' => [
                    'value' => 3
                ]
            ];
            $params = [
                'index' => 'fs',
                'type' => 'simsodep',
                'body' => $body
            ];


            // echo '<pre>',print_r($params['body'],1),'</pre>';

            $results = $client->updateByQuery($params);

            if ($item_id) {
                $query = " UPDATE fs_sim set status = '3' WHERE id = ".$key;
                $db->query($query);
                $rows = $db->affected_rows();
            }

        }
        // die;
        // var_dump($list_id);die;
        // lịch sử đơn hàng
        $row_history['order_id'] = $rs;
        $row_history['time'] = $time;
        $row_history['status'] = 9;
        $row_history['name_status'] = 'Tạo đơn hàng';
        // $row_history['user_id'] = $_SESSION['ad_userid'];
        // $row_history['username'] = $_SESSION['ad_username'];
        $history_id = $this -> _add($row_history, 'fs_order_history');
 
        return $rs;
    }

    function standart_money($money){
        $money = str_replace(',','' , trim($money));
        $money = str_replace(' ','' , $money);
        $money = str_replace('.','' , $money);
//      $money = intval($money);
        // $money = (double)($money);
        return $money; 
    }
    function getCity(){
        global $db;
        $query = "SELECT id,name FROM fs_cities ORDER BY ordering ASC";
        $sql = $db->query($query);
        $rel = $db->getObjectList();
        return $rel;
    }

    function detailOrder($id){
        global $db;
        $query = "SELECT * FROM fs_order WHERE id = $id";
        $sql = $db->query($query);
        $rel = $db->getObject();
        return $rel;
    }
    function orderItem($id){
        global $db;
        $query = "SELECT * FROM fs_order_items WHERE id = $id";
        $sql = $db->query($query);
        $rel = $db->getObjectList();
        return $rel;
    }
    function detail_sim($id){
        global $db;
        $query = "SELECT * FROM fs_sim WHERE id = $id";
        $sql = $db->query($query);
        $rel = $db->getObject();
        return $rel;
    }


}