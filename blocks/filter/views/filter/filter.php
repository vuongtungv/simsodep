
        <tr>
            <th width="6%"><div class="border-right">STT</div></th>
            <th width="20%">
                <div class="border-right numbersim2">
                    <div class="show-sim-head">
                        <input type="hidden" id="show-sim-head" name="show-sim-head">
                        <div class="show-value">
                            <p class="p-dots">
                                Đầu số
                                <span class="img_dotss"></span>
<!--                                <div class="img_dotss svg-dots-head-table">-->
<!--                                    <span class="dot"></span>-->
<!--                                    <span class="dot"></span>-->
<!--                                    <span class="dot"></span>-->
<!--                                </div>-->
                            </p>
                        </div>
                        <div class="options" style="display: none;">
                            <div class="scroll-y">

                                <?php 
                                    $check = '';
                                    if ($order) {
                                        $param['order']= $order;
                                    }else{
                                        unset($param['order']);
                                    }

                                    if (!$param['head']) {
                                        $check = 'checked';
                                    }

                                    unset($param['head']);

                                    $link = FSRoute::addPram($param,$url);
                                ?>

                                    <div data="<?php echo $link ?>"  class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
                                        <input <?php echo $check ?> type="checkbox" class="custom-control-input" id="headall">
                                        <label class="custom-control-label" for="headall">
                                            <p class="phone">Tất cả</p>
                                        </label>
                                    </div>

                                <?php 
                                    $check = '';
                                    if ($order) {
                                        $param['order']= $order;
                                    }else{
                                        unset($param['order']);
                                    }


                                    $param['head']= 'new';

                                    if ($head == 'new') {
                                         unset($param['head']);
                                        $check = 'checked';
                                    }
                                    $link = FSRoute::addPram($param,$url);
                                ?>

                                    <div data="<?php echo $link ?>"  class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
                                        <input <?php echo $check ?> type="checkbox" class="custom-control-input" id="typemoi">
                                        <label class="custom-control-label" for="typemoi">
                                            <p class="phone">Đầu số mới</p>
                                        </label>
                                    </div>

                                <?php 
                                    $check = '';
                                    if ($order) {
                                        $param['order']= $order;
                                    }else{
                                        unset($param['order']);
                                    }


                                    $param['head']= 'old';

                                    if ($head == 'old') {
                                         unset($param['head']);
                                        $check = 'checked';
                                    }
                                    $link = FSRoute::addPram($param,$url);
                                ?>
                                    <div data="<?php echo $link ?>"  class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
                                        <input <?php echo $check ?> type="checkbox" class="custom-control-input" id="typecu">
                                        <label class="custom-control-label" for="typecu">
                                            <p class="phone">Đầu số Cũ</p>
                                        </label>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </th>

            <th width="20%">
                <div class="border-right numbersim3">
                    <div class="show-sim-price">
                        <input type="hidden" id="show-sim-price" name="show-sim-price">
                        <div class="show-value">
                            <p class="p-dots">
                                Giá bán
                                <span class="img_dotss"></span>

                            </p>
                        </div>
                        <div class="options options-befa-all" style="display: none;">
                            <div class="scroll-y">

                                <?php 
                                    $check = '';

                                    if ($order) {
                                        $param['order']= $order;
                                    }else{
                                        unset($param['order']);
                                    }

                                    if ($head) {
                                        $param['head']= $head;
                                    }else{
                                        unset($param['head']);
                                    }

                                    if (!$param['price']) {
                                        $check = 'checked';
                                    }
                                    unset($param['price']);
                                    $link = FSRoute::addPram($param,$url);
                                 ?>

                                    <div data="<?php echo $link ?>"  class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
                                        <input <?php echo $check ?> type="checkbox" class="custom-control-input" id="priceall">
                                        <label class="custom-control-label" for="priceall">
                                            <p class="phone">Tất cả</p>
                                        </label>
                                    </div>

                                <?php foreach ($prices as $item) {
                                    $check = '';

                                    if ($order) {
                                        $param['order']= $order;
                                    }else{
                                        unset($param['order']);
                                    }

                                    if ($head) {
                                        $param['head']= $head;
                                    }else{
                                        unset($param['head']);
                                    }

                                    $param['price']= $item->id;

                                    if ($item->id == @$price) {
                                         unset($param['price']);
                                        $check = 'checked';
                                    }
                                    $link = FSRoute::addPram($param,$url);
                                    ?>
                                    <div data="<?php echo $link ?>"  class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
                                        <input <?php echo $check ?> type="checkbox" class="custom-control-input" id="type<?php echo $item->name ?>">
                                        <label class="custom-control-label" for="type<?php echo $item->name ?>">
                                            <p class="phone"><?php echo $item->title ?></p>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </th>

            <th width="16%">
                <div class="border-right numbersim4">
                    <div class="selected-network-sim">
                        <input type="hidden" id="selected-network-sim" name="selected-network-sim">
                        <div class="show-value">
                            <p class="p-dots">
                                Nhà mạng
                                <span class="img_dotss"></span>
                            </p>
                        </div>
                        <div class="options" style="display: none;">
                            <div class="scroll-y">
                                <?php
                                    $check = '';

                                    if ($order) {
                                        $param['order']= $order;
                                    }else{
                                        unset($param['order']);
                                    }

                                    if ($head) {
                                        $param['head']= $head;
                                    }else{
                                        unset($param['head']);
                                    }

                                    if ($price) {
                                        $param['price']= $price;
                                    }else{
                                        unset($param['price']);
                                    }

                                    if (!$param['mang']) {
                                        $check = 'checked';
                                    }
                                    unset($param['mang']);
                                    $link = FSRoute::addPram($param,$url);

                                  ?>

                                    <div data="<?php echo $link ?>"  class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
                                        <input <?php echo $check ?> type="checkbox" class="custom-control-input" id="netall">
                                        <label class="custom-control-label" for="netall">
                                            <p class="phone">Tất cả</p>
                                        </label>
                                    </div>

                                <?php foreach ($net as $item) {
                                    $check = '';

                                    if ($order) {
                                        $param['order']= $order;
                                    }else{
                                        unset($param['order']);
                                    }

                                    if ($head) {
                                        $param['head']= $head;
                                    }else{
                                        unset($param['head']);
                                    }

                                    if ($price) {
                                        $param['price']= $price;
                                    }else{
                                        unset($param['price']);
                                    }

                                    $param['mang']= $item->alias;

                                    if ($item->alias == @$network) {
                                         unset($param['mang']);
                                        $check = 'checked';
                                    }
                                    $link = FSRoute::addPram($param,$url);
                                    ?>
                                    <div data="<?php echo $link ?>"  class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
                                        <input <?php echo $check ?> type="checkbox" class="custom-control-input" id="type<?php echo $item->name ?>">
                                        <label class="custom-control-label" for="type<?php echo $item->name ?>">
                                            <p class="phone"><?php echo $item->name ?></p>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </th>
            <th width="23%">
                <div class="border-right numbersim5">
                    <!--Thể loại <img src="images/cham.png" alt="">-->
                    <div class="show-sim-type">
                        <input type="hidden" id="selected-type-sim" name="select-type-sim">
                        <div class="show-value">
                            <p class="p-dots">
                                Thể loại
                                <?php if ($trang != 'list') {?>
                                    <span class="img_dotss"></span>
                                <?php } ?>
                            </p>
                        </div>
                            <?php if ($trang != 'list') {?>
                            <div class="options" style="display: none;">
                                <div class="scroll-y">

                                    <?php 
                                        $check = '';
                                        
                                        if ($order) {
                                            $param['order']= $order;
                                        }else{
                                            unset($param['order']);
                                        }
                                        
                                        if ($head) {
                                            $param['head']= $head;
                                        }else{
                                            unset($param['head']);
                                        }

                                        if ($price) {
                                            $param['price']= $price;
                                        }else{
                                            unset($param['price']);
                                        }

                                        if ($network) {
                                            $param['mang']= $network;
                                        }else{
                                            unset($param['mang']);
                                        }

                                        if (!$param['cat']) {
                                            $check = 'checked';
                                        }
                                        unset($param['cat']);
                                        $link = FSRoute::addPram($param,$url);
                                     ?>

                                        <div data="<?php echo $link ?>"  class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
                                            <input <?php echo $check ?> type="checkbox" class="custom-control-input" id="typeall">
                                            <label class="custom-control-label" for="typeall">
                                                <p class="phone">Tất cả</p>
                                            </label>
                                        </div>

                                    <?php foreach ($type as $item) {
                                        $check = '';
                                        
                                        if ($order) {
                                            $param['order']= $order;
                                        }else{
                                            unset($param['order']);
                                        }
                                        
                                        if ($head) {
                                            $param['head']= $head;
                                        }else{
                                            unset($param['head']);
                                        }

                                        if ($price) {
                                            $param['price']= $price;
                                        }else{
                                            unset($param['price']);
                                        }

                                        if ($network) {
                                            $param['mang']= $network;
                                        }else{
                                            unset($param['mang']);
                                        }

                                        $param['cat']= $item->alias;
                                        if ($item->alias == @$cat) {
                                             unset($param['cat']);
                                            $check = 'checked';
                                        }
                                        $link = FSRoute::addPram($param,$url);
                                        ?>
                                        <div data="<?php echo $link ?>"  class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
                                            <input <?php echo $check ?> type="checkbox" class="custom-control-input" id="type<?php echo $item->name ?>">
                                            <label class="custom-control-label" for="type<?php echo $item->name ?>">
                                                <p class="phone"><?php echo $item->name ?></p>
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>
                            <?php } ?>
                    </div>
                </div>
            </th>
            
            <th width="10%"><div class="border-right">Điểm</div></th>
            <th width="10%"><img src="/templates/default/images/img_svg/sim_theo_nha_mang/bar_cart.svg" alt=""></th>
            <th width="7%"><img style="margin-top: 3px;" src="/templates/default/images/img_svg/sim_theo_nha_mang/bar_pay.svg" alt=""></th>
        </tr>