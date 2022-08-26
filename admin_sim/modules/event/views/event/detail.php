<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<?php
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   
	
	//$this -> dt_form_begin(1,4,$title.' '.FSText::_('News'));
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('News'),'fa-edit',1,'col-md-8',1);
        TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
    	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
        TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/small/',URL_ROOT.@$data->image));
    	TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 10,0);
        TemplateHelper::datetimepicke( FSText :: _('Published time' ), 'created_time', @$data->created_time?@$data->created_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20,'','col-md-2','col-md-4');
    $this->dt_form_end_col(); // END: col-1
    
    $this -> dt_form_begin(1,2,FSText::_('Kích hoạt'),'fa-unlock',1,'col-md-4 fl-right');
        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1,'','','','col-sm-4','col-sm-8');
        //TemplateHelper::dt_checkbox(FSText::_('Hiển thị trang chủ'),'show_in_homepage',@$data -> show_in_homepage,0,'','','','col-sm-4','col-sm-8');
        //TemplateHelper::dt_checkbox(FSText::_('Tin nổi bật'),'is_hot',@$data -> is_hot,0,'','','','col-sm-4','col-sm-8');
        //TemplateHelper::dt_checkbox(FSText::_('Tin mới'),'is_new',@$data -> is_new,0,'','','','col-sm-4','col-sm-8');
        TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'','',0,'','','col-sm-4','col-sm-8');
    $this->dt_form_end_col(); // END: col-2
    //$this -> dt_form_begin(1,2,FSText::_('tác giả'),'fa-user',1,'col-md-4');
//        TemplateHelper::dt_edit_text(FSText :: _('Người tạo'),'',@$data -> author,'','','','','','','col-sm-4','col-sm-8');
//        TemplateHelper::datetimepicke( FSText :: _('Thời gian tạo' ), '', @$data->start_time?@$data->start_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20,'','col-md-4','col-md-8');
//        TemplateHelper::dt_edit_text(FSText :: _('Người sửa'),'',@$data -> author_last,'','','','','','','col-sm-4','col-sm-8');
//        TemplateHelper::datetimepicke( FSText :: _('Thời gian sửa'), '', @$data->end_time?@$data->end_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20,'','col-md-4','col-md-8');
//        //TemplateHelper::dt_edit_text(FSText :: _(''),'author',@$data -> author,'',650,450,1,'','','col-sm-2','col-sm-12');
//    $this->dt_form_end_col(); // END: col-4
    
    //$this -> dt_form_begin(1,2,FSText::_('Ảnh'),'fa-image',1,'col-md-4 fl-right');
        //TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/small/',URL_ROOT.@$data->image));
        //TemplateHelper::dt_edit_image(FSText :: _('icon'),'icon',str_replace('/original/','/original/',URL_ROOT.@$data->icon));
    //$this->dt_form_end_col(); // END: col-2
    
    $this -> dt_form_begin(1,2,FSText::_('Summary'),'fa-info',1,'col-md-4');
        TemplateHelper::dt_edit_text(FSText :: _(''),'summary',@$data -> summary,'',100,5,0,'','','col-sm-2','col-sm-12');
        //TemplateHelper::dt_edit_text(FSText :: _('Thông tin chi tiết'),'description',@$data -> description,'',650,450,1,'','','col-sm-2','col-sm-12');
    $this->dt_form_end_col(); // END: col-4
    
    $this -> dt_form_begin(1,4,FSText::_('Content'),'fa-user',1,'col-md-8');
        TemplateHelper::dt_edit_text(FSText :: _(''),'content',@$data -> content,'',650,450,1,'','','col-sm-2','col-sm-12');
    $this->dt_form_end_col(); // END: col-4

    //$this -> dt_form_begin(1,4,FSText::_('Tin liên quan'),'fa-question-circle',1,'col-md-8');
    //    include 'detail_related.php';
    //$this->dt_form_end_col(); // END: col-4
    
    
    //$this -> dt_form_begin(1,2,FSText::_('Tags'),'fa-tags',1,'col-md-4 fl-right');
//        TemplateHelper::dt_edit_text(FSText :: _(''),'tags',@$data -> tags,'',100,4,0,'','','col-sm-2','col-sm-12');
//    $this->dt_form_end_col(); // END: col-4
    
    //$this -> dt_form_begin(1,4,FSText::_('Sản phẩm liên quan'),'fa fa-briefcase',1,'col-md-8');
//        include 'detail_related_products.php';
//    $this->dt_form_end_col(); // END: col-4
    
    $this -> dt_form_begin(1,2,FSText::_('Cấu hình seo'),'',1,'col-md-4 fl-right');
        TemplateHelper::dt_edit_text(FSText :: _('SEO title'),'seo_title',@$data -> seo_title,'',100,1,0,'','','col-md-12','col-md-12');
		TemplateHelper::dt_edit_text(FSText :: _('SEO meta keyword'),'seo_keyword',@$data -> seo_keyword,'',100,1,0,'','','col-md-12','col-md-12');
		TemplateHelper::dt_edit_text(FSText :: _('SEO meta description'),'seo_description',@$data -> seo_description,'',100,6,0,'','','col-md-12','col-md-12');
    $this->dt_form_end_col(); // END: col-4
    
    // $this -> dt_form_begin(1,4,FSText::_('Cấu hình seo keyword'),'',1,'col-md-12');
//        TemplateHelper::dt_checkbox(FSText::_('Tự động tối ưu seo'),'optimal_seo',@$data -> optimal_seo,1,'','',FSText::_('Tự động lấy các keyword đã có trong các tin đã đăng,tối đa 3 keyword(thuộc link trong website) trong 1 bài viết + keyword(link ngoài website)'));
//    $this->dt_form_end_col(); // END: col-4
    
	?>
        <!--<ul class="nav nav-tabs">
            <li class="active"><a href="#fragment-1" data-toggle="tab" aria-expanded="true"><?php //echo FSText::_('Trường cơ bản cơ bản'); ?></a>
            </li>
        </ul>
        <div class="tab-content panel-body">
            <div class="tab-pane active" id="fragment-1">
                <?php //include_once 'detail_base.php';?>            
            </div>

        </div> -->
<?php 
    //$this -> dt_form_end(@$data,1,0,2,'Cấu hình seo');
    $this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4');
?>

<?php //include 'detail_seo.php'; ?>
