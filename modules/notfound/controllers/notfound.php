<?php
/*
 * Huy write
 */
	// controller
	
	class NotfoundControllersNotfound extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
            $breadcrumbs = array();
            $breadcrumbs[] = array(0=> FSText::_('404 Error'));
            global $tmpl;
            $tmpl -> assign('breadcrumbs', $breadcrumbs);
//            $tmpl -> set_seo_special();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
	}
	
?>