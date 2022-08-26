<?php
    global $tmpl; 
    $tmpl -> addStylesheet('highlight','blocks/newslist/assets/css');
    $tmpl -> addScript('script','blocks/newslist/assets/js');
    $total = count($list);
    $m = date('m');
    $y = date('Y');
    //$number = cal_days_in_month(CAL_GREGORIAN, 11, $y); // 31
//    echo "There were {$number} days in $m $y";
?>

<div class="col-left">
    <div class="row">
        <?php foreach ($listHot as $key=>$item){
            if($key == 0 || $key == 1){
            $link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias);
        ?>

                <div class="col-md-6 <?php echo $key==0 ? 'big-first' : 'big-second';?> news-big">
                    <a href="<?php echo $link;?>">
                        <img src="<?php echo URL_ROOT.str_replace('/original/', '/small/',$item->image)?>" alt="<?php echo $item -> title?>">
                        <p class="title-new">
                            <?php echo getWord(14,$item -> title);?>
                        </p>
                    </a>
                    <p class="time-post">
                        <?php echo $item->category_name?> -
                        <?php
                            echo $time_elapsed = $this->timeAgo($item->updated_time);
                        ?>
                    </p>
                    <p class="brief">
                        <?php echo getWord(23,$item -> summary);?>
                    </p>
                </div>
        <?php } }?>
    </div>
</div>
<div class="col-right">
    <div class="small-news">
        <div class="scroll-y">
            <?php foreach ($listHot as $key=> $it){
                if($key >1){
                $link = FSRoute::_("index.php?module=news&view=news&id=".$it->id."&code=".$it->alias."&ccode=".$it-> category_alias);
            ?>
                    <div class="item-news">
                        <a href="<?php echo $link;?>"><?php echo $it->title?></a>
                        <p class="time-post">
                            <?php echo $it->category_name?> -
                            <?php
                            echo $time_elapsed = $this->timeAgo($it->updated_time);
                            ?>
                        </p>
                        <p><?php echo getWord('20',$it->summary)?></p>
                    </div>
            <?php } }?>
        </div>
    </div>
</div>

