	<?php 
	global $tmpl,$config; 
	$tmpl -> addStylesheet('simtheonhamang','modules/search/assets/css');
	// $tmpl -> addScript('simtheonhamang','modules/search/assets/js');
    $tmpl->addScript('add_cart','modules/sim_network/assets/js');
    $page = FSInput::get('page','1','int');
	$limit = FSInput::get('limit','50','int');
    $i = ($page-1)*$limit;
	?>
<!--List sim-->
<div class="container list-sim">
    <div class="no-sim">
        <h1 class="title">Số sim <b><?php echo $sim ?></b> đã bán hoặc chưa cập nhật lên website</h1>
        <div class="des-no-sim">
            <?php echo html_entity_decode($config['des_no_sim']) ?>
            <div class="tutorial">
                <h4>Hướng dẫn tìm kiếm sim số đẹp</h4>
                <p><i class="fa fa-circle" aria-hidden="true"></i> Tìm sim có số <span><?php echo substr( $sim, - 6) ?></span> hãy gõ <a target="_blank" href="<?php echo URL_ROOT.'tim-sim/'.substr( $sim, - 6).'.html' ?>"><?php echo substr( $sim, - 6) ?></a></p>
                <p><i class="fa fa-circle" aria-hidden="true"></i> Tìm sim có đầu <span><?php echo substr($sim,0,3) ?></span> đuôi <span><?php echo substr( $sim, - 6) ?></span> hãy gõ <a target="_blank"  href="<?php echo URL_ROOT.'tim-sim/'.substr($sim,0,3).'*'.substr( $sim, - 6).'.html' ?>"><?php echo substr($sim,0,3).'*'.substr( $sim, - 6) ?></a></p>
                <p><i class="fa fa-circle" aria-hidden="true"></i> Tìm sim có đầu bằng <span><?php echo substr($sim,0,6) ?></span> đuôi bất kỳ hãy gõ <a target="_blank"  href="<?php echo URL_ROOT.'tim-sim/'.substr($sim,0,6).'*.html' ?>"><?php echo substr($sim,0,6).'*' ?></a></p>
            </div>
        </div>

        <div class="ex-no-sim">
            <h2 class="pal-no-sim">Danh sách gần giống sim: <?php echo $sim ?></h2>
            <a href="<?php echo URL_ROOT.'tim-sim/*'.$key.'.html' ?>">Xem tất cả sim đuôi <?php echo $key ?> <i class="fa fa-angle-right" aria-hidden="true"></i></a>
        </div>
    </div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th width="6%"><div class="border-right">STT</div></th>
            <th width="20%">
                <div class="border-right">
                    Số sim
                </div>
            </th>
            <th width="20%">
                <div class="border-right">
                    <span>Giá</span>
                    <!-- Rounded switch -->
<!--                     <label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                    </label> -->
                </div>
            </th>
            <th width="16%"><div class="border-right">Nhà mạng</div></th>
            <th width="23%">
                <div class="border-right">
                    <!--Thể loại <img src="images/cham.png" alt="">-->
                    <div class="show-sim-type">
                        <input type="hidden" id="selected-type-sim" name="select-type-sim">
                        <div class="show-value">
                            <span>
                                Thể loại
                                <!--                                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>-->
                            </span>
                        </div>
                    </div>
                </div>
            </th>
            <th width="10%"><div class="border-right">Điểm</div></th>
            <th width="10%"><img src="/templates/default/images/img_svg/sim_theo_nha_mang/bar_cart.svg" alt=""></th>
            <th width="7%"><img style="margin-top: 3px;" src="/templates/default/images/img_svg/sim_theo_nha_mang/bar_pay.svg" alt=""></th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach ($list as $value) {
            $item = $value['_source'];
            $cat_name = explode(',', $item['cat_name']);
            $cat_name = $cat_name[0];
            $i++;
            $exit_cart = 'no_cart';
            if (in_array($item['number'], @$_SESSION['arr_cart']))
                $exit_cart = 'exit_cart';
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $item['sim'] ?></td>
                <td>
                    <?php if($item['price_old']) {?>
                        <p class="price-new"><?php echo format_money($item['price_public'],' đ');?></p>
                        <p class="price-old"><?php echo format_money($item['price_old'],' đ');?></p>
                    <?php }else{?>
                    <?php echo format_money($item['price_public'],' đ');  }?>
                </td>
                <td><?php echo $item['network'] ?></td>
                <td><?php echo $cat_name ?></td>
                <td><?php echo $item['point'] ?></td>
                <td class="cart-no-hover">
                    <a cart="<?php echo $exit_cart ?>" class="<?php echo $exit_cart ?>" type="list" href="javascript:void(0)" title="<?php echo $exit_cart == 'no_cart'?'Thêm vào giỏ hàng':'Xóa khỏi giỏ hàng' ?>" class="" onclick="action_cart('<?php echo $item['number'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>',this)">
                        <img src="<?php echo $exit_cart == 'no_cart'?URL_ROOT.'/templates/default/images/img_svg/sim_theo_nha_mang/content_cart.svg':URL_ROOT.'templates/default/images/img_svg/sim_theo_nha_mang/content_cart_hover.svg' ?>" class="img-no-hover">
                    </a>
                </td>
                <td>
                    <?php $link = FSRoute::_('index.php?module=paynow&view=paynow&task=sim&sim='.$item['number']) ?>
                    <a class="pay_now_hover" href="<?php echo $link ?>" onclick="update_cart('<?php echo $item['number'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>','<?php echo $link ?>')" title="Mua ngay">
                        <img style="margin-top: 5px" src="<?php echo URL_ROOT ?>/templates/default/images/img_svg/sim_theo_nha_mang/content_pay.svg" alt="" class="img-no-hover">
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php if (@$pagination) { ?>
        <?php echo $pagination->showPagination(3); ?>
    <?php } ?>
</div>