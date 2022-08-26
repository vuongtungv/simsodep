<?php
global $tmpl; 
$tmpl -> addStylesheet('highlight','blocks/newslist/assets/css');

?>
<div class='row'>
	<?php  for ($i=0;$i<count($list); $i++  ){?>
		<?php $item = $list[$i];?>
		<?php $link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias);?>
            <div class="col-xs-12 col-sm-12">
                <a class="new-item fl-left" href='<?php echo $link ?>' title="<?php echo $item -> title ?>" >
            		<?php echo getWord(20,$item->title);?> <span>(<?php echo $item->hits ?>)</span>
            	</a>
            </div>
	<?php } ?>
</div>
