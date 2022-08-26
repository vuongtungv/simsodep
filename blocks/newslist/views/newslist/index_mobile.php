<?php
global $tmpl;
$tmpl -> addStylesheet('highlight','blocks/newslist/assets/css');
//$link_readmore =FSRoute::_("index.php?module=news&view=home");
?>

<?php if(isset($list[0])){?>
<div class="new-big">
    <a href="<?php echo FSRoute::_("index.php?module=news&view=news&id=".$list[0]->id."&code=".$list[0]->alias."&ccode=".$list[0]-> category_alias)?>">
        <img src="<?php echo URL_ROOT.str_replace('/original/','/big_mobile/',$list[0]->image)?>" alt="<?php echo $list[0]->title?>">
        <p class="title-big">
            <a href="<?php echo FSRoute::_("index.php?module=news&view=news&id=".$list[0]->id."&code=".$list[0]->alias."&ccode=".$list[0]-> category_alias)?>"><?php echo $list[0]->title?></a>
        </p>
        <p class="brief-big"><?php echo getWord(15,$list[0]->title);?></p>
        <p class="time-post">
            <span class="title-cate-bl"><?php echo $list[0]->category_name?></span>
            -
            <?php
                echo timeAgo($list[0]->created_time);
            ?>
        </p>
    </a>
</div>
<?php }?>

<div class="new-small">
    <?php for($i = 1; $i<count($list); $i++){
        ?>
        <div class="item">
            <div class="img-small">
                <img src="<?php echo URL_ROOT.str_replace('/original/','/big_mobile/', $list[$i]->image);?>" alt="<?php echo $list[$i]->title?>">
            </div>
            <div class="body-small">
                <a class="title-small" href="<?php echo FSRoute::_("index.php?module=news&view=news&id=".$list[$i]->id."&code=".$list[$i]->alias."&ccode=".$list[$i]-> category_alias)?>">
                    <?php echo getWord(15,$list[$i]->title);?>
                </a>
                <p class="time-post">
                    <span class="title-cate-bl"><?php echo $list[$i]->category_name?></span>
                    -
                    <?php
                    echo $time_elapsed = timeAgo($list[$i]->created_time);
                    ?>
                </p>
            </div>
        </div>
    <?php }?>
    <div class="view-more">
        <a href="<?php echo FSRoute::_('index.php?module=news&view=home&Itemid=2')?>">Xem thêm <span>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
    </div>
</div>