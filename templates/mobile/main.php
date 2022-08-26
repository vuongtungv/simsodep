<?php 
//if(!$user->userID){
//    $link = FSRoute::_('index.php?module=users&task=login&Itemid=69');
//    setRedirect($link);
//} ?>
<div id="page" class="abc">
    <!--Promotion information-->

    <header class="row-content" id="header">
        <div class="container">
            <a class="logo-images" href="<?php echo URL_ROOT; ?>" title="<?php echo $config['site_name']?>">
                <img class="img-responsive" src="<?php echo URL_ROOT.'images/logo-mobile.png';?>" alt="<?php echo $config['site_name']?>" />
            </a>
            
            <a class="onclick-memnu fl-left" href="#menu" id="onclick-memnu" title="">
				<i class="fa fa-bars"></i>
			</a>
            
            <div class="header-logo fl-left">
                <a class="logo-image" href="<?php echo URL_ROOT; ?>" title="<?php echo $config['site_name']?>">
                    <img src="<?php echo $logo;?>" alt="<?php echo $config['site_name']?>" />
                </a>
                <span class="logo-title"><?php echo FSText::_("Honda Chắp cánh những ước mơ"); ?></span>
            </div><!-- END: .header-logo -->
            
            <div class="header-slogan fl-left">
                <?php echo $config['slogan']?>
            </div><!-- END: .header-slogan -->
            
            <?php echo $tmpl -> load_direct_blocks('log',array('style'=>'default')); ?>
            <?php //echo $tmpl -> load_direct_blocks('search',array('style'=>'default')); ?> 
        </div>
    </header>
    <!-- END: header -->
    <div class="clearfix"></div>
    <nav class="row-item" id="nav">
        <div class="container">
            <?php echo $tmpl -> load_direct_blocks('mainmenu',array('style'=>'megamenu','group'=>'1')); ?>
        </div>
    </nav>
    <!-- END: nav -->
    <div class="clearfix"></div>

    <?php if($Itemid != 1){ ?>
    <section id="main-breadcrumbs" class="main-breadcrumbs">
        <div class="container">
            <?php  echo $tmpl -> load_direct_blocks('breadcrumbs',array('style'=>'simple')); ?>
        </div>
    </section>
    <div class="clearfix"></div>
    <?php } ?>

    <div class="main row-content" id="main">
        <?php include 'main_wrapper.php' ?>
    </div>
    <!-- END: main -->
    <div class="clearfix"></div>

    <footer class="row-content" id="footer">
        <div class="container">
            <div class="info-footer fl-left">
                <?php echo $config['info_footer']?>
            </div>
            
            <a class="fl-right footer-mail" href="mail:<?php echo $config['email']?>">
                <i class="fa fa-envelope fl-left"></i>
                <p class="row-item content">
                    <span class="label">Email</span>
                    <span class="value"><?php echo $config['email']?></span>
                </p>
                
            </a><!-- END: .footer-mail -->
            
            <a class="fl-right footer-hotline" href="tel:<?php echo $config['hotline']?>">
                <i class="fa fa-phone fl-left"></i>
                <p class="row-item content">
                    <span class="label">Tổng đài hỗ trợ</span>
                    <span class="value"><?php echo $config['hotline']?></span>
                </p>
            </a><!-- END: .footer-hotline -->
        </div>
    </footer><!-- END: footer -->
    <nav id="menu">
        <?php echo $tmpl -> load_direct_blocks('mainmenu', array('style'=>'megamenu_moblie','group'=>'1')); ?>
    </nav>
</div>