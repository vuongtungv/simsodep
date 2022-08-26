<?php
global $tmpl, $config;
$Itemid = 1;
$tmpl->addStylesheet('default','modules/home/assets/css');
$tmpl->addScript('add_cart','modules/home/assets/js');
$tmpl->addScript('regis_promotions','modules/home/assets/js');
?>
<input type="hidden" id="url_root" value="<?php echo URL_ROOT?>">
<?php //testVar($_SESSION['cart'])?>
<!--Content home-->
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->


<?php echo $tmpl->load_direct_blocks('banners', array('style' => 'default','category_id' => '4'));?>

<div class="container content-home mr-top-home">
    <div class="flex-content">
        <div class="left-content">
            <!-- tìm theo loại -->
            <?php echo $tmpl->load_direct_blocks('cat', array('style' => 'default')); ?>

            <!-- tìm theo nhà mạng -->
            <?php echo $tmpl->load_direct_blocks('network', array('style' => 'default')); ?>

            <div class="quick-filter sale-of-day">
                <div class="flex-header">
                    <h2 class="title-hea">SIM VIETTEL V90</h2>
                    <span class="pull-right view-all">
                        <a href="<?php echo FSRoute::_("index.php?module=sim_network&view=home&type=1")?>">Xem thêm</a>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
                            <!--                        <img style="margin-top: -2px;" src="--><?php //echo URL_ROOT?><!--/templates/default/images/img_svg/trangchu/xemthem_muangay_arrow.svg" alt="">-->
                    </span>
                </div>

                <div class="clearfix"></div>
                <div class="row">
                    <?php echo $tmpl->load_direct_blocks('list_sim', array('style' => 'default','type' => '1','limit' =>'9')); ?>
                </div>
            </div>
            <div class="quick-filter sim-vip">
                <div class="flex-header">
                    <h2 class="title-hea">Sim vip</h2>
                    <span class="pull-right view-all">
                        <a href="<?php echo FSRoute::_("index.php?module=sim_network&view=home&type=2")?>">Xem thêm</a>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
    <!--                        <img style="margin-top: -2px;" src="--><?php //echo URL_ROOT?><!--/templates/default/images/img_svg/trangchu/xemthem_muangay_arrow.svg" alt=""> -->
                    </span>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <?php echo $tmpl->load_direct_blocks('list_sim', array('style' => 'default','type' => '2','limit' =>'9')); ?>
                </div>
            </div>
            <div class="quick-filter sim-vip">
                <div class="flex-header">
                    <h2 class="title-hea">Sim trả sau</h2>
                    <span class="pull-right view-all">
                    <a href="<?php echo FSRoute::_("index.php?module=sim_network&view=home&type=5")?>">Xem thêm</a>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span>
                </div>
                    <div class="clearfix"></div>
                <div class="row">
                    <?php echo $tmpl->load_direct_blocks('list_sim', array('style' => 'default','type' => '5','limit' =>'9')); ?>
                </div>
            </div>
            <div class="quick-filter sim-offer">
                <div class="flex-header">
                    <h2 class="title-hea">Sim đề xuất</h2>
                    <span class="pull-right view-all">
                        <a href="<?php echo FSRoute::_("index.php?module=sim_network&view=home&type=3")?>">Xem thêm</a>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
    <!--                        <img style="margin-top: -2px;" src="--><?php //echo URL_ROOT?><!--/templates/default/images/img_svg/trangchu/xemthem_muangay_arrow.svg" alt="">-->
                    </span>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <?php echo $tmpl->load_direct_blocks('list_sim', array('style' => 'default','type' => '3','limit' =>'9')); ?>
                </div>
            </div>
        </div>
        <div class="right-content">
            <div class="card sim-default sim-tasteful">
                <h3 class="card-header">Khuyến mãi sim số đẹp</h3>
                <div class="card-body ">
                    <div class="scroll-y">
                        <?php echo $tmpl->load_direct_blocks('list_sim', array('style' => 'default_2','type' => '4','limit' =>'25')); ?>
                    </div>
                </div>
                <div class="hr-line">
                    <div class="bg-line"></div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo FSRoute::_("index.php?module=sim_network&view=home&type=4")?>">Xem thêm sim khuyến mãi</a>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
<!--                    <img style="margin-top: -2px;" src="--><?php //echo URL_ROOT?><!--/templates/default/images/img_svg/trangchu/xemthem_muangay_arrow.svg" alt="">-->

                </div>
            </div>

            <!-- tìm theo ngày sinh  -->
            <?php echo $tmpl->load_direct_blocks('search_birth', array('style' => 'default')); ?>

            <!-- tìm theo phong thủy -->
            <?php echo $tmpl->load_direct_blocks('point_button', array('style' => 'default')); ?>

            <!-- tìm sim hợp mệnh -->
            <?php echo $tmpl->load_direct_blocks('lives', array('style' => 'default')); ?>

            <div class="register-sale">
                <form action="" method="post" >
                    <div class="box-top">
                        <h3 class="title-hea">Đăng ký khuyến mãi</h3>
                        <div class="SumoSelect">
                            <!--Đang ký -->
                            <!--                            --><?php //echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'default_home','category_id' => '1')); ?>
                            <input type="hidden" id="selected-sim-name" name="sim-name" value="<?php echo $regis_default[0]->network?>" data-id="<?php echo $regis_default[0]->network_id?>">
                            <div class="sim-name">
                                <div class="value-type"><?php echo $regis_default[0]->network?></div>
                                <div class="select-dropdown-icon">
<!--                                    <i class="fa fa-angle-down" aria-hidden="true"></i>-->
                                    <img src="/templates/default/images/img_svg/trangchu/down_menu.svg" alt="" class="icon_drop_x">
                                </div>
                                <div class="options">
                                    <?php foreach ($show_netname as $net){ ?>
                                        <div class="option" data-id="<?php echo $net->network_id?>" value="<?php echo $net->network ?>" data-placement="bottom" data-toggle="tooltip"><?php echo $net->network ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-bottom">
<!--                        <img src="/templates/default/images/bg_register.png" alt="">-->
                        <input type="hidden" id="id_net_work" name="id_net_work" value="<?php echo $regis_default[0]->network_id?>">
                        <!--                        <img src="/templates/default/images/banner_register.png" alt="">-->
                        <!--                        --><?php //echo $tmpl->load_direct_blocks('banners', array('style' => 'default_home','category_id' => '1')); ?>
                        <h3 class="name-regis"><span id="name_regis"><?php echo $regis_default[0]->title?></span></h3>
                        <p class="price-regis" id="price_regis"><?php echo $regis_default[0]->price?></p>
                        <div class="detail-regis" id="detail_regis">
                            <?php echo html_entity_decode($regis_default[0]->content) ?>
                        </div>
                        <div class="method-regis">
                            <p class="">Soạn: <span id="send_detail"><?php echo $regis_default[0]->rules_regis?></span></p>
                            <p class="">Gửi: <span id="send_num"><?php echo $regis_default[0]->number_send?></span></p>
                        </div>


                        <div  class="btn btn-default-focus click-regis-now">
                            <a id="promotions-link" class="promotions-link <?php if($regis_default[0]->link_promotions) echo 'promotions-link-show'?>" href="<?php echo $regis_default[0]->link_promotions?>">Đăng ký ngay <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                            <span id="promotions-pop" class="promotions-pop <?php if($regis_default[0]->link_promotions) echo 'promotions-pop-hidden'?>" >Đăng ký ngay <i class="fa fa-angle-right" aria-hidden="true"></i><span>
                        </div>



                        <div class="success-click">
                            <div class="show-send-mess">
                                <button type="button" class="close pull-left close-pup">
                                    <img src="/templates/default/images/img_svg/trangchu/close.svg" alt="">
                                </button>
                                <p>Để đăng ký gói cước <span id="name_regis_pop"><?php echo $regis_default[0]->title?></span> quý khách vui lòng soạn tin nhắn trên điện thoại với nội dung <span id="send_detail_pop"><?php echo $regis_default[0]->rules_regis?></span> gửi đến đầu số
                                    <span id="send_num_pop"><?php echo $regis_default[0]->number_send?></span></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

<!--    <img src="/templates/default/images/img_svg/trangchu/3dot.svg" alt="" class="content-home center_page">-->
    <div class="svg-dots">
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>

    <div class="reviews-sim">
        <div class="box-content">
            <div class="scroll-y">
                <?php echo $config['reviews_sim']?>
            </div>
        </div>
    </div>
    <div class="news-home">
        <div class="title">
            <h4 class="btn btn-primary">TIN TỨC SIM SỐ ĐẸP</h4>
            <span class="pull-right view-all">
                <a href="<?php echo FSRoute::_('index.php?module=news&view=home&Itemid=2')?>">Xem thêm</a>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
            </span>
            <div class="clearfix"></div>
        </div>
        <div class="content-new">
            <?php echo $tmpl->load_direct_blocks('newslist', array('style' => 'home','type' => 'home')); ?>
        </div>
    </div>
</div>

