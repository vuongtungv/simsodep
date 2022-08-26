<?php
    global $config,$tmpl; 
    $tmpl -> addStylesheet('default_news','blocks/mainmenu/assets/css');
    ?>
    <?php 
    $root_total = 0;
    $root_last = 0;
    $max_word = 5;
    for($i = 1 ; $i <= count($list); $i++)
    {
    	if(@$list[$i]->level == 1)
    	{
    		$root_total ++ ;
    		$root_last = $i;
    		
    	}
    }
?>

<ul class="menu-news-bottom">
		<?php
		$html = ""; 
		$i = 1;
		$num_child = array();
		$parant_close = 0;
		foreach ($list as $item) {?>
        <?php ?>
			<?php 
			$link = $item->link? FSRoute::_($item->link):'';
			$class = '';
			$level = $item -> level?$item -> level : 0; 
			$class .= ' level'.$level;
            $class_item = '';
			if($arr_activated[$item->id]) $class_item = ' activated ';
			// level = 1
			if($item->level==0)
			{
				if($i == 1)
					$class .= ' first-item';
				if($i == ($root_last-1) )
					$class .= ' last-item';
				if(($i != 1) && ($i != ($root_last-1)))
					$class .= ' menu-item';
			}
			
			// level > 1
			else
			{
				$parent = $item->parent_id;
				// total children
				$total_children_of_parent = isset($list[$parent])?$list[$parent]->children:0;
				if(isset($num_child[$parent]))
				{
					if($total_children_of_parent == $num_child[$parent])
					{
						$class .= " first-sitem ";	
					}
					else
					{
						$class .= " mid-sitem ";	
					}
				}
			}
		
		$html .= "<li class=' $class $class_item' >\n";
        if($item -> link)
        	$html .= "	<a href='$link'>";
       	else 
       		$html .= "	<a href='$link'>";
       		
        $name   = $item -> name;
        $html .= "		$name ";
        if($item -> link)
        	 $html .= "	</a>\n";
       	else 
       		$html .= "	</a>";
        	
		// browse child
		$num_child[$item->id] = $item->children ;
		if($item->children  > 0)
			 $html .= "		<ul>";
		
		if(@$num_child[$item->parent_id] == 1) 
		{
			// if item has children => close in children last, don't close this item 
			if($item->children > 0)
			{
				$parant_close ++;
			}
			else
			{
				$parant_close ++;
				for($i = 0 ; $i < $parant_close; $i++)
				{
					$html .= "	</li>";
					$html .= "</ul>";
				}
				$parant_close = 0;
				$num_child[$item->parent_id]--;
			}
		}
		if(( (@$num_child[$item->parent_id] == 0) && (@$item->parent_id >0 ) ) || !$item->children )
		{
			$html .= "</li>";
		}
		if(@$num_child[$item->parent_id] >= 1) 
			$num_child[$item->parent_id]--;
			  
		$i ++;
	}
	echo $html;
	?>
    <div class="clear"></div>
</ul>
<div class='created_email clearfix'>
	<h3 class='created_email_title'><?php echo FSText::_('Nhận email khóa học - tin tuyển sinh quan tâm'); ?></h3>
	<form id="discount_form" method="post" name="newletter_form" action="<?php echo FSRoute::_('index.php?module=discount&task=save'); ?>" onsubmit="javascript: return check_discount_form();" >
	    <input type="text" name="email" id="dc_email" value="" class="txt-input" placeholder="<?php echo FSText::_('Nhập email của bạn...') ?>" />
	    <input type="submit" value="<?php echo FSText::_('Tạo ngay')?>" class="button-sub button" id='bt-submit'/>
		<input type="hidden" name='return' value="<?php echo base64_encode($_SERVER['REQUEST_URI']);?>"  />
	</form>
</div>