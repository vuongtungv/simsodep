<?php
global $config,$tmpl;
$tmpl -> addScript('form');
$tmpl -> addScript('singedsim_mobile','modules/signedsim/assets/js');
$tmpl->addStylesheet('singedsim_mobile','modules/signedsim/assets/css');
$tmpl->addStylesheet('deprecate_mobile','modules/deprecate/assets/css');

// popup success
$tmpl->addStylesheet('success_order','modules/paynow/assets/css');
$tmpl -> addScript('success_order','modules/paynow/assets/js');

$tmpl->addTitle ('Ký gửi sim');

$Itemid = FSInput::get('Itemid',0);
$contact_email = FSInput::get('contact_email');
$contact_name = FSInput::get('contact_name');
$contact_address = FSInput::get('contact_address');
$contact_group = FSInput::get('contact_group');
$contact_title = FSInput::get('contact_title');
$contact_parts = FSInput::get('contact_parts');
$message = htmlspecialchars_decode(FSInput::get('message'));



?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<!-- -->
<div class="form-required">
    <div class="card-header">Điền thông tin ký gửi sim</div>
    <form action="" name="form-default" id="form-default" method="post">
        <div class="box-1">
            <label for="" class="label-requi">
                <input name="signed_name" id="signed_name" type="text" class="form form-control in-reque" placeholder="Họ tên *">
                <span class="icon-alert icon_error"><img src="/templates/mobile/images/error_input.png" alt=""></span>
                <span class="icon-alert icon_success"><img src="/templates/mobile/images/success_input.png" alt=""></span>
            </label>
            <label for="" class="label-requi">
                <input name="signed_phone" id="signed_phone" type="text" class="form form-control in-reque" placeholder="Điện thoại *">
                <span class="icon-alert icon_error"><img src="/templates/mobile/images/error_input.png" alt=""></span>
                <span class="icon-alert icon_success"><img src="/templates/mobile/images/success_input.png" alt=""></span>
            </label>
            <label for="" class="label-requi">
                <input name="signed_address" id="signed_address" type="text" class="form form-control in-reque" placeholder="Địa chỉ *">
                <span class="icon-alert icon_error"><img src="/templates/mobile/images/error_input.png" alt=""></span>
                <span class="icon-alert icon_success"><img src="/templates/mobile/images/success_input.png" alt=""></span>
            </label>
            <label for="" class="label-requi">
                <select style="height: 112px;-moz-appearance: none;-webkit-appearance: none;appearance: none;" name="select-city" id="select-city" class="form form-control in-reque">
                    <option value="">Tỉnh / TP *</option>
                    <?php foreach ($getCity as $it_ct){?>
                        <option value="<?php echo $it_ct->id?>"><?php echo $it_ct->name?></option>
                    <?php }?>
                </select>
                <!--                <input name="signed_address" id="signed_address" type="text" class="form form-control in-reque" placeholder="Địa chỉ *">-->
                <span class="icon-alert icon_error"><img src="/templates/mobile/images/error_input.png" alt=""></span>
                <span class="icon-alert icon_success"><img src="/templates/mobile/images/success_input.png" alt=""></span>
            </label>
            <label for="" class="label-requi">
                <input name="signed_email" id="signed_email" type="text" class="form form-control in-reque" placeholder="Email">
                <span class="icon-alert icon_error"><img src="/templates/mobile/images/error_input.png" alt=""></span>
                <span class="icon-alert icon_success"><img src="/templates/mobile/images/success_input.png" alt=""></span>
            </label>
            <textarea id="signed_comment" name="signed_comment" rows="3" class="form form-control in-reque in-texa" placeholder="Ghi chú"></textarea>
            <p class="customer-note"><span>Khách hàng lưu ý: </span>Những đơn đặt hàng đầy đủ thông tin cần thiết (*) và được viết bằng tiếng Việt có dấu là những đơn đặt hàng chính xác.</p>
        </div>
        <div class="box-2">
            <div class="show-hover">
                <label for="" class="label-requi">
                    <input id="number_sim" name="number_sim" type="text" class="form form-control in-reque" placeholder="Số sim muốn ký gửi">
                    <span class="icon-alert icon_error"><img src="/templates/mobile/images/error_input.png" alt=""></span>
                    <span class="icon-alert icon_success"><img src="/templates/mobile/images/success_input.png" alt=""></span>
                </label>
                <div class="box-hover">
                    <p>
                        Quý khách vui lòng dùng số điện thoại <span class="reload-phone">09xxxxxxxx</span> soạn tin nhắn với nội dung: <span>"Ký gửi sim </span> <span class="reload-phone">09xxxxxxxx</span> <span>gửi đến 0976898989"</span> để tiến hành xác nhận giao dịch ký gửi sim. Xin cảm ơn!
                    </p>
                </div>
            </div>
            <label for="" class="label-requi">
                <input name="price_sell" id="price_sell" type="text" class="form form-control in-reque" placeholder="Giá tiền muốn bán">
                <span class="icon-alert icon_error"><img src="/templates/mobile/images/error_input.png" alt=""></span>
                <span class="icon-alert icon_success"><img src="/templates/mobile/images/success_input.png" alt=""></span>
            </label>
            <label for="" class="label-requi">
                <input name="percent_brokers" id="percent_brokers" type="text" class="form form-control in-reque" placeholder="% cho môi giới (bao gồm trong giá bán)">
                <span class="icon-alert icon_error"><img src="/templates/mobile/images/error_input.png" alt=""></span>
                <span class="icon-alert icon_success"><img src="/templates/mobile/images/success_input.png" alt=""></span>
            </label>
            <div class="customer-note note">
                <p class="tit-note"><span>Lưu ý:</span> Để kiểm tra tính chính xác của giao dịch ký gửi, nhân viên sẽ liên hệ vào sim số điện thoại muốn bán để xác nhận trong vòng 24h kể từ khi quý khách muốn đăng ký ký gửi sim.</p>
                <p class="bod-not">
                    Chỉ nhận ký gửi sim có giá trị từ 10tr trở lên. % tối thiểu dành cho môi giới từ 15% trở lên. Người bán và người mua giao dịch tại CH của web. Người bán và người mua thỏa thuận trách nhiệm và quyền lợi với nhau khi giao dịch
                </p>
            </div>
            <a href="javascript: void(0)" id="submitbt" class="btn btn-primary sub-requi">Xác nhận ký gửi sim</a>
            <input type="hidden" name="module" value="signedsim"/>
            <input type="hidden" name="task" value="save"/>
            <input type="hidden" name="view" value="signedsim"/>
        </div>
    </form>

</div>



<div class="success-order">
    <div class="bg-black">
        <div class="body">
            <button type="button" class="close pull-left close-pup">
                <img src="/templates/default/images/icon-close-pupup.png" alt="">
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


<div id="snackbar-signedsim" class="">
    <p>Thêm vào giỏ hàng thành công !</p>
</div>

<style>
    .box-hover{
        background: #f4f4f4;
        padding: 15px;
        position: relative;
        margin-bottom: 14px;
        display: none;
        top: -9px;
        border-radius: 10px;
    }
    .box-hover:before{
        content: '';
        position: absolute;
        transform: rotate(45deg);
        width: 40px;
        height: 40px;
        top: -20px;
        left: 33px;
        z-index: 1;
        background: #f4f4f4;
    }
    .box-hover p{
        font-family: Roboto-Regular;
        font-size: 36px;
    }
    .box-hover p span{
        font-family: Roboto-Bold;
    }

    .success-order{
        top: 0px;
    }
    .bg-black{
        width: unset !important;
        height:unset !important;
    }
    .hea-text{
        width: 715px !important;
        font-size: 44px !important;
        padding: 15px;
        line-height: 65px !important;
    }
    .detal{
        font-size: 44px !important;
    }
    .close-pup{
        right: 40px !important;
    }
    .close-pup img{
        width: 250%;
    }
</style>