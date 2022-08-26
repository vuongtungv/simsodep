<?php
    
    // require PATH_BASE.'libraries/elasticsearch/vendor/elasticsearch/elasticsearch/src/Elasticsearch/ClientBuilder.php';
    use Elasticsearch\ClientBuilder;
    require PATH_BASE.'libraries/elasticsearch/vendor/autoload.php';
    $hosts = [
        [
            'host' => 'localhost',
            'port' => '9200',
            'scheme' => 'http',
        ],

    ];

	// models 
	include 'blocks/list_sim/models/list_sim.php';
	class List_simBControllersList_sim
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{

		    $type  = $parameters->getParams('type'); 
			$limit = $parameters->getParams('limit');
			$limit = $limit ? $limit:9;
            $style = $parameters->getParams('style');
			// call models
			$model = new List_simBModelslist_sim();
			
			$results = $this->elasticsearch($type,$limit);

            $list = $results['hits']['hits'];
            
			$style = $style?$style:'default';
			// call views
			include 'blocks/list_sim/views/list_sim/'.$style.'.php';
		}


        function elasticsearch($type,$limit){

            $client = ClientBuilder::create()->setHosts($hosts)->build();

            // trạng thái status mặc định là 0
            $must_status = array('status'=>'0');
            $must_status = array('term'=>$must_status);
            $must['must'][] = $must_status;
            // trạng thái status mặc định là 0
            $must_admin_status = array('admin_status'=>'1');
            $must_admin_status = array('term'=>$must_admin_status);
            $must['must'][] = $must_admin_status;
            
            if ($type) {
                $must_type = array('type'=>$type);
                $must_type = array('term'=>$must_type);
                $must['must'][] = $must_type;
            }

            $query['bool'] = $must;
            $body['query'] = $query;
            $body['size'] = $limit;
            $body['from'] = 0;

            // $order = FSInput::get('order');
            // if ($order) {
            //     switch ($order) {
            //         case 'up':
            //             $ordering = 'asc';
            //             break;
            //         case 'down':
            //             $ordering = 'desc';
            //             break;
            //     }

            //     $sort = array('price_public'=>$ordering);
            //     $body['sort'][] = $sort;
            // }

            $params = [
                'index' => 'fs',
                'type' => 'simsodep',
                'body' => $body
            ];

            $results = $client->search($params);
           // echo '<pre>',print_r($results,1),'</pre>';die;

            return $results;
        }

        
        /*
    	 * get record by rid
    	 */
    	function get_record_by_id($id, $table_name = '', $select = '*') {
    		if (! $id)
    			return;
    		if (! $table_name)
    			$table_name = $this->table_name;
                
            $fstable = FSFactory::getClass('fstable');
            $this->table_name = $fstable->_($table_name);    
    		$query = " SELECT " . $select . "
    					  FROM " . $this->table_name . "
    					  WHERE id = $id ";
    		
    		global $db;
    		$sql = $db->query ( $query );
    		$result = $db->getObject ();
    		return $result;
    	}
	}
	
?>