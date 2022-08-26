<?php global $tmpl;
	$tmpl -> addStylesheet('banners','blocks/banners/assets/css');

?>


<div id="banner_default" class="container carousel slide" data-ride="carousel" data-interval="4000" style="padding: 0px; margin-top: 12px;">

    <!-- Indicators -->
    <ul class="carousel-indicators">
        <?php if(count($list) >1){
            foreach($list as $key=>$item){ ?>
                <li data-target="#banner_default" data-slide-to="<?php echo $key?>" class="<?php if($key ==0) echo 'active'?>"></li>
            <?php } }?>
    </ul>

    <!-- The slideshow -->
    <div class="carousel-inner">
        <?php $i = 0;?>
        <?php foreach($list as $key => $item){?>
            <div class="carousel-item item <?php if($key == 0 ) echo 'active'?>">

                <?php if($item -> type == 1){?>
                    <?php if($item -> image){?>
                        <a class="banners-item" href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>'  id="banner_item_<?php echo $item ->id; ?>">
                            <?php if($item -> width && $item -> height){?>
                                <img class="img-responsive"  alt="<?php echo $item -> name; ?>" src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $item -> image);?>" width="<?php echo $item -> width;?>" height="<?php echo $item -> height;?>">
                            <?php } else { ?>
                                <img class="img-responsive" alt="<?php echo $item -> name; ?>" src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $item -> image);?>">
                            <?php }?>
                        </a>
                    <?php }?>
                <?php } else if($item -> type == 2){?>
                    <?php if($item -> flash){?>
                        <a class="banners-item" href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>' id="banner_item_<?php echo $item ->id; ?>">
                            <embed menu="true" loop="true" play="true" src="<?php echo URL_ROOT.$item->flash?>"  wmode="transparent"
                                   pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?php echo $item -> width;?>" height="<?php echo $item -> height;?>">
                        </a>
                    <?php }?>
                <?php } else if($item -> type == 3) {?>
                    <div class='banner_item_<?php echo $i; ?> banner_item' <?php echo $item -> width?'style="width:'.$item -> width.'px"':'';?> id="banner_item_<?php echo $item ->id; ?>">
                        <?php echo $item -> content; ?>
                    </div>
                <?php }else{?>
                    <a class="banners-item" href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>'  id="banner_item_<?php echo $item ->id; ?>">
                        <?php if($text_pos == 'top'){?>
                            <?php echo $item -> content; ?>
                        <?php } ?>
                        <?php if($item -> width && $item -> height){?>
                            <img class="img-responsive"  alt="<?php echo $item -> name; ?>" src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $item -> image);?>" width="<?php echo $item -> width;?>" height="<?php echo $item -> height;?>">
                        <?php } else { ?>
                            <img class="img-responsive" alt="<?php echo $item -> name; ?>" src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $item -> image);?>">
                        <?php }?>
                        <?php if($text_pos == 'bottom'){?>
                            <?php echo $item -> content; ?>
                        <?php } ?>
                    </a>
                <?php }?>
                <?php $i ++; ?>
            </div>
        <?php }?>
    </div>

</div>


 