<?php 
	$params = array (
		'suffix' => array(
					'name' => 'Hậu tố',
					'type' => 'text',
					'default' => 'schedule_'
					),
                    
        'limit' => array(
					'name' => 'Giới hạn',
					'type' => 'text',
					'default' => '1'
					),
        'type' => array(
					'name'=>'Lấy theo',
					'type' => 'select',
					'value' => array('auto'=>'Tự động lấy tin mới nhất','ramdom'=>'Ngẫu nhiên'),
//					'attr' => array('multiple' => 'multiple'),
			         ),            
		'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array('default' => 'Hiển thị trang chủ')
			),
            
	);