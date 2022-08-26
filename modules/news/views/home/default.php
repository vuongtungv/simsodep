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
                    <a href="<?php echo $link?>">
                        <?php if($item->image){?>
                            <img src="<?php echo URL_ROOT.str_replace('/original/','/large/',$item->image)?>" alt="<?php echo $item->title?>">
                        <?php }else{?>
                            <img src="/templates/default/images/no_img.png" alt="no_img">
                        <?php }?>

                        <?php echo $item->title?>
                    </a>
                    <p class="time-post">
                        <?php echo $item->category_name?> -
                        <span>
                                    <?php
                                    echo $time_elapsed = $this->timeAgo($item->updated_time);
                                    ?>
                                </span>
                    </p>
                    <p class="brief">
                        <?php echo getWord(25,$item -> summary);?>
                    </p>
                </div>
                <?php }?>
            </div>
        </div>
        <?php foreach ($list as $item){?>
            <?php if($listHot[0]->id != $item->id && $listHot[1]->id != $item->id){?>
                <?php $link = FSRoute::_('index.php?module=news&view=news&code='.$item->alias.'&id='.$item->id);?>
                <div class="item-small-news">
                    <div class="row">
                        <div class="col-md-5 img-small">
                            <a href="<?php echo $link?>">
                                <?php if($item->image){?>
                                    <img src="<?php echo URL_ROOT.str_replace('/original/','/small/', $item->image)?>" alt="<?php echo $item->title?>">
                                <?php }else{?>
                                    <img src="/templates/default/images/no_img.png" alt="no_img">
                                <?php }?>
                            </a>
                        </div>
                        <div class="col-md-7 small-news">
                            <a href="<?php echo $link?>"><?php echo $item->title?></a>
                            <p class="time-post">
                                <?php echo $item->category_name?> -
                                <span>
                                    <?php
                                        echo $time_elapsed = $this->timeAgo($item->updated_time);
                                    ?>
                                </span>
                            </p>
                            <p class="brief">
                                <?php echo getWord(25,$item -> summary);?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php }?>
        <?php }?>
        <?php if($pagination) echo $pagination->showPagination(); ?>
    </div>
</div>

