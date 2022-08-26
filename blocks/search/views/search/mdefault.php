<?php
    global $tmpl,$module;
    $tmpl -> addScript("msearch","blocks/search/assets/js");
    $tmpl -> addScript("autoNumeric","templates/default/js");
    $tmpl->addStylesheet('msearch','blocks/search/assets/css');

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

    <div class="search-icon">
        <div action="#" class="form-search">
            <div class="input_search">
                <input type="text" id="text-search" class="form-control tx-num" placeholder="Nhập số sim muốn tìm kiếm" value="<?php echo @$a_keyword&&@$a_keyword!='all'?$a_keyword:'' ?>" ><img src="/templates/mobile/images/img_svg/trang_chu/search.svg" alt="">
            </div>
            <?php if(FSInput::get('module') !='home'){?>
            <button type="button" class="form-control click_search"><?php echo @$a_keyword&&@$a_keyword!='all'?$a_keyword:'Tìm kiếm' ?><img src="/templates/mobile/images/img_svg/trang_chu/search.svg" alt=""></button>
            <?php }else{?>
                <button type="button" class="form-control click_search"><?php echo @$a_keyword&&@$a_keyword!='all'?$a_keyword:'Tìm kiếm sim' ?><img src="/templates/mobile/images/img_svg/trang_chu/search.svg" alt=""></button>
            <?php }?>
        </div>
        <div class="form-search-full" style="display: none;">
            <form  name="search_form" id="search_form" id="search_form" onsubmit="javascript: submit_form_search();return false;">
                <div class="search_bg search_bg-lv1">
                    <div class="SumoSelect">
                        <!--Danh sách nhà mạng-->
                        <div class="select select_1">
                            <select name="selected-value" id="selected-value" class="sel-ip">
                                <option value="">Nhà mạng</option>
                                <?php foreach ($network as $net){ ?>
                                <option <?php echo @$a_network==$net->id&&@$a_network!='all'?'selected':'' ?> value="<?php echo $net->id ?>"><?php echo $net->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!--Thể loại sim-->
                        <div class="select select_2">
                            <select name="selected-type" id="selected-type" class="sel-ip" style="padding-right: 96px;white-space: initial;line-height: 50px;">
                                <option value="">Thể loại</option>
                                <?php foreach ($type as $type){ ?>
                                    <option <?php echo @$a_cat==$type->id&&@$a_cat!='all'?'selected':'' ?> value="<?php echo $type->alias ?>"><?php echo $type->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="search_bg search_bg-lv2">
                    <div class="point-total mprice">
                        <input data-v-min="0" data-v-max="999999999999" class="form form-control numeric" type="text" id="form_price" name="form_price" placeholder="Giá từ" value="<?php echo @$a_from_price ?>" >
                        <input data-v-min="0" data-v-max="999999999999" class="form form-control numeric" type="text" id="to_price" name="to_price" placeholder="Giá đến" value="<?php echo @$a_to_price ?>">
                    </div>
                    <div class="form form-control type-number check-type-number-1">
                        <span class="title-sim-type">Giá:</span>
                        <label class="checkcontainer">Tất cả
                            <input type="radio" <?php echo !@$a_order||$a_order==''?'checked':'' ?> name="sim-price" value="" id="order-price">
                            <span class="radiobtn"></span>
                        </label>
                        <label class="checkcontainer">Tăng
                            <input type="radio" <?php echo @$a_order=='up'?'checked':'' ?> name="sim-price" value="up" id="order-price">
                            <span class="radiobtn"></span>
                        </label>
                        <label class="checkcontainer">Giảm
                            <input type="radio" <?php echo @$a_order=='down'?'checked':'' ?> name="sim-price" value="down" id="order-price">
                            <span class="radiobtn"></span>
                        </label>

                    </div>
                    <div class="point-total">
                        <input class="form form-control total-button-sim" type="number" id="total-button-sim" name="total-button-sim" placeholder="Tổng nút (1-10)" value="<?php echo @$a_button&&$a_button!='all'?$a_button:'' ?>">
                        <input class="form form-control total-score-sim" type="number" id="total-score-sim" name="total-score-sim" placeholder="Tổng điểm (<81)" value="<?php echo @$a_point&&$a_point!='all'?$a_point:'' ?>">
                    </div>
                    <div class="form form-control seri-sim type-number check-type-number-2">
                        <div class="row no-gutters">
                            <div class="col-md-4 title-sim-type">Số không gồm:</div>
                            <div class="col-md-2 custom-control custom-checkbox ">
                                <input <?php echo in_array(0, @$arr_number)||$a_number=='0'?'checked':'' ?> value="0" type="checkbox" name="number" class="custom-control-input" id="InputPlace0">
                                <label class="custom-control-label" for="InputPlace0">0</label>
                            </div>
                            <div class="col-md-2 custom-control custom-checkbox ">
                                <input <?php echo in_array(1, @$arr_number)?'checked':'' ?> value="1" type="checkbox" name="number" class="custom-control-input" id="InputPlace1">
                                <label class="custom-control-label" for="InputPlace1">1</label>
                            </div>
                            <div class="col-md-2 custom-control custom-checkbox ">
                                <input <?php echo in_array(2, @$arr_number)?'checked':'' ?> value="2" type="checkbox" name="number" class="custom-control-input" id="InputPlace2">
                                <label class="custom-control-label" for="InputPlace2">2</label>
                            </div>
                            <div class="col-md-2 custom-control custom-checkbox ">
                                <input <?php echo in_array(3, @$arr_number)?'checked':'' ?> value="3" type="checkbox" name="number" class="custom-control-input" id="InputPlace3">
                                <label class="custom-control-label" for="InputPlace3">3</label>
                            </div>
                            <div class="col-md-2 custom-control custom-checkbox ">
                                <input <?php echo in_array(4, @$arr_number)?'checked':'' ?> value="4" type="checkbox" name="number" class="custom-control-input" id="InputPlace4">
                                <label class="custom-control-label" for="InputPlace4">4</label>
                            </div>
                            <div class="col-md-2 custom-control custom-checkbox ">
                                <input <?php echo in_array(5, @$arr_number)?'checked':'' ?> value="5" type="checkbox" name="number" class="custom-control-input" id="InputPlace5">
                                <label class="custom-control-label" for="InputPlace5">5</label>
                            </div>
                            <div class="col-md-2 custom-control custom-checkbox ">
                                <input <?php echo in_array(6, @$arr_number)?'checked':'' ?> value="6" type="checkbox" name="number" class="custom-control-input" id="InputPlace6">
                                <label class="custom-control-label" for="InputPlace6">6</label>
                            </div>
                            <div class="col-md-2 custom-control custom-checkbox ">
                                <input <?php echo in_array(7, @$arr_number)?'checked':'' ?> value="7" type="checkbox" name="number" class="custom-control-input" id="InputPlace7">
                                <label class="custom-control-label" for="InputPlace7">7</label>
                            </div>
                            <div class="col-md-2 custom-control custom-checkbox ">
                                <input <?php echo in_array(8, @$arr_number)?'checked':'' ?> value="8" type="checkbox" name="number" class="custom-control-input" id="InputPlace8">
                                <label class="custom-control-label" for="InputPlace8">8</label>
                            </div>
                            <div class="col-md-2 custom-control custom-checkbox ">
                                <input <?php echo in_array(9, @$arr_number)?'checked':'' ?> value="9" type="checkbox" name="number" class="custom-control-input" id="InputPlace9">
                                <label class="custom-control-label" for="InputPlace9">9</label>
                            </div>
                        </div>
                    </div>
                </div>
                <span onclick="javascript: submit_form_search();return false;" class="btn btn-primary btn_search">Tìm kiếm sim</span>
                <input type='hidden'  name="module" value="search"/>
                <input type='hidden'  name="module" id='link_search' value="<?php echo FSRoute::_('index.php?module=search&view=search'); ?>" />
                <input type='hidden'  name="view" value="search"/>
                <input type='hidden'  name="Itemid" value="20"/>
                <input type='hidden'  name="url_root" id="url_root" value="<?php echo URL_ROOT ?>"/>
                <input type="hidden"  name="check_price" id="check_price" value="false">
                <input type="hidden" name="inc_num" id="inc_num" value="false">
            </form>
            <p class="slogan span10">Trung tâm mua bán sim số đẹp giá rẻ, uy tín - chuyên nghiệp</p>
        </div>
    </div>



<style>
    #selected-type{
        padding-right: 96px;
        white-space: initial;
        line-height: 47px;     
    }
</style>