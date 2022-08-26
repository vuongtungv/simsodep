<?php
global $tmpl, $config;
$tmpl->setTitle("Đăng nhập");
$tmpl->addStylesheet("users_login", "modules/users/assets/css");
$tmpl->addScript("form");
$tmpl->addScript("login", "modules/users/assets/js");
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
    <div class="login_contai rows clearfix">
        <div class="l-left col-md-8">
            <img src="<?php echo $config['img_login'] ?>"/>
        </div>
        <div class="l-form col-md-4">
            <div id="login-form" class ="login-form" >
                <form  name="frm_forget_pass" id="frm_forget_pass" class="login_form fff-form"  action="#" method="post">
                    <p class="col-title_username">Điền Email của bạn</p>
                    <input id="username" class="form-control input_login" type="text" style="width: 100%;" size="30" name="username"  placeholder="Username...." />
                    </br>
                    <a class="link_login" style="width: 140px;margin: 0 auto;margin-top: 10px;background: #cc0000;color: #fff;display: block;padding: 5px;text-align: center;" href="javascript:void(0);" title="Lấy lại mật khẩu">Lấy lại mật khẩu</a>
                    <!-- <p class="copy_right">© 2017. Copyright by Honda Vietnam</p> -->
                                  <input type="hidden" name="module" value="users"/>
                                  <input type="hidden" name="view" value="users"/>
           
                                <input type="hidden" name="task" value="fa_save_pass"/>
                               
                                <!--<input type="hidden" name="redirect" value="<?php echo FSInput::get('redirect', URL_ROOT); ?>" />-->
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




