<?php

    require PATH_BASE.'libraries/elasticsearch/vendor/elasticsearch/elasticsearch/src/Elasticsearch/ClientBuilder.php';
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

	class CronjobControllersCronjob extends FSControllers
	{
		var $module;
		var $view;

		function __construct()
		{
			// $this -> limit = 40;
			// $this -> view = 'order';
			// $this -> table_name = 'fs_order';
			$array_status = array( 
                                9 => FSText::_('Mới'),
                                1 => FSText::_('Đang kiểm tra'),
                                2 =>FSText::_('Giao dịch xong'),
                                3 =>FSText::_('Bán rồi đã báo'),
                                4 =>FSText::_('Bán rồi chưa báo'),
                                5 =>FSText::_('Vẫn còn chưa báo'),
                                6 =>FSText::_('Vẫn còn đã báo'),
                                7 =>FSText::_('Không gọi được'),
                                8 =>FSText::_('Hủy'),
                                11 =>FSText::_('Đang giao dịch'),
                                12 =>FSText::_('Khách hàng hẹn'),
                                );
			$this -> arr_status = $array_status;
			parent::__construct();
		}

		// cập nhật trạng thái sim theo đơn hàng
		function update_status_order(){
			$model = $this -> model;
			$users = $model->get_records('','fs_order','id,status,code,products_id,created_time,edited_time,date_appointment','id DESC');
			$time_now = time();
			global $db;
			$client = ClientBuilder::create()->setHosts($hosts)->build();


			foreach (@$users as $key) {
				// echo '<pre>',print_r($key),'</pre>';
				switch ($key->status) {

					// đơn hàng mới ,Sau 07 ngày sẽ được hiển thị lại ở ngoài web
					case 9:

						$limit = 7; 

						$time_order = strtotime($key->created_time);

						$time = ($time_now - $time_order)/86400;

						// echo '<pre>',print_r(date('Y-m-d H:i:s', $time_order)),'</pre>';

						// echo '<pre>',print_r($item),'</pre>';
						// echo '<pre>',print_r($time_now),'</pre>';
						// echo '<pre>',print_r($time_order),'</pre>';
						// echo '<pre>',print_r($time),'</pre>';

						// die;

						$list_id = explode(',', $key->products_id);

						if ($time > $limit) {

							foreach ($list_id as $item ) {

								$sim = $model->get_record('id = '.$item,'fs_sim','agency,number');
								if ($sim) {
									$must = array(); $query = array();
									$must_item = array('_id'=>$sim->agency.'-'.$sim->number);
									$must_arr = array('term'=>$must_item);
									$must['must'][] = $must_arr;

									$query['bool'] = $must;
									$body['query'] = $query;
									$body['script'] = [
										'source' => 'ctx._source.status  = params.value',
										'params' => [
											'value' => 0
										]
									];
									$params = [
										'index' => 'fs',
										'type' => 'simsodep',
										'body' => $body
									];

									$results = $client->updateByQuery($params);

									// echo '<pre>',print_r($params['body'],1),'</pre>';

									$query = " UPDATE fs_sim set status = 0 WHERE id = ".$item;
									$db->query($query);
									$his = $db->affected_rows();
								}
							}
						}

						break;

					// đang kiểm tra ,Sau 01 ngày sẽ được hiển thị lại ở ngoài web
					case 1:

						$limit = 1; 
						$time_order = strtotime($key->edited_time);
						$time = ($time_now - $time_order)/86400;

						$list_id = explode(',', $key->products_id);

						if ($time > $limit) {

							foreach ($list_id as $item ) {

								$sim = $model->get_record('id = '.$item,'fs_sim','agency,number');

								if ($sim) {
									$must = array(); $query = array();
									$must_item = array('_id'=>$sim->agency.'-'.$sim->number);
									$must_arr = array('term'=>$must_item);
									$must['must'][] = $must_arr;

									$query['bool'] = $must;
									$body['query'] = $query;
									$body['script'] = [
										'source' => 'ctx._source.status  = params.value',
										'params' => [
											'value' => 0
										]
									];
									$params = [
										'index' => 'fs',
										'type' => 'simsodep',
										'body' => $body
									];

									$results = $client->updateByQuery($params);

									// echo '<pre>',print_r($params['body'],1),'</pre>';

									$query = " UPDATE fs_sim set status = 0 WHERE id = ".$item;
									$db->query($query);
									$his = $db->affected_rows();
								}
							}
						}

						break;

					// Đang giao dịch ,Sau 01 ngày sẽ được hiển thị lại ở ngoài web
					case 11:

						$limit = 2; 
						$time_order = strtotime($key->edited_time);
						$time = ($time_now - $time_order)/86400;

						$list_id = explode(',', $key->products_id);

						if ($time > $limit) {

							foreach ($list_id as $item ) {

								$sim = $model->get_record('id = '.$item,'fs_sim','agency,number');
								if ($sim) {
									$must = array(); $query = array();
									$must_item = array('_id'=>$sim->agency.'-'.$sim->number);
									$must_arr = array('term'=>$must_item);
									$must['must'][] = $must_arr;

									$query['bool'] = $must;
									$body['query'] = $query;
									$body['script'] = [
										'source' => 'ctx._source.status  = params.value',
										'params' => [
											'value' => 0
										]
									];
									$params = [
										'index' => 'fs',
										'type' => 'simsodep',
										'body' => $body
									];

									$results = $client->updateByQuery($params);

									// echo '<pre>',print_r($params['body'],1),'</pre>';

									$query = " UPDATE fs_sim set status = 0 WHERE id = ".$item;
									$db->query($query);
									$his = $db->affected_rows();
								}
							}
						}

						break;

					// Vẫn còn chưa báo ,Sau 03 ngày sẽ được hiển thị lại ở ngoài web
					case 5:

						$limit = 3; 
						$time_order = strtotime($key->edited_time);
						$time = ($time_now - $time_order)/86400;

						$list_id = explode(',', $key->products_id);

						if ($time > $limit) {

							foreach ($list_id as $item ) {

								$sim = $model->get_record('id = '.$item,'fs_sim','agency,number');
								if ($sim) {
									$must = array(); $query = array();
									$must_item = array('_id'=>$sim->agency.'-'.$sim->number);
									$must_arr = array('term'=>$must_item);
									$must['must'][] = $must_arr;

									$query['bool'] = $must;
									$body['query'] = $query;
									$body['script'] = [
										'source' => 'ctx._source.status  = params.value',
										'params' => [
											'value' => 0
										]
									];
									$params = [
										'index' => 'fs',
										'type' => 'simsodep',
										'body' => $body
									];

									$results = $client->updateByQuery($params);

									// echo '<pre>',print_r($params['body'],1),'</pre>';

									$query = " UPDATE fs_sim set status = 0 WHERE id = ".$item;
									$db->query($query);
									$his = $db->affected_rows();
								}
							}
						}

						break;

					// Khách hàng hẹn ,Quá ngày hẹn sẽ được hiển thị lại ở ngoài web
					case 12:

						$limit = 3; 
						$time_order = $key->date_appointment;

						$list_id = explode(',', $key->products_id);

						if ($time_now > $time_order) {
							foreach ($list_id as $item ) {

								$sim = $model->get_record('id = '.$item,'fs_sim','agency,number');
								if ($sim) {
									$must = array(); $query = array();
									$must_item = array('_id'=>$sim->agency.'-'.$sim->number);
									$must_arr = array('term'=>$must_item);
									$must['must'][] = $must_arr;

									$query['bool'] = $must;
									$body['query'] = $query;
									$body['script'] = [
										'source' => 'ctx._source.status  = params.value',
										'params' => [
											'value' => 0
										]
									];
									$params = [
										'index' => 'fs',
										'type' => 'simsodep',
										'body' => $body
									];

									$results = $client->updateByQuery($params);

									// echo '<pre>',print_r($params['body'],1),'</pre>';

									$query = " UPDATE fs_sim set status = 0 WHERE id = ".$item;
									$db->query($query);
									$his = $db->affected_rows();
								}
							}
						}else{
							foreach ($list_id as $item ) {

								$sim = $model->get_record('id = '.$item,'fs_sim','agency,number');
								if ($sim) {
									$must = array(); $query = array();
									$must_item = array('_id'=>$sim->agency.'-'.$sim->number);
									$must_arr = array('term'=>$must_item);
									$must['must'][] = $must_arr;

									$query['bool'] = $must;
									$body['query'] = $query;
									$body['script'] = [
										'source' => 'ctx._source.status  = params.value',
										'params' => [
											'value' => 3
										]
									];
									$params = [
										'index' => 'fs',
										'type' => 'simsodep',
										'body' => $body
									];

									$results = $client->updateByQuery($params);

									// echo '<pre>',print_r($params['body'],1),'</pre>';

									$query = " UPDATE fs_sim set status = 3 WHERE id = ".$item;
									$db->query($query);
									$his = $db->affected_rows();
								}
							}
						}

						break;

					// Bán rồi đã báo ,Sau 03 ngày sẽ xóa khỏi danh sách sim
					case 3:

						$limit = 3; 
						$time_order = strtotime($key->edited_time);
						$time = ($time_now - $time_order)/86400;

						$list_id = explode(',', $key->products_id);

						if ($time > $limit) {

							foreach ($list_id as $item ) {

								$sim = $model->get_record('id = '.$item,'fs_sim','agency,number');
								if ($sim) {
									$must = array(); $query = array();
									$must_item = array('_id'=>$sim->agency.'-'.$sim->number);
									$must_arr = array('term'=>$must_item);
									$must['must'][] = $must_arr;

									$query['bool'] = $must;
									$body['query'] = $query;
									unset($body['script']);
									$params = [
										'index' => 'fs',
										'type' => 'simsodep',
										'body' => $body
									];

									$body['script'] = array();

									$results = $client->deleteByQuery($params);

									// echo '<pre>',print_r($params['body'],1),'</pre>';

									$query = " DELETE FROM fs_sim WHERE id = ".$item;
									$query = " DELETE FROM fs_sim_dublicate WHERE id = ".$item;
									$db->query($query);
									$his = $db->affected_rows();
								}
							}
						}

						break;

					// Bán rồi chưa báo ,Sau 03 ngày sẽ xóa khỏi danh sách sim
					case 4:

						$limit = 3; 
						$time_order = strtotime($key->edited_time);
						$time = ($time_now - $time_order)/86400;

						$list_id = explode(',', $key->products_id);

						if ($time > $limit) {

							foreach ($list_id as $item ) {

								$sim = $model->get_record('id = '.$item,'fs_sim','agency,number');
								if ($sim) {
									$must = array(); $query = array();
									$must_item = array('_id'=>$sim->agency.'-'.$sim->number);
									$must_arr = array('term'=>$must_item);
									$must['must'][] = $must_arr;

									$query['bool'] = $must;
									$body['query'] = $query;
									unset($body['script']);
									$params = [
										'index' => 'fs',
										'type' => 'simsodep',
										'body' => $body
									];


									$results = $client->deleteByQuery($params);

									$query = " DELETE FROM fs_sim WHERE id = ".$item;
									$query = " DELETE FROM fs_sim_dublicate WHERE id = ".$item;
									$db->query($query);
									$his = $db->affected_rows();
								}
							}
						}

						break;

					// Giao dịch xong ,Sau 03 ngày sẽ xóa hẳn khỏi web
					case 2:

						$limit = 3; 
						$time_order = strtotime($key->edited_time);
						$time = ($time_now - $time_order)/86400;

						$list_id = explode(',', $key->products_id);

						if ($time > $limit) {

							foreach ($list_id as $item ) {

								$sim = $model->get_record('id = '.$item,'fs_sim','agency,number');
								if ($sim) {
									$must = array(); $query = array();
									$must_item = array('_id'=>$sim->agency.'-'.$sim->number);
									$must_arr = array('term'=>$must_item);
									$must['must'][] = $must_arr;

									$query['bool'] = $must;
									$body['query'] = $query;
									unset($body['script']);
									$params = [
										'index' => 'fs',
										'type' => 'simsodep',
										'body' => $body
									];

									$body['script'] = array();

									$results = $client->deleteByQuery($params);

									// echo '<pre>',print_r($params['body'],1),'</pre>';

									$query = " DELETE FROM fs_sim WHERE id = ".$item;
									$query = " DELETE FROM fs_sim_dublicate WHERE id = ".$item;
									$db->query($query);
									$his = $db->affected_rows();
								}
							}
						}

						break;
					
					default:
						break;
				}

			}

			// echo '<pre>',print_r($users),'</pre>';
			
		}

		function update_all(){

			// sửa đổi và xóa các sim không phù hợp
			$this->update_remove();

			// xóa các sim trùng trong đại lý
			$this->remove_dublicate();

			//cập nhật giá sim
			$this->update_price();

			//cập nhật thể loại sim
			// $this->update_cat();

			//cập nhật sim vào bảng chính
			$this->update_sim();

			$link = FSRoute::_(URL_ROOT.'admin_sim/index.php?module=log&view=log');
            setRedirect($link);

		}

		 function update_field(){

		 	$sql = '';
             for ($i=43; $i <= 628; $i++) {
                 if ($i==48 ||$i==49 ||$i==50 ||$i==51 ||$i==89 ||$i==90 ||$i==91 ||$i==98 ||$i==99 ||$i==100 ||$i==101 ||$i==543 ||$i==627)
                     continue;
             	$sql .= 'ALTER TABLE fs_sim_'.$i.' DROP IF EXISTS start_time;';
             	$sql .= 'ALTER TABLE fs_sim_'.$i.' DROP IF EXISTS end_time;';
             	$sql .= 'ALTER TABLE fs_sim_'.$i.' DROP IF EXISTS author_id;';
             	$sql .= 'ALTER TABLE fs_sim_'.$i.' DROP IF EXISTS author_last_id;';
             }
             var_dump($sql);

		 }

		function check_duplicate($t=1){
			$link = FSRoute::_(URL_ROOT.'admin_sim/index.php?module=log&view=log');
			// if ($t > 2) {
			// 	setRedirect($link);
			// }
			$client = ClientBuilder::create()->setHosts($hosts)->build();


			global $db;
            $model = $this -> model;
            $list = $model->get_duplicate();
	            // var_dump($list);die;
            if ($list) {

            	// tìm các sim trùng có giá nhỏ nhất trong bảng sim
				foreach ($list as $value) {

					if ($array_delete[$value->number]) {
						if ( $value->price_public <= $array_delete[$value->number]['price_public']) {
							$array_delete[$value->number] = array('id' => $value->id, 'number' => $value->number , 'price_public' => $value->price_public  );
						}
					}else{
						$array_delete[$value->number] = array('id' => $value->id, 'number' => $value->number , 'price_public' => $value->price_public  );

					}

				}

            // echo '<pre>',print_r($array_delete),'</pre>';die;
				$i = 0;
	            $sql = 'DELETE FROM fs_sim WHERE id IN(';
	            $sql_duplicate = 'DELETE FROM fs_sim_dublicate WHERE id IN(';
	            foreach ($list as $item) {

	            	// so sánh các sim trùng với các sim có giá nhỏ nhất
	            	if ( $array_delete[$item->number]['number'] == $item->number && $item->price_public >= $array_delete[$item->number]['price_public'] && $array_delete[$item->number]['id'] != $item->id ) {

	//                    $sim = $model->get_record('id = '.$item->id,'fs_sim','agency,number');

		                $sql .= $item->id.',';
		                $sql_duplicate .= $item->id.',';

		                $params ['body'][] = array(  
					        'delete' => array(  
					            '_index' => 'fs',  
					            '_type' => 'simsodep',  
					            '_id' =>$item->agency.'-'.$item->number  
					        )  
					    );

					    // Every 1000 documents stop and send the bulk request
	                    if ($i % 1000 == 0) {
	                        $responses = $client->bulk($params);

	                        // erase the old bulk request
	                        $params = ['body' => []];

	                        // unset the bulk response when you are done to save memory
	                        unset($responses);
	                    }

		                $i++;
	            	}
	            }
	            $sql = rtrim($sql,",");
	            $sql_duplicate = rtrim($sql_duplicate,",");
	            $sql .= ');';
	            // var_dump($i);die;
	            $sql_duplicate .= ');';

	            $time = date('Y-m-d H:i:s');

	            $user_id = '';
            	$user_name = '';
                if ($_SESSION['ad_userid']) {
                	$user_id = $_SESSION['ad_userid'];
                	$user_name = $_SESSION['ad_full_name'];
                }

	        	$sql_log = 'INSERT INTO fs_log (created_time, agency, agnecy_name, user, user_name, title)
						VALUES ("'.$time.'", "all", "all", "'.$user_id.'", "'.$user_name.'","Xóa thành công '.$i.' sim trùng");';
						
	            $sql = $sql.$sql_duplicate.$sql_log;
	            $db->query($sql);
				$row = $db->affected_rows();

				// Send the last batch if it exists
                if (!empty($params['body'])) {
                    $responses = $client->bulk($params);
    			}

				// echo '<pre>',print_r($params),'</pre>';die;
				// $results = $client->search($params);
	        	// $results = $client->deleteByQuery($params);
				// echo '<pre>',print_r($results),'</pre>';die;

    			// gọi lại chính hàm đó để xử lý giới hạn 200k 
    			// $t++;
    			// return $this->check_duplicate($t);

            }
            
    		setRedirect($link);
        }

		function update_remove(){

			$model = $this -> model;
			global $db;
			$users = $model->get_records('published = 1 AND type = 2','fs_users','id,access,full_name');
			$network = $model->get_records('published = 1','fs_network','id,name,header');
			$sql = '';
			foreach ($users as $key) {
				$total = $model->get_count('','fs_sim_'.$key->id.'','id');
				if ($total>0) {

					// cập nhật và loại bỏ sim
						// chuyển đổi số 84
						// $sql .= "Update fs_sim_".$key->id." set sim = INSERT(sim, 1, 2, '0') , number = INSERT(number, 1, 2, '0') WHERE LEFT(number,2) = 84;";
						// xóa các sim không phù hợp
						$sql .= "DELETE FROM fs_sim_".$key->id." WHERE LENGTH(number) > 11 OR LENGTH(number) < 9 OR (LENGTH(number) = 9 AND LEFT(number,1) = 0) OR (LENGTH(number) = 10 AND LEFT(number,1) != 0) OR price < 150000;";
						// // cập nhật hoàn chỉnh số 
						// $sql .= "UPDATE fs_sim_".$key->id." SET sim = CONCAT('0',sim) , number = CONCAT('0',number) WHERE LENGTH(number) = 9 AND LEFT(number,1) <> 0 ;";

					// cập nhật nhà mạng (cập nhật bảng tạm trước)
						$sql .= "
						UPDATE fs_sim_".$key->id."  
							SET     network =  CASE ";
						foreach ($network as $item) {
							$sql .= " WHEN LEFT(number, 3) IN (".$item->header.") AND network_id IS NULL THEN '".$item->name."' ";
						}
						$sql .= "
	 						ELSE network
	                    END;
	                    ";

	                    $head = '';
	                    $sql .= "
							UPDATE fs_sim_".$key->id."  
							SET     network_id =  CASE ";
						foreach ($network as $item) {
							$sql .= " WHEN LEFT(number, 3) IN (".$item->header.") AND network_id IS NULL THEN '".$item->id."' ";
							$head .= $item->header.',';
						}
						$sql .= "
	 						ELSE network_id
	                    END;
	                    ";

	                    $head = explode(',', $head);
//	                    var_dump($head);

						// xóa các sim không thuộc nhà mạng nào
						$sql .= "DELETE FROM fs_sim_".$key->id." WHERE network_id IS NULL;";
						// user có quyền đăng sim trực tiếp lên web
						// if ($key->access == 1) {
						// 	$sql .= "Update fs_sim_".$key->id." SET admin_status = 1;";
						// }


						// loại bỏ các số trùng nhau trong đại lý
						// $list = $model->get_duplicate_agency('fs_sim_'.$key->id);

						// // tìm các sim trùng có giá nhỏ nhất trong đại lý
						// foreach ($list as $value) {

						// 	if ($array_delete[$value->number]) {
						// 		if ( $value->price <= $array_delete[$value->number]['price']) {
						// 			$array_delete[$value->number] = array('id' => $value->id, 'number' => $value->number , 'price' => $value->price  );
						// 		}
						// 	}else{
						// 		$array_delete[$value->number] = array('id' => $value->id, 'number' => $value->number , 'price' => $value->price  );

						// 	}

						// }
						// echo '<pre>',print_r($list,1),'</pre>';die;

						// if ($list) {

						// 	$sql .= 'DELETE FROM fs_sim_'.$key->id.' WHERE id IN(0';
				  //           foreach ($list as $item) {

				  //           	// so sánh các sim trùng với các sim có giá nhỏ nhất
				  //           	if ( $array_delete[$item->number]['number'] == $item->number && $item->price >= $array_delete[$item->number]['price'] && $array_delete[$item->number]['id'] != $item->id ) {
				  //               	$sql .= ','.$item->id;
						// 		}

				  //           }
				  //           $sql .= ');';
						// }

						// echo '<pre>',print_r($sql,1),'</pre>';die;

					// cập nhật số sim đại lý và tên đại lý (cập nhật bảng tạm trước)
						$total_sim = $model->get_count('agency ='.$key->id,'fs_sim_'.$key->id.'','id');
						if ($total_sim>0) {
							$sql .= "Update fs_users SET total_sim ='".$total."' WHERE 
										id = ".$key->id.";";
						}
						// $sql .= "Update fs_sim_".$key->id." SET agency_name ='".$key->full_name."' WHERE 
						// 			agency = ".$key->id." AND agency_name IS NULL;";
				}

			}


			// var_dump($sql);die;
			$db->query($sql);
			$row = $db->affected_rows();

			// $link = FSRoute::_(URL_ROOT.'admin_sim');
   //          setRedirect($link);
		}

		function remove_dublicate(){
			$model = $this -> model;
			global $db;
			$users = $model->get_records('published = 1 AND type = 2','fs_users','id,access,full_name');
			$sql = '';
			foreach ($users as $key) {
				$total = $model->get_count('','fs_sim_'.$key->id.'','id');
				if ($total>0) {

					// loại bỏ các số trùng nhau trong đại lý
					$list = $model->get_duplicate_agency('fs_sim_'.$key->id);

					// tìm các sim trùng có giá nhỏ nhất trong đại lý
					foreach ($list as $value) {

						if ($array_delete[$value->number]) {
							if ( $value->price <= $array_delete[$value->number]['price']) {
								$array_delete[$value->number] = array('id' => $value->id, 'number' => $value->number , 'price' => $value->price  );
							}
						}else{
							$array_delete[$value->number] = array('id' => $value->id, 'number' => $value->number , 'price' => $value->price  );

						}

					}

					// echo '<pre>',print_r($list,1),'</pre>';
					// echo '<pre>',print_r($array_delete,1),'</pre>';die;
					if ($list) {

						$sql .= 'DELETE FROM fs_sim_'.$key->id.' WHERE id IN(0';
			            foreach ($list as $item) {

			            	// so sánh các sim trùng với các sim có giá nhỏ nhất
			            	if ( $array_delete[$item->number]['number'] == $item->number && $item->price >= $array_delete[$item->number]['price'] && $array_delete[$item->number]['id'] != $item->id ) {
			                	$sql .= ','.$item->id;
							}

			            }
			            $sql .= ');';
					}
				}

			}


			// var_dump($sql);die;
			$db->query($sql);
			$row = $db->affected_rows();
		}

		// cập nhật nhà mạng (cập nhật bảng tạm trước)
		function update_network(){
			$model = $this -> model;
			global $db;
			$users = $model->get_records('published = 1 AND type = 2','fs_users','id,access');
			$network = $model->get_records('published = 1','fs_network','id,name,header');
			$sql = '';
			foreach ($users as $key) {
				$total = $model->get_count('','fs_sim_'.$key->id.'','id');
				if ($total>0) {
					$sql .= "
						UPDATE fs_sim_".$key->id."  
						SET     network =  CASE ";
					foreach ($network as $item) {
						$sql .= " WHEN LEFT(number, 3) IN (".$item->header.") AND network_id IS NULL THEN '".$item->name."' ";
					}
					$sql .= "
 						ELSE network
                    END;
                    ";

                    $sql .= "
						UPDATE fs_sim_".$key->id."  
						SET     network_id =  CASE ";
					foreach ($network as $item) {
						$sql .= " WHEN LEFT(number, 3) IN (".$item->header.") AND network_id IS NULL THEN '".$item->id."' ";
					}
					$sql .= "
 						ELSE network_id
                    END;
                    ";

					// xóa các sim không thuộc nhà mạng nào
					$sql .= "DELETE FROM fs_sim_".$key->id." WHERE agency IS NULL;";
					// user có quyền đăng sim trực tiếp lên web
					if ($key->access == 1) {
						$sql .= "Update fs_sim_".$key->id." SET admin_status = 1;";
					}
				}

			}
			// var_dump($sql);die;
			$db->query($sql);
			$row = $db->affected_rows();

			$link = FSRoute::_(URL_ROOT.'admin_sim');
            setRedirect($link);
		}

		// cập nhật số sim đại lý và tên đại lý (cập nhật bảng tạm trước)
		function update_agency(){
			$model = $this -> model;
			global $db;
			$sql = '';
			$users = $model->get_records('published = 1 AND type = 2','fs_users','id,full_name');
			foreach ($users as $item) {

				$total = $model->get_count('','fs_sim_'.$item->id.'','id');
				if ($total>0) {

					$total = $model->get_count('agency ='.$item->id,'fs_sim_'.$item->id.'','id');
					if ($total>0) {
						$sql .= "Update fs_users SET total_sim ='".$total."' WHERE 
									id = ".$item->id.";";
					}
					$sql .= "Update fs_sim_".$item->id." SET agency_name ='".$item->full_name."' WHERE 
								agency = ".$item->id." AND agency_name IS NULL;";

				}
			}
			// var_dump($sql);die;
			$db->query($sql);
			$row = $db->affected_rows();

			$link = FSRoute::_(URL_ROOT.'admin_sim');
            setRedirect($link);
		}

		// cập nhật giá (cập nhật bảng tạm trước)
		function update_price(){
			$model = $this -> model;
			global $db;
			$sql = '';
			$users = $model->get_records('published = 1 AND type = 2','fs_users','id,full_name,price');
			foreach ($users as $key) {

				$total = $model->get_count('','fs_sim_'.$key->id.'','id');
				if ($total>0) {

					$price = $model->get_records('price_id = '.$key->price,'fs_price_commissions','price_f,price_t,commission,commission_unit,commission_type,price_id');
					// var_dump($key);die;
					$sql .= "Update fs_sim_".$key->id." SET commission ='".$key->price."';";

					$sql .= "
					UPDATE fs_sim_".$key->id."  
					SET     price_public =  CASE ";
					// $i = 1;
					foreach ($price as $item) {

						$item->price_f = $item->price_f - 1;

						if ($item->commission_type == 'up') {
							# code...
							if ($item->commission_unit == 'percent') {
								$price_public =  $item->commission / 100;
								$sql .= " WHEN price > ".$item->price_f." AND price < ".$item->price_t." AND commission = ".$item->price_id." AND price_public IS NULL THEN price + price * ".$price_public." ";
							}else{
								$price_public =  $item->commission;
								$sql .= " WHEN price > ".$item->price_f." AND price < ".$item->price_t." AND commission = ".$item->price_id." AND price_public IS NULL THEN price + ".$price_public." ";
							}
						}
						if ($item->commission_type == 'down') {
							if ($item->commission_unit == 'percent') {
								$price_public =  $item->commission / 100;
								$sql .= " WHEN price > ".$item->price_f." AND price < ".$item->price_t." AND commission = ".$item->price_id." AND price_public IS NULL THEN price - price * ".$price_public." ";
							}else{
								$price_public =  $item->commission;
								$sql .= " WHEN price > ".$item->price_f." AND price < ".$item->price_t." AND commission = ".$item->price_id." AND price_public IS NULL THEN price - ".$price_public." ";
							}
						}
					}


 					$sql .= "
 						ELSE price_public
                    END;
                    ";

					$sql .= "
					UPDATE fs_sim_".$key->id."  
					SET     commission_value =  CASE ";
					
					foreach ( $price as $item) {
						$item->price_f = $item->price_f - 1;
						if ($item->commission_type == 'commission') {
							if ($item->commission_unit == 'percent') {
								$price_public =  $item->commission / 100;
								$sql .= " WHEN price >= ".$item->price_f." AND price < ".$item->price_t." AND commission = ".$item->price_id." AND commission_value IS NULL THEN price * ".$price_public." ";
							}else{
								$sql .= " WHEN price >= ".$item->price_f." AND price < ".$item->price_t." AND commission = ".$item->price_id." AND commission_value IS NULL THEN ".$item->commission." ";
							}
						}
					}


					$sql .= "
 						ELSE commission_value
                    END;
                    ";

                    $sql .= "Update fs_sim_".$key->id." 
                    	SET price_public = CASE 
                    		WHEN SUBSTRING(REVERSE(price_public),4,1) != 5 AND SUBSTRING(REVERSE(price_public),4,1) != 9 AND price_public > 0 THEN round(price_public,-4) 
                    		WHEN SUBSTRING(REVERSE(price_public),3,1) < 5 AND price_public > 0 THEN round(price_public,-3) 
                    		WHEN SUBSTRING(REVERSE(price_public),3,1) > 4 AND price_public > 0 THEN round(price_public,-3) - 1000 
	                		ELSE price_public
	                    END;
            		";

				}
			}
			// var_dump($sql);die;
			$db->query($sql);
			$row = $db->affected_rows();

			// $link = FSRoute::_(URL_ROOT.'admin_sim');
   //          setRedirect($link);
		}

		// cập nhật dữ liệu từ bảng tạm sang bảng chính
		function update_sim()
		{
            $time = date('Y-m-d H:i:s');
            $model = $this -> model;
            global $db;
            $users = $model->get_records('published = 1 AND type = 2','fs_users','id,full_name');
            foreach ($users as $item) {

                $total = $model->get_count('','fs_sim_'.$item->id.'','id');
                if ($total>0) {

		            $sql = '';
                    // xóa sim đại lý ở bảng chính
                    $sql .= 'DELETE FROM fs_sim WHERE agency = '.$item->id.';';

                    // xóa sim đại lý ở bảng trùng
                    $sql .= 'DELETE FROM fs_sim_dublicate WHERE agency = '.$item->id.';';

                    // chuyển sim từ bảng phụ sang chính
                    $sql .= 'INSERT INTO fs_sim (
							sim,
							number,
							price,
							created_time,
							network,
							network_id,
							agency,
							agency_name,
							cat_id,
							cat_type,
							cat_alias,
							cat_name,
							commission,
							commission_value,
							price_public,
							admin_status,
							point,
							button,
							price_old,
							type
							)
						SELECT 
							sim,
							number,
							price,
							created_time,
							network,
							network_id,
							agency,
							agency_name,
							cat_id,
							cat_type,
							cat_alias,
							cat_name,
							commission,
							commission_value,
							price_public,
							admin_status,
							point,
							button, 
							price_old,
							type
							FROM fs_sim_'.$item->id.' ;';

                    // bảng sim phụ dành cho check trùng
                    $sql .= 'INSERT INTO fs_sim_dublicate (
							sim,
							number,
							price,
							network_id,
							agency,
							price_public
							)
						SELECT 
							sim,
							number,
							price,
							network_id,
							agency,
							price_public
							FROM fs_sim_'.$item->id.' ;';

                    // xóa sim đã xử lý ở bảng phụ
                    // $sql .= 'DELETE FROM fs_sim_'.$item->id.' ;';
                    $sql .= 'TRUNCATE TABLE fs_sim_'.$item->id.';';

                    $user_id = '';
                	$user_name = '';
                    if ($_SESSION['ad_userid']) {
                    	$user_id = $_SESSION['ad_userid'];
                    	$user_name = $_SESSION['ad_full_name'];
                    }

                    // cập nhật lịch sử
                    $sql .= 'INSERT INTO fs_log (created_time, agency, agnecy_name, user, user_name, title)
						VALUES ("'.$time.'", "'.$item->id.'", "'.$item->full_name.'", "'.$user_id.'", "'.$user_name.'","Cập nhật thành công '.$total.' sim của đại lý : '.$item->full_name.'");';
					$db->query($sql);
					$row = $db->affected_rows();

					// xóa xim trong đại lý khi đăng sim
            		// $this->delete_es($agency_id);


					//				    cập nhật dữ liệu vào es
                    $this->update_es($total,$item->id);
				}
			}

//			 var_dump($sql);die;

	  //       $db->query($sql);
			// $row = $db->affected_rows();

			// $link = FSRoute::_(URL_ROOT.'admin_sim');
   //          setRedirect($link);
		}

	    function delete_es($id){
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
	        $client = ClientBuilder::create()->setHosts($hosts)->build();

	        // xóa dữ liệu theo query elasticsearch
	        $updateRequest = [
	            'index'     => 'fs',
	            'type'      => 'simsodep',
	            'conflicts' => 'abort',
	            'body' => [
	                'query' => [
	                    'term' => [
	                        'agency' => "$id"
	                    ]
	                ]
	            ]
	        ];

	        $results = $client->deleteByQuery($updateRequest);

	//        echo '<pre>',print_r($results,1),'</pre>';die;
	    }

		function update_es($total,$agency_id){

            $client = ClientBuilder::create()->setHosts($hosts)->build();
            $model = $this -> model;

//            giới hạn một lần chỉ select được 300000 để xử lý nên cần chia ra
            $limit = 100000;
            $x = $total/$limit;
            $x = ceil($x);

            if ($x<1){
            	$x = 1;
            }

            global $db;

            for ($j = 0; $j < $x; $j++){

                $start = $j*$limit;
                // var_dump($x);
                $sim = $model->get_records('agency ='.$agency_id,'fs_sim','id,sim,number,price,network,network_id,status,admin_status,agency,agency_name,cat_alias,cat_name,price_public,price_old,button,point,type,created_time,commission,commission_value','',$start.','.$limit.'');
               // var_dump($j);
               // var_dump(count($sim));

                $params = ['body' => []];

                for ($i = 0; $i <= count($sim); $i++) {
                    $params['body'][] = [
                        'index' => [
                            '_index' => 'fs',
                            '_type' => 'simsodep',
                            '_id' => $sim[$i]->agency.'-'.$sim[$i]->number
                        ]
                    ];


                    $params['body'][] = [
                        'sim_id' => $sim[$i]->id,
                        'sim' => $sim[$i]->sim,
                        'number' => $sim[$i]->number,
                        'price' => $sim[$i]->price,
                        'network' => $sim[$i]->network,
                        'network_id' => $sim[$i]->network_id,
                        'status' => $sim[$i]->status,
                        'admin_status' => $sim[$i]->admin_status,
                        'agency' => $sim[$i]->agency,
                        'agency_name' => $sim[$i]->agency_name,
                        'cat_alias' => $sim[$i]->cat_alias,
                        'cat_name' => $sim[$i]->cat_name,
                        'price_public' => (int)$sim[$i]->price_public,
                        'price_old' => $sim[$i]->price_old,
                        'button' => $sim[$i]->button,
                        'point' => $sim[$i]->point,
                        'type' => $sim[$i]->type,
                        'created_time' => $sim[$i]->created_time,
                        'commission' => $sim[$i]->commission,
                        'commission_value' => $sim[$i]->commission_value
                    ];


                    // Every 1000 documents stop and send the bulk request
                    if ($i % 1000 == 0) {
                        $responses = $client->bulk($params);

                        // erase the old bulk request
                        $params = ['body' => []];

                        // unset the bulk response when you are done to save memory
                        unset($responses);
                    }
                }
                // Send the last batch if it exists
                if (!empty($params['body'])) {
                    $responses = $client->bulk($params);
    			}

//                                echo '<pre>',print_r($responses,1),'</pre>';die;
            }
            // var_dump($total);die;
        }


		function update_cat()
		{
			$model = $this -> model;
			global $db;

			$year5x = '1950';
			$year6x = '1960';
			$year7x = '1970';
			$year8x = '1980';
			$year9x = '1990';
			$year10x = '2000';
			$year11x = '2010';
			for ($x = 1951; $x <= 1960; $x++) {
				$year5x .= ",".$x;
			}

			for ($x = 1961; $x <= 1970; $x++) {
				$year6x .= ",".$x;
			}

			for ($x = 1971; $x <= 1980; $x++) {
				$year7x .= ",".$x;
			}

			for ($x = 1981; $x <= 1990; $x++) {
				$year8x .= ",".$x;
			}

			for ($x = 1991; $x <= 2000; $x++) {
				$year9x .= ",".$x;
			}

			for ($x = 2001; $x <= 2010; $x++) {
				$year10x .= ",".$x;
			}

			for ($x = 2011; $x <= 2020; $x++) {
				$year11x .= ",".$x;
			}

			$key = 1;
			for ($x = 2; $x <= 20; $x++) {
				$key .= ",".$x;
			}

			$users = $model->get_records('published = 1 AND type = 2','fs_users','id,full_name');
			$sql = '';
			foreach ($users as $item) {

			$total = $model->get_count('','fs_sim_'.$item->id.'','id');
			if ($total>0) {

			$sql .= "

				UPDATE fs_sim_".$item->id." 
 					SET     cat_name =  CASE
 						WHEN RIGHT(number, 6) IN (000000,111111,222222,333333,444444,555555,666666,777777,888888,999999) THEN 'Sim lục quý'
 						WHEN RIGHT(number, 5) IN (00000,11111,22222,33333,44444,55555,66666,77777,88888,99999) THEN 'Sim ngũ quý'

                        WHEN RIGHT(number, 4) = 0000 THEN 'Sim tứ quý,Sim tứ quý 0000'
 						WHEN RIGHT(number, 4) = 1111 THEN 'Sim tứ quý,Sim tứ quý 1111' 
                        WHEN RIGHT(number, 4) = 2222 THEN 'Sim tứ quý,Sim tứ quý 2222' 
                        WHEN RIGHT(number, 4) = 3333 THEN 'Sim tứ quý,Sim tứ quý 3333'
						WHEN RIGHT(number, 4) = 4444 THEN 'Sim tứ quý,Sim tứ quý 4444'
						WHEN RIGHT(number, 4) = 5555 THEN 'Sim tứ quý,Sim tứ quý 5555'
						WHEN RIGHT(number, 4) = 6666 THEN 'Sim tứ quý,Sim tứ quý 6666'
						WHEN RIGHT(number, 4) = 7777 THEN 'Sim tứ quý,Sim tứ quý 7777'
						WHEN RIGHT(number, 4) = 8888 THEN 'Sim tứ quý,Sim tứ quý 8888'
						WHEN RIGHT(number, 4) = 9999 THEN 'Sim tứ quý,Sim tứ quý 9999'

 						WHEN RIGHT(number, 3) IN (000,111,222,333,444,555,666,777,888,999) AND SUBSTRING(number, 5, 3) IN (000,111,222,333,444,555,666,777,888,999) THEN 'Sim tam hoa kép'  
 						WHEN RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 7, 2) = SUBSTRING(number, 5, 2) THEN 'Sim taxi 2'

 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 8, 1) THEN 'Sim taxi 3,Sim taxi ABA.ABA'  
 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 9, 1) THEN 'Sim taxi 3,Sim taxi AAB.AAB'  
 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 9, 1) THEN 'Sim taxi 3,Sim taxi BAA.BAA'
 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 9, 1) THEN 'Sim taxi 3,Sim taxi ABC.ABC'

							
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) THEN 'Sim taxi 4,Sim taxi ABBB.ABBB'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) THEN 'Sim taxi 4,Sim taxi AAAB.AAAB'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) THEN 'Sim taxi 4,Sim taxi ABBA.ABBA'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) THEN 'Sim taxi 4,Sim taxi AABB.AABB'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) THEN 'Sim taxi 4,Sim taxi 4 khác'


						WHEN RIGHT(number, 3) = 000 THEN 'Sim tam hoa,Sim tam hoa 000'
 						WHEN RIGHT(number, 3) = 111 THEN 'Sim tam hoa,Sim tam hoa 111'
 						WHEN RIGHT(number, 3) = 222 THEN 'Sim tam hoa,Sim tam hoa 222'
 						WHEN RIGHT(number, 3) = 333 THEN 'Sim tam hoa,Sim tam hoa 333'
 						WHEN RIGHT(number, 3) = 444 THEN 'Sim tam hoa,Sim tam hoa 444'
 						WHEN RIGHT(number, 3) = 555 THEN 'Sim tam hoa,Sim tam hoa 555'
 						WHEN RIGHT(number, 3) = 666 THEN 'Sim tam hoa,Sim tam hoa 666'
 						WHEN RIGHT(number, 3) = 777 THEN 'Sim tam hoa,Sim tam hoa 777'
 						WHEN RIGHT(number, 3) = 888 THEN 'Sim tam hoa,Sim tam hoa 888'
 						WHEN RIGHT(number, 3) = 999 THEN 'Sim tam hoa,Sim tam hoa 999'

						WHEN RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 6, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) THEN 'Sim số kép,Sim số kép AAAA.BB'
						WHEN RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND RIGHT(number, 1) = SUBSTRING(number, 5, 1) THEN 'Sim số kép,Sim số kép AA.BB.AA'
						WHEN RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND RIGHT(number, 1) != SUBSTRING(number, 5, 1) THEN 'Sim số kép,Sim số kép AA.BB.CC'
						WHEN RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) != SUBSTRING(number, 6, 1) THEN 'Sim số kép,Sim số kép AA.BB'

						WHEN RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 7, 2) != SUBSTRING(number, 5, 2) THEN 'Sim số lặp'
						WHEN RIGHT(number, 1) - SUBSTRING(number, 9, 1) = 2 AND  SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) = 2 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) = 2 THEN 'Sim tiến đơn,Sim tiến đơn đặc biệt'
						WHEN RIGHT(number, 1) - SUBSTRING(number, 9, 1) = 1 AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) =1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) =1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) =1 AND SUBSTRING(number, 6, 1) - SUBSTRING(number, 5, 1) = 1 THEN 'Sim tiến đơn,Sim tiến đơn 6'
						WHEN RIGHT(number, 1) - SUBSTRING(number, 9, 1) = 1 AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) = 1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) = 1 AND SUBSTRING(number, 6, 1) - SUBSTRING(number, 5, 1) != 1 THEN 'Sim tiến đơn,Sim tiến đơn 5'
						WHEN RIGHT(number, 1) - SUBSTRING(number, 9, 1) =1 AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) = 1  AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) != 1 THEN 'Sim tiến đơn,Sim tiến đơn 4'
						WHEN RIGHT(number, 1) - SUBSTRING(number, 9, 1) = 1 AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) != 1 THEN 'Sim tiến đơn,Sim tiến đơn 3'
						WHEN RIGHT(number, 1) > SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) > SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) > SUBSTRING(number, 7, 1) THEN 'Sim tiến đơn,Sim tiến đơn khác'


						WHEN RIGHT(number, 4) IN (".$year5x.") THEN 'Sim năm sinh,Sim năm sinh 195x'
 						WHEN RIGHT(number, 4) IN (".$year6x.") THEN 'Sim năm sinh,Sim năm sinh 196x'
 						WHEN RIGHT(number, 4) IN (".$year7x.") THEN 'Sim năm sinh,Sim năm sinh 197x'
 						WHEN RIGHT(number, 4) IN (".$year8x.") THEN 'Sim năm sinh,Sim năm sinh 198x'
 						WHEN RIGHT(number, 4) IN (".$year9x.") THEN 'Sim năm sinh,Sim năm sinh 199x'
 						WHEN RIGHT(number, 4) IN (".$year10x.") THEN 'Sim năm sinh,Sim năm sinh 200x'
 						WHEN RIGHT(number, 4) IN (".$year11x.") THEN 'Sim năm sinh,Sim năm sinh 201x'


 						WHEN (number LIKE '%000000%' OR number LIKE '%111111%' OR number LIKE '%222222%' OR number LIKE '%333333%' OR number LIKE '%444444%' OR number LIKE '%555555%' OR number LIKE '%666666%' OR number LIKE '%777777%' OR number LIKE '%888888%' OR number LIKE '%999999%') THEN 'Sim lục quý giữa'
 						WHEN (number LIKE '%00000%' OR number LIKE '%11111%' OR number LIKE '%22222%' OR number LIKE '%33333%' OR number LIKE '%44444%' OR number LIKE '%55555%' OR number LIKE '%66666%' OR number LIKE '%77777%' OR number LIKE '%88888%' OR number LIKE '%99999%') AND number NOT LIKE '%000000%' AND number NOT LIKE '%111111%' AND number NOT LIKE '%222222%' AND number NOT LIKE '%333333%' AND number NOT LIKE '%444444%' AND number NOT LIKE '%555555%' AND number NOT LIKE '%666666%' AND number NOT LIKE '%777777%' AND number NOT LIKE '%888888%' AND number NOT LIKE '%999999%' THEN 'Sim ngũ quý giữa'
 						WHEN (number LIKE '%0000%' OR number LIKE '%1111%' OR number LIKE '%2222%' OR number LIKE '%3333%' OR number LIKE '%4444%' OR number LIKE '%5555%' OR number LIKE '%6666%' OR number LIKE '%7777%' OR number LIKE '%8888%' OR number LIKE '%9999%') AND number NOT LIKE '%000000%' AND number NOT LIKE '%111111%' AND number NOT LIKE '%222222%' AND number NOT LIKE '%333333%' AND number NOT LIKE '%444444%' AND number NOT LIKE '%555555%' AND number NOT LIKE '%666666%' AND number NOT LIKE '%777777%' AND number NOT LIKE '%888888%' AND number NOT LIKE '%999999%' AND number NOT LIKE '%00000%' AND number NOT LIKE '%11111%' AND number NOT LIKE '%22222%' AND number NOT LIKE '%33333%' AND number NOT LIKE '%44444%' AND number NOT LIKE '%55555%' AND number NOT LIKE '%66666%' AND number NOT LIKE '%77777%' AND number NOT LIKE '%88888%' AND number NOT LIKE '%99999%' THEN 'Sim tứ quý giữa'

 						WHEN RIGHT(number, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 3, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 4, 1) = SUBSTRING(number, 5, 1) THEN 'Sim gánh đảo,Sim gánh đảo kép'
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 3, 1) != SUBSTRING(number, 6, 1) THEN 'Sim gánh đảo,Sim gánh đảo đơn'
 						WHEN RIGHT(number, 1) > SUBSTRING(number, 7, 1) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 5, 1) THEN 'Sim tiến kép,Sim tiến kép ABB.ACC'
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 9, 1) > SUBSTRING(number, 6, 1) THEN 'Sim tiến kép,Sim tiến kép AAC.BBC'
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 9, 1) > SUBSTRING(number, 6, 1) AND SUBSTRING(number, 8, 1) > SUBSTRING(number, 5, 1) THEN 'Sim tiến kép,Sim tiến kép khác'
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 5, 1) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) THEN 'Sim soi gương'
 						WHEN SUBSTRING(number, 8, 2) = SUBSTRING(number, 5, 2) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 10, 1) > SUBSTRING(number, 7, 1) THEN 'Sim tiến ba,Sim tiến ba AAB.AAC'
 						WHEN RIGHT(number, 2) = SUBSTRING(number, 6, 2) AND SUBSTRING(number, 7, 1) != SUBSTRING(number, 6, 1) AND SUBSTRING(number, 8, 1) > SUBSTRING(number, 5, 1) THEN 'Sim tiến ba,Sim tiến ba CAB.DAB'
 						WHEN SUBSTRING(number, 8, 2) = SUBSTRING(number, 5, 2) AND SUBSTRING(number, 5, 1) != SUBSTRING(number, 6, 1) AND SUBSTRING(number, 10, 1) > SUBSTRING(number, 7, 1) THEN 'Sim tiến ba,Sim tiến ba ABC.ABD'
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 9, 1) > SUBSTRING(number, 6, 1) THEN 'Sim tiến ba,Sim tiến ba ACB.ADB'
 						WHEN RIGHT(number, 2) = SUBSTRING(number, 6, 2) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 8, 1) > SUBSTRING(number, 5, 1) THEN 'Sim tiến ba,Sim tiến ba ACC.BCC'

 						WHEN (RIGHT(number, 4) != 8386) AND ((RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 7, 1) > 1) OR (SUBSTRING(number, 9, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 10, 1) - SUBSTRING(number, 8, 1) > 1)) THEN 'Sim tiến đôi,Sim tiến đôi khác'

 						WHEN (RIGHT(number, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 6, 1) = 1 AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 5, 1)) OR (SUBSTRING(number, 9, 1) - SUBSTRING(number, 7, 1) = 1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 5, 1) = 1 AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 6, 1)) THEN 'Sim tiến đôi,Sim tiến 3 đôi cuối'
 						WHEN (RIGHT(number, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 6, 1) != 1) OR (SUBSTRING(number, 9, 1) - SUBSTRING(number, 7, 1) = 1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 5, 1) != 1 AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 8, 1)) THEN 'Sim tiến đôi,Sim tiến 2 đôi cuối'

 						WHEN RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 5, 1) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 6, 1) THEN 'Sim số gánh,Sim số gánh ACA.BCB'
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 5, 1) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 6, 1) THEN 'Sim số gánh,Sim số gánh ABA.ACA'
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 9, 1) THEN 'Sim số gánh,Sim số gánh ABA.CDC'
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) != SUBSTRING(number, 7, 1) AND SUBSTRING(number, 7, 1) != SUBSTRING(number, 9, 1) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) THEN 'Sim số gánh,Sim số gánh ABA'

 						WHEN RIGHT(number, 4) = 1102 THEN 'Sim đặc biệt,Nhất nhất không nhì'
 						WHEN RIGHT(number, 4) = 1368 THEN 'Sim đặc biệt,Sinh tài lộc phát'
 						WHEN RIGHT(number, 4) = 4078 THEN 'Sim đặc biệt,Bốn mùa không thất bát'
 						WHEN RIGHT(number, 4) = 8386 THEN 'Sim đặc biệt,Phát tài phát lộc'
 						WHEN RIGHT(number, 4) = 8683 THEN 'Sim đặc biệt,Phát lộc phát tài'
 						WHEN RIGHT(number, 4) = 8910 THEN 'Sim đặc biệt,Cao hơn người'
 						WHEN RIGHT(number, 6) = 151618 THEN 'Sim đặc biệt,Mỗi năm mỗi lộc mỗi phát'
 						WHEN RIGHT(number, 6) = '049053' THEN 'Sim đặc biệt,Không gặp hạn'

 						WHEN (RIGHT(number, 2) < 20 OR RIGHT(number, 2) > 49) AND SUBSTRING(number, 7, 2) < 13 AND SUBSTRING(number, 7, 2) > 0 AND SUBSTRING(number, 5, 2) < 32 AND SUBSTRING(number, 5, 2) > 0 THEN 'Năm sinh DD/MM/YY'
 						WHEN RIGHT(number, 2) IN (68,86) THEN 'Sim lộc phát'
 						WHEN RIGHT(number, 2) IN (39,79) THEN 'Sim thần tài'
 						WHEN RIGHT(number, 2) IN (38,78) THEN 'Sim ông địa'
 						WHEN ((SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) = 1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) = 1) OR (SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) = 1 AND SUBSTRING(number, 6, 1) - SUBSTRING(number, 5, 1) = 1) OR (SUBSTRING(number, 6, 1) - SUBSTRING(number, 5, 1) = 1 AND SUBSTRING(number, 5, 1) - SUBSTRING(number, 4, 1) = 1) OR(SUBSTRING(number, 5, 1) - SUBSTRING(number, 4, 1) = 1 AND SUBSTRING(number, 4, 1) - SUBSTRING(number, 3, 1) = 1)) AND SUBSTRING(number, 5, 1) != SUBSTRING(number, 9, 1) AND cat_id NOT LIKE '%,28,%' THEN 'Sim tiến giữa'
 						WHEN LEFT(number, 4) IN (0903,0913,0983) THEN 'Sim đầu số cổ'
 						WHEN price < 500000 THEN 'Sim giá rẻ'


						ELSE 'Sim dễ nhớ'
                    END;


				UPDATE fs_sim_".$item->id." 
 					SET     cat_alias =  CASE
 						WHEN RIGHT(number, 6) IN (000000,111111,222222,333333,444444,555555,666666,777777,888888,999999) THEN ',sim-luc-quy,'
 						WHEN RIGHT(number, 5) IN (00000,11111,22222,33333,44444,55555,66666,77777,88888,99999) THEN ',sim-ngu-quy,'

                        WHEN RIGHT(number, 4) = 0000 THEN ',sim-tu-quy,tu-quy-0000,'
 						WHEN RIGHT(number, 4) = 1111 THEN ',sim-tu-quy,tu-quy-1111,' 
                        WHEN RIGHT(number, 4) = 2222 THEN ',sim-tu-quy,tu-quy-2222,' 
                        WHEN RIGHT(number, 4) = 3333 THEN ',sim-tu-quy,tu-quy-3333,'
						WHEN RIGHT(number, 4) = 4444 THEN ',sim-tu-quy,tu-quy-4444,'
						WHEN RIGHT(number, 4) = 5555 THEN ',sim-tu-quy,tu-quy-5555,'
						WHEN RIGHT(number, 4) = 6666 THEN ',sim-tu-quy,tu-quy-6666,'
						WHEN RIGHT(number, 4) = 7777 THEN ',sim-tu-quy,tu-quy-7777,'
						WHEN RIGHT(number, 4) = 8888 THEN ',sim-tu-quy,tu-quy-8888,'
						WHEN RIGHT(number, 4) = 9999 THEN ',sim-tu-quy,tu-quy-9999,'

 						WHEN RIGHT(number, 3) IN (000,111,222,333,444,555,666,777,888,999) AND SUBSTRING(number, 5, 3) IN (000,111,222,333,444,555,666,777,888,999) THEN ',sim-tam-hoa-kep,'  
 						WHEN RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 7, 2) = SUBSTRING(number, 5, 2) THEN ',sim-taxi-2,'

 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 8, 1) THEN ',sim-taxi-3,taxi-abaaba,'  
 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 9, 1) THEN ',sim-taxi-3,taxi-aabaab,'  
 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 9, 1) THEN ',sim-taxi-3,taxi-baabaa,'
 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 9, 1) THEN ',sim-taxi-3,taxi-abcabc,'

 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) THEN ',sim-taxi-4,taxi-abbbabbb,'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) THEN ',sim-taxi-4,taxi-aaabaaab,'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) THEN ',sim-taxi-4,taxi-abbaabba,'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) THEN ',sim-taxi-4,taxi-aabbaabb,'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) THEN ',sim-taxi-4,taxi-4-khac,'

						WHEN RIGHT(number, 3) = 000 THEN ',sim-tam-hoa,tam-hoa-000,'
 						WHEN RIGHT(number, 3) = 111 THEN ',sim-tam-hoa,tam-hoa-111,'
 						WHEN RIGHT(number, 3) = 222 THEN ',sim-tam-hoa,tam-hoa-222,'
 						WHEN RIGHT(number, 3) = 333 THEN ',sim-tam-hoa,tam-hoa-333,'
 						WHEN RIGHT(number, 3) = 444 THEN ',sim-tam-hoa,tam-hoa-444,'
 						WHEN RIGHT(number, 3) = 555 THEN ',sim-tam-hoa,tam-hoa-555,'
 						WHEN RIGHT(number, 3) = 666 THEN ',sim-tam-hoa,tam-hoa-666,'
 						WHEN RIGHT(number, 3) = 777 THEN ',sim-tam-hoa,tam-hoa-777,'
 						WHEN RIGHT(number, 3) = 888 THEN ',sim-tam-hoa,tam-hoa-888,'
 						WHEN RIGHT(number, 3) = 999 THEN ',sim-tam-hoa,tam-hoa-999,'
 							
						WHEN RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 6, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) THEN ',sim-so-kep,so-kep-aaaabb,'
						WHEN RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND RIGHT(number, 1) = SUBSTRING(number, 5, 1) THEN ',sim-so-kep,so-kep-aa-bb-aa,'
						WHEN RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND RIGHT(number, 1) != SUBSTRING(number, 5, 1) THEN ',sim-so-kep,so-kep-aa-bb-cc,'
						WHEN RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) != SUBSTRING(number, 6, 1) THEN ',sim-so-kep,so-kep-aa-bb,'
						WHEN RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 7, 2) != SUBSTRING(number, 5, 2) THEN ',sim-so-lap,'
						WHEN RIGHT(number, 1) - SUBSTRING(number, 9, 1) = 2 AND  SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) = 2 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) = 2 THEN ',sim-tien-don,tien-don-dac-biet,'
						WHEN RIGHT(number, 1) - SUBSTRING(number, 9, 1) = 1 AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) =1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) =1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) =1 AND SUBSTRING(number, 6, 1) - SUBSTRING(number, 5, 1) = 1 THEN ',sim-tien-don,tien-don-6,'
						WHEN RIGHT(number, 1) - SUBSTRING(number, 9, 1) = 1 AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) = 1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) = 1 AND SUBSTRING(number, 6, 1) - SUBSTRING(number, 5, 1) != 1 THEN ',sim-tien-don,tien-don-5,'
						WHEN RIGHT(number, 1) - SUBSTRING(number, 9, 1) =1 AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) = 1  AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) != 1 THEN ',sim-tien-don,sim-tien-don-4,'
						WHEN RIGHT(number, 1) - SUBSTRING(number, 9, 1) = 1 AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) != 1 THEN ',sim-tien-don,tien-don-3,'
						WHEN RIGHT(number, 1) > SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) > SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) > SUBSTRING(number, 7, 1) THEN ',sim-tien-don,tien-don-khac,'


						WHEN RIGHT(number, 4) IN (".$year5x.") THEN ',sim-nam-sinh,nam-sinh-195x,'
 						WHEN RIGHT(number, 4) IN (".$year6x.") THEN ',sim-nam-sinh,nam-sinh-196x,'
 						WHEN RIGHT(number, 4) IN (".$year7x.") THEN ',sim-nam-sinh,nam-sinh-197x,'
 						WHEN RIGHT(number, 4) IN (".$year8x.") THEN ',sim-nam-sinh,nam-sinh-198x,'
 						WHEN RIGHT(number, 4) IN (".$year9x.") THEN ',sim-nam-sinh,nam-sinh-199x,'
 						WHEN RIGHT(number, 4) IN (".$year10x.") THEN ',sim-nam-sinh,nam-sinh-200x,'
 						WHEN RIGHT(number, 4) IN (".$year11x.") THEN ',sim-nam-sinh,nam-sinh-201x,'


 						WHEN (number LIKE '%000000%' OR number LIKE '%111111%' OR number LIKE '%222222%' OR number LIKE '%333333%' OR number LIKE '%444444%' OR number LIKE '%555555%' OR number LIKE '%666666%' OR number LIKE '%777777%' OR number LIKE '%888888%' OR number LIKE '%999999%') THEN ',sim-luc-quy-giua,'
 						WHEN (number LIKE '%00000%' OR number LIKE '%11111%' OR number LIKE '%22222%' OR number LIKE '%33333%' OR number LIKE '%44444%' OR number LIKE '%55555%' OR number LIKE '%66666%' OR number LIKE '%77777%' OR number LIKE '%88888%' OR number LIKE '%99999%') AND number NOT LIKE '%000000%' AND number NOT LIKE '%111111%' AND number NOT LIKE '%222222%' AND number NOT LIKE '%333333%' AND number NOT LIKE '%444444%' AND number NOT LIKE '%555555%' AND number NOT LIKE '%666666%' AND number NOT LIKE '%777777%' AND number NOT LIKE '%888888%' AND number NOT LIKE '%999999%' THEN ',sim-ngu-quy-giua,'
 						WHEN (number LIKE '%0000%' OR number LIKE '%1111%' OR number LIKE '%2222%' OR number LIKE '%3333%' OR number LIKE '%4444%' OR number LIKE '%5555%' OR number LIKE '%6666%' OR number LIKE '%7777%' OR number LIKE '%8888%' OR number LIKE '%9999%') AND number NOT LIKE '%000000%' AND number NOT LIKE '%111111%' AND number NOT LIKE '%222222%' AND number NOT LIKE '%333333%' AND number NOT LIKE '%444444%' AND number NOT LIKE '%555555%' AND number NOT LIKE '%666666%' AND number NOT LIKE '%777777%' AND number NOT LIKE '%888888%' AND number NOT LIKE '%999999%' AND number NOT LIKE '%00000%' AND number NOT LIKE '%11111%' AND number NOT LIKE '%22222%' AND number NOT LIKE '%33333%' AND number NOT LIKE '%44444%' AND number NOT LIKE '%55555%' AND number NOT LIKE '%66666%' AND number NOT LIKE '%77777%' AND number NOT LIKE '%88888%' AND number NOT LIKE '%99999%' THEN ',sim-tu-quy-giua,'
 						
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 3, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 4, 1) = SUBSTRING(number, 5, 1) THEN ',sim-ganh-dao,ganh-dao-kep,'
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 3, 1) != SUBSTRING(number, 6, 1) THEN ',sim-ganh-dao,sim-ganh-dao-don,'
 						WHEN RIGHT(number, 1) > SUBSTRING(number, 7, 1) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 5, 1) THEN ',sim-tien-kep,tien-kep-abbacc,'
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 9, 1) > SUBSTRING(number, 6, 1) THEN ',sim-tien-kep,tien-kep-aacbcc,'
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 9, 1) > SUBSTRING(number, 6, 1) AND SUBSTRING(number, 8, 1) > SUBSTRING(number, 5, 1) THEN ',sim-tien-kep,tien-kep-khac,'
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 5, 1) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) THEN ',sim-soi-guong,'
 						WHEN SUBSTRING(number, 8, 2) = SUBSTRING(number, 5, 2) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 10, 1) > SUBSTRING(number, 7, 1) THEN ',sim-tien-ba,tien-ba-aab-aac,'
 						WHEN RIGHT(number, 2) = SUBSTRING(number, 6, 2) AND SUBSTRING(number, 7, 1) != SUBSTRING(number, 6, 1) AND SUBSTRING(number, 8, 1) > SUBSTRING(number, 5, 1) THEN ',sim-tien-ba,tien-ba-cab-dab,'
 						WHEN SUBSTRING(number, 8, 2) = SUBSTRING(number, 5, 2) AND SUBSTRING(number, 5, 1) != SUBSTRING(number, 6, 1) AND SUBSTRING(number, 10, 1) > SUBSTRING(number, 7, 1) THEN ',sim-tien-ba,tien-ba-abc-abd,'
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 9, 1) > SUBSTRING(number, 6, 1) THEN ',sim-tien-ba,tien-ba-acb-adb,'
 						WHEN RIGHT(number, 2) = SUBSTRING(number, 6, 2) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 8, 1) > SUBSTRING(number, 5, 1) THEN ',sim-tien-ba,tien-ba-accbcc,'
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 5, 1) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 6, 1) THEN ',sim-so-ganh,so-ganh-acabcb,'
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 5, 1) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 6, 1) THEN ',sim-so-ganh,so-ganh-abaaca,'
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 9, 1) THEN ',sim-so-ganh,so-ganh-abacdc,'
 						WHEN RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) != SUBSTRING(number, 7, 1) AND SUBSTRING(number, 7, 1) != SUBSTRING(number, 9, 1) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) THEN ',sim-so-ganh,so-ganh-aba,'
 						WHEN (RIGHT(number, 4) != 8386) AND ((RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 7, 1) > 1) OR (SUBSTRING(number, 9, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 10, 1) - SUBSTRING(number, 8, 1) > 1)) THEN ',sim-tien-doi,tien-doi-khac,'
 						WHEN (RIGHT(number, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 6, 1) = 1 AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 5, 1)) OR (SUBSTRING(number, 9, 1) - SUBSTRING(number, 7, 1) = 1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 5, 1) = 1 AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 6, 1)) THEN ',sim-tien-doi,tien-doi-3,'
 						WHEN (RIGHT(number, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 6, 1) != 1) OR (SUBSTRING(number, 9, 1) - SUBSTRING(number, 7, 1) = 1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 5, 1) != 1 AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 8, 1)) THEN ',sim-tien-doi,tien-doi-2,'
 						WHEN RIGHT(number, 4) = 1102 THEN ',sim-dac-biet,nhat-nhat-khong-nhi,'
 						WHEN RIGHT(number, 4) = 1368 THEN ',sim-dac-biet,sinh-tai-loc-phat,'
 						WHEN RIGHT(number, 4) = 4078 THEN ',sim-dac-biet,bon-mua-khong-that-bat,'
 						WHEN RIGHT(number, 4) = 8386 THEN ',sim-dac-biet,phat-tai-phat-loc,'
 						WHEN RIGHT(number, 4) = 8683 THEN ',sim-dac-biet,phat-loc-phat-tai,'
 						WHEN RIGHT(number, 4) = 8910 THEN ',sim-dac-biet,cao-hon-nguoi,'
 						WHEN RIGHT(number, 6) = 151618 THEN ',sim-dac-biet,moi-nam-moi-loc-moi-phat,'
 						WHEN RIGHT(number, 6) = '049053' THEN ',sim-dac-biet,khong-gap-han,'

 						WHEN (RIGHT(number, 2) < 20 OR RIGHT(number, 2) > 49) AND SUBSTRING(number, 7, 2) < 13 AND SUBSTRING(number, 7, 2) > 0 AND SUBSTRING(number, 5, 2) < 32 AND SUBSTRING(number, 5, 2) > 0 THEN ',sim-ngay-thang-nam-sinh,'
 						WHEN RIGHT(number, 2) IN (68,86) THEN ',sim-loc-phat,'
 						WHEN RIGHT(number, 2) IN (39,79) THEN ',sim-than-tai,'
 						WHEN RIGHT(number, 2) IN (38,78) THEN ',sim-ong-dia,'
 						WHEN ((SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) = 1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) = 1) OR (SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) = 1 AND SUBSTRING(number, 6, 1) - SUBSTRING(number, 5, 1) = 1) OR (SUBSTRING(number, 6, 1) - SUBSTRING(number, 5, 1) = 1 AND SUBSTRING(number, 5, 1) - SUBSTRING(number, 4, 1) = 1) OR(SUBSTRING(number, 5, 1) - SUBSTRING(number, 4, 1) = 1 AND SUBSTRING(number, 4, 1) - SUBSTRING(number, 3, 1) = 1)) AND SUBSTRING(number, 5, 1) != SUBSTRING(number, 9, 1) AND cat_id NOT LIKE '%,28,%' THEN ',sim-tien-giua,'
 						WHEN LEFT(number, 4) IN (0903,0913,0983) THEN ',sim-dau-so-co,'
 						WHEN price < 500000 THEN ',sim-gia-re,'


						ELSE ',sim-de-nho,'
                    END;


			";

			}}
//			 var_dump($sql);die;

	        $db->query($sql);
			$row = $db->affected_rows();

			// $link = FSRoute::_(URL_ROOT.'admin_sim');
   //          setRedirect($link);
		}


		// cập nhật loại sim (cập nhật vào bảng tạm trước)
		// function update_cat1()
		// {
		// 	// var_dump(1);die;
		// 	// call models
		// 	$model = $this -> model;
		// 	global $db;

		// 	$year5x = '1950';
		// 	$year6x = '1960';
		// 	$year7x = '1970';
		// 	$year8x = '1980';
		// 	$year9x = '1990';
		// 	$year10x = '2000';
		// 	$year11x = '2010';
		// 	for ($x = 1951; $x <= 1960; $x++) {
		// 		$year5x .= ",".$x;
		// 	}

		// 	for ($x = 1961; $x <= 1970; $x++) {
		// 		$year6x .= ",".$x;
		// 	}

		// 	for ($x = 1971; $x <= 1980; $x++) {
		// 		$year7x .= ",".$x;
		// 	}

		// 	for ($x = 1981; $x <= 1990; $x++) {
		// 		$year8x .= ",".$x;
		// 	}

		// 	for ($x = 1991; $x <= 2000; $x++) {
		// 		$year9x .= ",".$x;
		// 	}

		// 	for ($x = 2001; $x <= 2010; $x++) {
		// 		$year10x .= ",".$x;
		// 	}

		// 	for ($x = 2011; $x <= 2020; $x++) {
		// 		$year11x .= ",".$x;
		// 	}

		// 	$key = 1;
		// 	for ($x = 2; $x <= 20; $x++) {
		// 		$key .= ",".$x;
		// 	}

		// 	$users = $model->get_records('published = 1 AND type = 2','fs_users','id,full_name');
		// 	$sql = '';
		// 	foreach ($users as $item) {

		// 	$total = $model->get_count('','fs_sim_'.$item->id.'','id');
		// 	if ($total>0) {

		// 	$sql .= "
		//        	UPDATE fs_sim_".$item->id." SET cat_id ='', cat_alias ='', cat_name =''  WHERE cat_id IS NULL;

		// 		UPDATE fs_sim_".$item->id."  
		// 			SET     cat_id =  CASE
		// 				WHEN RIGHT(number, 6) IN (000000,111111,222222,333333,444444,555555,666666,777777,888888,999999) THEN ',2,'
		// 				WHEN RIGHT(number, 5) IN (00000,11111,22222,33333,44444,55555,66666,77777,88888,99999) THEN ',3,'

  //                       WHEN RIGHT(number, 4) = 0000 THEN ',4,63,'
		// 				WHEN RIGHT(number, 4) = 1111 THEN ',4,71,' 
  //                       WHEN RIGHT(number, 4) = 2222 THEN ',4,70,' 
  //                       WHEN RIGHT(number, 4) = 3333 THEN ',4,69,'
		// 				WHEN RIGHT(number, 4) = 4444 THEN ',4,68,'
		// 				WHEN RIGHT(number, 4) = 5555 THEN ',4,67,'
		// 				WHEN RIGHT(number, 4) = 6666 THEN ',4,66,'
		// 				WHEN RIGHT(number, 4) = 7777 THEN ',4,65,'
		// 				WHEN RIGHT(number, 4) = 8888 THEN ',4,64,'
		// 				WHEN RIGHT(number, 4) = 9999 THEN ',4,72,'

		// 				WHEN RIGHT(number, 3) IN (000,111,222,333,444,555,666,777,888,999) AND SUBSTRING(number, 5, 3) IN (000,111,222,333,444,555,666,777,888,999) THEN ',5,'
		// 				WHEN RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 7, 2) = SUBSTRING(number, 5, 2) THEN ',7,'

		// 				WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 8, 1) THEN ',8,9,'  
 	// 					WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 9, 1) THEN ',8,10,'  
 	// 					WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 9, 1) THEN ',8,11,'
 	// 					WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) THEN ',8,12,' 
 	// 					ELSE cat_id
  //                   END;
 
		// 		UPDATE fs_sim_".$item->id."  
		// 			SET     cat_alias =  CASE
		// 				WHEN RIGHT(number, 6) IN (000000,111111,222222,333333,444444,555555,666666,777777,888888,999999) THEN ',luc-quy,'
		// 				WHEN RIGHT(number, 5) IN (00000,11111,22222,33333,44444,55555,66666,77777,88888,99999) THEN ',ngu-quy,'

  //                       WHEN RIGHT(number, 4) = 0000 THEN ',sim-tu-quy,sim-tu-quy-0000,'
		// 				WHEN RIGHT(number, 4) = 1111 THEN ',sim-tu-quy,sim-tu-quy-1111,' 
  //                       WHEN RIGHT(number, 4) = 2222 THEN ',sim-tu-quy,sim-tu-quy-2222,' 
  //                       WHEN RIGHT(number, 4) = 3333 THEN ',sim-tu-quy,sim-tu-quy-3333,'
		// 				WHEN RIGHT(number, 4) = 4444 THEN ',sim-tu-quy,sim-tu-quy-4444,'
		// 				WHEN RIGHT(number, 4) = 5555 THEN ',sim-tu-quy,sim-tu-quy-5555,'
		// 				WHEN RIGHT(number, 4) = 6666 THEN ',sim-tu-quy,sim-tu-quy-6666,'
		// 				WHEN RIGHT(number, 4) = 7777 THEN ',sim-tu-quy,sim-tu-quy-7777,'
		// 				WHEN RIGHT(number, 4) = 8888 THEN ',sim-tu-quy,sim-tu-quy-8888,'
		// 				WHEN RIGHT(number, 4) = 9999 THEN ',sim-tu-quy,sim-tu-quy-9999,'

		// 				WHEN RIGHT(number, 3) IN (000,111,222,333,444,555,666,777,888,999) AND SUBSTRING(number, 5, 3) IN (000,111,222,333,444,555,666,777,888,999) THEN ',tam-hoa-kep,'
		// 				WHEN RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 7, 2) = SUBSTRING(number, 5, 2) THEN ',taxi-2,'
						
		// 				WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 8, 1) THEN ',taxi-3,taxi-aba-aba,'  
 	// 					WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 9, 1) THEN ',taxi-3,taxi-aab-aab,'  
 	// 					WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 9, 1) THEN ',taxi-3,taxi-baa-baa,'
 	// 					WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) THEN ',taxi-3,taxi-abc-abc,'
		// 				ELSE cat_alias
  //                   END;

		// 		UPDATE fs_sim_".$item->id." 
 	// 				SET     cat_name =  CASE
 	// 					WHEN RIGHT(number, 6) IN (000000,111111,222222,333333,444444,555555,666666,777777,888888,999999) THEN ',Sim lục quý,'
 	// 					WHEN RIGHT(number, 5) IN (00000,11111,22222,33333,44444,55555,66666,77777,88888,99999) THEN ',Sim ngũ quý,'

  //                       WHEN RIGHT(number, 4) = 0000 THEN ',Sim tứ quý,Sim tứ quý 0000,'
 	// 					WHEN RIGHT(number, 4) = 1111 THEN ',Sim tứ quý,Sim tứ quý 1111,' 
  //                       WHEN RIGHT(number, 4) = 2222 THEN ',Sim tứ quý,Sim tứ quý 2222,' 
  //                       WHEN RIGHT(number, 4) = 3333 THEN ',Sim tứ quý,Sim tứ quý 3333,'
		// 				WHEN RIGHT(number, 4) = 4444 THEN ',Sim tứ quý,Sim tứ quý 4444,'
		// 				WHEN RIGHT(number, 4) = 5555 THEN ',Sim tứ quý,Sim tứ quý 5555,'
		// 				WHEN RIGHT(number, 4) = 6666 THEN ',Sim tứ quý,Sim tứ quý 6666,'
		// 				WHEN RIGHT(number, 4) = 7777 THEN ',Sim tứ quý,Sim tứ quý 7777,'
		// 				WHEN RIGHT(number, 4) = 8888 THEN ',Sim tứ quý,Sim tứ quý 8888,'
		// 				WHEN RIGHT(number, 4) = 9999 THEN ',Sim tứ quý,Sim tứ quý 9999,'

 	// 					WHEN RIGHT(number, 3) IN (000,111,222,333,444,555,666,777,888,999) AND SUBSTRING(number, 5, 3) IN (000,111,222,333,444,555,666,777,888,999) THEN ',Sim tam hoa kép,'  
 	// 					WHEN RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 7, 2) = SUBSTRING(number, 5, 2) THEN ',Sim taxi 2,'

 	// 					WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 8, 1) THEN ',Sim taxi 3,Sim taxi ABA.ABA,'  
 	// 					WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 9, 1) THEN ',Sim taxi 3,Sim taxi AAB.AAB,'  
 	// 					WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 9, 1) THEN ',Sim taxi 3,Sim taxi BAA.BAA,'
 	// 					WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) THEN ',Sim taxi 3,Sim taxi ABC.ABC,'
		// 				ELSE cat_name
  //                   END;

		// 		UPDATE fs_sim_".$item->id." SET cat_type = '1' WHERE cat_id != '';

		// 		UPDATE fs_sim_".$item->id."  
		// 			SET     cat_id =  CASE
		// 				WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',13,83'
 	// 					WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',13,87'
 	// 					WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',13,86'
 	// 					WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND cat_type IS NULL THEN ',13,88'
 	// 					WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',13,85'
 	// 					WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',13,84'
 	// 					ELSE cat_id 
  //                   END;
 
		// 		UPDATE fs_sim_".$item->id."  
		// 			SET     cat_alias =  CASE
		// 				WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',taxi-4,sim-taxi-abcdabcd'
 	// 					WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',taxi-4,sim-taxi-abbbabbb'
 	// 					WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',taxi-4,sim-taxi-aaabaaab'
 	// 					WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND cat_type IS NULL THEN ',Sim taxi 4,sim-taxi-abbaabba'
 	// 					WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',taxi-4,sim-taxi-aabbaabb'
 	// 					WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',taxi-4,sim-taxi-4-khac'
 	// 					ELSE cat_alias
  //                   END;

		// 		UPDATE fs_sim_".$item->id." 
 	// 				SET     cat_name =  CASE
 	// 					WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',Sim taxi 4,Sim taxi ABCD.ABCD'
 	// 					WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',Sim taxi 4,Sim taxi ABBB.ABBB'
 	// 					WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',Sim taxi 4,Sim taxi AAAB.AAAB'
 	// 					WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND cat_type IS NULL THEN ',Sim taxi 4,Sim taxi ABBA.ABBA'
 	// 					WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',Sim taxi 4,Sim taxi AABB.AABB'
 	// 					WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',Sim taxi 4,Sim taxi 4 khác'
 	// 					ELSE cat_name
  //                   END;

		// 		UPDATE fs_sim_".$item->id."  
		// 			SET     cat_id =  CASE
 	// 					WHEN RIGHT(number, 3) = 000 AND cat_type IS NULL THEN CONCAT(cat_name, ',6,82')
 	// 					WHEN RIGHT(number, 3) = 111 AND cat_type IS NULL THEN CONCAT(cat_name, ',6,81')
 	// 					WHEN RIGHT(number, 3) = 222 AND cat_type IS NULL THEN CONCAT(cat_name, ',6,80')
 	// 					WHEN RIGHT(number, 3) = 333 AND cat_type IS NULL THEN CONCAT(cat_name, ',6,79')
 	// 					WHEN RIGHT(number, 3) = 444 AND cat_type IS NULL THEN CONCAT(cat_name, ',6,78')
 	// 					WHEN RIGHT(number, 3) = 555 AND cat_type IS NULL THEN CONCAT(cat_name, ',6,77')
 	// 					WHEN RIGHT(number, 3) = 666 AND cat_type IS NULL THEN CONCAT(cat_name, ',6,76')
 	// 					WHEN RIGHT(number, 3) = 777 AND cat_type IS NULL THEN CONCAT(cat_name, ',6,75')
 	// 					WHEN RIGHT(number, 3) = 888 AND cat_type IS NULL THEN CONCAT(cat_name, ',6,74')
 	// 					WHEN RIGHT(number, 3) = 999 AND cat_type IS NULL THEN CONCAT(cat_name, ',6,73')
 	// 					ELSE cat_id
  //                   END;
 
		// 		UPDATE fs_sim_".$item->id."  
		// 			SET     cat_alias =  CASE
 	// 					WHEN RIGHT(number, 3) = 000 AND cat_type IS NULL THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-000')
 	// 					WHEN RIGHT(number, 3) = 111 AND cat_type IS NULL THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-111')
 	// 					WHEN RIGHT(number, 3) = 222 AND cat_type IS NULL THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-222')
 	// 					WHEN RIGHT(number, 3) = 333 AND cat_type IS NULL THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-333')
 	// 					WHEN RIGHT(number, 3) = 444 AND cat_type IS NULL THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-444')
 	// 					WHEN RIGHT(number, 3) = 555 AND cat_type IS NULL THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-555')
 	// 					WHEN RIGHT(number, 3) = 666 AND cat_type IS NULL THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-666')
 	// 					WHEN RIGHT(number, 3) = 777 AND cat_type IS NULL THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-777')
 	// 					WHEN RIGHT(number, 3) = 888 AND cat_type IS NULL THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-888')
 	// 					WHEN RIGHT(number, 3) = 999 AND cat_type IS NULL THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-999')
 	// 					ELSE cat_alias
  //                   END;

		// 		UPDATE fs_sim_".$item->id." 
 	// 				SET     cat_name =  CASE
 	// 					WHEN RIGHT(number, 3) = 000 AND cat_type IS NULL THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 000')
 	// 					WHEN RIGHT(number, 3) = 111 AND cat_type IS NULL THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 111')
 	// 					WHEN RIGHT(number, 3) = 222 AND cat_type IS NULL THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 222')
 	// 					WHEN RIGHT(number, 3) = 333 AND cat_type IS NULL THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 333')
 	// 					WHEN RIGHT(number, 3) = 444 AND cat_type IS NULL THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 444')
 	// 					WHEN RIGHT(number, 3) = 555 AND cat_type IS NULL THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 555')
 	// 					WHEN RIGHT(number, 3) = 666 AND cat_type IS NULL THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 666')
 	// 					WHEN RIGHT(number, 3) = 777 AND cat_type IS NULL THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 777')
 	// 					WHEN RIGHT(number, 3) = 888 AND cat_type IS NULL THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 888')
 	// 					WHEN RIGHT(number, 3) = 999 AND cat_type IS NULL THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 999')
 	// 					ELSE cat_name
  //                   END;


		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',14,15'),cat_alias = CONCAT(cat_alias, ',so-kep,so-kep-aa-bb-aa'),cat_name = CONCAT(cat_name, ',Sim số kép,Sim số kép AA.BB.AA')
		// 			WHERE RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND RIGHT(number, 1) = SUBSTRING(number, 5, 1) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',14,16',cat_alias) = CONCAT(cat_alias, ',so-kep,so-kep-aa-bb-cc'),cat_name = CONCAT(cat_name, ',Sim số kép,Sim số kép AA.BB.CC')
		// 			WHERE RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND RIGHT(number, 1) != SUBSTRING(number, 5, 1) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',14,17'),cat_alias = CONCAT(cat_alias, ',so-kep,so-kep-aa-bb'),cat_name = CONCAT(cat_name, ',Sim số kép,Sim số kép AA.BB')
		// 			WHERE RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) != SUBSTRING(number, 6, 1) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',14,93',cat_alias) = CONCAT(cat_alias, ',so-kep,so-kep-aaaabb'),cat_name = CONCAT(cat_name, ',Sim số kép,Sim số kép AAAA.BB')
		// 			WHERE RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 6, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND cat_type IS NULL; 

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',18'),cat_alias = CONCAT(cat_alias, ',so-lap'),cat_name = CONCAT(cat_name, ',Sim số lặp')
		// 			WHERE RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 7, 2) != SUBSTRING(number, 5, 2) AND cat_type IS NULL;
				
		//        	Update fs_sim_".$item->id." SET cat_id =CONCAT(cat_id, ',28,29'),cat_alias = CONCAT(cat_alias, ',tien-don,tien-don-dac-biet'),cat_name =CONCAT(cat_name, ',Sim tiến đơn,Sim tiến đơn đặc biệt')  WHERE 
		// 			RIGHT(number, 1) - SUBSTRING(number, 9, 1) = 2 AND  SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) = 2 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) = 2 AND cat_type IS NULL;
					
		// 		Update fs_sim_".$item->id." SET cat_id =CONCAT(cat_id, ',28,30'),cat_alias = CONCAT(cat_alias, ',tien-don,tien-don-6'),cat_name = CONCAT(cat_name, ',Sim tiến đơn,Sim tiến đơn 6')  WHERE 
		// 			RIGHT(number, 1) - SUBSTRING(number, 9, 1) = 1 AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) =1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) =1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) =1 AND SUBSTRING(number, 6, 1) - SUBSTRING(number, 5, 1) = 1 AND cat_type IS NULL;
					
		// 		Update fs_sim_".$item->id." SET cat_id =CONCAT(cat_id, ',28,31'),cat_alias = CONCAT(cat_alias, ',tien-don,tien-don-5'),cat_name = CONCAT(cat_name, ',Sim tiến đơn,Sim tiến đơn 5')  WHERE 
		// 			RIGHT(number, 1) - SUBSTRING(number, 9, 1) = 1 AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) = 1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) = 1 AND SUBSTRING(number, 6, 1) - SUBSTRING(number, 5, 1) != 1 AND cat_type IS NULL;
					
		// 		Update fs_sim_".$item->id." SET cat_id =CONCAT(cat_id, ',28,32'),cat_alias = CONCAT(cat_alias, ',tien-don,tien-don-4'),cat_name = CONCAT(cat_name, ',Sim tiến đơn,Sim tiến đơn 4')  WHERE 
		// 			RIGHT(number, 1) - SUBSTRING(number, 9, 1) =1 AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) = 1  AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) != 1 AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id =CONCAT(cat_id, ',28,33'),cat_alias = CONCAT(cat_alias, ',tien-don,tien-don-3'),cat_name = CONCAT(cat_name, ',Sim tiến đơn,Sim tiến đơn 3')  WHERE 
		// 			RIGHT(number, 1) - SUBSTRING(number, 9, 1) = 1 AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) != 1 AND cat_type IS NULL;
						
		// 		Update fs_sim_".$item->id." SET cat_id =CONCAT(cat_id, ',28,34'),cat_alias = CONCAT(cat_alias, ',tien-don,tien-don-khac'),cat_name = CONCAT(cat_name, ',Sim tiến đơn,Sim tiến đơn khác')  WHERE 
		// 			RIGHT(number, 1) > SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) > SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) > SUBSTRING(number, 7, 1) AND cat_id NOT LIKE '%,28,%'  AND cat_type IS NULL;

		// 		UPDATE fs_sim_".$item->id."  
		// 			SET     cat_id =  CASE
 	// 					WHEN RIGHT(number, 4) IN (".$year5x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',96,60')
 	// 					WHEN RIGHT(number, 4) IN (".$year6x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',97,60')
 	// 					WHEN RIGHT(number, 4) IN (".$year7x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',98,60')
 	// 					WHEN RIGHT(number, 4) IN (".$year8x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',99,60')
 	// 					WHEN RIGHT(number, 4) IN (".$year9x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',100,60')
 	// 					WHEN RIGHT(number, 4) IN (".$year10x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',101,60')
 	// 					WHEN RIGHT(number, 4) IN (".$year11x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',102,60')
 	// 					ELSE cat_id
  //                   END;
 
		// 		UPDATE fs_sim_".$item->id."  
		// 			SET     cat_alias =  CASE
 	// 					WHEN RIGHT(number, 4) IN (".$year5x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',sim-nam-sinh,sim-nam-sinh-195x')
 	// 					WHEN RIGHT(number, 4) IN (".$year6x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',sim-nam-sinh,sim-nam-sinh-196x')
 	// 					WHEN RIGHT(number, 4) IN (".$year7x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',sim-nam-sinh,sim-nam-sinh-197x')
 	// 					WHEN RIGHT(number, 4) IN (".$year8x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',sim-nam-sinh,sim-nam-sinh-198x')
 	// 					WHEN RIGHT(number, 4) IN (".$year9x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',sim-nam-sinh,sim-nam-sinh-199x')
 	// 					WHEN RIGHT(number, 4) IN (".$year10x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',sim-nam-sinh,sim-nam-sinh-200x')
 	// 					WHEN RIGHT(number, 4) IN (".$year11x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',sim-nam-sinh,sim-nam-sinh-201x')
 	// 					ELSE cat_alias
  //                   END;

		// 		UPDATE fs_sim_".$item->id." 
 	// 				SET     cat_name =  CASE
 	// 					WHEN RIGHT(number, 4) IN (".$year5x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',Sim năm sinh,Sim năm sinh 195x')
 	// 					WHEN RIGHT(number, 4) IN (".$year6x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',Sim năm sinh,Sim năm sinh 196x')
 	// 					WHEN RIGHT(number, 4) IN (".$year7x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',Sim năm sinh,Sim năm sinh 197x')
 	// 					WHEN RIGHT(number, 4) IN (".$year8x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',Sim năm sinh,Sim năm sinh 198x')
 	// 					WHEN RIGHT(number, 4) IN (".$year9x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',Sim năm sinh,Sim năm sinh 199x')
 	// 					WHEN RIGHT(number, 4) IN (".$year10x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',Sim năm sinh,Sim năm sinh 200x')
 	// 					WHEN RIGHT(number, 4) IN (".$year11x.") AND cat_type IS NULL THEN CONCAT(cat_name, ',Sim năm sinh,Sim năm sinh 201x')
 	// 					ELSE cat_name
  //                   END;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',54'),cat_alias = CONCAT(cat_alias, ',luc-quy-giua'),cat_name = CONCAT(cat_name, ',Sim lục quý giữa')  WHERE 
		// 			(number LIKE '%000000%' OR number LIKE '%111111%' OR number LIKE '%222222%' OR number LIKE '%333333%' OR number LIKE '%444444%' OR number LIKE '%555555%' OR number LIKE '%666666%' OR number LIKE '%777777%' OR number LIKE '%888888%' OR number LIKE '%999999%') AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',55'),cat_alias = CONCAT(cat_alias, ',ngu-quy-giua'),cat_name = CONCAT(cat_name, ',Sim ngũ quý giữa')  WHERE 
		// 			(number LIKE '%00000%' OR number LIKE '%11111%' OR number LIKE '%22222%' OR number LIKE '%33333%' OR number LIKE '%44444%' OR number LIKE '%55555%' OR number LIKE '%66666%' OR number LIKE '%77777%' OR number LIKE '%88888%' OR number LIKE '%99999%') AND number NOT LIKE '%000000%' AND number NOT LIKE '%111111%' AND number NOT LIKE '%222222%' AND number NOT LIKE '%333333%' AND number NOT LIKE '%444444%' AND number NOT LIKE '%555555%' AND number NOT LIKE '%666666%' AND number NOT LIKE '%777777%' AND number NOT LIKE '%888888%' AND number NOT LIKE '%999999%' AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',56'),cat_alias = CONCAT(cat_alias, ',tu-quy-giua'),cat_name = CONCAT(cat_name, ',Sim tứ quý giữa') WHERE 
		// 			(number LIKE '%0000%' OR number LIKE '%1111%' OR number LIKE '%2222%' OR number LIKE '%3333%' OR number LIKE '%4444%' OR number LIKE '%5555%' OR number LIKE '%6666%' OR number LIKE '%7777%' OR number LIKE '%8888%' OR number LIKE '%9999%') AND number NOT LIKE '%000000%' AND number NOT LIKE '%111111%' AND number NOT LIKE '%222222%' AND number NOT LIKE '%333333%' AND number NOT LIKE '%444444%' AND number NOT LIKE '%555555%' AND number NOT LIKE '%666666%' AND number NOT LIKE '%777777%' AND number NOT LIKE '%888888%' AND number NOT LIKE '%999999%' AND number NOT LIKE '%00000%' AND number NOT LIKE '%11111%' AND number NOT LIKE '%22222%' AND number NOT LIKE '%33333%' AND number NOT LIKE '%44444%' AND number NOT LIKE '%55555%' AND number NOT LIKE '%66666%' AND number NOT LIKE '%77777%' AND number NOT LIKE '%88888%' AND number NOT LIKE '%99999%' AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',42,43'),cat_alias = CONCAT(cat_alias, ',ganh-dao,ganh-dao-kep'),cat_name = CONCAT(cat_name, ',Sim gánh đảo,Sim gánh đảo kép')  WHERE 
		// 			RIGHT(number, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 3, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 4, 1) = SUBSTRING(number, 5, 1) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',42,44'),cat_alias = CONCAT(cat_alias, ',ganh-dao,ganh-dao-don'),cat_name = CONCAT(cat_name, ',Sim gánh đảo,Sim gánh đảo đơn')  WHERE 
		// 			RIGHT(number, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 3, 1) != SUBSTRING(number, 6, 1) AND cat_type IS NULL;
				
		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',90,89'),cat_alias = CONCAT(cat_alias, ',sim-tien-kep,tien-kep-abbacc'),cat_name = CONCAT(cat_name, ',Sim tiến kép,Sim tiến kép ABB.ACC')  WHERE 
		// 			RIGHT(number, 1) > SUBSTRING(number, 7, 1) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 5, 1) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',90,103'),cat_alias = CONCAT(cat_alias, ',sim-tien-kep,tien-kep-aacbcc'),cat_name = CONCAT(cat_name, ',Sim tiến kép,Sim tiến kép AAC.BBC')  WHERE 
		// 			RIGHT(number, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 9, 1) > SUBSTRING(number, 6, 1) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',90,104'),cat_alias = CONCAT(cat_alias, ',sim-tien-kep,tien-kep-khac'),cat_name = CONCAT(cat_name, ',Sim tiến kép,Sim tiến kép khác')  WHERE 
		// 			RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 9, 1) > SUBSTRING(number, 6, 1) AND SUBSTRING(number, 8, 1) > SUBSTRING(number, 5, 1) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',45'),cat_alias = CONCAT(cat_alias, ',soi-guong'),cat_name = CONCAT(cat_name, ',Sim soi gương')  WHERE 
		// 			RIGHT(number, 1) = SUBSTRING(number, 5, 1) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1);

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',39,40'),cat_alias = CONCAT(cat_alias, ',so-ganh,so-ganh-aba-cdc'),cat_name = CONCAT(cat_name, ',Sim số gánh,Sim số gánh ABA.CDC')  WHERE 
		// 			RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 9, 1) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',39,95'),cat_alias = CONCAT(cat_alias, ',so-ganh,so-ganh-abaaca'),cat_name = CONCAT(cat_name, ',Sim số gánh,Sim số gánh ABA.ACA')  WHERE 
		// 			RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 5, 1) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 6, 1) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',39,94'),cat_alias = CONCAT(cat_alias, ',so-ganh,so-ganh-acabcb'),cat_name = CONCAT(cat_name, ',Sim số gánh,Sim số gánh ACA.BCB')  WHERE 
		// 			RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 5, 1) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 6, 1) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',39,41'),cat_alias = CONCAT(cat_alias, ',so-ganh,so-ganh-aba'),cat_name = CONCAT(cat_name, ',Sim số gánh,Sim số gánh ABA')  WHERE 
		// 			RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) != SUBSTRING(number, 7, 1) AND SUBSTRING(number, 7, 1) != SUBSTRING(number, 9, 1) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',50,61'),cat_alias = CONCAT(cat_alias, ',tien-ba,tien-ba-aab-aac'),cat_name = CONCAT(cat_name, ',Sim tiến ba,Sim tiến ba AAB.AAC')  WHERE 
		// 			SUBSTRING(number, 8, 2) = SUBSTRING(number, 5, 2) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 10, 1) > SUBSTRING(number, 7, 1) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',50,51'),cat_alias = CONCAT(cat_alias, ',tien-ba,tien-ba-cab-dab'),cat_name = CONCAT(cat_name, ',Sim tiến ba,Sim tiến ba CAB.DAB')  WHERE 
		// 			RIGHT(number, 2) = SUBSTRING(number, 6, 2) AND SUBSTRING(number, 7, 1) != SUBSTRING(number, 6, 1) AND SUBSTRING(number, 8, 1) > SUBSTRING(number, 5, 1) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',50,52'),cat_alias = CONCAT(cat_alias, ',tien-ba,tien-ba-abc-abd'),cat_name = CONCAT(cat_name, ',Sim tiến ba,Sim tiến ba ABC.ABD')  WHERE 
		// 			SUBSTRING(number, 8, 2) = SUBSTRING(number, 5, 2) AND SUBSTRING(number, 5, 1) != SUBSTRING(number, 6, 1) AND SUBSTRING(number, 10, 1) > SUBSTRING(number, 7, 1) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',50,53'),cat_alias = CONCAT(cat_alias, ',tien-ba,tien-ba-acb-adb'),cat_name = CONCAT(cat_name, ',Sim tiến ba,Sim tiến ba ACB.ADB')  WHERE 
		// 			RIGHT(number, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 9, 1) > SUBSTRING(number, 6, 1) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',50,91'),cat_alias = CONCAT(cat_alias, ',tien-ba,tien-ba-accbcc'),cat_name = CONCAT(cat_name, ',Sim tiến ba,Sim tiến ba ACC.BCC')  WHERE 
		// 			RIGHT(number, 2) = SUBSTRING(number, 6, 2) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 8, 1) > SUBSTRING(number, 5, 1) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',46,49'),cat_alias = CONCAT(cat_alias, ',tien-doi,tien-doi-khac'),cat_name = CONCAT(cat_name, ',Sim tiến đôi,Sim tiến đôi khác')  WHERE 
		// 			RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1)  = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 7, 1) > 1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 5, 1) > 1 RIGHT(number, 4) AND != 8386 AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',46,47'),cat_alias = CONCAT(cat_alias, ',tien-doi,tien-doi-3'),cat_name = CONCAT(cat_name, ',Sim tiến đôi,Sim tiến 3 đôi cuối')  WHERE 
		// 			(RIGHT(number, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 6, 1) = 1 AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 5, 1)) OR (SUBSTRING(number, 9, 1) - SUBSTRING(number, 7, 1) = 1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 5, 1) = 1 AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 6, 1)) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',46,48'),cat_alias = CONCAT(cat_alias, ',tien-doi,tien-doi-2'),cat_name = CONCAT(cat_name, ',Sim tiến đôi,Sim tiến 2 đôi cuối')  WHERE 
		// 			(RIGHT(number, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 6, 1) != 1) OR (SUBSTRING(number, 9, 1) - SUBSTRING(number, 7, 1) = 1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 5, 1) != 1 AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 8, 1)) AND cat_type IS NULL;


  //  				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',19,20'),cat_alias = CONCAT(cat_alias, ',dac-biet,nhat-nhat-khong-nhi'),cat_name = CONCAT(cat_name, ',Sim đặc biệt,Nhất nhất không nhì') WHERE 
		// 					RIGHT(number, 4) = 1102 AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',19,21'),cat_alias = CONCAT(cat_alias, ',dac-biet,sinh-tai-loc-phat'),cat_name = CONCAT(cat_name, ',Sim đặc biệt,Sinh tài lộc phát') WHERE 
		// 					RIGHT(number, 4) = 1368 AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',19,22'),cat_alias = CONCAT(cat_alias, ',dac-biet,bon-mua-khong-that-bat'),cat_name = CONCAT(cat_name, ',Sim đặc biệt,Bốn mùa không thất bát') WHERE 
		// 					RIGHT(number, 4) = 4078 AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',19,23'),cat_alias = CONCAT(cat_alias, ',dac-biet,phat-tai-phat-loc'),cat_name = CONCAT(cat_name, ',Sim đặc biệt,Phát tài phát lộc') WHERE 
		// 					RIGHT(number, 4) = 8386 AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',19,24'),cat_alias = CONCAT(cat_alias, ',dac-biet,phat-loc-phat-tai'),cat_name = CONCAT(cat_name, ',Sim đặc biệt,Phát lộc phát tài') WHERE 
		// 					RIGHT(number, 4) = 8683 AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',19,25'),cat_alias = CONCAT(cat_alias, ',dac-biet,cao-hon-nguoi'),cat_name = CONCAT(cat_name, ',Sim đặc biệt,Cao hơn người') WHERE 
		// 					RIGHT(number, 4) = 8910 AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',19,26'),cat_alias = CONCAT(cat_alias, ',dac-biet,moi-nam-moi-loc-moi-phat'),cat_name = CONCAT(cat_name, ',Sim đặc biệt,Mỗi năm mỗi lộc mỗi phát') WHERE 
		// 					RIGHT(number, 6) = 151618 AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',19,27'),cat_alias = CONCAT(cat_alias, ',dac-biet,khong-gap-han'),cat_name = CONCAT(cat_name, ',Sim đặc biệt,Không gặp hạn') WHERE 
		// 					RIGHT(number, 6) = 049053 AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',35'),cat_alias = CONCAT(cat_alias, 'ngay-thang-nam-sinh'),cat_name =  CONCAT(cat_name, ',Năm sinh DD/MM/YY')  WHERE 
		// 			(RIGHT(number, 2) < 20 OR RIGHT(number, 2) > 49) AND SUBSTRING(number, 7, 2) < 13 AND SUBSTRING(number, 5, 2) < 32 AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',36'),cat_alias = CONCAT(cat_alias, ',loc-phat'),cat_name = CONCAT(cat_name, ',Sim lộc phát')  WHERE 
		// 			RIGHT(number, 2) IN (68,86) AND RIGHT(number, 4) != 8386 AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',37'),cat_alias = CONCAT(cat_alias, ',than-tai'),cat_name = CONCAT(cat_name, ',Sim thần tài')  WHERE 
		// 			RIGHT(number, 2) IN (39,79) AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',38'),cat_alias = CONCAT(cat_alias, ',ong-dia'),cat_name = CONCAT(cat_name, ',Sim ông địa')  WHERE 
		// 			RIGHT(number, 2) IN (38,78) AND cat_type IS NULL;


		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',57'),cat_alias = CONCAT(cat_alias, ',tien-giua'),cat_name = CONCAT(cat_name, ',Sim tiến giữa') WHERE 
		// 					((SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) = 1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) = 1) OR (SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) = 1 AND SUBSTRING(number, 6, 1) - SUBSTRING(number, 5, 1) = 1) OR (SUBSTRING(number, 6, 1) - SUBSTRING(number, 5, 1) = 1 AND SUBSTRING(number, 5, 1) - SUBSTRING(number, 4, 1) = 1) OR(SUBSTRING(number, 5, 1) - SUBSTRING(number, 4, 1) = 1 AND SUBSTRING(number, 4, 1) - SUBSTRING(number, 3, 1) = 1)) AND SUBSTRING(number, 5, 1) != SUBSTRING(number, 9, 1) AND cat_id NOT LIKE '%,28,%' AND cat_type IS NULL;

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',59,'),cat_alias = CONCAT(cat_alias, ',de-nho,'),cat_name = CONCAT(cat_name, ',Sim dễ nhớ') WHERE cat_id = '';
				
		// 		UPDATE fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',1,'),cat_alias = CONCAT(cat_alias, ',dau-so-co,'),cat_name = CONCAT(cat_name, ',Sim đầu số cổ') WHERE 
		// 			LEFT(number, 4) IN (0903,0913,0983);

		// 		Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',58'),cat_alias = CONCAT(cat_alias, ',dep-gia-re'),cat_name = CONCAT(cat_name, ',Sim đẹp giá rẻ') WHERE
		// 					price < 500000 AND cat_type IS NULL;

		// 		UPDATE fs_sim_".$item->id." set cat_id = CONCAT(cat_id, ','),cat_alias = CONCAT(cat_alias, ','),cat_name = CONCAT(cat_name, ',') WHERE cat_type IS NULL;
		// 		Update fs_sim_".$item->id." SET cat_type = '1' WHERE cat_type IS NULL;

	 //        ";
	 //    	}

	 //    	}

	 //        // var_dump($sql);die;

	 //        $db->query($sql);
		// 	$row = $db->affected_rows();

		// 	$link = FSRoute::_(URL_ROOT.'admin_sim');
  //           setRedirect($link);

		// }		
	}
	
?>