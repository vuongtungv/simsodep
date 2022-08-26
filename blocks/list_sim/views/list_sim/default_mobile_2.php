

<?php foreach ($list as $value){
    $item = $value['_source'];
    $cat_name = explode(',', $item['cat_name']);
    $cat_name = $cat_name[0];
    $i++;
    $exit_cart = 'no_cart';
    if (in_array($item['number'], @$_SESSION['arr_cart']))
        $exit_cart = 'exit_cart';
    ?> 
    <div class="col-md-6 item">
    <div class="top">
        <p class="phone"><a href="<?php echo $link ?>"><?php echo $item['sim'] ?></a></p>
        <p class="name-net"><?php echo $item['network'] ?></p>
        <a class="icon_add-cart add-cart " href="javascript:void(0)" class="" cart="<?php echo $exit_cart ?>" onclick="action_cart('<?php echo $item['number'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price_public'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>',this)">
            <img src="<?php echo URL_ROOT?>/templates/mobile/images/img_svg/trang_chu/Cart.svg" alt="">
        </a>
    </div>
    <div class="bottom">
        <p class="price-new"><?php echo number_format($item['price_public'], 0, ',', '.') ?> đ</p>

        <?php if($item['price_old'] != 0 && $item['price_old']) {?>
           <p class="price-old"><?php echo number_format($item['price_old'], 0, ',', '.')?> đ</p>
        <?php }else{?>
            <p class="sim-type txt-capitalize">
                <?php echo $cat_name ?>
            </p>
        <?php }?>

        <a class="add-cart-pay" href="<?php echo $link ?>" onclick="update_cart('<?php echo $item['sim'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price_public'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>','<?php echo $link ?>')" title="Mua ngay">
            <img src="<?php echo URL_ROOT?>/templates/mobile/images/img_svg/trang_chu/pay.svg" alt="">
        </a>
    </div>
</div>
<?php }?>