<?php 
    global $tmpl,$config;
    $tmpl->setTitle("Đại lỹ");
    $tmpl -> addStylesheet("users_login","modules/users/assets/css");
    $Itemid = FSInput::get('Itemid',1);
    $redirect = FSInput::get('redirect');
?>  
<h1 class="title-module">
    <span>Chính sách chung</span>
</h1>
<div id="users-logged" class ="users-logged" >
    <?php echo $config['general_policy'] ?>
</div>    
        
        