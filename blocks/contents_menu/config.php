<?php 
	$params = array (
		'suffix' => array(
					'name' => 'Hậu tố',
					'type' => 'text',
					'default' => '_contents_menu'
					),
                    
        'limit' => array(
					'name' => 'Giới hạn',
					'type' => 'text',
					'default' => '6'
					),
                    
		'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array('default' => 'Mặc định')
			),
            
        'category_id' => array(
					'name'=>'Nhóm danh mục',
					'type' => 'select',
					'value' => get_category(),
					'attr' => array('multiple' => 'multiple'),
			),
	);
    
    function get_category(){
		global $db;
			$query = " SELECT name, id 
						FROM fs_contents_categories 
						";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			if(!$result)
			     return;
			$arr_group = array();
            foreach($result as $item){
            	$arr_group[$item -> id] = $item -> name;
            }
			return $arr_group;
	}
?>