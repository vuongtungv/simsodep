<?php
/**
 * @author vangiangfly
 * @category Controller
 */
class SimControllersSim extends FSControllers{
    function __construct(){
        parent::__construct();
    }
    
    function display(){
        global $arrProductLine;

        $type = FSInput::get('type', 'default');
        $this->model->type = $type;
        $orderSims = $this->model->getSimsCart();

        global $tmpl;
        $breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Thanh toán', 1=>'');
		$tmpl -> assign('breadcrumbs', $breadcrumbs);
        require(PATH_BASE.'modules/' . $this->module . '/views/paynow/default.php');
    }

    function save_order(){
        // var_dump(1);die;
        $model = $this -> model;
        
        $rs  = $model -> save_order();
        
        if($rs){
            unset($_SESSION['cart']);
            $link = FSRoute::_('index.php?module=paynow&view=paynow&task=success&id='.$rs.'&Itemid=31');
            $msg = 'Đặt sim thành công';
            setRedirect($link,$msg);
        }
        else {
            $link = FSRoute::_('index.php?module=paynow&view=paynow');
            $msg = 'Chưa đặt được sim';
            setRedirect($link,$msg);
        }
    }

    function success(){
        $id= FSInput::get('id');
        $model = $this -> model;
        $order = $model->get_record('id ="'.$id.'"','fs_order','*');
        $list = $model->get_order_item($id);
        // var_dump($list);die;
        require(PATH_BASE.'modules/' . $this->module . '/views/paynow/success.php');
    }

    function get_member()
    {
        $model = $this -> model;

        $code= FSInput::get('code');
        $total= FSInput::get('total');
        
        $member = $model->get_record('code ="'.$code.'"','fs_members','*');

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
            'position' => '',
            'position_name' => '',
            "id"=>''
        );

        if ($member->discount) {
            $total = $total - $total*$member->discount/100;
            $number = format_money($total);
            $string = int_to_words($total);
        }

        $json['total_original'] = $total;
        $json['total'] = $number;
        $json['string'] = $string;
        $json['name'] = $member->name;
        $json['telephone'] = $member->telephone;
        $json['email'] = $member->email;
        $json['address'] = $member->address;
        $json['discount'] = $member->discount;
        $json['position'] = $member->position;
        $json['position_name'] = $member->position_name;
        $json['id'] = $member->id;

        echo json_encode($json);

    } 

    function mdisplay(){
        global $arrProductLine;

        $type = FSInput::get('type', 'default');
        $this->model->type = $type;
        $orderSims = $this->model->getSimsCart();

        global $tmpl;
        $breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Thanh toán', 1=>'');
		$tmpl -> assign('breadcrumbs', $breadcrumbs);
        require(PATH_BASE.'modules/' . $this->module . '/views/paynow/default_mobile.php');
    }
}