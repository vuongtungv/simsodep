<?php
/*
 * Huy write
 */

class AjaxPagination
{
	var $limit;
	var $current_page;
	var $total_records;
	var $total_pages;
	
	function __construct($limit,$current_page,$total_records,$total_pages){
		$this->limit = $limit;
        $this->current_page = $current_page;
		$this->total_records = $total_records;
		$this->total_pages = $total_pages;
        
	}
	/*
	 * maxpage is max page is show. But It is not last pageg.
	 * ex: 1,2,3,4..100.=> 4 is max page 
	 */
	function showPagination($maxpage = 5,$id)
	{
		$previous = "<";
		//$next = "Tiếp";
		$next = ">";
		$first_page = "&laquo;";
		$last_page = "&raquo;";

		//$current_page = FSInput::get('page');
		if(!$this->current_page || $this->current_page < 0)
			$this->current_page = 1;
		$html  = "";
		if($this->limit < $this->total_records)
		{
			$num_of_page = ceil( $this->total_records / $this -> limit );
			
			$start_page = $this->current_page - $maxpage;
			if($start_page <= 0)
				 $start_page = 1;
			
			$end_page = $this->current_page + $maxpage;
			
			if($end_page > $num_of_page) 
				$end_page = $num_of_page;
			
//			//WRITE prefix on screen
			$html  .= "<div class='pagination row-item mvl'>";
//			//$html .=  "<font class='title_pagination'>" . FSText :: _('') . "</font> ";
//			//Write Previous
			if(($this->current_page > 1) && ($num_of_page > 1)){
				$html .= "<a class='first-page' onclick='load_ajax_pagination(\"".$id."\")' title='first_page' data-page='". 0 ."'  >" . $first_page . "</a>";
				$html .= "<a class='pre-page' onclick='load_ajax_pagination(\"".$id."\")' title='pre_page' data-page='". ($this->current_page -1 ) ."'  >" . $previous . "</a>";
				if($start_page !=1)
					 $html .= "<a>..</a>";
			}
			for($i=$start_page; $i<=$end_page; $i++){
				if($i != $this->current_page){
					if($i == 1)
					 	$html .= "<a class='other-page' onclick='load_ajax_pagination(\"".$id."\")' title='Page " . $i . "' data-page='". $i ."'  ><span>" . $i . "</span></a>";
					 else
					 $html .= "<a class='other-page' onclick='load_ajax_pagination(\"".$id."\")' title='Page " . $i . "' data-page='". $i ."' ><span>" . $i . "</span></a>";
				}
				else{
////					 $html .= "<font title='Page " . $i . "' class='current'>" . $i . "</font>";
					 $html .= "<font title='Page " . $i . "' class='current'><span>" . $i . "</span></font>";
				}
			}
			//Write Next
			if(($this->current_page < $num_of_page) && ($num_of_page > 1)){
				if($end_page < $num_of_page) 
					$html .= "<a>..</a>";
				$html .= "<a class='next-page' title='Next page' onclick='load_ajax_pagination(\"".$id."\")' data-page='". ($this->current_page + 1) ."' >" . $next . "</a>";
				$html .= "<a class='last-page' onclick='load_ajax_pagination(\"".$id."\")' data-page='". $num_of_page ."' >" . $last_page . "</a>";
			}
			$html .= "</div>";
		}
		
		return $html;
	}
}
?>
<script>
	function load_ajax_pagination(id){
	    if(id){
    		//$.get($value,{}, function(html){ 
    			//$().html(html);
    		    $('html, body').animate({scrollTop:$(id).position().top}, 'slow');
    		//});
        }
	}
</script>
