<?php
    global $tmpl; 
    $tmpl -> addStylesheet('owl.carousel.min','libraries/OwlCarousel2-2.2.1/assets');
    $tmpl -> addScript('owl.carousel.min','libraries/OwlCarousel2-2.2.1');
    
    $tmpl -> addStylesheet('style_default','blocks/slideshow/assets/css');
    $tmpl -> addScript('default','blocks/slideshow/assets/js');
    $i = 0;$j = 0;
?>	
<?php if(isset($data) && !empty($data)){?>
    <div id="owl-demo" class="owl-carousel">
        <?php foreach($data as $item){?>
            <?php if($item->image){ ?>
            <div class="item">
                <!--<h4 class="title-slide"><a href="<?php //echo $item->url;?>" title=""><?php //echo $item->name;?></a></h4>-->
                <a href="<?php echo $item->url; ?>" >
                    <img class="img-responsive" src="<?php echo URL_ROOT.str_replace('/original/', '/slideshow_large/', $item -> image)?>" alt="<?php echo $item->name;?>" />
                </a>
            </div>
            <?php } ?>
            <?php $j++;?>				
		<?php }?>
    </div>    
<?php }?>

