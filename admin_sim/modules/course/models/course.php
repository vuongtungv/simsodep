<?php 
	class CourseModelsCourse extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 30;
			$this -> view = 'course';
			$this -> arr_img_paths = array(
                                    //array('resized',420,252,'resize_image'),
                                    array('small',265,160,'resize_image')
                                );
			$this -> table_category_name = FSTable_ad::_('fs_course_category');
            $this -> table_name = FSTable_ad::_('fs_course');
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			//$cday = date('d');
			$this -> img_folder = 'images/course/'.$cyear.'/'.$cmonth;
			$this -> check_alias = 0;
			$this -> field_img = 'image';
			
			parent::__construct();
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "";
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
					$where .= ' AND a.course_id = '.$filter.' ';
				}
			}	
			
			if(!$ordering)
				$ordering .= " ORDER BY date_created DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.coursename LIKE '%".$keysearch."%' ";
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
		
		function save($row = array(), $use_mysql_real_escape_string = 1){
			$name = FSInput::get('name');		
			if(!$name)
				return false;
			$id = FSInput::get('id',0,'int');	
			$course_id = FSInput::get('course_id',0,'int');
			if(!$course_id){
				Errors::_('Bạn phải chọn nhóm danh mục');
				return;
			}
			
			$cat =  $this->get_record_by_id($course_id,$this -> table_category_name);
			$row['course_category'] = $cat -> name;
         	
         	$row['coursename'] = $name;
         	$row['summary'] = FSInput::get('summary');
			// $row['content'] = htmlspecialchars_decode(FSInput::get('content'));
			$time = date('Y-m-d H:i:s');

            if($id){
        		$row['lastedit_date'] 	= $time;
				$row['lastedit_id'] 	= $_SESSION['ad_userid'];
				$row['lastedit_name'] 	= $_SESSION['ad_username'];
        	}else{
    			$row['date_created'] 	= $time;
				$row['creator_id'] 		= $_SESSION['ad_userid'];
				$row['creator_name'] 	= $_SESSION['ad_username'];
        	}
			
			$image_name_image = $_FILES["image"]["name"];
    		if($image_name_image){
    			$image_image = $this->upload_image('image','_'.time(),2000000,$this -> arr_img_paths);
    			if($image_image){
    				$row['image'] = $image_image;
    			}
    		}

    		$cyear = date ( 'Y' ); 
    		$path = PATH_BASE.'images'.DS.'upload_file'.DS.$cyear.DS;
            require_once(PATH_BASE.'libraries'.DS.'upload.php');
            $upload = new Upload();
            $upload->create_folder ( $path );

    		$file_upload = $_FILES["file"]["name"];
			if($file_upload){
				$path_original = $path;
				// remove old if exists record and img
				if($id){
					$img_paths = array();
					$img_paths[] = $path_original;
				}
				$fsFile = FSFactory::getClass('FsFiles');
				// upload
				$file_upload_name = $fsFile -> upload_file("file", $path_original ,50000000, '_'.time());
				if(!$file_upload_name)
					return false;
				$row['file'] = 'images/upload_file/'.$cyear.'/'.$file_upload_name;
			}

			$rs = parent::save($row);
            return $rs;
		}
        
		/*
		 * select in category of home
		 */
		function get_categories_tree()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_category_name." AS a
						  	ORDER BY ordering ";         
			$sql = $db->query($query);
			$list = $db->getObjectList();
			// $tree  = FSFactory::getClass('tree','tree/');
			// $list = $tree -> indentRows2($result);
			return $list;
		}
		
	}
	
?>