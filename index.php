<?php

//echo "<pre>";
// var_dump($_REQUEST);
// alert error
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
// error_reporting(0);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Ho_Chi_Minh');
// print_r($_REQUEST);
include("includes/defines.php");
if (USE_BENMARCH) {
    require('libraries/Benchmark.class.php');
    Benchmark::startTimer();
}

// session
if (!isset($_SESSION)) {
    session_start();
}

// var_dump($_SESSION['cart']);

if (@$_SESSION['cart']){
    $arr_cart = array();
    foreach ($_SESSION['cart'] as $item){
        $arr_cart[] = $item[2];
    }
    $_SESSION['arr_cart'] = $arr_cart;
}

include("includes/config.php");
include("libraries/database/pdo.php");
$db = new FS_PDO();

require_once ("libraries/fsinput.php");
include('libraries/fsfactory.php');

$cache = 0;
global $page_cache;
$page_cache = 1;

$raw = FSInput::get('raw');
$print = FSInput::get('print');

require_once ("libraries/fstext.php");
require_once ("libraries/fstable.php");
require_once("libraries/fsrouter.php");
include("includes/functions.php");
//include("libraries/database/mysql.php");
//include("libraries/database/pdo.php");
include("libraries/fscontrollers.php");
include("libraries/fsmodels.php");
include('libraries/fsdevice.php');
require('libraries/fsuser.php');

/* Phiên bản mobile */
$mobile = @$_SESSION['run_pc'];  
$detect = new FSDevice;
if($detect->isMobile()  && !$detect->isTablet() && !$mobile)
    define('IS_MOBILE', 1);
else
    define('IS_MOBILE', 0);

//$db = new Mysql_DB();
//$user = new FSUser();
$module = FSInput::get('module', 'home');
$view = FSInput::get('view', $module);
$task = FSInput::get('task');
$task = $task ? $task : 'display';
// language
$lang_request = FSInput::get('lang');
if ($lang_request) {
    $_SESSION['lang'] = $lang_request;
} else {
    $_SESSION['lang'] = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'vi';
}

//$use_cache = USE_CACHE;
$use_cache = 0;
// if(isset($_COOKI['user_id']) && $_COOKIE['user_id']){
// 	$use_cache  = 0;
// }


$translate = FSText::load_languages('font-end', $_SESSION['lang'], $module);

if ($raw) {
    // FsGlobal
    $global_class = FSFactory::getClass('FsGlobal');
    $config = $global_class->get_all_config();
    $user = new FSUser();
    $module_config = $global_class->get_module_config($module, $view, $task);

    $cache_time = 0;
    if ($use_cache) {
        $cache_time = isset($module_config->cache) ? $module_config->cache : 0;
    }
    // load main content not use Template
    $fsCache = FSFactory::getClass('FSCache');
    $uri = $_SERVER['REQUEST_URI'];
    preg_match('#\/(.*?)\.html#is', $uri, $u);
    if (isset($u[0])) {
        $u = $u[0];
    } else {
        $u = $uri;
    }
    $key = md5($u);
    $folder_cache = 'modules/' . $module;
    $content_cache = $fsCache->get($key, $folder_cache, $cache_time);
    if ($content_cache) {
        echo $content_cache;
    } else {
        $html = call_module($module, $view, $task);
        // put cache
        $fsCache->put($key, $html, $folder_cache);
        echo $html;
    }
    $db->close();
    //
} else {
    // call config before call Template
    $global_class = FSFactory::getClass('FsGlobal');
    $config = $global_class->get_all_config();
    $user = new FSUser();
    $module_config = $global_class->get_module_config($module, $view, $task);

    $cache_time = 0;
    if ($use_cache) {
        $cache_time = isset($module_config->cache) ? $module_config->cache : 0;
    }
    // load main content use Template
    include("libraries/templates.php");
    global $tmpl;
    $tmpl = new Templates();


    /* Phiên bản mobile */
    if(IS_MOBILE)
        $tmpl->tmpl_name = 'mobile';

    if ($print) {
        $main_content = loadMainContent($module, $view, $task, 0);
        include_once('templates/' . $tmpl->tmpl_name . '/print.php');
        die;
    }

    if (!$cache_time || !$use_cache) {
        $main_content = loadMainContent($module, $view, $task, 0);
        ob_start();
        include_once("templates/" . $tmpl->tmpl_name . "/index.php");
        // var_dump($tmpl);die;
        $all_website_content = ob_get_contents();
        ob_end_clean();

        echo get_wrapper_site($tmpl, 'header', $module, 0);
        echo $all_website_content;

        if (USE_BENMARCH) {
            echo '<div  class="benmarch noc">';
            echo Benchmark::showTimer(5) . ' sec| ';
            echo Benchmark::showMemory('kb') . ' kb';
            echo '</div>';
        }
        echo get_wrapper_site($tmpl, 'footer', $module, 0);
        echo '</body></html>';
        $db->close();
    } else if ($use_cache != 2) {// use cache local or no cache
        $main_content = loadMainContent($module, $view, $task, $cache_time);
        ob_start();
        include_once("templates/" . $tmpl->tmpl_name . "/index.php");
        $all_website_content = ob_get_contents();
        ob_end_clean();

        echo get_wrapper_site($tmpl, 'header', $module, $cache_time);
        echo $all_website_content;

        if (USE_BENMARCH) {
            echo '<div class="benmarch ca1">';
            echo Benchmark::showTimer(5) . ' sec| ';
            echo Benchmark::showMemory('kb') . ' kb';
            echo '</div>';
        }
        echo get_wrapper_site($tmpl, 'footer', $module, $cache_time);
        echo '</body></html>';
        $db->close();
    } else { // use cache global
        $fsCache = FSFactory::getClass('FSCache');
        $uri = $_SERVER['REQUEST_URI'];
        preg_match('#\/(.*?)\.html#is', $uri, $u);
        if (isset($u[0])) {
            $u = $u[0];
        } else {
            $u = $uri;
            if (strpos($u, 'module') === false) {
                $u = '/';
            }
        }
        $key = md5($u);

        // FOLDER CACHE
        if(IS_MOBILE){
        	$folder_cache = 'modules/'.$module.'/m'.$view;
        }else{
        $folder_cache = 'modules/' . $module . '/' . $view;
        }


        $sort = FSInput::get('order', 'defautl');
        switch ($sort) {
            case 'alpha':
                $folder_cache .= '_alpha';
                break;
            case 'desc':
                $folder_cache .= '_desc';
                break;
            case 'asc':
                $folder_cache .= '_asc';
                break;
            // default :
            // 	$folder_cache .= '/'.$view;
        }
        // echo $view ;die;
        if ($module == 'products') {
            $ccode = FSInput::get('ccode');
            $folder_cache .= '/' . $ccode;
        }
        // end FOLDER CACHE

        $content_cache = $fsCache->get($key, $folder_cache, $cache_time);
        if ($content_cache) {
            echo $content_cache;
            if (USE_BENMARCH) {
                echo '<div  class="benmarch ca2 hide">';
                echo Benchmark::showTimer(5) . ' sec| ';
                echo Benchmark::showMemory('kb') . ' kb';
                echo '</div>';
            }
            echo '</body></html>';
        } else {
            // load content module ( not use cache by use cache Global)
            $main_content = loadMainContent($module, $view, $task, 0);

            ob_start();
            include_once("templates/" . $tmpl->tmpl_name . "/index.php");
            $html_body = $all_website_content = ob_get_contents();
            $html_header = get_wrapper_site($tmpl, 'header', $module, 0);
            $html_footer = get_wrapper_site($tmpl, 'footer', $module, 0);
            ob_end_clean();

            $html = $html_header . $html_body . $html_footer;
            // put cache
            $fsCache->put($key, $html, $folder_cache);
            echo $html;
            if (USE_BENMARCH) {
                echo '<div  class="benmarch noc2">';
                echo Benchmark::showTimer(5) . ' sec| ';
                echo Benchmark::showMemory('kb') . ' kb';
                echo '</div>';
            }
        }
        $db->close();
    }
}

/*
 * Display msg when redirect
 */

function display_msg_redirect() {
    global $config;
    $html = '';
    if (isset($_SESSION ['have_redirect'])) {
        if ($_SESSION ['have_redirect'] == 1) {
            $html .= "<div id='msgModal' class='msgmodal' style='display: block;'>
                        <div class='msgmodal-content'>
                        <div class='msgmodal-body'>
                    ";

            $types = array(0 => 'error', 1 => 'alert', 2 => 'suc');
            foreach ($types as $type) {
                if (isset($_SESSION ["msg_$type"])) {
                    if ($type == 'suc') {
                        $html .= '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                      <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                      <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                                  </svg>';
                    } else {
                        $html .= '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                  <circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                  <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/>
                                  <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/>
                                </svg>';
                    }
                    $msg_error = $_SESSION ["msg_$type"];
                    foreach ($msg_error as $item) {
                        $html .= "<p style='text-align: center;font-size: 25px;line-height: 30px;'>" . $item . "</p>";
                    }
                    unset($_SESSION ["msg_$type"]);

                    if ($type == 'suc') {
                        $html .= '<a class="bt-modals" href="#">OK</a>';
                    } else {
                        $html .= '<a class="bt-modals" href="#">Đóng</a>';
                    }
                }
            }

            $html .= "</div></div></div>";
            $html .= '<script>
                    // Get the modal
                        var modal = document.getElementById("msgModal");

                        // Get the button that opens the modal
                        //var btn = document.getElementById("myBtn");

                        // Get the <span> element that closes the modal
                        var span = document.getElementsByClassName("close-modal")[0];

                        // When the user clicks the button, open the modal
                        //btn.onclick = function() {
                        //    modal.style.display = "block";
                        //}

                        // When the user clicks on <span> (x), close the modal
var a1 = document.getElementsByClassName("bt-modals")[0];                        

                        a1.onclick = function() {
                            modal.style.display = "none";
                        }


                        // When the user clicks on <span> (x), close the modal
                        span.onclick = function() {
                            modal.style.display = "none";
                        }

                        // When the user clicks anywhere outside of the modal, close it
                        window.onclick = function(event) {
                            if (event.target == modal) {
                                modal.style.display = "none";
                            }
                        }

                        //var x = document.getElementById("msgModal")
                        //x.className = "msgmodal";
                        //setTimeout(function(){ x.className = x.className.replace("msgmodal", "msgmodal hide"); }, 5000);
                    </script>';
        }
        unset($_SESSION ['have_redirect']);
    }
    return $html;
}

/*
 * function Load Main content
 */

function loadMainContent($module = '', $view = '', $task = '', $cache_time = 0) {
    $html = '';
    //  message when redirect
    $html .= display_msg_redirect();

    if ($cache_time) {
        $fsCache = FSFactory::getClass('FSCache');
        $key = md5($_SERVER['REQUEST_URI']);
        $content_cache = $fsCache->get($key, 'modules/' . $module, $cache_time);
        if ($content_cache) {
            return $html . $content_cache;
        } else {
            $main_content = call_module($module, $view, $task);
            $fsCache->put($key, $main_content, 'modules/' . $module);
            return $html . $main_content;
        }
    } else {

        if(IS_MOBILE)
            $task = 'm'.$task;
        $main_content = call_module($module,$view,$task);
        return $html.$main_content;
    }
}

function call_module($module, $view, $task) {

    $path = PATH_BASE . 'modules' . DS . $module . DS . 'controllers' . DS . $view . ".php";
    if (file_exists($path)) {
        ob_start();
        require_once $path;
        $c = ucfirst($module) . 'Controllers' . ucfirst($view);
        $controller = new $c();
        $controller->$task();
        $main_content = ob_get_contents();
        ob_end_clean();
        return $main_content;
    } else {
        return;
    }
}

/*
 * Get header, footer for case: Cache Local
 * @cache_time ( second)
 */

function get_wrapper_site($tmpl, $wrapper_name = 'header', $module, $cache, $cache_time = 10) {
    if ($cache && $cache_time) {
        $fsCache = FSFactory::getClass('FSCache');
        $key = md5($_SERVER['REQUEST_URI']);
        $wrapper = $fsCache->get($key, $wrapper_name . '/' . $module, $cache_time);
        if ($wrapper) {
            return $wrapper;
        } else {
            $func_call = 'load' . ucfirst($wrapper_name);
            ob_start();
            $tmpl->$func_call();
            $wrapper = ob_get_contents();
            ob_end_clean();
            $fsCache->put($key, $wrapper, $wrapper_name . '/' . $module);
            return $wrapper;
        }
    } else {
        $func_call = 'load' . ucfirst($wrapper_name);
        ob_start();
        $tmpl->$func_call();
        $rs = ob_get_contents();
        ob_end_clean();
        return $rs;
    }
}

?>
