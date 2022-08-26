<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<?php
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png',1); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png',1); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   

    echo '  <div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>'; 

	//$this -> dt_form_begin(1,4,$title.' '.FSText::_('News'));
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Course'),'fa-edit',1,'col-md-12',1);
    ?>
    <div class="form-group">
        <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText :: _('Danh mục'); ?></label>
        <div class="col-sm-9 col-xs-12">
            <select  name ="course_id" id="course_id" class='form-control'>
            <option value="">---Chọn danh mục---</option>
            <?php foreach($categories as $item) {
                    $html_check = "";
                    if(@$data ->course_id == $item ->id) {
                        $html_check = " selected='selected' ";
                    }
            ?>
                    <option value="<?php echo $item->id?>" <?php echo $html_check; ?>><?php echo $item ->name; ?></option> 
            <?php } ?>
            </select>
        </div>
    </div>
<?php

        //TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'course_id',@$data->course_id,0,$categories,$field_value = 'id', $field_label='name',$size = 10,0);
        TemplateHelper::dt_edit_text(FSText :: _('Tên khóa học'),'name',@$data->coursename);
    	// TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
        TemplateHelper::dt_edit_image(FSText::_('Image'),'image',str_replace('/original/','/small/',URL_ROOT.@$data->image));
        ?>
        <!-- <div class="form-group">
            <label class="col-md-3 col-xs-12 control-label">File</label>
            <div class="col-md-9  col-xs-12">
                <?php if(@$data->file){?>
                <div class="sort_file">
                    <a style="color: rgba(255, 153, 0, 0.79);" href="#"><?php echo @$data->file; ?></a>
                    <span style="cursor: pointer;margin-left: 10px;color: #F44336;font-size: 16px;" onclick="remove_file('course','course','1','file','sort_file')">
                        <i class="fa fa-times-circle"></i>
                    </span><br>
                </div>
                <?php }?>
                <div class="fileUpload btn btn-primary ">
                    <span><i class="fa fa-cloud-upload"></i> Upload</span>
                    <input type="file" class="upload" name="file">
                    <input type="hidden" id="check_file" value="1">
                </div>
                <span>(Chỉ nhập file PDF)</span>
            </div>
        </div> -->
        <?php
        TemplateHelper::dt_edit_file(FSText::_('File'),'file',@$data->file);
        // TemplateHelper::dt_edit_text(FSText::_('Summary'),'summary',@$data->summary,'',100,5);
        ?>
        <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Cấp học viên") ?></label>
            <div class="col-sm-9 col-xs-12">
                <select name="level" id="level" class="form-control">
                    <option value="">-- <?php echo FSText::_('Chọn Cấp học viên') ?> --</option>
                    <option value="1" <?php if (@$data->level == 1) echo 'selected' ?>>HVN</option>
                    <option value="2" <?php if (@$data->level == 2) echo 'selected' ?>>Head</option>
                    <option value="3" <?php if (@$data->level == 3) echo 'selected' ?>>User</option>
                </select>
            </div>
        </div>
        <?php
        // TemplateHelper::dt_checkbox(FSText::_('Lựa chọn'),'is_view',@$data -> is_view,0,array(0=>FSText::_('Chỉ xem'),1=>FSText::_('Download') ));
    	TemplateHelper::dt_edit_text(FSText::_('Ordering'),'ordering',@$data->ordering,@$maxOrdering,'20');
        // TemplateHelper::dt_checkbox(FSText::_('Hoạt động'),'active',@$data->active,1);
        TemplateHelper::dt_checkbox(FSText::_('Hoạt động'),'published',@$data -> published,1);
        TemplateHelper::dt_checkbox(FSText::_('Chỉ hiện 2 tabs đầu'),'is_tab',@$data->is_tab,0);
    $this->dt_form_end_col(); // END: col-1
    
    // $this -> dt_form_begin(1,2,FSText::_('Admin'),'fa-user',1,'col-md-4 fl-right');
    //     TemplateHelper::dt_text(FSText::_('Tên người tạo'),@$data->creator_name,'','','','col-md-5','col-md-7');
    //     TemplateHelper::dt_text(FSText::_('Thời gian tạo'),@$data->date_created?@$data->date_created:'','', '','','col-md-5','col-md-7');
    //     TemplateHelper::dt_text(FSText::_('Tên người sửa'),@$data->lastedit_name,'','','','col-md-5','col-md-7');
    //     TemplateHelper::dt_text(FSText::_('Thời gian sửa'),@$data->lastedit_date?@$data->lastedit_date:'','', '','','col-md-5','col-md-7');   
    // $this->dt_form_end_col(); // END: col-2    
    
    // $this -> dt_form_begin(1,4,FSText::_('Content'),'fa-user',1,'col-md-8');
    //     TemplateHelper::dt_edit_text(FSText :: _(''),'content',@$data -> content,'',650,450,1,'','','col-sm-2','col-sm-12');
    // $this->dt_form_end_col(); // END: col-4
    
	?>
<?php 
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
        $('.alert-danger').show();  
        
        if(!notEmpty('course_id','Bạn chưa chọn danh mục')){
            return false;
        }

        if(!notEmpty('name','Bạn phải nhập tên khóa học'))
            return false;
        
        if(!lengthMaxword('name',10,'Mỗi từ tối đa có 10 ký tự'))
            return false;
            
        if(!notEmpty('image','Bạn phải nhập hình ảnh'))
            return false;

        if(!notEmpty('level','Hãy chọn cấp học viên')){
            return false;
        }

         // if(!notEmpty('file','bạn phải nhập file'))
         //    return false;

        $('.alert-danger').hide();
        return true;
    }
   
</script>