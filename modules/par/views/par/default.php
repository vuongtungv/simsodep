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
    <div class="show-pagination">
        <input type="hidden" id="selected-pagination" name="select-pagination">
        <div class="header-list-sim">
            <h1 class="name-header-ls"><?php echo $br; ?></h1>
            <div class="show-value">
                <span>Sắp xếp: </span> <strong class="value-pagination"><?php echo @$order_name ?></strong>&nbsp;&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i>
            </div>
        </div>
        <div class="select-dropdown-icon">
            <!--<i class="fa fa-angle-down" aria-hidden="true"></i>-->
        </div>
        <div class="options" style="display: none;">

            <?php foreach ($this->sort_arr as $key => $value) {?>
                <div class="option" value="random" data-placement="bottom" data-toggle="tooltip" data-original-title="" title="">
                    <?php 

                        $check = '';
                        $param['order'] = $key;
                        if ( $key == @$order) {
                             unset($param['order']);
                            $check = 'checked';
                        }
                        $link = FSRoute::addPram($param,$url);

                    ?>
                    <a class="<?php echo $check ?>" href="<?php echo $link ?>"><?php echo $value ?></a>
                </div>                
            <?php } ?>

        </div>
    </div>

    <table class="table table-hover">
        <thead>
            <?php echo $tmpl->load_direct_blocks('filter', array('style' => 'filter','url' => $url)); ?>
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
                    <a cart="<?php echo $exit_cart ?>" class="" type="list" href="javascript:void(0)" title="<?php echo $exit_cart == 'no_cart'?'Thêm vào giỏ hàng':'Xóa khỏi giỏ hàng' ?>" class="" onclick="action_cart('<?php echo $item['number'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price_public'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>',this)">
                        <img src="<?php echo $exit_cart == 'no_cart'?URL_ROOT.'/templates/default/images/img_svg/sim_theo_nha_mang/content_cart.svg':URL_ROOT.'templates/default/images/img_svg/sim_theo_nha_mang/content_cart_hover.svg' ?>" class="img-no-hover">
                    </a>
                </td>
                <td>
                    <?php $link = FSRoute::_('index.php?module=paynow&view=paynow&task=sim&sim='.$item['number']) ?>
                    <a class="" href="<?php echo $link ?>" onclick="update_cart('<?php echo $item['number'] ?>','<?php echo $item['sim_id'] ?>','<?php echo $item['price_public'] ?>','<?php echo $item['network'] ?>','<?php echo $cat_name ?>','<?php echo $item['point'] ?>','<?php echo $item['button'] ?>','<?php echo $link ?>')" title="Mua ngay">
                        <img style="margin-top: 5px" src="<?php echo URL_ROOT ?>/templates/default/images/img_svg/sim_theo_nha_mang/content_pay.svg" alt="" class="img-no-hover">
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
            <span class="pull-right view-all"><a href="<?php echo FSRoute::_('index.php?module=news&view=home&Itemid=2')?>">Xem thêm <i class="fa fa-angle-right" aria-hidden="true"></i></a></span>
            <div class="clearfix"></div>
        </div>
        <div class="content-new">
            <?php echo $tmpl->load_direct_blocks('newslist', array('style' => 'home','type' => 'home','limit' =>'15')); ?>
        </div>
    </div>
</div>