<?php 
	class ContentsModelsContent extends FSModels
	{
		function __construct()
		{
		
			$fstable = FSFactory::getClass('fstable');
			$this->table_name  = $fstable->_('fs_contents');
			$this->table_category  = $fstable->_('fs_contents_categories');
            $this -> table_add = $fstable->_('fs_address');
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
			$query = " SELECT id,title,image,source,content,category_id,category_id_wrapper,category_alias,category_name,
                                summary, alias, created_time, updated_time,seo_title,seo_keyword,seo_description,show_map,tags
						FROM ". $fs_table -> getTable('fs_contents') ." 
						WHERE published = 1 AND category_published = 1
						".$where ;
			global $db;
		$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
        
        function get_address_list(){
			$query = ' select * from '. $this -> table_add.' where published = 1 AND show_contact = 0';
			global $db;
			$sql = $db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
        
        function getRelateNewsList($cid)
		{
			if(!$cid)
				die;
			$code = FSInput::get('code');	
			$where = '';
			if($code){
				$where .= " AND alias <> '$code' ";
			} else {
				$id = FSInput::get('id',0,'int');
				if(!$id)
					die('Not exist this url');
				$where .= " AND id <> '$id' ";
			}
			
			global $db;
			$limit = 10;
			$fs_table = FSFactory::getClass('fstable');
			
			$query = " SELECT id,title,alias, category_id,updated_time ,image,category_alias
						FROM ". $this->table_name ."
						WHERE alias <> '".$code."'
							AND category_id = $cid
							AND published = 1
							".$where."
						ORDER BY  id DESC, ordering DESC
						LIMIT $limit
						";
			$db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
	}
	
?>