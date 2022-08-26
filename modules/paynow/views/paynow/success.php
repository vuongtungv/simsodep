<?php
global $tmpl, $config;
$tmpl->addTitle('Hóa đơn');
$tmpl->addStylesheet('bill','modules/paynow/assets/css');
$tmpl->addStylesheet('success_order','modules/paynow/assets/css');
$tmpl -> addScript('success_order','modules/paynow/assets/js');


?>

<!-- Company-contact -->
<div class="container company-bill">
    <div class="row">
        <div class="col-md-4 img-logo">
            <a href="<?php echo URL_ROOT?>"><img src="<?php echo URL_ROOT.$config['logo']?>" alt=""></a>
        </div>
        <div class="col-md-8 infor-company">
            <?php echo $config['header_bill']?>
        </div>
    </div>
</div>
<!--Content home -->
<div class="container content-bill">
    <div class="infor-customer">
        <p>Đơn đặt hàng ngày: <?php echo date('d/m/y   H:s',strtotime($order->created_time)) ?></p>
        <table>
            <tr>
                <td>Mã đơn hàng<span>:</span></td>
                <td><?php echo $order->code ?></td>
            </tr>
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
        <?php echo $method->content ?>
    </div>
<!--    <p class="download_pdf"><a href="--><?php //echo FSRoute::_('index.php?module=paynow&view=paynow&task=pdf_success&raw=1')?><!--"><img src="/templates/default/images/icon-download.png" alt="">&nbsp;&nbsp; Xuất đơn hàng</a></p>-->
</div>
<div class="success-order">
    <div class="bg-black">
        <div class="body">
            <button type="button" class="close pull-left close-pup">
                <img src="/templates/default/images/img_svg/trangchu/close.svg" alt="">
            </button>
            <p class="hea-text">Đặt hàng thành công !</p>
            <p class="detal">Mọi thắc mắc và vấn đề phát sinh, quý khách vui lòng liên hệ với bộ phận chăm sóc khách hàng hoặc đến trực tiếp cửa hàng để nhận được sự hỗ trợ tốt nhất. Xin cảm ơn quý khách!</p>
        </div>
        <p class="download">
            <!-- <?php $id_order =  $_SESSION['order_id']?> -->
<!--            <a class="link-export" href="--><?php //echo FSRoute::_("index.php?module=paynow&view=export&task=pdf_success&id=$id_order&raw=1")?><!--">-->
            <a class="link-export" href="<?php echo FSRoute::_("index.php?module=paynow&view=export&task=api_pdf_export&id=$id&raw=1")?>">
                Xuất đơn hàng
            </a>
        </p>
    </div>
</div>



<!--Footer-->
<div class="container footer-bill">
    <?php echo $config['footer_bill']?>
</div>
