<?php
global $tmpl, $user;
$tmpl->addStylesheet("users_info", "modules/users/assets/css");
$tmpl->addStylesheet('jquery-ui', 'libraries/jquery/jquery.ui');
$tmpl->addScript('form1');
$tmpl->addScript('default', 'modules/users/assets/js');
$tmpl->addScript('jquery-ui', 'libraries/jquery/jquery.ui');
$Itemid = FSInput::get('Itemid', 1);

$task = FSInput::get('task');
?>
<style>
    #workstart{
        background: url(/images/date.png) no-repeat 98%;
    }
</style>

<div class="contai_info">
    <p class="title_info "> <span><i class="fa fa-user-plus"></i> Cập nhật tài khoản user</span></p>
    <div class="form_created_user">
        <form class="form-horizontal" method="post" action="#" name="update_form_user">
            <div class="form-group">
                <label for="" class="control-label col-xs-3"></label>
                <div class="col-xs-9">
                    <span class="start">* (Trường bắt buộc)</span> 
                </div>
            </div>
            <div class="form-group">
                <label for="username" class="control-label col-xs-3">Tên đăng nhập <span class="start">*</span> </label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" readonly="true" value="<?php echo $info_user->username ?>">
                    <span class="check_validate" id="check_validate"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="control-label col-xs-3">Mật khẩu <span class="start">*</span> </label>
                <div class="col-xs-9">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo $info_user->password ?>">
                    <input type="hidden" class="form-control" id="password_hidden" name="password_hidden" placeholder="Password" value="<?php echo $info_user->password ?>">
                    <span class="valid_" style="color:#ff0000;display:block;padding-top: 10px;" id="valid_pass"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="control-label col-xs-3">Xác nhận lại mật khẩu <span class="start">*</span> </label>
                <div class="col-xs-9">
                    <input type="password" class="form-control" id="re-password" name="re-password" placeholder="Password" value="<?php echo $info_user->password ?>">
                    <input type="hidden" class="form-control" id="password_hidden" name="password_hidden" placeholder="Password" value="<?php echo $info_user->password ?>">
                    <span class="valid_" style="color:#ff0000;display:block;padding-top: 10px;" id="valid_pass"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="control-label col-xs-3">Tên học viên <span class="start">*</span> </label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Tên đầy đủ"value="<?php echo $info_user->name ?>" readonly="true" >
                </div>
            </div>
                <div class="form-group">
                <label for="sex" class="control-label col-xs-3">Giới tính <span class="start">*</span> </label>
                <div class="col-xs-9">
                    <select class="form-control" name="sex">
                        
                        <option value="1" <?php if($info_user->sex==1)echo 'selected' ?>>Nam</option>
                        <option value="2" <?php if($info_user->sex==2)echo 'selected' ?>>Nữ</option>
                    </select>
                </div>
            </div>
            <!--div class="form-group">
                <label for="dcs_code" class="control-label col-xs-3">DCS Code</label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" id="dcs_code" name="dcs_code" placeholder="abc123" value="<?php echo $info_user->code_dcs ?>">
                    <span class="valid_" style="color:#ff0000;display:block;padding-top: 10px;" id="valid_code"></span>
                    <input type="hidden" class="form-control" id="check_trung_dsc" placeholder="" value="0">
                </div>
            </div -->
            <div class="form-group">
                <label for="cmt" class="control-label col-xs-3">Số CMT <span class="start">*</span> </label>
                <div class="col-xs-9">
                    <input type="text" maxlength="12" class="form-control" id="cmt" name="cmt" placeholder="1518787654" value="<?php echo $info_user->cmt ?>">
                    <span class="valid_" style="color:#ff0000;display:block;padding-top: 10px;" id="valid_cmt"></span>
                    <input type="hidden" class="form-control" id="check_trung_cmt" placeholder="" value="0">
                </div>
            </div>
            <div class="form-group">
                <label for="telephone" class="control-label col-xs-3">Điện thoại <span class="start">*</span> </label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Vd: 0987654321" value="<?php echo $info_user->telephone ?>">
                    <span class="valid_" style="color:#ff0000;display:block;padding-top: 10px;" id="valid_phone"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="control-label col-xs-3">Email <span class="start">*</span> </label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" id="email" name="email" placeholder="thanhvien@dailyhonda.vn" value="<?php echo $info_user->email ?>">
                    <input type="hidden" class="form-control" id="email_old" placeholder="thanhvien@dailyhonda.vn" value="<?php echo $info_user->email ?>">
                    <input type="hidden" class="form-control" id="check_trung" placeholder="" value="0">
                </div>
            </div>
            <!--
             <div class="form-group">
                <label for="telephone" class="control-label col-xs-3">Thời gian bắt đầu làm việc <span class="start">*</span> </label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" name='workstart' id='workstart' value ="<?php echo date('m-Y',  strtotime($info_user->workstart)); ?>"/>
                    <!--<img src="<?php echo URL_ROOT . 'images/date.png' ?>" alt="">
                </div>
            </div>
            -->
            <div class="form-group">
                <label for="position" class="control-label col-xs-3">Chức vụ<span class="start">*</span></label>
                <div class="col-xs-9">
                    <select class="form-control"  id="position" name="position">
                        <option value="">-- <?php echo FSText::_('Chọn chức vụ') ?> --</option>
                        <?php foreach ($get_posotion as $item) { ?>
                            <option value="<?php echo $item->id ?>"  <?php if ($info_user->position == $item->id) echo 'selected'; ?> ><?php echo $item->name ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="position" class="control-label col-xs-3">Hoạt động<span class="start"></span></label>
                <div class="col-xs-9">
                    <select class="form-control" name="published">
                        <option value="0" <?php if ($info_user->published == 0) echo 'selected' ?>>Đã nghỉ việc</option>
                        <option value="1" <?php if ($info_user->published == 1) echo 'selected' ?>>Đang hoạt động</option>
                    </select>
                </div>
            </div>
            <!--                    <div class="form-group">
                                    <label for="address" class="control-label col-xs-3">Địa chỉ<span class="start">*</span></label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" id="address" name="address" placeholder="VD: Honda oto Mỹ Đình">
                                    </div>
                                </div>-->

            <div class="form-group">
                <label for="username" class="control-label col-xs-3"></label>
                <div class="col-xs-9">
                    <a class="btn_register" href="javascript: void(0)" id='submitbt_user_update'>Cập nhật</a>
                    <input type="hidden" name = "module" value = "users" />
                    <input type="hidden" name = "view" value = "users" />
                    <input type="hidden" name = "task" value = "update_user" />
                    <input type="hidden" name = "id_user" id="id_user" value = "<?php echo $info_user->id ?>" />
                </div>
            </div>
        </form>
    </div>
</div>  
