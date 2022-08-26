<?php
    global $tmpl,$module;
    $tmpl -> addScript("search","blocks/point_button/assets/js");
 
?>

<div class="find-date feng-shui">
    <h1 class="bg-title">Tìm theo phong thủy</h1>
    <form class="body">
        <div class="choose-total-point">
            <input type="text" id="button_pt" class="form form-control" placeholder="Tổng nút (1-10)" />
            <input type="text"  id="point_pt" class="form form-control" placeholder="Tổng điểm (1-80)" />
        </div>
        <div class="view-more">
            <a onclick="javascript: submit_form_search_poin_button();return false;" href="#">Tìm kiếm sim <span>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
        </div>
    </form>
</div>