<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách quản trị viên') );
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	//$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
    
    $filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 1;

    $filter_categories = array();
	$filter_categories['title'] = FSText::_('Tỉnh/thành'); 
	$filter_categories['list'] = @$city; 
	$filter_categories['field'] = 'name';

	$fitler_config['filter'][] = $filter_categories;
    
    $list_config[] = array('title'=>'Tên quản trị viên','field'=>'full_name', 'type'=>'text','col_width' => '20%','align'=>'left'); 
    $list_config[] = array('title'=>'Số điện thoại','field'=>'phone', 'type'=>'text','col_width' => '15%','align'=>'left');
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	$list_config[] = array('title'=>'Phân quyền','type'=>'view','module'=>'users','view'=>'users','task'=>'permission','field_value'=>'cid');
    $list_config[] = array('title'=>'Edit','type'=>'edit');
	$list_config[] = array('title'=>'Ngày tạo','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
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