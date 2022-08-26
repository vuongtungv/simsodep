<?php
	/*
	 * Huy write
	 */
	// controller
class ContactControllersContact extends FSControllers {
	
		function display(){
		$model = $this->model;
			
			$submitbt = FSInput::get('submitbt');
			$msg = '';
			$address=$model->get_address_list();
			$parts=$model->get_parts_list();
            
			$array_breadcrumb[] = array(0=> array('name'=> FSText::_('Contact'), 'link'=>'','selected' => 0));
			// breadcrumbs
			$breadcrumbs = array ();
			$breadcrumbs [] = array (0 => FSText::_( 'Liên hệ' ), 1 => '' );
			global $tmpl;
			$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
			$tmpl -> set_seo_special();
			// call views
			include 'modules/'.$this->module.'/views/'.$this->view.'/'.'default.php';
		}
		
		/* 
		 * save contact
		 */
		function save(){
			
			$model = $this->model;
			$id = $model->save();
            $sender_name = FSInput::get('contact_name');
			$sender_email = FSInput::get('contact_email');
			$sender_parts = FSInput::get('contact_parts');
			$parts = $model->get_record(' email = "'.$sender_parts.'"','fs_contact_parts');
			$sender_parts_name = $parts->name;
            $return = base64_decode(FSInput::get('return'));
			if($id)
			{
			    if($return){
			         $link = $return;
			    }else{
			         $link = FSRoute::_("index.php?module=contact&Itemid=14");
			    }
                 
				$msg = FSText::_("Cám ơn bạn đã liên lạc với chúng tôi.");
				if(!$this -> send_mail($sender_name,$sender_email,$sender_parts_name)){
					$msg = FSText::_("Cám ơn bạn đã liên lạc với chúng tôi.");
				}
				setRedirect($link,$msg);
				return;
			}
			else{
				echo "<script type='text/javascript'>alert('Xin lỗi bạn không gửi được thông điệp liên hệ.'); </script>";
				$this -> display();
				return;
			}
		}
		
	// function sendmail
		function send_mail($sender_name='',$sender_email='',$sender_parts_name='')
		{
				include 'libraries/errors.php';
				// send Mail()
				$mailer = FSFactory::getClass('Email','mail');
				$global = new FsGlobal();
				
				// sender
				//$sender_name = FSInput::get('contact_name');
//				$sender_email = FSInput::get('contact_email');
				$sender_title = FSInput::get('contact_title');

				// Recipient
						
				$to = $global-> getConfig('admin_email');
				$site_name = $global-> getConfig('site_name');

				global $config;
				$subject = ' - Liên hệ';

				$contact_title = FSInput::get('contact_title');
				$contact_fullname = FSInput::get('contact_name');
                $address = FSInput::get('contact_address');
                $contact_telephone = FSInput::get('contact_phone');
                $contact_group = FSInput::get('contact_group');
				$contact_email = FSInput::get('contact_email');
				$contact_parts_email = FSInput::get('contact_parts');

				$contact_subject = FSInput::get('contact_subject');
				
				$fax = FSInput::get('contact_fax');
				$content = htmlspecialchars_decode(FSInput::get('message'));
				
				$mailer -> isHTML(true);
				$mailer -> setSender(array($sender_email,$sender_name));
				$mailer -> AddAddress($to,'admin');
				
				$arr_mail = explode(',',$contact_parts_email);
				if($arr_mail && count($arr_mail)){
					$i = 0;
					foreach($arr_mail as $item){
						$mailer -> AddCC($item, $sender_name);;
						$i ++;
					}
				}

				$mailer -> setSubject(''.html_entity_decode($site_name).' '.$subject.' từ '.$contact_fullname);
				// body
				
				$body = '';
				$body .= '<table border="0" cellpadding="1" cellspacing="1"><tbody>';
				$body .= '<tr><td style="width:120px;"><strong>Tiêu đề:</strong></td><td>'.$contact_title.'</td></tr>';
				$body .= '<tr><td style="width:120px;"><strong>Họ và tên:</strong></td><td>'.$contact_fullname.'</td></tr>';
				$body .= '<tr><td style="width:120px;"><strong>Nhóm đối tượng:</strong></td><td>'.$contact_group.'</td></tr>';
				$body .= '<tr><td style="width:120px;"><strong>Email:</strong></td><td>'.$contact_email.'</td></tr>';
				$body .= '<tr><td style="width:120px;"><strong>Địa chỉ:</strong></td><td>'.$address.'</td></tr>';
				$body .= '<tr><td style="width:120px;"><strong>Bộ phận liên hệ:</strong></td><td>'.$sender_parts_name.'</td></tr>';
				$body .= '<tr><td style="width:120px;"><strong>Nội dung:</strong></td><td>'.$content.'</td></tr>';
				$body .= '</tbody></table>';
//				$body .= $message;
				$mailer -> setBody($body);
				if(!$mailer ->Send())
					return false;
				return true;
		}
		
		/*
		 * function check Captcha
		 */
		function check_captcha(){
			$captcha = FSInput::get('txtCaptcha');
			
			if ( $captcha == $_SESSION["security_code"]){
				return true;
			} else {
			}
			return false;
		}
	//	function map(){
//			$model = new ContactModelsContact();
//			$google_map = $model -> get_address_current();
//			$str_des = '';
//			$str_des .= '<center>';
//            $str_des .= '    	<h3>'.@$google_map -> name. '</h3>';
//            $str_des .= '    	<p><strong>Add: </strong>'.@$google_map -> address. '</p>';
//            $str_des .= '    	<p><strong>Telephone: </strong>'.@$google_map -> phone. '</p>';
//            $str_des .= '    	</center>';
//            include 'modules/'.$this->module.'/views/'.$this->view.'/'.'map.php';
//		}
        function map(){
            $model = new ContactModelsContact();
            $list = $model -> get_address_current();   
            $data = array(
                'error' => true,
                'message' => '',
                'html' => ''
            );
            //<p><strong>Địa chỉ: </strong>'.$list -> address. '</p>          
            $data['html'] .= '  
                                <h3>'.$list -> name. '</h3>
  
                                <p><strong>Điện thoại: </strong>'.$list -> phone. '</p>
                                <p><strong>Email: </strong>'.$list -> email. '</p>
                            ';
            
            $data['error'] = false;
            echo json_encode($data);
        }
	}
	
?>