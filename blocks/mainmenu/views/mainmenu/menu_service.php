<?php
    global $tmpl,$config;  
    $tmpl -> addStylesheet('menu','blocks/mainmenu/assets/css');
    $url_current = $_SERVER['REQUEST_URI'];
    $url_current = substr(URL_ROOT, 0, strlen(URL_ROOT)-1).$url_current;
?>

<ul class="menu-service">
	 	<?php 
		 	$Itemid  = FSInput::get('Itemid',1,'int'); 
		 	$total = count($list); 
		 	$i = 0;
		 	$count_children = 0;
		 	$summner_children = 0;
		 //	echo "<li class='item first_item ".($Itemid == 1? 'activated':'')."' >
//                    <a class='icon-home' href='".URL_ROOT."' ></a>    
//                  </li>";
		 	foreach ( $list as $item ) { 
		 		//$class =  $item -> id ==  $Itemid ? 'active':'';
                $link = $item ->link? FSRoute::_($item ->link):'';
                $class = '';
                if($link == $url_current){
                    $class = 'active';
                }
//		 		if($i == 0)
//		 			  $class .= ' first-item';
		 		if($i == ($total -1))
		 			  $class .= ' last-item';
		 		
	 			$count_children ++;
                
	 			if($count_children == $summner_children && $summner_children)
	 				 $class .= ' last-item';
                                     
	 			echo "<li class='item  ' >
                        <a class='$class' href='".$link."' >".$item -> name."</a>
                     </li>";	
		 		// sepa
		 		//if($i < $total - 1)
		 			//echo "<li class='sepa' ><span>&nbsp;</span></li>";
		 		$i ++;
		 	}
		 	?>
</ul><!-- nav -->
