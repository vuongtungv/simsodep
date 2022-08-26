<?php 
	$params = array (
		'suffix' => array(
					'name' => 'Hậu tố',
					'type' => 'text',
					'default' => '_fanpage_facebook'
					),
	//	'limit' => array(
//					'name' => 'Giới hạn',
//					'type' => 'text',
//					'default' => '6'
//					),
	//	'type' => array(
//					'name'=>'Lấy theo',
//					'type' => 'select',
//					'value' => array('newest'=> 'Mới nhất','ramdom'=>'Ngẫu nhiên','highlight'=>'Tin hot','grid'=>'Đọc nghiều nhất','home'=>'Hiển thị trang chủ'),
//			),			
		'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array('default' => 'Mặc định')
			),
        //'category_id' => array(
//					'name'=>'Nhóm danh mục',
//					'type' => 'select',
//					'value' => get_category(),
//					'attr' => array('multiple' => 'multiple'),
//			),

	);

?>