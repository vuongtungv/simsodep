<?php
global $tmpl;
$tmpl->addStylesheet("users_info", "modules/users/assets/css");
$tmpl->addStylesheet('jquery-ui', 'libraries/jquery/jquery.ui');
$tmpl->addScript('form');
$tmpl->addScript('default', 'modules/users/assets/js');
$tmpl->addScript('jquery-ui', 'libraries/jquery/jquery.ui');
$Itemid = FSInput::get('Itemid', 1);

$task = FSInput::get('task');
$date_now = date('m');
$head_id = FSInput::get('head_id');
$month_to = FSInput::get('month_to');
$year_to = FSInput::get('year_to');
$month_from = FSInput::get('month_from');
$year_from = FSInput::get('year_from');
$type_exam = FSInput::get('type_exam');
?>	
<div class="contai_info">
    <p class="title_info "> <span><i class="fa fa-bar-chart"></i> Lịch Sử Học Tập</span></p>
    <div class="history_learning">
        <div class="head_top">
            <form class="form-horizontal"  name="show_list_user">
                <div class="form-group">
                    <div class="col-xs-4"></div>
                    <!--<label for="" class="control-label col-xs-2" style="width: 14%;padding: 5px 0 0 0;">Thống kê kết quả: </label>
                    <select class="form-control type_exam col-xs-2" name="type_exam">
                        <option value="">Tất cả</option>
                        <option value="1" <?php if ($type_exam == 1) echo 'selected'; ?>>Thi online</option>
                        <option value="2" <?php if ($type_exam == 2) echo 'selected'; ?>>Thi Tổng Hợp</option>
                    </select>-->

                    <label for="inputPassword" class="control-label col-xs-1" style="width: 5%">Từ:</label>
                    <div class="col-xs-3" style="width: 20%;">
                        <select class="form-control date_search" name="month_to" id="month_to">
                            <option value="">Tháng</option>
                            <?php for ($i = 1; $i <= 12; $i++) { ?>
                                <option value="<?php echo $i ?>" <?php if ($month_to == $i) echo 'selected' ?> ><?php echo $i ?></option>
                            <?php } ?>
                        </select>
                        <select class="form-control date_search" name="year_to" id="year_to">
                            <option value="">Năm</option>
                            <?php for ($i = 2015; $i <= 2018; $i++) { ?>
                                <option value="<?php echo $i ?>" <?php if ($year_to == $i) echo 'selected' ?> ><?php echo $i ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <label for="inputPassword" class="control-label col-xs-1"  style="width: 5%">Đến:</label>
                    <div class="col-xs-3" style="width: 20%;">
                        <select class="form-control date_search" name="month_from" id="month_from">
                            <option value="">Tháng</option>
                            <?php for ($i = 1; $i <= 12; $i++) { ?>
                                <option   value="<?php echo $i ?>" <?php if ($month_from == $i) echo 'selected' ?> ><?php echo $i ?></option>
                            <?php } ?>
                        </select>
                        <select class="form-control date_search" name="year_from" id="year_from">
                            <option value="">Năm</option>
                            <?php for ($i = 2015; $i <= 2017; $i++) { ?>
                                <option value="<?php echo $i ?>" <?php if ($year_from == $i) echo 'selected' ?> ><?php echo $i ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <a href="javascript:void(0)" class="btn_show_list col-xs-1"><i class="fa fa-search"></i>Xem</a>
                 
<!--                    <a href="javascript:void(0)" class="btn_excel col-xs-2"><i class="fa  fa-file-excel-o"></i>Xuất ra Excel</a>-->
                </div>
            </form>
        </div>
        <div class="content_list">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Ngày thi</th>
                        <th>Thời gian bắt đầu</th>
                        <th>Thời gian kết thúc</th>
                        <th>Thời Gian Làm Bài</th>
                        <th>Điểm</th>
                        <th>Đạt/Không Đạt</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($list_exam_per as $item) {
                        ?>
                        <tr>
                            <td><?php echo $i + 1 ?></td>
                            <td style="text-align: center;cursor: pointer"><?php echo date('d-m-Y', $item->start_time) ?></td>
                            <td style="text-align: center;cursor: pointer"><?php echo date('H:i d-m-Y', $item->start_time) ?></td>
                            <td style="text-align: center;cursor: pointer"><?php echo date('H:i d-m-Y', $item->end_time) ?></td>
                            <td><?php echo gmdate("H:i:s",strtotime(date('Y-m-d H:i:s',$item->end_time))-strtotime(date('Y-m-d H:i:s',$item->start_time)))?></td>
                            <!--<td><?php echo date('Y-m-d H:i:s',$item->end_time).'----'.date('Y-m-d H:i:s',$item->start_time) ?></td>-->
                            <td style="text-align:center;color:#ff0000"><?php echo $item->point ?></td>
                            <td><?php
                                if ($item->status == 1) {
                                    echo 'Đạt';
                                } else {
                                    echo 'Không Đạt';
                                }
                                ?></td>
                        </tr>

                        <?php
                        $i++;
                    }
                    ?>

                    <tr>
                </tbody>
            </table>
            <div class="total_history">
                <p><i class="i_h fa fa-check-square-o"></i>Điểm trung bình: <span style="color:#cc0000"><?php echo $get_dtb->TB ?></span></p>
                <p><i class="i_h fa fa-pencil-square-o"></i>Số lần đã làm bài: <span style="color:#cc0000"><?php echo count($list_exam_per) ?></span></p>

            </div>
        </div>
    </div>
</div>  
