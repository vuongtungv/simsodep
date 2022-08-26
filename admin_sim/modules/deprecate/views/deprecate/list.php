<?php  
	global $toolbar;
	// $toolbar->setTitle(FSText :: _('Tìm sim theo yêu cầu') );
	$toolbar->setTitle(FSText :: _('Tìm sim theo yêu cầu ('.$new.' đơn hàng mới) ') );
    //$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
    $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 

	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Họ tên','field'=>'fullname','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Địa chỉ','field'=>'address','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Điện thoại','field'=>'telephone','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'6 số cuối muốn tìm','field'=>'six_last','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Giá tiền mong muốn','field'=>'price','ordering'=> 1,'type'=>'format_money');
    //$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	//$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	$list_config[] = array('title'=>'Thời gian tạo','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Trạng thái','field'=>'status','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Người sửa','field'=>'author','ordering'=> 1,'type'=>'text');
	$list_config[] = array('title'=>'Thời gian sửa','field'=>'edited_time','ordering'=> 1,'type'=>'datetime');
	$list_config[] = array('title'=>'Xem','type'=>'edit');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
