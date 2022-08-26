<?php
    global $tmpl,$module;
    $tmpl -> addScript("search","blocks/search_birth/assets/js");
 
?>

<div class="find-date">
    <h1 class="bg-title">Tìm theo ngày sinh</h1>
    <div class="body">
        <div class="choose-date">
            <div class="SumoSelect">
                <!--Ngày-->
                <select id="selected-day-2" name="select-day-2" class="select-date">
                    <option value="0">Ngày</option>
                    <?php for ($i=1; $i <=31 ; $i++) { ?>
                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php } ?>
                </select>
                <!--Tháng-->
                <select id="selected-month-2" name="select-month-2" class="select-date">
                    <option value="0">Tháng</option>
                    <?php for ($i=1; $i <=12 ; $i++) { ?>
                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php } ?>
                </select>
                <!--Năm-->
                <select id="selected-year-2" name="select-year-2" class="select-date">
                    <option value="0">Năm</option>
                    <?php for ($i=1930; $i <=2019 ; $i++) { ?>
                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="view-more">
            <a onclick="javascript: submit_form_search_birth();return false;" href="#">Tìm kiếm sim <span>&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
        </div>
    </div>
</div>