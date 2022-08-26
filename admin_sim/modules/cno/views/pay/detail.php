<?php
    $title = @$data_agency ? FSText :: _('Chốt công nợ'): FSText :: _('Chốt công nợ '); 
    global $toolbar;
    $toolbar->setTitle($title);
    // $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
    // $toolbar->addButton('apply',FSText :: _('Xác nhận chốt công nợ'),'','apply.png'); 
    $toolbar->addButton('Save',FSText :: _('Xác nhận chốt công nợ'),'','save.png'); 
    $toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png'); 
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <i class="fa fa-th-list"></i>
        <?php echo FSText::_('Thông tin đại lý ').$data_agency->full_name ?>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered table-hover panel-body">

            <tbody id="table_history">
                <tr>
                    <td>Người liên hệ</td>
                    <td><?php echo $data_agency->manager ?></td>
                </tr>
                 <tr>
                    <td>Website</td>
                    <td><?php echo $data_agency->web ?></td>
                </tr>
                <tr>
                    <td>Điện thoại</td>
                    <td><?php echo $data_agency->phone ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?php echo $data_agency->email ?></td>
                </tr>
                 <tr>
                    <td>Địa chỉ</td>
                    <td><?php echo $data_agency->address ?></td>
                </tr>
                 <tr>
                    <td>Tỉnh / Thành phố</td>
                    <td><?php echo $city->name ?></td>
                </tr>
                <tr>
                    <td>Chiết khấu / Tăng giảm giá sim</td>
                    <td><?php echo $data_agency->price_name ?></td>
                </tr>
                <tr>
                    <td>Ghi chú</td>
                    <td><?php echo $data_agency->summary ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="panel panel-info">
    <div class="panel-heading">
        <i class="fa fa-th-list"></i>
        <?php echo FSText::_('Danh sách công nợ ').$data_agency->full_name ?>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered table-hover panel-body">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Thời gian</th>
                    <th>Số sim GD</th>
                    <th>Trả thu</th>
                    <th>Trạng thái</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody id="table_history">
                <?php $sim_cno=''; $id_cno=','; $total=0; $i=1; foreach ($list as $item) {
                    $total = $total + $item->recive;
                    $id_cno .= $item->id.',';
                    $sim_cno .= $item->sim.',';
                ?>
                <tr>
                    <td width="30"><?php echo $i ?></td>
                    <td><?php echo date('d/m/Y h:i', strtotime($item->created_time)); ?></td>
                    <td><?php echo $item->sim ?></td>
                    <td><?php echo format_money($item->recive) ?></td>
                    <td>Đang đối chiếu</td>
                    <td><?php echo $item->note ?></td>
                </tr>
                <?php $i++; } ?>
                <tr>
                    <?php $color =  $total>0 ?'blue':'red' ?>
                    <td style="text-align: center;font-weight: bold;font-size: 15px;color:<?php echo $color; ?>" colspan="6"><?php echo $total>0 ?'Tổng số tiền phải thu':'Tổng số tiền phải trả' ?>: <?php echo format_money($total) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php  

    $this -> dt_form_begin(1,4,$title.' '.$data_agency->full_name);

    TemplateHelper::datetimepicke( FSText :: _('Ngày chốt' ), 'day', @$data_agency->day?@$data_agency->day:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian bắt đầu chuyển sim'), 20,'','col-md-3','col-md-4');
?>
    <input type="hidden" name="cno_id" value="<?php echo $id_cno ?> ">
    <input type="hidden" name="cno_sim" value="<?php echo $sim_cno ?> ">
    <input type="hidden" name="agency" value="<?php echo $data_agency->id ?> ">
    <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label">Số tiền</label>
        <div class="col-md-9 col-xs-12">
            <input type="text" class="form-control" data-v-min="0" data-v-max="999999999999" name="recive" id="recive" value="<?php echo format_money($total,'') ?>" size="60" maxlength="255">
        </div>
    </div>
<?php 
    TemplateHelper::dt_edit_text(FSText :: _('Ghi chú'),'note',@$data_agency -> note,'',100,5,0,'','','col-sm-3','col-sm-9');
    $this -> dt_form_end(@$data);
?>
<?php if ($history) { ?>
<div class="panel panel-info">
        <div class="panel-heading">
            <i class="fa fa-history"></i>
            <?php echo FSText::_('Lịch sử thanh toán ').$data_agency->full_name ?>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered table-hover panel-body">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Thời gian</th>
                        <!-- <th>Số sim GD</th> -->
                        <th>Trả thu</th>
                        <th>Trạng thái</th>
                        <th>Ghi chú</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody id="table_history">
                    <?php $i=1; foreach ($history as $item) {
                    ?>
                    <tr>
                        <td width="30"><?php echo $i ?></td>
                        <td><?php echo date('d/m/Y h:i', strtotime($item->created_time)); ?></td>
                        <!-- <td><?php echo $item->cno_sim ?></td> -->
                        <td><?php echo format_money($item->recive) ?></td>
                        <td>Đã xong</td>
                        <td><?php echo $item->note ?></td>
                        <td><a target="_blank" href="index.php?module=cno&view=pay&task=edit&id=<?php echo $item->id ?>">Xem</a></td>
                    </tr>
                    <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>
        
