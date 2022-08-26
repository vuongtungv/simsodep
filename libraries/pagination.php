<?php
/*
 * Huy write
 */

class Pagination
{
	var $limit;
	var $total;
	var $page;
	var $url;
	
	function __construct($limit,$total,$page,$url = ''){
		$this->limit = $limit;
		$this->total = $total;
		$this->page = $page;
//		if(!IS_REWRITE){
			if($url)
				// $this->url = clean($url);
				$this->url = $url;
			else
			{
				$url = $_SERVER['REQUEST_URI'];
//				$url =  trim(preg_replace('/&page=[0-9]+/i', '', $url));
				$this->url = clean($url);
				$this->url = $url;
			}
//		} else {
//			if(!$url)
//				$url = $_SERVER['REQUEST_URI'];
////			if(strpos($url,'-page') !== false)
//			$search = preg_match('#-page([0-9]*)#is',$url,$main);
//			if()
//			
//			$url = Route::deURL($url);
//			$url =  trim(preg_replace('/&page=[0-9]+/i', '', $url));
//			$this->url = $url;
//		}
	}
	
	function create_link_with_page($url,$page){
        if(!IS_REWRITE){
            $url =  trim(preg_replace('/&page=[0-9]+/i', '', $url));

            if(!$page || $page == 1){
                return $url;
            } else {
                return $url.'&page='.$page;
            }
        } else {
            if(!$page || $page == 1){
                $url = trim(preg_replace('/-trang-[0-9]+/', '', $url));
                return $url;
			} else {
				$search = preg_match('#-trang-([0-9]+)#is',$url,$main);
				if($search){
					$url = preg_replace('/-trang-[0-9]+/i','-trang-'.$page, $url);
				} else {
					$url = preg_replace('/.html/i','-trang-'.$page.'.html', $url);
				}
				return $url;
			}
		}
	}
	
	function create_link_with_page_ajax($url,$page){
		
		$url =  trim(preg_replace('/&page=[0-9]+/i', '', $url));
		
		if(!$page || $page == 1){
			return $url;
		} else {
			return $url.'&page='.$page;
		}
	}
	
	/*
	 * maxpage is max page is show. But It is not last pageg.
	 * ex: 1,2,3,4..100.=> 4 is max page 
	 */
	function showPagination($maxpage = 5)
	{
		$previous = '<i class="fa fa-angle-left" aria-hidden="true"></i>';
		//$next = "Tiếp";
//		$next = '<i class="fa fa-angle-right" aria-hidden="true"></i>';
		$next = '<img style="margin-top: 2px;" src="/templates/default/images/img_svg/sim_theo_nha_mang/pagination_next.svg"/>';
		$first_page = '<i class="fa fa-angle-left"></i><i class="fa fa-angle-left"></i> Trang đầu';
//		$last_page = 'Trang cuối <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i>';
		$last_page = 'Trang cuối  <img style="margin-top: -3px;" src="/templates/default/images/img_svg/sim_theo_nha_mang/pagination_next.svg"/><img style="margin-top: -3px;" src="/templates/default/images/img_svg/sim_theo_nha_mang/pagination_next.svg"/>';

		
		
		$current_page = FSInput::get('page');
		if(!$current_page || $current_page < 0)
			$current_page = 1;
		$html  = "";
        
        $url = $this->url;
        // $url = clean($url);
        
		if($this->limit < $this->total)
		{
			$num_of_page = ceil( $this->total / $this -> limit );
			
			$start_page = $current_page - $maxpage;
			if($start_page <= 0)
				 $start_page = 1;
			
			$end_page = $current_page + $maxpage;
			
			if($end_page > $num_of_page) 
				$end_page = $num_of_page;
			
			//WRITE prefix on screen
			$html  .= "<nav aria-label='Page navigation example' class='pagination-bottom'><ul class='pagination justify-content-center'>";
			//$html .=  "<font class='title_pagination'>" . FSText :: _('') . "</font> ";
			//Write Previous
			if(($current_page > 1) && ($num_of_page > 1)){
				$html .= "<li class='page-item'><a class='page-link' title='first_page' href='" . Pagination::create_link_with_page($url,1) . "' title='".FSText::_('First page')."' >" . $first_page . "</a></li>";
				$html .= "<li class='page-item'><a class='page-link' title='pre_page' href='" . Pagination::create_link_with_page($url,$current_page-1). "' title='".FSText::_('Previous')."' >" . $previous . "</a></li>";
				if($start_page !=1)
					 $html .= "<b>..</b>";
			}
			for($i=$start_page; $i<=$end_page; $i++){
				if($i != $current_page){
					if($i == 1)
					 	$html .= "<li class='page-item'><a class='page-link' title='Page " . $i . "' href='" . Pagination::create_link_with_page($url,0) . "' ><span>" . $i . "</span></a></li>";
					 else
					 $html .= "<li class='page-item'><a class='page-link' title='Page " . $i . "' href='" .Pagination::create_link_with_page($url,$i) . "' ><span>" . $i . "</span></a></li>";
				}
				else{
//					 $html .= "<font title='Page " . $i . "' class='current'>" . $i . "</font>";
					 $html .= "<li class='page-item active'><a  class='page-link' title='Page " . $i . "' class='current'><span>" . $i . "</span></a></li>";
				}
			}
			//Write Next
			if(($current_page < $num_of_page) && ($num_of_page > 1)){
				if($end_page < $num_of_page)
					$html .= "<b>..</b>";
				$html .= "<li class='page-item'><a class='page-link' title='Next page' href='" . Pagination::create_link_with_page($url,$current_page+1) . "' >" . $next . "</a></li>";
				$html .= "<li class='page-item'><a class='page-link' title='Last page' href='" . Pagination::create_link_with_page($url,$num_of_page). "' >" . $last_page . "</a></li>";
			}
			$html .= "</ul></nav>";
		}
		
		return $html;
	}

	function mshowPagination($maxpage = 5)
	{
		$previous = '<i class="fa fa-angle-left" aria-hidden="true"></i>';
		//$next = "Tiếp";
		$next = '<i class="fa fa-angle-right" aria-hidden="true"></i>';
		$first_page = '<i class="fa fa-angle-left"></i><i class="fa fa-angle-left"></i>';
		$last_page = '<i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i>';

		
		
		$current_page = FSInput::get('page');
		if(!$current_page || $current_page < 0)
			$current_page = 1;
		$html  = "";
        
        $url = $this->url;
        // $url = clean($url);
        
		if($this->limit < $this->total)
		{
			$num_of_page = ceil( $this->total / $this -> limit );
			
			$start_page = $current_page - $maxpage;
			if($start_page <= 0)
				 $start_page = 1;
			
			$end_page = $current_page + $maxpage;
			
			if($end_page > $num_of_page) 
				$end_page = $num_of_page;
			
			//WRITE prefix on screen
			$html  .= "<nav aria-label='Page navigation example' class='pagination-bottom'><ul class='pagination justify-content-center'>";
			//$html .=  "<font class='title_pagination'>" . FSText :: _('') . "</font> ";
			//Write Previous
			if(($current_page > 1) && ($num_of_page > 1)){
				$html .= "<li class='page-item'><a class='page-link' title='first_page' href='" . Pagination::create_link_with_page($url,1) . "' title='".FSText::_('First page')."' >" . $first_page . "</a></li>";
				$html .= "<li class='page-item'><a class='page-link' title='pre_page' href='" . Pagination::create_link_with_page($url,$current_page-1). "' title='".FSText::_('Previous')."' >" . $previous . "</a></li>";
				if($start_page !=1)
					 $html .= "<b>..</b>";
			}
			for($i=$start_page; $i<=$end_page; $i++){
				if($i != $current_page){
					if($i == 1)
					 	$html .= "<li class='page-item'><a class='page-link' title='Page " . $i . "' href='" . Pagination::create_link_with_page($url,0) . "' ><span>" . $i . "</span></a></li>";
					 else
					 $html .= "<li class='page-item'><a class='page-link' title='Page " . $i . "' href='" .Pagination::create_link_with_page($url,$i) . "' ><span>" . $i . "</span></a></li>";
				}
				else{
//					 $html .= "<font title='Page " . $i . "' class='current'>" . $i . "</font>";
					 $html .= "<li class='page-item active'><a  class='page-link' title='Page " . $i . "' class='current'><span>" . $i . "</span></a></li>";
				}
			}
			//Write Next
			if(($current_page < $num_of_page) && ($num_of_page > 1)){
				if($end_page < $num_of_page)
					$html .= "<b>..</b>";
				$html .= "<li class='page-item'><a class='page-link' title='Next page' href='" . Pagination::create_link_with_page($url,$current_page+1) . "' >" . $next . "</a></li>";
				$html .= "<li class='page-item'><a class='page-link' title='Last page' href='" . Pagination::create_link_with_page($url,$num_of_page). "' >" . $last_page . "</a></li>";
			}
			$html .= "</ul></nav>";
		}
		
		return $html;
	}

    function genareate_limit($url = ''){        	
		if(!$url)
		  $url = $this->url;
          
        $url = clean($url);
		if(!IS_REWRITE){
			$url =  trim(preg_replace('/&page=[0-9]+/i', '', $url));
            $url =  trim(preg_replace('/&limit=[0-9]+/i', '', $url));
			
		} else {
			$url = trim(preg_replace('/-page[0-9]+/i', '', $url));
			 $url =  trim(preg_replace('/&limit=[0-9]+/i', '', $url));
             $url =  trim(preg_replace('/\?limit=[0-9]+/i', '', $url));
		}
        $limit = FSInput::get('limit', 12, 'int');
        
           	$html = '';
            
    	   $html .= ' <select onchange="location = this.value;">';
           $arrNumberOfPage = range(12, 48, 4);
           foreach($arrNumberOfPage as $val){ 
                $checked = $limit == $val?'selected="selected"':'';
                 $html .= ' <option '.$checked.' value="'.$url.'?limit='.$val.'" >'.$val.'</option>';
            } 
            $html .= ' </select>';
        return $html;
    }
}