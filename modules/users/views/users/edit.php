<?php
     //print_r($_REQUEST);
    global $tmpl;
    $tmpl->setTitle("Thành viên");
    $tmpl -> addStylesheet("users","modules/users/assets/css");
    $tmpl -> addScript('form');
    $tmpl -> addScript('users','modules/users/assets/js');
    $Itemid = FSInput::get('Itemid',1);
?>
<div class="users row">
	<div class="col-lg-2"> 
		<?php include 'blocks/mainmenu/views/mainmenu/menu_user.php';?>
	</div>
	<div  class="col-lg-10">
		<div class="cat_title clearfix mt10">
			<div class="inner">
				<span>Cập nhập thông tin cá nhân</span>
			</div>
			<div class="arrow-right"></div>
		</div>
		<form id="form-user-edit" action="<?php echo FSRoute::_("index.php?module=users&task=edit_save&Itemid=40"); ?>" method="post" name="form-user-edit" enctype="multipart/form-data">
			<table width="100%" border="0" cellpadding="6">
				<tr>
			    	<td align="right" width="20%"><b>Họ tên:</b>&nbsp;&nbsp;</td>
			    	<td>
			    		<div class="select-box pull-left">
				    		<select name="sex">
				    			<option>Giới tính</option>
				    			<option value="1" <?php echo ($data->sex == 1)?'selected':''?>>Anh</option>
				    			<option value="0" <?php echo ($data->sex == 0 && $data->sex !='')?'selected':''?>>Chị</option>
				    		</select>
			    		</div>
			    		<input class="txt-input input-full-name" type="text" name="full_name" id="full_name" value="<?php echo $data->full_name;?>" />
			    		<div class="clearfix"></div>
			    	</td>
				</tr>
				<tr>
			    	<td align="right"><b>Email:</b>&nbsp;<font color="red">*</font></td>
				    <td>
				    	<input class="txt-input" type="text" name="email" id="email" value="<?php echo $data->email;?>" />
				    </td>
				</tr>
				<tr>
			    	<td align="right"><b>Ngày sinh:</b>&nbsp;&nbsp;</td>
			    	<td id="td-wapper-birthday">
			    		<div class="select-box pull-left">
				    		<select name="birth_day" >
				    			<option>Ngày</option>
				    			<?php for($i = 1;$i<=31;$i++){?>
				    				<option value="<?php echo $i?>" <?php echo (date("d",strtotime($data->birthday))==$i)?'selected':'';?>><?php echo $i?></option>
				    			<?php }?>
				    		</select>
			    		</div>
			    		<div class="select-box pull-left">
				    		<select  name="birth_month">
				    			<option>Tháng</option>
				    			<?php for($j = 1;$j<=12;$j++){?>
				    				<option value="<?php echo $j?>" <?php echo (date("m",strtotime($data->birthday))==$j)?'selected':'';?>><?php echo $j?></option>
				    			<?php }?>
				    		</select>
				    	</div>
				    	<div class="select-box pull-left">	
				    		<select name="birth_year">
				    			<option>Năm</option>
				    			<?php for($k = (date("Y")-13);$k>(date("Y")-70);$k--){?>
				    				<option value="<?php echo $k?>" <?php echo (date("Y",strtotime($data->birthday))==$k)?'selected':'';?>><?php echo $k?></option>
				    			<?php }?>
				    		</select>
			    		</div>
			    		<div class="clearfix"></div>
			    	</td>
				</tr>
				<tr>
					<td align="right"><b>Địa chỉ</b>&nbsp;&nbsp;</td>
					<td>
						<input class="txt-input"  type="text" name="address" id="address" value="<?php echo $data->address;?>"/>
					</td>
				</tr>
				<tr class=''>
					<td align="right"><b>Điện thoại</b>&nbsp;&nbsp;</td>
					<td>
						<input class="txt-input"  type="text" name="telephone" id="telephone" value="<?php echo $data->telephone;?>"/>
					</td>
				</tr>
				<tr class=''>
					<td align="right"><b>Di động</b>&nbsp;&nbsp;</td>
					<td>
						<input class="txt-input"  type="text" name="mobilephone" id="mobilephone" value="<?php echo $data->mobilephone;?>"/>
					</td>
				</tr>
<!--					<tr>-->
<!--						<td align="right"><b>Ảnh đại điện</b>&nbsp;&nbsp;</td>-->
<!--						<td>-->
<!--							<input id="image" type="file" name="avatar">-->
<!--						</td>-->
<!--					</tr>-->
				 	<tr>
				 		<td>&nbsp;</td>
				    	<td>
				   	 		<input type="checkbox" name="edit_pass" id="edit_pass"/> 
				   	 		<b><font color="#0066AB">Thay đổi mật khẩu</font></b>
				   		</td>
					</tr>
					<tr class='password_area'>
						<td align="right"><b>Nhập mật hiện tại</b>&nbsp;&nbsp;</td>
						<td>
							<input class="txt-input"  type="password" name="old_password" id="old_password" value=""/>
						</td>
					</tr>
					<tr class='password_area'>
						<td align="right"><b>Mật khẩu mới</b>&nbsp;&nbsp;</td>
						<td>
							<input class="txt-input" type="password" name="password" id="password"  value=""/>
						</td>
					</tr>
					<tr class='password_area'>
						<td align="right"><b>Xác nhận mật khẩu mới</b>&nbsp;&nbsp;</td>
						<td><input class="txt-input" type="password" name="re-password" id="re-password" value="" /></td>
					</tr>
				  	<tr>
				 		<td>&nbsp;</td>
				  		<td class="button-submit-tr">
				    		<input class="button-submit-edit button" name="submit" type="submit" value="Lưu thông tin"  />
				       		<input class="button-reset-edit button" name="reset" type="reset" value="Nhập lại"   />
				    	</td>
				  	</tr>
			</table>
		</form>
	</div>
</div>