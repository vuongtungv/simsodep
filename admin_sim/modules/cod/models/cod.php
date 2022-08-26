<?php 
	class CodModelsCod extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'cod';
			$this -> type = 'cod';
			$this -> arr_img_paths = array(array('resized',220,64,'resize_image'));
			$this -> table_name = FSTable_ad::_('fs_cod');
		
			
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
			
			
			if(isset($_SESSION[$this -> prefix.'filter0'] ))
			{
				if($_SESSION[$this -> prefix.'filter0'] )
				{
					$status = $_SESSION[$this -> prefix.'filter0'];
					$where .= " AND a.status = ".$status." ";
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

			$price = FSInput::get ( 'price');
			$row ['price'] = $this -> standart_money($price, 0);

			$price_first = FSInput::get ( 'price_first');
			$row ['price_first'] = $this -> standart_money($price_first, 0);
			
			$price_last = FSInput::get ( 'price_last');
			$row ['price_last'] = $this -> standart_money($price_last, 0);

			$phone = FSInput::get ( 'phone');
			if ($phone) {
				$order = $this->get_record('number = '.$phone,'fs_order_items','order_id');
			}
			if (@$order) {
				$row ['order_id'] = $order->order_id;
			}

			$id = parent::save ( $row ,1);
			if (! $id) {
				Errors::setError ( 'Not save' );
				return false;
			}

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