<?php 
	//global $tmpl;
	//$tmpl -> addStylesheet('statistics','blocks/statistics/assets/css');
?>
<div class="row">
    <div class="col-xs-6">
        <p>
            <i class="fa fa-arrow-circle-o-right"></i>
            <?php echo FSText::_('Tổng số học viên'); ?>: <span><?php echo number_format($online, 0, ',', '.');?></span>
        </p>
    </div>
    <div class="col-xs-6">
        <p>
            <i class="fa fa-arrow-circle-o-right"></i>
            <?php echo FSText::_('Tổng số Đại lý'); ?>: <span><?php echo number_format($online, 0, ',', '.');?></span>
        </p>
    </div>
    <div class="col-xs-12">
        <p class="col-item-count1">
            <i class="fa fa-arrow-circle-o-right"></i> 
            <?php echo FSText::_('Đang online'); ?>: <span><?php echo number_format($online, 0, ',', '.');?></span>
        </p>
    </div>
</div>
