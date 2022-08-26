<?php 
	class DepartmentModelsDepartment extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'department';
			$this -> table_name = FSTable_ad::_('fs_department');
            // config for save
			$cyear = date('Y');
			$cmonth = date('m');
			//$cday = date('d');
			$this -> img_folder = 'images/address/'.$cyear.'/'.$cmonth;
			$this -> check_alias = 1;
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
						  	fs_department AS a
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}
		
		function save($row = array(), $use_mysql_real_escape_string = 1){
			$name = FSInput::get('name');
			if(!$name)
				return false;
                	
			$alias= FSInput::get('alias');
			$fsstring = FSFactory::getClass('FSString','','../');
			if(!$alias){
				$row['alias'] = $fsstring -> stringStandart($name);
			} else {
				$row['alias'] = $fsstring -> stringStandart($alias);
			}
			$row['latitude'] = FSInput::get('latitude');
			$row['longitude'] = FSInput::get('longitude');
			$id = FSInput::get('id',0,'int');
            
            $show_contact = FSInput::get('show_contact');
            //if(isset($show_contact ) && $show_contact != 0)
			//{
				//$rs = $this -> _update_column('fs_address', 'show_contact','0');
			//}
			// remove other_image
			if(!$this -> remove_other_images($id))
				return false;
			// upload other_imge
			
			//if(!$this->upload_other_images($id))
			//{
				//Errors::setError('Can not upload other_image');
			//}
			return parent::save($row);
		}
		function remove(){
			$img_paths = array();
			$path_original =  PATH_IMG_ADDRESS.'original'.DS;
			$path_resize =  PATH_IMG_ADDRESS.'resized'.DS; //142x100
			$path_large =  PATH_IMG_ADDRESS.'large'.DS; //309x219
			$img_paths[] = $path_original;
			$img_paths[] = $path_resize;
			$img_paths[] = $path_large;
			return parent::remove('image',$img_paths);
		}
		
		/*
		 * value: == 1 :hot
		 * value  == 0 :unhot
		 * published record
		 */
		function hot($value)
		{
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
							SET is_hot = $value
						WHERE id IN ( $str_ids ) " ;
				$db->query($sql);
				$rows = $db->affected_rows();
				return $rows;
			}
			return 0;
		}
        
		//function upload_other_images($product_id)
//		{
//			global $db;
//			$fsFile = FSFactory::getClass('FsFiles','');
//			for($i = 0 ; $i < 5; $i ++)
//			{
//				$upload_area   = "other_image_".$i;
//				if($_FILES[$upload_area]["name"])
//				{
//					// upload
////					$path =  PATH_IMG_PRODUCTS.$category_alias.'/original'.DS;
//					$path =  PATH_IMG_ADDRESS.'/original'.DS;
//					$image = $fsFile -> uploadImage($upload_area, $path ,2000000, '_'.time());
//					if(	!$image)
//						return false;
//					
//					// rezise to standart : 300x175
////					$path_crop =  PATH_IMG_PRODUCTS.$category_alias.'/resized'.DS;
//					$path_crop =  PATH_IMG_ADDRESS.'/resized'.DS;
//					if(!$fsFile ->resize_image($path.$image, $path_crop.$image,130, 130))
//					{
//						return false;
//					}
//					
//					$path_resize = PATH_IMG_ADDRESS.'large'.DS;
//					if(!$fsFile ->resize_image($path.$image, $path_resize.$image,770, 500))
//						return false;
//					
//				// rezise to medium : 356x356
//				$path_resize = PATH_IMG_ADDRESS.'medium'.DS;
//				if(!$fsFile ->resize_image($path.$image, $path_resize.$image,245, 208))
//					return false;
//						
//					// rezise to standart : 70x70
//					$path_small = PATH_IMG_ADDRESS.'small'.DS;
//					if(!$fsFile ->resize_image($path.$image, $path_small.$image,70,70)){
//						return false;
//					}
//					
//					
//					$sql = " INSERT INTO fs_showroom_images
//								(address_id,image)
//								VALUES ('$product_id','$image')
//								";
////					print_r($sql);exit;
//					$db->query($sql);
//					if(!$db->insert())
//						return false;		
//				}		
//			}
//			return true;
//		}
		function get_showroom_images($address_id){
			if(!$address_id)
				return;
			$query   = " SELECT image,id 
						FROM fs_showroom_images
						WHERE address_id = $address_id";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function remove_other_images($add_id)
		{
			if(!$add_id)
				return true;
			$other_images_remove = FSInput::get('other_image',array(),'array');
			$str_other_images = implode(',',$other_images_remove);
			if($str_other_images)
			{
				global $db;
				
				// remove images in folder contain these images
				$query   = " SELECT image 
						FROM fs_showroom_images
						WHERE address_id = $add_id
						AND id IN ($str_other_images)
						";
				$sql = $db->query($query);
				$images_need_remove = $db->getObjectList();
				
				$fsFile = FSFactory::getClass('FsFiles','');
				foreach ($images_need_remove as $item) {
					if($item->image)
					{
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'original'.DS);
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'resized'.DS);
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'large'.DS);
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'medium'.DS);
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'small'.DS);
						
					}
				}
				
				// remove in database
				$sql = " DELETE FROM fs_showroom_images
						WHERE address_id = $add_id
							AND id IN ($str_other_images)" ;
				$db->query($sql);
				$rows = $db->affected_rows();
				return $rows;
			}
			return true;
		}
	}
	
?>