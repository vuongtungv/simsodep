<?php
class UsersModelsUsers extends FSModels {
	var $limit;
	var $page;
	function __construct() {
		$limit = FSInput::get ( 'limit', 20, 'int' );
		$page = FSInput::get ( 'page' );
		$this-> limit = $limit;
		$this-> page = $page;
        $this -> view = 'users';
		$this -> table_name = 'fs_users';
        $this -> table_news_categories = FSTable_ad::_('fs_news_categories');
        $this -> table_products_categories = FSTable_ad::_('fs_products_categories');
        $this -> table_name_groups = 'fs_users_groups';
        $this -> check_alias = 0;
        $this -> arr_img_paths = array(
                                            //array('resized',420,252,'resize_image'),
                                            array('small',90,90,'cut_image'),
                                            //array('large',420,252,'cut_image')
                                        );        
        $cyear = date('Y');
		$cmonth = date('m');
		//$cday = date('d');
		$this -> img_folder = 'images/users/'.$cyear.'/'.$cmonth;
        // $this -> field_img = 'image';
                        
        parent::__construct();
	}

	function setQuery() {
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
				$ordering .= " ORDER BY $sort_field $sort_direct, id DESC ";
		}

		if(isset($_SESSION[$this -> prefix.'filter0'])){
			$filter = $_SESSION[$this -> prefix.'filter0'];
			if($filter){
				$where .= ' AND a.city = '.$filter.'';
			}
		}

		if(isset($_SESSION[$this -> prefix.'filter1'])){
			$filter = $_SESSION[$this -> prefix.'filter1'];
			if($filter){
				if ($filter == 1) {
					$where .= ' AND a.type = 2 and a.total_sim > 0';
				}
				if ($filter == 2) {
					$where .= ' AND a.type = 2 and a.total_sim = 0';
				}
			}
		}

		if(!$ordering)
			$ordering .= " ORDER BY full_name ASC";
		
		
		if(isset($_SESSION[$this -> prefix.'keysearch'] ))
		{
			if($_SESSION[$this -> prefix.'keysearch'] )
			{
				$keysearch = $_SESSION[$this -> prefix.'keysearch'];
				$where .= " AND ( a.username LIKE '%".$keysearch."%' OR a.full_name LIKE '%".$keysearch."%' OR a.email LIKE '%".$keysearch."%' OR a.manager LIKE '%".$keysearch."%' OR a.web LIKE '%".$keysearch."%' OR a.phone LIKE '%".$keysearch."%'  )";
			}
		}
		$query = " SELECT a.*
					  FROM 
					  ".$this -> table_name." AS a
					  	WHERE type=2".
					 $where.
					 $ordering. " ";
					
		return $query;
	}

	/*
		 * Save
		 */
	function save($row = array(), $use_mysql_real_escape_string = 1) {	   

		$cid = $this->save_into_users ();

		$id = FSInput::get('id');
		if(!$id && $cid){
			$sql = "
			DROP TABLE IF EXISTS `fs_sim_".$cid."`;
			CREATE TABLE `fs_sim_".$cid."` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `sim` varchar(255) DEFAULT NULL,
			  `number` varchar(255) DEFAULT NULL,
			  `price` double(255,0) DEFAULT NULL,
			  `created_time` datetime DEFAULT NULL,
			  `edited_time` datetime DEFAULT NULL,
			  `public_time` datetime DEFAULT NULL,
			  `network` varchar(255) DEFAULT NULL,
			  `network_id` int(11) DEFAULT NULL,
			  `author` varchar(255) DEFAULT NULL,
			  `status` int(11) DEFAULT '0',
			  `admin_status` int(255) DEFAULT '0',
			  `agency` int(11) DEFAULT '0',
			  `agency_name` varchar(255) DEFAULT NULL,
			  `cat_id` varchar(255) DEFAULT '',
			  `cat_type` int(11) DEFAULT NULL,
			  `cat_alias` varchar(255) DEFAULT '',
			  `cat_name` varchar(999) DEFAULT '',
			  `commission` int(11) DEFAULT NULL,
			  `commission_value` double(255,0) DEFAULT NULL,
			  `price_public` double(255,0) DEFAULT NULL,
			  `commission_percent` double(255,0) DEFAULT NULL,
			  `type` tinyint(11) DEFAULT NULL,
			  `price_old` double(255,0) DEFAULT NULL,
			  `point` int(11) DEFAULT NULL,
			  `button` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;";
		global $db;
		$db->query ( $sql );
		$rows = $db->affected_rows ();
		}
		

//		if ($cid)
//			if ($this->save_into_users_groups ( $cid ))
//				return $cid;
		
		return $cid;
	
	}
	
	function save_into_users() {
	    $row = array();
		$edit_pass = FSInput::get('edit_pass');

		// $agencies = FSInput::get('agencies');
		// $agencies = $this->get_record('published=1 AND id='.$agencies,'fs_agencies','id,name');
		// $row['agencies_name'] = $agencies->name;

		$price = FSInput::get('price');
		if ($price) {
			$price = $this->get_record('published=1 AND id='.$price,'fs_price','id,name');
			$row['price_name'] = $price->name;
		}else{
			$row['price_name'] = NULL;
		}
		$row['type'] = 2;

		if($edit_pass){
			$row['password'] = md5(FSInput::get("password1"));
		}

		return parent::save($row,0);
	}

	function delete($id) {

		global $db;
		
		// remove in database
		$sql = " DELETE FROM fs_sim WHERE agency = $id ;";
		$sql .= " DELETE FROM fs_sim_dublicate WHERE agency = $id ;";
		$sql .= " UPDATE fs_users SET total_sim = 0 
					WHERE id = $id ";

		$db->query ( $sql );
		$rows = $db->affected_rows ();
		return $rows;

	}	

	function allowed($id) {

		global $db;
		
		$sql = " UPDATE fs_sim SET admin_status = '1' 
					WHERE admin_status = 0 AND agency = $id ";
		$db->query ( $sql );
		$rows = $db->affected_rows ();
		return $rows;

	}
	
	/*
		 * check exits User
		 */
	function checkExistUser() {
		global $db;
		$email = FSInput::get ( 'email' );
		$username = FSInput::get ( 'username' );
	    
	}
	
	/*
		 * Save into tble_users_groups
		 * @id: id of user
		 */
	function save_into_users_groups($id) {
		
		if ($id) {
			global $db;
			//	remove before save
			$sql = " DELETE FROM fs_users_groups
						WHERE userid = $id ";
			
			$db->query ( $sql );
			$rows = $db->affected_rows ();
			
			$group_ids = FSInput::get ( 'group_ids', array (), 'array' );
			if (@$group_ids) {
				foreach ( $group_ids as $groupid ) {
					
					// save
					$sql = " INSERT INTO fs_users_groups
									(`userid`,`groupid`)
									VALUES ('$id','$groupid')
									";
					
					$db->query ( $sql );
				
		//						$id = $db->insert();
				}
			}
			return $id;
		}
	}
	
	function permission_save($cid = 0) {
		if(!$cid)
			return;
		
		$rs = $this -> permission_base_save($cid);	
		$rs1 = $this -> permission_other_save($cid);	
		return $rs;
	}
	function permission_other_save($cid = 0) {
		$row = array();
		
		// NEWS
		$area_select = FSInput::get ( 'area_news_categories_select' );
		$str_list = '';
		if (! $area_select || $area_select == 'none') {
			$str_list = 'none';
		} else if ($area_select == 'all') {
			$str_list = 'all';
		} else {
			$list = FSInput::get ( 'news_categories', array (), 'array' );
			$arr_list = implode ( ',', $list );
			if ($arr_list) {
				$str_list = ',' . $arr_list . ',';
			}
		}
		$row['news_categories'] = $str_list;
		
		// PRODUCTS
		$area_select = FSInput::get ( 'area_products_categories_select' );
		$str_list = '';
		if (! $area_select || $area_select == 'none') {
			$str_list = 'none';
		} else if ($area_select == 'all') {
			$str_list = 'all';
		} else {
			$list = FSInput::get ( 'products_categories', array (), 'array' );
			$arr_list = implode ( ',', $list );
			if ($arr_list) {
				$str_list = ',' . $arr_list . ',';
			}
		}
		$row['products_categories'] = $str_list;
		$this -> _update($row,'fs_users','id = '.$cid);
		
	}
	function permission_base_save($cid = 0) {
		$permission_arr = FSInput::get ( 'per_28', array (), 'array' );
		
		$modulelist = $this->get_records ( 'published = 1', 'fs_permission_tasks' );
		// array module_type list.
		global $db;
		foreach ( $modulelist as $m ) {
			
			$permission_arr = FSInput::get ( 'per_' . $m->id, array (), 'array' );
			
			$per = 0;
			if (count ( $permission_arr )) {
				for($i = 0; $i < count ( $permission_arr ); $i ++)
					$per = max ( $per, $permission_arr [$i] );
			}
			
			//			die;
			$sql = ' SELECT id FROM fs_users_permission 
						WHERE user_id = ' . $cid . '
						AND task_id = ' . $m->id . ' ';
			$db->query ( $sql );
			$id = $db->getResult ();
			
			if (! $id) {
				$sql_insert = '  INSERT INTO fs_users_permission 
							(user_id,task_id,permission)
							VALUES ("' . $cid . '","' . $m->id . '","' . $per . '") ';
				$db->query ( $sql_insert );
				$id = $db->insert ();
				if (! $id)
					return 0;
			} else {
				$sql_update = " UPDATE  fs_users_permission
									 SET permission = '$per'
								 		WHERE id = $id ";
				$db->query ( $sql_update );
				$rows = $db->affected_rows ();
			}
		}
		return true;
	}
	
    function save_fun_permission(){
        $row = array();
        
        $list = FSInput::get ( 'list_field', array (), 'array' );
		$arr_list = implode ( ',', $list );
		if ($arr_list) {
			$str_list = ',' . $arr_list . ',';
		}
        $row['list_field'] = $str_list;
        
        $row['user_id'] = FSInput::get('user_id',0,'int');
        $row['module'] = FSInput::get('n_module');
        $row['view'] = FSInput::get('n_view');
        
        $field = $this->get_count(' user_id = '.$row['user_id'].' AND module = "'.$row['module'].'" AND view = "'.$row['view'].'" ','fs_users_permission_fun');
        if($field){
            $rs = $this->_update($row,'fs_users_permission_fun',' user_id = '.$row['user_id'].' AND module = "'.$row['module'].'" AND view = "'.$row['view'].'" ');
        }else{
            $rs = $this->_add($row,'fs_users_permission_fun',1);
        }
        
        if($rs){
            return $rs;
        }else{
            return false;
        }
    }
    
    function save_field_permission(){
        $row = array();
        
        $list = FSInput::get ( 'list_field', array (), 'array' );
		$arr_list = implode ( ',', $list );
		if ($arr_list) {
			$str_list = ',' . $arr_list . ',';
		}
        $row['list_field'] = $str_list;
        
        $row['user_id'] = FSInput::get('user_id',0,'int');
        $row['module'] = FSInput::get('n_module');
        $row['view'] = FSInput::get('n_view');
        
        $field = $this->get_count(' user_id = '.$row['user_id'].' AND module = "'.$row['module'].'" AND view = "'.$row['view'].'" ','fs_users_permission_field');
        if($field){
            $rs = $this->_update($row,'fs_users_permission_field',' user_id = '.$row['user_id'].' AND module = "'.$row['module'].'" AND view = "'.$row['view'].'" ');
        }else{
            $rs = $this->_add($row,'fs_users_permission_field',1);
        }
        
        if($rs){
            return $rs;
        }else{
            return false;
        }
         
    }
	/*
		 * Select all list category of news
		 */
	function get_news_categories() {
		global $db;
		$result = $this->get_records ( '', 'fs_news_categories', '*', 'ordering, parent_id' );
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$list = $tree->indentRows2 ( $result );
		
		return $list;
	}
	
	/*
		 * Select all list category of product
		 */
	function get_products_categories() {
		global $db;
		$result = $this->get_records ( '', 'fs_products_categories', '*', 'ordering, parent_id' );
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$list = $tree->indentRows2 ( $result );
		
		return $list;
	}
/*
		 * check exist email .
		 */
		function check_exits_email()
		{
			global $db ;
			$email      =  FSInput::get("email");
			if(!$email){
				return false;
			}
			$sql = " SELECT count(*) 
					FROM fs_users 
					WHERE 
						email = '$email'
					";
			$db -> query($sql);
			$count = $db->getResult();
			
			return $count;
		}
		/*
		 * check exist username .
		 */
		function check_exits_username()
		{
			global $db ;
			$username      =  FSInput::get("username");
			if(!$username){
				return false;
			}
			$sql = " SELECT count(*) 
					FROM fs_users 
					WHERE 
						username = '$username'
					";
			$db -> query($sql);
			$count = $db->getResult();
			return $count;
		}
        
        public function ajax_check_exist_username()
        {
            global $db ;
            $id   = FSInput::get("id",0,'int');
            $user = $this->get_record_by_id($id,'fs_users','username');
            $email_check = '';
            $username_check = '';
            if($user){
                $username_check = $user->username;
            }
            
            $username      =  FSInput::get("username");
            if (!$username) {
                return false;
            }

            $sql = ' SELECT count(id)
                     FROM fs_users
                     WHERE username = "'.$username.'"'
                    ;
            //$db -> query($sql);
            $count = $db->getResult($sql);
            if ($count && $username_check != $username) {
                return false;
            }
            return true;
        }
        
        public function ajax_check_exits_email()
        {
            global $db ;
            
            $id   = FSInput::get("id",0,'int');
            $user = $this->get_record_by_id($id,'fs_users','email');
            $email_check = '';
            if($user){
                $email_check = $user->email;
            }
            
            $email      =  FSInput::get("email");
            if (!$email) {
                return false;
            }

            $sql = ' SELECT count(id)
                     FROM fs_users
                     WHERE email = "'.$email.'"'
                    ;
            //$db -> query($sql);
            $count = $db->getResult($sql);
            if ($count && $email_check != $email) {
                return false;
            }
            return true;
        }

}

?>