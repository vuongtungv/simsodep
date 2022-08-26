<?php global $tmpl;
    $tmpl -> addStylesheet('menu','blocks/mainmenu/assets/css');
    //$tmpl -> addScript('compactmenu','blocks/mainmenu/assets/js');
    
	$Itemid = FSInput::get('Itemid',1,'int');
    $lang = isset($_SESSION['lang'])?$_SESSION['lang']:'vi';
?>
<!-- <div class='mainmenu mainmenu-<?php echo $style; ?>'>-->
<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
 	<?php 
	    $Itemid  = FSInput::get('Itemid',1,'int'); 
	 	$total = count($list); 
	 	$i = 1;
	 	$count_children = 0;
	 	$summner_children = 0;
	 	echo "<li class='nav-item ".($Itemid == 1? 'active':'')."' ><a href='".URL_ROOT."' >Trang chủ</a>  </li>";
	// 	echo "<li class='sepa' ><span>&nbsp;</span></li>";
	 	foreach ( $list as $item ) {
		  $class =  $item -> id ==  $Itemid ? 'activated':'';
//		 		if($i == 0)
//		 			  $class .= ' first-item';
	 		if($i == ($total))
	 			  $class .= ' last-item';
	 			$count_children ++;
	 			if($count_children == $summner_children && $summner_children)
	 				 $class .= ' last-item';
	 			$link = FSRoute::_($item ->link);
	 			echo "<li class=' ".$class." item".$i."' ><a class='item-detail' href='".$link."' ><span> ".$item -> name."</span></a>  </li>";
	 			
	 		// sepa
	 		// if($i < $total - 1)
	 		// 	echo "<li class='sepa' ><span>&nbsp; | &nbsp;</span></li>";
	 		$i ++;
	 	}
	 	?>
 </ul>
<!--</div>-->

    