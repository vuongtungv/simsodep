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
$page = FSInput::get('page','1','int');
$page = $page ? $page:1; 
$limit = FSInput::get('limit','50','int');
$i = ($page-1)*$limit;
?>

    <!-- limit view all -->
    <div class="view-all-sims">
        <h1 class="name-header-ls"><?php echo $ber ?></h1>
        <div class="bg-head">
            <h2 class="title" id="id-filter"><span>Bộ lọc</span></h2>
            <div class="show-pagination">
                <input type="hidden" id="selected-pagination" name="select-pagination">
                <div class="show-value">
                    <span>Sắp sếp: </span>
                    <select name="" id="" class="select_location <?php echo $param['order']?>">
                        <?php foreach ($this->sort_arr as $key => $value) {?>
                                <?php 

                                    $check = '';
                                    $param['order'] = $key;
                                    if ( $key == @$order) {
                                         unset($param['order']);
                                        $check = 'selected';
                                    }
                                    $link = FSRoute::addPram($param,$url);

                                ?>
                                <option <?php echo $check ?> value="<?php echo $link ?>"><?php echo $value ?></option>
                        <?php } ?>

                    </select>
<!--                    <img src="images/icon_down.jpg" alt="">-->
                </div>
            </div>
        </div>


        <table class="table-list">
            <?php  foreach ($list as $value) {
                $item = $value['_source'];
                $cat_name = explode(',', $item['cat_name']);
                $cat_name = $cat_name[0];
                $i++;
                $exit_cart = 'no_cart';
                if (in_array($item['number'], @$_SESSION['arr_cart']))
                    $exit_cart = 'exit_cart';
                if ($name_cat) 
                $cat_name = $name_cat->name;
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
                        <img class="<?php echo $exit_cart ?> scart" src="/templates/mobile/images/icon_has_cart.png" alt="">
                        <!--                        <img data="--><?php //echo $exit_cart ?><!--" src="--><?php //echo URL_ROOT ?><!--templates/mobile/images/icon-dot-detail.png" alt="">-->
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
                                    <div class="td" style="width:10%" class="stt">
                                        <a class="sim-num stt_sim"><?php echo $i ?></a>
                                    </div>
                                    <div class="td" style="width:40%" class="body-i">
                                        <p class="sim-num"><?php echo $item['sim'] ?></p>
                                        <p class="sim-net"><?php echo $item['network'] ?></p>
                                        <p class="sim-type"><?php echo $cat_name ?></p>
                                    </div>
                                    <div class="td" style="width:40%" cclass="body-i">
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

        <?php if($pagination) echo $pagination->mshowPagination(1); ?>
    </div>

    <div class="filter-show">
        <div class="body">
            <div class="header-bor close-pup">
                <img  class="img-close" src="<?php echo URL_ROOT?>/templates/mobile/images/img_svg/thanh_toan/close.svg" alt="">
                <a href="#" class="btn-completed">Hoàn tất</a>
            </div>
<!--             <div class="box-sort-price">
                <span class="title-sort">Sắp xếp giá</span>
                <span class="title-sim-type">Tăng dần</span>
                <label class="switch">
                    <input type="checkbox">
                    <span class="slider round"></span>
                </label>
            </div> -->
            <?php echo $tmpl->load_direct_blocks('filter', array('style' => 'mfilter','url' => $url)); ?>
            <!--<p class="detal">Mọi thắc mắc và vấn đề phát sinh, quý khách vui lòng liên hệ với bộ phận chăm sóc khách hàng hoặc đến trực tiếp cửa hàng để nhận được sự hỗ trợ tốt nhất. Xin cảm ơn quý khách!</p>-->
        </div>
    </div>


    <!-- SEO HOME-->
    <div class="seo-home">
        <div class="scroll-y">
            <?php echo @$content ? $content : $config['reviews_sim']?>
        </div>
    </div>
    <!-- NEW HOME -->
    <div class="new-home">
        <div class="header-new">
            <h4 class="title-card"><a href="index.php?module=news&view=home&Itemid=2" class="news-all">Tin tức sim số đẹp</a></h4>
        </div>
        <?php echo $tmpl->load_direct_blocks('newslist', array('style' => 'index_mobile','type' => 'home','limit' =>'4')); ?>
    </div>
