<?php
global $tmpl; 
$tmpl -> addStylesheet('newslist_default','blocks/newslist/assets/css');
FSFactory::include_class('fsstring');
$Itemid = 4;
$i = 0;$j=0;
?>
<div class="newslist_hot">
    <h2 class="news-hot-detail">
        <span>Tin hot</span>
    </h2>
	<div class="news-hot">
		<?php 
		foreach ($array_cats as $cat) {
			if(!count($array_news_by_cat[$cat->id])){
				continue;
			}
			?>
            	<?php $news = $array_news_by_cat[$cat->id];?>
            	<?php $total = count($news);?>
                	<?php 	foreach ($news as $new){?>
            			<?php $class = '';?>
	                		<?php $link = FSRoute::_("index.php?module=news&view=news&id=".$new->id."&code=".$new->alias."&ccode=".$new-> category_alias);?>
	                		<?php $w140h105 = URL_ROOT.str_replace('/original/', '/small/',$new -> image);?>
	                			<div class="media-box">
		                			<a href="<?php echo $link; ?>"><img width="75" height="60" alt="<?php echo $new->title?>" src="<?php echo $w140h105; ?>"  /></a>
								  	<div class="media-body">
										<h3>
											<a href="<?php echo $link; ?>" title="<?php echo $new->title?>"><?php echo get_word_by_length(70,$new->title);?></a>
										</h3>
									</div>
									<div class="clear"></div>
								</div>
                	<?php }?>
			<?php 
			$j++;
		}
		?>
	</div>
</div>
            		
