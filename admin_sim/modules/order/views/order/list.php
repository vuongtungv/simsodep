<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách đơn hàng').' ('.$new.' đơn hàng mới)' );
	// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	//$toolbar->addButton('export',FSText :: _('Export'),'','Excel-icon.png');
    //	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 3;
    $fitler_config['text_count'] = 2;
    
    $text_from_date = array();
	$text_from_date['title'] =  FSText::_('Từ ngày'); 
	
	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày');  
 
	$filter_status = array();
	$filter_status['title'] =  FSText::_('Trạng thái'); 
	$filter_status['list'] = @$array_obj_status; 

	$filter_member = array();
	$filter_member['title'] =  FSText::_('Loại khách hàng'); 
	$filter_member['list'] = @$array_obj_member;
	$filter_user['field'] = 'name';	

	$filter_user = array();
	$filter_user['title'] = FSText::_('Nhân viên'); 
	$filter_user['list'] = @$user_cms; 
	$filter_user['field'] = 'full_name';

	
	$fitler_config['filter'][] = $filter_status;
	$fitler_config['filter'][] = $filter_member;
	$fitler_config['filter'][] = $filter_user;
	$fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;
	//$fitler_config['text'][] = $text_userid;
    
    $list_config = array();
    $list_config[] = array('title'=>FSText :: _('Mã đơn hàng'),'field'=>'code','ordering'=> 1, 'type'=>'status_order');
	$list_config[] = array('title'=>FSText :: _('Người mua'),'field'=>'recipients_name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>FSText :: _('Danh sách sim đặt mua'),'field'=>'list_sim','ordering'=> 1, 'type'=>'text_phone_order');
	$list_config[] = array('title'=>FSText :: _('Giá'),'field'=>'total_end','ordering'=> 1, 'type'=>'format_money');
	$list_config[] = array('title'=>FSText :: _('Điện thoại'),'field'=>'recipients_mobilephone','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>FSText :: _('Thành phố'),'field'=>'recipients_city_name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>FSText :: _('Nhân viên'),'field'=>'username','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Trạng thái','field'=>'status','ordering'=> 1, 'type'=>'edit_selectbox','col_width' => '13%','arr_params'=>array('arry_select'=>$array_obj_status,'field_value'=>'id','field_label'=>'name','size'=>1));
	$list_config[] = array('title'=>'Khách hàng','field'=>'member_level_name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>FSText :: _('Ngày mua'),'field'=>'created_time','ordering'=> 1, 'type'=>'day_time');
	$list_config[] = array('title'=>FSText :: _('Chi tiết'),'type'=>'edit');
    
	// $list_config[] = array('title'=>FSText :: _('Giá trị'),'field'=>'total_after_discount','ordering'=> 1, 'type'=>'format_money');
 //    $list_config[] = array('title'=>FSText :: _('Trạng thái'),'field'=>'status','ordering'=> 1, 'type'=>'status','arr_params'=>$array_obj_status);
	
    
    TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
    
?>
<style type="text/css" media="screen">
	.op{
		position: relative;
	}
	.op .all_p{
		display: none;
	}
/*	.op:hover .one_p{
		display: none;
	}*/
	.op:hover .all_p{
		display: block;
		position: absolute;
	    top: -11px;
	    background: #eaeaea;
	    padding: 10px;
	    border: 1px solid #ccc;
	    left: 98%;
	    color: #337ab7;
	}
</style>
<script>
	$(function() {
		$( "#text0" ).datepicker({
		  clickInput:true,
          dateFormat: 'dd-mm-yy',
          changeMonth: true,
          numberOfMonths: 2,
          changeYear: true,
          maxDate:  " + d ",
          showMonthAfterYear: true
        });
		$( "#text1" ).datepicker({
		  clickInput:true,
          dateFormat: 'dd-mm-yy',
          changeMonth: true,
          numberOfMonths: 2,
          changeYear: true,
          maxDate:  " + d ",
          showMonthAfterYear: true
        });
	});
</script>
