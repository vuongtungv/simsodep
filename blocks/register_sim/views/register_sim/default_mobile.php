<?php
    global $tmpl,$module;
    $tmpl->addScript("regis_promotions_mobile","blocks/register_sim/assets/js");
    $tmpl->addStylesheet('default_mobile','blocks/register_sim/assets/css');
?>

<?php

//Detect special conditions devices
$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

?>



<form class="body form-promo">
    <div class="choose-date">
        <h1 class="title-hea">Đăng ký khuyến mãi</h1>
        <select name="value-promotion" id="value-promotion" class="value-promotion">
            <?php foreach ($show_netname as $key=>$item_n){?>
                <option value="<?php echo $item_n->network_id?>" <?php if($key == 0) echo 'selected'?>><?php echo $item_n->network?></option>
            <?php }?>
        </select>
    </div>
    <div class="detail-promo">
<!--        <img src="/templates/mobile/images/bg-01.png" alt="">-->
        <div class="show-infor">
            <div class="left">
                <input type="hidden" id="id_net_work" name="id_net_work" value="<?php echo $show_netname[0]->network_id?>">
                <!--                        <img src="/templates/default/images/banner_register.png" alt="">-->
                <!--                        --><?php //echo $tmpl->load_direct_blocks('banners', array('style' => 'default_home','category_id' => '1')); ?>
                <h3 class="name-regis"><span id="name_regis"><?php echo $show_netname[0]->title?></span></h3>
                <p class="price-regis color_yell" id="price_regis"><?php echo $show_netname[0]->price?></p>
            </div>
            <div class="right detail-regis" id="detail_regis">
                <?php echo $show_netname[0]->content?>
            </div>
        </div>
        <div class="bottom-send">
            <div class="method-regis">
                <p class="">Soạn: <span id="send_detail" class="color_yell"><?php echo $regis_default[0]->rules_regis?></span></p>
                <p class="">Gửi: <span id="send_num" class="color_yell"><?php echo $regis_default[0]->number_send?></span></p>
            </div>

<!--            do something with this information-->
            <?php if($regis_default[0]->link){ ?>
                <?php if( $iPod || $iPhone ){ ?>
                    <a href="<?php echo $regis_default[0]->link?>" class="btn btn-primary quick-re quick-re-iphone">Đăng ký ngay <span>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                <?php }else if($Android){ ?>
                    <a href="<?php echo $regis_default[0]->link ?>" class="btn btn-primary quick-re quick-re-android">Đăng ký ngay <span>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                <?php } ?>
            <?php }else{ ?>
                <?php if( $iPod || $iPhone ){ ?>
                    <a href="sms:<?php echo $regis_default[0]->number_send?>&body=<?php echo $regis_default[0]->rules_regis?>" class="btn btn-primary quick-re quick-re-iphone">Đăng ký ngay <span>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                <?php }else if($Android){ ?>
                    <a href="sms:<?php echo $regis_default[0]->number_send?>?body=<?php echo $regis_default[0]->rules_regis?>" class="btn btn-primary quick-re quick-re-android">Đăng ký ngay <span>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                <?php } ?>
            <?php }?>


        </div>
    </div>
</form>



<!--<script type="text/javascript">-->
<!--    $(document).ready(function () {-->
<!--        $('#value-promotion').change(function () {-->
<!---->
<!--            $.ajax({-->
<!--                url: "index.php?module=home&view=home&task=ajax_get_promotions&raw=1",-->
<!--                data: {-->
<!--                    cid: $(this).val()-->
<!--                },-->
<!--                dataType: "json",-->
<!--                success: function(json) {-->
<!--                    // var obj = JSON.parse('{"firstName":"John", "lastName":"Doe"}');-->
<!--                    // alert(obj.firstName);-->
<!--                    // var detail_per = JSON.parse(json);-->
<!--                    alert(json.title);-->
<!--                    if(json.title !='null'){-->
<!--                        document.getElementById("detail_regis").innerHTML = json.content;-->
<!---->
<!--                        document.getElementById("name_regis").innerHTML = json.title;-->
<!--                        document.getElementById("price_regis").innerHTML = json.price;-->
<!---->
<!--                        document.getElementById("send_detail").innerHTML = json.rules_regis;-->
<!--                        document.getElementById("send_num").innerHTML = json.number_send;-->
<!---->
<!--                        document.getElementById("name_regis_pop").innerHTML = json.title;-->
<!--                        document.getElementById("send_detail_pop").innerHTML = json.rules_regis;-->
<!--                        document.getElementById("send_num_pop").innerHTML = json.number_send;-->
<!--                    }-->
<!--                }-->
<!--            });-->
<!--        });-->
<!--    });-->  
<!--</script>-->