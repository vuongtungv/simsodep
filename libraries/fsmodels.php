<?php
class FSModels {
	var $limit;
	var $page;
    var $arr_img_paths;
    var $arr_img_paths_other;
    var $img_folder;
    var $table_name;
		var $type;
	function __construct() {
		$page = FSInput::get ( 'page', 0, 'int' );
		$limit = FSInput::get ( 'limit', 10, 'int' );
		$this->page = $page;
		$this->limit = $limit;

        $module = FSInput::get('module','home');
		$view = FSInput::get('view',$module);

		$this -> module = $module;
		$this -> view = $view;
        $this -> load_params();
	}

    function load_params(){

	}

	function _update($row, $table_name, $where = '', $use_mysql_real_escape_string = 1) {
		global $db;
		$total = count ( $row );
		if (! $total || ! $table_name)
			return;
		$sql = 'UPDATE ' . $table_name . ' SET ';
		$i = 0;
		foreach ( $row as $key => $value ) {
			if ($use_mysql_real_escape_string){
				// $sql .= "`" . $key . "` = '" . mysql_real_escape_string ( $value ) . "'";
				if(strpos($value,"'") !== false){
                    $value = str_replace("'","\'",$value);
                }
				if($value == 0){
					$sql .= "`".$key."` = '".$value."'";
				}else{
					$sql .= "`".$key."` = '".$db -> escape_string($value)."'";
				}
			}else{
				$sql .= "`" . $key . "` = '" . $value . "'";
            }
            
			if ($i < $total - 1)
				$sql .= ',';
			$i ++;
		}
		if ($where)
			$where = ' WHERE ' . $where;
		$sql .= $where;
		// $db->query ( $sql );
		$rows = $db->affected_rows ($sql );
		return $rows;
	}

	function _add($row, $table_name, $use_mysql_real_escape_string = 0) {
		global $db;
		if (! $table_name)
			return false;
		$str_fields = array ();
		$str_values = array ();

		if (! count ( $row ))
			return;
		foreach ( $row as $field => $value ) {
			$str_fields [] = "`" . $field . "`";
			if ($use_mysql_real_escape_string)
				$value = $db -> escape_string($value);

			$str_values [] = "'" . $value . "'";
		}

		$str_fields = implode ( ',', $str_fields );
		$str_values = implode ( ',', $str_values );



		$sql = ' INSERT INTO  ' . $table_name;
		$sql .= '(' . $str_fields . ") ";
		$sql .= 'VALUES (' . $str_values . ") ";
        //print_r($sql);die;
		// $db->query ( $sql );
		$id = $db->insert ($sql);
		return $id;

	}
	/*
		 * Value need remove
		 */
		function _remove($where = '',$table_name = ''){
			$sql_where = '';
			if($where)
				$sql_where .= ' WHERE '.$where;
			if( !$table_name )
				$table_name = $this -> table_name ;
			$sql = " DELETE FROM ".$table_name. $sql_where;
			global $db;
			$db->query($sql);
			$rows = $db->affected_rows();
			return $rows;
		}
	/*
		 * Remove img
		 */
	// remove image of id IN str_id
	function remove_image($where, $path_arr = array(), $field = 'image', $table_name = '') {
		if (! $where || ! count ( $path_arr ))
			return;
		if (! $table_name)
			return false;
		$sql = " SELECT " . $field . "
					 FROM " . $table_name . "
					 WHERE  " . $where;
		global $db;
		$db->query ( $sql );
		$list = $db->getObjectList ();

		for($i = 0; $i < count ( $list ); $i ++) {
			$image = $list [$i]->$field;
			if ($image)
				for($j = 0; $j < count ( $path_arr ); $j ++) {

					if (! @unlink ( $path_arr [$j] . $image )) {
						//						$fserrors = FSFactory::getClass('Errors');
					//						$fserrors -> _('Not remove image'.$path_arr[$j].$image);
					//						return false;
					}
				}
		}
		return true;
	}

	/*
	 * Get wrapper of list id
	 * ex: get parent_ids from fs_category where id IN ()
	 * return string of wrapper
	 */
	function _get_wrapper($tablename, $field_wrapper, $where_value, $where_field = 'id', $where_type = 'IN') {
		if (! $tablename || ! $field_wrapper || ! $where_value)
			return;
		$sql = ' SELECT  ' . $field_wrapper;
		$sql .= ' FROM ' . $tablename;
		if ($where_type == 'IN') {
			$sql .= ' WHERE  ' . $where_field . ' IN (' . $where_value . ') ';
		} else {
			$sql .= ' WHERE  ' . $where_field . $where_type . $where_value;
		}
		global $db;
		$db->query ( $sql );
		$list = $db->getObjectlist ();

		$str_wrapper = '';
		for($i = 0; $i < count ( $list ); $i ++) {
			$item = $list [$i];
			if ($item->$field_wrapper) {
				if ($str_wrapper)
					$str_wrapper .= ',';
				$str_wrapper .= $item->$field_wrapper;
			}
		}
		if (! $str_wrapper)
			return;
		$arr_wrapper = explode ( ',', $str_wrapper );
		$arr_wrapper = array_unique ( $arr_wrapper );
		return implode ( $arr_wrapper, ',' );
	}

	function get_estore() {
		$estore_id = $_SESSION ['estore_id'];
		if (! $estore_id)
			return;

		global $db;
		$sql = " SELECT id,category_ids,estore_name,estore_url,category_ids_wrapper,product_categories_wrapper, city_id, district_id,destination_ids,username,etemplate
				FROM fs_estores
				WHERE `id`  = '$estore_id'
				";
		$db->query ( $sql );
		return $db->getObject ();

	}

	/*
	 * get Destination
	 * default: Hoan kiem, Ha Noi
	 */
	function get_destination($district_id = '1478') {
		if (! $district_id)
			return false;
		global $db;
		$sql = " SELECT id, name FROM fs_destination
				WHERE district_id = $district_id ";
		$db->query ( $sql );
		return $db->getObjectList ();
	}
	function alert_error($msg) {
		echo "<script type='text/javascript'>alert('" . $msg . "'); </script>";
	}
	function get_estore_by_ids($str_estore_id) {
		if (! $str_estore_id)
			return;
		global $db;
		$sql = " SELECT id,estore_name,username,estore_url FROM fs_estores
				WHERE id IN (" . $str_estore_id . ")
				AND published = 1";
		$db->query ( $sql );
		return $list = $db->getObjectListByKey ( 'id' );
	}
	function get_estore_by_id($estore_id) {
		if (! $estore_id)
			return;
		global $db;
		$sql = " SELECT id,estore_name,username,estore_url FROM fs_estores
				WHERE id = (" . $estore_id . ")
				AND published = 1";
		$db->query ( $sql );
		return $list = $db->getObject ();
	}

	/*
	 * get record by rid
	 */
	function get_record_by_id($id, $table_name = '', $select = '*') {
		if (! $id)
			return;
		if (! $table_name)
			$table_name = $this->table_name;
		$query = " SELECT " . $select . "
					  FROM " . $table_name . "
					  WHERE id = $id ";

		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}
	/*
	 * Return result
	 */
	function get_result($where = '', $table_name = '', $field = 'id') {
		if (! $where)
			return;
		if (! $table_name)
			$table_name = $this->table_name;
		$select = " SELECT " . $field . " ";
		$query = $select . "  FROM " . $table_name . "
					  WHERE " . $where;

		global $db;
		$sql = $db->query ( $query );
		$result = $db->getResult ();
		return $result;
	}
	/*
	 * select count(...) thỏa mãn điều kiện
	 */
	// function get_count($where = '', $table_name = '', $select = '*') {
	// 	if (! $where)
	// 		return;
	// 	if (! $table_name)
	// 		$table_name = $this->table_name;
	// 	 $query = ' SELECT count(' . $select . ')
	// 				  FROM ' . $table_name . '
	// 				  WHERE ' . $where;

	// 	global $db;
	// 	$sql = $db->query ( $query );
	// 	$result = $db->getResult ();
	// 	return $result;
	// }
	function get_count($where = '',$table_name = '',$select = '*'){
			if(!$table_name)
				$table_name = $this -> table_name;
			$query = " SELECT count(".$select.")
						  FROM ".$table_name;
			if($where)
			$query.=" WHERE ".$where ;
			global $db;
			$result = $db->getResult($query);
			return $result;
		}
	/*
	 * get record by rid
	 */
	function get_record($where = '', $table_name = '', $select = '*') {
		if (! $where)
			return;
		if (! $table_name)
			$table_name = $this->table_name;
		$query = " SELECT " . $select . "
					  FROM " . $table_name . "
					  WHERE " . $where;

		global $db;
		$db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}
	/*
	 * get records
	 */
	function get_records($where = '', $table_name = '', $select = '*', $ordering = '', $limit = '', $field_key = '') {
		$sql_where = " ";
		if ($where) {
			$sql_where .= ' WHERE ' . $where;
		}
		if (! $table_name)
			$table_name = $this->table_name;
		$query = " SELECT " . $select . "
					  FROM " . $table_name . $sql_where;

		if ($ordering)
			$query .= ' ORDER BY ' . $ordering;
		if ($limit)
			$query .= ' LIMIT ' . $limit;

//		echo $query;
		global $db;
		$sql = $db->query ( $query );
		if (! $field_key)
			$result = $db->getObjectList ();
		else
			$result = $db->getObjectListByKey ( $field_key );
		return $result;
	}

	/*
	 * save into table
	 */
	function _save($row = array(), $table_name = '', $use_mysql_real_escape_string = 0) {
		$id = FSInput::get ( 'id', 0, 'int' );
		var_dump($row);die();
		if (! $id)
			return $this->_add ( $row, $table_name, $use_mysql_real_escape_string );
		else
			return $this->_update ( $row, $table_name, ' WHERE id = ' . $id, $use_mysql_real_escape_string );
	}

	function get_countries() {
		global $db;
		$sql = " SELECT id, name FROM fs_countries
				WHERE published = 1
				ORDER BY `ordering`
				";
		$db->query ( $sql );
		return $db->getObjectList ();
	}

	/*
	 * get list District
	 * default: Ha Noi
	 */
	function get_districts($city_id) {
		if (! $city_id)
			return;
		global $db;
		$sql = " SELECT id, name FROM fs_districts
				WHERE city_id = $city_id
				AND published = 1
				ORDER BY `ordering`
				";
		$db->query ( $sql );
		return $db->getObjectList ();
	}
	function get_cities($country_id = 66) {
		global $db;
		$sql = " SELECT id, name FROM fs_cities
				WHERE country_id = $country_id
				AND published = 1
				ORDER BY `ordering`";
		$db->query ( $sql );
		return $db->getObjectList ();
	}
	function get_communes($district_id = 66) {
		global $db;
		$sql = " SELECT id, name FROM fs_commune
				WHERE district_id = $district_id
				AND published = 1
				ORDER BY `ordering`";
		$db->query ( $sql );
		return $db->getObjectList ();
	}
	function get_sitemap($level = 0) {
		$where = '';
		if ($level)
			$where .= ' AND level < "' . $level . '" ';
		global $db;
		$sql = " SELECT name,alias, level, parent_id,module, record_id as id,id as sitemap_id
				FROM fs_sitemap
				WHERE published  = 1
				" . $where . "
				ORDER BY module,ordering";
		$db->query ( $sql );
		$list = $db->getObjectList ();
		if (! $list)
			return;
		$tree_class = FSFactory::getClass ( 'tree', 'tree/' );

		// call views
		$arr_sitemap = array ();
		foreach ( $list as $item ) {
			if (! isset ( $arr_sitemap [$item->module] ))
				$arr_sitemap [$item->module] = array ();
			$arr_sitemap [$item->module] [] = $item;
		}
		if (! count ( $arr_sitemap ))
			return;
		foreach ( $arr_sitemap as $key => $items ) {
			$arr_sitemap [$key] = $tree_class->indentRows ( $items );
		}
		return $arr_sitemap;
	}
	function check_exist($value, $id = '', $field = 'alias', $table_name = '') {
		if (! $value)
			return true;
		if (! $table_name)
			$table_name = $this->table_name;
		$query = " SELECT count(*)
					  FROM " . $table_name . "
					WHERE
						$field = '" . $value . "' ";
		if ($id)
			$query .= ' AND id <> ' . $id . ' ';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getResult ();
		return $result;
	}
	/*
	 * Chèn từ khóa vào nội dung ( bài viết hoặc sản phẩm)
	 */
	function insert_keyword_to_content($content) {
		$content = htmlspecialchars_decode($content);
		$arr_keyword_name = $this -> get_records('published = 1','fs_keywords','name,link');
		if(count($arr_keyword_name)){
				foreach($arr_keyword_name as $item){
					preg_match('#<a[^>]*>((^((?!</a>).)*$)*?)'.$item ->name.'(((^((?!<a>).)*$))*?)</a>#is',$content,$rs);
					if(count($rs))
						continue;
					$link = $item->link ? FSRoute::_($item -> link): FSRoute::_('index.php?module=products&view=search&keyword='.str_replace(' ','+',trim($item -> name)));
					$content  = str_replace($item -> name,'<a href="'.$link.'" >'.$item -> name.'</a>',$content);
				}
		}
		return $content;
	}
/*
		 * get Max value of Ordering field in table fs_categories
		 */
		function getMaxOrdering()
		{
			$query = " SELECT Max(a.ordering)
					 FROM ".$this -> table_name." AS a
					";
			global $db;
			$sql = $db->query($query);
			$result = $db->getResult();
			if(!$result)
				return 1;
			return ($result + 1);
		}
		function get_max_ordering($tablename)
		{
			$query = " SELECT Max(a.ordering)
					 FROM ".$tablename." AS a
					";
			global $db;
			$sql = $db->query($query);
			$result = $db->getResult();
			if(!$result)
				return 1;
			return ($result + 1);
		}
		/*
		 * Lấy value từ fs_config
		 */
		function get_config($key)
		{
			if(!$key)
				return;
			$query = ' SELECT value
					 FROM fs_config
					 WHERE `name` = "'.$key.'" ';
			global $db;
			$sql = $db->query($query);
			$result = $db->getResult();
			return $result;
		}
		/*
		 * Get user
		 */
		function get_user()
		{
			if(!isset( $_SESSION['user_id']) || !$_SESSION['user_id'])
				return;
			$user_id = $_SESSION['user_id'];
			return  $this -> get_record('id = '.$user_id.'','fs_members');
		}

		/*
    	 * Ghi lại lần đăng nhập vào hệ thống
    	 */
    	function upload_last_time($user_id){
    		if(!$user_id)
    			return;
    		$time = date("Y-m-d H:i:s");
    		$row = array();
    		$row['last_time'] = $time;
    		$this -> _update($row, 'fs_members','id = '.$user_id);
    	}


		//function ajax_add_member_follow(){
//			if(!isset( $_SESSION['user_id']) || !$_SESSION['user_id'])
//				return '3';// chưa login
//			$user_id = $_SESSION['user_id'];
//			$member_id = FSInput::get('member_id',0,'int');
//			if(!$member_id)
//				return;
//			// không thể theo dõi chính mình
//            if($member_id == $user_id)
//                return '4';
//
//            $status = FSInput::get('status',0,'int');
//            // danh sách theo dõi,được theo dõi của user_id
//            $record = $this -> get_record_by_id($user_id ,'fs_members','followers,following,full_name,username');
//            // danh sách theo dõi,được theo dõi của member_id
//            $record2 = $this -> get_record_by_id($member_id ,'fs_members','followers,following,block_member');
//            $name = $record->full_name? $record->full_name:$record->username;
//			global $db;
//			if(!$record && !$record2)
//                return false;
//
//            // kiểm tra user_id có bị member_id chặn(block)
//            if(strpos($record2->block_member,','.$user_id) !== false)
//                return '5';
//
//            $row = array();
//            $row2 = array();
//            //if($status==1){ // đi theo dõi người khác
//                if(strpos($record->following,','.$member_id) !== false){ // kiểm tra nếu đã có member_id này trong danh sách theo dõi
//        		    $following = str_replace(','.$member_id,'',$record->following);
//                    $row['following']= $following;
//                    $rs = $this -> _update($row,'fs_members', ' id = '.$user_id);
//                    if($rs){
//                        $_SESSION['following'] = $row['following'];
//                        $followers = str_replace(','.$user_id,'',$record2->followers);
//                        $row2['followers']= $followers;
//                        $this -> _update($row2,'fs_members', ' id = '.$member_id);
//
//                        // Insert vào notify
//        				$row3 = array();
//        				$row3['user_id'] = $member_id;
//        				$time = date("Y-m-d H:i:s");
//        				$row3['created_time'] = $time;
//        				$row3['readers_id'] = '';
//                        $link_member = FSRoute::link_member($_SESSION['user_id'],@$_SESSION['username'],@$_SESSION['email']);
//        				$row3['message'] = '<a href="'.$link_member.'" >'.$name.'</a> đã bỏ theo dõi bạn';
//        				$row3['is_read'] = 0;
//        				//$row3['record_id'] = $record -> id;
//        				$row3['type'] = 'member_unfollow';
//        				$row3['action_user_id'] = $user_id;
//        				$this -> _add($row3, 'fs_notify');
//
//                    }
//        			return '2';
//        		}else{ // kiểm tra nếu chưa có member_id này trong danh sách theo dõi
//        			$row['following']= $record->following.','.$member_id;
//        			$rs = $this -> _update($row,'fs_members', ' id = '.$user_id);
//                    if($rs){
//                        $_SESSION['following'] = $row['following'];
//                        $row2['followers']= $record2->followers.','.$user_id;
//                        $this -> _update($row2,'fs_members', ' id = '.$member_id);
//
//                        // Insert vào notify
//        				$row3 = array();
//        				$row3['user_id'] = $member_id;
//        				$time = date("Y-m-d H:i:s");
//        				$row3['created_time'] = $time;
//        				$row3['readers_id'] = '';
//        				$link_member = FSRoute::link_member($_SESSION['user_id'],@$_SESSION['username'],@$_SESSION['email']);
//        				$row3['message'] = '<a href="'.$link_member.'" >'.$name.'</a> đang theo dõi bạn';
//        				$row3['is_read'] = 0;
//        				//$row3['record_id'] = $record -> id;
//        				$row3['type'] = 'member_follow';
//        				$row3['action_user_id'] = $user_id;
//        				$this -> _add($row3, 'fs_notify');
//                    }
//        			return '1';
//        		}
//            //}else{ // người khác theo dõi mình
//            //    if(strpos($record->followers,','.$member_id) !== false ){
////        		    $followers = str_replace(','.$member_id,'',$record->followers);
////                    $row['followers']= $followers;
////                    //$_SESSION['followers'] = $followers;
////                    $rs = $this -> _update($row,'fs_members', ' id = '.$user_id);
////                    if($rs){
////                        $following = str_replace(','.$user_id,'',$record2->following);
////                        $row2['following']= $following;
////                        $this -> _update($row2,'fs_members', ' id = '.$member_id);
////                    }
////        			return '-1';
////        		}else{
////        			$row['followers'] = $record->followers.','.$member_id;
////        			$rs = $this -> _update($row,'fs_members', ' id = '.$user_id);
////                    if($rs){
////                        $row2['following']= $record2->following.','.$user_id;
////                        $this -> _update($row2,'fs_members', ' id = '.$member_id);
////                    }
////        			return '1';
////        		}
////            }
//		}

        //function ajax_block_member(){
//			if(!isset( $_SESSION['user_id']) || !$_SESSION['user_id'])
//				return '3';// chưa login
//			$user_id = $_SESSION['user_id'];
//			$member_id = FSInput::get('member_id',0,'int');
//			if(!$member_id)
//				return;
//			// người đi theo dõi người khác
//            if($member_id == $user_id)
//                return '4';
//
//            $record = $this -> get_record_by_id($user_id ,'fs_members','block_member,full_name,username,email');
//            $name = $record->full_name? $record->full_name:$record->username;
//			global $db;
//			if(!$record)
//                return false;
//
//            $row = array();
//            if(strpos($record->block_member,','.$member_id) !== false){
//    		    $block_member = str_replace(','.$member_id,'',$record->block_member);
//                $row['block_member']= $block_member;
//                $rs = $this -> _update($row,'fs_members', ' id = '.$user_id);
//                if($rs){
//                    $_SESSION['block_member'] = $row['block_member'];
//                    // Insert vào notify
//    				$row3 = array();
//    				$row3['user_id'] = $member_id;
//    				$time = date("Y-m-d H:i:s");
//    				$row3['created_time'] = $time;
//    				$row3['readers_id'] = '';
//    				$link_member = FSRoute::link_member($_SESSION['user_id'],@$_SESSION['username'],@$_SESSION['email']);
//    				$row3['message'] = '<a href="'.$link_member.'" >'.$name.'</a> đã bỏ chặn bạn';
//    				$row3['is_read'] = 0;
//    				//$row3['record_id'] = $record -> id;
//    				$row3['type'] = 'member_unblock';
//    				$row3['action_user_id'] = $user_id;
//    				$this -> _add($row3, 'fs_notify');
//                }
//    			return '2';
//    		}else{
//    			$row['block_member'] = $record->block_member.','.$member_id;
//    			$rs = $this -> _update($row,'fs_members', ' id = '.$user_id);
//                if($rs){
//                    $_SESSION['block_member'] = $row['block_member'];
//                    // Insert vào notify
//    				$row3 = array();
//    				$row3['user_id'] = $member_id;
//    				$time = date("Y-m-d H:i:s");
//    				$row3['created_time'] = $time;
//    				$row3['readers_id'] = '';
//    				$link_member = FSRoute::link_member($_SESSION['user_id'],@$_SESSION['username'],@$_SESSION['email']);
//    				$row3['message'] = '<a href="'.$link_member.'" >'.$name.'</a> đã chặn bạn';
//    				$row3['is_read'] = 0;
//    				//$row3['record_id'] = $record -> id;
//    				$row3['type'] = 'member_block';
//    				$row3['action_user_id'] = $user_id;
//    				$this -> _add($row3, 'fs_notify');
//                }
//    			return '1';
//    		}
//		}

        function ajax_pause_data(){
			$user_id = '';
			if(!isset($_SESSION['el_user_id']) && !isset($_COOKIE['el_user_id']))
				return '2';// chưa login

            if(!empty($_COOKIE['el_user_id'])){
                $user_id = $_COOKIE['el_user_id'];
            }elseif(!empty($_SESSION['el_user_id'])){
                $user_id = $_SESSION['el_user_id'];
            }

			$id = FSInput::get('id',0,'int');
			if(!$id)
				return 0;

			global $db;
            $this->table_name = 'fs_products';
            $time = date("Y-m-d H:i:s");
            $row = array();

            $row['edited_time'] = $time; //date_pause
            $row['date_pause'] = $time;

            $data = $this->get_record_by_id($id,$this->table_name,'id,is_status,date_use_end');
            if(!$data){
                return 0;
            }

            if(@$data->date_use_end <= $time)
                return 3;

            if(@$data->is_status == 2){
                $row['is_status'] = 0;
            }else{
                $row['is_status'] = 2;
            }

            $rs = $this ->_update($row,$this->table_name,'id = '.$id,1);
			if($rs)
				return 1;
			else
				return 0;

		}

        function ajax_remove_data(){
			$user_id = '';
			if(!isset($_SESSION['el_user_id']) && !isset($_COOKIE['el_user_id']))
				return '2';// chưa login

            if(!empty($_COOKIE['el_user_id'])){
                $user_id = $_COOKIE['el_user_id'];
            }elseif(!empty($_SESSION['el_user_id'])){
                $user_id = $_SESSION['el_user_id'];
            }

			$id = FSInput::get('id',0,'int');
			if(!$id)
				return 0;

			global $db;
            $this->table_name = 'fs_products';

            $row = array();

            $data = $this->get_record_by_id($id,$this->table_name,'id,image');
            if(!$data){
                return 0;
            }

            $rs = $this ->_remove('id = '.$id,$this->table_name);
			if($rs){
			    $this ->_remove('products_id = '.$data->id,'fs_products_service');

                $path = PATH_BASE.$data->image;
                @unlink($path);
                foreach ( $this->arr_img_paths as $item){
                    @unlink(str_replace ( '/original/', '/'. $item[0] .'/', $path));
                }
                $this->remove_other_image($id,$this->table_name.'_images');
                return 1;
			}else{
				return 0;
			}
		}

        //function ajax_save_product(){
//			$user_id = '';
//			if(!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id']))
//				return '3';// chưa login
//
//            if(!empty($_COOKIE['user_id'])){
//                $user_id = $_COOKIE['user_id'];
//            }elseif(!empty($_SESSION['user_id'])){
//                $user_id = $_SESSION['user_id'];
//            }
//
//			$product_id = FSInput::get('product_id',0,'int');
//			if(!$product_id)
//				return 0;
//
//			$product = $this -> get_record_by_id($product_id,'fs_products','user_id');
//			if(!$product){
//				return 0;
//			}
//
//            if($user_id == $product->user_id)
//                return '4';
//
//			global $db;
//			$record = $this -> get_record_by_id($user_id ,'fs_members_seekers','save_products');
//            if(!$record)
//                return false;
//
//            $row = array();
//
//			if(strpos($record->save_products,','.$product_id) !== false){
//    		    $save_products = str_replace(','.$product_id,'',$record->save_products);
//                $row['save_products'] = $save_products;
//                $rs = $this -> _update($row,'fs_members_seekers', ' id = '.$user_id);
//                if($rs){
//                    $_SESSION['save_products'] = $row['save_products'];
//                    setcookie("save_products", $row['save_products'] ,time() +200000000,'/');
//                }
//    			return '1';
//    		}else{
//    			$row['save_products'] = $record->save_products.','.$product_id;
//    			$rs = $this -> _update($row,'fs_members_seekers', ' id = '.$user_id);
//                if($rs){
//                    $_SESSION['save_products'] = $row['save_products'];
//                    setcookie("save_products", $row['save_products'] ,time() +200000000,'/');
//                }
//    			return '2';
//    		}
//
//		}


        //function ajax_add_like(){
//            $user_id = '';
//			if(!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id']))
//				return '3';// chưa login
//
//            if(!empty($_COOKIE['user_id'])){
//                $user_id = $_COOKIE['user_id'];
//            }elseif(!empty($_SESSION['user_id'])){
//                $user_id = $_SESSION['user_id'];
//            }
//
//			$product_id = FSInput::get('product_id',0,'int');
//			if(!$product_id)
//				return 0;
//
//			$product = $this -> get_record_by_id($product_id,'fs_products','user_id,likes');
//			if(!$product){
//				return 0;
//			}
//
//            if($user_id == $product->user_id)
//                return '4';
//
//			global $db;
//
//            $row = array();
//
//			if(strpos($product->likes.',',','.$user_id.',') !== false){
//    		    $likes = str_replace(','.$user_id.',',',',$product->likes.',');
//                $row['likes'] = $likes;
//                $rs = $this -> _update($row,'fs_products', ' id = '.$product_id);
//    			return '1';
//    		}else{
//    			$row['likes'] = $product->likes.','.$user_id;
//    			$rs = $this -> _update($row,'fs_products', ' id = '.$product_id);
//    			return '2';
//    		}
//
//		}

        //function ajax_add_manufactory_follow(){
//    		if(!isset( $_SESSION['user_id']) || !$_SESSION['user_id'])
//    			return '3';// chưa login
//    		$user_id = $_SESSION['user_id'];
//    		$manufactory_id = FSInput::get('manufactory_id',0,'int');
//    		if(!$manufactory_id)
//    			return;
//
//    		global $db;
//            $status = FSInput::get('status',0,'int');
//    		$record = $this -> get_record_by_id($user_id ,'fs_members','manufactories,un_manufactories');
//            if(!$record)
//                return false;
//            $row = array();
//
//            if($status==1){
//                if(strpos($record->manufactories,','.$manufactory_id) !== false){
//        		    $manufactories = str_replace(','.$manufactory_id,'',$record->manufactories);
//                    $row['manufactories']= $manufactories;
//                    $rs = $this -> _update($row,'fs_members', ' id = '.$user_id);
//                    if($rs){
//                        $_SESSION['manufactories'] = $row['manufactories'];
//                    }
//        			return '2';
//        		}else{
//        			$row['manufactories']= $record->manufactories.','.$manufactory_id;
//        			$rs = $this -> _update($row,'fs_members', ' id = '.$user_id);
//                    if($rs){
//                        $_SESSION['manufactories'] = $row['manufactories'];
//                    }
//        			return '1';
//        		}
//            }else{
//                if(strpos($record->un_manufactories,','.$manufactory_id) !== false ){
//        		    $un_manufactories = str_replace(','.$manufactory_id,'',$record->un_manufactories);
//                    $row['un_manufactories']= $un_manufactories;
//                    $rs = $this -> _update($row,'fs_members', ' id = '.$user_id);
//                    if($rs){
//                        $_SESSION['un_manufactories'] = $row['un_manufactories'];
//                    }
//        			return '2';
//        		}else{
//        			$row['un_manufactories'] = $record->un_manufactories.','.$manufactory_id;
//        			$rs = $this -> _update($row,'fs_members', ' id = '.$user_id);
//                    if($rs){
//                        $_SESSION['un_manufactories'] = $row['un_manufactories'];
//                    }
//        			return '1';
//        		}
//            }
//
//    	}

		function ajax_add_like(){
			if(!isset( $_SESSION['user_id']) && !isset($_COOKIE['user_id']))
				return '3'; //chua login
                
			$user_id = !empty($_COOKIE['user_id'])? $_COOKIE['user_id']:$_SESSION['user_id'];
			$product_id = FSInput::get('product_id',0,'int');
            
			if(!$product_id)
				return 0;

			$product = $this -> get_record_by_id($product_id,'fs_products','user_id,alias,id,tablename,name');
			if(!$product){
				return 0;
			}

            if($user_id == $product->user_id)
                return 4;

			global $db;
			$record = $this -> get_record(' product_id  = '.$product_id.' AND follower_id = '.$user_id,'fs_products_like');
			$suggest = $this -> get_record(' products_id  = '.$product_id.' AND user_id = '.$user_id,'fs_suggest_counseling');

			if($suggest){
				$data_suggest = 1;
			}else{
				$data_suggest = 0;
			}
            $time = date('Y-m-d 00:00:00');
			if($record){
				$this -> _remove('id = '.$record -> id, 'fs_products_like');
                $result = 1;
			}else{
				$row = array();
                $row['created_time']= $time;
				$row['product_id']= $product_id;
				$row['follower_id']= $user_id;
				$row['is_suggest']= $data_suggest;
				$row['is_send']= 0;
				$row['time_send'] = $time;
        		$row['time_plan'] = $time;
				$rid = $this -> _add($row,'fs_products_like');
                $result = 2;
			}
			$total_like = $this -> get_count(' product_id  = '.$product_id,'fs_products_like' );

			$row = array();
			$row['like'] = $total_like;
			$this -> _update($row,'fs_products','id = '.$product_id);
            
			if($product -> tablename){
				$this -> _update($row,$product -> tablename,'record_id = '.$product_id);
			}
			return $result;
		}

		function get_products_follow()
		{
			if(!isset($_SESSION['user_id']))
				return;
			$user_id = $_SESSION['user_id'];

			$query = '  SELECT product_id FROM fs_products_like  WHERE follower_id = '.$user_id.' ';
			global $db;
			$sql = $db->query($query);
			return $db->getObjectList();
		}

        function upload_image($image_tag_name = 'image',$suffix = '', $max_size = 2000000,$arr_img_paths = array(),$img_folder = ''){
			if(!$img_folder)
				$img_folder = $this -> img_folder;
			$img_link = str_replace('\\', '/', $img_folder);
			$img_folder = str_replace('/', DS, $img_folder);
			$img_folder = PATH_BASE.$img_folder.DS;
			$fsFile = FSFactory::getClass('FsFiles');
			// upload
			$path = $img_folder.'original'.DS;
			if(!$fsFile -> create_folder($path)){
	    		Errors:: setError("Not create folder ".$path);
    			return false;
	    	}

			$image = $fsFile -> uploadImage($image_tag_name, $path ,$max_size, $suffix);
			if(!$image)
				return false;

			//if($this->image_watermark){
//				$fsFile->add_logo($path,$image,PATH_BASE.str_replace('/',DS, 'images/mask/default.png'),9);
//			}
			$img_link = $img_link.'/original/'.$image	;
			if(!count($arr_img_paths))
				$arr_img_paths = $this -> arr_img_paths;

			if(!count($arr_img_paths))
				return $img_link;

			foreach($arr_img_paths as $item){
				$path_resize = str_replace(DS.'original'.DS, DS.$item[0].DS, $path);
				$fsFile -> create_folder($path_resize);
				$method_resize = $item[3]?$item[3]:'resized_not_crop';
				if(!$fsFile ->$method_resize($path.$image, $path_resize.$image,$item[1], $item[2]))
					return false;

			}

			return $img_link;
		}
        /**
         * Upload và resize ảnh
         *
         * @return Bool
         */
		function upload_other_images(){
			$module = $this->type? $this->type:FSInput::get('module');
			$record_id = FSInput::get('record_id',0,'int');
			global $db;
			$cyear = date ( 'Y' );
			$cmonth = date ( 'm' );
			$cday = date ( 'd' );

			$path = PATH_BASE.'images'.DS.$module .DS.$cyear.DS.$cmonth.DS.$cday.DS.'original'.DS;
            require_once(PATH_BASE.'libraries'.DS.'upload.php');
            $upload = new  Upload();
            $upload->create_folder ( $path );

            $file_name = $upload -> uploadImage('file', $path, 10000000, '_' . time () );

	         if(is_string($file_name) and $file_name!='' and !empty($this->arr_img_paths_other)){
				$fsFile = FSFactory::getClass('FsFiles');
				foreach($this->arr_img_paths_other as $item){
					$path_resize = str_replace(DS.'original'.DS, DS.$item[0].DS, $path);
					$fsFile -> create_folder($path_resize);
					$method_resize = $item[3]?$item[3]:'resized_not_crop';
					if(!$fsFile ->$method_resize($path.$file_name, $path_resize.$file_name,$item[1], $item[2]))
						return false;

				}
	        }

	        if($record_id){
	        	$row['record_id'] = $record_id;
	        }else{
	        	$data = base64_decode(FSInput::get('data'));
	            $data = explode('|', $data);
	            $row = array();
	            if($data[0] == 'add')
	                $row['session_id'] = $data[1];
	            else
	                $row['record_id'] = $data[1];
	        }


			$row['image'] = 'images/'.$module .'/'.$cyear.'/'.$cmonth.'/'.$cday.'/'.'original'.'/'.$file_name;
			$row['title'] = $_FILES['file']['name'];
			$rs = $this -> _add($row, 'fs_'.$module .'_images');
			echo  $rs;
			return $rs ;
		}

        function delete_other_image($record_id = 0){
			$record_id = FSInput::get('record_id',0,'int');
			$session_id = FSInput::get('session_id');
            $file_name = FSInput::get('name');
            $id = FSInput::get('id');

            $module = $this->type? $this->type:FSInput::get('module');
            global $db;

        	$where = '';
          	if($file_name){
	            $where .= ' AND title = \''.$file_name.'\'';
	        }elseif ($id){
        	    $where .= ' AND id = '.$id;
	        }

            if($record_id){
               $where .= ' AND record_id = ' . $record_id ;

            }elseif ($session_id) {
							$where .= ' AND session_id = "' . $session_id. '" ';
            }

            $query = '  SELECT *
                        FROM fs_'.$module .'_images
                        WHERE  1 = 1 ' . $where;
            $db->query($query);
            $images = $db->getObject();
            if($images){
                    $query = '  DELETE FROM fs_'.$module .'_images
                                WHERE id = \''.$images->id.'\'';
                    $db->query($query);
                    $path = PATH_BASE.$images->image;
                    @unlink($path);
                 	foreach ( $this->arr_img_paths_other as $image){
    					@unlink(str_replace ( '/original/', '/'. $image[0] .'/', $path));
    				}
                    echo 1;
                    return;
            }
            echo 0;
            return;
        }

        function remove_other_image($record_id = 0,$tablename = ''){
            if(!$record_id && !$tablename)
			 return false;

            global $db;

            $where = ' record_id = ' . $record_id ;

            $query = '  SELECT *
                        FROM '.$tablename.'
                        WHERE ' . $where;
            $db->query($query);
            $images = $db->getObjectList();

            if(count($images)){
                    $query = '  DELETE FROM '.$tablename .'
                                WHERE '.$where ;
                    $db->query($query);

                    foreach($images as $item){
                        $path = PATH_BASE.$item->image;
                        @unlink($path);
                     	foreach ( $this->arr_img_paths_other as $img){
        					@unlink(str_replace ( '/original/', '/'. $img[0] .'/', $path));
        				}
                    }
            }

        }

    function sort_other_images(){
    	$module = $this->type? $this->type:FSInput::get('module');
        global $db;
        if(isset($_POST["sort"])){
        	if(is_array($_POST["sort"])){
        		foreach($_POST["sort"] as $key=>$value){
        			$db->query("UPDATE fs_".$module."_images SET ordering = $key WHERE id = $value");
        		}
        	}
        }
    }
	/**
	 * Sửa thuộc tính của ảnh
	 *
	 * @return Bool
	 */
	function change_attr_image() {
		global $db;
		$data = base64_decode ( FSInput::get ( 'data' ) );
		$data = explode ( '|', $data );
		$row = array ();
		$where = '';
		if ($data [0] == 'add') {
			$where .= ' AND session_id = "' . $data [1] . '" ';
		} else {
			$where .= ' AND record_id = "' . $data [1] . '" ';
		}
		$field = FSInput::get ( 'field' );
		$value = FSInput::get ( 'value' );

		$id = FSInput::get ( 'id', 0, 'int' );
		if (! $id)
			return;
		if ($field == 'color') {
			$color = $this->get_record_by_id($value,'fs_products_colors');
			$row ['color_id'] = $value;
			$row ['color_code'] = $color->code;
			$row ['color_name'] = $color->name;

		}
		$rs = $this->_update ( $row, 'fs_' . $this->type . '_images', ' id = ' . $id . $where );
		return $rs;
	}

    /**
	 * Sửa tiêu đề ảnh của ảnh
	 *
	 * @return Bool
	 */
	function change_title_attr_image() {
		global $db;
		$data = base64_decode ( FSInput::get ( 'data' ) );
		$data = explode ( '|', $data );
		$row = array ();

		$value = FSInput::get ( 'value' );
		$id = FSInput::get ( 'id', 0, 'int' );
		if (! $id)
			return;

		$row ['title'] = $value;

		$rs = $this->_update ( $row, 'fs_' . $this->type . '_images', ' id = ' . $id  );
		return $rs;
	}

    function delete_image(){
        global $db;
        $id = FSInput::get('id', 0);
        $field = FSInput::get('field');
        $data = $this->get_record_by_id($id,$this->table_name);
        $row =array();
        $row[$field] = '';
        $rs =$this -> _update($row,$this->table_name,'id = '.$id);
        //print_r($this->arr_img_paths);
        if($rs){
            $path = PATH_BASE.$data->$field;
            @unlink($path);
      		foreach ( $this->arr_img_paths as $image){
				@unlink(str_replace ( '/original/', '/'. $image[0] .'/', $path));
			}
        }

    }
    /**
     * Lấy danh sách ảnh
     *
     * @return Object list
     */
    function getProductImages2($id,$type = 'edit'){
    	$session_id = session_id();
		if($type == 'add'){
			$where = 'session_id = \''.$session_id.'\'';
		}else{
            $where = 'record_id = '.$id;
		}
       global $db;
       $query = '  SELECT *
                    FROM fs_'.$this->type.'_images
                    WHERE '.$where.'
                    ORDER BY ordering, id ASC';
		$sql = $db->query($query);
		return $db->getObjectList();
    }
    /*
      * Sử lý lại ảnh khi save
      */
     function update_images($id,$type = 'edit'){
        global $db;

        $main_image_old = ''; // mặc định là sẽ chuyển từ ảnh phụ đầu tiên vào;
        // if($type == 'edit'){
        // 	$main_image_old = $this -> get_result( 'id = '.$id,'fs_'.$this->type,'image');
        // }
        // if(!$main_image_old){
        //     // đẩy ảnh đầu tiên vào ảnh chính
        //     $list = $this -> getProductImages2($id,$type);
        //     if(isset($list[0] -> image)){
        //     	//$row = array();
        //     	//$row['image'] = $list[0] -> image;
        //         //$row['name'] = $list[0] -> title;
        //         //$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
			  //   //$row ['alias'] = $fsstring->stringStandart ( $list[0] -> title );
        //     	// update lại trường image trong fs_product
        //     	//$this -> _update($row, 'fs_'.$this->type,'id='.$id);
        //     	// resized thêm kích cỡ ảnh nữa vì nó làm ảnh chính
        //     	//$this -> sized_main_image($list[0] -> image);
        //     	// xóa bản ghi đầu tiên
        //     	//$this -> _remove('id='.$list[0]->id,'fs_'.$this->type.'_images');
        //     }
        // }
        if($type == 'add'){
            $session_id = session_id();
            $query = '  UPDATE fs_'.$this->type.'_images SET record_id = '.$id.', session_id = \'\'
                        WHERE session_id = \''.$session_id.'\'';
            $db->query($query);
            $rows = $db->affected_rows();
            return $rows;
        }
     }

     function sortProductImages(){
        global $db;
        $image_main_new = null;  // ảnh chính mới
        $image_replace_main = 0; // ảnh chính cũ sẽ bổ sung vào
        if(isset($_POST["sort"])){
        	if(is_array($_POST["sort"])){
        		foreach($_POST["sort"] as $key=>$value){
        			if(!$key){
        				if(!$value){ // Không thay$cache main_image ( vì main_image luôn xếp đầu tiên
        					continue;
        				}else{ // Có ảnh phụ thay thế ảnh chính
        					$image_main_new = $value;
        				}
        			}else{
        				if($value){
        					$db->query('UPDATE fs_'.$this->type.'_images SET ordering = '.$key.' WHERE id = '.$value);
        				}else{ // ảnh chính sẽ nhảy vào vị trí này $key
        					$image_replace_main = $key;
        				}
        			}
        		}
        	}
        }
        // if($image_main_new){
       // 	$record = $this -> get_record_by_id($image_main_new,'fs_'.$this->type.'_images');
       // 	$main_image_old = $this -> get_result( 'id = '.$record -> record_id,'fs_'.$this->type,'image');
       // 	$main_image_news = $record -> image;
       // 	$row = array();
        //    $row['image'] = $main_image_news;
       // 	// update ảnh chính
       // 	$this -> _update($row, 'fs_'.$this->type, 'id = '.$record -> record_id);
				//
       // 	// RESIZED : CHƯA LÀM
       // 	// $this -> sized_main_image($main_image_news);
				//
       // 	// thế ảnh phụ = ảnh chính cũ nhưng theo STT mới
       // 	$row2 = array();
       // 	$row2['image'] = $main_image_old;
       // 	$row2['ordering'] = $image_replace_main;
       // 	$this -> _update($row2, 'fs_'.$this->type.'_images','id='.$record -> id);
       //}

    }
    	/*
		 * Mark messages is read.
		 */
		function mark_read($id) {
		$user_id = $_SESSION ['user_id'];
		global $db;
		$sql = " UPDATE fs_messages
						SET readers_id = concat_ws(' ',\",'$user_id'\",readers_id)
						WHERE id = $id
						AND ( readers_id is NULL
							OR readers_id NOT LIKE  \"%'$user_id'%\" )";
		$db->query ( $sql );
		$rows = $db->affected_rows ();
			return $rows;
		}

        /*
		 * caculater vocher
		 */
        function save_vocher($user_id,$order_id,$code_vocher = ''){
            if(!$user_id || !$order_id || !$code_vocher)
                return false;

            $data = $this-> get_record(' published = 1 AND name = "'.$code_vocher.'"','fs_discount_code');
            if(!$data)
                return false;

            if($data->count == 0){
                return false;
            }

            if(strpos($data->list_user.',',','.$order_id.',') !== false)
                return false;

            $row = array();
            $row['count'] = $data->count - 1;
            $row['list_user'] = $data->list_user? $data->list_user.$user_id.',':','.$user_id.',';
            $row['list_order_id'] = $data->list_order_id? $data->list_order_id.$order_id.',':','.$order_id.',';

            $rs = $this->_update($row,'fs_discount_code',' id = '.$data->id,1);
            if(!$rs){
                return false;
            }
            return true;
        }

        function calculate_total_type($type = 0){
            if(!$type){
                return 0;
            }
            if(!isset($_SESSION['cart_service_'.$type])){
                return 0;
            }

            $cart_service = $_SESSION['cart_service_'.$type];
            $cart_vocher =  !empty($_SESSION['cart_vocher_'.$type])? $_SESSION['cart_vocher_'.$type]:array();

            $total = 0;
            //$total2 = 0;

            if(count($cart_service)){
                $total = $cart_service[7];
            }

            $code_vocher = '';
            $type_vocher = '';
            $value_vocher = 0;
            //$total = $total + $total2;

            if(!empty($_SESSION['cart_vocher_'.$type])){
                //$row['code_vocher'] = $cart_vocher['code_vocher'];
                $type_vocher = $cart_vocher['type'];
                $value_vocher = $cart_vocher['val'];
            }

            if ($type_vocher != '') {
    			if ($type_vocher == 1) {
    				$value_vocher_ = $value_vocher / 100;
    				$total = $total - ($total * $value_vocher_);
    			} else {
    				$total = $total - $value_vocher;
    			}
    		}
            $total = $total>=0 ? $total:0;
            $total = round($total, 0);
            return $total;
        }

        function send_email1($title, $content, $nTo, $mTo,$diachicc='',$is_mail = 0){
            //global $email_info;

            $global_class = FSFactory::getClass('FsGlobal');

            $admin_name = $global_class->getConfig('admin_name');
			$admin_email = $global_class->getConfig('admin_email');

            $nFrom = $admin_name;

            $server = 'xxxxxxxxxx';
            $mFrom = 'xxxxxxxx';
            $mPass = 'xxxxzxx';
                   
            FSFactory::include_class('class.smtp','mailserver');
            $mail = FSFactory::getClass('PHPMailer','mailserver');

            $body = $content;

            $mail->IsSMTP();
            //Tắt mở kiểm tra lỗi trả về, chấp nhận các giá trị 0 1 2
            // 0 = off không thông báo bất kì gì, tốt nhất nên dùng khi đã hoàn thành.
            // 1 = Thông báo lỗi ở client
            // 2 = Thông báo lỗi cả client và lỗi ở server
            $mail->SMTPDebug= 0; // enables SMTP debug information (for testing)
            $mail->Debugoutput = "html"; // Lỗi trả về hiển thị với cấu trúc HTML
            $mail->CharSet= "utf-8";

            $mail->SMTPAuth= true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host= $server; //$email_info['Host'];
            $mail->Port= '465'; //$email_info['Port'];

            $mail->Username= $mFrom;// GMAIL username
            $mail->Password= $mPass;// GMAIL password

            $mail->SetFrom($mFrom, $nFrom);
            //chuyen chuoi thanh mang
            $ccmail = explode(',', $diachicc);
            $ccmail = array_filter($ccmail);

            if(!empty($ccmail)){
                foreach ($ccmail as $k => $v) {
                    $mail->addBCC($v);
                }
            }

            if($is_mail)
                $mail->addCC($admin_email,$admin_name);

            $mail->Subject = $title;
            $mail->MsgHTML($body);
            //$mail->MsgHTML(file_get_contents('email-template.html'), dirname(__FILE__));

            $address = $mTo;

            $mail->AddAddress($address, $nTo);
            $mail->AddReplyTo($admin_email, $admin_name);

            if(!$mail->Send()){
                return false;
                //echo $random;
//                echo "có lỗi khi gửi email: " . $mail->ErrorInfo;
//                die;
            }
            return true;
        }
}
