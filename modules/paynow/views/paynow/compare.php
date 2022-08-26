<?php 
    global $tmpl, $config;
    $tmpl->addTitle('So sánh sim');
    $tmpl->addStylesheet('compare-sim','modules/paynow/assets/css');
    $tmpl -> addScript('cart','modules/paynow/assets/js');
 ?>
<div class="container compare-sim">
    <h1 class="title-hea">So sánh sim</h1>
    <p class="note-compare">Quý khách chọn từ 02 đến 04 sim trong giỏ hàng để so sánh</p>
    <div class="show-sim-compare">
        <div class="row no-gutters">
            <?php foreach ($orderSims as $item) {?>
            <div class="custom-control custom-checkbox custom-control-inline item-compare col-md-2">
                <input data-network="<?php echo $item->network ?>" data-sim="<?php echo $item->sim ?>" data-cat="<?php $ar_type = explode(',',trim($item->cat_name, ','));echo $ar_type[0];?>" data-point="<?php echo $item->point ?>" data-button="<?php echo $item->button ?>" data-price="<?php echo format_money($item->price_public)?>" name="check" value="<?php echo $item->id ?>" type="checkbox" class="custom-control-input" id="sim<?php echo $item->id ?>">
                <label class="custom-control-label" for="sim<?php echo $item->id ?>">
                    <p class="phone"><?php echo $item->sim ?></p>
                    <p class="supplier"><?php echo $item->network ?></p>
                    <p class="price"><?php echo format_money($item->price_public) ?></p>
                </label>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="title-box">
        <button type="button" class="box-head">So sánh sim</button>
    </div>

    <table class="table table-striped table-compare">
        <thead>
            <tr>
                <th scope="col" width="20%"><p>Số sim</p></th>
                <th scope="col" width="20%"><p class="sim1"></p></th>
                <th scope="col" width="20%"><p class="sim2"></p></th>
                <th scope="col" width="20%"><p class="sim3"></p></th>
                <th scope="col" width="20%"><p class="sim4"></p></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row"><p>Nhà mạng</p></th>
                <td class="network1"></td>
                <td class="network2"></td>
                <td class="network3"></td>
                <td class="network4"></td>
            </tr>
            <tr>
                <th scope="row"><p>Thể loại</p></th>
                <td class="cat1"></td>
                <td class="cat2"></td>
                <td class="cat3"></td>
                <td class="cat4"></td>
            </tr>
            <tr>
                <th scope="row"><p>Nút</p></th>
                <td class="button1"></td>
                <td class="button2"></td>
                <td class="button3"></td>
                <td class="button4"></td>
            </tr>
            <tr>
                <th scope="row"><p>Điểm</p></th>
                <td class="point1"></td>
                <td class="point2"></td>
                <td class="point3"></td>
                <td class="point4"></td>
            </tr>
            <tr>
                <th scope="row"><p>Giá tiền</p></th>
                <td class="price1"></td>
                <td class="price2"></td>
                <td class="price3"></td>
                <td class="price4"></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td><button id="paynow" class="btn btn-primary">Thanh toán</button></td>
                <td>
                    <div class="custom-control custom-checkbox custom-control-inline item-compare col-md-2">
                        <input type="checkbox" class="custom-control-input" name="compare" id="compare1">
                        <label class="custom-control-label" for="compare1"></label>
                    </div>
                </td>
                <td>
                    <div class="custom-control custom-checkbox custom-control-inline item-compare col-md-2">
                        <input type="checkbox" class="custom-control-input" name="compare" id="compare2">
                        <label class="custom-control-label" for="compare2"></label>
                    </div>
                </td>
                <td>
                    <div class="custom-control custom-checkbox custom-control-inline item-compare col-md-2">
                        <input type="checkbox" class="custom-control-input" name="compare" id="compare3">
                        <label class="custom-control-label" for="compare3"></label>
                    </div>
                </td>
                <td>
                    <div class="custom-control custom-checkbox custom-control-inline item-compare col-md-2">
                        <input type="checkbox" class="custom-control-input" name="compare" id="compare4">
                        <label class="custom-control-label" for="compare4"></label>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>


</div>