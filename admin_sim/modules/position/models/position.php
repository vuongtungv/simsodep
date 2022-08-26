<?php 
	class PositionModelsPosition extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'position';
			$this -> table_name = FSTable_ad::_('fs_position');
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
						  	fs_position AS a
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}
		
		function save($row = array(), $use_mysql_real_escape_string = 1){
			$name = FSInput::get('name');
			if(!$name)
				return false;

			$cid = parent::save($row,0);;

			// remove
			if (! $this->remove_commission ( $cid )) {
				//				return false;
			}
			// edit
			if (! $this->save_exist_commission ( $cid )) {
				//				return false;
			}
			// save new
			if (! $this->save_new_commission ( $cid )) {
			}
              
			return parent::save($row);
		}

		function save_exist_commission($id) {
		global $db;
		// EXIST FIELD
		$commissions_exist_total = FSInput::get ( 'commissions_exist_total' );
		
		$sql_alter = "";
		$arr_sql_alter = array ();
		$rs = 0;

		for($i = 0; $i < $commissions_exist_total; $i ++) {
			
			$id_exist = FSInput::get ( 'id_exist_' . $i );
			
			$price_f_exist = FSInput::get ( 'price_f_exist_' . $i );
			$price_f_exist_begin = FSInput::get ( 'price_f_exist_' . $i . "_original" );
			
			$price_t_exist = FSInput::get ( 'price_t_exist_' . $i );
			$price_t_exist_begin = FSInput::get ( 'price_t_exist_' . $i . "_original" );
			
			$commission_exist = FSInput::get ( 'commission_exist_' . $i );
			$commission_exist_begin = FSInput::get ( 'commission_exist_' . $i . "_original" );
			
			$commission_unit_exist = FSInput::get ( 'commission_unit_exist_' . $i );
			$commission_unit_exist_begin = FSInput::get ( 'commission_unit_exist_' . $i . "_original" );

			$commission_type_exist = FSInput::get ( 'commission_type_exist_' . $i );
			$commission_type_exist_begin = FSInput::get ( 'commission_type_exist_' . $i . "_original" );
			
			$ordering_exist = FSInput::get('ordering_exist_'.$i);
			$ordering_exist_begin = FSInput::get('ordering_'.$i.'_original');
			

			if (($price_f_exist != $price_f_exist_begin) || ($price_t_exist != $price_t_exist_begin) || ($commission_exist != $commission_exist_begin) || ($commission_unit_exist != $commission_unit_exist_begin) || ($commission_type_exist != $commission_type_exist_begin) || ($ordering_exist != $ordering_exist_begin) ) {
				$sim_price_f =  FSInput::get ( 'price_f_exist_' . $i);
				$sim_price_t= FSInput::get ( 'price_t_exist_' . $i );
				$commission= FSInput::get ( 'commission_exist_' . $i );
				$price_f= $this -> standart_money($sim_price_f);
				$price_t= $this -> standart_money($sim_price_t);
				$commission= $this -> standart_money_commission($commission);
				$row = array ();
				$row ['price_f'] = $price_f;
				$row ['price_t'] =$price_t;
				$row ['price_t'] =$price_t;
				$row ['price_t'] =$price_t;
				$row ['commission'] =$commission;
				$time = date('Y-m-d H:i:s');
				$row ['update_time'] =$time;
				if (! $row ['price_t'] && ! $row ['price_f']) {
					continue;
				}
				$row ['commission_unit'] = FSInput::get ( 'commission_unit_exist_' . $i );
				$row ['commission_type'] = FSInput::get ( 'commission_type_exist_' . $i );
				$row['ordering'] = $ordering_exist;
				
				$u = $this->_update ( $row, 'fs_member_commissions', ' id=' . $id_exist );
				if ($u)
					$rs ++;
			}
		}
		return $rs;
	
		// END EXIST FIELD
	}
	function standart_money_commission($money){
		$money = str_replace(',','' , trim($money));
		$money = str_replace(' ','' , $money);
//		$money = intval($money);
		$money = (double)($money);
		return $money; 
	}

	function standart_money($money){
		$money = str_replace(',','' , trim($money));
		$money = str_replace(' ','' , $money);
		$money = str_replace('.','' , $money);
//		$money = intval($money);
		$money = (double)($money);
		return $money; 
	}
	/*
		 * remove commission
		 */
	function remove_commission($record_id) {
		if (! $record_id)
			return true;
//		$other_images_remove = FSInput::get ( 'other_commission', array (), 'array' );
//		if (! $other_images_remove)
//			return true;
//		$str_other_commissions = implode ( ',', $other_commissions_remove );
		$other_image_remove = FSInput::get('other_image',array(),'array');
		$str_other_commissions = implode(',',$other_image_remove);
		if ($str_other_commissions) {
			global $db;
			
			// remove in database
			$sql = " DELETE FROM fs_member_commissions
						WHERE price_id = $record_id AND id IN ($str_other_commissions)";
			$db->query ( $sql );
			$rows = $db->affected_rows ();
			return $rows;
		}
		return true;
	}
	
	/*
		 * Add commission
		 */
	function save_new_commission($record_id) {
		global $db;
		for($i = 0; $i < 50; $i ++) {
			$row = array ();

			$sim_price_f = FSInput::get ( 'new_price_t_' . $i );
			$sim_price_t = FSInput::get ( 'new_price_f_' . $i );
			$commission = FSInput::get ( 'new_commission_' . $i );
			$ordering = FSInput::get ( 'new_ordering_' . $i );

			$price_f= $this -> standart_money($sim_price_f);
			$price_t= $this -> standart_money($sim_price_t);
			$commission= $this -> standart_money_commission($commission);

			$row ['price_t'] = $price_f;
			$row ['price_f'] = $price_t;
			$row ['ordering'] = $ordering;
			$row ['commission'] = $commission;
			$row ['commission_unit'] = FSInput::get ( 'new_commission_unit_' . $i );
			$row ['commission_type'] = FSInput::get ( 'new_commission_type_' . $i );
			$time = date('Y-m-d H:i:s');
			$row ['created_time'] =$time;
			if (! $row ['price_t'] && ! $row ['price_f']) {
				continue;
			}
			$row ['price_id'] = $record_id;
			$row ['published'] = 1;
			$rs = $this->_add ( $row, 'fs_member_commissions', 0 );
		}
		return true;
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