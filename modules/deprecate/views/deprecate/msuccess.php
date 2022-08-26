<?php
global $config,$tmpl;
$tmpl -> addScript('form');
$tmpl -> addScript('deprecate_mobile','modules/deprecate/assets/js');
$tmpl->addStylesheet('deprecate_mobile','modules/deprecate/assets/css');

// popup success
$tmpl->addStylesheet('success_order','modules/paynow/assets/css');
$tmpl -> addScript('success_order','modules/paynow/assets/js');

$tmpl->addTitle ('Tìm sim theo yêu cầu');

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
    <div class="card-header">Điền thông tin tìm sim theo yêu cầu</div>
    <form action="" name="form-default" id="form-default" method="post">
        <div class="box-1">
            <label for="" class="label-requi">
                <input name="deprecate_name" id="deprecate_name" type="text" class="form form-control in-reque" placeholder="Họ tên *">
                <span class="icon-alert icon_error"><img src="/templates/mobile/images/error_input.png" alt=""></span>
                <span class="icon-alert icon_success"><img src="/templates/mobile/images/success_input.png" alt=""></span>
            </label>
            <label for="" class="label-requi">
                <input name="deprecate_phone" id="deprecate_phone" type="text" class="form form-control in-reque" placeholder="Điện thoại *">
                <span class="icon-alert icon_error"><img src="/templates/mobile/images/error_input.png" alt=""></span>
                <span class="icon-alert icon_success"><img src="/templates/mobile/images/success_input.png" alt=""></span>
            </label>
            <label for="" class="label-requi">
                <input name="deprecate_address" id="deprecate_address" type="text" class="form form-control in-reque" placeholder="Địa chỉ *">
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
                <input name="deprecate_email" id="deprecate_email" type="text" class="form form-control in-reque" placeholder="Email">
                <span class="icon-alert icon_error"><img src="/templates/mobile/images/error_input.png" alt=""></span>
                <span class="icon-alert icon_success"><img src="/templates/mobile/images/success_input.png" alt=""></span>
            </label>
            <textarea id="deprecate_comment" name="deprecate_comment" rows="3" class="form form-control in-reque in-texa" placeholder="Ghi chú"></textarea>
            <p class="customer-note"><span>Khách hàng lưu ý: </span>Những đơn đặt hàng đầy đủ thông tin cần thiết (*) và được viết bằng tiếng Việt có dấu là những đơn đặt hàng chính xác.</p>
        </div>
        <div class="box-2">
            <label for="" class="label-requi">
                <input name="deprecate_six" id="deprecate_six" type="text" class="form form-control in-reque" placeholder="6 số sim cuối trở xuống muốn tìm">
                <span class="icon-alert icon_error"><img src="/templates/mobile/images/error_input.png" alt=""></span>
                <span class="icon-alert icon_success"><img src="/templates/mobile/images/success_input.png" alt=""></span>
            </label>
            <label for="" class="label-requi">
                <input name="deprecate_price" id="deprecate_price" type="text" class="form form-control in-reque" placeholder="Giá tiền mong muốn">
                <span class="icon-alert icon_error"><img src="/templates/mobile/images/error_input.png" alt=""></span>
                <span class="icon-alert icon_success"><img src="/templates/mobile/images/success_input.png" alt=""></span>
            </label>
            <div class="customer-note note">
                <p class="tit-note"><span>Lưu ý: </span></p>
                <p class="bod-not">
                    + Chỉ nhận tìm kiếm sim theo 6 số điện thoại cuối trở xuống. Không nhận tìm kiếm sim theo điều kiện không cụ thể như: hợp mệnh, hợp phong thủy, tìm theo tổng nút, tổng điểm…. <br/>
                    + Thời gian tối đa để chờ kết quả là trong 72h kể từ khi có nhân viên liên hệ KH để xác nhận lại nhu cầu tìm sim.
                </p>
            </div>
            <!--            <button class="btn btn-primary sub-requi">Xác nhận tìm sim theo yêu cầu</button>-->
            <a href="javascript: void(0)" id="submitbt" class="btn btn-primary sub-requi">Xác nhận tìm sim theo yêu cầu</a>
            <input type="hidden" name="module" value="deprecate"/>
            <input type="hidden" name="task" value="save"/>
            <input type="hidden" name="view" value="deprecate"/>
        </div>
    </form>

</div>
<div class="success-order">
    <div class="bg-black">
        <div class="body">
            <button type="button" class="close pull-right close-pup">
                <img src="/templates/default/images/icon-close-pupup.png" alt="">
            </button>
            <p class="hea-text">Gửi tìm sim theo yêu cầu <br/> thành công !</p>
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

