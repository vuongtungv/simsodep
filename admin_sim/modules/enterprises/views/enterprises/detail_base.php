<table cellspacing="1" class="admintable">
<?php 
	TemplateHelper::dt_edit_text(FSText :: _('Tên doanh nghiệp'),'title',@$data -> title);
	//TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    TemplateHelper::dt_edit_text(FSText :: _('Địa chỉ'),'address',@$data -> address);
    TemplateHelper::dt_edit_text(FSText :: _('Điện thoại'),'telephone',@$data -> telephone);
    TemplateHelper::dt_edit_text(FSText :: _('Fax'),'fax',@$data -> fax);
    TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',@$data -> email);
    TemplateHelper::dt_edit_text(FSText :: _('Website'),'source_website',@$data -> source_website);
    TemplateHelper::dt_edit_text(FSText :: _('Mã số thuế'),'tax_code',@$data -> tax_code);
    TemplateHelper::dt_edit_text(FSText :: _('Người liên hệ/điện thoại'),'contact_person',@$data -> contact_person);
    TemplateHelper::dt_edit_text(FSText :: _('Người đại diện trên giấy phép kinh doanh'),'business_license',@$data -> business_license);
    TemplateHelper::dt_edit_selectbox(FSText::_('Lĩnh vực sản xuất'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 10,0,1);
	TemplateHelper::dt_edit_image(FSText :: _('Logo doanh nghiệp'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image));
    TemplateHelper::dt_edit_file(FSText :: _('Giấy phép kinh doanh/giấy phép hoạt động'),'file_upload',$data->file_upload);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
    TemplateHelper::dt_date_pick ( FSText :: _('Published time' ), 'created_time', @$data->created_time?@$data->created_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20);
    TemplateHelper::dt_date_pick ( FSText :: _('Thời gian bắt đầu hoạt động'), 'start_time', @$data->start_time?@$data->start_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');

    //TemplateHelper::dt_sepa();
//	TemplateHelper::dt_edit_text(FSText :: _('SEO title'),'seo_title',@$data -> seo_title,'',100,1);
//	TemplateHelper::dt_edit_text(FSText :: _('SEO meta keyword'),'seo_keyword',@$data -> seo_keyword,'',100,1);
//	TemplateHelper::dt_edit_text(FSText :: _('SEO meta description'),'seo_description',@$data -> seo_description,'',100,9);
?>
</table>