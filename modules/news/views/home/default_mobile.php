<?php
global $tmpl;
$tmpl -> addStylesheet('home_mobile','modules/news/assets/css');
$total = count($list);
$Itemid = 7;
FSFactory::include_class('fsstring');
?>


<!-- NEW HOME -->
<div class="new-home">
    <div class="new-big">
        <?php if($listHot){?>
            <a href="<?php echo FSRoute::_('index.php?module=news&view=news&code='.$listHot[0]->alias.'&id='.$listHot[0]->id)?>">
                <img src="<?php echo URL_ROOT.str_replace('/original/','/big_mobile/',$listHot[0]->image)?>" alt="<?php echo $listHot[0]->title?>">
            </a>
            <p class="title-big"><a href="<?php echo FSRoute::_('index.php?module=news&view=news&code='.$listHot[0]->alias.'&id='.$listHot[0]->id)?>"><?php echo $listHot[0]->title?></a></p>
            <p class="brief-big"><?php echo getWord(20,$listHot[0]->summary);?></p>
            <p class="time-post">
                <span class="title-cate-bl"><?php echo $listHot[0]->category_name?></span>
                -
                <?php
                    echo $time_elapsed = $this->timeAgo($listHot[0]->created_time);
                ?>
            </p>
        <?php }?>
    </div>
    <div class="new-small">
        <?php foreach ($list as $item){?>
            <?php if($listHot[0]->id != $item->id && $listHot[1]->id != $item->id){?>
                <?php $link = FSRoute::_('index.php?module=news&view=news&code='.$item->alias.'&id='.$item->id);?>
                <div class="item">
                    <div class="img-small">
                        <a href="<?php echo $link;?>">
                            <?php if($item->image){?>
                                <img src="<?php echo URL_ROOT.str_replace('/original/','/large/',$item->image)?>" alt="<?php echo $item->title?>">
                            <?php }else{ ?>
                                <img src="/templates/default/images/no_img.png" alt="<?php echo $item->title?>">
                            <?php }?>
                        </a>
                    </div>
                    <div class="body-small">
                        <!--<a href="--><?php //echo $link?><!--" class="title-small">--><?php //echo getWord(10,$item->title);?><!--</a>-->
                        <a href="<?php echo $link?>" class="title-small"><?php echo $item->title;?></a>
                        <p class="time-post">
                            <span class="title-cate-bl"><?php echo $item->category_name?></span>
                            -
                            <span>
                                <?php
                                    echo $time_elapsed = $this->timeAgo($item->created_time);
                                ?>
                            </span>
                        </p>
                    </div>
                </div>
            <?php }?>
        <?php }?>
    </div>
    <?php if($pagination) echo $pagination->mshowPagination(1); ?>
</div>


