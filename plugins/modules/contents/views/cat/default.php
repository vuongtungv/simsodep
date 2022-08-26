<?php
	global $tmpl;
	$tmpl -> addStylesheet('cat','modules/contents/assets/css');
	$tmpl -> addScript('cat','modules/contents/assets/js');

	$total_list = count($list);
        $Itemid = 7;
	$class = '';	
?>	

	<div class="contents_cat wapper-page  wapper-page-cat">
		
		<h1 class="cat_title flever_18">
			<?php 	echo $cat->name;?>
		</h1>
	<div class="wapper-content-page">
		<?php 
		if($total_list){
			for($i = 0; $i < $total_list; $i ++){
			if($i == $total_list-1){
					 $class .= ' last-item';
				}
				$item = $list[$i];
				
				$link = FSRoute::_("index.php?module=contents&view=contents&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias."&Itemid=$Itemid");
		?>
		<div class='item <?php echo $class; ?>'>
			<div class='frame_img'>
				<a class='item-img' href="<?php echo $link; ?>">
					<img src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $item->image); ?>" alt="<?php echo htmlspecialchars(@$item->title); ?>" onerror="javascript:this.src='<?php echo URL_ROOT.'images/NA220x160.png' ?>'"/>
				</a>
			</div>
			<div class="details">
				<h2 class="title_content"><a href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->title); ?>"><?php echo htmlspecialchars(@$item->title); ?></a></h2>
				<div class='item-sum'>	<?php echo $item->summary; ?>	</div>
				<a class="read_more" href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->title); ?>">Xem tiếp</a>
			</div>
			<div class="clear"></div>
		</div>
		<?php 
			}
			if($pagination) echo $pagination->showPagination(3);
		} else {
			echo FSText::_('Không có bài viết nào trong chuyên mục')." : <strong>".$cat->name."</strong>";
		 }
		?>
		</div>
		<div class='clear'></div>
	</div>