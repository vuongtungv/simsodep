<?php 
	$params = array (
		'suffix' => array(
					'name' => 'Hậu tố',
					'type' => 'text',
					'default' => '_content_home'
					),
                    
        'limit' => array(
					'name' => 'Giới hạn',
					'type' => 'text',
					'default' => '1'
					),
        'type' => array(
					'name'=>'Lấy theo',
					'type' => 'select',
					'value' => array('auto'=>'Tự động lấy tin mới nhất','ramdom'=>'Ngẫu nhiên','home'=>'Hiển thị trang chủ'),
//					'attr' => array('multiple' => 'multiple'),
			         ),            
		'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array('default' => 'Hiển thị trang chủ')
			),
            
        'category_id' => array(
					'name'=>'Danh mục',
					'type' => 'select',
					'value' => get_categories(),
//					'attr' => array('multiple' => 'multiple'),
			),
	);
function get_categories(){
	global $db;
	$query = " SELECT name, id
						FROM fs_contents_categories
						ORDER By ordering, id
						";
	$db->query($query);
	$list = $db->getObjectList();
	if(!$list)
	     return;
	$arr_group = array();
    foreach($list as $item){
        $arr_group[$item -> id] = $item -> name;
    }
	return $arr_group;
}
?>