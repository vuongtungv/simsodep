<?php
global $tmpl, $config;
$Itemid = 1;
$tmpl->addStylesheet('default','modules/home/assets/css');
$tmpl->addScript('add_cart','modules/home/assets/js');
$tmpl->addScript('regis_promotions','modules/home/assets/js');

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
                                $link_type = URL_ROOT.$type->parent_alias.'/'.$type->alias.'.html';
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
                <a onclick="javascript: submit_form_search_network();return false;" href="<?php echo URL_ROOT.'danh-sach-sim.html' ?>" class="btn quick-search">Xem toàn bộ sim trong hệ thống<span>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
            </div>
        </div>
    </form>
    <p class="slogan span10">Trung tâm mua bán sim số đẹp giá rẻ, uy tín - chuyên nghiệp</p>
</div>
<!-- SALE IN DAY SIM HOME-->
<div class="sale-sim sim-sale-day">
    <h2 class="title-hea">Sim viettel v90</h2>
    <div class="list-item">
        <div class="row">
            <?php echo $tmpl->load_direct_blocks('list_sim', array('style' => 'default_mobile','type' => '1','limit' =>'10')); ?>
        </div>
    </div>
    <div class="view-more">
        <a href="<?php echo FSRoute::_("index.php?module=sim_network&view=home&type=1")?>">Xem thêm <span>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
    </div>
</div>
<!-- VIP SIM HOME-->
<div class="sale-sim sim-vip">
    <h2 class="title-hea">Sim vip</h2>
    <div class="list-item">
        <div class="row">
            <?php echo $tmpl->load_direct_blocks('list_sim', array('style' => 'default_mobile','type' => '2','limit' =>'10')); ?>
        </div>
    </div>
    <div class="view-more">
        <a href="<?php echo FSRoute::_("index.php?module=sim_network&view=home&type=2")?>">Xem thêm <span>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
    </div>
</div>
<!-- Trả sau SIM HOME-->
<div class="sale-sim sim-vip">
    <h2 class="title-hea">Sim trả sau</h2>
    <div class="list-item">
        <div class="row">
            <?php echo $tmpl->load_direct_blocks('list_sim', array('style' => 'default_mobile','type' => '5','limit' =>'10')); ?>
        </div>
    </div>
    <div class="view-more">
        <a href="<?php echo FSRoute::_("index.php?module=sim_network&view=home&type=5")?>">Xem thêm <span>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
    </div>
</div>
<!-- OFFER SIM HOME-->
<div class="sale-sim sim-offer">
    <h2 class="title-hea">Sim đề xuất</h2>
    <div class="list-item">
        <div class="row">
            <?php echo $tmpl->load_direct_blocks('list_sim', array('style' => 'default_mobile','type' => '3','limit' =>'10')); ?>
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
        <h4 class="title-card"><a href="index.php?module=news&view=home&Itemid=2" class="news-all">Tin tức sim số đẹp</a></h4>
    </div>
    <?php echo $tmpl->load_direct_blocks('newslist', array('style' => 'index_mobile','type' => 'home','limit' =>'4')); ?>
</div>