<?php
	// models 
	class UsersControllersPrice extends Controllers 
	{
		var $module;
		var $gid;
		function __construct()
		{
//			$module = 'users';
			$this->view = 'price';
			parent::__construct(); 
			$this->gid = FSInput::get('gid');
			//var_dump($_REQUEST);die;
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data('');
			
			// call views
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		
		
		function add()
		{
			$model = $this -> model;
			$maxOrdering = $model->getMaxOrdering();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		function edit()
		{
			$cds = FSInput::get('id',array(),'array');
			$cid = $cds[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($cid);
			$commissions = $model ->get_records('price_id = '.$data -> id.' ORDER BY ordering ASC','fs_price_commissions');
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}


		// Excel toàn bộ danh sách copper ra excel
		function export(){
			setRedirect('index.php?module='.$this -> module.'&view='.$this -> view.'&task=export_file&raw=1');
		}	
		function export_file(){

			FSFactory::include_class('excel','excel');
//			require_once 'excel.php';
			$model  = $this -> model;
			$time = date('Y-m-d');
			$filename = 'commissions-'.$time;
			$list = $model->get_data_for_export();
			if(empty($list)){
				echo 'error';exit;
			}else {
				$excel = FSExcel();
				$excel->set_params(array('out_put_xls'=>'export/commissions/'.$filename.'.xls','out_put_xlsx'=>'export/commissions/'.$filename.'.xlsx'));
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
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(70);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'STT');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'TÊN TRƯỜNG HỢP CHIẾT KHẤU');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'USER TẠO');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'USER CẬP NHẬP');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'TRẠNG THÁI');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'NGÀY TẠO');
				$i = 1;
				foreach ($list as $item){
					$key = isset($key)?($key+1):2;

					$st = 'Không hoạt động';
					if ($item->published == 1) {
						$st = 'Có hoạt động';
					}

					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $i);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item ->name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item ->user_create_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $item ->user_update_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $st);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, date('d/m/Y  H:s',strtotime($item->created_time)));
					$i++;
				}
				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:F1' );
			// var_dump($list);die;
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