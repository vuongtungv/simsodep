<?php  	global $tmpl;
	$tmpl -> addStylesheet('rating','plugins/comments/css');
	$tmpl -> addScript('rating','plugins/comments/js');
	$url = $_SERVER['REQUEST_URI'];
	$module = FSInput::get ( 'module' );
	$view = FSInput::get ( 'view' );
	$rid = FSInput::get ( 'id' );
	$arr_rating = array(
		5=>'Xuất sắc',
		4=>'Rất tốt',
		3=>'Trung bình',
		2=>'Tàm tạm',
		1=>'Kém',
	);
	$return = base64_encode($url);
	if(empty($_SESSION['user_id'])) {
		$login = 0;
	}else{
		$login = 1;
	}
?>
<div class='comments'>

	<div class="comment_header mt10" onclick="check_login(<?php echo $login;?>)">
		Viết đánh giá
	</div>
		<!-- FORM COMMENT	-->
		
		<div class='comment_form  <?php echo $_SESSION['user_id']?'':'hide'?>' id="comment_form">
			<form action="#" method="post" name="comment_add_form" id='comment_add_form' class='form_comment'>
				<table width="100%" cellpadding="5">
					<tr>
						<td class="form_name"><b>Họ tên / Nickname</b></td>
						<td class="form_text">
						<input type="text" id="name"  value="<?php echo $_SESSION['fullname'];?>"  class="txt_input"/>
						
						</td>
					</tr>
					<tr>
						<td class="form_name" valign="top">
							<b>Nhận xét của bạn</b>
							<ul>
								<li><span>Xem sản phẩm, dịch vụ của chúng tôi</span></li>
								<li><span>Viết những gì bạn thích về sản phẩm</span></li>
								<li><span>Viết những gì bạn không thích về nó</span></li>
								<li><span>Mô tả một số tính năng, màu sắc, phong cách ...</span></li>
								<li><span>Cung cấp càng nhiều chi tiết càng tốt để giúp khách hàng khác quyết định</span></li>
								<li><span>Hãy trung thực ý kiến ​​và đánh giá xấu tốt đều ​​có giá trị</span></li>
							</ul>
						</td>
						<td  class="form_text" valign="top"><textarea id="text" class="txt_input" rows="6" name="text"></textarea></td>
					</tr>
					<tr>
						<td class="form_name"><b>Đánh giá</b></td>
						<td class="form_text">
							<div class="select-box ">
								<select name="rating" class="txt_input">
									<?php foreach ($arr_rating  as $key=>$item){?>
										<option value="<?php echo $key;?>"><?php echo $item;?></option>
									<?php }?>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<td class="form_name"><b>Xác nhận</b></td>
						<td  class="form_text">
							<img id="imgCaptcha" src="<?php echo URL_ROOT?>libraries/jquery/ajax_captcha/create_image.php" />
							<a href="javascript:changeCaptcha();"  title="Click here to change the captcha" class="code-view" >&nbsp;</a>
							<input type="text" id="txtCaptcha" value="" class="txt_input" name="txtCaptcha"  />
						</td>
					</tr>
					<tr>
						<td class="form_name"></td>
						<td class="button_area">
							<a class="button submitbt" href="javascript: void(0)" id='submitbt'>
								<span>Đăng đánh giá</span>
							</a>
						</td>
					</tr>
				</table>
				<input type="hidden" value="<?php echo $module;?>" name='module' />
				<input type="hidden" value="<?php echo $view;?>" name='view' />
				<input type="hidden" value="save_comment" name='task' />
				<input type="hidden" value="<?php echo $_SESSION['user_id'];?>" name='user_id' />
				<input type="hidden" value="<?php echo $_SESSION['fullname'];?>"  name="user_name"/>
				<input type="hidden" value="<?php echo $_SESSION['user_email'];?>" name='user_email' />
				<input type="hidden" value="<?php echo $rid;?>" name='record_id' id='record_id'  />
				<input type="hidden" value="<?php echo $return;?>" name='return'  />
			</form>
		</div>
	<?php 
		if($total_comment){
		$return = base64_encode($url);
		?>
			<div class='comments_contents'>
			<?php foreach ($list_parent as $item){ ?>
				<?php echo  display_comment_item($item,$list_children,0,3,$return);?>
			<?php }?>
			</div>
		<?php }?>
</div>
<?php 
function display_comment_item($item,$childdren,$level,$max_level = 2,$return){
	$sub = ($level >= $max_level) ? ($max_level % 2) : ($level % 2);
	$html = '<div class="comment-item comment-item-'.$item -> id.' '. ($item -> parent_id? "comment-child":""). ' comment_level_'.$level.' comment_sub_'.$sub.'"   >';
				
	$html .= '<span class="name">'.$item -> name.'</span> | ';
	$html .= '<span class="date">Đăng ngày:'. date('d/m/Y',strtotime($item -> created_time)).'</span> ';
	$html .= '<div class="rating "> ';
		$html .= '<span>Đánh giá:</span> ';
		for($i = 0; $i < 5;$i ++){
			if($i < $item->rating ){
				$html .= '<img  width="15" height="15" alt="*" src="'.URL_ROOT.'images/star_full.gif">';
			}else{
				$html .= '<img  width="15" height="15" alt="*" src="'.URL_ROOT.'images/star_empty.gif">';
			}
		}
	$html .= '</div>';
	$html .= '<div class="comment_content "> ';
	$html .=  $item -> comment;
	$html .= '</div>';
	$html .= '</div>';
	return $html;
}
?>