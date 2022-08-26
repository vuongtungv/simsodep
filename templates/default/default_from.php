<?php 
    global $config,$tmpl;
    $tmpl -> addScript('form');
    $tmpl -> addScript('contact','modules/contact/assets/js');
    $tmpl ->addStylesheet('contact','modules/contact/assets/css'); 
    
    $url = $_SERVER['REQUEST_URI'];
    $return = base64_encode($url);  
?>

<a href="#myModal" role="button" class="open-popup" data-toggle="modal">&nbsp;</a>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<form method="post" action="#" name="contact_popup" id="contact_popup" class="contact_popup row-item" enctype="multipart/form-data">
         
                <p class="info_popup"><?php echo $config['info_popup'];  ?></p>   
        		<input type="text" maxlength="255"   name="contact_name" id="contact_name_p" value="" class="form_control" placeholder="<?php echo FSText::_("Họ và tên*"); ?>" />
        
                <input type="text" maxlength="255"  name="contact_phone" id="contact_phone_p" value="" class="form_control" placeholder="<?php echo FSText::_("Số điện thoại*"); ?>" />
        
        		<input type="text" maxlength="255"   name="contact_email" id="contact_email_p" value="" class="form_control" placeholder="<?php echo FSText::_("Email*"); ?>" />
        
                	
        		<input type="text" maxlength="255"   name="contact_address" id="contact_address_p"  value="" class="form_control" placeholder="<?php echo FSText::_("Địa chỉ"); ?>" />
        
                
        		<textarea rows="6" cols="30" name='message' id='message_p' placeholder="<?php echo FSText::_("Nội dung liên hệ"); ?>"  ></textarea>
            
        		
        		<div class="row-item">
                    <input class="form_control txtCaptcha fl-left" placeholder="<?php echo FSText::_("Nhập mã bảo mật"); ?>"  type="text" id="txtCaptcha_p" value="" name="txtCaptcha_p" size="5"/>
        	        <a href="javascript:changeCaptcha();" title="Click here to change the captcha" class="code-view fl-right">
        				<img id="imgCaptcha" class="fl-left" src="<?php echo URL_ROOT?>libraries/jquery/ajax_captcha/create_image.php" />
        			</a>
                </div>
                <p class="info-refest" style="margin-bottom: 10px;"><?php echo FSText::_('Nếu mã bảo mật nhìn không rõ xin vui lòng click vào hình ảnh mã bảo mật để nhận mã mới.'); ?></p>
                <div class="row-item">
                    <a class="button fl-left submitbt" href="javascript: void(0)" id='submitbt_p'>
        				<?php echo FSText::_("Gửi liên hệ"); ?>
        			</a>
                    <a class="button fl-left reset" href="javascript: void(0)" id='resetbt_p'>
        				<?php echo FSText::_("Nhập lại"); ?>
        			</a>
                    <span class="notification fl-right">(*)Thông tin bắt buộc</span>
                </div>
        		
        		<input type="hidden" name="module" value="contact" />
        		<input type="hidden" name="task" value="save" />
        		<input type="hidden" name="view" value="contact" />
        		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
                <input type="hidden" name='return' value='<?php echo $return; ?>' />
        	</form>
	       <!-- END:  FORM -->
        </div>
    </div>
</div>