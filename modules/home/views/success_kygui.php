<?php
global $tmpl, $config;
$Itemid = 1;
$tmpl->addStylesheet('default','modules/home/assets/css');
$tmpl->addScript('add_cart','modules/home/assets/js');
$tmpl->addScript('regis_promotions','modules/home/assets/js');

// popup success
$tmpl->addStylesheet('success_order','modules/paynow/assets/css');
$tmpl -> addScript('success_order','modules/paynow/assets/js');

        $a_network = FSInput::get('network');
        $a_cat = FSInput::get('cat');
        $a_from_price = FSInput::get('from_price');
        $a_to_price = FSInput::get('to_price');
        $a_button = FSInput::get('button');
        $a_point = FSInput::get('point');
        $a_keyword = FSInput::get('keyword');
        $a_order = FSInput::get('order');
        $a_number = FSInput::get('number');
        $arr_number = array();
        if (@$a_number && $a_number != 'all') {
            $arr_number = explode('-', $a_number);
        }
        $in = '';
        if ((@$a_button&&$a_button!='all')||(@$a_point&&$a_point!='all')||(@$a_number || $a_number=='0')) {
            $in = 'show';
        }
        if (@$a_network && $a_network != 'all') {
            $network_item = $model->get_record('id = '.$a_network,'fs_network','id,name');
        }
        if (@$a_cat && $a_cat != 'all') {
            $type_item = $model->get_record('alias = "'.$a_cat.'"','fs_sim_type','id,name,alias');
        }
        if (@$a_price && $a_price != 'all') {
            $price_item = $model->get_record('price = "'.$a_price.'"','fs_pricesim','id,title,price');
        }

?>
<input type="hidden" id="url_root" value="<?php echo URL_ROOT?>">

<!--Menu filter-->
<div id="sim_search_wrap">
    <form action="">
        <div class="search_bg search_bg-lv1">
            <div class="SumoSelect">
                <!--Danh sách nhà mạng-->
                <input type="hidden" id="selected-options" name="select-options">
                <div class="select-options">
                    <select name="selected-value" id="selected-value" class="sel-ip select_location">
                        <option value="all">Nhà mạng</option>
                        <?php foreach ($network as $net){ ?>
                        <option <?php echo @$a_network==$net->id&&@$a_network!='all'?'selected':'' ?> value="<?php echo URL_ROOT.$net->alias.'.html' ?>"><?php echo $net->name ?></option>
                        <?php } ?>
                    </select>
                </div>

                <!--Thể loại sim-->
                <input type="hidden" id="selected-type" name="select-type">
                <div class="select-type">
                    <select name="selected-type" id="selected-type" class="sel-ip select_location">
                        <option>Thể loại</option>
                        <?php foreach ($type as $type){
                            if ($type->level == 0) {
                                $link_type = URL_ROOT.$type->alias.'.html';
                            }else{
                                $link_type = URL_ROOT.$type->parent_name.'/'.$type->alias.'.html';
                            }
                         ?>
                            <option <?php echo @$a_cat==$type->id&&@$a_cat!='all'?'selected':'' ?> value="<?php echo $link_type ?>"><?php echo $type->name ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="search_bg search_bg-lv2">
            <div class="SumoSelect">
                <!--Click quick search-->
                <!-- <button type="button" class="btn quick-search">Xem toàn bộ sim trong hệ thống <span>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span></button> -->
                <a onclick="javascript: submit_form_search_network();return false;" href="<?php echo URL_ROOT.'tim-sim/all.html' ?>" class="btn quick-search">Xem toàn bộ sim trong hệ thống<span>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
            </div>
        </div>
    </form>
    <p class="slogan span10">Trung tâm mua bán sim số đẹp giá rẻ, uy tín - chuyên nghiệp</p>
</div>
<!-- SALE IN DAY SIM HOME-->
<div class="sale-sim sim-sale-day">
    <h1 class="title-hea">Sim viettel v90</h1>
    <div class="list-item">
        <div class="row">
            <?php echo $tmpl->load_direct_blocks('list_sim', array('style' => 'default_mobile','type' => '1','limit' =>'4')); ?>
        </div>
    </div>
    <div class="view-more">
        <a href="<?php echo FSRoute::_("index.php?module=sim_network&view=home&type=1")?>">Xem thêm <span>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
    </div>
</div>
<!-- VIP SIM HOME-->
<div class="sale-sim sim-vip">
    <h1 class="title-hea">Sim vip</h1>
    <div class="list-item">
        <div class="row">
            <?php echo $tmpl->load_direct_blocks('list_sim', array('style' => 'default_mobile','type' => '2','limit' =>'4')); ?>
        </div>
    </div>
    <div class="view-more">
        <a href="<?php echo FSRoute::_("index.php?module=sim_network&view=home&type=2")?>">Xem thêm <span>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
    </div>
</div>
<!-- OFFER SIM HOME-->
<div class="sale-sim sim-offer">
    <h1 class="title-hea">Sim đề xuất</h1>
    <div class="list-item">
        <div class="row">
            <?php echo $tmpl->load_direct_blocks('list_sim', array('style' => 'default_mobile','type' => '3','limit' =>'4')); ?>
        </div>
    </div>
    <div class="view-more">
        <a href="<?php echo FSRoute::_("index.php?module=sim_network&view=home&type=3")?>">Xem thêm <span>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
    </div>
</div>
<!-- SEO HOME-->
<div class="seo-home">
    <div class="scroll-y">
        <?php echo $config['reviews_sim']?>
    </div>
</div>
<!-- NEW HOME -->
<div class="new-home">
    <div class="header-new">
        <h1 class="title-card"><a href="index.php?module=news&view=home&Itemid=2" class="news-all">Tin tức sim số đẹp</a></h1>
    </div>
    <?php echo $tmpl->load_direct_blocks('newslist', array('style' => 'index_mobile','type' => 'home','limit' =>'4')); ?>
</div>


<div class="success-order">
    <div class="bg-black">
        <div class="body">
            <button type="button" class="close close-pup">
                <img src="<?php echo URL_ROOT?>/templates/mobile/images/img_svg/trang_chu/close.svg" alt="">
            </button>
            <p class="hea-text">Ký gửi sim thành công !</p>
            <p class="detal">Mọi thắc mắc và vấn đề phát sinh, quý khách vui lòng liên hệ với bộ phận chăm sóc khách hàng hoặc đến trực tiếp cửa hàng để nhận được sự hỗ trợ tốt nhất. Xin cảm ơn quý khách!</p>
        </div>
        <!--        <p class="download">-->
        <!--            --><?php //$id_order =  FSInput::get('id');?>
        <!--            <a class="link-export" href="--><?php //echo FSRoute::_("index.php?module=paynow&view=export&task=pdf_success&id=$id_order&raw=1")?><!--">-->
        <!--                Xuất đơn hàng-->
        <!--            </a>-->
        <!--        </p>-->
    </div>
</div>


<style>
    .success-order{
        top: 0px;
        padding-top: 300px;
    }
    .bg-black{
        width: unset !important;
        height:unset !important;
    }
    .hea-text{
        width: 715px !important;
        font-family: Roboto-Medium !important;
        font-size: 40px !important;
        padding: 15px;
        line-height: 65px !important;
    }
    .body{
        padding: 80px 28px 50px !important;
    }
    .detal{
        font-size: 38px !important;
        font-family: Roboto-Regular !important;
        margin: 35px 0px 0px !important;
    }
    .close-pup{
        left: 40px !important;
        top: 40px !important;
    }
    .close-pup img{
        width: 40px;
        float: left;
    }

</style>