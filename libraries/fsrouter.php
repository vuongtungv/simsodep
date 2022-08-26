<?php

class FSRoute {

    var $url;

    function __construct($url) {
        
    }

    static function _($url) {
        return FSRoute::enURL($url);
    }

    /*
     * Trả lại tên mã hóa trên URL
     */

    static function get_name_encode($name, $lang) {
        $lang_url = array();

        if ($lang == 'vi')
            return $name;
        else
            return $lang_url[$name];
    }

    static function addParameters($params, $value, $module = '', $view = '') {
        // only filter
        if (!$module) {
            $module = FSInput::get('module');
            //$view = FSInput::get('view');
            if (!$view) {
                //$module = FSInput::get('module');
                $view = FSInput::get('view');
            }
        }

        return FSRoute :: _($_SERVER['REQUEST_URI']);
    }

    static function addPram($params,$link) {

        if (!$params) {
            return $link;
        }
        
        foreach ($params as $key => $value) {
            $tail .=  $key.'='.$value.'&';
        }
        $tail = rtrim($tail,"&");
        $link = $link.'?'.$tail;

        return $link;
    }

    function removeParameters($params) {
        // only filter
        $module = FSInput::get('module');
        $view = FSInput::get('view');
        $ccode = FSInput::get('ccode');
        $filter = FSInput::get('filter');
        $manu = FSInput::get('manu');
        $Itemid = FSInput::get('Itemid');

        $url = 'index.php?module=' . $module . '&view=' . $view;
        if ($ccode) {
            $url .= '&ccode=' . $ccode;
        }
        if ($filter) {
            $url .= '&filter=' . $filter;
        }
        $url .= '&Itemid=' . $Itemid;
        $url = trim(preg_replace('/&' . $params . '=[0-9a-zA-Z_-]+/i', '', $url));
    }

    /*
     * rewrite
     */

    static function enURL($url) {
        if (!$url)
            $url = $_SERVER['REQUEST_URI'];

        if (!IS_REWRITE)
            return URL_ROOT . $url;
        if (strpos($url, 'http://') !== false || strpos($url, 'https://') !== false)
            return $url;

        $url_reduced = substr($url, 10); // width : index.php
        $array_buffer = explode('&', $url_reduced, 10);
        $array_params = array();
        for ($i = 0; $i < count($array_buffer); $i ++) {
            $item = $array_buffer[$i];
            $pos_sepa = strpos($item, '=');
            $array_params[substr($item, 0, $pos_sepa)] = substr($item, $pos_sepa + 1);
        }

        $module = isset($array_params['module']) ? $array_params['module'] : '';
        $view = isset($array_params['view']) ? $array_params['view'] : $module;
        $task = isset($array_params['task']) ? $array_params['task'] : 'display';
        $Itemid = isset($array_params['Itemid']) ? $array_params['Itemid'] : 0;
        //$location  = isset($array_params['location'])?$array_params['location']: CITY;

        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'vi';
        $url_first = URL_ROOT;
        $url1 = '';
        switch ($module) {
            case 'signedsim':
                switch ($view) {
                    case 'signedsim':
                        return $url_first.'ky-gui-sim.html';
                    default:
                        return $url_first . $url;
                }
                break;
            case 'deprecate':
                switch ($view) {
                    case 'deprecate':
                        return $url_first.'tim-sim-theo-yeu-cau.html';
                    default:
                        return $url_first . $url;
                }
                break;
            case 'sim_network':
                switch ($view) {
                    case 'home':
                        $type = isset($array_params['type']) ? $array_params['type'] : '';
                        if($type == 1){
                            return $url_first.'sim-viettel-v90.html';
                        }elseif($type ==2){
                            return $url_first.'sim-vip.html';
                        }elseif($type==3){
                            return $url_first.'sim-de-xuat.html';
                        }elseif($type ==4){
                            return $url_first.'khuyen-mai-sim-so-dep.html';
                        }elseif($type ==5){
                            return $url_first.'sim-tra-sau.html';
                        }else{
                            return $url_first . $url;
                        }
                    default:
                        return $url_first . $url;
                }
                break;
            case 'contest':
                switch ($view) {
                    case 'home':
                        switch ($task){
                            case 'result':
                                return $url_first . 'ket-qua-thi-va-kiem-tra.html';
                            default:
                                return $url_first . 'thi-va-kiem-tra.html';
                        }
                    default:
                        return $url_first . $url;
                }
                break;
            case 'news':
                switch ($view) {
                    case 'news':
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
//                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        return $url_first .'tin-tuc/'. $code  . FSRoute::get_name_encode('', $lang). '.html';
                    case 'cat':
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        return $url_first . $ccode . '-' . FSRoute::get_name_encode('cn', $lang) . $id . '.html';
                    case 'home':
                        return $url_first.'tin-tuc.html';
                    case 'search':
                        $keyword = isset($array_params['keyword']) ? $array_params['keyword'] : '';
                        $url = $url_first . FSRoute::get_name_encode('tim-kiem-tin-tuc', $lang);
                        if ($keyword) {
                            $url .= '/' . $keyword . '.html';
                        }
                        return $url;
                    default:
                        return $url_first . $url;
                }
                break;
            case 'paynow':
                    switch ($task){
                        case 'sim':
                            // $network = isset($array_params['net']) ? $array_params['net'] : '';
                            $sim = isset($array_params['sim']) ? $array_params['sim'] : '';
                            return $url_first . $sim . '.html';
                        case 'success':
                            // $id = isset($array_params['id']) ? $array_params['id'] : '';
                            return $url_first .'dat-sim-thanh-cong.html';
                        case 'compare':
                            return $url_first . 'so-sanh-sim.html';
                        case 'pdf_success':
                            $id = isset($array_params['id']) ? $array_params['id'] : '';
                            return $url_first . 'export-'.$id.'.html';
                        case 'api_pdf_export':
                            $id = isset($array_params['id']) ? $array_params['id'] : '';
                            return $url_first . 'export-pdf-'.$id.'.html';
                        default:
                            return $url_first . 'gio-hang.html';
                    }
            case 'search':
                    $keyword = isset($array_params['keyword']) ? $array_params['keyword'] : '';
                    $network = isset($array_params['network']) ? $array_params['network'] : '';
                    $cat = isset($array_params['cat']) ? $array_params['cat'] : '';
                    $price = isset($array_params['price']) ? $array_params['price'] : '';
                    $order = isset($array_params['order']) ? $array_params['order'] : '';
                    $button = isset($array_params['button']) ? $array_params['button'] : '';
                    $point = isset($array_params['point']) ? $array_params['point'] : '';
                    $number = isset($array_params['number']) ? $array_params['number'] : '';
                    $limit = isset($array_params['limit']) ? $array_params['limit'] : '';
                    return $url_first . $keyword . '/' . $network . '/' . $cat . '/' . $price . '/' . $order . '/' . $button . '/' . $point . '/' . $number . '/' . $limit . '.html';
            case 'contents':
                switch ($view) {
                    case 'cat':
                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        return $url_first . $ccode . '-cc' . $id . '.html';
                    case 'content':
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        //return $url_first.FSRoute::get_name_encode('ct',$lang).'-'.$code.'.html';
//                        return $url_first . $code . '-' . FSRoute::get_name_encode('c', $lang) . $id . '.html';
                        return $url_first .'apl/'. $code.'.html';
                }
                break;
            case 'notfound':
                switch ($view) {
                    case 'notfound':
                        return $url_first . '404-page.html';
                    default:
                        return $url_first . $url;
                }
                break;
		    case 'documents':
				switch ($view){
					case 'document':
						switch($task){
                            case 'download':
                                $data  = isset($array_params['data'])?$array_params['data']: '';
                                return URL_ROOT.'ho-tro-dao-tao-'.$data.'.html';
                        }
						return $url_first.'ho-tro-dao-tao.html';
					default:
						return $url_first.$url;
				}
				break;
            case 'cache':
                return $url_first . 'delete-cache.html';

            case 'sitemap':
                return $url_first . 'site-map.html';

            case 'users':
                switch ($view) {
                    case 'users':
                        switch ($task) {
                            case 'login':
                                $url1 = '';
                                foreach ($array_params as $key => $value) {
                                    if ($key == 'module' || $key == 'view' || $key == 'Itemid' || $key == 'task')
                                        continue;
                                    $url1 .= '&' . $key . '=' . $value;
                                }

                                return URL_ROOT . 'dang-nhap.html' . $url1;
                            case 'register':
                                $url1 = '';
                                foreach ($array_params as $key => $value) {
                                    if ($key == 'module' || $key == 'view' || $key == 'Itemid' || $key == 'task')
                                        continue;
                                    $url1 .= '&' . $key . '=' . $value;
                                }
                                return URL_ROOT . 'dang-ky.html' . $url1;
                            case 'fget_pass':
                                return URL_ROOT . 'quen-mat-khau.html';
                            case 'update_forgot_pass':
                             $id = isset($array_params['data']) ? $array_params['data'] : '';
                                return URL_ROOT . 'cap-nhat-mat-khau-'.$id.'.html';
                            case 'logout':
                                return URL_ROOT . 'dang-xuat.html';
                            case 'user_info':
                                return URL_ROOT . 'quichebaomat';
                            case 'register_user':
                                return URL_ROOT . 'tao-moi-user.html';
                            case 'list_user':
                                return URL_ROOT . 'danh-sach-user.html';
                            case 'edit_user':
                                 $id = isset($array_params['id']) ? $array_params['id'] : '';
                                return URL_ROOT . 'cap-nhat-user-u'.$id.'.html';
                            case 'changepass':
                                return URL_ROOT . 'thay-doi-mat-khau.html';

                            case 'history_learning':
                                return URL_ROOT . 'lich-su-hoc-tap.html';
                        }
                    default:
                        return URL_ROOT . $url;
                }
                break;

            default:
                return URL_ROOT . $url;
        }
    }

    /*
     * get real url from virtual url
     */

    function deURL($url) {
        if (!IS_REWRITE)
            return $url;
        return $url;
        if (strpos($url, URL_ROOT_REDUCE) !== false) {
            $url = substr($url, strlen(URL_ROOT_REDUCE));
        }
        if ($url == 'news.html')
            return 'index.php?module=news&view=home&Itemid=1';
        if (strpos($url, 'news-page') !== false) {
            $f = strpos($url, 'news-page') + 9;
            $l = strpos($url, '.html');
            $page = intval(substr($url, $f, ($l - $f)));
            return "index.php?module=news&view=home&page=$page&Itemid=1";
        }
        $array_url = explode('/', $url);
        $module = isset($array_url[0]) ? $array_url[0] : '';
        switch ($module) {
            case 'news':
                // if cat
                if (preg_match('#news/([^/]*)-c([0-9]*)-it([0-9]*)(-page([0-9]*))?.html#s', $url, $arr)) {
                    return "index.php?module=news&view=cat&id=" . @$arr[2] . "&Itemid=" . @$arr[3] . '&page=' . @$arr[5];
                }
                // if article
                if (preg_match('#news/detail/([^/]*)-i([0-9]*)-it([0-9]*).html#s', $url, $arr)) {
                    return "index.php?module=news&view=news&id=" . @$arr[2] . "&Itemid=" . @$arr[3];
                }
            case 'companies':
                $str_continue = ($module = isset($array_url[1])) ? $array_url[1] : '';
                if ($str_continue == 'register.html')
                    return "index.php?module=companies&view=company&task=register&Itemid=5";
                if (preg_match('#category-id([0-9]*)-city([0-9]*)-it([0-9]*)(-page([0-9]*))?.html#s', $str_continue, $arr)) {
                    if (isset($arr[5]))
                        return "index.php?module=companies&view=category&id=" . @$arr[1] . "&city=" . @$arr[2] . "&Itemid=" . @$arr[3] . "&page=" . @$arr[5];
                    else
                        return "index.php?module=companies&view=category&id=" . @$arr[1] . "&city=" . @$arr[2] . "&Itemid=" . @$arr[3];
                }
            default:
                return $url;
        }
    }

    function get_home_link() {
        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'vi';
        if ($lang == 'vi') {
            return URL_ROOT;
        } else {
            return URL_ROOT . 'en';
        }
    }

    /*
     * Dịch ngang
     */

    static function change_link_by_lang($lang, $link = '') {
        $module = FSRoute::get_param('module', $link);
        $view = FSRoute::get_param('view', $link);
        if (!$view)
            $view = $module;
        if (!$module || ($module == 'home' && $view == 'home')) {
            if ($lang == 'en') {
//				return URL_ROOT;
            } else {
                return URL_ROOT . 'vi';
            }
        }
        switch ($module) {

            case 'contents':
                switch ($view) {
                    case 'content':
                        $code = FSRoute::get_param('code', $link);
                        $record = FSRoute::trans_record_by_field($code, 'alias', 'fs_contents', $lang, 'id,alias,category_alias');
                        if (!$record)
                            return;
                        $url = URL_ROOT . FSRoute::get_name_encode('ct', $lang) . '-' . $record->alias;
                        return $url . '.html';
                        return $url;
                }
                break;
            default:
                $url = URL_ROOT . 'ce-information';
                return $url . '.html';
        }
    }

    /*
     * Hàm trả lại tham số: có thể từ biến $_REQUEST hay từ phân tích URL truyền vào
     */

    static function get_param($param_name, $link = '') {
        if (!$link)
            return FSInput::get($param_name);
        $url = str_replace('&amp;', '&', $link);
        $url_reduced = substr($url, 10); // width : index.php
        $array_buffer = explode('&', $url_reduced, 10);
        $array_params = array();
        for ($i = 0; $i < count($array_buffer); $i ++) {
            $item = $array_buffer[$i];
            $pos_sepa = strpos($item, '=');
            $array_params[substr($item, 0, $pos_sepa)] = substr($item, $pos_sepa + 1);
        }
        return @$array_params[$param_name];
    }

    function get_record_by_id($id, $table_name, $lang, $select) {
        if (!$id)
            return;
        if (!$table_name)
            return;
        $fs_table = FSFactory::getClass('fstable');
        $table_name = $fs_table->getTable($table_name);

        $query = " SELECT " . $select . "
					  FROM " . $table_name . "
					  WHERE id = $id ";

        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    /*
     * Lấy bản ghi dịch ngôn ngữ
     */

    static function trans_record_by_field($value, $field = 'alias', $table_name, $lang, $select = '*') {
        if (!$value)
            return;
        if (!$table_name)
            return;
        $fs_table = FSFactory::getClass('fstable');
        $table_name_old = $fs_table->getTable($table_name);

        $query = " SELECT id
					  FROM " . $table_name_old . "
					  WHERE " . $field . " = '" . $value . "' ";

        global $db;
        $sql = $db->query($query);
        $id = $db->getResult();
        if (!$id)
            return;
        $query = " SELECT " . $select . "
					  FROM " . $fs_table->translate_table($table_name) . "
					  WHERE id = '" . $id . "' ";
        global $db;
        $sql = $db->query($query);
        $rs = $db->getObject();
        return $rs;
    }

    /*
     * Dịch từ field -> field ( tìm lại id rồi dịch ngược)
     */

    function translate_field($value, $table_name, $field = 'alias') {

        if (!$value)
            return;
        if (!$table_name)
            return;
        $fs_table = FSFactory::getClass('fstable');
        $table_name_old = $fs_table->getTable($table_name);

        $query = " SELECT id
					  FROM " . $table_name_old . "
					  WHERE $field = '" . $value . "' ";
        global $db;
        $sql = $db->query($query);
        $id = $db->getResult();
        if (!$id)
            return;
        $query = " SELECT " . $field . "
					  FROM " . $fs_table->translate_table($table_name) . "
					  WHERE id = '" . $id . "' ";
        global $db;
        $sql = $db->query($query);
        $rs = $db->getResult();
        return $rs;
    }

}
