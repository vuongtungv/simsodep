<?php 
    $j=0;
	if($total_news_list){
		for($i = 0; $i < $total_news_list; $i ++){
			$news = $news_list[$i];
			$link_news = FSRoute::_("index.php?module=news&view=news&id=".$news->id."&code=".$news->alias."&ccode=".$news-> category_alias."&Itemid=$Itemid");
	$j++;
    ?>
		
        <?php if($i%4 == 0){ ?>
            <div class="news_category">
                <div class="hot_new_detail">
    				<?php if($news->image){?>
    					<a href="<?php echo $link_news; ?>" >
    						<img width="177" height="133" src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $news->image); ?>" alt="<?php echo htmlspecialchars(@$news->title); ?>" />
    					</a>
    				<?php }?>
                    <div class="title">
        				<h3><a href="<?php echo $link_news; ?>" ><?php echo $news -> title; ?></a></h3>
        				<span><?php echo date('H:s   d/m/Y',strtotime($news -> created_time)); ?></span>				
        				<p><?php echo getWord(50,$news -> summary);?></p>
    			    </div> 
                </div>
            </div>
            <?php }?>
            <?php if($i%4 != 0){ ?>
				<li class="<?php echo ($j%4 == 0)?'last':''?>"><a href="<?php echo $link_news; ?>" ><?php echo $news -> title; ?></a></li>          
            <?php }?>
	<?php }}?>
    