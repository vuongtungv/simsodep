<?php
global $tmpl;
$tmpl->addStylesheet ( 'click', 'blocks/product_menu/assets/css' );
//$tmpl->addScript ( 'product_menu_click', 'blocks/product_menu/assets/js' );
$Itemid = FSInput::get('Itemid',1,'int');
$num_child = array ();
$parant_close = 0;
$i = 0;$j = 0;
$count_children = 0;
$summner_children = 0;

$html_activate = '';
$html_normal = '';
$html_activate_other = '';
$html_normal_other = '';
$total = count ( $list );
$noicon = URL_ROOT.'images/icon_sp_khac.png';
foreach ( $list as $item ) {
	$class = '';
	$class .= ' level_' . $item->level;
	if ($i == 0)
		$class .= ' first-item';
	if ($i == ($total - 1))
		$class .= ' last-item';
	
	$group_activated = 0;
	$link = FSRoute::_ ( 'index.php?module=products&view=cat&cid=' . $item->id . '&ccode=' . $item->alias . '&Itemid=' . $Itemid );
	if (in_array ( $item->id, $group_has_parent_activated ) || in_array ( $item->parent_id, $group_has_parent_activated )) {
		if(in_array ( $item->id, $group_has_parent_activated ))
			$class .= ' activated';
		$group_activated = 1;
		$group_has_parent_activated [] = $item->id;
	}
	
	if ($item->level) {
		$count_children ++;
		if ($count_children == $summner_children && $summner_children)
			$class .= ' last-item';
		if ($group_activated) {
			$html_activate .= "<li class='item $class child_" . $item->parent_id . "' ><h2 class='h2_" . $item->level . "'><a href='" . $link . "'  ><span> " . $item->name . "</span></a></h2>  ";
		} else {
			$html_normal .= "<li class='item $class child_" . $item->parent_id . "' ><h2 class='h2_" . $item->level . "'><a href='" . $link . "'  ><span> " . $item->name . "</span></a></h2>  ";
		}
		
	} else {
		$count_children = 0;
		$summner_children = $item->children;
		if($j <= 6){
			if ($group_activated) {
				$html_activate .= "<li class='item $class  ' id='pr_" . $item->id . "' >";
				$html_activate .= "<h2 class='h2_" . $item->level . "'><a href='" . $link . "' ><img  alt='".$item->name."' src='".URL_ROOT.str_replace('/original/', '/original/',$item -> icon)."'  onerror='javascript:this.src=\"".$noicon."\"' /><span> " . $item->name . "</span></a></h2>  ";
			} else {
				$html_normal .= "<li class='item $class  ' id='pr_" . $item->id . "' >";
				$html_normal .= "<h2 class='h2_" . $item->level . "'><a href='" . $link . "' ><img  alt='".$item->name."' src='".URL_ROOT.str_replace('/original/', '/original/',$item -> icon)."' onerror='javascript:this.src=\"".$noicon."\"' /><span> " . $item->name . "</span></a></h2>  ";
			}
		}else{
			if ($group_activated) {
				$html_activate_other .= "<li class='item level_1  ' id='pr_" . $item->id . "' >";
				$html_activate_other .= "<h2 class='h2_1'><a href='" . $link . "' ><span> " . $item->name . "</span></a></h2>  ";
			} else {
				$html_activate_other .= "<li class='item level_1  ' id='pr_" . $item->id . "' >";
				$html_activate_other .= "<h2 class='h2_1'><a href='" . $link . "' ><span> " . $item->name . "</span></a></h2>  ";
			}
		}
		$j++;
	}
	$num_child [$item->id] = $item->children;
	if ($item->children > 0) {
		if ($item->level) {
			if ($group_activated) {
				$html_activate .= "<ul id='c_" . $item->id . "' class='wrapper_children wrapper_children_level" . $item->level . "'  >";
			} else {
				$html_normal .= "<ul id='c_" . $item->id . "' class='wrapper_children wrapper_children_level" . $item->level . "'  >";
			}
		} else {
			if ($group_activated) {
				$html_activate .= "<ul id='c_" . $item->id . "' class='wrapper_children_level" . $item->level . "' >";
			} else {
				$html_normal .= "<ul id='c_" . $item->id . "' class='wrapper_children_level" . $item->level . " '  >";
			}
		}
	}
	
	if (@$num_child [$item->parent_id] == 1) {
		// if item has children => close in children last, don't close this item 
		if ($item->children > 0) {
			$parant_close ++;
		} else {
			$parant_close ++;
			for($i = 0; $i < $parant_close; $i ++) {
				if ($group_activated) {
					$html_activate .= "</ul>";
				} else {
					$html_normal .= "</ul>";
				}
			}
			$parant_close = 0;
			$num_child [$item->parent_id] --;
		}
		
		if (((@$num_child [$item->parent_id] == 0) && (@$item->parent_id > 0)) || ! $item->children) {
			if ($group_activated) {
				$html_activate .= "</li>";
			} else {
				$html_normal .= "</li>";
			}
		}
		if (@$num_child [$item->parent_id] >= 1)
			$num_child [$item->parent_id] --;
	}
	
	if (isset ( $num_child [$item->parent_id] ) && ($num_child [$item->parent_id] == 1)) {
		if ($group_activated) {
			$html_activate .= "</ul>";
		} else {
			$html_normal .= "</ul>";
		}
	}
	if (isset ( $num_child [$item->parent_id] ) && ($num_child [$item->parent_id] >= 1))
		$num_child [$item->parent_id] --;

}
?>
<div class="nav-mainmenu">
	<div class="arrow-count-down">
		Danh mục sản phẩm
	</div>
	<div id="nav_on_top" class="<?php echo ($Itemid==1)?'selected':''?>">
		<ul class='product_menu  product_menu-<?php echo $style;?>' >
		   <?php echo $html_activate; ?>
		   <?php echo $html_normal; ?>
		   <li id="pr_158" class="item level_0 ">
				<h2 class="h2_0">
					<a href="#">
					<img src="<?php echo URL_ROOT.'images/icon_sp_khac.png'; ?>">
						<span>Sản phẩm khác</span>
					</a>
				</h2>
				<ul class="wrapper_children_level0 ">
				 	<?php echo $html_activate_other; ?>
		   			<?php echo $html_normal_other; ?>
				</ul>
			</li>
		</ul>
<!--	end CONTENT -->
	</div> 
</div> 
