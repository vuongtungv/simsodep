<?php

class FsGlobal {

    function __construct() {
        
    }

    /*     * *************	FOR ONE LANGUAGE ********** */

    function getConfig($name) {
        $fstable = FSFactory:: getClass('fstable');
        global $db;
        $sql = " SELECT value FROM " . $fstable->_('fs_config') . "
			WHERE name = '$name' ";
        $db->query($sql);
        return $db->getResult();
    }

    /*     * *************	FOR ONE LANGUAGE ********** */

    function getConfig_email($name) {
        $fstable = FSFactory:: getClass('fstable');
        global $db;
        $sql = " SELECT value FROM " . $fstable->_('fs_config_email') . "
			WHERE name = '$name' ";
        $db->query($sql);
        return $db->getResult();
    }

    /*     * *************	FOR ONE LANGUAGE ********** */

    function getConfig_info($name) {
        $fstable = FSFactory:: getClass('fstable');
        global $db;
        $sql = " SELECT value FROM " . $fstable->_('fs_config_info') . "
			WHERE name = '$name' ";
        $db->query($sql);
        return $db->getResult();
    }


    /*     * *************	FOR ONE LANGUAGE ********** */

    function getConfigContest() {
        global $db;
        $fstable = FSFactory:: getClass('fstable');
        $sql = " SELECT * FROM " . $fstable->_('fs_question_config') . "
						WHERE published = 1";
        $db->query($sql);
        $list = $db->getObjectList();
        $array_config = array();
        foreach ($list as $item) {
            $array_config[$item->name] = $item->value;
        }
        return $array_config;
    }

    /*     * *************	FOR ONE LANGUAGE ********** */

    /*
     * Lấy các biến config trong bảng fs_config_module cho giao diện hiện tại 
     */

    function get_module_config($module, $view = '', $task = '', $params = array()) {
        if (!$module)
            return;

        $view = $view ? $view : $module;
        if (USE_MEMCACHE) {
            $fsmemcache = FSFactory::getClass('fsmemcache');
            $mem_key = 'config_module_' . $module . '_' . $view . '_' . $task;

            $config_in_memcache = $fsmemcache->get($mem_key);

            if ($config_in_memcache) {
                return $config_in_memcache;
            } else {
                $where = '';
                $where .= 'module = "' . $module . '" AND view = "' . $view . '"';
                if ($task == 'display' || !$task) {
                    $where .= ' AND ( task = "display" OR task = "" OR task IS NULL)';
                } else {
                    $where .= ' AND task = "' . $task . '" ';
                }

                $fstable = FSFactory:: getClass('fstable');
                global $db;
                $sql = " SELECT cache,params,fields_seo_title,fields_seo_keyword,fields_seo_description,fields_seo_h1,fields_seo_h2,fields_seo_image_alt,value_seo_title,value_seo_keyword,value_seo_description  FROM fs_config_modules
					WHERE $where ";
                $db->query($sql);
                $rs = $db->getObject();
                $config_in_memcache = $fsmemcache->set($mem_key, $rs, 180);
                return $rs;
            }
        } else {
            $where = '';
            $where .= 'module = "' . $module . '" AND view = "' . $view . '"';
            if ($task == 'display' || !$task) {
                $where .= ' AND ( task = "display" OR task = "" OR task IS NULL)';
            } else {
                $where .= ' AND task = "' . $task . '" ';
            }

            $fstable = FSFactory:: getClass('fstable');
            global $db;
            $sql = " SELECT cache,params,fields_seo_title,fields_seo_keyword,fields_seo_description,fields_seo_h1,fields_seo_h2,fields_seo_image_alt,value_seo_title,value_seo_keyword,value_seo_description FROM fs_config_modules
				WHERE $where ";
            $db->query($sql);
            $rs = $db->getObject();
//			$config_in_memcache = $fsmemcache -> set($mem_key,$rs,1000);
            return $rs;
        }
    }

    /*
     * get config is common
     */

    function get_all_config() {
//		global $db;
//		$fstable  = FSFactory:: getClass('fstable');
//		$sql = " SELECT * FROM ".$fstable->_('fs_config')."
//				WHERE is_common = 1
//			 ";
//		$db->query($sql);
//		$list =  $db->getObjectList();
//		$array_config = array();
//		foreach($list as $item){
//			$array_config[$item -> name] = $item -> value;
//		}
//		return $array_config;


        if (USE_MEMCACHE) {
            $fsmemcache = FSFactory::getClass('fsmemcache');
            $mem_key = 'config_commom';

            $config_in_memcache = $fsmemcache->get($mem_key);

            if ($config_in_memcache) {
                return $config_in_memcache;
            } else {
                global $db;
                $fstable = FSFactory:: getClass('fstable');
                $sql = " SELECT * FROM " . $fstable->_('fs_config') . "
						WHERE is_common = 1
					 ";
                $db->query($sql);
                $list = $db->getObjectList();
                $array_config = array();
                foreach ($list as $item) {
                    $array_config[$item->name] = $item->value;
                }
                $fsmemcache->set($mem_key, $array_config, 1000);
                return $array_config;
            }
        } else {
            global $db;
            $fstable = FSFactory:: getClass('fstable');
            $sql = " SELECT * FROM " . $fstable->_('fs_config') . "
						WHERE is_common = 1
					 ";
            $db->query($sql);
            $list = $db->getObjectList();
            $array_config = array();
            foreach ($list as $item) {
                $array_config[$item->name] = $item->value;
            }
            return $array_config;
        }
    }

    function get_all_config_email() {
//		global $db;
//		$fstable  = FSFactory:: getClass('fstable');
//		$sql = " SELECT * FROM ".$fstable->_('fs_config')."
//				WHERE is_common = 1
//			 ";
//		$db->query($sql);
//		$list =  $db->getObjectList();
//		$array_config = array();
//		foreach($list as $item){
//			$array_config[$item -> name] = $item -> value;
//		}
//		return $array_config;


        if (USE_MEMCACHE) {
            $fsmemcache = FSFactory::getClass('fsmemcache');
            $mem_key = 'config_commom';

            $config_in_memcache = $fsmemcache->get($mem_key);

            if ($config_in_memcache) {
                return $config_in_memcache;
            } else {
                global $db;
                $fstable = FSFactory:: getClass('fstable');
                $sql = " SELECT * FROM " . $fstable->_('fs_config_email') . "
						WHERE is_common = 1
					 ";
                $db->query($sql);
                $list = $db->getObjectList();
                $array_config = array();
                foreach ($list as $item) {
                    $array_config[$item->name] = $item->value;
                }
                $fsmemcache->set($mem_key, $array_config, 1000);
                return $array_config;
            }
        } else {
            global $db;
            $fstable = FSFactory:: getClass('fstable');
            $sql = " SELECT * FROM " . $fstable->_('fs_config_email') . "
						WHERE is_common = 1
					 ";
            $db->query($sql);
            $list = $db->getObjectList();
            $array_config = array();
            foreach ($list as $item) {
                $array_config[$item->name] = $item->value;
            }
            return $array_config;
        }
    }

    /*     * *************	FOR MULTILANGUAGE ********** */

//	function getConfig($name)
//	{
//		$lang =$_SESSION['lang'];
//		global $db;
//		$sql = " SELECT value FROM ".'fs_config_'.$lang."
//			WHERE name = '$name' ";
//		$db->query($sql);
//		return $db->getResult();
//	}
//	/*
//	 * get config is common
//	 */
//	function get_all_config(){
//		global $db;
//		$lang =$_SESSION['lang'];
//		$sql = " SELECT * FROM ".'fs_config_'.$lang."
//				WHERE is_common = 1
//			 ";
//		$db->query($sql);
//		$list =  $db->getObjectList();
//		$array_config = array();
//		foreach($list as $item){
//			$array_config[$item -> name] = $item -> value;
//		}
//		return $array_config;
//	}

    /*
     * Gọi các bảng khởi tạo cho menus
     */
    function get_menu_by_group($group_id) {
        $fstable = FSFactory:: getClass('fstable');
        if (USE_MEMCACHE) {
            $fsmemcache = FSFactory::getClass('fsmemcache');
            $mem_key = 'menus';

            $menu_in_memcache = $fsmemcache->get($mem_key);

            if ($menu_in_memcache) {
                $list = $menu_in_memcache;
            } else {
                global $db;
                $sql = " SELECT id,link, name, level, parent_id as parent_id, target,group_id
					FROM " . $fstable->_('fs_menus_items') . "
					WHERE published  = 1
						ORDER BY ordering";
                $db->query($sql);
                $rs = $db->getObjectList();
                $menu_in_memcache = $fsmemcache->set($mem_key, $rs, 100000);
                $list = $rs;
            }
            if (!count($menu_in_memcache)) {
                return;
            }
            $rs = array();
            foreach ($list as $item) {
                if ($item->group_id == $group_id) {
                    $rs[] = $item;
                }
            }
            return $rs;
        } else {
            global $db;
            $sql = ' SELECT id,link, name, level, parent_id as parent_id, target,group_id
				FROM ' . $fstable->_('fs_menus_items') . '
				WHERE published  = 1 AND group_id = ' . $group_id . '
					ORDER BY ordering';
            $db->query($sql);
            $rs = $db->getObjectList();
            return $rs;
        }
    }

    /*
     * Lấy ra các block
     */

    function get_blocks() {
        $fstable = FSFactory:: getClass('fstable');
        if (USE_MEMCACHE) {
            $fsmemcache = FSFactory::getClass('fsmemcache');
            $mem_key = 'blocks';


            $blocks_in_memcache = $fsmemcache->get($mem_key);

            if ($blocks_in_memcache) {
                return $blocks_in_memcache;
            } else {

                global $db;
                $sql = " SELECT id,title,content,url, ordering, module, position, showTitle,text_color,summary,
                        text_replace, params ,listItemid,news_categories,contents_categories,type_html
						FROM " . $fstable->_('fs_blocks') . " AS a 
						WHERE published = 1 
					    ORDER by ordering";
                $db->query($sql);
                $rs = $db->getObjectList();
                $blocks_in_memcache = $fsmemcache->set($mem_key, $rs, 1000);
                return $rs;
            }
        } else {
            global $db;
            $where = '';
            $module = FSInput::get('module');
            $view = FSInput::get('view');
            $ccode = FSInput::get('ccode');
            if ($ccode) {
                //if($module == 'contents' && $view == 'content'){
                //$where .= ' AND contents_categories IN (0'.$category_id.'0) ';
                //	$where .= 'AND  contents_categories like "%,'.$ccode.',%" ';
                //}
            }
            $sql = 'SELECT id,title,content, ordering,url, module, position,text_color,summary,text_replace,
                        showTitle, params ,listItemid,news_categories,contents_categories,type_html
						FROM ' . $fstable->_('fs_blocks') . ' AS a 
						WHERE published = 1 ' . $where . ' 
					ORDER BY ordering';
            //print_r($sql);        
            $db->query($sql);
            $rs = $db->getObjectList();
            return $rs;
        }
    }

    /*
     * Lấy ra các banner
     */

    function get_banners($category_id) {
        $fstable = FSFactory:: getClass('fstable');
        if (USE_MEMCACHE) {
            $fsmemcache = FSFactory::getClass('fsmemcache');
            $mem_key = 'banners';

//			$banners_in_memcache = $fsmemcache -> get($mem_key);
//			if(!$banners_in_memcache){
            global $db;
            $sql = " SELECT name,id,category_id,type,image,flash,content,link,height,width,listItemid,news_categories_alias
						FROM " . $fstable->_('fs_banners') . " AS a 
						WHERE published = 1 
							ORDER by ordering";
            $db->query($sql);
            $rs = $db->getObjectList();
            $banners_in_memcache = $rs;
            $fsmemcache->set($mem_key, $rs, 1000);
//			}
            $rs = array();

            foreach ($banners_in_memcache as $item) {
                // In category
                if (strpos(',' . $category_id . ',', ',' . $item->category_id . ',') === false)
                    continue;
                // news_categories
                $ccode = FSInput::get('ccode');
                $module = FSInput::get('module');
                if ($ccode && $module == 'news') {
                    if (strpos($item->news_categories_alias, ',' . $ccode . ',') === false)
                        continue;
                }
                // Itemid
                $Itemid = FSInput::get('Itemid', 1, 'int');
                if ($item->listItemid == 'all' || strpos($item->listItemid, ',' . $Itemid . ',') !== false) {
                    $rs[] = $item;
                }
//				$array_config[$item -> name] = $item -> value;
            }
            $fsmemcache->set($mem_key, $rs, 1000);
            return $rs;
        } else {
            $where = '';

            if (!$category_id)
                return;
            $where .= ' AND category_id IN (' . $category_id . ') ';
            $module = FSInput::get('module');
            $ccode = FSInput::get('ccode');
            if ($ccode) {
                if ($module == 'products') {
                    $where .= 'AND  products_categories_alias like "%,' . $ccode . ',%" ';
                } else if ($module == 'news') {
                    $where .= 'AND  news_categories_alias like "%,' . $ccode . ',%" ';
                } else {
                    
                }
            }
            // Itemid
            $Itemid = FSInput::get('Itemid', 1, 'int');
            $where .= "AND (listItemid = 'all'
							OR listItemid like '%,$Itemid,%')
							";

            $query = " SELECT name,id,category_id,type,image,flash,content,link,height,width
						  FROM " . $fstable->_('fs_banners') . " AS a
						  WHERE published = 1
						 " . $where . " ORDER BY ordering, id ";
            global $db;
            $db->query($query);
            $list = $db->getObjectList();

            return $list;
        }
    }

    /*
     * Xác định người giới thiệu ( hàm này chỉ dùng cho webite có cộng tác viên)
     */

    function set_introducer() {
        // người vào là cộng tác viên thì đặt luôn nó là người giới thiệu
        if (isset($_SESSION['is_collaborator']) && $_SESSION['user_id']) {
            $_SESSION['introducer'] = $_SESSION['user_id'];
            return;
        }
        $col_id = FSInput::get('col_id');
        // không có người giới thiệu thì lưu lại để tránh phải vào db nhiều lần truy vấn
        if (!$col_id) {
            if (!isset($_SESSION['introducer'])) {
                $col_id = $this->get_collaborator_by_ip();
                if ($col_id)
                    $_SESSION['introducer'] = $col_id;
                else
                    $_SESSION['introducer'] = $col_id;
            }
        }else {
            $col_id = base64_decode($col_id);
            $col_id = intval($col_id);
            // không có người giới thiệu thì lưu lại để tránh phải vào db nhiều lần truy vấn
            if (!$col_id) {
                if (!isset($_SESSION['introducer'])) {
                    $col_id = $this->get_collaborator_by_ip();
                    if ($col_id)
                        $_SESSION['introducer'] = $col_id;
                    else
                        $_SESSION['introducer'] = $col_id;
                }
            }else {
                $check = $this->check_collaborator($col_id);
                if (!$check) {
                    if (!isset($_SESSION['introducer'])) {
                        $_SESSION['introducer'] = 0;
                    }
                } else {
                    $_SESSION['introducer'] = $col_id;
                }
            }
        }
    }

    function check_collaborator($col_id) {
        global $db;
        $sql = " SELECT count(*) 
						FROM fs_members AS a 
						WHERE published = 1
							AND block <> 1
							AND is_collaborator = 1 
							";
        $db->query($sql);
        return $rs = $db->getResult();
    }

    /*
     * Kiểm tra ip này đã truy cập chưa, có  
     */

    function get_collaborator_by_ip() {
        global $config;
        $exprice_time = isset($config['intro_exprice']) ? $config['intro_exprice'] : 20;
        $ip_address = $_SERVER['REMOTE_ADDR'];
        global $db;
        $sql = " SELECT col_id 
				FROM fs_hits 
				WHERE DATE_SUB(NOW(),INTERVAL $exprice_time DAY) < visited_time 
				AND col_id <> 0
					";
        $db->query($sql);
        return $rs = $db->getResult();
    }

}
