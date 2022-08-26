<?php

//    require PATH_BASE.'libraries/elasticsearch/vendor/elasticsearch/elasticsearch/src/Elasticsearch/ClientBuilder.php';
    use Elasticsearch\ClientBuilder;
    require PATH_BASE.'libraries/elasticsearch/vendor/autoload.php';
    $hosts = [
        [
            'host' => 'localhost',          //yourdomain.com
            'port' => '9200',
            'scheme' => 'http',             //https
            //        'path' => '/elastic',
            //        'user' => 'username',         //nếu ES cần user/pass
            //        'pass' => 'password!#$?*abc'
        ],

    ];

	class SimModelsSearch extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
		    date_default_timezone_set('Asia/Ho_Chi_Minh');  
			$this -> limit = 30;
			$this -> view = 'sim';
			$this -> arr_img_paths = array(
                                            array('resized',226,135,'resize_image'),
                                            array('small',212,128,'cut_image'),
                                            array('large',462,280,'resize_image')
                                        );
			$this -> table_category_name = FSTable_ad::_('fs_news_categories');
            $this -> table_name = FSTable_ad::_('fs_sim');
            $this -> table_link = 'fs_menus_createlink';
            $this -> table_products = 'fs_products';
            $limit_created_link = 30;
			$this->limit_created_link = $limit_created_link;
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			//$cday = date('d');
			
			parent::__construct();
		}

		function getPagination($value = '')
		{
	        $total = $value? $value:$this->getTotal($value);  
            $pagination = new Pagination($this->limit,$total,$this->page);
            return $pagination;
		} 

		function get_note(){
			global $db;
			$where = '';
			if(isset($_SESSION['sim'])){
				$keyword = $_SESSION['sim'];
				$where = ' WHERE sim = "'.$keyword.'"';
			}
			$query = "  SELECT *
					FROM fs_history_sim ".$where."
					Order by created_time DESC Limit 20 
					";
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function save_note() {
			$time = date("Y-m-d H:i:s");
			$product_note = FSInput::get('product_note');
			$phone_note = FSInput::get('phone_note');
			$note_note = FSInput::get('note_note');

			$row['sim'] = $product_note;
			$row['phone'] = $phone_note;
			$row['note'] = $note_note;
			$row['user_id'] = $_SESSION['ad_userid'];
			$row['user_name'] = $_SESSION['ad_username'];
			$row['created_time'] = $time ;

			// var_dump($row);die;

			$id = $this -> _add($row, 'fs_history_sim');
			return $id;

		}

		function get_data($value = '')
		{
			return '';
		}
		
		function setQuery(){
			return '';
		}

		function getTotal($value='')
		{
			return '';
		}
		
		/*
	     * Save all record for list form
	     */
        function save_all(){
            $client = ClientBuilder::create()->setHosts($hosts)->build();
            $total = FSInput::get('total',0,'int');
            if(!$total)
            return true;
            global $db;
            $field_change = FSInput::get('field_change');
            if(!$field_change)
            return false;
            // 	calculate filters:
            $arr_table_name_changed = array();

            $field_change_arr = explode(',',$field_change);
            $total_field_change = count($field_change_arr);
            $record_change_success = 0;
            for($i = 0; $i < $total; $i ++){
                $str_update = '';
                $update = 0;
                $row = array();
                foreach($field_change_arr as $field_item){
                    $field_value_original = FSInput::get($field_item.'_'.$i.'_original')	;
                    $field_value_new = FSInput::get($field_item.'_'.$i)	;
                    if(is_array($field_value_new)){
                        $field_value_new = count($field_value_new)?','.implode(',',$field_value_new).',':'';
                    }

                    if($field_value_original != $field_value_new){
                        $update =1;
                        $row[$field_item] = $db -> escape_string($field_value_new);
                        $row[$field_item] = $row[$field_item] == NUll ? 0:$row[$field_item];
                    }
                }
                if($update){
                    $id = FSInput::get('id_'.$i, 0, 'int');

                    $sim = $this->get_record('id = '.$id,'fs_sim','agency,number');
                    $must_item = array('_id'=>$sim->agency.'-'.$sim->number);
                    $must_arr = array('term'=>$must_item);
                    $must['should'][] = $must_arr;

                    $query['bool'] = $must;
                    $body['query'] = $query;
                    $body['script'] = [
                        'source' => 'ctx._source.status  = params.value',
                        'params' => [
                            'value' => $row['status']
                        ]
                    ];
                    $params = [
                        'index' => 'fs',
                        'type' => 'simsodep',
                        'body' => $body
                    ];

                    $results = $client->updateByQuery($params);
                    $rs = $this -> _update($row,$this ->  table_name, '  id = '.$id,0 );
                    if(!$rs)
                        return false;
                    $record_change_success ++;
                }
            }

            // calculate filters:
//			if($this -> calculate_filters){
//				$this -> caculate_filter($arr_table_name_changed);
//			}
            return $record_change_success;
        }
	}
	
?>