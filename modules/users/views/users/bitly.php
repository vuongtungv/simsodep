<?php
     //print_r($_REQUEST);
    global $tmpl;
    $tmpl->setTitle("Gửi link giới thiệu bạn bè");
    $tmpl -> addStylesheet("users","modules/users/assets/css");
?>
<div class="users">
	<div class="frame_header clearfix">
		<h1 class="pull-left"><span>Gửi link giới thiệu bạn bè</span></h1>
		<div class="pull-right">
			<?php if($icon_point){?>
				<img alt="Điểm" src="<?php echo URL_ROOT.$icon_point?>">
			<?php } ?>
			<b>Tài khoản của bạn  hiện có <font color="#B80405"><?php echo $point;?></font> điểm</b>
		</div>
	</div>
	<div class="row">
		<div class="menu_users col-lg-2">
			<?php include 'blocks/mainmenu/views/mainmenu/menu_user.php';?>
		</div>
		<div class="users_info col-lg-10">
			<p>Copy link sau và gửi cho bạn bè để tích lũy điểm thưởng:</p>
			<input id="link_bitly" class="txt-input mt10" type="text" value="<?php  echo $bitly_v3_shorten['url'];?>" />
			<p>Với mối lượt click của bạn bè qua link trên bạn sẽ được cộng 5 điểm vào tài khoản, tích lũy điểm để nhận được các phần quà đặc biệt từ topWatch. </p>
			<a  id="history"  href="javascript:window.history.go(-1);"><font color='#134593'>&laquo; Trở lại</font></a>
		</div>
		
	</div>
</div>