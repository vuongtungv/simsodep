<?php 
	class PurchaseModelsPurchase extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'purchase';
			$this -> table_name = 'fs_Purchase';
			parent::__construct();
		}
		

		
	}
	
?>