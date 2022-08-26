<?php
global $tmpl;
$tmpl -> addStylesheet('tintuc','modules/news/assets/css');
$total = count($list);
$Itemid = 7;
FSFactory::include_class('fsstring');
?>


<!--Beadcrumb-->
<?php //$tmpl->load_direct_blocks('breadcrumbs'); ?>
<!--Home home-->
<div class="container home-news">
    <div class="center-news">
        <h1 class="title-news">Tin nổi bật</h1>
        <div class="big-news">
            <div class="row">
                <?php foreach ($listHot as $item){?>
                    <div class="col-md-6 item-big-news">
                        <?php $link = FSRoute::_('index.php?module=news&view=news&code='.$item->alias.'&id='.$item->id);?>
                        <img src="<?php echo URL_ROOT.str_replace('/original/','/large/',$item->image)?>" alt="">
                        <a href="<?php echo $link?>"><?php echo $item->title?></a>
                    </div>
                <?php }?>
            </div>
        </div>
        <?php foreach ($list as $item){?>
            <?php $link = FSRoute::_('index.php?module=news&view=news&code='.$item->alias.'&id='.$item->id);?>
            <div class="item-small-news">
                <div class="row">
                    <div class="col-md-5 img-small">
                        <a href="<?php echo $link?>">
                            <img src="<?php echo URL_ROOT.str_replace('/original/','/small/', $item->image)?>" alt="">
                        </a>
                    </div>
                    <div class="col-md-7 small-news">
                        <a href="<?php echo $link?>"><?php echo $item->title?></a>
                        <p class="time-post"><?php echo $item->category_name?> - <span>4 giờ trước</span></p>
                        <p class="brief">
                            <?php
                            $text = explode(' ',$item->summary);
                            for($i= 0 ; $i<22; $i++) {
                                echo $text[$i] . " ";
                            }
                            if(count($text) >=22){
                                echo "...";
                            }
                            ?></p>
                    </div>
                </div>
            </div>
        <?php }?>
        <?php if($pagination) echo $pagination->showPagination(); ?>
    </div>
</div>