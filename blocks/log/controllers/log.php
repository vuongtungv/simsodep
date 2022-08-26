<?php

	class LogBControllersLog
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			
			$style = $parameters->getParams('style');
			$style = $style?$style:'default';
            
            //$contents_id = $parameters->getParams('contents_id');
            
            $id = FSInput::get('id',0,'int');
            $module = FSInput::get('module');
 
      
			$list_menu = array(
				FSText::_('Thông tin tài khoản') => FSRoute::_(''),
				FSText::_('Đổi mật khẩu') => FSRoute::_(''),
				FSText::_('Thống kê trắc nghiệm') => FSRoute::_(''),
				FSText::_('Thoát') => 'index.php?module=users&task=logout',
	
			);
   
			include 'blocks/log/views/log/'.$style.'.php';
		}
        
	}

?>
