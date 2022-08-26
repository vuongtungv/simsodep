<?php global $tmpl;
$tmpl -> addStylesheet('banners','blocks/banners/assets/css');
$tmpl -> addScript('banners','blocks/banners/assets/js');
$total = count($list);
?>
<?php if($total){ ?>
    <div class="container ">
        <div class="banner-right">
            <?php $i = 0;?>
            <?php foreach($list as $item){?>

                <?php if($item -> type == 1){?>
                    <?php if($item -> image){?>
                        <div class="width-fi">

                            <a class="banners-item" href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>'  id="banner_item_<?php echo $item ->id; ?>">
                                <?php if($item -> width && $item -> height){?>
                                    <img class="img-responsive"  alt="<?php echo $item -> name; ?>" src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $item -> image);?>" width="<?php echo $item -> width;?>" height="<?php echo $item -> height;?>">
                                <?php } else { ?>
                                    <img class="img-responsive" alt="<?php echo $item -> name; ?>" src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $item -> image);?>">
                                <?php }?>
                            </a>
<!--                            <h3 class="banners_title">-->
<!--                                <span>--><?php //echo $item -> name; ?><!--</span>-->
<!--                            </h3>-->
<!--                            <div class="content-banner row-item">-->
<!--                                --><?php //echo $item -> content; ?>
<!--                            </div>-->
<!--                            <a class="view-all" href="--><?php //echo $item -> link;?><!--" title="--><?php //echo FSText::_('Xem thêm'); ?><!--">--><?php //echo FSText::_('Xem thêm'); ?><!--</a>-->
                        </div>
                    <?php }?>
                <?php } else if($item -> type == 2){?>
                    <?php if($item -> flash){?>
                        <div class="width-fi">
                            <a class="banners-item col-item" href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>' id="banner_item_<?php echo $item ->id; ?>">
                                <embed menu="true" loop="true" play="true" src="<?php echo URL_ROOT.$item->flash?>"  wmode="transparent"
                                       pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?php echo $item -> width;?>" height="<?php echo $item -> height;?>">
                            </a>
                        </div>
                    <?php }?>
                <?php } else if($item -> type == 3) {?>
                    <div class="width-fi">
                        <div class='banner_item_<?php echo $i; ?> banner_item col-item' <?php echo $item -> width?'style="width:'.$item -> width.'px"':'';?> id="banner_item_<?php echo $item ->id; ?>">
                            <?php echo $item -> content; ?>
                        </div>
                    </div>
                <?php }else{?>
                    <div class="width-fi">
                        <a class="banners-item col-item" href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>'  id="banner_item_<?php echo $item ->id; ?>">
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
                    </div>
                <?php }?>
                <?php $i ++; ?>
            <?php }?>
        </div>
    </div>
<?php } ?>

