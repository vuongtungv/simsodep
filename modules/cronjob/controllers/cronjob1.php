<?php

	class CronjobControllersCronjob extends FSControllers
	{
		var $module;
		var $view;

		// cập nhật và loại bỏ sim
		function update_remove(){

			$model = $this -> model;
			global $db;
			$users = $model->get_records('published = 1 AND type = 2','fs_users','id');
			$network = $model->get_records('published = 1','fs_network','id,name,header');
			$sql = '';
			foreach ($users as $key) {
				$total = $model->get_count('','fs_sim_'.$key->id.'','id');
				if ($total>0) {

					// chuyển đổi số 84
					$sql .= "Update fs_sim_".$key->id." set sim = INSERT(sim, 1, 2, '0') , number = INSERT(number, 1, 2, '0') WHERE LEFT(number,2) = 84;";
					// xóa các sim không phù hợp
					$sql .= "DELETE FROM fs_sim_".$key->id." WHERE LENGTH(number) > 10 OR LENGTH(number) < 9 OR (LENGTH(number) = 9 AND LEFT(number,1) = 0) OR (LENGTH(number) = 10 AND LEFT(number,1) != 0) OR price < 150000;";
					// // cập nhật hoàn chỉnh số 
					$sql .= "UPDATE fs_sim_".$key->id." SET sim = CONCAT('0',sim) , number = CONCAT('0',number) WHERE LENGTH(number) = 9 AND LEFT(number,1) <> 0 ;";
				}

			}
			// var_dump($sql);die;
			$db->query($sql);
			$row = $db->affected_rows();

			$link = FSRoute::_(URL_ROOT.'admin_sim');
            setRedirect($link);
		}

			// cập nhật nhà mạng (cập nhật bảng tạm trước)
		function update_network(){
			$model = $this -> model;
			global $db;
			$users = $model->get_records('published = 1 AND type = 2','fs_users','id');
			$network = $model->get_records('published = 1','fs_network','id,name,header');
			foreach ($users as $key) {

				$total = $model->get_count('','fs_sim_'.$key->id.'','id');
				if ($total>0) {

					foreach ($network as $item) {
						$sql .= "Update fs_sim_".$key->id." SET network ='".$item->name."',network_id ='".$item->id."'  WHERE 
									LEFT(number, 3) IN (".$item->header.") AND network_id IS NULL ;";
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
			$db->query($sql);
			$row = $db->affected_rows();

			$link = FSRoute::_(URL_ROOT.'admin_sim');
            setRedirect($link);
		}

		// cập nhật giá (cập nhật bảng tạm trước)
		function update_price(){
			$model = $this -> model;
			global $db;

			// cập nhật ID giá vào bảng tạm
			$sql = '';
			$commission = $model->get_records('published = 1 AND type = 2','fs_users','id,price');
			foreach ($commission as $item) {
				$sql .= "Update fs_sim_".$item->id." SET commission ='".$item->price."';";
			}

			$db->query($sql);
			$row = $db->affected_rows();

			$sql = '';
			$price = $model->get_records('','fs_price_commissions','*');
			// var_dump($price);die;
			foreach ($price as $item) {

				foreach ($commission as $key) {
					if ($item->price_id == $key->price) {
						switch ($item->commission_type) {
							case 'up':
								if ($item->commission_unit == 'percent') {
									$price_public =  $item->commission / 100;  
									$sql .= "Update fs_sim_".$key->id." SET price_public = round(price * ".$price_public." + price,-4)  WHERE 
												price >= ".$item->price_f." AND price < ".$item->price_t." AND commission = ".$item->price_id." AND price_public IS NULL; ";
								}else{
									$sql .= "Update fs_sim_".$key->id." SET price_public = round(price + ".$item->commission.",-4) WHERE 
												price >= ".$item->price_f." AND price < ".$item->price_t." AND commission = ".$item->price_id." AND price_public IS NULL; ";
								}
								break;
							case 'down':
								if ($item->commission_unit == 'percent') {
									$price_public =  $item->commission / 100;  
									$sql .= "Update fs_sim_".$key->id." SET price_public = round(price - price * ".$price_public.",-4) WHERE 
												price >= ".$item->price_f." AND price < ".$item->price_t." AND commission = ".$item->price_id." AND price_public IS NULL; ";
								}else{
									$sql .= "Update fs_sim_".$key->id." SET price_public = round(price - ".$item->commission.",-4) WHERE 
												price >= ".$item->price_f." AND price < ".$item->price_t." AND commission = ".$item->price_id." AND price_public IS NULL; ";
								}
								break;
							
							default:
								if ($item->commission_unit == 'percent') {
									$price_public =  $item->commission / 100;
									$sql .= "Update fs_sim_".$key->id." SET commission_value = round(price * ".$price_public.",-4) WHERE 
												price >= ".$item->price_f." AND price < ".$item->price_t." AND commission = ".$item->price_id." AND commission_value IS NULL; ";
								}else{
									$sql .= "Update fs_sim_".$key->id." SET commission_value = round(".$item->commission.",-4) WHERE 
												price >= ".$item->price_f." AND price < ".$item->price_t." AND commission = ".$item->price_id." AND commission_value IS NULL; ";
								}
								break;
						}
					}
				}

			}

			// die;

			$db->query($sql);
			$row = $db->affected_rows();

			$link = FSRoute::_(URL_ROOT.'admin_sim');
            setRedirect($link);
		}

		// cập nhật dữ liệu từ bảng tạm sang bảng chính
		function update_sim()
		{
			$model = $this -> model;
			global $db;
			$users = $model->get_records('published = 1 AND type = 2','fs_users','id,full_name');
			$sql = '';
			foreach ($users as $item) {

				$total = $model->get_count('','fs_sim_'.$item->id.'','id');
				if ($total>0) {
				// xóa sim đại lý ở bảng chính
				$sql= 'DELETE FROM fs_sim WHERE agency = '.$item->id.';';

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
							FROM fs_sim_'.$item->id.' ;';

				// xóa sim đã xử lý ở bảng phụ
				$sql .= 'DELETE FROM fs_sim_'.$item->id.' WHERE cat_type = 1;';
			}
		}

			// var_dump($sql);die;

	        $db->query($sql);
			$row = $db->affected_rows();

			$link = FSRoute::_(URL_ROOT.'admin_sim');
            setRedirect($link);
		}

		// xóa dữ liệu đã xử lý ở bảng tạm
		// function delete_sim()
		// {
		// 	$model = $this -> model;
		// 	global $db;
		// 	$users = $model->get_records('published = 1 AND type = 2','fs_users','id');
		// 	$sql = '';
		// 	foreach ($users as $item) {
		// 		$sql .= 'DELETE FROM fs_sim_'.$item->id.' WHERE cat_type = 1;';
		// 	}

		// 	// var_dump($sql);die;

	 //        $db->query($sql);
		// 	$row = $db->affected_rows();

		// 	$link = FSRoute::_(URL_ROOT.'admin_sim');
  //           setRedirect($link);
		// }

		// cập nhật loại sim (cập nhật vào bảng tạm trước)
		function update_cat()
		{
			// var_dump(1);die;
			// call models
			$model = $this -> model;
			global $db;

			$year = 1949;
			for ($x = 1950; $x <= 2019; $x++) {
				$year .= ",".$x;
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
		       	UPDATE fs_sim_".$item->id." SET cat_id ='', cat_alias ='', cat_name =''  WHERE cat_id IS NULL;

				UPDATE fs_sim_".$item->id."  
					SET     cat_id =  CASE
						WHEN RIGHT(number, 6) IN (000000,111111,222222,333333,444444,555555,666666,777777,888888,999999) THEN ',2,'
						WHEN RIGHT(number, 5) IN (00000,11111,22222,33333,44444,55555,66666,77777,88888,99999) THEN ',3,'

                        WHEN RIGHT(number, 4) = 0000 THEN ',4,63,'
						WHEN RIGHT(number, 4) = 1111 THEN ',4,71,' 
                        WHEN RIGHT(number, 4) = 2222 THEN ',4,70,' 
                        WHEN RIGHT(number, 4) = 3333 THEN ',4,69,'
						WHEN RIGHT(number, 4) = 4444 THEN ',4,68,'
						WHEN RIGHT(number, 4) = 5555 THEN ',4,67,'
						WHEN RIGHT(number, 4) = 6666 THEN ',4,66,'
						WHEN RIGHT(number, 4) = 7777 THEN ',4,65,'
						WHEN RIGHT(number, 4) = 8888 THEN ',4,64,'
						WHEN RIGHT(number, 4) = 9999 THEN ',4,72,'

						WHEN RIGHT(number, 3) IN (000,111,222,333,444,555,666,777,888,999) AND SUBSTRING(number, 5, 3) IN (000,111,222,333,444,555,666,777,888,999) THEN ',5,'
						WHEN RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 7, 2) = SUBSTRING(number, 5, 2) THEN ',7,'

						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 8, 1) THEN ',8,9,'  
 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 9, 1) THEN ',8,10,'  
 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 9, 1) THEN ',8,11,'
 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) THEN ',8,12,' 
                    END;
 
				UPDATE fs_sim_".$item->id."  
					SET     cat_alias =  CASE
						WHEN RIGHT(number, 6) IN (000000,111111,222222,333333,444444,555555,666666,777777,888888,999999) THEN ',luc-quy,'
						WHEN RIGHT(number, 5) IN (00000,11111,22222,33333,44444,55555,66666,77777,88888,99999) THEN ',ngu-quy,'

                        WHEN RIGHT(number, 4) = 0000 THEN ',sim-tu-quy,sim-tu-quy-0000,'
						WHEN RIGHT(number, 4) = 1111 THEN ',sim-tu-quy,sim-tu-quy-1111,' 
                        WHEN RIGHT(number, 4) = 2222 THEN ',sim-tu-quy,sim-tu-quy-2222,' 
                        WHEN RIGHT(number, 4) = 3333 THEN ',sim-tu-quy,sim-tu-quy-3333,'
						WHEN RIGHT(number, 4) = 4444 THEN ',sim-tu-quy,sim-tu-quy-4444,'
						WHEN RIGHT(number, 4) = 5555 THEN ',sim-tu-quy,sim-tu-quy-5555,'
						WHEN RIGHT(number, 4) = 6666 THEN ',sim-tu-quy,sim-tu-quy-6666,'
						WHEN RIGHT(number, 4) = 7777 THEN ',sim-tu-quy,sim-tu-quy-7777,'
						WHEN RIGHT(number, 4) = 8888 THEN ',sim-tu-quy,sim-tu-quy-8888,'
						WHEN RIGHT(number, 4) = 9999 THEN ',sim-tu-quy,sim-tu-quy-9999,'

						WHEN RIGHT(number, 3) IN (000,111,222,333,444,555,666,777,888,999) AND SUBSTRING(number, 5, 3) IN (000,111,222,333,444,555,666,777,888,999) THEN ',tam-hoa-kep,'
						WHEN RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 7, 2) = SUBSTRING(number, 5, 2) THEN ',taxi-2,'
						
						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 8, 1) THEN ',taxi-3,taxi-aba-aba,'  
 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 9, 1) THEN ',taxi-3,taxi-aab-aab,'  
 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 9, 1) THEN ',taxi-3,taxi-baa-baa,'
 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) THEN ',taxi-3,taxi-abc-abc,'

                    END;

				UPDATE fs_sim_".$item->id." 
 					SET     cat_name =  CASE
 						WHEN RIGHT(number, 6) IN (000000,111111,222222,333333,444444,555555,666666,777777,888888,999999) THEN ',Sim lục quý,'
 						WHEN RIGHT(number, 5) IN (00000,11111,22222,33333,44444,55555,66666,77777,88888,99999) THEN ',Sim ngũ quý,'

                        WHEN RIGHT(number, 4) = 0000 THEN ',Sim tứ quý,Sim tứ quý 0000,'
 						WHEN RIGHT(number, 4) = 1111 THEN ',Sim tứ quý,Sim tứ quý 1111,' 
                        WHEN RIGHT(number, 4) = 2222 THEN ',Sim tứ quý,Sim tứ quý 2222,' 
                        WHEN RIGHT(number, 4) = 3333 THEN ',Sim tứ quý,Sim tứ quý 3333,'
						WHEN RIGHT(number, 4) = 4444 THEN ',Sim tứ quý,Sim tứ quý 4444,'
						WHEN RIGHT(number, 4) = 5555 THEN ',Sim tứ quý,Sim tứ quý 5555,'
						WHEN RIGHT(number, 4) = 6666 THEN ',Sim tứ quý,Sim tứ quý 6666,'
						WHEN RIGHT(number, 4) = 7777 THEN ',Sim tứ quý,Sim tứ quý 7777,'
						WHEN RIGHT(number, 4) = 8888 THEN ',Sim tứ quý,Sim tứ quý 8888,'
						WHEN RIGHT(number, 4) = 9999 THEN ',Sim tứ quý,Sim tứ quý 9999,'

 						WHEN RIGHT(number, 3) IN (000,111,222,333,444,555,666,777,888,999) AND SUBSTRING(number, 5, 3) IN (000,111,222,333,444,555,666,777,888,999) THEN ',Sim tam hoa kép,'  
 						WHEN RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 7, 2) = SUBSTRING(number, 5, 2) THEN ',Sim taxi 2,'

 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 8, 1) THEN ',Sim taxi 3,Sim taxi ABA.ABA,'  
 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 9, 1) THEN ',Sim taxi 3,Sim taxi AAB.AAB,'  
 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) = SUBSTRING(number, 9, 1) THEN ',Sim taxi 3,Sim taxi BAA.BAA,'
 						WHEN RIGHT(number, 3) = SUBSTRING(number, 5, 3) AND SUBSTRING(number, 10, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) THEN ',Sim taxi 3,Sim taxi ABC.ABC,'

                    END

				UPDATE fs_sim_".$item->id." SET cat_type = '1' WHERE cat_id IS NOT NULL

				UPDATE fs_sim_".$item->id."  
					SET     cat_id =  CASE
						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',13,83'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',13,87'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',13,86'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND cat_type IS NULL THEN ',13,88'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',13,85'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',13,84' 
                    END;
 
				UPDATE fs_sim_".$item->id."  
					SET     cat_alias =  CASE
						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',taxi-4,sim-taxi-abcdabcd'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',taxi-4,sim-taxi-abbbabbb'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',taxi-4,sim-taxi-aaabaaab'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND cat_type IS NULL THEN ',Sim taxi 4,sim-taxi-abbaabba'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',taxi-4,sim-taxi-aabbaabb'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',taxi-4,sim-taxi-4-khac'
                    END;

				UPDATE fs_sim_".$item->id." 
 					SET     cat_name =  CASE
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',Sim taxi 4,Sim taxi ABCD.ABCD'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',Sim taxi 4,Sim taxi ABBB.ABBB'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',Sim taxi 4,Sim taxi AAAB.AAAB'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND cat_type IS NULL THEN ',Sim taxi 4,Sim taxi ABBA.ABBA'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',Sim taxi 4,Sim taxi AABB.AABB'
 						WHEN RIGHT(number, 4) = SUBSTRING(number, 3, 4) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL THEN ',Sim taxi 4,Sim taxi 4 khác'
                    END

				UPDATE fs_sim_".$item->id."  
					SET     cat_id =  CASE
 						WHEN RIGHT(number, 3) = 000 THEN CONCAT(cat_name, ',6,82')
 						WHEN RIGHT(number, 3) = 111 THEN CONCAT(cat_name, ',6,81')
 						WHEN RIGHT(number, 3) = 222 THEN CONCAT(cat_name, ',6,80')
 						WHEN RIGHT(number, 3) = 333 THEN CONCAT(cat_name, ',6,79')
 						WHEN RIGHT(number, 3) = 444 THEN CONCAT(cat_name, ',6,78')
 						WHEN RIGHT(number, 3) = 555 THEN CONCAT(cat_name, ',6,77')
 						WHEN RIGHT(number, 3) = 666 THEN CONCAT(cat_name, ',6,76')
 						WHEN RIGHT(number, 3) = 777 THEN CONCAT(cat_name, ',6,75')
 						WHEN RIGHT(number, 3) = 888 THEN CONCAT(cat_name, ',6,74')
 						WHEN RIGHT(number, 3) = 999 THEN CONCAT(cat_name, ',6,73')
                    END;
 
				UPDATE fs_sim_".$item->id."  
					SET     cat_alias =  CASE
 						WHEN RIGHT(number, 3) = 000 THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-000')
 						WHEN RIGHT(number, 3) = 111 THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-111')
 						WHEN RIGHT(number, 3) = 222 THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-222')
 						WHEN RIGHT(number, 3) = 333 THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-333')
 						WHEN RIGHT(number, 3) = 444 THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-444')
 						WHEN RIGHT(number, 3) = 555 THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-555')
 						WHEN RIGHT(number, 3) = 666 THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-666')
 						WHEN RIGHT(number, 3) = 777 THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-777')
 						WHEN RIGHT(number, 3) = 888 THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-888')
 						WHEN RIGHT(number, 3) = 999 THEN CONCAT(cat_name, ',sim-tam-hoa,sim-tam-hoa-999')
                    END;

				UPDATE fs_sim_".$item->id." 
 					SET     cat_name =  CASE
 						WHEN RIGHT(number, 3) = 000 THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 000')
 						WHEN RIGHT(number, 3) = 111 THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 111')
 						WHEN RIGHT(number, 3) = 222 THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 222')
 						WHEN RIGHT(number, 3) = 333 THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 333')
 						WHEN RIGHT(number, 3) = 444 THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 444')
 						WHEN RIGHT(number, 3) = 555 THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 555')
 						WHEN RIGHT(number, 3) = 666 THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 666')
 						WHEN RIGHT(number, 3) = 777 THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 777')
 						WHEN RIGHT(number, 3) = 888 THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 888')
 						WHEN RIGHT(number, 3) = 999 THEN CONCAT(cat_name, ',Sim tam hoa,Sim tam hoa 999')
                    END


				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',14,15'),cat_alias = CONCAT(cat_alias, ',so-kep,so-kep-aa-bb-aa'),cat_name = CONCAT(cat_name, ',Sim số kép,Sim số kép AA.BB.AA')
					WHERE RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND RIGHT(number, 1) = SUBSTRING(number, 5, 1) AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',14,16',cat_alias) = CONCAT(cat_alias, ',so-kep,so-kep-aa-bb-cc'),cat_name = CONCAT(cat_name, ',Sim số kép,Sim số kép AA.BB.CC')
					WHERE RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND RIGHT(number, 1) != SUBSTRING(number, 5, 1) AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',14,17'),cat_alias = CONCAT(cat_alias, ',so-kep,so-kep-aa-bb'),cat_name = CONCAT(cat_name, ',Sim số kép,Sim số kép AA.BB')
					WHERE RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) != SUBSTRING(number, 6, 1) AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',14,93',cat_alias) = CONCAT(cat_alias, ',so-kep,so-kep-aaaabb'),cat_name = CONCAT(cat_name, ',Sim số kép,Sim số kép AAAA.BB')
					WHERE RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 6, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 8, 1) AND cat_type IS NULL; 

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',18'),cat_alias = CONCAT(cat_alias, ',so-lap'),cat_name = CONCAT(cat_name, ',Sim số lặp')
					WHERE RIGHT(number, 2) = SUBSTRING(number, 7, 2) AND SUBSTRING(number, 7, 2) != SUBSTRING(number, 5, 2) AND cat_type IS NULL;
				
		       	Update fs_sim_".$item->id." SET cat_id =CONCAT(cat_id, ',28,29'),cat_alias = CONCAT(cat_alias, ',tien-don,tien-don-dac-biet'),cat_name =CONCAT(cat_name, ',Sim tiến đơn,Sim tiến đơn đặc biệt')  WHERE 
					RIGHT(number, 1) - SUBSTRING(number, 9, 1) = 2 AND  SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) = 2 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) = 2 AND cat_type IS NULL;
					
				Update fs_sim_".$item->id." SET cat_id =CONCAT(cat_id, ',28,30'),cat_alias = CONCAT(cat_alias, ',tien-don,tien-don-6'),cat_name = CONCAT(cat_name, ',Sim tiến đơn,Sim tiến đơn 6')  WHERE 
					RIGHT(number, 1) - SUBSTRING(number, 9, 1) = 1 AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) =1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) =1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) =1 AND SUBSTRING(number, 6, 1) - SUBSTRING(number, 5, 1) = 1 AND cat_type IS NULL;
					
				Update fs_sim_".$item->id." SET cat_id =CONCAT(cat_id, ',28,31'),cat_alias = CONCAT(cat_alias, ',tien-don,tien-don-5'),cat_name = CONCAT(cat_name, ',Sim tiến đơn,Sim tiến đơn 5')  WHERE 
					RIGHT(number, 1) - SUBSTRING(number, 9, 1) = 1 AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) = 1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) = 1 AND SUBSTRING(number, 6, 1) - SUBSTRING(number, 5, 1) != 1 AND cat_type IS NULL;
					
				Update fs_sim_".$item->id." SET cat_id =CONCAT(cat_id, ',28,32'),cat_alias = CONCAT(cat_alias, ',tien-don,tien-don-4'),cat_name = CONCAT(cat_name, ',Sim tiến đơn,Sim tiến đơn 4')  WHERE 
					RIGHT(number, 1) - SUBSTRING(number, 9, 1) =1 AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) = 1  AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) != 1 AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id =CONCAT(cat_id, ',28,33'),cat_alias = CONCAT(cat_alias, ',tien-don,tien-don-3'),cat_name = CONCAT(cat_name, ',Sim tiến đơn,Sim tiến đơn 3')  WHERE 
					RIGHT(number, 1) - SUBSTRING(number, 9, 1) = 1 AND SUBSTRING(number, 9, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) != 1 AND cat_type IS NULL;
						
				Update fs_sim_".$item->id." SET cat_id =CONCAT(cat_id, ',28,34'),cat_alias = CONCAT(cat_alias, ',tien-don,tien-don-khac'),cat_name = CONCAT(cat_name, ',Sim tiến đơn,Sim tiến đơn khác')  WHERE 
					RIGHT(number, 1) > SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) > SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) > SUBSTRING(number, 7, 1) AND cat_id NOT LIKE '%,28,%'  AND cat_type IS NULL;
				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',60'),cat_alias = CONCAT(cat_alias,',nam-sinh'),cat_name = CONCAT(cat_name,',Sim năm sinh')  WHERE 
					RIGHT(number, 4) IN (".$year.") AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',54'),cat_alias = CONCAT(cat_alias, ',luc-quy-giua'),cat_name = CONCAT(cat_name, ',Sim lục quý giữa')  WHERE 
					(number LIKE '%000000%' OR number LIKE '%111111%' OR number LIKE '%222222%' OR number LIKE '%333333%' OR number LIKE '%444444%' OR number LIKE '%555555%' OR number LIKE '%666666%' OR number LIKE '%777777%' OR number LIKE '%888888%' OR number LIKE '%999999%') AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',55'),cat_alias = CONCAT(cat_alias, ',ngu-quy-giua'),cat_name = CONCAT(cat_name, ',Sim ngũ quý giữa')  WHERE 
					(number LIKE '%00000%' OR number LIKE '%11111%' OR number LIKE '%22222%' OR number LIKE '%33333%' OR number LIKE '%44444%' OR number LIKE '%55555%' OR number LIKE '%66666%' OR number LIKE '%77777%' OR number LIKE '%88888%' OR number LIKE '%99999%') AND number NOT LIKE '%000000%' AND number NOT LIKE '%111111%' AND number NOT LIKE '%222222%' AND number NOT LIKE '%333333%' AND number NOT LIKE '%444444%' AND number NOT LIKE '%555555%' AND number NOT LIKE '%666666%' AND number NOT LIKE '%777777%' AND number NOT LIKE '%888888%' AND number NOT LIKE '%999999%' AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',56'),cat_alias = CONCAT(cat_alias, ',tu-quy-giua'),cat_name = CONCAT(cat_name, ',Sim tứ quý giữa') WHERE 
					(number LIKE '%0000%' OR number LIKE '%1111%' OR number LIKE '%2222%' OR number LIKE '%3333%' OR number LIKE '%4444%' OR number LIKE '%5555%' OR number LIKE '%6666%' OR number LIKE '%7777%' OR number LIKE '%8888%' OR number LIKE '%9999%') AND number NOT LIKE '%000000%' AND number NOT LIKE '%111111%' AND number NOT LIKE '%222222%' AND number NOT LIKE '%333333%' AND number NOT LIKE '%444444%' AND number NOT LIKE '%555555%' AND number NOT LIKE '%666666%' AND number NOT LIKE '%777777%' AND number NOT LIKE '%888888%' AND number NOT LIKE '%999999%' AND number NOT LIKE '%00000%' AND number NOT LIKE '%11111%' AND number NOT LIKE '%22222%' AND number NOT LIKE '%33333%' AND number NOT LIKE '%44444%' AND number NOT LIKE '%55555%' AND number NOT LIKE '%66666%' AND number NOT LIKE '%77777%' AND number NOT LIKE '%88888%' AND number NOT LIKE '%99999%' AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',42,43'),cat_alias = CONCAT(cat_alias, ',ganh-dao,ganh-dao-abba-cddc'),cat_name = CONCAT(cat_name, ',Sim gánh đảo,Sim gánh đảo ABBA.CDDC')  WHERE 
					RIGHT(number, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 3, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 4, 1) = SUBSTRING(number, 5, 1) AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',42,44'),cat_alias = CONCAT(cat_alias, ',ganh-dao,ganh-dao-abba'),cat_name = CONCAT(cat_name, ',Sim gánh đảo,Sim gánh đảo ABBA')  WHERE 
					RIGHT(number, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 3, 1) != SUBSTRING(number, 6, 1) AND cat_type IS NULL;
				
				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',90,89'),cat_alias = CONCAT(cat_alias, ',sim-tien-kep,tien-kep-abbacc'),cat_name = CONCAT(cat_name, ',Sim tiến kép,Sim tiến kép ABB.ACC')  WHERE 
					RIGHT(number, 1) > SUBSTRING(number, 7, 1) AND RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 5, 1) ANDcat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',90,103'),cat_alias = CONCAT(cat_alias, ',sim-tien-kep,tien-kep-aacbcc'),cat_name = CONCAT(cat_name, ',Sim tiến kép,Sim tiến kép AAC.BBC')  WHERE 
					RIGHT(number, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 9, 1) > SUBSTRING(number, 6, 1) ANDcat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',90,104'),cat_alias = CONCAT(cat_alias, ',sim-tien-kep,tien-kep-khac'),cat_name = CONCAT(cat_name, ',Sim tiến kép,Sim tiến kép khác')  WHERE 
					RIGHT(number, 1) = SUBSTRING(number, 9, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 9, 1) > SUBSTRING(number, 6, 1) AND SUBSTRING(number, 8, 1) > SUBSTRING(number, 5, 1) ANDcat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',45'),cat_alias = CONCAT(cat_alias, ',soi-guong'),cat_name = CONCAT(cat_name, ',Sim soi gương')  WHERE 
					RIGHT(number, 1) = SUBSTRING(number, 5, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 8, 1) AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',50,61'),cat_alias = CONCAT(cat_alias, ',tien-ba,tien-ba-aac-aad'),cat_name = CONCAT(cat_name, ',Sim tiến ba,Sim tiến ba AAC.AAD')  WHERE 
					SUBSTRING(number, 8, 2) = SUBSTRING(number, 5, 2) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 10, 1) > SUBSTRING(number, 7, 1) AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',50,51'),cat_alias = CONCAT(cat_alias, ',tien-ba,tien-ba-cab-dab'),cat_name = CONCAT(cat_name, ',Sim tiến ba,Sim tiến ba CAB.DAB')  WHERE 
					RIGHT(number, 2) = SUBSTRING(number, 6, 2) AND SUBSTRING(number, 8, 1) > SUBSTRING(number, 5, 1) AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',50,52'),cat_alias = CONCAT(cat_alias, ',tien-ba,tien-ba-abc-abd'),cat_name = CONCAT(cat_name, ',Sim tiến ba,Sim tiến ba ABC.ABD')  WHERE 
					SUBSTRING(number, 8, 2) = SUBSTRING(number, 5, 2) AND SUBSTRING(number, 5, 1) != SUBSTRING(number, 6, 1) AND SUBSTRING(number, 10, 1) > SUBSTRING(number, 7, 1) AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',50,53'),cat_alias = CONCAT(cat_alias, ',tien-ba,tien-ba-acb-adb'),cat_name = CONCAT(cat_name, ',Sim tiến ba,Sim tiến ba ACB.ADB')  WHERE 
					RIGHT(number, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 9, 1) > SUBSTRING(number, 6, 1) AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',39,40'),cat_alias = CONCAT(cat_alias, ',so-ganh,so-ganh-aba-cdc'),cat_name = CONCAT(cat_name, ',Sim số gánh,Sim số gánh ABA.CDC')  WHERE 
					RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) = SUBSTRING(number, 7, 1) AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',39,95'),cat_alias = CONCAT(cat_alias, ',so-ganh,so-ganh-abaaca'),cat_name = CONCAT(cat_name, ',Sim số gánh,Sim số gánh ABA.ACA')  WHERE 
					RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 5, 1) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) != SUBSTRING(number, 6, 1) AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',39,94'),cat_alias = CONCAT(cat_alias, ',so-ganh,so-ganh-acabcb'),cat_name = CONCAT(cat_name, ',Sim số gánh,Sim số gánh ACA.BCB')  WHERE 
					RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) != SUBSTRING(number, 7, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 5, 1) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 6, 1) AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',39,41'),cat_alias = CONCAT(cat_alias, ',so-ganh,so-ganh-aba'),cat_name = CONCAT(cat_name, ',Sim số gánh,Sim số gánh ABA')  WHERE 
					RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 5, 1) != SUBSTRING(number, 7, 1) AND RIGHT(number, 1) != SUBSTRING(number, 9, 1) AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',46,47'),cat_alias = CONCAT(cat_alias, ',tien-doi,tien-doi-3'),cat_name = CONCAT(cat_name, ',Sim tiến đôi,Sim tiến 3 đôi cuối')  WHERE 
					RIGHT(number, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 8, 1) - SUBSTRING(number, 6, 1) = 1 AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 5, 1) AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',46,48'),cat_alias = CONCAT(cat_alias, ',tien-doi,tien-doi-2'),cat_name = CONCAT(cat_name, ',Sim tiến đôi,Sim tiến 2 đôi cuối')  WHERE 
					(RIGHT(number, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 7, 1)) OR (RIGHT(number, 1) - SUBSTRING(number, 8, 1) = 1 AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 7, 1)) AND cat_type IS NULL; BA.CA 0616

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',46,49'),cat_alias = CONCAT(cat_alias, ',tien-doi,tien-doi-khac'),cat_name = CONCAT(cat_name, ',Sim tiến đôi,Sim tiến đôi khác')  WHERE 
					((RIGHT(number, 1) = SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1)  = SUBSTRING(number, 6, 1) AND SUBSTRING(number, 9, 1) > SUBSTRING(number, 7, 1) AND SUBSTRING(number, 7, 1) > SUBSTRING(number, 5, 1)) OR (RIGHT(number, 1) > SUBSTRING(number, 8, 1) AND SUBSTRING(number, 8, 1) > SUBSTRING(number, 6, 1) AND SUBSTRING(number, 9, 1) = SUBSTRING(number, 7, 1) AND SUBSTRING(number, 7, 1) = SUBSTRING(number, 5, 1))) AND cat_type IS NULL;

   				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',19,20'),cat_alias = CONCAT(cat_alias, ',dac-biet,nhat-nhat-khong-nhi'),cat_name = CONCAT(cat_name, ',Sim đặc biệt,Nhất nhất không nhì') WHERE 
							RIGHT(number, 4) = 1102 AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',19,21'),cat_alias = CONCAT(cat_alias, ',dac-biet,sinh-tai-loc-phat'),cat_name = CONCAT(cat_name, ',Sim đặc biệt,Sinh tài lộc phát') WHERE 
							RIGHT(number, 4) = 1368 AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',19,22'),cat_alias = CONCAT(cat_alias, ',dac-biet,bon-mua-khong-that-bat'),cat_name = CONCAT(cat_name, ',Sim đặc biệt,Bốn mùa không thất bát') WHERE 
							RIGHT(number, 4) = 4078 AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',19,23'),cat_alias = CONCAT(cat_alias, ',dac-biet,phat-tai-phat-loc'),cat_name = CONCAT(cat_name, ',Sim đặc biệt,Phát tài phát lộc') WHERE 
							RIGHT(number, 4) = 8386 AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',19,24'),cat_alias = CONCAT(cat_alias, ',dac-biet,phat-loc-phat-tai'),cat_name = CONCAT(cat_name, ',Sim đặc biệt,Phát lộc phát tài') WHERE 
							RIGHT(number, 4) = 8683 AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',19,25'),cat_alias = CONCAT(cat_alias, ',dac-biet,cao-hon-nguoi'),cat_name = CONCAT(cat_name, ',Sim đặc biệt,Cao hơn người') WHERE 
							RIGHT(number, 4) = 8910 AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',19,26'),cat_alias = CONCAT(cat_alias, ',dac-biet,moi-nam-moi-loc-moi-phat'),cat_name = CONCAT(cat_name, ',Sim đặc biệt,Mỗi năm mỗi lộc mỗi phát') WHERE 
							RIGHT(number, 6) = 151618 AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',19,27'),cat_alias = CONCAT(cat_alias, ',dac-biet,khong-gap-han'),cat_name = CONCAT(cat_name, ',Sim đặc biệt,Không gặp hạn') WHERE 
							RIGHT(number, 6) = 049053 AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',35'),cat_alias = CONCAT(cat_alias, 'ngay-thang-nam-sinh'),cat_name =  CONCAT(cat_name, ',Sim ngày tháng năm sinh')  WHERE 
					RIGHT(number, 2) < 20 AND RIGHT(number, 2) > 49 AND SUBSTRING(number, 7, 2) < 13 AND SUBSTRING(number, 7, 2) > 0 AND SUBSTRING(number, 5, 2) < 32 AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',36'),cat_alias = CONCAT(cat_alias, ',loc-phat'),cat_name = CONCAT(cat_name, ',Sim lộc phát')  WHERE 
					RIGHT(number, 2) IN (68,86) AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',37'),cat_alias = CONCAT(cat_alias, ',than-tai'),cat_name = CONCAT(cat_name, ',Sim thần tài')  WHERE 
					RIGHT(number, 2) IN (39,79) AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',38'),cat_alias = CONCAT(cat_alias, ',ong-dia'),cat_name = CONCAT(cat_name, ',Sim ông địa')  WHERE 
					RIGHT(number, 2) IN (38,78) AND cat_type IS NULL;


				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',57'),cat_alias = CONCAT(cat_alias, ',tien-giua'),cat_name = CONCAT(cat_name, ',Sim tiến giữa') WHERE 
							((SUBSTRING(number, 8, 1) - SUBSTRING(number, 7, 1) = 1 AND SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) = 1) OR (SUBSTRING(number, 7, 1) - SUBSTRING(number, 6, 1) = 1 AND SUBSTRING(number, 6, 1) - SUBSTRING(number, 5, 1) = 1) OR (SUBSTRING(number, 6, 1) - SUBSTRING(number, 5, 1) = 1 AND SUBSTRING(number, 5, 1) - SUBSTRING(number, 4, 1) = 1) OR(SUBSTRING(number, 5, 1) - SUBSTRING(number, 4, 1) = 1 AND SUBSTRING(number, 4, 1) - SUBSTRING(number, 3, 1) = 1)) AND cat_id NOT LIKE '%,28,%' AND cat_type IS NULL;

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',59,'),cat_alias = CONCAT(cat_alias, ',de-nho,'),cat_name = CONCAT(cat_name, ',Sim dễ nhớ') WHERE cat_id = '';
				
				UPDATE fs_sim_".$item->id." SET cat_id = ',1',cat_alias = ',dau-so-co',cat_name = ',Sim đầu số cổ'  WHERE 
					LEFT(number, 4) IN (0903,0913,0983);

				Update fs_sim_".$item->id." SET cat_id = CONCAT(cat_id, ',58'),cat_alias = CONCAT(cat_alias, ',dep-gia-re'),cat_name = CONCAT(cat_name, ',Sim đẹp giá rẻ') WHERE
							price < 500000 AND cat_type IS NULL;

				UPDATE fs_sim_".$item->id." set cat_id = CONCAT(cat_id, ','),cat_alias = CONCAT(cat_alias, ','),cat_name = CONCAT(cat_name, ',') WHERE cat_type IS NULL;
				Update fs_sim_".$item->id." SET cat_type = '1' WHERE cat_type IS NULL;

	        ";
	    	}

	    	}

	        var_dump($sql);die;

	        $db->query($sql);
			$row = $db->affected_rows();

			$link = FSRoute::_(URL_ROOT.'admin_sim');
            setRedirect($link);

		}		
	}
	
?>