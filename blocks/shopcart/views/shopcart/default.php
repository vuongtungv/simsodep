<?php global $tmpl;
//$tmpl->addStylesheet('shopcart', 'eblocks/shopcart/assets/css');
?>


<div class="show-cart">
    <table class="table table-hover table-cart">
        <thead>
            <tr>
                <th scope="col">Số sim</th>
                <th scope="col"style="text-align: right">Giá tiền</th>
                <th scope="col" style="width: 11px;"></th>
            </tr>
        </thead>
        <tbody>
            <?php $totalPrice=0; foreach ($orderSims as $item){?>
            <tr>
                <td><?php echo $item[2]?></td>
                <td><?php echo number_format($item[1], 0, ',', '.') ?> đ</td>
                <td>
                    <a href="<?php echo FSRoute::_('index.php?module=home&view=home&task=delete&number=' . $item[2]) ?>">
                        <span><i class="fa fa-times" aria-hidden="true"></i></span>
                    </a>
                </td>
            </tr>
            <?php $totalPrice += $item[1]; }?>
        </tbody>
        <tfoot>
        <tr>
            <td>Tổng thanh toán</td>
            <td id="total_cart"><?php echo number_format($totalPrice, 0, ',', '.') ?> đ</td>
            <td></td>
        </tr>
        <tr>
            <td><a href="<?php echo FSRoute::_("index.php?module=paynow&view=paynow&task=compare")?>" class="btn btn-primary">So sánh sim</a></td>
            <td><a href="<?php echo FSRoute::_("index.php?module=paynow&view=paynow")?>" class="btn btn-primary">Thanh toán</a></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</div>