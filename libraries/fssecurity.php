<?php
class FSSecurity
{
	function __construct()
	{

	}
    
	function checkLogin()
	{
   
		if(empty($_SESSION['user_id']) && empty($_COOKIE['user_id']))
		{
			$Itemid = 45;
			$url = FSRoute::_("index.php?module=users&task=login&Itemid=5");
			$msg = FSText :: _("Bạn phải đăng nhập để sử dụng tính năng này");
			setRedirect($url,$msg,'error');
		}

	}

	function checkLoginSteps()
	{
		$steps = !empty($_COOKIE['steps'])? $_COOKIE['steps']:$_SESSION['steps'];
		if($steps==2){
            $url = FSRoute::_("index.php?module=members&view=seekers&task=add_info&Itemid=50");
            $msg = FSText::_("Thông tin tài khoản cá nhân của bạn chưa đầy đủ. Đề nghị hoàn thành các thông tin này!");
            setRedirect($url,$msg,'error');
        }
        if($steps==1){
            $url = FSRoute::_('index.php?module=members&view=seekers&task=add_field&Itemid=50');
            $msg = FSText::_("Thông tin tài khoản cá nhân của bạn chưa đầy đủ. Đề nghị hoàn thành các thông tin này!");
            setRedirect($url,$msg,'error');
        }

	}

    function checkLogin_employer(){
        if(empty($_SESSION['el_user_id']) && empty($_COOKIE['el_user_id']))
		{
			$Itemid = 35;
			$url = FSRoute::_("index.php?module=employer&view=login&Itemid=35");
			$msg = FSText :: _("Bạn phải đăng nhập để sử dụng tính năng này");
			setRedirect($url,$msg,'error');
		}
    }

	function checkEsoresLogin(){
		$this -> checkLogin();
		if(!isset($_SESSION['estore_id']))
		{
			echo "<script>alert('You do not have permission');history.go(-1)</script>";
			return false;
		}
		else
			return true;
	}

	// check for estore : saneps
	function checkEsoresLogin1()
	{
		if(!isset($_SESSION['e-email']))
		{
			$Itemid = 9;
			$url = FSRoute::_("index.php?module=estores&task=login&Itemid=$Itemid");
			$msg = FSText :: _("B&#7841;n ph&#7843;i &#273;&#259;ng nh&#7853;p gian h&#224;ng &#273;&#7875; s&#7917; d&#7909;ng t&#237;nh n&#259;ng n&#224;y");
			setRedirect(URL_ROOT,$msg,'error');
		}
		else
			return true;
	}
}
