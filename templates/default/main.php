<?php 
    $a_keyword = FSInput::get('keyword');

 ?>
<input type="hidden" value="<?php echo FSInput::get('module')?>" id="name-module">
<input type="hidden" value="<?php echo $Itemid ?>" id="Itemid">
<input type="hidden" value="1" id="input_value_advanced_search">
<div id="opacity-body" >
    <div class="warp-scroll">
        <div id="oe_overlay" class="" style="opacity: 0;"></div>
        <ul class="container header-scroll">
            <li><a href="<?php echo URL_ROOT?>">
                    <img class="logo-scroll" src="/templates/default/images/img_svg/trangchu/logo_sticky.svg" alt=""></a>
            </li>
            <li>
                <form action="" method="post" id="search_scroll" accept-charset="utf-8">
                    <input type="text" class="form form-control text-search-2" value="<?php echo @$a_keyword&&@$a_keyword!='all'?$a_keyword:'' ?>" name="text-search" id="text-search-2" placeholder="Nhập số sim quý khách muốn tìm kiếm">
                </form>
            </li>
            <li class="dot-scroll">
<!--                <img class="dot-scroll" src="/templates/default/images/img_svg/trangchu/menudot_sticky.svg" alt="">-->
                <div class="svg-dots svg-dots-white">
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
                <div class="show-menu-scroll">
                    <?php echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'megamenu', 'group' => '5')); ?>
                </div>
            </li>
            <li>
                <a href="
                        <?php
                            if(!empty($_SESSION['cart'])){
                                echo FSRoute::_('index.php?module=paynow&view=paynow');
                            }else{
                                echo "javascript:void()";
                            }
                        ?>
                    ">
                    <img class="cart-scroll" src="/templates/default/images/img_svg/trangchu/cart_sticky.svg" alt="">
                    <span>Giỏ hàng (<?php
                        if(!empty($_SESSION['cart'])){
                            echo '<span id="scroll_cart">'.count($_SESSION['cart']).'</span>';
                        }else{
                            echo '<span id="scroll_cart">0</span>';
                        }
                        ?> sản phẩm)</span>
                </a>
            </li>
        </ul>
    </div>

    <div id="height-scroll">
        <header>
            <!--Promotion information-->
            <?php echo $tmpl->load_direct_blocks('newslist', array('style' => 'marquee','type' => 'marquee','limit' => '3')); ?>
            <!--Company information-->
            <div class="container company-information">
                <span class="title-company pull-left"><?php echo $config['company_name']?></span>
                <span class="work-company pull-right">Giờ làm việc : <?php echo $config['time_work']?></span>
                <div class="clearfix"></div>
            </div>
            <!-- Company-contact -->
            <div class="container company-contact">
                <?php if(FSInput::get('module') == 'home'){?>
                    <h1 class="img-logo">
                        <a href="<?php echo URL_ROOT?>"><img width="202px;" height="100%" src="/templates/default/images/img_svg/trangchu/logo.svg"></a>
                    </h1>
                <?php }else{?>
                    <div class="img-logo">
                        <a href="<?php echo URL_ROOT?>"><img width="202px;" height="100%" src="/templates/default/images/img_svg/trangchu/logo.svg"></a>
                    </div>
                <?php }?>
                <div class="contact-banner">
                    <div class="banner">
                        <?php echo $tmpl->load_direct_blocks('banners', array('style' => 'header_top','category_id' =>'1'));?>
                    </div>
                    <div class="contact-header">
                        <p class="phone">Bộ phận chăm sóc khách hàng</p>
                        <div class="phone-2">
                            <p><?php echo @$config['contact_phone']?></p>
                            <p><?php echo @$config['contact_phone_2']?></p>
                        </div>
                    </div>
                    <div class="shopcart">
                        <p>Giỏ hàng</p>
                        <div class="icon-cart">
                            <img src="/templates/default/images/img_svg/trangchu/header_cart.svg" alt="Giỏ hàng">

                            <?php
                            if(!empty($_SESSION['cart'])){
                                echo '<span>'.count($_SESSION['cart']).'</span>';
                            }else{
                                echo '<span style="display:none">'.count($_SESSION['cart']).'</span>';
                            }
                            ?>

                        </div>
                        <!--Show cart-->
                        <?php
                        // if(!empty($_SESSION['cart']) && count($_SESSION['cart'])>0){
                        echo $tmpl->load_direct_blocks('shopcart', array('style' => 'default'));
                        // }
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <?php
            //    if(!empty($_SESSION['cart'])){
            //        testVar($_SESSION['cart']);
            //    }else{
            //        echo 1;
            //    }
            //
            //?>
            <!--Menu top-->
            <nav class="container navbar navbar-expand-lg menu-top hover-opa">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-top"
                        aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="menu_opacity"></div>
                <div class="collapse navbar-collapse" id="menu-top">
                    <?php echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'megamenu', 'group' => '5')); ?>
                </div>
            </nav>

            <!--Menu filter-->
        </header>




        <!--Search-->
        <?php echo $tmpl->load_direct_blocks('search', array('style' => 'default')); ?>

    </div>

    <?php if($Itemid != 1){
        $tmpl->load_direct_blocks('breadcrumbs');
    }?>
    <?php echo $main_content ?>

<!--    <img src="/templates/default/images/img_svg/trangchu/3dot.svg" alt="" class="content-home center_page">-->
    <div class="svg-dots">
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>


    <!--Footer-->
    <footer class="container footer-bottom">
        <div class="top-foot row no-gutters">
            <div class="col-md-6">
                <?php echo $config['info_footer']?>
            </div>
            <div class="col-md-2 link-foot">
                <?php echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'bottom', 'group' => '4')); ?>
            </div>
            <div class="col-md-2 link-foot">
                <?php echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'bottom_support', 'group' => '3')); ?>
            </div>
            <div class="col-md-2 number-sims">
                <div class="color-life"></div>
                <div class="sims">
                    <div class="num million">10</div>
                    <div class="num thousand">815</div>
                    <div class="num hundred">326</div>
                </div>
                <p>Tổng số sim hiện có</p>
                <a target="_blank" title="Website da dang ky voi Bo Cong Thuong" rel="nofollow" href="http://online.gov.vn/Home/WebDetails/57566"><img src="<?php echo URL_ROOT?>/templates/default/images/img_svg/trangchu/bo_cong_thuong.svg" alt=""></a>
                <a target="_blank" rel="nofollow" href="//www.dmca.com/Protection/Status.aspx?ID=f5b2162f-16b0-417d-9ddc-f8ab06b61a15" title="DMCA.com Protection Status" class="dmca-badge">
                    <img  style="margin-top: 20px" src ="<?php echo URL_ROOT?>templates/default/images/img_svg/trangchu/dmca-01.svg"  alt="DMCA.com Protection Status" /></a>
                <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
            </div>
        </div>
        <div class="bottom-foot">
            <span class="pull-left"><?php echo $config['copyring']?></span>
            <span class="pull-center"><?php echo html_entity_decode($config['author']) ?></span>
            <span class="pull-right"><?php echo html_entity_decode($config['design']) ?></span>
            <div class="clearfix"></div>
        </div>
    </footer>
</div>
<?php echo $tmpl->load_direct_blocks('banners', array('style' => 'default_left','category_id' => '2'));?>
<?php echo $tmpl->load_direct_blocks('banners', array('style' => 'default_right','category_id' => '3'));?>


<div class="zalo-chat-widget" data-oaid="579745863508352884" data-welcome-message="Rất vui khi được hỗ trợ bạn!" data-autopopup="0" data-width="350" data-height="420"></div>

<script src="https://sp.zalo.me/plugins/sdk.js"></script>
