<?php
global $tmpl, $config;
$tmpl->addTitle('Thanh toán');
$tmpl->addStylesheet('default','modules/paynow/assets/css');
$tmpl->addStylesheet('deprecate','modules/deprecate/assets/css');
$tmpl -> addScript('form');
$tmpl -> addScript('deprecate','modules/deprecate/assets/js');
$tmpl -> addScript('cart','modules/paynow/assets/js');
$Itemid = 2;
$_SERVER['REQUEST_URI'];
// var_dump($_SESSION['cart']);
?>
<input type="hidden" id="url_root" value="<?php echo URL_ROOT?>">
<input type="hidden" id="click-city" value="">
<input type="hidden" id="click-method" value="">
<?php //$tmpl->load_direct_blocks('breadcrumbs'); ?>

<!--Home home-->
<div class="container bg-title-pay">
    <h1 class="title-h-b">Đặt mua sim<?php if(count($orderSims) == 1) echo ": ".$orderSims[0]->sim ?></h1>
</div>
<div class="container show-cart-top">
<!--    <h1 class="title-h-b">Đặt mua sim--><?php //if(count($orderSims) == 1) echo ": ".$orderSims[0]->sim ?><!--</h1>-->
    <div class="row">
        <div class="col-md-3 box-code">
            <p>Nhập mã khuyến mại hoặc khách hàng (nếu có):</p>
            <div style="display: flex">
                <input id="code" type="text" class="form-control code-customer">
                <button id="check_code" class="btn btn-primary enter-code">Áp dụng</button>
            </div>
        </div>
        <div class="col-md-9 policy-cart">
            <?php echo $config['note_pay']?>
        </div>
    </div>
    <div class="table-cart">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col"><span>Số sim</span></th>
                <th scope="col"><span>Nhà mạng</span></th>
                <th scope="col"><span>Thể loại</span></th>
                <th scope="col"><span>Điểm</span></th>
                <th scope="col"><span>Ngày cập nhật</span></th>
                <th scope="col"><span>Giá tiền</span></th>
            </tr>
            </thead>
            <tbody>
            <?php $total=0; foreach ($orderSims as $item){
                $total = $item->price_public + $total;
                ?>
                <tr>
                    <td>
                        <span>
                            <a onclick="return confirm('Bạn có muốn xóa khỏi giỏ hàng?')" href="<?php echo FSRoute::_('index.php?module=home&view=home&task=delete&number=' . $item->number) ?>">
<!--                                <i class="fa fa-times" aria-hidden="true"></i></a>-->
                                <i></i>
                        </span>
                    </td>
                    <td><?php echo $item->sim?></td>
                    <td><?php echo $item->network?></td>
                    <td width="147">
                        <?php $ar_type = explode(',',trim($item->cat_name, ','));
                            echo $ar_type[0];
                        ?>
                    </td>
                    <td><?php echo $item->point?></td>
                    <td><?php echo date('d/m/Y', strtotime($item->created_time)); ?></td>
                    <td><?php echo number_format($item->price_public, 0, ',', '.') ?> đ</td>
                </tr>
            <?php }?>
            </tbody>
        </table>
        <div class="row-line">
            <p class="head"><span>Tổng cộng:</span></p>
            <p class="text"><?php echo number_format($total, 0, ',', '.') ?> đ</p>
        </div>
        <div class="row-line">
            <p class="head"><span>Khuyến mãi:</span></p>
            <p class="text" id="member_sales">0% khách hàng mới</p>
        </div>
        <div class="row-line">
            <p class="head"><span>Tổng thanh toán:</span></p>
            <p class="text" id="totalend"><?php echo number_format($total, 0, ',', '.') ?> đ (<?php echo convert_number_to_words($total).' đồng' ?>)</p>
        </div>
    </div>
</div>
<div class="container form-order">
    <div class="header-top">
        <h2 class="title-top">Điền thông tin thanh toán</h2>
        <span class="text-thanh-ngang"><img id="step-success" src="/templates/default/images/img_svg/trangchu/process-02.svg" alt=""/>Kiểm tra đơn hàng</span>
    </div>
    <form action="#" class="form-default" name="form-default" id="form-default" method="post">
        <div class="row">
            <div class="col-md-6 item-left">
                <div class="form-group item-position">
                    <input type="text" class="form-control text-border" name="deprecate_name" id="deprecate_name" placeholder="Họ tên *">
                    <p id="show-error-name" class="error-name">Quý khách chưa nhập họ tên</p>
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                </div>
                <div class="form-group item-position">
                    <input type="text" class="form-control text-border" name="deprecate_phone" id="deprecate_phone" placeholder="Điện thoại *">
                    <p id="show-error-phone" class="error-phone">Quý khách chưa nhập số điện thoại</p>
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                </div>
                <div class="form-group item-position">
                    <input type="text" class="form-control text-border" name="deprecate_address" id="deprecate_address" placeholder="Địa chỉ *">
                    <p id="show-error-address" class="error-address">Quý khách chưa nhập địa chỉ</p>
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
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
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                </div>

                <div class="item-position">
                    <input type="text" class="form-control text-border" name="deprecate_email" id="deprecate_email" placeholder="Email">
                    <p id="show-error-email" class="error-email">Quý khách nhập sai định dạng email</p>
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                </div>

                <div class="form-group SumoSelect item-position">
                    <!--Danh sách sim-->
                    <input type="hidden" id="selected-paymethod" name="select-paymethod" value="">
                    <div class="select-paymethod">
                        <div class="btn btn-primary choose-pay value-paymethod">Chọn phương thức thanh toán</div>
                        <div class="select-dropdown-icon">
                            <!--<i class="fa fa-chevron-down" aria-hidden="true"></i>-->
                        </div>
                        <div class="options">
                            <?php foreach ($method as $item) { $hidden =' style="display:none"' ?>
                                <div class="option select-method <?php echo $item->type_id == 1 ? 'hidden':'' ?>" <?php echo $item->type_id == 1 ? $hidden:'' ?> data-id="<?php echo $item->id ?>" value="<?php echo $item->id ?>" data-placement="bottom" data-toggle="tooltip"><?php echo $item->title ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <p id="show-error-method" class="error-method">Quý khách chưa chọn phương thức thanh toán</p>
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                </div>
                <label for="comment">Ghi chú:</label>
                <textarea class="form-control text-note" rows="5" name="comment" id="comment"></textarea>
                <p class="customer-note">
                    Khách hàng lưu ý: Những đơn đặt hàng đầy đủ thông tin cần thiết (*) và được  viết bằng tiếng việt có dấu là những đơn đặt hàng chính xác.
                </p>
            </div>
            <div class="col-md-6 item-right">
                <div class="date-price">
                    <p>Đơn đặt hàng ngày <?php echo $time = date("Y-m-d H:i:s"); ?></p>
                    <p>Tổng cộng: <span id="ex_total"><?php echo number_format($total, 0, ',', '.') ?> đ</span></p>
                </div>
                <div class="infor-customer">
                    <p>Khách hàng: <span class="deprecate_name"></span></p>
                    <p>Số điện thoại: <span class="deprecate_phone"></span></p>
                    <p>Địa chỉ: <span class="deprecate_address"></span></p>
                    <p>Tỉnh/Thành phố: <span class="deprecate_city"></span></p>
                    <p>Email: <span class="deprecate_email"></span></p>
                    <p>Ghi chú: <span class="comment"></span></p>
                </div>
                <div class="pay-method">
                    <p>Hình thức thanh toán: <span class="method_pay"></span></p>
                    <div class="method_des"></div>
                </div>
            </div>
            <div class="col-md-12">
                <a href="javascript: void(0)" id="submitbt" class="btn btn-primary btn-send">Xác nhận đơn hàng</a>
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

        </div>
    </form>
</div>