<?php 
	$params = array (
		'suffix' => array(
					'name' => 'Hậu tố',
					'type' => 'text',
					'default' => '_newsmenu'
					),
		'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array(
                                    'default' => 'Mặc định',
                                    'responsive' => 'Responsive',
//                                    'myphamhanquoc'=>'kiểu 2'
                                    )
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
						FROM fs_news_categories WHERE parent_id = 0
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