<?php
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Thêm mới sim'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png',1); 
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png',1); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png',1); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   
	

    $this -> dt_form_begin();
    TemplateHelper::dt_edit_selectbox(FSText::_('Cách nhập'),'type','1',0,array('1'=>'Nhập trực tiếp','2'=>'Import từ file Excel'),$field_value = 'id', $field_label='treename','',0,1,'');
    TemplateHelper::dt_edit_text(FSText :: _('Nhập mới dãy số'),'sims',@$data ->sims,'',100,10,'','Mỗi dòng là một số. Sim và giá cách nhau bởi dấu cách');
    TemplateHelper::dt_edit_file(FSText :: _('Nhập file excel'),'excel',@$data ->excel,' Cột A là sim, cột B là giá, bắt đầu tính từ dòng số 2');
    TemplateHelper::dt_edit_selectbox(FSText::_('Chọn đơn vị giá'),'unit_price',@$data ->unit_price,0,array('1'=>'Ngìn','2'=>'Trăm','3'=>'Triệu'),$field_value = 'id', $field_label='treename','',0,1,'Đơn vị giá mặc định là VND');
    TemplateHelper::dt_edit_selectbox(FSText::_('Đại lý'),'partner',@$data ->partner,0,array(),$field_value = 'id', $field_label='treename','',0,1,'');
    TemplateHelper::datetimepicke( FSText :: _('Thời gian hiển thị' ), 'public_time', @$data->public_time?@$data->public_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20,'','col-md-3','col-md-4');
    $this -> dt_form_end(@$data,1,0); 

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
		return true;
	}

    $(function(){
        $('#excel').parent().parent().parent().parent().parent().hide();
        $("select#type").change(function(){
            input_type = $(this).val();
            if(input_type == 1){
                $('#sims').parent().parent().show();
                $('#excel').parent().parent().parent().parent().parent().hide();
            }else if(input_type == 2){
                $('#excel').parent().parent().parent().parent().parent().show();
                $('#sims').parent().parent().hide();
            }
        });
                
    })

</script>
