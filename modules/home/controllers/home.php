<?php

 
class HomeControllersHome extends FSControllers{
    function __construct(){
        parent::__construct();
    }
    
    function display(){
        $model = $this->model;
//        $getVideoHome = $this->model->getVideoHome();
//        $getNewsHome = $this->model->getNewsHome();
        $network = $this->model->get_records('published = 1','fs_network','id,name',' ordering ASC ');
        $type = $model->get_records('','fs_sim_type','id,name,alias',' ordering ASC,id ASC ');
        $regis_default = $this->model->regis_default();
        $show_netname = $this->model->show_netname();
        require(PATH_BASE.'modules/'.$this->module.'/views/default.php');
    }
    function mdisplay(){
        $model = $this->model;
//        $getVideoHome = $this->model->getVideoHome();
//        $getNewsHome = $this->model->getNewsHome();
        $network = $this->model->get_records('published = 1','fs_network','id,name,alias',' ordering ASC ');
        $type = $model->get_records('','fs_sim_type','id,name,alias,level,parent_name,parent_alias',' ordering ASC,id ASC ');
        require(PATH_BASE.'modules/'.$this->module.'/views/default_mobile.php');
    }

    function phongthuy(){
        $model = $this->model;
        
        // breadcrumbs
        $breadcrumbs = array ();
        $breadcrumbs [] = array (0 => FSText::_( 'Sim phong thủy' ), 1 => '' );
        global $tmpl;

        $tmpl->assign ( 'breadcrumbs', $breadcrumbs );
        $seo = $model->get_record('module_seo = "phongthuy"','fs_seo','title,keywords,description,content');

        if ($seo) {
            $tmpl -> assign('title', $seo->title);
            $tmpl -> assign('keywords', $seo->keywords);
            $tmpl ->assign ( 'description', $seo->description);
        }

        // $tmpl -> set_seo_special();
        // call views
        include 'modules/'.$this->module.'/views/'.'phongthuy.php';
    }

    function mphongthuy(){
        $model = $this->model;
        
        // breadcrumbs
        $breadcrumbs = array ();
        $breadcrumbs [] = array (0 => FSText::_( 'Sim phong thủy' ), 1 => '' );
        global $tmpl;

        $tmpl->assign ( 'breadcrumbs', $breadcrumbs );
        $seo = $model->get_record('module_seo = "phongthuy"','fs_seo','title,keywords,description,content');

        if ($seo) {
            $tmpl -> assign('title', $seo->title);
            $tmpl -> assign('keywords', $seo->keywords);
            $tmpl ->assign ( 'description', $seo->description);
        }

        // $tmpl -> set_seo_special();
        // call views
        include 'modules/'.$this->module.'/views/'.'mphongthuy.php';
    }

    function dinhgia(){
        $model = $this->model;
        
        // breadcrumbs
        $breadcrumbs = array ();
        $breadcrumbs [] = array (0 => FSText::_( 'Định giá sim' ), 1 => '' );
        global $tmpl;

        $tmpl->assign ( 'breadcrumbs', $breadcrumbs );
        $seo = $model->get_record('module_seo = "dinhgia"','fs_seo','title,keywords,description,content');

        if ($seo) {
            $tmpl -> assign('title', $seo->title);
            $tmpl -> assign('keywords', $seo->keywords);
            $tmpl ->assign ( 'description', $seo->description);
        }

        // $tmpl -> set_seo_special();
        // call views
        include 'modules/'.$this->module.'/views/'.'dinhgia.php';
    }

    function mdinhgia(){
        $model = $this->model;
        
        // breadcrumbs
        $breadcrumbs = array ();
        $breadcrumbs [] = array (0 => FSText::_( 'Định giá sim' ), 1 => '' );
        global $tmpl;

        $tmpl->assign ( 'breadcrumbs', $breadcrumbs );
        $seo = $model->get_record('module_seo = "dinhgia"','fs_seo','title,keywords,description,content');

        if ($seo) {
            $tmpl -> assign('title', $seo->title);
            $tmpl -> assign('keywords', $seo->keywords);
            $tmpl ->assign ( 'description', $seo->description);
        }

        // $tmpl -> set_seo_special();
        // call views
        include 'modules/'.$this->module.'/views/'.'mdinhgia.php';
    }

    function internet(){
        $model = $this->model;
        
        // breadcrumbs
        $breadcrumbs = array ();
        $breadcrumbs [] = array (0 => FSText::_( 'Lắp đặt internet' ), 1 => '' );
        global $tmpl;

        $tmpl->assign ( 'breadcrumbs', $breadcrumbs );
        $seo = $model->get_record('module_seo = "internet"','fs_seo','title,keywords,description,content');

        if ($seo) {
            $tmpl -> assign('title', $seo->title);
            $tmpl -> assign('keywords', $seo->keywords);
            $tmpl ->assign ( 'description', $seo->description);
        }

        // $tmpl -> set_seo_special();
        // call views
        include 'modules/'.$this->module.'/views/'.'internet.php';
    }

    function minternet(){
        $model = $this->model;
        
        // breadcrumbs
        $breadcrumbs = array ();
        $breadcrumbs [] = array (0 => FSText::_( 'Lắp đặt internet' ), 1 => '' );
        global $tmpl;

        $tmpl->assign ( 'breadcrumbs', $breadcrumbs );
        $seo = $model->get_record('module_seo = "internet"','fs_seo','title,keywords,description,content');

        if ($seo) {
            $tmpl -> assign('title', $seo->title);
            $tmpl -> assign('keywords', $seo->keywords);
            $tmpl ->assign ( 'description', $seo->description);
        }

        // $tmpl -> set_seo_special();
        // call views
        include 'modules/'.$this->module.'/views/'.'minternet.php';
    }

    function bangso(){
        $model = $this->model;
        
        // breadcrumbs
        $breadcrumbs = array ();
        $breadcrumbs [] = array (0 => FSText::_( 'Bảng số' ), 1 => '' );
        global $tmpl;

        $tmpl->assign ( 'breadcrumbs', $breadcrumbs );
        $seo = $model->get_record('module_seo = "bangso"','fs_seo','title,keywords,description,content');

        if ($seo) {
            $tmpl -> assign('title', $seo->title);
            $tmpl -> assign('keywords', $seo->keywords);
            $tmpl ->assign ( 'description', $seo->description);
        }

        // $tmpl -> set_seo_special();
        // call views
        include 'modules/'.$this->module.'/views/'.'bangso.php';
    }

    function mbangso(){
        $model = $this->model;
        
        // breadcrumbs
        $breadcrumbs = array ();
        $breadcrumbs [] = array (0 => FSText::_( 'Bảng số' ), 1 => '' );
        global $tmpl;

        $tmpl->assign ( 'breadcrumbs', $breadcrumbs );
        $seo = $model->get_record('module_seo = "bangso"','fs_seo','title,keywords,description,content');

        if ($seo) {
            $tmpl -> assign('title', $seo->title);
            $tmpl -> assign('keywords', $seo->keywords);
            $tmpl ->assign ( 'description', $seo->description);
        }

        // $tmpl -> set_seo_special();
        // call views
        include 'modules/'.$this->module.'/views/'.'mbangso.php';
    }

    function update_id(){
        $list = $_SESSION['cart'];
        foreach ($list as $item) {
            if (!$item[0]) {
                $sim = $this->model->get_record('number = '.$item[2],'fs_sim','id,price_public,number,network,network_id,cat_name,point,button');
                if ($sim) {
                    $sim_list[$item[2]] = array(
                        $sim->id,
                        $sim->price_public,
                        $sim->number,
                        $sim->network,
                        $sim->cat_name,
                        $sim->point,
                        $sim->button,
                    );
                }
            }else{
                $sim_list[$item[2]] = $item;
            }
        }
        $_SESSION['cart'] = $sim_list;
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

    function action_cart()
    {
        $sim_id = FSInput::get('id', 0, 'int');
        $price_sim = FSInput::get('price');
        $sim = FSInput::get('sim');
        $network = FSInput::get('network');
        $cat = FSInput::get('cat');
        $point = FSInput::get('point');
        $button = FSInput::get('button');
        $key = $sim;
        if (!isset($_SESSION['cart'])) {
            $sim_list = array();
            $sim_list[$key] = array(
                $sim_id,
                $price_sim,
                $sim,
                $network,
                $cat,
                $point,
                $button,
            );
            $_SESSION['cart'] = $sim_list;
        }else{
            if ($_SESSION['cart'][$sim]) {
                $product_list = $_SESSION['cart'];
                $products_new = array();
                foreach ($product_list as $key=>$val){
                    if ($sim != $key){
                        $products_new[$key] = $val;
                    }
                }
                $_SESSION['cart'] = $products_new;
            }else{
                $sim_list = $_SESSION['cart'];
                $sim_list[$key] = array(
                    $sim_id,
                    $price_sim,
                    $sim,
                    $network,
                    $cat,
                    $point,
                    $button,
                );
                $_SESSION['cart'] = $sim_list;
            }
        }

        $html = '';
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $html.='<tr>
                        <td>'.$item[2].'</td>
                        <td>'.number_format($item[1], 0, ',', '.').' đ</td>
                        <td>
                            <a href="https://simsodepgiare.com.vn/index.php?module=home&amp;view=home&amp;task=delete&amp;number='.$sim.'">
                                <span><i class="fa fa-times" aria-hidden="true"></i></span>
                            </a>
                        </td>
                    </tr>';
            $total += $item[1];
        }
        $total = number_format($total, 0, ',', '.').' đ';
        $json_arr = array( "list" => $html, "quantity" => count($_SESSION['cart']), "total" => $total );

        if (@$_SESSION['cart']){
            $arr_cart = array();
            foreach ($_SESSION['cart'] as $item){
                $arr_cart[] = $item[2];
            }
            $_SESSION['arr_cart'] = $arr_cart;
        }else{
            unset($_SESSION['arr_cart']);
        }

        echo json_encode( $json_arr );
    }

    function maction_cart()
    {
        $sim_id = FSInput::get('id', 0, 'int');
        $price_sim = FSInput::get('price');
        $sim = FSInput::get('sim');
        $network = FSInput::get('network');
        $cat = FSInput::get('cat');
        $point = FSInput::get('point');
        $button = FSInput::get('button');
        $key = $sim;
        if (!isset($_SESSION['cart'])) {
            $sim_list = array();
            $sim_list[$key] = array(
                $sim_id,
                $price_sim,
                $sim,
                $network,
                $cat,
                $point,
                $button,
            );
            $_SESSION['cart'] = $sim_list;
        }else{
            if ($_SESSION['cart'][$sim]) {
                $product_list = $_SESSION['cart'];
                $products_new = array();
                foreach ($product_list as $key=>$val){
                    if ($sim != $key){
                        $products_new[$key] = $val;
                    }
                }
                $_SESSION['cart'] = $products_new;
            }else{
                $sim_list = $_SESSION['cart'];
                $sim_list[$key] = array(
                    $sim_id,
                    $price_sim,
                    $sim,
                    $network,
                    $cat,
                    $point,
                    $button,
                );
                $_SESSION['cart'] = $sim_list;
            }
        }

        $html = '';
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {

            $html.='<tr>
                        <td class="first">
                            <a data="'.$sim.'" class="icon_delete" href="javascript:void(0)">
                                <img src="/templates/mobile/images/icon_delete.png" alt="">
                            </a>
                            <p class="title-bold phone-number">'.$item[2].'</p>
                            <p class="phone-network">'.$item[3].'</p>
                            <p class="phone-type">'.$item[4].'</p>
                        </td>
                        <td class="second">
                            <p class="phone-price">'.number_format($item[1], 0, ',', '.').' đ</p>
                            <p class="phone-point">Điểm: '.$item[5].'</p>
                            <p class="phone-point">Nút: '.$item[6].'</p>
                        </td>
                    </tr>';

            $total += $item[1];
        }
        $html .= '<script language="javascript" type="text/javascript" src="https://simsodepgiare.com.vn/templates/mobile/js/templates.js"></script>';
        $total_m = number_format($total, 0, ',', '.').' đ';
        $total_word = '('.ucfirst(convert_number_to_words($total)).')';
        $json_arr = array( "list" => $html, "quantity" => count($_SESSION['cart']), "total" => $total_m, "total_word" => $total_word );

        if (@$_SESSION['cart']){
            $arr_cart = array();
            foreach ($_SESSION['cart'] as $item){
                $arr_cart[] = $item[2];
            }
            $_SESSION['arr_cart'] = $arr_cart;
        }else{
            unset($_SESSION['arr_cart']);
        }

        echo json_encode( $json_arr );
    }

    function msuccess_kygui(){
        require(PATH_BASE.'modules/' . $this->module . '/views/success_kygui.php');
    }
    function msuccess_timsim(){
        require(PATH_BASE.'modules/' . $this->module . '/views/success_timsim.php');
    }


    function update_cart()
    {
        $sim_id = FSInput::get('id', 0, 'int');
        $price_sim = FSInput::get('price');
        $sim = FSInput::get('sim');
        $network = FSInput::get('network');
        $cat = FSInput::get('cat');
        $point = FSInput::get('point');
        $button = FSInput::get('button');

        $key = $sim;
            $sim_list = array();
            $sim_list[$key] = array(
                $sim_id,
                $price_sim,
                $sim,
                $network,
                $cat,
                $point,
                $button,
            );
        $_SESSION['cart'] = $sim_list;
        // if (!$sim_id){
        //     $item = $this->model->get_record('number = '.$sim,'fs_sim','id,price_public,number,network,network_id,cat_name,point,button');
        //     $sim_list[$key] = array(
        //         $item->id,
        //         $price_sim,
        //         $sim,
        //         $network,
        //         $cat,
        //         $point,
        //         $button,
        //     );
        //     $_SESSION['cart'] = $sim_list;
        // }
    }
    function check_count_cart(){
        if(isset($_SESSION['cart'])){
            $count_cart = count($_SESSION['cart']);
            if($count_cart <= 1){
                $count_cart = 0;
            }else{
                $count_cart--;
            }
        }else{
            $count_cart = 0;
        }
        echo $count_cart;
    }

    function delete_cart(){
        $sim = FSInput::get('sim');
        if ($sim){
            if (isset($_SESSION['cart'])){
                $product_list = $_SESSION['cart'];
                $products_new = array();
                foreach ($product_list as $key=>$val){
                    if ($sim != $key){
                        $products_new[$key] = $val;
                    }
                }
                $_SESSION['cart'] = $products_new;
            }
        }
    }

    function delete(){
        $number = FSInput::get('number', 0, 'int');
        if ($number){
            if (isset($_SESSION['cart'])){
                $product_list = $_SESSION['cart'];
                $count_products_current = 0;
                $products_new = array();
                foreach ($product_list as $key=>$val){
                    if ($number != $key){
                        $products_new[$key] = $val;
                    }
                }
                $_SESSION['cart'] = $products_new;
            }
        }

        if (@$_SESSION['cart']){
            $arr_cart = array();
            foreach ($_SESSION['cart'] as $item){
                $arr_cart[] = $item[2];
            }
            $_SESSION['arr_cart'] = $arr_cart;
        }else{
            unset($_SESSION['arr_cart']);
        }

        $link = $_SERVER['HTTP_REFERER'];
        setRedirect($link);
    }

    function mdelete(){
        $number = FSInput::get('number', 0, 'int');
        $code = FSInput::get('code', 0, 'int');
        if ($number){
            if (isset($_SESSION['cart'])){
                $product_list = $_SESSION['cart'];
                $count_products_current = 0;
                $products_new = array();
                foreach ($product_list as $key=>$val){
                    if ($number != $key){
                        $products_new[$key] = $val;
                    }
                }
                $_SESSION['cart'] = $products_new;
            }
        }

        $html = '';
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $html.='<tr>
                        <td class="first">
                            <a data="'.$item[2].'" class="icon_delete" href="javascript:void(0)">
                                <img src="/templates/mobile/images/icon_delete.png" alt="">
                            </a>
                            <p class="title-bold phone-number">'.$item[2].'</p>
                            <p class="phone-network">'.$item[3].'</p>
                            <p class="phone-type">Thể loại: '.$item[4].'</p>
                        </td>
                        <td class="second">
                            <p class="phone-price">'.number_format($item[1], 0, ',', '.').' đ</p>
                            <p class="phone-point">Điểm: '.$item[5].'</p>
                            <p class="phone-point">Nút: '.$item[6].'</p>
                        </td>
                    </tr>';

            $total += $item[1];
        }
        $html .= '<script language="javascript" type="text/javascript" src="https://simsodepgiare.com.vn/templates/mobile/js/templates.js"></script>';
        $total_m = number_format($total, 0, ',', '.').' đ';
        $total_word = '('.ucfirst(convert_number_to_words($total)).')';
        $json_arr = array( "list" => $html, "quantity" => count($_SESSION['cart']), "total" => $total_m, "total_word" => $total_word );

        if (@$_SESSION['cart']){
            $arr_cart = array();
            foreach ($_SESSION['cart'] as $item){
                $arr_cart[] = $item[2];
            }
            $_SESSION['arr_cart'] = $arr_cart;
        }else{
            unset($_SESSION['arr_cart']);
        }

        echo json_encode( $json_arr );
    }

    function ajax_get_promotions(){
        $model  = $this -> model;
        $cid = FSInput::get('cid');
        $rs  = $model -> ajax_get_promotions($cid);

        $detail_json = array(
            'title'=>$rs->title,
            'price' =>$rs->price,
            'content'=>$rs->content,
            'rules_regis'=>$rs->rules_regis,
            'number_send'=>$rs->number_send,
            'link'=>$rs->link_promotions,
        );

        echo json_encode($detail_json);
    }


    function toggle_advanced_search(){
        if(isset($_SESSION['advance_search'])){
            unset($_SESSION['advance_search']);
        }else{
            $_SESSION['advance_search'] = 1;
        }
        echo @$_SESSION['advance_search'];
    }

} 