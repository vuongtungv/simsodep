<?php
/*
 * Huy write
 */

class FSString
{
	function generateRandomString($length=8)
 	{
	 	$characters = array(
			"A","B","C","D","E","F","G","H","J","K","L","M",
			"N","P","Q","R","S","T","U","V","W","X","Y","Z",
			"1","2","3","4","5","6","7","8","9");
		
		//make an "empty container" or array for our keys
		$keys = array();
		
		//first count of $keys is empty so "1", remaining count is 1-6 = total 7 times
		while(count($keys) <= $length) {
		    //"0" because we use this to FIND ARRAY KEYS which has a 0 value
		    //"-1" because were only concerned of number of keys which is 32 not 33
		    //count($characters) = 33
		    $x = mt_rand(0, count($characters)-1);
		    if(!in_array($x, $keys)) {
		       $keys[] = $x;
		    }
		}
		$random_chars = "";
		foreach($keys as $key){
		   $random_chars .= $characters[$key];
		}
		return $random_chars;
 	}
 	
 	/*
	 * Remove viet sign and replace " " to "-"
	 */
 	
 	function parseString($str){
 		$arr=array("&ldquo;","&rdquo;","&lsquo;","&rsquo;","&quot;","'","&gt;","&lt;");
		$str=str_replace($arr, "-", $str);
 		$arr=array(".","!","~","@","#","$","%","^","&","*","(",")","=","+","|","\\","/","?",",","'",'"','“','”','>','<','quot;');
		$str=str_replace($arr, "", $str);
		$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
		
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
		$str = preg_replace("/(đ)/", 'd', $str);
		
		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
		$str = preg_replace("/(Đ)/", 'D', $str);



		$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
		return $str;
	} 
	
	/*
	 * Remove viet sign but not replace " " to "-"
	 */
	function remove_viet_sign($str){
		$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
		$str = preg_replace("/(đ)/", 'd', $str);
		
		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
		$str = preg_replace("/(Đ)/", 'D', $str);
		
		$arr=array(".","!","~","@","#","$","%","^","&","*","(",")","=","+","|","\\","/","?",",","'");
		$str=str_replace($arr, "", $str);
		
		return $str;
	}
	
	function stringStandart($str)
	{
		$str  =  $this -> parseString($str);
		$str = preg_replace('/\s\s+/', ' ', $str);
		$str = str_replace(' ','-',$str);
		$str = strtolower ( $str);
		return $str;
	}
    
    function stringStandart2($str)
	{
		$str  =  $this -> parseString($str);
		$str = preg_replace('/\s\s+/', ' ', $str);
		$str = str_replace('-','',$str);
		$str = strtolower ( $str);
		return $str;
	}

	//lo?i b? ho?t d?ng c?a các th? html, vô hi?u hóa
	function htmlspecialbo($str){
		$arrDenied	= array('<', '>', '"');
		$arrReplace	= array('&lt;', '&gt;', '&quot;');
		$str = str_replace($arrDenied, $arrReplace, $str);
		return $str;
	}
	
	// lo?i b? các th? html, javascript
	function removeHTML($string){
		$string = preg_replace ('/<script.*?\>.*?<\/script>/si', ' ', $string); 
		$string = preg_replace ('/<style.*?\>.*?<\/style>/si', ' ', $string); 
		$string = preg_replace ('/<.*?\>/si', ' ', $string); 
		$string = str_replace ('&nbsp;', ' ', $string);
		$string = html_entity_decode ($string);
		return $string;
	}
	//hàm c?t chu?i
	function cut_string($str,$length){
		if (mb_strlen($str,"UTF-8") > $length) return mb_substr($str,0,$length,"UTF-8") . "...";
		else return $str;
	}
	
	function str_encode($encodeStr="")
	{
		$returnStr = "";
		if($encodeStr == '') return $encodeStr;
		if(!empty($encodeStr)) {
			$enc = base64_encode($encodeStr);
			$enc = str_replace('=','',$enc);
			$enc = str_rot13($enc);
			$returnStr = $enc;
		}
		return $returnStr;
	}
	
	function str_decode($encodedStr="",$type=0)
	{
	  $returnStr = "";
	  $encodedStr = str_replace(" ","+",$encodedStr);
		if(!empty($encodedStr)) {
			 $dec = str_rot13($encodedStr);
			 $dec = base64_decode($dec);
			$returnStr = $dec;
		}
	  return $returnStr;
	}
	function random(){
		$rand_value = "";
		$rand_value.=rand(1000,9999);
		$rand_value.=chr(rand(65,90));
		$rand_value.=rand(1000,9999);
		$rand_value.=chr(rand(97,122));
		$rand_value.=rand(1000,9999);
		$rand_value.=chr(rand(97,122));
		$rand_value.=rand(1000,9999);
		return $rand_value;
	}
 //End function
	  function implodeWord($str,$noWord){
			
			$str = preg_replace("/ +/i", " ", $str);
			$array = explode(" ", $str);

	
			for($i=0;$i<$noWord;$i++){       
			  if (preg_match("/[0-9A-Za-zÀ-ÖØ-öø-ÿ]/i", $array[$i])) $aryContent[] = $array[$i];
			  
			}
			$strContent = implode(" ",$aryContent);
			return $strContent;
	  }
	  function getWord($noWord,$str){
			
			$noCountWord = FSString::count_words(strip_tags($str));
			if($noCountWord >= $noWord){
			  $content = FSString::implodeWord(strip_tags($str),$noWord).'...';
			} else {
			  $content = strip_tags($str);
			}
			
			$k = chr(92); 
			$content = str_replace($k,"",$content);
		
			return $content;
	  }
	function count_words($str) {
		$words = 0;
		
		$str =  preg_replace("/ +/i", " ", $str);
		$array = explode(" ", $str);
		for($i=0;$i < count($array);$i++){
	
		  if (preg_match("/[0-9A-Za-zÀ-ÖØ-öø-ÿ]/i", $array[$i]))
	
		  $words++;
		}
		return $words;
	}
	function convertDateTime($strDate = "", $strTime = ""){
		//Break string and create array date time
		$strDateArray	= explode("-", $strDate);
		$countDateArr	= count($strDateArray);
		$strTime		= str_replace("-", ":", $strTime);
		$strTimeArray	= explode(":", $strTime);
		$countTimeArr	= count($strTimeArray);
		//Get Current date time
		$today			= getdate();
		$day				= $today["mday"];
		$mon				= $today["mon"];
		$year				= $today["year"];
		$hour				= $today["hours"];
		$min				= $today["minutes"];
		$sec				= $today["seconds"];
		//Get date array
		switch($countDateArr){
			case 2:
				$day	= intval($strDateArray[0]);
				$mon	= intval($strDateArray[1]);
				break;
			case $countDateArr >= 3:
				$day	= intval($strDateArray[0]);
				$mon	= intval($strDateArray[1]);
				$year = intval($strDateArray[2]);
				break;
		}
		//Get time array
		switch($countTimeArr){
			case 2:
				$hour	= intval($strTimeArray[0]);
				$min	= intval($strTimeArray[1]);
				break;
			case $countTimeArr >= 3:
				$hour	= intval($strTimeArray[0]);
				$min	= intval($strTimeArray[1]);
				$sec	= intval($strTimeArray[2]);
				break;
		}
		//Return date time integer
		if(@mktime($hour, $min, $sec, $mon, $day, $year) == -1) return $today[0];
		else return mktime($hour, $min, $sec, $mon, $day, $year);
	}
	
	function convert_utf8_to_telex($str) {
		$str=strtr($str, array(
		'à'=>'af',
		'á'=>'as',
		'ả'=>'ar',
		'ã'=>'ax',
		'ạ'=>'aj',
		
		'ă'=>'aw',
		'ằ'=>'awf',
		'ắ'=>'aws',
		'ẳ'=>'awr',
		'ẵ'=>'awx',
		'ặ'=>'awj',

		'â'=>'aa',		
		'ầ'=>'aaf',
		'ấ'=>'aas',
		'ẩ'=>'aar',
		'ẫ'=>'aax',
		'ậ'=>'aaj',

		'đ'=>'dd',

		'è'=>'ef',
		'é'=>'es',
		'ẻ'=>'er',
		'ẽ'=>'ex',
		'ẹ'=>'ej',

		'ê'=>'ee',		
		'ề'=>'eef',
		'ế'=>'ees',
		'ể'=>'eer',
		'ễ'=>'eex',
		'ệ'=>'eej',

		'ì'=>'if',
		'í'=>'is',
		'ỉ'=>'ir',
		'ĩ'=>'ix',
		'ị'=>'ij',

		'ò'=>'of',
		'ó'=>'os',
		'ỏ'=>'or',
		'õ'=>'ox',
		'ọ'=>'oj',

		'ô'=>'oo',		
		'ồ'=>'oof',
		'ố'=>'oos',
		'ổ'=>'oor',
		'ỗ'=>'oox',
		'ộ'=>'ooj',

		'ơ'=>'ow',		
		'ờ'=>'owf',
		'ớ'=>'ows',
		'ở'=>'owr',
		'ỡ'=>'owx',
		'ợ'=>'owj',

		'ù'=>'uf',
		'ú'=>'us',
		'ủ'=>'ur',
		'ũ'=>'ux',
		'ụ'=>'uj',

		'ư'=>'uw',		
		'ừ'=>'uwf',
		'ứ'=>'uws',
		'ử'=>'uwr',
		'ữ'=>'uwx',
		'ự'=>'uwj',

		'À'=>'af',
		'Á'=>'as',
		'Ả'=>'ar',
		'Ã'=>'ax',
		'Ạ'=>'aj',
		
		'Ă'=>'aw',
		'Ằ'=>'awf',
		'Ắ'=>'aws',
		'Ẳ'=>'awr',
		'Ẵ'=>'awx',
		'Ặ'=>'awj',

		'Â'=>'aa',		
		'Ầ'=>'aaf',
		'Ấ'=>'aas',
		'Ẩ'=>'aar',
		'Ẫ'=>'aax',
		'Ậ'=>'aaj',

		'Đ'=>'dd',

		'È'=>'ef',
		'É'=>'es',
		'Ẻ'=>'er',
		'Ẽ'=>'ex',
		'Ẹ'=>'ej',

		'Ê'=>'ee',		
		'Ề'=>'eef',
		'Ế'=>'ees',
		'Ể'=>'eer',
		'Ễ'=>'eex',
		'Ệ'=>'eej',

		'Ì'=>'if',
		'Í'=>'is',
		'Ỉ'=>'ir',
		'Ĩ'=>'ix',
		'Ị'=>'ij',

		'Ò'=>'of',
		'Ó'=>'os',
		'Ỏ'=>'or',
		'Õ'=>'ox',
		'Ọ'=>'oj',

		'Ô'=>'oo',		
		'Ồ'=>'oof',
		'Ố'=>'oos',
		'Ổ'=>'oor',
		'Ỗ'=>'oox',
		'Ộ'=>'ooj',

		'Ơ'=>'ow',		
		'Ờ'=>'owf',
		'Ớ'=>'ows',
		'Ở'=>'owr',
		'Ỡ'=>'owx',
		'Ợ'=>'owj',

		'Ù'=>'uf',
		'Ú'=>'us',
		'Ủ'=>'ur',
		'Ũ'=>'ux',
		'Ụ'=>'uj',

		'Ư'=>'uw',		
		'Ừ'=>'uwf',
		'Ứ'=>'uws',
		'Ử'=>'uwr',
		'Ữ'=>'uwx',
		'Ự'=>'uwj',

		'ỳ'=>'yf',
		'ý'=>'ys',
		'ỷ'=>'yr',
		'ỹ'=>'yx',
		'ỵ'=>'yj',
		
		'À'=>'af',
		'Á'=>'as',
		'Ả'=>'ar',
		'Ã'=>'ax',
		'Ạ'=>'aj',
		
		'Ă'=>'aw',
		'Ằ'=>'awf',
		'Ắ'=>'aws',
		'Ẳ'=>'awr',
		'Ẵ'=>'awx',
		'Ặ'=>'awj',

		'Â'=>'aa',		
		'Ầ'=>'aaf',
		'Ấ'=>'aas',
		'Ẩ'=>'aar',
		'Ẫ'=>'aax',
		'Ậ'=>'aaj',

		'Đ'=>'dd',

		'È'=>'ef',
		'É'=>'es',
		'Ẻ'=>'er',
		'Ẽ'=>'ex',
		'Ẹ'=>'ej',

		'Ê'=>'ee',		
		'Ề'=>'eef',
		'Ế'=>'ees',
		'Ể'=>'eer',
		'Ễ'=>'eex',
		'Ệ'=>'eej',

		'Ì'=>'if',
		'Í'=>'is',
		'Ỉ'=>'ir',
		'Ĩ'=>'ix',
		'Ị'=>'ij',

		'Ò'=>'of',
		'Ó'=>'os',
		'Ỏ'=>'or',
		'Õ'=>'ox',
		'Ọ'=>'oj',

		'Ô'=>'oo',		
		'Ồ'=>'oof',
		'Ố'=>'oos',
		'Ổ'=>'oor',
		'Ỗ'=>'oox',
		'Ộ'=>'ooj',

		'Ơ'=>'ow',		
		'Ờ'=>'owf',
		'Ớ'=>'ows',
		'Ở'=>'owr',
		'Ỡ'=>'owx',
		'Ợ'=>'owj',

		'Ù'=>'uf',
		'Ú'=>'us',
		'Ủ'=>'ur',
		'Ũ'=>'ux',
		'Ụ'=>'uj',

		'Ư'=>'uw',		
		'Ừ'=>'uwf',
		'Ứ'=>'uws',
		'Ử'=>'uwr',
		'Ữ'=>'uwx',
		'Ự'=>'uwj',
		
		'Ỳ'=>'yf',
		'Ý'=>'ys',
		'Ỷ'=>'yr',
		'Ỹ'=>'yx',
		'Ỵ'=>'yj',
		));
		return $str;
	} 
}