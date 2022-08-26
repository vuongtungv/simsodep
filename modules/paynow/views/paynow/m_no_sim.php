	<?php 

    global $config,$tmpl,$user;
    
    $Itemid = FSInput::get('Itemid', 1, 'int');
    $lang = FSInput::get('lang');
    $logo = URL_ROOT.$config['logo'];

    $tmpl -> addScript('templates','templates/mobile/js');
    $tmpl -> addScript('link_searchFull','templates/mobile/js');
    $tmpl -> addScript('sim_all','templates/mobile/js');
    $tmpl -> addScript('jquery.mCustomScrollbar.concat.min','templates/mobile/js');

    $tmpl->addStylesheet('sim_all','templates/mobile/css');
    $tmpl->addStylesheet('jquery.mCustomScrollbar','templates/mobile/js/');
    $tmpl->addStylesheet('font-awesome','templates/mobile/scss/font-awesome/css');
    $tmpl ->addStylesheet('pop_add_cart','templates/mobile/css');


	$tmpl -> addStylesheet('m-no-sim','modules/paynow/assets/css');
	$tmpl -> addScript('simtheonhamang','modules/search/assets/js');
    $tmpl->addScript('add_cart','modules/sim_network/assets/js');
    $page = FSInput::get('page','1','int');
	$limit = FSInput::get('limit','50','int');
    $i = ($page-1)*$limit;
	?>
<!--List sim-->
<div class="m-no-sim-fuild">
    <div class="no-sim">
        <h1 class="title">* Số sim <b><?php echo $sim ?></b> đã bán hoặc chưa cập nhật lên website</h1>
        <div class="des-no-sim">
            <?php echo html_entity_decode($config['des_no_sim']) ?>
            <div class="tutorial">
                <h4>Hướng dẫn tìm kiếm sim số đẹp</h4>
                <p>- Tìm sim có số <span><?php echo substr( $sim, - 6) ?></span> hãy gõ <a target="_blank" href="<?php echo URL_ROOT.'tim-sim/'.substr( $sim, - 6).'.html' ?>"><?php echo substr( $sim, - 6) ?></a></p>
                <p>- Tìm sim có đầu <span><?php echo substr($sim,0,3) ?></span> đuôi <span><?php echo substr( $sim, - 6) ?></span> hãy gõ <a target="_blank"  href="<?php echo URL_ROOT.'tim-sim/'.substr($sim,0,3).'*'.substr( $sim, - 6).'.html' ?>"><?php echo substr($sim,0,3).'*'.substr( $sim, - 6) ?></a></p>
                <p>- Tìm sim có đầu bằng <span><?php echo substr($sim,0,6) ?></span> đuôi bất kỳ hãy gõ <a target="_blank"  href="<?php echo URL_ROOT.'tim-sim/'.substr($sim,0,6).'*.html' ?>"><?php echo substr($sim,0,6).'*' ?></a></p>
            </div>
        </div>
    </div>
    <div class="ex-no-sim">
        <h2 class="p-no-sim">Danh sách gần giống sim: <?php echo $sim ?></h2>

    <!-- limit view all -->
    <div class="view-all-sims">

        <table class="table-list">
            <?php  foreach ($list as $value) {
                $item = $value['_source'];
                $cat_name = explode(',', $item['cat_name']);
                $cat_name = $cat_name[0];
                $i++;
                $exit_cart = 'no_cart';
                if (in_array($item['number'], @$_SESSION['arr_cart']))
                    $exit_cart = 'exit_cart';
            ?>
            <?php $link = FSRoute::_('index.php?module=paynow&view=paynow&task=sim&sim='.$item['number']) ?>
            <tr>
                <td width="12%" class="stt"><?php echo $i ?></td>
                <td width="39%" class="body-i">
                    <a class="sim-num" href="<?php echo $link ?>"><?php echo $item['sim'] ?></a>
                    <p class="sim-net"><?php echo $item['network'] ?></p>
                    <p class="sim-type"><?php echo $cat_name ?></p>
                </td>
                <td width="39%" class="body-i">
                    <p class="price"><?php echo format_money($item['price_public'],' đ') ?></p>
                    <?php if(!@$item['price_old']){?>
                        <p class="point">Điểm: <span><?php echo $item['point'] ?></span></p>
                        <p class="knot">Nút: <span><?php echo $item['button'] ?></span></p>
                    <?php }else{?>
                        <p class="point" style="text-decoration: line-through"><?php echo format_money($item['price_old'],' đ')  ?></p>
                        <p class="point">Điểm: <span><?php echo $item['point'] ?></span></p>
                    <?php }?>
                </td>
<!--                 <td width="10%" class="detail">
                    <a href="#"><img src="<?php echo URL_ROOT ?>templates/mobile/images/icon-dot-detail.png" alt=""></a>
                </td> -->
                <td width="10%" class="detail">
                    <button class="w-modal md_cart_<?php echo $item['sim_id'] ?>" data-toggle="modal" data-target="#exampleModal<?php echo $i ?>">
                        <img class="<?php echo $exit_cart ?> scart" src="/templates/mobile/images/img_svg/trang_chu/cart_dot.svg" alt="">
                        <!--                        <img data="--><?php //echo $exit_cart ?><!--" src="--><?php //echo URL_ROOT ?><!--templates/mobile/images/img_svg/trang_chu/3dotgray.svg" alt="">-->
                        <div data="<?php echo $exit_cart ?>" class="dots-style">
                            <span class="dot-item grey"></span>
                            <span class="dot-item grey"></span>
                            <span class="dot-item grey"></span>
                        </div>
                    </button>
                </td>

                <!-- Modal -->
                <div class="modal fade modal-pop-add-cart" id="exampleModal<?php echo $i ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="show-pop-sim">
                                <div class="table-list">
                                    <div class="td" style="width:12%" class="stt"><a class="sim-num stt_sim"><?php echo $i ?></a></div>
                                    <div class="td" style="width:39%" class="body-i">
                                        <p class="sim-num"><?php echo $item['sim'] ?></p>
                                        <p class="sim-net"><?php echo $item['network'] ?></p>
                                        <p class="sim-type"><?php echo $cat_name ?></p>
                                    </div>
                                    <div class="td" style="width:39%" cclass="body-i">
                                        <p class="price"><?php echo format_money($item['price_public'],' đ')  ?></p>
                                        <p class="point">Điểm: <span><?php echo $item['point'] ?></span></p>
                                        <p class="knot">Nút: <span><?php echo $item['button'] ?></span></p>
                                    </div>

                                    <div class="td" style="width:10%" class="detail">
                                        <div class="td-dots-style dots-style">
                                            <span class="dot-item blue"></span>
                                            <span class="dot-item blue"></span>
                                            <span class="dot-item blue"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pop_mobile_add_cart">
                                <div class="detail-cart-show">
                                    <div class="redrect-cart add-cart-pay" >
                                        <span class="title-pop"><a href="<?php echo $link ?>">Thanh toán</a></span>
                                        <span class="title-pop">
                                            <a class="icart" href="<?php echo $link ?>"><img src="<?php echo URL_ROOT ?>templates/mobile/images/img_svg/small_menu/pay.svg" alt=""></a>
                                        </span>
                                    </div>
                                    <div style="display:<?php echo $exit_cart == 'exit_cart'?'none':'block'; ?>" class="redrect-cart div-add-cart<?php echo $item['sim_id'] ?>">
                                        <span class="title-pop" cart="no_cart" type="list" onclick="action_cart('<?php echo $item['number'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price_public'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>',this)">Thêm vào giỏ hàng</span>
                                        <span class="title-pop">
                                            <a cart="no_cart" type="list" href="javascript:void(0)" class="icon_add-cart add-cart icart" onclick="action_cart('<?php echo $item['number'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price_public'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>',this)" data-dismiss="modal">
                                                <img src="<?php echo URL_ROOT ?>templates/mobile/images/img_svg/small_menu/cart.svg" alt="">
                                            </a>
                                        </span>
                                    </div>
                                    <div style="display:<?php echo $exit_cart == 'no_cart'?'none':'block'; ?>" class="redrect-cart delete-sim<?php echo $item['sim_id'] ?>">
                                        <span class="title-pop color-carr" cart="exit_cart" type="list" onclick="action_cart('<?php echo $item['number'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price_public'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>',this)">Xóa sim khỏi giỏ hàng</span>
                                        <span class="title-pop">
                                            <a cart="exit_cart" type="list" href="javascript:void(0)" class="icart" onclick="action_cart('<?php echo $item['number'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price_public'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>',this)"><img src="<?php echo URL_ROOT ?>templates/mobile/images/img_svg/small_menu/delete.svg" data-dismiss="modal" alt=""></a>
                                        </span>
                                    </div>
                                    <p class="cancel-cart" data-dismiss="modal">
                                        Hủy
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<div class="bmd">
    <a class="m_sosim" href="<?php echo URL_ROOT.'tim-sim/*'.$key.'.html' ?>">Xem tất cả sim đuôi <?php echo $key ?></a>
</div>