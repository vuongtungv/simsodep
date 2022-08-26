<?php

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

	class SimControllersSim extends Controllers
	{
		function __construct()
		{
			$this->view = ''; 
			parent::__construct();
			$array_status = array( 0 => 'Hiển thị',1 => 'Giữ',2=>'Đã bán',3=>'Ẩn'); 
			$this -> arr_status = $array_status;
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;

			$array_status = $this -> arr_status;
			$array_obj_status = array();
			foreach($array_status as $key => $name){
				$array_obj_status[] = (object)array('id'=>($key),'name'=>$name);
			}
            
         	$list = $model->get_data('');
         	$network = $model->get_records('published = 1','fs_network','name,id');
           	$partner = $model->get_records('published=1 and type=2 ORDER BY full_name ASC , ordering DESC , id DESC','fs_users','id,full_name');
           	$city = $model->get_records('published=1 order by ordering asc','fs_cities','id,name');
           	$type = $model->get_records(' 1=1 order by id asc','fs_sim_type','id,name,alias');
			$list_key = array();
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
			$maxOrdering = $model->getMaxOrdering();
			$uploadConfig = base64_encode('add|'.session_id());
			$partner = $model->get_records('published=1 and type=2 ORDER BY full_name ASC , ordering DESC , id DESC','fs_users','id,full_name');
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
        
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$categories = $model->get_news_categories_tree_by_permission();
            $partner = $model->get_records('published=1 and type = 2 order by ordering asc','fs_users','id,full_name');
			$data = $model->get_record_by_id($id);

			include 'modules/'.$this->module.'/views/'.$this->view.'/view.php';
		}
        
		function get_agency()
		{
			$model = $this -> model;

			$id= FSInput::get('agency');
			
			$agency = $model->get_record('id ='.$id,'fs_users','price_name');

			if ($agency) {
				echo $agency->price_name;
			}else{
				echo '';
			}

		} 

		function get_member()
		{
			$model = $this -> model;

			$phone= FSInput::get('phone');
			
			$member = $model->get_record('telephone ='.$phone,'fs_members','*');

			$json = array(
	            'name' => '',
	            'code' => '',
	            'email' => '',
	            "address"=>'',
	            "city"=>'',
	            "discount"=>'',
	            "discount_unit"=>'',
	            "discount_name"=>'',
	            "price"=>'',
	        );

			$json['name'] = $member->name;
			$json['code'] = $member->code;
	        $json['email'] = $member->email;
	        $json['address'] = $member->address;
	        $json['city'] = $member->city;

			if (@$member) {
            	$discount_name = $member->position_name;
	            $price = $model->get_records('price_id ="'.$member->position.'"','fs_member_commissions','*');
	            // var_dump($price);die;
            	$total =  FSInput::get('price_public');
            	$total =  standart_money($total);
            	$code = $member->code;
	            if ($price) {
	                foreach ($price as $item) {
	                    if ($total >= $item->price_f && $total< $item->price_t) {
	                        $discount = $item->commission;
	                        $discount_unit = $item->commission_unit;
	                    }
	                }
	            }
		        $json['discount'] = $discount;
		        $json['discount_unit'] = $discount_unit;
		        $json['discount_name'] = $discount_unit=='percent'?$discount.'%':format_money($discount,'');
		        $after = $total;
		        if ($discount_unit=='percent') {
		        	$after = $total - $total*$discount/100;
		        }
		        if ($discount_unit=='price') {
		        	$after = $total - $discount;
		        }
		        $json['price'] = format_money($after,'');
			}

	        echo json_encode($json);

		} 

		function save_ajax()
		{
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$id = $model->save();
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			if($this -> page)
				$link .= '&page='.$this -> page;
			if($id)
			{
				setRedirect($link,FSText :: _('Saved'));
			}
			else
			{
				setRedirect($link,FSText :: _('Not save'),'error');
			}
		}

        function add_param(){
            $results_id= FSInput::get('results_id');
			$model  = $this -> model;
			$created_link  = $model -> get_linked_id();
			if(!$created_link)
				return;
			
			$field_display  = $created_link -> add_field_display;
			$field_value  = $created_link -> add_field_value;
			$add_param  = $created_link -> add_parameter;
			
			// create array if add multi param
			$arr_field_value = explode(',',$field_value);
			$arr_add_param = explode(',',$add_param);
			
			
			$list = $model->get_data_from_table($created_link -> add_table,$field_display,$field_value,$created_link -> add_field_distinct);
			$pagination = $model->get_pagination_create_link($created_link -> add_table,$field_display,$field_value,$created_link -> add_field_distinct);
			
            include 'modules/'.$this->module.'/views/news/add_param.php';
		}

		function delete()
    	{
            $model  = $this -> model;
            $ids = FSInput::get('id',array(),'array');
            $client = ClientBuilder::create()->setHosts($hosts)->build();
            $indices = $client->cat()->indices();

            foreach ($ids as $item){
                $sim = $model->get_record('id = '.$item,'fs_sim','agency,number');
                $must_item = array('_id'=>$sim->agency.'-'.$sim->number);
                $must_arr = array('term'=>$must_item);
                $must['should'][] = $must_arr;
            }

            $query['bool'] = $must;
            $body['query'] = $query;

            $params = [
                'index' => 'fs',
                'type' => 'simsodep',
                'body' => $body
            ];

           // echo '<pre>',print_r($params),'</pre>';die;
            $results = $client->deleteByQuery($params);
    		$this->delete_sim('sim đã được xóa');
    	}
        
        function is_hot()
    	{
    		$this->is_check('is_hot',1,'is_hot');
    	}
    	function unis_hot()
    	{
    		$this->unis_check('is_hot',0,'un_hot');
    	}
        function is_new()
    	{
    		$this->is_check('is_new',1,'is_new');
    	}
    	function unis_new()
    	{
    		$this->unis_check('is_new',0,'un_new');
    	}
        
	}
?>