<?php 
	class DeprecateModelsStatus extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'contact_order';
			$this -> table_name = 'fs_status';
			parent::__construct();
		}
	}
	
?>