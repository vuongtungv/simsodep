<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Lịch sử thanh toán') );
	$toolbar->addButton('add',FSText :: _('Đối chiếu'),'','edit.png'); 
	// $toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 

	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 2;
	$fitler_config['text_count'] = 0;

	$text_from_date = array();
	$text_from_date['title'] =  FSText::_('Từ ngày'); 
	
	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày'); 

	// $filter_status = array();
	// $filter_status['title'] =  FSText::_('Trạng thái'); 
	// $filter_status['list'] = @$array_obj_status; 

	$filter_user = array();
	$filter_user['title'] = FSText::_('Nhân viên'); 
	$filter_user['list'] = @$user_cms; 
	$filter_user['field'] = 'full_name';

	$filter_agency = array();
	$filter_agency['title'] = FSText::_('Đại lý'); 
	$filter_agency['list'] = @$new_agency; 
	$filter_agency['field'] = 'name';

	// $fitler_config['filter'][] = $filter_status;
	$fitler_config['filter'][] = $filter_user;
	$fitler_config['filter'][] = $filter_agency;
	$fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;

	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Đại lý','field'=>'agency_name','ordering'=> 1, 'type'=>'text','col_width' => '10%','arr_params'=>array('size'=> 40));
	$list_config[] = array('title'=>'Người chốt','field'=>'user_name','ordering'=> 1, 'type'=>'text','col_width' => '10%','arr_params'=>array('size'=> 40));
    $list_config[] = array('title'=>'Ngày chốt','field'=>'created_time','ordering'=> 1, 'type'=>'day_time');
	$list_config[] = array('title'=>'Số tiền','field'=>'recive','ordering'=> 1, 'type'=>'format_money_pay','col_width' => '10%','arr_params'=>array('size'=> 40));
	$list_config[] = array('title'=>'Trạng thái','field'=>'status','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Ghi chú','field'=>'note','ordering'=> 1, 'type'=>'text','col_width' => '30%','arr_params'=>array('size'=> 40));
	$list_config[] = array('title'=>'Chi tiết','type'=>'edit');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
