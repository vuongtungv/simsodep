<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách đại lý') );
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	//$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
    
    $filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 2;

    $filter_categories = array();
	$filter_categories['title'] = FSText::_('Tỉnh/thành'); 
	$filter_categories['list'] = @$city; 
	$filter_categories['field'] = 'name';

	$filter_status = array();
	$filter_status['title'] =  FSText::_('Đại lý có sim'); 
	$filter_status['list'] = @$array_obj_status;
	$filter_status['field'] = 'name';	

	$fitler_config['filter'][] = $filter_categories;
	$fitler_config['filter'][] = $filter_status;
    
    $list_config[] = array('title'=>'Tên đại lý','field'=>'full_name', 'type'=>'text','col_width' => '20%','align'=>'left'); 
    $list_config[] = array('title'=>'Phone/Email/website','field'=>'phone', 'type'=>'phone_email_web','col_width' => '15%','align'=>'left');
    // $list_config[] = array('title'=>'Chiết khấu','field'=>'agencies_name', 'type'=>'text','col_width' => '15%','align'=>'left');
    $list_config[] = array('title'=>'Chiết khấu/Tăng giảm giá','field'=>'price_name', 'type'=>'text','col_width' => '15%','align'=>'left');
    $list_config[] = array('title'=>'Thành phố','field'=>'city','ordering'=> 1, 'type'=>'edit_selectbox','col_width' => '25%','arr_params'=>array('arry_select'=>$city,'field_value'=>'id','field_label'=>'name','size'=>1));
    $list_config[] = array('title'=>'Số sim','field'=>'total_sim', 'type'=>'text','col_width' => '10%','align'=>'left');
    $list_config[] = array('title'=>'Công nợ','field'=>'owe', 'type'=>'text','col_width' => '10%','align'=>'left');
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	// $list_config[] = array('title'=>'Phân quyền','type'=>'view','module'=>'users','view'=>'users','task'=>'permission','field_value'=>'cid');
    $list_config[] = array('title'=>'Edit','type'=>'edit');
    $list_config[] = array('title'=>'Xóa sim','type'=>'delete');
    $list_config[] = array('title'=>'Duyệt sim','type'=>'allowed');
	$list_config[] = array('title'=>'Ngày cập nhật sim','field'=>'last_update','ordering'=> 1, 'type'=>'datetime');
	// $list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
    
    TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>

<script>
function confirm_task(delUrl) {
	  if (confirm("Thực hiện tác vụ ?")) {
	    document.location = delUrl;
	  }
}
</script>