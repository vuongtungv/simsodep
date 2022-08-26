<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('COD ('.$new.' cod mới) ') );
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 

	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 1;


	$filter_status = array();
	$filter_status['title'] =  FSText::_('Trạng thái'); 
	$filter_status['list'] = @$array_obj_status; 

	$fitler_config['filter'][] = $filter_status;

	//	CONFIG	
	$list_config = array();
    $list_config[] = array('title'=>'Ngày','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Sim','field'=>'sim','ordering'=> 1, 'type'=>'text_order','col_width' => '10%','arr_params'=>array('size'=> 40));
	$list_config[] = array('title'=>FSText :: _('Giá'),'field'=>'price','ordering'=> 1, 'type'=>'format_money');
	$list_config[] = array('title'=>FSText :: _('Giá thu'),'field'=>'price_last','ordering'=> 1, 'type'=>'format_money');
	$list_config[] = array('title'=>'Điện thoại','field'=>'phone','ordering'=> 1, 'type'=>'text','col_width' => '10%','arr_params'=>array('size'=> 40));
	$list_config[] = array('title'=>'Mã bưu phẩm','field'=>'code','ordering'=> 1, 'type'=>'text_cod','col_width' => '10%','arr_params'=>array('size'=> 40));
	$list_config[] = array('title'=>'Ngày chuyển','field'=>'day','ordering'=> 1, 'type'=>'datetime','col_width' => '10%','arr_params'=>array('size'=> 40));
	$list_config[] = array('title'=>'Trạng thái','field'=>'status','ordering'=> 1, 'type'=>'edit_selectbox','col_width' => '13%','arr_params'=>array('arry_select'=>$array_obj_status,'field_value'=>'id','field_label'=>'name','size'=>1));
	$list_config[] = array('title'=>'Thu tiền','field'=>'take','ordering'=> 1, 'type'=>'edit_selectbox','col_width' => '13%','arr_params'=>array('arry_select'=>$array_obj_money,'field_value'=>'id','field_label'=>'name','size'=>1));
    //$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','arr_params'=>array('search'=>'/original/','replace'=>'/resized/'));
	//$list_config[] = array('title'=>'Category','field'=>'category_name','ordering'=> 1, 'type'=>'text','arr_params'=>array('arry_select'=>$categories,'field_value'=>'id','field_label'=>'treename','size'=>10));
 //    $list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	// $list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	$list_config[] = array('title'=>'Edit','type'=>'edit');
	// $list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
