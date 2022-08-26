<?php
/*
 * Huy write
 */
	// models 
    include 'blocks/shopcart/models/shopcart.php';
	class ShopcartBControllersShopcart
	{
		function __construct()
		{
		}
		function display($parameters,$title){
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';
            $model = new ShopcartModelsShopcart();

            $orderSims = $_SESSION['cart'];

//            $styleProducts = $model->getStyleProduct();


			// call views
			include 'blocks/shopcart/views/shopcart/'.$style.'.php';
		}
	}
	
?>