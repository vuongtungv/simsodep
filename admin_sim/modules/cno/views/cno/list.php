<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách công nợ ('.$new.' công nợ mới) ') );
	$toolbar->addButton('export',FSText :: _('Export Total'),'','Excel-icon.png');
	$toolbar->addButton('export_detail',FSText :: _('Export Detail'),'','Excel-icon.png');
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	// $toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 

	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 4;
	$fitler_config['text_count'] = 2;

	$text_from_date = array();
	$text_from_date['title'] =  FSText::_('Từ ngày'); 
	
	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày'); 

	$filter_status = array();
	$filter_status['title'] =  FSText::_('Trạng thái'); 
	$filter_status['list'] = @$array_obj_status; 

	$filter_user = array();
	$filter_user['title'] = FSText::_('Nhân viên'); 
	$filter_user['list'] = @$user_cms; 
	$filter_user['field'] = 'full_name';

	$filter_agency = array();
	$filter_agency['title'] = FSText::_('Tất cả đại lý'); 
	$filter_agency['list'] = @$new_agency; 
	$filter_agency['field'] = 'name';	

	$filter_agency_bad = array();
	$filter_agency_bad['title'] = FSText::_('Đại lý nợ xấu'); 
	$filter_agency_bad['list'] = @$bad_agency; 
	$filter_agency_bad['field'] = 'name';

	$fitler_config['filter'][] = $filter_status;
	$fitler_config['filter'][] = $filter_user;
	$fitler_config['filter'][] = $filter_agency;
	$fitler_config['filter'][] = $filter_agency_bad;
	$fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;

	//	CONFIG	
	$list_config = array();
    $list_config[] = array('title'=>'Ngày GD','field'=>'created_time','ordering'=> 1, 'type'=>'day_time');
	$list_config[] = array('title'=>'Số sim </br>(Đại lý)','field'=>'sim','ordering'=> 1, 'type'=>'cno_sim','col_width' => '10%','arr_params'=>array('size'=> 40));
	$list_config[] = array('title'=>FSText :: _('Giá cuối </br>(giá DL)'),'field'=>'price_sell','ordering'=> 1, 'type'=>'cno_partner');
	$list_config[] = array('title'=>'Hoa hồng','field'=>'commissions','ordering'=> 1, 'type'=>'cno_commissions','col_width' => '10%','arr_params'=>array('size'=> 40));
	$list_config[] = array('title'=>'Phải trả </br>(Thực trả)','field'=>'price_partner','ordering'=> 1, 'type'=>'cno_price','col_width' => '10%','arr_params'=>array('size'=> 40));
	$list_config[] = array('title'=>'Thu hộ </br>(Tự thu)','field'=>'partner_recive','ordering'=> 1, 'type'=>'cno_recive','col_width' => '10%','arr_params'=>array('size'=> 40));
	$list_config[] = array('title'=>'Lãi </br>(Phí)','field'=>'price_interest','ordering'=> 1, 'type'=>'cno_interest','col_width' => '10%','arr_params'=>array('size'=> 40));
	$list_config[] = array('title'=>'Phải trả/Thu','field'=>'recive','ordering'=> 1, 'type'=>'format_money','col_width' => '10%','arr_params'=>array('size'=> 40));
	$list_config[] = array('title'=>'Trạng thái','field'=>'status','ordering'=> 1, 'type'=>'edit_selectbox','col_width' => '13%','arr_params'=>array('arry_select'=>$array_obj_status,'field_value'=>'id','field_label'=>'name','size'=>1));
	$list_config[] = array('title'=>'Edit','type'=>'edit');
	// $list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>

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

