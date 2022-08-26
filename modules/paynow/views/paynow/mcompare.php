<?php 
    global $tmpl, $config;
    $tmpl->addTitle('So sánh sim');
    $tmpl->addStylesheet('simsosanh','templates/mobile/css/');
    $tmpl -> addScript('cart_mobile','modules/paynow/assets/js');
 ?>

    <div class="compare-sim">
        <div class="box-hea">
            <p class="hea">So sánh sim</p>
            <p class="bri">Quý khách chọn từ 02 đến 04 trong giỏ hàng để so sánh</p>
        </div>
        <table class="table1">
            <tr>
                <?php foreach ($orderSims as $item) {?>
                <td class="td-first custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="check<?php echo $item->id ?>" data-network="<?php echo $item->network ?>" data-sim="<?php echo $item->sim ?>" data-cat="<?php $ar_type = explode(',',trim($item->cat_name, ','));echo $ar_type[0];?>" data-point="<?php echo $item->point ?>" data-button="<?php echo $item->button ?>" data-price="<?php echo format_money($item->price_public)?>" name="check" value="<?php echo $item->id ?>">
                    <label for="check<?php echo $item->id ?>" class="custom-control-label">
                        <p class="name"><?php echo $item->sim ?></p>
                        <p class="type-tex"><?php echo $item->network ?></p>
                        <p class="type-tex"><?php echo format_money($item->price_public) ?></p>
                    </label>
                </td>
                <?php } ?>
            </tr>
        </table>
        <button class="box-hea-2 box-head">
            <p>So sánh sim <span>&nbsp;&nbsp;<img src="/templates/mobile/images/img_svg/so_sanh_sim/so_sanh_icon.svg" alt=""></span></p>
        </button>
        <div>
            <div class="box-table">
                <table class="table2 table2tt">
                    <tr class="tr1">
                        <td class="td-first">
                            <p class="name sim1"></p>
                            <p class="type-tex network1">Trống</p>
                        </td>
                        <td class="td-second">
                            <p class="name point1"></p>
                            <p class="type-tex button1"></p>
                        </td>
                        <td class="td-thirt">
                            <p class="name price1"></p>
                            <p class="type-tex cat1"></p>
                        </td>
                        <td class="td-four">
                            <div class="custom-control custom-checkbox">
                                <input name="compare" type="checkbox" class="custom-control-input" value="" id="compare1">
                                <label for="compare1" class="custom-control-label"></label>
                            </div>

                        </td>
                    </tr>
                    <tr class="tr2">
                        <td class="td-first">
                            <p class="name sim2"></p>
                            <p class="type-tex network2">Trống</p>
                        </td>
                        <td class="td-second">
                            <p class="name point2"></p>
                            <p class="type-tex button2"></p>
                        </td>
                        <td class="td-thirt">
                            <p class="name price2"></p>
                            <p class="type-tex cat2"></p>
                        </td>
                        <td class="td-four">
                            <div class="custom-control custom-checkbox">
                                <input name="compare" type="checkbox" class="custom-control-input" value="" id="compare2">
                                <label for="compare2" class="custom-control-label"></label>
                            </div>

                        </td>
                    </tr>
                    <tr class="tr3">
                        <td class="td-first">
                            <p class="name sim3"></p>
                            <p class="type-tex network3">Trống</p>
                        </td>
                        <td class="td-second">
                            <p class="name point3"></p>
                            <p class="type-tex button3"></p>
                        </td>
                        <td class="td-thirt">
                            <p class="name price3"></p>
                            <p class="type-tex cat3"></p>
                        </td>
                        <td class="td-four">
                            <div class="custom-control custom-checkbox">
                                <input name="compare" type="checkbox" class="custom-control-input" value="" id="compare3">
                                <label for="compare3" class="custom-control-label"></label>
                            </div>

                        </td>
                    </tr>
                    <tr class="tr4">
                        <td class="td-first">
                            <p class="name sim4"></p>
                            <p class="type-tex network4">Trống</p>
                        </td>
                        <td class="td-second">
                            <p class="name point4"></p>
                            <p class="type-tex button4"></p>
                        </td>
                        <td class="td-thirt">
                            <p class="name price4"></p>
                            <p class="type-tex cat4"></p>
                        </td>
                        <td class="td-four">
                            <div class="custom-control custom-checkbox">
                                <input name="compare" type="checkbox" class="custom-control-input" value="" id="compare4">
                                <label for="compare4" class="custom-control-label"></label>
                                <p></p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="sub-form">
                <button  id="paynow" class="btn btn-primary no_compare">Thanh toán</button>
            </div>
        </div>
    </div>