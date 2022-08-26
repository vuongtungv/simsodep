	<?php 
	global $tmpl,$config; 
	$tmpl -> addStylesheet('simtheonhamang','modules/search/assets/css');
    $tmpl -> addStylesheet('home','modules/sim_network/assets/css');
	$tmpl -> addScript('simtheonhamang','modules/search/assets/js');
    $tmpl->addScript('add_cart','modules/sim_network/assets/js');
    $page = FSInput::get('page','1','int');
	$limit = FSInput::get('limit','50','int');
    $i = ($page-1)*$limit;
	?>
<!--List sim-->
<div class="container list-sim">
    <div class="show-pagination">
        <input type="hidden" id="selected-pagination" name="select-pagination">
        <div class="show-value"><span>Số lượng hiển thị: </span> <strong class="value-pagination">50 sim</strong>&nbsp;&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i></div>
        <div class="select-dropdown-icon">
            <!--<i class="fa fa-angle-down" aria-hidden="true"></i>-->
        </div>
        <div class="options" style="display: none;">
            <div class="option" value="0" data-placement="bottom" data-toggle="tooltip" data-original-title="" title="">
                80 sim
            </div>
            <div class="option" value="1" data-placement="bottom" data-toggle="tooltip" data-original-title="" title="">
                100 sim
            </div>
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
                        <span class="text-sort">Giá giảm dần</span>
                        <!-- Rounded switch -->
                        <label class="switch">
                            <input type="checkbox">
                            <span class="click-change slider round"></span>
                        </label>
                    </div>
                </th>
                <th width="16%"><div class="border-right">
                        Nhà mạng
<!--                        <i class="fa fa-ellipsis-h" aria-hidden="true"></i></div>-->
                </th>
                <th width="23%">
                    <div class="border-right">
                        <!--Thể loại <img src="images/cham.png" alt="">-->
                        <div class="show-sim-type">
                            <input type="hidden" id="selected-type-sim" name="select-type-sim">
                            <div class="show-value">
                                <span>Thể loại <i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>
                            </div>
                            <div class="select-dropdown-icon">
                                <!--<i class="fa fa-ellipsis-h" aria-hidden="true"></i>-->
                            </div>
                            <div class="options" style="display: none;">
                                <div class="scroll-y">
                                    <?php foreach ($type as $item): ?>
                                        <div class="custom-control custom-checkbox custom-control-inline item-compare">
                                            <input type="checkbox" class="custom-control-input" id="type1">
                                            <label class="custom-control-label" for="type1">
                                                <p class="phone"><?php echo $item->name ?></p>
                                            </label>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </th>
                <th width="10%"><div class="border-right">Điểm</div></th>
                <th width="10%"><img src="/images/icon-table-1.png" alt=""></th>
                <th width="7%"><img src="/images/icon-table-2.png" alt=""></th>
            </tr>
        </thead>
        <tbody>
            <?php  foreach ($list as $item) {
                $i++;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td style="cursor: pointer;"><span class="add-cart-pay" data-id="<?php echo $item->id?>" data-price="<?php echo $item->price?>" data-sim="<?php echo $item->sim?>"><?php echo $item->sim ?></span></td>
                <td><?php echo format_money($item->price_public,' đ')  ?></td>
                <td><?php echo $item->network ?></td>
                <td><?php echo trim($item->cat_name, ','); ?></td>
                <td><?php echo $item->point ?></td>
                <td class="cart-no-hover">
                    <a class="icon_add-cart add-cart <?php
                    if(isset($_SESSION['cart'])){
                        foreach ($_SESSION['cart'] as $id_cart){
                            if($id_cart[0]== $list[$i]->id){
                                echo " in_cart icon_in_cart delete-cart-ok";
                            }
                        }
                    }
                    ?>" href="<?php
                    if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
                        for($j=1; $j<=count($_SESSION['cart']); $j++){
                            foreach ($_SESSION['cart'] as $key =>$val) {
                                if ($j == count($_SESSION['cart'])) {
                                    if ($_SESSION['cart'][$key][0] == $list[$i]->id) {
                                        echo FSRoute::_('index.php?module=home&view=home&task=delete&id=' . $list[$i]->id);
                                    } else {
                                        echo 'javascript:void()';
                                    }
                                } else if ($_SESSION['cart'][$key][0] == $list[$i]->id) {
                                    echo FSRoute::_('index.php?module=home&view=home&task=delete&id=' . $list[$i]->id);
                                }
                            }
                        }
                    }else{
                        echo 'javascript:void()';
                    }
                    ?>"
                        <?php
                        if(isset($_SESSION['cart'])){
                            foreach ($_SESSION['cart'] as $id_cart){ if($id_cart[0]== $list[$i]->id){ ?>
                                onclick="return confirm('Bạn có muốn xóa khỏi giỏ hàng?')"
                            <?php }} }
                        ?>
                       data-id="<?php echo $item->id?>" data-price="<?php echo $item->price?>" data-sim="<?php echo $item->sim?>" title="Thêm vào giỏ hàng">
                        <img src="/templates/default/images/icon-no-hover-01.png" alt="" class="img-no-hover">
                    </a>
                </td>
                <td>
                    <a  class="add-cart-pay" href="javascript:void(0);" data-id="<?php echo $item->id?>" data-price="<?php echo $item->price?>" data-sim="<?php echo $item->sim?>">
                        <img src="/templates/default/images/icon-no-hover-02.png" alt="" class="img-no-hover">
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php if ($pagination) { ?>
        <?php echo $pagination->showPagination(3); ?>
    <?php } ?>
</div>
<div class="container content-home">
    <div class="reviews-sim">
        <div class="box-content">
            <div class="scroll-y">
                <?php echo $config['reviews_sim']?>
            </div>
        </div>
    </div>
    <div class="news-home">
        <div class="title">
            <button class="btn btn-primary">TIN TỨC SIM SỐ ĐẸP</button>
            <span class="pull-right view-all"><a href="<?php echo FSRoute::_('index.php?module=news&view=home&Itemid=2')?>">Xem thêm <i class="fa fa-angle-right" aria-hidden="true"></i></a></span>
            <div class="clearfix"></div>
        </div>
        <div class="content-new">
            <?php echo $tmpl->load_direct_blocks('newslist', array('style' => 'home','type' => 'home','limit' =>'15')); ?>
        </div>
    </div>
</div>

<style>
    /*.list-sim thead th:nth-child(5) .border-right{*/
        /*padding-right: 65px;*/
    /*}*/
    .list-sim thead th:nth-child(5) .border-right .fa{
        right: 68px;
        top: 16px;
    }
    .list-sim thead th:nth-child(5) .border-right{
        position: unset !important;
    }
    .list-sim tbody tr td:nth-child(5){
        line-height: 30px !important;
        padding-bottom: 10px;
        padding-top: 10px;
    }
    .list-sim tbody tr td:nth-child(1):after{
        left: 30px !important;
    }
    .show-sim-type{
        position: unset !important;
    }
    .show-sim-type .options{
        right: 10px !important;
        width: 100% !important;
        top: 48px !important;
    }
</style>