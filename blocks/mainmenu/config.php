<?php 
	$params = array (
		'suffix' => array(
					'name' => FSText::_('Hậu tố'),
					'type' => 'text',
					'default' => '_mainmenu'
					),
		'limit' => array(
					'name' => FSText::_('Giới hạn'),
					'type' => 'text',
					'default' => '6'
					),
			
		'style' => array(
					'name'=> FSText::_('Kiểu Style'),
					'type' => 'select',
					'value' => array(
                                    'default' => FSText::_('Mặc định'),
                                    'link_menu'=> 'Menu Liên kết',
                                    'default_news' => FSText::_('Tư vấn tuyển sinh'),
                                    'bottom' => FSText::_('Menu bottom dưới footer'),
                                    'responsive'=> FSText::_('Menu mặc định responsive'),
                                    //'contents'=> FSText::_('Menu giới thiệu click'),
                                    //'contents2'=> FSText::_('Menu giới thiệu show'),
                                    //'main_activities'=> FSText::_('Các hoạt động chính')
                                    )
		),
        'group' => array(
					'name'=>FSText::_('Nhóm menu'),
					'type' => 'select',
					'value' => get_category(),
					//'attr' => array('multiple' => 'multiple'),
		 ),
         
         'contents_id' => array(
					'name'=>'Bài viết',
					'type' => 'select',
					'value' => get_contents(),
					'attr' => array('multiple' => 'multiple'),
		),   

	);
    
    function get_category(){
            $fstable  = FSFactory:: getClass('fstable');
			$table_name = 'fs_menus_groups';
            
		    global $db;
			$query = ' SELECT group_name, id
						FROM '.$table_name.'
						WHERE published = 1 ';
			$sql = $db->query($query);
			$result = $db->getObjectList();
			if(!$result)
			     return;
			$arr_group = array();
            foreach($result as $item){
            	$arr_group[$item -> id] = $item -> group_name;
            }
			return $arr_group;
	}
    
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