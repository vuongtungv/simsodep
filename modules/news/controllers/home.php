<?php
/*
 * Huy write
 */
	// controller
	
	class NewsControllersHome extends FSControllers
	{
		function display()
		{			
			// call models
			$model = $this -> model;

			global $tags_group;
			
			$categories = $model->get_records(' published = 1 ','fs_news_categories','id,name,alias');

			$query_body = $model->set_query_body();
			$list = $model->get_list($query_body);
		    $listHot = $model->getListHot();
			$total = $model->getTotal($query_body);


			$pagination = $model->getPagination($total);

			$breadcrumbs = array();
			$breadcrumbs[] = array(0=> FSText::_('Tin tức'), 1 => FSRoute::_('index.php?module=news&view=home&Itemid=2'));
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();
			
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function mdisplay()
		{
			// call models
			$model = $this -> model;

			global $tags_group;

			$categories = $model->get_records(' published = 1 ','fs_news_categories','id,name,alias');

			$query_body = $model->set_query_body();
			$list = $model->get_list($query_body);
		    $listHot = $model->getListHot();
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);

			$breadcrumbs = array();
			$breadcrumbs[] = array(0=> FSText::_('Tin tức'), 1 => FSRoute::_('index.php?module=news&view=home&Itemid=2'));
			global $tmpl;
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();

			// call views
			include 'modules/'.$this->module.'/views/'.$this->view.'/default_mobile.php';
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