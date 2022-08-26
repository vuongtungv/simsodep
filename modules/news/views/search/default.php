<?php 
global $tmpl;
$tmpl -> addStylesheet('tintuc','modules/news/assets/css');
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
<!--<h1 class="block_title_cat">-->
<!--  	<span>--><?php //echo FSText::_('Kết quả tìm kiếm cho từ khóa').' "'.$keyword.'"'; ?><!--</span>-->
<!--</h1>-->
<!--<div class='news_search news_cat'>-->
<!--	<div class="row">-->
<!--		--><?php //
//		if($total_list){
//			for($i = 0; $i < $total_list; $i ++){
//				$news = $list[$i];
//				$link_news = FSRoute::_("index.php?module=news&view=news&id=".$news->id."&code=".$news->alias."&ccode=".$news-> category_alias."&Itemid=$Itemid");
//		?>
<!--		<div class="col-lg-12 col-xs-12">-->
<!--			<div class="newslist-item row-item" >-->
<!--				<a class='item-image fl-left' href="--><?php //echo $link_news; ?><!--">-->
<!--					<img width="252" onerror="this.src='/images/no-images.png'" class="img-responsive" src="--><?php //echo URL_ROOT.str_replace('/original/','/small/', $news->image); ?><!--" alt="--><?php //echo htmlspecialchars(@$news->title); ?><!--" />-->
<!--				</a>-->
<!--				<h2 class="title"><a href="--><?php //echo $link_news; ?><!--" title="--><?php //echo htmlspecialchars(@$news->title); ?><!--">--><?php //echo htmlspecialchars(@$news->title); ?><!--</a></h2>-->
<!--				<summary class="summary">--><?php //echo getWord(30,$news -> summary);?><!--</summary>-->
<!--				<a class="detail" href='--><?php //echo $link_news;?><!--' title='--><?php //echo $news ->title;?><!--'>--><?php //echo FSText::_('Xem ngay'); ?><!--</a>-->
<!--			</div>-->
<!--		</div>-->
<!--		--><?php //
//			}
//			if($pagination) echo $pagination->showPagination(3);
//		} else {
//			echo "Không có kết quả nào cho từ khóa <strong>".$keyword."</strong>";
//		 }
//		 ?>
<!--	</div>-->
<!--    <div class="clear"></div>-->
<!--</div>-->


<div class="container home-news">
    <div class="center-news">
        <h1 class="title-news"><?php echo FSText::_('Kết quả tìm kiếm cho từ khóa: ').' "'.$keyword.'"'; ?></h1>
        <?php if($list){?>
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
                            <p class="time-post">
                                <?php echo $item->category_name?> -
                                <span>
                                    <?php
                                        echo $time_elapsed = $this->timeAgo($item->created_time);
                                    ?>
                                </span>
                            </p>
                            <p class="brief">
                                <?php echo getWord(22,$item -> summary);?>
                            </p>

                        </div>
                    </div>
                </div>
            <?php }?>
            <nav aria-label="Page navigation example" class="pagination-bottom">
            <?php if($pagination) echo $pagination->showPagination(); ?>
        </nav>
        <?php }else{ echo "Không có kết quả nào cho từ khóa <strong>".$keyword."</strong>";}?>
    </div>
</div>