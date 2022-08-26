<?php
/*
 * Huy write
 */
	// controller
	
	class NewsControllersNews extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;
			
			$data = $model->getNews();
			
			if(!$data)
				setRedirect(URL_ROOT,'Không tồn tại bài viết này','Error');
			$ccode = FSInput::get('ccode');
				
			$category_id = $data -> category_id;
			
			$category = $model -> get_category_by_id($category_id);
			if(!$category)
				setRedirect(URL_ROOT,'Không tồn tại danh mục này','Error');
                
			$Itemid = 7;
			// relate
			$relate_news_list = $model->getRelateNewsList($category_id);
    
 
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Tin tức', 1 => FSRoute::_('index.php?module=news&view=home&Itemid=2') );
//			$breadcrumbs[] = array(0=>$category -> name, 1 => FSRoute::_('index.php?module=news&view=cat&id='.$data -> category_id.'&ccode='.$data -> category_alias));
//            $breadcrumbs[] = array(0=>$category -> name, 1 => '');
			$breadcrumbs[] = array(0=>$data->title, 1 => '');
			global $tmpl,$module_config;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> assign('tags', $data->tags);
//            $tmpl->assign ( 'description', $data->content );

            if(isset($data->seo_title)){
                $tmpl -> assign('title', html_entity_decode(@$data->seo_title));
            }else{
                $tmpl -> assign('title', html_entity_decode(@$data->title));
            }

            if(isset($data->seo_keyword)){
                $tmpl -> assign('keywords', @$data->seo_keyword);
            }else{
                $tmpl -> assign('keywords', @$data->summary);
            }

            if(isset($data->seo_description)){
                $tmpl -> assign('description', @$data->seo_description);
            }


			$tmpl->assign ( 'og_image', URL_ROOT.$data->image );
			
			// seo
			$tmpl -> set_data_seo($data);
			
			// call views			
		include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function mdisplay()
		{
			// call models
			$model = $this -> model;

			$data = $model->getNews();

			if(!$data)
				setRedirect(URL_ROOT,'Không tồn tại bài viết này','Error');
			$ccode = FSInput::get('ccode');

			$category_id = $data -> category_id;

			$category = $model -> get_category_by_id($category_id);
			if(!$category)
				setRedirect(URL_ROOT,'Không tồn tại danh mục này','Error');

			$Itemid = 7;
			// relate
			$relate_news_list = $model->getRelateNewsList($category_id);


			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Tin tức', 1 => FSRoute::_('index.php?module=news&view=home&Itemid=2') );
//			$breadcrumbs[] = array(0=>$category -> name, 1 => FSRoute::_('index.php?module=news&view=cat&id='.$data -> category_id.'&ccode='.$data -> category_alias));
//            $breadcrumbs[] = array(0=>$category -> name, 1 => '');
			$breadcrumbs[] = array(0=>$data->title, 1 => '');
			global $tmpl,$module_config;
            $tmpl -> assign('breadcrumbs', $breadcrumbs);  
            $tmpl -> assign('tags', $data->tags);
//            $tmpl->assign ( 'description', $data->content );

            if(isset($data->seo_title)){
                $tmpl -> assign('title', @$data->seo_title);
            }else{
                $tmpl -> assign('title', @$data->title);
            }

            if(isset($data->seo_keyword)){
                $tmpl -> assign('keywords', @$data->seo_keyword);
            }else{
                $tmpl -> assign('keywords', @$data->summary);
            }

            if(isset($data->seo_description)){
                $tmpl -> assign('description', @$data->seo_description);
            }


            $tmpl->assign ( 'og_image', URL_ROOT.$data->image );

            // seo
            $tmpl -> set_data_seo($data);

			// call views
		include 'modules/'.$this->module.'/views/'.$this->view.'/default_mobile.php';
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
			$model = $this -> model;
			$news_id = FSInput::get('id');
			$model -> update_hits($news_id);
		}
        function timeAgo($time_ago)
        {
            $time_ago = strtotime($time_ago);
            $cur_time   = time();
            $time_elapsed   = $cur_time - $time_ago;
            $seconds    = $time_elapsed ;
            $minutes    = round($time_elapsed / 60 );
            $hours      = round($time_elapsed / 3600);
            $days       = round($time_elapsed / 86400 );
            $weeks      = round($time_elapsed / 604800);
            $months     = round($time_elapsed / 2600640 );
            $years      = round($time_elapsed / 31207680 );
            // Seconds
            if($seconds <= 60){
                return "Just now";
            }
            //Minutes
            else if($minutes <=60){
                if($minutes==1){
                    return "1 phút trước";
                }
                else{
                    return "$minutes phút trước";
                }
            }
            //Hours
            else if($hours <=24){
                if($hours==1){
                    return "1 giờ trước";
                }else{
                    return "$hours giờ trước";
                }
            }
            //Days
            else if($days <= 7){
                if($days==1){
                    return "Hôm qua";
                }else{
                    return "$days ngày trước";
                }
            }
            //Weeks
            else if($weeks <= 4.3){
                if($weeks==1){
                    return "Một tuần trước";
                }else{
                    return "$weeks tuần trước";
                }
            }
            //Months
            else if($months <=12){
                if($months==1){
                    return "1 tháng trước";
                }else{
                    return "$months tháng trước";
                }
            }
            //Years
            else{
                if($years==1){
                    return "1 năm trước";
                }else{
                    return "$years năm trước";
                }
            }
        }
		
	}
	
?>