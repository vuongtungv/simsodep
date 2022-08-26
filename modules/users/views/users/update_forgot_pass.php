<?php
global $tmpl, $config;
$tmpl->setTitle("Đăng nhập");
$tmpl->addStylesheet("users_login", "modules/users/assets/css");
$tmpl->addScript('form1');
$tmpl->addScript("login", "modules/users/assets/js");
$Itemid = FSInput::get('Itemid', 1);
$redirect = FSInput::get('redirect');
$username = FSInput::get('username');

if (!$username) {
    $username = "Username";
}
$password = "Password";

$data_id=FSInput::get('data');


?>
<style>
  input{
    margin: 10px 0;
  }
  #valid_pass{
        color: red;
    margin-bottom: 15px;
        line-height: 30px;
    padding-left: 15px;
    background-color: #ffdddd;
    border-left: 6px solid #f44336;
    float: left;
    width: 100%;
    margin-top: 30px;
  }
</style>
<div class="container_login container-fluid">
    <div class="head_login rows clearfix">
        <div class="head_left col-md-6">
            <div class="logo_ col-md-6">
                <img src="<?php echo URL_ROOT ?>modules/users/assets/images/login_01.png" alt=""/>
            </div>
            <div class="text_lg col-md-6" style="color:#fff !important;">
                <?php echo $config['slogan'] ?>
            </div>
        </div>
        <div class="head_right col-md-6">
            <div class="hotline col-md-6">
                <p class="r_text">Tổng đài hỗ trợ</p>
                <p class="number_hot">1800 8001</p>
            </div>
            <div class="email_ col-md-6">
                <p class="r_text">Email</p>
                <p>suport@hondavietnamtraining.edu.vn</p>
            </div>
        </div>
    </div>
    <div class="login_contai rows clearfix">
        <div class="l-left col-md-6">
            <!--<img src="<?php echo URL_ROOT . 'modules/users/assets/images/bg-login_05.jpg' ?>"/>-->
        </div>
        <div class="l-form col-md-6">
            <div id="login-form" class ="login-form" >
                <form  name="frm_up_pass" id="frm_up_pass" class="login_form fff-form"  action="#" method="post">
                    <p class="col-title_username">Cập nhật mật khẩu</p>
                   <input  type="text"  class="form-control col-xs-10" id="activated_code" name="activated_code" value="" placeholder="Mã bảo mật" />

                   <input type="password"  class="form-control col-xs-10" id="password" name="password" value="" placeholder="Mật khẩu mới" />

                   <input type="password"  class="form-control col-xs-10" id="repassword" name="repassword" value="" placeholder="Nhập lại mật khẩu mới" />
                    </br>
                    <div class="clearfix"></div>
                    <a id="update_pass" class="btn_up_pass" style="width: 140px;margin: 0 auto;margin-top: 10px;background: #cc0000;color: #fff;display: block;padding: 5px;text-align: center;" href="javascript:void(0);" title="Lấy lại mật khẩu">Cập nhật mật khẩu</a>
                    <p class="copy_right">© 2017. Copyright by Honda Vietnam</p>
                    <input type="hidden" name="data_id" value="<?php echo $data_id ?>"/>
                    <input type="hidden" name="module" value="users"/>
                    <input type="hidden" name="task" value="do_update_forgot_pass"/>
                    <input type="hidden" name="view" value="users"/>
                        <p id="valid_pass"></p>
                               
                             
                    <?php
                    if ($redirect)
                        echo "<input type='hidden' name = 'redirect' value = '$redirect' />";
                    ?>
                </form>              
            </div><!--  END: #login-form -->    

        </div>
    </div>
</div>




