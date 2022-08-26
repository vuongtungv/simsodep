<?php
global $tmpl,$config;
//    $tmpl -> addStylesheet('detail','modules/news/assets/css');
$tmpl -> addStylesheet('detail_mobile','modules/news/assets/css');
?>

<!--Detail news-->
<div class="detail-news">
    <div class="body-news">
        <h1 class="title-news"><?php echo $data->title?></h1>
        <p class="time-post">
            <?php echo $data->category_name?> -
            <span>
                <?php
                    echo $time_elapsed = $this->timeAgo($data->created_time);
                ?>
            </span>
        </p>
        <p class="brief"><?php echo $data->summary?></p>
        <?php echo $data->content?>
    </div>
    <div class="tag-news">
        <ul>
            <strong>Tags: </strong>
            <?php
            $tag = explode(',',$data->tags);
            foreach($tag as $item){ if($item !=''){?>
                <li><a href="<?php echo FSRoute::_('index.php?module=news&view=search&keyword='.$item)?>"><?php echo $item?></a></li>
            <?php }}?>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="other-news">
        <h4 class="title-hea">Tin liên quan</h4>
        <ul>
            <?php foreach ($relate_news_list as $item){?>
                <?php $link = FSRoute::_('index.php?module=news&view=news&code='.$item->alias.'&id='.$item->id);?>
                <li class="item-news">
                    <a href="<?php echo $link;?>"><?php echo $item->title?></a>
                </li>
            <?php }?>
        </ul>
    </div>
</div>
