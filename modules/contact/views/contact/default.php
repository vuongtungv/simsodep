<?php
    global $config,$tmpl; 
    $tmpl -> addScript('form');
    $tmpl -> addScript('contact','modules/contact/assets/js');
    $tmpl->addStylesheet('contac','modules/contact/assets/css'); 

    $Itemid = FSInput::get('Itemid',0);
    $contact_email = FSInput::get('contact_email');
    $contact_name = FSInput::get('contact_name');
    $contact_address = FSInput::get('contact_address');
    $contact_group = FSInput::get('contact_group');
    $contact_title = FSInput::get('contact_title');
    $contact_parts = FSInput::get('contact_parts');
    $message = htmlspecialchars_decode(FSInput::get('message'));
?>

<div class="contact-main row-item">
	<h1 class="title-module">
		<span><?php echo FSText::_("Thông tin liên hệ"); ?></span>
	</h1><!-- END: .name-contact -->
    
    <!--<h2 class="title-content">
        <?php //echo $config['title_contact'] ?>
        CÔNG TY tnhh công nghệ và năng lượng <span>sptec</span> việt nam
    </h2> -->
    
	<div class="wapper-content-page row">
        <div class="col-xs-12 col-sm-12 col-info">
            <?php  include_once 'default_info.php'; ?>
        </div>
        
        <div class="col-xs-12 col-sm-6">
			<?php include_once 'default_from.php'; ?>
		</div>
        
        <div class="col-xs-12 col-sm-6"> 
	       <?php include_once 'default_map.php';?>
	   </div><!-- END: .map -->
	</div><!-- END: .wapper-content-page -->
</div><!-- END: .contact -->
