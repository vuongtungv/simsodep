<?php $stt=1; foreach($address as $item){?>
<div class="inner-info row-item">
    <h2 class="contact-title">
        <span><?php echo $item->name;?></span>
    </h2>
    <div class="content">
        <?php echo $item->more_info; ?>
    </div>
</div><!-- END: .inner-info -->
<?php $stt+=1; }?>



