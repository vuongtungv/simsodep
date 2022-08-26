<!-- HEAD -->
<?php
$title = @$data ? FSText :: _('Edit') : FSText :: _('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply', FSText :: _('Apply'), '', 'apply.png', 1);
$toolbar->addButton('Save', FSText :: _('Save'), '', 'save.png', 1);
$toolbar->addButton('cancel', FSText :: _('Cancel'), '', 'cancel.png');
// var_dump($_SESSION);
echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>';

$this->dt_form_begin(1, 4, $title . ' ' . FSText::_('Chiết khấu / Tăng giảm giá Sim'));

TemplateHelper::dt_edit_text(FSText :: _('Tên'), 'name', @$data->name, '', 200);
?>
<div class="form-group">
    <label class="col-md-3 col-xs-12 control-label">User tạo</label>
    <div class="col-md-9 col-xs-12">
        <input type="text" class="form-control" disabled value="<?php echo @$data->user_create_name ?>" size="60" maxlength="200">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 col-xs-12 control-label">User sửa</label>
    <div class="col-md-9 col-xs-12">
        <input type="text" class="form-control" disabled value="<?php echo @$data->user_update_name ?>" size="60" maxlength="200">
    </div>
</div>
<?php

include_once 'detail_commission.php';

$this->dt_form_end(@$data, 1, 0);
?>
<!-- END HEAD-->
<script type="text/javascript">

    $('.form-horizontal').keypress(function (e) {
        if (e.which == 13) {
            formValidator();
            return false;
        }
    });

    function formValidator()
    {
        $('.alert-danger').show();
        if (!notEmpty('name', 'Bạn cần nhập tên'))
            return false;

        $('.alert-danger').hide();
        return true;
    }
</script>

