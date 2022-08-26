<?php 
	class ContactModelsContact extends FSModels{
			function __construct()
			{
			 $fstable = FSFactory::getClass('fstable');
			 $this -> table_name = $fstable->_('fs_contact');
             $this -> table_add = $fstable->_('fs_address');
             $this -> table_parts = $fstable->_('fs_contact_parts');
			}

		function save(){
			$email = FSInput::get('contact_email');
			$fullname = FSInput::get('contact_name');
			$address = FSInput::get('contact_address');
			$type_id = FSInput::get('contact_group');
			$title = FSInput::get('contact_title');
			$parts = FSInput::get('contact_parts');
			//$website = FSInput::get('website');
			//$subject = FSInput::get('contact_subject');
			$content = htmlspecialchars_decode(FSInput::get('message'));
			$time = date("Y-m-d H:i:s");
			$published = 0;
			
			$sql = " INSERT INTO 
						". $this -> table_name ." (`email`,fullname,address,type_id,title,parts_email,content,edited_time,created_time,published)
						VALUES ('$email','$fullname','$address','$type_id','$title','$parts','$content','$time','$time','$published')";
			global $db;
			$db->query($sql);
			$id = $db->insert();
			return $id;
			
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
        
        
	}
?>