<?php 
	class AqModelsCategories extends ModelsCategories
	{
		function __construct()
		{
			$this -> limit = 20;
			
			$this -> table_items = FSTable_ad::_('fs_aq');
			$this -> table_name = FSTable_ad::_('fs_aq_categories');
			$this -> check_alias = 1;
			$this -> call_update_sitemap = 1;
			//$this -> arr_img_paths = array(array('resized',210,152,'resized_image'),array('small',80,80,'cut_image'));
            $cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
			$this -> img_folder = 'images/aq/cat/'.$cyear.'/'.$cmonth;
			$this -> field_img = 'image';
			// exception: key (field need change) => name ( key change follow this field)
			$this -> field_except_when_duplicate = array(array('list_parents','id'),array('alias_wrapper','alias'));
			parent::__construct();
		}
        
        function save($row = array(), $use_mysql_real_escape_string = 1) {
            $field_img = 'icon';
            $image = $_FILES[$field_img]["name"];
            if($image){
        		// remove old if exists record and img
        		$this -> remove_old_image($id,$field_img);
        		
        		$image = $this -> upload_image($field_img,'_'.time(),2000000);
        		$row['icon'] = 	$image;
            }
            $row['type_id'] = 0;

    		$rid = parent::save ( $row );
            return $rid;
    	}
	}
	
?>