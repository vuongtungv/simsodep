<?php
global $tmpl,$config;
$tmpl->setTitle("Đăng nhập");
$tmpl->addStylesheet("users_login", "modules/users/assets/css");
$Itemid = FSInput::get('Itemid', 1);
$redirect = FSInput::get('redirect');
$username = FSInput::get('username');
if (!$username) {
    $username = "Username";
}
$password = "Password";
?>
<div class="head_login rows clearfix">
    <div class="container">
    <div class="head_left col-xs-8 col-md-6">
        <div class="logo_ col-xs-4 col-md-6">
            <img width="260px" src="<?php echo URL_ROOT ?>modules/users/assets/images/login_02.bmp" alt=""/>
        </div>
        <div class="text_lg col-xs-8 col-md-6">
            <?php echo $config['slogan'] ?>
        </div>
    </div>
    <div class="head_right col-xs-4 col-md-6">
        <div class="hotline col-md-6">
            <p class="r_text">Tổng đài hỗ trợ</p>
            <p class="number_hot"><?php echo $config['hotline'] ?></p>
        </div>
        <div class="email_ col-md-6">
            <p class="r_text">Email</p>
            <p><?php echo $config['email'] ?></p>
        </div>
    </div>
</div>
</div>
<div class="container clearfix">
    <div class="container_login container-fluid">
        <div class="login_contai rows">
            <div class="l-left col-md-8">
                <img src="<?php echo $config['img_login'] ?>"/>
            </div>
            <div class="l-form col-md-4">
                <div id="login-form" class ="login-form" >
                    <form action="<?php echo FSRoute::_("index.php?module=users") ?>" name="login_form" class="login_form fff-form"  method="post">
                        <p class="col-title_username">Tài khoản</p>
                        <input id="user_username" class="form-control input_login" type="text" size="30" name="username"  onblur="if (this.value == '')
                        this.value = '<?php echo $username; ?>'" onfocus="if (this.value == '<?php echo $username; ?>')
                        this.value = ''" value="<?php echo $username; ?>" />

                        <p class="col-title_pass">Mật khẩu</p>

                        <input id="user_password"  class="form-control input_login" type="password" size="30"  name="password" onblur="if (this.value == '')
                        this.value = '<?php echo $password; ?>'" onfocus="if (this.value == '<?php echo $password; ?>')
                        this.value = ''" value="<?php echo $password; ?>" />

                        <p style="padding-top: 15px;color: #000">(<span style="color:#cc0000">*</span>) Điền tên đăng nhập và mật khẩu do HVN cung cấp để đăng nhập</p>
                    </br>
                     <a href="<?php echo FSRoute::_("index.php?module=users&task=fget_pass") ?>"  id="forgot_pass" style="font-size: 14px;padding-bottom: 15px;display: block;"><i class="fa fa-lock" style="padding-right: 10px;"></i>Gửi lại mật khẩu</a>
                    <input type="submit" class='submitbt' name="submitbt" value = "<?php echo FSText::_("Đăng nhập"); ?>"   /> 
<!-- <p class="copy_right">© 2017. Copyright by Honda Vietnam</p> -->
                    <input type="hidden" name = "module" value = "users" />
                    <input type="hidden" name = "view" value = "users" />
                    <input type="hidden" name = "task" value = "login_save" />
                    <input type="hidden" name = "Itemid" value = "<?php echo $Itemid; ?>" />
                    <?php
                    if ($redirect)
                        echo "<input type='hidden' name = 'redirect' value = '$redirect' />";
                    ?>
                </form>              
            </div><!--  END: #login-form -->    

        </div>
    </div>
</div>
</div>
<div class="footer_login">
    <div class="container">
        <?php echo $config['info_footer'] ?>
    </div>
</div>




