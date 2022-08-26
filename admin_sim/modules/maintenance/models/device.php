<?php 
	class MaintenanceModelsDevice extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$limit = 100;
			$this -> view = 'maintenance_device';
			$this->limit = $limit;
			$this -> table_name = 'fs_maintenance_device';
            $this -> table_maintenance = 'fs_maintenance';
            
            $this -> arr_img_paths = array(array('resized',270,146,'resize_image'));
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			//$cday = date('d');
			$this -> img_folder = 'images/maintenance/device/'.$cyear.'/'.$cmonth;
			$this -> check_alias = 1;
			$this -> field_img = 'image';
            
			parent::__construct();
            //$this -> array_synchronize = array('fs_schedules'=>array('id'=>'user_id','username'=>'user_name','full_name'=>'full_name','sex'=>'sex'
                                                                       // ,'address'=>'address','level'=>'level','email'=>'email','mobilephone'=>'mobilephone'));                                  
		}
		
		
		function setQuery()
		{
			// ordering
			$ordering = "";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			$where = "  WHERE 1=1 ";
			
            // from
			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d H:i:s',$date_from);
					$where .= ' AND a.created_time >=  "'.$date_new.'" ';
				}
			}
			
			// to
			if(isset($_SESSION[$this -> prefix.'text1']))
			{
				$date_to = $_SESSION[$this -> prefix.'text1'];
				if($date_to){
					$date_to = $date_to . ' 23:59:59';
					$date_to = strtotime($date_to);
					$date_new = date('Y-m-d H:i:s',$date_to);
					$where .= ' AND a.created_time <=  "'.$date_new.'" ';
				}
			}
            
			if(isset($_SESSION[$this -> prefix.'keysearch'])){
				$keysearch = $_SESSION[$this -> prefix.'keysearch'];
				if($keysearch){
					$where .= " AND ( a.username LIKE '%".$keysearch."%' OR a.full_name LIKE '%".$keysearch."%' OR a.id LIKE '%".$keysearch."%' )
										";
				}
           
			}
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a "
						 .$where.
						 $ordering. " ";
			return $query;
		}

		function save(){
			
		}
		
		/*
		 * Createa folder when create user
		 */
		function create_folder_upload($id){
			$fsFile = FSFactory::getClass('FsFiles','');
			$path = PATH_BASE.'uploaded'.DS.'estores'.DS.$id;
			return $fsFile->create_folder($path);
		}
		
 	
	}
	
	
?>