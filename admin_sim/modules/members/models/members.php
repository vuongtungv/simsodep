<?php

class MembersModelsMembers extends FSModels {

    var $limit;
    var $prefix;

    function __construct() {
        $limit = 100;
        $this->view = 'members';
        $this->limit = $limit;
        $this->table_name = 'fs_members';
        parent::__construct();
        //$this -> array_synchronize = array('fs_schedules'=>array('id'=>'user_id','username'=>'user_name','full_name'=>'full_name','sex'=>'sex'
        // ,'address'=>'address','level'=>'level','email'=>'email','mobilephone'=>'mobilephone'));                                  
    }

    function setQuery() {
        // ordering
        $ordering = "ORDER BY id DESC ";
        if (isset($_SESSION[$this->prefix . 'sort_field'])) {
            $sort_field = $_SESSION[$this->prefix . 'sort_field'];
            $sort_direct = $_SESSION[$this->prefix . 'sort_direct'];
            $sort_direct = $sort_direct ? $sort_direct : 'asc';
            $ordering = '';
            if ($sort_field)
                $ordering .= " ORDER BY $sort_field $sort_direct, id DESC ";
        }
        $where = "  WHERE 1=1 ";

        // from
        if (isset($_SESSION[$this->prefix . 'text0'])) {
            $date_from = $_SESSION[$this->prefix . 'text0'];
            if ($date_from) {
                $date_from = strtotime($date_from);
                $date_new = date('Y-m-d H:i:s', $date_from);
                $where .= ' AND a.lastedit_date >=  "' . $date_new . '" ';
            }
        }

        // to
        if (isset($_SESSION[$this->prefix . 'text1'])) {
            $date_to = $_SESSION[$this->prefix . 'text1'];
            if ($date_to) {
                $date_to = $date_to . ' 23:59:59';
                $date_to = strtotime($date_to);
                $date_new = date('Y-m-d H:i:s', $date_to);
                $where .= ' AND a.lastedit_date <=  "' . $date_new . '" ';
            }
        }

        if (isset($_SESSION[$this->prefix . 'filter0'])) {
            $filter = $_SESSION[$this->prefix . 'filter0'];
            if ($filter) {
                $where .= ' AND a.position = ' . $filter . ' ';
            }
        }

        if (isset($_SESSION[$this->prefix . 'keysearch'])) {
            $keysearch = $_SESSION[$this->prefix . 'keysearch'];
            if ($keysearch) {
                $where .= " AND ( a.username LIKE '%" . $keysearch . "%' OR a.name LIKE '%" . $keysearch . "%' OR a.id LIKE '%" . $keysearch . "%' )
										";
            }
        }

        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_name . " AS a "
                . $where .
                $ordering . " ";
//        echo $query;
        return $query;
    }

    /*     * ****************************** SAVE **************************************** */
    /*
     * 
     * Save
     */

    function save($row = array(), $use_mysql_real_escape_string = 1) {
         $id = FSInput::get('id');
         if($id){
               $mem=$this->get_record('id='.$id,'fs_members');
         }
        
       $time = date('Y-m-d H:i:s');
        $row['lastedit_date']=$time;
        
        $city_id = FSInput::get('city');
        if ($city_id) {
            $city=$this->get_record('id='.$city_id,'fs_cities');
            $row['city'] = $city_id;
            $row['city_name'] = $city->name;
        }
        $position_id = FSInput::get('position');
        if ($position_id) {
            $position=$this->get_record('id='.$position_id,'fs_position');
            $row['position'] = $position_id;
            $row['position_name'] = $position->name;
        }
        //lưu tên người sửa
          $user_id = isset($_SESSION['ad_userid'])? $_SESSION['ad_userid']:'';
            if(!$user_id)
                return false;
               
           $user = $this->get_record_by_id($user_id,'fs_users','username');
            if($id){
                $row['lastedit_name'] = $user->username;
            }else{
                $row['lastedit_name'] = $user->username; 
            }
        
        
        $pass = FSInput::get('password');

        if ($pass) {
            $row['password'] = md5(FSInput::get("password"));
        }else{
           $row['password'] = $mem->password;
        }
        $row['sex'] = FSInput::get('sex');


        return parent::save($row, 0);
    }

    function remove() {
        $img_paths = array();
        $img_paths[] = PATH_IMG_MEMBER_AVATAR . 'original' . DS;
        $img_paths[] = PATH_IMG_MEMBER_AVATAR . 'resized' . DS;
        return parent::remove('avatar', $img_paths);
    }

    /*
     * Createa folder when create user
     */

    function create_folder_upload($id) {
        $fsFile = FSFactory::getClass('FsFiles', '');
        $path = PATH_BASE . 'uploaded' . DS . 'estores' . DS . $id;
        return $fsFile->create_folder($path);
    }

    function get_department() {
        global $db;
        $query = " SELECT *
				FROM fs_department";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
    function get_data_member() {
        global $db;
        $where = '1=1 AND m.position = p.id';
      if (isset($_SESSION[$this->prefix . 'filter0'])) {
            $filter = $_SESSION[$this->prefix . 'filter0'];
            if ($filter==2) {
                $where .= ' AND m.type = 2 ';
            }elseif($filter==3){
                $where .= ' AND m.type = 3 ';
            }elseif($filter==1){
                $where .= ' AND m.type = 1 ';
            }
        }

        $query = " SELECT m.*,p.name as vi_tri
				FROM fs_members as m, fs_position as p
                WHERE $where";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
        function ajax_check_exits_email() {
        global $db;
        $email = FSInput::get("email");
        
        if (!$email) {
            return false;
        }
     $sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						email = '$email'
					";
        $db->query($sql);
        $count = $db->getResult();
        echo $count;die;
        if ($count) {
            return false;
        }
        return true;
    }

}

/*
 * get record 
 */

function get_record($where = '', $table_name = '', $select = '*') {
    if (!$where)
        return;
    if (!$table_name)
        $table_name = $this->table_name;
    $query = " SELECT " . $select . "
						  FROM " . $table_name . "
						  WHERE " . $where;
    global $db;
    $db->query($query);
    $result = $db->getObject();
    return $result;
}

?>