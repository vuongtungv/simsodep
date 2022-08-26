<?php
global $tmpl;
//$tmpl -> addStylesheet('highlight','blocks/newslist/assets/css');
//$tmpl -> addScript('script','blocks/newslist/assets/js');
//$total = count($list);
//$m = date('m');
//$y = date('Y');
//$number = cal_days_in_month(CAL_GREGORIAN, 11, $y); // 31
//    echo "There were {$number} days in $m $y";
?>

<?php if($list){?>
    <div class="container promotion-information">
        <marquee behavior="scroll" direction="left" class="top-slide" onmouseover="this.stop();" onmouseleave="this.start();">
            <?php foreach ($list as $item){
                $link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias);
                ?>
                <a href="<?php echo $link;?>"><?php echo $item->title?></a>
            <?php }?>
        </marquee>
        <span class="close-promo pull-right"><i class="fa fa-times" aria-hidden="true"></i></span>
    </div>
<?php }?>