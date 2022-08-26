<?php
	global $tmpl, $config;
	$tmpl->addStylesheet('thanhtoan','templates/mobile/css');
	$tmpl->addStylesheet('timsimtheoyeucau','templates/mobile/css');

	$tmpl -> addScript('form');
	// $tmpl -> addScript('deprecate','modules/deprecate/assets/js');
	$tmpl -> addScript('cart_mobile','modules/paynow/assets/js');
?>

<input type="hidden" id="url_root" value="<?php echo URL_ROOT?>">
<input type="hidden" id="click-city" value="">
<input type="hidden" id="click-method" value="">

    <!--Home home-->
    <div class="show-cart-top">
        <h1 class="title-h-b">Đặt mua sim<?php if(count($orderSims) == 1) echo ": ".$orderSims[0]->sim ?></h1>
        <div class="box-code">
            <p>Nhập mã khách hàng (nếu có):</p>
            <input id="code" type="text" class="form-control code-customer">
            <button  id="check_code" class="btn btn-primary enter-code">Áp dụng</button>
        </div>
        <div class="policy-cart">
            <p class="note-pol">* Mã khách hàng sẽ tự động gửi đến quý khách từ lần mua sim thành công thứ 2</p>
            <div class="other-pol">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapsePol" aria-expanded="false" aria-controls="collapsePol">
                    Quyền lợi khi có mã khách hàng
                </button>
                <div id="collapsePol" class="collapse tog-show">
                    <?php echo $config['note_pay']?>
                </div>
            </div>
        </div>
        <table class="table-quick-cart table-cart">
            <thead>
            <tr>
                <th width="15%"></th>
                <th width="50%"><p class="back-head">Sim</p></th>
                <th width="35%"><p class="back-head" style="padding: 21px 0px 21px 55px;">Giá tiền</p></th>
            </tr>
            </thead>
            <tbody>
            <?php $total=0; foreach ($orderSims as $item){
                $total = $item->price_public + $total;
                ?>	
            <tr class="row_<?php echo $item->number ?>">
                <td class="tze">
                    <a data="<?php echo $item->number ?>" class="icon_delete" href="javascript:void(0)">
                        <img src="/templates/mobile/images/img_svg/trang_chu/gio_hang/delete.svg" alt=""/>
                    </a>
                </td>
                <td class="first">
                    <p class="title-bold phone-number"><?php echo $item->sim?></p>
                    <p class="phone-network"><?php echo $item->network?></p>
                    <p class="phone-type">Thể loại: <?php $ar_type = explode(',',trim($item->cat_name, ',')); echo $ar_type[0]; ?></p>
                    <p class="phone-point">Điểm: <?php echo $item->point?></p>
                </td>
                <td class="second">
                    <p class="phone-price"><?php echo number_format($item->price_public, 0, ',', '.') ?> đ</p>
                    <p class="date-edit">Ngày cập nhật <?php echo date('d/m/Y', strtotime($item->created_time)); ?></p>
                </td>
            </tr>
            <?php }?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3">
                    <div class="total-pay total-def" >
                        <h3 class="title-hea">Tổng cộng : <span id="total_ori"><?php echo number_format($total, 0, ',', '.') ?></span> đ</h3>
                        <p>Khuyến mãi: <span id="member_sales">0% khách hàng mới</span></p>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="total-pay" >
                        <h3 class="title-hea">Tổng thanh toán : <span id="m_totalend"><?php echo number_format($total, 0, ',', '.') ?> đ</span></h3>
                        <p id="m_totalend_word">(<?php echo ucfirst(convert_number_to_words($total)).' đồng' ?>)</p>
                    </div>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
    <!-- -->
    <div class="form-required form-pay">
        <form action="#" class="form-default" name="form-default" id="form-default" method="post">
            <h2 class="card-header">Điền thông tin thanh toán</h2>
            <div class="box-1">
                <label for="" class="label-requi item-position">
                    <input type="text" class="form form-control in-reque" name="deprecate_name" id="deprecate_name" placeholder="Họ tên *">
                    <span class="icon-alert icon_error"><img src="/templates/mobile/images/img_svg/ki_gui_sim/caution.svg" alt=""></span>
                    <span class="icon-alert icon_success"><img src="/templates/mobile/images/img_svg/ki_gui_sim/content_ok.svg" alt=""></span>
                </label>
                <label for="" class="label-requi item-position">
                    <input type="text" class="form form-control in-reque" name="deprecate_phone" id="deprecate_phone" placeholder="Điện thoại *">
                    <span class="icon-alert icon_error"><img src="/templates/mobile/images/img_svg/ki_gui_sim/caution.svg" alt=""></span>
                    <span class="icon-alert icon_success"><img src="/templates/mobile/images/img_svg/ki_gui_sim/content_ok.svg" alt=""></span>
                </label>
                <label for="" class="label-requi item-position">
                    <input type="text" class="form form-control in-reque" name="deprecate_address" id="deprecate_address" placeholder="Địa chỉ *">
                    <span class="icon-alert icon_error"><img src="/templates/mobile/images/img_svg/ki_gui_sim/caution.svg" alt=""></span>
                    <span class="icon-alert icon_success"><img src="/templates/mobile/images/img_svg/ki_gui_sim/content_ok.svg" alt=""></span>
                </label>
                <div class="SumoSelect item-position">
                    <select name="select-city" id="selected-city" class="select-paymethod text-border">
                    	<option value="">Tỉnh/ Thành phố *</option>
                    	<?php foreach ($getCity as $item){ ?>
                            <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                        <?php } ?>
                    </select>
                    <span class="icon-alert icon_error" style="top: 10px;"><img src="/templates/mobile/images/img_svg/ki_gui_sim/caution.svg" alt=""></span>
                    <span class="icon-alert icon_success" style="top: 15px;"><img src="/templates/mobile/images/img_svg/ki_gui_sim/content_ok.svg" alt=""></span>
                </div>
                <label for="" class="label-requi item-position">
                    <input type="text" class="form form-control in-reque" name="deprecate_email" id="deprecate_email" placeholder="Email">
                    <span class="icon-alert icon_error"><img src="/templates/mobile/images/img_svg/ki_gui_sim/caution.svg" alt=""></span>
                    <span class="icon-alert icon_success"><img src="/templates/mobile/images/img_svg/ki_gui_sim/content_ok.svg" alt=""></span>
                </label>
                <div class="SumoSelect item-position">
                    <select name="select-paymethod" id="selected-paymethod" class="select-paymethod text-border">
                    	<option value="">Chọn phương thức thanh toán *</option>
                    	<?php foreach ($method as $item) { $hidden ='disabled' ?>
                        	<option class="<?php echo $item->type_id == 1 ? 'hidden':'' ?>" <?php echo $item->type_id == 1 ? $hidden:'' ?> data='<?php echo $item->content ?>' value="<?php echo $item->id ?>"><?php echo $item->title ?></option>
                        <?php } ?>
                    </select>
                    <span class="icon-alert icon_error"><img src="/templates/mobile/images/img_svg/ki_gui_sim/caution.svg" alt=""></span>
                    <span class="icon-alert icon_success"><img src="/templates/mobile/images/img_svg/ki_gui_sim/content_ok.svg" alt=""></span>
                </div>
                <textarea rows="3" class="form form-control in-reque in-texa" id="comment" name="comment" placeholder="Ghi chú"></textarea>
                <p class="customer-note"><span>Khách hàng lưu ý: </span>Những đơn đặt hàng đầy đủ thông tin cần thiết (*) và được viết bằng tiếng Việt có dấu là những đơn đặt hàng chính xác.</p>
            </div>
            <div class="box-process">
                <img style="width: 30px;" src="/templates/mobile/images/img_svg/trang_chu/process-01.svg" alt="">
            </div>
            <h2 class="card-header">Kiểm tra đơn hàng</h2>
            <div class="box-2">
                <p class="date-order">Đơn hàng đặt <?php echo $time = date("H:i, d/m/Y"); ?></p>
                <p class="total-pay">Tổng cộng: <span id="ex_total"><?php echo number_format($total, 0, ',', '.') ?> đ</span></p>
                <p class="detail-cust">Khách hàng: <span class="deprecate_name"></span></p>
                <p class="detail-cust">Số điện thoại: <span class="deprecate_phone"></span></p>
                <p class="detail-cust">Địa chỉ: <span class="deprecate_address"></span></p>
                <p class="detail-cust">Email: <span class="deprecate_email"></span></p>
                <p class="detail-cust">Tỉnh/ Thành phố: <span class="deprecate_city"></span></p>
                <p class="note-cust">Ghi chú: <span class="comment"></span></p>
                <p class="pay-type">Hình thức thanh toán: <span class="method_pay"></span></p>
                <p class="note1 method_des"></p>
<!--                <p class="note1 note3"><span>Lưu ý:</span> Nếu trong giỏ hàng của quý khách đang có quá 03 sim thì vui lòng xóa bớt sim để đủ điều kiện thực hiện giao dịch giữ sim.</p>-->
                <div class="btn-sub-dh">
                    <a href="javascript: void(0)" id="submitbt" class="btn btn-primary btn-send sub-requi">Xác nhận đơn hàng</a>
                </div>

                <input type="hidden" id="totalmoney" name="totalmoney" value="<?php echo $total ?>">
                <input type="hidden" id="totalafter" name="totalafter" value="<?php echo $total ?>">
                <input type="hidden" name="code" id="code_f" value=""/>
                <input type="hidden" name="discount" id="discount" value=""/>
                <input type="hidden" name="discount_unit" id="discount_unit" value=""/>
                <input type="hidden" name="discount_name" id="discount_name" value=""/>
                <input type="hidden" name="gift" id="gift" value=""/>
                <input type="hidden" name="module" value="paynow"/>
                <input type="hidden" name="view" value="paynow"/>
                <input type="hidden" name="task" value="save_order"/>

            </div>
        </form>
    </div>
