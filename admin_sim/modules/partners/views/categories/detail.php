<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
    
	$this -> dt_form_begin(1,4,$title.' '.FSText::_('Categories'),'',1,'col-md-8',1);
    
    	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
    	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    //	TemplateHelper::dt_edit_text(FSText :: _('Mã nhóm'),'code',@$data -> code,'',60,1,0);
    	TemplateHelper::dt_edit_selectbox(FSText::_('Parent'),'parent_id',@$data -> parent_id,'',$categories,$field_value = 'id', $field_label='treename',$size = 1,0,1);
    	// TemplateHelper::dt_checkbox(FSText::_('Kế thừa từ bảng cha'),'inheritance_perent_table',@$data -> inheritance_perent_table,0);
    	//TemplateHelper::dt_edit_selectbox(FSText::_('Tên bảng'),'tablename',@$data -> tablename,'fs_products',$tables,$field_value = 'table_name', $field_label='table_name',$size = 1,0,1);
    	
    //	TemplateHelper::dt_edit_text(FSText :: _('Vat'),'vat',@$data -> vat,'10','',1,0,FSText::_("giá trị %"));
    	// TemplateHelper::dt_checkbox(FSText::_('Bán lẻ?'),'is_retail ',@$data -> is_retail,0);
    	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
    	
    	//TemplateHelper::dt_edit_selectbox(FSText::_('Size'),'sizes',@$data -> sizes,0,$sizes,$field_value = 'id', $field_label='name',$size = 10,1);
    
    	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/original/',URL_ROOT.@$data->image));
        //TemplateHelper::dt_edit_image(FSText :: _('icon'),'icon',str_replace('/original/','/original/',URL_ROOT.@$data->icon));
	$this->dt_form_end_col(); // END: col-1
    
    $this -> dt_form_begin(1,4,FSText::_('Kích hoạt'),'',1,'col-md-4');
        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1,'','','','col-sm-4','col-sm-6');
    $this->dt_form_end_col(); // END: col-2
    // TemplateHelper::dt_edit_image(FSText :: _('Icon'),'icon',str_replace('/original/','/resized/',URL_ROOT.@$data->icon),'','','Cấp 1 iển thị tại menu sản phẩm , Cấp 2 hiển thị trang chủ tại gợi ý mua sắm');
	// TemplateHelper::dt_edit_image(FSText :: _('Banner'),'banner',str_replace('/original/','/small/',URL_ROOT.@$data->banner),'','','170x320px, Hiển thị trang chủ bên dưới gợi ý mua sắm');
	// TemplateHelper::dt_edit_image(FSText :: _('Banner'),'banner_2',str_replace('/original/','/resized/',URL_ROOT.@$data->banner_2),'','','975x150px, Hiển thị trang chủ bên dưới danh sách sản phẩm');
	// TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'description',@$data -> description);
	// TemplateHelper::dt_edit_text(FSText :: _('Các sp hot'),'description_hot',@$data -> description_hot,'',650,450,1);
    $this -> dt_form_end(@$data,1,1,2,FSText::_('Cấu hình Seo'),'',1,'col-md-4');
?>
