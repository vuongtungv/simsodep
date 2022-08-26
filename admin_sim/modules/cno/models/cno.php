<?php 
	class CnoModelsCno extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'cno';
			$this -> type = 'cno';
			$this -> arr_img_paths = array(array('resized',220,64,'resize_image'));
			$this -> table_name = FSTable_ad::_('fs_cno');
		
			
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
			
			if(isset($_SESSION[$this -> prefix.'filter0'] ))
			{
				if($_SESSION[$this -> prefix.'filter0'] )
				{
					$status = $_SESSION[$this -> prefix.'filter0'];
					$where .= " AND a.status = ".$status." ";
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter1'] ))
			{
				if($_SESSION[$this -> prefix.'filter1'] )
				{
					$status = $_SESSION[$this -> prefix.'filter1'];
					$where .= " AND a.user_id = ".$status." ";
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'] ))
			{
				if($_SESSION[$this -> prefix.'filter2'] )
				{
					$status = $_SESSION[$this -> prefix.'filter2'];
					$where .= " AND a.agency = ".$status." ";
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter3'] ))
			{
				if($_SESSION[$this -> prefix.'filter3'] )
				{
					$status = $_SESSION[$this -> prefix.'filter3'];
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

			$price_sell = FSInput::get ( 'price_sell');
			$row ['price_sell'] = $this -> standart_money($price_sell, 0);

			$price_orginal = FSInput::get ( 'price_orginal');
			$row ['price_orginal'] = $this -> standart_money($price_orginal, 0);

			$commissions = FSInput::get ( 'commissions');
			$row ['commissions'] = $this -> standart_money($commissions, 0);

			$price_partner = FSInput::get ( 'price_partner');
			$row ['price_partner'] = $this -> standart_money($price_partner, 0);

			$price_partner_end = FSInput::get ( 'price_partner_end');
			$row ['price_partner_end'] = $this -> standart_money($price_partner_end, 0);

			$price_interest = FSInput::get ( 'price_interest');
			$row ['price_interest'] = $this -> standart_money($price_interest, 0);

			$price_revice = FSInput::get ( 'price_revice');
			$row ['price_revice'] = $this -> standart_money($price_revice, 0);

			$partner_recive = FSInput::get ( 'partner_recive');
			$row ['partner_recive'] = $this -> standart_money($partner_recive, 0);

			$price_support = FSInput::get ( 'price_support');
			$row ['price_support'] = $this -> standart_money($price_support, 0);

			$recive = FSInput::get ( 'recive');
			$row ['recive'] = $this -> standart_money($recive, 0);

			$agency = FSInput::get ( 'agency');
			$agency = $this->get_record('published = 1 AND id = '.$agency,'fs_users','id,full_name,phone');
			if ($agency) {
				$row ['agency'] = $agency->id;
				$row ['agency_name'] = $agency->full_name;
				$row ['agency_phone'] = $agency->phone;
			}

			$user_id = FSInput::get ( 'user_id');
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

			return $id;
		}

	    function get_data_cno($id,$detail = 0) {
	    	// var_dump($detail);die;
	        global $db;
			$ordering = "";
			$where = "1=1";
			if ($id) {
				$where = "agency = ".$id;
			}

			if ($detail == 0) {
				if(isset($_SESSION[$this -> prefix.'sort_field']))
				{
					$sort_field = $_SESSION[$this -> prefix.'sort_field'];
					$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
					$sort_direct = $sort_direct?$sort_direct:'asc';
					$ordering = '';
					if($sort_field)
						$ordering .= " ORDER BY $sort_field $sort_direct, a.created_time DESC, a.id DESC ";
				}
				
				if(!$ordering)
					$ordering .= " ORDER BY a.created_time DESC , a.id DESC ";
			}else{
				$ordering .= " ORDER BY a.agency ASC ";
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
			
			
			if(isset($_SESSION[$this -> prefix.'filter0'] ))
			{
				if($_SESSION[$this -> prefix.'filter0'] )
				{
					$status = $_SESSION[$this -> prefix.'filter0'];
					$where .= " AND a.status = ".$status." ";
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter1'] ))
			{
				if($_SESSION[$this -> prefix.'filter1'] )
				{
					$status = $_SESSION[$this -> prefix.'filter1'];
					$where .= " AND a.user_id = ".$status." ";
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'] ))
			{
				if($_SESSION[$this -> prefix.'filter2'] )
				{
					$status = $_SESSION[$this -> prefix.'filter2'];
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

	        $query = " SELECT *
					FROM fs_cno as a
	                WHERE $where $ordering";
	        global $db;
	        $sql = $db->query($query);
	        $result = $db->getObjectList();
	        return $result;
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