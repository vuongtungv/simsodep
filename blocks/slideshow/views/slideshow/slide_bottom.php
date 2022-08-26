<?php
    global $tmpl; 
    $tmpl -> addStylesheet('owl.carousel','libraries/owl.carousel/owl-carousel');
    $tmpl -> addStylesheet('owl.theme','libraries/owl.carousel/owl-carousel');
    $tmpl -> addStylesheet('owl.transitions','libraries/owl.carousel/owl-carousel');
    $tmpl -> addScript('owl.carousel.min','libraries/owl.carousel/owl-carousel');
    
    $tmpl -> addStylesheet('style_bottom','blocks/slideshow/assets/css');
    $tmpl -> addScript('default','blocks/slideshow/assets/js');
    $i = 0;$j = 0;
?>	
<?php if(isset($data) && !empty($data)){?>
    <div id="owl-bottom" class="owl-carousel">
        <?php foreach($data as $item){?>
            <div class="item">
                <a href="<?php echo $item->url; ?>" title="" class="item-images" >
                    <img src="<?php echo URL_ROOT.str_replace('/original/', '/slideshow_large/', $item -> image)?>" alt="<?php echo $item->name;?>" />
                    <h4 class="title-sile-bt"><?php echo $item->name; ?></h4>
                </a>
            </div>
            <?php $j++;?>				
		<?php }?>
    </div>
<?php }?>

