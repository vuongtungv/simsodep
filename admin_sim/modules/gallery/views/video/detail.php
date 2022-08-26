<?php
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	// $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png',1); 
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png',1); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png',1);
	$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png'); 

    echo '  <div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>';  
	
	$this -> dt_form_begin(1,4,$title.' '.FSText::_('Bài học video'),'fa-edit',1,'col-md-12',1);
?>
    <div class="form-group">
        <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText :: _('Khóa học'); ?></label>
        <div class="col-sm-9 col-xs-12">
            <select  name ="course_id" id="course_id" class='form-control'>
            <option value="">---Chọn khóa học---</option>
            <?php foreach($course as $item) {
                    $html_check = "";
                    if(@$data ->course_id == $item ->id) {
                        $html_check = " selected='selected' ";
                    }
            ?>
                    <option value="<?php echo $item->id?>" <?php echo $html_check; ?>><?php echo $item ->coursename; ?></option> 
            <?php } ?>
            </select>
        </div>
    </div>
<?php
    	TemplateHelper::dt_edit_text(FSText :: _('Tên Video'),'name',@$data -> name);
    	// TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',40,1,0,FSText::_("You must enter alias "));
        @$data->image ? $image = URL_ROOT.@$data->image : $image = '';
//    	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',$image));
    	TemplateHelper::dt_edit_file(FSText :: _('Video'),'video',@$data->video,'','col-md-3','col-md-9');
    	TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',650,450,1,'','','col-sm-3','col-sm-9');
        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1,'','','');
    $this->dt_form_end_col();

    $this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4');
?>

<script type="text/javascript">
    $('.form-horizontal').keypress(function (e) {
      if (e.which == 13) {
        formValidator();
        return false;  
      }
    });
    function formValidator()
    {
        var $i = $("#check_image").val();
        var $v = $("#check_video").val();

        
        if(!notEmpty('course_id','Bạn phải chọn khóa học')){
            return false;
        }

        if(!notEmpty('name','Bạn phải nhập tên video')){
            return false;
        }
        
        if(!lengthMaxword('name',10,'Mỗi từ tối đa có 10 ký tự'))
            return false;
        
//        if ($i == 0) {
//            if(!notEmpty('image','Bạn phải nhập hình ảnh')){
//                return false;
//            }
//        }

        if ($v == 0) {
            if(!notEmpty('video','Bạn phải nhập video')){
                return false;
            }
        }

        if (CKEDITOR.instances.summary.getData() == '') {
            invalid("summary", 'Bạn phải nhập tóm tắt');
            // $("#cke_summary").focus();
            return false;
        }
            
        $('.alert-danger').hide();

        return true;
    }    
</script>

