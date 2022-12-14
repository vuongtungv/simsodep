<?php
    global $tmpl,$module;
    $tmpl -> addScript("search","blocks/search/assets/js");
    $tmpl -> addScript("autoNumeric","templates/default/js");
    $tmpl->addStylesheet('search','blocks/search/assets/css');

        $a_network = FSInput::get('network');
        $a_cat = FSInput::get('cat');
        $a_from_price = FSInput::get('from_price');
        $a_to_price = FSInput::get('to_price');
        $a_button = FSInput::get('button');
        $a_point = FSInput::get('point');
        $a_keyword = FSInput::get('keyword');
        $a_order = FSInput::get('order');
        $a_number = FSInput::get('number');
        $arr_number = array();
        if (@$a_number && $a_number != 'all') {
            $arr_number = explode('-', $a_number);
        }
        $in = '';
        if ((@$a_button&&$a_button!='all')||(@$a_point&&$a_point!='all')||(@$a_number || $a_number=='0')) {
            $in = 'show';
        }
        if (@$a_network && $a_network != 'all') {
            $network_item = $model->get_record('id = '.$a_network,'fs_network','id,name');
        }
        if (@$a_cat && $a_cat != 'all') {
            $type_item = $model->get_record('alias = "'.$a_cat.'"','fs_sim_type','id,name,alias');
        }
        if (@$a_price && $a_price != 'all') {
            $price_item = $model->get_record('price = "'.$a_price.'"','fs_pricesim','id,title,price');
        }
?>
<style>
    .price-show::placeholder {
        color: #888888;
        opacity: 1; /* Firefox */
    }

    .price-show:-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: #888888;
    }

    .price-show::-ms-input-placeholder { /* Microsoft Edge */
        color: #888888;
    }
    #submit_search .fa-search{
        border-left: 2px solid #888888;
        padding-left: 6px;
    }
    #sim_search_wrap form .search_bg-lv3 .icon-search{
        top: 6px;
        right: 8px;
        cursor: pointer;
        padding: 7px 10px 7px 0;
        border-radius: 0 2.5px 2.5px 0;
    }
</style>
<input type="hidden" id="id_val" value="">
<input type="hidden" id="height_scr" value="">
<div class="container" id="sim_search_wrap">
    <form action="" method="get"  name="search_form" id="search_form" onsubmit="javascript: submit_form_search();return false;">
        <div class="search_bg search_bg-lv1">
            <div class="SumoSelect">
                <!--Danh s??ch sim-->
                <input type="hidden" id="selected-value" name="select-options" value="<?php echo @$a_network&&@$a_network!='all'?$a_network:'' ?>">
                <div class="select-options">
                    <div class="value"><?php echo @$network_item->name?$network_item->name:'Danh s??ch m???ng' ?></div>
                    <div class="select-dropdown-icon">
                    </div>
                    <div class="options">
                        <div class="option" value="all" data-placement="bottom" data-toggle="tooltip">Ch???n nh?? m???ng</div>
                        <?php foreach ($network as $net){ ?>
                        <div class="option" <?php echo @$a_network==$net->id&&@$a_network!='all'?'selected':'' ?> value="<?php echo $net->id ?>" data-placement="bottom" data-toggle="tooltip"><?php echo $net->name ?></div>
                        <?php } ?>
                    </div>
                </div>

                <!--Th??? lo???i sim-->
                <input type="hidden" id="selected-type" name="select-type" value="<?php echo @$a_cat&&@$a_cat!='all'?$a_cat:'' ?>">
                <div class="select-type">
                    <div class="value-type"><?php echo @$type_item->name?$type_item->name:'Th??? lo???i sim' ?></div>
                </div>
                <div class="ver2 options" id="options_choose_type">
                    <div class="scroll-y" style="height: 200px !important;">
                        <div class="option" value="all" data-placement="bottom" data-toggle="tooltip">Ch???n th??? lo???i</div>
                        <?php foreach ($type as $type){ ?>
                            <div class="option" <?php echo @$a_cat==$type->id&&@$a_cat!='all'?'selected':'' ?> value="<?php echo $type->alias ?>" data-placement="bottom" data-toggle="tooltip"><?php echo $type->name ?></div>
                        <?php } ?>
                    </div>
                </div>

                <!--Gi?? ti???n-->

<!--                 <div class="input-price">
                    <label for="form_price">Gi??</label>
                    <input data-v-min="0" data-v-max="999999999999" class="form form-control numeric" type="text" id="form_price" name="form_price" placeholder="T???..." value="<?php echo @$a_from_price ?>">
                    <label class="lse" for="to_price">- Gi??</label>
                    <input  data-v-min="0" data-v-max="999999999999" class="form form-control numeric" type="text" id="to_price" name="to_price" placeholder="?????n..." value="<?php echo @$a_to_price ?>">
                </div> -->

                <div class="form form-control" style="width: 292px;">
                    <input data-v-min="0" data-v-max="999999999999" class="price-show numeric" type="text" id="form_price" name="form_price" placeholder="Gi?? t???..." value="<?php echo @$a_from_price ?>">
                    <img src="<?php echo URL_ROOT ?>images/line.svg">
                    <input data-v-min="0" data-v-max="999999999999"  class="price-show numeric" type="text" id="to_price" name="to_price" style="" placeholder="Gi?? ?????n..." value="<?php echo @$a_to_price ?>">
                </div>

<!--                 <input type="hidden" id="selected-price" name="select-prices" value="<?php echo @$a_price&&@$a_price!='all'?$a_price:'' ?>">
                <div class="select-prices">
                    <div class="value-price"><?php echo @$price_item->title?$price_item->title:'Ch???n gi?? ti???n' ?></div>
                    <div class="select-dropdown-icon">
                    </div>
                    <div class="options">
                        <div class="option" value="all" data-placement="bottom" data-toggle="tooltip">Ch???n gi?? ti???n</div>
                        <?php foreach ($price as $price){ ?>
                        <div class="option" <?php echo @$a_price==$price->price&&@$a_price!='all'?'selected':'' ?> value="<?php echo $price->price ?>" data-placement="bottom" data-toggle="tooltip"><?php echo $price->title ?></div>
                        <?php } ?>
                    </div>
                </div> -->
            </div>
        </div>
        <div class="search_bg search_bg-lv3">
            <input type="text" class="form form-control text-search" name="text-search" id="text-search"
                   placeholder="Nh???p s??? sim qu?? kh??ch mu???n t??m ki???m" value="<?php echo @$a_keyword&&@$a_keyword!='all'?$a_keyword:'' ?>">
            <span onclick="javascript: submit_form_search();return false;" id="submit_search" class="icon-search">
                <i class="fa fa-search <?php if(FSInput::get('module')=='search') echo ' color-search';?>" aria-hidden="true">
                    <img src="/templates/default/images/img_svg/trangchu/search.svg" alt="" class="img_search_ic">
                </i>
                <a>T??m ki???m</a>
            </span>
            <div class="show-show"></div>
            <div id="search-guide" class="hint" data-toggle="tooltip" style="line-height: 18px;">
                    <span style="color: #0762dc; font-size: 16px; font-family: text-regular;">S??? d???ng d???u <span
                                style="color: #5d5d5d;font-weight: bold;">"x"</span> ?????i ??i???n cho 1 s??? v?? d???u <span
                                style="color: #5d5d5d;font-weight: bold;">"*"</span> ?????i ??i???n cho m???t chu???i s???.
                        </span> <br>
                <p>????? t??m sim b???t ?????u b???ng 098, qu?? kh??ch nh???p v??o 098*</p>
                <p>????? t??m sim k???t th??c b???ng 888, qu?? kh??ch nh???p v??o *888</p>
                <p>????? t??m sim b??n trong c?? s??? 888, qu?? kh??ch nh???p v??o 888</p>
                <p>????? t??m sim b???t ?????u b???ng 098 v?? k???t th??c b???ng 888, nh???p v??o
                    098*888</p>
                <p>????? t??m sim b???t ?????u b???ng 098 v?? k???t th??c b???ng 808, 818, 828,
                    838, 848, 858, 868, 878, 888, 898 nh???p v??o 098*8x8</p>
                <br>
                <span style="color: #0762dc; font-size: 16px;font-family: text-regular;">S??? d???ng d???u <span
                            style="color: #5d5d5d;font-weight: bold;">"-"</span> ?????i di???n cho <span
                            style="color: #5d5d5d;font-weight: bold">"ho???c"</span> ????? t??m v???i nhi???u k???t qu???
                            nhanh h??n.
                        </span> <br>
                <p>????? t??m sim b???t ?????u b???ng 096 ho???c 098, qu?? kh??ch nh???p v??o
                    09(6-8)*</p>
                <p>????? t??m sim k???t th??c b???ng 888 ho???c 999, qu?? kh??ch nh???p v??o
                    *(888-999)</p>
                <p>????? t??m sim b??n trong c?? s??? 888 ho???c 999, qu?? kh??ch nh???p v??o
                    (888-999)</p>
                <p>????? t??m sim b???t ?????u b???ng 096 ho???c 098 v?? k???t th??c b???ng 888 ho???c
                    999, nh???p v??o 09(6-8)*(888-999)</p>
                <p>????? t??m sim b???t ?????u b???ng 096 ho???c 098 v?? k???t th??c b???ng 808 -&gt;
                    898 ho???c t??? 909 -&gt; 999 nh???p v??o 09(6-8)*(8x8-9x9)</p>

            </div>
        </div>
        <div id="black-opa">
        </div>
        <div class="search_bg search_bg-lv4">
            <div class="form form-control sim-price type-number">
                <span class="title-sim-price">Gi??:</span>
                <label class="checkcontainer">T???t c???
                    <input type="radio" <?php echo !@$a_order||$a_order==''?'checked':'' ?> value="" name="sim-price" id="order-price">
                    <span class="radiobtn"></span>
                </label>
                <label class="checkcontainer">T??ng
                    <input type="radio" <?php echo @$a_order=='up'?'checked':'' ?> name="sim-price" value="up" id="order-price">
                    <span class="radiobtn"></span>
                </label>
                <label class="checkcontainer">Gi???m
                    <input type="radio" <?php echo @$a_order=='down'?'checked':'' ?> name="sim-price" value="down" id="order-price">
                    <span class="radiobtn"></span>
                </label>
            </div>
            <button class="btn btn-primary btn-advanced" id="advanced-search" type="button" data-toggle="collapse" data-target="#advanced-search" aria-expanded="false" aria-controls="advanced-search" style="display: block;">
                T??m n??ng cao
            </button>
        </div>
        <div class="search_bg collapse <?php echo @$in ?> search_bg-lv5">
            <div class="top">
                <input class="form form-control total-button-sim" type="text" id="total-button-sim"
                       name="total-button-sim"
                       placeholder="T???ng n??t (1-10)" value="<?php echo @$a_button&&$a_button!='all'?$a_button:'' ?>" >
                <input class="form form-control total-score-sim" type="text" id="total-score-sim" name="total-score-sim"
                       placeholder="T???ng ??i???m (<81)" value="<?php echo @$a_point&&$a_point!='all'?$a_point:'' ?>">
            </div>
            <div class="form form-control seri-sim type-number">
                <span class="title-sim-type">D??y s??? kh??ng bao g???m:</span>
                <div class="custom-control custom-checkbox ">
                    <input <?php echo in_array(0, @$arr_number)||$a_number=='0'?'checked':'' ?> value="0" type="checkbox" class="custom-control-input" name="number" id="InputPlace0">
                    <label class="custom-control-label" for="InputPlace0">0</label>
                </div>
                <div class="custom-control custom-checkbox ">
                    <input <?php echo in_array(1, @$arr_number)?'checked':'' ?> value="1" type="checkbox" class="custom-control-input" name="number" id="InputPlace1">
                    <label class="custom-control-label" for="InputPlace1">1</label>
                </div>
                <div class="custom-control custom-checkbox ">
                    <input <?php echo in_array(2, @$arr_number)?'checked':'' ?> value="2" type="checkbox" class="custom-control-input" name="number" id="InputPlace2">
                    <label class="custom-control-label" for="InputPlace2">2</label>
                </div>
                <div class="custom-control custom-checkbox ">
                    <input <?php echo in_array(3, @$arr_number)?'checked':'' ?> value="3" type="checkbox" class="custom-control-input" name="number" id="InputPlace3">
                    <label class="custom-control-label" for="InputPlace3">3</label>
                </div>
                <div class="custom-control custom-checkbox ">
                    <input <?php echo in_array(4, @$arr_number)?'checked':'' ?> value="4" type="checkbox" class="custom-control-input" name="number" id="InputPlace4">
                    <label class="custom-control-label" for="InputPlace4">4</label>
                </div>
                <div class="custom-control custom-checkbox ">
                    <input <?php echo in_array(5, @$arr_number)?'checked':'' ?> value="5" type="checkbox" class="custom-control-input" name="number" id="InputPlace5">
                    <label class="custom-control-label" for="InputPlace5">5</label>
                </div>
                <div class="custom-control custom-checkbox ">
                    <input <?php echo in_array(6, @$arr_number)?'checked':'' ?> value="6" type="checkbox" class="custom-control-input" name="number" id="InputPlace6">
                    <label class="custom-control-label" for="InputPlace6">6</label>
                </div>
                <div class="custom-control custom-checkbox ">
                    <input <?php echo in_array(7, @$arr_number)?'checked':'' ?> value="7" type="checkbox" class="custom-control-input" name="number" id="InputPlace7">
                    <label class="custom-control-label" for="InputPlace7">7</label>
                </div>
                <div class="custom-control custom-checkbox ">
                    <input <?php echo in_array(8, @$arr_number)?'checked':'' ?> value="8" type="checkbox" class="custom-control-input" name="number" id="InputPlace8">
                    <label class="custom-control-label" for="InputPlace8">8</label>
                </div>
                <div class="custom-control custom-checkbox ">
                    <input <?php echo in_array(9, @$arr_number)?'checked':'' ?> value="9" type="checkbox" class="custom-control-input" name="number" id="InputPlace9">
                    <label class="custom-control-label" for="InputPlace9">9</label>
                </div>
            </div>
        </div>

        <input type='hidden'  name="module" value="search"/>
        <input type='hidden'  name="module" id='link_search' value="<?php echo FSRoute::_('index.php?module=search&view=search'); ?>" />
        <input type='hidden'  name="view" value="search"/>
        <input type='hidden'  name="Itemid" value="20"/>
        <input type='hidden'  name="url_root" id="url_root" value="<?php echo URL_ROOT ?>"/>

        <input type="hidden" name="text_form_price" id="text_form_price" value="">
        <input type="hidden" name="text_to_price" id="text_to_price" value="">
        <input type="hidden" name="text_sea" id="text_sea" value="">
        <input type="hidden" name="check_price" id="check_price" value="false">
        <input type="hidden" name="in_nut" id="in_nut" value="">
        <input type="hidden" name="in_diem" id="in_diem" value="">
        <input type="hidden" name="inc_num" id="inc_num" value="false">


    </form>
    <p class="slogan span10" style="font-weight: normal">Trung t??m mua b??n sim s??? ?????p gi?? r???, uy t??n - chuy??n nghi???p</p>
</div>
