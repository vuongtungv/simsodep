<?php
    global $tmpl,$config;  
    $tmpl -> addStylesheet('menu','blocks/mainmenu/assets/css');
?>
<div class="menu row-item">
    <div class="row">
 	<?php 
	 	$Itemid  = FSInput::get('Itemid',1,'int'); 
	 	$total = count($list); 
	 	$i = 0;
	 	$count_children = 0;
	 	$summner_children = 0;
        $link = '';
        $image = '';
	 	//echo "<li class='item first_item ".($Itemid == 1? 'activated':'')."' ><a href='".URL_ROOT."' ><span> Trang chủ</span></a>  </li>";
	 	foreach ( $list as $item ) { 
	 		$class =  $item -> id ==  $Itemid ? 'active':'';
	 		if($i == ($total -1))
	 			  $class .= ' last-item';
 			$count_children ++;
 			if($count_children == $summner_children && $summner_children)
 				 $class .= ' last-item';
            if($item ->link){
                $link = $item->is_link == 1? $item ->link:FSRoute::_($item ->link.'&Itemid='.$item -> id);
            }
            
            if($item->image){
                $image = URL_ROOT.$item->image;
                $image = '<img class="img-responsive" src="'.$image.'" alt="'.$item -> name.'" />';
            }
                 
 			echo "<div class='col-xs-6' >
                    <a class='item $class ' href='".$link."' target='$item->target'  >
                        $image
                        <div class='row-item'>
                            <h2> ".$item -> name."</h2>
                            <summary>".getWord(20,html_entity_decode($item -> summary))."</summary>
                            <span>".FSText::_('Xem thêm')."<i class='fa fa-long-arrow-right'></i></span>
                        </div>
                      </a>
                 </div>     
                ";
	 		// sepa
	 		//if($i < $total - 1)
	 			//echo "<li class='sepa' ><span>&nbsp;</span></li>";
	 		$i ++;
	 	}
	 	?>
    </div>
</div>