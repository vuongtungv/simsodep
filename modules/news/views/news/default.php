<?php  	
    global $tmpl,$config;
//    $tmpl -> addStylesheet('detail','modules/news/assets/css');
    $tmpl -> addStylesheet('tintuc','modules/news/assets/css');
?>

<!--Detail news-->
<div class="container detail-news">
    <div class="body-news">
        <h1 class="title-news"><?php echo $data->title?></h1>
        <p class="time-post">
            <?php echo $data->category_name?> -
            <span>
                <?php
                    echo $time_elapsed = $this->timeAgo($data->updated_time);
                ?>
            </span>
        </p>
        <p class="brief"><?php echo $data->summary?></p>
        <div class="content">
            <?php echo $data->content?>
        </div>
    </div>
    <?php if($data->tags !=''){?>
        <div class="tag-news">
            <strong>Tags: </strong>
            <ul>
                <?php
                    $tag = explode(',',$data->tags);
                    foreach($tag as $item){ if($item !=''){?>
                    <li><a href="<?php echo FSRoute::_('index.php?module=news&view=search&keyword='.$item)?>"><?php echo $item?></a></li>
                <?php }}?>
            </ul>
            <div class="clearfix"></div>
        </div>
    <?php }?>
    <div class="other-news">
        <h4 class="title-hea">Tin liên quan</h4>
        <div class="box-list">
            <?php foreach ($relate_news_list as $item){?>
                <?php $link = FSRoute::_('index.php?module=news&view=news&code='.$item->alias.'&id='.$item->id);?>
                <div class="item-news">
                    <a href="<?php echo $link?>">
                        <?php if($item->image == ''){?>
                            <img src="/templates/default/images/no_img.png" alt="">
                        <?php }else{?>
                            <img src="<?php echo URL_ROOT.str_replace('original','resized',$item->image)?>" alt="">
                        <?php }?>
                        <h3><?php echo $item->title?></h3>
                    </a>
                </div>
            <?php }?>
        </div>
    </div>

</div>

