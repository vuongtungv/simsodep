<?php

/*
 * Huy write
 */

// controller
class UsersControllersUsers extends FSControllers {

    var $module;
    var $view;

    function __construct() {
        global $user;
        parent::__construct();
    }

    function display() {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        // call models
        $model = $this->model;
        // call views			
        include 'modules/' . $this->module . '/views/' . $this->view . '/logged.php';
    }

    /*
     * View information of member
     */

    function detail() {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();

        $model = $this->model;
        $data = $model->getMember();
        $province = $model->getProvince($data->province);
        $district = $model->getDistrict($data->district);
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    /*
     * View information of member
     */

    function edit() {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $user_id = $_SESSION['user_id'];

        $global_class = FSFactory::getClass('FsGlobal');
        $model = $this->model;
        $data = $model->getMember();
        $cities = $model->get_cities();
        //$districts  = $model -> get_districts($data -> city_id);
        $config_person_edit = $model->getConfig('person_edit');
        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Thông tin cá nhân', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);

        include 'modules/' . $this->module . '/views/' . $this->view . '/edit.php';
    }

    function user_info() {
        global $user;

        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $model = $this->model;

        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Thông tin tài khoản', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);

        include 'modules/' . $this->module . '/views/' . $this->view . '/user_info.php';
    }

    function login() {

        $model = $this->model;
        if (isset($_SESSION['username'])) {
            $link = FSRoute::_('index.php?module=users&task=user_info&Itemid=45');
            setRedirect($link);
        }
        $config_person_login_info = $model->getConfig('login_info');

        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Đăng nhập', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);

        include 'modules/' . $this->module . '/views/' . $this->view . '/login.php';
    }

    function login_save() {

        global $user;
        $return = FSInput::get('return');
        $url = base64_decode($return);
        $model = $this->model;

        $link = FSRoute::_('index.php?module=users&task=user_info&Itemid=45');
        $username = FSInput::get2('username', '', 'str');
        $password = FSInput::get('password', '', 'str');
        // echo $password;die;
        $loged = $user->login($username, $password);
        if ($loged) {

            $url = FSRoute::_('index.php?module=users&task=user_info&Itemid=5');
            //$msg = 'Tôi đã đọc và đồng ý với các điều khoản trong  <a href="/quichebaomat/" target="_blank" style="text-decoration: underline; color: #3da6ea;">Quy chế bảo mật</a> của trang web ';
            $msg='';
            setRedirect($url, $msg);
        } else {
            $url = FSRoute::_('index.php?module=users&task=login&Itemid=5');
            $msg = 'Tên đăng nhập hoặc password chưa chính xác.';
            setRedirect($url, $msg, 'error');
        }
    }

    function fget_pass() {
    
        $model = $this->model;
    
        if (isset($_SESSION['username'])) {
            $link = FSRoute::_('index.php?module=users&task=user_info&Itemid=45');
            setRedirect($link);
        }
           
        $config_person_login_info = $model->getConfig('login_info');

        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Đăng nhập', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);

        include 'modules/' . $this->module . '/views/' . $this->view . '/forget_pass.php';
    }

//        function do_login() {
//        global $user;
//        $json = array(
//            'error' => true,
//            'message' => 'Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.',
//            'redirect' => URL_ROOT
//        );
//        $username = FSInput::get('email', '', 'str');
//
//        $password = FSInput::get('password', '', 'str');
//        $redirect = FSInput::get('redirect', '');
//        $loged = $user->login($username, $password);
//        if ($loged) {
//            $url = URL_ROOT;
//            $msg = 'Bạn đã đăng nhập thành công.';
//            setRedirect($url, $msg);
//        } else {
//            $url = FSRoute::_(" index.php?module=members&view=members&task=login");
//            $msg = 'Bạn  đăng nhập không thành công.';
//            setRedirect($url, $msg);
//        }
//    }

    /*
     * Display form forget
     */

    function forget() {
        if (isset($_SESSION['username'])) {
            if ($_SESSION['username']) {
                $Itemid = 37;
                $link = FSRoute::_("index.php?module=users&task=logged&Itemid=$Itemid");
                setRedirect($link);
            }
        }
        $model = $this->model;
        $config_person_forget = $model->getConfig('person_forget');

        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Quên mật khẩu', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);

        include 'modules/' . $this->module . '/views/' . $this->view . '/forget_pass.php';
    }

    function activate() {
        $model = $this->model;
        $url = FSRoute::_('index.php?module=users&task=login&Itemid=11');
        if ($model->activate()) {
            setRedirect($url, 'Tài khoản của bạn đã được kích hoạt thành công');
        } else {
            setRedirect($url);
        }
    }

    function fa_save_pass() {

           global $user;
        $model = $this->model;

        $user_check = $model->forget();

        if (@$user_check) {
            // $resetPass = $model->resetPass($user->id);
              $activated_code = rand(100000, 999999);

            $user->updateUser(array('activated_code' => $activated_code), $user_check->id);

            // if (!$resetPass) {
            //     $msg = "Lỗi hệ thống khi reset Password";
            //     setRedirect(URL_ROOT, $msg, 'error');
            // }
            include 'modules/' . $this->module . '/controllers/emails.php';
            // send Mail()
            $user_emails = new UsersControllersEmail();

            if (!$user_emails->sendMailForget($user_check, $activated_code)) {
                $msg = "Lỗi hệ thống khi send mail";
                setRedirect(URL_ROOT, $msg, 'error');
            }

// echo 'dđ';die;
            $msg = "Mã xác nhận đã được gửi tới email của bạn. Vui lòng kiểm tra email của bạn để tiếp tục!";

            setRedirect('index.php?module=users&task=fget_pass&Itemid=69', $msg);
        } else {

            $msg = "Hiện không có tài khoản nào có email này, vui lòng kiểm tra lại email hoặc liên hệ quản trị";
            setRedirect("index.php?module=users&task=fget_pass&Itemid=69", $msg, 'error');
        }
    }

   function update_forgot_pass() {

        global $tmpl, $user;
        if ($user->userID)
            setRedirect(FSRoute::_('index.php?module=users&view=users'), 'Bạn đã đăng nhập!');
        require(PATH_BASE . 'modules/' . $this->module . '/views/' . $this->view . '/update_forgot_pass.php');
    }

    function do_update_forgot_pass() {

        global $user;
        $id = FSInput::get('data_id');
        $activated_code = FSInput::get('activated_code', '', 'str');

        $check = $user->check_forgot($id, $activated_code);

        if ($check) {
            
             $password = FSInput::get('password', '', 'str');

            $user->updateUser(array('password' => $password), $check->id);
          
            $msg = 'Bạn đã đổi mật khẩu thành công!';
            setRedirect('index.php?module=users&task=login&Itemid=69',$msg);
        } else {
             $msg = 'Không thành công. Vui lòng thử lại lần nữa!';
            setRedirect(URL_ROOT,$msg);
        }

    }


    function fget_save() {
    
        $model = $this->model;

        $user = $model->forget();
      
        if (@$user->email) {
            $resetPass = $model->resetPass($user->id);
          
            if (!$resetPass) {
                $msg = "Lỗi hệ thống khi reset Password";
                setRedirect(URL_ROOT, $msg, 'error');
            }
            include 'modules/' . $this->module . '/controllers/emails.php';
            // send Mail()
            $user_emails = new UsersControllersEmail();
        
            if (!$user_emails->sendMailForget($user, $resetPass)) {

                $msg = "Lỗi hệ thống khi send mail";
                setRedirect(URL_ROOT, $msg, 'error');
            }

            $msg = "Mật khẩu của bạn đã được thay đổi. Vui lòng kiểm tra email của bạn";
//           echo $msg;die;
            setRedirect(URL_ROOT, $msg);
        } else {
            $msg = "Email của bạn không tồn tại trong hệ thống. Vui lòng kiểm tra lại!";
            setRedirect("index.php?module=users&task=forget&Itemid=38", $msg, 'error');
        }
    }

    function logout() {
        global $user;
        $user->logout();
//        unset($_SESSION['user_id']);
//        unset($_SESSION['fullname']);
//        unset($_SESSION['username']);
//        unset($_SESSION['user_email']);
        $url = FSRoute::_('index.php?module=users&task=login&Itemid=69');
        setRedirect($url);
    }  
      function delete_filter() {
        global $user;
        
       unset($_SESSION['head_id']);
       unset($_SESSION['date_from']);
       unset($_SESSION['date_to']);
        $url = FSRoute::_('index.php?module=users&task=history_learning&Itemid=69');
        setRedirect($url);
    }

    /*
     * After login
     */

    function logged() {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $model = $this->model;
//			$menus_user = $model -> getMenusUser();

        include 'modules/' . $this->module . '/views/' . $this->view . '/logged.php';
    }

    /*     * ************** EDIT ********** */

    function edit_save() {
        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);
        $edit_pass = FSInput::get("edit_pass");
        if ($edit_pass) {
            if (!$this->check_edit_save()) {
                $link = FSRoute::_("index.php?module=users&view=users&task=edit");
                $msg = FSText::_("Không thay đổi được!");
                setRedirect($link, '', '');
//					return false;
            }
        }
        $id = $model->edit_save();
        // if not save
        if ($id) {
            $_SESSION['fullname'] = FSInput::get('full_name');
            $_SESSION['user_email'] = FSInput::get('email');
            $link = FSRoute::_("index.php?module=users&task=edit&Itemid=$Itemid");
            $msg = FSText::_("Bạn đã cập nhật thành công");
            setRedirect($link, $msg);
        } else {
            $link = FSRoute::_("index.php?module=users&task=edit&Itemid=$Itemid");
            $msg = FSText::_("Không cập nhật thành công!");
            setRedirect($link, $msg, 'error');
        }
    }

    function views_select_birthday() {
        include 'modules/' . $this->module . '/views/' . $this->view . '/select_birthday.php';
    }

    function check_edit_save() {
        FSFactory::include_class('errors');
        $model = $this->model;
        // check pass
        $old_password = FSInput::get("old_password");
        $password = FSInput::get("password");
        $re_password = FSInput::get("re-password");
        if (!$model->checkOldpass($old_password)) {
            Errors::setError(FSText::_("Mật khẩu không đúng"));
            return false;
        }
        if ($password && ($password != $re_password)) {
            Errors::setError(FSText::_("Mật khẩu không trùng nhau nhau"));
            return false;
        }
        if ($password == '' || $re_password == '') {
            Errors::setError(FSText::_("Chưa nhập mật khẩu mới"));
            return false;
        }
//			$email = FSInput::get("email");
//			$re_email = FSInput::get("re-email");
//			if($re_email)
//			{
//				if($email != $re_email)
//				{
//					Errors::setError(FSText::_("Email kh&ocirc;ng tr&ugrave;ng nhau"));
//					return false;
//				}	
//			}

        return true;
    }

    /*     * ************** REGISTER ********** */
    /*
     * Resigter
     */

    function register() {

        $model = $this->model;
        $config_register_rules = $model->getConfig('register_rules');
        $config_register_info = $model->getConfig('register_info');
//			$cities  = $model -> getCity();
//			$city_id_first = $cities[0] ->id;
//			$city_current = FSInput::get('province',$city_id_first,'int');
//			$districts  = $model -> getDistricts($city_current);
//			$district_current = FSInput::get('district',$districts[0] ->id,'int');

        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Đăng ký thành viên', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);

        include 'modules/' . $this->module . '/views/' . $this->view . '/register.php';
    }

    function list_user() {
        $model = $this->model;
//        $list_user = $model->get_list_user();
        $list_head = $model->get_list_head();
        $query_body = $model->set_query_body();
        $list = $model->get_list($query_body);
//        var_dump($list);
         $total = $model->getTotal_2($query_body);
        $pagination = $model->getPagination($total);

        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Danh sách User', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        include 'modules/' . $this->module . '/views/' . $this->view . '/list_user.php';
    }

    function history_learning() {

        global $user;
        $model = $this->model;
        $list_head = $model->get_list_head();

        $query_body = $model->set_query_body_2();

        $list_student = $model->get_list_2($query_body);
      
        $total = $model->getTotal($query_body);
        $pagination = $model->getPagination($total);

//        $list_student = $model->get_list_student();
        $query_body_3 = $model->set_query_body_3();
        $list_exam_per = $model->get_list($query_body_3);
//        var_dump($list_exam_per);die;
//        $list_exam_per = $model->get_records('userid=' . $user->userID, 'fs_exam');
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Lịch sử học tập', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        if ($user->userInfo->type == 2 || $user->userInfo->type == 1) {
            include 'modules/' . $this->module . '/views/' . $this->view . '/history_learning.php';
        } else if ($user->userInfo->type == 3) {
            $get_dtb = $model->get_DTB();
            include 'modules/' . $this->module . '/views/' . $this->view . '/history_learning_person.php';
        }
    }
    function histy_learning() {
  
        global $user;
        $model = $this->model;
        $list_head = $model->get_list_head();

        $query_body = $model->set_query_body_2();

        $list_student = $model->get_list_2($query_body);
      
        $total = $model->getTotal($query_body);
        $pagination = $model->getPagination($total);

//        $list_student = $model->get_list_student();
        $query_body_3 = $model->set_query_body_3();
        $list_exam_per = $model->get_list($query_body_3);
//        var_dump($list_exam_per);die;
//        $list_exam_per = $model->get_records('userid=' . $user->userID, 'fs_exam');
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Lịch sử học tập', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        if ($user->userInfo->type == 2 || $user->userInfo->type == 1) {
            include 'modules/' . $this->module . '/views/' . $this->view . '/history_learning.php';
        } else if ($user->userInfo->type == 3) {
            $get_dtb = $model->get_DTB();
            include 'modules/' . $this->module . '/views/' . $this->view . '/history_learning_person.php';
        }
    }

    function register_user() {
        global $user;
        $model = $this->model;

        $get_max_stt=$model->get_max_stt();
        $list_manager_user = $this->model->get_records('creator_id=' . $user->userID, 'fs_members');
  $get_posotion = $model->get_records('published = 1', 'fs_position');
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Tạo User', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        include 'modules/' . $this->module . '/views/' . $this->view . '/register_user.php';
    }

    function edit_user() {
        global $user;
        $model = $this->model;
        $id_user = FSInput::get('id');
        $list_manager_user = $this->model->get_records('creator_id=' . $user->userID, 'fs_members');
        $info_user = $this->model->get_record('id=' . $id_user, 'fs_members');
  $get_posotion = $model->get_records('published = 1', 'fs_position');
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Cập nhật User', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        include 'modules/' . $this->module . '/views/' . $this->view . '/edit_user.php';
    }

    function register_save() {

        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);
        $id = $model->save();

        // if not save
        if ($id) {
            // logged
//            $email = FSInput::get("email_register");
//            $name = explode('@', $email);
//            $_SESSION['fullname'] = $name[0];
//            $_SESSION['user_email'] = FSInput::get('email_register');
//            $_SESSION['user_id'] = $id;
            $link = FSRoute::_("index.php?module=users&task=list_user");
            $msg = "Bạn đã đăng ký tài khoản thành công!";
            setRedirect($link, $msg);
        } else {
            $link = URL_ROOT;
            $msg = FSText::_("Xin lỗi. Bạn chưa đăng ký thành công.");
            setRedirect($link, $msg, 'error');
        }
    }

    function update_user() {

        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);
        $id = $model->update_save();

        // if not save
        if ($id) {
            // logged
//            $email = FSInput::get("email_register");
//            $name = explode('@', $email);
//            $_SESSION['fullname'] = $name[0];
//            $_SESSION['user_email'] = FSInput::get('email_register');
//            $_SESSION['user_id'] = $id;
            $link = FSRoute::_("index.php?module=users&task=list_user");
            $msg = "Cập nhật user thành công!";
            setRedirect($link, $msg);
        } else {
            $link = URL_ROOT;
            $msg = FSText::_("Xin lỗi. Bạn chưa cập nhật user thành công!");
            setRedirect($link, $msg, 'error');
        }
    }

    function update_delegate() {

        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);
        $id = $model->delegate_save();
        // if not save
        if ($id) {
            $link = FSRoute::_("index.php?module=users&task=user_info");
            $msg = "Cập nhật user thành công!";
            setRedirect($link, $msg);
        } else {
            $link = URL_ROOT;
            $msg = FSText::_("Xin lỗi. Bạn chưa cập nhật user thành công!");
            setRedirect($link, $msg, 'error');
        }
    }

    function check_register_save() {
        // check pass
        $username = FSInput::get("username");
        FSFactory::include_class('errors');
        if (!$username) {
            Errors::setError(FSText::_("Chưa nhập username"));
            return false;
        }

        $password = FSInput::get("password");
        $re_password = FSInput::get("re_password");
        if (!$password || !$re_password) {
            Errors::setError(FSText::_("Chưa nhập mật khẩu"));
            return false;
        }
        if ($password != $re_password) {
            Errors::setError(FSText::_("Mật khẩu không trùng nhau"));
            return false;
        }

        $email = FSInput::get("email");
        $re_email = FSInput::get("re-email");
        if (!$email || !$re_email) {
            Errors::setError(FSText::_("Chưa nhập email"));
            return false;
        }
        if ($email != $re_email) {
            Errors::setError(FSText::_("Email nhập lại không khớp"));
            return false;
        }

        // check captcha				
        if (!$this->check_captcha()) {
//				Errors::setError(FSText::_("Mã hiển thị chưa đúng"));
            $this->alert_error('Mã hiển thị chưa đúng');
            return false;
        }

        $model = $this->model;
        // check email and identify card
        if (!$model->check_exits_email()) {
            return false;
        }
        if (!$model->check_exits_username()) {
            return false;
        }

        return true;
    }

    function check_exits_email() {
        $model = $this->model;
        if (!$model->check_exits_email())
            return false;
        return true;
    }

    function ajax_check_exist_dcs() {

        $model = $this->model;
        if (!$model->ajax_check_exist_dcs()) {
            echo 0;
            return false;
        }
        echo 1;
        return true;
    }

    function ajax_check_exist_cmt() {

        $model = $this->model;
        if (!$model->ajax_check_exist_cmt()) {
            echo 0;
            return false;
        }
        echo 1;
        return true;
    }

    function ajax_check_exist_username() {

        $model = $this->model;
        if (!$model->ajax_check_exits_username()) {
            echo 0;
            return false;
        }
        echo 1;
        return true;
    }

    function ajax_check_exist_email() {

        $model = $this->model;
        if (!$model->ajax_check_exits_email()) {
            echo 0;
            return false;
        }
        echo 1;
        return true;
    }

    /*
     * load District by city id. 
     * Use Ajax
     */

    function destination() {
        $model = $this->model;

        $cid = FSInput::get('cid');
        $did = FSInput::get('did');
        if ($cid) {
            $rs = $model->getDestination($cid);
        }
        if ($did) {
            $rs = $model->getDestination1($did);
        }
        $json = '[{id: 0,name: "Điểm đến"},'; // start the json array element
        $json_names = array();
        foreach ($rs as $item) {
            $json_names[] = "{id: $item->id, name: '$item->name'}";
        }
        $json .= implode(',', $json_names);
        $json .= ']'; // end the json array element
        echo $json;
    }

    /*
     * check valid Sim
     */

//		function check_valid_sim()
//		{
//		// check SIM
//			$model = $this -> model;
//			if(!$model->checkSimByAjax())
//			{
//				echo 0;
//				return;
//			}
//			echo 1;
//			return;
//		}
    function check_captcha() {
        $captcha = FSInput::get('txtcaptcha');
        if ($captcha == $_SESSION["security_code"]) {
            return true;
        } else {
            
        }
        return false;
    }

    function changepass() {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);
        include 'modules/' . $this->module . '/views/' . $this->view . '/changepass.php';
    }

    function edit_save_changepass() {
        // check logged
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);

        $link = FSRoute::_("index.php?module=users&task=user_info&Itemid=5");
        $link_err = FSRoute::_("index.php?module=users&task=changepass&Itemid=5");
        $check = $model->check_change_pass();
        if (!$check) {
            setRedirect($link_err, 'Mật khẩu cũ chưa chính xác', 'error');
        }

        if (!$this->check_captcha()) {

            setRedirect($link_err, 'Bạn nhập sai mã hiển thị', 'error');
        }
        $rs = $model->save_changepass();
        // if not save
//echo $rs;die;
        if ($rs) {
            $msg = FSText::_("Bạn đã thay đổi thành công");
            setRedirect($link, $msg);
        } else {
            $msg = FSText::_("Xin lỗi. Bạn chưa thay đổi thành công!");
            setRedirect($link_err, $msg, 'error');
        }
    }

    function change_email_save() {
        // check logged
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);

        $link = FSRoute::_("index.php?module=users&task=changepass&Itemid=$Itemid");
        $email_new = FSInput::get('email_new');
        if ($email_new) {

            $re_email_new = FSInput::get('re_email_new');
            if ($email_new != $re_email_new) {
                $msg = FSText::_("Email nh&#7853;p ch&#432;a kh&#7899;p!");
                setRedirect($link, $msg, 'error');
            }
            $check = $model->check_change_pass();
            if (!$check) {
                setRedirect($link, 'Email m&#7899;i c&#7911;a b&#7841;n &#273;&#227; t&#7891;n t&#7841;i trong h&#7879; th&#7889;ng. B&#7841;n ch&#432;a thay &#273;&#7893;i &#273;&#432;&#7907;c th&#244;ng tin', 'error');
            }
        }

        $rs = $model->save_changepass();
        // if not save


        if ($rs) {
            $msg = FSText::_("B&#7841;n &#273;&#227; thay &#273;&#7893;i th&#224;nh c&#244;ng");
            setRedirect($link, $msg);
        } else {
            $msg = FSText::_("Xin l&#7895;i, b&#7841;n &#273;&#227; thay &#273;&#7893;i kh&#244;ng th&#224;nh c&#244;ng!");
            setRedirect($link, $msg, 'error');
        }
    }

    /*
     * * Load list addbook
     * Get address book for search
     */

    function ajax_get_address_book_by_key() {
        $model = $this->model;
        $list = $model->get_address_book_by_key();
        $total = count($list);
        if (!$total) {
            $add_property = $model->get_address_book_properties();
            // convert to array
            $other_properties = array();
            foreach ($add_property as $item) {
                if (!isset($other_properties[$item->type]))
                    $other_properties[$item->type] = array();
                $other_properties[$item->type][] = $item;
            }
            // location	
            $countries = $model->get_countries();
            $country_current = isset($data->coutry_id) ? $data->coutry_id : 66; // default: VietNam
            $cities = $model->get_cities($country_current);
            $city_id_first = $cities[0]->id;
            $city_current = isset($data->city_id) ? $data->city_id : $city_id_first;
            $districts = $model->get_districts($city_current);
            $district_current = isset($data->district_id) ? $data->district_id : $districts[0]->id;
            $communes = $model->get_communes($district_current);
            $commune_current = isset($communes[0]->id) ? $communes[0]->id : 0;
            $categories = $model->get_records('published = 1', 'fs_address_book_categories', $select = 'id,name,parent_id', $ordering = ' ordering,id ');
        }
        include 'modules/' . $this->module . '/views/' . $this->view . '/register_address_book.php';
    }

    function ajax_add_address_book_form() {
        $model = $this->model;
        $add_property = $model->get_address_book_properties();
        // convert to array
        $other_properties = array();
        foreach ($add_property as $item) {
            if (!isset($other_properties[$item->type]))
                $other_properties[$item->type] = array();
            $other_properties[$item->type][] = $item;
        }

        // location	
        $countries = $model->get_countries();
        $country_current = 66; // default: VietNam
        $cities = $model->get_cities($country_current);
        $city_current = isset($cities[0]->id) ? $cities[0]->id : 0;
        $districts = $model->get_districts($city_current);
        $district_current = isset($data->district_id) ? $data->district_id : $districts[0]->id;
        $communes = $model->get_communes($district_current);
        $commune_current = isset($communes[0]->id) ? $communes[0]->id : 0;
        $categories = $model->get_records('published = 1', 'fs_address_book_categories', $select = 'id,name,parent_id', $ordering = ' ordering,id ');
        include 'modules/' . $this->module . '/views/' . $this->view . '/register_add_addressbook.php';
    }

    /*
     * Get address book for search
     */

    function ajax_load_address_book_by_id() {
        $model = $this->model;
        $id = FSInput::get('id', 'int', 0);
        if (!$id)
            return;
        $data = $model->get_record_by_id($id, 'fs_address_book');
        if (!$data)
            return;
        $add_property = $model->get_address_book_properties();
        // convert to array
        $other_properties = array();
        foreach ($add_property as $item) {
            if (!isset($other_properties[$item->type]))
                $other_properties[$item->type] = array();
            $other_properties[$item->type][] = $item;
        }
        // location	
        $countries = $model->get_countries();
        $country_current = isset($data->coutry_id) ? $data->coutry_id : 66; // default: VietNam
        $cities = $model->get_cities($country_current);
        $city_id_first = $cities[0]->id;
        $city_current = isset($data->city_id) ? $data->city_id : $city_id_first;
        $districts = $model->get_districts($city_current);
        $district_current = isset($data->district_id) ? $data->district_id : $districts[0]->id;
        $communes = $model->get_communes($district_current);
        $commune_current = isset($data->commune_id) ? $data->commune_id : $communes[0]->id;
        $categories = $model->get_records('published = 1', 'fs_address_book_categories', $select = 'id,name,parent_id', $ordering = ' ordering,id ');

        include 'modules/' . $this->module . '/views/' . $this->view . '/register_load_address_book.php';
    }

    // function bitly() {
    //     $fssecurity = FSFactory::getClass('fssecurity');
    //     $fssecurity->checkLogin();

    //     $user_id = $_SESSION['user_id'];
    //     $point = FSFactory::getClass('fspoint');
    //     $point = $point->total_point($user_id);

    //     //Cấu  hình điểm 
    //     $global_class = FSFactory::getClass('FsGlobal');

    //     $point_gold = $global_class->getConfigPoint('point_gold');
    //     $point_silver = $global_class->getConfigPoint('point_silver');
    //     $point_bronze = $global_class->getConfigPoint('point_bronze');
    //     $icon_point = '';
    //     if ($point >= $point_bronze && $point < $point_silver)
    //         $icon_point = 'images/icon_bronze.png';
    //     else if ($point >= $point_silver && $point < $point_gold)
    //         $icon_point = 'images/icon_silver.png';
    //     else if ($point >= $point_gold)
    //         $icon_point = 'images/icon_gold.png';

    //     $model = $this->model;
    //     $data = $model->getMember();

    //     FSFactory::include_class('Bitly');
    //     $bitly = new Bitly("R_9c58a65325cb4b84a3135a2bd6747ea4", "o_7sp3k7hqbc", "62a7343d70fbabf1140243cf0e865568c1f4ebf6", "7f6c5cda8f1183bb994880e8f5e5f8fe8c71c352", "http://api.bit.ly/v3/", "https://api-ssl.bit.ly/v3/", "https://api-ssl.bit.ly/oauth/");

    //     $link = FSRoute::_("index.php?module=users&task=view&task=bitly_coutn&user_id=" . base64_encode($data->id));

    //     $bitly_v3_shorten = $bitly->bitly_v3_shorten($link, '213d92530afa51a9e5f42f3eea37c779ca42d0f1', 'bit.ly', 'o_7sp3k7hqbc', 'R_9c58a65325cb4b84a3135a2bd6747ea4');
    //     //breadcrumbs
    //     $breadcrumbs = array();
    //     $breadcrumbs[] = array(0 => 'Giới thiệu bạn bè', 1 => '');
    //     global $tmpl;
    //     $tmpl->assign('breadcrumbs', $breadcrumbs);

    //     include 'modules/' . $this->module . '/views/' . $this->view . '/bitly.php';
    // }

    function bitly_coutn() {
        $user_id = FSInput::get('user_id');
        if (!$user_id)
            return;
        FSFactory::include_class('Bitly');
        $bitly = new Bitly("R_9c58a65325cb4b84a3135a2bd6747ea4", "o_7sp3k7hqbc", "62a7343d70fbabf1140243cf0e865568c1f4ebf6", "7f6c5cda8f1183bb994880e8f5e5f8fe8c71c352", "http://api.bit.ly/v3/", "https://api-ssl.bit.ly/v3/", "https://api-ssl.bit.ly/oauth/");

        $link = FSRoute::_("index.php?module=users&task=view&task=bitly_coutn&user_id=" . $user_id);

        $bitly_v3_shorten = $bitly->bitly_v3_shorten($link, '213d92530afa51a9e5f42f3eea37c779ca42d0f1', 'bit.ly', 'o_7sp3k7hqbc', 'R_9c58a65325cb4b84a3135a2bd6747ea4');

        $bitly_v3_clicks = $bitly->bitly_v3_clicks($bitly_v3_shorten['url']);
        if (!$bitly_v3_clicks)
            return;
        $bitly_count = $bitly_v3_clicks[0]['user_clicks'];
        $model = $this->model;
        $data = $model->add_point($user_id, $bitly_count);
        setRedirect(URL_ROOT, '');
    }

    function redeem_points() {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();

        $user_id = $_SESSION['user_id'];
        $point = FSFactory::getClass('fspoint');
        $point = $point->total_point($user_id);

        //Cấu  hình điểm 
        $global_class = FSFactory::getClass('FsGlobal');

        $point_gold = $global_class->getConfigPoint('point_gold');
        $point_silver = $global_class->getConfigPoint('point_silver');
        $point_bronze = $global_class->getConfigPoint('point_bronze');
        $icon_point = '';
        if ($point >= $point_bronze && $point < $point_silver)
            $icon_point = 'images/icon_bronze.png';
        else if ($point >= $point_silver && $point < $point_gold)
            $icon_point = 'images/icon_silver.png';
        else if ($point >= $point_gold)
            $icon_point = 'images/icon_gold.png';

        include 'modules/' . $this->module . '/views/' . $this->view . '/redeem_points.php';
    }

    function list_gift() {

        $user_id = $_SESSION['user_id'];
        $point = FSFactory::getClass('fspoint');
        $point = $point->total_point($user_id);

        //Cấu  hình điểm 
        $global_class = FSFactory::getClass('FsGlobal');

        $point_gold = $global_class->getConfigPoint('point_gold');
        $point_silver = $global_class->getConfigPoint('point_silver');
        $point_bronze = $global_class->getConfigPoint('point_bronze');
        $icon_point = '';
        if ($point >= $point_bronze && $point < $point_silver)
            $icon_point = 'images/icon_bronze.png';
        else if ($point >= $point_silver && $point < $point_gold)
            $icon_point = 'images/icon_silver.png';
        else if ($point >= $point_gold)
            $icon_point = 'images/icon_gold.png';

        $link = FSRoute::_('index.php?module=users&view=users&task=redeem_points');

        $point_request = FSInput::get('point');
        if ($point_request > $point) {
            $msg = 'Số điểm bạn nhập lớn hơn số điểm hiện có';
            setRedirect($link, $msg, 'error');
        }

        $model = $this->model;
        $list = $model->get_gift();
        if (!$list) {
            $msg = 'Không tìm thấy quà tặng nào tương ứng';
            setRedirect($link, $msg, 'error');
        }
        include 'modules/' . $this->module . '/views/' . $this->view . '/list_gift.php';
    }

    function order_gift() {
        $link = FSRoute::_('index.php?module=users&view=users&task=redeem_points');
        $point_request = FSInput::get('point');

        $model = $this->model;
        $rs = $model->save_order_gift();
        if ($rs) {
            $msg = FSText::_("Bạn đã đổi quà tặng thành công. Chúng tôi sẽ liên hệ với bạn trong thời gian ngắn nhất");
            setRedirect($link, $msg);
        } else {
            $msg = FSText::_("Xin lỗi. Bạn chưa đổi thành công!");
            setRedirect($link, $msg, 'error');
        }
    }

    function export() {
        
        setRedirect('index.php?module=' . $this->module . '&view=' . $this->view . '&task=export_file&raw=1');
    }  
      function export_list_user() {
        
        setRedirect('index.php?module=' . $this->module . '&view=' . $this->view . '&task=export_file_user&raw=1');
    }

    
   function export_file(){

       ob_start();

        require(PATH_BASE.'libraries/excel/PHPExcel_/PHPExcel.php');
        
        $objPHPExcel = new PHPExcel();

//        $objPHPExcel->getProperties()->setCreator("Sevenam")
//            ->setLastModifiedBy("Sevenam")
//            ->setTitle("Office 2007 XLSX Vietrade Document")
//            ->setSubject("Office 2007 XLSX Vietrade Document")
//            ->setDescription("Sevenam report ".date('d-m-Y'))
//            ->setKeywords("Sevenam report")
//            ->setCategory("Sevenam report");

        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(20);
        $sheet->getColumnDimension('N')->setWidth(20);

//        $sheet->mergeCells("A1:K1");
//        $sheet->setCellValue('A1', 'Lịch sử học tập');
//        $sheet->getStyle("A1")->getFont()->setSize(15)->setBold(true);
//        $sheet->getStyle('A1')->getAlignment()->applyFromArray(
//            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
//        );
        ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(0);
        $sheet->setCellValue('A1', FSText::_('Số TT'));
        $sheet->setCellValue('B1', FSText::_('Mã Head'));
        $sheet->setCellValue('C1', FSText::_('Tên Head'));
        $sheet->setCellValue('D1', FSText::_('Tỉnh/ Thành phố'));
        $sheet->setCellValue('E1', FSText::_('Họ và tên học viên'));
        $sheet->setCellValue('F1', FSText::_('Mã code DCS'));
        $sheet->setCellValue('G1', FSText::_('Giới tính'));
        $sheet->setCellValue('H1', FSText::_('Số điện thoại'));
        $sheet->setCellValue('I1', FSText::_('Email'));
        $sheet->setCellValue('J1', FSText::_('Số lần làm bài'));
        $sheet->setCellValue('K1', FSText::_('Điểm trung bình'));
        $sheet->setCellValue('L1', FSText::_('Vị trí công việc'));
        $sheet->setCellValue('M1', FSText::_('Trạng thái'));
        $sheet->setCellValue('N1', FSText::_('Username'));
        $sheet->getStyle('A1:K1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        );
        $sheet->getStyle("A1:K1")->getFont()->setSize(13);

        $cCell = 1;
//        $list = $this->model->get_data();
//          $query_body = $this->model->set_query_body_2();

        $list = $this->model->get_data_for_export();
        // echo count($list);die;
      $key=2;
        foreach($list as $item){
            // $pos = $this->model->get_record_by_id($item->position,'fs_position','name');

           // $key = isset($key)?($key+1):2;
            $sheet->setCellValue('A'.$key, $cCell);
            $sheet->setCellValue('B'.$key, $item->creator_name);
            $sheet->setCellValue('C'.$key, '');
            $sheet->setCellValue('D'.$key, $item->city_name);
            $sheet->setCellValue('E'.$key, $item->name);
            $sheet->setCellValue('F'.$key, $item->code_dcs);
            $sheet->setCellValue('G'.$key, $item->sex);
            $sheet->setCellValue('H'.$key, $item->telephone);
            $sheet->setCellValue('I'.$key, $item->email);
            $sheet->setCellValue('J'.$key, $item->num_exam);
            $sheet->setCellValue('K'.$key, $item->DTB);
            $sheet->setCellValue('L'.$key, @$item->vi_tri);
            $sheet->setCellValue('M'.$key, ($item->published==1)?'Đang hoạt động':'Đã nghỉ' );
            $sheet->setCellValue('N'.$key, $item->username);
            $sheet->getStyle('A'.$key.':B'.$key)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            );

            $sheet->getStyle('F'.$key.':K'.$key)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            );
            $cCell++;
    $key++;
        } 

            // die();
//        $sheet->getStyle('C2:C'.$cCell)
//            ->getAlignment()
//            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP)
//            ->setWrapText(true);

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $sheet->getStyle(
            'A1:' .
            $sheet->getHighestColumn() .
            $sheet->getHighestRow()
        )->applyFromArray($styleArray);
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="lich-su-hoc-tap-'.date('d-m-Y').'.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
ob_end_clean();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    } 
    

     function export_file_user(){

       ob_start();

        require(PATH_BASE.'libraries/excel/PHPExcel_/PHPExcel.php');
        
        $objPHPExcel = new PHPExcel();

//        $objPHPExcel->getProperties()->setCreator("Sevenam")
//            ->setLastModifiedBy("Sevenam")
//            ->setTitle("Office 2007 XLSX Vietrade Document")
//            ->setSubject("Office 2007 XLSX Vietrade Document")
//            ->setDescription("Sevenam report ".date('d-m-Y'))
//            ->setKeywords("Sevenam report")
//            ->setCategory("Sevenam report");

        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(40);
        $sheet->getColumnDimension('J')->setWidth(20);

//        $sheet->mergeCells("A1:K1");
//        $sheet->setCellValue('A1', 'Lịch sử học tập');
//        $sheet->getStyle("A1")->getFont()->setSize(15)->setBold(true);
//        $sheet->getStyle('A1')->getAlignment()->applyFromArray(
//            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
//        );
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

        $sheet->setCellValue('A1', FSText::_('Số TT'));
        $sheet->setCellValue('B1', FSText::_('Mã Head'));
        $sheet->setCellValue('C1', FSText::_('Họ và tên học viên'));
        $sheet->setCellValue('D1', FSText::_('Username'));
        $sheet->setCellValue('E1', FSText::_('Email'));
        $sheet->setCellValue('F1', FSText::_('Số điện thoại'));
        $sheet->setCellValue('G1', FSText::_('Giới tính'));
        $sheet->setCellValue('H1', FSText::_('Trạng thái'));
        $sheet->setCellValue('I1', FSText::_('Vị trí công việc'));
        $sheet->setCellValue('J1', FSText::_('Mã code DCS'));
        $sheet->getStyle('A1:J1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        );
        $sheet->getStyle("A1:J1")->getFont()->setSize(13);

        $cCell = 1;
//        $list = $this->model->get_data();
//          $query_body = $this->model->set_query_body_2();

        $list = $this->model->get_data_for_export_user();

      $key=2;
        foreach($list as $item){
            // $pos = $this->model->get_record_by_id($item->position,'fs_position','name');

           // $key = isset($key)?($key+1):2;
            $sheet->setCellValue('A'.$key, $cCell);
            $sheet->setCellValue('B'.$key, @$item->creator_name);
            $sheet->setCellValue('C'.$key, @$item->name);
            $sheet->setCellValue('D'.$key, @$item->username);
            $sheet->setCellValue('E'.$key, @$item->email);
            $sheet->setCellValue('F'.$key, @$item->telephone);
            $sheet->setCellValue('G'.$key, (@$item->sex==1)?'Nam':'Nữ');
            $sheet->setCellValue('H'.$key, (@$item->published==1)?'Đang hoạt động':'Đã nghỉ' );
            $sheet->setCellValue('I'.$key, @$item->vi_tri);
             $sheet->setCellValue('J'.$key, @$item->code_dcs);
            $sheet->getStyle('A'.$key.':B'.$key)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            );


            $sheet->getStyle('F'.$key.':J'.$key)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            );

            $cCell++;
    $key++;

        } 
            // die();
//        $sheet->getStyle('C2:C'.$cCell)
//            ->getAlignment()
//            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP)
//            ->setWrapText(true);

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $sheet->getStyle(
            'A1:' .
            $sheet->getHighestColumn() .
            $sheet->getHighestRow()
        )->applyFromArray($styleArray);
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="danh-sach-user-'.date('d-m-Y').'.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
ob_end_clean();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    } 
    
    
    
    function export_file_() {
 
        FSFactory::include_class('excel', 'excel');
//			require_once 'excel.php';
        $model = $this->model;
        $filename = 'lich-su-hoc-tap-export';
          $query_body = $model->set_query_body_2();
        $list = $model->get_list_2($query_body);
//        $categories = $model->get_records('', 'fs_products_categories', 'id,code,alias,name,tablename', '', '', 'id');
        if (empty($list)) {
            echo 'error';
            exit;
        } else {
            $excel = FSExcel();
            $excel->set_params(array('out_put_xls' => 'export/excel/' . $filename . '.xls', 'out_put_xlsx' => 'export/excel/' . $filename . '.xlsx'));
            $style_header = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ffff00'),
                ),
                'font' => array(
                    'bold' => true,
                )
            );
            $style_header1 = array(
                'font' => array(
                    'bold' => true,
                )
            );

            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(60);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('M')->setWidth(30);


            $excel->obj_php_excel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);


            $excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'STT');
//				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Category');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Mã HEAD');
            //	$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Image');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Tên HEAD');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Tỉnh/ Thành Phố');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Họ tên học viên');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'Mã code DCS'); // overview
            $excel->obj_php_excel->getActiveSheet()->setCellValue('G1', 'Giới tính'); // Specs
            $excel->obj_php_excel->getActiveSheet()->setCellValue('H1', 'Số điện thoại'); // ProDescription
            $excel->obj_php_excel->getActiveSheet()->setCellValue('I1', 'Email'); // driverLink
            $excel->obj_php_excel->getActiveSheet()->setCellValue('J1', 'Số lần làm bài');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('K1', 'Điểm trung bình');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('L1', 'Vị trí công việc');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('M1', 'Trạng thái');
            $i = 0;
            $total_money = 0;
            $total_quantity = 0;
            foreach ($list as $item) {
                $key = isset($key) ? ($key + 1) : 2;
                $excel->obj_php_excel->getActiveSheet()->setCellValue('A' . $key, $i+1);
//					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, @$categories[$item->category_id]->code);		
                $excel->obj_php_excel->getActiveSheet()->setCellValue('B' . $key, $item->creator_name);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('C' . $key, '');
                $excel->obj_php_excel->getActiveSheet()->setCellValue('D' . $key, $item->city_name);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('E' . $key, $item->name);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('F' . $key, $item->code_dcs);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('G' . $key, $item->sex); // đang làm
                $excel->obj_php_excel->getActiveSheet()->setCellValue('H' . $key, $item->telephone);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('I' . $key, $item->email);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('J' . $key, $item->num_exam);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('K' . $key, $item->DTB);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('L' . $key, $item->position);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('M' . $key, $item->published);
                $excel->obj_php_excel->getActiveSheet()->getRowDimension($i + 2)->setRowHeight(20);
                $i ++;
            }
//				$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.($i+2), 'Tổng');
//				$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.($i+2), $total_quantity);
//				$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.($i+2), $total_money);

            $excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_header);
            $excel->obj_php_excel->getActiveSheet()->duplicateStyle($excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:L1');

//				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getAlignment()->setIndent(1);// padding cell

            $output = $excel->write_files();

            $path_file = PATH_ADMINISTRATOR . DS . str_replace('/', DS, $output['xls']);
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            header("Content-type: application/force-download");
            header("Content-Disposition: attachment; filename=\"" . $filename . '.xls' . "\";");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: " . filesize($path_file));
            readfile($path_file);
        }
    }

//      function do_forgot_pass() {
//        ob_start();
//        global $user;
//        $json = array(
//            'error' => true,
//            'message' => 'Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.',
//            'redirect' => URL_ROOT
//        );
//        $username = FSInput::get('username', '', 'str');
//        $email = FSInput::get('email', '', 'str');
//        $redirect = FSInput::get('redirect', '', 'str');
//        $forgot = $user->forgot($username, $email);
//        if ($forgot) {
//            $activated_code = rand(100000, 999999);
//            $user->updateUser(array('activated_code' => $activated_code), $forgot->id);
//            $json['error'] = false;
//            $json['message'] = 'Bạn đã gửi <b>yêu cầu đổi mật khẩu</b> thành công.<br />Bạn vui lòng <b>kiểm tra email</b> để thực hiện tiếp theo.';
//            $msg = 'Chào <b>' . $forgot->fullname . '</b><br /><br />
//                    Yêu cầu đổi mật khẩu của bạn đã được gửi đi. Vui lòng <a href="' . FSRoute::_('index.php?module=members&view=members&task=update_forgot_pass') . '?data=' . fsEncode($forgot->id) . '">click vào đây</a>, để thực hiện bước tiếp theo.<br /><br />
//                    Mã bảo mật của bạn: <b>' . $activated_code . '</b><br /><br />
//                    Cảm ơn!';
//            sendMailFS('Yêu cầu đổi mật khẩu tại ' . $_SERVER['SERVER_NAME'], $msg, $forgot->fullname, $forgot->email);
//        } else {
//            $json['message'] = 'Tên đăng nhập hoặc email không đúng.';
//        }
//        ob_end_clean();
//        echo json_encode($json);
//    }
//    function do_forgot_pass() {
//      echo '123';die;
//        ob_start();
//        global $user;
//        $json = array(
//            'error' => true,
//            'message' => 'Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.',
//            'redirect' => URL_ROOT
//        );
//        $username = FSInput::get('username', '', 'str');
//      
//        $email = FSInput::get('email', '', 'str');
//      
//         $redirect = FSInput::get('redirect', '', 'str');
//        $forgot = $user->forgot($username, $email);
//
//        if ($forgot) {
//            $activated_code = rand(100000, 999999);
//            $user->updateUser(array('activated_code' => $activated_code), $forgot->id);
//            $json['error'] = false;
//            $json['message'] = 'Bạn đã gửi yêu cầu đổi mật khẩu thành công.Bạn vui lòng kiểm tra email để thực hiện tiếp theo.';
//            $json['redirect'] =$redirect;
//            $msg = 'Chào <b>' . $username . '</b><br /><br />
//                    Yêu cầu đổi mật khẩu của bạn đã được gửi đi. Vui lòng <a href="' . FSRoute::_('index.php?module=users&view=users&task=update_forgot_pass') . '?data=' . fsEncode($forgot->id) . '">click vào đây</a>, để thực hiện bước tiếp theo.<br /><br />
//                    Mã bảo mật của bạn: <b>' . $activated_code . '</b><br /><br />
//                    Cảm ơn!';
//
//            sendMailFS('Yêu cầu đổi mật khẩu tại ' . $_SERVER['SERVER_NAME'], $msg, $forgot->username, $forgot->email);
//             setRedirect(URL_ROOT,    $json['message']);
//            
//        } else {
//             setRedirect(FSRoute::_('index.php?module=users&view=users&task=forgot_pass&Itemid=100'), 'Tên đăng nhập hoặc email không đúng!');
//        }
////        ob_end_clean();
////        echo json_encode($json);
//    }
}

?>
