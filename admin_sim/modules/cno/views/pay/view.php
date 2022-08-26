<?php
    $title = 'Chi tiết thanh toán'; 
    global $toolbar;
    $toolbar->setTitle($title);
    // $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
    // $toolbar->addButton('apply',FSText :: _('Xác nhận chốt công nợ'),'','apply.png'); 
    // $toolbar->addButton('Save',FSText :: _('Xác nhận chốt công nợ'),'','save.png'); 
    $toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png'); 
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <i class="fa fa-th-list"></i>
        <?php echo FSText::_('Danh sách công nợ ') ?>
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
                    <th>Chi tiết</th>
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
                    <td>
                        <?php foreach ($array_obj_status as $key) {
                            if ($key->id == $item->status) {
                                echo $key->name;
                            }
                        } ?>
                    </td>
                    <td><?php echo $item->note ?></td>
                    <td><a target="_blank" href="index.php?module=cno&view=cno&task=edit&id=<?php echo $item->id ?>">Xem</a></td>
                </tr>
                <?php $i++; } ?>
                <tr>
                    <?php $color =  $total>0 ?'blue':'red' ?>
                    <td style="text-align: center;font-weight: bold;font-size: 15px;color:<?php echo $color; ?>" colspan="7"><?php echo $total>0 ?'Tổng số tiền đã thu':'Tổng số tiền đã trả' ?>: <?php echo format_money($total) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
        
