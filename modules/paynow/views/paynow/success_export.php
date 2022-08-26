<?php
global $tmpl, $config;
$tmpl->addTitle('Hóa đơn');
$tmpl->addStylesheet('bill','modules/paynow/assets/css');
$tmpl->addStylesheet('success_order','modules/paynow/assets/css');
$tmpl -> addScript('success_order','modules/paynow/assets/js');


?>

<!-- Company-contact -->
<div class="container company-bill">
    <div class="row" style="border-bottom: 2px solid #d8d7d7; padding-bottom: 40px;display: flex;">
        <div class="img-logo" style="width: 40%">
            <a href="<?php echo URL_ROOT?>"><img style="width: 75%" src="<?php echo URL_ROOT?>/templates/default/images/img_svg/trangchu/logo.svg" alt=""></a>
        </div>
        <div class="infor-company" style="width: 60%">
            <?php echo $config['header_bill']?>
        </div>
    </div>
</div>

<div class="container status-customer" style="display: flex; padding: 30px 83px 0px; background: #fffffF;">
    <div class="left-bi" style="width: 70%">
        <h2 style="text-transform: uppercase; margin-bottom: 5px;font-family: Text-Bold;">Hóa đơn bán hàng</h2>
        <p style="margin-bottom:0px; font-size: 16px;"><span style="padding-right: 10px;">Mã đơn hàng: <?php echo $order->code ?></span>                  Đơn đặt hàng ngày: <?php echo date('d/m/y   H:s',strtotime($order->created_time)) ?></p>
    </div>
    <div class="right" style="width: 30%">
        <p style="text-align: right; margin-bottom: 10px; font-family: Text-Bold">Trạng thái thanh toán</p>
        <div style="background: #e74c3c ;padding: 8px;text-align: center; border-radius: 5px;text-transform: uppercase; color: #FFFFFF; float:right; width: 210px; font-family: Text-Bold">Chưa thanh toán</div>
    </div>
</div>


<!--Content home -->
<div class="container content-bill">

    <div class="infor-customer" style="padding-top: 30px;">
        <table>
<!--            <tr>-->
<!--                <td>Mã đơn hàng<span>:</span></td>-->
<!--                <td>--><?php //echo $order->code ?><!--</td>-->
<!--            </tr>-->
            <tr>
                <td>Khách hàng<span>:</span></td>
                <td><?php echo $order->recipients_name ?></td>
            </tr>
            <tr>
                <td>Số điện thoại<span>:</span></td>
                <td><?php echo $order->recipients_mobilephone ?></td>
            </tr>
            <tr>
                <td>Địa chỉ<span>:</span></td>
                <td><?php echo $order->recipients_address ?></td>
            </tr>
            <tr>
                <td>Email<span>:</span></td>
                <td><?php echo $order->recipients_email ?></td>
            </tr>
            <tr>
                <td>Ghi chú <span>:</span></td>
                <td><?php echo $order->recipients_comments ?></td>
            </tr>
        </table>
    </div>
    <div class="table-order">
        <table class="table table-default">
            <thead>
                <tr>
                    <th scope="col"><span>Số sim</span></th>
                    <th scope="col"><span>Nhà mạng</span></th>
                    <th scope="col"><span>Thể loại</span></th>
                    <th scope="col"><span>Điểm</span></th>
                    <th scope="col"><span>Ngày cập nhật</span></th>
                    <th scope="col"><span>Giá tiền</span></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $item ) { ?>
                    <tr>
                        <td><?php echo $item->sim ?></td>
                        <td><?php echo $item->network ?></td>
                        <td>
                            <?php $ar_type = explode(',',trim($item->cat_name, ','));
                            echo $ar_type[0];
                            ?>
                        </td>
                        <td><?php echo $item->point ?></td>
                        <td><?php echo date('d/m/y   H:s',strtotime($item->time_create)) ?></td>
                        <td><?php echo format_money($item->price_public,' đ') ?></td>
                    </tr>
                <?php  } ?>
            </tbody>
        </table>
    </div>
    <div class="box-total">
        <table>
            <tr>
                <td>Tổng cộng<span>:</span></td>
                <td><?php echo format_money($order->total_before,' đ') ?></td>
            </tr>
            <tr>
                <td>Khuyến mãi<span>:</span></td>
                <td>
                    <?php 
                        $discount = '0%';
                        $gift = '';
                        $d_name = '';
                        if ($order->discount_unit == 'price') {
                            $discount = format_money($order->discount_value,' đ');
                        }
                        if ($order->discount_unit == 'percent') {
                            $discount = $order->discount_value.'%';
                        }
                        if ($order->discount_name) {
                            $d_name = ' - '.$order->discount_name;
                        }
                        if ($order->gift) {
                            $gift = ' và '.$order->gift;
                        }
                        echo $discount.$d_name.$gift;
                    ?>
                 </td>
            </tr>
            <tr>
                <td>Tổng thanh toán<span>:</span></td>
                <td><?php echo format_money($order->total_end,' đ') ?> (<?php echo int_to_words($order->total_end).' đồng' ?>)</td>
            </tr>
        </table>
    </div>
    <div class="bill-note">
        <p class="top">Hình thức thanh toán:  <span><?php echo $method->title ?></span></p>
<!--        --><?php //echo $method->content ?>
    </div>
<!--    <p class="download_pdf"><a href="--><?php //echo FSRoute::_('index.php?module=paynow&view=paynow&task=pdf_success&raw=1')?><!--"><img src="/templates/default/images/icon-download.png" alt="">&nbsp;&nbsp; Xuất đơn hàng</a></p>-->
</div>




<!--Footer-->
<div class="container footer-bill" style="position: relative;">
    <?php echo $config['footer_bill']?>
    <img src="<?php echo URL_ROOT?>/templates/default/images/bill-07-08-19.png" style="position: absolute;top:25px;right: 100px;width: 20%">
</div>


<style>
    body{
        background: #fffffF;
    }
    .css_fix_top_menu{
        display: none !important;
    }
</style>