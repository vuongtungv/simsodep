<?php

    require PATH_BASE.'libraries/elasticsearch/vendor/elasticsearch/elasticsearch/src/Elasticsearch/ClientBuilder.php';
    use Elasticsearch\ClientBuilder;

	class SimModelsSim extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
		    date_default_timezone_set('Asia/Ho_Chi_Minh');  
			$this -> limit = 30;
			$this -> view = 'sim';
			$this -> arr_img_paths = array(
                                            array('resized',226,135,'resize_image'),
                                            array('small',212,128,'cut_image'),
                                            array('large',462,280,'resize_image')
                                        );
			$this -> table_category_name = FSTable_ad::_('fs_news_categories');
            $this -> table_name = FSTable_ad::_('fs_sim');
            $this -> table_link = 'fs_menus_createlink';
            $this -> table_products = 'fs_products';
            $limit_created_link = 30;
			$this->limit_created_link = $limit_created_link;
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			//$cday = date('d');
			$this -> img_folder = 'images/news/'.$cyear.'/'.$cmonth;
			$this -> check_alias = 0;
			$this -> field_img = 'image';
			
			parent::__construct();
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
            
            // from
    		if(isset($_SESSION[$this -> prefix.'text0']))
    		{
    			$date_from = $_SESSION[$this -> prefix.'text0'];
    			if($date_from){
    				$date_from = strtotime($date_from);
    				$date_new = date('Y-m-d H:i:s',$date_from);
    				$where .= ' AND created_time >=  "'.$date_new.'" ';
    			}
    		}
    
    		// to
    		if(isset($_SESSION[$this -> prefix.'text1']))
    		{
    			$date_to = $_SESSION[$this -> prefix.'text1'];
    			if($date_to){
    				$date_to = $date_to . ' 23:59:59';
    				$date_to = strtotime($date_to);
    				$date_new = date('Y-m-d H:i:s',$date_to);
    				$where .= ' AND created_time <=  "'.$date_new.'" ';
    			}
    		}

    		// from
    		if(isset($_SESSION[$this -> prefix.'text2']))
    		{
    			$price_from = $_SESSION[$this -> prefix.'text2'];
    			if($price_from){
    				$where .= ' AND price >= '.$price_from.'';
    			}
    		}
    
    		// to
    		if(isset($_SESSION[$this -> prefix.'text3']))
    		{
    			$price_to = $_SESSION[$this -> prefix.'text3'];
    			if($price_to){
    				$where .= ' AND price <= '.$price_to.'';
    			}
    		}
			
			// estore
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND network_id = '.$filter.'';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter1 = $_SESSION[$this -> prefix.'filter1'];
				if($filter1){
					$where .= ' AND agency = '.$filter1.'';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'])){
				$filter2 = $_SESSION[$this -> prefix.'filter2'];
				if($filter2){
					$where .= " AND cat_id LIKE '%,".$filter2.",%' ";
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter3'])){
				$filter3 = $_SESSION[$this -> prefix.'filter3'];
				if($filter3){
					$where .= ' AND status = '.$filter3.'';
				}
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$key = $_SESSION[$this -> prefix.'keysearch'];
					// $arr_key = explode('*',$key);
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					// $where .= " AND (number LIKE '%".$keysearch."%' OR sim LIKE '%".$keysearch."%' )  ";
					$where .= " AND number LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT id, sim, number, price, created_time, network, status, admin_status, cat_name, agency_name, commission_value, price_public
						  FROM 
						  	".$this -> table_name."
						  	WHERE admin_status = 1 ".
						 $where. " ";
			return $query;
		}

	function getTotal($value='')
		{
			$query = $this->setQuery();
			$query = str_ireplace('id, sim, number, price, created_time, network, status, admin_status, cat_name, agency_name, commission_value, price_public','count(id)',$query);
			if(!$query)
				return ;
			global $db;
			$sql = $db->query($query);
			$total = $db->getResult();
			return $total;
		}

    function delete_es($id){
        require PATH_BASE.'libraries/elasticsearch/vendor/autoload.php';
        $hosts = [
            [
                'host' => 'localhost',          //yourdomain.com
                'port' => '9200',
                'scheme' => 'http',             //https
                //        'path' => '/elastic',
                //        'user' => 'username',         //n???u ES c???n user/pass
                //        'pass' => 'password!#$?*abc'
            ],

        ];
        $client = ClientBuilder::create()->setHosts($hosts)->build();

        // x??a d??? li???u theo query elasticsearch
        $updateRequest = [
            'index'     => 'fs',
            'type'      => 'simsodep',
            'conflicts' => 'abort',
            'body' => [
                'query' => [
                    'term' => [
                        'agency' => "$id"
                    ]
                ]
            ]
        ];

        $results = $client->deleteByQuery($updateRequest);

//        echo '<pre>',print_r($results,1),'</pre>';die;
    }

	function upload_csv($input_name){
		define ( 'DEC_10', 10 ); //d??nh cho t??nh t???ng n??t sim
        global $db;
		$fileName = $_FILES[$input_name]['tmp_name'];

		if ($_FILES[$input_name]['size'] > 0) {

			//	x??a sim ?????i l?? kh???i ES n???u import th??nh c??ng
        
	        $file = fopen($fileName, 'r');

	        $agency_id = FSInput::get('agency',0,'int');
			$agency_id = $_SESSION['ad_type']==2 ? $_SESSION['ad_userid'] : $agency_id;
			if (!$agency_id) {
				$link = 'index.php?module=sim&view=sim&task=add';
				setRedirect($link,'B???n c???n ch???n ?????i l?? tr?????c khi ????ng sim');
			}

			// x??a xim trong ?????i l?? khi ????ng sim
            // $this->delete_es($agency_id);

			$agency = $this->get_record('id ='.$agency_id,'fs_users','full_name,access');
			$agency_name = $agency->full_name;

			$admin_status = $_SESSION['ad_access']?$_SESSION['ad_access']:0;

            $time = date('Y-m-d H:i:s');

			 $sql = 'TRUNCATE TABLE fs_sim_'.$agency_id.';';
			// $db->query($sql);
			// $result = $db->affected_rows();

			$sql .= 'UPDATE fs_users SET last_update = "'.$time.'" WHERE id = '.$agency_id.';';
			$db->query($sql);
			$db->affected_rows();
			
			$sql = 'INSERT INTO fs_sim_'.$agency_id.' (sim, number, price, agency, agency_name, created_time, type, price_old, point, button , admin_status, cat_name ) VALUES ';
			// $column = fgetcsv($file);
			$line = 1;

			// ??i???u ki???n sim n??m sinh
			$year5x = array('1950');
			$year6x = array('1960');
			$year7x = array('1970');
			$year8x = array('1980');
			$year9x = array('1990');
			$year10x = array('2000');
			$year11x = array('2010');
			for ($x = 1951; $x < 1960; $x++) {
				array_push($year5x, $x);
			}
			for ($x = 1961; $x < 1970; $x++) {
				array_push($year6x, $x);
			}
			for ($x = 1971; $x < 1980; $x++) {
				array_push($year7x, $x);
			}
			for ($x = 1981; $x < 1990; $x++) {
				array_push($year8x, $x);
			}
			for ($x = 1991; $x < 2000; $x++) {
				array_push($year9x, $x);
			}
			for ($x = 2001; $x < 2010; $x++) {
				array_push($year10x, $x);
			}
			for ($x = 2011; $x < 2020; $x++) {
				array_push($year11x, $x);
			}

	        while (($column = fgetcsv($file, 10000, ',')) !== FALSE) {
	        	// if ($line == 1) {
	        	// 	$line++;
	        	// 	continue;
	        	// }
	        	// var_dump($column);die;

	        	// X??? l?? s??? sim hi???n th???
	        	$outcome = $column[0];
	        	// lo???i b??? c??c k?? t??? tr??? s??? v?? c??c d???u ch??? ?????nh
	        	// $outcome = preg_replace("/[^0-9._, ]/", "", $outcome);
	        	$outcome = preg_replace('/[^0-9. ]/', '', $outcome);
	        	// chuy???n c??c k?? t??? tr??ng l???p v??? d???u .
				// $outcome = preg_replace('/\,{1,}/', '.', $outcome);
				// $outcome = preg_replace('/\_{1,}/', '.', $outcome);
				$outcome = preg_replace('/\ {1,}/', '.', $outcome);
				$outcome = preg_replace('/\.{1,}/', '.', $outcome);

				$outcome = trim($outcome,".");

				// c???p nh???t s??? sim ???n
				$outnum = $column[0];
				$outnum = preg_replace('/[^0-9]/', '', $outnum);
               // var_dump($outnum);die;
				// t???ng ??i???m v?? t???ng n??t
				// $point = $outnum;

               // th??m s??? 0 n???u ch??a c??
				if (strlen($outnum) == 9) {
					$outnum = '0'.$outnum;
					$outcome = '0'.$outcome;
				}

				// chuy???n ?????i s??? 84
				if (substr($outcome,0,2) == 84) {
					$outcome = ltrim($outcome,'84');
					$outcome = '0'.$outcome;
				}

				// Lo???i n???u sim c?? 11 s???
				if (strlen($outnum) > 10) {
					continue;
				}

				$point = $this->totalDigitsOfNumber($outnum);

				$button = ($point%100)%10;

				// X??? l?? gi??
				$price = preg_replace('/[., ]/', '', $column[1]);
				$price = $price ? $price:0;

				$price_old = preg_replace('/[., ]/', '', $column[2]);
				$price_old = $price_old ? $price_old:0;

				$type = $column[3] ? $column[3]:0;

				// var_dump($column);
				// var_dump($button);
				// var_dump($point);die;

				// x??? l?? th??? lo???i
				$cat = $this->sim($outnum,$price,$year5x,$year6x,$year7x,$year8x,$year9x,$year10x,$year11x);
				// $cat = '';

				// var_dump($price_old);die;

	            $sql .='("' . $outcome . '","' . $outnum . '","'. $price .'", "'.$agency_id.'", "'.$agency_name.'", "'.$time.'", "'.$type.'", "'.$price_old.'", "'.$point.'", "'.$button.'", "'.$admin_status.'", "'.$cat.'") ,';

	        }

        	$sql = rtrim($sql,',');
        	// var_dump($sql);die;
            $db->query($sql);
			$result = $db->affected_rows();

			// c???p nh???t l???ch s???
			$sql = 'INSERT INTO fs_log (created_time, agency, agnecy_name, user, user_name, title)
						VALUES ("'.$time.'", "'.$agency_id.'", "'.$agency_name.'", "'.$_SESSION['ad_userid'].'", "'.$_SESSION['ad_full_name'].'","Import th??nh c??ng '.$result.' sim v??o ?????i l?? : '.$agency_name.'");';

			$db->query($sql);
			$db->affected_rows();

			$link = 'index.php?module='.$this -> module.'&view=sim&task=add';
			setRedirect($link,'C?? '.$result.' sim ???????c b??? sung v??o '.$agency_name.' ! Tr?????ng h???p c?? sim tr??ng v???i c??c ?????i l?? kh??c, ch??ng t??i s??? hi???n th??? sim c?? gi?? th???p nh???t.');

	    }

	}

	function  sim($sim = '',$price = '',$year5x,$year6x,$year7x,$year8x,$year9x,$year10x,$year11x){
		if (!$sim) {
			return;
		}

		$first4 = substr($sim,0,4);


		// check l???c qu??
		$sort_sim = substr ( $sim, - 6 );
		$arr_lucquy = array('000000','111111','222222','333333','444444','555555','666666','777777','888888','999999');
		if (in_array($sort_sim, $arr_lucquy)){
			$type = 'Sim l???c qu??';
			if ($first4 == '0903' || $first4 == '0913' || $first4 == '0983') {
				$type .= ',Sim ?????u s??? c???';
			}
			return $type;
		}	
		// check ng?? qu??
		$sort_sim = substr ( $sim, - 5 );
		$arr_nguquy = array('00000','11111','22222','33333','44444','55555','66666','77777','88888','99999');
		if (in_array($sort_sim, $arr_nguquy)){
			$type = 'Sim ng?? qu??';
			if ($first4 == '0903' || $first4 == '0913' || $first4 == '0983') {
				$type .= ',Sim ?????u s??? c???';
			}
			return $type;
		}

		// check t??? qu??
		$sort_sim = substr ( $sim, - 4 );

		if ($sort_sim == '0000') {
			$type = 'Sim t??? qu??,Sim t??? qu?? 0000';
		}
		if ($sort_sim == '1111') {
			$type = 'Sim t??? qu??,Sim t??? qu?? 1111';
		}
		if ($sort_sim == '2222') {
			$type = 'Sim t??? qu??,Sim t??? qu?? 2222';
		}
		if ($sort_sim == '3333') {
			$type = 'Sim t??? qu??,Sim t??? qu?? 3333';
		}
		if ($sort_sim == '4444') {
			$type = 'Sim t??? qu??,Sim t??? qu?? 4444';
		}
		if ($sort_sim == '5555') {
			$type = 'Sim t??? qu??,Sim t??? qu?? 5555';
		}
		if ($sort_sim == '6666') {
			$type = 'Sim t??? qu??,Sim t??? qu?? 6666';
		}
		if ($sort_sim == '7777') {
			$type = 'Sim t??? qu??,Sim t??? qu?? 7777';
		}
		if ($sort_sim == '8888') {
			$type = 'Sim t??? qu??,Sim t??? qu?? 8888';
		}		
		if ($sort_sim == '9999') {
			$type = 'Sim t??? qu??,Sim t??? qu?? 9999';
		}

		if ($type) {
			if ($first4 == '0903' || $first4 == '0913' || $first4 == '0983') {
				$type .= ',Sim ?????u s??? c???';
			}
			return $type;
		}

		$locate82 = substr($sim,8,2);
		$locate62 = substr($sim,6,2);
		$locate42 = substr($sim,4,2);

		// check taxi 2
		if ($locate82 == $locate62 && $locate62 == $locate42) {
			$type = 'Sim taxi 2';
			if ($first4 == '0903' || $first4 == '0913' || $first4 == '0983') {
				$type .= ',Sim ?????u s??? c???';
			}
			return $type;
		}

		$locate73 = substr($sim,7,3);
		$locate43 = substr($sim,4,3);
		$locate91 = substr($sim,9,1);
		$locate71 = substr($sim,7,1);

		// check taxi 3
		if ($locate73 == $locate43 && $locate91 == $locate71) {
			$type = 'Sim taxi 3,Sim taxi ABA.ABA';
			if ($first4 == '0903' || $first4 == '0913' || $first4 == '0983') {
				$type .= ',Sim ?????u s??? c???';
			}
			return $type;
		}
		$locate81 = substr($sim,8,1);
		if ($locate73 == $locate43 && $locate71 == $locate81) {
			$type = 'Sim taxi 3,Sim taxi AAB.AAB';
			if ($first4 == '0903' || $first4 == '0913' || $first4 == '0983') {
				$type .= ',Sim ?????u s??? c???';
			}
			/// check n??m sinh
			if (in_array($locate64, $year9x)){
				$type .= ',Sim n??m sinh,Sim n??m sinh 199x';
			}	
			// check ng??y th??ng n??m sinh
			if (($locate82 < 20 || $locate82 > 49) && $locate62 < 13 && $locate62 > 0 && $locate42 < 32 && $locate42 > 0) {
				$type .= ',N??m sinh DD/MM/YY';
			}
			return $type;
		}
		if ($locate73 == $locate43 && $locate81 == $locate91) {
			$type = 'Sim taxi 3,Sim taxi BAA.BAA';
			if ($first4 == '0903' || $first4 == '0913' || $first4 == '0983') {
				$type .= ',Sim ?????u s??? c???';
			}
			return $type;
		}
		$locate64 = substr($sim,6,4);
		if ($locate73 == $locate43) {
			$type = 'Sim taxi 3,Sim taxi ABC.ABC';
			if ($first4 == '0903' || $first4 == '0913' || $first4 == '0983') {
				$type .= ',Sim ?????u s??? c???';
			}
			// check n??m sinh
			if (in_array($locate64, $year5x)){
				$type .= ',Sim n??m sinh,Sim n??m sinh 195x';
			}	
			if (in_array($locate64, $year6x)){
				$type .= ',Sim n??m sinh,Sim n??m sinh 196x';
			}	
			if (in_array($locate64, $year7x)){
				$type .= ',Sim n??m sinh,Sim n??m sinh 197x';
			}	
			if (in_array($locate64, $year8x)){
				$type .= ',Sim n??m sinh,Sim n??m sinh 198x';
			}		
			if (in_array($locate64, $year10x)){
				$type .= ',Sim n??m sinh,Sim n??m sinh 200x';
			}	
			if (in_array($locate64, $year11x)){
				$type .= ',Sim n??m sinh,Sim n??m sinh 201x';
			}
			// check ng??y th??ng n??m sinh
			if (($locate82 < 20 || $locate82 > 49) && $locate62 < 13 && $locate62 > 0 && $locate42 < 32 && $locate42 > 0) {
				$type .= ',N??m sinh DD/MM/YY';
			}
			return $type;
		}

		$type = '';

		$locate43 = substr($sim,4,3);
		$locate73 = substr($sim,7,3);

		// check tam hoa k??p
		$sort_sim = $locate43;
		$sort_sim2 = $locate73;
		$arr_tamhoa = array('000','111','222','333','444','555','666','777','888','999');
		if (in_array($sort_sim, $arr_tamhoa) && in_array($sort_sim2, $arr_tamhoa)){
			$type = 'Sim tam hoa k??p';
			if ($first4 == '0903' || $first4 == '0913' || $first4 == '0983') {
				$type .= ',Sim ?????u s??? c???';
			}
			// check n??m sinh	
			if (in_array($locate64, $year10x)){
				$type .= ',Sim n??m sinh,Sim n??m sinh 200x';
			}	
			return $type;
		}

		// check taxi 4
		$locate61 = substr($sim,6,1);
		$locate24 = substr($sim,2,4);
		if ($locate64 == $locate24 && $locate91 == $locate81 && $locate81 == $locate71 && $locate71 != $locate61) {
			$type .= 'Sim taxi 4,Sim taxi ABBB.ABBB';
		}
		if ($locate64 == $locate24 && $locate91 != $locate81 && $locate81 == $locate71 && $locate71 == $locate61) {
			$type .= 'Sim taxi 4,Sim taxi AAAB.AAAB';
		}
		if ($locate64 == $locate24 && $locate91 == $locate61 && $locate71 == $locate81 && $locate71 != $locate61) {
			$type .= 'Sim taxi 4,Sim taxi ABBA.ABBA';
		}
		if ($locate64 == $locate24 && $locate91 == $locate81 && $locate81 != $locate71 && $locate71 == $locate61) {
			$type .= 'Sim taxi 4,Sim taxi AABB.AABB';
		}
		if ($locate64 == $locate24 && $locate91 != $locate81 && $locate81 != $locate71 && $locate71 != $locate61 && $locate91 != $locate61 && $locate81 != $locate61 && $locate91 != $locate71) {
			$type .= 'Sim taxi 4,Sim taxi ABCD.ABCD';
		}
		if ( $locate64 == $locate24 && strpos($type, 'Sim taxi 4') === false) {
			$type .= 'Sim taxi 4,Sim taxi 4 kh??c';
		}


		//check tam hoa
		if ($locate73 == '000') {
			$type .= ',Sim tam hoa,Sim tam hoa 000';
		}
		if ($locate73 == '111') {
			$type .= ',Sim tam hoa,Sim tam hoa 111';
		}
		if ($locate73 == '222') {
			$type .= ',Sim tam hoa,Sim tam hoa 222';
		}
		if ($locate73 == '333') {
			$type .= ',Sim tam hoa,Sim tam hoa 333';
		}
		if ($locate73 == '444') {
			$type .= ',Sim tam hoa,Sim tam hoa 444';
		}
		if ($locate73 == '555') {
			$type .= ',Sim tam hoa,Sim tam hoa 555';
		}
		if ($locate73 == '666') {
			$type .= ',Sim tam hoa,Sim tam hoa 666';
		}
		if ($locate73 == '777') {
			$type .= ',Sim tam hoa,Sim tam hoa 777';
		}
		if ($locate73 == '888') {
			$type .= ',Sim tam hoa,Sim tam hoa 888';
		}
		if ($locate73 == '999') {
			$type .= ',Sim tam hoa,Sim tam hoa 999';
		}

		$locate51 = substr($sim,5,1);
		$locate41 = substr($sim,4,1);

		// check ti???n ????n
		if (($locate91 - $locate81 == 2) && ($locate81 - $locate71 == 2) && ($locate71 - $locate61 == 2)) {
			$type .= ',Sim ti???n ????n,Sim ti???n ????n ?????c bi???t';
		}
		if (($locate91 - $locate81 == 1) && ($locate81 - $locate71 == 1) && ($locate71 - $locate61 == 1) && ($locate61 - $locate51 == 1) && ($locate51 - $locate41 == 1)) {
			$type .= ',Sim ti???n ????n,Sim ti???n ????n 6';
		}	
		if (($locate91 - $locate81 == 1) && ($locate81 - $locate71 == 1) && ($locate71 - $locate61 == 1) && ($locate61 - $locate51 == 1) && ($locate51 - $locate41 != 1 || $locate41 > $locate51)) {
			$type .= ',Sim ti???n ????n,Sim ti???n ????n 5';
		}	
		if (($locate91 - $locate81 == 1) && ($locate81 - $locate71 == 1) && ($locate71 - $locate61 == 1) && ($locate61 - $locate51 != 1 || $locate51 > $locate61)) {
			$type .= ',Sim ti???n ????n,Sim ti???n ????n 4';
		}	
		if (($locate91 - $locate81 == 1) && ($locate81 - $locate71 == 1) && ($locate71 - $locate61 != 1 || $locate61 > $locate71)) {
			$type .= ',Sim ti???n ????n,Sim ti???n ????n 3';
		}	
		if ( (strpos($type, 'ti???n') == false) && ($locate91 > $locate81) && ($locate81 > $locate71) && ($locate71 > $locate61) ) {
			$type .= ',Sim ti???n ????n,Sim ti???n ????n kh??c';
		}

		// check s??? l???p
		if ($locate82 == $locate62 && $locate62 != $locate42) {
			$type .= ',Sim s??? l???p';
		}

		// check s??? k??p
		if ($locate91 == $locate81 && $locate61 == $locate71 && $locate61 == $locate51 && $locate41 == $locate51) {
			$type .= ',Sim s??? k??p,Sim s??? k??p AAAA.BB';
		}
		if ($locate82 == $locate42 && $locate91 == $locate81 && $locate81 == $locate51 && $locate61 == $locate71) {
			$type .= ',Sim s??? k??p,Sim s??? k??p AA.BB.AA';
		}	
		if ($locate91 == $locate81 && $locate61 == $locate71 && $locate41 == $locate51 && $locate91 != $locate41 && $locate91 != $locate71 && $locate41 != $locate71) {
			$type .= ',Sim s??? k??p,Sim s??? k??p AA.BB.CC';
		}	
		if ($locate91 == $locate81 && $locate61 == $locate71 && $locate41 != $locate51) {
			$type .= ',Sim s??? k??p,Sim s??? k??p AA.BB';
		}

		// check n??m sinh
		if (in_array($locate64, $year5x)){
			$type .= ',Sim n??m sinh,Sim n??m sinh 195x';
		}	
		if (in_array($locate64, $year6x)){
			$type .= ',Sim n??m sinh,Sim n??m sinh 196x';
		}	
		if (in_array($locate64, $year7x)){
			$type .= ',Sim n??m sinh,Sim n??m sinh 197x';
		}	
		if (in_array($locate64, $year8x)){
			$type .= ',Sim n??m sinh,Sim n??m sinh 198x';
		}	
		if (in_array($locate64, $year9x)){
			$type .= ',Sim n??m sinh,Sim n??m sinh 199x';
		}	
		if (in_array($locate64, $year10x)){
			$type .= ',Sim n??m sinh,Sim n??m sinh 200x';
		}	
		if (in_array($locate64, $year11x)){
			$type .= ',Sim n??m sinh,Sim n??m sinh 201x';
		}

		// check l???c qu?? gi???a
	 	if (strpos($sim,'000000') == TRUE || strpos($sim,'111111') == TRUE || strpos($sim,'222222') == TRUE || strpos($sim,'333333') == TRUE || strpos($sim,'444444') == TRUE || strpos($sim,'555555') == TRUE || strpos($sim,'666666') == TRUE || strpos($sim,'777777') == TRUE || strpos($sim,'888888') == TRUE || strpos($sim,'999999') == TRUE) {
			$type .= ',Sim l???c qu?? gi???a';
		}
		// check ng?? qu?? gi???a
	 	if ((strpos($type, 'l???c') == false) && (strpos($sim,'00000') == TRUE || strpos($sim,'11111') == TRUE || strpos($sim,'22222') == TRUE || strpos($sim,'33333') == TRUE || strpos($sim,'44444') == TRUE || strpos($sim,'55555') == TRUE || strpos($sim,'66666') == TRUE || strpos($sim,'77777') == TRUE || strpos($sim,'88888') == TRUE || strpos($sim,'99999') == TRUE)) {
			$type .= ',Sim ng?? qu?? gi???a';
		}	
		// check t??? qu?? gi???a
	 	if ( (strpos($type, 'l???c') == false) && (strpos($type, 'ng??') == false) && (strpos($sim,'0000') == TRUE || strpos($sim,'1111') == TRUE || strpos($sim,'2222') == TRUE || strpos($sim,'3333') == TRUE || strpos($sim,'4444') == TRUE || strpos($sim,'5555') == TRUE || strpos($sim,'6666') == TRUE || strpos($sim,'7777') == TRUE || strpos($sim,'8888') == TRUE || strpos($sim,'9999') == TRUE)) {
			$type .= ',Sim t??? qu?? gi???a';
		}

		$locate21 = substr($sim,2,1);
		$locate31 = substr($sim,3,1);

		//check g??nh ?????o
		if ($locate64 != $locate24 && ($locate91 == $locate61 && $locate81 == $locate71 && $locate21 == $locate51 && $locate31 == $locate41)) {
			$type .= ',Sim g??nh ?????o,Sim g??nh ?????o k??p';
		}
		if ($locate91 == $locate61 && $locate81 == $locate71 && ($locate21 != $locate51 || $locate31 != $locate41) ) {
			$type .= ',Sim g??nh ?????o,Sim g??nh ?????o ????n';
		}

		// check ti???n k??p
		if ((strpos($type, 'k??p') == false) && ($locate91 > $locate61 && $locate91 == $locate81 && $locate61 == $locate51 && $locate71 == $locate41 && $locate71 != $locate81 && $locate71 != $locate61)) {
			$type .= ',Sim ti???n k??p,Sim ti???n k??p ABB.ACC';
		}
		if ((strpos($type, 'k??p') == false) && ($locate91 == $locate61 && $locate81 == $locate71 && $locate51 == $locate41 && $locate81 > $locate51)) {
			$type .= ',Sim ti???n k??p,Sim ti???n k??p AAC.BBC';
		}
		if ((strpos($type, 'k??p') == false) && ($locate91 == $locate81 && $locate61 == $locate51 && $locate81 > $locate51 && $locate71 > $locate41)) {
			$type .= ',Sim ti???n k??p,Sim ti???n k??p kh??c';
		}

		// check soi g????ng
		if ($locate91 == $locate41 && $locate91 != $locate81 && $locate81 == $locate51 && $locate61 == $locate71) {
			$type .= ',Sim soi g????ng';
		}

		// check ti???n ba
		if ($locate64 != $locate24 && substr($sim,7,2) == $locate42 && $locate41 == $locate51 && $locate91 > $locate61) {
			$type .= ',Sim ti???n ba,Sim ti???n ba AAB.AAC';
		}
	 	if ($locate64 != $locate24 && $locate82 == substr($sim,5,2) && $locate61 != $locate51 && $locate71 > $locate41) {
			$type .= ',Sim ti???n ba,Sim ti???n ba CAB.DAB';
		} 	
		if ($locate64 != $locate24 && substr($sim,7,2) == $locate42 && $locate41 != $locate51 && $locate91 > $locate61) {
			$type .= ',Sim ti???n ba,Sim ti???n ba ABC.ABD';
		}
		if (strpos($type, 'g??nh') == false && $locate64 != $locate24 && $locate41 != $locate61 && $locate91 == $locate61 && $locate41 == $locate71 && $locate81 > $locate51) {
			$type .= ',Sim ti???n ba,Sim ti???n ba ACB.ADB';
		}
		if ($locate64 != $locate24 && $locate82 == substr($sim,5,2) && $locate61 == $locate51 && $locate71 > $locate41) {
			$type .= ',Sim ti???n ba,Sim ti???n ba ACC.BCC';
		}

		// check ti???n ????i
		if (((($locate91 - $locate71 == 1 ) && ($locate71 - $locate51 == 1 ) && $locate81 == $locate61 && $locate61 == $locate41) || (($locate81 - $locate61 == 1 ) && ($locate61 - $locate41 == 1 ) && $locate91 == $locate71 && $locate71 == $locate51)) ) {
			$type .= ',Sim ti???n ????i,Sim ti???n 3 ????i cu???i';
		}
		if ( ($locate64 != '8386') && (strpos($type, 'tam hoa') == false) && (strpos($type, 'ti???n') == false) && (strpos($type, 'gi???a') == false) && $locate64 != $locate24 && ( ($locate91 == $locate71 && $locate71 == $locate51 && ($locate81 - $locate61 > 0 ) && ($locate61 - $locate41 > 0 ) ) || ($locate81 == $locate61 && $locate61 == $locate41 && ($locate91 - $locate71 > 0 ) && ($locate71 - $locate51 > 0 )) )) {
			$type .= ',Sim ti???n ????i,Sim ti???n ????i kh??c';
		}
		if ($locate64 != $locate24&& (strpos($type, 'ti???n') == false) && ( (($locate91 - $locate71 == 1 ) && $locate61 != $locate71 && $locate81 == $locate61 && ($locate71 - $locate51 != 1 || $locate41 != $locate61)) || (($locate81 - $locate61 == 1 ) && $locate81 != $locate71 && ($locate61 - $locate41 != 1 || $locate51 != $locate71 ) && $locate91 == $locate71) ) ) {
			$type .= ',Sim ti???n ????i,Sim ti???n 2 ????i cu???i';
		}

		// check s??? g??nh
		if ( (strpos($type, 'ti???n') == false) && $locate62 != $locate82 && $locate91 == $locate71 && $locate71 != $locate61 && $locate61 == $locate41 && $locate91 != $locate81 && $locate81 == $locate51) {
			$type .= ',Sim s??? g??nh,Sim s??? g??nh ACA.BCB';
		}
		if ( (strpos($type, 'ti???n') == false) && $locate91 == $locate71 && $locate71 == $locate61 && $locate61 == $locate41 && $locate91 != $locate81 && $locate81 != $locate51) {
			$type .= ',Sim s??? g??nh,Sim s??? g??nh ABA.ACA';
		}
	 	if ( (strpos($type, 'ti???n') == false) && $locate91 == $locate71 && $locate41 == $locate61 && $locate71 != $locate81 && $locate81 != $locate51 && $locate61 != $locate71) {
			$type .= ',Sim s??? g??nh,Sim s??? g??nh ABA.CDC';
		}
		if ( (strpos($type, 'ti???n') == false) && $locate64 != $locate24 && $locate91 == $locate71 && $locate41 != $locate61 && $locate61 != $locate81 && $locate91 != $locate81) {
			$type .= ',Sim s??? g??nh,Sim s??? g??nh ABA';
		}


		// check ?????c bi??t
		if ($locate64 == '1102') {
			$type .= ',Sim ?????c bi???t,Nh???t nh???t kh??ng nh??';
		}
		if ($locate64 == '1368') {
			$type .= ',Sim ?????c bi???t,Sinh t??i l???c ph??t';
		}
		if ($locate64 == '4078') {
			$type .= ',Sim ?????c bi???t,B???n m??a kh??ng th???t b??t';
		}
		if ($locate64 == '8386') {
			$type .= ',Sim ?????c bi???t,Ph??t t??i ph??t l???c';
		}
		if ($locate64 == '8683') {
			$type .= ',Sim ?????c bi???t,Ph??t l???c ph??t t??i';
		}
		if ($locate64 == '8910') {
			$type .= ',Sim ?????c bi???t,Cao h??n ng?????i';
		}
		$locate46 = substr($sim,4,6);
		if ($locate46 == '151618') {
			$type .= ',Sim ?????c bi???t,M???i n??m m???i l???c m???i ph??t';
		}	
		if ($locate46 == '049053') {
			$type .= ',Sim ?????c bi???t,Kh??ng g???p h???n';
		}

		// check ng??y th??ng n??m sinh
		if (($locate82 < 20 || $locate82 > 49) && $locate62 < 13 && $locate62 > 0 && $locate42 < 32 && $locate42 > 0) {
			$type .= ',N??m sinh DD/MM/YY';
		}

		// check l???c ph??t
		if ($locate82 == 68 || $locate82 == 86){
			$type .= ',Sim l???c ph??t';
		}

		// check th???n t??i
		if ($locate82 == 39 || $locate82 == 79) {
			$type .= ',Sim th???n t??i';
		}

		// check ??ng ?????a
		if ($locate82 == 38 || $locate82 == 78) {
			$type .= ',Sim ??ng ?????a';
		}

		// check ti???n gi???a
		if ( ((($locate71 - $locate61 == 1) && ($locate61 - $locate51 == 1) && ($locate51 - $locate41 == 1)) || (($locate61 - $locate51 == 1) && ($locate51 - $locate41 == 1) && ($locate41 - $locate31 == 1) ) || (($locate51 - $locate41 == 1) && ($locate41 - $locate31 == 1) && ($locate31 - $locate21 == 1) )) && ($locate91 - $locate81 != 1) ) {
			$type .= ',Sim ti???n gi???a';
		}

		// check ?????u s??? c???
		if ($first4 == '0903' || $first4 == '0913' || $first4 == '0983') {
			$type .= ',Sim ?????u s??? c???';
		}

		// check gi?? r???
		if($price < 500000){
			$type .= ',Sim gi?? r???';
		}

		if ($type == '') {
			$type .= ',Sim d??? nh???';
		}

		$type = trim( $type, ',');

		return $type;
	}

	function totalDigitsOfNumber($n) {
	    $total = 0;
	    do {
	        $total = $total + ($n % DEC_10);
	        $n = floor ( $n / DEC_10 );
	    } while ( $n > 0 );
	    return $total;
	}


	function save($row = array(), $use_mysql_real_escape_string = 1){
		$input_type = FSInput::get('type',0,'int');
		if($input_type == 2){  // excel
			// $count_sim_suc = $this -> upload_excel('excel');
			$count_sim_suc = $this -> upload_csv('excel');
				return $count_sim_suc;
		}else{
			$sims = FSInput::get('sims');
			if(!$sims)
				return false;

	        $agency_id = FSInput::get('agency',0,'int');
			$agency_id = @$_SESSION['ad_type']==2 ? $_SESSION['ad_userid'] : $agency_id;
			if (!$agency_id) {
				$link = 'index.php?module=sim&view=sim&task=add';
				setRedirect($link,'B???n c???n ch???n ?????i l?? tr?????c khi ????ng sim');
			}
			
			$list_sim = explode(PHP_EOL,$sims);
				
			$array_sim = array();
			foreach($list_sim as $item){
				if(!$item || !trim($item))
					continue;
				$item =  preg_replace('!\s+!', ' ', trim($item));
				$array_sim_info = explode(' ',$item);
				if(count($array_sim_info) < 2)
					continue;
				$str_sim_number = '';
				$c = 0;
				$k = 0;
				$sim_to_int = filter_var($item, FILTER_SANITIZE_NUMBER_INT);
				$length_sim = 11; // ki???u sim 10 hay 11 s???
				if(strpos($sim_to_int,'09') === 0){
					$length_sim = 10;
				}
				foreach($array_sim_info as $str_sim){
					$b = filter_var($str_sim, FILTER_SANITIZE_NUMBER_INT);
					if(!$c){
						if($b[0] != 0){
							$b = '0'.$b;
							$str_sim = '0'.$str_sim;
						}
					}
					$c += strlen($b);
					if($c > $length_sim){
						$sim_number = $str_sim_number;
						break;
					}else{
						if($str_sim_number)
							$str_sim_number .= ' '.$str_sim;
						else 
							$str_sim_number .= $str_sim;
						$k ++;	
					}
				}
				$sim_price = 	$array_sim_info[$k];
				$array_sim[] = array('sim'=>$sim_number,'price'=>$sim_price);
			}
		}

		var_dump($array_sim);die;
		
		$time = date('Y-m-d H:i:s');
			
		// C??c sim ???? x??? l??
		$array_sim_executed = array();
		$count_sim_suc = 0;
		$arr_buff_sims = array();
		$total_sims = count($array_sim);
		$i = 0;
		foreach($array_sim as $item){
			$i ++;
			$sim_number = 	$item['sim'];
			$sim_price = 	$item['price'];
			if(!$sim_number){
				Errors::setError ( $sim_number. ' b??? l???i ' );
				continue;
			}
					
			$row = array();
			$row['sim'] = $sim_number;

			$sim_number = $this -> convert_to_number($sim_number);
			// $unit_price = FSInput::get('unit_price');
			$price = $this -> standart_money($sim_price);
	
			$array_sim_executed[] = $sim_number;

			$row['number'] = $sim_number;

			// ?????i l??

		 	if(isset($_SESSION['ad_type']) && $_SESSION['ad_type']==2){
    			$row ['agency'] = $_SESSION['ad_userid'];
				$row ['agency_name'] = $_SESSION['ad_full_name'];
		    }else{
				$agency_id = FSInput::get('agency',0,'int');
				if($agency_id){
					$agency = $this->get_record_by_id($agency_id,'fs_users');
					$row ['agency'] = $agency->id;
					$row ['agency_name'] = $agency->full_name;
				}
		    }


			$row['price'] = $price;
			$row['created_time'] = $time;
			$row['edited_time'] = $time;

			// $row['unit_price'] = $unit_price;
			$row['public_time'] = FSInput::get('public_time');
			$row['status'] = 0;
			$row['admin_status'] = 0;
			
			// var_dump($row);die;
			// ki???m tra tr??ng l???p v???i db
			$arr_buff_sims[] = $row;
			if($count_sim_suc % 500 == 0 || $i == $total_sims){
				$rs = $this -> _add_multi($arr_buff_sims, 'fs_sim');
				$arr_buff_sims = array();
			}
			$count_sim_suc ++;
		}

		$link = 'index.php?module='.$this -> module.'&view=wait';
		setRedirect($link,'C?? '.$count_sim_suc.' sim ???????c b??? sung! Tr?????ng h???p c?? sim tr??ng v???i c??c ?????i l?? kh??c, ch??ng t??i s??? hi???n th??? sim c?? gi?? th???p nh???t.');
	}

	function upload_excel($input_name){


		$fsFile = FSFactory::getClass('FsFiles');
		// upload
		$path =  PATH_BASE.'images'.DS.'excel'.DS;
		$excel = $fsFile -> uploadExcel($input_name, $path,20000000000, '_'.time());
		
		if(	!$excel){
			return false;
		}
		else{

			$file_path = $path.$excel;
	        require(PATH_BASE.'libraries/PHPExcel/PHPExcel.php');
	        $objPHPExcel = PHPExcel_IOFactory::load($file_path);
	        $objPHPExcel->setActiveSheetIndex(0);
	        $sheet = $objPHPExcel->getActiveSheet();
	        $numberRow = $sheet->getHighestRow();
	        $count_sim_upaload = 0;

            $agency_id = FSInput::get('agency',0,'int');
			$agency_id = @$_SESSION['ad_type']==2 ? $_SESSION['ad_userid'] : $agency_id;
            $time = date('Y-m-d H:i:s');

	        $sql = 'INSERT INTO fs_sim_'.$agency_id.' (sim, price, agency, created_time) VALUES ';

	        for($row = 2; $row <= $numberRow; $row++){
	            $data = array(
	                'sim' => $sheet->getCell('A'.$row)->getValue(),
	                'price' => '0'.ltrim($sheet->getCell('B'.$row)->getValue(), '0'),
	            );

                $sql .='("'.$data['sim'].'", "'.$data['price'].'", "'.$agency_id.'", "'.$time.'")';
                if ($row<$numberRow) {
                	$sql .=',';
                }

				$count_sim_upaload++;
	        }
            // var_dump($sql);die;
            global $db;
            $db->query($sql);
			$row = $db->affected_rows();

			$link = 'index.php?module='.$this -> module.'&view=wait';
			setRedirect($link,'C?? '.$count_sim_upaload.' sim ???????c b??? sung! Tr?????ng h???p c?? sim tr??ng v???i c??c ?????i l?? kh??c, ch??ng t??i s??? hi???n th??? sim c?? gi?? th???p nh???t.');
		}
	}

	function get_cell_content($data,$sheet_index,$row_index,$col_index){
		$content = isset($data->sheets[$sheet_index]['cells'][$row_index][$col_index])?$data->sheets[$sheet_index]['cells'][$row_index][$col_index]:'';
		return $content;
	}

	function convert_exel($info_import_product,$agency) {
		$sim_input_exel = $info_import_product;
		
		$time = date('Y-m-d H:i:s');
		
		// C??c sim ???? x??? l??
		$array_sim_executed = array();
		$arr_buff_sims = array();
	
		if($sim_input_exel){
			
			$sim_number = 	$sim_input_exel['sim'];
			$sim_price = 	$sim_input_exel['price'];

			$row = array();
			$row['sim'] = $sim_number;

			// $sim_number = $this -> convert_to_number($sim_number);
			
			// $sim_price = $this -> standart_money($sim_price);
				
			// $row['number'] = $sim_number;

			$agency_id = FSInput::get('agency',0,'int');
			$row ['agency'] = @$_SESSION['ad_type']==2 ? $_SESSION['ad_userid'] : $agency_id;

	
			// if(isset($_SESSION['ad_type']) && $_SESSION['ad_type']==2){
   //  			$row ['agency'] = $_SESSION['ad_userid'];
			// 	$row ['agency_name'] = $_SESSION['ad_full_name'];
		 //    }else{
			// 	$agency_id = FSInput::get('agency',0,'int');
			// 	if($agency_id){
			// 		$agency = $this->get_record_by_id($agency_id,'fs_users');
			// 		$row ['agency'] = $agency->id;
			// 		$row ['agency_name'] = $agency->full_name;
			// 	}
		 //    }

			$row['price'] = $sim_price;
			$row['created_time'] = $time;
			// $row['edited_time'] = $time;

			// $row['public_time'] = FSInput::get('public_time');
			// $row['status'] = 0;
			// $row['admin_status'] = 0;

		}
		return $row;
	}

	function convert_to_number($sim_number){
		$sim_number = str_replace(',','' , trim($sim_number));
		$sim_number = str_replace('+84','' , trim($sim_number));
		$sim_number = str_replace(' ','' , $sim_number);
		$sim_number = str_replace('.','' , $sim_number);
		$sim_number = intval($sim_number);
		$sim_number = '0'.$sim_number;
		return $sim_number;
	}

	function standart_money($money){
		$money = str_replace(',','' , trim($money));
		$money = str_replace(' ','' , $money);
		$money = str_replace('.','' , $money);
		$money = (double)($money);

		return $money;
	}
	
	function check_sim($sim_number){
		$sim_number = $this -> convert_to_number($sim_number);
		if(strlen($sim_number) < 10 || strlen($sim_number) > 11 )
			return false;
		return true;
	}

        function get_linked_id()
		{
			$id = FSInput::get('id',0,'int');
			if(!$id)
				return;
			global $db;
			$query = " SELECT *
						FROM  ".$this -> table_link."
						WHERE published = 1
						AND id = $id 
						 ";
			$result = $db->getObject($query);
			
			return $result;
		}
        /*
		 * get List data from table
		 * for create link
		 */
		function get_data_from_table($add_table,$add_field_display,$add_field_value,$add_field_distinct){
			$query = $this -> set_query_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct);
			if(!$query)
				return;
			global $db;
			$sql = $db->query_limit($query,$this->limit_created_link,$this->page);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		function get_total_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct){
			global $db;
			$query = $this -> set_query_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct);

			$total = $db->getTotal($query);
			return $total;
		}
		
		function get_pagination_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct)
		{
			$total = $this->get_total_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct);		
			$pagination = new Pagination($this->limit_created_link,$total,$this->page);
			return $pagination;
		}
        function set_query_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct){
			$query  = '';
			if($add_field_distinct){
				if($add_field_display != $add_field_value){
					echo "Khi ???? ch???n distinct, duy nh???t ch??? x??t m???t tr?????ng. B???n h??y check l???i tr?????ng hi???n th??? v?? tr?????ng d??? li???u";
					return false;
				}
				$query .= ' SELECT DISTINCT '.$add_field_display. ' ';
			} else {
				$query .= ' SELECT '.$add_field_display. ' ,' . $add_field_value.'  ';
			}
			$query .= ' FROM '.$add_table ;
			$query .= '	WHERE published = 1 ';
			return $query;
		}
        
        function get_products_related($product_related){
    		if(!$product_related)
    				return;
    		$query   = ' SELECT id, name,image 
    					FROM '.$this -> table_products.'
    					WHERE id IN (0'.$product_related.'0) 
    					 ORDER BY POSITION(","+id+"," IN "0'.$product_related.'0")
    					';
    		global $db;
    		$sql = $db->query($query);
    		$result = $db->getObjectList();
    		return $result;
    	}
	}
	
?>



