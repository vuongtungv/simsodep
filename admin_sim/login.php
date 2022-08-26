<?php 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
ini_set('session.gc_maxlifetime', 36000);
error_reporting (E_ALL);define('WRITE_LOG_MYSQL',0);

function login(){
    $db = new FS_PDO();
    $password = md5(FSInput::get('password'));
    $username = FSInput::get('username');
        // $username = $db->escape_string($username);
    $query = 'SELECT u.id, u.username, u.email, u.type, u.full_name, u.access
                FROM fs_users AS u
                WHERE published = 1 AND  u.username = \''.$username.'\' AND u.password = \''.$password.'\'
                LIMIT 1';
                
    $user = $db->getObject($query);
    if(!$user){
        return false;
    }
    $_SESSION['ad_logged']     = 1;
    $_SESSION['ad_userid']     = $user->id;
    $_SESSION['ad_type']    = $user->type;
    $_SESSION['ad_full_name']    = $user->full_name;
    $_SESSION['ad_username']   = $user->username;
    $_SESSION['ad_useremail']  = $user->email;
    $_SESSION['ad_access']  = $user->access;
    return true;
}

session_start();
if(isset($_SESSION['ad_logged']) && $_SESSION['ad_logged']==1)
    header("Location: index.php");
    
require_once("../includes/config.php");
require_once('../libraries/database/mysql.php');
require_once('../libraries/database/mysql.php');
include("../libraries/database/pdo.php");
$db = new FS_PDO();
require_once("../libraries/fsinput.php");

require_once ("../includes/functions.php");
$action     = FSInput::get('action');

if($action == "login"){
    if(!login()){
        echo '<script type="text/javascript">alert(\'Thông tin đăng nhập không đúng hoặc tài khoản của bạn chưa được kích hoạt!\')</script>';
    }   
    else{
        header( "Location: index.php" );
    }
}
?>
<!DOCTYPE html>

<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>FinalStyle | Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Kay - FinalStyle" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="assets/pages/css/login-2.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="templates/default/images/favicon.ico"/>
    </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="javascript:void(0)">
                <h3>FinalStyle</h3> 
            </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="login.php" method="post">
                <div class="form-title">
                    <span class="form-title">Welcome.</span>
                    <span class="form-subtitle">Please login.</span>
                </div>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any username and password. </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> </div>
                <div class="form-actions">
                    <button type="submit" class="btn red btn-block uppercase">Login</button>
                    <input name="action" type="hidden" value="login"/>
                </div>
            </form>
            <!-- END LOGIN FORM -->
        </div>
        <div class="copyright hide"> 2014 © FinalStyle. Admin Dashboard Template. </div>
        <!-- END LOGIN -->
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="assets/pages/scripts/login.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
        </script>
    </body>

</html>