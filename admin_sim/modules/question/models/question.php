<?php 
class QuestionModelsQuestion extends FSModels
{
	var $limit;
	var $prefix;

	function __construct()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$this->limit = 30;
		$this->view = 'question';

		//$this -> table_types = 'fs_news_types';
		$this->arr_img_paths = array(
			//array('resized',420,252,'resize_image'),
			array('small', 204, 122, 'cut_image'),
			array('large', 570, 343, 'cut_image')
		);
		$this->table_category_name = FSTable_ad::_('fs_question_categories');
		$this->table_name = FSTable_ad::_('fs_question');
		$this->table_link = 'fs_menus_createlink';
		$this->table_products = 'fs_question';
		$limit_created_link = 30;
		$this->limit_created_link = $limit_created_link;
		// config for save
		$cyear = date('Y');
		$cmonth = date('m');
		//$cday = date('d');
		$this->img_folder = 'images/question/' . $cyear . '/' . $cmonth;
		$this->check_alias = 0;
		$this->field_img = 'image';

		parent::__construct();
	}

	function setQuery()
	{
		// ordering
		$ordering = "";
		$where = "  ";
		if (isset($_SESSION[$this->prefix . 'sort_field'])) {
			$sort_field = $_SESSION[$this->prefix . 'sort_field'];
			$sort_direct = $_SESSION[$this->prefix . 'sort_direct'];
			$sort_direct = $sort_direct ? $sort_direct : 'asc';
			$ordering = '';
			if ($sort_field)
				$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
		}
		// estore
		if (isset($_SESSION[$this->prefix . 'filter0'])) {
			$filter = $_SESSION[$this->prefix . 'filter0'];
			if ($filter) {
				$where .= ' AND a.group_id =  "' . $filter . '" ';
			}
		}

		if (!$ordering)
			$ordering .= " ORDER BY date_created DESC , id DESC ";


		if (isset($_SESSION[$this->prefix . 'keysearch'])) {
			if ($_SESSION[$this->prefix . 'keysearch']) {
				$keysearch = $_SESSION[$this->prefix . 'keysearch'];
				$where .= " AND a.name LIKE '%" . $keysearch . "%' ";
			}
		}

		$query = " SELECT a.*
						  FROM 
						  	" . $this->table_name . " AS a
						  	WHERE 1=1 " .
			$where .
			$ordering . " ";
		return $query;
	}

	function save($row = array(), $use_mysql_real_escape_string = 1)
	{
		$name = FSInput::get('name');
		if (!$name){
			Errors::_('Bạn chưa nhập câu hỏi', 'error');
			return false;
		}
		$answers_title = FSInput::get('answers_title', array(), 'array');
		$haveAnswer = false;
		foreach($answers_title as $val)
			if (trim($val) != '')
				$haveAnswer = true;
		if (!$haveAnswer){
			Errors::_('Bạn chưa nhập đáp án', 'error');
			return false;
		}
		$group_id = FSInput::get('group_id', 0);
		if($group_id) {
			$cat_id = FSInput::get('cat_id', 0, 'int');
			$cat = $this->get_record_by_id($cat_id, 'fs_course_category');
			$row['cat_id'] = $cat->id;
			$row['category'] = $cat->name;
		}

		$user_id = isset($_SESSION['ad_userid']) ? $_SESSION['ad_userid'] : '';
		if (!$user_id)
			return false;

		$time = date('Y-m-d H:i:s');
		$row['published'] = 1;
		$user = $this->get_record_by_id($user_id, 'fs_users', 'username');

		$row['date_created'] = $row['lastedit_date'] = time();

        /* if($id){
            $row['created_time'] = $time;
            $row['end_time'] = $time;
            $row['author_last'] = $user->username;
            $row['author_last_id'] = $user_id;
        }else{
            $row['updated_time'] = $time;
            $row['end_time'] = $time;
            $row['start_time'] = $time;
            $row['author'] = $user->username;
            $row['author_id'] = $user_id;
        }*/

		$id = parent::save($row);

		$this->save_answers($id);

		return $id;
	}

	function save_answers($id)
	{
		$this->_remove('record_id = ' . intval($id), 'fs_question_answers');
		$answers_title = FSInput::get('answers_title', array(), 'array');
		$answers_true = FSInput::get('answers_true', array(), 'array');
		foreach ($answers_title as $key => $val) {
			if (trim($val) != '') {
				$data = array(
					'record_id' => $id,
					'answer' => trim($val),
					'true' => 0,
					'answer_hit' => 0
				);

				if (isset($answers_true[$key]))
					$data['true'] = intval($answers_true[$key]);

				$this->_add($data, 'fs_question_answers');
			}
		}
	}

	/*
     * select in category of home
     */
	function get_categories_tree()
	{
		global $db;
		$query = " SELECT a.*
						  FROM 
						  	" . $this->table_category_name . " AS a
						  	WHERE published = 1 ORDER BY ordering ";
		$sql = $db->query($query);
		$result = $db->getObjectList();
		$tree = FSFactory::getClass('tree', 'tree/');
		$list = $tree->indentRows2($result);
		return $list;
	}

	/*
     * Save all record for list form
     */
	function save_all()
	{
		$total = FSInput::get('total', 0, 'int');
		if (!$total)
			return true;
		$field_change = FSInput::get('field_change');
		if (!$field_change)
			return false;
		$field_change_arr = explode(',', $field_change);
		$total_field_change = count($field_change_arr);
		$record_change_success = 0;
		for ($i = 0; $i < $total; $i++) {
//	        	$str_update = '';
			$row = array();
			$update = 0;
			foreach ($field_change_arr as $field_item) {
				$field_value_original = FSInput::get($field_item . '_' . $i . '_original');
				$field_value_new = FSInput::get($field_item . '_' . $i);
				if (is_array($field_value_new)) {
					$field_value_new = count($field_value_new) ? ',' . implode(',', $field_value_new) . ',' : '';
				}

				if ($field_value_original != $field_value_new) {
					$update = 1;
					// category
					if ($field_item == 'category_id') {
						$cat = $this->get_record_by_id($field_value_new, $this->table_category_name);
						$row['category_id_wrapper'] = $cat->list_parents;
						$row['category_alias_wrapper'] = $cat->alias_wrapper;
						$row['category_name'] = $cat->name;
						$row['category_alias'] = $cat->alias;
						$row['category_id'] = $field_value_new;
					} else {
						$row[$field_item] = $field_value_new;
					}
				}
			}
			if ($update) {
				$id = FSInput::get('id_' . $i, 0, 'int');
				$str_update = '';
				global $db;
				$j = 0;
				foreach ($row as $key => $value) {
					if ($j > 0)
						$str_update .= ',';
					$str_update .= "`" . $key . "` = '" . $value . "'";
					$j++;
				}

				$sql = ' UPDATE  ' . $this->table_name . ' SET ';
				$sql .= $str_update;
				$sql .= ' WHERE id =    ' . $id . ' ';
				$db->query($sql);
				$rows = $db->affected_rows();
				if (!$rows)
					return false;
				$record_change_success++;
			}
		}
		return $record_change_success;


	}

	function get_linked_id()
	{
		$id = FSInput::get('id', 0, 'int');
		if (!$id)
			return;
		global $db;
		$query = " SELECT *
						FROM  " . $this->table_link . "
						WHERE published = 1
						AND id = $id 
						 ";
		$result = $db->getObject($query);

		return $result;
	}

	/*
     * get List data from table
     * for create link
     */
	function get_data_from_table($add_table, $add_field_display, $add_field_value, $add_field_distinct)
	{
		$query = $this->set_query_create_link($add_table, $add_field_display, $add_field_value, $add_field_distinct);
		if (!$query)
			return;
		global $db;
		$sql = $db->query_limit($query, $this->limit_created_link, $this->page);
		$result = $db->getObjectList();

		return $result;
	}

	function get_total_create_link($add_table, $add_field_display, $add_field_value, $add_field_distinct)
	{
		global $db;
		$query = $this->set_query_create_link($add_table, $add_field_display, $add_field_value, $add_field_distinct);

		$total = $db->getTotal($query);
		return $total;
	}

	function get_pagination_create_link($add_table, $add_field_display, $add_field_value, $add_field_distinct)
	{
		$total = $this->get_total_create_link($add_table, $add_field_display, $add_field_value, $add_field_distinct);
		$pagination = new Pagination($this->limit_created_link, $total, $this->page);
		return $pagination;
	}

	function set_query_create_link($add_table, $add_field_display, $add_field_value, $add_field_distinct)
	{
		$query = '';
		if ($add_field_distinct) {
			if ($add_field_display != $add_field_value) {
				echo "Khi đã chọn distinct, duy nhất chỉ xét một trường. Bạn hãy check lại trường hiển thị và trường dữ liệu";
				return false;
			}
			$query .= ' SELECT DISTINCT ' . $add_field_display . ' ';
		} else {
			$query .= ' SELECT ' . $add_field_display . ' ,' . $add_field_value . '  ';
		}
		$query .= ' FROM ' . $add_table;
		$query .= '	WHERE published = 1 ';
		return $query;
	}

	function get_answers($record_id = 0)
	{
		global $db;
		$query = '	SELECT *
					FROM fs_question_answers
					WHERE record_id = ' . $record_id.'
					ORDER BY id ASC';
		$db->query($query);
		return $db->getObjectList();
	}

	function get_groups(){
		global $db;
		$query = "SELECT a.*
				  FROM fs_question_groups AS a
				  WHERE published = 1 ORDER BY ordering ";
		$db->query($query);
		return $db->getObjectList();
	}

	function get_product_cats(){
		global $db;
		$query = "SELECT a.*
				  FROM fs_course_category AS a
				  WHERE active = 1 ORDER BY ordering ";
		$db->query($query);
		return $db->getObjectList();
	}
}