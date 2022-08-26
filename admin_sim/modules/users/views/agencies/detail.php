<!-- HEAD -->
<?php
$title = @$data ? FSText :: _('Edit') : FSText :: _('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply', FSText :: _('Apply'), '', 'apply.png', 1);
$toolbar->addButton('Save', FSText :: _('Save'), '', 'save.png', 1);
$toolbar->addButton('cancel', FSText :: _('Cancel'), '', 'cancel.png');

echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>';

$this->dt_form_begin(1, 4, $title . ' ' . FSText::_('Chiết khấu'));

TemplateHelper::dt_edit_text(FSText :: _('Tên chiết khấu'), 'name', @$data->name, '', 200);

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
        if (!notEmpty('name', 'Bạn cần nhập tên chiết khấu'))
            return false;

        $('.alert-danger').hide();
        return true;
    }
</script>

