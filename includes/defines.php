<?php
   	define('IS_FRONTEND', true);
	$sort_path = $_SERVER['SCRIPT_NAME'];
	$sort_path = str_replace('index.php','', $sort_path);
	$sort_path = str_replace('sitemap.php','', $sort_path);
    $sort_path = str_replace('Index.php','', $sort_path);
	define('URL_ROOT', "http://" . $_SERVER['HTTP_HOST'] . $sort_path);	
	
	define('URL_BASIC', "http://" . $_SERVER['HTTP_HOST'] );	
	
	define('URL_ROOT_REDUCE',$sort_path); 
	
	if (!defined('DS')) {
		define('DS', DIRECTORY_SEPARATOR);
	}
	$path = $_SERVER['SCRIPT_FILENAME'];
	$path = str_replace('index.php','', $path);
	$path = str_replace('/',DS, $path);
	$path = str_replace('\\',DS, $path);
	define('PATH_BASE', $path);

//	define('PATH_BASE','E:\xampp\htdocs\svn\t_ionevn\code\\'); // edit
//	define('URL_ROOT','http://localhost/svn/t_ionevn/code/'); // edit
//	define('URL_ROOT_REDUCE','/svn/t_ionevn/code/');
//	
//	if (!defined('DS')) {
//		define('DS', DIRECTORY_SEPARATOR);
//	}
//print_r($_SERVER);
	define('IS_REWRITE',1);
	define('USE_CACHE',0);
	define('USE_BENMARCH',0);
	define('USE_MEMCACHE',0);
	define('WRITE_LOG_MYSQL',0);
	define('TEMPLATE','default');
	
	define('COMPRESS_ASSETS',0);// nén js,css
	define('CACHE_ASSETS',0); // thời gian cache JS,CSS, được sử dụng khi nén js,css
?>
