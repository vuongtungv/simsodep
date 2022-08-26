<?php
	class RecruitmentControllersrecruitment extends Controllers
	{
		function __construct()
		{
			$this->view = 'recruitment' ; 
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
			
				// data from fs_recruitment_categories
				$categories_home  = $model->get_categories_tree();
				$maxOrdering = $model->getMaxOrdering();
				
				include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$categories  = $model->get_categories_tree();
//			$tags_categories = $model->get_tags_categories();
			$data = $model->get_record_by_id($id);
            
            $recruitment_related = $model -> get_news_related($data -> recruitment_related);
			// data from fs_news_categories
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
        
        function ajax_get_recruitment_related(){
			$model = $this -> model;
			$data = $model-> ajax_get_recruitment_related();
			$html = $this -> recruitment_genarate_related($data);
			echo $html;
			return;
		}
        function recruitment_genarate_related($data){
			$str_exist = FSInput::get('str_exist');
            $error_img = "this.src='/images/1443089194_picture-01.png'";
			$html = '';
				$html .= '<div class="recruitment_related">';
				foreach ($data as $item){
					if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
						$html .= '<div class="red recruitment_related_item  recruitment_related_item_'.$item -> id.'" onclick="javascript: set_recruitment_related('.$item->id.')" style="display:none" >';	
						$html .= $item -> title.'<br/>';			
						$html .= '<img onerror="'.$error_img.'" src="'.str_replace('/original/','/small/',URL_ROOT.@$item->image).'">';				
						$html .= '</div>';					
					}else{
						$html .= '<div class="recruitment_related_item  recruitment_related_item_'.$item -> id.'" onclick="javascript: set_recruitment_related('.$item->id.')">';	
						$html .= $item -> title.'<br/>';		
						$html .= '<img onerror="'.$error_img.'" src="'.str_replace('/original/','/small/',URL_ROOT.@$item->image).'">';		
						$html .= '</div>';	
					}
				}
				$html .= '</div>';
				return $html;
		}
		
		function view_comment($new_id){
//			$link = 'index.php?module=recruitment&view=comments&keysearch=&text_count=1&text0='.$new_id.'&filter_count=1&filter0=0';
			return '<a href="'.$link.'" target="_blink">Comment</a>'; 
		}
	}
?>