<?php
    global $tmpl; 
    $tmpl -> addStylesheet('highlight','blocks/newslist/assets/css');
?>

<?php if(count($list)){ ?>
	<?php  for ($i=0;$i<count($list); $i++  ){?>
		<?php $item = $list[$i];?>
		<?php $link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias);?>			
    	<div class="new-item row-item" >
            <a class="item-image" href='<?php echo  $link;?>' title='<?php echo $item ->title;?>'>
    		  <img width="100" class="img-responsive" src='<?php echo URL_ROOT.str_replace('/original/','/small/',$item -> image);?>' alt="<?php echo $item -> title;?>"/>
            </a>
            <h3 class="title">
                <a href='<?php echo  $link;?>' title='<?php echo $item ->title;?>'><?php echo getWord(12,$item->title);?></a>
            </h3>
    	</div>    	
	<?php } ?>
<?php } ?>
