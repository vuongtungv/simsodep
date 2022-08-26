<?php 
	class EnterprisesModelsCategories extends ModelsCategories
	{
		function __construct()
		{
			
			$this -> table_items = 'fs_enterprises';
			$this -> table_name = 'fs_enterprises_categories';
			$this -> check_alias = 1;
			$this -> call_update_sitemap = 1;
			
			// exception: key (field need change) => name ( key change follow this field)
			$this -> field_except_when_duplicate = array(array('list_parents','id'),array('alias_wrapper','alias'));
			parent::__construct();
			$this -> limit = 100;
            
           // $this -> array_synchronize = array($this -> table_items=>array('id'=>'category_id','alias'=>'category_alias','name'=>'category_name'
//                                                                            ,'published'=>'published_cate','alias_wrapper'=>'category_alias_wrapper'));
		}
	}
	
?>