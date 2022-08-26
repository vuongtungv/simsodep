<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
    $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
	
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Danh mục'),'fa-edit',1,'col-md-8',1);
    	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
    	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    	TemplateHelper::dt_edit_selectbox(FSText::_('Parent'),'parent_id',@$data -> parent_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 10,0,1);
    	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
    	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
        //TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,5,0);
    $this->dt_form_end_col(); // END: col-1
    
    $this -> dt_form_begin(1,6,FSText::_('Image'),'fa-image',1,'col-md-4 fl-right');
        TemplateHelper::dt_edit_image(FSText :: _('icon'),'icon',str_replace('/original/','/original/',URL_ROOT.@$data->icon));
    $this->dt_form_end_col(); // END: col-2
    
    $this -> dt_form_begin(1,4,FSText::_('Cấu hình seo'),'',1,'col-md-4 fl-right');
        TemplateHelper::dt_edit_text(FSText :: _('SEO title'),'seo_title',@$data -> seo_title,'',100,1,0,'','','col-md-12','col-md-12');
		TemplateHelper::dt_edit_text(FSText :: _('SEO meta keyword'),'seo_keyword',@$data -> seo_keyword,'',100,1,0,'','','col-md-12','col-md-12');
		TemplateHelper::dt_edit_text(FSText :: _('SEO meta description'),'seo_description',@$data -> seo_description,'',100,9,0,'','','col-md-12','col-md-12');
    $this->dt_form_end_col(); // END: col-4
    
    //$this -> dt_form_begin(1,4,FSText::_('Sản phẩm liên quan'),'fa fa-briefcase',1,'col-md-8');
//        include 'detail_related_products.php';
//    $this->dt_form_end_col(); // END: col-4
    
    $this -> dt_form_begin(1,4,FSText::_('Thông tin'),'fa-info',1,'col-md-8');
        TemplateHelper::dt_edit_text(FSText :: _(''),'summary',@$data -> summary,'',650,450,1,'','','col-sm-12','col-sm-12');
    $this->dt_form_end_col(); // END: col-4
    
//	TemplateHelper::dt_edit_image(FSText :: _('Icon'),'icon',@$data -> icon);
	
	$this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4');
	
?>

