<?php
/*
 * Huy write
 */
	// controller
	
	class NewsControllersCat extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;
			$cat  = $model->getCategory();
			if(!$cat)
			{
				setRedirect(URL_ROOT,'Không tồn tại danh mục này','error');
			}
            $categories = $model->get_records(' published = 1 ','fs_news_categories','id,name,alias');
			global $tags_group;
//            $tags_group = $cat -> tags_group;
			$query_body = $model->set_query_body($cat->id);
			$list = $model->getNewsList($query_body);
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);
            $listHot = $model->getListHot();
			$breadcrumbs = array();
//            $breadcrumbs[] = array(0=>'Tin tức', 1 => FSRoute::_('index.php?module=news&view=home&Itemid=2'));
            if($cat->parent_id){
                $list_cat_parent = $model->get_record_by_id($cat->parent_id,'fs_news_categories','id,alias,name');
                $breadcrumbs[] = array(0=>$list_cat_parent->name, 1 => FSRoute::_('index.php?module=news&view=cat&ccode='.$list_cat_parent->alias.'&id='.$list_cat_parent->id.'&Itemid=3'));
            }
			$breadcrumbs[] = array(0=>$cat->name, 1 => FSRoute::_('index.php?module=news&view=cat&ccode='.$cat->alias.'&id='.$cat->id.'&Itemid=3'));
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// seo
			$tmpl -> set_data_seo($cat);
			
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
        
        function ajax_session(){
            $type = FSInput::get('type');
            if($type){
                $_SESSION['type'] = $type;
                echo 1;
            }else{
                echo 0;
            }
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