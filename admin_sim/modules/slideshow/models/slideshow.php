<?php 
	class SlideshowModelsSlideshow extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'slideshow';
			
//			$this -> arr_img_paths = array(array('slideshow_large',672,259,'resized_not_crop'));
			$this -> table_name = FSTable_ad::_('fs_slideshow');
            $this -> table_categories = FSTable_ad::_('fs_slideshow_categories');
			
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
			$this -> img_folder = 'images/slideshow/'.$cyear.'/'.$cmonth.'/'.$cday;
			$this -> check_alias = 0;
			$this -> field_img = 'image';
			$this -> arr_img_paths_thumb = array(array('small',128,50,'resized_not_crop'));
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
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
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
		function  save($row = array(),$use_mysql_real_escape_string = 0){
			$category_id = FSInput::get('category_id',0,'int');
			$category = $this -> get_record_by_id($category_id,$this -> table_categories);
			$width_large =  $category -> width;
			$height_large =  $category -> height;
			$width_small =  $category -> width_small;
			$height_small =  $category -> height_small;
			$arr_img_paths = array(array('slideshow_large',$width_large,$height_large,'resized_not_crop'));
			if($width_small || $height_small){
				$arr_img_paths[] = array('slideshow_small',$width_small,$height_small,'resized_not_crop');
			}
			$this -> arr_img_paths = $arr_img_paths; 
            
			$image_name_thumb = $_FILES["image_thumb"]["name"];
    		if($image_name_thumb){
    			$image_thumb = $this->upload_image('image_thumb','_'.time(),2000000,$this -> arr_img_paths_thumb);
    			if($image_thumb){
    				$row['image_thumb'] = $image_thumb;
    			}
    		}

            $cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
            
            $path = PATH_BASE.'images'.DS.'slideshow'.DS.$cyear.DS.$cmonth.DS.$cday.DS;
            require_once(PATH_BASE.'libraries'.DS.'upload.php');
            $upload = new  Upload();
            $upload->create_folder ( $path );
            
            $file_upload = $_FILES["video"]["name"];
			if($file_upload){
                //$name = $_FILES['video']['name'];
                $type_video = explode('.', $file_upload);
                $type_video = end($type_video);
                //$random = rand();
                $tmp = $_FILES['video']['tmp_name']; 
                //var_dump($_FILES['video']);die;
                if($type_video != "mp4")
                {
                    echo "File Format Not Suppoted";
                }else{
                     move_uploaded_file($tmp,$path.$file_upload);
                }  
                $row['video'] = 'images/slideshow/'.$cyear.'/'.$cmonth.'/'.$cday.'/'.$file_upload;
			}
            
			return parent::save($row);
		}
		
		/*
		 * select in category of home
		 */
		function get_categories()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	". $this -> table_categories ." AS a
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
	}
?>