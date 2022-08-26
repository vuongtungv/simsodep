
.. <?php
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
 if(isset($_SESSION['head_id'])){
    $head_id_s=$_SESSION['head_id'];
}

$status = FSInput::get('status');
if(isset($_SESSION['status'])){
    $status_s = $_SESSION['status'];
}

$month_to = FSInput::get('month_to');
if(isset($_SESSION['month_to'])){
    $month_to_s = $_SESSION['month_to'];
}
$day_to = FSInput::get('day_to');
if(isset($_SESSION['day_to'])){
    $day_to_s = $_SESSION['day_to'];
}

$year_to = FSInput::get('year_to');
if(isset($_SESSION['year_to'])){
 $year_to_s = $_SESSION['year_to'];
}

$day_from = FSInput::get('day_from');
if(isset($_SESSION['day_from'])){
    $day_from_s =$_SESSION['day_from'];
}

$month_from = FSInput::get('month_from');
if(isset($_SESSION['month_from'])){
    $month_from_s =$_SESSION['month_from'];
}

$year_from = FSInput::get('year_from');
if(isset($_SESSION['year_from'])){
    $year_from_s = $_SESSION['year_from'];
}

$type_exam = FSInput::get('type_exam');
?>	
<div class="contai_info">
    <p class="title_info "> <span><i class="fa fa-bar-chart"></i> Lịch Sử Học Tập</span>
      <a href="javascript:void(0)" class="btn_excel col-xs-2"><i class="fa  fa-file-excel-o"></i>Xuất ra Excel</a>
      <a class="reset_filter" href="<?php echo FSRoute::_('index.php?module=users&task=delete_filter&Itemid=69') ?>">Bỏ lọc</a>
  </p>
  <div class="history_learning">
    <div class="head_top">
        <form class="form-horizontal" name="show_list_user">
            <div class="form-group">

                    <!--<label for="" class="control-label col-xs-2" style="width: 14%;padding: 5px 0 0 0;">Thống kê kết quả: </label>
                    <select class="form-control type_exam col-xs-2" name="type_exam">
                        <option value="">Tất cả</option>
                        <option value="1" <?php if ($type_exam == 1) echo 'selected'; ?>>Thi online</option>
                        <option value="2" <?php if ($type_exam == 2) echo 'selected'; ?>>Thi Tổng Hợp</option>
                    </select>-->

                    
                    <div class="col-md-3 date_img">
                        <span>Từ:</span>
                        <input type="text" class="form-control" name='date_from' id='date_from' value ="<?php echo FSInput::get('date_from'); ?>" placeholder="Chọn ngày bắt đầu"/>
                        <img src="<?php echo URL_ROOT.'images/date.png' ?>" alt=""> 
                    </div>
                    <div class="col-md-3 date_img">
                        <span>Đến:</span>
                        <input type="text" class="form-control" name='date_to' id='date_to' value ="<?php echo FSInput::get('date_to');?>" placeholder="Chọn ngày kết thúc"/>
                        <img src="<?php echo URL_ROOT.'images/date.png' ?>" alt=""> 
                    </div>
                    <?php if ($user->userInfo->type == 1) { ?>
                    <select name="head_id" class="form-control col-md-2" style="width: 165px;height: 37px;padding:1px 10px;margin-right: 10px" >
                        <option value="0">---Tất Cả HEAD---</option>
                        <?php foreach ($list_head as $item) { ?>
                        <option <?php if (($head_id && $head_id == $item->id)) echo 'selected' ?> value="<?php echo $item->id ?>"><?php echo $item->username ?></option>
                        <?php } ?>

                    </select>

                    <select name="status" class="form-control col-md-2" style="width: 165px;height: 37px;padding:1px 10px;margin-right:10px;">
                        <option <?php if ($status == 3) echo 'selected' ?> value="3">---Tất Cả Tình Trạng---</option>
                        <option <?php if ($status == 1) echo 'selected' ?> value="1">Đang hoạt động</option>
                        <option <?php if ($status == 2) echo 'selected' ?> value="2">Đã nghỉ</option>


                    </select>
                    <?php } ?>

                    
                    <a href="javascript:void(0)" class="btn_show_list col-xs-1"><i class="fa fa-search"></i>Xem</a>
                    <div class="clearfix"></div>
                    <p class="err_text" id="err_text" style="color:#cc0000;padding-top: 10px;"></p>
                </div>
            </form>
        </div>
        <div class="content_list">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên Học Viên</th>
                        <th>Mã DCS</th>
                        <th>Mã HEAD</th>
                        <th style="width:13%">Số Lần Làm Bài</th>
                        <th>Điểm Trung Bình</th>
                        <th>Vị Trí Công Việc</th>
                        <th>Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $y = 0;
                    foreach ($list_student as $item) {
                        $y++;
                        ?>
                        <tr>
                            <td><?php echo $y ?></td>
                            <td style="text-align: left;cursor: pointer"><a href="#myModal_<?php echo $item->id ?>" data-toggle="modal" style="color:#cc0000"><?php echo $item->name ?></a></td>
                            <td><?php echo $item->code_dcs ?></td>
                            <td><?php if ($item->creator_name) echo $item->creator_name ?></td>
                            <td><?php echo $item->num_exam ?></td>
                            <td style="text-align:center;color:#ff0000"><?php echo $item->DTB ?></td>
                            <td><?php echo $item->vi_tri ?></td>
                            <td><?php
                            if ($item->published == 1) {?>
                            <p><i class="fa fa-check-circle" style=" padding-right: 5px;color: #1abc9c;"></i>Đang hoạt động</p>
                            <?php } else {?>
                            <p style="color:#cc0000"><i class="fa fa-times-circle"  style=" padding-right: 5px;color: #cc0000;"></i>Đã nghỉ</p>
                            <?php  }
                            ?></td>
                        </tr>
                        <div id="myModal_<?php echo $item->id ?>" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" style="text-transform: uppercase;">Lịch Sử Học Tập Chi Tiết</h4>
                                    </div>
                                    <div class="modal-body clearfix">
                                        <div class="clearfix">
                                            <p class="col-xs-6" style="padding:7px 0 0 0;font-weight: 500">Họ tên học viên: <?php echo $item->name ?></p>
                                            <div class="form-group col-xs-6">
                                                <label for="" class="control-label col-xs-6" style="padding: 8px 0 0 0;font-weight: 500">Hình thức đào tạo: </label>
                                                <select class="form-control type_exam col-xs-6" name="type_exam" style="width: 50%;">
                                                    <option>Thi online</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="container_ clearfix">
                                            <div class="row thread" style="border: 1px solid #ddd;">
                                                <div class="col-xs-12 col-sm-12">
                                                    <div class="row" style="background:#eeeeee;line-height: 35px;">
                                                        <div class="col-xs-4 col-sm-1" style="border-left:1px solid #ddd;text-align: center">
                                                            STT
                                                        </div>
                                                        <div class="col-xs-4 col-sm-2" style="border-left:1px solid #ddd;text-align: center">
                                                            Ngày Thi
                                                        </div>
                                                        <div class="col-xs-4 col-sm-4" style="border-left:1px solid #ddd;text-align: center">
                                                            Môn Thi
                                                        </div>
                                                        <div class="col-xs-4 col-sm-3" style="border-left:1px solid #ddd;text-align: center">
                                                            Điểm
                                                        </div>
                                                        <div class="col-xs-4 col-sm-2" style="border-left:1px solid #ddd;text-align: center">
                                                            Kết quả
                                                        </div>
                                                    </div>
                                                </div>
             <?php $list_exam = $this->model->get_exam_detail($item->id) ?>
                                                <?php
                                                $i = 0;
                                                foreach ($list_exam as $it) {
                                                    ?>
                                                    <div class="col-xs-12 col-sm-12" style="line-height: 35px;border-top:1px solid #ddd ">
                                                        <div class="row">
                                                            <div class="col-xs-4 col-sm-1" style="text-align:center;">
                                                                <span><?php echo $i + 1 ?></span>
                                                            </div>
                                                            <div class="col-xs-4 col-sm-2" style="border-left:1px solid #ddd;text-align: center">
                                                                <span><?php echo date('d-m-Y', $it->start_time) ?></span>
                                                            </div>
                                                            <div class="col-xs-4 col-sm-4" style="border-left:1px solid #ddd;text-align: center">
                                                                <span><?php
                                                                if ($it->type_exam == 1) {
                                                                    echo 'Thi Online';
                                                                } else {
                                                                    echo 'Tổng Hợp';
                                                                }
                                                                ?></span>
                                                            </div>
                                                            <div class="col-xs-4 col-sm-3" style="border-left:1px solid #ddd;text-align: center">
                                                                <span style="color:#ff0000;"><?php echo $it->point ?>/100</span>
                                                            </div>
                                                            <div class="col-xs-4 col-sm-2" style="border-left:1px solid #ddd;text-align: center">
                                                                <span><?php
                                                                if ($it->status == 1) {
                                                                    echo 'Đạt';
                                                                } else {
                                                                    echo 'Chưa đạt';
                                                                }
                                                                ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <tr>
                    </tbody>
                </table>
                <?php if ($pagination) echo $pagination->showPagination(5); ?>
            </div>
        </div>
    </div>  
