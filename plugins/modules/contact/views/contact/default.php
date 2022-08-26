<?php
    global $config; 
    global $tmpl;
    $tmpl -> addScript('form');
    $tmpl -> addScript('contact','modules/contact/assets/js');
    $tmpl->addStylesheet('contact','modules/contact/assets/css'); 

    $Itemid = FSInput::get('Itemid',0);
    $contact_email = FSInput::get('contact_email');
    $contact_name = FSInput::get('contact_name');
    $contact_address = FSInput::get('contact_address');
    $contact_phone = FSInput::get('contact_phone');
    $contact_title = FSInput::get('contact_title');
    $message = htmlspecialchars_decode(FSInput::get('message'));
?>



<div class="contact col-item pal mbsi">
	<h1 class="name-contact pbl">
		<span><?php echo FSText::_("Thông tin liên hệ"); ?></span>
	</h1><!-- END: .name-contact -->
    
	<div class="wapper-content-page row">
		<div class="inner_left col-md-6 col-sm-12 col-xs-12">
            <?php  include_once 'default_info.php'; ?>
            
			<?php include_once 'default_from.php'; ?>
		</div>

	   <div class="map col-md-6 col-sm-12 col-xs-12">
           <h2 class="title-map">
                <span><?php echo FSText::_('Sơ đồ đường đi'); ?></span>
           </h2> 
	       <?php include_once 'default_map.php';?>
	   </div><!-- END: .map -->
	</div><!-- END: .wapper-content-page -->
</div><!-- END: .contact -->
