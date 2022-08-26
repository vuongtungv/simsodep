<?php
global $config,$tmpl,$user;
$Itemid = FSInput::get('Itemid', 1, 'int');
$lang = FSInput::get('lang');
$logo = URL_ROOT.$config['logo'];
//    $tmpl->addStylesheet('font-awesome.min', 'libraries/font-awesome/css');
$tmpl -> addScript('templates');
$tmpl -> addScript('tem2');
$tmpl -> addScript('jquery.mCustomScrollbar.concat.min');
//    $tmpl -> addScript('jquery.mCustomScrollbar.concat.min');
$tmpl -> addScript('js_scrollBar');
$tmpl->addStylesheet('jquery.mCustomScrollbar');
$tmpl->addStylesheet('font-awesome');
$tmpl->addStylesheet('css_scroll');
?>
<?php
   switch($Itemid){
       case '31':
           include 'main_info.php';
           break;
       default:
           include 'main.php';
           break;
   }
?>
<input type="hidden" id="root" value="<?php echo URL_ROOT ?>">
<?php include 'notification.php'; // thong bao?>
