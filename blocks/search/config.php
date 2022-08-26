<?php 
	$params = array (
		'suffix' => array(
					'name' => 'Hậu tố',
					'type' => 'text',
					'default' => '_search'
		),
		'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array(
                                    'default' => FSText::_('Tìm kiếm trang danh mục'),
                                    'default_home' => FSText::_('Tìm kiếm trang chủ'),
                                    )
		),
        

	);
?>