<?php
class CnoControllersCno extends Controllers {

    function __construct()
	{
		$this->view = 'cno' ; 
		parent::__construct();
		$array_status = array( 
                                1 => FSText::_('Mới'),
                                2 =>FSText::_('Đã xem'),
                                3 =>FSText::_('Đối chiếu'),
                                4 =>FSText::_('Đã xong')
                                );
		$this -> arr_status = $array_status;

		$array_money = array( 
                                0 => FSText::_('Không'),
                                1 => FSText::_('Có')
                                );
		$this -> arr_money = $array_money;
	}
    
	function display() {
		parent::display ();
		$sort_field = $this->sort_field;
		$sort_direct = $this->sort_direct;
		
		$model = $this->model;
		$list = $model->get_data ('');

		$array_status = $this -> arr_status;
		$array_obj_status = array();
		foreach($array_status as $key => $name){
			$array_obj_status[] = (object)array('id'=>($key),'name'=>$name);
		}

		$array_money = $this -> arr_money;
		$array_obj_money = array();
		foreach($array_money as $key => $name){
			$array_obj_money[] = (object)array('id'=>($key),'name'=>$name);
		}

		$user_cms = $model->get_records('published=1 and type=1 order by full_name asc','fs_users','id,username,full_name');
		// $agency = $model->get_records('published=1 and type=2 order by full_name asc','fs_users','id,username,full_name');
        $agency = $model->get_records('published=1 and type=2 ORDER BY full_name ASC , ordering DESC , id DESC','fs_users','id,full_name');
        $time = date("Y-m-d H:i");
        $time = strtotime($time);
        $new_agency = array();
        $bad_agency = array();
        foreach ($agency as $value) {
            $sum_total = $model->get_count('status=3 and agency='.$value->id,'fs_cno');
            $sum_price = $model->get_sum('status=3 and agency='.$value->id,'fs_cno','recive');
            $name_full = $value->full_name;
            if ($sum_total) {
                $name_full = $value->full_name.' (Số lượng: '.$sum_total.' - Tổng tiền: '.format_money($sum_price).')';
            }
            $new_agency[] = (object) array('id' => $value->id , 'name' => $name_full);

            // lọc đại lý có nợ xấu 
            if ($sum_price > 0) {
                $new = $model->get_record('status=3 and agency='.$value->id.' order by created_time desc limit 1 ','fs_cno','created_time');
                $ft = $time - strtotime($new->created_time);
                if ($ft > 172800) {
                    $bad_agency[] = (object) array('id' => $value->id , 'name' => $name_full);
                }

            }

        }
        $new_agency = (object) $new_agency;
        $bad_agency = (object) $bad_agency;
                // var_dump($bad_agency);

        $new = $model->get_count('status = 1','fs_cno');
		
        //$categories = $model->get_categories_tree();
        
		$pagination = $model->getPagination ('');
		include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
	}
    
    function add()
	{
		$model = $this -> model;
		//$categories = $model->get_categories_tree();
		$maxOrdering = $model->getMaxOrdering();
		
		include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
	}
	
	function edit()
	{
		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;

		$data = $model->get_record_by_id($id);
        // $count_s = $data->count + 1;
        // if ($count_s == 1) {
        //     $row['status'] = 2;
        //     $row['count'] = 2;
        //     $model->_update($row,'fs_cno','id='.$data->id);
        // }

        $order = $model->get_record_by_id($data->order_id);

		// $agency = $model->get_records('published = 1 AND type = 2','fs_users','id,full_name');
        $agency = $model->get_records('published=1 and type=2 ORDER BY full_name ASC , ordering DESC , id DESC','fs_users','id,full_name');
		$customer = $model->get_records('published = 1 AND type = 1','fs_users','id,full_name');

        $order_item = $model->get_record_by_id($data->order_item_id,'fs_order_items');
        $order = $model->get_record_by_id($data->order_id,'fs_order');
        
		// var_dump($agency);

		// data from fs_news_categories
		include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
	}
	    // Excel toàn bộ danh sách copper ra excel

    function export_detail() {
        setRedirect('index.php?module=' . $this->module . '&view=' . $this->view . '&task=export_file_details&raw=1');
    }
    function export_file_details() {
        FSFactory::include_class('excel', 'excel');
        $time = date("d-m-Y");
        $model = $this->model;

        $from = isset($_SESSION[$this -> prefix.'text0'])?$_SESSION[$this -> prefix.'text0']:'';
        $to = isset($_SESSION[$this -> prefix.'text1'])?$_SESSION[$this -> prefix.'text1']:'';

        $filename = 'Công nợ chi tiết theo đại lý ';

        if ($from) {
            $filename .= ' từ '.$from;
        }

        if ($to) {
            $filename .= ' đến '.$to;
        }

        if (!$from && !$to) {
            $filename = 'Công nợ chi tiết theo đại lý đến ngày '.$time;
        }

        $list = $model->get_data_cno('','1');
        // var_dump($list);die;
        if (empty($list)) {
            echo 'error';
            exit;
        } else {
            $excel = FSExcel();
            $excel->set_params(array('out_put_xls' => 'export/excel/' . $filename . '.xls', 'out_put_xlsx' => 'export/excel/' . $filename . '.xlsx'));

            $style_item = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '92D050'),
                ),
                'font' => array(
                    'bold' => true,
                )
            );

            $style_total = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFFF00'),
                ),
                'font' => array(
                    'bold' => true,
                )
            );   

            $style_agency = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                ),
                'font' => array(
                    'bold' => true,
                )
            );

            $style_total_out = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '00B0F0'),
                ),
                'font' => array(
                    'bold' => true,
                )
            );

            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('T')->setWidth(40);

            $total = 0;
            $total_out = 0;
            $agency = 0;
            $i = 1;
            $key = 1;
            $j = 0;
            foreach ($list as $item) {
                $j ++;
                $key ++;
                switch ($item->status) {
                    case '2':
                        $status = 'Đã xem';
                        break;
                    case '3':
                        $status = 'Đối chiếu';
                        break;
                    case '4':
                        $status = 'Đã xong';
                        break;
                    default:
                        $status = 'Mới';
                        break;
                }

                $filenameagency = 'Công nợ';
                if ($from) {
                    $filenameagency .= ' từ '.$from;
                }

                if ($to) {
                    $filenameagency .= ' đến '.$to;
                }

                $filenameagency .= ' của '.$item->agency_name.' : '.$item->agency_phone;

                if (!$from && !$to) {
                    $filenameagency = 'Công nợ đến ngày '.$time.' của '.$item->agency_name.' : '.$item->agency_phone;
                }

                if ($j == 1) {
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('E' . $key, $filenameagency);
                    $excel->obj_php_excel->getActiveSheet()->getStyle('E' . $key)->applyFromArray($style_agency);
                    $key +=1;

                    $excel->obj_php_excel->getActiveSheet()->setCellValue('A' . $key, 'STT');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('A' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('B' . $key, 'Ngày');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('B' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('C' . $key, 'Hotline Đại lý');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('C' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('D' . $key, 'Tên Đại lý');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('D' . $key)->applyFromArray($style_item);
                    $excel->obj_php_excel->getActiveSheet()->getStyle('D' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('E' . $key, 'Số sim giao dịch');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('E' . $key)->applyFromArray($style_item);
                    $excel->obj_php_excel->getActiveSheet()->getStyle('E' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('F' . $key, 'Giá bán');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('F' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('G' . $key, 'Giá Đại lý');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('G' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('H' . $key, 'Chiết khấu');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('H' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('I' . $key, 'Thực trả');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('I' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('J' . $key, 'Tự thu');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('J' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('K' . $key, 'Đại lý thu hộ');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('K' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('L' . $key, 'Phí giao dịch (Nếu có)');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('L' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('M' . $key, 'Tiền lãi');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('M' . $key)->applyFromArray($style_item);
                    $excel->obj_php_excel->getActiveSheet()->getStyle('M' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('N' . $key, 'Phải thu');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('N' . $key)->applyFromArray($style_item);
                    $excel->obj_php_excel->getActiveSheet()->getStyle('N' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('O' . $key, 'Phải trả');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('O' . $key)->applyFromArray($style_item);
                    $excel->obj_php_excel->getActiveSheet()->getStyle('O' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('P' . $key, 'Đã thanh toán');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('P' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('Q' . $key, 'Ngày chốt công nợ');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('Q' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('R' . $key, 'Trạng thái');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('R' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('S' . $key, 'Nhân viên');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('S' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('T' . $key, 'Ghi chú');
                    $excel->obj_php_excel->getActiveSheet()->getStyle('T' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $key +=1;

                    $total = $item->recive;
                    $total_out = $item->status == 4?$item->recive:0;
                }


                if ($agency != $item->agency) {
                    $agency = $item->agency;
                    if ($j > 1) {
                        // var_dump($total_out );die;
                        $excel->obj_php_excel->getActiveSheet()->setCellValue('N' . $key, 'Tổng tiền');
                        $excel->obj_php_excel->getActiveSheet()->setCellValue('O' . $key,format_money_0($total,''));
                        $excel->obj_php_excel->getActiveSheet()->setCellValue('P' . $key,format_money_0($total_out,''));
                        $excel->obj_php_excel->getActiveSheet()->getStyle('N' . $key)->applyFromArray($style_total);
                        $excel->obj_php_excel->getActiveSheet()->getStyle('O' . $key)->applyFromArray($style_total);
                        $excel->obj_php_excel->getActiveSheet()->getStyle('P' . $key)->applyFromArray($style_total_out);
                        $excel->obj_php_excel->getActiveSheet()->getStyle('N' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $excel->obj_php_excel->getActiveSheet()->getStyle('O' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $excel->obj_php_excel->getActiveSheet()->getStyle('P' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $key +=1;
                        $total = $item->recive;
                        $total_out = $item->status == 4?$item->recive:0;

                        $key +=2;
                        $excel->obj_php_excel->getActiveSheet()->setCellValue('E' . $key, $filenameagency);
                        $excel->obj_php_excel->getActiveSheet()->getStyle('E' . $key)->applyFromArray($style_agency);
                        $key +=1;

                            // var_dump($j);
                        if ($j <= count($list)) {
                            // var_dump($j);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('A' . $key, 'STT');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('A' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('B' . $key, 'Ngày');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('B' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('C' . $key, 'Hotline Đại lý');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('C' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('D' . $key, 'Tên Đại lý');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('D' . $key)->applyFromArray($style_item);
                            $excel->obj_php_excel->getActiveSheet()->getStyle('D' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('E' . $key, 'Số sim giao dịch');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('E' . $key)->applyFromArray($style_item);
                            $excel->obj_php_excel->getActiveSheet()->getStyle('E' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('F' . $key, 'Giá bán');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('F' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('G' . $key, 'Giá Đại lý');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('G' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('H' . $key, 'Chiết khấu');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('H' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('I' . $key, 'Thực trả');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('I' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('J' . $key, 'Tự thu');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('J' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('K' . $key, 'Đại lý thu hộ');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('K' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('L' . $key, 'Phí giao dịch (Nếu có)');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('L' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('M' . $key, 'Tiền lãi');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('M' . $key)->applyFromArray($style_item);
                            $excel->obj_php_excel->getActiveSheet()->getStyle('M' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('N' . $key, 'Phải thu');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('N' . $key)->applyFromArray($style_item);
                            $excel->obj_php_excel->getActiveSheet()->getStyle('N' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('O' . $key, 'Phải trả');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('O' . $key)->applyFromArray($style_item);
                            $excel->obj_php_excel->getActiveSheet()->getStyle('O' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('P' . $key, 'Đã thanh toán');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('P' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('Q' . $key, 'Ngày chốt công nợ');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('Q' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('R' . $key, 'Trạng thái');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('R' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('S' . $key, 'Nhân viên');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('S' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $excel->obj_php_excel->getActiveSheet()->setCellValue('T' . $key, 'Ghi chú');
                            $excel->obj_php_excel->getActiveSheet()->getStyle('T' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $key +=1;
                        }

                    }
                    $i = 1;

                }else{
                    $total = $total + $item->recive;
                    $total_out = $item->status == 4?$total_out + $item->recive:$total_out;
                    // var_dump($total_out);die;
                    $i++;
                }

                $excel->obj_php_excel->getActiveSheet()->setCellValue('A' . $key, $i);
                $excel->obj_php_excel->getActiveSheet()->getStyle('A' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('B' . $key, date('d/m/Y', strtotime($item->created_time)));
                $excel->obj_php_excel->getActiveSheet()->getStyle('B' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('C' . $key, $item->agency_phone);
                $excel->obj_php_excel->getActiveSheet()->getStyle('C' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('D' . $key, $item->agency_name);
                $excel->obj_php_excel->getActiveSheet()->getStyle('D' . $key)->applyFromArray($style_item);
                $excel->obj_php_excel->getActiveSheet()->getStyle('D' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('E' . $key, ' '.$item->number);
                $excel->obj_php_excel->getActiveSheet()->getStyle('E' . $key)->getFont()->setBold(true);
                $excel->obj_php_excel->getActiveSheet()->getStyle('E' . $key)->applyFromArray($style_item);
                $excel->obj_php_excel->getActiveSheet()->getStyle('E' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('F' . $key, format_money_0($item->price_sell,''));
                $excel->obj_php_excel->getActiveSheet()->getStyle('F' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('G' . $key, format_money_0($item->price_orginal,''));
                $excel->obj_php_excel->getActiveSheet()->getStyle('G' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('H' . $key, $item->commission_percent);
                $excel->obj_php_excel->getActiveSheet()->getStyle('H' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('I' . $key, format_money_0($item->price_partner_end,''));
                $excel->obj_php_excel->getActiveSheet()->getStyle('I' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('J' . $key, format_money_0($item->price_revice,''));
                $excel->obj_php_excel->getActiveSheet()->getStyle('J' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('K' . $key, format_money_0($item->partner_recive,''));
                $excel->obj_php_excel->getActiveSheet()->getStyle('K' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('L' . $key, format_money_0($item->price_support,''));
                $excel->obj_php_excel->getActiveSheet()->getStyle('L' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('M' . $key, format_money_0($item->price_interest,''));
                $excel->obj_php_excel->getActiveSheet()->getStyle('M' . $key)->applyFromArray($style_item);
                $excel->obj_php_excel->getActiveSheet()->getStyle('M' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('N' . $key, $item->recive>=0?format_money_0($item->recive,''):'');
                $excel->obj_php_excel->getActiveSheet()->getStyle('N' . $key)->applyFromArray($style_item);
                $excel->obj_php_excel->getActiveSheet()->getStyle('N' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('O' . $key,$item->recive<0?format_money_0($item->recive,''):'');
                $excel->obj_php_excel->getActiveSheet()->getStyle('O' . $key)->applyFromArray($style_item);
                $excel->obj_php_excel->getActiveSheet()->getStyle('O' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('P' . $key, $item->status==4?format_money_0($item->recive,''):'');
                $excel->obj_php_excel->getActiveSheet()->getStyle('P' . $key)->getFont()->setBold(true);
                $excel->obj_php_excel->getActiveSheet()->getStyle('P' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('Q' . $key, $item->pay_date?date('d/m/Y', strtotime($item->pay_date)):'');
                $excel->obj_php_excel->getActiveSheet()->getStyle('Q' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('R' . $key, $status);
                $excel->obj_php_excel->getActiveSheet()->getStyle('R' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('S' . $key, $item->user_name);
                $excel->obj_php_excel->getActiveSheet()->getStyle('S' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('T' . $key, $item->note);
                $excel->obj_php_excel->getActiveSheet()->getStyle('T' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                if ($j == count($list)) {
                    $key +=1;
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('N' . $key, 'Tổng tiền');
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('O' . $key,format_money_0($total,''));
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('P' . $key,format_money_0($total_out,''));
                    $excel->obj_php_excel->getActiveSheet()->getStyle('N' . $key)->applyFromArray($style_total);
                    $excel->obj_php_excel->getActiveSheet()->getStyle('O' . $key)->applyFromArray($style_total);
                    $excel->obj_php_excel->getActiveSheet()->getStyle('P' . $key)->applyFromArray($style_total_out);
                    $excel->obj_php_excel->getActiveSheet()->getStyle('N' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->getStyle('O' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $excel->obj_php_excel->getActiveSheet()->getStyle('P' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                }

            }



            // var_dump($total);
            // die;


            // $excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
            // $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(11);
            // $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
            // $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_header);
            // $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            // $excel->obj_php_excel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
            // $excel->obj_php_excel->getActiveSheet()->duplicateStyle($excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:T1');


            $output = $excel->write_files();

            $path_file = PATH_ADMINISTRATOR . DS . str_replace('/', DS, $output['xls']);
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            header("Content-type: application/force-download");
            header("Content-Disposition: attachment; filename=\"" . $filename . '.xls' . "\";");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: " . filesize($path_file));
            readfile($path_file);
        }
    }

    function export() {
        setRedirect('index.php?module=' . $this->module . '&view=' . $this->view . '&task=export_file&raw=1');
    }
  	function export_file() {
        FSFactory::include_class('excel', 'excel');
        $time = date("d-m-Y");
        $model = $this->model;

        $from = isset($_SESSION[$this -> prefix.'text0'])?$_SESSION[$this -> prefix.'text0']:'';
        $to = isset($_SESSION[$this -> prefix.'text1'])?$_SESSION[$this -> prefix.'text1']:'';

        $filename = 'Tổng hợp công nợ ';

        if ($from) {
            $filename .= ' từ '.$from;
        }

        if ($to) {
            $filename .= ' đến '.$to;
        }

        if (!$from && !$to) {
            $filename = 'Tổng hợp công nợ đến ngày '.$time;
        }

        // var_dump($filename);die;
        $list = $model->get_data_cno('');
        // var_dump($list);die;
        if (empty($list)) {
            echo 'error';
            exit;
        } else {
            $excel = FSExcel();
            $excel->set_params(array('out_put_xls' => 'export/excel/' . $filename . '.xls', 'out_put_xlsx' => 'export/excel/' . $filename . '.xlsx'));
            $style_header = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    // 'color' => array('rgb' => 'ffff00'),
                ),
                'font' => array(
                    // 'bold' => true,
                )
            );

            $style_total = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFFF00'),
                ),
                'font' => array(
                    'bold' => true,
                )
            );
            $style_total_out = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '00B0F0'),
                ),
                'font' => array(
                    'bold' => true,
                )
            );
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('T')->setWidth(40);
            $excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'STT');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Ngày');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Hotline Đại lý');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Tên Đại lý');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Số sim giao dịch');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'Giá bán');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('G1', 'Giá Đại lý');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('H1', 'Chiết khấu');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('I1', 'Thực trả');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('J1', 'Tự thu');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('K1', 'Đại lý thu hộ');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('L1', 'Phí giao dịch (Nếu có)');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('M1', 'Tiền lãi');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('N1', 'Phải thu');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('O1', 'Phải trả');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('P1', 'Đã thanh toán');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('Q1', 'Ngày chốt công nợ');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('R1', 'Trạng thái');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('S1', 'Nhân viên');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('T1', 'Ghi chú');
        	$total = 0;
            $total_out = 0;
            foreach ($list as $item) {
                $key = isset($key) ? ($key + 1) : 2;
            	$i = $key - 1;
            	switch ($item->status) {
            		case '2':
            			$status = 'Đã xem';
            			break;
            		case '3':
            			$status = 'Đối chiếu';
            			break;
        			case '4':
                        $total_out = $total_out + $item->recive;
            			$status = 'Đã xong';
            			break;
            		default:
            			$status = 'Mới';
            			break;
            	}
        		$total = $total + $item->recive;

 
                $excel->obj_php_excel->getActiveSheet()->setCellValue('A' . $key, $i);
                $excel->obj_php_excel->getActiveSheet()->getStyle('A' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('B' . $key, date('d/m/Y', strtotime($item->created_time)));
                $excel->obj_php_excel->getActiveSheet()->getStyle('B' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('C' . $key, $item->agency_phone);
                $excel->obj_php_excel->getActiveSheet()->getStyle('C' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('D' . $key, $item->agency_name);
                $excel->obj_php_excel->getActiveSheet()->getStyle('D' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('E' . $key, ' '.$item->number);
                $excel->obj_php_excel->getActiveSheet()->getStyle('E' . $key)->getFont()->setBold(true);
                $excel->obj_php_excel->getActiveSheet()->getStyle('E' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('F' . $key, format_money_0($item->price_sell,''));
                $excel->obj_php_excel->getActiveSheet()->getStyle('F' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('G' . $key, format_money_0($item->price_orginal,''));
                $excel->obj_php_excel->getActiveSheet()->getStyle('G' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('H' . $key, $item->commission_percent);
                $excel->obj_php_excel->getActiveSheet()->getStyle('H' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('I' . $key, format_money_0($item->price_partner_end,''));
                $excel->obj_php_excel->getActiveSheet()->getStyle('I' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('J' . $key, format_money_0($item->price_revice,''));
                $excel->obj_php_excel->getActiveSheet()->getStyle('J' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('K' . $key, format_money_0($item->partner_recive,''));
                $excel->obj_php_excel->getActiveSheet()->getStyle('K' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('L' . $key, format_money_0($item->price_support,''));
                $excel->obj_php_excel->getActiveSheet()->getStyle('L' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('M' . $key, format_money_0($item->price_interest,''));
                $excel->obj_php_excel->getActiveSheet()->getStyle('M' . $key)->getFont()->setBold(true);
                $excel->obj_php_excel->getActiveSheet()->getStyle('M' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('N' . $key, $item->recive>=0?format_money_0($item->recive,''):'');
                $excel->obj_php_excel->getActiveSheet()->getStyle('N' . $key)->getFont()->setBold(true);
                $excel->obj_php_excel->getActiveSheet()->getStyle('N' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('O' . $key,$item->recive<0?format_money_0($item->recive,''):'');
                $excel->obj_php_excel->getActiveSheet()->getStyle('O' . $key)->getFont()->setBold(true);
                $excel->obj_php_excel->getActiveSheet()->getStyle('O' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('P' . $key, $item->status==4?format_money_0($item->recive,''):'');
                $excel->obj_php_excel->getActiveSheet()->getStyle('P' . $key)->getFont()->setBold(true);
                $excel->obj_php_excel->getActiveSheet()->getStyle('P' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('Q' . $key, $item->pay_date?date('d/m/Y', strtotime($item->pay_date)):'');
                $excel->obj_php_excel->getActiveSheet()->getStyle('Q' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('R' . $key, $status);
                $excel->obj_php_excel->getActiveSheet()->getStyle('R' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('S' . $key, $item->user_name);
                $excel->obj_php_excel->getActiveSheet()->getStyle('S' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('T' . $key, $item->note);
                $excel->obj_php_excel->getActiveSheet()->getStyle('T' . $key)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            }

            $key = isset($key) ? ($key + 1):'0';
            $excel->obj_php_excel->getActiveSheet()->setCellValue('N' . $key, 'Tổng tiền');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('O' . $key,format_money_0($total,''));
            $excel->obj_php_excel->getActiveSheet()->setCellValue('P' . $key,format_money_0($total_out,''));

            // var_dump($total);die;

            $excel->obj_php_excel->getActiveSheet()->getStyle('N' . $key)->applyFromArray($style_total);
            $excel->obj_php_excel->getActiveSheet()->getStyle('O' . $key)->applyFromArray($style_total);
            $excel->obj_php_excel->getActiveSheet()->getStyle('P' . $key)->applyFromArray($style_total_out);

            $excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(11);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_header);
        	$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        	$excel->obj_php_excel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
            $excel->obj_php_excel->getActiveSheet()->duplicateStyle($excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:T1');


            $output = $excel->write_files();

            $path_file = PATH_ADMINISTRATOR . DS . str_replace('/', DS, $output['xls']);
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            header("Content-type: application/force-download");
            header("Content-Disposition: attachment; filename=\"" . $filename . '.xls' . "\";");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: " . filesize($path_file));
            readfile($path_file);
        }
    }
}
?>