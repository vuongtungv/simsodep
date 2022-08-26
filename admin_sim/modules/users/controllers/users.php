<?php

require PATH_BASE.'libraries/elasticsearch/vendor/elasticsearch/elasticsearch/src/Elasticsearch/ClientBuilder.php';
use Elasticsearch\ClientBuilder;
require PATH_BASE.'libraries/elasticsearch/vendor/autoload.php';
$hosts = [
    [
        'host' => 'localhost',          //yourdomain.com
        'port' => '9200',
        'scheme' => 'http',             //https
        //        'path' => '/elastic',
        //        'user' => 'username',         //nếu ES cần user/pass
        //        'pass' => 'password!#$?*abc'
    ],

];

class UsersControllersUsers extends Controllers
	{
		var $module;
		var $gid;
		function __construct()
		{
//			$module = 'users';
			$this->view = 'users';
			$this -> table_name = 'fs_users';
			parent::__construct(); 
			$this->gid = FSInput::get('gid');
			$array_status = array( 
                1 => FSText::_('Có'),
                2 => FSText::_('Không'),
                );
			$this -> arr_status = $array_status;
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
//			$select_cat = FSInput::get('select_cat');
			$model  = $this -> model;

			$array_status = $this -> arr_status;
			$array_obj_status = array();
			foreach($array_status as $key => $name){
				if ($key == 1) {
					$quantity = $model->get_count('type = 2 and total_sim > 0','fs_users');
				}
				if ($key == 2) {
					$quantity = $model->get_count('type = 2 and total_sim = 0','fs_users');
				}
				$array_obj_status[] = (object)array('id'=>($key),'name'=>$name.' - '.$quantity);
			}

			$list = $model->get_data('');
			$agencies = $model->get_records('published=1 order by ordering asc','fs_agencies','id,name');
			$city = $model->get_records('published=1 order by ordering asc','fs_cities','id,name');
			
			// call views
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/users/list.php';
		}
		
		
		function add()
		{
			$model = $this -> model;
			$maxOrdering = $model->getMaxOrdering();
			$agencies = $model->get_records('published=1 order by ordering asc','fs_agencies','id,name');
			$price = $model->get_records('published=1 order by name ASC','fs_price','id,name');
            $city = $model->get_records('published=1 order by ordering asc','fs_cities','id,name');
            // var_dump($city);die;
	//		$groups_all = $model->getUserGroupsAll();
			include 'modules/'.$this->module.'/views/users/detail.php';
		}
		function edit()
		{
			$cds = FSInput::get('id',array(),'array');
			$cid = $cds[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($cid);
			$agencies = $model->get_records('published=1 order by ordering asc','fs_agencies','id,name');
			$price = $model->get_records('published=1 order by name ASC','fs_price','id,name');
			$city = $model->get_records('published=1 order by ordering asc','fs_cities','id,name');
			$commissions = $model ->get_records('agency_id = '.$data -> id,'fs_agencies_commissions');
	//		$groups_all = $model->getUserGroupsAll();
	//		$groups_contain_user = $model->getUserGroupsByUser();
			include 'modules/'.$this->module.'/views/users/detail.php';
		}
		
		function save()
		{
			$model = $this -> model;
			$id = FSInput::get('id');
			if(!$id){
				if($model->check_exits_email()){
					setRedirect('index.php?module=users&view=users',FSText :: _('Email này đã có người sử dụng'),'error');	
				}
				if($model->check_exits_username()){
					setRedirect('index.php?module=users&view=users',FSText :: _('Username này đã có người sử dụng'),'error');	
				}
			}
			// check password and repass
			$password = FSInput::get("password1");
			$repass = FSInput::get("re-password1");
            
			if(@$id)
			{
				$edit_pass = FSInput::get('edit_pass');
				if($edit_pass){
					if(!$password || ($password != $repass))
					{
						setRedirect('index.php?module=users&view=users',FSText :: _('You must enter a valid password'),'error');
					}
				}
			}
			else
			{
				$edit_pass = FSInput::get('edit_pass');
				if($edit_pass){
					if(!$password || ($password != $repass))
					{
						setRedirect('index.php?module=users&view=users',FSText :: _('You must enter a valid password'),'error');
					}
				}	
			}
			
			// call Models to save
			$cid = $model->save();
			
			if($cid)
			{
				setRedirect('index.php?module=users&view=users&cid='.$cid,FSText :: _('Saved'));	
			}
			else
			{
				setRedirect('index.php?module=users&view=users',FSText :: _('Not save'),'error');	
			}
			
		}

		function delete() {
			$model = $this -> model;

			$id = FSInput::get('id',0,'int');
	        
			$link =  'index.php?module=users&view=users';
			$rs = $model->delete ($id);
			// $this->delete_es ($id);

			if ($rs) { 

                $client = ClientBuilder::create()->setHosts($hosts)->build();

                $must_item = array('agency'=>$id);
                $must_arr = array('term'=>$must_item);
                $must['must'][] = $must_arr;

                $query['bool'] = $must;
                $body['query'] = $query;

                $params = [
                    'index' => 'fs',
                    'type' => 'simsodep',
                    'body' => $body
                ];

                $results = $client->deleteByQuery($params);

				setRedirect ( $link, 'Đã xóa '.$rs.' sim ' );
			} else {
				setRedirect ( $link, 'Không có sim trong đại lý', 'error' );
			}
		}

		function delete_es($id){
	        require PATH_BASE.'libraries/elasticsearch/vendor/autoload.php';
	        $hosts = [
	            [
	                'host' => 'localhost',          //yourdomain.com
	                'port' => '9200',
	                'scheme' => 'http',             //https
	                //        'path' => '/elastic',
	                //        'user' => 'username',         //nếu ES cần user/pass
	                //        'pass' => 'password!#$?*abc'
	            ],

	        ];
	        $client = ClientBuilder::create()->setHosts($hosts)->build();

	        // xóa dữ liệu theo query elasticsearch
	        $updateRequest = [
	            'index'     => 'fs',
	            'type'      => 'simsodep',
	            'conflicts' => 'proceed',
	            'body' => [
	                'query' => [
	                    'term' => [
	                        'agency' => "$id"
	                    ]
	                ]
	            ]
	        ];

	        $results = $client->deleteByQuery($updateRequest);

	       // echo '<pre>',print_r($results,1),'</pre>';die;
	    }
		
		function allowed() {
			$model = $this -> model;

			$id = FSInput::get('id',0,'int');
	        
			$link =  'index.php?module=users&view=users';
			$rs = $model->allowed ($id);

			if ($rs) {

                $client = ClientBuilder::create()->setHosts($hosts)->build();

                $must_item = array('agency'=>$id);
                $must_arr = array('term'=>$must_item);
                $must['must'][] = $must_arr;

                $query['bool'] = $must;
                $body['query'] = $query;
                $body['script'] = [
                    'source' => 'ctx._source.admin_status  = params.value',
                    'params' => [
                        'value' => 1
                    ]
                ];
                $params = [
                    'index' => 'fs',
                    'type' => 'simsodep',
                    'body' => $body
                ];

                $results = $client->updateByQuery($params);
                       // echo '<pre>',print_r($params,1),'</pre>';die;

				setRedirect ( $link, 'Đã duyệt '.$rs.' sim ' );
			} else {
				setRedirect ( $link, 'Không có sim đang chờ duyệt', 'error' );
			}
		}

		function remove(){
	    
			$cids = FSInput::get('id',array(),'array');
			foreach ($cids as $cid){
				if( $cid != 1)
					$cids[] = $cid ;
			}
			if(!count($cids))
				return false;
			$str_cids = implode(',',$cids);

			foreach ($cids as $item) {
				$this->delete_es ($item);
			}

			$sql = " DELETE FROM fs_sim 
						WHERE agency IN ( $str_cids ); " ;

			$sql .= " DELETE FROM fs_sim_dublicate 
						WHERE agency IN ( $str_cids ); " ;
				
			global $db;
			$rows = $db->affected_rows($sql);

			$sql = " DELETE FROM ".$this -> table_name." 
						WHERE id IN ( $str_cids ) ;" ;
	                    						
			$rows = $db->affected_rows($sql);

			if($rows)
			{
				setRedirect('index.php?module='.$this -> module.'&view='.$this -> view,$rows.' '.FSText :: _('record was deleted'));
			}
			else
			{
				setRedirect('index.php?module='.$this -> module.'&view='.$this -> view,FSText :: _('Not delete'),'error');
			}
			
		}
		
		
		/*********************************** CREATE LINK *********************************/

		function linked()
		{
			$model = $this -> model;
			$linked_list = $model->getCreateLink();
			$parent_list = $model->getParentLink();
			
			$cid = FSInput::get('cid');
			if($cid)
			{
				$linked = $model -> getLinkedById($cid);
			}
			include 'modules/'.$this->module.'/views/users/linked.php';
			
		}
		/*********************************** end CREATE LINK *********************************/

		
		/*********************************** PERMISSION *********************************/

	function permission_save() {
		$model = $this->model;

		$id = FSInput::get('id',0,'int');
		$link = "index.php?module=users&view=users&task=permission&cid=".$id."" ;
		$rs = $model->permission_save ($id);
		
		// if not save
		if ($rs) {
			setRedirect ( $link, 'Đã lưu thành công' );
		} else {
			setRedirect ( $link, 'Bạn chưa lưu thành công', 'error' );
		}
	}
	function permission_apply() {
		$model = $this -> model;

		$id = FSInput::get('id',0,'int');
        
		$link =  'index.php?module=users&view=users&task=permission&cid='.$id ;
		$rs = $model->permission_save ($id);
		// if not save
		if ($rs) {
			setRedirect ( $link, 'Đã lưu thành công' );
		} else {
			setRedirect ( $link, 'Bạn chưa lưu thành công', 'error' );
		}
	}
	
	function permission(){
		$id = FSInput::get('cid');
        
        $link =  'index.php?module=users&view=users' ;     
		if(!$id || $id == 1 || $id==9){
			setRedirect($link, FSText::_('Không được quyền sửa user này') ,'error');
		}
		$model = $this -> model;
		$list_task = $model -> get_records('published = 1','fs_permission_tasks','*','ordering ASC, id ASC');
        
		$arr_task = array();
		foreach($list_task as $item){
			if(!isset($arr_task[$item -> module][$item -> view]))
				$arr_task[$item -> module][$item -> view] = array();
			$arr_task[$item -> module][$item -> view] = $item;	
		}
		
		// other
		$news_categories = $model->get_news_categories ();
		$products_categories = $model->get_products_categories ();
		
		$data = $model -> get_record_by_id($id,'fs_users');
        
		$list_permission = $model -> get_records(' user_id = '.$data -> id,'fs_users_permission','*','','','task_id');
		include 'modules/' . $this->module . '/views/' . $this->view . '/permission.php';
	}
    
    function display_page_fun(){
        $model = $this -> model;
        
        $n_module = FSInput::get('n_module');
        $n_view = FSInput::get('n_view');
        $user_id = FSInput::get('user_id',0,'int');
        if(!$n_module || !$n_view || !$user_id)
            return false;
        // list task phan quyen
        $task_fun = $model->get_record(' module = "'.$n_module.'" AND view = "'.$n_view.'"','fs_permission_tasks','list_function');
        // list fun phan quyen
        $list_field = $model->get_records(' published = 1 ','fs_permission_fun'); 
        // data save phan quyen
        $data = $model->get_record(' user_id = '.$user_id.' AND module = "'.$n_module.'" AND view = "'.$n_view.'" ','fs_users_permission_fun');
           
        include 'modules/' . $this->module . '/views/' . $this->view . '/display_page_fun.php';
    }
    
    function save_fun_permission(){
        $model = $this -> model;
        
        $n_module = FSInput::get('n_module');
        $n_view = FSInput::get('n_view');
        $user_id = FSInput::get('user_id',0,'int');
        
        if(!$n_module || !$n_view || !$user_id)
            setRedirect( 'index.php?module=users&view=users', 'lỗi,không có dữ liệu', 'error' );
            
        $link =  'index.php?module=users&view=users&task=permission&cid='.$user_id ;
		$rs = $model->save_fun_permission();
		// if not save
		if ($rs) {
			setRedirect ( $link, 'Đã lưu thành công' );
		} else {
			setRedirect ( $link, 'Bạn chưa lưu thành công', 'error' );
		}    
    }
    
    function display_page(){
        $model = $this -> model;
        
        $n_module = FSInput::get('n_module');
        $n_view = FSInput::get('n_view');
        $user_id = FSInput::get('user_id',0,'int');
        if(!$n_module || !$n_view || !$user_id)
            return false;
        
        
        
        $list_field = $model->get_records(' published = 1 AND module = "'.$n_module.'" AND view = "'.$n_view.'"','fs_permission_field');
        //if(!count($list_field))
//            return false;
        $data = $model->get_record(' user_id = '.$user_id.' AND module = "'.$n_module.'" AND view = "'.$n_view.'" ','fs_users_permission_field');
        
        include 'modules/' . $this->module . '/views/' . $this->view . '/display_page.php';
    }
    
    function save_field_permission(){
        $model = $this -> model;
        
        $n_module = FSInput::get('n_module');
        $n_view = FSInput::get('n_view');
        $user_id = FSInput::get('user_id',0,'int');
        
        if(!$n_module || !$n_view || !$user_id)
            setRedirect( 'index.php?module=users&view=users', 'lỗi,không có dữ liệu', 'error' );
            
        $link =  'index.php?module=users&view=users&task=permission&cid='.$user_id ;
		$rs = $model->save_field_permission();
		// if not save
		if ($rs) {
			setRedirect ( $link, 'Đã lưu thành công' );
		} else {
			setRedirect ( $link, 'Bạn chưa lưu thành công', 'error' );
		}    
    }
    
    function ajax_check_exist_email(){
		$model = $this -> model;
		if(!$model -> ajax_check_exits_email()){
			echo 0;
			return false;
		}
		echo 1;
		return true;
	}
    
    function ajax_check_exist_username(){
		$model = $this -> model;
		if(!$model -> ajax_check_exist_username()){
			echo 0;
			return false;
		}
		echo 1;
		return true;
	}
		
		/*********************************** end PERMISSION *********************************/		 
}
	
?>