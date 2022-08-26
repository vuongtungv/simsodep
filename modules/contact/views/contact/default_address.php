<?php $stt=1; foreach($address as $item){?>
<div class="address">
	<div class="address_wapper">
    
        <h2 class="names">	
			<?php echo $item->name;?>
		</h2>
		<div class="clear"></div>
		<div class="address_wapper_left">
			
            <?php if($item->address!=""){ ?>
			<span>
				<?php echo FSText::_("Địa chỉ"); ?>: 
				<?php echo $item->address;?>
			</span></br>
            <?php } ?>
            
            <?php if($item->phone!=""){ ?>
			<span>
				<?php echo FSText::_("Điện thoại"); ?>:
				<?php echo $item->phone;?>
			</span>
            <?php } ?>
            
            <?php if($item->hotline!=""){ ?>
			<span>
			     | <?php echo FSText::_("Hotline"); ?>:
				<?php echo $item->hotline;?>
			</span></br>
            <?php } ?>
            
            <?php if($item->email!=""){ ?>
			<span>
				<?php echo FSText::_("Email"); ?>:
				<?php echo $item->email;?>
			</span>
            <?php } ?>
            
            <?php if($item->more_info){ ?>
            <div class="content-contact">
            	<?php echo $item->more_info;?>
            </div>
            <?php } ?>

		</div>
		<div class="clear"></div>
	</div>
</div>
<?php $stt+=1; }?>

