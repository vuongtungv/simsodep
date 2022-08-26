<?php
    global $tmpl,$module;
     $tmpl -> addScript("default","blocks/cat/assets/js");

?>

<div class="quick-filter quick-filter-type">
    <h2 class="title-hea">Tìm nhanh theo loại</h2>
    <ul class="level_0">
        <?php foreach ($type_level_0 as $item) { if($item){
            $link = URL_ROOT.$item->alias.'.html';
            ?>
            <li class="<?php foreach ($type_level_1 as $it_lev) {if ($item->id == $it_lev->parent_id) echo " has-child ";}?>">
                <a href="<?php echo $link ?>">
                    <?php echo $item->name ?>
                </a>
                <div class="icon_down">
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
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

<style>
    .level_0 .has-child{
        position: relative;
    }
    .level_1{
        position: absolute;
        background: #FFFFFF;
        /*border-radius: 5px;*/
        padding: 5px 5px 5px 10px;
        top: 26px;
        display: none;
        z-index: 99;
        width: 183px;
        left: -109px;    
        cursor: pointer;
        top: 26px;
        box-shadow: 0px 0px 6px 0 rgba(0,0,0,0.4);
    }
    .level_1 li{
        list-style: none;
    }
    .icon_down{
        display: none;
        position: absolute;
        right: 35px;
        top: 1px;
        cursor: pointer;
        height: 26px;
    }
    .icon_down i{
        padding-top: 5px;
        display: none;
    }
    .icon_down:hover .level_1{
        display: block !important;
    }
    .has-child .icon_down{
        display: initial;
    }
    .has-child:hover .level_1{
        display: block !important;
    }
</style>