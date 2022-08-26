<div class="cart-moblie-show-header">
    <div class="scroll_view">
        <?php if(count($orderSims)>0){?>
            <table class="table-quick-cart" id="table-quick-cart">
                <thead>
                <tr>
                    <th width="62%"><p class="back-head">Sim</p></th>
                    <th width="38%"><p class="back-head" style="padding: 21px 0px 21px 0px; text-align: center;">Giá tiền</p></th>
                </tr>
                </thead>
                <tbody>
                <?php $totalPrice=0;foreach ($orderSims as $item){?>
                    <tr>
                        <td class="first">
                            <a data="<?php echo $item[2] ?>" class="icon_delete" href="javascript:void(0)">
                                <img src="/templates/mobile/images/img_svg/trang_chu/gio_hang/delete.svg" alt="">
                            </a>
                            <p class="title-bold phone-number"><?php echo $item[2] ?></p>
                            <p class="phone-network"><?php echo $item[3] ?></p>
                            <p class="phone-type"><?php echo $item[4] ?></p>
                        </td>
                        <td class="second">
                            <p class="phone-price"><?php echo number_format($item[1], 0, ',', '.') ?> đ</p>
                            <p class="phone-point">Điểm: <?php echo $item[5] ?></p>
                            <p class="phone-point">Nút: <?php echo $item[6] ?></p>
                            <!-- <p class="date-edit">Ngày cập nhật <?php echo date('d/m/Y', strtotime($item->created_time));?></p> -->
                        </td>
                    </tr>
                    <?php $totalPrice += $item[1]; }?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2">
                        <div class="total-pay" >
                            <h3 class="title-hea">Tổng thanh toán : <span id="total_cart"><?php echo number_format($totalPrice, 0, ',', '.') ?> đ</span></h3>
                            <p id="total_word">(<?php echo ucfirst(convert_number_to_words($totalPrice)) ?>)</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="box-fot">
                            <a class="btn btn-primary" href="<?php echo FSRoute::_("index.php?module=paynow&view=paynow&task=compare")?>">So sánh sim</a>
                            <a class="btn btn-primary" href="<?php echo FSRoute::_("index.php?module=paynow&view=paynow")?>">Thanh toán</a>
                        </div>
                    </td>
                </tr>
                </tfoot>
            </table>
        <?php }else{?>
            <table class="table-quick-cart" id="table-quick-cart">
                <thead>
                <tr>
                    <th width="62%"><p class="back-head">Sim</p></th>
                    <th width="38%"><p class="back-head" style="padding: 21px 0px 21px 0px; text-align: center;">Giá tiền</p></th>
                </tr>
                </thead>
                <tbody>
                <tr><td colspan="2" class="first"><p class="title-bold phone-number">Không có sản phẩm nào trong giỏ hàng</p></td></tr>
                </tbody>
                <tfoot style="display: none">
                <tr>
                    <td colspan="2">
                        <div class="total-pay" >
                            <h3 class="title-hea">Tổng thanh toán : <span id="total_cart"><?php echo number_format($totalPrice, 0, ',', '.') ?> đ</span></h3>
                            <p id="total_word">(<?php echo ucfirst(convert_number_to_words($totalPrice)) ?>)</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="box-fot">
                            <a class="btn btn-primary" href="<?php echo FSRoute::_("index.php?module=paynow&view=paynow&task=compare")?>">So sánh sim</a>
                            <a class="btn btn-primary" href="<?php echo FSRoute::_("index.php?module=paynow&view=paynow")?>">Thanh toán</a>
                        </div>
                    </td>
                </tr>
                </tfoot>
            </table>
        <?php }?>
    </div>
</div>


