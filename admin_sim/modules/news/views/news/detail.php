<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>

<?php
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png',1); 
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png',1); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png',1); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png'); 
    // $toolbar->addButton('close',FSText :: _('Close'),'','cancel.png');  
	
    echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>'; 
	//$this -> dt_form_begin(1,4,$title.' '.FSText::_('News'));
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('News'),'fa-edit',1,'col-md-8',1);
        TemplateHelper::dt_edit_text(FSText :: _('Tiêu đề tin'),'title',@$data -> title);
    	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
        ?>
<!--<div class="form-group">-->
<!--    <label class="col-md-3 col-xs-12 control-label">--><?php //echo FSText::_('')?><!--</label>-->
<!--    <div class="col-md-9 col-xs-12">-->
<!--        <input type="text" class="form-control" name="extends_field" id="extends_field" value="--><?php //echo @$data->extends_field ?><!--" size="60">-->
<!--    </div>-->
<!--</div>-->

<?php

        TemplateHelper::dt_edit_image(FSText :: _('Hình ảnh'),'image',str_replace('/original/','/small/',URL_ROOT.@$data->image));
    	// TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 10,0,0);
        TemplateHelper::dt_edit_text(FSText :: _('Tags'),'tags',@$data -> tags,'',255,1,0,FSText::_("Các giá trị cách nhau dấu \" , \""));
        TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data ->category_id,0,$categories,$field_value = 'id', $field_label='name',$size = 1,0,1);
        TemplateHelper::datetimepicke( FSText :: _('Published time' ), 'created_time', @$data->created_time?@$data->created_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20,'','col-md-3','col-md-4');
        //TemplateHelper::dt_edit_text(FSText :: _('Link video'),'video',@$data -> video,'',100,1,0,'','','col-sm-3','col-sm-9');
    $this->dt_form_end_col(); // END: col-1
    
    $this -> dt_form_begin(1,2,FSText::_('Quản trị'),'fa-user',1,'col-md-4 fl-right');
        TemplateHelper::dt_text(FSText :: _('Người tạo'),@$data -> author);
        //TemplateHelper::dt_text(FSText :: _('Thời gian tạo'),date('H:i:s d/m/Y',strtotime(@$data -> start_time)));
        TemplateHelper::dt_text(FSText :: _('Người sửa cuối'),@$data -> author_last);
        //TemplateHelper::dt_text(FSText :: _('Thời gian sửa'),date('H:i:s d/m/Y',strtotime(@$data -> end_time)));
    $this->dt_form_end_col(); // END: col-4
        
    $this -> dt_form_begin(1,2,FSText::_('Kích hoạt'),'fa-unlock',1,'col-md-4 fl-right');
        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1,'','','','col-sm-4','col-sm-8');
        TemplateHelper::dt_checkbox(FSText::_('Hiển thị trang chủ'),'show_in_homepage',@$data -> show_in_homepage,0,'','','','col-sm-4','col-sm-8');
        TemplateHelper::dt_checkbox(FSText::_('Tin marquee'),'is_marquee',@$data -> is_marquee,0,'','','','col-sm-4','col-sm-8');
//        TemplateHelper::dt_checkbox(FSText::_('Tin ở header'),'is_marquee',@$data -> is_marquee,0,'','','','col-sm-4','col-sm-8');
        //TemplateHelper::dt_checkbox(FSText::_('Tin dưới slideshow'),'is_new_video',@$data -> is_new_video,0,'','','','col-sm-4','col-sm-8');
        //TemplateHelper::dt_checkbox(FSText::_('Tin video'),'is_video',@$data -> is_video,0,'','','','col-sm-4','col-sm-8');
        //TemplateHelper::dt_checkbox(FSText::_('Tin mới'),'is_new',@$data -> is_new,0,'','','','col-sm-4','col-sm-8');
        TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'','',0,'','','col-sm-4','col-sm-8');
    $this->dt_form_end_col(); // END: col-2
    
 
    $this -> dt_form_begin(1,4,FSText::_('Content'),'fa-info',1,'col-md-8');
        TemplateHelper::dt_edit_text(FSText :: _(''),'content',@$data -> content,'',650,450,1,'','','col-sm-2','col-sm-12');
    $this->dt_form_end_col(); // END: col-4

    $this -> dt_form_begin(1,2,FSText::_('Summary'),'fa-info',1,'col-md-4');
        TemplateHelper::dt_edit_text(FSText :: _(''),'summary',@$data -> summary,'',100,5,0,'','','col-sm-2','col-sm-12');
        //TemplateHelper::dt_edit_text(FSText :: _('Thông tin chi tiết'),'description',@$data -> description,'',650,450,1,'','','col-sm-2','col-sm-12');
    $this->dt_form_end_col(); // END: col-4


    $this -> dt_form_begin(1,2,FSText::_('Cấu hình seo'),'',1,'col-md-4 fl-right');
    TemplateHelper::dt_edit_text(FSText :: _('SEO title'),'seo_title',@$data -> seo_title,'',100,1,0,'','','col-md-12','col-md-12');
    TemplateHelper::dt_edit_text(FSText :: _('SEO meta keyword'),'seo_keyword',@$data -> seo_keyword,'',100,1,0,'','','col-md-12','col-md-12');
    TemplateHelper::dt_edit_text(FSText :: _('SEO meta description'),'seo_description',@$data -> seo_description,'',100,6,0,'','','col-md-12','col-md-12');
    $this->dt_form_end_col(); // END: col-4
    $this -> dt_form_end(@$data,1,0,2,'Cấu hình seo');
    $this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4');
?>

<script>
    $(document).ready(function () {
        $('#title').on('keyup',function () {
            var $alias = to_slug($(this).val());
            document.getElementById("alias").value = $alias;
        });
        function to_slug(str) {
            // Chuyển hết sang chữ thường
            str = str.toLowerCase();

            // xóa dấu
            str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
            str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
            str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
            str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
            str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
            str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
            str = str.replace(/(đ)/g, 'd');

            // Xóa ký tự đặc biệt
            str = str.replace(/([^0-9a-z-\s])/g, '');

            // Xóa khoảng trắng thay bằng ký tự -
            str = str.replace(/(\s+)/g, '-');

            // xóa phần dự - ở đầu
            str = str.replace(/^-+/g, '');

            // xóa phần dư - ở cuối
            str = str.replace(/-+$/g, '');

            // return
            return str;
        }  
    });
</script>




<script type="text/javascript">
    $('.form-horizontal').keypress(function (e) {
      if (e.which == 13) {
        formValidator();
        return false;  
      }
    });
    
	function formValidator()
	{
	    $('.alert-danger').show();	
        
		if(!notEmpty('title','Bạn phải nhập tiêu đề'))
			return false;
        
        // if(!lengthMaxword('title',100,'Mỗi từ tối đa có 100 ký tự'))
        //     return false;
            
        if(!notEmpty('image','bạn phải nhập hình ảnh'))
			return false;
            
        if(!notEmpty('category_id','Bạn phải chọn danh mục'))
		   return false;
               
        if(!notEmpty('summary','Bạn phải nhập nội dung mô tả'))
		   return false;
        
        if (CKEDITOR.instances.content.getData() == '') {
            invalid("content", 'Bạn phải nhập nội dung chi tiết');
            return false;
        }
            
		$('.alert-danger').hide();
		return true;
	}
   

</script>
<?php //include 'detail_seo.php'; ?>
