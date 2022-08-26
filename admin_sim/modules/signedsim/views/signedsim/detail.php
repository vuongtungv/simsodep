<?php
//    $title = @$data ? FSText :: _('Xem'): FSText :: _('Add');
global $toolbar;
//    $toolbar->setTitle($title);
//$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png');
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png');
$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');

$this -> dt_form_begin(1,4,FSText::_('Chi tiết ký gửi sim'));

//    TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
//    TemplateHelper::dt_edit_text(FSText :: _('Người gửi'),'fullname',@$data -> fullname);
?>
<input type="hidden" id="signedsim_id" name="signedsim_id" value="<?php echo FSInput::get('id')?>">
    <!--    <div class="form-group">-->
    <!--        <label class="col-md-2 col-xs-12 control-label">--><?php //echo FSText::_('Tiêu đề')?><!--</label>-->
    <!--        <div class="col-md-10 col-xs-12">-->
    <!--            <input disabled="disabled" type="text" class="form-control" name="title" id="title" value="--><?php //echo $data->title ?><!--" size="60">-->
    <!--        </div>-->
    <!--    </div>-->
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Trạng thái')?></label>
        <div class="col-md-10 col-xs-12">
            <select name="status" id="status" class="form-control">
                <option value="Mới" <?php if($data->status == "Mới") echo "selected" ;?>>Mới</option>
                <option value="Đã xem" <?php if($data->status == "Đã xem") echo "selected" ;?>>Đã xem</option>
                <option value="Đang xử lý" <?php if($data->status == "Đang xử lý") echo "selected" ;?>>Đang xử lý</option>
                <option value="Giao dịch xong" <?php if($data->status == "Giao dịch xong") echo "selected" ;?>>Giao dịch xong</option>
                <option value="Không gọi được cho khách hàng" <?php if($data->status == "Không gọi được cho khách hàng") echo "selected" ;?>>Không gọi được cho khách hàng</option>
                <option value="Khách hàng không còn nhu cầu" <?php if($data->status == "Khách hàng không còn nhu cầu") echo "selected" ;?>>Khách hàng không còn nhu cầu</option>
                <option value="Hủy" <?php if($data->status == "Hủy") echo "selected" ;?>>Hủy</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-xs-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-sticky-note"></i>
                    Note cho nhân viên
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover panel-body">
                        <thead>
                        <tr>
                            <th width="30">STT</th>
                            <th>Thời gian</th>
                            <th>Tài khoản</th>
                            <th>Nội dung</th>
                        </tr>
                        </thead>
                        <tbody  id="table_note">
                        <?php if($note){ $i=1; foreach (@$note as $item) {
                            ?>
                            <tr>
                                <td width="30"><?php echo $i ?></td>
                                <td><?php echo date('d/m/Y h:i', strtotime($item->time)); ?></td>
                                <td><?php echo $item->username ?></td>
                                <td><?php echo $item->note ?></td>
                            </tr>
                            <?php $i++; } }?>
                        </tbody>
                    </table>
                    <div>
                        <input type="text" class="form-control" name="note" id="note">
                        <div style="text-align: right;padding-top: 15px;">
                            <a class="btn_order" id="add_note" href="javascript:void(0)">Thêm ghi chú</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xs-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-history"></i>
                    <?php echo FSText::_('Lịch sử tác động') ?>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover panel-body">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Thời gian</th>
                            <th>Tài khoản</th>
                            <th>Trạng thái</th>
                        </tr>
                        </thead>
                        <tbody id="table_history">
                        <?php $i=1; foreach ($history as $item) {
                            ?>
                            <tr>
                                <td width="30"><?php echo $i ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($item->time)); ?></td>
                                <td><?php echo $item->username ?></td>
                                <td><?php echo $item->name_status ?></td>
                            </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Người tìm')?></label>
        <div class="col-md-10 col-xs-12">
            <input disabled="disabled" type="text" class="form-control" name="fullname" id="fullname" value="<?php echo $data->fullname ?>" size="60">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Số điện thoại liên hệ')?></label>
        <div class="col-md-10 col-xs-12">
            <input disabled="disabled" type="text" class="form-control" name="telephone" id="telephone" value="<?php echo $data->telephone ?>" size="60">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Địa chỉ')?></label>
        <div class="col-md-10 col-xs-12">
            <input disabled="disabled" type="text" class="form-control" name="address" id="address" value="<?php echo $data->address ?>" size="60">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Thành phố')?></label>
        <div class="col-md-10 col-xs-12">
            <input disabled="disabled" type="text" class="form-control" name="address" id="address" value="<?php echo @$city_name->name ?>" size="60">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Email')?></label>
        <div class="col-md-10 col-xs-12">
            <input disabled="disabled" type="text" class="form-control" name="email" id="email" value="<?php echo @$data->email ?>" size="60">
        </div>
    </div>
<?php
//    TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',@$data -> email);
//    TemplateHelper::dt_edit_text(FSText :: _('Telephone'),'telephone',@$data -> telephone);
//    TemplateHelper::dt_edit_text(FSText :: _('Address'),'address',@$data -> address);
?>
    <!--    <div class="form-group">-->
    <!--        <label class="col-md-2 col-xs-12 control-label">--><?php //echo FSText::_('Bộ phận liên hệ')?><!--</label>-->
    <!--        <div class="col-md-10 col-xs-12">-->
    <!--            --><?php //foreach($parts as $item){?>
    <!--                --><?php //if($item->email==$data->parts_email) {?>
    <!--                    <input disabled="disabled" type="text" class="form-control" name="title" id="title" value="--><?php //echo $item->name ?><!--" size="60">-->
    <!--                --><?php //}else{}?>
    <!--            --><?php //}?>
    <!--        </div>-->
    <!--    </div>-->
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Ghi chú')?></label>
        <div class="col-md-10 col-xs-12">
            <textarea disabled="disabled" class="form-control" name="content" id="content"><?php echo @$data->content ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Số sim muốn ký gửi')?></label>
        <div class="col-md-10 col-xs-12">
            <textarea disabled="disabled" class="form-control" name="deposit_sim" id="deposit_sim"><?php echo @$data->deposit_sim ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Giá tiền muốn bán')?></label>
        <div class="col-md-10 col-xs-12">
            <textarea disabled="disabled" class="form-control" name="price" id="price"><?php echo format_money(@$data->price,'') ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('% trả cho môi giới')?></label>
        <div class="col-md-10 col-xs-12">
            <textarea disabled="disabled" class="form-control" name="percent_brokers" id="percent_brokers"><?php echo @$data->percent_brokers ?></textarea>
        </div>
    </div>
<?php
//    TemplateHelper::dt_edit_text(FSText :: _('Nội dung'),'content',@$data -> content,'',650,450,1,'','','col-sm-2','col-sm-10');

$this -> dt_form_end(@$data,1);
?>


<script  type="text/javascript" language="javascript">

    $("#status").change(function(){
        status = $(this).val();
        if (status == 12) {
            $("#appointment").show();
        }else{
            $("#appointment").hide();
        }
    });
    $('.save_comments').click(function () {
        $id = $(this).attr("value");
        $note = $('#note_'+$id).val();
        if ($note == '') {
            alert('Bạn cần nhập ghi chú');
            return false;
        }
        $.ajax({url: "<?php echo URL_ROOT.URL_ROOT_ADMIN ?>index.php?module=signedsim&task=save_comments&raw=1",
            data: {id: $id, note:$note},
            dataType: "text",
            success: function (result) {
                if (result == 1) {
                    alert('Đã lưu ghi chú');
                } else {
                    alert('Chưa lưu được');
                }
            }
        });
    });

    //$('.delete_sim').click(function () {
    //    if (confirm("Thực hiện tác vụ ?")) {
    //        $id = $(this).attr("value");
    //        $("#row_"+$id).remove();
    //        $.ajax({url: "<?php //echo URL_ROOT.URL_ROOT_ADMIN ?>//index.php?module=order&task=delete_sim_cart&raw=1",
    //            data: {id: $id},
    //            dataType: "text",
    //            success: function (result) {
    //                if (result != 0) {
    //                    $('.total_dh').html(result);
    //                    alert('Đã xóa khỏi giỏ hàng');
    //                } else {
    //                    alert('Chưa xóa được');
    //                }
    //            }
    //        });
    //    }
    //});

    $('#add_note').click(function () {
        $signedsim_id = $('#signedsim_id').val();
        $note = $('#note').val();
        if ($note == '') {
            alert('Bạn cần nhập ghi chú');
            return false;
        }

        $.ajax({url: "<?php echo URL_ROOT.URL_ROOT_ADMIN ?>index.php?module=signedsim&task=save_note&raw=1",
            data: {id: $signedsim_id, note: $note},
            dataType: "html",
            success: function (result) {
                if (result) {
                    $("#table_note").html(result);
                    $('#note').val('');
                    alert('Thêm ghi chú thành công');
                } else {
                    alert('Chưa thêm được ghi chú');
                }
            }
        });

    });

    //$('#save_status').click(function () {
    //    $order_id = $('#order_id').val();
    //    $products_id = $('#products_id').val();
    //    $deposit = $('#deposit').val();
    //    $pay = $('#pay').val();
    //    $member = $('#member_id').val();
    //    $date_appointment = $('#date_appointment').val();
    //    $status = $('#status').val();
    //    $.ajax({url: "<?php //echo URL_ROOT.URL_ROOT_ADMIN ?>//index.php?module=deprecate&task=save_status&raw=1",
    //        data: {id: $order_id, member:$member, products: $products_id, status: $status, deposit: $deposit, pay:$pay, date_appointment:$date_appointment },
    //        dataType: "text",
    //        success: function (result) {
    //            if (result == 0) {
    //                alert('Chưa lưu được');
    //            } else {
    //                $("#table_history").html(result);
    //                alert('Lưu thông tin đơn hàng thành công');
    //            }
    //        }
    //    });
    //});
    //
    //$('#save_info').click(function () {
    //    $order_id = $('#order_id').val();
    //    $name = $('#name_customer').val();
    //    $city = $('#city').val();
    //    $mail = $('#email_customer').val();
    //    $address = $('#address_customer').val();
    //    $phone = $('#phone_customer').val();
    //    $comments = $('#comments_customer').val();
    //    $.ajax({url: "<?php //echo URL_ROOT.URL_ROOT_ADMIN ?>//index.php?module=order&task=save_info&raw=1",
    //        data: {id: $order_id, name: $name, city: $city, mail: $mail, phone:$phone, comments:$comments , address:$address },
    //        dataType: "text",
    //        success: function (result) {
    //            if (result == 0) {
    //                alert('Chưa lưu được');
    //            } else {
    //                $("#table_history").html(result);
    //                alert('Lưu thông tin khách hàng thành công');
    //            }
    //        }
    //    });
    //});

    print_page();
    function print_page(){
        var width = 800;
        var centerWidth = (window.screen.width - width) / 2;
//	    var centerHeight = (window.screen.height - windowHeight) / 2;
        $('.Print').click(function(){
            link = window.location.href;
            link += '&print=1';
            window.open(link, "","width="+width+",menubar=0,resizable=1,scrollbars=1,statusbar=0,titlebar=0,toolbar=0',left="+ centerWidth + ",top=0");
        });
    }
</script>
