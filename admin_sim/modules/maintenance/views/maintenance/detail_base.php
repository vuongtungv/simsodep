<?php 
	TemplateHelper::dt_edit_text(FSText :: _('Tên đối tác'),'name',@$data -> name);
	//TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    TemplateHelper::dt_edit_text(FSText :: _('Điện thoại'),'hotline',@$data->hotline);
    TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',@$data->email);
    TemplateHelper::dt_edit_text(FSText :: _('Đại chỉ'),'address',@$data -> address);
    
    TemplateHelper::dt_edit_selectbox(FSText::_('Tỉnh/Thành phố'),'city_id',@$data->city_id,0,$cities,$field_value = 'id', $field_label='name',$size = 1,0);
    TemplateHelper::dt_edit_selectbox(FSText::_('Quận/huyện'),'district_id',@$data->district_id,0,$district,$field_value = 'id', $field_label='name',$size = 1,0);
    //TemplateHelper::dt_edit_image(FSText :: _('Email'),'email',$data->email);
    
    TemplateHelper::dt_edit_text(FSText :: _('Người liên hệ'),'name_contact',@$data -> name_contact);
    
    TemplateHelper::dt_edit_selectbox(FSText::_('Nhóm dự án'),'group_id',@$data->group_id,0,$group,$field_value = 'id', $field_label='name',$size = 1,0);
    
    TemplateHelper::dt_edit_file(FSText :: _('Hồ sơ công trình'),'file_works',@$data->file_works);
    
    TemplateHelper::dt_date_pick ( FSText :: _('Năm xây dựng'), 'date_start', @$data->date_start?@$data->date_start:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20);
    TemplateHelper::dt_date_pick ( FSText :: _('Năm bàn giao' ), 'date_end', @$data->date_end?@$data->date_end:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20);
    TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
    TemplateHelper::dt_sepa();
    
    TemplateHelper::dt_checkbox(FSText::_('Trạng thái chuyển nhượng'),'status',@$data -> status,0,array(1=>'Đã chuyển',0=>'chưa chuyển'));
    TemplateHelper::dt_edit_selectbox(FSText::_('Người quản lý hiện tại'),'user_id',@$data->user_id,0,$members,$field_value = 'id', $field_label='full_name',$size = 1,0);
    TemplateHelper::dt_edit_selectbox(FSText::_('Thành viên chuyển'),'receiver_id',@$data->receiver_id,0,$members,$field_value = 'id', $field_label='full_name',$size = 10,1,0,'','','chosen-select-no-results');
   
    
?>
<script  type="text/javascript" language="javascript">
$(function(){
	$("select#city_id").change(function(){
		$.ajax({url: "index.php?module=maintenance&view=maintenance&task=ajax_get_product_district&raw=1",
			 data: {cid: $(this).val()},
			  dataType: "text",
			  success: function(text) {
			    j = eval("(" + text + ")");
			    var options = '';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
				}
				$("#district_id").html(options);
				$('#district_id option:first').attr('selected', 'selected');
                $("#district_id").trigger("chosen:updated");
			  }
		});
	});				
				
});
</script>