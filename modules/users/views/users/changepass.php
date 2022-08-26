<?php
global $tmpl;
$tmpl->addStylesheet("users_info", "modules/users/assets/css");
$tmpl->addScript('form1');
$tmpl->addScript('users_changepass', 'modules/users/assets/js');
?>
        <div class="contai_info">
            <p class="title_info "> <span><i class="fa fa-user-o"></i> Đổi mật khẩu</span></p>

            <form action="<?php echo FSRoute::_("index.php?module=users&task=edit_save_changepass"); ?>" onsubmit="javascript:return checkFormsubmit();" name="frm_repassword_gh" method="post" id="frm_repassword_gh"  class="form-horizontal">
                <div class="form-group">
                    <label for="text_pass_old" class="control-label col-xs-4 col-md-3">Mật khẩu cũ (<font color="red">*</font>) </label>
                    <div class="col-xs-8 col-md-4">
                        <input class="form-control infor_input" type="password" name="text_pass_old" id="text_pass_old" value=""/>
                    </div>
                </div>    
                <div class="form-group">
                    <label for="text_pass_new" class="control-label  col-xs-4 col-md-3">Nhập mật khẩu mới (<font color="red">*</font>) </label>
                    <div class="col-xs-8 col-md-4">
                        <input class="form-control infor_input" type="password" name="text_pass_new" id="text_pass_new"  value=""/>
                    </div>
                </div>    
                <div class="form-group">
                    <label for="text_re_pass_new" class="control-label col-xs-4 col-md-3">Xác nhận mật khẩu mới (<font color="red">*</font>) </label>
                    <div class="col-xs-8 col-md-4">
                        <input class="form-control infor_input" type="password" name="text_re_pass_new" id="text_re_pass_new" value="" />
                            <span class="valid_" style="color:#ff0000;display:block;padding-top: 10px;" id="valid_pass"></span>
                    </div>
                </div>    
                <div class="form-group">
                    <label for="text_re_pass_new" class="control-label col-xs-4 col-md-3">Mã xác minh (<font color="red">*</font>) </label>
                    <div class="col-xs-4 col-md-4">
                        <input class="form-control infor_input" type="text" name="txtcaptcha" id="capcha" value="" />
                    </div>
                    <div class="col-xs-4 col-md-4">
                        <img id="imgCaptcha" src="<?php echo URL_ROOT ?>libraries/jquery/ajax_captcha/create_image.php" />
                        <a href="javascript:changeCaptcha();"  title="Click here to change the captcha" class="code-view" >
                            <i class="fa  fa-rotate-right" style="font-size: 30px;padding-left: 15px"></i>
                        </a>
                    </div>

                </div>    
                <div class="form-group">
                    <label for="text_pass_new" class="control-label col-xs-3"></label>
                    <div class="col-xs-4">
                        <input type="submit" value="<?php echo FSText::_("Đổi mật khẩu"); ?>" name="submitbt" id="submitbt"  class='button-submit-edits'/>	
                        <input type="hidden" name = "module" value = "users" />
                        <input type="hidden" name = "task" value = "edit_save_changepass" />
                        <input type="hidden" name = "Itemid" value = "<?php echo FSInput::get('Itemid'); ?>" />
                    </div>
                </div>
            </form>
        </div>
