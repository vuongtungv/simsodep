<?php
global $tmpl;
$tmpl -> addScript('megamenu','blocks/mainmenu/assets/js');
$tmpl -> addScript('megamenu-mobile','blocks/mainmenu/assets/js');
$tmpl -> addStylesheet('styles','blocks/mainmenu/assets/css');
$tmpl -> addStylesheet('menu-mobile','blocks/mainmenu/assets/css');
$lang = FSInput::get('lang');
$Itemid = FSInput::get('Itemid');
?>
<nav class="nav-menu">
    <ul class="menu_mobile">
        <?php $i = 0;?>
        <?php foreach($level_0 as $key=> $item):?>
            <?php $link = $item -> link? FSRoute::_($item -> link):''; ?>
            <?php $class = 'level_0';?>
            <?php $class .= $item -> description ? ' long ': ' sort' ?>
            <?php if($arr_activated[$item->id]) $class .= ' activated ';?>
            <li class="has-child" id="heading<?php echo $i;?>">
                <?php
                // kiểm tra xem có menu cấp 2 ko
                if(isset($children[$item -> id]) && count($children[$item -> id])  ){
                    $class_a = '';
                }else{
                    $class_a = 'a-block';
                }
                ?>
                <a <?php if($link) echo "href=\"$link\"";?> id="menu_item_<?php echo $item->id;?>" class="<?php echo $class_a?>" title="<?php echo htmlspecialchars($item -> name);?>">
                    <?php echo $item -> name;?>
                </a>
                <!--	LEVEL 1			-->
                <?php if(isset($children[$item -> id]) && count($children[$item -> id])  ){?>
                <button class="icon-down-lv-1 icon-down button-level-1" data-toggle="collapse" data-target="#collapse<?php echo $i;?>" aria-expanded="false" aria-controls="collapse<?php echo $i?>">
                    <!--                <i class="fa fa-angle-down" aria-hidden="true"></i>-->
                    <!--                <img src="/templates/mobile/images/down-icon.png" alt="">-->
                </button>
                <div id="collapse<?php echo $i;?>" class=" collapse level2" aria-labelledby="heading<?php echo $i;?>" data-parent="#accordion">
                    <ul class="<?php if($item->id == 156) echo 'scroll-y scroll-y-me' ?> ul-level-1 ul-show-level-2">
                        <?php }?>
                        <?php if(isset($children[$item -> id]) && count($children[$item -> id])  ){?>
                            <?php $j = 0;?>
                            <?php foreach($children[$item -> id] as $key=>$child){?>
                                <?php $link = $child -> link? FSRoute::_($child -> link):''; ?>
                                <li id="heading_lv2<?php echo $i;?>" class='li_lv1 sub-menu-level1 <?php if($arr_activated[$child->id]) $class .= ' activated ';?> '>
                                    <a href="<?php echo $link; ?>" class="sub-menu-item" id="menu_item_<?php echo $child->id;?>" title="<?php echo htmlspecialchars($child -> name);?>">
                                        <?php echo $child -> name;?>
                                    </a>
                                    <!--	LEVEL 2			-->
                                    <?php if(isset($children[$child -> id]) && count($children[$child -> id])  ){?>
                                        <button class="icon-down icon-down-lv2 button-level-2" data-toggle="collapse collapse_lv2" data-target="#collapse_lv2<?php echo $child->id;?>" aria-expanded="false" aria-controls="collapse_lv2<?php echo $child->id?>">
                                            <!--                                        <i class="fa fa-angle-down" aria-hidden="true"></i>-->
                                        </button>
                                        <div id="collapse_lv2<?php echo $child->id;?>" class="collapse collapse_level3" aria-labelledby="heading_lv2<?php echo $child->id;?>" data-parent="#">
                                            <ul id="<?php echo $child->id ?>" class="level-3">
                                                <?php foreach($children[$child -> id] as $key=>$child2){?>
                                                    <?php $link2 = $child2 -> link? FSRoute::_($child2 -> link):''; ?>
                                                    <li class='sub-menu-level<?php echo $child->level;?> <?php if($arr_activated[$child->id]) $class .= ' activated ';?> '>
                                                        <?php if($link2==''){?>
                                                            <span class="<?php echo $class?> sub-menu-item span-child" id="menu_item_<?php echo $child->id;?>" title="<?php echo htmlspecialchars($child2 -> name);?>">
                                                            <?php echo $child2 -> name;?>
                                                        </span>
                                                        <?php }else{?>
                                                            <a style="display: block;" href="<?php echo FSRoute::_($link2); ?>" class="<?php echo $class?> sub-menu-item" id="menu_item_<?php echo $child->id;?>" title="<?php echo htmlspecialchars($child2 -> name);?>">
                                                                <?php echo $child2 -> name;?>
                                                            </a>
                                                        <?php }?>
                                                        <!--	LEVEL 3			-->
                                                        <?php if(isset($children[$child2 -> id]) && count($children[$child2 -> id])){?>
                                                            <ul id="<?php echo $child2->id ?>" class="level-4">
                                                                <?php foreach($children[$child2 -> id] as $key=>$child3){?>
                                                                    <?php $link3 = $child3 -> link? FSRoute::_($child3 -> link):''; ?>
                                                                    <li class='sub-menu-level<?php echo $child3->level;?> <?php if($arr_activated[$child->id]) $class .= ' activated ';?> '>
                                                                        <a style="display: block;" href="<?php echo FSRoute::_($link3); ?>" class="<?php echo $class?> sub-menu-item" id="menu_item_<?php echo $child->id;?>" title="<?php echo htmlspecialchars($child3 -> name);?>">
                                                                            <?php echo $child3 -> name;?>
                                                                        </a>
                                                                    </li>
                                                                <?php }?>
                                                                <div class="clearfix"></div>
                                                            </ul>
                                                        <?php }?>
                                                    </li>
                                                <?php }?>
                                            </ul>
                                        </div>
                                    <?php }?>
                                </li>
                                <?php $j++;?>
                            <?php }?>
                        <?php }?>
                        <?php if(isset($children[$item -> id]) && count($children[$item -> id])  ){?>
                    </ul>
                </div>
            <?php }?>
            </li>
            <?php $i ++; ?>
        <?php endforeach;?>

        <!--	CHILDREN				-->
    </ul>
</nav>


<script type="text/javascript">
    $(document).ready(function () {
        $('.icon-down-lv2').click(function () {
            $(this).parent().find('.collapse_level3').toggle(300);
        });
    });
</script>