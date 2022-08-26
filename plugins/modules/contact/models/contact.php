<?php 
	class ContactModelsContact extends FSModels{
			function __construct()
			{
			     $this -> table_name = FSTable::_('fs_contact');
                 $this -> table_add = FSTable::_('fs_address');
			}

		function save(){
			$email = FSInput::get('contact_email');
			$fullname = FSInput::get('contact_name');
			$address = FSInput::get('contact_address');
			$telephone = FSInput::get('contact_phone');
			$title = FSInput::get('contact_title');
			//$website = FSInput::get('website');
			//$subject = FSInput::get('contact_subject');
			$content = htmlspecialchars_decode(FSInput::get('message'));
			$time = date("Y-m-d H:i:s");
			$published = 0;
			
			$sql = " INSERT INTO 
						".$this -> table_name." (`email`,fullname,address,telephone,title,content,edited_time,created_time,published)
						VALUES ('$email','$fullname','$address','$telephone','$title','$content','$time','$time','$published')";
			global $db;
			$db->query($sql);
			$id = $db->insert();
			return $id;
			
		}
		//function get_address_list(){
//			$query = "select * from ".$this -> table_add." WHERE published = 1 ORDER BY ordering ASC, id DESC";
//			global $db;
//			$sql = $db->query($query);
//			$list = $db->getObjectList();
//			foreach($list as $key=>$item){
//				 $query_image = "select image from fs_showroom_images where address_id=".$item->id;
//				 $sql_img = $db->query($query_image);
//				 $item->image = $db->getObjectList();
//			}
//			return $list;
//		}
        
        function get_address_list(){
			$query = "select * from fs_address";
			global $db;
			$sql = $db->query($query);
			$list = $db->getObjectList();
			//foreach($list as $key=>$item){
//				 $query_image = "select image from fs_showroom_images where address_id=".$item->id;
//				 $sql_img = $db->query($query_image);
//				 $item->image = $db->getObjectList();
//			}
			return $list;
		}
        
		function get_address_current(){
			$add_id = FSInput::get('id',0,'int');
			$query = "select * from ".$this -> table_add."  where id=".$add_id;
			global $db;
			$sql = $db->query($query);
			$object = $db->getObject();
			return $object;
		}
        
        
	}
?>