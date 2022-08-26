<?php
    global $tmpl,$module;
    $tmpl -> addScript("search","blocks/network/assets/js");
    $header = '';
?>
            <div class="quick-filter quick-filter-number">
<!--                <span class="title-hea">Tìm nhanh theo đầu số</span>-->
                <div class="SumoSelect">
                    <!--Theo nhà mạng-->

                    <!--Xem toàn bộ sim-->
                    <a onclick="javascript: submit_form_search_network();return false;" href="<?php echo URL_ROOT.'danh-sach-sim.html' ?>" class="all-sim btn btn-primary">Xem toàn bộ sim trong hệ thống</a>
                </div>
            </div>

<style>
    .quick-first .scroll-y{
        height: 200px !important;   
    }
</style>