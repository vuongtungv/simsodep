<?php 
	class CourseModelsCategories extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$limit = 20;
			$this -> view = 'categories';
			$this->limit = $limit;
			$this -> table_name = 'fs_course_category';
			$this -> check_alias = 1;
			parent::__construct();
		}
			
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, date_created DESC, id DESC ";
			}
			
			// estore
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.category_id_wrapper like  "%,'.$filter.',%" ';
				}
			}	
			
			if(!$ordering)
				$ordering .= " ORDER BY date_created DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}

		function save($row = array(),$use_mysql_real_escape_string = 0) 
		{
			$id = FSInput::get ( 'id', 0, 'int' );

			$user_id = $_SESSION['ad_userid'];
            $username = $_SESSION['ad_username'];
            if (!$id) {
                $row['creator_id'] 		= $user_id;
                $row['creator_name'] 	= $username;
                $row['date_created'] 	= date('Y-m-d H:i:s');
            } else {
                $row['lastedit_id'] 	= $user_id;
                $row['lastedit_name'] 	= $username;
                $row['lastedit_date'] 	= date('Y-m-d H:i:s');
            }

			// $image_name_icon = $_FILES["icon"]["name"];
   //  		if($image_name_icon){
   //  			$image_icon = $this->upload_image('icon','_'.time(),2000000,$this -> arr_img_paths_icon);
   //  			if($image_icon){
   //  				$row['icon'] = $image_icon;
   //  			}
   //  		}

			$id = parent::save ( $row );
			if (! $id) {
				Errors::setError ( 'Not save' );
				return false;
			}

			return $id;
		}
		
		/*
		 * select in category of home
		 */
		function get_categories_tree()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	 ORDER BY ordering ";         
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			return $list;
		}
	}
	
?>