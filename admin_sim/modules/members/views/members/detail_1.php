<!--﻿<link type="text/css" rel="stylesheet" media="all" href="../modules/members/assets/css/chosen.css" />
<script type="text/javascript" src="../modules/members/assets/js/select_multiple.js"></script>
<script type="text/javascript" src="../modules/members/assets/js/chosen.jquery.js"></script>-->
<!--﻿<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>-->
<!--<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />-->
<!-- HEAD -->
<?php
$task = FSInput::get('task');
$module_ = FSInput::get('module');
$view = FSInput::get('víew');
$title = @$data ? FSText::_('Edit') : FSText::_('Add');
global $toolbar;
$toolbar->setTitle($title);
//    $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
$toolbar->addButton('apply', FSText::_('Apply'), '', 'apply.png', 1);
$toolbar->addButton('save', FSText::_('Save'), '', 'save.png', 1);
$toolbar->addButton('cancel', FSText::_('Cancel'), '', 'cancel.png');

echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
		    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </div>';


$this->dt_form_begin(1, 4, $title . ' ' . FSText::_('Thành viên'));

if (@$data->avatar) {
    $avatar = strpos(@$data->avatar, 'http') === false ? URL_ROOT . str_replace('/original/', '/original/', @$data->avatar) : @$data->avatar;
} else {
    $avatar = URL_ROOT . 'images/1473944223_unknown2.png';
}
?>

<input type="hidden" id="type_user" value="<?php echo @$data->type ?>">
<input type="hidden" id="id_user" value="<?php echo @$data->id ?>">
<?php if (!isset($data)) { ?>
    <div class="form-group">
        <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Chọn loại thành viên") ?></label>
        <div class="col-sm-9 col-xs-12">
            <select name="type" id="type_member" class="form-control">
                <option value="0">-- <?php echo FSText::_('Chọn loại thành viên') ?> --</option>
                <option value="1" <?php if (@$data->type == 1) echo 'selected' ?>>HVN</option>
                <option value="2" <?php if (@$data->type == 2) echo 'selected' ?>>Head</option>
            </select>
        </div>
    </div>
<?php } ?>
<div class="form-group headid  <?php if (@$data->type != 3) echo 'block_field' ?>">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Thuộc head") ?></label>
    <div class="col-sm-9 col-xs-12">
        <select name="headid" id="headid" class="form-control">
            <option value="0">-- <?php echo FSText::_('Chọn Head') ?> --</option>
            <?php foreach ($get_members_head as $value) { ?>
                <?php $total_user = $this->model->get_records('creator_id=' . $value->id); ?>
                <option value="<?php echo $value->id ?>" <?php if (@$data->creator_id == $value->id) echo 'selected' ?> data-total="<?php echo count($total_user) ?>"><?php echo $value->username ?></option>

            <?php } ?>
            <input type="hidden" name="id_head" id="id_head" value="">
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Tên đăng nhập") ?></label>
    <div class="col-sm-9 col-xs-12">
        <input class="form-control" type="text" name="username" id="username" value="<?php echo @$data->username ?>" maxlength="255" <?php if ($task == 'edit') echo 'readonly="true"' ?>/>
        <p id="username_error" style="color:#ff0000"></p>
    </div>
</div>
<?php
//TemplateHelper::dt_edit_text(FSText :: _('Tên đăng nhập'), 'username', @$data->username);
?>
<!--<div class="form-group">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Mật khẩu") ?></label>
    <div class="col-sm-9 col-xs-12">
        <input class="form-control" type="password" name="password" id="password" value="<?php echo @$data->password ?>" />
    </div>
</div>-->
<div class="form-group dsc_code  <?php if (@$data->type != 3) echo 'block_field' ?>">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("DSC code") ?></label>
    <div class="col-sm-9 col-xs-12">
        <input class="form-control" name="code_dcs" id="code" value="<?php echo @$data->code_dcs ?>" maxlength="255">
        <p id="code_error" style="color:#ff0000"></p>
    </div>
</div>
<div class="form-group department  <?php if (@$data->type != 1) echo 'block_field' ?>">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Phòng ban") ?></label>
    <div class="col-sm-9 col-xs-12">
        <select name="department" id="department" class="form-control">
            <option value="">-- <?php echo FSText::_('Chọn phòng ban') ?> --</option>
            <?php foreach ($get_department as $item) { ?>
                <option value="<?php echo $item->id ?>" <?php if (@$data->department == $item->id) echo 'selected'; ?> ><?php echo $item->name ?></option>
            <?php } ?>
        </select>

    </div>
</div>

<div class="form-group cmt  <?php if (@$data->type != 3) echo 'block_field' ?>">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("CMT") ?></label>
    <div class="col-sm-9 col-xs-12">
        <input class="form-control" name="cmt" id="cmt" value="<?php echo @$data->cmt ?>" maxlength="12">
        <p id="cmt_error" style="color:#ff0000"></p>
    </div>
</div>

<?php
TemplateHelper::dt_edit_text(FSText :: _('Email'), 'email', @$data->email);
?>
<div class="form-group">
    <label class="col-sm-3 col-xs-12 control-label"></label>
    <div class="col-sm-9 col-xs-12">
        <p id="email_error" style="color:#ff0000"></p>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Họ và tên") ?></label>
    <div class="col-sm-9 col-xs-12">
        <input class="form-control" type="text" name="name" id="name" value="<?php echo @$data->name ?>" maxlength="255"  <?php if ($task == 'edit') echo 'readonly="true"' ?>/>
        <p id="username_error" style="color:#ff0000"></p>
    </div>
</div>

<div class="form-group sex">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Giới tính") ?></label>
    <div class="col-sm-2 col-xs-2">
        <select name="sex" id="sex" class="form-control">
<!--            <option value="">-- <?php echo FSText::_('Giới tính') ?> --</option>-->
            <option value="1"  <?php if (@$data->sex == 1) echo 'selected'; ?> >Nam</option>
            <option value="2"  <?php if (@$data->sex == 2) echo 'selected'; ?> >Nữ</option>
        </select>
    </div>
</div>

<div class="form-group position <?php if (@$data->type != 3) echo 'block_field' ?>">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Chức vụ") ?></label>
    <div class="col-sm-9 col-xs-12">
        <select name="position" id="position" class="form-control">
            <option value="">-- <?php echo FSText::_('Chọn chức vụ') ?> --</option>
            <?php foreach ($get_posotion as $item) { ?>
                <option value="<?php echo $item->id ?>"  <?php if (@$data->position == $item->id) echo 'selected'; ?> ><?php echo $item->name ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group workstart   <?php if (@$data->type == 2) echo 'block_field' ?>">
    <?php TemplateHelper::datetimepicke(FSText :: _('Thời gian bắt đầu làm việc'), 'workstart', @$data->workstart ? @$data->workstart : date('m-Y'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20, '', 'col-md-3', 'col-md-4'); ?>
<!--    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Thời gian bắt đầu làm việc") ?></label>
    <div class="col-sm-9 col-xs-12">
        <input  class="form-control" name="workstart" id="word_start" value="<?php echo @$data->workstart ?>">
     
    </div>-->
</div>


<div class="form-group city <?php if (@$data->type != 2) echo 'block_field' ?>" >
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Tỉnh/Tp") ?></label>
    <div class="col-sm-9 col-xs-12">
        <select name="city" id="city" class="form-control">
            <option value="">-- <?php echo FSText::_('Tỉnh/Tp') ?> --</option>
            <?php foreach ($cities as $item) { ?>
                <option value="<?php echo $item->id ?>" <?php if (@$data->city == $item->id) echo 'selected' ?>><?php echo $item->name ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<?php
//TemplateHelper::dt_edit_selectbox(FSText::_('Tỉnh/Tp'), 'city', @$data->city_id, 0, $cities, $field_value = 'id', $field_label = 'name', $size = 10, 0, 1);
?>

<?php
TemplateHelper::dt_checkbox(FSText::_('Trạng thái'), 'published', @$data->published, 1);
TemplateHelper::dt_checkbox(FSText::_('Password'), 'edit_pass', isset($data) ? 0 : 1, 0);
?>
<input type="hidden" name="" id="task_" value="<?php echo $task ?>">
<div class="form-group password_area " style="display: <?php echo @$data->id ? "none" : "block" ?>;">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Mật khẩu") ?></label>
    <div class="col-sm-6 col-xs-12">
        <input class="form-control" type="password" name="password" id="password1" />
    </div>
</div>
<div class="form-group password_area" style="display: <?php echo @$data->id ? "none" : "block" ?>;">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Xác nhận mật khẩu") ?></label>
    <div class="col-sm-6 col-xs-12">
        <input class="form-control" type="password" name="re-password" id="re-password" />
    </div>
</div>
<?php
//TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');

$this->dt_form_end(@$data, 1, 0);
?>
<script  type="text/javascript" language="javascript">

    $(function () {

        var $task_ = $('#task_').val();
        check_exist_user();
        check_exist_email();
        check_exist_dcs();
        check_exist_cmt();
        $("select#type_member").change(function () {
            var $vl_type = $(this).val();
            if ($vl_type == 1) {
                $('.headid').hide();
                $('.position').hide();
                $('.city').hide();
                $('.dsc_code').hide();
                $('.cmt').hide();
                $('.sex').hide();
                $('.department').show();
            } else if ($vl_type == 2) {
                $('.headid').hide();
                $('.position').hide();
                $('.dsc_code').hide();
                $('.cmt').hide();
                $('.department').hide();
                $('.workstart').hide();
                $('.city').show();
                $('.sex').hide();
            } else if ($vl_type == 3) {
                $('.headid').show();
                $('.position').show();
                $('.dsc_code').show();
                $('.cmt').show();
                $('.department').hide();
                $('.workstart').show();
                $('.city').hide();
                $('.sex').show();
                $("select#headid").change(function () {
                    var $user_head = $("#headid option:selected").text();
                    var $id_head = $("#headid option:selected").val();
                    var $total_user = $("#headid option:selected").attr('data-total');
                    $("#username").val($user_head + '_0' + ($total_user + 1));
                    $("#id_head").val($id_head);
                    $("#username").prop('readonly', true);
                });
            }
        });
    })

    $('#edit_pass_0').click(function () {
        $('.password_area').hide();
    });
    $('#edit_pass_1').click(function () {
        $('.password_area').show();
    });
    /* CHECK EXIST  EMAIL */
    function check_exist_email() {
        $user_id = $('#id_user').val();
        $('#email').blur(function () {
            if ($(this).val() != '') {
                $.ajax({url: "/index.php?module=users&task=ajax_check_exist_email&raw=1",
                    data: {email: $(this).val(), id: $user_id},
                    dataType: "text",
                    success: function (result) {
                        $('label.username_check').prev().remove();
                        $('label.username_check').remove();
                        if (result == 0) {
                            $('#email_succes').text('');
                            $('#email_error').text('Email này đã tồn tại. Bạn hãy sử dụng email khác!');
                            $('#email').focus();
                            //    invalid('email', 'Email này đã tồn tại. Bạn hãy sử dụng email khác');

                        } else {
                            $('#email_error').text('');
                            $('#email_succes').text('Email này được chấp nhận!!');
//                        valid('email');
//                        $('<br/><div id=\'email_error\' class=\'label_success username_check\'>' + 'Tên truy nhập này được chấp nhận' + '</div>').insertAfter($('#email').parent().children(':last'));
                        }
                    }
                });
            }
        });
    }
    /* CHECK EXIST  EMAIL */
    function check_exist_user() {
        $user_id = $('#id_user').val();
        $('#username').blur(function () {
            if ($(this).val() != '') {
                $.ajax({url: "/index.php?module=users&task=ajax_check_exist_username&raw=1",
                    data: {username: $(this).val(), id: $user_id},
                    dataType: "text",
                    success: function (result) {
                        $('label.username_check').prev().remove();
                        $('label.username_check').remove();
                        if (result == 0) {
                            $('#email_succes').text('');
                            $('#username_error').text('Tên đăng nhập này đã tồn tại. Vui lòng sử dụng tên đăng nhập khác');
                            $('#username').focus();
                            //    invalid('email', 'Email này đã tồn tại. Bạn hãy sử dụng email khác');

                        } else {
                            $('#username_error').text('');
                            $('#email_succes').text('Tên đăng nhập này được chấp nhận!!');
//                        valid('email');
//                        $('<br/><div id=\'email_error\' class=\'label_success username_check\'>' + 'Tên truy nhập này được chấp nhận' + '</div>').insertAfter($('#email').parent().children(':last'));
                        }
                    }
                });
            }
        });
    }
    /* CHECK EXIST  DCS */
    function check_exist_dcs() {
        $user_id = $('#id_user').val();
        $('#code').blur(function () {
            if ($(this).val() != '') {
                $.ajax({url: "/index.php?module=users&task=ajax_check_exist_dcs&raw=1",
                    data: {code_dcs: $(this).val(), id: $user_id},
                    dataType: "text",
                    success: function (result) {
                        $('label.username_check').prev().remove();
                        $('label.username_check').remove();
                        if (result == 0) {
                            $('#email_succes').text('');
                            $('#code_error').text('DCS code bị trùng. Bạn vui lòng nhập DCS code khác!');
                            $('#code').focus();
                            //    invalid('email', 'Email này đã tồn tại. Bạn hãy sử dụng email khác');

                        } else {
                            $('#code_error').text('');
//                            $('#code_error').text('Tên đăng nhập này được chấp nhận!!');
//                        valid('email');
//                        $('<br/><div id=\'email_error\' class=\'label_success username_check\'>' + 'Tên truy nhập này được chấp nhận' + '</div>').insertAfter($('#email').parent().children(':last'));
                        }
                    }
                });
            }
        });
    }
    /* CHECK EXIST  CMT */
    function check_exist_cmt() {
        $user_id = $('#id_user').val();
        $('#cmt').blur(function () {
            if ($(this).val() != '') {
                $.ajax({url: "/index.php?module=users&task=ajax_check_exist_cmt&raw=1",
                    data: {cmt: $(this).val(), id: $user_id},
                    dataType: "text",
                    success: function (result) {
                        $('label.username_check').prev().remove();
                        $('label.username_check').remove();
                        if (result == 0) {
                            $('#email_succes').text('');
                            $('#cmt_error').text('Số CMT bị trùng. Bạn vui lòng nhập lại!');
                            $('#cmt').focus();
                            //    invalid('email', 'Email này đã tồn tại. Bạn hãy sử dụng email khác');

                        } else {
                            $('#cmt_error').text('');
//                            $('#code_error').text('Tên đăng nhập này được chấp nhận!!');
//                        valid('email');
//                        $('<br/><div id=\'email_error\' class=\'label_success username_check\'>' + 'Tên truy nhập này được chấp nhận' + '</div>').insertAfter($('#email').parent().children(':last'));
                        }
                    }
                });
            }
        });
    }
    $('#username').keyup(function (e) {
        var characterReg = /^\s*[a-zA-Z0-9,\s]+\s*$/;
        var str = $(this).val();
        if (!characterReg.test(str)) {
            str = removeDiacritics(str);
            $(this).val(str);
        }
        if (e.which === 32) {
            //alert('No space are allowed in usernames'); 
            str = str.replace(/\s/g, '');
            $(this).val(str);
        }
        var characterReg2 = /^([a-zA-Z0-9]{6,100})$/;
        if (!characterReg2.test(str)) {

            str = removeDiacritics(str);
            str = str.replace(/\s/g, '');
            $(this).val(str);
        }

    }).blur(function () {
        var str = $(this).val();
        str = removeDiacritics(str);
        str = str.replace(/\s/g, '');
        $(this).val(str);
    });
    function removeDiacritics(input)
    {
        var output = "";
        var normalized = input.normalize("NFD");
        var i = 0;
        var j = 0;
        while (i < input.length)
        {
            output += normalized[j];
            j += (input[i] == normalized[j]) ? 1 : 2;
            i++;
        }
        return output;
    }
</script>
<style>
    .block_field{
        display: none;
    }
</style>

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
        var $task_ = $('#task_').val();
        if ($('#type_member').length > 0) {

            var ddl = document.getElementById("type_member");
            var selectedValue = ddl.options[ddl.selectedIndex].value;
            if (selectedValue == "0")
            {
//                    document.getElementById('msg_error').innerHTML = "Chưa chọn loại thành viên";
                alert('Chưa chọn loại thành viên');
//                    $('#msg_error').parent().show();
                $('#type_member').focus();
                alert('Chưa chọn loại thành viên');
                return false;
            }


            if (selectedValue == '3') {
                var head_id = document.getElementById("headid");
                var selected_headid = head_id.options[head_id.selectedIndex].value;
                if (selected_headid == "0")
                {
//                        document.getElementById('msg_error').innerHTML = "Bạn chưa chọn head!";
                    alert('Bạn chưa chọn head');
//                        $('#msg_error').parent().show();
                    $('#id_head').focus();
                    alert('Bạn chưa chọn head!');
                    return false;
                }
            }
        }
        //nhập user
//            if (!notEmpty('username', 'Bạn chưa nhập tên đăng nhập'))
//                return false;
        if (($('#username').val()).length == '') {
//                    document.getElementById('msg_error').innerHTML = "Bạn chưa nhập tên đăng nhập";
            alert('Bạn chưa nhập tên đăng nhập');
            $('#username').focus();
            return false;
        }

        //không quá 255 kí tự

//            if (!lengthMax("username", 255, 'Tên Đăng Nhập không được quá 255 ký tự!')) {
//                return false;
//            }
        if (($('#username').val()).length > 255) {
            alert('Tên Đăng Nhập không được quá 255 ký tự');
            return false;
        }
        //không chứa ký tự đặc biệt
        if (isChart_db("username", 'Tên Đăng Nhập không chứa kí tự đặc biệt!')) {
            return false;
        }
        if ($('#type_member').val() == 1 || $('#type_user').val() == 1) {
            if ($('#department').val() == 0) {
                alert('Bạn chưa chọn phòng ban');
                $('#department').focus();
                return false;
            }
        }
        if ($('#type_member').val() == 3 || $('#type_user').val() == 3) {

//                if ($('#code').val() == 0) {
//                    document.getElementById('msg_error').innerHTML = "Vui lòng nhập DSC code!";
//                    $('#msg_error').parent().show();
//                    $('#code').focus();
//                    return false;
//                }
            //check kí tư đặc biệt code
            re = /[~`!#$%\^&*+=[\]\\';,/{}|\\":<>\?]/;
            if (re.test($("#code").val())) {
//                    document.getElementById('msg_error').innerHTML = "DSC Code không chứa ký tự đặc biệt.";
                alert('DSC Code không chứa ký tự đặc biệt.');
//                    $('#msg_error').parent().show();
                $('#code').focus();
                return false;
            }
            if ($('#cmt').val() == 0) {
//                    document.getElementById('msg_error').innerHTML = "Vui lòng nhập sô CMT.";
                alert('Vui lòng nhập sô CMT');
//                    $('#msg_error').parent().show();
                $('#cmt').focus();
                return false;
            }
            re = /^[0-9 .]+$/;
            if (!re.test($("#cmt").val())) {
//                    document.getElementById('msg_error').innerHTML = "Số CMT không đúng định dạng.";
                alert('Số CMT không đúng định dạng.');
//                    $('#msg_error').parent().show();
                $('#cmt').focus();
                return false;
            }
            //Lớn hơn 9 kí tự
            if (($('#cmt').val()).length < 9) {
//                    document.getElementById('msg_error').innerHTML = "Số CMT lớn hơn 9 ký tự.";
                alert('Số CMT lớn hơn 9 ký tự.');
//                    $('#msg_error').parent().show();
                $('#cmt').focus();
                return false;
            }
            //không quá 12 kí tự
            if (($('#cmt').val()).length > 255) {
//                    document.getElementById('msg_error').innerHTML = "Sô CMT không được quá 12 ký tự";
                alert('Sô CMT không được quá 12 ký tự');
//                    $('#msg_error').parent().show();
                $('#cmt').focus();
                return false;
            }

            //nhập email
            if (($('#email').val()).length == '') {
//                    document.getElementById('msg_error').innerHTML = "Vui lòng nhập Email!";
                alert('Vui lòng nhập Email!');
//                    $('#msg_error').parent().show();
                $('#email').focus();
                alert('Vui lòng nhập Email!');
                return false;
            }

            //check email
            if (!isEmail('email', 'Email không đúng định dạng!'))
                return false;
            //nhập họ tên
            if (($('#name').val()).length == '') {
//                    document.getElementById('msg_error').innerHTML = "Vui lòng nhập Họ và Tên";
                alert('Vui lòng nhập Họ và Tên');
//                    $('#msg_error').parent().show();
                $('#name').focus();
                return false;
            }
            if (!lengthMaxword('name', 10, 'Mỗi từ tối đa có 10 ký tự'))
                return false;
            if ($('#position').val() == '') {
//                    document.getElementById('msg_error').innerHTML = "Bạn chưa chọn chức vụ";
                alert('Bạn chưa chọn chức vụ');
//                    $('#msg_error').parent().show();
                $('#position').focus();
                return false;
            }
            if ($('#word_start').val() == '') {
//                    document.getElementById('msg_error').innerHTML = "'Bạn chưa nhập thời gian làm việc";
                alert('Bạn chưa nhập thời gian làm việc');
//                    $('#msg_error').parent().show();
                $('#word_start').focus();
                return false;
            }


        }

        //nhập email
        if (($('#email').val()).length == '') {
//                document.getElementById('msg_error').innerHTML = "Vui lòng nhập Email";
            alert('Vui lòng nhập Email');
//                $('#msg_error').parent().show();
            $('#email').focus();
            alert('Vui lòng nhập Email!');
            return false;
        }
//            if (!notEmpty('email', 'Vui lòng nhập Email!'))
//                return false;

        //check email
        if (!isEmail('email', 'Email không đúng định dạng!'))
            return false;
        //nhập họ tên
        if (($('#name').val()).length == '') {
//                document.getElementById('msg_error').innerHTML = "Vui lòng nhập Họ và Tên";
            alert('Vui lòng nhập Họ và Tên');
//                $('#msg_error').parent().show();
            $('#name').focus();
            alert('Vui lòng nhập Họ và Tên');
            return false;
        }
        if (!lengthMaxword('name', 10, 'Mỗi từ tối đa có 10 ký tự'))
            return false;
//            if (!notEmpty('name', 'Vui lòng nhập Họ và Tên!'))
//                return false;

        if ($('#type_member').val() == 2 || $('#type_user').val() == 2) {
            if ($('#city').val().length == '') {
                alert('Bạn chưa chọn tỉnh, thành phố');
                $('#city').focus();
                return false;
            }
//                if (!notEmpty('city', 'Bạn chưa chọn tỉnh, thành phố!'))
//                    return false;
        }

        if ($('#type_member').val() != 2) {
            //nhập thời gian làm việc
            if ($('#workstart').val().length == '') {
//                document.getElementById('msg_error').innerHTML = "Bạn vui lòng nhập Thời Gian Bắt Đầu Làm Việc";
                alert('Bạn vui lòng nhập Thời Gian Bắt Đầu Làm Việc');
//                $('#msg_error').parent().show();
                $('#word_start').focus();
                return false;
            }
            if ($('#workstart').val().length == '') {
                document.getElementById('msg_error').innerHTML = "Bạn vui lòng nhập Thời Gian Bắt Đầu Làm Việc";
                $('#msg_error').parent().show();
                $('#word_start').focus();
                alert('Bạn vui lòng nhập Thời Gian Bắt Đầu Làm Việc');
                return false;
            }
//                if (!notEmpty('word_start', 'Bạn vui lòng nhập Thời Gian Bắt Đầu Làm Việc!'))
//                    return false;

            var txtVal = $('#workstart').val();
            if (isDate(txtVal) == 'false') {
                alert('Bạn nhập sai đinh dạng thời gian dd/mm/yyyy');
                $('#msg_error').parent().show();
                $('#workstart').focus();
                alert('Bạn nhập sai đinh dạng thời gian dd/mm/yyyy')
                return false;
            }
        }

        if ($("input[name='edit_pass']:checked").val() == 1) {
        if ($('#password1').val() == '') {
        document.getElementById('msg_error').innerHTML = "Bạn vui lòng nhập mật khẩu";
                $('#msg_error').parent().show();
                $('#password1').focus();
                alert('Bạn vui lòng nhập mật khẩu');
                return false;
        }

        if ($('#password1').length > 0) {
        if ($('#password1').val() == '') {
//                document.getElementById('msg_error').innerHTML = "Bạn vui lòng nhập mật khẩu";
        alert('Bạn vui lòng nhập mật khẩu');
//                $('#msg_error').parent().show();
                $('#password1').focus();
                return false;
        }
        if ($("#password1").val().length < 8) {
        document.getElementById('msg_error').innerHTML = "Mật khẩu mới phải > 8 ký tự";
                $('#msg_error').parent().show();
                $('#password1').focus();
                alert('Mật khẩu mới phải > 8 ký tự')
                return false;
        }
        re = /[0-9]/;
                if (!re.test($("#password1").val())) {
        document.getElementById('msg_error').innerHTML = "Mật khẩu phải chứa ít nhất một chữ số (0-9)!";
                $('#msg_error').parent().show();
                $('#password').focus();
                alert('Mật khẩu phải chứa ít nhất một chữ số (0-9)!');
                return false;
        }

        if ($("#password1").val().length < 8) {
//                    document.getElementById('msg_error').innerHTML = "Mật khẩu mới phải > 8 ký tự";
        alert('Mật khẩu mới phải > 8 ký tự');
//                    $('#msg_error').parent().show();
                $('#password1').focus();
                return false;
                re = /[A-Z]/;
                if (!re.test($("#password1").val())) {
        document.getElementById('msg_error').innerHTML = "Mật khẩu phải chứa ít nhất một chữ cái In Hoa (A-Z)";
                $('#msg_error').parent().show();
                $('#password').focus();
                alert('Mật khẩu phải chứa ít nhất một chữ cái In Hoa (A-Z)');
                return false;
        }
        }

        re = /[0-9]/;
                if (!re.test($("#password1").val())) {
//                    document.getElementById('msg_error').innerHTML = "Mật khẩu phải chứa ít nhất một chữ số (0-9)!";
        alert('Mật khẩu phải chứa ít nhất một chữ số (0-9)!');
//                    $('#msg_error').parent().show();
                if ($('#re-password').val() == '') {
        document.getElementById('msg_error').innerHTML = "Bạn vui lòng nhập xác nhận mật khẩu";
                $('#msg_error').parent().show();
                $('#re-password').focus();
                alert('Bạn vui lòng nhập xác nhận mật khẩu');
                return false;
        }

        re = /[A-Z]/;
                if (!re.test($("#password1").val())) {
//                    document.getElementById('msg_error').innerHTML = "Mật khẩu phải chứa ít nhất một chữ cái In Hoa (A-Z)";
        alert('Mật khẩu phải chứa ít nhất một chữ cái In Hoa (A-Z)');
//                    $('#msg_error').parent().show();
                if ($('#password1').val() != $('#re-password').val()) {
        document.getElementById('msg_error').innerHTML = "Mật khẩu không trùng nhau, vui lòng nhập lại!";
                $('#msg_error').parent().show();
                $('#re-password').focus();
                alert('Mật khẩu không trùng nhau, vui lòng nhập lại!');
                return false;
        }
        }

        if ($('#re-password').val() == '') {
//                document.getElementById('msg_error').innerHTML = "Bạn vui lòng nhập xác nhận mật khẩu";
        alert('Bạn vui lòng nhập xác nhận mật khẩu');
//                $('#msg_error').parent().show();
                $('#re-password').focus();
                return false;
        }
        if ($('#password1').val() != $('#re-password').val()) {
//                document.getElementById('msg_error').innerHTML = "Mật khẩu không trùng nhau, vui lòng nhập lại!";
        alert('Mật khẩu không trùng nhau, vui lòng nhập lại!');
//                $('#msg_error').parent().show();
                $('#re-password').focus();
                return false;
        }

        }
        === === =
                >>> >>> > .r28145
                return true;
    }


    /*************** CHECK FORM ***************/
//If the length of the element's string is 0 then display helper message
    function notEmpty(elemid, helperMsg) {
        elem = document.getElementById(elemid);
        if (elem.value.length == 0) {
            document.getElementById('msg_error').innerHTML = helperMsg;
            $('#msg_error').parent().show();
//		alert(helperMsg);
            elem.focus(); // set the focus to this input
            return false;
        }
        return true;
    }

    function isDate(txtDate)
    {

        var currVal = txtDate;
        if (currVal == '')
            return false;
        //DeclareRegex  
        var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
        var dtArray = currVal.match(rxDatePattern); // is format OK?
        if (dtArray == null)
            return false;
        //Checks for mm/dd/yyyy format.

        dtMonth = dtArray[1];
        dtDay = dtArray[3];
        dtYear = dtArray[5];
        if (dtMonth < 1 || dtMonth > 12)
            return false;
        else if (dtDay < 1 || dtDay > 31)
            return false;
        else if ((dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31)
            return false;
        else if (dtMonth == 2)
        {
            var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
            if (dtDay > 29 || (dtDay == 29 && !isleap))
                return false;
        }
        return true;
    }

</script>