<?php
    global $config,$tmpl; 
    $tmpl -> addScript('form');
    $tmpl -> addScript('signedsim','modules/signedsim/assets/js');
    $tmpl->addStylesheet('signedsim','modules/signedsim/assets/css');
    $tmpl->addStylesheet('deprecate','modules/deprecate/assets/css');
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
<!--Beadcrumb-->
<?php //$tmpl->load_direct_blocks('breadcrumbs'); ?>
<!--Home home-->
<div class="container home-search-demand home-deposit">
    <h1 class="title-top">Điền thông tin ký gửi sim</h1>
    <form action="" class="form-default" name="form-default" id="form-default" method="post">
        <div class="row">
            <div class="col-md-6 item-left">
                <div class="form-group item-position">
                    <input type="text" class="form-control text-border" name="signed_name" id="signed_name" placeholder="Họ tên *">
                    <p id="show-error-name" class="error-name">Quý khách chưa nhập họ tên</p>
                </div>
                <div class="form-group item-position">
                    <input type="text" class="form-control text-border" name="signed_phone" id="signed_phone" placeholder="Điện thoại *">
                    <p id="show-error-phone" class="error-phone">Quý khách chưa nhập số điện thoại</p>
                </div>
                <div class="form-group item-position">
                    <input type="text" class="form-control text-border" name="signed_address" id="signed_address" placeholder="Địa chỉ *">
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
                    <p id="show-error-city" class="error-phone">Quý khách chưa chọn Tỉnh/TP</p>
                </div>
                <div class="form-group item-position">
                    <input type="text" class="form-control text-border" name="signed_email" id="signed_email" placeholder="Email">
                    <p id="show-error-email" class="error-email">Quý khách nhập sai định dạng email</p>
                </div>

                <label for="comment">Ghi chú:</label>
                <textarea class="form-control text-note" rows="5" id="signed_comment" name="signed_comment"></textarea>
                <p class="customer-note">
                    Khách hàng lưu ý: Những đơn đặt hàng đầy đủ thông tin cần thiết (*) và được  viết bằng tiếng việt có dấu là những đơn đặt hàng chính xác.
                </p>
            </div>
            <div class="col-md-6 item-right">
                <div class="show-hover">
                    <div class="form-group item-position">
                        <input onkeypress="return isNumber(event)" type="text" class="form-control input-text input-text-2" placeholder="Số sim muốn ký gửi" id="number_sim" name="number_sim">
                        <p id="show-error-number-sim" class="error-number-sim">SĐT gồm 10 số, bắt đầu từ số 0
                        </p>
                    </div>
                    <div class="box-hover">
                        <p>
                            Quý khách vui lòng dùng số điện thoại <span class="reload-phone">09xxxxxxxx</span> soạn tin nhắn với nội dung: <span>"Ký gửi sim </span> <span class="reload-phone">09xxxxxxxx</span> <span>gửi đến 0976898989"</span> để tiến hành xác nhận giao dịch ký gửi sim. Xin cảm ơn!
                        </p>
                    </div>
                </div>
                <div class="form-group item-position">
                    <input data-v-min="0" data-v-max="999999999999" type="text" class="form-control input-text input-text-2 numeric" name="price_sell" id="price_sell" placeholder="Giá tiền muốn bán">
                     <p id="show-error-price-sell" class="error-price-sell">Quý khách phải nhập số</p>
                </div>
                <div class="form-group item-position">
                    <input onkeypress="return isNumber(event)" type="text" class="form-control input-text input-text-2" name="percent_brokers" id="percent_brokers" placeholder="% sẽ trả cho môi giới">
                    <p id="show-error-percent-brokers" class="error-percent-brokers">Quý khách nhập từ 15-100</p>
                </div>
                <p>
                    <strong>Lưu ý:</strong> Để kiểm tra tính chính xác của giao dịch ký gửi, nhân viên sẽ liên hệ vào sim số điện thoại muốn bán để xác nhận trong vòng 24h kể từ khi quý khách muốn đăng ký ký gửi sim.
                </p>
                <p>
                    Chỉ nhận ký gửi sim có giá trị từ 10tr trở lên. % tối thiểu dành cho môi giới từ 15% trở lên. Người bán và người mua giao dịch tại CH của web. Người bán và người mua thỏa thuận trách nhiệm và quyền lợi với nhau khi giao dịch
                </p>
                <a href="javascript: void(0)" id="submitbt" class="btn btn-primary btn-send">Xác nhận ký gửi sim</a>
                <input type="hidden" name="module" value="signedsim"/>
                <input type="hidden" name="task" value="save"/>
                <input type="hidden" name="view" value="signedsim"/>
            </div>
        </div>
    </form>
</div>
<!--<img src="/templates/default/images/img_svg/trangchu/3dot.svg" alt="" class="content-home center_page">-->

