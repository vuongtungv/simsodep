<?php
global $tmpl,$config;
// $tmpl -> addStylesheet('home','modules/sim_network/assets/css');
$tmpl -> addStylesheet('simtheonhamang','modules/search/assets/css');
$tmpl->addScript('add_cart','modules/sim_network/assets/js');
$total = count($list);
$Itemid = 7;
$page = FSInput::get('page','1','int');
$limit = FSInput::get('limit','50','int');
$i = ($page-1)*$limit;
$a = FSInput::get('order');

FSFactory::include_class('fsstring');
//echo 111; die;
?>
<input type="hidden" id="url_root" value="<?php echo URL_ROOT?>">
<input type="hidden" id="module" value="<?php echo FSInput::get('module')?>">

<!--List sim-->
<div class="container list-sim">
    <div class="show-pagination">
        <input type="hidden" id="selected-pagination" name="select-pagination">
        <div class="header-list-sim">
            <h3 class="name-header-ls"><span><?php echo $title_net ?></span></h3>
            <div class="show-value">
                <span>Sắp xếp: </span> <strong class="value-pagination"><?php echo @$order_name ?></strong>&nbsp;&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i>
            </div>
        </div>
        <div class="select-dropdown-icon">
            <!--<i class="fa fa-angle-down" aria-hidden="true"></i>-->
        </div>
        <div class="options" style="display: none;">

            <?php foreach ($this->sort_arr as $key => $value) {?>
                <div class="option custom-checkbox" value="random" data-placement="bottom" data-toggle="tooltip" data-original-title="" title="">
                    <?php 

                        $check = '';
                        $param['order'] = $key;
                        if ( $key == @$order) {
                             unset($param['order']);
                            $check = 'checked';
                        }
                        $link = FSRoute::addPram($param,$url);

                    ?>
                    <a class="custom-control-label <?php if($check == '' && $key=='random' && ($a=='random'||$a=='' )){echo 'checked';}else{ echo $check;} ?>" href="<?php echo $link ?>"><?php echo $value ?></a>
                </div>                
            <?php } ?>

        </div>
    </div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th width="6%"><div class="border-right">STT</div></th>
            <th width="20%">
                <div class="border-right numbersim2">
                    <div class="show-sim-head">
                        <input type="hidden" id="show-sim-head" name="show-sim-head">
                        <div class="show-value">
                            <p class="p-dots">
                                Đầu số
                                <span class="img_dotss"></span>
                            </p>
                        </div>
                        <div class="options" style="display: none;">
                            <div class="scroll-y">
                                <?php 
                                    $check = '';
                                    if ($order) {
                                        $param['order']= $order;
                                    }else{
                                        unset($param['order']);
                                    }

                                    if (!$param['header']) {
                                        $check = 'checked';
                                    }

                                    unset($param['header']);

                                    $link = FSRoute::addPram($param,$url);
                                ?>

                                    <div data="<?php echo $link ?>"  class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
                                        <input <?php echo $check ?> type="checkbox" class="custom-control-input" id="headall">
                                        <label class="custom-control-label" for="headall">
                                            <p class="phone">Tất cả</p>
                                        </label>
                                    </div>

                                <?php 
                                    $check = '';
                                    if ($order) {
                                        $param['order']= $order;
                                    }else{
                                        unset($param['order']);
                                    }


                                    $param['header']= 'new';

                                    if ($header == 'new') {
                                         unset($param['header']);
                                        $check = 'checked';
                                    }
                                    $link = FSRoute::addPram($param,$url);
                                ?>
                                    <div data="<?php echo $link ?>"  class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
                                        <input <?php echo $check ?> type="checkbox" class="custom-control-input" id="typemoi">
                                        <label class="custom-control-label" for="typemoi">
                                            <p class="phone">Đầu số mới</p>
                                        </label>
                                    </div>
                                <?php 
                                    $check = '';
                                    if ($order) {
                                        $param['order']= $order;
                                    }else{
                                        unset($param['order']);
                                    }


                                    $param['header']= 'old';

                                    if ($header == 'old') {
                                         unset($param['header']);
                                        $check = 'checked';
                                    }
                                    $link = FSRoute::addPram($param,$url);
                                ?>
                                    <div data="<?php echo $link ?>"  class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
                                        <input <?php echo $check ?> type="checkbox" class="custom-control-input" id="typecu">
                                        <label class="custom-control-label" for="typecu">
                                            <p class="phone">Đầu số Cũ</p>
                                        </label>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </th>

            <th width="20%">
                <div class="border-right numbersim3">
                    <div class="show-sim-price">
                        <input type="hidden" id="show-sim-price" name="show-sim-price">
                        <div class="show-value">
                            <p class="p-dots ">
                                Giá bán
                                <span class="img_dotss"></span>
                            </p>
                        </div>
                        <div class="options options-befa-network" style="display: none;">
                            <div class="scroll-y">
                                <?php 
                                    $check = '';

                                    if ($order) {
                                        $param['order']= $order;
                                    }else{
                                        unset($param['order']);
                                    }

                                    if ($header) {
                                        $param['header']= $header;
                                    }else{
                                        unset($param['header']);
                                    }

                                    if (!$param['price']) {
                                        $check = 'checked';
                                    }
                                    unset($param['price']);
                                    $link = FSRoute::addPram($param,$url);
                                 ?>

                                    <div data="<?php echo $link ?>"  class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
                                        <input <?php echo $check ?> type="checkbox" class="custom-control-input" id="priceall">
                                        <label class="custom-control-label" for="priceall">
                                            <p class="phone">Tất cả</p>
                                        </label>
                                    </div>
                                <?php foreach ($prices as $item) {
                                    $check = '';

                                    if ($order) {
                                        $param['order']= $order;
                                    }else{
                                        unset($param['order']);
                                    }

                                    if ($header) {
                                        $param['header']= $header;
                                    }else{
                                        unset($param['header']);
                                    }

                                    $param['price']= $item->id;

                                    if ($item->id == @$price) {
                                         unset($param['price']);
                                        $check = 'checked';
                                    }
                                    $link = FSRoute::addPram($param,$url);
                                    ?>
                                    <div data="<?php echo $link ?>"  class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
                                        <input <?php echo $check ?> type="checkbox" class="custom-control-input" id="type<?php echo $item->name ?>">
                                        <label class="custom-control-label" for="type<?php echo $item->name ?>">
                                            <p class="phone"><?php echo $item->title ?></p>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </th>
            <th width="16%">
                <div class="border-right numbersim3">
                    <div class="show-sim-price">
                        <input type="hidden" id="show-sim-price" name="show-sim-price">
                        <div class="show-value">
                            <p class="p-dots">
                                Nhà mạng
                            </p>
                        </div>
                    </div>
                </div>
            </th>
            <th width="23%">
                <div class="border-right numbersim5">
                    <!--Thể loại <img src="images/cham.png" alt="">-->
                    <div class="show-sim-type">
                        <input type="hidden" id="selected-type-sim" name="select-type-sim">
                        <div class="show-value">
                            <p class="p-dots">
                                Thể loại
                                <span class="img_dotss"></span>
                            </p>
                        </div>
                            <div class="options" style="display: none;">
                                <div class="scroll-y">
                                    
                                    <?php 
                                        $check = '';
                                        
                                        if ($order) {
                                            $param['order']= $order;
                                        }else{
                                            unset($param['order']);
                                        }
                                        
                                        if ($header) {
                                            $param['header']= $header;
                                        }else{
                                            unset($param['header']);
                                        }

                                        if ($price) {
                                            $param['price']= $price;
                                        }else{
                                            unset($param['price']);
                                        }

                                        if ($network) {
                                            $param['mang']= $network;
                                        }else{
                                            unset($param['mang']);
                                        }

                                        if (!$param['cat']) {
                                            $check = 'checked';
                                        }
                                        unset($param['cat']);
                                        $link = FSRoute::addPram($param,$url);
                                     ?>

                                        <div data="<?php echo $link ?>"  class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
                                            <input <?php echo $check ?> type="checkbox" class="custom-control-input" id="typeall">
                                            <label class="custom-control-label" for="typeall">
                                                <p class="phone">Tất cả</p>
                                            </label>
                                        </div>

                                    <?php foreach ($type as $item) {
                                        $check = '';
                                        if ($order) {
                                            $param['order']= $order;
                                        }else{
                                            unset($param['order']);
                                        }

                                        if ($header) {
                                            $param['header']= $header;
                                        }else{
                                            unset($param['header']);
                                        }

                                        if ($price) {
                                            $param['price']= $price;
                                        }else{
                                            unset($param['price']);
                                        }

                                        $param['cat']= $item->alias;
                                        if ($item->alias == @$cat) {
                                             unset($param['cat']);
                                            $check = 'checked';
                                        }
                                        $link = FSRoute::addPram($param,$url);
                                        ?>
                                        <div data="<?php echo $link ?>"  class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
                                            <input <?php echo $check ?> type="checkbox" class="custom-control-input" id="type<?php echo $item->name ?>">
                                            <label class="custom-control-label" for="type<?php echo $item->name ?>">
                                                <p class="phone"><?php echo $item->name ?></p>
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>


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

            if ($name_cat) 
                $cat_name = $name_cat->name;
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
                    <a cart="<?php echo $exit_cart ?>" class="<?php echo $exit_cart ?>" type="list" href="javascript:void(0)" title="<?php echo $exit_cart == 'no_cart'?'Thêm vào giỏ hàng':'Xóa khỏi giỏ hàng' ?>" class="" onclick="action_cart('<?php echo $item['number'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price_public'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>',this)">
                        <img src="<?php echo $exit_cart == 'no_cart'?'/templates/default/images/img_svg/sim_theo_nha_mang/content_cart.svg':'templates/default/images/img_svg/sim_theo_nha_mang/content_cart_hover.svg' ?>" class="img-no-hover">
                    </a>
                </td>
                <td>
                    <?php $link = FSRoute::_('index.php?module=paynow&view=paynow&task=sim&sim='.$item['number']) ?>
                    <a class="pay_now_hover" href="<?php echo $link ?>" onclick="update_cart('<?php echo $item['number'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price_public'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>','<?php echo $link ?>')" title="Mua ngay">
                        <img style="margin-top: 5px" src="<?php echo URL_ROOT ?>/templates/default/images/img_svg/sim_theo_nha_mang/content_pay.svg" alt="" class="img-no-hover">
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <?php if($pagination) echo $pagination->showPagination(); ?>
</div>


<div class="container content-home">
<!--    <img src="/templates/default/images/img_svg/trangchu/3dot.svg" alt="" class="content-home center_page">-->
    <div class="svg-dots">
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>
    <div class="reviews-sim">
        <div class="box-content">
            <div class="scroll-y">
                <?php echo @$content ? $content : $config['reviews_sim']?>
            </div>
        </div>
    </div>
    <div class="news-home">
        <div class="title">
            <h4 class="btn btn-primary">TIN TỨC SIM SỐ ĐẸP</h4>
            <span class="pull-right view-all"><a href="<?php echo FSRoute::_('index.php?module=news&view=home&Itemid=2')?>">Xem thêm</a>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span>
            <div class="clearfix"></div>
        </div>
        <div class="content-new">
            <?php echo $tmpl->load_direct_blocks('newslist', array('style' => 'home','type' => 'home','limit' =>'15')); ?>
        </div>
    </div>
</div>


<style>
    .select-first-sim::before{
        right: 50px;
    }
    .select-first-sim::after{
        right: 45px;
    }
    .select-type-sim::before{
        right: 55px;
    }
    .select-type-sim::after{
        right: 51px;
    }
</style>