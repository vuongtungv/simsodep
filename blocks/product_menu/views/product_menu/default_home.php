<?php global $tmpl;
	$tmpl -> addStylesheet('arrow-count-down','blocks/product_menu/assets/css');
	$Itemid = FSInput::get('Itemid',1,'int');
    $ccode = FSInput::get('ccode');
?>

<div class="product_menu_home <?php echo ($Itemid==1)?'selected':''?> col-xs-12 col-sm-12 ">
	<!--	CONTENT -->
        <div class="row-item">
            <ul class=' product-menu-<?php echo $style; ?> row-item' >
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
                    $link = FSRoute::_('index.php?module=products&view=cat&id='.$item->id.'&ccode='.$item->alias);
                    
    		 		$class  .= ' level_'.$item -> level;
    		 		if($i == ($total -1))
    		 			  $class .= ' last-item';
    		 		
                    if($item -> level ){
    		 			$count_children ++;
    		 			if($count_children == $summner_children && $summner_children)
    		 				 $class .= ' last-item';
    
    		 			echo "<li class='item $class child_".$item->parent_id."' ><a class='a2_".$item->level."' href='".$link."'  ><span> ".$item -> name."</span></a>  ";
                    } else {
                        $count_children = 0;
                        $summner_children = $item -> children;
                        	echo "<li class='item $class  ' id='pr_".$item -> id."' >";
                            echo "<a class='a2_".$item->level."' href='".$link."' ><span> ".$item -> name."</span></a>";
                    } 
                ?>
              <?php 
                $num_child[$item->id] = $item->children ;
                if($item->children  > 0){
                	if($item -> level)
                    	echo "<ul id='c_".$item->id."' class=' sub-menu wrapper_children wrapper_children_level".$item -> level."' style='display:none' >";
                    else 
                    	echo "<ul id='c_".$item->id."' class=' sub-menu wrapper_children_level".$item -> level."' >";
                }
    
                if(@$num_child[$item->parent_id] == 1) 
                {
                    if($item->children > 0)
                    {
                        $parant_close ++;
                    }
                    else
                    {
                        $parant_close ++;
                        for($i = 0 ; $i < $parant_close; $i++)
                        {
                            echo "</ul>";
                        }
                        $parant_close = 0;
                        $num_child[$item->parent_id]--;
                    }
                    
                    if(( (@$num_child[$item->parent_id] == 0) && (@$item->parent_id >0 ) ) || !$item->children )
                    {
                      echo "</li>";
                    }
                    if(@$num_child[$item->parent_id] >= 1) 
                        $num_child[$item->parent_id]--;
                }   
                    
                
                if(isset($num_child[$item->parent_id] ) && ($num_child[$item->parent_id] == 1) )
                    echo "</ul>";
                if(isset($num_child[$item->parent_id]) && ($num_child[$item->parent_id] >= 1) )
                    $num_child[$item->parent_id]--;
                      
            }
                ?>
        </div>    
	<!--	end CONTENT --> 
</div> 