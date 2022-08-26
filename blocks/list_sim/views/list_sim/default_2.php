<?php
    global $tmpl; 
    $tmpl -> addScript('script','blocks/list_sim/assets/js');
?>
<style type="text/css" media="screen">
    .phone-number a.ldf2{
        color: #3478f7 !important;
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
    // var_dump($item);
    ?>
    <?php $link = FSRoute::_('index.php?module=paynow&view=paynow&task=sim&sim='.$item['number']) ?>
    <div class="item-phone">
        <p class="top">
            <span class="phone-number pull-left add-cart-pay" data-id="<?php echo $item->id?>">
                <a  onclick="update_cart('<?php echo $item['sim'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price_public'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>','<?php echo $link ?>')" class="ldf2" href="<?php echo $link ?>" title=""><?php echo $item['sim'] ?>
                </a>
            </span>
            <span class="phone-type pull-right">
                            <a cart="<?php echo $exit_cart ?>" class="icon_add-cart add-cart" type="block2" href="javascript:void(0)" title="<?php echo $exit_cart == 'no_cart'?'Thêm vào giỏ hàng':'Xóa khỏi giỏ hàng' ?>" class="" onclick="action_cart('<?php echo $item['number'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price_public'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>',this)">
                                <img src="<?php echo $exit_cart == 'no_cart'?'templates/default/images/img_svg/sim_theo_nha_mang/content_cart.svg':'templates/default/images/img_svg/sim_theo_nha_mang/content_cart_hover.svg' ?>" alt="">
                            </a>

                            <a class="pay_now_hover" href="<?php echo $link ?>" onclick="update_cart('<?php echo $item['sim'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price_public'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>','<?php echo $link ?>')" title="Mua ngay">
                                <img src="<?php echo URL_ROOT ?>templates/default/images/img_svg/sim_theo_nha_mang/content_pay.svg" alt="" class="img-no-hover">
                            </a>

                        </span>
        </p>
        <div class="clearfix"></div>
        <p class="bottom">
            <?php if($item['price_old'] != 0 && $item['price_old']) {?>
                <span class="price-old pull-left"><?php echo number_format($item['price_old'], 0, ',', '.')?> đ</span>
            <?php }else{?>
                <span class="pull-left txt-capitalize"><?php echo $cat_name ?></span>
            <?php }?>
            <span class="price-new pull-right"><?php echo number_format($item['price_public'], 0, ',', '.') ?> đ</span>
        </p>
        <div class="clearfix"></div>
    </div>
<?php }?>
