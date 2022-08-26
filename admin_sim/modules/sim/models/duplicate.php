<?php 
	class SimModelsDuplicate extends FSModels
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
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND number LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT id, sim, number, price, created_time, network, network_id, status, admin_status, agency, agency_name, cat_id, cat_type, cat_alias, cat_name, commission, commission_value, price_public
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE admin_status = 3 ".
						 $where.
						 $ordering. " ";
			return $query;
		}

		function getTotal($value='')
		{
			$query = $this->setQuery();
			$query = str_ireplace('id, sim, number, price, created_time, network, network_id, status, admin_status, agency, agency_name, cat_id, cat_type, cat_alias, cat_name, commission, commission_value, price_public','count(id)',$query);
			if(!$query)
				return ;
			global $db;
			$sql = $db->query($query);
			$total = $db->getResult();
			return $total;
		}
		
		// function save($row = array(), $use_mysql_real_escape_string = 1){
		// 	$title = FSInput::get('title');		
		// 	if(!$title)
		// 		return false;
		// 	$id = FSInput::get('id',0,'int');	
		// 	$category_id = FSInput::get('category_id',0,'int');
		// 	if(!$category_id){
		// 		Errors::_('Bạn phải chọn danh mục');
		// 		return;
		// 	}
			
		// 	$cat =  $this->get_record_by_id($category_id,$this -> table_category_name);
		// 	$row['category_id_wrapper'] = $cat -> list_parents;
		// 	$row['category_alias_wrapper'] = $cat -> alias_wrapper;
		// 	$row['category_name'] = $cat -> name;
		// 	$row['category_alias'] = $cat -> alias;
            
     
			
		// 	$row['content'] = htmlspecialchars_decode(FSInput::get('content'));
		// 	$time = date('Y-m-d H:i:s');
  //           $row['published'] = 1;

  //           $user_id = isset($_SESSION['ad_userid'])? $_SESSION['ad_userid']:'';
  //           if(!$user_id)
  //               return false;
                
  //           $user = $this->get_record_by_id($user_id,'fs_users','username');
  //           if($id){
  //         		$row['updated_time'] = $time;
  //               $row['end_time'] = $time;
  //               $row['author_last'] = $user->username;
  //               $row['author_last_id'] = $user_id;
  //           }else{
  //           	$row['created_time'] = $time;
  //           	$row['updated_time'] = $time;
  //               $row['end_time'] = $time;
  //               $row['start_time'] = $time;
  //               $row['author'] = $user->username;
  //               $row['author_id'] = $user_id;
  //           }
            
  //           $fsstring = FSFactory::getClass('FSString','','../');
  //           $alias = $fsstring -> stringStandart($title);
		// 	$rs = parent::save($row);

  //           return $rs;
		// }

		function save($row = array(), $use_mysql_real_escape_string = 1){
		$input_type = FSInput::get('type',0,'int');
		if($input_type == 2){  // excel
			$count_sim_suc = $this -> upload_excel('excel');
				return $count_sim_suc;
		}else{
			$sims = FSInput::get('sims');
			if(!$sims)
				return false;
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
		include_once 'sim_object.php';
		$sim_object = new Sims();
		
		$time = date('Y-m-d H:i:s');
		
		// Đại lý
		// $agency_id = FSInput::get('agency',0,'int'); 
		// if(!$agency_id){
		// 	Errors::setError ('Bạn phải chọn đại lý ' );
		// 	return;
		// }
		// $agency = $this->get_record_by_id ( $agency_id, 'fs_agencies' );
			
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
				
			if(!$this -> check_sim($sim_number)){
				Errors::setError ( $sim_number. ' không đúng định dạng ' );
				continue;
			}
					
			$row = array();
			$row['sim'] = $sim_number;
			$sim_number = $this -> convert_to_number($sim_number);
			// kiểm tra trùng lặp so với các sim cùng import
			if(in_array($sim_number, $array_sim_executed)){
				Errors::setError ( $sim_number. ' bị trùng ' );
				continue;
			}else{
				$array_sim_executed[] = $sim_number;
			}
			
			$row['number'] = $sim_number;
			// $row ['agency'] = $agency_id;
			// $row ['agency_alias'] = $agency->alias;
			// $row ['agency_name'] = $agency->name;
			// $row ['is_own'] = $agency->is_own;
			$row['price'] = $sim_price;
			$row['created_time'] = $time;
			$row['edited_time'] = $time;

			$row['unit_price'] = FSInput::get('unit_price');
			$row['public_time'] = FSInput::get('public_time');
			
			// kiểm tra trùng lặp với db
			$arr_buff_sims[] = $row;
			if($count_sim_suc % 500 == 0 || $i == $total_sims){
				$rs = $this -> _add_multi($arr_buff_sims, 'fs_sim');
				$arr_buff_sims = array();
			}
			$count_sim_suc ++;
		}

		$link = 'index.php?module='.$this -> module.'&view='.$this -> view.'&task=wait';
		setRedirect($link,'Có '.$count_sim_suc.' sim được bổ sung! Trường hợp có sim trùng với các đại lý khác, chúng tôi sẽ hiển thị sim có giá thấp nhất.');
	}

	function upload_excel($input_name){
		// Đại lý
		// $agency_id = FSInput::get('agency',0,'int'); 
		// if(!$agency_id){
		// 	Errors::setError ('Bạn phải chọn đại lý ' );
		// 	return;
		// }
		// $agency = $this->get_record_by_id ( $agency_id, 'fs_agencies' );
		$fsFile = FSFactory::getClass('FsFiles');
		// upload
		$path =  PATH_BASE.'images'.DS.'excel'.DS;
		$excel = $fsFile -> uploadExcel($input_name, $path,20000000, '_'.time());
		
		if(	!$excel){
			return false;
		}
		else{
			// var_dump(1);die;
		
			$file_path = $path.$excel;
			require_once("../libraries/excel/phpExcelReader/Excel/reader.php");
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('UTF-8');
			$data->read($file_path);
			unset($total_product);					
			$total_product =count($data->sheets[0]['cells']);
			unset($j);
			$count_sim_upaload = 0;
			for($j=2;$j<=$total_product;$j++){
				$info_import_product = array();
				$sim = trim($this->get_cell_content($data,0,$j,1));
				if(@$sim[0] != '0')
					$sim = '0'.$sim;
				$info_import_product['sim'] = $sim;	
				$info_import_product['price'] =  preg_replace('/[^0-9]+/i','',$this->get_cell_content($data,0,$j,2));
				$upload_exel =$this->convert_exel($info_import_product,'');
				if(!$upload_exel){
					continue;
				}else{	
					$arr_buff_sims[] = $upload_exel;
					if($count_sim_upaload % 200 == 0 || $j == $total_product){
						$rs = $this -> _add_multi($arr_buff_sims, 'fs_sim');
						$arr_buff_sims = array();
					}
					$count_sim_upaload++;
				}
				
				
			}

			$link = 'index.php?module='.$this -> module.'&view='.$this -> view.'&task=wait';
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
			$sim_number = $this -> convert_to_number($sim_number);
			
				
				
			$row['number'] = $sim_number;
	
			// $row ['agency'] = $agency->id;
			// $row ['agency_alias'] = $agency->alias;
			// $row ['agency_name'] = $agency->name;
			// $row ['is_own'] = $agency->is_own;

			$row['price'] = $sim_price;
			$row['created_time'] = $time;
			$row['edited_time'] = $time;

			$row['unit_price'] = FSInput::get('unit_price');
			$row['public_time'] = FSInput::get('public_time');

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
	
	function check_sim($sim_number){
		$sim_number = $this -> convert_to_number($sim_number);
		if(strlen($sim_number) < 10 || strlen($sim_number) > 11 )
			return false;
		return true;
	}
        
        function get_news_related($news_related){
    		if(!$news_related)
    				return;
    		$query   = " SELECT id, title,image 
    					FROM ".$this -> table_name."
    					WHERE id IN (0".$news_related."0) 
    					 ORDER BY POSITION(','+id+',' IN '0".$news_related."0')
    					";
    		global $db;
    		$sql = $db->query($query);
    		$result = $db->getObjectList();
    		return $result;
    	}
        /*
		 *==================== AJAX RELATED news==============================
		 */
	
    	function ajax_get_news_related(){
    		$news_id = FSInput::get('new_id',0,'int');
            // category_id danh muc
    		$category_id = FSInput::get('category_id',0,'int');
            // tim kiem keyword
    		$keyword = FSInput::get('keyword');
            $keyword_tag = FSInput::get('keyword_tag');
            // chuoi id tin lien quan keyword tag
            $str_related = FSInput::get('str_related');
            // id khi click vao xoa tin lien quan
            $id = FSInput::get('id',0,'int');
            
    		$where = ' WHERE published = 1 ';
            
    		if($category_id){
    			$where .= ' AND (category_id_wrapper LIKE "%,'.$category_id.',%"	) ';
    		}
            if($keyword){
                $where .= " AND ( title LIKE '%".$keyword."%' OR alias LIKE '%".$keyword."%' OR content LIKE '%".$keyword."%' )";
            }
    		if($keyword_tag){
    		    $keyword_tag = explode(',',$keyword_tag);
                //$keyword_tag = str_replace(',','',$keyword_tag);
                $total = count($keyword_tag);
                $where .= ' AND ( ';
                for($i=0;$i<$total;$i++){
                    if($i == 0){
                        $where .= " title LIKE '%".$keyword_tag[$i]."%' OR alias LIKE '%".$keyword_tag[$i]."%' OR content LIKE '%".$keyword_tag[$i]."%' ";
                    }else{
                       $where .= " OR title LIKE '%".$keyword_tag[$i]."%' OR alias LIKE '%".$keyword_tag[$i]."%' OR content LIKE '%".$keyword_tag[$i]."%' ";
                    }
                }
                $where .= ' ) '; 
            }
            if($str_related){
                if($id){
                    $str_related = str_replace(','.$id,'',$str_related);
                }
                $where .= ' AND id NOT IN(0'.$str_related.'0) ';
            }
    		
    		$query_body = ' FROM '.$this -> table_name.' '.$where;
    		$ordering = " ORDER BY created_time DESC , id DESC ";
    		$query = ' SELECT id,category_id,title,category_name,image'.$query_body.$ordering.' LIMIT 100 ';
            //print_r($query);
    		global $db;
    		$sql = $db->query($query);
    		$result = $db->getObjectList();
    		return $result;
    	}
		
		/*
		 * select in category of home
		 */
		function get_categories_tree()
		{
			global $db;
			$query = " SELECT *
						  FROM 
						  	".$this -> table_category_name." AS a
						  	WHERE published = 1 ORDER BY ordering ";         
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			return $list;
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