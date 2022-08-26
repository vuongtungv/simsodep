<?php 
	class SimModelsCategories extends FSModels
	{
		function __construct()
		{
			
			$this -> table_name = FSTable_ad::_('fs_network');
			$this -> call_update_sitemap = 1;

			parent::__construct();
			$this -> limit = 100;
		}
        

	}
	
?>