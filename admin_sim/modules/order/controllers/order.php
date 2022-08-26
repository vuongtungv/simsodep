<?php
	class OrderControllersOrder  extends Controllers
	{
		function __construct()
		{
			$this->view = 'order' ; 
			parent::__construct(); 
			$array_status = array( 
                                9 => FSText::_('Mới'),
                                1 => FSText::_('Đang kiểm tra'),
                                2 =>FSText::_('Giao dịch xong'),
                                3 =>FSText::_('Bán rồi đã báo'),
                                4 =>FSText::_('Bán rồi chưa báo'),
                                5 =>FSText::_('Vẫn còn chưa báo'),
                                6 =>FSText::_('Vẫn còn đã báo'),
                                7 =>FSText::_('Không gọi được'),
                                8 =>FSText::_('Hủy'),
                                11 =>FSText::_('Đang giao dịch'),
                                12 =>FSText::_('Khách hàng hẹn'),
                                );
			$this -> arr_status = $array_status;
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$text2 = FSInput::get('text2');
			if($text2){
				$_SESSION[$this -> prefix.'text2'] = $text2;
			}
			
			$model  = $this -> model;
		
			$list = $model->get_data('');
			
			$array_status = $this -> arr_status;
			$array_obj_status = array();
			foreach($array_status as $key => $name){
				$array_obj_status[] = (object)array('id'=>($key),'name'=>$name);
			}

			$new = $model->get_count('status = 9','fs_order');

			$user_cms = $model->get_records('published=1 and type=1 order by full_name asc','fs_users','id,username,full_name');

			$array_obj_member = $model->get_records('published=1 ','fs_position','id,name');
			
			$pagination = $this -> model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
        
		function showStatus($status){
			$arr_status = $this -> arr_status;
			echo @$arr_status[$status];
		}

		function edit()
		{
			$model = $this -> model;
			$array_status = $this -> arr_status;

			$array_obj_status = array();
			foreach($array_status as $key => $name){
				$array_obj_status[] = (object)array('id'=>($key),'name'=>$name);
			}

			$order  = $model -> getOrderById();
			$data = $model -> get_data_order();
			$history = $model -> get_history();
			$history_order = $model -> get_history_order($order->id,$order->recipients_mobilephone);
			$city = $model->get_records('published = 1','fs_cities','id,name');
			$method = $model->get_records('published = 1','fs_typepay','id,title');
			$note = $model -> get_note();

			if (count($history)==1) {
				$model -> seen($order->id,'Đã xem');
				$model -> update_status($order->id,'11');
			}
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}

	    function save_status() {

	        $model = $this->model;

	        $rs = $model->save_status();

	        if ($rs == 0) {
	        	echo 0;
	            return false;
	        }

	        $history = $model -> get_history();
			include 'modules/order/views/order/history.php';
	    }

	    function delete_sim_cart() {

	        $model = $this->model;
	        $id = FSInput::get('id');
	        $item = $model->get_record('id = '.$id,'fs_order_items');
	        $order = $model->get_record('id = '.$item->order_id,'fs_order');

	        $str_id = str_replace($item->product_id,'',$order->products_id);
	        $str_id = str_replace(',,',',',$str_id);
	        $str_id = rtrim($str_id,',');
	        $row['products_id'] = $str_id;

	        $str_sim = str_replace($item->number,'',$order->list_sim);
	        $str_sim = str_replace(';;',';',$str_sim);
	        $str_sim = rtrim($str_sim,';');
	        $row['list_sim'] = $str_sim;


	        $row['total_before'] = $order->total_before - $item->price_public;
	        $row['total_after'] = $order->total_after - $item->price_public;
	        $row['total_end'] = $order->total_end - $item->price_end;

	        $ud = $model->_update($row,'fs_order','id ='.$order->id);
	        // var_dump($ud);die;
	        $rs = $model->_remove('id = '.$id,'fs_order_items');

	        if ($rs == 0) {
	        	echo 0;
	            return false;
	        }

        	$note = 'Đã xóa sim '.$item->number.' khỏi giỏ hàng';
        	$model->seen($order->id,$note);
	        echo format_money($row['total_end']);
	            return true;
	    }
	    
	    function save_comments() {

	        $model = $this->model;
	        $rs = $model->save_comments();

	        if ($rs == 0) {
	        	echo 0;
	            return false;
	        }

	        echo 1;
	            return true;
	    }

	    function save_info() {

	        $model = $this->model;

	        $rs = $model->save_info();

	        if ($rs == 0) {
	        	echo 0;
	            return false;
	        }

	        echo 1;
	            return true;
	    }

		function save_note() {

	        $model = $this->model;

	        $rs = $model->save_note();

	        if ($rs == 0) {
	            return false;
	        }

	        $note = $model -> get_note();
			include 'modules/order/views/order/note.php';

	    }
	    function cno(){
	    	$model = $this->model;
	    	$phone = FSInput::get('phone');
	    	$cno = $model->get_record('number = '.$phone,'fs_cno','id');
	    	if ($cno) {
	    		$link = 'index.php?module=cno&view=cno&task=edit&id='.$cno->id;
	    		setRedirect($link);
	    	}
	    	else{
	    		$rs = $model -> save_cno();
	    		if ($rs) {
	    			$link = 'index.php?module=cno&view=cno&task=edit&id='.$rs;
	    			setRedirect($link);
	    		}
	    		$link = URL_ROOT_ADMIN;
    			setRedirect($link);
	    	}
	    }

	    function cod(){
	    	$model = $this->model;
	    	$phone = FSInput::get('phone');
	    	$cod = $model->get_record('sim = '.$phone,'fs_cod','id');
	    	if ($cod) {
	    		$link = 'index.php?module=cod&view=cod&task=edit&id='.$cod->id;
	    		setRedirect($link);
	    	}
	    	else{
	    		$rs = $model -> save_cod();
	    		if ($rs) {
	    			$link = 'index.php?module=cod&view=cod&task=edit&id='.$rs;
	    			setRedirect($link);
	    		}
	    		$link = URL_ROOT_ADMIN;
    			setRedirect($link);
	    	}
	    }

		
		function cancel_order(){
			$model = $this -> model;
			
			$rs  = $model -> cancel_order();
			
			$Itemid = 61;	
			$id = FSInput::get('id');
			$link = 'index.php?module=order&view=order&task=edit&id='.$id;
			if(!$rs){
				$msg = 'Không hủy được đơn hàng';
				setRedirect($link,$msg,'error');
			}
			else {
				$msg = 'Đã hủy được đơn hàng';
				setRedirect($link);
			}
		}

		function save_order_cms(){
			// var_dump(1);die;
			$model = $this -> model;
			
			$rs  = $model -> save_order_cms();
			
			$link = 'index.php?module=order&view=order';
			if($rs){
				$msg = 'Đặt sim thành công';
				setRedirect($link,$msg);
			}
			else {
				$msg = 'Chưa đặt được sim';
				setRedirect($link,$msg);
			}
		}

		function finished_order(){
			$model = $this -> model;
			
			$rs  = $model -> finished_order();
			
			$Itemid = 61;	
			$id = FSInput::get('id');
			$link = 'index.php?module=order&view=order&task=edit&id='.$id;
			if(!$rs){
				$msg = 'Không hoàn tất được đơn hàng';
				setRedirect($link,$msg,'error');
			}
			else {
				$msg = 'Đã hoàn tất được đơn hàng thành công';
				setRedirect($link);
			}
		}
	// Excel toàn bộ danh sách copper ra excel
		function export(){
			setRedirect('index.php?module='.$this -> module.'&view='.$this -> view.'&task=export_file&raw=1');
		}	
		function export_file(){
			FSFactory::include_class('excel','excel');
//			require_once 'excel.php';
			$model  = $this -> model;
			$filename = 'order-export';
			$list = $model->get_member_info();
			if(empty($list)){
				echo 'error';exit;
			}else {
				$excel = FSExcel();
				$excel->set_params(array('out_put_xls'=>'export/excel/'.$filename.'.xls','out_put_xlsx'=>'export/excel/'.$filename.'.xlsx'));
				$style_header = array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb'=>'ffff00'),
					),
					'font' => array(
						'bold' => true,
					)
				);
				$style_header1 = array(
					'font' => array(
						'bold' => true,
					)
				);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Mã đơn hàng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Người mua');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Giá trị');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Ngày mua');
				foreach ($list as $item){
					$key = isset($key)?($key+1):2;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, 'DH'.str_pad($item -> id, 8 , "0", STR_PAD_LEFT) );
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->sender_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, format_money($item -> total_after_discount));
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $item->created_time);
				}
				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:D1' );
				$output = $excel->write_files();
				
				$path_file =   PATH_ADMINISTRATOR.DS.str_replace('/',DS, $output['xls']);
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);			
				header("Content-type: application/force-download");			
				header("Content-Disposition: attachment; filename=\"".$filename.'.xls'."\";" );			
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".filesize($path_file));
				readfile($path_file);
			}
		}	
	}
	
?>