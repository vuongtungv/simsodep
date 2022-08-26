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
			
			$model = new ContactModelsContact();
			$id = $model->save();
			if($id)
			{
				$link = FSRoute::_("index.php?module=contact&Itemid=14");
				$msg = "Cám ơn bạn đã liên lạc với chúng tôi.";
				if(!$this -> send_mail()){
					$msg = FSText::_(" Cám ơn bạn đã liên lạc với chúng tôi. ");
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
		function send_mail()
		{
				include 'libraries/errors.php';
				// send Mail()
				//$mailer = FSInput::get('contact_email');
				$mailer = FSFactory::getClass('Email','mail');
				$global = new FsGlobal();
				
				// sender
				$sender_name = FSInput::get('contact_name');
				$sender_email = FSInput::get('contact_email');
				$sender_title = FSInput::get('contact_title');

				// Recipient
						
				$to = $global-> getConfig('admin_email');
				$site_name = $global-> getConfig('site_name');
				//$to= FSInput::get('to');
				//$sender_email = FSInput::get('email');
				global $config;
				$subject = ' -  Contact from customer';

				$contact_fullname = FSInput::get('contact_name');
                $address = FSInput::get('contact_address');
                $contact_telephone = FSInput::get('contact_phone');
				$contact_email = FSInput::get('contact_email');
				$contact_title = FSInput::get('contact_title');
                //$contact_title = FSInput::get('contact_title');
				$contact_subject = FSInput::get('contact_subject');
				
				$fax = FSInput::get('contact_fax');
				$content = htmlspecialchars_decode(FSInput::get('message'));
				
				$mailer -> isHTML(true);
				$mailer -> setSender(array($sender_email,$sender_name));
				$mailer -> AddAddress($to,'admin');
				
				$mailer -> AddCC('tuananh@finalstyle.com','Phạm tuấn Anh');
      //          $mailer -> AddCC('aanhpt@gmail.com','Phạm tuấn Anh');
				$mailer -> setSubject(''.html_entity_decode($site_name).' '.$subject);
				// body
				
				$body = '';
				$body .= '<p align="left"><strong>Full name: </strong> '.$contact_fullname.'</p>';
				$body .= '<p align="left"><strong>Email : </strong> '.$contact_email.'</p>';
//				$body .= '<p align="left"><strong>Điện thoại : </strong> '.$fax.'</p>';
				$body .= '<p align="left"><strong>Phone : </strong> '.$contact_telephone.'</p>';
				$body .= '<p align="left"><strong>Title : </strong> '.$contact_title.'</p>';
				//$body .= '<p align="left"><strong>Địa chỉ : </strong> '.$address.'</p>';
				$body .= '<p align="left"><strong>Content : </strong> '.$content.'</p>';
				
//				$body .= '<p align="left"><strong>Started work time: </strong> '.$date_work .' '.$hour_work.':'.$minute_work.'</p>';
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
                      
            $data['html'] .= '  
                                    <h3>'.$list -> name. '</h3>
                                    <p><strong>Địa chỉ: </strong>'.$list -> address. '</p>
                                    <p><strong>Điện thoại: </strong>'.$list -> phone. '</p>
                                    <p><strong>Fax: </strong>'.$list -> fax. '</p>
                                    <p><strong>Email: </strong>'.$list -> email. '</p>
                                    <p><strong>Website: </strong>'.$list -> website. '</p>
                               
                            ';
            
            $data['error'] = false;
            echo json_encode($data);
        }
	}
	
?>