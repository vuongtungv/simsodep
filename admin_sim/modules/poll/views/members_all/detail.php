<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
//$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
//$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   

	//$this -> dt_form_begin(0);
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Sửa'),'fa-edit',1,'col-md-12',1);
?>
    <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label"><?php echo FSText::_('Câu hỏi')?></label>
        <div class="col-md-9 col-xs-12">
            <input style="width: 60%; float: left;" type="text" class="form-control" name="questions" id="questions" value="<?php echo @$data -> name ?>" size="60">
            <input disabled="disabled" style="width: 20%; float: right; text-align: center;" type="text" class="form-control" name="count_questions" id="count_questions" value="<?php echo @$data->total_poll ?> phiếu" size="60">
        </div>
    </div>
    <?php  $j=0;
        foreach($answers as $item){ 
            $j++;
            $count_answer = $model->getCountAnswer($item->id);
    ?>
        <div class="form-group">
            <label class="col-md-3 col-xs-12 control-label"><?php echo FSText::_('Lựa chọn')?></label>
            <div class="col-md-9 col-xs-12">
                <input style="width: 60%; float: left;" type="text" class="form-control" name="questions_name" id="questions_name" value="<?php echo $item->title ?>" size="60">
                <?php if($count_answer){?>
                    <input disabled="disabled" style="width: 20%; float: left; text-align: center;" type="text" class="form-control" name="questions_name" id="questions_name" value="<?php echo number_format($count_answer/$data->total_poll*100, 2, ',', '.');?>%" size="60">
                <?php }?>
                <input disabled="disabled" style="width: 20%; float: right; text-align: center;" type="text" class="form-control" name="questions_name" id="questions_name" value="<?php echo $count_answer ?> phiếu" size="60">
            </div>
        </div>
    <?php }?>
<?php
//        TemplateHelper::datetimepicke( FSText::_('Thời gian nhận xét' ), 'created_time', @$data->created_time?@$data->created_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20,'','col-md-3','col-md-4');
	$this->dt_form_end_col(); // END: col-1s
//    $this -> dt_form_begin(1,4,FSText::_('Kích hoạt'),'fa-unlock',1,'col-md-4 fl-right');
//        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1,'','','','col-sm-4','col-sm-6');
//        TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'','',0,'','','col-sm-4','col-sm-6');
//    $this->dt_form_end_col(); // END: col-2
    $this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4'); 
?>
