<?php 
	class PromotionModelsPromotion extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'promotion';
			$this -> table_name = FSTable_ad::_('fs_promotion');
			
			// config for save
			$this -> check_alias = 0;
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
			
			// estore
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.category_id_wrapper like  "%,'.$filter.',%" ';
				}
			}	
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
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

		function save($row = array(),$use_mysql_real_escape_string = 0) 
		{
			$id = FSInput::get ( 'id', 0, 'int' );
			//time promotion
			// $date_start = FSInput::get('date_start');
			// $published_hour_start = FSInput::get('published_hour_start',date('H:i'));
			$date_end = FSInput::get('date_end');
			$published_hour_end = FSInput::get('published_hour_end',date('H:i'));
			// if($date_start){
			// 	$row['date_start'] = date('Y-m-d H:i:s',strtotime($published_hour_start. $date_start));
			// }
			if($date_end){
				$row['date_end'] = date('Y-m-d H:i:s',strtotime($published_hour_end. $date_end));
			}
			// if( date('Y-m-d H:i:s') > $row['date_end'] || date('Y-m-d H:i:s') > $row['date_start']){
			// 	Errors::_ ( 'Thời gian khuyến mại đã quá hạn','alert' );
			// }
			// if($row['date_start']  > $row['date_end']){
			// 	Errors::_ ( 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc','alert' );			
			// }
			$row['content'] = htmlspecialchars_decode(FSInput::get('content'));
			
			$id = parent::save ( $row );
			if (! $id) {
				Errors::setError ( 'Not save' );
				return false;
			}

			return $id;
		}
		
	}
	
?>