<?php
    global $tmpl,$module;
    $tmpl -> addScript("search","blocks/search_birth/assets/js");
 
?>
<div class="card sim-default sim-date" id="search-birthday">
                <h3 class="card-header">Tìm sim theo ngày sinh</h3>
                <div class="card-body">
                    <div class="find-date">
                        <div class="SumoSelect">
                            <!--Ngày-->
                            <input type="hidden" id="selected-day-2" name="select-day-2" value="">
                            <div class="select-day-2">
                                <div class="value-day-2">Ngày</div>
                                <div class="select-dropdown-icon">
                                    <img src="/templates/default/images/img_svg/trangchu/down_menu.svg" alt="" class="date-x">
                                </div>
                            </div>
                            <div class="ver4 options" id="choose-day-2">
                                <div class="scroll-y">
                                    <?php for ($i=1; $i <=31 ; $i++) { ?>
                                        <div class="option" value="<?php echo $i ?>" data-placement="bottom" data-toggle="tooltip"><?php echo $i ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <!--Tháng-->
                            <input type="hidden" id="selected-month-2" name="select-month-2" value="">
                            <div class="select-month-2">
                                <div class="value-month-2">Tháng</div>
                                <div class="select-dropdown-icon">
                                    <img src="/templates/default/images/img_svg/trangchu/down_menu.svg" alt="" class="date-x">
                                </div>

                            </div>
                            <div class="ver5 options" id="choose-month-2">
                                <div class="scroll-y">
                                    <?php for ($i=1; $i <=12 ; $i++) { ?>
                                        <div class="option" value="<?php echo $i ?>" data-placement="bottom" data-toggle="tooltip"><?php echo $i ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <!--Năm-->
                            <input type="hidden" id="selected-year-2" name="select-year-2" value="">
                            <div class="select-year-2">
                                <div class="value-year-2">Năm</div>
                                <div class="select-dropdown-icon">
                                    <img src="/templates/default/images/img_svg/trangchu/down_menu.svg" alt="" class="date-x">
                                </div>

                            </div>   
                            <div class="ver6 options" id="choose-year-2">
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
                <div class="card-footer">
                    <a onclick="javascript: submit_form_search_birth();return false;" href="#">Tìm kiếm sim</a>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
<!--                    <img style="margin-top: -3px;" src="https://simsodepgiare.com.vn//templates/default/images/img_svg/trangchu/xemthem_muangay_arrow.svg" alt="">-->

                </div>
            </div>