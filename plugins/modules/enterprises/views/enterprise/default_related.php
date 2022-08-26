<!--	RELATE CONTENT		-->
<?php
	$total_content_relate = count($relate_products_list);
	if($total_content_relate){ ?>
	       <h3 class="relate_title mbm">
                <span>Tin cùng chuyên mục</span>
           </h3>
        <?php 
			for($i = 0; $i < $total_content_relate; $i ++){
			$item = $relate_products_list[$i]; 
			$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id);
		?>	
            <a class="img_news relate_content mbm" href='<?php echo $link;?>' title='<?php echo $item ->title;?>'>
				<img  class="img-responsive fl-left" alt="" src="<?php echo URL_ROOT.str_replace('/original/', '/small/', $item->image);?>" />
                <p class="text"><?php echo getWord(12,$item ->title);?></p>
			</a>
                
		<?php } ?>
<?php } ?>
<!--	end RELATE CONTENT		-->