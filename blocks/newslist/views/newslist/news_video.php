<?php
    global $tmpl;
    $tmpl -> addStylesheet('highlight','blocks/newslist/assets/css');
?>

<div class="container">
    <?php if(count($list)){ ?>
    <div id="hot_news">
        <?php  for ($i=0;$i<count($list); $i++  ){?>
        	<?php $item = $list[$i];?>
        	<?php $link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias);?>
            <?php if($i > 3) break;?>
            <div class="new-video-item">
                <a href="<?php echo $link; ?>" >
                    <img src="<?php echo URL_ROOT.str_replace('/original/','/small/', $item->image); ?>" alt='<?php echo $item -> title?>' />
                </a>
                <h3 class="heading"><a class="new-item" href='<?php echo $link ?>' title="<?php echo $item -> title ?>" ><?php echo cutString($item->title, 50, '...');?></a></h3>
            </div>
        <?php } ?>
        <?php $i=0; foreach ($list_video as $video): ?>
            <div class="new-video-item video">
                <a class="bg-click" href="<?php echo FSRoute::_("index.php?module=news&view=news&id=".$video->id."&code=".$video->alias."&ccode=".$video-> category_alias);?>" title="<?php echo $video -> title?>">&nbsp;</a>
                <a href="<?php echo $link; ?>" >
                    <img width="100%" src="<?php echo URL_ROOT.str_replace('/original/','/large/', $video->image); ?>" alt='<?php echo $video -> title?>' />
                </a>
            </div>
        <?php $i++; endforeach; ?>
        <div class="clear"></div>
    </div> 
    <?php } ?>
</div>



