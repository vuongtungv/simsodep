<?php
/*
 * Huy write
 */
	// controller
	
	class ProductsControllersProduct extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			
			// call models
			$model = $this -> model;
			
			$data = $model->getproducts();
			
			if(!$data)
				die('Kh&#244;ng t&#7891;n t&#7841;i b&#224;i vi&#7871;t n&#224;y');
			$ccode = FSInput::get('ccode');
				
			$category_id = $data -> category_id;
			
			$category = $model -> get_category_by_id($category_id);
			if(!$category)
				die('Kh&#244;ng th&#7845;y Category');
			$Itemid = 7;
//			if($ccode){
//				if(trim($ccode) != trim($category-> alias )){
//					$link_products = FSRoute::_("index.php?module=products&view=products&code=".trim($data->alias)."&ccode=".trim($category-> alias)."&Itemid=$Itemid");
//					setRedirect($link_products);
//				}
//			}
			
			// relate
			$relate_products_list = $model->getRelateproductsList($category_id);
            $products_related = $model->get_products_related($data->products_related,$data->id);
			// tin liên quan theo tags
			$relate_products_list_by_tags = $model->get_relate_by_tags($data -> tags,$data -> id,$category_id);
			$total_content_relate  = count($relate_products_list);
			$str_ids = '';
			for($i = 0; $i < $total_content_relate; $i ++){
				$item = $relate_products_list[$i];
				if($i > 0) $str_ids .= ',';
				$str_ids .= $item -> category_id;
			}
			$content_category_alias = $model->get_content_category_ids($str_ids);
			
			// chèn keyword  vào trong nội dung
				
			$description = $this->insert_link_keyword($data->content);	
				
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Sản phẩm Việt Nam', 1 => 'javascript: void(0)');
			$breadcrumbs[] = array(0=>$category -> name, 1 => FSRoute::_('index.php?module=products&view=cat&id='.$data -> category_id.'&ccode='.$data -> category_alias));	
			$breadcrumbs[] = array(0=>$data->title, 1 => '');	
			global $tmpl,$module_config;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> assign('title', $data->title);
			$tmpl -> assign('tags', $data->tags);
			
			// seo
			$tmpl -> set_data_seo($data);
			
			// call views			
		include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
		
		
		/* Save comment */
		function save_comment(){
			$return = FSInput::get('return');
			$url = base64_decode($return);
			
			if(!$this -> check_captcha()){
				$msg = 'Mã hiển thị không đúng';
				setRedirect($url,$msg,'error');
			}
			$model = $this -> model;
			if(!$model -> save_comment()){
				$msg =  'Chưa lưu thành công comment!';
				setRedirect($url,$msg,'error');
			} else {
				setRedirect($url,'Cảm ơn bạn đã gửi comment');
			}
		}
		/* Save comment reply*/
		function save_reply(){
			$return = FSInput::get('return');
			$url = base64_decode($return);
			
			$model = $this -> model;
			if(!$model -> save_comment()){
				$msg =  'Chưa lưu thành công comment!';
				setRedirect($url,$msg,'error');
			} else {
				setRedirect($url,'Cảm ơn bạn đã gửi comment');
			}
		}
		
		// check captcha
		function check_captcha(){
			$captcha = FSInput::get('txtCaptcha');
			
			if ( $captcha == $_SESSION["security_code"]){
				return true;
			} else {
			}
			return false;
		}
		
		function rating(){
			$model = $this -> model;
			if(!$model -> save_rating()){
				echo '0';
				return;
			} else {
				echo '1';
				return;
			}
		}
		function count_views(){
			$model = $this -> model;
			if(!$model -> count_views()){
				echo 'hello';
				return;
			} else {
				echo '1';
				return;
			}
		}
		// update hits
		function update_hits(){
			$model = new ProductsModelsProduct();
			$products_id = FSInput::get('id');
			$model -> update_hits($products_id);
		}
		
	}
	
?>