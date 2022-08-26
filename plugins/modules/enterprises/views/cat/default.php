<?php
	global $tmpl;
	$tmpl -> addStylesheet('cat','modules/enterprises/assets/css');
	$total_news_list = count($list);
    $Itemid = 7;
	FSFactory::include_class('fsstring');	
?>	

<?php // echo $tmpl -> load_direct_blocks('newslist',array('style'=>'grid','type'=>'hot','limit'=>4)); ?>

<aside class="news_cat row-item">
	<h1 class="news-cat-title">
        <span><?php echo $cat->name; ?></span>
    </h1>
	

	<div class="newslist row-item">
        <div class="row">
            <div class="col-sm-12 col-xs-12">
            	<?php if($total_news_list){?>
            		<?php foreach ($list as $item) {
            		  $link_cat = FSRoute::_('index.php?module=enterprises&view=cat&id='.$item->category_id.'&ccode='.$item->category_alias.'&Itemid='.$Itemid); 
            	       $link = '';
                        if($item->source_website){
                                $link = "href='http://".$item->source_website."' target='_blank' ";
                          }
                    ?> 
            				
                            <div class="newslist-item col-item row-item pam">
            					<a class="img_news fl-left mrm" <?php echo $link;?> title='<?php echo $item ->title;?>'>
            						<img  class="img-responsive" alt="" src="<?php echo URL_ROOT.str_replace('/original/', '/resized/', $item->image);?>">
            					</a>
                                <div class="newslist-item-content">
                					<h3>
                                        <a <?php echo $link ?> title="<?php echo $item -> title ?>" ><?php echo getWord(16,$item->title);?></a>
                                    </h3>
                                    <div class="item-info">
                                        <span>Địa chỉ:</span> <?php echo $item->address; ?>
                                    </div>
                                    <div class="item-info">
                                        <span>Điện thoại:</span> <?php echo $item->telephone; ?>
                                    </div>
                                    <div class="item-info">
                                        <span>Fax:</span> <?php echo $item->fax; ?>
                                    </div>
                                    <div class="item-info item-info-email">
                                        <span>Email:</span> <?php echo $item->email; ?>
                                    </div>
                                    <div class="item-info">
                                        <span>Website:</span> 
                                        <a class="" href="http://<?php echo $item->source_website; ?>" target="_blank" title="<?php echo $item -> title ?>">
                                            <?php echo $item->source_website; ?>
                                        </a>
                                    </div>
                					<div class="item-info">
                                        <span>Lĩnh vực sản xuất:</span> 
                                        <a href="<?php echo $link_cat; ?>" title="<?php echo $item -> category_name;?>"><?php echo $item -> category_name;?></a>
                                    </div>
                                </div><!-- END: .newslist-item-content -->
                            </div><!--  END: .newslist-item -->
            		<?php	} ?>
            	<?php } ?>
            </div>
            <div class="clearfix"></div>
            
            <?php if($pagination) echo $pagination->showPagination(3);?>
        </div>
	</div><!-- END: .newslist -->
</aside><!-- END: .news_cat -->