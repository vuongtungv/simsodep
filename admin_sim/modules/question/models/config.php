<?php 
class QuestionModelsConfig   extends FSModels{

	function __construct(){
		parent::__construct();
		$this->name_table = 'fs_question_config';
	}

	function getData(){
		global $db;
		$query = $this->setQuery();
		if (!$query)
			return array();
		$db->query($query);
		return $db->getObjectList();
	}

	function setQuery(){
		$query = "SELECT *
				  FROM ".$this->name_table."
				  WHERE published = 1
				  ORDER BY ordering";
		return $query;
	}

	function save($row = array(), $use_mysql_real_escape_string = 0){
		global $db;
		$data = $this->getData();
		$fsFile = FSFactory::getClass('FsFiles');
		foreach ($data as $item) {
			if($item->name == 'groups'){
				$number_questions = FSInput::get("number_questions", 0, 0);
				$value = FSInput::get("$item->name", array(), 'array');
				$total = array_sum($value);
				if($total > $number_questions){
					Errors::_(FSText::_('Số câu hỏi trong các nhóm > tổng số câu hỏi'), 'error');
					return false;
				}
				$value = serialize($value);
			}else {
				if ($item->data_type == 'editor')
					$value = htmlspecialchars_decode(FSInput::get("$item->name"));
				else if ($item->data_type == 'image') {
					if (isset($_FILES[$item->name]['name']) && !empty($_FILES[$item->name]['name'])) {
						$path = PATH_BASE . 'images' . DS . 'config' . DS;
						$image = $fsFile->uploadImage($item->name, $path, 2000000, '_' . time());
						if (!$image)
							continue;
						$value = 'images/config/' . $image;
					} else {
						continue;
					}
				} else
					$value = FSInput::get("$item->name");
			}
			$sql = "UPDATE ".$this->name_table." SET
					value = '$value'
					WHERE name = '$item->name'";
			$db->query($sql);
			$rows = $db->affected_rows();
		}
		return true;
	}

	function get_groups(){
		global $db;
		$query = "SELECT a.*
				  FROM fs_question_groups AS a
				  WHERE published = 1 ORDER BY ordering ";
		$db->query($query);
		return $db->getObjectList();
	}
}