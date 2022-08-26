<style type="text/css">
    .price_name{
        color: #de2c17;
        font-size: 14px;
    }
</style>
<?php
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Thêm mới sim'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png',1); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   
	
    $data_partner=@$data ->agency;
    if(isset($_SESSION['ad_type']) && $_SESSION['ad_type']==2){
        $data_partner = $_SESSION['ad_userid'];
    }

    $this -> dt_form_begin();
    TemplateHelper::dt_edit_selectbox(FSText::_('Cách nhập'),'type','2',0,array('1'=>'Nhập trực tiếp','2'=>'Import từ file CSV'),$field_value = 'id', $field_label='treename','',0,1,'');
    // TemplateHelper::dt_edit_text(FSText :: _('Nhập mới dãy số'),'sims',@$data ->sims,'',100,10,'','Mỗi dòng là một số. Sim và giá cách nhau bởi dấu cách');
    TemplateHelper::dt_edit_file(FSText :: _('Nhập file CSV'),'excel',@$data ->excel,' Cột A là sim, cột B là giá');
    // TemplateHelper::dt_edit_selectbox(FSText::_('Chọn đơn vị giá'),'unit_price',@$data ->unit_price,0,array('1'=>'Nghìn','2'=>'Trăm nghìn','3'=>'Triệu'),$field_value = 'id', $field_label='treename','',0,1,'Đơn vị giá mặc định là VND');
    TemplateHelper::dt_edit_selectbox(FSText::_('Đại lý'),'agency',@$data_partner,0,$partner,$field_value = 'id', $field_label='full_name','',0,1,'');
    // TemplateHelper::datetimepicke( FSText :: _('Thời gian hiển thị' ), 'public_time', @$data->public_time?@$data->public_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20,'','col-md-3','col-md-4');
?>
<!-- <div style="text-align: center;">
    <a id="btn_save_sim" class="btn blue btn-outline sbold" href="javascript:void(0)"><i class="fa fa-save"></i> Lưu lại </a>
</div> -->
<?php
    $this -> dt_form_end(@$data,1,0); 
?>

<script type="text/javascript">
    $('#agency').parent().append('<p class="price_name"></p>');
    $('#agency').change(function () {
    $agency = $(this).val();
        $.ajax({url: "<?php echo URL_ROOT.URL_ROOT_ADMIN ?>index.php?module=sim&view=sim&task=get_agency&raw=1",
            data: {agency: $agency},
            dataType: "text",
            success: function (result) {
                if(result){
                    $('.price_name').html('Trường hợp chiết khấu " '+result+' "');
                }else{
                    $('.price_name').html('');
                }
            }
        });
    });

    // $('.form-horizontal').keypress(function (e) {
      // if (e.which == 13) {
        // formValidator();
        // return false;  
      // }
    // });

    <?php if(isset($_SESSION['ad_type']) && $_SESSION['ad_type']==2){
        $data_partner = $_SESSION['ad_userid']; ?>
        $('#agency').attr('disabled','disabled');
    <?php } ?>
    
	function formValidator()
	{
        $('.alert-danger').show();  
        
        if(!notEmpty('agency','Bạn phải chọn đại lý'))
            return false;
            
        $('.alert-danger').hide();
        return true;
	}

    $(function(){
        $('#sims').parent().parent().hide();
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
