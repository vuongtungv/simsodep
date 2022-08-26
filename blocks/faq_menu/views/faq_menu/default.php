<?php global $tmpl;
	$tmpl -> addStylesheet('default','blocks/faq_menu/assets/css');
//    $tmpl -> addScript('default_menu','blocks/faq/assets/js');
	$Itemid = FSInput::get('Itemid',16,'int');
    $ccode = FSInput::get('ccode');
?>

<div class="faq_menu">
    <h2 class="block_title"> <a title="Chuyên mục"><?php echo FSText::_('Chuyên mục'); ?></a></h2>
	<!--	CONTENT -->
        <ul class='nav-faq-menus row-item' >
    	 	<?php 
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
                    	$class =  $item -> alias ==  $ccode ? 'active':'';
                    }
                    if($Itemid == 15){
                        $link = FSRoute::_('index.php?module=faq&view=cat&id='.$item->id.'&ccode='.$item->alias);
                    }else{
                        $link = FSRoute::_('index.php?module=faq&view=cat_employer&id='.$item->id.'&ccode='.$item->alias);
                    }
                    
    		 		$class  .= ' level_'.$item -> level;
    		 		if($i == ($total -1))
    		 			  $class .= ' last-item';
                          
    		 		$icon = '';
                    $icon .= $item->icon? "<i style='background: url(".URL_ROOT.str_replace('/original/','original/',$item->icon).") no-repeat center center;'>&nbsp;</i>":"";
                        	
                    if($item -> level ){
    		 			$count_children ++;
    		 			if($count_children == $summner_children && $summner_children)
    		 				 $class .= ' last-item';
    
    		 			echo "<li class='has-sub item $class child_".$item->parent_id."' >
                                <div class='a2_".$item->level."' >
                                <a  href='".$link."'  > ".$item -> name."</a> 
                              </div> ";
                    } else {
                        $count_children = 0;
                        $summner_children = $item -> children;
                        	echo "<li class='has-sub item $class  ' id='pr_".$item -> id."' >";
                            echo "<div class='a2_".$item->level."'>
                                    <a  href='".$link."' > ".$item -> name."</a>
                                  </div>";
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
        </ul>
	<!--	end CONTENT --> 
</div>