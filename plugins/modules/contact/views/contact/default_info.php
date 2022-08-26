<?php $stt=1; foreach($address as $item){?>
    <div class="row-cl contact-address">
        <h3 class="contact-title-ft col-cl">
            <span><?php echo $item->name;?></span>
        </h3>
        <ul>
            <li class="col-item-contact col-contact-1">
                <span><?php echo FSText::_('Trụ sở chính') ?>: </span><?php echo $item->address;?>
            </li>
            <li class="col-item-contact col-contact-2">
                <span><?php echo FSText::_('Điện thoại') ?>: </span> <?php echo $item->phone; ?>
            </li>
            <li class="col-item-contact col-contact-3">
                <span><?php echo FSText::_('Fax') ?>: </span><?php echo $item->fax;?>
            </li>
            <li class="col-item-contact col-contact-4">
                <span><?php echo FSText::_('Email') ?>: </span><?php echo $item->email;?> 
            </li>
            <li class="col-item-contact col-contact-5">
                <span><?php echo FSText::_('Website') ?>: </span><?php echo $item->website; ?>
            </li>
        </ul>
    </div><!-- END: .contact-address -->
    
    <div class="row-cl infor_contact">
        <?php echo $item->more_info; ?>
    </div>
    <div class="clear"></div>
<?php $stt+=1; }?>



