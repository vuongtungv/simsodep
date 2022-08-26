<?php 
	class MaintenanceModelsMaintenance extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$limit = 100;
			$this -> view = 'maintenance';
			$this->limit = $limit;
			$this -> table_name = 'fs_maintenance';
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
					$where .= " AND ( a.name LIKE '%".$keysearch."%' OR a.hotline LIKE '%".$keysearch."%' OR a.id LIKE '%".$keysearch."%' )
										";
				}
           
			}
            
            if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.user_id =  '.$filter ;
				}
			}	
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a "
						 .$where.
						 $ordering. " ";
			return $query;
		}
		
		// ajax load quận/huyện (theo tỉnh thành))
        function ajax_get_product_district($city_id) {
    		if (! $city_id)
    			return;
    		global $db;
    		$query = ' SELECT *
    						FROM fs_districts 
    						WHERE city_id  = '.$city_id
    	             ;
    		$sql = $db->query ( $query );
    		$rs = $db->getObjectList ();
    		return $rs;
    	}
		/******************************** SAVE *****************************************/
		/*
		 * 
		 * Save
		 */
		function save(){
		    global $db;  
            $name = FSInput::get ( 'name' );
        
    		if (! $name) {
    			Errors::_ ( 'You must entere name' );
    			return false;
    		}
    		$id = FSInput::get ( 'id', 0, 'int' );
    		$alias = FSInput::get ( 'alias' );
            
    		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
            //$row ['name'] = mysql_real_escape_string($name);
    		if (! $alias) {
    			$row ['alias'] = $fsstring->stringStandart ( $name );
    		} else {
    		  
    			$row ['alias'] = $fsstring->stringStandart ( $alias );
                
    		}
            
            // category and category_id_wrapper
    		$group_id = FSInput::get ( 'group_id', 0, 'int' );
    		if (! $group_id){
    			Errors::_ ( 'You must select group' );
    			return false;	
    		}
    			
    		$row ['group_id'] = $group_id;
    
            // Huyện / thị xã.
            $city_id = FSInput::get ( 'city_id',0,'int' );
            if($city_id){
                //$cities = $this-> get_record_by_id ( $city_id, 'fs_cities' );
    			$row ['city_id'] = $city_id;
                
        		$district_id = FSInput::get ( 'district_id',0,'int' );
        		if ($district_id) {
        			//$district = $this->get_record_by_id ( $district_id, 'fs_districts' );
        			$row ['district_id'] = $district_id;
        		}
            }
            // upload file_works  
			$cyear = date ( 'Y' ); 
    		$path = PATH_BASE.'images'.DS.'upload_file'.DS.$cyear.DS;
            require_once(PATH_BASE.'libraries'.DS.'upload.php');
            $upload = new  Upload();
            $upload->create_folder ( $path );
            
            $file_upload = $_FILES["file_works"]["name"];
			if($file_upload){
				$path_original = $path;
				$fsFile = FSFactory::getClass('FsFiles');
				// upload
				$file_upload_name = $fsFile -> upload_file("file_works", $path_original ,10000000, '_'.time());
				if($file_upload_name)
                    $row['file_works'] = 'images/upload_file/'.$cyear.'/'.$file_upload_name;
			}
            // END upload file_works  
			return parent::save($row,0);
		}
	
 	
	}
	
	
?>