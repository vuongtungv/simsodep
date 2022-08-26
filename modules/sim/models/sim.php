<?php
/**
 * @author vangiangfly
 * @category Model
 */
class SimModelsSim extends FSModels{
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
    function getSim($product_id = 0)
    {
        $query = "  SELECT id,sim,price,created_time,network,point,cat_name
					FROM fs_sim 
					WHERE id = ".intval($product_id);
        global $db;
        $db->query($query);
        return $db->getObject();
    }

    function save_order(){
        $str_id = ',';
        foreach($_SESSION['cart'] as $item){
            $list_id[] = $item[0];
            $str_id .= $item[0].',';
        }
        $str_id = trim($str_id,',');
        // var_dump($str_id);die;

        $phone = FSInput::get('deprecate_phone');
        $address = FSInput::get('deprecate_address');
        $name = FSInput::get('deprecate_name');
        $email = FSInput::get('deprecate_email');
        $deposit = FSInput::get('deposit');
        $pay = FSInput::get('select-paymethod');
        $note = FSInput::get('comment');
        $totalmoney = FSInput::get('totalmoney');
        $totalafter = FSInput::get('totalafter');

        $time = date("Y-m-d H:i:s");

        if(!$list_id)
            return;
        global $db;
        
        //Lưu thông tin khách hàng
        $member = $this -> get_record(' telephone ='.$phone,'fs_members','id,position,position_name,discount,code');
        if (@$member) {
            $row['member_level'] = $member->position;
            $row['member_level_name'] = $member->position_name;
            $row['member_discount'] = $member->discount;
            $row['member_id'] = $member->id;
            $row['member_code'] = $member->code;
        }else{

            $row_member['name'] = $name;
            $row_member['username'] = $name;
            $row_member['position'] = '4';
            $row_member['position_name'] = 'Kh mới';
            $row_member['email'] = $email;
            $row_member['discount'] = 0;
            $row_member['address'] = $address;
            $row_member['telephone'] = $phone;
            $row_member['published'] = 1;
            $row_member['buy'] = 0; 
            $row_member['created_time'] = $time; 
            $row_member['day'] = date('Y-m-d H:i:s',strtotime('+1 year',strtotime($time)));

            // var_dump($row_member);die;
            $rs_member = $this -> _add($row_member, 'fs_members');

            $code = 'KH'.str_pad($rs_member, 4 , "0", STR_PAD_LEFT);
            $query = " UPDATE fs_members set code = '".$code."' WHERE id = ".$rs_member;
            $db->query($query);
            $rs_member2 = $db->affected_rows();

            $row['member_level'] = '4';
            $row['member_level_name'] = 'Kh mới';
            $row['member_discount'] = 0 ;
            $row['member_id'] = $rs_member ;
            $row['member_code'] = $code ;

        }


        // Lưu thông tin đơn hàng
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



        // $row['recipients_city'] = $city->id;
        // $row['recipients_city_name'] = $city->name;
        // $row['user_id'] = $_SESSION['ad_userid'];
        // $row['username'] = $_SESSION['ad_username'];
        $row['status'] = 9;


        $rs = $this -> _add($row, 'fs_order');
        // var_dump($rs);die;

        $code_dh = 'DH'.str_pad($rs, 8 , "0", STR_PAD_LEFT);
        $query = " UPDATE fs_order set code = '".$code_dh."' WHERE id = ".$rs;
        $db->query($query);
        $rs2 = $db->affected_rows();

        if(!$rs)
            return false;

        //Lưu dữ liệu từng sim
        foreach ($list_id as $key) {
            if (!$key) {
                continue;
            }
            $product = $this -> get_record('admin_status = 1 AND id ='.$key,'fs_sim');
            $agency = $this->get_record('published = 1 AND type = 2 AND id = '.$product->agency,'fs_users');
            $agency_city = $this->get_record('published = 1 AND id = '.$agency->city,'fs_cities','id,name');
            $row_item['order_id'] = $rs;

            $row_item['agency_id'] = $agency->id;
            $row_item['agency_name'] = $agency->full_name;
            $row_item['agency_phone'] = $agency->phone;
            $row_item['agency_web'] = $agency->web;
            $row_item['agency_city'] = $agency_city->name;

            $row_item['time_create'] = $product->created_time;
            $row_item['time_order'] = $time;
            $row_item['product_id'] = $product->id;
            $row_item['price'] = $product->price;
            $row_item['sim'] = $product->sim;
            $row_item['number'] = $product->number;
            $row_item['discount'] = $row['member_discount'];

            $row_item['commission'] = $product->commission_value;
            $row_item['commission_percent'] = $product->commission_percent;
            $price_public = $product->price_public;
            $price_sell = $price ? $price:$product->price_public;
            $row_item['price_public'] = $price_public;
            $row_item['price_sell'] = $price_sell;
            $row_item['price_end'] = @$member->discount ? $price_sell - $price_sell*$member->discount/100 : $price_sell ;
            $row_item['interest'] = $row_item['price_end'] - $product->price + $product->commission_value;

            // var_dump($row_item);die;
            $item_id = $this -> _add($row_item, 'fs_order_items');

            $row_history['order_id'] = $rs;
            $row_history['time'] = $time;
            $row_history['status'] = 9;
            $row_history['name_status'] = 'Tạo đơn hàng';
            $row_history['user_id'] = $_SESSION['ad_userid'];
            $row_history['username'] = $_SESSION['ad_username'];
            $history_id = $this -> _add($row_history, 'fs_order_history');

            //cập nhật trạng thái sim
            if ($item_id) {
                $query = " UPDATE fs_sim set status = '1' WHERE id = ".$key;
                $db->query($query);
                $rows = $db->affected_rows();
            }
        }
 
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


}