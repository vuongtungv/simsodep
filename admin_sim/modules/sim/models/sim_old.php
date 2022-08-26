<?php 
	class SimModelsSim extends FSModels
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
			$this -> img_folder = 'images/news/'.$cyear.'/'.$cmonth;
			$this -> check_alias = 0;
			$this -> field_img = 'image';
			
			parent::__construct();
		}
		
		function setQuery(){
			
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
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
            
            // from
    		if(isset($_SESSION[$this -> prefix.'text0']))
    		{
    			$date_from = $_SESSION[$this -> prefix.'text0'];
    			if($date_from){
    				$date_from = strtotime($date_from);
    				$date_new = date('Y-m-d H:i:s',$date_from);
    				$where .= ' AND created_time >=  "'.$date_new.'" ';
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
    				$where .= ' AND created_time <=  "'.$date_new.'" ';
    			}
    		}

    		// from
    		if(isset($_SESSION[$this -> prefix.'text2']))
    		{
    			$price_from = $_SESSION[$this -> prefix.'text2'];
    			if($price_from){
    				$where .= ' AND price >= '.$price_from.'';
    			}
    		}
    
    		// to
    		if(isset($_SESSION[$this -> prefix.'text3']))
    		{
    			$price_to = $_SESSION[$this -> prefix.'text3'];
    			if($price_to){
    				$where .= ' AND price <= '.$price_to.'';
    			}
    		}
			
			// estore
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND network_id = '.$filter.'';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter1 = $_SESSION[$this -> prefix.'filter1'];
				if($filter1){
					$where .= ' AND agency = '.$filter1.'';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'])){
				$filter2 = $_SESSION[$this -> prefix.'filter2'];
				if($filter2){
					$where .= " AND cat_id LIKE '%,".$filter2.",%' ";
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter3'])){
				$filter3 = $_SESSION[$this -> prefix.'filter3'];
				if($filter3){
					$where .= ' AND status = '.$filter3.'';
				}
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$key = $_SESSION[$this -> prefix.'keysearch'];
					// $arr_key = explode('*',$key);
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					// $where .= " AND (number LIKE '%".$keysearch."%' OR sim LIKE '%".$keysearch."%' )  ";
					$where .= " AND number LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT id, sim, number, price, created_time, network, status, admin_status, cat_name, agency_name, commission_value, price_public
						  FROM 
						  	".$this -> table_name."
						  	WHERE admin_status = 1 ".
						 $where. " ";
			return $query;
		}

	function getTotal($value='')
		{
			$query = $this->setQuery();
			$query = str_ireplace('id, sim, number, price, created_time, network, status, admin_status, cat_name, agency_name, commission_value, price_public','count(id)',$query);
			if(!$query)
				return ;
			global $db;
			$sql = $db->query($query);
			$total = $db->getResult();
			return $total;
		}

	function upload_csv($input_name){
		define ( "DEC_10", 10 ); //dành cho tính tổng nút sim
        global $db;
		$fileName = $_FILES[$input_name]["tmp_name"];

		if ($_FILES[$input_name]["size"] > 0) {
        
	        $file = fopen($fileName, "r");

	        $agency_id = FSInput::get('agency',0,'int');
			$agency_id = @$_SESSION['ad_type']==2 ? $_SESSION['ad_userid'] : $agency_id;
			if (!$agency_id) {
				$link = 'index.php?module=sim&view=sim&task=add';
				setRedirect($link,'Bạn cần chọn đại lý trước khi đăng sim');
			}

			$agency = $this->get_record('id ='.$agency_id,'fs_users','full_name,access');
			$agency_name = $agency->full_name;

			$admin_status = $_SESSION['ad_access']?$_SESSION['ad_access']:0;

            $time = date('Y-m-d H:i:s');

			 $sql = 'TRUNCATE TABLE fs_sim_'.$agency_id.';';
			// $db->query($sql);
			// $result = $db->affected_rows();

			$sql .= 'UPDATE fs_users SET last_update = "'.$time.'" WHERE id = '.$agency_id.';';
			$db->query($sql);
			$db->affected_rows();
			
			$sql = 'INSERT INTO fs_sim_'.$agency_id.' (sim, number, price, agency, agency_name, created_time, type, price_old, point, button , admin_status ) VALUES ';
			// $column = fgetcsv($file);
			$line = 1;
	        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
	        	if ($line == 1) {
	        		$line++;
	        		continue;
	        	}
	        	// var_dump($column);die;

	        	// Xử lý số sim hiển thị
	        	$outcome = @$column[0];
	        	// loại bỏ các ký tự trừ số và các dấu chỉ định
	        	// $outcome = preg_replace("/[^0-9._, ]/", "", $outcome);
	        	$outcome = preg_replace("/[^0-9. ]/", "", $outcome);
	        	// chuyển các ký tự trùng lặp về dấu .
				// $outcome = preg_replace('/\,{1,}/', '.', $outcome);
				// $outcome = preg_replace('/\_{1,}/', '.', $outcome);
				$outcome = preg_replace('/\ {1,}/', '.', $outcome);
				$outcome = preg_replace('/\.{1,}/', '.', $outcome);

				$outcome = trim($outcome,".");

				// cập nhật số sim ẩn
				$outnum = @$column[0];
				$outnum = preg_replace("/[^0-9]/", "", $outnum);
//                var_dump($outnum);die;
				// tổng điểm và tổng nút
				$point = $outnum;

				$point = $this->totalDigitsOfNumber($point);

				$button = ($point%100)%10;

				// Xử lý giá
				$price = preg_replace("/[., ]/", "", @$column[1]);

				$price_old = preg_replace("/[., ]/", "", @$column[2]);

				$type = @$column[3];

				// var_dump($column);
				// var_dump($button);
				// var_dump($point);die;

	            $sql .='("' . $outcome . '","' . $outnum . '","'. $price .'", "'.$agency_id.'", "'.$agency_name.'", "'.$time.'", "'.$type.'", "'.$price_old.'", "'.$point.'", "'.$button.'", "'.$admin_status.'") ,';

	        }

        	$sql = rtrim($sql,",");
        	// var_dump($sql);die;
            $db->query($sql);
			$result = $db->affected_rows();

			$link = 'index.php?module='.$this -> module.'&view=wait';
			setRedirect($link,'Có '.$result.' sim được bổ sung! Trường hợp có sim trùng với các đại lý khác, chúng tôi sẽ hiển thị sim có giá thấp nhất.');

	    }

	}

	function totalDigitsOfNumber($n) {
	    $total = 0;
	    do {
	        $total = $total + ($n % DEC_10);
	        $n = floor ( $n / DEC_10 );
	    } while ( $n > 0 );
	    return $total;
	}


	function save($row = array(), $use_mysql_real_escape_string = 1){
		$input_type = FSInput::get('type',0,'int');
		if($input_type == 2){  // excel
			// $count_sim_suc = $this -> upload_excel('excel');
			$count_sim_suc = $this -> upload_csv('excel');
				return $count_sim_suc;
		}else{
			$sims = FSInput::get('sims');
			if(!$sims)
				return false;

	        $agency_id = FSInput::get('agency',0,'int');
			$agency_id = @$_SESSION['ad_type']==2 ? $_SESSION['ad_userid'] : $agency_id;
			if (!$agency_id) {
				$link = 'index.php?module=sim&view=sim&task=add';
				setRedirect($link,'Bạn cần chọn đại lý trước khi đăng sim');
			}
			
			$list_sim = explode(PHP_EOL,$sims);
				
			$array_sim = array();
			foreach($list_sim as $item){
				if(!$item || !trim($item))
					continue;
				$item =  preg_replace('!\s+!', ' ', trim($item));
				$array_sim_info = explode(' ',$item);
				if(count($array_sim_info) < 2)
					continue;
				$str_sim_number = '';
				$c = 0;
				$k = 0;
				$sim_to_int = filter_var($item, FILTER_SANITIZE_NUMBER_INT);
				$length_sim = 11; // kiểu sim 10 hay 11 số
				if(strpos($sim_to_int,'09') === 0){
					$length_sim = 10;
				}
				foreach($array_sim_info as $str_sim){
					$b = filter_var($str_sim, FILTER_SANITIZE_NUMBER_INT);
					if(!$c){
						if($b[0] != 0){
							$b = '0'.$b;
							$str_sim = '0'.$str_sim;
						}
					}
					$c += strlen($b);
					if($c > $length_sim){
						$sim_number = $str_sim_number;
						break;
					}else{
						if($str_sim_number)
							$str_sim_number .= ' '.$str_sim;
						else 
							$str_sim_number .= $str_sim;
						$k ++;	
					}
				}
				$sim_price = 	$array_sim_info[$k];
				$array_sim[] = array('sim'=>$sim_number,'price'=>$sim_price);
			}
		}

		var_dump($array_sim);die;
		
		$time = date('Y-m-d H:i:s');
			
		// Các sim đã xử lý
		$array_sim_executed = array();
		$count_sim_suc = 0;
		$arr_buff_sims = array();
		$total_sims = count($array_sim);
		$i = 0;
		foreach($array_sim as $item){
			$i ++;
			$sim_number = 	$item['sim'];
			$sim_price = 	$item['price'];
			if(!$sim_number){
				Errors::setError ( $sim_number. ' bị lỗi ' );
				continue;
			}
					
			$row = array();
			$row['sim'] = $sim_number;

			$sim_number = $this -> convert_to_number($sim_number);
			// $unit_price = FSInput::get('unit_price');
			$price = $this -> standart_money($sim_price);
	
			$array_sim_executed[] = $sim_number;

			$row['number'] = $sim_number;

			// Đại lý

		 	if(isset($_SESSION['ad_type']) && $_SESSION['ad_type']==2){
    			$row ['agency'] = $_SESSION['ad_userid'];
				$row ['agency_name'] = $_SESSION['ad_full_name'];
		    }else{
				$agency_id = FSInput::get('agency',0,'int');
				if($agency_id){
					$agency = $this->get_record_by_id($agency_id,'fs_users');
					$row ['agency'] = $agency->id;
					$row ['agency_name'] = $agency->full_name;
				}
		    }


			$row['price'] = $price;
			$row['created_time'] = $time;
			$row['edited_time'] = $time;

			// $row['unit_price'] = $unit_price;
			$row['public_time'] = FSInput::get('public_time');
			$row['status'] = 0;
			$row['admin_status'] = 0;
			
			// var_dump($row);die;
			// kiểm tra trùng lặp với db
			$arr_buff_sims[] = $row;
			if($count_sim_suc % 500 == 0 || $i == $total_sims){
				$rs = $this -> _add_multi($arr_buff_sims, 'fs_sim');
				$arr_buff_sims = array();
			}
			$count_sim_suc ++;
		}

		$link = 'index.php?module='.$this -> module.'&view=wait';
		setRedirect($link,'Có '.$count_sim_suc.' sim được bổ sung! Trường hợp có sim trùng với các đại lý khác, chúng tôi sẽ hiển thị sim có giá thấp nhất.');
	}

	function upload_excel($input_name){


		$fsFile = FSFactory::getClass('FsFiles');
		// upload
		$path =  PATH_BASE.'images'.DS.'excel'.DS;
		$excel = $fsFile -> uploadExcel($input_name, $path,20000000000, '_'.time());
		
		if(	!$excel){
			return false;
		}
		else{

			$file_path = $path.$excel;
	        require(PATH_BASE.'libraries/PHPExcel/PHPExcel.php');
	        $objPHPExcel = PHPExcel_IOFactory::load($file_path);
	        $objPHPExcel->setActiveSheetIndex(0);
	        $sheet = $objPHPExcel->getActiveSheet();
	        $numberRow = $sheet->getHighestRow();
	        $count_sim_upaload = 0;

            $agency_id = FSInput::get('agency',0,'int');
			$agency_id = @$_SESSION['ad_type']==2 ? $_SESSION['ad_userid'] : $agency_id;
            $time = date('Y-m-d H:i:s');

	        $sql = 'INSERT INTO fs_sim_'.$agency_id.' (sim, price, agency, created_time) VALUES ';

	        for($row = 2; $row <= $numberRow; $row++){
	            $data = array(
	                'sim' => $sheet->getCell('A'.$row)->getValue(),
	                'price' => '0'.ltrim($sheet->getCell('B'.$row)->getValue(), '0'),
	            );

                $sql .='("'.$data['sim'].'", "'.$data['price'].'", "'.$agency_id.'", "'.$time.'")';
                if ($row<$numberRow) {
                	$sql .=',';
                }

				$count_sim_upaload++;
	        }
            // var_dump($sql);die;
            global $db;
            $db->query($sql);
			$row = $db->affected_rows();

			$link = 'index.php?module='.$this -> module.'&view=wait';
			setRedirect($link,'Có '.$count_sim_upaload.' sim được bổ sung! Trường hợp có sim trùng với các đại lý khác, chúng tôi sẽ hiển thị sim có giá thấp nhất.');
		}
	}

	function get_cell_content($data,$sheet_index,$row_index,$col_index){
		$content = isset($data->sheets[$sheet_index]['cells'][$row_index][$col_index])?$data->sheets[$sheet_index]['cells'][$row_index][$col_index]:'';
		return $content;
	}

	function convert_exel($info_import_product,$agency) {
		$sim_input_exel = $info_import_product;
		
		$time = date('Y-m-d H:i:s');
		
		// Các sim đã xử lý
		$array_sim_executed = array();
		$arr_buff_sims = array();
	
		if($sim_input_exel){
			
			$sim_number = 	$sim_input_exel['sim'];
			$sim_price = 	$sim_input_exel['price'];

			$row = array();
			$row['sim'] = $sim_number;

			// $sim_number = $this -> convert_to_number($sim_number);
			
			// $sim_price = $this -> standart_money($sim_price);
				
			// $row['number'] = $sim_number;

			$agency_id = FSInput::get('agency',0,'int');
			$row ['agency'] = @$_SESSION['ad_type']==2 ? $_SESSION['ad_userid'] : $agency_id;

	
			// if(isset($_SESSION['ad_type']) && $_SESSION['ad_type']==2){
   //  			$row ['agency'] = $_SESSION['ad_userid'];
			// 	$row ['agency_name'] = $_SESSION['ad_full_name'];
		 //    }else{
			// 	$agency_id = FSInput::get('agency',0,'int');
			// 	if($agency_id){
			// 		$agency = $this->get_record_by_id($agency_id,'fs_users');
			// 		$row ['agency'] = $agency->id;
			// 		$row ['agency_name'] = $agency->full_name;
			// 	}
		 //    }

			$row['price'] = $sim_price;
			$row['created_time'] = $time;
			// $row['edited_time'] = $time;

			// $row['public_time'] = FSInput::get('public_time');
			// $row['status'] = 0;
			// $row['admin_status'] = 0;

		}
		return $row;
	}

	function convert_to_number($sim_number){
		$sim_number = str_replace(',','' , trim($sim_number));
		$sim_number = str_replace('+84','' , trim($sim_number));
		$sim_number = str_replace(' ','' , $sim_number);
		$sim_number = str_replace('.','' , $sim_number);
		$sim_number = intval($sim_number);
		$sim_number = '0'.$sim_number;
		return $sim_number;
	}

	function standart_money($money){
		$money = str_replace(',','' , trim($money));
		$money = str_replace(' ','' , $money);
		$money = str_replace('.','' , $money);
		$money = (double)($money);

		return $money;
	}
	
	function check_sim($sim_number){
		$sim_number = $this -> convert_to_number($sim_number);
		if(strlen($sim_number) < 10 || strlen($sim_number) > 11 )
			return false;
		return true;
	}
		
		/*
	     * Save all record for list form
	     */
	    function save_all(){
	        $total = FSInput::get('total',0,'int');
	        if(!$total)
	           return true;
	        $field_change = FSInput::get('field_change');
	        if(!$field_change)
	           return false;
	        $field_change_arr = explode(',',$field_change);
	        $total_field_change = count($field_change_arr);
	        $record_change_success = 0;
	        for($i = 0; $i < $total; $i ++){
//	        	$str_update = '';
	        	$row = array();
	        	$update = 0;
	        	foreach($field_change_arr as $field_item){
	        	      $field_value_original = FSInput::get($field_item.'_'.$i.'_original')	;
	        	      $field_value_new = FSInput::get($field_item.'_'.$i)	;
	        		  if(is_array($field_value_new)){
        	      		$field_value_new = count($field_value_new)?','.implode(',',$field_value_new).',':'';
	        	      }
	        	      
	        	      if($field_value_original != $field_value_new){
	        	          $update =1;
	        	       		// category
	        	          if($field_item == 'category_id'){
	        	          		$cat =  $this->get_record_by_id($field_value_new,$this -> table_category_name);
								$row['category_id_wrapper'] = $cat -> list_parents;
								$row['category_alias_wrapper'] = $cat -> alias_wrapper;
								$row['category_name'] = $cat -> name;
								$row['category_alias'] = $cat -> alias;
								$row['category_id'] = $field_value_new;
	        	          }else{
								$row[$field_item] = $field_value_new;
	        	          }
	        	      }    
	        	}
	        	if($update){
	        		$id = FSInput::get('id_'.$i, 0, 'int'); 
	        		$str_update = '';
	        		global $db;
	        		$j = 0;
	        		foreach($row as $key => $value){
	        			if($j > 0)
	        				$str_update .= ',';
	        			$str_update .= "`".$key."` = '".$value."'";
	        			$j++;
	        		}
            
		            $sql = ' UPDATE  '.$this ->  table_name . ' SET ';
		            $sql .=  $str_update;
		            $sql .=  ' WHERE id =    '.$id.' ';
		            $db->query($sql);
		            $rows = $db->affected_rows();
		            if(!$rows)
		                return false;
		            $record_change_success ++;
	        	}
	        }
	        return $record_change_success;  
	           
	        
	    }
        function get_linked_id()
		{
			$id = FSInput::get('id',0,'int');
			if(!$id)
				return;
			global $db;
			$query = " SELECT *
						FROM  ".$this -> table_link."
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
		function get_data_from_table($add_table,$add_field_display,$add_field_value,$add_field_distinct){
			$query = $this -> set_query_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct);
			if(!$query)
				return;
			global $db;
			$sql = $db->query_limit($query,$this->limit_created_link,$this->page);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		function get_total_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct){
			global $db;
			$query = $this -> set_query_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct);

			$total = $db->getTotal($query);
			return $total;
		}
		
		function get_pagination_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct)
		{
			$total = $this->get_total_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct);		
			$pagination = new Pagination($this->limit_created_link,$total,$this->page);
			return $pagination;
		}
        function set_query_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct){
			$query  = '';
			if($add_field_distinct){
				if($add_field_display != $add_field_value){
					echo "Khi đã chọn distinct, duy nhất chỉ xét một trường. Bạn hãy check lại trường hiển thị và trường dữ liệu";
					return false;
				}
				$query .= ' SELECT DISTINCT '.$add_field_display. ' ';
			} else {
				$query .= ' SELECT '.$add_field_display. ' ,' . $add_field_value.'  ';
			}
			$query .= ' FROM '.$add_table ;
			$query .= '	WHERE published = 1 ';
			return $query;
		}
        
        function get_products_related($product_related){
    		if(!$product_related)
    				return;
    		$query   = ' SELECT id, name,image 
    					FROM '.$this -> table_products.'
    					WHERE id IN (0'.$product_related.'0) 
    					 ORDER BY POSITION(","+id+"," IN "0'.$product_related.'0")
    					';
    		global $db;
    		$sql = $db->query($query);
    		$result = $db->getObjectList();
    		return $result;
    	}
	}
	
?>