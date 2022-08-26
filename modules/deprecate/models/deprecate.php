<?php 
	class DeprecateModelsDeprecate extends FSModels{
			function __construct()
			{
			 $fstable = FSFactory::getClass('fstable');
			 $this -> table_name = $fstable->_('fs_deprecate');
             $this -> table_add = $fstable->_('fs_address');
             $this -> table_parts = $fstable->_('fs_deprecate_parts');
			}

		function save(){
			$deprecate_name = FSInput::get('deprecate_name');
			$deprecate_phone = FSInput::get('deprecate_phone');
			$deprecate_address = FSInput::get('deprecate_address');
			$deprecate_email = FSInput::get('deprecate_email');
			$deprecate_comment = FSInput::get('deprecate_comment');
			$deprecate_six = FSInput::get('deprecate_six');
			$deprecate_price = FSInput::get('deprecate_price');
			$deprecate_price = standart_money($deprecate_price);
            $city_name = FSInput::get('select-city');
            $status = "Mới";
			//$website = FSInput::get('website');
			//$subject = FSInput::get('contact_subject');
			$content = htmlspecialchars_decode(FSInput::get('message'));
			$time = date("Y-m-d H:i:s");
			$published = 0;
			
			$sql = " INSERT INTO 
						". $this -> table_name ." (status,city_name,`fullname`,telephone,address,email,content,six_last,price,created_time,published)
						VALUES ('$status','$city_name','$deprecate_name','$deprecate_phone','$deprecate_address','$deprecate_email','$deprecate_comment','$deprecate_six','$deprecate_price','$time','$published')"; 
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