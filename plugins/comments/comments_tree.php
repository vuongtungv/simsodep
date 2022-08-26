<?php  	
    global $tmpl;
	$tmpl -> addStylesheet('default','plugins/comments/css');
	$tmpl -> addScript('default','plugins/comments/js');
	$url = $_SERVER['REQUEST_URI'];
	$module = FSInput::get ( 'module' );
	$view = FSInput::get ( 'view' );
	$rid = FSInput::get ( 'id' );

	$return = base64_encode($url);

?>
<div id="_info_comment" class="row-item"></div>
<div class='comments'>		
        <div class='comment_form_title row-item' >Gửi bình luận</div>
		<form action="javascript:void(0);" method="post" name="comment_add_form" id='comment_add_form' class='form_comment' class="form_comment" onsubmit="javascript: submit_comment();return false;">
			<textarea id="cmt_content" class="col-xs-12 pal message" name="content" rows="8" placeholder="<?php echo FSText::_('Nội dung'); ?>" ></textarea>
            <div class="row">
                <div class="label  col-xs-12 col-sm-3 ">
                    <label>Tên</label>
            		<input id="cmt_name" class="pas txt_input" type="text" name="name" placeholder="<?php echo FSText::_('Tên của bạn'); ?>" />
            	</div>
                <div class="label col-xs-12 col-sm-3">
                    <label>Email</label>
            		<input id="cmt_email" class="pas txt_input" type="text" name="email" placeholder="<?php echo FSText::_('Email của bạn'); ?>"  />
            	</div>
                <div class="button_area col-xs-12 col-sm-6 ">
                    <label>Mã bảo mật</label> 
            		<input type="text" id="txtCaptcha" value="" name="txtCaptcha" class="pas" placeholder="<?php echo FSText::_('Mã bảo mật'); ?>" />	
            		<a href="javascript:changeCaptcha();" title="Click here to change the captcha" class="code__view">
            			<img id="imgCaptcha" src="<?php echo URL_ROOT?>libraries/jquery/ajax_captcha/create_image.php" />
            		</a>
                    <input class="button fl-right submitbt" type="submit" value="<?php echo FSText::_('Gửi'); ?>" />
            	</div>
        	</div>
             
			<input type="hidden" value="<?php echo $module;?>" name='module' id="_cmt_module" />
			<input type="hidden" value="<?php echo $view;?>" name='view' id="_cmt_view" />
			<input type="hidden" value="save_comment" name='task' />
			<input type="hidden" value="<?php echo $rid;?>" name='record_id' id="_cmt_record_id" />
			<input type="hidden" value="<?php echo $return;?>" name='return'  id="_cmt_return"  />
			<input type="hidden" value="<?php echo '/index.php?module='.$module.'&view='.$view.'&task=save_comment&raw=1'; ?>" name="return" id="link_reply_form" />
		</form>
</div>