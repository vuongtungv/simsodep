<link type="text/css" rel="stylesheet" media="all" href="../modules/members/assets/css/chosen.css" />
<script type="text/javascript" src="../modules/members/assets/js/select_multiple.js"></script>
<script type="text/javascript" src="../modules/members/assets/js/chosen.jquery.js"></script>
﻿<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<!-- HEAD -->
<?php
$title = @$data ? FSText::_('Edit') : FSText::_('Add');
global $toolbar;
$toolbar->setTitle($title);
//    $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
$toolbar->addButton('apply', FSText::_('Apply'), '', 'apply.png');
$toolbar->addButton('save', FSText::_('Save'), '', 'save.png');
$toolbar->addButton('cancel', FSText::_('Cancel'), '', 'cancel.png');

$this->dt_form_begin(1, 4, $title . ' ' . FSText::_('Thành viên'));

if (@$data->avatar) {
    $avatar = strpos(@$data->avatar, 'http') === false ? URL_ROOT . str_replace('/original/', '/original/', @$data->avatar) : @$data->avatar;
} else {
    $avatar = URL_ROOT . 'images/1473944223_unknown2.png';
}
?>
<?php
// TemplateHelper::dt_edit_text(FSText :: _('Tên đăng nhập'), 'username', @$data->username);
TemplateHelper::dt_edit_text(FSText :: _('Họ và tên'), 'name', @$data->name);
TemplateHelper::dt_edit_text(FSText :: _('Mã khách hàng'), 'code', @$data->code);
TemplateHelper::dt_edit_text(FSText :: _('Số lần mua hàng'), 'buy', @$data->buy);
TemplateHelper::dt_edit_text(FSText :: _('Mức giảm giá'), 'discount', @$data->buy);
TemplateHelper::dt_edit_text(FSText :: _('Email'), 'email', @$data->email);
TemplateHelper::dt_edit_text(FSText :: _('Số điện thoại'), 'telephone', @$data->telephone);
TemplateHelper::dt_edit_text(FSText :: _('Địa chỉ'), 'address', @$data->address); 
TemplateHelper::datetimepicke( FSText :: _('Hạn sử dụng'), 'day', @$data->day?@$data->day:date('Y-m-d H:i:s'), FSText :: _('Hạn sử dụng thành viên'), 20,'','col-md-3','col-md-4');
?>
  <div class="form-group">
        <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Giới tính")?></label>
        <div class="col-sm-9 col-xs-12">
            <select name="sex" id="sex" class="form-control">
                <option <?php if($data->sex ==0) echo 'selected';?> value="0">Nam</option>
                <option <?php if($data->sex ==1) echo 'selected';?> value="1">Nữ</option>
            </select>
<!--            <input class="form-control" type="text" name="sex" id="sex" value="--><?php //echo ($data->sex=='male')?'Nam':'Nữ' ?><!--" />-->
        </div>
    </div>
<div class="form-group position">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Hạng khách hàng") ?></label>
    <div class="col-sm-9 col-xs-12">
        <select name="position" id="position" class="form-control">
            <option value="">-- <?php echo FSText::_('Hạng khách hàng') ?> --</option>
            <?php foreach ($get_posotion as $item) { ?>
                <option value="<?php echo $item->id ?>"  <?php if(@$data->position==$item->id)echo 'selected'; ?> ><?php echo $item->name ?></option>
            <?php } ?>
        </select>
    </div>
</div>

<?php
//TemplateHelper::dt_edit_text(FSText :: _('Thuộc head'), 'headid', @$data->headid);
TemplateHelper::dt_edit_selectbox(FSText::_('Tỉnh/Tp'), 'city', @$data->city, 0, $cities, $field_value = 'id', $field_label = 'name', $size = 0, 0, 0);
?>

<?php
TemplateHelper::dt_checkbox(FSText::_('Hoạt động'), 'published', @$data->published, 1);
?>
<?php
//TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');

$this->dt_form_end(@$data, 1, 0);
?>
<script  type="text/javascript" language="javascript">






</script>