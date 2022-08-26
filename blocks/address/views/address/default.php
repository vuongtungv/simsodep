<?php
    global $tmpl,$config; 
    $tmpl -> addStylesheet('address','blocks/address/assets/css');
?> 
 <div class="contact-ndt row">
	<div class="col-sm-6 commitment">
        <?php echo $config['info_home_employer'] ?>
	</div>
    
	<div class="col-sm-6 contact-location">
		<h3><?php echo FSText::_('Liên hệ'); ?></h3>
        <?php foreach($list as $item){ ?>
            <article>
    			<h4><?php echo $item->name ?></h4>
    			<?php echo $item->more_info; ?>
    		</article>
        <?php } ?>
	</div><!-- END: contact-location -->
</div>
