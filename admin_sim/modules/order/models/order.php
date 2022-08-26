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

	class OrderModelsOrder extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 40;
			$this -> view = 'order';
			$this -> table_name = 'fs_order';
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
					$ordering .= " ORDER BY $sort_field $sort_direct, id DESC ";
			}
			
			// from
			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d H:i:s',$date_from);
					$where .= ' AND a.created_time >=  "'.$date_new.'" ';
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
					$where .= ' AND a.created_time <=  "'.$date_new.'" ';
				}
			}
			
			// userid
			if(isset($_SESSION[$this -> prefix.'text2']))
			{
				$userid = $_SESSION[$this -> prefix.'text2'];
				$userid  = intval($userid );
				if($userid){
					$where .= ' AND a.user_id =  '.$userid ;
				}
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY id DESC ";
			
			
//			if(isset($_SESSION[$this -> prefix.'filter0'])){
//				$filter = $_SESSION[$this -> prefix.'filter0'];
//				if($filter){
//					$where .= ' AND b.id =  "'.$filter.'" ';
//				}
//			}
			
//			if(isset($_SESSION[$this -> prefix.'filter1'])){
//				$filter = $_SESSION[$this -> prefix.'filter1'];
//				if($filter){
//					$where .= ' AND a.user_id =  "'.$filter.'" ';
//				}
//			}

			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$filter = (int)$filter;
					$where .= ' AND a.status =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter1 = $_SESSION[$this -> prefix.'filter1'];
				if($filter1){
					$where .= ' AND a.member_level =  "'.$filter1.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'])){
				$filter2 = $_SESSION[$this -> prefix.'filter2'];
				if($filter2){
					$where .= ' AND a.user_id =  "'.$filter2.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					if(strpos($keysearch, 'DH') === 0){
						$keysearch_id = str_replace('DH','', $keysearch);
						$keysearch_id = (int)$keysearch_id;
					}
					$where .= " AND ( a.id LIKE '%".$keysearch."%' OR list_number LIKE  '%".$keysearch."%' OR recipients_mobilephone LIKE  '%".$keysearch."%' 
								OR list_sim LIKE  '%".$keysearch."%' OR recipients_name LIKE  '%".$keysearch."%' OR recipients_email LIKE  '%".$keysearch."%' ";
					if(isset($keysearch_id))
						$where .= "	OR a.id LIKE '%".$keysearch_id."%' ";
						
					$where .= "	)"; 
				}
			}
			
			$query = " SELECT a.*
						  FROM fs_order AS a  
						   WHERE 1 = 1 
						    "
						  .$where .$ordering;			
			return $query;
		}
		function seen($id,$note){
			// lịch sử đơn hàng
			$time = date("Y-m-d H:i:s");
	        $row_history['order_id'] = $id;
	        $row_history['time'] = $time;
	        // $row_history['status'] = 11;
	        $row_history['name_status'] = $note;
	        $row_history['user_id'] = $_SESSION['ad_userid'];
	        $row_history['username'] = $_SESSION['ad_username'];
	        // var_dump($row_history);die;
	        $history_id = $this -> _add($row_history, 'fs_order_history');
		}

		function update_status($id,$status){
			// lịch sử đơn hàng
			$time = date("Y-m-d H:i:s");
	        $row['status'] = $status;
	        $this -> _update($row, 'fs_order','id ='.$id);
		}

		function get_data_order(){
			$id = FSInput::get('id',0,'int');
			global $db;
			$query = "  SELECT *
					FROM fs_order_items 
					WHERE
						order_id = $id
					";
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function get_history_order($id,$phone){
			global $db;
			$query = "  SELECT *
					FROM fs_order
					WHERE
						recipients_mobilephone = $phone AND id != $id AND (status = 2 OR status = 8) ORDER BY created_time DESC
					";
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function get_history(){
			$id = FSInput::get('id',0,'int');
			global $db;
			$query = "  SELECT *
					FROM fs_order_history 
					WHERE
						order_id = $id ORDER BY `time` DESC LIMIT 10
					";
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function get_note(){
			$id = FSInput::get('id',0,'int');
			global $db;
			$query = "  SELECT *
					FROM fs_order_note 
					WHERE
						order_id = $id ORDER BY `time` DESC LIMIT 10
					";
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function getOrderById(){
			$id = FSInput::get('id',0,'int');
			global $db;
			$query = "  SELECT *
					FROM fs_order AS a
					WHERE
						id = $id
					";
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}

		function save_order_cms(){
			$id = FSInput::get('product_order',0,'int');
			$phone = FSInput::get('phone');
			$name = FSInput::get('name');
			$email = FSInput::get('email');
			$address = FSInput::get('address');
			$deposit = FSInput::get('deposit');
			$pay = FSInput::get('pay');
			$note = FSInput::get('note');
			$city = FSInput::get('city');

			$time = date("Y-m-d H:i:s");

			if(!$id)
				return;
			global $db;
            
			$product = $this -> get_record('admin_status = 1 AND id ='.$id,'fs_sim');
			if ($product) {
				$agency = $this->get_record('published = 1 AND type = 2 AND id = '.$product->agency,'fs_users');
				$agency_city = $this->get_record('published = 1 AND id = '.$agency->city,'fs_cities','id,name');
				$city = $this -> get_record('published = 1 AND id ='.$city,'fs_cities','id,name');

				//Lưu thông tin khách hàng
				$row['member_level_name'] = 'Khách vãng lai';
	        	$row['member_level'] = '99';
				$member = $this -> get_record(' telephone ='.$phone,'fs_members','id,position,position_name,discount,code');
				if (@$member) {
					$row['member_level'] = $member->position;
					$row['member_level_name'] = $member->position_name;
					$row['member_id'] = $member->id;
					$row['member_code'] = $member->code;

	            	$discount_name = $member->position_name;
		            $price = $this->get_records('price_id ="'.$member->position.'"','fs_member_commissions','*');
		            // var_dump($price);die;
	            	$total = $product->price_public;
	            	$code = $member->code;
		            if ($price) {
		                foreach ($price as $item) {
		                    if ($total >= $item->price_f && $total< $item->price_t) {
		                        $discount = $item->commission;
		                        $discount_unit = $item->commission_unit;
		                    }
		                }
		            }

				}

				// Lưu thông tin đơn hàng

				$row['discount_code'] = $code;
		        $row['discount_unit'] = $discount_unit;
		        $row['discount_value'] = $discount;
		        $row['discount_name'] = $discount_name;

				$row['list_sim'] = $product->sim;
				$row['list_number'] = str_replace('.','',$product->number);
				$row['recipients_name'] = $name;
				$row['recipients_email'] = $email;
				$row['deposit_method'] = $deposit;
				$row['payment_method'] = $pay;
				$row['recipients_comments'] = $note;
				$row['recipients_mobilephone'] = $phone;
				$row['recipients_address'] = $address;
				$row['products_id'] = $id;
				$row['created_time'] = $time;
				$row['total_before'] = $product->price_public;
				$row['total_after'] = $product->price_public;

				$price_end = $product->price_public;
	            if (@$discount_unit == 'price') {
	                $price_end = $product->price_public - $discount;
	            }
	            if (@$discount_unit == 'percent') {
	                $price_end = $product->price_public - $discount*$product->price_public/100;
	                $price_end = round($price_end);
	            }
				$row['total_end'] = $price_end;

				$row['recipients_city'] = $city->id;
				$row['recipients_city_name'] = $city->name;
				$row['user_id'] = $_SESSION['ad_userid'];
				$row['username'] = $_SESSION['ad_username'];
				$row['status'] = 9;


				// var_dump($row);die;
				$rs = $this -> _add($row, 'fs_order');

				$code_dh = 'DH'.str_pad($rs, 8 , "0", STR_PAD_LEFT);
				$query = " UPDATE fs_order set code = '".$code_dh."' WHERE id = ".$rs;
				$db->query($query);
				$rs2 = $db->affected_rows();

				if(!$rs)
					return false;

				//Lưu dữ liệu từng sim
				$row_item['order_id'] = $rs;

				$row_item['agency_id'] = $agency->id;
				$row_item['agency_name'] = $agency->full_name;
				$row_item['agency_phone'] = $agency->phone;
				$row_item['agency_web'] = $agency->web;
				$row_item['agency_city'] = $agency_city->name;

				$row_item['time_create'] = $product->created_time;
				$row_item['time_order'] = $time;
				$row_item['product_id'] = $product->id;
				$row_item['price'] = $product->price;
				$row_item['sim'] = $product->sim;
				$row_item['number'] = $product->number;

				// Thông tin khuyến mại
	            $row_item['discount'] = @$discount;
	            if (@$discount_unit == 'price') {
	                $row_item['discount'] = $discount;
	            }
	            $row_item['discount_code'] = @$code;
	            $row_item['discount_unit'] = @$discount_unit;
	            $row_item['discount_name'] = @$discount_name;


	            // Giá đại lý
	            $row_item['price'] = $product->price;
	            // chiết khấu vnd
	            $row_item['commission'] = $product->commission_value;
	            // chiết khấu %
	            $row_item['commission_percent'] = $product->commission_value/$product->price*100;
	            // Giá thu về = gía đại lý - chiết khấu
	            $price_recive = $product->price - $product->commission_value;
	            // Giá cuối = giá bán - giảm giá
	            $price_end = $product->price_public;
	            if (@$discount_unit == 'price') {
	                $price_end = $product->price_public - $row_item['discount'];
	            }
	            if (@$discount_unit == 'percent') {
	                $price_end = $product->price_public - $row_item['discount']*$product->price_public/100;
	                $price_end = round($price_end);
	            }
	            // tiền lãi = giá cuối - giá thu về
	            $interest = $price_end - $price_recive;

	            $row_item['price_public'] = $product->price_public;
	            $row_item['price_sell'] = $price_recive;
	            $row_item['price_end'] = $price_end;
	            $row_item['interest'] = $interest;

	            // var_dump($row_item);die;
				$item_id = $this -> _add($row_item, 'fs_order_items');

				$row_history['order_id'] = $rs;
				$row_history['time'] = $time;
				$row_history['status'] = 9;
				$row_history['name_status'] = 'Tạo đơn hàng';
				$row_history['user_id'] = $_SESSION['ad_userid'];
				$row_history['username'] = $_SESSION['ad_username'];
				$history_id = $this -> _add($row_history, 'fs_order_history');

				//cập nhật trạng thái sim
				if ($item_id) {

					$client = ClientBuilder::create()->setHosts($hosts)->build();

					$must = array();

		            $must_item = array('_id'=>$agency->id.'-'.$product->number);
		            $must_arr = array('term'=>$must_item);
		            $must['must'][] = $must_arr;

		            $query_es['bool'] = $must;
		            $body['query'] = $query_es;
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
		            // echo '<pre>',print_r($results,1),'</pre>';die;

		            if ($item_id) {
		                $query = " UPDATE fs_sim set status = '3' WHERE id = ".$id;
		                $db->query($query);
		                $rows = $db->affected_rows();
		            }
				}
	     
				return $item_id;
			}
			return;
		}

		function standart_money($money){
			$money = str_replace(',','' , trim($money));
			$money = str_replace(' ','' , $money);
			$money = str_replace('.','' , $money);
	//		$money = intval($money);
			// $money = (double)($money);
			return $money; 
		}

		function save_status(){
			$id = FSInput::get('id',0,'int');
			$products = FSInput::get('products');
			$deposit = FSInput::get('deposit');
			$pay = FSInput::get('pay');
			$date_appointment = FSInput::get('date_appointment');
			$status = FSInput::get('status',0,'int');
			$time = date("Y-m-d H:i:s");
			if ($date_appointment) {
				$date_appointment = strtotime($date_appointment);
			}
			$orrder = $this->get_record('id = '.$id,'fs_order','*');
			$old_status = $orrder->status;

				// var_dump(@$lever);die;
			global $db;

			// Thay đổi trạng thái đơn hàng
				$sql = 'UPDATE fs_order SET status = '.$status.',deposit_method = "'.$deposit.'",payment_method = "'.$pay.'",date_appointment = "'.$date_appointment.'",edited_time = "'.$time.'"
						WHERE id = '.$id;
				$db->query($sql);
				$rows = $db->affected_rows();

			$array_status = $this -> arr_status;
			$array_obj_status = array();
			foreach($array_status as $key => $name){
				if ($key == $status) {
					$name_status = $name;
				}
			}

			$member = FSInput::get('member','0','int');
			$lever = $this->get_records('published = 1','fs_position');

			$list_id = explode(',', $products);

			// Lưu lịch sử và cập nhật cấp độ thành viên
			if ($rows && $old_status!=$status) {

				$row_history['order_id'] = $id;
				$row_history['time'] = $time;
				$row_history['status'] = $status;
				$row_history['name_status'] = $name_status;
				$row_history['user_id'] = $_SESSION['ad_userid'];
				$row_history['username'] = $_SESSION['ad_username'];
				$history_id = $this -> _add($row_history, 'fs_order_history');

				// các trường hợp khi thay đổi trạng thái đơn hàng
				switch ($status) {
					// giao dịch xong
					case 2:
						
						if ($old_status != 2) {
							// cập nhật trạng thái sim

							$client = ClientBuilder::create()->setHosts($hosts)->build();

							foreach ($list_id as $item ) {
							
								$sim = $this->get_record('id = '.$item,'fs_sim','agency,number');
								$must = array(); $query = array();
								$must_item = array('_id'=>$sim->agency.'-'.$sim->number);
								$must_arr = array('term'=>$must_item);
								$must['must'][] = $must_arr;

								// echo '<pre>',print_r($must),'</pre>';die;

								$query['bool'] = $must;
								$body['query'] = $query;
								$body['script'] = [
									'source' => 'ctx._source.status  = params.value',
									'params' => [
										'value' => 2
									]
								];
								$params = [
									'index' => 'fs',
									'type' => 'simsodep',
									'body' => $body
								];

								$results = $client->updateByQuery($params);

								// var_dump($results);

								$query = " UPDATE fs_sim set status = 2 WHERE id = ".$item;
								$db->query($query);
								$his = $db->affected_rows();

							}


							// Check thành viên
							if (@$member) {
								// tính số lần thanh toán thành công
								$query = " UPDATE fs_members set buy = buy + 1 WHERE id = ".$member;
								$db->query($query);
								$mem = $db->affected_rows();

								$info_mem = $this->get_record('id = '.$member,'fs_members');
								foreach ($lever as $item) {
									$arr = explode('-', $item->quantity);
									if ($info_mem->buy >= @$arr[0] && $info_mem->buy <= @$arr[1]) {
										$mem_type = $item->id;
										$mem_type_name = $item->name;
									}
								}

								$sql = " UPDATE fs_members set position = '".@$mem_type."', position_name = '".@$mem_type_name."' WHERE id = ".$member;
								$db->query($sql);
								$mem = $db->affected_rows();
							}else{
								foreach ($lever as $item) {
									$arr = explode('-', $item->quantity);
									if (1 >= @$arr[0] && 1 <= @$arr[1]) {
										$mem_type = $item->id;
										$mem_type_name = $item->name;
									}
								}

								$row_member['name'] = $orrder->recipients_name;
					            $row_member['username'] = $orrder->recipients_name;
					            $row_member['position'] = $mem_type;
					            $row_member['position_name'] = $mem_type_name;
					            $row_member['email'] = $orrder->recipients_email;
					            $row_member['address'] = $orrder->recipients_address;
					            $row_member['telephone'] = $orrder->recipients_mobilephone;
					            $row_member['city'] = $orrder->recipients_city;
					            $row_member['city_name'] = $orrder->recipients_city_name;
					            $row_member['published'] = 1;
					            $row_member['buy'] = 1; 
					            $row_member['created_time'] = $time; 
					            $row_member['day'] = date('Y-m-d H:i:s',strtotime('+1 year',strtotime($time)));

					            // var_dump($row_member);die;
					            $rs_member = $this -> _add($row_member, 'fs_members');
		                        // $code = 'KH'.str_pad($rs_member, 4 , "0", STR_PAD_LEFT);
		                        $code = rand(100000,999999);
								$code = $this->create_code($code);

					            $query = " UPDATE fs_members set code = '".$code."' WHERE id = ".$rs_member.";";

					            // update thông tin thành viên vào đơn hàng
					            $query .= 'UPDATE fs_order SET member_id = '.$rs_member.',member_code = "'.$code.'",member_level = "'.$mem_type.'",member_level_name = "'.$mem_type_name.'"
								WHERE id = '.$id;

					            $db->query($query);
					            $rs_member2 = $db->affected_rows();


							}

						}

						break;

					// bán rồi đã báo
					case 3:
						
						$client = ClientBuilder::create()->setHosts($hosts)->build();
						foreach ($list_id as $item ) {
							$sim = $this->get_record('id = '.$item,'fs_sim','agency,number,status');
							if (@$sim) {
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

								// var_dump($results);

								$query = " UPDATE fs_sim set status = 3 WHERE id = ".$item;
								$db->query($query);
								$his = $db->affected_rows();

							}


						}

						break;

					// bán rồi chưa báo
					case 4:
						
						$client = ClientBuilder::create()->setHosts($hosts)->build();	
						foreach ($list_id as $item ) {
							$sim = $this->get_record('id = '.$item,'fs_sim','agency,number,status');
							// nếu còn sim cập nhật trạng thái sang bán rồi đã báo
							if (@$sim) {

								// $sql = 'UPDATE fs_order SET status = 3,deposit_method = "'.$deposit.'",payment_method = "'.$pay.'",date_appointment = "'.$date_appointment.'" WHERE id = '.$id;
								// $db->query($sql);
								// $rows = $db->affected_rows();
								$must = array(); $query = array();
								$must_item = array('_id'=>$sim->agency.'-'.$sim->number);
								$must_arr = array('term'=>$must_item);
								$must['must'][] = $must_arr;

								// echo '<pre>',print_r($must),'</pre>';die;

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

								// var_dump($results);

								$query = " UPDATE fs_sim set status = 3 WHERE id = ".$item;
								$db->query($query);
								$his = $db->affected_rows();

							}


						}

						break;

					// vẫn còn đã báo	
					case 6:
						$client = ClientBuilder::create()->setHosts($hosts)->build();
						foreach ($list_id as $item ) {

							$sim = $this->get_record('id = '.$item,'fs_sim','agency,number');
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

							$query = " UPDATE fs_sim set status = 0 WHERE id = ".$item;
							$db->query($query);
							$his = $db->affected_rows();
						}

						break;

					// không gọi được khách hàng
					case 7:
	
						$client = ClientBuilder::create()->setHosts($hosts)->build();
						foreach ($list_id as $item ) {

							$sim = $this->get_record('id = '.$item,'fs_sim','agency,number');
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

							$query = " UPDATE fs_sim set status = 0 WHERE id = ".$item;
							$db->query($query);
							$his = $db->affected_rows();
						}

						break;

					// giao dịch hủy
					case 8:

						$client = ClientBuilder::create()->setHosts($hosts)->build();
						foreach ($list_id as $item ) {

							$sim = $this->get_record('id = '.$item,'fs_sim','agency,number');
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

						if ($status != 2 && $old_status == 2) {
							// Check thành viên
							if (@$member) {
								$query = " UPDATE fs_members set buy = buy - 1 WHERE id = ".$member;
								$db->query($query);
								$mem = $db->affected_rows();
								$info_mem = $this->get_record('id = '.$member,'fs_members');
								foreach ($lever as $item) {
									$arr = explode('-', $item->quantity);
									if ($info_mem->buy >= @$arr[0] && @$info_mem->buy <= $arr[1]) {
										$mem_type = $item->id;
										$mem_type_name = $item->name;
									}
								}

								$sql = " UPDATE fs_members set position = '".@$mem_type."', position_name = '".@$mem_type_name."' WHERE id = ".$member;
								$db->query($sql);
								$mem = $db->affected_rows();
							}
						}

						break;
					
					// khách hàng hẹn, đang kiểm tra, đang giao dịch, mới , bán rồi đã báo ,vẫn còn chưa báo
					default:
						
						$client = ClientBuilder::create()->setHosts($hosts)->build();
						foreach ($list_id as $item ) {
							$sim = $this->get_record('id = '.$item,'fs_sim','agency,number,status');
							if (@$sim) {
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

								// var_dump($sim);

								$query = " UPDATE fs_sim set status = 3 WHERE id = ".$item;
								$db->query($query);
								$his = $db->affected_rows();

							}


						}

						break;
				}

				if(@$his){
					$query = " UPDATE fs_order set cancel_time = '".$time."',cancel_people = '".$_SESSION['ad_userid']."' WHERE id = ".$id;
					$db->query($query);
					$row2 = $db->affected_rows();
				}

			}

			return $rows;
		}

		function create_code($code){
			$kh = $this->get_record('code="'.$code.'"','fs_members');
		    if (!$kh){
			    return $code; 
			}
			$code = rand(100000,999999);
		    return $this->create_code($code);
		}

		function save_comments(){

			$id = FSInput::get('id',0,'int');
			$note = FSInput::get('note');
			$query = " UPDATE fs_order set comments = '".$note."' WHERE id = ".$id;
			global $db;
			$db->query($query);
			$rows = $db->affected_rows();

			return $rows;
		}

		function save_note(){

			$id = FSInput::get('id',0,'int');
			$note = FSInput::get('note');
			$time = date("Y-m-d H:i:s");

			$row_history['order_id'] = $id;
			$row_history['time'] = $time;
			$row_history['note'] = $note;
			$row_history['user_id'] = $_SESSION['ad_userid'];
			$row_history['username'] = $_SESSION['ad_username'];
			// var_dump($row_history);die;
			$rows = $this -> _add($row_history, 'fs_order_note');

			return $rows;
		}

		function save_cno(){

			$id = FSInput::get('id');
			$order = $this->get_record('id='.$id,'fs_order');

			$row['order_id'] = $id;
			$row['customer_name'] = $order->recipients_name;
			$row['customer_address'] = $order->recipients_address;
			$row['customer_phone'] = $order->recipients_mobilephone;
			$row['customer_city'] = $order->recipients_city;
			$row['customer_city_name'] = $order->recipients_city_name;
			$row['customer_email'] = $order->recipients_email;
			$row['order_note'] = $order->recipients_comments;
			$row['order_date'] = $order->created_time;
			$row['status'] = 1;
			$row['count'] = 0;

			$item_id = FSInput::get('item');
			$item = $this->get_record('id='.$item_id,'fs_order_items');

			// var_dump($item);

			$row['order_item_id'] = $item_id;
			$row['sim'] = $item->sim;
			$row['price_sell'] = $item->price_end; //gia cuối
			$row['price_orginal'] = $item->price; //gia dai ly
			$row['commissions'] = $item->commission; // hoa hong
			$row['commission_percent'] = $item->commission_percent; // hoa hong
			$row['number'] = $item->number;
			$row['agency'] = $item->agency_id;
			$row['agency_name'] = $item->agency_name;
			$row['user_id'] = $_SESSION['ad_userid'];
			$row['user_name'] = $_SESSION['ad_username'];

			$partner = $item->price - $item->commission;

			$row['price_partner'] = $partner;
			$row['price_partner_end'] = $partner;

			$row['partner_recive'] = $item->price_end;
			$interest = $item->price_end - $partner;
			$row['price_interest'] = $interest;
			$row['recive'] = $interest;

			$row['created_time'] = date("Y-m-d H:i:s");

			// var_dump($row);die;

			$rs = $this -> _add($row, 'fs_cno');

			if ($rs) {
				$note = 'Chuyển công nợ sim '.$item->sim;
				$this->seen($id,$note);
			}

			return $rs;
		}

		function save_cod(){

			$row['sim'] = FSInput::get('phone');
			$row['price'] = FSInput::get('price');
			$row['price_first'] = 0;
			$row['price_last'] = FSInput::get('price');
			$row['phone'] = FSInput::get('number');
			$row['order_id'] = FSInput::get('order');
			$row['order_item'] = FSInput::get('order_item');
			$row['created_time'] = date("Y-m-d H:i:s");

			$rs = $this -> _add($row, 'fs_cod');

			return $rs;

			if ($rs) {
				$note = 'Chuyển cod sim '.$row['sim'];
				$id = $row['order_id'];
				$this->seen($id,$note);
			}
		}

		function save_info(){

			$id = FSInput::get('id',0,'int');
			$name = FSInput::get('name');
			$city = FSInput::get('city');
			$city_name = $this->get_record('id = '.$city,'fs_cities','name');
			$city_name = $city_name->name;
			$mail = FSInput::get('mail');
			$phone = FSInput::get('phone');
			$comments = FSInput::get('comments');
			$address = FSInput::get('address');

			$rows['recipients_name'] = $name;
			$rows['recipients_city'] = $city;
			$rows['recipients_city_name'] = $city_name;
			$rows['recipients_email'] = $mail;
			$rows['recipients_mobilephone'] = $phone;
			$rows['recipients_comments'] = $comments;
			$rows['recipients_address'] = $address;

			// var_dump($rows);die;
			$rs = $this -> _update($rows, 'fs_order', 'id = '.$id );

			return $rs;
		}

		function cancel_order(){
			$cancel_people = $_SESSION['ad_username'];
			$id = FSInput::get('id',0,'int');
			$time = date("Y-m-d H:i:s");
			if(!$id)
				return;
			global $db;
            
			// get order_id to return
			$query = " SELECT * 
						FROM fs_order
						WHERE   
							id = $id 
							AND is_temporary = 1
					";
            	
			$db -> query($query);
			$order = $db -> getObject();
			
            
			$order_id = $order -> id;
            
            //print_r($order_id);die; 
            
			if(!$order_id)
				return false;
               
            
			if($order ->  status)
				return false;
				
				$row['status'] = 2;
				$row['edited_time'] = $time;
				$row['cancel_people'] = $cancel_people;
				$row['cancel_time'] = $time;
				$row['cancel_is_penalty'] = 1;
				$row['cancel_is_compensation'] = 1;
				$row['status_before_cancel'] = 0;
				$row['is_dispute'] = 0;
				$rs = $this -> _update($row, 'fs_order', ' id = '.$order -> id);
                
                
				return $rs;
			return;	
		}
		
		function finished_order(){
			$cancel_people = $_SESSION['ad_username'];
			$id = FSInput::get('id',0,'int');
			$time = date("Y-m-d H:i:s");
			if(!$id)
				return;
				
			global $db;
			// get order_id to return
			$query = " SELECT * 
						FROM fs_order
						WHERE   
							id = $id 
							AND is_temporary = 1
					";	
			$db -> query($query);
			$order = $db -> getObject();
			$order_id = $order -> id;
			if(!$order_id)
				return false;
			if($order ->  status >= 1)
				return false;
			if(!$order ->  status){	
				$row['status'] = 1;
				$row['edited_time'] = $time;
				$row['status_before_cancel'] = 0;
				$rs = $this -> _update($row, 'fs_order', ' id = '.$order -> id);
				if(!$rs)
					return false;
					
				// cộng tiền thanh toán vào bảng thành viên	
				$this -> add_money_to_member($order -> total_after_discount,$order -> user_id);				
				$this -> add_buy_number_to_product($order -> id);
				$this -> change_status_oder($order -> id);
				// send email after payment successful
				$this -> mail_to_buyer_after_successful($order -> id);
				return $rs;
			} 
			return;	
		}
		
		function mail_to_buyer_after_successful($id){
			if(!$id)
				return;
			global $db;
			
	         
			// get order
			$query = " SELECT * 
						FROM fs_order
						WHERE  id = '$id' 
							AND is_temporary = 1 
					";	
			$db -> query($query);
			$order = $db->getObject();
//			$estore = $this -> getEstore($order -> estore_id);
			$data = $this -> get_orderdetail_by_orderId($id);
			if(count($data)){
				$i = 0;
				$str_prd_ids = '';
				foreach($data as $item){
					if($i > 0)
						$str_prd_ids .= ',';
					$str_prd_ids .= $item -> product_id;
					$i ++;
				}
				$arr_product = $this -> get_products_from_orderdetail($str_prd_ids);
				
			}
				
			if(!$order)
				return;
			
				// send Mail()
				$mailer = FSFactory::getClass('Email','mail');
				
				$select = 'SELECT * FROM fs_config WHERE published = 1';
				global $db;
				$db -> query($select);
				$config = $db->getObjectListByKey('name');
				$admin_name  = $config['admin_name']-> value;
				$admin_email  = $config['admin_email']-> value;
				$mail_order_body  = $config['mail_order_successful_body']-> value;
				$mail_order_subject  = $config['mail_order_successful_subject']-> value;
				
//				$admin_name = $global -> getConfig('admin_name');
//				$admin_email = $global -> getConfig('admin_email');
//				$mail_order_body = $global -> getConfig('mail_order_successful_body');
//				$mail_order_subject = $global -> getConfig('mail_order_successful_subject');
//				echo $mail_order_body;
//				die;
				$mailer -> isHTML(true);
				$mailer -> setSender(array($admin_email,$admin_name));
				$mailer -> AddBCC('phamhuy@finalstyle.com','pham van huy');
				$mailer -> AddAddress($order->recipients_email,$order->recipients_name);
				$mailer -> setSubject($mail_order_subject); 
				
				// body
				$body = $mail_order_body;
				$body = str_replace('{name}', $order-> sender_name, $body);
				$body = str_replace('{ma_don_hang}', 'DH'.str_pad($order -> id, 8 , "0", STR_PAD_LEFT), $body);
				
				// SENDER
				$sender_info = '<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">';
				$sender_info .= '	<tbody>'; 
			  	$sender_info .= ' <tr>';
				$sender_info .= '<td width="173px">Tên người đặt hàng </td>';
				$sender_info .= '<td width="5px">:</td>';
				$sender_info .= '<td>'.$order-> sender_name.'</td>';
			  	$sender_info .= '</tr>';
			  	$sender_info .= '<tr>';
				$sender_info .= '<td>Giới tính</td>';
				$sender_info .= '<td width="5px">:</td>';
				$sender_info .= '<td>';
				if(trim($order->sender_sex) == 'female')
					$sender_info .= "N&#7919;";
				else 
					$sender_info .= "Nam";
				$sender_info .= '</td>';
				$sender_info .= '</tr>';
				$sender_info .= '<tr>';
				$sender_info .= '<td>Địa chỉ  </td>';
				$sender_info .= '<td width="5px">:</td>';
				$sender_info .= '<td>'.$order-> sender_address.'</td>';
			  	$sender_info .= '</tr>';
			  	$sender_info .= '<tr>';
				$sender_info .= '<td>Email </td>';
				$sender_info .= '<td width="5px">:</td>';
				$sender_info .= '<td>'.$order-> sender_email.'</td>';
			  	$sender_info .= '</tr>';
			 	$sender_info .= '<tr>';
				$sender_info .= '<td>Điện thoại </td>';
				$sender_info .= '<td width="5px">:</td>';
				$sender_info .= '<td>'. $order-> sender_telephone .'</td>';
			  	$sender_info .= '</tr>';
				$sender_info .= ' </tbody>';
				$sender_info .= '</table>';
//				$sender_info .= 			'</td>';
				// end SENDER
				
				// RECIPIENT
				$recipient_info = '<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">';
				$recipient_info .= '	<tbody> ';
			  	$recipient_info .= '<tr>';
				$recipient_info .= '<td width="173px">Tên người nhận hàng</td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>'.$order-> recipients_name.'</td>';
			 	$recipient_info .= '</tr>';
			  	$recipient_info .= '<tr>';
				$recipient_info .= '<td>Giới tính </td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>';
				if(trim($order->recipients_sex) == 'female')
					$recipient_info .= "N&#7919;";
				else 
					$recipient_info .= "Nam";
				$recipient_info .= 	'</td>';
			 	$recipient_info .= ' </tr>';
			 	$recipient_info .= ' <tr>';
				$recipient_info .= '<td>Địa chỉ  </td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>'.$order-> recipients_address .'</td>';
			 	$recipient_info .= '</tr>';
				$recipient_info .= ' <tr>';
				$recipient_info .= '<td>Email </td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>'.$order-> recipients_email .'</td>';
				$recipient_info .= '</tr>';
			  	$recipient_info .= '<tr>';
				$recipient_info .= '<td>Điện thoại </td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>'.$order-> recipients_telephone .'</td>';
			  	$recipient_info .= '</tr>';
			  	$recipient_info .= '<tr>';
			  	
				$recipient_info .= '<td>Thời gian đặt hàng</td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>';
					$hour = date('H',strtotime($order-> received_time));
					if($hour)
						$recipient_info .= $hour." h, ";
					$recipient_info .=  "ng&#224;y ". date('d/m/Y',strtotime($order-> received_time));
				$recipient_info .= '</td>';
			  	$recipient_info .= '</tr>';
			  	
			  	$recipient_info .= '<td>Địa điểm nhân hàng </b></td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>';
				$recipient_info .=  $order->recipients_here ? 'Đặt lấy tại nhà hàng':'Nhận tại địa chỉ người nhận';
				$recipient_info .= '</td>';
			  	$recipient_info .= '</tr>';
			  	
			 	$recipient_info .= '</tbody>';
				$recipient_info .= '</table>';
				// end RECIPIENT
				
				
//				$body .= '<br/>';
//				$body .= '<div style="background: none repeat scroll 0 0 #55AEE7;color: #FFFFFF;font-weight: bold;height: 27px;padding-left: 10px;line-height: 25px; margin: 2px;">Chi tiết đơn hàng</div>';
//				$body .= '<div style="padding: 10px">';
				// detail
				$order_detail = '	<table width="964" cellspacing="0" cellpadding="6" bordercolor="\#CCC" border="1" align="center" style="border-style:solid;border-collapse:collapse;margin-top:2px">';
				$order_detail .= '		<thead style=" background: #E7E7E7;line-height: 12px;">';
				$order_detail .= '			<tr>';
				$order_detail .= '				<th width="30">STT</th>';
				$order_detail .= '				<th>T&#234;n s&#7843;n ph&#7849;m</th>';
				$order_detail .= '				<th width="117" >Giá</th>';
				$order_detail .= '				<th width="117">S&#7889; l&#432;&#7907;ng</th>';
				$order_detail .= '				<th width="117">T&#7893;ng gi&#225; ti&#7873;n</th>';
				$order_detail .= '			</tr>';
				$order_detail .= '		</thead>';
				$order_detail .= '		<tbody>';
				
//				$total_money = 0;
				$total_discount = 0;
				for($i = 0 ; $i < count($data); $i ++ ){
					$item = $data[$i];
//					$link_view_product = FSRoute::_('index?module=products&view=product&ename='.@$estore->estore_url.'&id='.$item->product_id.'&code='.@$arr_product[$item->product_id] -> alias.'&Itemid=6');
					$link_view_product = FSRoute::_('index.php?module=products&view=product&pcode='.@$arr_product[$item->product_id] -> alias.'&id='.$item->product_id.'&ccode='.@$arr_product[$item->product_id] ->category_alias.'&Itemid=5');
//					$total_money += $item -> total;
//					$total_discount += $item -> discount * $item -> count;

					$order_detail .= '				<tr>';
					$order_detail .= '					<td align="center">';
					$order_detail .= '						<strong>'.($i+1).'</strong><br/>';
					$order_detail .= '					</td>';
					$order_detail .= '					<td> ';
					$order_detail .= '						<a href="'.$link_view_product.'">';
					$order_detail .= 							@$arr_product[$item -> product_id] -> name;
					$order_detail .= '						</a> ';
					$order_detail .= '					</td>';
										
										//		PRICE 	
					$order_detail .= '					<td> ';
					$order_detail .= '						<strong>';
					$order_detail .= 							format_money($item -> price);
					$order_detail .= '						</strong> VND';
					$order_detail .= '					</td>';
					$order_detail .= '					<td> ';
					$order_detail .= '						<strong>';
					$order_detail .= 							$item -> count?$item -> count:0;
					$order_detail .= '						</strong>';
					$order_detail .= '					</td>';
					$order_detail .= '					<td> ';
					$order_detail .= '						<span >';
					$order_detail .= 							format_money($item -> total);
					$order_detail .= '						</span> VND';
					$order_detail .= '					</td>';
					$order_detail .= '				</tr>';
				}
				$order_detail .= '				<tr>';
				$order_detail .= '					<td colspan="4"  align="right"><strong>Tổng:</strong></td>';
				$order_detail .= '					<td ><strong >'.format_money($order -> total_before_discount).'</strong> VND</td>';
				$order_detail .= '				</tr>';
				if($order -> payment_method){
					$order_detail .= '				<tr>';
					$order_detail .= '					<td colspan="4"  align="right"><strong>Giảm giá (khi mua qua address):</strong></td>';
					$order_detail .= '					<td ><strong >'.format_money($order -> total_before_discount - $order -> total_after_discount).'</strong> VND</td>';
					$order_detail .= '				</tr>';
					$order_detail .= '				<tr>';
					$order_detail .= '					<td colspan="4"  align="right"><strong>Thành tiền:</strong></td>';
					$order_detail .= '					<td ><strong >'.format_money($order -> total_after_discount).'</strong> VND</td>';
					$order_detail .= '				</tr>';
				}
				$order_detail .= '		</tbody>';
				$order_detail .= '	</table>	';
				
//				$body .= '	<br/><br/>	';
//				$body .= '<div style="padding: 10px;font-weight: bold;margin-bottom: 30px;">';
//				$body .= '<div>Ch&acirc;n th&agrave;nh c&#7843;m &#417;n!</div>';
//				$body .=  '<div> '.$site_name.' (<a href="'.URL_ROOT.'" target="_blank">'.URL_ROOT.'</a>)</div>';
//				$body .= '	</div>	';
//				$body .= '</div>';
				$body = str_replace('{thong_tin_nguoi_dat}', $sender_info, $body);
				$body = str_replace('{thong_tin_nguoi_nhan}', $recipient_info, $body);
				$body = str_replace('{thong_tin_don_hang}', $order_detail, $body);
				
				$mailer -> setBody($body);
				if(!$mailer ->Send())
					return false;
				return true;
		}
		
		
		
		/*
		 * Add điểm vào bảng thành viên
		 */
		function add_money_to_member($money,$user_id){
			if(!$money || !$user_id)
				return;
			$sql = 'UPDATE fs_members SET money = money + '.$money.'
						WHERE id = '.$user_id	;
			global $db;
			$db->query($sql);
			$rows = $db->affected_rows();
			return $rows;
		}
		
		/*
		 * Thêm số lần mua vào bảng sản phẩm
		 */
		function add_buy_number_to_product($oder_id){
			$order_items = $this -> get_records('order_id = '.$oder_id,'fs_order_items','*');
			if(!count($order_items))
				return;
			global $db;
			foreach($order_items as $item){
				$sql = 'UPDATE fs_sim SET sale_count = sale_count + '.$item -> count.'
						WHERE id = '.$item ->product_id	;
				$db->query($sql);
				$rows = $db->affected_rows();
			} 
		}
		function change_status_oder($oder_id){
			global $db;
				$sql = 'UPDATE fs_order_items SET status = 1
						WHERE order_id = '.$oder_id	;
				$db->query($sql);
				$rows = $db->affected_rows();
		}
		/*
		 * Repay the money after cancel order for guest
		 */
		function repay($money,$guest_username,$str_penaty = ''){
			// SAVE FS_MEMBERS
			// add money 
			global $db;
			if(!$guest_username)
				return false;
			$sql = "UPDATE fs_members SET `money` = money + ".$money." WHERE username = '".$guest_username."' ";
			$db->query($sql);
			$rows = $db->affected_rows();
			if(!$rows)
				return false;
				
			// SAVE HISTORY	
			$time = date("Y-m-d H:i:s");
			$row3['money'] = $money;
			$row3['type'] = 'deposit';
			$row3['username'] = $guest_username;
			$row3['created_time'] = $time;
			$row3['description'] = $str_penaty;
			$row3['service_name'] = 'Trả lại tiền';
			if(!$this -> _add($row3, 'fs_history'))
				return false;
		}
		
		
		function pay_penalty(){
			$cancel_people = $_SESSION['ad_username'];
			$id = FSInput::get('id',0,'int');
			$time = date("Y-m-d H:i:s");
			if(!$id)
				return;
				
			$row['edited_time'] = $time;
			$row['cancel_is_penalty'] = 1;
			$rs = $this -> _update($row, 'fs_order', ' id = '.$id. ' AND status = 6 ');
			return $rs;
		}
		function pay_compensation(){
			$cancel_people = $_SESSION['ad_username'];
			$id = FSInput::get('id',0,'int');
			$time = date("Y-m-d H:i:s");
			if(!$id)
				return;
				
			$row['edited_time'] = $time;
			$row['cancel_is_compensation'] = 1;
			$rs = $this -> _update($row, 'fs_order', ' id = '.$id. ' AND status = 6 ');
			return $rs;
		}
		function get_orderdetail_by_orderId($order_id){
			if(!$order_id)
				return;
			$session_id = session_id();	
			$query = " SELECT a.*
						FROM fs_order_items AS a
						WHERE  a.order_id = $order_id ";
			global $db;
			$db -> query($query);
			return $rs = $db->getObjectList();
		}
		
		function get_products_from_orderdetail($str_product_ids){
			if(!$str_product_ids)
				return false;
			$query = " SELECT a.*
						FROM fs_sim AS a
						WHERE id IN ($str_product_ids) ";
			global $db;
			$db -> query($query);
			$products = $db->getObjectListByKey('id');
			return $products;
		}
		
					function get_member_info($start = 0,$end = 0){
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
			$sql = $db->query_limit_export($query,$start,$end);
			$result = $db->getObjectList();
			if(	isset($_POST['filter'])){
				$_SESSION[$this -> prefix.'filter']  =  $_POST['filter'] ;
			}
		
			return $result;
		}
	}
?>
