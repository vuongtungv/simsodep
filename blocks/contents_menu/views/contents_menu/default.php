<?php 
    global $tmpl;
    $tmpl -> addStylesheet('styles','blocks/contents_menu/assets/css');
    $tmpl -> addScript('script','blocks/contents_menu/assets/js');
    $Itemid  = 8;
    $code = FSInput::get('code');
?>

<div class="contents_menu_ row-item">
    <div id="css_menu_content" >
        <ul>
            <?php $i=0; foreach($list as $item){ 
                  $link = FSRoute::_('index.php?module=contents&view=content&id='.$item->id.'&code='.$item->alias.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);  
            ?>
        	   <li class="has-sub <?php echo $code == $item->alias? 'active':'' ?>">
                    <div>
                        <a href="<?php echo $link; ?>" title="<?php echo $item->title; ?>"><?php echo $item->title; ?></a>
                    </div>
               </li>
           <?php $i++; } ?>
        </ul>
    </div>	
</div><!--	END: .contents_menu -->

 