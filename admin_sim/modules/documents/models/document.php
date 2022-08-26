<?php 
	class DocumentsModelsDocument extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'document';
			$this -> table_name = FSTable_ad::_('fs_documents');

			$this -> arr_img_paths = array(array('small',265,160,'resize_image'));
			$cyear = date('Y');
			$cmonth = date('m');
			//$cday = date('d');
			$this -> img_folder = 'images/document/'.$cyear.'/'.$cmonth;
			$this -> check_alias = 0;
			$this -> field_img = 'image';

			parent::__construct();
		}

		function setQuery(){
			
			// ordering
			$ordering = "";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, date_created DESC, id DESC";
					
			}
			if(!$ordering)
				$ordering .= " ORDER BY date_created DESC , id DESC ";
			
			$where = "  ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.title LIKE '%".$keysearch."%'  OR a.coursename LIKE '%".$keysearch."%'";
				}
			}
			 if (isset($_SESSION[$this->prefix . 'filter0'])) {
	            $filter = $_SESSION[$this->prefix . 'filter0'];
	            if ($filter) {
	                $where .= ' AND a.filetype = '. $filter .' ';
	            }
	        }
			

            $query = " SELECT a.*
						  FROM 
						  	" . $this->table_name . " AS a
						  	WHERE 1=1 " . $where . $ordering . " ";
//						echo $query;
			return $query;
		}
		function getMenuItems() {
			$query = " SELECT id,coursename as name, parent_id
					  	FROM fs_course
				  		WHERE 1=1"
					  	;
			global $db;
			$sql = $db->query ( $query );
			$menus_item = $db->getObjectList ();
			//print_r($menus_item);die;
			$fstree = FSFactory::getClass ( 'tree', 'tree/' );
			$list = $fstree->indentRows ( $menus_item, 3 );

			return $list;
		}
        function save($row = array(), $use_mysql_real_escape_string = 1){
			// file downlaod
            global $db;
            $time = date("Y-m-d H:i:s");
            $row['date_created'] = $time;
			return parent::save($row);
		}


	}
	
?>