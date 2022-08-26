<?php 
    global $config,$tmpl;
    $lang = FSInput::get('lang');
    //$tmpl -> addStylesheet('default','blocks/fanpage_facebook/assets/css');
?>

<?php if($config['link_fanpage']){ ?>
<div class="col-fanpage fl-left">
    <h4 class="intro-face mbs"><?php echo FSText::_('like để gia nhập cộng đồng ketnoigiaoduc'); ?></h4>
    <div class="fb-page" data-href="<?php echo $config['link_fanpage'] ?>" data-width="374" data-height="150" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"></div>
</div><!-- END: .col-fanpage -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/<?php echo $lang=='vi'? 'vi_VN':'en_EN'; ?>/sdk.js#xfbml=1&version=v2.6&appId=676651149130836";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php } ?>
