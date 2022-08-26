<?php
/*
 * Huy write
 */
	// controller
	
	class EnterprisesControllersHome extends FSControllers
	{
		function display()
		{
			// call models
			$model = $this -> model;
			// cat list
			$list_cats = $model -> get_cats();

			global $tags_group;
			
			$query_body = $model->set_query_body();
			$list = $model->get_list($query_body);
		
	
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Doanh nghiệp Việt Nam', 1 => '');
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();
			
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
        
        /* 
		 * save 
		 */
		function save(){
			
			$model = $this -> model;
             if (empty($_FILES['image_file']['name'])) {
			    $link = FSRoute::_("index.php?module=enterprises&view=home&Itemid=13");
				$msg = " Bạn phải nhập logo doanh nghiệp ";
				return setRedirect($link,$msg);
            }
             if (empty($_FILES['file_upload']['name'])) {
			     //upload
				$link = FSRoute::_("index.php?module=enterprises&view=home&Itemid=13");
				$msg = " Bạn phải nhập giấy phép kinh doanh hoặc giấy phép hoạt động ";
				return setRedirect($link,$msg);
            }
            
            
			$id = $model->save();
			if($id)
			{
				$link = FSRoute::_("index.php?module=enterprises&view=home&Itemid=13");
				$msg = " Bạn đã đăng ký thành công,chúng tôi sẽ gửi một bản coppy vào email đăng ký của bạn, mọi thông tin đăng ký sẽ được kiểm chứng trước khi được hiển thị trên website. Cảm ơn quý khách! ";
				return setRedirect($link,$msg);
				
			}
			else{
				echo "<script type='text/javascript'>alert('Lỗi không gửi đăng ký.'); </script>";
				$this -> display();
				return;
			}
		}
        
		
	}
	
?>