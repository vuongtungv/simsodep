<?php
global $config,$tmpl,$user;
$Itemid = FSInput::get('Itemid', 1, 'int');
$lang = FSInput::get('lang');
$success = FSInput::get('success');
$id_order = FSInput::get('id_order');
$logo = URL_ROOT.$config['logo'];

$tmpl->addStylesheet('style','templates/mobile/css');
$tmpl->addStylesheet('jquery.mCustomScrollbar','templates/mobile/css/');
$tmpl->addStylesheet('font-awesome','templates/mobile/scss/font-awesome/css');
$tmpl->addStylesheet('thanhtoan-success','templates/mobile/css/');

$tmpl -> addScript('templates','templates/mobile/js');
$tmpl -> addScript('link_searchFull','templates/mobile/js');
$tmpl -> addScript('js_scrollBar','templates/mobile/js');
$tmpl -> addScript('jquery.mCustomScrollbar.concat.min','templates/mobile/js');

?>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<?php //echo $tmpl->load_direct_blocks('newslist', array('style' => 'marquee','type' => 'marquee','limit' => '3')); ?>
<header class="menu-top menu-home" data-spy="affix" data-offset-top="250" >
    <div class="icon_back" id="ic_back_click_search" style="display: none;">
        <a><span><i class="fa fa-angle-left" aria-hidden="true"></i></span></a>
    </div>
    <div class="menu-icon">
        <img src="/templates/mobile/images/img_svg/trang_chu/left_menu.svg" alt="" id="btn-menu">
        <div class="abcedef">
            <div class="dropdown-menu" id="show-menu">
                <?php echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'megamenu_moblie', 'group' => '6')); ?>
                <?php if(FSInput::get('module') == 'home'){?>
                    <h1 class="child-2">
                        <a href="<?php echo URL_ROOT?>"><img style="width: 50%" src="/templates/mobile/images/img_svg/trang_chu/logo.svg" alt=""></a>
                        <ul>
                            <li class="icon_email"><p class="title"><?php echo $config['contact_email']?></p></li>
                            <li class="icon_phone">
                                <p class="title">Bộ Phận Chăm Sóc Khách Hàng</p>
                                <p class="detail"><?php echo $config['contact_phone']?></p>
                                <p class="detail"><?php echo $config['contact_phone_2']?></p>
                            </li>
                            <li class="icon_clock">
                                <p class="title">Giờ làm việc :</p>
                                <p class="detail"><?php echo $config['time_work']?></p>
                            </li>
                        </ul>
                    </h1>
                <?php }else{?>
                    <div class="child-2">
                        <a href="<?php echo URL_ROOT?>"><img style="width: 50%" src="/templates/mobile/images/img_svg/trang_chu/logo.svg" alt=""></a>
                        <ul>
                            <li class="icon_email"><p class="title"><?php echo $config['contact_email']?></p></li>
                            <li class="icon_phone">
                                <p class="title">Bộ Phận Chăm Sóc Khách Hàng</p>
                                <p class="detail"><?php echo $config['contact_phone']?></p>
                                <p class="detail"><?php echo $config['contact_phone_2']?></p>
                            </li>
                            <li class="icon_clock">
                                <p class="title">Giờ làm việc :</p>
                                <p class="detail"><?php echo $config['time_work']?></p>
                            </li>
                        </ul>
                    </div>
                <?php }?>
            </div>
        </div>

    </div>
    <?php if($Itemid != 1){ ?>
        <div class="logo-menu">
            <a href="<?php echo URL_ROOT?>"><img style="width: 100px;" src="/templates/mobile/images/img_svg/trang_chu/logo_sticky.svg" alt=""></a>
        </div>
    <?php }?>

    <!--Search-->
    <?php echo $tmpl->load_direct_blocks('search', array('style' => 'mdefault')); ?>

    <div class="dots-icon">
<!--        <img src="--><?php //echo URL_ROOT ?><!--templates/mobile/images/img_svg/trang_chu/right_menu.svg" alt="" id="btn-dots">-->
        <div id="btn-dots" class="d_white">
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
        <div class="dots-show <?php if(FSInput::get('module')=='home') echo 'dots-show-home'?>" id="dots-show" style="display: none;">
            <div class="dots-show-scr">
                <div class="sale-sim">
                    <h1 class="title-hea">Khuyến mãi sim số đẹp</h1>
                    <div class="list-item">
                        <div class="row">
                            <?php echo $tmpl->load_direct_blocks('list_sim', array('style' => 'default_mobile','type' => '4','limit' =>'10')); ?>
                        </div>
                    </div>
                    <div class="view-more">
                        <a href="<?php echo FSRoute::_("index.php?module=sim_network&view=home&type=4")?>">Xem thêm <span>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                    </div>
                </div>

                <!-- tìm theo ngày sinh  -->
                <?php echo $tmpl->load_direct_blocks('search_birth', array('style' => 'mdefault')); ?>

                <!-- tìm theo phong thủy -->
                <?php echo $tmpl->load_direct_blocks('point_button', array('style' => 'mdefault')); ?>

                <!-- tìm sim hợp mệnh -->
                <?php echo $tmpl->load_direct_blocks('lives', array('style' => 'mdefault')); ?>

                <div class="find-date regis-promotion">
                    <?php echo $tmpl->load_direct_blocks('register_sim', array('style' => 'default_mobile')); ?>
                </div>
                <div class="d-mr-top"></div>
                <div class="footer-bottom">
                    <?php echo $config['info_footer_mobile']?>
                    <div id="accordion">
                        <div class="title-tog" id="headingOne">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Về chúng tôi
                            </button>
                        </div>
                        <div id="collapseOne" class="collapse tog-show" aria-labelledby="headingOne" data-parent="#accordion">
                            <?php echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'bottom_mobile', 'group' => '4')); ?>
                        </div>

                        <div class="title-tog" id="headingTwo">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Chăm sóc khách hàng
                            </button>
                        </div>
                        <div id="collapseTwo" class="collapse tog-show" aria-labelledby="headingTwo" data-parent="#accordion">
                            <?php echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'bottom_support_mobile', 'group' => '3')); ?>
                        </div>
                        <div class="bor-bot"></div>
                    </div>
                    <p class="copyright"><?php echo $config['copyring']?></p>
                    <div class="author">
                        <div class="a">
                            <p class="name"><?php echo html_entity_decode($config['author'])?></p>
                            <?php echo html_entity_decode($config['design']) ?>
                        </div>
                        <div class="box-fot-img">
                            <img class="img-checkbct" src="<?php echo URL_ROOT?>/templates/default/images/img_svg/trangchu/bo_cong_thuong.svg" alt="">
                            <a href="//www.dmca.com/Protection/Status.aspx?ID=f5b2162f-16b0-417d-9ddc-f8ab06b61a15" title="DMCA.com Protection Status" class="dmca-badge">
                                <img class="img_dmca" style="margin-top: 20px" src ="templates/default/images/img_svg/trangchu/dmca-01.svg"  alt="DMCA.com Protection Status" /></a>
                            <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <div class="<?php if(FSInput::get('module')=='home') echo 'home ';?> cart-icon ">

        <div class="icon_has_cart <?php if(count(@$_SESSION['cart']) >0) echo 'has_pro_dot';?>">
<!--            <img src="/templates/mobile/images/icon_has_cart.png" alt="">-->
        </div>

        <img src="<?php echo URL_ROOT ?>/templates/mobile/images/img_svg/trang_chu/Cart.svg" alt="" id="btn-cart">
        <div id="id-show-cart" style="display: none;">
            <?php echo $tmpl->load_direct_blocks('shopcart', array('style' => 'default_mobile'));?>
        </div>
    </div>
    <div class="help-onl" style="display: none;">
        <img src="/templates/mobile/images/img_svg/trang_chu/huong_dan_tim_kiem.svg" alt="" id="id-help">
        <div class="show-help" id="show-help">
            <div class="box-1-h">
                <p class="title-help">Sử dụng dấu " <span>x</span> " đại điện cho 1 số và dấu " <span>-</span> " đại điện cho một chuỗi số. </p>
                <p class="brief-list">Để tìm sim bắt đầu bằng 098, quý khách nhập vào 098*</p>
                <p class="brief-list">Để tìm sim kết thúc bằng 888, quý khách nhập vào *888</p>
                <p class="brief-list">Để tìm sim bên trong có số 888, quý khách nhập vào 888</p>
                <p class="brief-list">Để tìm sim bắt đầu bằng 098 và kết thúc bằng 888, nhập vào 098*888</p>
                <p class="brief-list">Để tìm sim bắt đầu bằng 098 và kết thúc bằng 808, 818, 828, 838, 848, 858, 868, 878, 888, 898 nhập vào 098*8x8</p>
            </div>
            <div class="box-2-h">
                <p class="title-help">Sử dụng dấu " <span>-</span> " đại diện cho " <span>hoặc</span> " để tìm với nhiều kết quả nhanh hơn.</p>
                <p class="brief-list">Để tìm sim bắt đầu bằng 096 hoặc 098, quý khách nhập vào 09(6-8)</p>
                <p class="brief-list">Để tìm sim kết thúc bằng 888 hoặc 999, quý khách nhập vào *(888-999)</p>
                <p class="brief-list">Để tìm sim bên trong có số 888 hoặc 999, quý khách nhập vào (888-999)</p>
                <p class="brief-list">Để tìm sim bắt đầu bằng 096 hoặc 098 và kết thúc bằng 888 hoặc 999, nhập vào 09(6-8)*(888-999)</p>
                <p class="brief-list">Để tìm sim bắt đầu bằng 096 hoặc 098 và kết thúc bằng 808 -> 898 hoặc từ 909 -> 999 nhập vào 09(6-8)*(8x8-9x9)</p>
            </div>
        </div>
    </div>
</header>

<div id="bg-opacity" class=" <?php echo $success==1?'bg-opacity':'' ?>">
    <?php if($Itemid != 1){
        $tmpl->load_direct_blocks('breadcrumbs', array('style' => 'default_mobile'));
    }?>
    <?php echo $main_content ?>
    <!-- FOOTER -->
    <footer class="footer-bottom">
        <?php echo $config['info_footer_mobile']?>
        <div id="accordion">
            <div class="title-tog" id="headingFooterOne">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFooterOne" aria-expanded="false" aria-controls="collapseFooterOne">
                    Về chúng tôi
                </button>
            </div>
            <div id="collapseFooterOne" class="collapse tog-show" aria-labelledby="headingFooterOne" data-parent="#accordion">
                <?php echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'bottom_mobile', 'group' => '4')); ?>
            </div>

            <div class="title-tog" id="headingFooterTwo">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFooterTwo" aria-expanded="false" aria-controls="collapseFooterTwo">
                    Chăm sóc khách hàng
                </button>
            </div>
            <div id="collapseFooterTwo" class="collapse tog-show" aria-labelledby="headingFooterTwo" data-parent="#accordion">
                <?php echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'bottom_support_mobile', 'group' => '3')); ?>
            </div>
            <div class="bor-bot"></div>
        </div>
        <p class="copyright"><?php echo $config['copyring']?></p>
        <div class="author">
            <div class="a">
                <p class="name"><?php echo html_entity_decode($config['author'])?></p>
                <?php echo html_entity_decode($config['design']) ?>
            </div>
            <div class="box-fot-img">
                <a target="_blank" title="Website da dang ky voi Bo Cong Thuong" rel="nofollow" href="http://online.gov.vn/Home/WebDetails/57566"><img src="<?php echo URL_ROOT?>/templates/default/images/img_svg/trangchu/bo_cong_thuong.svg" alt=""></a>
                <a href="//www.dmca.com/Protection/Status.aspx?ID=f5b2162f-16b0-417d-9ddc-f8ab06b61a15" title="DMCA.com Protection Status" class="dmca-badge">
                    <img class="img_dmca" style="margin-top: 20px" src ="<?php echo URL_ROOT?>templates/default/images/img_svg/trangchu/dmca-01.svg"  alt="DMCA.com Protection Status" /></a>
                <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
            </div>
        </div>
    </footer>
</div>

<input type="hidden" id="root" value="<?php echo URL_ROOT ?>">
<input type="hidden" id="name_module" value="<?php echo FSInput::get('module') ?>">

<div class="go-top scrollAnimationToTop" id="scrollAnimationToTop" style="display: none;"></div>


<?php if ($success) {?>
<div class="success-order">
    <div class="body">
        <button type="button" class="close pull-left close-pup">
            <img style="width: 46px;" class="bg-opacity" src="<?php echo URL_ROOT?>/templates/mobile/images/img_svg/trang_chu/close.svg" alt=""></button>
        <p class="hea-text">Đặt hàng thành công !</p>
        <p class="detal">Mọi thắc mắc và vấn đề phát sinh, quý khách vui lòng liên hệ với bộ phận chăm sóc khách hàng hoặc đến trực tiếp cửa hàng để nhận được sự hỗ trợ tốt nhất. Xin cảm ơn quý khách!</p>
    </div>
    <p class="download"><a href="<?php echo FSRoute::_("index.php?module=paynow&view=export&task=api_pdf_export&id=$id_order&raw=1")?>">
            <img src="templates/mobile/images/img_svg/trang_chu/download.svg" alt="">&nbsp;&nbsp; Xuất đơn hàng</a></p>
</div>








<script type="text/javascript">
    $(document).ready(function () {
        $(window).scroll(function() {
            // declare variable
            var topPos = $(this).scrollTop();

            // if user scrolls down - show scroll to top button
            if (topPos > 500) {
                $('.scrollAnimationToTop').addClass('active');

            } else {
                $('.scrollAnimationToTop').removeClass('active');
            }

        }); // scroll END
      
        //Click event to scroll to top
        $('.scrollAnimationToTop').click(function () {
            $('html, body').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });




    $(".bg-opacity").click(function(){
        $(".success-order").fadeOut();
        $("#bg-opacity").removeClass("bg-opacity");
    });
    $(".success-order").click(function(e){
        e.stopPropagation();
    });

    $name_module = $('#name_module').val();
    // alert($name_module);
    $('#ic_back_click_search').click(function () {
        // alert(123456);
        $(this).css('display','none');
        $('.menu-icon').css('display','block');
        $('.search-icon').css('width','55%');
        $('.dots-icon').css('display','block');
        $('.cart-icon').css('display','block');
        if($name_module!='home'){
            $('.logo-menu').css('display','none');
        }
    });


</script>
<?php } ?>

<?php include 'notification.php'; // thong bao?>

<!-- Use a button to open the snackbar -->
<!-- <button onclick="myFunction()">Show Snackbar</button> -->

<!-- The actual snackbar -->
<div id="snackbar">
    <p></p>
</div>




<style>
    .has_pro_dot{
        position: relative;
    }
    .has_pro_dot:after{
        content: '';
        width: 16px;
        height: 16px;
        border-radius: 50px;
        background: #0f357c;
        position: absolute;
        top: 0px;
        right: 0px;
    }
    .home .has_pro_dot:after{
        right: 7px !important;
    }
</style>