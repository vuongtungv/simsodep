<?php 
//module_view_task

$config_module['search_serial'] = array(
	// Thông số này giúp cho các trang không nhập được  SEO như trang "trang chủ sp, trang chủ tin tức,...)
	'seo_special' => 1,
	'params' => array (	
		'limit' => array(
			'name' => 'Giới hạn',
			'type' => 'text',
			'default' => '6'
		),
		'descriptions_serial' => array(
			'name' => 'Mô tả',
			'type' => 'textarea',
			'default' => '',
		),
	)
);
$config_module['search_warranty'] = array(
	// Thông số này giúp cho các trang không nhập được  SEO như trang "trang chủ sp, trang chủ tin tức,...)
	'seo_special' => 1,
	'params' => array (	
		'limit' => array(
			'name' => 'Giới hạn',
			'type' => 'text',
			'default' => '6'
		),
		'descriptions_warranties' => array(
			'name' => 'Mô tả',
			'type' => 'textarea',
			'default' => '',
		),
	)
);
?>