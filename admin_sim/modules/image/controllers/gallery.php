<?php
	class GalleryControllersGallery  extends Controllers
	{
		function __construct()
		{
			$this->view = 'gallery' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
            $categories = $model->get_categories_tree();
            
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
            $categories = $model->get_categories_tree();
			$maxOrdering = $model->getMaxOrdering();
			$uploadConfig = base64_encode('add|'.session_id());
			
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
            $categories = $model->get_categories_tree();
			$data = $model->get_record_by_id($id);
			
			$uploadConfig = base64_encode('edit|'.$id);
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		function get_other_images(){
	        $list_other_images = $this->model->get_other_images();   
	        include 'modules/' . $this->module . '/views/' . $this->view . '/detail_images_list.php';
	    } 
	   /**
	     * Upload nhiều ảnh
	     */ 
	    function upload_other_images(){
	        $this->model->upload_other_images();
	    }
	    /**
	     * Xóa ảnh
	     */ 
	    function delete_other_image(){
	        $this->model->delete_other_image();
	    }
    
	    /**
	     * Sắp xếp ảnh
	     */
	    function sort_other_images(){
	        $this->model->sort_other_images();
	    } 
	    function add_title_other_images(){
	        $this->model->add_title_other_images();
	    } 
	}
	
?>