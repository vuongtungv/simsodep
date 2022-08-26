<?php 
	$params = array (
		'suffix' => array(
					'name' => 'Hậu tố',
					'type' => 'text',
					'default' => '_news_list'
		),
		'limit' => array(
					'name' => 'Giới hạn',
					'type' => 'text',
					'default' => '6'
		),
		'type' => array(
					'name'=>'Lấy theo',
					'type' => 'select',
					'value' => array(
										'ordering'=>'Theo thứ tự ordering',
                                        'auto'=> 'Mới nhất',
                                        'ramdom'=>'Ngẫu nhiên',
                                        'home'=>'Tin trang chủ',
                                        'marquee' =>'Marquee top'
                                        //'home'=>'Hiển thị trang chủ'
                                    ),
//					'attr' => array('multiple' => 'multiple'),
		),
        //'limit_video' => array(
//					'name' => 'Giới hạn video',
//					'type' => 'text',
//					'default' => '6'
//		),  			
		'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array(
                                    'default' => 'Mặc định',
                                    'home' => 'Show home',
                                    'marquee' =>'Marquee top'
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
						FROM fs_news_categories 
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