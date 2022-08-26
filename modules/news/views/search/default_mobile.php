<?php
global $tmpl;
$tmpl -> addStylesheet('home_mobile','modules/news/assets/css');
$total = count($list);
$Itemid = 7;
FSFactory::include_class('fsstring');
$tmpl -> addStylesheet('cat','modules/news/assets/css');
$keyword = FSInput::get('keyword');
$page = FSInput::get('page');
$title = 'Tìm kiếm với từ khóa "'.$keyword.'"';
if(!$page)
    $tmpl->addTitle( $title);
else
    $tmpl->addTitle( $title.' - Trang '.$page);

$total = count($list);

$str_meta_des = $keyword;

for($i = 0; $i < $total ; $i ++ ){
    $item = $list[$i];
    $str_meta_des .= ','.$item -> title;
}
$tmpl->addMetakey($str_meta_des);
$tmpl->addMetades($str_meta_des);
$Itemid = 4;
?>
<!-- NEW HOME -->
<div class="new-home">
    <h1 class="title-news" style="padding: 30px 28px;"><?php echo FSText::_('Kết quả tìm kiếm cho từ khóa: ').' "'.$keyword.'"'; ?></h1>
    <?php if($list){?>
        <div class="new-small">
            <?php foreach ($list as $item){?>
                <?php $link = FSRoute::_('index.php?module=news&view=news&code='.$item->alias.'&id='.$item->id);?>
                <div class="item">
                    <div class="img-small">
                        <a href="<?php echo $link;?>">
                            <img src="<?php echo URL_ROOT.str_replace('/original/','/large/',$item->image)?>" alt="">
                        </a>
                    </div>
                    <div class="body-small">
                        <a href="<?php echo $link?>" class="title-small"><?php echo getWord(10,$item->summary);?></a>
                        <p class="time-post"><?php echo $item->category_name?> -
                            <span>
                            <?php
                                echo $time_elapsed = $this->timeAgo($item->created_time);
                            ?>
                            </span>
                        </p>
                    </div>
                </div>
            <?php }?>
        </div>
    <?php }?>
    <?php if($pagination) echo $pagination->showPagination(); ?>
</div>
