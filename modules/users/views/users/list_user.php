<?php
//print_r($_REQUEST);
global $tmpl, $user;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("users_info", "modules/users/assets/css");
$tmpl->addScript('form');
$tmpl->addScript('users_info', 'modules/users/assets/js');
$Itemid = FSInput::get('Itemid', 1);

$task = FSInput::get('task');
$head_id = FSInput::get('head_id');
$status = FSInput::get('status');
?>  
<div class="contai_info">
    <p class="title_info "> <span><i class="fa fa-users"></i> Danh sách User</span></p>
    <div class="box_search clearfix">
        <div class="col-md-3 tit_1">
            <p >Danh sách User thuộc đại lý</p>
        </div>
        <div class="col-md-9 grp_btn">
            <?php if ($user->userInfo->type == 1) { ?>
                <select name="head_id" class="form-control col-md-2" style="width: 165px;" onchange="window.location.href = this.value">
                    <option value="?head_id=0">---Tất cả head---</option>
                    <?php foreach ($list_head as $item) { ?>
                        <option <?php if ($head_id == $item->id) echo 'selected' ?> value="?head_id=<?php echo $item->id ?>"><?php echo $item->username ?></option>
                    <?php } ?>

                </select>
            <?php } ?>
            <?php if ($user->userInfo->type == 2) { ?>
                <select name="status" class="form-control col-md-2" style="width: 165px;float: right;" onchange="window.location.href = this.value">
                    <option <?php if ($status == 3) echo 'selected' ?> value="?&status=3">---Tất Cả Tình Trạng---</option>
                    <option <?php if ($status == 1) echo 'selected' ?> value="?&status=1">Đang hoạt động</option>
                    <option <?php if ($status == 2) echo 'selected' ?> value="?&status=2">Đã nghỉ</option>
                </select>
            <?php } ?>

            <form name="search_user" method="post" action="<?php echo FSRoute::_("index.php?module=users&task=list_user&Itemid=5") ?>">
                <input type="text" class="form-control input_search" name="keyword" id="keyword" placeholder="Từ khóa tìm kiếm">
                <a href="javascript:void(0)" class="search_user" id="search_user"><i class="fa  fa-search"></i>Tìm kiếm</a>        
                <input type="hidden" name = "module" value = "users" />
                <input type="hidden" name = "view" value = "users" />
                <input type="hidden" name = "task" value = "list_user" />
            </form>

            <?php if ($user->userInfo->type == 2) { ?>
                <a href="<?php echo FSRoute::_('index.php?module=users&task=register_user') ?>" class="link_created_user" ><i class="fa fa-user-plus"></i>Tạo mới User</a>
            <?php } ?>

            <?php if($user->userInfo->type==1){?>
                    <a href="javascript:void(0)" class="btn_excel col-xs-2"><i class="fa  fa-file-excel-o"></i>Xuất Excel</a>
            <?php }?>

        </div>
    </div>
    <table class="table table-bordered  table-hover table_list_user">
        <thead>
            <tr>
                <!-- <th>ID</th> -->
                <th>Tên Học Viên</th>
                <th>Tên Đăng Nhập</th>
                <th>Email</th>
                <th>Ngày Tạo</th>
                <th>Đã Học/ Đã Đăng Kí</th>
                <th>Trạng Thái</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $item) { ?>
                <tr>
                    <!--td><?php echo $item->id ?></td-->
                    <td><a href="<?php echo FSRoute::_('index.php?module=users&task=edit_user&id=' . $item->id) ?>" style="color:#cc0000" ><?php echo $item->name ?></a></td>
                    <td><?php echo $item->username ?></td>
                    <td><?php echo $item->email ?></td>
                    <td><?php echo date('d-m-Y', strtotime($item->created_time)) ?></td>
                    <td><?php echo ltrim($item->registed_name, ',') ?></td>
                    <td><?php if ($item->published == 1) { ?>
                            <p><i class="fa fa-check-circle" style=" padding-right: 5px;color: #1abc9c;"></i>Đang hoạt động</p>
                        <?php } else { ?>
                            <p style="color:#cc0000"><i class="fa fa-times-circle"  style=" padding-right: 5px;color: #cc0000;"></i>Đã nghỉ</p>
                        <?php } ?></td>
                </tr>
            <?php } ?>

        </tbody>

    </table>
    <?php if ($pagination) echo $pagination->showPagination(5); ?>
</div>


