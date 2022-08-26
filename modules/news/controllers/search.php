<?php
/*
 * Huy write
 */
	// controller
	
	class NewsControllersSearch
	{
		var $module;
		var $view;
		function __construct()
		{
			
			$this->module  = 'news';
			$this->view  = 'search';
			include 'modules/'.$this->module.'/models/'.$this->view.'.php';
		}
		function display()
		{
			// call models
			$model = new NewsModelsSearch();
			$query_body = $model -> set_query_body();
			$list = $model -> get_list($query_body);
			$total = $model -> getTotal($query_body);
			$total_list = count($list);
			$pagination = $model->getPagination($total);
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=> FSText::_('Tìm kiếm'), 1 => '');
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();

			// create breadcrumb
//			$array_breadcrumb = $model -> get_breadcrumb();
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function mdisplay()
		{
			// call models
			$model = new NewsModelsSearch();
			$query_body = $model -> set_query_body();
			$list = $model -> get_list($query_body);
			$total = $model -> getTotal($query_body);
			$total_list = count($list);
			$pagination = $model->getPagination($total);

			$breadcrumbs = array();
			$breadcrumbs[] = array(0=> FSText::_('Tìm kiếm'), 1 => '');
			global $tmpl;
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();

			// create breadcrumb
//			$array_breadcrumb = $model -> get_breadcrumb();
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