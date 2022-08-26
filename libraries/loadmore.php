<?php
/*
 * Huy write
 */

class Loadmore
{
	var $limit;
	var $total;
	var $page;
	var $url;
	
	function __construct($limit,$total,$page,$url = ''){
		$this->limit = $limit;
		$this->total = $total;
		$this->page = $page;
			if($url)
				$this->url = $url;
			else
			{
				$url = $_SERVER['REQUEST_URI'];
				$this->url = $url;
			}
	}
	

	function showPagination()
	{
		$next = FSText :: _('Mời bạn xem thêm sản phẩm');
		
		
		$current_page = FSInput::get('page');
		if(!$current_page || $current_page < 0)
			$current_page = 1;
		$html  = "";
		if($this->limit < $this->total)
		{
			$num_of_page = ceil( $this->total / $this -> limit );
			
			//Write Next
			if(($current_page < $num_of_page) && ($num_of_page > 1)){
				$html  .= "<div class='pagination'>";
					$html .= '<a class="load_more"  id="load_more_button" title="Next page" href="javascript: void(0);" ><span>'. $next . '</span></a>';
				$html .= "</div>";
				$html .= '<div class="animation_image" style="display:none;"><img src="/images/ajax-loader.gif"> Loading...</div>';
				$html .= '<input type="hidden" value="'.$num_of_page.'" name="total_rows" id="total_rows" >';
			}
		}
		
		return $html;
	}
}