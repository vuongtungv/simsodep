<?php  	global $tmpl;
$tmpl -> addStylesheet('detail','modules/news/assets/css');
$tmpl -> addScript('form');
$tmpl -> addScript('main');
$tmpl -> addScript('detail','modules/news/assets/js');
FSFactory::include_class('fsstring');

$print = FSInput::get('print',0);
?>
<div class="news_detail row-content">
    <div class="row">
        <div class="col-sm-9 news-detail-left">
            <div class="col-item row-item pal">
            
                <h1 class="news-title pbm mbm"><?php	echo $data -> title; ?></h1>
                
                <div class="news-detail-share row-item mbm">
                    <span class="fl-left news-datetime"><?php echo format_date($data -> created_time); ?></span>
                    <?php include 'default_share_bottom.php'; ?>
                </div><!-- END: .news-detail-share -->
                
                <h2 class="news-summary">
                    <p><?php echo $data -> summary; ?></p>
                </h2>
                
                <div class='news-description mbm'>
            		<?php echo $description; ?>
            	</div><!-- END: .news-detail-content -->
    
                <div class="news-detail-share row-item mbm">
                    <?php if($data->source_products){ ?>
                        <span class="fl-left news-sours">Nguồn: <?php echo $data->source_products; ?></span>
                    <?php } ?>
                    
                    <?php include 'default_share_bottom.php'; ?>
                </div><!-- END: .news-detail-share -->
                
                <div class="news-comment-face row-item">
                    <span class="title-comment"><?php echo FSText::_('Bình luận của bạn') ?></span>
                    <div class="row">
                        <div class="fb-comments" data-href="http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" data-width="100%" data-num-posts="10"></div>
                    </div>
                </div><!-- END: .news-comment-face -->
                
            </div>
        </div><!-- END: .news-detail-left -->
        
        <div class="col-sm-3 news-detail-right row-item">
        
            <?php if(count($products_related)){?>
            <div class="news-related row-item col-item col-xs-12 col-sm-12">
                <h3 class="relate_title">
                    <span>Tin liên quan</span>
               </h3>
                <?php $i = 0;?>
    			<?php foreach($products_related as $item){
    				$link_news = FSRoute::_("index.php?module=news&view=news&code=".$item->alias."&id=".$item -> id."&ccode=".$item -> category_alias."&Itemid=$Itemid"); 
                ?>
    				<a class="item-relate fl-left plm pvm <?php echo $i==(count($products_related)-1)? 'item-relate-last':'' ?>" href="<?php echo $link_news; ?>" title="<?php echo $item -> title; ?>"><?php echo getWord(12,$item -> title); ?></a>
    			<?php $i++; }?>
            </div><!-- END: .news-related -->
            <?php }?>
            
            <div class="news-categories-related row-item col-item col-xs-12 col-sm-12">
                <?php include 'default_related.php'; ?>
            </div><!-- END: .news-detail-left -->
            
        </div><!-- END: .news-detail-left -->

	</div>
    <input type="hidden" value="<?php echo $data->id; ?>" name='news_id' id='news_id'  />
</div>
