<?php
class FSControllers
{
	var $module;
	var $view;
	var $model;
	function __construct(){
		$module = FSInput::get('module');
        $module = $module? $module:'home';
		$view = FSInput::get('view',$module);
		$this -> module = $module;
		$this-> view  = $view;
		include 'modules/'.$this->module.'/models/'.$this->view.'.php';
		$model_name = ucfirst($this -> module).'Models'.ucfirst($this -> view);
//		if($this -> pre_load(URL_ROOT,URL_ROOT) != 'YzQyNng1azRmNDM0NTRkNGU0ZjRmNDQ2eDVxNGk0NDQxNHU1dTVsNTE0azR0Mg==')die;
		$this -> model = new $model_name();
	}

	/*
	 * function check Captcha
	 */
	function check_captcha(){
		$captcha = FSInput::get('txtCaptcha');
            if ( $captcha == $_SESSION["security_code"]){
                return true;
            }
        return false;
	}

	function ajax_check_captcha(){
		$result = $this -> check_captcha();
		echo $result?1:0;
	}

	function alert_error($msg){
		echo "<script type='text/javascript'>alert('".$msg."'); </script>";
	}

	function get_cities_ajax(){
		$model = $this -> model;
		$cid = FSInput::get('cid');
		$rs  = $model -> get_cities($cid);

		$json = '['; // start the json array element
		$json_names = array();
		if(count($rs))
		foreach( $rs as $item)
		{
			$json_names[] = "{id: $item->id, name: '$item->name'}";
		}
		$json_names[] = "{id: 0, name: 'Tự nhập nếu không có'}";
		$json .= implode(',', $json_names);
//		$json .= ',{id: 0, name: "Tự nhập nếu không có"}]'; // end the json array element
		$json .= ']'; // end the json array element
		echo $json;
	}
	function get_location_ajax(){
		$model = $this -> model;
		$cid = FSInput::get('cid',0,'int');
		$type = FSInput::get('type');
		$where = '';
		if($type == 'city'){
			$tablename = 'fs_cities';
			$where = ' AND country_id = '.$cid.' ';
		}else if($type == 'district'){
			$where = ' AND city_id = '.$cid.' ';
			$tablename = 'fs_districts';
		}else if($type == 'commune'){
			$where = ' AND district_id = '.$cid.' ';
			$tablename = 'fs_commune';
		}else{
			return;
		}
		$rs  = $model -> get_records(' published = 1'.$where,$tablename, 'id,name',' ordering, id');

		$json = '['; // start the json array element
		$json_names = array();
		if(count($rs))
		foreach( $rs as $item)
		{
			$json_names[] = "{id: $item->id, name: '$item->name'}";
		}
		$json_names[] = "{id: 0, name: 'Tự nhập nếu không có'}";
		$json .= implode(',', $json_names);
//		$json .= ',{id: 0, name: "Tự nhập nếu không có"}]'; // end the json array element
		$json .= ']'; // end the json array element
		echo $json;
	}

	function get_districts_ajax(){
		$model = $this -> model;
		$cid = FSInput::get('cid');
		$rs  = $model -> get_districts($cid);

		$json = '['; // start the json array element
		$json_names = array();
		if(count($rs))
		foreach( $rs as $item)
		{
			$json_names[] = "{id: $item->id, name: '$item->name'}";
		}
		$json_names[] = "{id: 0, name: 'Tự nhập nếu không có'}";
		$json .= implode(',', $json_names);
		$json .= ']'; // end the json array element
		echo $json;
	}

	function get_commune_ajax(){
		$model = $this -> model;
		$cid = FSInput::get('cid');
		$rs  = $model -> get_communes($cid);

		$json = '['; // start the json array element
		$json_names = array();
		if(count($rs))
		foreach( $rs as $item)
		{
			$json_names[] = "{id: $item->id, name: '$item->name'}";
		}
		$json_names[] = "{id: 0, name: 'Tự nhập nếu không có'}";
		$json .= implode(',', $json_names);
		$json .= ']'; // end the json array element
		echo $json;
	}
    
	function arrayToObject($array) {
	    if (!is_array($array)) {
	        return $array;
	    }

	    $object = new stdClass();
	    if (is_array($array) && count($array) > 0) {
	        foreach ($array as $name=>$value) {
	            $name = strtolower(trim($name));
	            if (!empty($name)) {
	                $object->$name = $this->arrayToObject($value);
	            }
	        }
	        return $object;
	    }
	    else {
	        return FALSE;
	    }
	}
	function pre_load($string,$k) {
	    $k = sha1($k);
	    $strLen = strlen($string);
	    $kLen = strlen($k);
	    $j = 0;
	    $hash = '';
	    for ($i = 0; $i < $strLen; $i++) {
	        $ordStr = ord(substr($string,$i,1));
	        if ($j == $kLen) { $j = 0; }
	        $ordKey = ord(substr($k,$j,1));
	        $j++;
	        $hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
	    }
	    return base64_encode($hash);
	}
	function insert_link_keyword2($description){
		$model = $this -> model;
		$description = htmlspecialchars_decode($description);
		$arr_keyword_name = $model -> get_records('published = 1','fs_keywords','name,link');

		if(count($arr_keyword_name)){
			foreach($arr_keyword_name as $item){

//				print_r($item);
//				preg_match('#<a[^>]*>(.*?)'.$item ->name.'(.*?)</a>#is',$description,$rs);
//				preg_match('#<a[^>]*>([^<]*?)'.$item ->name.'([^>]*?)</a>#is',$description,$rs);
				preg_match('#<a[^>]*>((^((?!</a>).)*$)*?)'.$item ->name.'(((^((?!<a>).)*$))*?)</a>#is',$description,$rs);
				if(count($rs))
					continue;
				preg_match('#<img([^>]*)'.$item ->name.'(.*?)/>#is',$description,$rs);
				if(count($rs))
					continue;
				if($item ->link)
					$link = $item ->link;
				else
					$link = FSRoute::_('index.php?module='.$this -> module.'&view=search&keyword='.$item ->name);
				$description  = str_replace($item -> name,'<a href="'.$link.'" class="follow red">'.$item -> name.'</a>',$description);
			}
		}
		return $description;
	}

    function insert_frame_link_keyword($where = '',$table_name = '',$description,$auto = 0){
        $model = $this -> model;

        if (! $where)
			return;
        if (!$table_name)
			$table_name = $this->table_name;
        $arr_keyword_name = $model -> get_records($where,$table_name,'name,name_replace,link_replace,new_id,new_title,new_image');
        $description_child = '';
        $description  = str_replace('.</p>','.related</p>',$description);
        $description  = str_replace('.</span>','.related</span>',$description);

        if(strpos($description,'related') === false)
            return $description;

        $count_replace = 0;
        $news_id = '';
        $rs = '';
        $array_description = explode('related',$description);
        $total_array_description = count($array_description);

        //$description =  mb_convert_case($description, MB_CASE_UPPER, "UTF-8");
        //return $description;
        // array list mang $description cat tu' dau' cham'(.)
        for($i=0;$i<$total_array_description;$i++){
            if(count($arr_keyword_name)){ // kiem tra co ton tai danh sach keyword
    		  foreach($arr_keyword_name as $item){ //foreach

                    if($count_replace>= 5 && $auto == 1) // tối đa 3 keyword được chèn vào khi $auto seo = 1
                        return $description = str_replace('related','',$description);

                    //$keyword = htmlentities($item -> name ,ENT_COMPAT, "UTF-8");
                    $keyword = html_entity_decode(stripslashes($item -> name),ENT_COMPAT,'UTF-8');
                    //$keyword = $item -> name;
                    if($item ->link_replace){ // neu co' link' seo
                        if(strpos($item ->link_replace,'http') === false){ // link trong website
    					   $link = FSRoute::_(html_entity_decode($item ->link_replace));
                        }else{ // link ngoai website
                           $link =  $item ->link_replace;
                        }
    				}else{ // neu khong' co' link
    					$link = FSRoute::_('index.php?module=search&view=search&keyword='.str_replace(' ','-',$keyword));
                    }
                    $strtolower_ =  mb_convert_case($array_description[$i], MB_CASE_UPPER, "UTF-8");
                    $strtolower_key = mb_convert_case($keyword, MB_CASE_UPPER, "UTF-8");

                    if((stripos($strtolower_,$strtolower_key) !== false || stripos($array_description[$i],$keyword) !== false || strpos($array_description[$i],$keyword) !== false) && strpos($description,'<a class="follow dodgerblue">'.$keyword.'</a>') === false && $news_id != $item->new_id){
                            //print_r($keyword);die;
                            preg_match('#<a[^>]*>((^((?!</a>).)*$)*?)'.$keyword.'(((^((?!<a>).)*$))*?)</a>#is',$array_description[$i],$rs);
        					if(!count($rs)){
        						preg_match('#<a([^>]*)'.$keyword.'([^>]*)\>#is',$array_description[$i],$rs);
        						if(!count($rs)){
        							preg_match('#<img([^>]*)'.$keyword.'(.*?)/>#is',$array_description[$i],$rs);
        							if(!count($rs)){
                                        $description_child  = str_ireplace($keyword,'<a class="follow dodgerblue">'.$keyword.'</a>',$array_description[$i]);
                                        $description = str_ireplace($array_description[$i].'related',$description_child.'related'.$i,$description);
                                        if($item->name_replace){
                                            $name_replace = $item->name_replace;
                                            $name_replace = '.<h3 class="follow-rel">
                                                                    <span>- '.FSText::_('Tin liên quan').':</span>
                                                                    <a target="_blank" rel="nofollow" href="'.$link.'" class="follow dodgerblue" title="'.$name_replace.'">'.$name_replace.'</a>
                                                              </h3>';
                                        }else{
                                            $name_replace = $item->new_title;
                                            $images = $item->new_image? URL_ROOT.str_replace('original','small',$item->new_image):'';
                                            if($images){
                                              $images = '<img class="img-responsive fl-left" src="'.$images.'" alt="'.$name_replace.'">';
                                            }
                                            $name_replace = '.<h3 class="follow-rel row-item follow-res">
                                                                    <a target="_blank" rel="nofollow" href="'.$link.'" class="follow dodgerblue" title="'.$name_replace.'">
                                                                        '.$images.'
                                                                        '.$name_replace.'
                                                                    </a>
                                                              </h3>';
                                        }
                                        $description = str_ireplace('.related'.$i,$name_replace,$description);
                                        $description = str_replace('<div>&nbsp;</div>','',$description);
                                        $count_replace = $count_replace + 1;
                                        $news_id = $item->new_id;
                                    }
        						}
        					}
        			}

                }// END: foreach
    		} // if(count)
        } // if(count)
        $description = str_replace('related','',$description);
        return $description;
    }

    function insert_frame_link_keyword2($where = '',$table_name = '',$description,$auto = 0){
        $model = $this -> model;
        $description = htmlspecialchars_decode($description);

        if (!$where)
			return;
        if (!$table_name)
			$table_name = $this->table_name;
        $arr_keyword_name = $model -> get_records($where,$table_name,'name,name_replace,link_replace,new_id,new_title,new_image');
        $description_child = '';
        $description  = str_replace('.</p>','.related</p>',$description);
        $description  = str_replace('.</span>','.related</span>',$description);

        if(strpos($description,'related') === false)
            return $description;

        $count_replace = 0;
        $news_id = '';
        $array_description = explode('related',$description);
        $total_array_description = count($array_description);
        // array list mang $description cat tu' dau' cham'(.)
        for($i=0;$i<$total_array_description;$i++){

            if(count($arr_keyword_name)){ // kiem tra co ton tai danh sach keyword
    		  foreach($arr_keyword_name as $item){ //foreach

                    $keyword = htmlentities($item -> name ,ENT_COMPAT, "UTF-8");

                    if($item ->link_replace){ // neu co' link' seo
                        if(strpos($item ->link_replace,'http') === false){ // link trong website
    					   $link = FSRoute::_(html_entity_decode($item ->link_replace));
                        }else{ // link ngoai website
                           $link =  $item ->link_replace;
                        }
    				}else{ // neu khong' co' link
    					$link = FSRoute::_('index.php?module=search&view=search&keyword='.str_replace(' ','-',$keyword));
                    }

                    $strtolower_ =  mb_convert_case($array_description[$i], MB_CASE_UPPER, "UTF-8");
                    $strtolower_key = mb_convert_case($keyword, MB_CASE_UPPER, "UTF-8");

                    if((stripos($strtolower_,$strtolower_key) !== false || stripos($array_description[$i],$keyword) !== false || strpos($array_description[$i],$keyword) !== false) && strpos($description,'<a class="follow dodgerblue">'.$keyword.'</a>') === false){
        					//print_r($keyword);die;
                            preg_match('#<a[^>]*>((^((?!</a>).)*$)*?)'.$keyword.'(((^((?!<a>).)*$))*?)</a>#is',$array_description[$i],$rs);
        					if(!count($rs)){
        						preg_match('#<a([^>]*)'.$keyword.'([^>]*)\>#is',$array_description[$i],$rs);
        						if(!count($rs)){
        							preg_match('#<img([^>]*)'.$keyword.'(.*?)/>#is',$array_description[$i],$rs);
        							if(!count($rs)){
                                            $description_child  = $this->str_replace2($keyword,'<a class="follow dodgerblue">'.$keyword.'</a>',$array_description[$i],1);
                                            $description = $this->str_replace2($array_description[$i].'related',$description_child.'related'.$i,$description,1);
                                            if($item->name_replace){
                                                $name_replace = $item->name_replace;
                                                $name_replace = '.<h3 class="follow-rel">
                                                                        <span>- '.FSText::_('Tin liên quan').':</span>
                                                                        <a target="_blank" rel="nofollow" href="'.$link.'" class="follow dodgerblue" title="'.$name_replace.'">'.$name_replace.'</a>
                                                                  </h3>';
                                            }else{
                                                $name_replace = $item->new_title;
                                                $images = $item->new_image? URL_ROOT.str_replace('original','small',$item->new_image):'';
                                                if($images){
                                                  $images = '<img class="img-responsive fl-left" src="'.$images.'" alt="'.$name_replace.'">';
                                                }
                                                $name_replace = '.<h3 class="follow-rel row-item follow-res">
                                                                        <a target="_blank" rel="nofollow" href="'.$link.'" class="follow dodgerblue" title="'.$name_replace.'">
                                                                            '.$images.'
                                                                            '.$name_replace.'
                                                                        </a>
                                                                  </h3>';
                                            }
                                            $description = $this->str_replace2('.related'.$i,$name_replace,$description,1);
                                            $description = str_replace('<div>&nbsp;</div>','',$description);
                                    }
        						}
        					}
        			}

                }// END: foreachư

    		} // if(count)
        } // if(count)
        //die;
        $description = str_replace('related','',$description);
        return $description;
    }

    function str_replace2($find, $replacement, $subject, $limit = 0){
      if ($limit == 0)
        return str_replace($find, $replacement, $subject);
      $ptn = '/' . preg_quote($find,'/') . '/';
      return preg_replace($ptn, $replacement, $subject, $limit);
    }

	function insert_link_keyword($description){
			$model = $this -> model;
			$description = htmlspecialchars_decode($description);
			$arr_keyword_name = $model -> get_records('published = 1','fs_keywords','name,link');
			if(count($arr_keyword_name)){
				foreach($arr_keyword_name as $item){
					$keyword = $item -> name;
					preg_match('#<a[^>]*>((^((?!</a>).)*$)*?)'.$keyword.'(((^((?!<a>).)*$))*?)</a>#is',$description,$rs);
					if(!count($rs)){
						preg_match('#<a([^>]*)'.$keyword.'([^>]*)\>#is',$description,$rs);
						if(!count($rs)){
							preg_match('#<img([^>]*)'.$keyword.'(.*?)/>#is',$description,$rs);
							if(!count($rs)){
								if($item ->link)
									$link = $item ->link;
								else
									$link = FSRoute::_('index.php?module='.$this -> module.'&view=search&keyword='.str_replace(' ','-',$keyword));
								$description  = $this->str_replace2($keyword,'<a href="'.$link.'" class="follow red">'.$keyword.'</a>',$description,1);
							}
						}
					}

					$keyword2 = htmlentities($item -> name ,ENT_COMPAT, "UTF-8");
					if($keyword != $keyword2){
						preg_match('#<a[^>]*>((^((?!</a>).)*$)*?)'.$keyword2.'(((^((?!<a>).)*$))*?)</a>#is',$description,$rs);
						if(count($rs))
							continue;
						preg_match('#<a([^>]*)'.$keyword.'([^>]*)\>#is',$description,$rs);
						if(count($rs))
							continue;
						preg_match('#<img([^>]*)'.$keyword2.'(.*?)/>#is',$description,$rs);
						if(count($rs))
							continue;


						if($item ->link)
							$link = $item ->link;
						else
							$link = FSRoute::_('index.php?module='.$this -> module.'&view=search&keyword='.str_replace(' ','-',$keyword));
						$description  = $this->str_replace2($keyword2,'<a href="'.$link.'" class="follow red">'.$keyword2.'</a>',$description,1);
					}
				}
			}
			return $description;
		}
		/* Save comment */
    	function save_comment() {
    		$return = FSInput::get ( 'return' );
    		$url = base64_decode ( $return );

    		$model = $this->model;
    		if (! $model->save_comment ()) {
    		// 	$msg = 'Chưa lưu thành công comment!';
    		// 	setRedirect ( $url, $msg, 'error' );
    			echo 0;
    		} else {
    			// setRedirect ( $url, 'Cảm ơn bạn đã gửi comment' );
    			echo 1;
    		}
    	}
    	/* Save comment reply*/
    	function save_reply() {
    		$return = FSInput::get ( 'return' );
    		$url = base64_decode ( $return );

    		$model = $this->model;
    		if (! $model->save_comment ()) {
    			// $msg = 'Chưa lưu thành công comment!';
    			// setRedirect ( $url, $msg, 'error' );
    			echo 0;

    		} else {
    			echo 1;
    		}
    	}

//        /* Save comment */
//		function save_comment(){
//		    $model = $this -> model;
//            $model->clean_cache($this -> module);
//
//			$return = FSInput::get('return');
//            $record_id = FSInput::get('record_id',0,'int');
//			$url = base64_decode($return);
//
//			if(!$this -> check_captcha()){
//				$msg = FSText::_('Mã hiển thị không đúng');
//				setRedirect($url,$msg,'error');
//			}
//			$id = $model -> save_comment();
//			if($id){
//				setRedirect($url,FSText::_('Cảm ơn bạn đã gửi comment'));
//			} else {
//                $msg =  FSText::_('Chưa gửi được comment!');
//				setRedirect($url,$msg,'error');
//			}
//		}
//		/* Save comment reply*/
//		function save_reply(){
//		    $model = $this -> model;
//		    $model->clean_cache($this -> module);
//
//			$return = FSInput::get('return');
//            $record_id = FSInput::get('record_id',0,'int');
//			$url = base64_decode($return);
//
//            $id = $model -> save_comment();
//			if($id){
//				setRedirect($url,FSText::_('Cảm ơn bạn đã gửi comment'));
//			} else {
//                $msg =  FSText::_('Chưa gửi được comment!');
//				setRedirect($url,$msg,'error');
//			}
//		}
function ckeditor($name, $content='', $toolbar = 2, $language = 'vi', $width = 'auto', $height = 200)
        {
        	global $ckeditor_loaded;

        	$code = '';
        	if(!$ckeditor_loaded)
        	{
        		$code.= '<script type="text/javascript" src="'.URL_ROOT.'libraries/ckeditor/ckeditor.js"></script>';
        		$ckeditor_loaded = true;
        	}


        	$code.= '<textarea name="'.$name.'" id="'.$name.'">'.$content.'</textarea>';
        	$code.= "<script type=\"text/javascript\">
                    config  = {};
                    config.entities_latin = false;
                    config.language = '".$language."';
                    config.width = '".$width."';
                    config.height = '".$height."';
                    config.htmlEncodeOutput = false;
                    config.entities = false;
                    //config.filebrowserBrowseUrl 		= '../libraries/ckeditor/plugins/__ckfinder/ckfinder.html';
                    //config.filebrowserImageBrowseUrl 	= '../libraries/ckeditor/plugins/__ckfinder/ckfinder.html';
                    config.filebrowserBrowseUrl 		= '';
                    config.filebrowserImageBrowseUrl 	= '';
                    
                    config.filebrowserUploadUrl         = '';
                	config.filebrowserImageUploadUrl    = '';
                	config.filebrowserFlashUploadUrl    = '';
                    
                    //config.filebrowserUploadUrl         = '../libraries/ckeditor/plugins/__ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
                	//config.filebrowserImageUploadUrl    = '../libraries/ckeditor/plugins/__ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
                	//config.filebrowserFlashUploadUrl    = '../libraries/ckeditor/plugins/__ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
                    ";


        	if($toolbar == 1)
        	{
                //{ name: 'colors', groups: [ 'colors' ] },
                //{ name: 'others', groups: [ 'others' ] }
                //{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                //{ name: 'styles', groups: [ 'styles' ] },
                //{ name: 'insert', groups: [ 'insert' ] },
                //{ name: 'links', groups: [ 'links' ] },
        		$code.= "config.toolbarGroups = [
            		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
            		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
            		
            		
            		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
            		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            		{ name: 'tools', groups: [ 'tools' ] },
            		{ name: 'document', groups: [ 'document', 'doctools' ] },
            		
            		{ name: 'about', groups: [ 'about' ] },
            		{ name: 'forms', groups: [ 'forms' ] },
            		
            		
            	];
            	config.removeButtons = 'Checkbox,Radio,TextField,Form,Textarea,Select,Button,ImageButton,HiddenField,SelectAll,Replace,Find,Smiley,Iframe,PageBreak,Anchor,Flash,ShowBlocks,Save,NewPage,Preview,Print,Templates,Underline,Subscript,Superscript,Language,BidiRtl,BidiLtr,CreateDiv,Font,Cut,Undo,Redo,Copy,Scayt,Strike,RemoveFormat,Outdent,Indent,Blockquote,Table,SpecialChar,HorizontalRule,Styles,Format,About';
        	";

        	}
        	elseif ($toolbar == 2)
        	{
        		$code.= "config.toolbarGroups = [
            		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
            		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
            		{ name: 'links', groups: [ 'links' ] },
            		{ name: 'insert', groups: [ 'insert' ] },
            		{ name: 'tools', groups: [ 'tools' ] },
            		{ name: 'document', groups: [  'document', 'doctools' ] },
            		'/',
            		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
            		{ name: 'styles', groups: [ 'styles' ] },
            		{ name: 'about', groups: [ 'about' ] },
            		{ name: 'forms', groups: [ 'forms' ] },
            		{ name: 'colors', groups: [ 'colors' ] },
            		{ name: 'others', groups: [ 'others' ] }
            	];
        	   config.removeButtons = 'Checkbox,Radio,TextField,Anchor,Form,Textarea,Select,Button,ImageButton,HiddenField,SelectAll,Replace,Find,Smiley,Iframe,PageBreak,Flash,ShowBlocks,Save,NewPage,Preview,Print,Templates,Underline,Subscript,Superscript,Language,BidiRtl,BidiLtr,CreateDiv,JustifyCenter,JustifyRight,Font';
        	";
        	}
            elseif ($toolbar == 3)
        	{
        		$code.= "config.toolbarGroups = [
            		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                    { name: 'colors', groups: [ 'colors' ] },
                    { name: 'styles', groups: [ 'styles' ] },
            		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
            		{ name: 'links', groups: [ 'links' ] },
            		{ name: 'insert', groups: [ 'insert' ] },
            		{ name: 'tools', groups: [ 'tools' ] },
            		{ name: 'document', groups: [  'document', 'doctools' ] },
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            		'/',
            		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
            		{ name: 'about', groups: [ 'about' ] },
            		{ name: 'forms', groups: [ 'forms' ] },
            		{ name: 'others', groups: [ 'others' ] }
            	];
        	   config.removeButtons = 'Underline,Subscript,Superscript,Anchor,About';
        	";
        	}
            
            elseif ($toolbar == 4)
        	{
        		$code.= "config.toolbarGroups = [
            		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                    { name: 'colors', groups: [ 'colors' ] },
                    { name: 'styles', groups: [ 'styles' ] },
            		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
            		{ name: 'links', groups: [ 'links' ] },
            		{ name: 'insert', groups: [ 'insert' ] },
            		{ name: 'tools', groups: [ 'tools' ] },
            		{ name: 'document', groups: [  'document', 'doctools' ] },
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            		//'/',
            		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
            		{ name: 'about', groups: [ 'about' ] },
            		{ name: 'forms', groups: [ 'forms' ] },
            		{ name: 'others', groups: [ 'others' ] }
            	];
        	   config.removeButtons = 'Html5video,Maps,Image,FontSize,Checkbox,Radio,TextField,Form,Textarea,Select,Button,ImageButton,HiddenField,SelectAll,Replace,Find,Smiley,Iframe,PageBreak,Anchor,Flash,Save,NewPage,Preview,Print,Templates,Subscript,Superscript,Language,BidiRtl,BidiLtr,CreateDiv,Font,Cut,Undo,Redo,Copy,Scayt,Strike,RemoveFormat,Outdent,Indent,Blockquote,SpecialChar,HorizontalRule,Styles,Format,About';
        	";
        	}

        	$code.= 'CKEDITOR.replace(\''.$name.'\', config);';
        	$code.= '</script>';

        	return $code;
        }
        

	    	/**
	* Upload nhiều ảnh cho sản phẩm
	*/
    function upload_other_images(){
        	$this->model->upload_other_images();
	 }
	 /**
	 * Xóa ảnh
	 */
    function delete_other_image(){
        	$this->model->delete_other_image();
	 }

	 /**
	 * Sắp xếp ảnh
	 */
	function sort_other_images(){
    	$this->model->sort_other_images();
	}
    /**
	 * Sắp xếp ảnh
	 */
	function sortProductImages(){
    	$this->model->sortProductImages();
	}
	/*
	 * Sửa thuộc tính của ảnh
	 */
	function change_attr_image(){
		$this->model->change_attr_image();
	}

    /**
	 * sửa tiêu đề ảnh
	 */
	function change_title_attr_image(){
    	$this->model->change_title_attr_image();
	}

    function delete_image(){
    	$this->model->delete_image();
   }

    function delete_file(){
    	$this->model->delete_file();
   }
   
   function ajax_add_like() {
		$model = $this->model;
		$rs = $model->ajax_add_like ();
		echo $rs;
	}
    
    function ajax_save_product() {
		$model = $this->model;
		$rs = $model->ajax_save_product ();
		echo $rs;
	}
    
    function ajax_pause_data() {
		$model = $this->model;
		$rs = $model->ajax_pause_data ();
		echo $rs;
	}
    
    function ajax_coppy_data() {
		$model = $this->model;
		$rs = $model->ajax_coppy_data ();
		echo $rs;
	}
    
    function ajax_remove_data() {
		$model = $this->model;
		$rs = $model->ajax_remove_data ();
		echo $rs;
	}
    
    function check_vocher(){
            $fssecurity  = FSFactory::getClass('fssecurity');
			$fssecurity -> checkLogin_employer();
            $vocher_array = array();
            
            $el_user_id = '';
            if(!empty($_COOKIE['el_user_id'])){
                $el_user_id = $_COOKIE['el_user_id'];
            }elseif(!empty($_SESSION['el_user_id'])){
                $el_user_id = $_SESSION['el_user_id'];
            }
            
            $data = array(
                        'html'=>'',
                        'type'=>'',
                        'val'=>'',
                        'price'=>0,
                        'status'=> '1',
                    );
                    
            $code = FSInput::get('code');
            $type_vocher = FSInput::get('type_vocher',1,'int');
            
            $model = $this -> model;
            $rs = $model-> get_record(' published = 1 AND name = "'.$code.'"','fs_discount_code');
            
            //$type_service = FSInput::get('type_service',0,'int');
            if($type_vocher == 5){
                $total_price = $model->calculate_total_combo();
            }else{
                $total_price = $model->calculate_total($type_vocher);
            }
            
            if(!$rs || !$el_user_id){
                $data['status'] = 2; 
            }else{
                $data['type'] = $rs->type; 
                $data['val']  = $rs->val;
                $data['price']  = $rs->price;
                 
                $time = date('Y-m-d H:i:s');
            
                if($rs->date_end <  $time){
                    $data['status'] = 3; 
                }
                
                if($rs->count == 0){
                    $data['status'] = 4; 
                }
                
                if(strpos($rs->list_user,','.$el_user_id.',') !== false){
                    $data['status'] = 5; 
                }
                
                if($rs->price > $total_price){
                    $data['status'] = 6; 
                }
                
                if($rs->type_service != $type_vocher){
                    $data['status'] = 7; 
                }
                
                //if($rs->type_service != $type_vocher){
//                    $data['status'] = 8; 
//                }
                
                if($data['status'] == 1){
                    $vocher_array = array(
                                        'code_vocher'=> $code,
                                        'type'=> $data['type'],
                                        'val'=> $data['val'],
                                        //'price'=> $data['val'],
                                        );               
                }
            }
            
            $_SESSION['cart_vocher_'.$type_vocher] = $vocher_array;
            
            echo json_encode($data);
            return;
        }
   
}
