<?php
    global $tmpl;
    $tmpl -> addStylesheet('default','blocks/list_sim/assets/css');
    //$link_readmore =FSRoute::_("index.php?module=news&view=home");
?>

<?php
// testVar($list);
?>
<style type="text/css" media="screen">
    .phone-number a.ldf{
        color: #fff;
    }
</style>
<?php foreach ($list as $value){
    $item = $value['_source'];
    $cat_name = explode(',', $item['cat_name']);
    $cat_name = $cat_name[0];
    $i++;
    $exit_cart = 'no_cart';
    if (in_array($item['number'], @$_SESSION['arr_cart']))
        $exit_cart = 'exit_cart';
    ?> 
    <?php $link = FSRoute::_('index.php?module=paynow&view=paynow&task=sim&sim='.$item['number']) ?>
    <div class="col-md-4 item-phone">
        <p class="top">
            <span class="phone-number pull-left add-cart-pay">
                <a href="<?php echo $link ?>" onclick="update_cart('<?php echo $item['sim'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price_public'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>','<?php echo $link ?>')" class="ldf" title="<?php echo $item['sim'] ?>">
                    <?php echo $item['sim'] ?>
                </a>
            </span>
            <span class="phone-type pull-right"><?php echo $item['network'] ?></span>
        </p>
        <div class="clearfix"></div>
        <p class="bottom">
            <?php if($item['price_old'] != 0 && $item['price_old']) {?>
                <span class="price-old pull-left"><?php echo number_format($item['price_old'], 0, ',', '.')?> đ</span>
            <?php }else{?>
                <span class="pull-left txt-capitalize">
                    <?php echo $cat_name ?>
                </span>
            <?php }?>
            <span class="price-new pull-right"><?php echo number_format($item['price_public'], 0, ',', '.') ?> đ</span>
        </p>   
        <div class="clearfix"></div>
        <div class="action-phone">
            <span class="pull-left">
                <a type="block1" href="javascript:void(0)" class="" cart="<?php echo $exit_cart ?>" onclick="action_cart('<?php echo $item['number'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price_public'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>',this)" title="<?php echo $exit_cart == 'no_cart'?'Thêm vào giỏ hàng':'Xóa khỏi giỏ hàng' ?>">
                        <?php echo $exit_cart == 'no_cart'?'Thêm vào giỏ hàng':'Xóa khỏi giỏ hàng' ?>
                </a>
            </span>
            <span class="pull-right view-other">
                <a class="" href="<?php echo $link ?>" onclick="update_cart('<?php echo $item['sim'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price_public'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>','<?php echo $link ?>')" title="Mua ngay">Mua ngay</a>
<!--                <img style="margin-top: -2px; margin-left: 2px;" src="--><?php //echo URL_ROOT?><!--/templates/default/images/img_svg/trangchu/xemthem_muangay_arrow.svg" alt=""></i>-->
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </span>
        </div>
    </div>
<?php }?>

