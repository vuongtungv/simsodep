<?php 
//module_view_task
$config_module['enterprises_home'] = array(
	// Thông số này giúp cho các trang không nhập được  SEO như trang "trang chủ sp, trang chủ tin tức,...)
	'seo_special' => 1,
	'params' => array (	
		'limit' => array(
			'name' => 'Giới hạn',
			'type' => 'text',
			'default' => '6'
		)
	)
);

$config_module['enterprises_cat'] = array(
	// Các trường hỗ trợ cho lấy SEO TITLE
	'fields_seo_title' => 
		array('fields'=>	array('seo_title'=>'Seo Title','name'=>'Tên danh mục'),
				'help'=> 'Cấu hình cho Seo Title. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),
	'fields_seo_keyword'=> 
		array('fields'=> array('seo_keyword'=>'Seo Keyword','name'=>'Tên danh mục'),
				'help'=> 'Cấu hình cho Seo Title. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),
	'fields_seo_description' => 
		array('fields'=> array('seo_description'=>'Seo Description','name'=>'Tên danh mục'),
			'help'=> 'Cấu hình cho thẻ Meta keywword. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),	
	'params' => array (	
		'limit' => array(
			'name' => 'Giới hạn',
			'type' => 'text',
			'default' => '6'
		),

	),
);


/*
 * Hàm liệt kê danh sách cách phương thức resize ảnh
 */
function get_method_resized_image(){
	return array('cropImge' => 'Crop ảnh', // crop ảnh
				'cut_image' => 'Cắt ảnh', // chém ảnh cho vừa khít
				'resize_image' => 'Resize ảnh',// nguyên tỉ lệ, thêm khoảng trắng
				'resized_not_crop' => 'Resize không crop',// bóp méo ảnh
		);
}
?>