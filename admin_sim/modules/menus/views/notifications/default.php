<?php if ($list){ ?>
<li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        <i class="icon-bell"></i>
        <span class="badge badge-success"> <?php echo @$total ?> </span>
    </a>
    <ul class="dropdown-menu" style="max-width: 350px;width: 350px;">

        <li>
            <ul class="dropdown-menu-list scroller" data-handle-color="#637283">
                <?php foreach ($list as $item){ ?>
                <li>
                    <a target="_blank" href="<?php echo 'index.php?module=order&view=order&task=edit&id='.$item->id ?>">
                        <span class="time">chi tiết</span>
                        <span class="details">
                            <span class="label label-sm label-icon label-success">
                                <i class="fa fa-truck"></i>
                            </span>Mã : <?php echo $item->code ?> - <?php echo date('H:i d/m/y',$item->date_appointment) ?> </span>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </li>
    </ul>
</li>
<?php } ?>