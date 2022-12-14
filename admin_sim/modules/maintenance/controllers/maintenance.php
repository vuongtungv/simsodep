<?php
	
	class MaintenanceControllersMaintenance extends Controllers
	{
		function __construct()
		{
			$this->view = 'maintenance'; 
			parent::__construct(); 
		}
		
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;


			$model  = $this -> model;
            //$group = $model -> get_records('published = 1','fs_members_group','*','ordering DESC');
            $members = $model->get_records('published = 1','fs_members','id,username,full_name','ordering ASC , id ASC');
            $cities = $model->get_records('published = 1','fs_cities','id,name,alias','ordering ASC , id ASC');
            $district = $model->get_records('published = 1','fs_districts','id,name,alias','ordering ASC , id ASC');
            $group = $model->get_records('published = 1','fs_maintenance_group','id,name,alias','ordering ASC , id ASC');
			//$cities = $model-> get_cities_name();
			$list = $model->get_data();
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
			$maxOrdering = $model->getMaxOrdering();
            $members = $model->get_records('published = 1','fs_members','id,username,full_name','ordering ASC , id ASC');
			$cities = $model->get_records('published = 1','fs_cities','id,name,alias','ordering ASC , id ASC');
            $district = $model->get_records('published = 1 AND city_id = 1473 ','fs_districts','id,name,alias','ordering ASC , id ASC');
            $group = $model->get_records('published = 1','fs_maintenance_group','id,name,alias','ordering ASC , id ASC');
            
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		function edit()
		{
		    $ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model  = $this -> model;
			$data = $model->get_record_by_id($id);
			if(!$data)
				die('Not found url');
            $members = $model->get_records('published = 1','fs_members','id,username,full_name','ordering ASC , id ASC');    
            $group = $model->get_records('published = 1','fs_maintenance_group','id,name,alias','ordering ASC , id ASC');
            $cities = $model->get_records('published = 1','fs_cities','id,name,alias','ordering ASC , id ASC');
            $where = '';
            if($data->city_id){
                $where = ' AND city_id = '. $data->city_id;
            }
            $district = $model->get_records('published = 1'. $where,'fs_districts','id,name,alias','ordering ASC , id ASC');    
            //$group = $model -> get_records('published = 1','fs_members_group','*','ordering DESC');
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
        
        function ajax_get_product_district(){
			$model  = $this -> model;
			$cid = FSInput::get('cid');
			$rs  = $model -> ajax_get_product_district($cid);
			
			$json = '['; // start the json array element
			$json_names = array();
			foreach( $rs as $item)
			{
				$json_names[] = "{id: $item->id, name: '$item->name'}";
			}
			$json .= implode(',', $json_names);
			$json .= ']'; // end the json array element
			echo $json;
		}
		// Excel to??n b??? danh s??ch copper ra excel
		function export(){
			setRedirect('index.php?module='.$this -> module.'&view='.$this -> view.'&task=export_file&raw=1');
		}	
		function export_file(){
			FSFactory::include_class('excel','excel');
//			require_once 'excel.php';
			$model  = $this -> model;
			$filename = 'member-export';
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
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'T??n truy c???p');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'H??? v?? t??n');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', '?????a ch???');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Email');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', '??i???n tho???i');
				foreach ($list as $item){
					$key = isset($key)?($key+1):2;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->username);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->full_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->address);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $item->email);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $item->mobilephone);
				}
				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1' );
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
				
		// Excel to??n b??? danh s??ch copper ra excel
		function export_excel(){
			require_once 'excel.php';
			$model  = $this -> model;
			$start = FSInput::get('start');
			$start=(isset($start) && !empty($start))?$start:1;
			$start=$start-1;
			$end = FSInput::get('end');
			$end=(isset($end) && !empty($end))?$end:10;
			$list = $model->get_member_info($start,$end);
			if(empty($list)){
				echo 'error';exit;
			}else {
				$excel = V_Excel();
				$excel->set_params(array('out_put_xls'=>'export/excel/'.'danh_sach_'.date('H-i_j-n-Y',time()).'.xls','out_put_xlsx'=>'export/excel/'.'danh_sach_'.date('j-n-Y',time()).'.xlsx'));
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
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'T??n truy c???p');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'H??? v?? t??n');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', '?????a ch???');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Email');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', '??i???n tho???i');
				foreach ($list as $item){
					$key = isset($key)?($key+1):2;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->username);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->fullname);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->address);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $item->email);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $item->mobilephone);
				}
				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1' );
				$output = $excel->write_files();
				echo URL_ROOT.'ione_admin/'.$output['xls'];
			}
		}	
		function quality_export(){
			$html='<form id="form1" name="form1" method="post" >';
			$html.='<h1 style="color:#FF0000; text-align:center">B???n h??y ??i???n s??? th??? t??? c???a b???n ghi mu???n export</h1>';
			$html.='<p style="text-align:center"><label>B???t ?????u :</label>';
			$html.='<input type="text" name="start_at" id="start_at" /><br />';
			$html.='<label>K???t th??c: </label><input type="text" name="end_at" id="end_at" /><br><span>N???u b???n kh??ng nh???p s??? th??? t??? th?? h??? th???ng s??? t??? export t??? 1 - 10</span></p>';
			$html.='<p style="text-align:center">';
			$html.='<label>';
			$html.='<input onclick="javascript:configClickExport();" type="submit" name="submit_quality" id="submit_quality" value="Ok" />';
			$html.='</label>';
			$html.='</p>';
			$html.='</form>';
			print_r($html);		
		}
	}
?>