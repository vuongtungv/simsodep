<?php
/**
 * @author vangiangfly
 * @final 21/04/2013
 */ 
class QuestionModelsGroup extends FSModels
{
    var $limit;
    var $prefix;
    function __construct()
    {
        parent::__construct();
        $this->limit = 20;
        $this->view = 'group';
        $this->table_types = 'group';
        $this->table_name = 'fs_question_groups';
        $this->check_alias = 0;
    }
    function setQuery()
    {
        $ordering = "";
        $where = "  ";
        if (isset($_SESSION[$this->prefix . 'sort_field']))
        {
            $sort_field = $_SESSION[$this->prefix . 'sort_field'];
            $sort_direct = $_SESSION[$this->prefix . 'sort_direct'];
            $sort_direct = $sort_direct ? $sort_direct : 'asc';
            $ordering = '';
            if ($sort_field)
                $ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
        }
        if (!$ordering)
            $ordering .= " ORDER BY created_time DESC , id DESC ";
        if (isset($_SESSION[$this->prefix . 'keysearch']))
        {
            if ($_SESSION[$this->prefix . 'keysearch'])
            {
                $keysearch = $_SESSION[$this->prefix . 'keysearch'];
                $where .= " AND a.title LIKE '%" . $keysearch . "%' ";
            }
        }
        $query = "  SELECT a.*
                    FROM 
                    " . $this->table_name . " AS a
                    WHERE 1=1 " . $where . $ordering . " ";
        return $query;
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
        for ($i = 0; $i < $total; $i++){
            $row = array();
            $update = 0;
            foreach ($field_change_arr as $field_item)
            {
                $field_value_original = FSInput::get($field_item . '_' . $i . '_original');
                $field_value_new = FSInput::get($field_item . '_' . $i);
                if (is_array($field_value_new))
                {
                    $field_value_new = count($field_value_new) ? ',' . implode(',', $field_value_new) .
                        ',' : '';
                }
                if ($field_value_original != $field_value_new)
                {
                    $update = 1;
                    $row[$field_item] = $field_value_new;
                }
            }
            if ($update)
            {
                $id = FSInput::get('id_' . $i, 0, 'int');
                $str_update = '';
                global $db;
                $j = 0;
                foreach ($row as $key => $value)
                {
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
}