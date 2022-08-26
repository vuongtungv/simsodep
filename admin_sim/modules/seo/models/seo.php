<?php 
	class SeoModelsSeo extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'seo';
			$this -> table_name = 'fs_seo';
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
					$ordering .= " ORDER BY $sort_field $sort_direct, module_seo ASC, created_time DESC, id DESC ";
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY module_seo ASC, created_time DESC , id DESC ";
			
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

		function save($row = array(), $use_mysql_real_escape_string = 1) {	 
			// echo 1; die;
			$id = FSInput::get ( 'id');
			$module_seo = FSInput::get ( 'module_seo');
			$type = FSInput::get ( 'type');

			if ($type) {
				switch ($module_seo) {
					case 'cat':
						$list = $this->get_record('level = 0  and id="'.$type.'"','fs_sim_type','id,name');
						$name_seo = @$list->name;
						break;
					case 'network':
						$list = $this->get_record('published=1 and id="'.$type.'"','fs_network','id,name,alias');
						$name_seo = @$list->name;
						break;
					case 'head_network':
						$list = $this->get_record('published=1 and id="'.$type.'"','fs_network','id,name,alias');
						$name_seo = @$list->name;
						break;
					case 'header':
						$list = $this->get_record('published=1 and id="'.$type.'"','fs_network','id,name,alias');
						$name_seo = @$list->name;
						break;
					case 'sim':
						break;
					case 'par':
						$name_seo = '';
						switch ($type) {
				        	case 'kim':
				        		$name_seo = 'Sim hợp mệnh kim';
				        		break;
				        	case 'moc':
				        		$name_seo = 'Sim hợp mệnh mộc';
				        		break;
			        		case 'thuy':
				        		$name_seo = 'Sim hợp mệnh thủy';
				        		break;
			        		case 'hoa':
				        		$name_seo = 'Sim hợp mệnh hỏa';
				        		break;
			        		case 'tho':
				        		$name_seo = 'Sim hợp mệnh thổ';
				        		break;
				        }
						break;
					case 'subcat':
						$list = $this->get_record('level = 0 and id="'.$type.'"','fs_sim_type','id,name');
						$name_seo = @$list->name;
						break;
					default:
						break;
				}
				$row['name_type'] = @$name_seo;
			}

			if ($id) {
				$row['user_update'] = $_SESSION['ad_userid'];
				$row['user_update_name'] = $_SESSION['ad_username'];
			}else{
				$row['user_create'] = $_SESSION['ad_userid'];
				$row['user_create_name'] = $_SESSION['ad_username'];
			}
			// var_dump($row);die;
			$cid = parent::save($row,0);
			
			return $cid;
		
		}

		function hot($value)
		{
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
							SET is_hot = $value
						WHERE id IN ( $str_ids ) " ;
				$db->query($sql);
				$rows = $db->affected_rows();
				return $rows;
			}
			return 0;
			
		}
	}
	
?>