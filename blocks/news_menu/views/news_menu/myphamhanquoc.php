<?php global $tmpl;
	$tmpl -> addStylesheet('news_menu','blocks/news_menu/assets/css');
?>
	<!--	CONTENT -->
        <ul class='news_menu  news_menu-<?php echo $style; ?>' >
	 	<h3><?php echo $title; ?></h3>
		<?php 
	 	$Itemid  = 5; // config
        $num_child = array();
        $parant_close = 0;
	 	$i = 0;
	 	$count_children = 0;
	 	$summner_children = 0;
	 	$id = 0;
	 	
	 	if($need_check)
	 		$id = FSInput::get('id',0,'int');
	 		
        $total = count($list);
		 	foreach ( $list as $item ) { 
                $class = '';
                if($need_check){
                	$class =  $item -> alias ==  $ccode ? 'activated':'';
                }
                $link = FSRoute::_('index.php?module=news&view=cat&id='.$item->id.'&ccode='.$item->alias.'&Itemid='.$Itemid);
                
                
		 		$class  .= ' level_'.$item -> level;
		 		if($i == 0)
		 			  $class .= ' first-item';
		 		if($i == ($total -1))
		 			  $class .= ' last-item';
		 		echo "<li class='item $class child_".$item->parent_id."' ><a href='".$link."' titlte='".$item->name."' ><span> ".$item -> name."</span></a>  ";
                  
        }
            ?>
         </ul>
	<!--	end CONTENT -->

 