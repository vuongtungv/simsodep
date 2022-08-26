<?php
/*
 * Huy write
 */

class FSMemcache{
	var $memc;
	function __construct(){
	}
	
	function connect(){
		$this -> memc = new Memcache;
		$connect = @$this -> memc ->connect('localhost', 11211) ;
		return $connect;
	}

	function get_version(){
		$this -> connect();
		return $this -> memc -> getVersion();
	}
	
	function get($key){
		if(!$this -> check_exist_memcache())
			return false;
		if(!$this -> connect())
			return;
		
		return $this -> memc->get($key);
	}
	
	function set($key,$value,$time){
		if(!$this -> check_exist_memcache())
			return false;
		if(!$this -> connect())
			return;
		$this -> memc -> set($key, $value, false, $time) or die ("Failed to save data at the server");
	}
	
	function check_exist_memcache(){
		if(class_exists('Memcache'))
	  		return true;
		return false;
	}
}
//
// 
////Can Use 127.0.0.1 instead "localhost"
//$version = $memcache->getVersion();
//echo "Server's version: ".$version."<br/>\n";
//$tmp_object = new stdClass;
//$tmp_object->str_attr = 'test';
//$tmp_object->int_attr = 123;
//$memcache->set('key', $tmp_object, false, 10) or die ("Failed to save data at the server");
//echo "Store data in the cache (data will expire in 10 seconds)<br/>\n";
//$get_result = $memcache->get('key');
//echo "Data from the cache:<br/>\n";
//var_dump($get_result);