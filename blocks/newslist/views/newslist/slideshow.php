<?php
    global $tmpl;
    $tmpl -> addStylesheet('jcarousel.responsive', 'blocks/newslist/assets/css');
    $tmpl -> addScript('jquery.jcarousel.min','blocks/newslist/assets/js');
    $tmpl -> addStylesheet('slideshow','blocks/newslist/assets/css');
    $tmpl -> addScript('slideshow','blocks/newslist/assets/js');
?>
<div class="container">
    <div id="news-slide">
        <div class="jcarousel-wrapper">
            <div class="jcarousel list-item" data-jcarousel="true">
                <ul id="list-address-view">
                    <?php  for ($i=0;$i<count($list); $i++  ){
                        $item = $list[$i];
                        $link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item->category_alias);
                        $image_resized = URL_ROOT.str_replace('/original/', '/large/', $item->image);
                    ?>
                    <li class="item item-small box-shadow">
                        <div class="image-preview">
                            <a href="<?php echo $link;?>" title="<?php echo $item-> title;?>"><img src="<?php echo $image_resized;?>" alt="<?php echo $item->title;?>" /></a>
                        </div>
                        <div class="title">
                            <a class="name" title="<?php echo $item->title;?>" href="<?php echo $link;?>"><?php echo $item->title;?></a>
                            <div class="fb-like" data-href="<?php echo $link;?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                            <p class="summary"><?php echo $item -> summary;?></p>
                            <a class="detail" title="Xem tư vấn" href="<?php echo $link;?>"><?php echo FSText::_('Xem chi tiết'); ?></a>
                        </div>
                    </li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <a href="#" class="jcarousel-control-prev" data-jcarouselcontrol="true"></a>
        <a href="#" class="jcarousel-control-next" data-jcarouselcontrol="true"></a>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=930343043734339";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
