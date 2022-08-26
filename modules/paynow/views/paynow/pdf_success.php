









<?php

// get the HTML
ob_start();
// database connection here

?>
<html lang="vi" >
<head id="Head1" prefix="og: http://ogp.me/ns# fb:http://ogp.me/ns/fb# article:http://ogp.me/ns/article#">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
    <meta http-equiv="Cache-control" content="public" />
    <title>Hóa đơn</title>
</head>
<body>
    <div class="company-bill" style="height: 210px;position: relative;">
        <div class="left img-logo" >
            <a href="<?php echo URL_ROOT?>"><img src="<?php echo $config['logo']?>" alt=""></a>
        </div>
        <div class="right infor-company" style="top: 0px;right: 0px; position: absolute;">
            <?php echo $config['header_bill']?>
        </div>
        <div class="clear-fix"></div>
    </div>
    <!--Content home -->
    <div class="container content-bill">
        <div class="status-customer" style="border-bottom: 2px solid #d8d7d7; position: relative;padding: 20px 0px;">
            <div class="left-bi" style="float: left; width: 65%; margin-bottom: 15px;">
                <h2 style="text-transform: uppercase; margin-bottom: 5px;">Hóa đơn bán hàng</h2>
                <p style="margin-bottom:0px;"><span style="padding-right: 300px;">Mã đơn hàng: <?php echo $order->code ?></span>                  Đơn đặt hàng ngày: <?php echo date('d/m/y   H:s',strtotime($order->created_time)) ?></p>
            </div>
            <div class="right" style=" width: 22%; position: absolute; right: 0px;top: 20px;">
                <p style="text-align: right">Trạng thái thanh toán</p>
                <div style="background: red;padding: 8px;text-align: center; border-radius: 5px;text-transform: uppercase; color: #FFFFFF">Chưa thanh toán</div>
            </div>
        </div>
        <div class="infor-customer" style="border-bottom: 2px solid #d8d7d7; padding-bottom: 30px;">
<!--            <p>Đơn đặt hàng ngày: --><?php //echo date('d/m/y   H:s',strtotime($order->created_time)) ?><!--</p>-->
            <p></p>
            <table >
<!--                <tr>-->
<!--                    <td width="150" style="font-family: --><?php //echo $fontname?><!--">Mã đơn hàng<span>:</span></td>-->
<!--                    <td>--><?php //echo $order->code ?><!--</td>-->
<!--                </tr>-->
                <tr>
                    <td width="150">Khách hàng<span>:</span></td>
                    <td><?php echo $order->recipients_name ?></td>
                </tr>
                <tr>
                    <td width="150">Số điện thoại<span>:</span></td>
                    <td><?php echo $order->recipients_mobilephone ?></td>
                </tr>
                <tr>
                    <td width="150">Địa chỉ<span>:</span></td>
                    <td><?php echo $order->recipients_address ?></td>
                </tr>
                <tr>
                    <td width="150">Email<span>:</span></td>
                    <td><?php echo $order->recipients_email ?></td>
                </tr>
                <tr>
                    <td width="150">Ghi chú <span>:</span></td>
                    <td><?php echo $order->recipients_comments ?></td>
                </tr>
            </table>
        </div>

        <div class="table-order">
            <table class="table table-default">
                <thead>
                <tr>
                    <th scope="col" style="padding: 0px 15px;" ><div class="col1 div div1">Số sim</div></th>
                    <th scope="col" style="padding: 0px 15px;" ><div class="col2 div div1">Nhà mạng</div></th>
                    <th scope="col" style="padding: 0px 15px;" ><div class="col3 div div1">Thể loại</div></th>
                    <th scope="col" style="padding: 0px 15px;" ><div class="col4 div div1">Điểm</div></th>
                    <th scope="col" style="padding: 0px 15px;" ><div class="col5 div div1">Ngày cập nhật</div></th>
                    <th scope="col" style="padding: 0px 15px;" ><div class="col6 div div1">Giá tiền</div></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $item ) { ?>
                    <tr >
                        <td style="padding: 14px 0px; border: 1px solid #e0e0e0; border-top: none;border-right: none;"><?php echo $item->sim ?></td>
                        <td style="padding: 14px 0px; border-bottom: 1px solid #e0e0e0;"><?php echo $item->network ?></td>
                        <td style="padding: 14px 0px; border-bottom: 1px solid #e0e0e0;">
                            <?php $ar_type = explode(',',trim($item->cat_name, ','));
                            echo $ar_type[0];
                            ?>
                        </td>
                        <td style="padding: 14px 0px; border-bottom: 1px solid #e0e0e0;"><?php echo $item->point ?></td>
                        <td style="padding: 14px 0px; border-bottom: 1px solid #e0e0e0;"><?php echo date('d/m/y  H:s',strtotime($item->time_create)) ?></td>
                        <td style="padding: 14px 0px; border: 1px solid #e0e0e0; border-top: none;"><?php echo format_money($item->price_public,' đ') ?></td>
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
<!--            --><?php //echo $method->content ?>
        </div>
        <!--    <p class="download_pdf"><a href="--><?php //echo FSRoute::_('index.php?module=paynow&view=paynow&task=pdf_success&raw=1')?><!--"><img src="/templates/default/images/icon-download.png" alt="">&nbsp;&nbsp; Xuất đơn hàng</a></p>-->
    </div>
    <!--Footer-->
    <div class="container footer-bill" style="position: relative;overflow:hidden; height: 100%">
        <?php echo $config['footer_bill']?>
        <img src="<?php echo URL_ROOT?>/templates/default/images/bill-07-08-19.png" style="position: absolute;top:25px;right: 15px;width: 20%">
    </div>


    <style>
        .col1{width: 60px;}
        .col2{width: 80px;}
        .col3{width: 90px;}
        .col4{width: 50px;}
        .col5{width: 120px;}
        .col6{width: 130px;}
        .div { background: #0253ea; color: #ffffff; text-align: center;margin-top: 8px;}
        .div1 { border: solid 1mm #0253ea; border-radius: 11px;              -moz-border-radius: 11px;              }

        .clear-fix::after {
            content: "";
            clear: both;
            display: table;
        }
        body{
            font-size: 12px;
            font-family: robotobold;
        }
        .company-bill{
            border-bottom: 2px solid #d8d7d7;
        }
        .company-bill .img-logo{
            width: 35%;
            float: left;
        }
        .company-bill .img-logo img{
            width: 100%;
        }
        .infor-company{
            width: 65%;
            /*font-family: robotobolditalic;*/
        }
        /*.clear-fix{*/
        /*clear: both;*/
        /*display: block;*/
        /*}*/
        .table-order{
            color: #333333;
            margin-bottom:0px;
            margin-top: 30px;
        }
        .table-order .table-default{
            border-collapse: collapse;
        }
        .table-order thead{
            background: #3478f7;
            width: 100%;
        }
        .table-order thead th{
            background: #3478f7;
            height: 40px;

        }
        .table-order thead th p{
            line-height: 28px;
            /*background: #0253ea;*/
            color: #ffffff;
            height: 28px;
            text-align: center;
            /*border-radius: 50px;*/
            border: solid 2mm black; border-radius: 5mm;              -moz-border-radius: 5mm;
        }
        .table-order tbody td:nth-child(1),.table-order tbody td:nth-child(6){
            font-weight: bold;
        }
        /*.table-order tbody tr{*/
        /*line-height: 47px;*/
        /*}*/
        .table-order tbody tr td{
            text-align: center;
            /*height: 20px;*/

            overflow: hidden;

        }

        .infor-customer p{
            text-align: right;
            margin-bottom: 0px;
        }
        .infor-customer td:nth-child(1){
            width: 130px;
            font-weight: normal;
        }
        .infor-customer td:nth-child(2){
            font-weight: bold;
            font-size: 12px;
        }
        .infor-sim{
            border-left: 1px solid #777777;
            border-right: 1px solid #777777;
            border-bottom: 1px solid #777777;
        }

        .infor-customer td span{
            float: right;
        }


        .box-total{
            margin-top: 10px;
            padding: 18px 20px 18px 26px;
            background: #f3f3f3;
            border: none;
        }
        .box-total table td:nth-child(1){
            width: 130px;
            vertical-align: top;
        }
        .box-total table td:nth-child(1) span{
            float: right;
        }
        .box-total table td:nth-child(2){
            font-weight: bold;
            font-style: italic;
            font-size: 12px;
        }
        .bill-note{
            margin-top: 15px;
            padding-bottom: 10px;
            font-size: 13px;
        }
        .bill-note .top{
            /*font-family: Text-Regular;*/
            margin-bottom: 5px;
        }
        .bill-note .top span{
            /*font-family: Text-semiBold;*/
            font-weight: bold;
        }
        .bill-note p{
            line-height: 24px;
        }
        .footer-bill{
            border-top:3px solid #d8d7d7;
            background: #ffffff;
            padding: 15px;
            margin-top: 15px;
        }
        .footer-bill .title-hea{
            text-transform: uppercase;
            /*font-family: Text-semibold-Italic;*/
            margin: 0px 0px 5px;
            font-size: 14px;
        }
        .footer-bill p{
            /*font-family: Text-Regular;*/
            line-height: 24px;
            font-size: 13px;
            margin-bottom:0px;
        }

    </style>
</body>
</html>





<?php
$content = ob_get_clean();

header('Content-Type: text/html; charset=utf-8');
//echo "<pre>";
//    print_r($content);
//echo "</pre>";
//global $tmpl, $config;

require PATH_BASE.'libraries/htmltwopdf/vendor/autoload.php';



use Spipu\Html2Pdf\Html2Pdf;


require_once(PATH_BASE.'libraries/htmltwopdf/vendor/spipu/html2pdf/src/Html2Pdf.php');

$html2pdf = new Html2Pdf('P', 'A4', 'en', 'true','UTF-8');


//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$fontname = TCPDF_FONTS::addTTFfont(PATH_BASE.'templates/default/fonts/Roboto-Bold.ttf', 'TrueTypeUnicode', '', 32);

$html2pdf->setDefaultFont('dejavusans');

$html2pdf->pdf->SetDisplayMode('fullpage');
$html2pdf->WriteHTML($content);

ob_end_clean();

$nameFile = "Don-hang-".$order->code.'.pdf';

$html2pdf->Output( $nameFile,'D');
//$html2pdf->Output();
?>
