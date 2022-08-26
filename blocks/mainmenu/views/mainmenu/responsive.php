<?php
    global $tmpl,$config;
    $tmpl -> addStylesheet('responsive','blocks/mainmenu/assets/css');
    $tmpl -> addScript('responsive','blocks/mainmenu/assets/js');
    $url_current = $_SERVER['REQUEST_URI'];
    $url_current = substr(URL_ROOT, 0, strlen(URL_ROOT)-1).$url_current;
?>


<div id="menu-new-click">
<a class="logo" href="<?php echo URL_ROOT ?>"><img src="/images/responsive_logo.jpg" alt=""></a>
<a href="javascript:void(0);" style="font-size:30px;" class="icon click-show" data-id ="myTopnav">&#9776;</a>
<div class="topnav" id="myTopnav">
    <?php
      $Itemid  = FSInput::get('Itemid',1,'int');
      $total = count($list);
      $i = 0;
      $count_children = 0;
      $summner_children = 0;
      foreach ( $list as $item ) {

                $link = $item ->link? FSRoute::_($item ->link):'';
                $class = '';
                if($link == $url_current){
                    $class = 'active';
                }
        if($i == ($total -1))
            $class .= ' last-item';
        $count_children ++;
        if($count_children == $summner_children && $summner_children)
           $class .= ' last-item';
        echo "<a href='".$link."' >".$item -> name."</a>";

        $i ++;
      }
      ?>
     <?php if($tmpl->count_block('menu_log_responsive')) {?>
        <?php  echo $tmpl -> load_position('menu_log_responsive','XHTML2'); ?>
    <?php } ?>
</div>
</div>
