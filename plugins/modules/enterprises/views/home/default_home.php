    <div class="new_cat wapper-page  wapper-page-cat">
	    <div class="wapper-content-page">
			<?php 
			if($total_news_list){
				for($i = 0; $i < 3; $i ++){
					$news = $news_list[$i];
					$link_news = FSRoute::_("index.php?module=news&view=news&id=".$news->id."&code=".$news->alias."&ccode=".$news-> category_alias."&Itemid=$Itemid");
			?>
			<div class='item <?php echo ($i==0)?'row1':''?>'>
				<div class='frame_img_news'>
				<?php if($news->image){?>				
					<a class='item-img' href="<?php echo $link_news; ?>">
						<img width="290" height="220" class="img-responsive" src="<?php echo URL_ROOT.str_replace('/original/','/original/', $news->image); ?>" alt="<?php echo htmlspecialchars(@$news->title); ?>" />
					</a>				
				<?php } ?>
                    <div class="news_title">
    					<h2  class="item_title flever_22" ><a href="<?php echo $link_news; ?>" title="<?php echo htmlspecialchars(@$news->title); ?>"><?php echo htmlspecialchars(@$news->title); ?></a></h2>
    				</div>
                </div>
			</div>
			<?php 
				}
			}
			?>
			<div class='clearfix'></div>
		</div>	
	</div>