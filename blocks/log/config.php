<?php
	$params = array (
		'suffix' => array(
					'name' => FSText::_('Hậu tố'),
					'type' => 'text',
					'default' => '_log'
		),

		'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array(
                    'default' => FSText::_('cá nhân'),
                    'default_seeker_left'=>FSText::_('Menu chức năng thí sinh(bên trái)'),
                    'default_employer_left'=>FSText::_('Menu chức năng NĐT quản lý TS(bên trái)'),
                    'employer'=> FSText::_('nhà đào tạo'),
					'nav_employer'=>FSText::_('Menu chức năng nhà tạo'),
					'nav_employer_responsive'=>FSText::_('Menu chức năng nhà tạo responsive'),
					'nav_employer_left'=>FSText::_('Menu chức năng nhà tạo(bên trái)'),
					'log_responsive_ts'=>FSText::_('Menu chức năng log_responsive thí sinh'),
					'log_responsive_ndt'=>FSText::_('Menu chức năng log_responsive nhà đào tạo')
                    )
		),
        
        'contents_id' => array(
					'name'=>'Bài viết',
					'type' => 'select',
					'value' => get_contents(),
					'attr' => array('multiple' => 'multiple'),
		),   

	);

function get_contents(){
        $fstable  = FSFactory:: getClass('fstable');
		$table_name = $fstable->_('fs_contents');
        
	    global $db;
		$query = ' SELECT title, id 
					FROM '.$table_name.' 
					';
		$sql = $db->query($query);
		$result = $db->getObjectList();
		if(!$result)
		     return;
		$arr_group = array();
        foreach($result as $item){
        	$arr_group[$item -> id] = $item -> title;
        }
		return $arr_group;
}
?>
