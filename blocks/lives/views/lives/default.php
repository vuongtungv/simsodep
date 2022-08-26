<?php
    global $tmpl,$module;
    // $tmpl -> addScript("search","blocks/lives/assets/js");
 
?>
            <div class="card sim-default sim-combine-destiny">
                <h3 class="card-header">Tìm sim hợp mệnh</h3>
                <div class="card-body">
                    <div class="box-combine-destiny">
                        <p><a href="<?php echo URL_ROOT.'sim-hop-menh-kim.html' ?>"><img src="/templates/default/images/img_svg/trangchu/menh_kim.svg" alt=""><span><img
                                        src="/templates/default/images/img_svg/trangchu/line.svg" alt=""></span>Sim
                            Hợp Mệnh Kim</a></p>
                        <p><a href="<?php echo URL_ROOT.'sim-hop-menh-moc.html' ?>"><img src="/templates/default/images/img_svg/trangchu/menh_moc.svg" alt=""><span><img src="/templates/default/images/img_svg/trangchu/line.svg" alt=""></span>Sim
                            Hợp Mệnh Mộc</a></p>
                        <p><a href="<?php echo URL_ROOT.'sim-hop-menh-thuy.html' ?>"><img src="/templates/default/images/img_svg/trangchu/menh_thuy.svg" alt=""><span><img src="/templates/default/images/img_svg/trangchu/line.svg" alt=""></span>Sim
                            Hợp Mệnh Thủy</a></p>
                        <p><a href="<?php echo URL_ROOT.'sim-hop-menh-hoa.html' ?>"><img src="/templates/default/images/img_svg/trangchu/menh_hoa.svg" alt=""><span><img src="/templates/default/images/img_svg/trangchu/line.svg" alt=""></span>Sim
                            Hợp Mệnh Hỏa</a></p>
                        <p><a href="<?php echo URL_ROOT.'sim-hop-menh-tho.html' ?>"><img src="/templates/default/images/img_svg/trangchu/menh_tho.svg" alt=""><span><img src="/templates/default/images/img_svg/trangchu/line.svg" alt=""></span>Sim
                            Hợp Mệnh Thổ</a></p>
                    </div>
                    <!-- theo ngày tháng năm sinh -->
                    <div class="find-date">
                        <div class="SumoSelect">
                            <!--Ngày-->
                            <input type="hidden" id="selected-day" name="select-day" value="1">
                            <div class="select-day">
                                <div class="value-day">Ngày</div>
                                <div class="select-dropdown-icon">
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </div>
                                <div class="options">
                                    <div class="scroll-y">
                                        <?php for ($i=1; $i <=31 ; $i++) { ?>
                                            <div class="option" value="<?php echo $i ?>" data-placement="bottom" data-toggle="tooltip"><?php echo $i ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!--Tháng-->
                            <input type="hidden" id="selected-month" name="select-month" value="1">
                            <div class="select-month">
                                <div class="value-month">Tháng</div>
                                <div class="select-dropdown-icon">
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </div>
                                <div class="options">
                                    <div class="scroll-y">
                                        <?php for ($i=1; $i <=12 ; $i++) { ?>
                                            <div class="option" value="<?php echo $i ?>" data-placement="bottom" data-toggle="tooltip"><?php echo $i ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!--Năm-->
                            <input type="hidden" id="selected-year" name="select-year" value="1">
                            <div class="select-year">
                                <div class="value-year">Năm</div>
                                <div class="select-dropdown-icon">
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </div>
                                <div class="options">
                                    <div class="scroll-y">
                                        <?php for ($i=1930; $i <=2019 ; $i++) { ?>
                                            <div class="option" value="<?php echo $i ?>" data-placement="bottom" data-toggle="tooltip"><?php echo $i ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="type-number">
                        <label class="checkcontainer">Nam
                            <input type="radio" checked="checked" name="gender">
                            <span class="radiobtn"></span>
                        </label>
                        <label class="checkcontainer" style=" margin-left: 14px;">Nữ
                            <input type="radio" name="gender">
                            <span class="radiobtn"></span>
                        </label>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#">Tìm kiếm sim</a>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
<!--                    <img style="margin-top: -2px;" src="--><?php //echo URL_ROOT?><!--templates/default/images/img_svg/trangchu/xemthem_muangay_arrow.svg" alt="">-->

                </div>
            </div>