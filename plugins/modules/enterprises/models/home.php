<?php 
	class EnterprisesModelsHome extends FSModels
	{
		function __construct(){
			
		parent::__construct();
		global $module_config;
		FSFactory::include_class('parameters');
		$current_parameters = new Parameters($module_config->params);
		$limit   = $current_parameters->getParams('limit'); 
		$this->limit = $limit;
		$this -> limit_per_cat = 4;
	
		}
		/*
		 * select cat list is children of catid
		 */
		function get_cats()
		{
			global $db;
			$query = " SELECT id,name, alias, list_parents,image,level,parent_id
					FROM fs_enterprises_categories 
					WHERE 
						show_in_homepage = 1
					ORDER BY ordering
							";
			$db->query($query);
			$list = $db->getObjectList();
			
			return $list;	
		}
		function set_query_body()
		{
			$date1  = FSInput::get("date_search");
			$where  = "";
			$fs_table = FSFactory::getClass('fstable');
			$query = " FROM ".$fs_table -> getTable('fs_enterprises')."
						  WHERE 
						  	 published = 1 
						  	". $where.
						    " ORDER BY  ordering DESC,created_time DESC, id DESC 
						 ";
			return $query;
		}
		
		function get_list($query_body)
		{
			if(!$query_body)
				return;
				
			global $db;
			$query = " SELECT * ";
			
            $query .= $query_body;
            //print_r($query);
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			return $result;
		}
		
		/*
		 * return enterprises list in category list.
		 * These categories is Children of category_current
		 */
		function get_list_in_cat($cat_id)
		{
			global $db;
			if(!$cat_id)
				return false;
			
			$order = " ORDER BY ordering DESC, id DESC ";
			$query   = " SELECT *
						FROM fs_enterprises 
						WHERE category_id_wrapper like '%,".$cat_id.",%' AND published = 1 AND category_published = 1 " 
						.$order." 
						LIMIT ".$this -> limit_per_cat." ";
						
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function getTotal($query_body)
		{
			if(!$query_body)
				return ;
			global $db;
			$query = "SELECT count(*)";
			$query .= $query_body;
			$sql = $db->query($query);
			$total = $db->getResult();
			return $total;
		}
		
		function getPagination($total)
		{
			FSFactory::include_class('Pagination');
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
		}
        
        function save()
		{
		     
			global $db;
			$row = array();
			$title = FSInput::get('txt_name');		
			if(!$title)
				return false;
                
			$category_id = FSInput::get('sl_cat','int',0);
			if(!$category_id){
				Errors::_('Bạn phải chọn lĩnh vực');
				return;
			}
			
			$cat =  $this->get_record_by_id($category_id,'fs_enterprises_categories');
            $row['category_id'] = $category_id;
            $row['category_alias'] = $cat -> alias;
			$row['category_id_wrapper'] = $cat -> list_parents;
			$row['category_alias_wrapper'] = $cat -> alias_wrapper;
			$row['category_name'] = $cat -> name;
            
            $row['title'] = $title;
			$row['address'] =   FSInput::get("txt_address");
            $row['telephone']  = FSInput::get("txt_phone");
            $row['fax'] =   FSInput::get("txt_fax");
			$row['email'] =   FSInput::get("txt_email");
            $row['source_website'] =   FSInput::get("txt_website");
            
            $row['tax_code'] =   FSInput::get("txt_code");
            $row['contact_person'] =   FSInput::get("contact_name");
            $row['business_license'] =   FSInput::get("business_license");
            $row['ordering'] = FSInput::get('ordering');
            
            $date_from  =  FSInput::get("date_from");
            $row['start_time']  = date("Y-m-d",strtotime($date_from));
			//$row['address']   =  FSInput::get("address");
            
            // upload file 
            $cyear = date ( 'Y' );
            $cmonth = date('m');
            
    	    global $db;  
    		$path = PATH_BASE.'images'.DS.'upload_enterpries'.DS.$cyear.DS;
            require_once(PATH_BASE.'libraries'.DS.'upload.php');
            $upload = new  Upload();
            $upload->create_folder ( $path );
            $fsFile = FSFactory::getClass('FsFiles');
            if (!empty($_FILES['file_upload']['name'])) {
			     //upload
				$file_upload_name = $fsFile -> upload_file("file_upload", $path ,100000000, '_'.time());
				$row['file_upload'] = 'images/upload_enterpries/'.$cyear.'/'.$file_upload_name;
            }
            // end upload file 
            
            $path_img = PATH_BASE.'images'.DS.'enterprises'.DS.$cyear.DS.$cmonth.DS.'original'.DS;
            if (!empty($_FILES['image_file']['name'])) {
                    
			     //upload
				$file_name = $upload -> uploadImage('image_file', $path_img, 10000000, '_' . time () );

                    
                $arr_img_paths = array(array('small',148,148,'resized_not_crop'),array('resized',148,148,'resize_image'));
                
                if(is_string($file_name) and $file_name!='' and !empty($arr_img_paths)){
    	        	foreach ( $arr_img_paths as $item ) {
    					$path_resize = str_replace ( DS.'original'.DS, DS. $item [0].DS, $path_img );
    					$upload->create_folder ( $path_resize );
    					$method_resize = $item [3] ? $item [3] : 'resize_image';
    					$upload-> $method_resize ( $path_img . $file_name, $path_resize . $file_name, $item [1], $item [2] );
    				}
    	        }
                
				$row['image'] = 'images/enterprises/'.$cyear.'/'.$cmonth.'/'.'original/'.$file_name;
            }
            
            // end upload logo 
		    
			$row['published'] =  0;
            $time = date("Y-m-d H:i:s");
			$row['created_time']  = $time;
			$row['updated_time']  = $time;
			
			global $config;
			$id = $this -> _add($row, 'fs_enterprises');
            
			if($id){
				$this -> send_mail_user($row['title'],$row['address'],$row['telephone'],$row['fax'],$row['email'],$row['category_name'],
                                            $row['source_website'],$row['image'],$row['file_upload'],$row['start_time'],$row['tax_code'],
                                            $row['contact_person'],$row['business_license']);
			}
            
			return $id;	
		}
        
        function send_mail_user($title,$address,$telephone,$fax,$email,$category_name,$source_website,$image,$file_upload,$start_time,$tax_code,$contact_person,$business_license){
		    
//			include 'libraries/errors.php';
			// send Mail()
			$mailer = FSFactory::getClass('Email','mail');
			$global = new FsGlobal();
            
			$admin_name = $global -> getConfig('admin_name');
			$admin_email = $global -> getConfig('admin_email');
			$mail_register_subject = $global -> getConfig('mail_register_subject');
			$mail_register_body = $global -> getConfig('mail_register_body');
            
//			global $config;
			// config to user gmail
			
			$mailer -> isHTML(true);
//			$mailer -> IsSMTP();
			$mailer -> setSender(array($admin_email,$admin_name));
			$mailer -> AddAddress($email,$contact_person);
			$mailer -> AddBCC('tuananh@finalstyle.com','Phạm Tuấn Anh');
			$mailer -> setSubject($mail_register_subject);
			
			// body
			$body = $mail_register_body;
			$body = str_replace('{name}', $title, $body);
			$body = str_replace('{address}', $address, $body);
            $body = str_replace('{telephone}', $telephone, $body);
            $body = str_replace('{fax}', $fax, $body);
            $body = str_replace('{email}', $email, $body);
            $body = str_replace('{category_name}', $category_name, $body);
            $body = str_replace('{source_website}', $source_website, $body);
            $body = str_replace('{image}', $image, $body);
            $body = str_replace('{file_upload}', $file_upload, $body);
            $body = str_replace('{start_time}', $start_time, $body);
            $body = str_replace('{tax_code}', $tax_code, $body);
			$body = str_replace('{contact_person}', $contact_person, $body);
			$body = str_replace('{business_license}', $business_license, $body);
											
			$mailer -> setBody($body);
			
			if(!$mailer ->Send()){
				Errors::_('Error sending mail');
				return false;
                
			}
			return true;
			
			//en
		}
	}
	
?>