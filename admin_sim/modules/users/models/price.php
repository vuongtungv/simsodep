<?php
class UsersModelsPrice  extends FSModels {
	var $limit;
	var $page;
	function __construct() {
		$limit = FSInput::get ( 'limit', 20, 'int' );
		$page = FSInput::get ( 'page' );
		$this-> limit = $limit;
		$this-> page = $page;
        $this -> view = 'price';
		$this -> table_name = 'fs_price';
        $this -> check_alias = 0;
                        
        parent::__construct();
	}

	function setQuery() {
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

		if(isset($_SESSION[$this -> prefix.'filter0'])){
			$filter = $_SESSION[$this -> prefix.'filter0'];
			if($filter){
				$where .= ' AND a.city = '.$filter.'';
			}
		}

		if(!$ordering)
			$ordering .= " ORDER BY name ASC, ordering DESC , id DESC ";
		
		
		if(isset($_SESSION[$this -> prefix.'keysearch'] ))
		{
			if($_SESSION[$this -> prefix.'keysearch'] )
			{
				$keysearch = $_SESSION[$this -> prefix.'keysearch'];
				$where .= " AND ( a.name LIKE '%".$keysearch."%' )";
			}
		}
		$query = " SELECT a.*
					  FROM 
					  ".$this -> table_name." AS a
					  	WHERE 1=1".
					 $where.
					 $ordering. " ";
					
		return $query;
	}

	function get_data_for_export() {
		global $db;
		$query = $this->setQuery ();
		if (! $query)
			return array ();
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		
		return $result;
	}

	/*
		 * Save
		 */
	function save($row = array(), $use_mysql_real_escape_string = 1) {	 
		// echo 1; die;
		$id = FSInput::get ( 'id');
		if ($id) {
			$row['user_update'] = $_SESSION['ad_userid'];
			$row['user_update_name'] = $_SESSION['ad_username'];
		}else{
			$row['user_create'] = $_SESSION['ad_userid'];
			$row['user_create_name'] = $_SESSION['ad_username'];
		}
		
		$cid = parent::save($row,0);;

				// remove
		if (! $this->remove_commission ( $cid )) {
			//				return false;
		}
		// edit
		if (! $this->save_exist_commission ( $cid )) {
			//				return false;
		}
		// save new
		if (! $this->save_new_commission ( $cid )) {
		}
		
		return $cid;
	
	}

	function save_exist_commission($id) {
		global $db;
		// EXIST FIELD
		$commissions_exist_total = FSInput::get ( 'commissions_exist_total' );
		
		$sql_alter = "";
		$arr_sql_alter = array ();
		$rs = 0;

		for($i = 0; $i < $commissions_exist_total; $i ++) {
			
			$id_exist = FSInput::get ( 'id_exist_' . $i );
			
			$price_f_exist = FSInput::get ( 'price_f_exist_' . $i );
			$price_f_exist_begin = FSInput::get ( 'price_f_exist_' . $i . "_original" );
			
			$price_t_exist = FSInput::get ( 'price_t_exist_' . $i );
			$price_t_exist_begin = FSInput::get ( 'price_t_exist_' . $i . "_original" );
			
			$commission_exist = FSInput::get ( 'commission_exist_' . $i );
			$commission_exist_begin = FSInput::get ( 'commission_exist_' . $i . "_original" );
			
			$commission_unit_exist = FSInput::get ( 'commission_unit_exist_' . $i );
			$commission_unit_exist_begin = FSInput::get ( 'commission_unit_exist_' . $i . "_original" );

			$commission_type_exist = FSInput::get ( 'commission_type_exist_' . $i );
			$commission_type_exist_begin = FSInput::get ( 'commission_type_exist_' . $i . "_original" );
			
			$ordering_exist = FSInput::get('ordering_exist_'.$i);
			$ordering_exist_begin = FSInput::get('ordering_'.$i.'_original');
			

			if (($price_f_exist != $price_f_exist_begin) || ($price_t_exist != $price_t_exist_begin) || ($commission_exist != $commission_exist_begin) || ($commission_unit_exist != $commission_unit_exist_begin) || ($commission_type_exist != $commission_type_exist_begin) || ($ordering_exist != $ordering_exist_begin) ) {
				$sim_price_f =  FSInput::get ( 'price_f_exist_' . $i);
				$sim_price_t= FSInput::get ( 'price_t_exist_' . $i );
				$commission= FSInput::get ( 'commission_exist_' . $i );
				$price_f= $this -> standart_money($sim_price_f);
				$price_t= $this -> standart_money($sim_price_t);
				$commission= $this -> standart_money_commission($commission);
				$row = array ();
				$row ['price_f'] = $price_f;
				$row ['price_t'] =$price_t;
				$row ['price_t'] =$price_t;
				$row ['price_t'] =$price_t;
				$row ['commission'] =$commission;
				$time = date('Y-m-d H:i:s');
				$row ['update_time'] =$time;
				if (! $row ['price_t'] && ! $row ['price_f']) {
					continue;
				}
				$row ['commission_unit'] = FSInput::get ( 'commission_unit_exist_' . $i );
				$row ['commission_type'] = FSInput::get ( 'commission_type_exist_' . $i );
				$row['ordering'] = $ordering_exist;
				
				$u = $this->_update ( $row, 'fs_price_commissions', ' id=' . $id_exist );
				if ($u)
					$rs ++;
			}
		}
		return $rs;
	
		// END EXIST FIELD
	}
	function standart_money_commission($money){
		$money = str_replace(',','' , trim($money));
		$money = str_replace(' ','' , $money);
//		$money = intval($money);
		$money = (double)($money);
		return $money; 
	}

	function standart_money($money){
		$money = str_replace(',','' , trim($money));
		$money = str_replace(' ','' , $money);
		$money = str_replace('.','' , $money);
//		$money = intval($money);
		$money = (double)($money);
		return $money; 
	}
	/*
		 * remove commission
		 */
	function remove_commission($record_id) {
		if (! $record_id)
			return true;
//		$other_images_remove = FSInput::get ( 'other_commission', array (), 'array' );
//		if (! $other_images_remove)
//			return true;
//		$str_other_commissions = implode ( ',', $other_commissions_remove );
		$other_image_remove = FSInput::get('other_image',array(),'array');
		$str_other_commissions = implode(',',$other_image_remove);
		if ($str_other_commissions) {
			global $db;
			
			// remove in database
			$sql = " DELETE FROM fs_price_commissions
						WHERE price_id = $record_id AND id IN ($str_other_commissions)";
			$db->query ( $sql );
			$rows = $db->affected_rows ();
			return $rows;
		}
		return true;
	}
	
	/*
		 * Add commission
		 */
	function save_new_commission($record_id) {
		global $db;
		for($i = 0; $i < 50; $i ++) {
			$row = array ();

			$sim_price_f = FSInput::get ( 'new_price_t_' . $i );
			$sim_price_t = FSInput::get ( 'new_price_f_' . $i );
			$commission = FSInput::get ( 'new_commission_' . $i );
			$ordering = FSInput::get ( 'new_ordering_' . $i );

			$price_f= $this -> standart_money($sim_price_f);
			$price_t= $this -> standart_money($sim_price_t);
			$commission= $this -> standart_money_commission($commission);

			$row ['price_t'] = $price_f;
			$row ['price_f'] = $price_t;
			$row ['ordering'] = $ordering;
			$row ['commission'] = $commission;
			$row ['commission_unit'] = FSInput::get ( 'new_commission_unit_' . $i );
			$row ['commission_type'] = FSInput::get ( 'new_commission_type_' . $i );
			$time = date('Y-m-d H:i:s');
			$row ['created_time'] =$time;
			if (! $row ['price_t'] && ! $row ['price_f']) {
				continue;
			}
			$row ['price_id'] = $record_id;
			$row ['published'] = 1;
			$rs = $this->_add ( $row, 'fs_price_commissions', 0 );
		}
		return true;
	}


}

?>