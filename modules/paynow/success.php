<?php
// include autoloader
//require_once 'dompdf/autoload.inc.php';
//use Dompdf\Dompdf;
//$dompdf = new Dompdf();
//$page = file_get_contents('html_success.php');
//$dompdf->loadHtml($page);
//$dompdf->setPaper('A4', 'landscape');
//ini_set("memory_limit","128M");
//$dompdf->render();
//$dompdf->stream( "/path-to-save-pdf-file/sample.pdf");

?>

<?php
global $tmpl, $config;
$tmpl->addTitle('Hóa đơn');
$tmpl->addStylesheet('bill','modules/paynow/assets/css');
$tmpl->addStylesheet('success_order','modules/paynow/assets/css');
$tmpl -> addScript('success_order','modules/paynow/assets/js');
?>
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
                <?php foreach ($list as $item ) {
                    # code...
                ?>
                <tr>
                    <td><?php echo $item->sim ?></td>
                    <td><?php echo $item->network ?></td>
                    <td><?php echo trim($item->cat_name,',') ?></td>
                    <td><?php echo $item->point ?></td>
                    <td><?php echo date('d/m/y   H:s',strtotime($item->time_create)) ?></td>
                    <td><?php echo format_money($item->price_public,' đ') ?></td>
                </tr>
                <?php } ?>
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
                <td><?php echo $order->member_discount ?>% <?php echo $order->member_level_name ?></td>
            </tr>
            <tr>
                <td>Tổng thanh toán<span>:</span></td>
                <td><?php echo format_money($order->total_end,' đ') ?> (<?php echo int_to_words($order->total_end).' đồng' ?>)</td>
            </tr>
        </table>
    </div>
    <div class="bill-note">
        <p class="top">Hình thức thanh toán:  <span><?php echo $order->payment_method ?></span></p>
        <?php echo $config['note_bill'] ?>
    </div>
    <p class="download_pdf"><a href="#"><img src="/templates/default/images/icon-download.png" alt="">&nbsp;&nbsp; Xuất đơn hàng</a></p>
</div>


<div class="success-order">
    <div class="bg-black">
        <div class="body">
            <button type="button" class="close pull-left close-pup"><img src="/templates/default/images/icon-close-pupup.png" alt=""></button>
            <p class="hea-text">Đặt hàng thành công !</p>
            <p class="detal">Mọi thắc mắc và vấn đề phát sinh, quý khách vui lòng liên hệ với bộ phận chăm sóc khách hàng hoặc đến trực tiếp cửa hàng để nhận được sự hỗ trợ tốt nhất. Xin cảm ơn quý khách!</p>
        </div>
        <p class="download"><a href="#"><img src="/templates/default/images/icon-download.png" alt="">&nbsp;&nbsp; Xuất đơn hàng</a></p>
    </div>
</div>
