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
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Giá')?></label>
        <div class="col-md-10 col-xs-12">
            <input type="text" class="form-control" name="title" id="title" value="<?php echo @$data->title ?>" size="60">
            <input type="text" style="margin-top: 15px;" class="form-control" name="price" id="price" value="<?php echo @$data->price ?>" size="60">
        </div>
    </div>

<?php
//    TemplateHelper::dt_edit_text(FSText :: _('Nội dung'),'content',@$data -> content,'',650,450,1,'','','col-sm-2','col-sm-10');

$this -> dt_form_end(@$data,1);
?>