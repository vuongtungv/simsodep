<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/slideshow/models/slideshow.php';
	class SlideshowBControllersSlideshow
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			$category_id = $parameters->getParams('category_id');
			$limit = $parameters->getParams('limit');
			$style = $parameters->getParams('style');
			$timeout = $parameters->getParams('timeout');
			$limit = $limit? $limit : '4';
			$style = $style ? $style : 'default';
			$timeout = $timeout ? $timeout : '3';
			// call models
			$model = new SlideshowBModelsSlideshow();
			$data = $model -> get_data($category_id);
			if(!count($data))
				return;
			include 'blocks/slideshow/views/slideshow/'.$style.'.php';
		}
	}
	
?>