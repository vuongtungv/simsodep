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
<div class="contai_info">
    <p class="title_info "> <span><i class="fa fa-user-plus"></i> Tạo mới tài khoản</span></p>
    <div class="form_created_user">
        <?php if($user->userInfo->type==2){?>
            <form class="form-horizontal" method="post" action="#" name="register_form_user">
            <div class="form-group">
                <label for="" class="control-label col-xs-3"></label>
                <div class="col-xs-9">
                    <span class="start">* (Trường bắt buộc)</span> 
                </div>
            </div>
            <div class="form-group">
                <label for="username" class="control-label col-xs-4 col-md-3">Tên đăng nhập <span class="start">*</span> </label>
                <div class="col-xs-4 col-md-9">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" readonly="true" value="<?php echo $user->userInfo->username . '_0' . ($get_max_stt[0]->num_max + 1) ?>">
                    <input type="hidden" id="num_max" name="num_max" value="<?php echo $get_max_stt[0]->num_max + 1 ?>">
                    <span class="check_validate" id="check_validate"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="control-label col-xs-3">Mật khẩu <span class="start">*</span> </label>
                <div class="col-xs-9">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <span class="valid_" style="color:#ff0000;display:block;padding-top: 10px;" id="valid_pass"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="control-label col-xs-3">Tên học viên <span class="start">*</span> </label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Tên đầy đủ" max="10">
                    <span class="valid_" style="color:#ff0000;display:block;padding-top: 10px;" id="valid_name"></span>
                </div>
            </div>
            <!--                    <div class="form-group">
                                    <label for="birthday" class="control-label col-xs-3">Ngày sinh <span class="start">*</span> </label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" id="birthday" name="birthday" placeholder="dd/mm/yyyy">
            
                                    </div>
                                </div>-->
            <div class="form-group">
                <label for="sex" class="control-label col-xs-3">Giới tính <span class="start">*</span> </label>
                <div class="col-xs-9">
                    <select class="form-control" name="sex">
                        <option value="1">Nam</option>
                        <option value="2">Nữ</option>
                    </select>
                </div>
            </div>
            <!--div class="form-group">
                <label for="dcs_code" class="control-label col-xs-3">DCS Code</label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" id="dcs_code" name="dcs_code" placeholder="abc123">
                     <span class="valid_" style="color:#ff0000;display:block;padding-top: 10px;" id="valid_code"></span>
                </div>
            </div-->
            <div class="form-group">
                <label for="cmt" class="control-label col-xs-3">Số CMT <span class="start">*</span> </label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" id="cmt" name="cmt" placeholder="1518787654">
                     <span class="valid_" style="color:#ff0000;display:block;padding-top: 10px;" id="valid_cmt"></span>
                </div>
            </div>


            <div class="form-group">
                <label for="email" class="control-label col-xs-3">Email <span class="start">*</span> </label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" id="email" name="email" placeholder="thanhvien@dailyhonda.vn">
                </div>
            </div>
            <div class="form-group">
                <label for="telephone" class="control-label col-xs-3">Điện thoại <span class="start">*</span> </label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Vd: 0987654321">
                </div>
            </div>

            <div class="form-group">
                <label for="position" class="control-label col-xs-3">Chức vụ<span class="start">*</span></label>
                <div class="col-xs-9">
                    <select class="form-control" name="position" id="position">
                           <option value="">---Chọn chức vụ----</option>
                        <?php foreach ($get_posotion as $item) { ?>
                            <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                        <?php } ?>
                    </select>
                       <span class="valid_" style="color:#ff0000;display:block;padding-top: 10px;" id="valid_position"></span>
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

                    <a class="btn_register" href="javascript: void(0)" id='submitbt_user'>Thêm mới</a>
                    <input type="hidden" name = "module" value = "users" />
                    <input type="hidden" name = "view" value = "users" />
                    <input type="hidden" name = "task" value = "register_save" />

                </div>
            </div>
        </form>
        <?php }else{ ?>
        <p>Bạn không có quyền thực hện chức năng này</p>
        <?php } ?>
        
    </div>
</div>  
