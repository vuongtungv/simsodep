<?php
//print_r($_REQUEST);
global $tmpl;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("users_info", "modules/users/assets/css");
$tmpl->addScript('form1');
$tmpl->addScript('users_info', 'modules/users/assets/js');
$Itemid = FSInput::get('Itemid', 1);

$task = FSInput::get('task');
?>  
<style>
    #submitbt_up_delegate{
        background: #ee0000;
        color: #fff;
        padding: 5px 20px;
        border-radius: 3px;
    }
</style>

<div class="contai_info">
    <h1 class="title-module">
        <a class="">
            <i class="fa fa-user-o"></i>Thông tin tài khoản
        </a>
    </h1>

    <table class="table table_info">

        <tbody>
            <tr>
                <td class="th_left">Tên đăng nhập</td>
                <td><?php echo $user->userInfo->username ?></td>
            </tr>
            <tr>
                <td class="th_left">Tên Head</td>
                <td><?php echo $user->userInfo->name ?></td>
            </tr>
<!--            <tr>
                <td class="th_left">Ngày sinh</td>
                <td><?php echo $user->userInfo->birthday ?></td>
            </tr>-->
<!--            <tr>
                <td class="th_left">Điện thoại</td>
                <td><?php echo $user->userInfo->telephone ?></td>
            </tr>-->
            <?php if ($user->userInfo->type == 3) { ?>
                <tr>
                    <td class="th_left">DSC Code</td>
                    <td><?php echo $user->userInfo->code_dcs ?></td>
                </tr>
            <?php } ?>
            <?php if ($user->userInfo->type == 3) { ?>
                <tr>
                    <td class="th_left">Thuộc đại lý</td>
                    <td><?php echo $user->userInfo->creator_name ?></td>
                </tr>
            <?php } ?>
            <?php if ($user->userInfo->type == 3) { ?>
                <tr>
                    <td class="th_left">Chức vụ</td>
                    <?php $position = $this->model->get_record('id=' . $user->userInfo->position, 'fs_position') ?>
                    <td><?php echo $position->name ?></td>
                </tr>
            <?php } ?>
            <?php if ($user->userInfo->type == 1) { ?>
                <tr>
                    <td class="th_left">Phòng ban</td>
                    <?php $department = $this->model->get_record('id=' . $user->userInfo->department, 'fs_department') ?>
                    <td><?php echo $department->name ?></td>
                </tr>
            <?php } ?>
            <?php if ($user->userInfo->type == 1) { ?>
                <tr>
                    <td class="th_left">Thời gian công tác từ</td>

                    <td><?php echo $user->userInfo->workstart ?></td>
                </tr>
            <?php } ?>
            <?php if ($user->userInfo->type == 2) { ?>
            <td class="th_left">Tỉnh/Thành Phố</td>
            <td>
                <?php if ($user->userInfo->city) { ?>
                    <?php $city = $this->model->get_record('id=' . $user->userInfo->city, 'fs_cities') ?>
                    <?php echo $city->name ?>
                <?php } ?>
            </td>
            </tr>

        <?php } ?>
        <?php if ($user->userInfo->email && $user->userInfo->type != 2 ) { ?>
        <tr>
            <td class="th_left">Email</td>
            <td><?php echo $user->userInfo->email ?></td>
        </tr>
        <?php } ?>
<!--            <tr>
<td class="th_left">Ngày đăng ký</td>
<td><?php echo $user->userInfo->created_time ?></td>
</tr>-->
        </tbody>
    </table>
    <?php if ($user->userInfo->type == 2) { ?>
        <h1 class="title-module">
            <a class="">
                <i class="fa fa-user-o"></i>Người phụ trách
            </a>
        </h1>

        <form class="form-horizontal" method="post" action="#" name="upinfo_form_user">
            <div class="form-group">
                <label for="username" class="control-label col-xs-5 col-md-2" style="text-align: left">Người đại diện </label>
                <div class="col-xs-7 col-md-4">
                    <input type="text" class="form-control" id="delegate_name" name="delegate_name" placeholder="Họ tên người đại diện"  value="<?php echo $user->userInfo->delegate_name ?>">
                    <span class="check_validate" id="check_validate" style="color:#ff0000;"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="username" class="control-label col-xs-5 col-md-2" style="text-align: left">Số điện thoại </label>
                <div class="col-xs-7 col-md-4">
                    <input type="text" class="form-control" id="delegate_phone" name="delegate_phone" placeholder="Số điện thoại người đại diện"  value="<?php echo $user->userInfo->delegate_phone ?>"  maxlength="12">
                    <span class="check_validate" id="check_validate_phone"  style="color:#ff0000;"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="username" class="control-label col-xs-5 col-md-2" style="text-align: left">Email </label>
                <div class="col-xs-7 col-md-4">
                    <input type="text" class="form-control" id="delegate_email" name="delegate_email" placeholder="Email người đại diện"  value="<?php echo $user->userInfo->delegate_email ?>">
                    <span class="check_validate" id="check_validate"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="username" class="control-label col-xs-2" style="text-align: left"></label>
                <div class="col-xs-4">
                    <a class="btn_register" href="javascript: void(0)" id='submitbt_up_delegate' >Cập nhật</a>
                    <input type="hidden" name = "module" value = "users" />
                    <input type="hidden" name = "view" value = "users" />
                    <input type="hidden" name = "task" value = "update_delegate" />
                </div>
            </div>


        </form>
    <?php } ?>



</div>



