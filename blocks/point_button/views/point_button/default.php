<?php
    global $tmpl,$module;
    $tmpl -> addScript("search","blocks/point_button/assets/js");
 
?>
            <div class="card sim-default sim-geomancy">
                <h3 class="card-header">Tìm sim phong thủy</h3>
                <div class="card-body">
                    <div class="find-date find-total">

                        <input class="form-control" id="button_pt" type="text" placeholder="Tổng nút">
                        <input class="form-control" id="point_pt" type="text" placeholder="Tổng điểm">
                    </div>

                </div>
                <div class="card-footer">
                    <a onclick="javascript: submit_form_search_poin_button();return false;" href="#">Tìm kiếm sim</a>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
<!--                    <img style="margin-top: -3px;" src="https://simsodepgiare.com.vn//templates/default/images/img_svg/trangchu/xemthem_muangay_arrow.svg" alt="">-->

                </div>
            </div>