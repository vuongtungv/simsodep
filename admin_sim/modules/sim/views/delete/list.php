<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách sim đã xóa') );
	//$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('restore',FSText :: _('Khôi phục'),'','add.png');  
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 	
	//	FILTER

	$filter_config  = array();
	$fitler_config['search'] = 1; 
    $fitler_config['text_count'] = 4;
    $fitler_config['filter_count'] = 4;

    $filter_categories = array();
	$filter_categories['title'] = FSText::_('Nhà mạng'); 
	$filter_categories['list'] = @$network; 
	$filter_categories['field'] = 'name';

	$filter_partner = array();
	$filter_partner['title'] = FSText::_('Đại lý'); 
	$filter_partner['list'] = @$partner; 
	$filter_partner['field'] = 'full_name';

    $filter_type = array();
    $filter_type['title'] = FSText::_('Loại sim'); 
    $filter_type['list'] = @$type; 
    $filter_type['field'] = 'name';

    $filter_status = array();
    $filter_status['title'] =  FSText::_('Trạng thái'); 
    $filter_status['list'] = @$array_obj_status;

    $text_from_date = array();
	$text_from_date['title'] =  FSText::_('Từ ngày'); 
	
	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày');

	$text_from_price = array();
	$text_from_price['title'] =  FSText::_('Từ giá'); 
	
	$text_to_price = array();
	$text_to_price['title'] =  FSText::_('Đến giá');    
	
	$fitler_config['filter'][] = $filter_categories;
	$fitler_config['filter'][] = $filter_partner;
    $fitler_config['filter'][] = $filter_type;
	$fitler_config['filter'][] = $filter_status;
    $fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;	
	$fitler_config['text'][] = $text_from_price;
	$fitler_config['text'][] = $text_to_price;


	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Sim','field'=>'sim','ordering'=> 1,'align'=>'left', 'type'=>'text');
	$list_config[] = array('title'=>'Nhà mạng','field'=>'network','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Đại lý','field'=>'agency_name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Giá bán','field'=>'price','ordering'=> 1, 'type'=>'format_money');
	$list_config[] = array('title'=>'Chiết khấu','field'=>'commission_value','ordering'=> 1, 'type'=>'format_money');
	$list_config[] = array('title'=>'Giá hiển thị','field'=>'price_public','ordering'=> 1, 'type'=>'format_money');
    $list_config[] = array('title'=>'Ngày tạo','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
    // $list_config[] = array('title'=>'Ngày hiển thị','field'=>'public_time','ordering'=> 1, 'type'=>'datetime');

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