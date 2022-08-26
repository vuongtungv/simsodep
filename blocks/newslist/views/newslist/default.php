<?php
    global $tmpl; 
    $tmpl -> addStylesheet('highlight','blocks/newslist/assets/css');
    //$link_readmore =FSRoute::_("index.php?module=news&view=home");
?>

<div class="newslist-content row-item">
<?php  for ($i=0;$i<count($list); $i++  ){?>
	<?php $item = $list[$i];?>
	<?php $link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias);?>
    <h3 class="item-news">
        <a class="new-item" href='<?php echo $link ?>' title="<?php echo $item -> title ?>" >
    		<i class="fa fa-circle"></i> <?php echo getWord(20,$item->title);?>
    	</a>
    </h3><!-- END: item-news -->        
<?php } ?>
</div>

