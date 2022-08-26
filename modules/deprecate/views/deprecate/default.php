<?php
    global $config,$tmpl; 
    $tmpl -> addScript('form');
    $tmpl -> addScript('deprecate','modules/deprecate/assets/js');
    $tmpl->addStylesheet('deprecate','modules/deprecate/assets/css');
    $tmpl -> addScript("autoNumeric","templates/default/js");
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
<!--Beadcrumb-->
<?php //$tmpl->load_direct_blocks('breadcrumbs'); ?>
<!--Home home-->
<div class="container home-search-demand">
    <h1 class="title-top">Điền thông tin tìm sim theo yêu cầu</h1>
    <form action="" class="form-default" name="form-default" id="form-default" method="post">
        <div class="row">
            <div class="col-md-6 item-left">
                <div class="form-group item-position">
                    <input type="text" class="form-control text-border" name="deprecate_name" id="deprecate_name" placeholder="Họ tên *">
                    <p id="show-error-name" class="error-name">Quý khách chưa nhập họ tên</p>
                </div>
                <div class="form-group item-position">
                    <input type="text" class="form-control text-border" name="deprecate_phone" id="deprecate_phone" placeholder="Điện thoại *">
                    <p id="show-error-phone" class="error-phone">Quý khách chưa nhập số điện thoại</p>
                </div>
                <div class="form-group item-position">
                    <input type="text" class="form-control text-border" name="deprecate_address" id="deprecate_address" placeholder="Địa chỉ *">
                    <p id="show-error-address" class="error-address">Quý khách chưa nhập địa chỉ</p>
                </div>
                <div class="form-group item-position">
                    <!--Thể loại sim-->
                    <input type="hidden" id="selected-city" name="select-city" value="">
                    <div class="select-city">
                        <div class="value-city form-control text-border">Tỉnh/ Thành phố *</div>
                    </div>
                    <div class="ver3 options" id="options-select-city">
                        <div class="scroll-y" style="height: 200px !important;">
                            <?php foreach ($getCity as $item){ ?>
                                <div class="option" value="<?php echo $item->id?>" data-name="<?php echo $item->name?>" data-placement="bottom" data-toggle="tooltip"><?php echo $item->name ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <p id="show-error-city" class="error-city">Quý khách chưa chọn Tỉnh/TP</p>
                </div>
                <div class="form-group item-position">
                    <input type="text" class="form-control text-border" name="deprecate_email" id="deprecate_email" placeholder="Email">
                    <p id="show-error-email" class="error-email">Quý khách nhập sai định dạng email</p>
                </div>

                <label for="comment">Ghi chú:</label>
                <textarea class="form-control text-note" rows="5" id="deprecate_comment" name="deprecate_comment"></textarea>

                <p class="customer-note">
                Khách hàng lưu ý: Những đơn đặt hàng đầy đủ thông tin cần thiết (*) và được  viết bằng tiếng việt có dấu là những đơn đặt hàng chính xác.
                </p>
            </div>
            <div class="col-md-6 item-right">
                <div class="form-group item-position">
                    <input onkeypress="return isNumber(event)" type="text" class="form-control input-text input-text-2" name="deprecate_six" id="deprecate_six" placeholder="Nhập 6 số sim cuối">
                    <p id="show-error-six" class="error-six">Vui lòng nhập 6 số sim cuối</p>
                </div>
                <div class="form-group item-position">
                    <input data-v-min="0" data-v-max="999999999999" type="text" class="form-control input-text input-text-2 numeric" name="deprecate_price" id="deprecate_price" placeholder="Giá tiền mua mong muốn">
                     <p id="show-error-price" class="error-price">Vui lòng nhập giá tiền</p>
                </div>
                    <p class="note">Lưu ý:</p>
                <p>
                    + Chỉ nhận tìm kiếm sim theo 6 số điện thoại cuối trở xuống. Không nhận tìm kiếm sim theo điều kiện
                    không cụ thể như: hợp mệnh, hợp phong thủy, tìm theo tổng nút, tổng điểm….
                </p>
                <p>
                    + Thời gian tối đa để chờ kết quả là trong 72h kể từ khi có nhân viên liên hệ KH để xác nhận lại nhu
                    cầu tìm sim.
                </p>
                <a href="javascript: void(0)" id="submitbt" class="btn btn-primary btn-send">Xác nhận tìm sim theo yêu cầu</a>
                <input type="hidden" name="module" value="deprecate"/>
                <input type="hidden" name="task" value="save"/>
                <input type="hidden" name="view" value="deprecate"/>
            </div>
        </div>
    </form>
</div>




<!--<div class="contact-main row-item">-->
<!--	<h1 class="title-module">-->
<!--		<span>--><?php //echo FSText::_("Thông tin liên hệ"); ?><!--</span>-->
<!--	</h1><!-- END: .name-contact -->
<!--    -->
<!--    <!--<h2 class="title-content">-->
<!--        --><?php ////echo $config['title_contact'] ?>
<!--        CÔNG TY tnhh công nghệ và năng lượng <span>sptec</span> việt nam-->
<!--    </h2> -->
<!--    -->
<!--	<div class="wapper-content-page row">-->
<!--        <div class="col-xs-12 col-sm-12 col-info">-->
<!--            --><?php // include_once 'default_info.php'; ?>
<!--        </div>-->
<!--        -->
<!--        <div class="col-xs-12 col-sm-6">-->
<!--			--><?php //include_once 'default_from.php'; ?>
<!--		</div>-->
<!--        -->
<!--        <div class="col-xs-12 col-sm-6"> -->
<!--	       --><?php //include_once 'default_map.php';?>
<!--	   </div><!-- END: .map -->
<!--	</div><!-- END: .wapper-content-page -->
<!--</div><!-- END: .contact -->
