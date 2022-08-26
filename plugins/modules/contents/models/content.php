<?php 
	class ContentsModelsContent extends FSModels
	{
		function __construct()
		{
		
			$fstable = FSFactory::getClass('fstable');
			$this->table_name  = $fstable->_('fs_contents');
			$this->table_category  = $fstable->_('fs_contents_categories');
		}


		/*
		 * get Article
		 */
		function get_data()
		{
			$id = FSInput::get('id',0,'int');
			if($id){
				$where = " AND id = '$id' ";				
			} else {
				$code = FSInput::get('code');
				if(!$code)
					die('Not exist this url');
				$where = " AND alias = '$code' ";
			}
			$fs_table = FSFactory::getClass('fstable');
			$query = " SELECT id,title,image,source,content,category_id,category_id_wrapper,category_alias,category_name, summary, alias, created_time, updated_time,seo_title,seo_keyword,seo_description
						FROM ".$fs_table -> getTable('fs_contents')." 
						WHERE published = 1 AND category_published = 1
						".$where." ";
			global $db;
		$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
	}
	
?>