<?php 
	class CnoModelsPay extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'pay';
			$this -> type = 'pay';
			$this -> arr_img_paths = array(array('resized',220,64,'resize_image'));
			$this -> table_name = FSTable_ad::_('fs_pay');
		
			
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
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			// if(isset($_SESSION[$this -> prefix.'filter0'] ))
			// {
			// 	if($_SESSION[$this -> prefix.'filter0'] )
			// 	{
			// 		$status = $_SESSION[$this -> prefix.'filter0'];
			// 		$where .= " AND a.status = ".$status." ";
			// 	}
			// }

			if(isset($_SESSION[$this -> prefix.'filter0'] ))
			{
				if($_SESSION[$this -> prefix.'filter0'] )
				{
					$status = $_SESSION[$this -> prefix.'filter0'];
					$where .= " AND a.user_id = ".$status." ";
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter1'] ))
			{
				if($_SESSION[$this -> prefix.'filter1'] )
				{
					$status = $_SESSION[$this -> prefix.'filter1'];
					$where .= " AND a.agency = ".$status." ";
				}
			}

			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND (a.id LIKE '%".$keysearch."%' OR a.phone LIKE '%".$keysearch."%' OR a.sim LIKE '%".$keysearch."%' OR a.code LIKE '%".$keysearch."%') ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}

		function save($row = array(),$use_mysql_real_escape_string = 0) {

			$time = date("Y-m-d H:i:s");
			$row ['cno_id'] = FSInput::get ( 'cno_id');
			$row ['cno_sim'] = FSInput::get ( 'cno_sim');

			$recive = FSInput::get ( 'recive');
			$row ['recive'] = $this -> standart_money($recive, 0);

			$row ['status'] = 'Đã thanh toán';
			if ($row ['recive'] > 0) {
				$row ['status'] = 'Đã nhận tiền';
			}

			$agency = FSInput::get ( 'agency');
			$agency = $this->get_record('published = 1 AND id = '.$agency,'fs_users','id,full_name');
			if ($agency) {
				$row ['agency'] = $agency->id;
				$row ['agency_name'] = $agency->full_name;
			}



			$user_id = $_SESSION['ad_userid'];
			$user_id = $this->get_record('published = 1 AND id = '.$user_id,'fs_users','id,full_name');
			if ($user_id) {
				$row ['user_id'] = $user_id->id;
				$row ['user_name'] = $user_id->full_name;
			}

			// var_dump($row);die;


			$id = parent::save ( $row ,1);
			if (! $id) {
				Errors::setError ( 'Not save' );
				return false;
			}

			$query = " UPDATE fs_cno set status = '4',pay_date = '".$time."' WHERE id IN (0".$row ['cno_id']."0)";
			global $db;
			$db->query($query);
			$rs = $db->affected_rows();

			return $id;
		}

		function standart_money($money,$method){
			$money = str_replace(',','' , trim($money));
			$money = str_replace(' ','' , $money);
			$money = str_replace('.','' , $money);
	//		$money = intval($money);
			$money = (double)($money);
			if(!$method)
				return $money;
			if($method == 1){
				$money = $money * 1000;
				return $money; 
			}
			if($method == 2){
				$money = $money * 1000000;
				return $money; 
			}
		}
        
	}
	
?>