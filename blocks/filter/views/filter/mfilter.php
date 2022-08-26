<div id="accordion2" class="accordion2">

    <div class="title-tog" id="headingIdFour">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseIdFour" aria-expanded="false" aria-controls="collapseFour">
            Đầu số
        </button>
    </div>
    <div id="collapseIdFour" class="collapse tog-show" aria-labelledby="headingIdFour" data-parent="#accordion2">

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

    <div class="title-tog" id="headingIdThree">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseIdThree" aria-expanded="false" aria-controls="collapseThree">
            Giá bán
        </button>
    </div>
    <div id="collapseIdThree" class="collapse tog-show" aria-labelledby="headingIdThree" data-parent="#accordion2">

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

    <div class="title-tog" id="headingIdOne">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseIdOne" aria-expanded="false" aria-controls="collapseOne">
            Nhà mạng
        </button>
    </div>
    <div id="collapseIdOne" class="collapse tog-show" aria-labelledby="headingIdOne" data-parent="#accordion2">
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
        <div  data="<?php echo $link ?>" class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
            <input <?php echo $check ?> type="checkbox" class="custom-control-input" id="n_<?php echo $item->name ?>">
            <label class="custom-control-label" for="n_<?php echo $item->name ?>">
                <p class="phone"><?php echo $item->name ?></p>
            </label>
        </div>
        <?php } ?>
    </div>

    <div class="title-tog" id="headingIdTwo">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseIdTwo" aria-expanded="false" aria-controls="collapseTwo">
            Thể loại
        </button>
    </div>
    <div id="collapseIdTwo" class="collapse tog-show" aria-labelledby="headingIdTwo" data-parent="#accordion2">
        <div class="scroll-y height-scroll-s">
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

            <?php if ($trang != 'list') {?>
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

                if ($network) {
                    $param['mang']= $network;
                }else{
                    unset($param['mang']);
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

                $param['cat']= $item->alias;
                if ($item->alias == @$cat) {
                     unset($param['cat']);
                    $check = 'checked';
                }
                $link = FSRoute::addPram($param,$url);
                ?>
                <div data="<?php echo $link ?>" class="custom-control custom-checkbox custom-control-inline item-compare check-filter">
                    <input <?php echo $check ?> type="checkbox" value="<?php echo $item->alias ?>" class="custom-control-input" id="s_<?php echo $item->name ?>">
                    <label class="custom-control-label" for="s_<?php echo $item->name ?>">
                        <p class="phone"><?php echo $item->name ?></p>
                    </label>
                </div>
            <?php } ?>
            <?php } ?>
        </div>
    </div>
    <div class="bor-bot"></div>
</div>