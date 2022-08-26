<?php 
	class PartnersModelsCategories extends ModelsCategories
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			parent::__construct();
			$limit = FSInput::get('limit',200,'int');
			$this -> limit = $limit;
			$this -> type = 'partners';
			$this -> table_items = FSTable_ad::_('fs_'.$this -> type);
			$this -> table_name = FSTable_ad::_('fs_'.$this -> type.'_categories');
			$this -> check_alias = 1;
			$this->img_folder = 'images/' . $this->type . '/cat';
			$this->field_img = 'image';
			$this -> arr_img_paths = array(array('resized',222,144,'resize_image'));
		}
		
		/*
		 * Show list category of product follow page
		 */
		function get_categories_tree()
		{
			global $db;
			$query = $this->setQuery();
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			$limit = $this->limit;
			$page  = $this->page?$this->page:1;
			
			$start = $limit*($page-1);
			$end = $start + $limit;
			
			$list_new = array();
			$i = 0;
			foreach ($list as $row){
				if($i >= $start && $i < $end){
					$list_new[] = $row;
				}
				$i ++;
				if($i > $end)
					break;
			}
			return $list_new;
		}
		/*
		 * Select all list category of product
		 */
		function get_categories_tree_all()
		{
			global $db;
			$query = $this->setQuery();
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			
			return $list;
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$task = FSInput::get ( 'task' );
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
					
			}
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			$where = "  ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] && $task != 'edit' && $task != 'add')
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND name LIKE '%".$keysearch."%' ";
				}
			}
			
		$query = " SELECT a.*, a.parent_id as parent_id 
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1".
						 $where.
						 $ordering. " ";
						
			return $query;
		}
		
	}
	
?>