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

	class SimControllersDelete extends Controllers
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
                $array_obj_status[] = (object)array('id'=>($key+1),'name'=>$name);
            }
            
         	$list = $model->get_data('');
            $network = $model->get_records('published = 1','fs_network','name,id');
            $partner = $model->get_records('published=1 and type=2 ORDER BY full_name ASC , ordering DESC , id DESC','fs_users','id,full_name');
            $type = $model->get_records(' 1=1 order by id asc','fs_sim_type','id,name,alias');
			$list_key = array();
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
        function wait()
        {
            parent::display();
            $sort_field = $this -> sort_field;
            $sort_direct = $this -> sort_direct;
            
            $model  = $this -> model;
            
            $list = $model->get_data('');
            
           
            $list_key = array();
            $pagination = $model->getPagination('');
            include 'modules/'.$this->module.'/views/'.$this->view.'/wait.php';
        }
		function add()
		{
			$model = $this -> model;
			$maxOrdering = $model->getMaxOrdering();
			$uploadConfig = base64_encode('add|'.session_id());

			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
        
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$categories = $model->get_news_categories_tree_by_permission();
            
			$data = $model->get_record_by_id($id);

			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
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

        function restore()
        {
            $model  = $this -> model;
            $ids = FSInput::get('id',array(),'array');
            $client = ClientBuilder::create()->setHosts($hosts)->build();

            foreach ($ids as $item){
                $sim = $model->get_record('id = '.$item,'fs_sim','agency,number');
                $must_item = array('_id'=>$sim->agency.'-'.$sim->number);
                $must_arr = array('term'=>$must_item);
                $must['should'][] = $must_arr;
            }

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
             // echo '<pre>',print_r($params),'</pre>';die;
//            var_dump($ids);die;

            $this->is_check('admin_status',1,'sim đã được khôi phục');

        }

        function remove()
        {

            $id = FSInput::get('id',0,'int');

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

            $results = $client->deleteByQuery($params);

            $model = $this -> model;

            $model->remove_sim_dublicate();
            $rows = $model->remove();
            if($rows)
            {
                setRedirect('index.php?module='.$this -> module.'&view='.$this -> view,$rows.' '.FSText :: _('record was deleted'));
            }
            else
            {
                setRedirect('index.php?module='.$this -> module.'&view='.$this -> view,FSText :: _('Not delete'),'error');
            }
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
        
        function show_in_homepage()
    	{
    		$this->is_check('show_in_homepage',1,'show home');
    	}
    	function unshow_in_homepage()
    	{
    		$this->unis_check('show_in_homepage',0,'un home');
    	}

        function is_slideshow()
        {
            $this->is_check('is_slide',1,'show slideshow');
        }
        function unis_slideshow()
        {
            $this->unis_check('is_slide',0,'un slideshow');
        }
        function is_new_video()
        {
            $this->is_check('is_new_video',1,'show news dưới slide');
        }
        function unis_new_video()
        {
            $this->unis_check('is_new_video',0,'un news dưới slide');
        }
        
	}
?>