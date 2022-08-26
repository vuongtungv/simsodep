<?php 
	class SlideshowModelsCategories extends FSModels
	{
		function __construct()
		{
			$this -> limit = 20;
			
			$this -> table_items = FSTable_ad::_('fs_slideshow');
			$this -> table_name = FSTable_ad::_('fs_slideshow_categories');
            
			$this -> check_alias = 1;
//			$this -> call_update_sitemap = 1;
			
			parent::__construct();
		}
	}
	
?>