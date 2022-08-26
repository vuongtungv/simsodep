<?php 

	class GalleryModelsVideo extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this->view = 'video';
            $this->type = 'video';
            $this -> table_category_name = FSTable_ad::_('fs_course');
			$this -> table_name = FSTable_ad::_('fs_video');
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
			$this-> arr_img_paths = array (array ('resized',260,150, 'cut_image' ),array ('large',770,435, 'cut_image' ));
			$this -> img_folder = 'images/video/'.$cyear.'/'.$cmonth.'/'.$cday;
			$this -> check_alias = 0;
			$this -> field_img = 'image';
			
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
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
            
            // estore
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.category_id_wrapper like  "%,'.$filter.',%" ';
				}
			}	
            
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND  a.name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  ".$this -> table_name." AS a
						  	WHERE 1=1".
						 $where.
						 $ordering. " ";
						
			return $query;
		}
		function save($row = array(), $use_mysql_real_escape_string = 1){
            global $db; 
            $id = FSInput::get('id',0,'int');
            $cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
    		$path = PATH_BASE.'video'.DS.$cyear.DS.$cmonth.DS.$cday.DS;
            require_once(PATH_BASE.'libraries'.DS.'upload.php');
            $upload = new  Upload();
            $upload->create_folder ( $path );           
            $video = $_FILES["video"]["name"];
			if($video){
				$path_original = $path;
				// remove old if exists record and img
				if($id){
					$img_paths = array();
					$img_paths[] = $path_original;
					// special not remove when update
					// $this -> remove_file($id,$img_paths,'video',$this ->table_name);
				}
				$fsFile = FSFactory::getClass('FsFiles');
				// upload
				$video_name = $fsFile -> upload_media("video", $path_original ,512000, '_'.time());
				if(!$video_name)
					return false;
				$row['video'] = 'video/'.$cyear.'/'.$cmonth.'/'.$cday.'/'.$video_name;
			}

			$course_id = FSInput::get ( 'course_id', 0, 'int' );
			if (!$course_id){
				Errors::_ ( 'You must select course' );
				return false;
			}

			$cat = $this->get_record_by_id ( $course_id, $this-> table_category_name );
			$row ['course_category_id'] = $cat->course_id;
			$row ['course_name'] = $cat->coursename;
            
			return parent::save($row);
		}

		function get_course() {
			global $db;
			$query = " SELECT *
					FROM ".$this -> table_category_name." where active = 1
					ORDER BY ordering ASC";
			global $db;
			$sql = $db->query ( $query );
			$result = $db->getObjectList ();
			return $result;
		}
        	
	}
	
?>