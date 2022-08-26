<?php 
	class SignedsimModelsSignedsim extends FSModels{
			function __construct()
			{
			 $fstable = FSFactory::getClass('fstable');
			 $this -> table_name = $fstable->_('fs_signedsim');
             $this -> table_add = $fstable->_('fs_address');
             $this -> table_parts = $fstable->_('fs_contact_parts');
			}

		function save(){
            $signed_name = FSInput::get('signed_name');
            $signed_phone = FSInput::get('signed_phone');
            $signed_address = FSInput::get('signed_address');
            $signed_email = FSInput::get('signed_email');
            $signed_comment = FSInput::get('signed_comment');
            $number_sim = FSInput::get('number_sim');
            $price_sell = FSInput::get('price_sell');
            $price_sell = standart_money($price_sell);
            $percent_brokers = FSInput::get('percent_brokers');
            $city_name = FSInput::get('select-city');
            $status = "Mới";
			//$website = FSInput::get('website');
			//$subject = FSInput::get('contact_subject');
			$content = htmlspecialchars_decode(FSInput::get('message'));
			$time = date("Y-m-d H:i:s");
			$published = 0;
  
			$sql = " INSERT INTO 
						". $this -> table_name ." (status,fullname,telephone,address,email,content,deposit_sim,price,percent_brokers,city_name,created_time,published)
						VALUES ('$status','$signed_name','$signed_phone','$signed_address','$signed_email','$signed_comment','$number_sim','$price_sell','$percent_brokers','$city_name','$time','$published')";
			global $db;
			$db->query($sql);
			$id = $db->insert();
			return $id;
			
		}

		function standart_money($money){
			$money = str_replace(',','' , trim($money));
			$money = str_replace(' ','' , $money);
			$money = str_replace('.','' , $money);
	//		$money = intval($money);
			// $money = (double)($money);
			return $money; 
		}

		function get_parts_list(){
			$query = ' select * from '. $this -> table_parts.' where published = 1 ';
			global $db;
			$sql = $db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
        
        function get_address_list(){
			$query = ' select * from '. $this -> table_add.' where published = 1 AND show_home = 0 ';
			global $db;
			$sql = $db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
        
		function get_address_current(){
			$add_id = FSInput::get('id',0,'int');
			$query = "select * from ".$this -> table_add."  where id=". $add_id;
			global $db;
			$sql = $db->query($query);
			$object = $db->getObject();
			return $object;
		}
        function getCity(){
            global $db;
            $query = "SELECT id,name FROM fs_cities ORDER By ordering ASC";
            $sql = $db->query($query);
            $rel = $db->getObjectList();
            return $rel;
        }
        
	}
?>