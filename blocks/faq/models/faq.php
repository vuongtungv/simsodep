<?php 
	class FaqlistBModelsFaqlist
	{
		function __construct()
		{
          
		}
		
		function setQuery($ordering,$limit,$type){
			$fstable = FSFactory::getClass('fstable');
			$Itemid = FSInput::get('Itemid',16,'int');
			if($Itemid == 15){
			  	$this->table_name  = $fstable->_('fs_aq');
			}else{
			  	$this->table_name  = $fstable->_('fs_faq');
			}
			$where = '';
			$order = '';
			$order .= ' hits DESC , ordering DESC';
			$query = ' SELECT id,title,content,alias,category_alias 
						  FROM '. $this->table_name .'
						  WHERE  published = 1 '. $where .'
						  ORDER BY  '. $order .'
						  LIMIT '. $limit  
						 ;
			return $query;
		}
        
		function get_list($ordering,$limit,$type){
			global $db;
			$query = $this->setQuery($ordering,$limit,$type);
			if(!$query)
				return;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
        

	}
	
?>