<?php
    global $tmpl,$module;
     $tmpl -> addScript("default","blocks/cat/assets/js");
     $tmpl -> addStylesheet("default_mobile","blocks/cat/assets/css");

?>

<li class="has-child li-find-sim" id="heading2">
    <a>Tìm nhanh theo sim</a>
    <button style="position: absolute; width: 100%;top: -42px" class="icon-down-lv-1 icon-down button-show-find-sim" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
<!--        <i class="fa fa-angle-down" aria-hidden="true"></i>-->
    </button>
    <div id="collapse2" class="collapse level2" aria-labelledby="heading1" data-parent="#accordion">
        <div class="scroll-y scroll-y-me">
            <ul class="level_0">
                <?php foreach ($type_level_0 as $item) { if($item){
                    $link = URL_ROOT.$item->alias.'.html';
                    ?>
                    <li class="<?php foreach ($type_level_1 as $it_lev) {if ($item->id == $it_lev->parent_id) echo " has-child ";}?>">
                        <a href="<?php echo $link ?>">
                            <?php echo $item->name ?>
                        </a>
                        <div class="icon_down in-icon-click">
                            <button class="icon-drop">
                                <img src="/templates/mobile/images/cong-icon.png" alt="" class="img-change">
                            </button>
                            <ul class="level_1">
                                <?php
                                foreach ($type_level_1 as $level_1){
                                    if($level_1->parent_id == $item->id){
                                        $sublink = URL_ROOT.$item->alias.'/'.$level_1->alias.'.html';
                                        ?>
                                        <li><a href="<?php echo $sublink; ?>"><?php echo $level_1->name?></a></li>
                                    <?php }}?>
                            </ul>
                        </div>

                    </li>
                <?php } }?>
            </ul>
        </div>
    </div>
</li>