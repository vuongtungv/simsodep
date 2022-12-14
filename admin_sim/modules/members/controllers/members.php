<?php

class MembersControllersMembers extends Controllers {

    function __construct() {
        $this->view = 'members';
        parent::__construct();
    }

    function display() {
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;

        $model = $this->model;
        //$group = $model -> get_records('published = 1','fs_members_group','*','ordering DESC');
        //$cities = $model-> get_cities_name();
        $list = $model->get_data('');
        $cities = $model->get_records('published = 1', 'fs_cities','*','name ASC');
        $get_posotion = $model->get_records('published = 1', 'fs_position');
        $pagination = $model->getPagination('');
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }

    function add() {
        $model = $this->model;
        $maxOrdering = $model->getMaxOrdering();
        $cities = $model->get_records('published = 1', 'fs_cities','*','name ASC');
//        var_dump($cities);
        $get_department = $model->get_records('published = 1', 'fs_department');
        $get_members_head = $model->get_records('published = 1 AND type=2', 'fs_members');
        $get_posotion = $model->get_records('published = 1', 'fs_position');
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function edit() {
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $model = $this->model;
        $cities = $model->get_records('published = 1', 'fs_cities','*','name ASC');
        $data = $model->get_record_by_id($id);
//        testVar($data);

        $get_department = $model->get_records('published = 1', 'fs_department');
        $get_members_head = $model->get_records('published = 1 AND type=2', 'fs_members');
        $get_posotion = $model->get_records('published = 1', 'fs_position');
        if (!$data)
            die('Not found url');
        //$group = $model -> get_records('published = 1','fs_members_group','*','ordering DESC');
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function save() {
       
        $model = $this->model;
        $id = FSInput::get('id');
//        if (!$id) {
//            if ($model->check_exits_email()) {
//                setRedirect('index.php?module=members&view=members', FSText :: _('Email n??y ???? c?? ng?????i s??? d???ng'), 'error');
//            }
//            if ($model->check_exits_username()) {
//                setRedirect('index.php?module=members&view=members', FSText :: _('Username n??y ???? c?? ng?????i s??? d???ng'), 'error');
//            }
//        }
        // check password and repass
        $password = FSInput::get("password");
        $repass = FSInput::get("re-password");
       
        if (@$id) {
            $edit_pass = FSInput::get('edit_pass');
            
            if ($edit_pass) { 
                if (!$password || ($password != $repass)) {
                    setRedirect('index.php?module=members&view=members', FSText :: _('You must enter a valid password'), 'error');
                }
            }
        } else {
            if (!$password || ($password != $repass))
                setRedirect('index.php?module=members&view=members', FSText :: _('You must enter a valid password'), 'error');
        }

        // call Models to save
        $cid = $model->save();

        if ($cid) {
            setRedirect('index.php?module=members&view=members&cid=' . $cid, FSText :: _('Saved'));
        } else {
            setRedirect('index.php?module=members&view=members', FSText :: _('Not save'), 'error');
        }
    }

    function login() {
        $id = FSInput::get('id', 0, 'int');
        if (!$id)
            setRedirect('index.php?module=' . $this->module . '&view=' . $this->view, FSText::_('????ng nh???p kh??ng th??nh c??ng'));

        $this->logout();

        $model = $this->model;
        $user = $model->get_record_by_id($id, 'fs_members_seekers', 'id,username,full_name,email,published_info');
        if (!$user)
            setRedirect('index.php?module=' . $this->module . '&view=' . $this->view, FSText::_('????ng nh???p kh??ng th??nh c??ng'));

        $_SESSION['fullname'] = $user->full_name;
        $_SESSION['username'] = $user->username;
        $_SESSION['user_id'] = $user->id;
        $_SESSION['email'] = $user->email;
        $_SESSION['published_info'] = $user->published_info;

        setcookie("email", $user->email, time() + 200000000, '/');
        setcookie("fullname", $user->full_name, time() + 200000000, '/');
        setcookie("username", $user->username, time() + 200000000, '/');
        setcookie("user_id", $user->id, time() + 200000000, '/');
        setcookie("published_info", $user->published_info, time() + 200000000, '/');

        $link = URL_ROOT;
        $msg = FSText::_(" B???n ???? ????ng nh???p th??nh c??ng ");
        setRedirect($link, $msg);
    }

    function logout() {
        unset($_SESSION['fullname']);
        unset($_SESSION['username']);
        unset($_SESSION['user_id']);
        unset($_SESSION['email']);
        unset($_SESSION['published_info']);

        setcookie("email", '', time() - 200000000, '/');
        setcookie("user_id", '', time() - 200000000, '/');
        setcookie("fullname", '', time() - 200000000, '/');
        setcookie("username", '', time() - 200000000, '/');
        setcookie("published_info", '', time() - 200000000, '/');
        //session_unset();
        //if (isset($_SERVER['HTTP_COOKIE'])) {
//                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
//                foreach($cookies as $cookie) {
//                    $parts = explode('=', $cookie);
//                    $name = trim($parts[0]);
//                    setcookie($name, '', time()-200000000);
//                    setcookie($name, '', time()-200000000, '/');
//                }
//            }
        //$Itemid = FSInput::get("Itemid",1);
        //$link = FSRoute::_("index.php?module=employer&view=home&Itemid=$Itemid");
        //setRedirect($link);
    }

    function view_title($data) {
        $link = URL_ROOT . $data->username;
        return '<a target="_blink" href="' . $link . '" title="view font-end">' . $data->username . '</a>';
    }

    // Excel to??n b??? danh s??ch copper ra excel
    function export() {
        setRedirect('index.php?module=' . $this->module . '&view=' . $this->view . '&task=export_file&raw=1');
    }
  function export_file() {
        FSFactory::include_class('excel', 'excel');
        $model = $this->model;
        $filename = 'Danh-sach-thanh-vien';
         $list = $model->get_data_member('');
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
          $excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'T??n truy c???p');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'H??? v?? t??n');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('C1', '?????a ch???');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Email');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('E1', '??i???n tho???i');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'CMT');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('G1', 'Code_dcs');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('H1', 'Head');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('I1', 'Ng?????i ph??? tr??ch');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('K1', 'SDT ng?????i ph??? tr??ch');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('L1', 'Email ng?????i ph??? tr??ch');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('M1', 'Tr???ng th??i');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('N1', 'V??? tr?? c??ng vi???c');
            foreach ($list as $item) {
                $key = isset($key) ? ($key + 1) : 2;
                $excel->obj_php_excel->getActiveSheet()->setCellValue('A' . $key, $item->username);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('B' . $key, $item->name);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('C' . $key, $item->city_name);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('D' . $key, $item->email);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('E' . $key, $item->telephone);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('F' . $key, $item->cmt);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('G' . $key, $item->code_dcs);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('H' . $key, $item->creator_name);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('I' . $key, $item->delegate_name);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('K' . $key, $item->delegate_phone);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('L' . $key, $item->delegate_email);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('M' . $key, $item->published);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('N' . $key, $item->vi_tri);
            }
            $excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_header);
            $excel->obj_php_excel->getActiveSheet()->duplicateStyle($excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1');
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
    function export_file_() {
        FSFactory::include_class('excel', 'excel');
//			require_once 'excel.php';
        $model = $this->model;
        $filename = 'member-export';
//        $list = $model->get_member_info();
          $list = $model->get_data('');
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
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'T??n truy c???p');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'H??? v?? t??n');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('C1', '?????a ch???');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Email');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('E1', '??i???n tho???i');
            foreach ($list as $item) {
                $key = isset($key) ? ($key + 1) : 2;
                $excel->obj_php_excel->getActiveSheet()->setCellValue('A' . $key, $item->username);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('B' . $key, $item->name);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('C' . $key, $item->city_name);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('D' . $key, $item->email);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('E' . $key, $item->telephone);
            }
            $excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_header);
            $excel->obj_php_excel->getActiveSheet()->duplicateStyle($excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1');
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

    // Excel to??n b??? danh s??ch copper ra excel
    function export_excel() {
        require_once 'excel.php';
        $model = $this->model;
        $start = FSInput::get('start');
        $start = (isset($start) && !empty($start)) ? $start : 1;
        $start = $start - 1;
        $end = FSInput::get('end');
        $end = (isset($end) && !empty($end)) ? $end : 10;
        $list = $model->get_member_info($start, $end);
        if (empty($list)) {
            echo 'error';
            exit;
        } else {
            $excel = V_Excel();
            $excel->set_params(array('out_put_xls' => 'export/excel/' . 'danh_sach_' . date('H-i_j-n-Y', time()) . '.xls', 'out_put_xlsx' => 'export/excel/' . 'danh_sach_' . date('j-n-Y', time()) . '.xlsx'));
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
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'T??n truy c???p');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'H??? v?? t??n');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('C1', '?????a ch???');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Email');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('E1', '??i???n tho???i');
            foreach ($list as $item) {
                $key = isset($key) ? ($key + 1) : 2;
                $excel->obj_php_excel->getActiveSheet()->setCellValue('A' . $key, $item->username);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('B' . $key, $item->name);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('C' . $key, $item->cityn_ame);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('D' . $key, $item->email);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('E' . $key, $item->telephone);
            }
            $excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_header);
            $excel->obj_php_excel->getActiveSheet()->duplicateStyle($excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1');
            $output = $excel->write_files();
            echo URL_ROOT . 'ione_admin/' . $output['xls'];
        }
    }

    function quality_export() {
        $html = '<form id="form1" name="form1" method="post" >';
        $html.='<h1 style="color:#FF0000; text-align:center">B???n h??y ??i???n s??? th??? t??? c???a b???n ghi mu???n export</h1>';
        $html.='<p style="text-align:center"><label>B???t ?????u :</label>';
        $html.='<input type="text" name="start_at" id="start_at" /><br />';
        $html.='<label>K???t th??c: </label><input type="text" name="end_at" id="end_at" /><br><span>N???u b???n kh??ng nh???p s??? th??? t??? th?? h??? th???ng s??? t??? export t??? 1 - 10</span></p>';
        $html.='<p style="text-align:center">';
        $html.='<label>';
        $html.='<input onclick="javascript:configClickExport();" type="submit" name="submit_quality" id="submit_quality" value="Ok" />';
        $html.='</label>';
        $html.='</p>';
        $html.='</form>';
        print_r($html);
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

}

?>