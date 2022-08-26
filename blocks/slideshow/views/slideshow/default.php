<?php
    global $tmpl; 
    $tmpl -> addStylesheet('owl.carousel.min','libraries/jquery/owl.carousel');
    $tmpl -> addStylesheet('owl.theme.default.min','libraries/jquery/owl.carousel');
    $tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel');
    $tmpl -> addStylesheet('default_home','blocks/slideshow/assets/css');
    $tmpl -> addScript('default_home','blocks/slideshow/assets/js');
    $i = 0;$j = 0;
?>	
<?php if(isset($data) && !empty($data)){?>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php foreach($data as $item){?>
                <li data-target="#myCarousel" data-slide-to="<?php echo $i;?>" <?php echo ($i==0)?'class="active"':''?>></li>
            <?php $i++;?>               
            <?php }?>
        </ol>
        <div class="carousel-inner" role="listbox">
            <?php foreach($data as $item){?>
            <div class="item <?php echo ($j==0)?'active':''?> ">
                <img class="img-responsive" src="<?php echo URL_ROOT.str_replace('/original/', '/slideshow_large/', $item -> image)?>" alt="<?php echo $item->name;?>" />
                <a class="carousel-caption hot-corner" href="<?php echo $item->url; ?>" >
                    <div class="hot-corner__logo">
                        <img class="img-responsive" src="<?php echo URL_ROOT.str_replace('/original/', '/small/', $item -> image_thumb)?>" alt="<?php echo $item->name;?>" />
                    </div>
                    <div class="logoslide">
                        <div class="hot-corner_title no-break-out"><?php echo cutString($item->name, 45, '...') ?></div>
                        <div class="hot-corner_summary no-break-out"><?php echo cutString($item->summary, 60, '...') ?></div>
                    </div>
                </a>
            </div>
            <?php $j++;?>               
            <?php }?>
        </div>
        <div class="clear"></div>
    </div>
<?php }?>