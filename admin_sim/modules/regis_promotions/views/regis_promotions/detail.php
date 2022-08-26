<?php
//    $title = @$data ? FSText :: _('Xem'): FSText :: _('Add');
global $toolbar;
//    $toolbar->setTitle($title);
//$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png');
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png');
$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');

$this -> dt_form_begin(1,4,FSText::_('Thêm giá tìm kiếm'));

//    TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
//    TemplateHelper::dt_edit_text(FSText :: _('Người gửi'),'fullname',@$data -> fullname);
?>
    <!--    <div class="form-group">-->
    <!--        <label class="col-md-2 col-xs-12 control-label">--><?php //echo FSText::_('Tiêu đề')?><!--</label>-->
    <!--        <div class="col-md-10 col-xs-12">-->
    <!--            <input disabled="disabled" type="text" class="form-control" name="title" id="title" value="--><?php //echo $data->title ?><!--" size="60">-->
    <!--        </div>-->
    <!--    </div>-->
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Tên gói cước')?></label>
        <div class="col-md-10 col-xs-12">
            <input type="text" class="form-control" name="title" id="title" value="<?php echo @$data->title ?>" size="60">
        </div>
    </div>
<!--    <div class="form-group">-->
<!--        <label class="col-md-2 col-xs-12 control-label">--><?php //echo FSText::_('Nhà mạng')?><!--</label>-->
<!--        <div class="col-md-10 col-xs-12">-->
<!--            <input type="text" class="form-control" name="network" id="network" value="--><?php //echo @$data->network ?><!--" size="60">-->
<!--        </div>-->
<!--    </div>-->
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Nhà mạng')?></label>
        <div class="col-md-10 col-xs-12">
            <select name="network_id" id="network" class="form-control">
                <?php foreach ($network as $net){ ?>
                    <option value="<?php echo @$data->network_id == $net->id ? @$data->network_id : $net->id?>" <?php echo @$data->network_id == $net->id ? 'selected' : ''?>><?php echo @$data->network == $net->name ? @$data->network : $net->name?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Giá gói cước')?></label>
        <div class="col-md-10 col-xs-12">
            <input type="text" class="form-control" name="price" id="price" value="<?php echo @$data->price ?>" size="60">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Cú pháp đăng ký gói cước')?></label>
        <div class="col-md-10 col-xs-12">
            <input type="text" style="margin-bottom: 15px;" placeholder="Cú pháp" class="form-control" name="rules_regis" id="rules_regis" value="<?php echo @$data->rules_regis ?>" size="60">
            <input type="text" placeholder="Gửi" class="form-control" name="number_send" id="number_send" value="<?php echo @$data->number_send ?>" size="60">
        </div>
    </div>
<!--    <div class="form-group">-->
<!--        <label class="col-md-2 col-xs-12 control-label">--><?php //echo FSText::_('Đầu số đăng ký gói cước')?><!--</label>-->
<!--        <div class="col-md-10 col-xs-12">-->
<!--            <input type="text" class="form-control" name="frist_number_regis" id="frist_number_regis" value="--><?php //echo @$data->frist_number_regis ?><!--" size="60">-->
<!--        </div>-->
<!--    </div>-->

    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Link')?></label>
        <div class="col-md-10 col-xs-12">
            <input type="text" class="form-control" name="link_promotions" id="link_promotions" value="<?php echo @$data->link_promotions ?>" size="60">
        </div>
    </div>

<?php
    TemplateHelper::dt_edit_text(FSText :: _('Nội dung gói cước'),'content',@$data -> content,'',650,450,1,'','','col-sm-2','col-sm-10');
    TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'','',0,'','','col-sm-2','col-sm-10');
$this -> dt_form_end(@$data,1);
?>