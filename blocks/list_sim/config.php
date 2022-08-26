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
										'1'=>'Sim khuyến mãi trong ngày',
                                        '2'=> 'Sim vip',
                                        '3'=>'Sim đề xuất',
                                        '4'=>'Khuyến mãi sim số đẹp trong ngày',
//                                        'marquee' =>'Marquee top'
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
                                    'marquee' =>'Marquee top',
                                    'default_2' =>'Khuyến mãi sim số đẹp'
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