<?php
    global $tmpl,$user;
    $tmpl -> addStylesheet("default","blocks/log/assets/css");
    
    //$//url = $_SERVER['REQUEST_URI'];
//    $redirect = base64_encode($url);
//    $Itemid = FSInput::get('Itemid',1,'int');
//    $view = FSInput::get('view');
//    
//    $url_current = $_SERVER['REQUEST_URI'];
//    $url_current = substr(URL_ROOT, 0, strlen(URL_ROOT)-1).$url_current;
    $userInfo = $user->userInfo;
?>
<div id="log" class="nav-log fl-right">
	<a class="logname"  href="<?php echo FSRoute::_('index.php?module=users&task=user_info&Itemid=5') ?>" >
        <i class="fa fa fa-user-o"></i>
        <span><?php echo $userInfo->username; ?></span>
    </a>
</div>
