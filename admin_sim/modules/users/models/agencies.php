<?php
class UsersModelsAgencies  extends FSModels {
	var $limit;
	var $page;
	function __construct() {
		$limit = FSInput::get ( 'limit', 20, 'int' );
		$page = FSInput::get ( 'page' );
		$this-> limit = $limit;
		$this-> page = $page;
        $this -> view = 'agencies';
		$this -> table_name = 'fs_agencies';
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
			$ordering .= " ORDER BY ordering DESC , id DESC ";
		
		
		if(isset($_SESSION[$this -> prefix.'keysearch'] ))
		{
			if($_SESSION[$this -> prefix.'keysearch'] )
			{
				$keysearch = $_SESSION[$this -> prefix.'keysearch'];
				$where .= " AND ( a.name LIKE '%".$keysearch."%' OR a.id LIKE '%".$keysearch."%' )";
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

	/*
		 * Save
		 */
	function save($row = array(), $use_mysql_real_escape_string = 1) {	   
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
			$price_f_exist_begin = FSInput::get ( 'price_f_exist_' . $i . "_begin" );
			
			$price_t_exist = FSInput::get ( 'price_t_exist_' . $i );
			$price_t_exist_begin = FSInput::get ( 'price_t_exist_' . $i . "_begin" );
			
			$commission_exist = FSInput::get ( 'commission_exist_' . $i );
			$commission_exist_begin = FSInput::get ( 'commission_exist_' . $i . "_begin" );
			
			$commission_unit_exist = FSInput::get ( 'commission_unit_exist_' . $i );
			$commission_unit_exist_begin = FSInput::get ( 'commission_unit_exist_' . $i . "_begin" );
			
			//				$ordering_exist = FSInput::get('ordering_exist_'.$i);
			//				$ordering_exist_begin = FSInput::get('ordering_'.$i.'_begin');
			

			if (($price_f_exist != $price_f_exist_begin) || ($price_t_exist != $price_t_exist_begin) || ($commission_exist != $commission_exist_begin) || ($commission_unit_exist != $commission_unit_exist_begin)) {
				$sim_price_f =  FSInput::get ( 'price_f_exist_' . $i);
				$sim_price_t= FSInput::get ( 'price_t_exist_' . $i );
				$price_f= $this -> standart_money($sim_price_f);
				$price_t= $this -> standart_money($sim_price_t);
				
				$row = array ();
				$row ['price_f'] = $price_f;
				$row ['price_t'] =$price_t;
				if (! $row ['price_t'] && ! $row ['price_f']) {
					continue;
				}
				$row ['commission'] = FSInput::get ( 'commission_exist_' . $i, 0, 'int' );
				$row ['commission_unit'] = FSInput::get ( 'commission_unit_exist_' . $i );
				

				$u = $this->_update ( $row, 'fs_agencies_commissions', ' id=' . $id_exist );
				if ($u)
					$rs ++;
			}
		}
		return $rs;
	
		// END EXIST FIELD
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
			$sql = " DELETE FROM fs_agencies_commissions
						WHERE agency_id = $record_id AND id IN ($str_other_commissions)";
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
		for($i = 0; $i < 20; $i ++) {
			$row = array ();
			$row ['price_t'] = FSInput::get ( 'new_price_t_' . $i );
			$row ['price_f'] = FSInput::get ( 'new_price_f_' . $i );
			$row ['commission'] = FSInput::get ( 'new_commission_' . $i );
			$row ['commission_unit'] = FSInput::get ( 'new_commission_unit_' . $i );
			if (! $row ['price_t'] && ! $row ['price_f']) {
				continue;
			}

			$row ['agency_id'] = $record_id;
			$row ['published'] = 1;
			$rs = $this->_add ( $row, 'fs_agencies_commissions', 0 );
		}
		return true;
	}


}

?>