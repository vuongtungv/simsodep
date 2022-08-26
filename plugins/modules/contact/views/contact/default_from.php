<div class="contact_form">
       
		<form method="post" action="#" name="contact" class="form" enctype="multipart/form-data">
			<div class="contact_table" width="100%">
                    
                   
					<div class="contact_table_cont">
						<input type="text" maxlength="255"   name="contact_name" id="contact_name" value="" class="form_control" placeholder="<?php echo FSText::_("Họ và tên"); ?>" />
					</div>
                    
                    <div class="contact_table_cont">
						<input type="text" maxlength="255"   name="contact_email" id="contact_email" value="" class="form_control" placeholder="<?php echo FSText::_("Địa chỉ Email"); ?>" />
					</div>
                    
                    <div class="contact_table_cont">
                        <input type="text" maxlength="255"  name="contact_phone" id="contact_phone" value="" class="form_control" placeholder="<?php echo FSText::_("Số điện thoại"); ?>" />
					</div>
                    
                     <div class="contact_table_cont">	
						<input type="text" maxlength="255"   name="contact_title" id="contact_title"  value="" class="form_control" placeholder="<?php echo FSText::_("Tiêu đề thông điệp"); ?>" />
					</div>
                    
					<div class="contact_table_cont">
							<textarea rows="6" cols="30" name='message' id='message' placeholder="<?php echo FSText::_("Nội dung thông điệp"); ?>"  ></textarea>
					</div>
					
                    <div class="contact_table_cont mbc">
        				<input type="checkbox" name="email_copy" id="contact_email_copy" value="1" >
        				<label for="contact_email_copy" id="contact_email_copymsg">
        					gửi một bản copy thông điệp này đến hộp email của bạn</label>
        			</div>
                    
					<div class="contact_table_cont row">
						<div class="col-md-4 col-sm-12 col-xs-12">
			                <input class="form_control" placeholder="<?php echo FSText::_("Mã xác nhận"); ?>"  type="text" id="txtCaptcha" value="" name="txtCaptcha" size="5"/>
						
					   </div>
                       <div class="col-md-8 col-sm-12 col-xs-12">
                            <a href="javascript:changeCaptcha();" title="Click here to change the captcha" class="code-view">
                				<img id="imgCaptcha" class="fl-left" src="<?php echo URL_ROOT?>libraries/jquery/ajax_captcha/create_image.php" />
                                <p class="view-change">&nbsp;</p>
                			</a>
                            
							<a class="button fl-right" href="javascript: void(0)" id='submitbt'>
								<span><?php echo FSText::_("Gửi liên hệ"); ?></span>
							</a>
					   </div>
				</div>
			</div>
			
			<input type="hidden" name="module" value="contact">
			<input type="hidden" name="task" value="save">
			<input type="hidden" name="view" value="contact">
			<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>">
		</form>
		<!--	end FORM				-->
		<div class="clear"></div>
	</div>