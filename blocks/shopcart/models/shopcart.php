<?php
class ShopcartModelsShopcart extends FSModels
{
    function __construct()
    {
        parent::__construct();
        $fstable = FSFactory::getClass('fstable');
//        $this->table_name  = 'fs_sim';
//        $this->table_category  = $fstable->_('fs_products_categories', MULTI_LANGUAGE);
        $this->limit = 4;
    }

    /**
     * Lấy thông tin sản phẩm trong giỏ hàng
     *
     * @return array
     */
    function getSim($product_id = 0)
    {
        $query = "  SELECT *
					FROM fs_sim 
					WHERE id = ".intval($product_id);
        global $db;
        $db->query($query);
        return $db->getObject();
    }

    function getStyleProduct(){
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
        $listStyle = array();
        foreach ($listProduct as $item) {
            $st = $item->info['style'];
            $query =" SELECT name
                      FROM fs_extends_style
                      WHERE id= $st";
            global $db;
            $sql = $db->query($query);
            $result = $db->getObject();
            $listStyle[]  = $result;
        }
        return $listStyle;

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

    function getProductsReleases($id = 0){
        global $db;
        $query = '  SELECT p.id AS id, r.id AS r_id, p.name AS name, p.alias AS alias, p.category_alias AS category_alias, p.price AS price, r.price AS r_price, r.record_id AS record_id
                    FROM fs_products_releases AS r
                        INNER JOIN fs_products AS p ON p.id = r.release_id
                    WHERE p.published = 1 AND r.id IN ('.$id.')
                    ORDER BY r.ordering ASC';
        $result = $db->query($query);
        return $db->getObjectList();
    }

    function getListCities(){
        global $db;
        $query = '  SELECT id, name
                    FROM fs_local_cities 
                    WHERE published = 1
                    ORDER BY ordering';
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function getListDistricts($city_id = 0){
        global $db;
        $sqlWhere = '';
        if($city_id)
            $sqlWhere = ' AND city_id = '.$city_id;
        $query = '  SELECT id, name
                    FROM fs_local_districts 
                    WHERE published = 1 '.$sqlWhere.'
                    ORDER BY ordering';
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function getUserInfo(){
        global $db;
        if(!isset($_SESSION['username']))
            return false;
        $sql = 'SELECT m.*,
                    (SELECT name FROM fs_local_cities AS c WHERE c.id = m.city_id LIMIT 1) AS city 
    			FROM fs_members AS m
    			WHERE username = \''.$_SESSION['username'].'\'';
        $db->query($sql);
        return $db->getObject();
    }

    function addOrder(){
        global $user;
        $orderProducts = $this->getProductsCart();

        $totalOrder = 0;
        $products_id = '0';
        foreach($orderProducts as $item){
            $totalOrder += $item -> price*$item->quantity;
            $products_id .= ','.$item->id;
        }
        $data = array();
        if($user->userID)
            $data['user_id']        = $user->userID;
        $data['sender_name']        = FSInput::get('sender_name', '');
        $data['sender_telephone']   = FSInput::get('sender_telephone', '');
        $data['sender_email']       = FSInput::get('sender_email', '');
        $data['sender_sex']       = FSInput::get('gender', '');
        $data['sender_city']        = FSInput::get('sender_city', '');
        $data['sender_district']    = FSInput::get('sender_district', '');
        $data['sender_address']     = FSInput::get('sender_address', '');
        $data['sender_comments']     = FSInput::get('sender_comments', '');
        $data['username']    = FSInput::get('username', '');
        $data['recipients_telephone']= FSInput::get('recipients_telephone', '');
        $data['recipients_email']   = FSInput::get('recipients_email', '');
        $data['recipients_city']    = FSInput::get('recipients_city', '');
        $data['recipients_district']= FSInput::get('recipients_district', '');
        $data['recipients_address'] = FSInput::get('recipients_address', '');
        $data['payment_type']        = FSInput::get('type-payment', '');
        $data['payment_method']        = FSInput::get('payment_method', 1);
//        $data['payment_bank']        = FSInput::get('payment_bank', '');
        $discount = 0;
        $discount_info = 0;
        if(isset($_SESSION['discount'])){
            $discount = $_SESSION['discount']['discount'];
            if($_SESSION['discount']['discount_unit'] == 2){
                $discount = round(($_SESSION['discount']['discount']*$totalOrder)/100, 0);
            }
            $discount_info = json_encode($_SESSION['discount']);
        }
        $data['total_before_discount'] = $totalOrder;
        $data['total_after_discount'] = $totalOrder - $discount;
        $data['products_id']    = $products_id;
        $data['discount']       = $discount;
        $data['discount_info']  = $discount_info;
//        $data['discount_code'] = @$_SESSION['discount']['code'];
        $data['discount_title'] = @$_SESSION['discount']['title'];
        $data['created_time'] = date("Y-m-d H:i:s");
//        $data['device_detect'] = DEVICE_DETECT;
        $id = $this->_add($data, 'fs_order');
        $code = 'DH'.str_pad($id, 6, "0", STR_PAD_LEFT);
        $this->_update(array('code'=>$code), 'fs_order', 'id = '.$id);
        $this->addOrderItems($id, $orderProducts);
        if(isset($_SESSION['discount']))
            $this->updateDiscountUsered($_SESSION['discount']['id']);
        $_SESSION['order_code'] = $code;
        $_SESSION['order_buyer'] = $data['sender_name'];
        $_SESSION['order_email'] = $data['sender_email'];

//        if(!$this->check_customer_exists($data['sender_telephone'])){
//            $this->_add(array(
//                'sender_name' => $data['sender_name'],
//                'sender_telephone' => $data['sender_telephone'],
//                'sender_email' => $data['sender_email'],
//                'sender_city' => $data['sender_city'],
//                'sender_district' => $data['sender_district'],
//                'sender_address' => $data['sender_address']
//            ), 'fs_customers');
//        }

        return $id.'|'.$code.'|'.$data['total_after_discount'];
    }

    function check_customer_exists($sender_telephone = ''){
        global $db;
        $query = '  SELECT count(id)
                    FROM fs_customers
                    WHERE sender_telephone = \''.$sender_telephone.'\'';
        $result = $db->query($query);
        return $db->getResult();
    }

    function addOrderItems($order_id, $orderProducts){
        foreach($orderProducts as $item){
            $data = array();
            $data['order_id']   = $order_id;
            $data['product_id'] = $item->id;
            $data['quantity']   = $item->quantity;
            $data['price']      = $item->price;
            $data['discount']   = $item->discount;
            $data['price_old']  = $item->price_old;
//            $data['combo'] = $item->info['combo'];
            $data['color'] = $item->info['color'];
            $data['size'] = $item->info['size'];
            $data['style'] = $item->info['style'];
            $data['material'] = $item->info['material'];
            $data['releases']  = '';
            $id = $this->_add($data, 'fs_order_items');
        }
    }

    function getOrder($id){
        global $db;
        $sql = 'SELECT * 
    			FROM fs_order
    			WHERE id = '.$id;
        $db->query($sql);
        return $db->getObject();
    }

    function getProductsOrder($id){
        global $db;
        $query = '  SELECT code, name, alias, category_alias, image, o.*
                    FROM fs_products AS p
                        INNER JOIN fs_order_items AS o ON o.product_id = p.id
                    WHERE order_id = '.$id;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $i = 0;
        foreach($result as $item){
            $result[$i]->releases = false; // $this->getProductsReleases($item->releases);
            $i++;
        }
        return $result;
    }

    function isFreeShip(){
        $total = 0;
        if(!isset($_SESSION['cart']))
            return true;
        foreach($_SESSION['cart'] as $item){
            $product = $this->getProduct($item[0]);
            $total += $product->price_old * $item[1];
        }
        if($total >= 1000000)
            return true;
        else
            return false;
    }

    function getShipping($id =0 ){
        if($this->isFreeShip())
            return 0;
        global $db;
        if(!$id)
            return 0;
        $sql = 'SELECT shipping 
    			FROM fs_local_cities
    			WHERE id = '.$id;
        $db->query($sql);
        $data = $db->getObject();
        if($data)
            return $data->shipping;
        return 0;
    }

    /**
     * Lấy danh sách size
     *
     * @return Object list
     */
    function getListSizes(){
        global $db;
        $query = "  SELECT id, `name`
                    FROM fs_extends_size";
        $db->query($query);
        return $db->getObjectListByKey('id');
    }

    /**
     * Lấy danh sách màu.
     *
     * @return Object list
     */
    function getListColors(){
        global $db;
        $query = "  SELECT id, title AS `name`
                    FROM fs_products_colors";
        $db->query($query);
        return $db->getObjectListByKey('id');
    }

    /**
     * Lấy danh sách màu.
     *
     * @return Object list
     */
    function getListMaterial(){
        global $db;
        $query = "  SELECT id, `name`
                    FROM fs_extends_material";
        $db->query($query);
        return $db->getObjectListByKey('id');
    }

    /**
     * Lấy danh mục
     * @return Object list
     */
    public function getListCats(){
        global $db;
        $query = '  SELECT id, name, alias, level, parent_id, alias, list_parents
                    FROM '.$this->table_category.'
                    WHERE published = 1
                    ORDER BY ordering ASC';
        $result = $db->query($query);
        $categories = $db->getObjectList();
        $tree_class  = FSFactory::getClass('tree','tree/');
        return $list = $tree_class -> indentRows($categories, 3);
    }

    /**
     * Lấy danh sách sản phẩm
     * @return Object list
     */
    function getListProduct(){
        global $db;
        $query = '  SELECT id, name, summary, price, price_old, discount, discount_unit, image, alias, category_alias, hot, new
                    FROM '.$this->table_name.' 
                    WHERE published = 1 AND discount > 0
                    ORDER BY id DESC';
        $result = $db->query_limit($query, $this->limit, $this->page);
        return $db->getObjectList();
    }

    /**
     * Cập nhật số lần sử dụng
     */
    function updateDiscountUsered($id = 0){
        global $db;
        $db->query('UPDATE fs_products_discount SET number_usered = number_usered + 1 WHERE id='.$id);
    }
}