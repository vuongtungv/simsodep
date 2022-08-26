<?php 
    $url = $_SERVER['REQUEST_URI'];
    $return = base64_encode($url);
?>
<div class="contact_form row-item">
		<form method="post" action="#" name="contact" class="form" enctype="multipart/form-data">
			<div class="row">
                <div class="col-xs-12">
                	<label><?php echo FSText::_("Tiêu đề"); ?> <span>(*)</span></label>
					<input type="text" maxlength="255" name="contact_title" id="contact_title" value="" class="form_control" />
				</div>
                <div class="col-xs-6">
					<label><?php echo FSText::_("Họ tên đầy đủ"); ?> <span>(*)</span></label>
                    <input type="tel" maxlength="255"  name="contact_name" id="contact_name" value="" class="form_control" />
                </div>
				<div class="col-xs-6">
                	<label><?php echo FSText::_("Nhóm đối tượng khách hàng"); ?> <span>(*)</span></label>
					<select name="contact_group" id="contact_group" class="select-no-group">
						<option value=""><?php echo FSText::_("-- Lựa chọn --"); ?></option>
						<option value="Thí sinh"><?php echo FSText::_("Thí sinh"); ?></option>
						<option value="Nhà Tuyển sinh/Đào tạo"><?php echo FSText::_("Nhà Tuyển sinh/Đào tạo"); ?></option>
					</select>
				</div>
				<div class="col-xs-6">
					<label><?php echo FSText::_("Email"); ?> <span>(*)</span></label>
					<input type="text" maxlength="255"   name="contact_email" id="contact_email" value="" class="form_control" />
				</div>
				<div class="col-xs-6"> 	
					<label><?php echo FSText::_("Địa chỉ"); ?> <span>(*)</span></label>
					<input type="text" maxlength="255"   name="contact_address" id="contact_address"  value="" class="form_control" />
				</div>
				<div class="col-xs-6">
                	<label><?php echo FSText::_("Liên hệ với bộ phận"); ?> <span>(*)</span></label>
					<select name="contact_parts" id="contact_parts" class="select-no-parts">
						<option value=""><?php echo FSText::_("-- Lựa chọn bộ phận --"); ?></option>
						<?php foreach($parts as $item){?>
							<option value="<?php echo $item->email?>"><?php echo $item->name?></option>
						<?php }?>
					</select>
				</div>
				<div class="col-xs-6"> 	
					&nbsp;
				</div>
				<div class="col-xs-12">  
					<label><?php echo FSText::_("Nhập nội dung liên hệ"); ?> <span>(*)</span></label>  
					<textarea rows="6" cols="30" name='message' id='message' ></textarea>
                </div>
				<div class="col-xs-12">	
					<label><?php echo FSText::_("Nhập mã bảo mật"); ?> <span>(*)</span></label>
	                <input class="form_control txtCaptcha fl-left" placeholder="<?php echo FSText::_("Nhập mã bảo mật"); ?>"  type="text" id="txtCaptcha" value="" name="txtCaptcha" size="5"/>
			        <a href="javascript:changeCaptcha();" title="Click here to change the captcha" class="code-view fl-right">
        				<img id="imgCaptcha" class="fl-left" src="<?php echo URL_ROOT?>libraries/jquery/ajax_captcha/create_image.php" />
        			</a>
        			<a href="javascript:changeCaptcha();" title="Click here to change the captcha" class="code-view fl-right orther">
        				<?php echo FSText::_("Xem mã khác"); ?>
        			</a>
        			<a class="button fl-left submitbt" href="javascript: void(0)" id='submitbt'>
						<?php echo FSText::_("Gửi liên hệ"); ?>
					</a>
					<!--
					<a class="button fl-left reset" href="javascript: void(0)" id='resetbt'>
						<?php //echo FSText::_("Nhập lại"); ?>
					</a>-->
                </div>
			</div>
			<input type="hidden" name='return' value='<?php echo $return; ?>' />
			<input type="hidden" name="module" value="contact" />
			<input type="hidden" name="task" value="save" />
			<input type="hidden" name="view" value="contact" />
			<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
		</form>
		<!--	end FORM				-->
		<div class="clear"></div>
</div>